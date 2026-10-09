<?php
$bladePath = 'C:\\xampp\\htdocs\\www\\learning\\resources\\views\\frontend\\partials\\categories-area.blade.php';
$bladeContent = file_get_contents($bladePath);

$idx = strpos($bladeContent, '<div class="row row-cols-xxl-4');
if ($idx !== false) {
    $head = substr($bladeContent, 0, $idx);
    $dynamicPart = <<<'HTML'
         <div class="row row-cols-xxl-4 row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 gx-35">
            @php
               $homepageCategories = \App\Models\HomepageCategory::where('is_active', true)->orderBy('sort_order')->get();
            @endphp
            @foreach($homepageCategories as $index => $cat)
            <div class="col wow itfadeUp" data-wow-duration=".9s" data-wow-delay=".{{ 3 + ($index % 4) }}s" style="visibility: visible; animation-duration: 0.9s; animation-delay: 0.3s; animation-name: itfadeUp;">
               <div class="it-categories-item item-style-1 text-center">
                  <span>
                     @if($cat->image)
                        <img src="{{ asset($cat->image) }}" alt="icon" style="max-width: 60px; max-height: 60px;">
                     @elseif($cat->svg_icon)
                        {!! $cat->svg_icon !!}
                     @else
                        <!-- Add a default icon or an image icon here if you want -->
                     @endif
                  </span>
                  <h6 class="mb-0">
                     @if($cat->link)
                        <a href="{{ $cat->link }}">{{ $cat->title }}</a>
                     @else
                        {{ $cat->title }}
                     @endif
                  </h6>
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </section>
HTML;
    file_put_contents($bladePath, $head . $dynamicPart);
    echo "Updated blade file!";
} else {
    echo "Could not find row block!";
}
