@php
    $hasChildren = $menu->active_children_tree && $menu->active_children_tree->isNotEmpty();
    $isActive = url()->current() == $menu->url;
@endphp

<li class="{{ $hasChildren ? 'has-dropdown' : '' }} {{ $isActive ? 'active' : '' }}">
   <a href="{{ $menu->url }}" target="{{ $menu->target ?: '_self' }}">
      <span>{{ $menu->name }}</span>
      @if ($hasChildren)
         <i class="far fa-chevron-down dropdown-arrow ms-1"></i>
      @endif
   </a>
   @if ($hasChildren)
      <ul class="it-submenu submenu">
         @foreach ($menu->active_children_tree as $child)
            @include('frontend.partials.menu-item', ['menu' => $child])
         @endforeach
      </ul>
   @endif
</li>
