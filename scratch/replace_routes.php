<?php
$c = file_get_contents("routes/web.php");
$target = "    Route::controller(UserController::class)->group(function () {\n        Route::get('users', 'index')->name('users.index');\n        Route::get('users/create', 'create')->name('users.create');\n        Route::post('users', 'store')->name('users.store');\n        Route::get('users/{user}/edit', 'edit')->name('users.edit');\n        Route::put('users/{user}', 'update')->name('users.update');\n        Route::delete('users/{user}', 'destroy')->name('users.destroy');\n    });\n});";
$replacement = "    Route::controller(UserController::class)->group(function () {\n        Route::get('users', 'index')->name('users.index');\n        Route::get('users/create', 'create')->name('users.create');\n        Route::post('users', 'store')->name('users.store');\n        Route::get('users/{user}/edit', 'edit')->name('users.edit');\n        Route::put('users/{user}', 'update')->name('users.update');\n        Route::delete('users/{user}', 'destroy')->name('users.destroy');\n    });\n\n    Route::controller(\App\Http\Controllers\SliderController::class)->group(function () {\n        Route::get('sliders', 'index')->name('sliders.index');\n        Route::get('sliders/create', 'create')->name('sliders.create');\n        Route::post('sliders', 'store')->name('sliders.store');\n        Route::get('sliders/{slider}/edit', 'edit')->name('sliders.edit');\n        Route::put('sliders/{slider}', 'update')->name('sliders.update');\n        Route::delete('sliders/{slider}', 'destroy')->name('sliders.destroy');\n    });\n});";

$c_norm = str_replace("\r\n", "\n", $c);
$c_replaced = str_replace($target, $replacement, $c_norm);

file_put_contents("routes/web.php", $c_replaced);
