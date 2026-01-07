<?php
/**
 * Template Name: Single Knowledge
 * Description: Trang chi tiết bài viết Kiến thức (Style Corporate/Law Firm)
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
    
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container mx-auto px-4 py-8">
            <div class="mb-6">
                <?php 
                if (function_exists('kailash_breadcrumbs')) {
                    kailash_breadcrumbs();
                } else {
                    ?>
                    <div class="text-sm text-gray-500 font-medium">
                        <a href="<?php echo home_url(); ?>" class="hover:text-[#125f4b] transition-colors">Home</a> 
                        <span class="mx-2">/</span> 
                        <a href="<?php echo get_post_type_archive_link('knowledge'); ?>" class="hover:text-[#125f4b] transition-colors"><?php pll_e('Kiến thức'); ?></a>
                        <span class="mx-2 hidden md:inline">/</span>
                        <span class="text-gray-900 hidden md:inline truncate max-w-[300px]"><?php the_title(); ?></span>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-4 uppercase tracking-wider font-bold">
                <span class="text-[#125f4b] flex items-center">
                    <i class="fa-regular fa-calendar mr-2"></i>
                    <?php echo get_the_date('d/m/Y'); ?>
                </span>
                
                <?php if ($post_tags) : ?>
                    <span class="text-gray-300">|</span>
                    <?php foreach ($post_tags as $tag) : ?>
                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="hover:text-[#125f4b] transition-colors">
                            #<?php echo $tag->name; ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight max-w-5xl">
                <?php the_title(); ?>
            </h1>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16">
            
            <main class="col-span-1 lg:col-span-8">
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="mb-8 rounded-lg overflow-hidden shadow-sm">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content prose prose-lg prose-slate max-w-none text-justify text-gray-800 leading-relaxed 
                    prose-headings:font-bold prose-headings:text-gray-900 
                    prose-a:text-[#125f4b] prose-a:no-underline hover:prose-a:underline
                    prose-img:rounded-lg">
                    <?php the_content(); ?>
                </div>

                <div class="mt-12 pt-6 border-t border-gray-200 flex flex-wrap justify-between items-center gap-4">
                    <div class="flex gap-4">
                        <button onclick="window.print()" class="flex items-center text-sm font-semibold text-gray-500 hover:text-[#125f4b] transition-colors border border-gray-300 px-4 py-2 rounded hover:border-[#125f4b]">
                            <i class="fa-solid fa-print mr-2"></i> <?php pll_e('In bài viết'); ?>
                        </button>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500 mr-2"><?php pll_e('Chia sẻ:'); ?></span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-[#1877F2] hover:text-white transition-colors">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-[#0077b5] hover:text-white transition-colors">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a href="mailto:?subject=<?php the_title(); ?>&body=<?php the_permalink(); ?>" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-gray-800 hover:text-white transition-colors">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </main>

            <aside class="col-span-1 lg:col-span-4">
                <div class="sticky top-24 space-y-10">
                    
                    <?php if ($authors): ?>
                    <div class="sidebar-widget">
                        <h3 class="text-lg font-bold text-gray-900 mb-5 pb-2 border-b-2 border-[#125f4b] inline-block">
                            <?php pll_e('Tác giả'); ?>
                        </h3>
                        
                        <div class="flex flex-col gap-6">
                            <?php foreach ($authors as $auth_id): 
                                $auth_name = get_the_title($auth_id);
                                $auth_link = get_permalink($auth_id);
                                $auth_pos  = get_field('position', $auth_id); 
                                $str_auth_pos = !empty($auth_pos) ? implode(', ', $auth_pos) : '';
                                
                                // Avatar logic
                                $auth_avatar = get_field('anh_dai_dien', $auth_id);
                                if (!$auth_avatar) $auth_avatar = "https://dummyimage.com/150x150/f3f4f6/9ca3af&text=" . substr($auth_name, 0, 1);
                            ?>
                                <div class="author-item flex items-start gap-4 group">
                                    <a href="<?php echo $auth_link; ?>" class="flex-shrink-0">
                                        <img src="<?php echo esc_url($auth_avatar); ?>" alt="<?php echo esc_attr($auth_name); ?>" class="w-16 h-16 rounded-full object-cover border border-gray-200 group-hover:border-[#125f4b] transition-colors shadow-sm">
                                    </a>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 text-lg leading-tight group-hover:text-[#125f4b] transition-colors">
                                            <a href="<?php echo $auth_link; ?>"><?php echo esc_html($auth_name); ?></a>
                                        </h4>
                                        <?php if ($str_auth_pos): ?>
                                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide mt-1 line-clamp-2"><?php echo $str_auth_pos; ?></p>
                                        <?php endif; ?>
                                        
                                        <a href="<?php echo $auth_link; ?>" class="text-xs text-[#125f4b] font-semibold mt-2 inline-flex items-center hover:underline">
                                            <?php pll_e('Xem hồ sơ'); ?> <i class="fa-solid fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($related_exps): ?>
                    <div class="sidebar-widget bg-gray-50 p-6 rounded-lg border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <?php pll_e('Lĩnh vực liên quan'); ?>
                        </h3>
                        
                        <ul class="space-y-2">
                            <?php foreach ($related_exps as $exp_id): ?>
                                <li>
                                    <a href="<?php echo get_permalink($exp_id); ?>" class="block py-2 px-3 bg-white border border-gray-200 rounded text-gray-700 hover:text-[#125f4b] hover:border-[#125f4b] hover:shadow-sm transition-all text-sm font-medium">
                                        <?php echo get_the_title($exp_id); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                </div>
            </aside>

        </div>

        <div class="mt-20 pt-10 border-t border-gray-200">
            <div class="flex justify-between items-end mb-8">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900">
                    <?php pll_e('Tin tức liên quan'); ?>
                </h3>
                <a href="<?php echo get_post_type_archive_link('knowledge'); ?>" class="hidden md:inline-block text-[#125f4b] font-bold hover:underline">
                    <?php pll_e('Xem tất cả'); ?> <i class="fa-solid fa-angle-right"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                // Logic: Ưu tiên tìm bài cùng Tags, trừ bài hiện tại
                $related_args = array(
                    'post_type'      => 'knowledge',
                    'posts_per_page' => 4,
                    'post__not_in'   => array($current_id), 
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                );

                if ($post_tags) {
                    $tag_ids = array();
                    foreach($post_tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
                    $related_args['tag__in'] = $tag_ids;
                }

                $related_query = new WP_Query($related_args);

                // Fallback nếu không có bài cùng tag
                if (!$related_query->have_posts()) {
                    $related_args['tag__in'] = null;
                    $related_query = new WP_Query($related_args);
                }

                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                ?>
                    <div class="group h-full flex flex-col">
                        <a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-lg mb-3 aspect-[16/10] bg-gray-100 relative">
                             <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                            <?php else : ?>
                                <img src="https://dummyimage.com/400x250/f3f4f6/9ca3af&text=Kailash" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <?php endif; ?>
                            
                            <span class="absolute bottom-0 left-0 bg-white/90 px-2 py-1 text-xs font-bold text-[#125f4b] backdrop-blur-sm">
                                <?php echo get_the_date('d/m/Y'); ?>
                            </span>
                        </a>
                        
                        <h4 class="font-bold text-gray-900 leading-snug group-hover:text-[#125f4b] transition-colors line-clamp-3 mb-2">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        
                        <div class="mt-auto pt-2 text-xs text-gray-400">
                           <?php 
                               $tags = get_the_tags();
                               if ($tags) {
                                   echo '#' . $tags[0]->name;
                               }
                           ?>
                        </div>
                    </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif; 
                ?>
            </div>
            
            <div class="mt-8 text-center md:hidden">
                <a href="<?php echo get_post_type_archive_link('knowledge'); ?>" class="inline-block border border-[#125f4b] text-[#125f4b] px-6 py-2 rounded font-bold hover:bg-[#125f4b] hover:text-white transition-colors">
                    <?php pll_e('Xem tất cả'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
