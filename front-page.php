<?php
/**
 * Template Name: Trang Chủ
 *
 * Responsive Optimized by Coder WP
 * @package kailash
 */

get_header(); 

$people_search = 'archive-people.php';
$pages = get_posts(array(
    'post_type'      => 'page',
    'posts_per_page' => 1,
    'meta_key'       => '_wp_page_template',
    'meta_value'     => $people_search,
    'fields'         => 'ids',
    'lang'           => pll_current_language(),
));

// Logic fallback giữ nguyên
$action_url = !empty($pages) ? get_permalink( $pages[0] ) : home_url('/'); 
?>

<main id="primary" class="site-main">

    <?php get_template_part('template-parts/banner'); ?>

    <section id="search" class="container relative h-auto md:h-[180px] z-20">
        
        <div class="wrapper-search grid grid-cols-1 md:grid-cols-3 bg-[#2b2b2b] gap-0 md:gap-1 relative md:absolute mt-[-30px] md:mt-0 top-0 md:-top-[60px] w-full shadow-xl z-10 rounded-lg md:rounded-none overflow-hidden md:overflow-visible">
            
            <div class="col-span-1 p-6 border-b border-[#555555] md:border-b-0 md:border-r"> 
                <div class="p-2 md:p-4 text-white text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-bold mb-2 md:mb-4"><?php pll_e('s_tieu_de_tim_kiem'); ?></h2>
                    <div class="desc-find text-sm md:text-base text-gray-300">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error nemo atque corporis.
                    </div>
                </div>
            </div>

            <form 
                action="<?php echo esc_url( $action_url ); ?>" 
                method="GET" 
                class="col-span-1 md:col-span-2 p-6 flex align-center justify-center items-center"
            >
                <div class="el-search flex align-center items-center w-full md:w-[80%] relative">
                    
                    <input 
                        type="text" 
                        name="keyword" 
                        class="w-full px-4 py-3 md:py-4 bg-[#414141] text-white text-base outline-none focus:bg-[#505050] transition-colors rounded md:rounded-none border border-transparent focus:border-gray-500" 
                        placeholder="<?php pll_e('s_placeholder_tim_kiem'); ?>"
                        required 
                    >
                    
                    <button type="submit" class="text-white absolute right-4 p-2 hover:text-yellow-500 transition-colors">
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

    <div class="pt-10 md:pt-0">
        <?php get_template_part( 'components/home/insight' ); ?>
    </div>

    <?php get_template_part( 'components/home/knowledge' ); ?>

    <?php get_template_part( 'components/home/people' ); ?>

    <?php get_template_part( 'components/home/experience' ); ?>

    <?php get_template_part( 'components/home/recent-work' ); ?>

    <?php get_template_part( 'components/home/about' ); ?>

</main>

<?php
get_footer(); 
?>
