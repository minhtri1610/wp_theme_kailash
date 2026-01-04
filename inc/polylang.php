<?php
/**
 * Tất cả các chức năng liên quan đến Polylang
 *
 * @package kailash
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Thoát nếu truy cập trực tiếp.
}

/**
 * Đăng ký chuỗi văn bản (strings) cho Polylang
 */
add_action('init', function() {
    // Chỉ chạy khi plugin Polylang được kích hoạt
    if ( ! function_exists('pll_register_string') ) {
        return;
    }
    
    // Đăng ký chuỗi và nhóm chúng vào 'kailash' (tên theme)
    $group = 'kailash';

    $group_home = 'home page';

    pll_register_string('Recent Projects', 'Dự án gần đây', $group);
    pll_register_string('Featured Services', 'Dịch vụ nổi bật', $group);
    pll_register_string('Our Partners', 'Đối tác tiêu biểu', $group);
    pll_register_string('Read More', 'Xem thêm', $group);
    pll_register_string('Contact Us', 'Liên hệ', $group);

    pll_register_string('Home', 'Trang chủ', $group_home);
    
    // Các chuỗi bạn vừa thêm cho front-page
    pll_register_string('Homepage Hero Title', 'Viện Kailash', $group);
    pll_register_string('Homepage Hero Subtitle', 'Tư vấn chuyên nghiệp - Giải pháp tin cậy', $group);

    pll_register_string('Projects', 'Dự án', $group);
    pll_register_string('No services found', 'Chưa có dịch vụ nào.', $group);

    //page dịch vụ
    pll_register_string('Experience', 'Kinh Nghiệm', $group);
    pll_register_string('View detail', 'Xem chi tiết', $group);

    //page cộng sự
    pll_register_string('Knowledge', 'Ấn Phẩm', $group);

    //page cộng sự
    pll_register_string('People', 'Cộng sự', $group);

    //insights
    pll_register_string('Insight', 'Góc nhìn', $group);

    // page dự án gần đây
    pll_register_string('Recent Work', 'Dự án gần đây', $group);

    // page about us
    pll_register_string('About us', 'Giới thiệu', $group);

    // page liên hệ
    pll_register_string('Contact', 'Liên hệ', $group);

    //search
    pll_register_string('Find People', 's_tieu_de_tim_kiem', $group_home);
    pll_register_string('Search Placeholder', 's_placeholder_tim_kiem', $group_home);
    pll_register_string('Search Description', 's_mo_ta_tim_kiem', $group_home);

    //footer
    pll_register_string('Tax Code', 'Mã số thuế', $group_home);
    pll_register_string('Hotline', 'Liên hệ', $group_home);
    pll_register_string('Address', 'Địa chỉ', $group_home);
    pll_register_string('Email', 'Email', $group_home);

    //banner
    pll_register_string('More Details', 'btn_view_more', $group_home);
    pll_register_string('Locations', 'Địa điểm', $group_home);
    pll_register_string('Professionals', 'Chuyên gia', $group_home);

    pll_register_string('experience_slug', 'Dịch vụ URL', $group_home);

    pll_register_string('Find not found', 'Không tìm thấy', $group);
    pll_register_string('View all people', 'Xem tất cả', $group_home);

    pll_register_string('Contact Us', 'Liên hệ chúng tôi', $group_home);

});
