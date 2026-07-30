@php
    $hasChildren = $menu->active_children_tree && $menu->active_children_tree->isNotEmpty();
@endphp

<li class="{{ $hasChildren ? 'has-dropdown' : '' }}">
   <a href="{{ $menu->url }}" target="{{ $menu->target ?: '_self' }}">{{ $menu->name }}</a>
   @if ($hasChildren)
      <ul class="it-submenu submenu">
         @foreach ($menu->active_children_tree as $child)
            @include('frontend.partials.menu-item', ['menu' => $child])
         @endforeach
      </ul>
   @endif
</li>
