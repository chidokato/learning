import os

path = r'resources\views\frontend\partials\categories-area.blade.php'
with open(path, 'r', encoding='utf-8', errors='ignore') as f:
    content = f.read()

# The clean end should be:
#                </div>
#             </div>
#          </div>
#       </div>
#    </section>
# But wait, we appended a footer:
#    </div>
# </section>

# Let's find the string: 'Data Science</h6>\n               </div>\n            </div>\n         </div>'
idx = content.find('Data Science</h6>')
if idx != -1:
    end_of_divs = content.find('</div>\n            </div>\n         </div>', idx)
    if end_of_divs != -1:
        # The correct content should be everything up to the end of that '</div>\n            </div>\n         </div>' + '\n   </div>\n</section>'
        end_idx = end_of_divs + len('</div>\n            </div>\n         </div>')
        clean_content = content[:end_idx] + '\n   </div>\n</section>'
        with open(path, 'w', encoding='utf-8') as f:
            f.write(clean_content)
        print('Fixed!')
    else:
        print('Could not find divs')
else:
    print('Could not find Data Science')
