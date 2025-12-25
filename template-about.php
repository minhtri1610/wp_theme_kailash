<?php
/**
 * Template Name: About Us
 * Description: Trang giới thiệu với cấu trúc Grid hiển thị các mục con (Giống Nishimura & Asahi)
 *
 * @package kailash
 */

get_header(); 

// Lấy ID trang hiện tại
$current_id = get_the_ID();


// 1. Tìm ID của trang cấu hình (Dựa vào slug 'theme-settings')
$settings_page = get_page_by_path('theme-settings');
$option_id = $settings_page ? $settings_page->ID : false;

// Fallback: Nếu bạn chưa tạo trang 'theme-settings', code sẽ thử lấy từ Trang chủ
if (!$option_id) $option_id = get_option('page_on_front');

// 2. Lấy mã ngôn ngữ (vi/en)
$lang = function_exists('pll_current_language') ? pll_current_language() : 'vi';

// 3. Lấy dữ liệu (Truyền $option_id vào tham số thứ 2)
// Lưu ý: Bạn cần tạo field có hậu tố _vi, _en trong ACF như hướng dẫn trước
$company_name    = get_field('company_name_' . $lang, $option_id);
$company_address = get_field('company_address_' . $lang, $option_id);

// Fallback nếu không có dịch
if (!$company_name)    $company_name = get_field('company_name', $option_id);
if (!$company_address) $company_address = get_field('company_address', $option_id);

// Dữ liệu dùng chung
$company_phone = get_field('company_phone', $option_id);
$company_email = get_field('company_email', $option_id);


// [MỚI] Tự động tạo link Map từ địa chỉ
$map_src = '';
if ($company_address) {
    // 1. Làm sạch địa chỉ (Bỏ thẻ HTML, bỏ xuống dòng thừa)
    $clean_address = strip_tags($company_address);
    $clean_address = str_replace(array("\r", "\n"), ' ', $clean_address);
    
    // 2. Mã hóa URL (Ví dụ: "Quận 1" thành "Qu%E1%BA%ADn+1")
    $encoded_address = urlencode($clean_address);
    
    // 3. Tạo link embed (z=16 là độ zoom)
    $map_src = "https://maps.google.com/maps?q={$encoded_address}&t=m&z=16&output=embed&iwloc=near";
} else {
    // Fallback: Nếu không có địa chỉ thì dùng tọa độ mặc định (TP.HCM)
    $map_src = "https://maps.google.com/maps?q=Ho+Chi+Minh+City&t=m&z=14&output=embed&iwloc=near";
}

?>

<div class="wrapper-about-us bg-white min-h-screen">
    <!-- 1. HERO BANNER & BREADCRUMB -->
    <div class="relative w-full h-[400px] bg-gray-900 overflow-hidden">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover opacity-60']); ?>
        <?php else : ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-us.jpg" class="w-full h-full object-cover opacity-60">
        <?php endif; ?>
        
        <!-- <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4 z-10">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 uppercase tracking-widest">
                <?php the_title(); ?>
            </h1>
        </div> -->
    </div>

    <div class="container mx-auto px-4 pt-4 pb-16 lg:pb-24">
        <!-- Breadcrumb đơn giản -->
        <?php
            if (function_exists('kailash_breadcrumbs')) {
                kailash_breadcrumbs();
            } else {
                ?>
                <div class="breadcrumb text-sm text-gray-500 mb-6">
                    <a href="<?php echo home_url(); ?>">Home</a> / 
                    <span class="text-gray-900"><?php the_title(); ?></span>
                </div>
                <?php
            }
        ?>
        <!-- 2. MAIN MESSAGE (Lời ngỏ / Giới thiệu chung) -->
        <div class=" mb-20">
            <div class="head-list-experience">
                <h2 class="text-4xl font-semibold text-black my-[3rem]"><?php pll_e('Giới thiệu') ?> </h2>
            </div>
            <div class="text-base md:text-xl text-gray-700 leading-relaxed font-light">
                <?php 
                // Hiển thị nội dung nhập trong Editor
                if ( have_posts() ) :
                    while ( have_posts() ) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </div>
            <div class="w-24 h-1 bg-[#125f4b] mx-auto mt-10"></div>
        </div>

    </div>

    <!-- 3. TRIẾT LÝ KINH DOANH (Giá trị cốt lõi) -->
    <!-- Logic: Lấy 3 trang con đầu tiên của trang About Us -->
    <div class="philosophy-section mb-24">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold text-[#125f4b] uppercase mb-4"><?php pll_e('Giá trị cốt lõi'); ?></h3>
            <p class="text-gray-500 max-w-2xl mx-auto"><?php pll_e('Những nguyên tắc định hình văn hóa và chất lượng dịch vụ của chúng tôi.'); ?></p>
        </div>
        
        <?php
        $child_args = array(
            'post_type'      => 'page',
            'posts_per_page' => 3, // Lấy 3 trang con
            'post_parent'    => $current_id,
            'orderby'        => 'menu_order',
            'order'          => 'ASC'
        );
        $philosophy_query = new WP_Query( $child_args );

        if ( $philosophy_query->have_posts() ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php while ( $philosophy_query->have_posts() ) : $philosophy_query->the_post(); ?>
                    <div class="philosophy-item group p-8 bg-gray-50 rounded-xl hover:bg-white hover:shadow-xl transition-all duration-300 border border-gray-100 text-center h-full">
                        <!-- Icon giả lập (hoặc dùng ACF icon nếu có) -->
                        <div class="w-16 h-16 mx-auto bg-white text-[#125f4b] border border-[#125f4b] group-hover:bg-[#125f4b] group-hover:text-white rounded-full flex items-center justify-center mb-6 text-2xl transition-colors duration-300 shadow-sm">
                            <i class="fa-regular fa-star"></i> 
                        </div>
                        
                        <h4 class="text-xl font-bold mb-4 text-gray-900 group-hover:text-[#125f4b] transition-colors">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        
                        <div class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                            <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else: ?>
            <div class="text-center p-8 border-2 border-dashed border-gray-300 rounded-lg text-gray-400">
                <p>Vui lòng tạo các trang con cho trang Giới thiệu (Parent = About Us) để hiển thị mục này.</p>
            </div>
        <?php endif; ?>
    </div>


    <!-- 4. DANH SÁCH CEO (Ban lãnh đạo) -->
    <!-- [UPDATED] Background xanh #125f4b, Card trắng nổi bật -->
    <div class="ceo-section py-24 mb-24 bg-[#125f4b]">
        <div class="container mx-auto px-4">
            
            <!-- Header Section: Chữ trắng -->
            <div class="text-center mb-16 relative">
                <h3 class="text-3xl md:text-4xl font-bold text-white uppercase tracking-wide">
                    <?php pll_e('Ban lãnh đạo'); ?>
                </h3>
                <span class="block w-16 h-1 bg-white/30 mx-auto mt-4 rounded-full"></span>
            </div>
            
            <?php
            $ceo_args = array(
                'post_type'      => 'people',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
                'meta_query'     => array(
                    'relation' => 'OR',
                    array( 'key' => 'position', 'value' => 'CEO', 'compare' => 'LIKE' ),
                    array( 'key' => 'position', 'value' => 'Founder', 'compare' => 'LIKE' ),
                    array( 'key' => 'position', 'value' => 'Giám đốc', 'compare' => 'LIKE' )
                )
            );
            $ceo_query = new WP_Query($ceo_args);

            if ($ceo_query->have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 justify-center">
                    <?php while ($ceo_query->have_posts()) : $ceo_query->the_post(); 
                        $pos = get_field('position');
                        $img = get_field('anh_dai_dien');
                        // Fallback ảnh
                        if(!$img) $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        if(!$img) $img = "https://dummyimage.com/400x500/ccc/fff&text=CEO";
                    ?>
                        <!-- Item Card: Nền trắng, Shadow, Bo góc -->
                        <div class="ceo-item group text-center bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            
                            <!-- Ảnh CEO -->
                            <div class="relative overflow-hidden rounded-xl mb-6 shadow-sm aspect-[3/4] mx-auto w-full">
                                <img src="<?php echo esc_url($img); ?>" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105">
                                
                                <!-- Overlay thông tin khi hover (Gradient xanh) -->
                                <div class="absolute inset-0 bg-gradient-to-t from-[#125f4b]/90 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                                    <p class="text-white text-sm italic mb-4 line-clamp-3 font-light">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                    </p>
                                    <a href="<?php the_permalink(); ?>" class="inline-block bg-white text-[#125f4b] text-xs font-bold uppercase py-2 px-6 rounded-full hover:bg-black hover:text-white transition-colors shadow-lg">
                                        <?php pll_e('Xem hồ sơ'); ?>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Tên & Chức vụ -->
                            <h4 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-[#125f4b] transition-colors">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <div class="inline-block px-3 py-1 bg-gray-100 text-[#125f4b] font-semibold text-xs uppercase tracking-widest rounded-md">
                                <?php echo is_array($pos) ? implode(', ', $pos) : esc_html($pos); ?>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else: ?>
                <div class="text-center p-8 border-2 border-dashed border-white/30 rounded-lg text-white/60">
                    <p>Chưa có thông tin ban lãnh đạo.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    

    <!-- 5. DANH SÁCH CỘNG SỰ (Button Link) -->
    <div class="partners-section mb-24 text-center">
        <h3 class="text-3xl font-bold text-center mb-8 text-black uppercase relative">
            <?php pll_e('Đội ngũ luật sư & chuyên gia'); ?>
            <span class="block w-12 h-1 bg-gray-200 mx-auto mt-4"></span>
        </h3>
        
        <p class="text-gray-600 max-w-2xl mx-auto mb-10 leading-relaxed">
            <?php pll_e('Với đội ngũ chuyên gia giàu kinh nghiệm trong nhiều lĩnh vực, chúng tôi cam kết mang lại giải pháp tối ưu nhất cho khách hàng.'); ?>
        </p>

        <a href="<?php echo get_post_type_archive_link('people'); ?>" class="inline-block border-2 border-[#125f4b] bg-white text-[#125f4b] px-10 py-3 rounded-full font-bold hover:bg-[#125f4b] hover:text-white transition-all uppercase text-sm tracking-widest shadow-sm hover:shadow-lg transform hover:-translate-y-1">
            <?php pll_e('Xem danh sách cộng sự'); ?> <i class="fa-solid fa-arrow-right ml-2"></i>
        </a>
    </div>
    
    

    <!-- 4. KEY FACTS SECTION (Phần thống kê giống các web luật) -->
    <div class="bg-[#f8f9fa] py-16 border-t border-gray-200">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-8 text-center divide-x divide-gray-200">
                
                <div class="p-4 group cursor-default transition-all duration-500 hover:-translate-y-2">
                    <div class="text-4xl md:text-5xl font-bold text-[#125f4b] mb-2 font-serif transition-transform duration-300 group-hover:scale-110 group-hover:text-[#0a4535]">2025</div>
                    <div class="text-sm text-gray-500 uppercase tracking-widest transition-colors duration-300 group-hover:text-[#125f4b]"><?php pll_e('Năm thành lập'); ?></div>
                </div>
                
                <div class="p-4 group cursor-default transition-all duration-500 hover:-translate-y-2">
                    <?php 
                        $people_query = new WP_Query( array(
                            'post_type' => 'people',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'fields' => 'ids', // Chỉ lấy ID cho nhẹ
                        ) );
                        $total_people = $people_query->found_posts;
                    ?>
                    <div class="text-4xl md:text-5xl font-bold text-[#125f4b] mb-2 font-serif transition-transform duration-300 group-hover:scale-110 group-hover:text-[#0a4535]"><?php echo $total_people; ?>+</div>
                    <div class="text-xs md:text-sm text-gray-500 uppercase tracking-widest font-bold transition-colors duration-300 group-hover:text-[#125f4b]"><?php pll_e('Nhân sự'); ?></div>
                </div>

                <div class="p-4 group cursor-default transition-all duration-500 hover:-translate-y-2">
                    <div class="text-4xl md:text-5xl font-bold text-[#125f4b] mb-2 font-serif transition-transform duration-300 group-hover:scale-110 group-hover:text-[#0a4535]">20+</div>
                    <div class="text-sm text-gray-500 uppercase tracking-widest transition-colors duration-300 group-hover:text-[#125f4b]"><?php pll_e('Địa điểm'); ?></div>
                </div>

            </div>
        </div>
    </div>

    <!-- 7. GOOGLE MAP & INFO -->
    <div class="map-section h-[500px] w-full relative">
        <!-- [CẬP NHẬT] Sử dụng link Map được tạo tự động từ địa chỉ -->
        <iframe 
            src="<?php echo esc_url($map_src); ?>" 
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"
            class="absolute inset-0 grayscale hover:grayscale-0 transition-all duration-1000 filter">
        </iframe>
        
        <!-- Map Overlay Info -->
        <div class="absolute bottom-10 left-4 md:left-10 md:top-1/2 md:-translate-y-1/2 md:bottom-auto bg-white p-8 rounded-lg shadow-2xl max-w-sm z-10 border-l-4 border-[#125f4b]">
            <!-- Tiêu đề / Tên công ty -->
            <h4 class="font-bold text-xl text-[#125f4b] mb-4 uppercase tracking-wide">
                <?php echo $company_name ? esc_html($company_name) : pll__('Trụ sở chính'); ?>
            </h4>
            
            <div class="space-y-3 text-gray-600">
                <!-- Địa chỉ -->
                <?php if($company_address): ?>
                <p class="flex items-start">
                    <i class="fa-solid fa-location-dot mt-1 mr-3 text-[#125f4b]"></i> 
                    <span><?php echo nl2br(esc_html($company_address)); ?></span>
                </p>
                <?php endif; ?>

                <!-- Điện thoại -->
                <?php if($company_phone): ?>
                <p class="flex items-center">
                    <i class="fa-solid fa-phone mr-3 text-[#125f4b]"></i> 
                    <a href="tel:<?php echo esc_attr($company_phone); ?>" class="hover:text-[#125f4b] transition-colors">
                        <?php echo esc_html($company_phone); ?>
                    </a>
                </p>
                <?php endif; ?>

                <!-- Email -->
                <?php if($company_email): ?>
                <p class="flex items-center">
                    <i class="fa-solid fa-envelope mr-3 text-[#125f4b]"></i> 
                    <a href="mailto:<?php echo esc_attr($company_email); ?>" class="hover:text-[#125f4b] transition-colors">
                        <?php echo esc_html($company_email); ?>
                    </a>
                </p>
                <?php endif; ?>
            </div>
            
            <a href="/lien-he" class="block mt-6 text-center bg-[#125f4b] text-white py-2 rounded hover:bg-black transition-colors font-medium text-sm">
                <?php pll_e('Liên hệ chúng tôi'); ?>
            </a>
        </div>
    </div>

</div>

<?php
get_footer(); // Tải file footer.php
?>
