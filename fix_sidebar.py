import sys

path = "resources/views/backend/layouts/app.blade.php"
with open(path, "r", encoding="utf-8") as f:
    content = f.read()

target1 = "['label' => 'Course', 'icon' => 'ri-book-open-line', 'route' => 'backend.courses.index'],"
replacement1 = target1 + "\n                                ['label' => 'Bài kiểm tra', 'icon' => 'ri-file-list-3-line', 'route' => 'backend.tests.index'],"
content = content.replace(target1, replacement1)

target2 = "{{ $item['label'] === 'Course'"
replacement2 = "{{ $item['label'] === 'Bài kiểm tra' && request()->routeIs('backend.tests.*') ? 'active' : '' }} " + target2
content = content.replace(target2, replacement2)

with open(path, "w", encoding="utf-8") as f:
    f.write(content)
