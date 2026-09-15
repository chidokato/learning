document.addEventListener("DOMContentLoaded", function() {
    const raw = document.getElementById('raw-curriculum');
    const container = document.getElementById('dynamic-curriculum-container');
    if(!raw || !container) return;
    
    let html = '<div class="accordion" id="accordionExample">';
    let chapters = [];
    let currentChapter = null;
    
    // Phân tích dữ liệu từ CKEditor (tìm H3 và UL)
    Array.from(raw.children).forEach(child => {
        if(child.tagName.toLowerCase() === 'h3') {
            if(currentChapter) chapters.push(currentChapter);
            currentChapter = { title: child.textContent, lessons: [] };
        } else if (child.tagName.toLowerCase() === 'ul' && currentChapter) {
            Array.from(child.children).forEach(li => {
                if(li.tagName.toLowerCase() === 'li') {
                    currentChapter.lessons.push(li.innerHTML);
                }
            });
        } else if (currentChapter && child.textContent.trim() !== '') {
            currentChapter.lessons.push(child.innerHTML);
        }
    });
    if(currentChapter) chapters.push(currentChapter);
    
    // Nếu không có thẻ H3 nào, hiển thị mặc định
    if(chapters.length === 0) {
        container.innerHTML = '<div class="content-body">' + raw.innerHTML + '</div>';
        document.getElementById('total-chapters-count').innerText = '0';
        return;
    }
    
    document.getElementById('total-chapters-count').innerText = chapters.length;

    chapters.forEach((chap, idx) => {
        const chapterTitle = document.createElement('span');
        chapterTitle.textContent = chap.title.toLocaleLowerCase('vi-VN')
            .replace(/\p{L}/u, letter => letter.toLocaleUpperCase('vi-VN'));
        let isShow = idx === 0 ? 'show' : '';
        let isCollapsed = idx === 0 ? '' : 'collapsed';
        let ariaExpanded = idx === 0 ? 'true' : 'false';
        let collapseId = 'collapseChap' + idx;
        let headingId = 'headingChap' + idx;
        
        let lessonHtml = chap.lessons.map(lessonHTML => {
            return `
            <li>
               <i class="far fa-play-circle" style="color: #03594E;"></i>
               <div class="lesson-text">
                  ${lessonHTML}
               </div>
            </li>
            `;
        }).join('');
        
        html += `
          <div class="accordion-items">
             <h4 class="accordion-header" id="${headingId}">
                <button class="accordion-buttons ${isCollapsed}" type="button" data-bs-toggle="collapse"
                   data-bs-target="#${collapseId}" aria-expanded="${ariaExpanded}"
                   aria-controls="${collapseId}">
                   ${chapterTitle.outerHTML}
                   <span>${chap.lessons.length} bài học</span>                 
                </button>
             </h4>
             <div id="${collapseId}" class="accordion-collapse collapse ${isShow}"
                aria-labelledby="${headingId}" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                   <div class="accordion-content">
                      <ul>
                         ${lessonHtml}
                      </ul>
                   </div>
                </div>
             </div>
          </div>
        `;
    });
    
    html += '</div>';
    container.innerHTML = html;
    
    // Xử lý nút Mở rộng tất cả / Thu gọn tất cả
    const toggleBtn = document.getElementById('toggle-all-accordion');
    if(toggleBtn) {
        let isExpandedAll = false;
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            isExpandedAll = !isExpandedAll;
            
            const collapses = container.querySelectorAll('.accordion-collapse');
            const buttons = container.querySelectorAll('.accordion-buttons');
            
            if(isExpandedAll) {
                // Mở tất cả
                collapses.forEach(el => el.classList.add('show'));
                buttons.forEach(el => {
                    el.classList.remove('collapsed');
                    el.setAttribute('aria-expanded', 'true');
                });
                toggleBtn.innerText = 'Thu gọn tất cả';
            } else {
                // Đóng tất cả
                collapses.forEach(el => el.classList.remove('show'));
                buttons.forEach(el => {
                    el.classList.add('collapsed');
                    el.setAttribute('aria-expanded', 'false');
                });
                toggleBtn.innerText = 'Mở rộng tất cả';
            }
        });
    }
});
