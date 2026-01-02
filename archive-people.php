<?php
/**
 * Template Name: Archive People
 *
 * Trang này hiển thị danh sách tất cả "Cộng sự".
 *
 * @package kailash
 */

get_header();
$current_page_id = get_queried_object_id(); 
// Lấy link sạch của trang đó
$page_url = get_permalink( $current_page_id );

// 1. CẤU HÌNH & LẤY THAM SỐ
// -----------------------------------------------------------
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );

// Lấy tham số từ URL
$keyword = isset($_GET['keyword']) ? sanitize_text_field($_GET['keyword']) : '';
$experience_filter = isset($_GET['experience_filter']) ? sanitize_text_field($_GET['experience_filter']) : '';

// Mảng chứa các ID bài viết tìm được
$final_post_ids = []; 
$has_search = false; // Cờ đánh dấu có thực hiện tìm kiếm hay không

// 2. XỬ LÝ TÌM KIẾM (Nếu có keyword)
// -----------------------------------------------------------
if ( !empty($keyword) ) {
    $has_search = true;

    // A. Tìm theo TÊN (Title) & Nội dung
    $args_title = array(
        'post_type' => 'people',
        's'         => $keyword,
        'fields'    => 'ids', // Chỉ lấy ID cho nhẹ
        'posts_per_page' => -1
    );
    $ids_by_title = get_posts($args_title);

    // B. Tìm theo META (Phone, Email)
    $args_meta = array(
        'post_type' => 'people',
        'fields'    => 'ids',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'OR', // Tìm thấy ở Phone HOẶC Email đều lấy
            array(
                'key'     => 'phone',
                'value'   => $keyword,
                'compare' => 'LIKE'
            ),
            array(
                'key'     => 'email',
                'value'   => $keyword,
                'compare' => 'LIKE'
            )
        )
    );
    $ids_by_meta = get_posts($args_meta);

    // C. Gộp ID và loại bỏ trùng lặp
    $final_post_ids = array_unique( array_merge( $ids_by_title, $ids_by_meta ) );
}

// 3. TẠO QUERY CHÍNH (MAIN QUERY)
// -----------------------------------------------------------

$meta_query = array(
    'relation' => 'OR',
    array(
        'key'     => 'sap_xep',
        'compare' => 'EXISTS'
    ),
    array(
        'key'     => 'sap_xep',
        'compare' => 'NOT EXISTS'
    ),
);

// Nếu có lọc theo lĩnh vực thì thêm vào (Logic code cũ của bạn)
if ( !empty($experience_filter) ) {
    $temp_meta_query = $meta_query;
    $meta_query = array(
        'relation' => 'AND',
        array(
            'key'     => 'assigned_experience_parent',
            'value'   => '"' . $experience_filter . '"',
            'compare' => 'LIKE'
        ),
        $temp_meta_query
    );
}

$args = array(
    'post_type'      => 'people',
    'posts_per_page' => 12, 
    'paged'          => $paged,
    'post_status'    => 'publish',
    'meta_query'     => $meta_query,
    
    // QUAN TRỌNG: Đặt tham số này để kích hoạt Hook
    'kailash_custom_sort' => true, 
    
    // Orderby mặc định để giữ chỗ, hook sẽ ghi đè sau
    'orderby'        => 'date', 
    'order'          => 'DESC'
);

// Áp dụng tìm kiếm keyword (Giữ nguyên code cũ của bạn)
if ( $has_search ) {
    $args['post__in'] = !empty($final_post_ids) ? $final_post_ids : array(0);
}

$the_query = new WP_Query( $args );

// 4. TÍNH TOÁN SỐ LIỆU (Result Count)
// -----------------------------------------------------------
$posts_per_page = $the_query->query_vars['posts_per_page'];
$total_posts    = $the_query->found_posts;
$start_result   = ($paged - 1) * $posts_per_page + 1;
$end_result     = min($paged * $posts_per_page, $total_posts);

if ($total_posts == 0) $start_result = 0;

?>

<div class="wapper-list-member">
    <div class="container c-list-member mb-12">
        <div class="head-list-member">
            <h2 class="text-4xl font-semibold text-black my-[3rem]"><?php pll_e('Cộng sự') ?> </h2>
        </div>
        <div class="content-list-member">
            <div class="desc-list-member mb-[3rem]">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus saepe quas suscipit commodi voluptates, omnis sit repudiandae sed nobis! Illo, accusamus! Quidem reiciendis totam quas repellendus molestias excepturi vel magnam!
            </div>
            <div class="wapper-search grid grid-cols-3 bg-[#2b2b2b] gap-1 -top-[60px]">
                <div class="col-span-1 p-4 border-r border-[#555555]"> 
                    <div class="p-4 text-white">
                        <h2 class="text-3xl font-bold mb-4"><?php pll_e('s_tieu_de_tim_kiem'); ?></h2>
                        <div class="desc-find">
                            <?php pll_e('s_mo_ta_tim_kiem'); ?>
                        </div>
                    </div>
                </div>
                <form role="search" method="get" action="<?php echo esc_url( $page_url ); ?>" class="col-span-2 p-4 flex align-center justify-center items-center flex-col">
                    <div class="el-search flex align-center items-center w-[80%] relative">
                        <input type="text" 
                            name="keyword" 
                            value="<?php echo esc_attr($keyword); ?>" class="w-full px-4 py-4 bg-[#414141] text-white text-base outline-none" placeholder="<?php pll_e('s_placeholder_tim_kiem'); ?>">
                        <button type="submit" class="text-white absolute right-4">
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
                    <div class="w-[80%] mt-2 text-right">
                        <a class="col-span-1 py-4 text-[#b6b6b6] underline" href="<?php echo esc_url( $page_url ); ?>">
                            Clear Search <i class="fa-solid fa-arrows-rotate"></i>
                        </a>
                    </div>
                    
                </form>
            </div>

            <div class="result-member">
                <?php if ( $the_query->have_posts() ) : ?>
                    <h4 class="my-[3rem]"><?php printf( pll__('Hiển thị %s ~ %s của %s kết quả'), $start_result, $end_result, $total_posts ); ?></h4>
                    <div class="list-member grid grid-cols-4 gap-6">
                        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
                            // Lấy dữ liệu ACF thật
                            $full_name = get_field('ho_ten');
                            $position = get_field('position') ?? [];
                            $phone = get_field('phone');
                            $email = get_field('email');
                            $link_fb = get_field('link_facebook');
                            $link_linkedin = get_field('link_linkedin');
                            $intro = get_field('mo_ta_ngan');
                            $address_working = get_field('dia_diem_lam_viec');
                            $address_working = $address_working ? $address_working : [];
                            // var_dump($address_working);exit;
                            $avatar = get_field('anh_dai_dien');
                            $avatar = $avatar ? $avatar :  "https://dummyimage.com/200x250/05654a/fff&text=KaiLash(270x270px)";
                        ?>
                            <div class="member-item my-3">
                                <a href="<?php the_permalink(); ?>" class="relative w-full aspect-[3/2] bg-gray-200">
                                    <img src="<?php echo $avatar; ?>" 
                                        alt="<?php echo $full_name; ?>"
                                        class="w-full h-[270px] object-cover transition-transform duration-500 group-hover:scale-105 border border-gray-300"
                                    >
                                    <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/images/members/member-1.jpg" alt="" class="w-full"> -->
                                    <div class="layer-gray absolute bottom-0 w-full h-full bg-[#000000] opacity-0 hover:opacity-50">
                                        <p class="text-white absolute p-4 top-1/2 max-w-[270px] max-h-[110px] line-clamp-4 text-justify">
                                            <?php echo $intro; ?>
                                        </p>
                                    </div>
                                </a>
                                <div class="member-info my-3">
                                    <a href="<?php the_permalink(); ?>"><h3 class="text-[#125f4b] font-semibold text-2xl"><?php echo $full_name; ?></h3></a>
                                    <p class="text-[#2c3338] my-3"><span><?php echo implode(', ', $position); ?></span> | <span><?php echo implode(', ', $address_working); ?></span></p>
                                    <hr class="my-2 text-[#125f4b]">
                                    <div class="m-contact flex flex-row justify-between items-center">
                                        
                                        <div class="m-phone ">
                                            <?php if ($phone != "") : ?>
                                                <i class="fa-solid fa-phone  p-3 rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white"></i>
                                                <span><a href="tel:+84901234567" class="underline underline-offset-1"><?php echo $phone; ?></a></span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="m-social">
                                            <a target="_blank" href="<?php echo $link_fb; ?>"><i class="fa-brands fa-facebook p-3 rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white"></i></a>
                                            <a target="_blank" href="<?php echo $link_linkedin; ?>"><i class="fa-brands fa-linkedin p-3 rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white"></i></a>
                                            <a target="_blank" href="mailto:<?php echo $email; ?>"><i class="fa-solid fa-envelope p-3 rounded-full bg-[#f1f1f1] hover:bg-[#125f4b] hover:text-white"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="pagination mt-16 flex justify-center">
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
                            echo '<ul class="flex gap-2">';
                            foreach ( $links as $link ) {
                                $link = str_replace('page-numbers', 'flex items-center justify-center p-3 w-[30px] h-[30px] rounded border border-gray-300 text-gray-600 hover:bg-[#125f4b] hover:text-white hover:border-[#125f4b] transition-colors', $link);
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
                    <div class="text-center py-20 my-[3rem]">
                        <p class="text-gray-500 text-lg"><?php pll_e('Không tìm thấy'); ?></p>
                        <a href="<?php echo get_permalink(); ?>" class="inline-block mt-4 text-[#125f4b] underline hover:text-black">
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
