<footer class="it-modern-footer">
   <!-- newsletter-area-start -->
   <div class="it-footer-newsletter-wrap">
      <div class="container">
         <div class="footer-newsletter-card wow itfadeUp" data-wow-duration=".9s" data-wow-delay=".2s">
            <div class="row align-items-center">
               <div class="col-lg-6 mb-4 mb-lg-0">
                  <div class="newsletter-content">
                     <span class="newsletter-tag">
                        <i class="far fa-paper-plane me-2"></i> BẢN TIN NỘI BỘ
                     </span>
                     <h3 class="newsletter-title text-white mb-2">
                        Đăng ký nhận thông tin & tài liệu mới nhất
                     </h3>
                     <p class="newsletter-desc mb-0 text-white-50">
                        Cập nhật các chương trình đào tạo, quy trình và kỹ năng thực chiến từ Indochine.
                     </p>
                  </div>
               </div>
               <div class="col-lg-6">
                  <form class="newsletter-form" action="#" method="POST" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã đăng ký nhận bản tin Indochine!');">
                     <div class="newsletter-input-group">
                        <i class="far fa-envelope input-icon"></i>
                        <input type="email" placeholder="Nhập địa chỉ email của bạn..." required>
                        <button type="submit" class="btn-newsletter-submit">
                           <span>Đăng Ký</span>
                           <i class="far fa-arrow-right ms-1"></i>
                        </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- newsletter-area-end -->

   <!-- main footer area start -->
   <div class="it-footer-main">
      <div class="container">
         <div class="row gx-4 gy-5">
            <!-- Col 1: Brand Info -->
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 wow itfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
               <div class="footer-widget footer-widget-brand pe-xl-4">
                  <div class="footer-logo mb-25">
                     <a href="{{ route('frontend.home') }}">
                        <img src="{{ $siteSetting->footer_logo_url }}" alt="Indochine Logo" class="footer-logo-img">
                     </a>
                  </div>
                  <p class="footer-brand-desc mb-25">
                     Hệ thống học tập và phát triển năng lực chuyên sâu của <strong>Learning Indochine</strong>. Chuẩn hóa kiến thức kinh doanh bất động sản, nâng tầm đội ngũ chuyên viên tư vấn hàng đầu.
                  </p>
                  <div class="footer-brand-action">
                     <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSetting->hotline ?: '0977572947') }}" class="btn-footer-contact">
                        <i class="fas fa-headset me-2"></i>
                        <span>Hotline Đào Tạo</span>
                     </a>
                  </div>
               </div>
            </div>

            <!-- Col 2: Useful Links (Categories) -->
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 wow itfadeUp" data-wow-duration=".9s" data-wow-delay=".4s">
               <div class="footer-widget">
                  <h4 class="footer-widget-title">Chuyên Đề</h4>
                  <div class="footer-title-line"></div>
                  <ul class="footer-links-list">
                     @php
                        $footerCategories = \App\Models\Category::where('is_active', true)->orderBy('sort_order')->take(5)->get();
                     @endphp
                     @if($footerCategories->isNotEmpty())
                        @foreach($footerCategories as $fCat)
                           <li>
                              <a href="{{ route('frontend.category.show', $fCat->slug) }}">
                                 <i class="far fa-angle-right me-2 link-arrow"></i>{{ $fCat->name }}
                              </a>
                           </li>
                        @endforeach
                     @else
                        <li><a href="{{ route('frontend.home') }}"><i class="far fa-angle-right me-2 link-arrow"></i>Kỹ Năng Bán Hàng</a></li>
                        <li><a href="{{ route('frontend.home') }}"><i class="far fa-angle-right me-2 link-arrow"></i>Đào Tạo Quản Lý</a></li>
                        <li><a href="{{ route('frontend.home') }}"><i class="far fa-angle-right me-2 link-arrow"></i>Tìm Kiếm Khách Hàng</a></li>
                        <li><a href="{{ route('frontend.home') }}"><i class="far fa-angle-right me-2 link-arrow"></i>Kỹ Năng Mềm</a></li>
                     @endif
                  </ul>
               </div>
            </div>

            <!-- Col 3: Portal Links -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 wow itfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
               <div class="footer-widget">
                  <h4 class="footer-widget-title">Học Viên</h4>
                  <div class="footer-title-line"></div>
                  <ul class="footer-links-list">
                     <li>
                        <a href="{{ route('frontend.tests.index') }}">
                           <i class="far fa-angle-right me-2 link-arrow"></i>Bài Kiểm Tra Năng Lực
                        </a>
                     </li>
                     <li>
                        <a href="{{ auth()->check() ? route('frontend.history.learning') : route('frontend.login') }}">
                           <i class="far fa-angle-right me-2 link-arrow"></i>Tiến Độ Học Tập
                        </a>
                     </li>
                     <li>
                        <a href="{{ auth()->check() ? route('frontend.history.tests') : route('frontend.login') }}">
                           <i class="far fa-angle-right me-2 link-arrow"></i>Lịch Sử Làm Bài Thi
                        </a>
                     </li>
                     <li>
                        <a href="{{ auth()->check() ? route('frontend.profile') : route('frontend.login') }}">
                           <i class="far fa-angle-right me-2 link-arrow"></i>Tài Khoản Học Viên
                        </a>
                     </li>
                     <li>
                        <a href="{{ route('frontend.home') }}">
                           <i class="far fa-angle-right me-2 link-arrow"></i>Quy Trình Giao Dịch
                        </a>
                     </li>
                  </ul>
               </div>
            </div>

            <!-- Col 4: Contact Info -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 wow itfadeUp" data-wow-duration=".9s" data-wow-delay=".6s">
               <div class="footer-widget">
                  <h4 class="footer-widget-title">Thông Tin Liên Hệ</h4>
                  <div class="footer-title-line"></div>
                  <div class="footer-contact-items mb-25">
                     <div class="contact-item mb-15">
                        <div class="contact-icon">
                           <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-info">
                           <span class="contact-label">Hotline hỗ trợ:</span>
                           <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSetting->hotline ?: '0977572947') }}" class="contact-value">
                              {{ $siteSetting->hotline ?: '0977 572 947' }}
                           </a>
                        </div>
                     </div>

                     <div class="contact-item mb-15">
                        <div class="contact-icon">
                           <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-info">
                           <span class="contact-label">Email đào tạo:</span>
                           <a href="mailto:{{ $siteSetting->email ?: 'mktindochine@gmail.com' }}" class="contact-value">
                              {{ $siteSetting->email ?: 'mktindochine@gmail.com' }}
                           </a>
                        </div>
                     </div>

                     <div class="contact-item">
                        <div class="contact-icon">
                           <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-info">
                           <span class="contact-label">Trụ sở đào tạo:</span>
                           <span class="contact-value">
                              {{ $siteSetting->address ?: 'Hà Nội, Việt Nam' }}
                           </span>
                        </div>
                     </div>
                  </div>

                  <!-- Social Icons -->
                  <div class="footer-social-wrap">
                     <span class="social-label d-block mb-10">Kênh truyền thông:</span>
                     <div class="footer-social-icons">
                        <a href="https://facebook.com" target="_blank" class="social-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://youtube.com" target="_blank" class="social-btn" title="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="https://tiktok.com" target="_blank" class="social-btn" title="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="https://linkedin.com" target="_blank" class="social-btn" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- main footer area end -->

   <!-- copyright-area-start -->
   <div class="it-footer-bottom">
      <div class="container">
         <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
               <p class="copyright-text mb-0">
                  Bản quyền © {{ date('Y') }} <a href="{{ route('frontend.home') }}" class="copyright-brand">Learning Indochine</a>. Bảo lưu mọi quyền.
               </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
               <div class="footer-bottom-links">
                  <a href="#">Điều khoản sử dụng</a>
                  <span class="divider">·</span>
                  <a href="#">Chính sách bảo mật</a>
                  <span class="divider">·</span>
                  <a href="#">Hỗ trợ kỹ thuật</a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- copyright-area-end -->

   @include('frontend.partials.chatbot-widget')
</footer>
