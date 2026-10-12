import sys
import re

path = "resources/views/frontend/tests/show.blade.php"
with open(path, "r", encoding="utf-8") as f:
    content = f.read()

# I need to extract the existing test form and result-box
form_match = re.search(r'(<div class="text-center mb-40">.*?</div>.*?<div id="result-box">.*?</div>)', content, re.DOTALL)
if not form_match:
    print("Could not find form block")
    sys.exit(1)

form_html = form_match.group(1)

# Now I'll replace the entire <main> block
new_main = """   <main>
      <div class="it-blog-details-area blog-details-left-sidebar pt-130 pb-130">
         <div class="container">
            <div class="row gx-35">
               
               <!-- Sidebar -->
               <div class="col-xl-4 col-lg-4">
                  <div class="it-shop-sidebar">
                     <div class="sidebar-widget mb-60">
                        <h4 class="sidebar-widget-title mb-25">Tìm kiếm</h4>
                        <div class="sidebar-search-box p-relative">
                           <form action="#">
                              <div class="sidebar-search-input">
                                 <input type="text" placeholder="Nhập từ khóa...">
                              </div>
                              <div class="sidebar-search-button">
                                 <button type="submit">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M17.0287 15.9397L13.7295 12.6592C14.6152 11.4885 15.087 9.89996 15.1238 7.91246C15.045 3.34121 12.4935 0.80771 7.93275 0.77771C3.31725 0.80696 0.75 3.48671 0.75 7.91171C0.75 12.558 3.3195 15.0457 7.94175 15.0727C9.9135 15.0607 11.496 14.6032 12.669 13.719L15.9713 17.0032C16.3597 17.3722 16.8195 17.2215 17.0317 17.0002C17.319 16.7017 17.3228 16.2315 17.0287 15.9397ZM2.25 7.92521C2.32275 4.14896 4.18425 2.30096 7.932 2.27771C11.6438 2.30171 13.5593 4.20596 13.6238 7.91171C13.5533 11.7517 11.745 13.5502 7.94175 13.5727C4.134 13.5502 2.325 11.7562 2.25 7.92521Z" fill="#03594E"></path>
                                    </svg>
                                 </button>
                              </div>
                           </form>
                        </div>
                     </div>
                     
                     <div class="sidebar-contact-wrap theme-bg fix z-index-1 text-center mb-60">
                        <img class="shape" src="{{ asset('assets/img/shape/blog-contact.png') }}" alt="">
                        <div class="thumb p-relative">
                           <div class="sidebar-contact-circle" style="position: static; transform: none; width: 150px; height: 150px; line-height: 150px; border-radius: 50%; background: #fff; margin: 0 auto; color: #00225a; font-weight: bold;">
                              <span>100% <br>CHẤT LƯỢNG</span>
                           </div>
                        </div>
                        <div class="sidebar-contact-2 mt-30">
                           <span>Hỗ trợ Kỹ thuật</span>
                           <a class="border-line" href="tel:{{ preg_replace('/[^0-9]/', '', $siteSetting->hotline ?? '') }}">{{ $siteSetting->hotline ?? '' }}</a>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Main Content -->
               <div class="col-xl-8 col-lg-8">
                  """ + form_html + """
               </div>

            </div>
         </div>
      </div>
   </main>"""

content = re.sub(r'<main>.*?</main>', new_main, content, flags=re.DOTALL)

with open(path, "w", encoding="utf-8") as f:
    f.write(content)
