import os

path = r'routes\web.php'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

new_routes = """    Route::controller(\\App\\Http\\Controllers\\HomepageCategoryController::class)->group(function () {
        Route::get('homepage-categories', 'index')->name('homepage_categories.index');
        Route::get('homepage-categories/create', 'create')->name('homepage_categories.create');
        Route::post('homepage-categories', 'store')->name('homepage_categories.store');
        Route::get('homepage-categories/{homepageCategory}/edit', 'edit')->name('homepage_categories.edit');
        Route::put('homepage-categories/{homepageCategory}', 'update')->name('homepage_categories.update');
        Route::delete('homepage-categories/{homepageCategory}', 'destroy')->name('homepage_categories.destroy');
    });
"""

# We insert right before `});\n\n$categoryHandler`
target = "});\n\n$categoryHandler"
idx = content.find(target)
if idx != -1:
    new_content = content[:idx] + new_routes + target + content[idx + len(target):]
    with open(path, 'w', encoding='utf-8') as f:
        f.write(new_content)
    print("Routes inserted.")
else:
    print("Could not find the insertion point.")
