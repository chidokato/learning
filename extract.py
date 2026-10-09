import json
import re
import os

transcript_path = r'C:\Users\chidokato\.gemini\antigravity\brain\5970e8f9-38db-4023-b255-9251953dc80e\.system_generated\logs\transcript_full.jsonl'
output_path = r'c:\xampp\htdocs\www\learning\scratch\categories_body.html'

last_user_input = None
with open(transcript_path, 'r', encoding='utf-8') as f:
    for line in f:
        try:
            entry = json.loads(line)
            if entry.get('type') == 'USER_INPUT':
                last_user_input = entry.get('content')
        except:
            pass

if last_user_input:
    # Find the row block
    idx = last_user_input.find('<div class="row row-cols-xxl-4')
    if idx != -1:
        html_block = last_user_input[idx:]
        with open(output_path, 'w', encoding='utf-8') as out:
            out.write(html_block)
        print('Wrote body')
    else:
        print('Could not find row block')
else:
    print('No user input found')
