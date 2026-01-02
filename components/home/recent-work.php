<section class="container my-[3em]" id="recent-work">
    <h2 class="text-4xl font-bold text-black mb-6"><?php pll_e('Dự án gần đây'); ?></h2>
    <div class="wapper-recent" id="slides-recent-work">
        <?php
        // 1. Query lấy 3 dự án mới nhất
        $args = array(
            'post_type'      => 'recent_work',
            'posts_per_page' => 5, 
            'post_status'    => 'publish',
            'orderby'        => 'meta_value', // Sắp xếp theo ngày dự án (ACF)
            'meta_key'       => 'project_start_date',
            'order'          => 'DESC', // Mới nhất lên đầu
        );
        // Nếu không dùng meta_key (ACF) để sắp xếp thì dùng 'date' mặc định
        // $args['orderby'] = 'date'; 

        $recent_work_query = new WP_Query($args);

        if ($recent_work_query->have_posts()) :
            while ($recent_work_query->have_posts()) : $recent_work_query->the_post();
                
                // 2. Xử lý hiển thị ngày tháng (d/m/Y -> Y.m)
                $date_string = get_field('project_start_date');
                $display_date = '';
                
                if ($date_string) {
                    // Chuyển đổi format từ 25/12/2025 -> 2025.12
                    $date_obj = DateTime::createFromFormat('d/m/Y', $date_string);
                    if ($date_obj) {
                        $display_date = $date_obj->format('Y.m');
                    } else {
                        $display_date = $date_string; 
                    }
                } else {
                    // Fallback: Lấy ngày đăng bài
                    $display_date = get_the_date('Y.m'); 
                }
        ?>
            <!-- Item HTML giữ nguyên cấu trúc -->
            <div class="item-recent shadow-[2px_2px_#dcdcdc] pr-[3rem] pb-[4rem] m-2 mb-1 group h-full bg-white">
                <h3 class="text-3xl text-gray-400 mb-2 font-light"><?php echo esc_html($display_date); ?></h3>
                <a href="<?php the_permalink(); ?>" class="text-lg font-bold text-black leading-snug group-hover:text-[#125f4b] transition-colors block">
                    <?php the_title(); ?>
                </a>
            </div>

        <?php 
            endwhile;
            wp_reset_postdata();
        else: 
        ?>
            <div class="col-span-3 text-gray-500 italic p-4"><?php pll_e('Đang cập nhật dự án...'); ?></div>
        <?php endif; ?>
    </div>

    <!-- Link Xem thêm -->
    <div class="flex justify-end items-end mr-[0rem] link mt-5">
        <a href="<?php echo get_post_type_archive_link('recent_work'); ?>" class="text-[#125f4b] font-bold hover:underline flex items-center">
            <?php pll_e('Xem thêm'); ?>
        </a>
    </div>
</section>
