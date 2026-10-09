<?php
function removeBom($path) {
    $content = file_get_contents($path);
    $bom = pack('H*','EFBBBF');
    if (preg_match('/^' . $bom . '/', $content)) {
        $content = preg_replace('/^' . $bom . '/', '', $content);
    }
    $content = trim($content, " \t\n\r\0\x0B");
    $content = "<?php\n" . preg_replace('/^<\?php/', '', $content);
    file_put_contents($path, $content);
}
removeBom(__DIR__ . "/app/Http/Controllers/HomepageCategoryController.php");
