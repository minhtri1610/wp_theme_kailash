<?php
/**
 * Template Name: Single Experience
 *
 * Template này xử lý hiển thị trang chi tiết cho Experience.
 * Logic:
 * - Nếu là Level 2 (Con): Hiển thị nội dung + Kiến thức liên quan (Knowledge).
 * - Nếu là Level 1 (Cha): Hiển thị danh sách con + Cộng sự liên quan (People).
 *
 * @package kailash
 */

get_header();

// Lấy ID hiện tại và kiểm tra Parent
$current_id = get_the_ID();
$post_parent_id = $post->post_parent; // Nếu = 0 là Level 1, > 0 là Level 2
$is_level_1 = ($post_parent_id == 0);
?>

<div class="wrapper-single-experience">
    <div class="head-banner mb-3">
        <?php if (has_post_thumbnail()) : ?>
            <div class="w-full max-h-[300px] relative">
                <a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-lg">
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-[300px] object-cover hover:scale-105 transition-transform duration-500']); ?>
                </a>
                <div class="container mx-auto px-5 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <h1 class="text-3xl md:text-5xl font-bold text-white mb-6 py-3 px-6 w-fit bg-gradient-to-r from-[#125f4b] to-[#125f4b]/0 border-l-4 border-[#ffffff] rounded-r-lg                                   ">
                        <?php the_title(); ?>
                    </h1>
                    <!-- <h1 class="text-3xl md:text-5xl font-bold text-[#fff] mb-6 p-3 bg-[#125f4bbe] w-fit"><?php the_title(); ?></h1> -->
                </div>  
            </div>
        <?php else : ?>
            <img class="w-full h-[300px] object-cover hover:scale-105 transition-transform duration-500" src="https://dummyimage.com/380x240/737373/fff&text=1250x300px" />
        <?php endif; ?>
    </div>
    <div class="container mx-auto px-4 mb-[5rem]">
        <!-- BREADCRUMB (Điều hướng tổng quát) -->
        <?php 
        if (function_exists('kailash_breadcrumbs')) {
            kailash_breadcrumbs();
        } else {
            // Fallback nếu chưa include file breadcrumbs
            ?>
            <div class="breadcrumb text-sm text-gray-500 mb-6">
                <a href="<?php echo home_url(); ?>">Home</a> / 
                <span class="text-gray-900"><?php the_title(); ?></span>
            </div>
            <?php
        }
        ?>

        <!-- ========================================================================= -->
        <!-- LAYOUT CHO LEVEL 2 (CHI TIẾT DỊCH VỤ) -->
        <!-- ========================================================================= -->
        <?php if (!$is_level_1) : ?>
            
            <div class="level-2-layout grid grid-cols-1 lg:grid-cols-3 gap-10">
                
                <!-- CỘT TRÁI: NỘI DUNG CHÍNH (Chiếm 2/3) -->
                <div class="col-span-1 lg:col-span-2">
                    <!-- <header class="entry-header mb-6">
                        <h1 class="text-3xl md:text-4xl font-bold text-[#125f4b] mb-4"><?php the_title(); ?></h1>
                        <?php if (has_excerpt()) : ?>
                            <div class="text-lg text-gray-600 italic border-l-4 border-[#125f4b] pl-4">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </header> -->

                    <div class="entry-content prose max-w-none text-gray-800 leading-relaxed">
                        <?php 
                            $content = get_the_content();
                            if ( !empty( $content ) && trim( $content ) !== "" ) {
                                the_content(); 
                            } else {
                        ?>
                            <div class="updating-notice py-8 px-6 bg-gray-50 border border-dashed border-gray-300 rounded-lg text-center">
                                <div class="text-4xl text-gray-300 mb-2">
                                    <i class="fa-solid fa-pen-to-square"></i> <!-- Icon (nếu có fontawesome) -->
                                </div>
                                <p class="text-gray-500 italic">
                                    <?php pll_e('Nội dung đang được cập nhật...'); ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>

                <!-- [CẬP NHẬT] DỰ ÁN GẦN ĐÂY (Recent Work) CHO LEVEL 1 -->
                <div class="text-left mx-auto mb-12">
                    <h2 class="text-2xl font-bold my-8 uppercase tracking-wide text-[#aa7d59] border-b border-b-[#dcdcdc] pb-2.5">
                        <?php pll_e('Dự án gần đây'); ?>
                    </h2>
                    
                    <?php
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
                        <div class="list-rencent-projects space-y-4">
                            <?php while ($project_query_l1->have_posts()) : $project_query_l1->the_post(); 
                                $p_start = get_field('project_start_date');
                                $p_end   = get_field('project_end_date');
                                $date_display = $p_start ? $p_start : '';
                                if($p_end) $date_display .= ' - ' . $p_end;
                            ?>
                                <div class="project-item border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                    <h3 class="text-lg font-bold text-gray-800 hover:text-[#125f4b] transition-colors mb-1">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <?php if($date_display): ?>
                                        <div class="text-sm text-gray-500 italic mb-2">
                                            <i class="fa-regular fa-calendar mr-2"></i><?php echo esc_html($date_display); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-gray-600 text-sm line-clamp-2">
                                        <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php 
                    else:
                        echo '<p class="text-gray-500 italic">' . pll__('Đang cập nhật danh sách dự án.') . '</p>';
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>

                    <!-- 2. DANH SÁCH CỘNG SỰ (PEOPLE) -->
                    <!-- Logic: Tìm People có field 'assigned_experience_parent' chứa ID bài này -->

                    <div class="text-left mx-auto mb-[5rem]">
                        <div class="">
                            <h2 class="text-2xl font-bold mb-8 uppercase tracking-wide text-[#aa7d59] border-b border-b-[#dcdcdc] pb-2.5">
                                <?php pll_e('Đội ngũ phụ trách'); ?>
                            </h2>

                            <?php
                            $people_args = array(
                                'post_type'      => 'people',
                                'posts_per_page' => -1,
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
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                    <?php while ($people_query->have_posts()) : $people_query->the_post(); ?>
                                        <div class="people-card text-center group p-3 shadow-[5px_4px_7px_2px_#ddd]">
                                            <a href="<?php the_permalink(); ?>" class="block">
                                                <div class="rounded-full overflow-hidden w-32 h-32 mx-auto mb-4 border-2 border-transparent group-hover:border-[#125f4b] transition-all">
                                                    <?php 
                                                    if (has_post_thumbnail()) {
                                                        the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']);
                                                    } else {
                                                        echo '<img src="https://dummyimage.com/150x150" class="w-full h-full object-cover">';
                                                    }
                                                    ?>
                                                </div>
                                                <h4 class="font-bold text-lg text-gray-900 group-hover:text-[#125f4b] transition"><?php the_title(); ?></h4>
                                                <div class="text-sm text-gray-500 mt-1 uppercase tracking-wider"><?php the_field('position'); ?></div>
                                            </a>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php 
                            else:
                                echo '<p class="text-center text-gray-500">Đang cập nhật danh sách nhân sự.</p>';
                            endif;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                </div>

                <!-- CỘT PHẢI: SIDEBAR & KIẾN THỨC LIÊN QUAN (Chiếm 1/3) -->
                <aside class="col-span-1">
                    <div class="sticky top-10 space-y-8">
                        
                        <!-- Box 1: Thông tin liên hệ nhanh (Ví dụ) -->
                        <div class="bg-gray-50 px-6 rounded-lg border border-gray-100">
                            <h3 class="text-3xl font-bold mb-4 text-gray-900"><?php pll_e('Liên hệ'); ?></h3>
                            <p class="text-gray-600 mb-4 text-sm">Liên hệ ngay để được tư vấn chi tiết về lĩnh vực này.</p>
                            <a href="/lien-he" class="block w-full text-center bg-[#125f4b] text-white py-2 rounded hover:bg-[#0e4b3a] transition">
                                <?php pll_e('Gửi yêu cầu'); ?>
                            </a>
                        </div>

                    </div>
                </aside>
            </div>


        <!-- ========================================================================= -->
        <!-- LAYOUT CHO LEVEL 1 (TỔNG QUAN LĨNH VỰC) -->
        <!-- ========================================================================= -->
        <?php else : ?>
            
            <div class="level-1-layout">
                <!-- Header Level 1 -->
                <div class="text-left mx-auto mb-12">
                    <h2 class="text-2xl font-bold mb-8 uppercase tracking-wide text-[#aa7d59] border-b border-b-[#dcdcdc] pb-2.5">
                        <?php pll_e('Các lĩnh vực chuyên môn'); ?>
                    </h2>
                    <div class="text-xl text-gray-600 leading-relaxed">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- 1. DANH SÁCH CÁC MỤC CON (LEVEL 2) -->
                <div class="mb-16">
                    
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
                                <a href="<?php the_permalink(); ?>" class="group bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-all hover:-translate-y-1">
                                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-[#125f4b] mb-3">
                                        <?php the_title(); ?>
                                    </h3>
                                    <div class="text-gray-500 text-sm line-clamp-3 mb-4">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                    </div>
                                    <span class="text-[#125f4b] font-medium text-sm flex items-center">
                                        Chi tiết <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m0-4H3"></path></svg>
                                    </span>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php 
                    wp_reset_postdata();
                    else : 
                        echo '<p class="text-center text-gray-500">Đang cập nhật nội dung.</p>';
                    endif; 
                    ?>
                </div>

                <!-- 2. DANH SÁCH CỘNG SỰ (PEOPLE) -->
                <!-- Logic: Tìm People có field 'assigned_experience_parent' chứa ID bài này -->

                <div class="text-left mx-auto mb-[5rem]">
                    <div class="">
                        <h2 class="text-2xl font-bold mb-8 uppercase tracking-wide text-[#aa7d59] border-b border-b-[#dcdcdc] pb-2.5">
                            <?php pll_e('Đội ngũ phụ trách'); ?>
                        </h2>

                        <?php
                        $people_args = array(
                            'post_type'      => 'people',
                            'posts_per_page' => -1,
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
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <?php while ($people_query->have_posts()) : $people_query->the_post(); ?>
                                    <div class="people-card text-center group p-3 shadow-[5px_4px_7px_2px_#ddd]">
                                        <a href="<?php the_permalink(); ?>" class="block">
                                            <div class="rounded-full overflow-hidden w-32 h-32 mx-auto mb-4 border-2 border-transparent group-hover:border-[#125f4b] transition-all">
                                                <?php 
                                                if (has_post_thumbnail()) {
                                                    the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']);
                                                } else {
                                                    echo '<img src="https://dummyimage.com/150x150" class="w-full h-full object-cover">';
                                                }
                                                ?>
                                            </div>
                                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-[#125f4b] transition"><?php the_title(); ?></h4>
                                            <div class="text-sm text-gray-500 mt-1 uppercase tracking-wider">Partner</div>
                                        </a>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php 
                        else:
                            echo '<p class="text-center text-gray-500">Đang cập nhật danh sách nhân sự.</p>';
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>

                <!-- [CẬP NHẬT] DỰ ÁN GẦN ĐÂY (Recent Work) CHO LEVEL 1 -->
                <div class="text-left mx-auto mb-12">
                    <h2 class="text-2xl font-bold mb-8 uppercase tracking-wide text-[#aa7d59] border-b border-b-[#dcdcdc] pb-2.5">
                        <?php pll_e('Dự án gần đây'); ?>
                    </h2>
                    
                    <?php
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
                        <div class="list-rencent-projects space-y-4">
                            <?php while ($project_query_l1->have_posts()) : $project_query_l1->the_post(); 
                                $p_start = get_field('project_start_date');
                                $p_end   = get_field('project_end_date');
                                $date_display = $p_start ? $p_start : '';
                                if($p_end) $date_display .= ' - ' . $p_end;
                            ?>
                                <div class="project-item border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                    <h3 class="text-lg font-bold text-gray-800 hover:text-[#125f4b] transition-colors mb-1">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <?php if($date_display): ?>
                                        <div class="text-sm text-gray-500 italic mb-2">
                                            <i class="fa-regular fa-calendar mr-2"></i><?php echo esc_html($date_display); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-gray-600 text-sm line-clamp-2">
                                        <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php 
                    else:
                        echo '<p class="text-gray-500 italic">' . pll__('Đang cập nhật danh sách dự án.') . '</p>';
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>

            </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
