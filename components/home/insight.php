<?php
/**
 * Component: Homepage Insight
 * Post Type: 'insight'
 */

// 1. Query lấy 3 Insight được set Order thấp nhất (hoặc mới nhất)
$args = array(
    'post_type'      => 'insight',
    'posts_per_page' => 3,            // Chỉ lấy đúng 3 cái
    'orderby'        => 'menu_order', // Sắp xếp theo thứ tự trong Admin
    'order'          => 'ASC',
    'post_status'    => 'publish',
);

$insight_query = new WP_Query( $args );
$posts = $insight_query->posts; // Lấy mảng các bài viết
?>

<section class="container mt-[1em]" id="insight">
    <h2 class="text-4xl font-bold text-black mb-6"><?php (function_exists('pll_e')) ? pll_e('Góc nhìn') : _e('Góc nhìn', 'kailash'); ?></h2>
    
    <?php if ( ! empty( $posts ) ) : ?>
        
        <div class="wapper-insight grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <?php if ( isset( $posts[0] ) ) : 
                $post_0 = $posts[0];
                $img_0  = get_the_post_thumbnail_url( $post_0->ID, 'large' ); // Ảnh lớn
                $link_0 = get_post_meta( $post_0->ID, '_insight_link', true );
                $title_0 = get_the_title( $post_0->ID );
            ?>
            <div class="left-insight col-span-1 md:col-span-2 h-full min-h-[300px]">
                <a class="insight-item relative h-full block group overflow-hidden" href="<?php echo esc_url( $link_0 ? $link_0 : '#' ); ?>">
                    <?php if($img_0): ?>
                        <img src="<?php echo esc_url( $img_0 ); ?>" alt="<?php echo esc_attr( $title_0 ); ?>" class="w-full h-full object-cover opacity-100 group-hover:opacity-60 transition-opacity duration-300 ease-out">
                    <?php else: ?>
                         <div class="w-full h-full bg-gray-300 flex items-center justify-center">No Image</div>
                    <?php endif; ?>
                    
                    <div class="ins-title absolute bottom-0 left-0 text-2xl bg-[#00000062] p-2 w-full translate-y-0 transition-transform duration-300">
                        <h3 class="text-white pl-2 font-semibold"><?php echo esc_html( $title_0 ); ?></h3>
                    </div>
                </a>
            </div>
            <?php endif; ?>


            <div class="right-insight grid grid-rows-2 gap-4 h-full">
                
                <?php 
                // Loop thủ công cho bài số 2 và số 3
                for ( $i = 1; $i <= 2; $i++ ) : 
                    if ( isset( $posts[$i] ) ) :
                        $post_item = $posts[$i];
                        $img_item  = get_the_post_thumbnail_url( $post_item->ID, 'medium_large' ); // Ảnh vừa
                        $link_item = get_post_meta( $post_item->ID, '_insight_link', true );
                        $title_item = get_the_title( $post_item->ID );
                ?>
                    <a class="insight-item relative block h-full min-h-[200px] group overflow-hidden" href="<?php echo esc_url( $link_item ? $link_item : '#' ); ?>">
                        <?php if($img_item): ?>
                            <img src="<?php echo esc_url( $img_item ); ?>" alt="<?php echo esc_attr( $title_item ); ?>" class="w-full h-full object-cover opacity-100 group-hover:opacity-60 transition-opacity duration-300 ease-out">
                        <?php else: ?>
                             <div class="w-full h-full bg-gray-300 flex items-center justify-center">No Image</div>
                        <?php endif; ?>

                        <div class="ins-title absolute bottom-0 left-0 text-2xl bg-[#00000062] p-2 w-full">
                            <h3 class="text-white pl-2 font-semibold"><?php echo esc_html( $title_item ); ?></h3>
                        </div>
                    </a>
                <?php 
                    endif; 
                endfor; 
                ?>

            </div>

        </div>

    <?php else : ?>
        
        <div class="wapper-insight grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="left-insight col-span-1 md:col-span-2 h-full">
                <a class="insight-item relative h-full block" href="#">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/insights/insight-1.jpg" alt="" class="w-full h-full object-cover">
                    <div class="ins-title absolute bottom-0 left-0 text-2xl bg-[#00000062] p-2 w-full">
                        <h3 class="text-white pl-2">Insight 1</h3>
                    </div>
                </a>
            </div>
            <div class="right-insight grid grid-rows-2 gap-4">
                 <div class="w-full h-full bg-gray-200 flex items-center justify-center">Please add "Insight" posts in Admin</div>
            </div>
        </div>

    <?php endif; wp_reset_postdata(); ?>

</section>
