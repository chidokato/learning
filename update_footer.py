import io
import sys

sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

filepath = 'resources/views/frontend/partials/footer.blade.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

replacements = {
    'Sign Up today to get the <br> latest inspiration & insights': 'Đăng ký ngay hôm nay để nhận <br> những thông tin & cảm hứng mới nhất',
    'Enter your Email Address': 'Nhập địa chỉ Email của bạn',
    'Access expert-led courses designed to help you succeed in your career, all from the comfort of your home.': 'Khám phá các khóa học chất lượng từ <strong>Learning Indochine</strong>, được thiết kế bởi chuyên gia giúp bạn thăng tiến sự nghiệp ngay tại nhà.',
    '<span class="text-1">Contact Us</span>': '<span class="text-1">Liên Hệ Ngay</span>',
    '<span class="text-2">Contact Us</span>': '<span class="text-2">Liên Hệ Ngay</span>',
    '<h4 class="it-footer-widget-title">Useful Links</h4>': '<h4 class="it-footer-widget-title">Liên Kết Hữu Ích</h4>',
    '<li><a href="#">Marketplace</a></li>': '<li><a href="#">Khóa Học Phổ Biến</a></li>',
    '<li><a href="#">kindergarten</a></li>': '<li><a href="#">Lộ Trình Đào Tạo</a></li>',
    '<li><a href="#">University</a></li>': '<li><a href="#">Tư Vấn Học Tập</a></li>',
    '<li><a href="#">GYM Coaching</a></li>': '<li><a href="#">Thư Viện Tài Liệu</a></li>',
    '<li><a href="#">Cooking</a></li>': '<li><a href="#">Cộng Đồng Học Viên</a></li>',
    '<h4 class="it-footer-widget-title">Our Company</h4>': '<h4 class="it-footer-widget-title">Về Chúng Tôi</h4>',
    '<li><a href="#">Contact Us</a></li>': '<li><a href="#">Liên Hệ</a></li>',
    '<li><a href="#">Become Teacher</a></li>': '<li><a href="#">Trở Thành Giảng Viên</a></li>',
    '<li><a href="#">Blog</a></li>': '<li><a href="#">Tin Tức & Blog</a></li>',
    '<li><a href="#">Instructor</a></li>': '<li><a href="#">Đội Ngũ Giảng Viên</a></li>',
    '<li><a href="#">Events</a></li>': '<li><a href="#">Sự Kiện Nổi Bật</a></li>',
    '<h4 class="it-footer-widget-title">Get Contact</h4>': '<h4 class="it-footer-widget-title">Thông Tin Liên Hệ</h4>',
    '<li><span>Phone:</span>': '<li><span>Điện thoại:</span>',
    '<li><span>Location:</span>': '<li><span>Địa chỉ:</span>',
    'North America, USA': 'Hà Nội, Việt Nam',
    'Copyright © 2025 <a href="#">Ordianit</a> All Rights Reserved': 'Bản quyền © 2025 <a href="#">Learning Indochine</a>. Bảo lưu mọi quyền.'
}

for old_str, new_str in replacements.items():
    content = content.replace(old_str, new_str)

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)

print("Replaced successfully.")
