<?php
    $args = array(
        'post_type'      => 'people',
        'posts_per_page' => 20, 
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    );
    // Khởi tạo Query
    $home_people_query = new WP_Query($args);
?>

<section class="bg-[#0e5644] mt-10 md:mt-[3em] relative pb-20 md:pb-0" id="people">
    
    <div class="wapper-people grid grid-cols-1 lg:grid-cols-2">
        
        <div class="wapper-slide-people" id="slides-top-people">
            <div class="bp-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/people/p_01.jpg" alt="" class="h-[50vh] lg:min-h-[800px] w-full object-cover relative">
            </div>
            <div class="bp-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/people/p_02.jpg" alt="" class="h-[50vh] lg:min-h-[800px] w-full object-cover relative">
            </div>
            <div class="bp-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/people/p_03.jpg" alt="" class="h-[50vh] lg:min-h-[800px] w-full object-cover relative">
            </div>
        </div>

        <div class="wapper-info-people mt-10 lg:mt-[5rem] px-4 lg:px-0">
            <div class="content-info-people flex flex-col items-center justify-center text-center lg:text-left">
                <h2 class="text-4xl md:text-5xl text-white font-extrabold mb-4">Tiêu đề</h2>
                <div class="content-info text-white p-0 lg:p-5 text-base md:text-lg max-w-prose">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus fuga libero dignissimos labore, magnam commodi possimus eos vel? Dicta perspiciatis quisquam accusantium impedit veniam delectus ad expedita facilis fugit ratione.
                </div>
            </div>
        </div>
    </div>

    <div class="relative lg:absolute flex w-full min-h-auto lg:min-h-[400px] mt-10 lg:mt-0 top-auto lg:top-[14rem] text-center z-[2] m-auto items-center justify-center pointer-events-none">
        
        <div class="line-count flex flex-col lg:flex-row w-full justify-center items-center lg:items-baseline gap-8 lg:gap-15 mx-auto">
            
            <div class="text-gray-700 flex items-baseline gap-2">
                <span class="text-white font-gilda text-xl md:text-[3rem] mr-2 -translate-y-1 block"><?php pll_e('Địa điểm'); ?></span>
                
                <span class="text-white font-gilda text-6xl md:text-[8rem] lg:text-[12rem] leading-none font-bold" counter-element="number">22</span>
                
                <span class="text-white font-gilda text-4xl md:text-[8rem] -translate-y-2">+</span>
            </div>

            <div class="hidden lg:block w-[1px] h-[10rem] bg-white rotate-[20deg] translate-y-8 ml-4"></div>

            <div class="text-gray-700 ml-0 lg:ml-4 flex items-baseline gap-2">
                <span class="text-white font-gilda text-xl md:text-[3rem] mr-2 -translate-y-1 block"><?php pll_e('Chuyên gia'); ?></span>
                
                <span class="text-white font-gilda text-6xl md:text-[8rem] lg:text-[12rem] leading-none font-bold" counter-element="number"><?php echo $home_people_query->found_posts; ?></span>
                
                <span class="text-white font-gilda text-4xl md:text-[8rem] -translate-y-2">+</span>
            </div>

        </div>
    </div>

    <div class="list-people bg-white relative lg:absolute w-[95%] lg:w-[90%] min-h-[300px] lg:min-h-[400px] mt-10 lg:mt-0 bottom-auto lg:bottom-[5rem] left-1/2 -translate-x-1/2 text-center z-[10] shadow-xl rounded-lg lg:rounded-none">
        <div id="list-people" class="p-4 md:p-[3rem]">
            <?php
                if ($home_people_query->have_posts()) :
                    while ($home_people_query->have_posts()) : $home_people_query->the_post();
                        
                        $position = get_field('position');
                        $full_name = get_field('ho_ten');
                        $avatar = get_field('anh_dai_dien');
                        $avatar = $avatar ? $avatar :  "https://dummyimage.com/200x250/05654a/fff&text=K"; // Fallback image ngắn gọn
            ?>
                        <div class="p-item mt-4 md:mt-[2.5em] px-2">
                            <div class="overflow-hidden mb-4 relative flex justify-center group">
                                <img src="<?php echo esc_url($avatar); ?>" 
                                    alt="<?php echo esc_attr($full_name); ?>"
                                    class="w-[160px] h-[200px] md:w-[200px] md:h-[250px] object-cover transition-transform duration-500 group-hover:scale-105 border border-gray-300"
                                >
                            </div>

                            <h3 class="text-xl md:text-2xl font-gilda text-gray-900 mb-1"><?php echo esc_html($full_name); ?></h3>
                            <?php if($position): ?>
                                <p class="text-xs md:text-sm font-nunito font-bold text-gray-400 uppercase tracking-widest line-clamp-1">
                                    <?php echo implode(', ', $position); ?>
                                </p>
                            <?php endif; ?>
                        </div>
            <?php
                    endwhile;
                endif;
            ?>
        </div>
    </div>
</section>
