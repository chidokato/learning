<!-- Indochine AI ChatBot Widget -->
@if(\App\Services\ChatbotConfigService::get('is_active', true))
<style>
   /* Reset & Base variables for ChatBot Widget */
   :root {
      --ai-primary: #6366F1;
      --ai-secondary: #8B5CF6;
      --ai-accent: #EC4899;
      --ai-dark: #1E1B4B;
      --ai-light: #F8FAFC;
      --ai-border: rgba(99, 102, 241, 0.15);
   }

   /* Floating Trigger Button */
   .ai-chat-floating-btn {
      position: fixed;
      bottom: 28px;
      right: 28px;
      z-index: 9999;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 22px 12px 16px;
      background: linear-gradient(135deg, var(--ai-primary) 0%, var(--ai-secondary) 50%, var(--ai-accent) 100%);
      color: #fff;
      border: none;
      border-radius: 50px;
      cursor: pointer;
      box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.5), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      font-family: 'Inter', sans-serif;
      text-decoration: none !important;
   }
   .ai-chat-floating-btn:hover {
      transform: translateY(-4px) scale(1.05);
      box-shadow: 0 20px 30px -10px rgba(99, 102, 241, 0.7);
      color: #fff;
   }
   .ai-chat-floating-btn .ai-btn-icon {
      width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
   }
   .ai-chat-floating-btn .ai-btn-text {
      font-size: 14px;
      font-weight: 700;
      letter-spacing: 0.3px;
      white-space: nowrap;
   }
   .ai-chat-floating-btn .ai-pulse {
      position: absolute;
      top: -3px;
      right: -3px;
      width: 14px;
      height: 14px;
      background-color: #22c55e;
      border: 2px solid #fff;
      border-radius: 50%;
      animation: ai-pulse-anim 2s infinite;
   }

   @keyframes ai-pulse-anim {
      0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
      70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
      100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
   }

   /* Chat Window Container */
   .ai-chat-window {
      position: fixed;
      bottom: 95px;
      right: 28px;
      width: 400px;
      max-width: calc(100vw - 40px);
      height: 580px;
      max-height: calc(100vh - 120px);
      z-index: 9999;
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      box-shadow: 0 25px 60px rgba(15, 23, 42, 0.2), 0 0 1px 1px rgba(0, 0, 0, 0.08);
      display: flex;
      flex-direction: column;
      overflow: hidden;
      opacity: 0;
      transform: translateY(25px) scale(0.95);
      pointer-events: none;
      transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
      font-family: 'Inter', sans-serif;
      border: 1px solid rgba(255, 255, 255, 0.8);
   }
   .ai-chat-window.active {
      opacity: 1;
      transform: translateY(0) scale(1);
      pointer-events: auto;
   }

   /* Header */
   .ai-chat-header {
      background: linear-gradient(135deg, #1E1B4B 0%, #311042 50%, #4C1D95 100%);
      color: #fff;
      padding: 18px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
   }
   .ai-header-left {
      display: flex;
      align-items: center;
      gap: 12px;
   }
   .ai-avatar {
      position: relative;
      width: 42px;
      height: 42px;
      border-radius: 12px;
      background: linear-gradient(135deg, #A855F7, #EC4899);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(168, 85, 247, 0.4);
      flex-shrink: 0;
   }
   .ai-avatar svg {
      width: 24px;
      height: 24px;
      color: #fff;
   }
   .ai-status-dot {
      position: absolute;
      bottom: -2px;
      right: -2px;
      width: 12px;
      height: 12px;
      background: #22c55e;
      border: 2px solid #1E1B4B;
      border-radius: 50%;
   }
   .ai-header-info h4 {
      margin: 0;
      font-size: 16px;
      font-weight: 700;
      color: #fff;
      line-height: 1.2;
   }
   .ai-header-info span {
      font-size: 11px;
      color: #E2E8F0;
      opacity: 0.85;
   }
   .ai-close-btn {
      background: rgba(255, 255, 255, 0.1);
      border: none;
      color: #fff;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background 0.2s ease;
   }
   .ai-close-btn:hover {
      background: rgba(255, 255, 255, 0.25);
   }

   /* Messages Area */
   .ai-chat-messages {
      flex: 1;
      padding: 18px 20px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 16px;
      background: #F8FAFC;
   }
   .ai-chat-messages::-webkit-scrollbar {
      width: 6px;
   }
   .ai-chat-messages::-webkit-scrollbar-thumb {
      background: #CBD5E1;
      border-radius: 10px;
   }

   .ai-message {
      display: flex;
      flex-direction: column;
      max-width: 85%;
      word-break: break-word;
      font-size: 14px;
      line-height: 1.5;
   }
   .ai-message.bot {
      align-self: flex-start;
   }
   .ai-message.user {
      align-self: flex-end;
   }

   .ai-msg-bubble {
      padding: 12px 16px;
      border-radius: 18px;
      position: relative;
   }
   .ai-message.bot .ai-msg-bubble {
      background: #fff;
      color: #1E293B;
      border-top-left-radius: 4px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      border: 1px solid #E2E8F0;
   }
   .ai-message.user .ai-msg-bubble {
      background: linear-gradient(135deg, var(--ai-primary), var(--ai-secondary));
      color: #fff;
      border-top-right-radius: 4px;
      box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
   }

   /* Markdown in Bot reply */
   .ai-msg-bubble p {
      margin: 0 0 8px 0;
   }
   .ai-msg-bubble p:last-child {
      margin-bottom: 0;
   }
   .ai-msg-bubble ul {
      margin: 6px 0;
      padding-left: 18px;
   }
   .ai-msg-bubble li {
      margin-bottom: 4px;
   }
   .ai-msg-bubble a {
      color: #6366F1;
      font-weight: 600;
      text-decoration: underline;
   }
   .ai-msg-bubble a:hover {
      color: #8B5CF6;
   }

   .ai-msg-time {
      font-size: 10px;
      color: #94A3B8;
      margin-top: 4px;
      align-self: flex-end;
   }
   .ai-message.bot .ai-msg-time {
      align-self: flex-start;
   }

   /* Quick Suggestion Chips */
   .ai-quick-chips {
      padding: 10px 20px;
      background: #fff;
      border-top: 1px solid #F1F5F9;
      display: flex;
      gap: 8px;
      overflow-x: auto;
      white-space: nowrap;
      scrollbar-width: none;
   }
   .ai-quick-chips::-webkit-scrollbar {
      display: none;
   }
   .ai-chip-btn {
      background: #F1F5F9;
      color: #475569;
      border: 1px solid #E2E8F0;
      border-radius: 20px;
      padding: 6px 14px;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 5px;
   }
   .ai-chip-btn:hover {
      background: #EEF2FF;
      color: #6366F1;
      border-color: #C7D2FE;
      transform: translateY(-1px);
   }

   /* Input Box */
   .ai-chat-footer {
      padding: 14px 20px 10px 20px;
      background: #fff;
      border-top: 1px solid #E2E8F0;
   }
   .ai-input-form {
      display: flex;
      align-items: center;
      background: #F8FAFC;
      border: 1.5px solid #E2E8F0;
      border-radius: 50px;
      padding: 4px 6px 4px 16px;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
   }
   .ai-input-form:focus-within {
      border-color: var(--ai-primary);
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
      background: #fff;
   }
   .ai-input-field {
      flex: 1;
      border: none;
      background: transparent;
      outline: none;
      font-size: 14px;
      color: #1E293B;
      padding: 8px 0;
   }
   .ai-input-field::placeholder {
      color: #94A3B8;
   }
   .ai-send-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--ai-primary), var(--ai-secondary));
      color: #fff;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s ease;
   }
   .ai-send-btn:hover {
      transform: scale(1.06);
      box-shadow: 0 4px 10px rgba(99, 102, 241, 0.4);
   }
   .ai-send-btn:disabled {
      background: #CBD5E1;
      cursor: not-allowed;
      box-shadow: none;
      transform: none;
   }

   .ai-footer-branding {
      text-align: center;
      font-size: 10px;
      color: #94A3B8;
      margin-top: 6px;
   }
   .ai-footer-branding span {
      color: #6366F1;
      font-weight: 700;
   }

   /* Typing Indicator */
   .ai-typing-indicator {
      display: flex;
      align-items: center;
      gap: 4px;
      padding: 10px 14px;
   }
   .ai-dot {
      width: 7px;
      height: 7px;
      background: #6366F1;
      border-radius: 50%;
      animation: ai-bounce 1.4s infinite ease-in-out both;
   }
   .ai-dot:nth-child(1) { animation-delay: -0.32s; }
   .ai-dot:nth-child(2) { animation-delay: -0.16s; }
   @keyframes ai-bounce {
      0%, 80%, 100% { transform: scale(0.6); opacity: 0.5; }
      40% { transform: scale(1.1); opacity: 1; }
   }

   /* Responsive for small screens */
   @media (max-width: 480px) {
      .ai-chat-window {
         width: calc(100vw - 24px);
         right: 12px;
         bottom: 80px;
         height: 75vh;
      }
      .ai-chat-floating-btn {
         right: 16px;
         bottom: 16px;
      }
   }
</style>

<!-- Floating Trigger Button -->
<button type="button" class="ai-chat-floating-btn" id="ai-chat-btn" aria-label="Mở Trợ lý Khóa học AI">
   <span class="ai-btn-icon">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
         <path d="M12 8V4H8"/>
         <rect width="16" height="12" x="4" y="8" rx="2"/>
         <path d="M2 14h2"/>
         <path d="M20 14h2"/>
         <path d="M15 13v2"/>
         <path d="M9 13v2"/>
      </svg>
   </span>
   <span class="ai-btn-text">AI Tư vấn</span>
   <span class="ai-pulse"></span>
</button>

<!-- Chat Window -->
<div class="ai-chat-window" id="ai-chat-window">
   <!-- Header -->
   <div class="ai-chat-header">
      <div class="ai-header-left">
         <div class="ai-avatar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
               <path d="M12 8V4H8"/>
               <rect width="16" height="12" x="4" y="8" rx="2"/>
               <path d="M15 13v2"/>
               <path d="M9 13v2"/>
            </svg>
            <span class="ai-status-dot"></span>
         </div>
         <div class="ai-header-info">
            <h4>{{ \App\Services\ChatbotConfigService::get('bot_name', 'Indochine AI Assistant') }}</h4>
            <span>{{ \App\Services\ChatbotConfigService::get('bot_subtitle', 'Trợ lý Khóa học & Lộ trình 24/7') }}</span>
         </div>
      </div>
      <button type="button" class="ai-close-btn" id="ai-chat-close-btn" aria-label="Đóng chat">
         <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
         </svg>
      </button>
   </div>

   <!-- Messages Area -->
   <div class="ai-chat-messages" id="ai-chat-messages">
      <!-- Bot welcome message -->
      <div class="ai-message bot">
         <div class="ai-msg-bubble">
            <p>{!! nl2br(e(\App\Services\ChatbotConfigService::get('welcome_message', '👋 Chào bạn! Mình là AI hỗ trợ của Indochine. Mình có thể giúp gì cho lộ trình học của bạn?'))) !!}</p>
         </div>
         <span class="ai-msg-time" id="ai-init-time">Vừa xong</span>
      </div>
   </div>

   <!-- Quick Chips -->
   <div class="ai-quick-chips" id="ai-quick-chips">
      @php
         $quickChips = \App\Services\ChatbotConfigService::get('quick_chips', [
            '🎯 Khóa học nổi bật',
            '💰 Học phí & Thanh toán',
            '🚀 Lộ trình người mới',
            '📞 Liên hệ Admin'
         ]);
      @endphp
      @foreach($quickChips as $chip)
      <button type="button" class="ai-chip-btn" data-query="{{ $chip }}">{{ $chip }}</button>
      @endforeach
   </div>

   <!-- Footer Input -->
   <div class="ai-chat-footer">
      <form class="ai-input-form" id="ai-chat-form" onsubmit="return false;">
         <input type="text" class="ai-input-field" id="ai-input-field" placeholder="Hỏi AI về khóa học, lộ trình..." autocomplete="off">
         <button type="submit" class="ai-send-btn" id="ai-send-btn" aria-label="Gửi tin nhắn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
               <line x1="22" y1="2" x2="11" y2="13"></line>
               <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg>
         </button>
      </form>
      <div class="ai-footer-branding">
         ⚡ Powered by <span>Indochine AI</span>
      </div>
   </div>
</div>

<script>
(function() {
   const chatBtn = document.getElementById('ai-chat-btn');
   const chatCloseBtn = document.getElementById('ai-chat-close-btn');
   const chatWindow = document.getElementById('ai-chat-window');
   const chatMessages = document.getElementById('ai-chat-messages');
   const chatForm = document.getElementById('ai-chat-form');
   const inputField = document.getElementById('ai-input-field');
   const sendBtn = document.getElementById('ai-send-btn');
   const quickChips = document.getElementById('ai-quick-chips');

   // Set initial time
   const initTimeEl = document.getElementById('ai-init-time');
   if (initTimeEl) {
      initTimeEl.textContent = new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
   }

   // Toggle window open/close
   function toggleChat(forceOpen = null) {
      const isOpen = forceOpen !== null ? forceOpen : !chatWindow.classList.contains('active');
      if (isOpen) {
         chatWindow.classList.add('active');
         inputField.focus();
         scrollToBottom();
      } else {
         chatWindow.classList.remove('active');
      }
   }

   chatBtn.addEventListener('click', () => toggleChat());
   chatCloseBtn.addEventListener('click', () => toggleChat(false));

   // Auto-scroll to latest message
   function scrollToBottom() {
      chatMessages.scrollTop = chatMessages.scrollHeight;
   }

   // Simple Markdown to HTML parser
   function parseMarkdown(text) {
      if (!text) return '';
      let html = text
         // bold
         .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
         // italic
         .replace(/\*(.*?)\*/g, '<em>$1</em>')
         // links [text](url)
         .replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" target="_blank" rel="noopener">$1</a>')
         // line break
         .replace(/\n\n+/g, '</p><p>')
         .replace(/\n/g, '<br>');

      return `<p>${html}</p>`;
   }

   // Append Message to UI
   function appendMessage(sender, text) {
      const msgDiv = document.createElement('div');
      msgDiv.className = `ai-message ${sender}`;

      const bubbleDiv = document.createElement('div');
      bubbleDiv.className = 'ai-msg-bubble';

      if (sender === 'bot') {
         bubbleDiv.innerHTML = parseMarkdown(text);
      } else {
         bubbleDiv.textContent = text;
      }

      const timeSpan = document.createElement('span');
      timeSpan.className = 'ai-msg-time';
      timeSpan.textContent = new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });

      msgDiv.appendChild(bubbleDiv);
      msgDiv.appendChild(timeSpan);
      chatMessages.appendChild(msgDiv);
      scrollToBottom();
   }

   // Show typing indicator
   function showTyping() {
      const typingDiv = document.createElement('div');
      typingDiv.className = 'ai-message bot';
      typingDiv.id = 'ai-typing';
      typingDiv.innerHTML = `
         <div class="ai-msg-bubble ai-typing-indicator">
            <span class="ai-dot"></span>
            <span class="ai-dot"></span>
            <span class="ai-dot"></span>
         </div>
      `;
      chatMessages.appendChild(typingDiv);
      scrollToBottom();
   }

   function removeTyping() {
      const typingDiv = document.getElementById('ai-typing');
      if (typingDiv) typingDiv.remove();
   }

   // Send message to server
   async function sendUserMessage(message) {
      const cleanMsg = message.trim();
      if (!cleanMsg) return;

      appendMessage('user', cleanMsg);
      inputField.value = '';
      sendBtn.disabled = true;

      showTyping();

      try {
         const response = await fetch('{{ route("api.chatbot.ask") }}', {
            method: 'POST',
            headers: {
               'Content-Type': 'application/json',
               'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}',
               'Accept': 'application/json'
            },
            body: JSON.stringify({ message: cleanMsg })
         });

         removeTyping();
         sendBtn.disabled = false;

         if (response.ok) {
            const data = await response.json();
            appendMessage('bot', data.reply || 'Xin lỗi, mình chưa hiểu ý bạn. Bạn hỏi lại nhé!');
         } else {
            let errorMsg = '⚠️ Có chút trục trặc kết nối, bạn hãy thử lại sau ít phút nhé!';
            try {
               const errData = await response.json();
               if (errData && (errData.reply || errData.message)) {
                  errorMsg = errData.reply || errData.message;
               }
            } catch(e) {}
            appendMessage('bot', errorMsg);
         }
      } catch (err) {
         removeTyping();
         sendBtn.disabled = false;
         appendMessage('bot', '⚠️ Không thể gửi tin nhắn. Hãy kiểm tra kết nối mạng của bạn nhé!');
      }
   }

   // Form submit
   chatForm.addEventListener('submit', function(e) {
      e.preventDefault();
      sendUserMessage(inputField.value);
   });

   // Enter key inside input
   inputField.addEventListener('keypress', function(e) {
      if (e.key === 'Enter' && !e.shiftKey) {
         e.preventDefault();
         sendUserMessage(inputField.value);
      }
   });

   // Quick chip click
   if (quickChips) {
      quickChips.addEventListener('click', function(e) {
         const btn = e.target.closest('.ai-chip-btn');
         if (btn) {
            const query = btn.getAttribute('data-query');
            if (query) {
               sendUserMessage(query);
            }
         }
      });
   }
})();
</script>
@endif
