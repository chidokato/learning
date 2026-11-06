document.addEventListener("DOMContentLoaded", function() {
    const raw = document.getElementById('raw-curriculum');
    const container = document.getElementById('dynamic-curriculum-container');
    if(!raw || !container) return;
    
    let html = '<div class="accordion" id="accordionExample">';
    let chapters = [];
    let currentChapter = null;
    
    // Phân tích dữ liệu từ CKEditor (tìm H2, H3, H4 và UL)
    Array.from(raw.children).forEach(child => {
        const tag = child.tagName.toLowerCase();
        if(tag === 'h2' || tag === 'h3' || tag === 'h4') {
            if(currentChapter) chapters.push(currentChapter);
            currentChapter = { title: child.textContent.trim(), lessons: [] };
        } else if (tag === 'ul' && currentChapter) {
            Array.from(child.children).forEach(li => {
                if(li.tagName.toLowerCase() === 'li') {
                    currentChapter.lessons.push(li.innerHTML.trim());
                }
            });
        } else if (currentChapter && child.textContent.trim() !== '') {
            currentChapter.lessons.push(child.innerHTML.trim());
        }
    });
    if(currentChapter) chapters.push(currentChapter);
    
    // Nếu không có thẻ tiêu đề nào, hiển thị mặc định
    if(chapters.length === 0) {
        container.innerHTML = '<div class="content-body p-3 bg-white rounded border">' + raw.innerHTML + '</div>';
        const chapCountEl = document.getElementById('total-chapters-count');
        if(chapCountEl) chapCountEl.innerText = '0';
        const lessonCountEl = document.getElementById('total-lessons-count');
        if(lessonCountEl) lessonCountEl.innerText = '0';
        return;
    }
    
    // Đếm tổng số bài học
    let totalLessons = 0;
    chapters.forEach(chap => {
        totalLessons += chap.lessons.length;
    });

    const chapCountEl = document.getElementById('total-chapters-count');
    if(chapCountEl) chapCountEl.innerText = chapters.length;

    const lessonCountEl = document.getElementById('total-lessons-count');
    if(lessonCountEl) lessonCountEl.innerText = totalLessons;

    chapters.forEach((chap, idx) => {
        let isShow = idx === 0 ? 'show' : '';
        let isCollapsed = idx === 0 ? '' : 'collapsed';
        let ariaExpanded = idx === 0 ? 'true' : 'false';
        let collapseId = 'collapseChap' + idx;
        let headingId = 'headingChap' + idx;
        let activeClass = idx === 0 ? 'active-chapter' : '';

        // Giữ tiêu đề rõ ràng, viết hoa chữ cái đầu nếu cần
        let displayTitle = chap.title;
        if (displayTitle && displayTitle.length > 0) {
            displayTitle = displayTitle.charAt(0).toUpperCase() + displayTitle.slice(1);
        }
        
        let lessonHtml = chap.lessons.map(lessonHTML => {
            return `
            <li class="curriculum-lesson-item">
               <div class="lesson-left">
                  <span class="lesson-play-icon">
                     <i class="fa-solid fa-play"></i>
                  </span>
                  <div class="lesson-text">
                     ${lessonHTML}
                  </div>
               </div>
               <div class="lesson-right">
                  <span class="lesson-type-tag">Bài học</span>
               </div>
            </li>
            `;
        }).join('');
        
        html += `
          <div class="accordion-items ${activeClass}">
             <h4 class="accordion-header" id="${headingId}">
                <button class="accordion-buttons ${isCollapsed}" type="button" data-bs-toggle="collapse"
                   data-bs-target="#${collapseId}" aria-expanded="${ariaExpanded}"
                   aria-controls="${collapseId}">
                   <div class="chapter-info-left">
                      <span class="chapter-arrow-icon">
                         <i class="fa-solid fa-chevron-down"></i>
                      </span>
                      <span class="chapter-title-text">${displayTitle}</span>
                   </div>
                   <div class="chapter-info-right">
                      <span class="chapter-badge">
                         <i class="fa-regular fa-circle-play me-1"></i>${chap.lessons.length} bài học
                      </span>
                   </div>
                </button>
             </h4>
             <div id="${collapseId}" class="accordion-collapse collapse ${isShow}"
                aria-labelledby="${headingId}">
                <div class="accordion-body">
                   <div class="accordion-content">
                      <ul class="curriculum-lesson-list">
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
    
    // Lắng nghe sự kiện đóng/mở từng chapter để đổi class active-chapter
    container.querySelectorAll('.accordion-collapse').forEach(collapseEl => {
        collapseEl.addEventListener('show.bs.collapse', function() {
            const item = this.closest('.accordion-items');
            if(item) item.classList.add('active-chapter');
        });
        collapseEl.addEventListener('hide.bs.collapse', function() {
            const item = this.closest('.accordion-items');
            if(item) item.classList.remove('active-chapter');
        });
    });

    // Xử lý nút Mở rộng tất cả / Thu gọn tất cả
    const toggleBtn = document.getElementById('toggle-all-accordion');
    if(toggleBtn) {
        let isExpandedAll = false;
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            isExpandedAll = !isExpandedAll;
            
            const collapses = container.querySelectorAll('.accordion-collapse');
            const buttons = container.querySelectorAll('.accordion-buttons');
            const toggleTextEl = document.getElementById('toggle-all-text') || toggleBtn;
            
            if(isExpandedAll) {
                // Mở tất cả
                collapses.forEach(el => {
                    if (window.bootstrap && bootstrap.Collapse) {
                        bootstrap.Collapse.getOrCreateInstance(el, { toggle: false }).show();
                    } else {
                        el.classList.add('show');
                    }
                    const item = el.closest('.accordion-items');
                    if(item) item.classList.add('active-chapter');
                });
                buttons.forEach(el => {
                    el.classList.remove('collapsed');
                    el.setAttribute('aria-expanded', 'true');
                });
                toggleTextEl.innerText = 'Thu gọn tất cả';
                toggleBtn.classList.add('active');
            } else {
                // Đóng tất cả
                collapses.forEach(el => {
                    if (window.bootstrap && bootstrap.Collapse) {
                        bootstrap.Collapse.getOrCreateInstance(el, { toggle: false }).hide();
                    } else {
                        el.classList.remove('show');
                    }
                    const item = el.closest('.accordion-items');
                    if(item) item.classList.remove('active-chapter');
                });
                buttons.forEach(el => {
                    el.classList.add('collapsed');
                    el.setAttribute('aria-expanded', 'false');
                });
                toggleTextEl.innerText = 'Mở rộng tất cả';
                toggleBtn.classList.remove('active');
            }
        });
    }
});
