<?php
/**
 * Template Name: Trang Chủ
 *
 * Đây là template cho trang chủ, nó sẽ tự động được
 * WordPress sử dụng khi file này tồn tại.
 *
 * @package kailash
 */

get_header(); // Tải file header.php

$people_search = 'archive-people.php';
$pages = get_posts(array(
    'post_type'      => 'page',
    'posts_per_page' => 1,
    'meta_key'       => '_wp_page_template',
    'meta_value'     => $people_search,
    'fields'         => 'ids',
    'lang'           => pll_current_language(), // QUAN TRỌNG: Chỉ tìm trang thuộc ngôn ngữ hiện tại
));
if ( !empty($pages) ) {
    $action_url = get_permalink( $pages[0] );
} else {
    // Fallback: Nếu không tìm thấy, về trang chủ hoặc hiện lỗi
    $action_url = home_url('/'); 
}
?>

<main id="primary" class="site-main">

<?php get_template_part('template-parts/banner'); ?>

    <!-- search -->
    <section id="search" class="container relative h-[180px]">
        <div class="wrapper-search grid grid-cols-3 bg-[#2b2b2b] gap-1 absolute -top-[60px] w-full shadow-lg z-10">
            
            <div class="col-span-1 p-4 border-r border-[#555555]"> 
                <div class="p-4 text-white">
                    <h2 class="text-3xl font-bold mb-4"><?php pll_e('s_tieu_de_tim_kiem'); ?></h2>
                    <div class="desc-find">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error nemo atque corporis.
                    </div>
                </div>
            </div>

            <form 
                action="<?php echo esc_url( $action_url ); ?>" 
                method="GET" 
                class="col-span-2 p-4 flex align-center justify-center items-center"
            >
                <div class="el-search flex align-center items-center w-[80%] relative">
                    
                    <input 
                        type="text" 
                        name="keyword" 
                        class="w-full px-4 py-4 bg-[#414141] text-white text-base outline-none focus:bg-[#505050] transition-colors" 
                        placeholder="<?php pll_e('s_placeholder_tim_kiem'); ?>"
                        required 
                    >
                    
                    <button type="submit" class="text-white absolute right-4 hover:text-yellow-500 transition-colors">
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            width="24" 
                            height="24" 
                            viewBox="0 0 24 24" 
                            fill="none" 
                            stroke="currentColor" 
                            stroke-width="2" 
                            stroke-linecap="round" 
                            stroke-linejoin="round"
                        >
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Danh sách dịch vụ -->
    <?php get_template_part( 'components/home/insight' ); ?>

    <!-- Danh sách bài viết -->
    <?php get_template_part( 'components/home/knowledge' ); ?>

    <?php get_template_part( 'components/home/people' ); ?>

    <?php get_template_part( 'components/home/experience' ); ?>

    <?php get_template_part( 'components/home/recent-work' ); ?>

    <?php get_template_part( 'components/home/about' ); ?>

</main>

<?php
get_footer(); // Tải file footer.php
?>
