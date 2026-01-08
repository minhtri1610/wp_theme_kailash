<?php
/**
 * Template Name: Single Experience
 * Responsive & UI Optimized by Coder WP
 * @package kailash
 */

get_header();

// Lấy ID hiện tại và kiểm tra Parent
$current_id = get_the_ID();
$post_parent_id = $post->post_parent; // Nếu = 0 là Level 1, > 0 là Level 2
$is_level_1 = ($post_parent_id == 0);
?>

<div class="wrapper-single-experience bg-white pb-20">
    
    <div class="head-banner mb-8 md:mb-12 relative group">
        <?php if (has_post_thumbnail()) : ?>
            <div class="w-full h-[300px] md:h-[400px] relative overflow-hidden">
                <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105']); ?>
                
                <div class="absolute inset-0 bg-black/30"></div>

                <div class="absolute inset-0 flex items-center justify-center container mx-auto px-4">
                    <h1 class="text-3xl md:text-5xl font-bold text-white py-4 px-6 md:px-10 bg-gradient-to-r from-[#125f4b] to-[#125f4b]/10 border-l-4 border-white backdrop-blur-sm shadow-lg max-w-4xl leading-tight">
                        <?php the_title(); ?>
                    </h1>
                </div>  
            </div>
        <?php else : ?>
            <div class="w-full h-[300px] md:h-[400px] bg-gray-200 relative flex items-center justify-center">
                <h1 class="text-3xl md:text-5xl font-bold text-gray-800 px-4 text-center"><?php the_title(); ?></h1>
            </div>
        <?php endif; ?>
    </div>

    <div class="container mx-auto px-4">
        
        <div class="mb-8 border-b border-gray-100 pb-4">
            <?php 
            if (function_exists('kailash_breadcrumbs')) {
                kailash_breadcrumbs();
            } else {
                ?>
                <div class="text-sm text-gray-500 font-medium">
                    <a href="<?php echo home_url(); ?>" class="hover:text-[#125f4b]">Home</a> / 
                    <span class="text-gray-900"><?php the_title(); ?></span>
                </div>
                <?php
            }
            ?>
        </div>

        <?php if (!$is_level_1) : ?>
            
            <div class="level-2-layout grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <div class="col-span-1 lg:col-span-8">
                    
                    <div class="entry-content prose prose-lg max-w-none text-gray-700 leading-relaxed text-justify
                        prose-headings:text-[#aa7d59] prose-headings:font-bold
                        prose-a:text-[#125f4b] prose-a:no-underline hover:prose-a:underline
                        prose-li:marker:text-[#125f4b]">
                        <?php 
                            $content = get_the_content();
                            if ( !empty( $content ) && trim( $content ) !== "" ) {
                                the_content(); 
                            } else {
                        ?>
                            <div class="updating-notice py-10 px-6 bg-gray-50 border border-dashed border-gray-300 rounded-lg text-center">
                                <i class="fa-solid fa-pen-to-square text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 italic"><?php pll_e('Nội dung đang được cập nhật...'); ?></p>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="my-12 border-t border-gray-200"></div>

                    <div class="mb-12">
                        <h2 class="text-2xl font-bold mb-6 text-[#aa7d59] border-l-4 border-[#125f4b] pl-3">
                            <?php pll_e('Dự án nổi bật'); ?>
                        </h2>
                        
                        <?php
                        $project_args_l2 = array(
                            'post_type'      => 'recent_work',
                            'posts_per_page' => 3, 
                            'meta_query'     => array(
                                array(
                                    'key'     => 'related_experience', // Field Relationship trả về ID
                                    'value'   => '"' . $current_id . '"', // Tìm ID trong chuỗi serialize
                                    'compare' => 'LIKE'
                                )
                            )
                        );
                        $project_query_l2 = new WP_Query($project_args_l2);

                        if ($project_query_l2->have_posts()) : ?>
                            <div class="grid grid-cols-1 gap-4">
                                <?php while ($project_query_l2->have_posts()) : $project_query_l2->the_post(); 
                                    $p_start = get_field('project_start_date');
                                    $p_end   = get_field('project_end_date');
                                    $date_display = $p_start ? $p_start : '';
                                    if($p_end) $date_display .= ' - ' . $p_end;
                                ?>
                                    <div class="project-item bg-gray-50 p-4 rounded-lg hover:shadow-md transition-shadow border border-gray-100">
                                        <h3 class="text-lg font-bold text-gray-900 hover:text-[#125f4b] transition-colors mb-2">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <?php if($date_display): ?>
                                            <div class="text-xs text-gray-500 italic mb-2 flex items-center">
                                                <i class="fa-regular fa-calendar mr-2 text-[#125f4b]"></i><?php echo esc_html($date_display); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="text-gray-600 text-sm line-clamp-2">
                                            <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php 
                        else:
                            // Ẩn nếu không có dự án, hoặc hiện thông báo
                            // echo '<p class="text-gray-500 italic text-sm">Chưa có dự án liên quan.</p>';
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>

                    <div class="mb-12">
                        <h2 class="text-2xl font-bold mb-8 text-[#aa7d59] border-l-4 border-[#125f4b] pl-3">
                            <?php pll_e('Chuyên gia phụ trách'); ?>
                        </h2>

                        <?php
                        $people_args = array(
                            'post_type'      => 'people',
                            'posts_per_page' => 4,
                            'meta_query'     => array(
                                array(
                                    'key'     => 'linh_vuc_phu_trach',
                                    'value'   => '"' . $current_id . '"',
                                    'compare' => 'LIKE'
                                )
                            )
                        );
                        $people_query = new WP_Query($people_args);

                        if ($people_query->have_posts()) : ?>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <?php while ($people_query->have_posts()) : $people_query->the_post(); 
                                     $p_avatar = get_field('anh_dai_dien');
                                     $p_pos = get_field('position');
                                ?>
                                    <div class="people-card text-center group">
                                        <a href="<?php the_permalink(); ?>" class="block">
                                            <div class="rounded-full overflow-hidden w-24 h-24 md:w-32 md:h-32 mx-auto mb-4 border-2 border-gray-100 group-hover:border-[#125f4b] transition-all shadow-sm">
                                                <?php if($p_avatar): ?>
                                                    <img src="<?php echo esc_url($p_avatar); ?>" class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <img src="https://dummyimage.com/150x150/eee/999&text=User" class="w-full h-full object-cover">
                                                <?php endif; ?>
                                            </div>
                                            <h4 class="font-bold text-base text-gray-900 group-hover:text-[#125f4b] transition leading-tight px-2">
                                                <?php the_title(); ?>
                                            </h4>
                                            <?php if($p_pos): ?>
                                                <div class="text-xs text-gray-500 mt-1 uppercase tracking-wide truncate px-2">
                                                    <?php echo is_array($p_pos) ? implode(', ', $p_pos) : $p_pos; ?>
                                                </div>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; wp_reset_postdata(); ?>
                    </div>
                </div>

                <aside class="col-span-1 lg:col-span-4">
                    <div class="sticky top-24 space-y-8">
                        
                        <div class="bg-[#125f4b] p-8 rounded-lg text-white text-center shadow-lg relative overflow-hidden group">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                            
                            <h3 class="text-2xl font-bold mb-4 relative z-10"><?php pll_e('Liên hệ tư vấn'); ?></h3>
                            <p class="text-white/90 mb-6 text-sm relative z-10">
                                <?php pll_e('Kết nối với luật sư chuyên môn của chúng tôi để được hỗ trợ giải quyết vấn đề của bạn.'); ?>
                            </p>
                            <a href="<?php echo home_url('/lien-he'); ?>" class="inline-block w-full bg-white text-[#125f4b] font-bold py-3 rounded hover:bg-gray-100 transition-colors shadow-sm relative z-10">
                                <?php pll_e('Gửi yêu cầu ngay'); ?>
                            </a>
                        </div>

                        <?php 
                        if ($post_parent_id > 0) {
                            $siblings_args = array(
                                'post_type'      => 'experience',
                                'post_parent'    => $post_parent_id,
                                'post__not_in'   => array($current_id),
                                'posts_per_page' => 5,
                                'orderby'        => 'menu_order',
                                'order'          => 'ASC'
                            );
                            $siblings_query = new WP_Query($siblings_args);
                            if ($siblings_query->have_posts()) : 
                        ?>
                            <div class="border border-gray-200 rounded-lg p-6 bg-white">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2"><?php pll_e('Dịch vụ liên quan'); ?></h3>
                                <ul class="space-y-3">
                                    <?php while ($siblings_query->have_posts()) : $siblings_query->the_post(); ?>
                                        <li>
                                            <a href="<?php the_permalink(); ?>" class="flex items-center text-gray-600 hover:text-[#125f4b] transition-colors group">
                                                <i class="fa-solid fa-angle-right text-xs mr-2 text-gray-400 group-hover:text-[#125f4b]"></i>
                                                <?php the_title(); ?>
                                            </a>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        <?php 
                            endif; wp_reset_postdata();
                        } 
                        ?>

                    </div>
                </aside>
            </div>


        <?php else : ?>
            
            <div class="level-1-layout">
                
                <div class="mb-16 text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-[#aa7d59] border-b-2 border-[#125f4b] inline-block pb-2">
                        <?php pll_e('Giới thiệu chung'); ?>
                    </h2>
                    <div class="text-lg text-gray-600 leading-relaxed text-justify md:text-left">
                        <?php the_content(); ?>
                    </div>
                </div>

                <div class="mb-20">
                    <div class="text-center mb-10">
                         <h2 class="text-2xl md:text-3xl font-bold text-gray-900"><?php pll_e('Các lĩnh vực chuyên môn'); ?></h2>
                         <div class="w-16 h-1 bg-[#125f4b] mx-auto mt-4"></div>
                    </div>
                    
                    <?php
                    $children_args = array(
                        'post_type'      => 'experience',
                        'post_parent'    => $current_id,
                        'posts_per_page' => -1,
                        'orderby'        => 'menu_order',
                        'order'          => 'ASC'
                    );
                    $children_query = new WP_Query($children_args);

                    if ($children_query->have_posts()) : ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php while ($children_query->have_posts()) : $children_query->the_post(); ?>
                                <a href="<?php the_permalink(); ?>" class="group bg-white border border-gray-200 rounded-xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">
                                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-[#125f4b] mb-3 transition-colors">
                                        <?php the_title(); ?>
                                    </h3>
                                    <div class="text-gray-500 text-sm line-clamp-3 mb-4 flex-1">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                    </div>
                                    <span class="text-[#125f4b] font-bold text-sm flex items-center mt-auto">
                                        <?php pll_e('Xem chi tiết'); ?> 
                                        <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                    </span>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php 
                    wp_reset_postdata();
                    endif; 
                    ?>
                </div>

                <div class="mb-20 bg-gray-50 -mx-4 md:-mx-8 px-4 md:px-8 py-12 rounded-3xl">
                    <div class="flex justify-between items-end mb-8 border-b border-gray-200 pb-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-[#aa7d59]">
                            <?php pll_e('Đội ngũ phụ trách'); ?>
                        </h2>
                        <a href="<?php echo get_post_type_archive_link('people'); ?>" class="text-[#125f4b] hover:underline font-medium hidden md:block">
                            <?php pll_e('Xem tất cả'); ?> <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </div>

                    <?php
                    $people_args = array(
                        'post_type'      => 'people',
                        'posts_per_page' => 4,
                        'meta_query'     => array(
                            array(
                                'key'     => 'linh_vuc_phu_trach',
                                'value'   => '"' . $current_id . '"',
                                'compare' => 'LIKE'
                            )
                        )
                    );
                    $people_query = new WP_Query($people_args);

                    if ($people_query->have_posts()) : ?>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <?php while ($people_query->have_posts()) : $people_query->the_post(); 
                                $p_avatar = get_field('anh_dai_dien');
                                $p_pos = get_field('position');
                            ?>
                                <div class="people-card bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow text-center group">
                                    <a href="<?php the_permalink(); ?>" class="block">
                                        <div class="rounded-full overflow-hidden w-28 h-28 mx-auto mb-4 border-2 border-gray-100 group-hover:border-[#125f4b] transition-all">
                                            <?php if($p_avatar): ?>
                                                <img src="<?php echo esc_url($p_avatar); ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <img src="https://dummyimage.com/150x150/eee/999&text=K" class="w-full h-full object-cover">
                                            <?php endif; ?>
                                        </div>
                                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-[#125f4b] transition line-clamp-1"><?php the_title(); ?></h4>
                                        <div class="text-xs text-gray-500 mt-1 uppercase tracking-wider line-clamp-1">
                                            <?php echo is_array($p_pos) ? implode(', ', $p_pos) : $p_pos; ?>
                                        </div>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php 
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>

                <div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-8 tracking-wide text-[#aa7d59] border-b border-b-[#dcdcdc] pb-2.5">
                        <?php pll_e('Dự án tiêu biểu'); ?>
                    </h2>
                    
                    <?php
                    // Query giữ nguyên logic
                    $project_args_l1 = array(
                        'post_type'      => 'recent_work',
                        'posts_per_page' => 5, 
                        'meta_query'     => array(
                            array(
                                'key'     => 'related_experience',
                                'value'   => '"' . $current_id . '"',
                                'compare' => 'LIKE'
                            )
                        )
                    );
                    $project_query_l1 = new WP_Query($project_args_l1);

                    if ($project_query_l1->have_posts()) : ?>
                        <div class="space-y-4">
                            <?php while ($project_query_l1->have_posts()) : $project_query_l1->the_post(); 
                                $p_start = get_field('project_start_date');
                                $p_end   = get_field('project_end_date');
                                $date_display = $p_start ? $p_start : '';
                                if($p_end) $date_display .= ' - ' . $p_end;
                            ?>
                                <div class="project-item group border-b border-gray-100 pb-4 last:border-0 last:pb-0 hover:bg-gray-50 p-2 rounded transition-colors">
                                    <div class="flex flex-col md:flex-row md:items-baseline justify-between">
                                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-[#125f4b] transition-colors mb-1">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <?php if($date_display): ?>
                                            <div class="text-sm text-gray-500 italic flex-shrink-0 md:ml-4">
                                                <i class="fa-regular fa-calendar mr-2 text-[#125f4b]"></i><?php echo esc_html($date_display); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-gray-600 text-sm mt-1 line-clamp-2">
                                        <?php echo wp_trim_words(get_the_excerpt(), 35); ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php 
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>

            </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
