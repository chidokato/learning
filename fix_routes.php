<?php
$lines = file('routes/web.php');
$newLines = [];
$inAuthBlock = false;

$replacement = <<<PHP
// Frontend Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('frontend.login');
    Route::post('login', 'login')->name('frontend.login.post');
    Route::get('sign-in.html', 'showLoginForm');
    Route::get('dang-nhap', 'showLoginForm');

    Route::get('register', 'showRegisterForm')->name('frontend.register');
    Route::post('register', 'register')->name('frontend.register.post');
    Route::get('sign-up.html', 'showRegisterForm');
    Route::get('dang-ky', 'showRegisterForm');

    Route::post('logout', 'logout')->name('frontend.logout');
    Route::get('logout', 'logout')->name('frontend.logout.get');
    Route::post('forgot-password', 'forgotPassword')->name('frontend.forgot-password');
    Route::middleware('auth')->group(function () {
        Route::get('profile', fn () => view('frontend.profile'))->name('frontend.profile');
        Route::post('profile', 'updateProfile')->name('frontend.profile.update');
    });
});
PHP;

foreach ($lines as $i => $line) {
    if ($i == 100) {
        $newLines[] = $replacement . "\n";
        $inAuthBlock = true;
    }
    if ($inAuthBlock && $i <= 120) {
        continue;
    }
    if ($i > 120) {
        $inAuthBlock = false;
        $newLines[] = $line;
    }
    if ($i < 100) {
        $newLines[] = $line;
    }
}

file_put_contents('routes/web.php', implode("", $newLines));
echo "Done replacing routes\n";
