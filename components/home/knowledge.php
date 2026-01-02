<section id="knowledge" class="container mx-auto mt-[3em] px-4">
    <div class="wapper-knowledge grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <?php
        // ------------------------------------------------------------------
        // CẤU HÌNH: Điền ID GỐC (Ví dụ ID của bản Tiếng Việt)
        // ------------------------------------------------------------------
        $base_ids = array(67, 71, 66); // <--- Thay ID bản Tiếng Việt vào đây

        foreach ($base_ids as $original_id) :
            
            // [LOGIC MỚI] Xử lý Đa ngôn ngữ an toàn
            // 1. Cố gắng lấy ID bài dịch tương ứng
            $translated_id = (function_exists('pll_get_post')) ? pll_get_post($original_id) : $original_id;
            
            // 2. Nếu không tìm thấy bài dịch (trả về 0 hoặc false), dùng lại ID gốc
            // Giúp luôn hiển thị được Label chủ đề dù chưa dịch
            $exp_id = $translated_id ? $translated_id : $original_id;

            // Lấy thông tin Lĩnh vực (Category)
            $cat_title = get_the_title($exp_id);
            $cat_link  = get_permalink($exp_id);

            // Query lấy 5 bài Knowledge thuộc lĩnh vực này
            $args = array(
                'post_type'      => 'knowledge',
                'posts_per_page' => 5, // Top 5 bài mới nhất
                'post_status'    => 'publish',
                'meta_query'     => array(
                    array(
                        'key'     => 'knowledge_related_experience', // Field ACF
                        'value'   => '"' . $exp_id . '"', // Tìm ID trong chuỗi serialize
                        'compare' => 'LIKE'
                    )
                )
            );
            $knowledge_query = new WP_Query($args);
        ?>

            <!-- category item -->
            <div class="kn-items">
                <!-- PHẦN LABEL: Luôn hiển thị vì nằm ngoài vòng lặp bài viết -->
                <div class="kn-head flex justify-between items-center">
                    <h2 class="text-3xl font-bold text-black mb-0">
                        <?php echo esc_html($cat_title); ?>
                    </h2>
                </div>
                
                <div class="kn-content">
                    <?php if ($knowledge_query->have_posts()) : ?>
                        <?php while ($knowledge_query->have_posts()) : $knowledge_query->the_post(); 
                            // Lấy các tag/lĩnh vực con
                            $sub_exps = get_field('knowledge_related_experience');
                        ?>
                            <div class="kn-item flex flex-col border-b border-gray-300 py-4">
                                <a class="text-[#0e0e0e] hover:text-[#125f4b] text-xl" href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                                
                                <?php if($sub_exps): ?>
                                    <div class="kn-list-sub flex flex-wrap">
                                        <?php 
                                        foreach($sub_exps as $sub_id): 
                                            // Không hiển thị lại Category cha đang đứng
                                            if($sub_id == $exp_id) continue; 
                                        ?>
                                            <span class="border rounded-xl outline-1 border-[#125f4b] px-2 my-2 text-base text-[#125f4b]">
                                                <?php echo get_the_title($sub_id); ?>
                                            </span>
                                        <?php 
                                            // Chỉ hiện 1 tag đầu tiên tìm thấy khác cha để giữ layout
                                            break; 
                                        endforeach; 
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <p class="text-[#0e0e0e] text-sm italic">
                                    <i class="fa-solid fa-calendar-days text-[#125f4b]"></i> 
                                    <?php echo get_the_date('Y-m-d'); ?>
                                </p>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <!-- Thông báo khi không có bài viết -->
                        <p class="text-gray-500 text-sm italic py-4">
                            <?php if(function_exists('pll_e')) { pll_e('Chưa có bài viết.'); } else { echo 'Chưa có bài viết.'; } ?>
                        </p>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>

                <div class="kn-footer flex justify-end mt-3">
                    <a href="<?php echo esc_url($cat_link); ?>" class="text-black">
                        View All <i class="fa-solid fa-angles-right"></i>
                    </a>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
</section>
