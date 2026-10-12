import sys
import re

path = "routes/web.php"
with open(path, "r", encoding="utf-8") as f:
    content = f.read()

target = "Route::get('products/create', fn () => redirect()->route('backend.courses.create'))->name('products.create');\n    });"
replacement = target + """

    Route::controller(\\App\\Http\\Controllers\\AdminTestController::class)->group(function () {
        Route::get('tests', 'index')->name('tests.index');
        Route::get('tests/{test}', 'show')->name('tests.show');
        Route::post('tests/import', 'import')->name('tests.import');
        Route::delete('tests/{test}', 'destroy')->name('tests.destroy');
    });
"""

content = content.replace(target, replacement)

with open(path, "w", encoding="utf-8") as f:
    f.write(content)
