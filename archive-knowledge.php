<?php
/**
 * Template Name: Archive Knowledge
 * Description: Trang hiển thị danh sách Kiến thức / Tin tức (Hỗ trợ cả Page Template & Archive mặc định)
 *
 * @package kailash
 */

get_header(); 

// 1. CẤU HÌNH QUERY
// -----------------------------------------------------------
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );

// Kiểm tra: Nếu là trang Archive mặc định -> Dùng query gốc
// Nếu là Page Template -> Tạo query mới để lấy bài Knowledge
if ( is_post_type_archive('knowledge') && !is_page() ) {
    global $wp_query;
    $the_query = $wp_query;
} else {
    // Tạo Custom Query
    $args = array(
        'post_type'      => 'knowledge',
        'posts_per_page' => 9, // Số lượng bài hiển thị
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC', // Bài mới nhất lên đầu
        'post_status'    => 'publish',
    );
    $the_query = new WP_Query( $args );
}
?>

<div class="wrapper-archive-knowledge min-h-screen">
    <div class="container mx-auto px-4">
        <!-- HEADER -->
        <div class="text-left mb-12">
            <h2 class="text-4xl font-semibold text-black my-[3rem]"><?php pll_e('Ấn phẩm') ?> </h2>
        </div>
        <div class="max-w-2xl text-left text-gray-600 mb-12">
            <p><?php pll_e('Cập nhật những thông tin, kiến thức pháp lý và thị trường mới nhất.'); ?></p>
        </div>

        <!-- LIST: Danh sách bài viết -->
        <?php if ( $the_query->have_posts() ) : ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                while ( $the_query->have_posts() ) : $the_query->the_post(); 
                    // Lấy dữ liệu ACF & Tags
                    $related_exps = get_field('knowledge_related_experience');
                    $authors = get_field('knowledge_authors');
                    $post_tags = get_the_tags();
                ?>
                    <article class="knowledge-card flex flex-col bg-gray-50 rounded-lg shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group h-full border border-gray-100">
                        
                        <!-- ẢNH ĐẠI DIỆN -->
                        <a href="<?php the_permalink(); ?>" class="block relative overflow-hidden aspect-[16/9]">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                            <?php else : ?>
                                <img src="https://dummyimage.com/600x400/f3f4f6/9ca3af&text=Kailash" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <?php endif; ?>
                        </a>

                        <!-- NỘI DUNG -->
                        <div class="p-6 flex-1 flex flex-col">
                            
                            <!-- Ngày đăng -->
                            <div class="text-xs text-gray-400 mb-2 flex items-center font-medium uppercase tracking-wider">
                                <i class="fa-regular fa-calendar mr-2"></i>
                                <?php echo get_the_date('d/m/Y'); ?>
                            </div>

                            <!-- Tiêu đề -->
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-[#125f4b] transition-colors">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <!-- Mô tả ngắn -->
                            <div class="text-gray-600 text-sm line-clamp-3 mb-4 flex-1">
                                <?php the_excerpt(); ?>
                            </div>

                            <!-- Category (Experience) -->
                            <?php if( $related_exps ): ?>
                                <div class="flex flex-wrap gap-2 pointer-events-none mb-2">
                                    <?php foreach($related_exps as $exp_id): ?>
                                        <!-- Note: Category thì thường ko cần link, nhưng nếu muốn link thì thêm thẻ a -->
                                        <span class="bg-[#125f4b] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-md">
                                            <?php echo get_the_title($exp_id); ?>
                                        </span>
                                    <?php break; endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- HASHTAGS -->
                            <?php if ( $post_tags ) : ?>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <?php foreach( $post_tags as $tag ) : ?>
                                        <a href="<?php echo get_tag_link( $tag->term_id ); ?>" class="text-[10px] uppercase font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded hover:bg-[#125f4b] hover:text-white transition-colors">
                                            #<?php echo $tag->name; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <hr class="border-gray-100 mb-4">

                            <!-- TÁC GIẢ (CÓ LINK) -->
                            <?php if( $authors ): ?>
                                <div class="authors-section flex items-center mt-auto">
                                    <!-- Author Names -->
                                    <div class="text-xs text-gray-500 flex items-center">
                                        <i class="fa-solid fa-feather-pointed mr-2"></i>
                                        <span class="font-bold text-gray-700 line-clamp-1">
                                            <?php 
                                            $author_links = array();
                                            foreach($authors as $auth_id) {
                                                // Tạo link cho từng tên tác giả
                                                $author_links[] = '<a href="' . get_permalink($auth_id) . '" class="hover:text-[#125f4b] transition-colors">' . get_the_title($auth_id) . '</a>';
                                            }
                                            // Nối các link bằng dấu phẩy
                                            echo implode(', ', $author_links);
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </article>

                <?php endwhile; ?>
            </div>

            <!-- PHÂN TRANG -->
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
                        $link = str_replace('page-numbers', 'flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-gray-600 hover:bg-[#125f4b] hover:text-white hover:border-[#125f4b] transition-colors', $link);
                        $link = str_replace('current', '!bg-[#125f4b] !text-white !border-[#125f4b]', $link);
                        echo '<li>' . $link . '</li>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>
            
            <?php 
            if (!is_post_type_archive('knowledge')) {
                wp_reset_postdata();
            }
            ?>

        <?php else : ?>
            <div class="text-center py-20">
                <p class="text-gray-500 text-lg"><?php pll_e('Chưa có ấn phẩm nào.'); ?></p>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
