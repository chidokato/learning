@php
   $isProfilePage = request()->routeIs('frontend.profile');
   $isTestsPage = request()->routeIs('frontend.tests.*');
   $currentUser = Auth::user();
@endphp

<style>
   .profile-sidebar-card {
      background: #ffffff;
      border: 1px solid #eef2f6;
      border-radius: 16px;
      padding: 22px 16px;
      box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
      margin-bottom: 30px;
   }
   .profile-user-info {
      display: flex;
      align-items: center;
      gap: 12px;
      padding-bottom: 16px;
      margin-bottom: 14px;
      border-bottom: 1px solid #f1f4f8;
   }
   .profile-avatar-box {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 19px;
      flex-shrink: 0;
      background: linear-gradient(135deg, #03594e 0%, #057d6e 100%);
      color: #ffffff;
      box-shadow: 0 4px 10px rgba(3, 89, 78, 0.18);
      overflow: hidden;
   }
   .profile-avatar-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
   }
   .profile-user-name {
      font-size: 15px;
      font-weight: 700;
      color: #1a2c5e;
      margin-bottom: 2px;
      line-height: 1.25;
   }
   .profile-user-email {
      font-size: 12px;
      color: #64748b;
      margin-bottom: 4px;
      line-height: 1.2;
   }
   .profile-role-badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      font-weight: 600;
      padding: 2px 7px;
      border-radius: 6px;
      background: rgba(3, 89, 78, 0.08);
      color: #03594e;
   }
   .profile-role-badge.badge-admin {
      background: rgba(26, 44, 94, 0.08);
      color: #1a2c5e;
   }

   .profile-nav-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 4px;
   }
   .profile-nav-link {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 14px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 500;
      color: #334155;
      text-decoration: none !important;
      transition: all 0.2s ease-in-out;
      border: 1px solid transparent;
      background: transparent;
      cursor: pointer;
      width: 100%;
   }
   .profile-nav-link-content {
      display: flex;
      align-items: center;
      gap: 11px;
   }
   .profile-nav-icon {
      width: 20px;
      text-align: center;
      font-size: 14.5px;
      color: #64748b;
      transition: color 0.2s ease;
   }
   .profile-nav-arrow {
      font-size: 11px;
      color: #94a3b8;
      transition: all 0.2s ease;
      opacity: 0.6;
   }
   .profile-nav-link:hover {
      background: #f8fafc;
      color: #03594e;
      border-color: #f1f5f9;
   }
   .profile-nav-link:hover .profile-nav-icon {
      color: #03594e;
   }
   .profile-nav-link:hover .profile-nav-arrow {
      opacity: 1;
      color: #03594e;
      transform: translateX(2px);
   }
   .profile-nav-link.active {
      background: linear-gradient(135deg, #03594e 0%, #046e61 100%) !important;
      color: #ffffff !important;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(3, 89, 78, 0.22);
      border-color: #03594e !important;
   }
   .profile-nav-link.active .profile-nav-icon {
      color: #ffffff !important;
   }
   .profile-nav-link.active .profile-nav-arrow {
      color: #ffffff !important;
      opacity: 0.9;
   }
   .profile-nav-divider {
      height: 1px;
      background: #f1f4f8;
      margin: 8px 4px;
   }
   .profile-nav-link.logout {
      color: #dc2626;
   }
   .profile-nav-link.logout .profile-nav-icon {
      color: #dc2626;
   }
   .profile-nav-link.logout .profile-nav-arrow {
      color: #dc2626;
   }
   .profile-nav-link.logout:hover {
      background: #fef2f2;
      color: #b91c1c;
      border-color: #fee2e2;
   }
   .profile-nav-link.logout:hover .profile-nav-icon,
   .profile-nav-link.logout:hover .profile-nav-arrow {
      color: #b91c1c;
   }
</style>

<div class="profile-sidebar-card">
   @if(Auth::check())
      <div class="profile-user-info">
         <div class="profile-avatar-box">
            @if($currentUser->avatar && file_exists(public_path($currentUser->avatar)))
               <img src="{{ asset($currentUser->avatar) }}" alt="{{ $currentUser->name }}">
            @else
               {{ mb_strtoupper(mb_substr($currentUser->name ?? 'U', 0, 1, 'UTF-8'), 'UTF-8') }}
            @endif
         </div>
         <div class="overflow-hidden flex-grow-1">
            <h5 class="profile-user-name text-truncate">{{ $currentUser->name }}</h5>
            <div class="profile-user-email text-truncate">{{ $currentUser->email }}</div>
            @if($currentUser->isAdmin())
               <span class="profile-role-badge badge-admin"><i class="far fa-shield-alt"></i> Quản trị viên</span>
            @else
               <span class="profile-role-badge"><i class="far fa-user-graduate"></i> Học viên</span>
            @endif
         </div>
      </div>
   @else
      <div class="profile-user-info">
         <div class="profile-avatar-box">
            <i class="far fa-user"></i>
         </div>
         <div class="overflow-hidden flex-grow-1">
            <h5 class="profile-user-name text-truncate">Khách</h5>
            <a href="{{ route('frontend.login') }}" class="text-primary" style="font-size: 13px;">Đăng nhập</a>
         </div>
      </div>
   @endif

   <div class="profile-sidebar-nav-wrap">
      <ul class="profile-nav-list" id="profileTab" role="tablist">
         <!-- 1. Thông tin cá nhân -->
         <li class="nav-item">
            @if($isProfilePage)
               <a class="profile-nav-link active" id="tab-info-link" data-bs-toggle="pill" href="#tab-info" role="tab" aria-controls="tab-info" aria-selected="true">
                  <span class="profile-nav-link-content">
                     <i class="far fa-user profile-nav-icon"></i>
                     <span>Thông tin cá nhân</span>
                  </span>
                  <i class="far fa-angle-right profile-nav-arrow"></i>
               </a>
            @else
               <a class="profile-nav-link" href="{{ route('frontend.profile') }}#tab-info">
                  <span class="profile-nav-link-content">
                     <i class="far fa-user profile-nav-icon"></i>
                     <span>Thông tin cá nhân</span>
                  </span>
                  <i class="far fa-angle-right profile-nav-arrow"></i>
               </a>
            @endif
         </li>

         <!-- 3. Lịch sử học tập -->
         <li class="nav-item">
            @if($isProfilePage)
               <a class="profile-nav-link" id="tab-learning-history-link" data-bs-toggle="pill" href="#tab-learning-history" role="tab" aria-controls="tab-learning-history" aria-selected="false">
                  <span class="profile-nav-link-content">
                     <i class="far fa-graduation-cap profile-nav-icon"></i>
                     <span>Lịch sử học tập</span>
                  </span>
                  <i class="far fa-angle-right profile-nav-arrow"></i>
               </a>
            @else
               <a class="profile-nav-link" href="{{ route('frontend.profile') }}#tab-learning-history">
                  <span class="profile-nav-link-content">
                     <i class="far fa-graduation-cap profile-nav-icon"></i>
                     <span>Lịch sử học tập</span>
                  </span>
                  <i class="far fa-angle-right profile-nav-arrow"></i>
               </a>
            @endif
         </li>

         <!-- 4. Lịch sử làm bài -->
         <li class="nav-item">
            @if($isProfilePage)
               <a class="profile-nav-link" id="tab-test-history-link" data-bs-toggle="pill" href="#tab-test-history" role="tab" aria-controls="tab-test-history" aria-selected="false">
                  <span class="profile-nav-link-content">
                     <i class="far fa-history profile-nav-icon"></i>
                     <span>Lịch sử làm bài</span>
                  </span>
                  <i class="far fa-angle-right profile-nav-arrow"></i>
               </a>
            @else
               <a class="profile-nav-link" href="{{ route('frontend.profile') }}#tab-test-history">
                  <span class="profile-nav-link-content">
                     <i class="far fa-history profile-nav-icon"></i>
                     <span>Lịch sử làm bài</span>
                  </span>
                  <i class="far fa-angle-right profile-nav-arrow"></i>
               </a>
            @endif
         </li>

         <!-- 5. Bài kiểm tra -->
         <li class="nav-item">
            <a class="profile-nav-link {{ $isTestsPage ? 'active' : '' }}" href="{{ route('frontend.tests.index') }}">
               <span class="profile-nav-link-content">
                  <i class="far fa-clipboard-check profile-nav-icon"></i>
                  <span>Bài kiểm tra</span>
               </span>
               <i class="far fa-angle-right profile-nav-arrow"></i>
            </a>
         </li>

         @if(Auth::check() && $currentUser->isAdmin())
            <li class="profile-nav-divider"></li>
            <li class="nav-item">
               <a class="profile-nav-link" href="{{ route('backend.admin.dashboard') }}">
                  <span class="profile-nav-link-content">
                     <i class="far fa-user-cog profile-nav-icon"></i>
                     <span>Quản trị hệ thống</span>
                  </span>
                  <span class="d-flex align-items-center gap-1">
                     <span class="badge" style="background: rgba(26,44,94,0.08); color: #1a2c5e; font-size: 10px; font-weight: 600; padding: 2px 6px;">Admin</span>
                     <i class="far fa-angle-right profile-nav-arrow"></i>
                  </span>
               </a>
            </li>
         @endif

         @if(Auth::check())
            <li class="profile-nav-divider"></li>
            <li class="nav-item">
               <a class="profile-nav-link logout" href="{{ route('frontend.logout.get') }}" onclick="event.preventDefault(); document.getElementById('profile-logout-form').submit();">
                  <span class="profile-nav-link-content">
                     <i class="far fa-sign-out-alt profile-nav-icon"></i>
                     <span>Đăng xuất</span>
                  </span>
                  <i class="far fa-angle-right profile-nav-arrow"></i>
               </a>
               <form id="profile-logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                  @csrf
               </form>
            </li>
         @endif
      </ul>
   </div>
</div>
