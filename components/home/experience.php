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

<section class="container mx-auto my-8 md:my-[3em] px-4" id="experience">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-4">
        
        <div class="col-span-1">
            <div class="content-experience h-full flex flex-col justify-center">
                <h2 class="text-3xl md:text-4xl font-bold text-black mb-4 md:mb-6"><?php pll_e('Dịch vụ'); ?></h2>
                
                <div class="content-info text-black py-2 md:py-5 text-base text-left md:text-justify leading-relaxed">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates delectus eligendi autem neque, nihil voluptatum aspernatur amet eum, ea perferendis debitis. Quibusdam ex rerum assumenda ullam perspiciatis ipsam, odio expedita!
                </div>
                
                <div class="flex justify-start items-end link mt-4 md:mt-5">
                    <a href="<?php echo site_url('/dich-vu'); ?>" class="text-[#125f4b] font-semibold hover:underline flex items-center gap-2">
                        <?php pll_e('Dịch vụ'); ?> <i class="fa-solid fa-angles-right text-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-span-1 lg:col-span-2">
            
            <div class="content-experience grid grid-cols-1 md:grid-cols-5 gap-6 md:gap-2 h-full">
                
                <div class="col-span-1 md:col-span-2 h-full">
                    <img class="w-full h-[300px] md:h-full object-cover rounded-lg md:rounded-none" src="<?php echo get_template_directory_uri(); ?>/assets/images/home/experience/practices_pc.jpg" alt="">
                </div>
                
                <div class="col-span-1 md:col-span-3 flex flex-col justify-between h-full">
                    
                    <a class="count-knowledge block group" href="<?php echo site_url('/kien-thuc'); ?>">
                        <h2 class="text-3xl md:text-4xl font-bold text-black mb-2 md:mb-6 text-center md:text-left group-hover:text-[#125f4b] transition-colors">
                            <?php pll_e('Kiến thức'); ?>
                        </h2>
                        
                        <p class="text-center md:text-right">
                            <span class="text-[#125f4b] font-gilda text-8xl md:text-8xl lg:text-[10rem] leading-none block md:inline-block" counter-element="number">
                                <?php echo $total_knowledge_posts; ?>
                            </span>
                        </p>
                    </a>
                    
                    <a class="img-knowledge mt-4 md:mt-0 block overflow-hidden rounded-lg md:rounded-none" href="<?php echo site_url('/kien-thuc'); ?>">
                        <img class="w-full h-[200px] md:h-auto object-cover hover:scale-105 hover:opacity-80 transition-all duration-500" src="<?php echo get_template_directory_uri(); ?>/assets/images/home/experience/knowledge_pc.jpg" alt="">
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
