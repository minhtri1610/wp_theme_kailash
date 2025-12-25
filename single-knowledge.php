<?php
/**
 * Template Name: Single Knowledge
 * Description: Trang chi tiết bài viết Kiến thức (Style giống Nishimura & Asahi)
 *
 * @package kailash
 */

get_header();

$current_id = get_the_ID();

// 1. LẤY DỮ LIỆU ACF
// ------------------------------------------------
$authors = get_field('knowledge_authors'); // Relationship: People
$related_exps = get_field('knowledge_related_experience'); // Relationship: Experience
$post_tags = get_the_tags();
?>

<div class="wrapper-single-knowledge bg-white min-h-screen pb-20">
    <div class="container mx-auto px-4">
        
        <!-- 1. BREADCRUMB -->
        <div class="py-6 border-b border-gray-100 mb-8">
            <?php 
            if (function_exists('kailash_breadcrumbs')) {
                kailash_breadcrumbs();
            } else {
                ?>
                <div class="text-sm text-gray-500">
                    <a href="<?php echo home_url(); ?>" class="hover:text-[#125f4b]">Home</a> / 
                    <a href="<?php echo get_post_type_archive_link('knowledge'); ?>" class="hover:text-[#125f4b]"><?php pll_e('Kiến thức'); ?></a> / 
                    <span class="text-gray-900"><?php the_title(); ?></span>
                </div>
                <?php
            }
            ?>
        </div>

        <!-- 2. ARTICLE HEADER (Tiêu đề & Meta) -->
        <div class="mb-12">
            <!-- Ngày đăng & Tags -->
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-4 uppercase tracking-wider font-medium">
                <span class="text-[#125f4b]"><?php echo get_the_date('F d, Y'); ?></span>
                
                <?php if ($post_tags) : ?>
                    <span class="text-gray-300">|</span>
                    <?php foreach ($post_tags as $tag) : ?>
                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="hover:text-[#125f4b] transition-colors">
                            #<?php echo $tag->name; ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Tiêu đề chính -->
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
                <?php the_title(); ?>
            </h1>
        </div>

        <!-- 3. MAIN LAYOUT (Grid 2 cột) -->
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- CỘT TRÁI: NỘI DUNG BÀI VIẾT (Chiếm 8/12) -->
            <main class="col-span-1 lg:col-span-8">
                
                <!-- Ảnh đại diện (Nếu có) -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="mb-8 rounded-lg overflow-hidden shadow-sm">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?>
                    </div>
                <?php endif; ?>

                <!-- Nội dung chính (Sử dụng typography plugin của Tailwind nếu có) -->
                <div class="entry-content prose prose-lg max-w-none text-gray-700 leading-relaxed text-justify">
                    <?php the_content(); ?>
                </div>

                <!-- Nút chia sẻ / In (Footer bài viết) -->
                <div class="mt-12 pt-6 border-t border-gray-200 flex justify-between items-center">
                    <div class="flex gap-2">
                        <button onclick="window.print()" class="flex items-center text-sm text-gray-500 hover:text-[#125f4b] transition-colors">
                            <i class="fa-solid fa-print mr-2"></i> <?php pll_e('In bài viết'); ?>
                        </button>
                    </div>
                    <!-- Social Share (Demo) -->
                    <div class="flex gap-3">
                        <a href="#" class="text-gray-400 hover:text-[#1877F2]"><i class="fa-brands fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-[#0077b5]"><i class="fa-brands fa-linkedin fa-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-black"><i class="fa-brands fa-x-twitter fa-lg"></i></a>
                    </div>
                </div>
            </main>

            <!-- CỘT PHẢI: SIDEBAR (Tác giả & Lĩnh vực) (Chiếm 4/12) -->
            <aside class="col-span-1 lg:col-span-4">
                <div class="sticky top-8 space-y-10">
                    
                    <!-- BOX 1: TÁC GIẢ (Authors) -->
                    <?php if ($authors): ?>
                    <div class="sidebar-widget">
                        <h3 class="text-lg font-bold text-gray-900 mb-5 border-b border-gray-200 pb-2">
                            <?php pll_e('Tác giả'); ?>
                        </h3>
                        
                        <div class="space-y-6">
                            <?php foreach ($authors as $auth_id): 
                                // Lấy thông tin tác giả
                                $auth_name = get_the_title($auth_id);
                                $auth_link = get_permalink($auth_id);
                                $auth_pos  = get_field('position', $auth_id); // Chức vụ
                                $str_auth_pos = !empty($auth_pos) ? implode(',', $auth_pos) : '';
                                
                                // Lấy ảnh
                                $auth_avatar = get_field('anh_dai_dien', $auth_id);
                                if (!$auth_avatar) $auth_avatar = get_the_post_thumbnail_url($auth_id, 'thumbnail');
                                if (!$auth_avatar) $auth_avatar = "https://dummyimage.com/150x150/ccc/fff&text=" . substr($auth_name, 0, 1);
                            ?>
                                <div class="author-item flex items-start group">
                                    <a href="<?php echo $auth_link; ?>" class="flex-shrink-0 mr-4">
                                        <img src="<?php echo esc_url($auth_avatar); ?>" alt="<?php echo esc_attr($auth_name); ?>" class="w-16 h-16 rounded-full object-cover border border-gray-200 group-hover:border-[#125f4b] transition-colors">
                                    </a>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg leading-tight group-hover:text-[#125f4b] transition-colors">
                                            <a href="<?php echo $auth_link; ?>"><?php echo esc_html($auth_name); ?></a>
                                        </h4>
                                        <?php if ($str_auth_pos): ?>
                                            <p class="text-xs text-gray-500 uppercase tracking-wide mt-1"><?php echo $str_auth_pos; ?></p>
                                        <?php endif; ?>
                                        
                                        <a href="<?php echo $auth_link; ?>" class="text-xs text-[#125f4b] font-medium mt-2 inline-block hover:underline">
                                            <?php pll_e('Xem hồ sơ'); ?> &rarr;
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- BOX 2: LĨNH VỰC LIÊN QUAN (Related Areas) -->
                    <?php if ($related_exps): ?>
                    <div class="sidebar-widget">
                        <h3 class="text-lg font-bold text-gray-900 mb-5 border-b border-gray-200 pb-2">
                            <?php pll_e('Lĩnh vực liên quan'); ?>
                        </h3>
                        
                        <ul class="space-y-3">
                            <?php foreach ($related_exps as $exp_id): ?>
                                <li>
                                    <a href="<?php echo get_permalink($exp_id); ?>" class="flex items-center justify-between text-gray-700 hover:text-[#125f4b] group transition-colors p-3 bg-gray-50 rounded hover:bg-gray-100">
                                        <span class="font-medium"><?php echo get_the_title($exp_id); ?></span>
                                        <i class="fa-solid fa-chevron-right text-xs text-gray-400 group-hover:text-[#125f4b]"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <!-- BOX 3: LIÊN HỆ / NEWSLETTER (Optional) -->
                    <div class="bg-[#125f4b] p-6 rounded text-center text-white">
                        <h4 class="font-bold text-lg mb-2"><?php pll_e('Đăng ký nhận bản tin'); ?></h4>
                        <p class="text-sm opacity-90 mb-4"><?php pll_e('Nhận những thông tin mới nhất từ chúng tôi.'); ?></p>
                        <a href="/lien-he" class="inline-block bg-white text-[#125f4b] px-6 py-2 rounded font-bold text-sm hover:bg-gray-100 transition-colors">
                            <?php pll_e('Đăng ký ngay'); ?>
                        </a>
                    </div>

                </div>
            </aside>

        </div>

        <!-- 4. TIN TỨC LIÊN QUAN (Related Posts) -->
        <div class="max-w-6xl mx-auto mt-20 pt-10 border-t border-gray-100">
            <h3 class="text-2xl font-bold text-gray-900 mb-8 border-l-4 border-[#125f4b] pl-4">
                <?php pll_e('Tin tức liên quan'); ?>
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                // Logic: Ưu tiên tìm bài cùng Tags
                $related_args = array(
                    'post_type'      => 'knowledge',
                    'posts_per_page' => 4,
                    'post__not_in'   => array($current_id), // Trừ bài hiện tại
                    'orderby'        => 'rand', // Random để nội dung phong phú
                );

                if ($post_tags) {
                    $tag_ids = array();
                    foreach($post_tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
                    $related_args['tag__in'] = $tag_ids;
                }

                $related_query = new WP_Query($related_args);

                // Fallback: Nếu không có bài cùng tag, lấy 4 bài mới nhất
                if (!$related_query->have_posts()) {
                    $related_args['tag__in'] = null;
                    $related_args['orderby'] = 'date';
                    $related_query = new WP_Query($related_args);
                }

                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                ?>
                    <div class="group">
                        <a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-lg mb-3 aspect-[16/10] bg-gray-100">
                             <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                            <?php else : ?>
                                <img src="https://dummyimage.com/400x250/f3f4f6/9ca3af&text=Kailash" class="w-full h-full object-cover">
                            <?php endif; ?>
                        </a>
                        <div class="text-xs text-gray-400 mb-2 uppercase tracking-wider flex items-center">
                            <i class="fa-regular fa-calendar mr-1"></i>
                            <?php echo get_the_date('d/m/Y'); ?>
                        </div>
                        <h4 class="font-bold text-gray-900 line-clamp-2 leading-snug group-hover:text-[#125f4b] transition-colors">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                    </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif; 
                ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
