<?php
    $args = array(
                'post_type'      => 'people',
                'posts_per_page' => 20, // Số lượng muốn hiển thị (Ví dụ: 4 hoặc 8). Điền -1 nếu muốn lấy hết.
                'orderby'        => 'menu_order', // Sắp xếp theo thứ tự bạn chỉnh trong Admin
                'order'          => 'ASC',
                'post_status'    => 'publish',
            );
    // Khởi tạo Query
    $home_people_query = new WP_Query($args);

?>

<section class="bg-[#0e5644] mt-[3em] relative" id="people">
    <div class="wapper-people grid grid-cols-4">
        <div class="wapper-slide-people col-span-2" id="slides-top-people">
            <div class="bp-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/people/p_01.jpg" alt="" class="h-auto w-auto min-h-[800px] min-w-full relative max-h-100">
            </div>
            <div class="bp-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/people/p_02.jpg" alt="" class="h-auto w-auto min-h-[800px] min-w-full relative max-h-100">
            </div>
            <div class="bp-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/people/p_03.jpg" alt="" class="h-auto w-auto min-h-[800px] min-w-full relative max-h-100">
            </div>
        </div>
        <div class="wapper-info-people mt-[5rem] col-span-2 ">
            <div class="content-info-people flex flex-col items-center justify-center">
                <h2 class="text-5xl text-white font-extrabold">Tiêu đề</h2>
                <div class="content-info text-white p-5 text-base">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus fuga libero dignissimos labore, magnam commodi possimus eos vel? Dicta perspiciatis quisquam accusantium impedit veniam delectus ad expedita facilis fugit ratione.
                </div>
            </div>
        </div>
    </div>
    <div class="absolute flex w-full min-h-[400px] top-[14rem] text-center z-[2] m-auto items-center">
        <!-- <div class="line-count flex w-full text-center my-0 mx-auto"> -->
        <div class="line-count flex w-full justify-center items-baseline gap-15 mx-auto">
            <div class="text-gray-700 flex items-baseline gap-2">
                <span class="text-white font-gilda text-[3rem] mr-2 -translate-y-1"><?php pll_e('Địa điểm'); ?></span>
                
                <span class="text-white font-gilda text-[12rem] leading-none" counter-element="number">22</span>
                
                <span class="text-white font-gilda text-[8rem] -translate-y-2">+</span>

                <!--  -->
            </div>
            <div class="w-[1px] h-[10rem] bg-white rotate-[20deg] translate-y-8 ml-4"></div>

            <div class="text-gray-700 ml-4 flex items-baseline gap-2">
                <span class="text-white font-gilda text-[3rem] mr-2 -translate-y-1"><?php pll_e('Chuyên gia'); ?></span>
                
                <span class="text-white font-gilda text-[12rem] leading-none" counter-element="number"><?php echo $home_people_query->found_posts; ?></span>
                
                <span class="text-white font-gilda text-[8rem] -translate-y-2">+</span>
            </div>

        </div>
    </div>

    <div class="list-people bg-white absolute w-[90%] min-h-[400px] bottom-[5rem] text-center z-[10]">
        <div id="list-people" class="p-[3rem]">
            <?php
                if ($home_people_query->have_posts()) :
                    while ($home_people_query->have_posts()) : $home_people_query->the_post();
                        
                        // Lấy dữ liệu ACF
                        $position = get_field('position');
                        $full_name = get_field('ho_ten');
                        $avatar = get_field('anh_dai_dien');
                        $avatar = $avatar ? $avatar :  "https://dummyimage.com/200x250/05654a/fff&text=KaiLash(270x270px)";
            ?>
                        <div class="p-item mt-[2.5em]">
                            <div class="overflow-hidden mb-4 relative flex justify-center">
                                <img src="<?php echo $avatar; ?>" 
                                    alt="<?php echo $full_name; ?>"
                                    class="w-[200px] h-[250px] object-cover transition-transform duration-500 group-hover:scale-105 border border-gray-300"
                                >
                            </div>

                            <h3 class="text-2xl font-gilda text-gray-900 mb-1"><?php echo $full_name; ?></h3>
                            <p class="text-sm font-nunito font-bold text-gray-400 uppercase tracking-widest"><?php echo implode(', ', $position); ?></p>
                        </div>
            <?php
                    endwhile;
                endif;
            ?>
        </div>
    </div>
</section>
