<?php
/**
 * Template Name: Contact
 * Description: Trang liên hệ với Form và Thông tin công ty động.
 *
 * @package kailash
 */

get_header(); 

// -----------------------------------------------------------
// 1. LOGIC LẤY DỮ LIỆU TỪ PAGE "THEME SETTINGS"
// -----------------------------------------------------------
$settings_page = get_page_by_path('theme-settings');
$option_id = $settings_page ? $settings_page->ID : false;
if (!$option_id) $option_id = get_option('page_on_front');

$lang = function_exists('pll_current_language') ? pll_current_language() : 'vi';

// Lấy dữ liệu
$company_name    = get_field('company_name_' . $lang, $option_id);
$company_address = get_field('company_address_' . $lang, $option_id);
$company_phone   = get_field('company_phone', $option_id);
$company_email   = get_field('company_email', $option_id);

// Fallback
if (!$company_name)    $company_name = get_field('company_name', $option_id);
if (!$company_address) $company_address = get_field('company_address', $option_id);

// Tạo link bản đồ tự động
$map_src = "https://maps.google.com/maps?q=Ho+Chi+Minh+City&t=m&z=14&output=embed&iwloc=near";
if ($company_address) {
    $clean_address = strip_tags($company_address);
    $clean_address = str_replace(array("\r", "\n"), ' ', $clean_address);
    $query_string = $company_name ? $company_name . " " . $clean_address : $clean_address;
    $map_src = "https://maps.google.com/maps?q=" . urlencode($query_string) . "&t=m&z=16&output=embed&iwloc=near";
}
?>

<div class="wrapper-contact bg-gray-50 min-h-screen py-16">
    <div class="container mx-auto px-4">
        
        <!-- HEADER -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-[#125f4b] mb-6 uppercase">
                <?php pll_e('Liên hệ'); ?>
            </h1>
            <div class="max-w-3xl mx-auto text-gray-600 leading-relaxed">
                <?php 
                // Hiển thị nội dung mô tả nhập trong trang Admin (nếu có)
                if ( have_posts() ) :
                    while ( have_posts() ) : the_post();
                        the_content();
                    endwhile;
                else: 
                    // Nội dung mặc định nếu chưa nhập gì
                    echo '<p>' . pll__('Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Hãy liên hệ với chúng tôi qua các kênh dưới đây hoặc điền vào biểu mẫu.') . '</p>';
                endif;
                ?>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 max-w-6xl mx-auto">
            
            <!-- CỘT TRÁI: THÔNG TIN LIÊN HỆ (Chiếm 5/12) -->
            <div class="col-span-1 lg:col-span-5 space-y-8">
                
                <!-- Box Thông tin -->
                <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100">
                        <?php pll_e('Thông tin kết nối'); ?>
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Tên công ty -->
                        <?php if($company_name): ?>
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-[#125f4b]/10 flex items-center justify-center text-[#125f4b] flex-shrink-0 mt-1">
                                <i class="fa-solid fa-building text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-1"><?php pll_e('Tên công ty'); ?></h4>
                                <p class="text-gray-600"><?php echo nl2br(esc_html($company_name)); ?></p>
                                <p>MST: <?php echo get_field('tax_id', $option_id); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- Địa chỉ -->
                        <?php if($company_address): ?>
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-[#125f4b]/10 flex items-center justify-center text-[#125f4b] flex-shrink-0 mt-1">
                                <i class="fa-solid fa-location-dot text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-1"><?php pll_e('Địa chỉ'); ?></h4>
                                <p class="text-gray-600"><?php echo nl2br(esc_html($company_address)); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Điện thoại -->
                        <?php if($company_phone): ?>
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-[#125f4b]/10 flex items-center justify-center text-[#125f4b] flex-shrink-0 mt-1">
                                <i class="fa-solid fa-phone text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-1"><?php pll_e('Điện thoại'); ?></h4>
                                <a href="tel:<?php echo esc_attr($company_phone); ?>" class="text-gray-600 hover:text-[#125f4b] transition-colors font-medium text-lg">
                                    <?php echo esc_html($company_phone); ?>
                                </a>
                                <p class="text-xs text-gray-400 mt-1"><?php pll_e('Hỗ trợ 24/7'); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Email -->
                        <?php if($company_email): ?>
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-[#125f4b]/10 flex items-center justify-center text-[#125f4b] flex-shrink-0 mt-1">
                                <i class="fa-solid fa-envelope text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-1"><?php pll_e('Email'); ?></h4>
                                <a href="mailto:<?php echo esc_attr($company_email); ?>" class="text-gray-600 hover:text-[#125f4b] transition-colors break-all">
                                    <?php echo esc_html($company_email); ?>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Bản đồ nhỏ -->
                <div class="bg-white p-2 rounded-lg shadow-sm border border-gray-100 h-[300px] overflow-hidden relative">
                    <iframe 
                        src="<?php echo esc_url($map_src); ?>" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        class="rounded filter grayscale hover:grayscale-0 transition-all duration-500">
                    </iframe>
                </div>

            </div>

            <!-- CỘT PHẢI: FORM LIÊN HỆ (Chiếm 7/12) -->
            <div class="col-span-1 lg:col-span-7">
                <div class="bg-white p-8 md:p-10 rounded-lg shadow-lg border-t-4 border-[#125f4b]">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">
                        <?php pll_e('Gửi tin nhắn cho chúng tôi'); ?>
                    </h3>
                    <p class="text-gray-500 mb-8 text-sm">
                        <?php pll_e('Vui lòng điền vào biểu mẫu dưới đây, chúng tôi sẽ phản hồi sớm nhất có thể.'); ?>
                    </p>

                    <!-- CONTACT FORM 7 -->
                    <div class="contact-form-wrapper">
                        <?php 
                        // THAY ID BÊN DƯỚI BẰNG ID FORM CỦA BẠN (Ví dụ: id="56")
                        echo do_shortcode('[contact-form-7 id="3723b89" title="Form Liên hệ"]');
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
get_footer(); // Tải file footer.php
?>
