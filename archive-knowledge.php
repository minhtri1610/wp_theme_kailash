<?php
/**
 * Template Name: Archive Knowledge
 * Description: Trang hiển thị danh sách Kiến thức / Tin tức (Responsive Optimized)
 *
 * @package kailash
 */

get_header();

// 1. CẤU HÌNH QUERY (GIỮ NGUYÊN LOGIC)
// -----------------------------------------------------------
$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);

if (is_post_type_archive('knowledge') && !is_page()) {
    global $wp_query;
    $the_query = $wp_query;
} else {
    $args = array(
        'post_type' => 'knowledge',
        'posts_per_page' => 9,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'language',
                'field' => 'slug',
                'terms' => pll_current_language(),
            ),
        ),
    );
    $the_query = new WP_Query($args);
}
?>

<div class="wrapper-archive-knowledge min-h-screen py-8 md:py-12">
    <div class="container mx-auto px-4">

        <div class="text-left mb-8 md:mb-12">
            <h2 class="text-3xl md:text-4xl font-semibold text-black mb-4 md:mb-6"><?php pll_e('Ấn Phẩm') ?> </h2>

            <div class="max-w-3xl text-left text-gray-600 text-base md:text-lg">
                <?php
                $current_page_id = get_queried_object_id();
                $content = get_post_field('post_content', $current_page_id);
                echo apply_filters('the_content', $content);
                ?>
            </div>
        </div>

        <?php if ($the_query->have_posts()): ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <?php
                while ($the_query->have_posts()):
                    $the_query->the_post();
                    $related_exps = get_field('knowledge_related_experience');
                    $authors = get_field('knowledge_authors');
                    $post_tags = get_the_tags();
                    ?>
                    <article
                        class="knowledge-card h-full flex flex-col bg-white rounded-lg shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group border border-gray-200">

                        <a href="<?php the_permalink(); ?>" class="block relative overflow-hidden aspect-[16/9] flex-shrink-0">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110']); ?>
                            <?php else: ?>
                                <img src="https://dummyimage.com/600x400/f3f4f6/9ca3af&text=Kailash"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <?php endif; ?>

                            <div
                                class="absolute bottom-0 left-0 bg-[#125f4b] text-white text-xs font-bold px-3 py-1.5 rounded-tr-lg">
                                <?php echo get_the_date('d/m/Y'); ?>
                            </div>
                        </a>

                        <div class="p-5 md:p-6 flex-1 flex flex-col">

                            <?php if ($related_exps): ?>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <?php foreach ($related_exps as $exp_id): ?>
                                        <span
                                            class="bg-gray-100 text-[#125f4b] text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide">
                                            <?php echo get_the_title($exp_id); ?>
                                        </span>
                                        <?php break; endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <h3
                                class="text-lg md:text-xl font-bold text-gray-900 mb-3 line-clamp-2 leading-snug group-hover:text-[#125f4b] transition-colors">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <div class="text-gray-600 text-sm line-clamp-3 mb-4 flex-1">
                                <?php the_excerpt(); ?>
                            </div>

                            <?php if ($post_tags): ?>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <?php foreach ($post_tags as $tag): ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>"
                                            class="text-[10px] text-gray-500 hover:text-[#125f4b] transition-colors italic">
                                            #<?php echo $tag->name; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <?php if ($authors): ?>
                                    <div class="text-xs text-gray-500 flex items-center">
                                        <i class="fa-solid fa-feather-pointed mr-2 text-[#125f4b]"></i>
                                        <span class="font-semibold text-gray-700 line-clamp-1">
                                            <?php
                                            $author_links = array();
                                            foreach ($authors as $auth_id) {
                                                $author_links[] = '<a href="' . get_permalink($auth_id) . '" class="hover:text-[#125f4b] hover:underline transition-colors">' . get_the_title($auth_id) . '</a>';
                                            }
                                            echo implode(', ', $author_links);
                                            ?>
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <div class="text-xs text-gray-400 italic">By Kailash Team</div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </article>

                <?php endwhile; ?>
            </div>

            <div class="pagination mt-12 md:mt-16 flex justify-center">
                <?php
                $links = paginate_links(array(
                    'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged'), get_query_var('page')),
                    'total' => $the_query->max_num_pages,
                    'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                    'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                    'mid_size' => 1, // Giảm mid_size trên mobile để không bị tràn
                    'type' => 'array'
                ));

                if (is_array($links)) {
                    // Thêm flex-wrap để xuống dòng trên màn hình siêu nhỏ
                    echo '<ul class="flex gap-2 flex-wrap justify-center">';
                    foreach ($links as $link) {
                        // Tăng kích thước vùng bấm touch target (w-10 h-10)
                        $link = str_replace('page-numbers', 'flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 text-gray-600 hover:bg-[#125f4b] hover:text-white hover:border-[#125f4b] transition-all duration-300 font-medium text-sm', $link);
                        $link = str_replace('current', '!bg-[#125f4b] !text-white !border-[#125f4b] shadow-md', $link);
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

        <?php else: ?>
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="bg-gray-100 p-6 rounded-full mb-4">
                    <i class="fa-regular fa-newspaper text-4xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 text-lg"><?php pll_e('Chưa có ấn phẩm nào.'); ?></p>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>