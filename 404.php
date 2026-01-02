<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package kailash
 */

get_header();
?>

<div class="wrapper-404 bg-gray-50 min-h-[70vh] flex flex-col items-center justify-center py-20 px-4 text-center relative overflow-hidden">
    
    <!-- Background Decor (Optional) -->
    <!-- <div class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none">
		<img src="<?php echo get_template_directory_uri(); ?>/assets/images/404.png" alt="" class="w-full h-full object-cover">
    </div> -->

    <!-- 404 Heading Lớn -->
    <h1 class="text-5xl md:text-[200px] font-bold text-[#125f4b] leading-none select-none opacity-50 font-serif" style="text-shadow: 2px 2px 0px rgba(0,0,0,0.1);">
        404
    </h1>

    <div class="mt-10 relative z-10">
        <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-4 uppercase tracking-widest">
            <?php 
            if (function_exists('pll_e')) {
                pll_e('Không tìm thấy trang'); 
            } else {
                echo 'Page Not Found';
            }
            ?>
        </h2>
        
        <p class="text-gray-600 mb-8 max-w-lg mx-auto leading-relaxed">
            <?php 
            if (function_exists('pll_e')) {
                pll_e('Rất tiếc, trang bạn đang tìm kiếm không tồn tại, đã bị xóa hoặc tên miền đã thay đổi. Hãy thử tìm kiếm nội dung khác hoặc quay về trang chủ.');
            } else {
                echo 'Sorry, the page you are looking for does not exist. It might have been moved or deleted.';
            }
            ?>
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-sm font-bold uppercase tracking-wider rounded-md text-white bg-[#125f4b] hover:bg-[#0a382b] transition-all shadow-md transform hover:-translate-y-1">
                <?php pll_e('Về trang chủ'); ?>
            </a>
            
            <a href="javascript:history.back()" class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-sm font-bold uppercase tracking-wider rounded-md text-gray-700 bg-white hover:bg-gray-50 hover:text-[#125f4b] transition-all shadow-sm transform hover:-translate-y-1">
                <?php pll_e('Quay lại'); ?>
            </a>
        </div>
    </div>

</div>

<?php
get_footer();
