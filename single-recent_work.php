<?php
/**
 * Template Name: Single Recent Work (Project Detail)
 * Description: Trang chi tiết dự án với layout Case Study chuyên nghiệp
 *
 * @package kailash
 */

get_header();

// 1. LẤY DỮ LIỆU CẦN THIẾT
$current_id = get_the_ID();
$start_date = get_field('project_start_date');
$end_date   = get_field('project_end_date');
$people     = get_field('related_people');      // Relationship Object
$experiences = get_field('related_experience'); // Relationship Object

// Xử lý chuỗi ngày tháng
$date_display = $start_date ? $start_date : '';
if($end_date) $date_display .= ' - ' . $end_date;
?>

<div class="wrapper-single-project bg-white pb-20">
    
    <div class="relative h-[300px] md:h-[400px] mb-12 group overflow-hidden">
        <?php if (has_post_thumbnail()) : ?>
            <div class="absolute inset-0">
                <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105']); ?>
                <div class="absolute inset-0 bg-black/50"></div> </div>
        <?php else : ?>
            <div class="absolute inset-0 bg-gradient-to-r from-[#0e4b3a] to-[#125f4b]"></div>
        <?php endif; ?>

        <div class="container mx-auto px-4 h-full flex flex-col justify-end pb-12 relative z-10">
            <div class="mb-4 text-sm text-gray-300">
                <?php 
                if (function_exists('kailash_breadcrumbs')) {
                    // Cần custom CSS cho breadcrumb màu trắng, hoặc dùng HTML thủ công
                ?>
                    <a href="<?php echo home_url(); ?>" class="hover:text-white">Home</a> / 
                    <a href="<?php echo get_post_type_archive_link('recent_work'); ?>" class="hover:text-white"><?php pll_e('Dự án'); ?></a> / 
                    <span class="text-white font-medium"><?php the_title(); ?></span>
                <?php } ?>
            </div>

            <h1 class="text-3xl md:text-5xl font-bold text-white leading-tight max-w-4xl">
                <?php the_title(); ?>
            </h1>
        </div>
    </div>

    <div class="container mx-auto px-4">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <main class="col-span-1 lg:col-span-8">
                
                <div class="entry-content prose prose-lg max-w-none text-gray-700 leading-relaxed text-justify
                    prose-headings:text-[#125f4b] prose-headings:font-bold
                    prose-a:text-[#125f4b] prose-a:no-underline hover:prose-a:underline
                    prose-img:rounded-xl prose-img:shadow-md">
                    
                    <?php 
                    if ( have_posts() ) : 
                        while ( have_posts() ) : the_post();
                            the_content();
                        endwhile; 
                    endif; 
                    ?>
                </div>

                <?php 
                $project_gallery = get_field('project_gallery'); 
                if($project_gallery): 
                ?>
                    <div class="mt-12">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 border-l-4 border-[#aa7d59] pl-3">
                            <?php pll_e('Hình ảnh dự án'); ?>
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <?php foreach($project_gallery as $img_id): ?>
                                <a href="<?php echo wp_get_attachment_image_url($img_id, 'full'); ?>" class="block rounded-lg overflow-hidden hover:opacity-90 transition">
                                    <?php echo wp_get_attachment_image($img_id, 'medium_large', false, ['class' => 'w-full h-48 object-cover']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </main>

            <aside class="col-span-1 lg:col-span-4">
                <div class="sticky top-24 space-y-8">
                    
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                            <?php pll_e('Thông tin dự án'); ?>
                        </h3>
                        
                        <div class="space-y-4">
                            <?php if($date_display): ?>
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase font-bold tracking-wider mb-1"><?php pll_e('Thời gian thực hiện'); ?></span>
                                    <div class="flex items-center text-gray-800 font-medium">
                                        <i class="fa-regular fa-clock text-[#125f4b] mr-2"></i>
                                        <?php echo esc_html($date_display); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if($experiences): ?>
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase font-bold tracking-wider mb-2"><?php pll_e('Lĩnh vực liên quan'); ?></span>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach($experiences as $exp_id): ?>
                                            <a href="<?php echo get_permalink($exp_id); ?>" class="inline-block bg-white border border-gray-200 text-gray-600 px-3 py-1 rounded text-sm hover:border-[#125f4b] hover:text-[#125f4b] transition-colors">
                                                <?php echo get_the_title($exp_id); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($people): ?>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                            <?php pll_e('Nhân sự phụ trách'); ?>
                        </h3>
                        
                        <div class="flex flex-col gap-4">
                            <?php foreach($people as $p_id): 
                                $p_name = get_the_title($p_id);
                                $p_link = get_permalink($p_id);
                                $p_pos  = get_field('position', $p_id);
                                
                                $p_avatar = get_field('anh_dai_dien', $p_id);
                                if(!$p_avatar) $p_avatar = "https://dummyimage.com/100x100/f3f4f6/999&text=" . substr($p_name, 0, 1);
                            ?>
                                <div class="flex items-center group">
                                    <a href="<?php echo $p_link; ?>" class="flex-shrink-0 mr-3">
                                        <img src="<?php echo esc_url($p_avatar); ?>" class="w-12 h-12 rounded-full object-cover border border-gray-200 group-hover:border-[#125f4b] transition-colors">
                                    </a>
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900 group-hover:text-[#125f4b] transition-colors">
                                            <a href="<?php echo $p_link; ?>"><?php echo esc_html($p_name); ?></a>
                                        </h4>
                                        <?php if($p_pos): ?>
                                            <p class="text-xs text-gray-500 truncate max-w-[150px]">
                                                <?php echo is_array($p_pos) ? implode(', ', $p_pos) : $p_pos; ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="bg-[#125f4b] p-6 rounded-xl text-white text-center">
                        <p class="text-sm opacity-90 mb-4">
                            <?php pll_e('Bạn cần tư vấn về dự án tương tự?'); ?>
                        </p>
                        <a href="<?php echo home_url('/lien-he'); ?>" class="inline-block bg-white text-[#125f4b] px-6 py-2 rounded font-bold hover:bg-gray-100 transition-colors w-full">
                            <?php pll_e('Liên hệ ngay'); ?>
                        </a>
                    </div>

                </div>
            </aside>
        </div>
        
        <div class="mt-20 pt-10 border-t border-gray-100">
            <div class="flex justify-between items-end mb-8">
                <h3 class="text-2xl font-bold text-gray-900 border-l-4 border-[#aa7d59] pl-3">
                    <?php pll_e('Dự án khác'); ?>
                </h3>
                <a href="<?php echo get_post_type_archive_link('recent_work'); ?>" class="hidden md:inline-block text-[#125f4b] font-bold hover:underline">
                    <?php pll_e('Xem tất cả'); ?> <i class="fa-solid fa-angle-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                $related_args = array(
                    'post_type'      => 'recent_work',
                    'posts_per_page' => 3,
                    'post__not_in'   => array($current_id),
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                );
                $related_query = new WP_Query($related_args);

                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                ?>
                    <div class="group h-full flex flex-col">
                        <a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-lg mb-3 aspect-[16/10] bg-gray-100">
                             <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                            <?php else : ?>
                                <img src="https://dummyimage.com/400x250/f3f4f6/9ca3af&text=Project" class="w-full h-full object-cover">
                            <?php endif; ?>
                        </a>
                        <div class="text-xs text-gray-400 mb-2 uppercase font-bold tracking-wider">
                            <?php echo get_the_date('Y'); ?>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 leading-snug group-hover:text-[#125f4b] transition-colors mb-2">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <div class="text-sm text-gray-600 line-clamp-2">
                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                        </div>
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
