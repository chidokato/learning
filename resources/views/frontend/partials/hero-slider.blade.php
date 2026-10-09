@php
   $sliders = \App\Models\Slider::where('is_active', true)->orderBy('sort_order')->get();
@endphp

@if($sliders->count() > 0)
<div class="it-hero-12-slider-area p-relative">
   <div class="swiper it-hero-12-active">
      <div class="swiper-wrapper">
         
         @foreach($sliders as $slider)
         <div class="swiper-slide">
            <section class="it-hero-12-area theme-bg z-index-1"> 
               <img class="it-hero-shape-2" src="{{ asset('assets/img/shape/hero-1-2.png') }}" alt="">
               <img class="it-hero-shape-3 d-none d-lg-block" src="{{ asset('assets/img/shape/hero-1-3.png') }}" alt="">
               <div class="container">
                  <div class="row align-items-center">
                     <div class="col-xl-6 col-lg-6">
                        <div class="it-hero-12-content">
                           @if($slider->subtitle)
                           <span class="it-hero-12-subtitle">
                              {{ $slider->subtitle }}
                           </span>
                           @endif
                           
                           @if($slider->title)
                           <h2 class="it-hero-title">
                              {{ $slider->title }}
                           </h2>
                           @endif
                           
                           @if($slider->button_text)
                           <div class="it-hero-bnt">
                              <a href="{{ $slider->button_link ?? '#' }}" class="it-btn-yellow border-radius-0">
                                 <span>
                                    <span class="text-1">{{ $slider->button_text }}</span>
                                    <span class="text-2">{{ $slider->button_text }}</span>
                                 </span>
                                 <i>
                                    <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M15.0544 8.1364C15.4058 7.78492 15.4058 7.21508 15.0544 6.8636L9.3268 1.13604C8.97533 0.784567 8.40548 0.784567 8.05401 1.13604C7.70254 1.48751 7.70254 2.05736 8.05401 2.40883L13.1452 7.5L8.05401 12.5912C7.70254 12.9426 7.70254 13.5125 8.05401 13.864C8.40548 14.2154 8.97533 14.2154 9.3268 13.864L15.0544 8.1364ZM0.417969 7.5V8.4H14.418V7.5V6.6H0.417969V7.5Z" fill="currentcolor"></path>
                                    </svg>
                                 </i>
                              </a>
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="col-xl-6 col-lg-6">
                        <div class="it-hero-thumb z-index-1">
                           <img src="{{ $slider->image_url }}" alt="">
                        </div>
                     </div>
                  </div>
               </div>  
            </section>
         </div>
         @endforeach
         
      </div>
      <div class="it-slider-arrow-wrap">
         <button class="arrow-next">
            <svg width="21" height="15" viewBox="0 0 21 15" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M20.7071 8.07106C21.0976 7.68054 21.0976 7.04737 20.7071 6.65685L14.3431 0.292885C13.9526 -0.0976396 13.3195 -0.0976396 12.9289 0.292885C12.5384 0.683409 12.5384 1.31657 12.9289 1.7071L18.5858 7.36395L12.9289 13.0208C12.5384 13.4113 12.5384 14.0445 12.9289 14.435C13.3195 14.8255 13.9526 14.8255 14.3431 14.435L20.7071 8.07106ZM0 7.36395V8.36395H20V7.36395V6.36395H0V7.36395Z" fill="currentcolor"></path>
            </svg>                       
         </button>
         <button class="arrow-prev">
            <svg width="21" height="15" viewBox="0 0 21 15" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M0.292892 8.07106C-0.0976315 7.68054 -0.0976315 7.04737 0.292892 6.65685L6.65685 0.292885C7.04738 -0.0976396 7.68054 -0.0976396 8.07107 0.292885C8.46159 0.683409 8.46159 1.31657 8.07107 1.7071L2.41421 7.36395L8.07107 13.0208C8.46159 13.4113 8.46159 14.0445 8.07107 14.435C7.68054 14.8255 7.04738 14.8255 6.65685 14.435L0.292892 8.07106ZM21 7.36395V8.36395H1V7.36395V6.36395H21V7.36395Z" fill="currentcolor"></path>
            </svg>
         </button>
      </div>
   </div>
</div>
@endif

<style>
   /* Custom CSS to reduce slider height */
   .it-hero-12-area {
      padding-top: 30px !important;
      padding-bottom: 30px !important;
   }
   
   .it-hero-12-area .it-hero-thumb {
      display: flex;
      justify-content: center;
      align-items: center;
   }
   
   .it-hero-12-area .it-hero-thumb img {
      max-height: 400px !important; /* Limiting the height of the image */
      width: auto !important; /* Keep aspect ratio */
      object-fit: contain;
   }
   
   @media (min-width: 992px) {
       .it-hero-12-area .it-hero-title {
           font-size: 42px !important; /* Slightly smaller title to fit the reduced height */
       }
   }
   
   @media (max-width: 991px) {
       .it-hero-12-area .it-hero-thumb img {
          max-height: 250px !important;
       }
   }
   
   /* Change button color to stand out */
   .it-hero-12-area .it-btn-yellow {
       background-color: var(--it-theme-5) !important; /* Bright orange */
       border: none !important;
   }
   .it-hero-12-area .it-btn-yellow span,
   .it-hero-12-area .it-btn-yellow svg {
       color: #ffffff !important; /* White text */
   }
   .it-hero-12-area .it-btn-yellow:hover {
       background-color: #e66c1f !important; /* Slightly darker orange on hover */
   }

   /* Change slider arrows hover color */
   .it-slider-arrow-wrap button:hover {
       border-color: var(--it-theme-5) !important;
       background-color: var(--it-theme-5) !important;
       color: #ffffff !important;
   }
</style>
