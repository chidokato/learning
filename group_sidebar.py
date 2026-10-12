import sys

path = "resources/views/backend/layouts/app.blade.php"
with open(path, "r", encoding="utf-8") as f:
    content = f.read()

import re

# Find the start and end of the block to replace
start_marker = '<li class="menu-title"><span>Menu</span></li>'
end_marker = '                        @endforeach'

start_idx = content.find(start_marker)
end_idx = content.find(end_marker, start_idx) + len(end_marker)

if start_idx != -1 and end_idx != -1:
    old_block = content[start_idx:end_idx]
    new_block = """@php
                            $menuGroups = [
                                'Giao diện & Trang chủ' => [
                                    ['label' => 'Slider', 'icon' => 'ri-image-line', 'route' => 'backend.sliders.index', 'active' => request()->routeIs('backend.sliders.*')],
                                    ['label' => 'Homepage Categories', 'icon' => 'ri-layout-grid-line', 'route' => 'backend.homepage_categories.index', 'active' => request()->routeIs('backend.homepage_categories.*')],
                                    ['label' => 'Menu', 'icon' => 'ri-menu-line', 'route' => 'backend.menus.index', 'active' => request()->routeIs('backend.menus.*')],
                                ],
                                'Khóa học & Nội dung' => [
                                    ['label' => 'Category', 'icon' => 'ri-folder-2-line', 'route' => 'backend.categories.index', 'active' => request()->routeIs('backend.categories.*')],
                                    ['label' => 'Topic', 'icon' => 'ri-price-tag-3-line', 'route' => 'backend.topics.index', 'active' => request()->routeIs('backend.topics.*')],
                                    ['label' => 'Course', 'icon' => 'ri-book-open-line', 'route' => 'backend.courses.index', 'active' => request()->routeIs('backend.courses.*') || request()->routeIs('backend.products.*')],
                                    ['label' => 'Bài kiểm tra', 'icon' => 'ri-file-list-3-line', 'route' => 'backend.tests.index', 'active' => request()->routeIs('backend.tests.*')],
                                    ['label' => 'News', 'icon' => 'ri-newspaper-line', 'route' => 'backend.news.index', 'active' => request()->routeIs('backend.news.*')],
                                ],
                                'Chăm sóc khách hàng' => [
                                    ['label' => 'Customer inquiry', 'icon' => 'ri-customer-service-2-line', 'route' => 'backend.customer-inquiries.index', 'active' => request()->routeIs('backend.customer-inquiries.*')],
                                    ['label' => 'AI ChatBot', 'icon' => 'ri-robot-line', 'route' => 'backend.chatbot.edit', 'active' => request()->routeIs('backend.chatbot.*')],
                                ],
                                'Hệ thống' => [
                                    ['label' => 'SEO', 'icon' => 'ri-search-eye-line', 'route' => 'backend.seo.edit', 'active' => request()->routeIs('backend.seo.*')],
                                    ['label' => 'Setting', 'icon' => 'ri-settings-3-line', 'route' => 'backend.settings.edit', 'active' => request()->routeIs('backend.settings.*')],
                                    ['label' => 'User', 'icon' => 'ri-user-3-line', 'route' => 'backend.users.index', 'active' => request()->routeIs('backend.users.*')],
                                ]
                            ];
                        @endphp
                        @foreach ($menuGroups as $groupName => $menuItems)
                            <li class="menu-title"><span data-key="t-{{ \\Illuminate\\Support\\Str::slug($groupName) }}">{{ $groupName }}</span></li>
                            @foreach ($menuItems as $item)
                                <li class="nav-item">
                                    <a class="nav-link menu-link {{ $item['active'] ? 'active' : '' }}" href="{{ $item['route'] ? route($item['route']) : '#' }}">
                                        <i class="{{ $item['icon'] }}"></i>
                                        <span>{{ $item['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endforeach"""
    
    content = content.replace(old_block, new_block)
    with open(path, "w", encoding="utf-8") as f:
        f.write(content)
else:
    print("Could not find block to replace.")
