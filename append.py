import mysql.connector

env_path = r'C:\xampp\htdocs\www\learning\.env'
db_host, db_port, db_database, db_username, db_password = '127.0.0.1', '3306', 'laravel', 'root', ''

with open(env_path, 'r', encoding='utf-8') as f:
    for line in f:
        if line.startswith('DB_HOST='): db_host = line.split('=')[1].strip()
        if line.startswith('DB_PORT='): db_port = line.split('=')[1].strip()
        if line.startswith('DB_DATABASE='): db_database = line.split('=')[1].strip()
        if line.startswith('DB_USERNAME='): db_username = line.split('=')[1].strip()
        if line.startswith('DB_PASSWORD='): db_password = line.split('=', 1)[1].strip()

conn = mysql.connector.connect(
    host=db_host, port=db_port, user=db_username, password=db_password, database=db_database
)
cursor = conn.cursor(dictionary=True)
cursor.execute("SELECT * FROM homepage_categories ORDER BY sort_order")
rows = cursor.fetchall()

php_code = "\n$data = [\n"
for row in rows:
    title = row['title'].replace("'", "\\'")
    svg = row['svg_icon'].replace("'", "\\'")
    php_code += f"    ['title' => '{title}', 'svg_icon' => '{svg}', 'sort_order' => {row['sort_order']}, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],\n"
php_code += "];\n\n"
php_code += "if (DB::table('homepage_categories')->count() == 0) {\n"
php_code += "    DB::table('homepage_categories')->insert($data);\n"
php_code += "    echo 'Inserted data successfully!<br>';\n"
php_code += "} else {\n"
php_code += "    echo 'Data already exists.<br>';\n"
php_code += "}\n"

with open(r'c:\xampp\htdocs\www\learning\public\setup_categories.php', 'a', encoding='utf-8') as f:
    f.write(php_code)

print("Done appending")
