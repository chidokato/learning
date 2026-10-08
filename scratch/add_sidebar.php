<?php
$c = file_get_contents("resources/views/backend/layouts/app.blade.php");
$target = "['label' => 'Menu', 'icon' => 'ri-menu-line', 'route' => 'backend.menus.index'],";
$replacement = "['label' => 'Slider', 'icon' => 'ri-image-line', 'route' => 'backend.sliders.index'],\n                                ['label' => 'Menu', 'icon' => 'ri-menu-line', 'route' => 'backend.menus.index'],";
$c = str_replace($target, $replacement, $c);

$targetActive = "{{ \$item['label'] === 'Setting' && request()->routeIs('backend.settings.*') ? 'active' : '' }}";
$replacementActive = "{{ \$item['label'] === 'Setting' && request()->routeIs('backend.settings.*') ? 'active' : '' }} {{ \$item['label'] === 'Slider' && request()->routeIs('backend.sliders.*') ? 'active' : '' }}";
$c = str_replace($targetActive, $replacementActive, $c);

file_put_contents("resources/views/backend/layouts/app.blade.php", $c);
