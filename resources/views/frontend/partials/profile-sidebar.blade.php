<div class="it-shop-sidebar">
   <div class="sidebar-widget mb-40">
      @if(Auth::check())
         <div class="d-flex align-items-center mb-25 pb-20 border-bottom">
            <div class="flex-shrink-0 me-3">
               <div style="width: 52px; height: 52px; border-radius: 50%; background: #03594e; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: bold;">
                  {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
               </div>
            </div>
            <div class="flex-grow-1 overflow-hidden">
               <h5 class="mb-5 text-truncate" style="font-size: 17px; font-weight: 600;">{{ Auth::user()->name }}</h5>
               <p class="mb-0 text-muted text-truncate" style="font-size: 13px;">{{ Auth::user()->email }}</p>
            </div>
         </div>
      @else
         <div class="d-flex align-items-center mb-25 pb-20 border-bottom">
            <div class="flex-shrink-0 me-3">
               <div style="width: 52px; height: 52px; border-radius: 50%; background: #03594e; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                  <i class="far fa-user"></i>
               </div>
            </div>
            <div class="flex-grow-1 overflow-hidden">
               <h5 class="mb-5 text-truncate" style="font-size: 17px; font-weight: 600;">Khách</h5>
               <a href="{{ route('frontend.login') }}" class="text-primary" style="font-size: 13px;">Đăng nhập</a>
            </div>
         </div>
      @endif

      <div class="sidebar-widget-list-wrap">
         <ul class="nav flex-column gap-2" id="profileTab">
            <li class="nav-item">
               <a class="sidebar-widget-list {{ request()->routeIs('frontend.profile') && !request()->has('tab') ? 'active' : '' }} text-decoration-none" href="{{ route('frontend.profile') }}">
                  <span><i class="far fa-user me-2"></i> Thông tin cá nhân</span>
                  <i class="far fa-angle-right"></i>
               </a>
            </li>
            <li class="nav-item">
               <a class="sidebar-widget-list text-decoration-none" href="{{ route('frontend.profile') }}#tab-password">
                  <span><i class="far fa-key me-2"></i> Đổi mật khẩu</span>
                  <i class="far fa-angle-right"></i>
               </a>
            </li>
            <li class="nav-item">
               <a class="sidebar-widget-list {{ request()->routeIs('frontend.tests.*') ? 'active' : '' }} text-decoration-none" href="{{ route('frontend.tests.index') }}">
                  <span><i class="far fa-clipboard-check me-2"></i> Bài kiểm tra</span>
                  <i class="far fa-angle-right"></i>
               </a>
            </li>
            @if(Auth::check() && Auth::user()->isAdmin())
            <li class="nav-item">
               <a class="sidebar-widget-list text-decoration-none" href="{{ route('backend.admin.dashboard') }}">
                  <span><i class="far fa-user-cog me-2"></i> Quản trị hệ thống</span>
                  <i class="far fa-angle-right"></i>
               </a>
            </li>
            @endif
            @if(Auth::check())
            <li class="nav-item">
               <a class="sidebar-widget-list text-decoration-none" href="{{ route('frontend.logout.get') }}" onclick="event.preventDefault(); document.getElementById('profile-logout-form').submit();">
                  <span class="text-danger"><i class="far fa-sign-out-alt me-2"></i> Đăng xuất</span>
                  <i class="far fa-angle-right text-danger"></i>
               </a>
               <form id="profile-logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                  @csrf
               </form>
            </li>
            @endif
         </ul>
      </div>
   </div>
</div>
