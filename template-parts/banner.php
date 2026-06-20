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

<div class="banner-header w-full overflow-hidden"> 
    <?php if ( $banner_query->have_posts() ) : ?>
        
        <?php while ( $banner_query->have_posts() ) : $banner_query->the_post(); 
            // --- LẤY DỮ LIỆU ---
            $bg_url   = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            $link     = get_post_meta( get_the_ID(), '_banner_link', true );
            $btn_text = get_post_meta( get_the_ID(), '_banner_btn_text', true );
        ?>
            
            <div class="b-item relative">
                
                <?php if ( $bg_url ) : ?>
                    <img src="<?php echo esc_url( $bg_url ); ?>" alt="<?php the_title_attribute(); ?>" class="b-img relative w-full h-[60vh] md:h-auto md:max-h-screen object-cover object-center">
                <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner/01.jpg" alt="" class="b-img relative w-full h-[60vh] md:h-auto md:max-h-screen object-cover object-center">
                <?php endif; ?>

                <div class="b-item-info absolute z-10 top-0 left-0 w-full h-full justify-center flex-col items-start flex pl-5 md:pl-[10%]">
                    
                    <h2 class="b-title mb-2 md:mb-3 ml-0 md:ml-5 text-3xl md:text-5xl lg:text-[4rem] text-white font-extrabold leading-tight shadow-sm drop-shadow-md">
                        <?php the_title(); ?>
                    </h2>
                    
                    <?php if ( $link ) : ?>
                        <a href="<?php echo esc_url( $link ); ?>" class="text-decoration-none group">
                            <button type="button" class="bg-[#ffffffa0] shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-light rounded-none px-4 py-2 md:px-5 md:py-2 text-center mr-2 mb-2 ml-0 md:ml-5 min-w-[100px] md:min-w-32 text-base md:text-xl text-black transition-all duration-300 group-hover:bg-white">
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
                        <button type="button" class="bg-[#ffffffa0] shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-light rounded-none px-4 py-2 md:px-5 md:py-2 text-center mr-2 mb-2 ml-0 md:ml-5 min-w-[100px] md:min-w-32 text-base md:text-xl text-black transition-all duration-300 hover:bg-white">
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
        
        <div class="b-item relative">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner/01.jpg" alt="" class="b-img relative w-full h-[60vh] md:h-auto md:max-h-screen object-cover object-center">
            <div class="b-item-info absolute z-10 top-0 left-0 w-full h-full justify-center flex-col items-start flex pl-5 md:pl-[10%]">
                <h2 class="b-title mb-2 md:mb-3 ml-0 md:ml-5 text-3xl md:text-5xl lg:text-[4rem] text-white font-extrabold leading-tight drop-shadow-md">Title 1</h2>
                <button type="button" class="bg-[#ffffffa0] shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-light rounded-none px-4 py-2 md:px-5 md:py-2 text-center mr-2 mb-2 ml-0 md:ml-5 min-w-[100px] md:min-w-32 text-base md:text-xl text-black">
                    <?php pll_e('btn_view_more'); ?>
                </button>
            </div>
        </div>
        <div class="b-item relative">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner/02.jpg" alt="" class="b-img relative w-full h-[60vh] md:h-auto md:max-h-screen object-cover object-center">
            <div class="b-item-info absolute z-10 top-0 left-0 w-full h-full justify-center flex-col items-start flex pl-5 md:pl-[10%]">
                <h2 class="b-title mb-2 md:mb-3 ml-0 md:ml-5 text-3xl md:text-5xl lg:text-[4rem] text-white font-extrabold leading-tight drop-shadow-md">Title 2</h2>
                <button type="button" class="bg-[#ffffffa0] shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-light rounded-none px-4 py-2 md:px-5 md:py-2 text-center mr-2 mb-2 ml-0 md:ml-5 min-w-[100px] md:min-w-32 text-base md:text-xl text-black">
                    <?php pll_e('btn_view_more'); ?>
                </button>
            </div>
        </div>

    <?php endif; ?>
    
</div>
