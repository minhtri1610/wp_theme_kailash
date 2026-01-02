<?php
/**
 * Template Name: Banner Home (Strict HTML Structure for Slick Slider)
 */

// 1. Khởi tạo Query lấy Banner từ CPT 'banner'
$args = array(
    'post_type'      => 'banner',
    'posts_per_page' => -1,           // Lấy tất cả
    'orderby'        => 'menu_order', // Sắp xếp theo thứ tự Order trong Page Attributes
    'order'          => 'ASC',
    'post_status'    => 'publish',
);

$banner_query = new WP_Query( $args );
?>

<div class="banner-header">

    <?php if ( $banner_query->have_posts() ) : ?>
        
        <?php while ( $banner_query->have_posts() ) : $banner_query->the_post(); 
            // --- LẤY DỮ LIỆU ---
            $bg_url   = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            $link     = get_post_meta( get_the_ID(), '_banner_link', true );
            $btn_text = get_post_meta( get_the_ID(), '_banner_btn_text', true );
        ?>
            
            <div class="b-item ">
                
                <?php if ( $bg_url ) : ?>
                    <img src="<?php echo esc_url( $bg_url ); ?>" alt="<?php the_title_attribute(); ?>" class="b-img relative max-h-100">
                <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner/01.jpg" alt="" class="b-img relative max-h-100">
                <?php endif; ?>

                <div class="b-item-info absolute z-2 top-0 left-0 w-full h-full justify-center flex-col items-start flex pl-[10%]">
                    
                    <h2 class="b-title mb-3 ml-5 text-[4rem] text-white font-extrabold"><?php the_title(); ?></h2>
                    
                    <?php if ( $link ) : ?>
                        <a href="<?php echo esc_url( $link ); ?>" class="text-decoration-none">
                            <button type="button" class="bg-[#ffffffa0] shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-light rounded-0 px-5 py-2 text-center me-2 mb-2 ml-5 min-w-32 text-xl text-black">
                                <?php 
                                    if( !empty($btn_text) ) {
                                        echo esc_html($btn_text); 
                                    } else {
                                        pll_e('btn_view_more'); 
                                    }
                                ?>
                            </button>
                        </a>
                    <?php else : ?>
                        <button type="button" class="bg-[#ffffffa0] shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-light rounded-0 px-5 py-2 text-center me-2 mb-2 ml-5 min-w-32 text-xl text-black">
                             <?php 
                                if( !empty($btn_text) ) {
                                    echo esc_html($btn_text); 
                                } else {
                                    pll_e('btn_view_more'); 
                                }
                            ?>
                        </button>
                    <?php endif; ?>

                </div>
            </div>

        <?php endwhile; wp_reset_postdata(); ?>

    <?php else : ?>
        
        <div class="b-item ">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner/01.jpg" alt="" class="b-img relative max-h-100">
            <div class="b-item-info absolute z-2 top-0 left-0 w-full h-full justify-center flex-col items-start flex pl-[10%]">
                <h2 class="b-title mb-3 ml-5 text-[4rem] text-white font-extrabold">Title 1</h2>
                <button type="button" class="bg-[#ffffffa0] shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-light rounded-0 px-5 py-2 text-center me-2 mb-2 ml-5 min-w-32 text-xl text-black"><?php pll_e('btn_view_more'); ?></button>
            </div>
        </div>
        <div class="b-item ">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner/02.jpg" alt="" class="b-img relative max-h-100">
            <div class="b-item-info absolute z-2 top-0 left-0 w-full h-full justify-center flex-col items-start flex  pl-[10%]">
                <h2 class="b-title mb-3 ml-5 text-[4rem] text-white font-extrabold">Title 2</h2>
                <button type="button" class="bg-[#ffffffa0] shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-light rounded-0 px-5 py-2 text-center me-2 mb-2 ml-5 min-w-32 text-xl text-black"><?php pll_e('btn_view_more'); ?></button>
            </div>
        </div>

    <?php endif; ?>
    
</div>
