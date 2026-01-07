<?php
/**
 * Template Name: Archive People
 *
 * Responsive Optimized by Coder WP
 * @package kailash
 */

get_header();
$current_page_id = get_queried_object_id(); 
$page_url = get_permalink( $current_page_id );

// 1. CẤU HÌNH & LẤY THAM SỐ (GIỮ NGUYÊN LOGIC)
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
$keyword = isset($_GET['keyword']) ? sanitize_text_field($_GET['keyword']) : '';
$experience_filter = isset($_GET['experience_filter']) ? sanitize_text_field($_GET['experience_filter']) : '';

$final_post_ids = []; 
$has_search = false; 

// 2. XỬ LÝ TÌM KIẾM (GIỮ NGUYÊN LOGIC)
if ( !empty($keyword) ) {
    $has_search = true;
    $args_title = array('post_type' => 'people', 's' => $keyword, 'fields' => 'ids', 'posts_per_page' => -1);
    $ids_by_title = get_posts($args_title);
    $args_meta = array(
        'post_type' => 'people', 'fields' => 'ids', 'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'OR',
            array('key' => 'phone', 'value' => $keyword, 'compare' => 'LIKE'),
            array('key' => 'email', 'value' => $keyword, 'compare' => 'LIKE')
        )
    );
    $ids_by_meta = get_posts($args_meta);
    $final_post_ids = array_unique( array_merge( $ids_by_title, $ids_by_meta ) );
}

// 3. TẠO QUERY CHÍNH (GIỮ NGUYÊN LOGIC)
$meta_query = array(
    'relation' => 'OR',
    array('key' => 'sap_xep', 'compare' => 'EXISTS'),
    array('key' => 'sap_xep', 'compare' => 'NOT EXISTS'),
);

if ( !empty($experience_filter) ) {
    $temp_meta_query = $meta_query;
    $meta_query = array(
        'relation' => 'AND',
        array('key' => 'assigned_experience_parent', 'value' => '"' . $experience_filter . '"', 'compare' => 'LIKE'),
        $temp_meta_query
    );
}

$args = array(
    'post_type'      => 'people',
    'posts_per_page' => 12, 
    'paged'          => $paged,
    'post_status'    => 'publish',
    'meta_query'     => $meta_query,
    'kailash_custom_sort' => true, 
    'orderby'        => 'date', 
    'order'          => 'DESC'
);

if ( $has_search ) {
    $args['post__in'] = !empty($final_post_ids) ? $final_post_ids : array(0);
}

$the_query = new WP_Query( $args );

// 4. TÍNH TOÁN SỐ LIỆU (Result Count)
$posts_per_page = $the_query->query_vars['posts_per_page'];
$total_posts    = $the_query->found_posts;
$start_result   = ($paged - 1) * $posts_per_page + 1;
$end_result     = min($paged * $posts_per_page, $total_posts);

if ($total_posts == 0) $start_result = 0;
?>

<div class="wapper-list-member">
    <div class="container mx-auto px-4 c-list-member mb-12">
        
        <div class="head-list-member">
            <h2 class="text-3xl md:text-4xl font-semibold text-black my-6 md:my-[3rem]"><?php pll_e('Cộng sự') ?> </h2>
        </div>

        <div class="content-list-member">
            <div class="desc-list-member mb-8 md:mb-[3rem] text-base text-justify md:text-left">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus saepe quas suscipit commodi voluptates, omnis sit repudiandae sed nobis! Illo, accusamus! Quidem reiciendis totam quas repellendus molestias excepturi vel magnam!
            </div>
            
            <div class="wapper-search grid grid-cols-1 md:grid-cols-3 bg-[#2b2b2b] gap-0 md:gap-1 relative top-0 md:-top-[10px] mb-8 md:mb-0 shadow-lg">
                
                <div class="col-span-1 p-4 border-b border-[#555555] md:border-b-0 md:border-r"> 
                    <div class="p-2 md:p-4 text-white text-center md:text-left">
                        <h2 class="text-2xl md:text-3xl font-bold mb-2 md:mb-4"><?php pll_e('s_tieu_de_tim_kiem'); ?></h2>
                        <div class="desc-find text-sm md:text-base text-gray-300">
                            <?php pll_e('s_mo_ta_tim_kiem'); ?>
                        </div>
                    </div>
                </div>

                <form role="search" method="get" action="<?php echo esc_url( $page_url ); ?>" class="col-span-1 md:col-span-2 p-6 flex align-center justify-center items-center flex-col">
                    <div class="el-search flex align-center items-center w-full md:w-[80%] relative">
                        <input type="text" 
                            name="keyword" 
                            value="<?php echo esc_attr($keyword); ?>" class="w-full px-4 py-3 md:py-4 bg-[#414141] text-white text-base outline-none focus:bg-[#505050] transition-colors rounded md:rounded-none" placeholder="<?php pll_e('s_placeholder_tim_kiem'); ?>">
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
                    <div class="w-full md:w-[80%] mt-2 text-center md:text-right">
                        <a class="col-span-1 py-2 md:py-4 text-[#b6b6b6] underline hover:text-white transition-colors text-sm" href="<?php echo esc_url( $page_url ); ?>">
                            Clear Search <i class="fa-solid fa-arrows-rotate"></i>
                        </a>
                    </div>
                </form>
            </div>

            <div class="result-member">
                <?php if ( $the_query->have_posts() ) : ?>
                    <h4 class="my-6 md:my-[3rem] text-lg font-medium text-gray-600"><?php printf( pll__('Hiển thị %s ~ %s của %s kết quả'), $start_result, $end_result, $total_posts ); ?></h4>
                    
                    <div class="list-member grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
                            $full_name = get_field('ho_ten');
                            $position = get_field('position') ?? [];
                            $phone = get_field('phone');
                            $email = get_field('email');
                            $link_fb = get_field('link_facebook');
                            $link_linkedin = get_field('link_linkedin');
                            $intro = get_field('mo_ta_ngan');
                            $address_working = get_field('dia_diem_lam_viec');
                            $address_working = $address_working ? $address_working : [];
                            $avatar = get_field('anh_dai_dien');
                            $avatar = $avatar ? $avatar :  "https://dummyimage.com/200x250/05654a/fff&text=K";
                        ?>
                            <div class="member-item my-0 md:my-3 group"> <a href="<?php the_permalink(); ?>" class="relative w-full block overflow-hidden">
                                    <img src="<?php echo esc_url($avatar); ?>" 
                                        alt="<?php echo esc_attr($full_name); ?>"
                                        class="w-full h-[350px] md:h-[270px] object-cover transition-transform duration-500 group-hover:scale-105 border border-gray-300"
                                    >
                                    <div class="layer-gray absolute top-0 left-0 w-full h-full bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <p class="text-white p-4 text-sm md:text-base line-clamp-5 text-justify">
                                            <?php echo esc_html($intro); ?>
                                        </p>
                                    </div>
                                </a>
                                <div class="member-info my-3">
                                    <a href="<?php the_permalink(); ?>"><h3 class="text-[#125f4b] font-semibold text-xl md:text-2xl hover:underline"><?php echo esc_html($full_name); ?></h3></a>
                                    
                                    <p class="text-[#2c3338] my-2 text-sm md:text-base line-clamp-2 min-h-[40px]">
                                        <span class="font-bold"><?php echo implode(', ', $position); ?></span> 
                                        <?php if(!empty($address_working)): ?>
                                            | <span><?php echo implode(', ', $address_working); ?></span>
                                        <?php endif; ?>
                                    </p>
                                    
                                    <hr class="my-2 border-[#125f4b]">
                                    
                                    <div class="m-contact flex flex-wrap justify-between items-center gap-2">
                                        
                                        <div class="m-phone flex items-center">
                                            <?php if ($phone != "") : ?>
                                                <div class="flex items-center gap-2">
                                                    <i class="fa-solid fa-phone w-8 h-8 flex items-center justify-center rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white transition-colors text-sm"></i>
                                                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>" class="text-sm md:text-base hover:text-[#125f4b] transition-colors whitespace-nowrap">
                                                        <?php echo esc_html($phone); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="m-social flex gap-2">
                                            <?php if($link_fb): ?>
                                                <a target="_blank" href="<?php echo esc_url($link_fb); ?>"><i class="fa-brands fa-facebook w-8 h-8 flex items-center justify-center rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white transition-colors text-sm"></i></a>
                                            <?php endif; ?>
                                            
                                            <?php if($link_linkedin): ?>
                                                <a target="_blank" href="<?php echo esc_url($link_linkedin); ?>"><i class="fa-brands fa-linkedin w-8 h-8 flex items-center justify-center rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white transition-colors text-sm"></i></a>
                                            <?php endif; ?>
                                            
                                            <?php if($email): ?>
                                                <a target="_blank" href="mailto:<?php echo esc_attr($email); ?>"><i class="fa-solid fa-envelope w-8 h-8 flex items-center justify-center rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white transition-colors text-sm"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="pagination mt-10 md:mt-16 flex justify-center">
                        <?php
                        $links = paginate_links(array(
                            'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                            'format'    => '?paged=%#%',
                            'current'   => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
                            'total'     => $the_query->max_num_pages,
                            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                            'mid_size'  => 2,
                            'type'      => 'array'
                        ));

                        if ( is_array( $links ) ) {
                            echo '<ul class="flex gap-2 flex-wrap justify-center">'; // flex-wrap để phân trang ko bị tràn
                            foreach ( $links as $link ) {
                                $link = str_replace('page-numbers', 'flex items-center justify-center w-[35px] h-[35px] md:w-[40px] md:h-[40px] rounded border border-gray-300 text-gray-600 hover:bg-[#125f4b] hover:text-white hover:border-[#125f4b] transition-colors text-sm md:text-base', $link);
                                $link = str_replace('current', '!bg-[#125f4b] !text-white !border-[#125f4b]', $link);
                                echo '<li>' . $link . '</li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                    </div>
                
                    <?php 
                        if (!is_post_type_archive('people')) {
                            wp_reset_postdata();
                        }
                    ?>
                <?php else : ?>
                    <div class="text-center py-10 md:py-20 my-6 md:my-[3rem] bg-gray-50 rounded-lg">
                        <i class="fa-regular fa-folder-open text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg"><?php pll_e('Không tìm thấy kết quả nào.'); ?></p>
                        <a href="<?php echo get_permalink(); ?>" class="inline-block mt-4 text-[#125f4b] font-bold underline hover:text-black">
                            <?php pll_e('Xem tất cả'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
    </div>
</div>

<?php
get_footer();
?>
