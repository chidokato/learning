<?php
$file = 'app/Http/Controllers/PostController.php';
$content = file_get_contents($file);

$content = str_replace("\$users = User::orderBy('name')->pluck('name', 'id');", "\$sellerOptions = User::orderBy('name')->pluck('name', 'id');", $content);
$content = str_replace("compact('type', 'typeLabel', 'categories', 'users')", "compact('type', 'typeLabel', 'categories', 'sellerOptions')", $content);
$content = str_replace("compact('type', 'typeLabel', 'categories', 'users', 'post')", "compact('type', 'typeLabel', 'categories', 'sellerOptions', 'post')", $content);

file_put_contents($file, $content);
echo "Fixed variable names in PostController to sellerOptions.\n";
