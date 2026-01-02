<?php
    // [LOGIC MỚI] Đếm tổng số bài viết Knowledge đã Publish
    $knowledge_count_query = new WP_Query(array(
        'post_type'      => 'knowledge',
        'post_status'    => 'publish',
        'posts_per_page' => -1,      // Lấy tất cả
        'fields'         => 'ids',   // Chỉ lấy ID để tối ưu tốc độ tải trang
    ));
    $total_knowledge_posts = $knowledge_count_query->found_posts;
?>
<section class="container my-[3em]" id="experience">
    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-1">
            <div class="content-experience">
                <h2 class="text-4xl font-bold text-black mb-6"><?php pll_e('Dịch vụ'); ?></h2>
                <div class="content-info text-black py-5 text-base align-justify">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates delectus eligendi autem neque, nihil voluptatum aspernatur amet eum, ea perferendis debitis. Quibusdam ex rerum assumenda ullam perspiciatis ipsam, odio expedita!
                </div>
                <div class="flex justify-start items-end link mt-5">
                    <a href="<?php echo site_url('/dich-vu'); ?>" class="text-[#125f4b]"><?php pll_e('Dịch vụ'); ?></a>
                </div>
                <!-- <a href="#" class="text-[#125f4b]">Experience <i class="fa-solid fa-angles-right"></i></a> -->
            </div>
        </div>
        <div class="col-span-2">
            <div class="content-experience grid grid-cols-5 gap-2 ">
                <div class="col-span-2">
                    <img class="w-full h-full" src="<?php echo get_template_directory_uri(); ?>/assets/images/home/experience/practices_pc.jpg" alt="">
                </div>
                <div class="col-span-3">
                    <a class="count-knowledge" href="<?php echo site_url('/kien-thuc'); ?>">
                        <h2 class="text-4xl font-bold text-black mb-6 text-center"><?php pll_e('Kiến thức'); ?></h2>
                        <p class="text-right"><span class="text-[#125f4b] font-gilda text-[10rem] leading-none" counter-element="number"><?php echo $total_knowledge_posts; ?></span>
</p>
</a>
                    <a class="img-knowledge" href="<?php echo site_url('/kien-thuc'); ?>">
                        <img class="w-full hover:opacity-60" src="<?php echo get_template_directory_uri(); ?>/assets/images/home/experience/knowledge_pc.jpg" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
