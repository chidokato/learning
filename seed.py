import os
import re
import mysql.connector

# Find database credentials from .env
env_path = r'C:\xampp\htdocs\www\learning\.env'
db_host, db_port, db_database, db_username, db_password = '127.0.0.1', '3306', 'laravel', 'root', ''

if os.path.exists(env_path):
    with open(env_path, 'r', encoding='utf-8') as f:
        for line in f:
            if line.startswith('DB_HOST='): db_host = line.split('=')[1].strip()
            if line.startswith('DB_PORT='): db_port = line.split('=')[1].strip()
            if line.startswith('DB_DATABASE='): db_database = line.split('=')[1].strip()
            if line.startswith('DB_USERNAME='): db_username = line.split('=')[1].strip()
            if line.startswith('DB_PASSWORD='): db_password = line.split('=', 1)[1].strip()

# Read the categories HTML
html_path = r'C:\xampp\htdocs\www\learning\resources\views\frontend\partials\categories-area.blade.php'
with open(html_path, 'r', encoding='utf-8') as f:
    html = f.read()

# Parse the items
import xml.etree.ElementTree as ET
# Because the HTML is messy, we can use regex to find each block.
items = re.findall(r'<div class="it-categories-item[^>]*>.*?<svg[^>]*>.*?</svg>.*?<h6[^>]*>(.*?)</h6>', html, re.DOTALL)
# Wait, this regex is too simple and might fail. Let's do better:
items = re.findall(r'<div class="it-categories-item.*?<svg(.*?)<\/svg>.*?<h6[^>]*>(.*?)</h6>', html, re.DOTALL)

try:
    conn = mysql.connector.connect(
        host=db_host,
        port=db_port,
        user=db_username,
        password=db_password,
        database=db_database
    )
    cursor = conn.cursor()
    
    # Check if empty
    cursor.execute("SELECT COUNT(*) FROM homepage_categories")
    count = cursor.fetchone()[0]
    
    if count == 0:
        sort_order = 1
        for svg_inner, title in items:
            full_svg = '<svg' + svg_inner + '</svg>'
            title = title.strip()
            cursor.execute(
                "INSERT INTO homepage_categories (title, svg_icon, sort_order, is_active, created_at, updated_at) VALUES (%s, %s, %s, %s, NOW(), NOW())",
                (title, full_svg, sort_order, 1)
            )
            sort_order += 1
        conn.commit()
        print(f'Inserted {len(items)} items.')
    else:
        print('Items already exist in DB.')
        
    cursor.close()
    conn.close()
except Exception as e:
    print('DB Error:', e)

