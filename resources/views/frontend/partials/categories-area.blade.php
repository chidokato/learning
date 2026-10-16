<section class="it-categories-area pt-30 pb-30">
   <div class="container">
      @php
         $homepageCategories = \Illuminate\Support\Facades\Cache::remember('home_homepage_categories', 600, function () {
             return \App\Models\HomepageCategory::where('is_active', true)->orderBy('sort_order')->get();
         });
         $count = $homepageCategories->count();
         $rowColsClass = match($count) {
             1 => 'row-cols-1 justify-content-center',
             2 => 'row-cols-xxl-2 row-cols-xl-2 row-cols-lg-2 row-cols-md-2 row-cols-1 justify-content-center',
             3 => 'row-cols-xxl-3 row-cols-xl-3 row-cols-lg-3 row-cols-md-3 row-cols-1 justify-content-center',
             default => 'row-cols-xxl-4 row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 justify-content-center',
         };
      @endphp

      <div class="row {{ $rowColsClass }} gx-35">
         @foreach($homepageCategories as $index => $cat)
         @php
             $hex = $cat->color ?: '#03594e';
             // Remove '#' if present
             $hex = ltrim($hex, '#');
             if(strlen($hex) == 3) {
                 $r = hexdec(str_repeat(substr($hex,0,1), 2));
                 $g = hexdec(str_repeat(substr($hex,1,1), 2));
                 $b = hexdec(str_repeat(substr($hex,2,1), 2));
             } else {
                 $r = hexdec(substr($hex,0,2));
                 $g = hexdec(substr($hex,2,2));
                 $b = hexdec(substr($hex,4,2));
             }
             $bg = "rgba($r, $g, $b, 0.08)";
             $targetUrl = $cat->link ? (Illuminate\Support\Str::startsWith($cat->link, ['http://', 'https://', '/']) ? $cat->link : url($cat->link)) : null;
         @endphp
         <style>
             .cat-item-{{ $cat->id }} {
                 display: block;
                 text-decoration: none !important;
                 border: 2px solid #{{ $hex }} !important;
                 background-color: {{ $bg }} !important;
                 transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                 cursor: pointer;
                 padding: 28px 20px 24px;
                 border-radius: 16px;
                 margin-bottom: 20px;
                 box-shadow: 0 4px 14px rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.08);
             }
             .cat-item-{{ $cat->id }}:hover {
                 background-color: #{{ $hex }} !important;
                 transform: translateY(-4px);
                 box-shadow: 0 12px 28px rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.28);
                 text-decoration: none !important;
             }
             .cat-item-{{ $cat->id }} span {
                 display: inline-block;
                 margin-bottom: 16px;
                 transition: transform 0.5s ease;
             }
             .cat-item-{{ $cat->id }}:hover span {
                 animation: icon-bounce 0.8s 1;
             }
             .cat-item-{{ $cat->id }} span svg, .cat-item-{{ $cat->id }} span svg path {
                 color: #{{ $hex }};
                 fill: currentcolor;
                 transition: all 0.3s ease;
             }
             .cat-item-{{ $cat->id }}:hover span svg, .cat-item-{{ $cat->id }}:hover span svg path {
                 color: #ffffff !important;
                 fill: #ffffff !important;
             }
             .cat-item-{{ $cat->id }} h6 {
                 color: #{{ $hex }} !important;
                 font-weight: 700;
                 font-size: 18px;
                 letter-spacing: 0.5px;
                 margin-bottom: 0;
                 transition: all 0.3s ease;
             }
             .cat-item-{{ $cat->id }}:hover h6 {
                 color: #ffffff !important;
             }
         </style>
         <div class="col wow itfadeUp" data-wow-duration=".9s" data-wow-delay=".{{ 3 + ($index % 4) }}s" style="visibility: visible; animation-duration: 0.9s; animation-delay: 0.3s; animation-name: itfadeUp;">
            @if($targetUrl)
            <a href="{{ $targetUrl }}" class="it-categories-item cat-item-{{ $cat->id }} text-center">
            @else
            <div class="it-categories-item cat-item-{{ $cat->id }} text-center">
            @endif
               <span>
                  @if($cat->image)
                     <img src="{{ asset($cat->image) }}" alt="icon" style="max-width: 80px; max-height: 80px;" loading="lazy" decoding="async" width="80" height="80">
                  @elseif($cat->svg_icon)
                     {!! $cat->svg_icon !!}
                  @endif
               </span>
               <h6>
                  {{ $cat->title }}
               </h6>
            @if($targetUrl)
            </a>
            @else
            </div>
            @endif
         </div>
         @endforeach
      </div>
   </div>
</section>