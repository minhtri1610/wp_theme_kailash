<?php
/**
 * Template Name: Single people
 * Responsive Optimized by Coder WP
 * @package kailash
 */

get_header();

// --- GIỮ NGUYÊN LOGIC PHP ---
$current_id = get_the_ID();
$full_name = get_field('ho_ten');
$position = get_field('position') ?: []; // Fallback array rỗng tránh lỗi implode
$linh_vuc_phu_trach = get_field('linh_vuc_phu_trach');
$anh_bia = get_field('anh_bia');
$phone    = get_field('phone');
$email    = get_field('email');
$linkedin = get_field('link_linkedin');
$facebook = get_field('link_facebook');
$dia_diem_lam_viec = get_field('dia_diem_lam_viec') ?: [];
$mo_ta_ngan = get_field('mo_ta_ngan');
$hoc_van = get_field('hoc_van');
$cong_viec_hien_tai = get_field('cong_viec_hien_tai');
$company_worked = get_field('company_worked');
$kinh_nghiem = get_field('kinh_nghiem');
$cong_trinh_nckh = get_field('cong_trinh_nckh');
?>

<div class="wrapper-single-experience bg-gray-50 md:bg-white">
    
    <div class="container mx-auto px-4 py-4">
        <?php 
        if (function_exists('kailash_breadcrumbs')) {
            kailash_breadcrumbs();
        } else {
            ?>
            <div class="breadcrumb text-sm text-gray-500">
                <a href="<?php echo home_url(); ?>" class="hover:text-[#125f4b]">Home</a> / 
                <span class="text-gray-900 font-medium"><?php the_title(); ?></span>
            </div>
            <?php
        }
        ?>
    </div>

    <div class="head-banner mb-0 md:mb-3 relative flex flex-col md:block">
        
        <?php if ($anh_bia != '') : ?>
            <div class="w-full h-[350px] md:max-h-[48vw] md:h-[48vw]">
                <div class="block overflow-hidden h-full w-full">
                    <img class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-500" src="<?php echo esc_url($anh_bia); ?>" alt="<?php echo esc_attr($full_name); ?>" />
                </div>
            </div>
        <?php else : ?>
            <img class="w-full h-[350px] md:h-[48vw] object-cover hover:scale-105 transition-transform duration-500" src="https://dummyimage.com/1920x800/737373/fff&text=Banner" />
        <?php endif; ?>

        <div class="info-block relative md:absolute inset-0 m-auto container mx-auto px-4 flex items-center bg-white md:bg-transparent -mt-6 md:mt-0 rounded-t-3xl md:rounded-none z-10">
            <div class="wapper-info inline-block w-full md:w-auto md:min-w-[30vw] md:max-w-[60vw] py-6 md:py-0">
                
                <div class="name-tag">
                    <h1 class="text-3xl md:text-5xl font-bold mb-3 text-gray-900"><?php echo esc_html($full_name); ?></h1>
                    <p class="mb-3 text-base md:text-xl text-gray-600">
                        <span>
                            <?php echo implode(', ', $position); ?> 
                            <?php if(!empty($dia_diem_lam_viec)) echo ' | ' . implode(', ', $dia_diem_lam_viec); ?>
                        </span>
                    </p>
                </div>
                
                <hr class="border-[#737373] mt-3 opacity-50">
                
                <div class="m-social mt-4 flex flex-wrap gap-2">
                    <?php if ($phone) : ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="group">
                            <i class="fa-solid fa-phone w-10 h-10 flex items-center justify-center rounded-full bg-[#f1f1f1] text-gray-600 group-hover:bg-[#125f4b] group-hover:text-white transition-colors"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($facebook) : ?>
                        <a target="_blank" href="<?php echo esc_url($facebook); ?>" class="group">
                            <i class="fa-brands fa-facebook w-10 h-10 flex items-center justify-center rounded-full bg-[#f1f1f1] text-gray-600 group-hover:bg-[#125f4b] group-hover:text-white transition-colors"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($linkedin) : ?>
                        <a target="_blank" href="<?php echo esc_url($linkedin); ?>" class="group">
                            <i class="fa-brands fa-linkedin w-10 h-10 flex items-center justify-center rounded-full bg-[#f1f1f1] text-gray-600 group-hover:bg-[#125f4b] group-hover:text-white transition-colors"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($email) : ?>
                        <a target="_blank" href="mailto:<?php echo esc_attr($email); ?>" class="group">
                            <i class="fa-solid fa-envelope w-10 h-10 flex items-center justify-center rounded-full bg-[#f1f1f1] text-gray-600 group-hover:bg-[#125f4b] group-hover:text-white transition-colors"></i>
                        </a>
                    <?php endif; ?>
                </div>

                <a href="#contact-section" class="inline-flex items-center justify-center px-6 py-2 rounded-full bg-[#3e3e3e] text-white mt-6 md:mt-[3rem] hover:bg-[#125f4b] transition-colors">
                    <i class="fa-solid fa-envelope mr-2"></i> Contact <i class="fa-solid fa-angle-right ml-2"></i>
                </a>

                <div class="icon-action my-4 flex gap-3">
                    <button onclick="window.print()" class="w-12 h-10 rounded border border-gray-200 bg-white text-[#3e3e3e] hover:bg-gray-50 flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-print"></i>
                    </button>
                    <button class="w-12 h-10 rounded border border-gray-200 bg-white text-[#3e3e3e] hover:bg-gray-50 flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-share"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-4 relative mb-10 md:mb-[5rem]">
        
        <div class="content-desc relative md:absolute w-full bg-white p-6 md:p-10 h-auto md:min-h-[20vh] z-[3] top-0 md:-top-[10vh] shadow-sm md:shadow-[1px_3px_3px_1px_#dcdcdc] rounded-b-lg md:rounded-none mb-8 md:mb-0 border-t md:border-t-0 border-gray-100">
            <div class="prose max-w-none text-justify text-gray-700">
                <?php 
                    if($mo_ta_ngan != '') {
                        echo nl2br(esc_html($mo_ta_ngan)); 
                    } else {
                        echo '<span class="italic text-gray-400">Đang cập nhật thông tin...</span>';
                    }
                ?>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-0 md:pt-[15%]">
            
            <div class="col-span-1 lg:col-span-2">
                
                <?php 
                // Hàm helper để render từng khối thông tin cho gọn code
                function render_profile_section($title, $icon, $content) {
                    if (empty($content)) return;
                    ?>
                    <div class="desc-info mb-8">
                        <h3 class="text-lg md:text-xl text-[#aa7d59] border-b border-b-[#dcdcdc] mb-4 pb-2 font-semibold flex items-center gap-2">
                            <i class="<?php echo $icon; ?> text-[#aa7d59]"></i> <?php echo $title; ?>
                        </h3>
                        <div class="text-gray-700 leading-relaxed pl-2 md:pl-6 text-justify">
                            <?php echo nl2br($content); ?>
                        </div>
                    </div>
                    <?php
                }

                render_profile_section('Tổ chức chuyên môn nghề nghiệp đang tham gia', 'fa-solid fa-briefcase', $cong_viec_hien_tai);
                render_profile_section('Học vấn', 'fa-solid fa-graduation-cap', $hoc_van);
                render_profile_section('Tổ chức đã từng làm việc – Chức vụ từng đảm nhiệm', 'fa-solid fa-building-circle-check', $company_worked);
                render_profile_section('Dự án đã từng tham gia', 'fa-solid fa-clipboard-check', $kinh_nghiem);
                render_profile_section('Bài viết/công trình nghiên cứu khoa học', 'fa-regular fa-newspaper', $cong_trinh_nckh);
                ?>

            </div>

            <div class="left-content col-span-1 border-t md:border-t-0 lg:border-l border-gray-300 pt-8 md:pt-0 pl-0 lg:pl-6" id="contact-section">
                
                <?php if($linh_vuc_phu_trach): ?>
                <div class="desc-info mb-6">
                    <h3 class="text-lg md:text-xl text-[#aa7d59] border-b border-b-[#dcdcdc] mb-4 pb-2 font-semibold">
                        <i class="fa-solid fa-book-bookmark text-[#aa7d59] mr-2"></i> Kinh nghiệm
                    </h3>
                    <div class="flex flex-col gap-2">
                        <?php foreach( $linh_vuc_phu_trach as $exp ): ?>
                            <a href="<?php echo get_permalink( $exp ); ?>" class="group flex items-start text-gray-700 hover:text-[#00a174] transition-colors">
                                <span class="mr-2 text-[#aa7d59] group-hover:text-[#00a174]">•</span>
                                <span class="text-base font-medium"><?php echo get_the_title( $exp ); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="box-contact mt-8 bg-[#f9f9f9] p-6 rounded-lg text-center md:text-left">
                    <h4 class="font-bold text-gray-800 mb-2">Liên hệ công việc</h4>
                    <p class="text-sm text-gray-500 mb-4">Kết nối trực tiếp với chuyên gia</p>
                    <a href="<?php echo esc_url('/lien-he'); ?>" class="inline-flex items-center justify-center w-full p-3 rounded bg-[#016549] text-white hover:bg-[#014d38] transition-colors">
                        <i class="fa-solid fa-envelope mr-2"></i> Gửi Email <i class="fa-solid fa-angle-right ml-2"></i>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
