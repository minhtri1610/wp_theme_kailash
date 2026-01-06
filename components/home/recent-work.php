<section class="container mx-auto my-10 md:my-[3em] px-4" id="recent-work">
    
    <h2 class="text-3xl md:text-4xl font-bold text-black mb-6"><?php pll_e('Dự án gần đây'); ?></h2>
    
    <div class="wapper-recent -mx-2" id="slides-recent-work">
        <?php
        // 1. Query giữ nguyên logic
        $args = array(
            'post_type'      => 'recent_work',
            'posts_per_page' => 5, 
            'post_status'    => 'publish',
            'orderby'        => 'meta_value', 
            'meta_key'       => 'project_start_date',
            'order'          => 'DESC', 
        );

        $recent_work_query = new WP_Query($args);

        if ($recent_work_query->have_posts()) :
            while ($recent_work_query->have_posts()) : $recent_work_query->the_post();
                
                // 2. Logic xử lý ngày tháng giữ nguyên
                $date_string = get_field('project_start_date');
                $display_date = '';
                
                if ($date_string) {
                    $date_obj = DateTime::createFromFormat('d/m/Y', $date_string);
                    if ($date_obj) {
                        $display_date = $date_obj->format('Y.m');
                    } else {
                        $display_date = $date_string; 
                    }
                } else {
                    $display_date = get_the_date('Y.m'); 
                }
        ?>
            <div class="item-recent shadow-[2px_2px_#dcdcdc] pr-6 pb-6 md:pr-[3rem] md:pb-[4rem] mx-2 my-2 group h-full bg-white border border-transparent hover:border-gray-200 transition-all duration-300">
                
                <h3 class="text-2xl md:text-3xl text-gray-400 mb-2 font-light select-none">
                    <?php echo esc_html($display_date); ?>
                </h3>
                
                <a href="<?php the_permalink(); ?>" class="text-base md:text-lg font-bold text-black leading-snug group-hover:text-[#125f4b] transition-colors block line-clamp-2">
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

    <div class="flex justify-end items-end mr-0 md:mr-[0rem] link mt-5">
        <a href="<?php echo get_post_type_archive_link('recent_work'); ?>" class="text-[#125f4b] font-bold hover:underline flex items-center gap-2 group">
            <?php pll_e('Xem thêm'); ?>
        </a>
    </div>
</section>
