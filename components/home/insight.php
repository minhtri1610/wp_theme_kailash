<section class="container mt-[1em]" id="insight">
    <h2 class="text-4xl font-bold text-black mb-6"><?php pll_e('Góc nhìn') ?></h2>
    <div class="wapper-insight grid grid-cols-3 gap-4">
        <div class="left-insight col-span-2 h-full">
            <a class="insight-item relative h-full" href="#">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/insights/insight-1.jpg" alt="" class="w-full h-full opacity-100 hover:opacity-60 transition-opacity duration-300 ease-out">
                <div class="ins-title absolute bottom-0 left-0 text-2xl bg-[#00000062] p-2 w-full">
                    <h3 class="text-white pl-2 ">Insight 1</h3>
                </div>
            </a>
        </div>
        <div class="right-insight grid grid-rows-2 gap-4">
            <a class="insight-item relative" href="#">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/insights/insight-2.jpg" alt="" class="w-full opacity-100 hover:opacity-60 transition-opacity duration-300 ease-out">
                <div class="ins-title absolute bottom-0 left-0 text-2xl bg-[#00000062] p-2 w-full">
                    <h3 class="text-white pl-2 ">Insight 2</h3>
                </div>
            </a>

            <a class="insight-item relative" href="#">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/insights/insight-3.jpg" alt="" class="w-full opacity-100 hover:opacity-60 transition-opacity duration-300 ease-out">
                <div class="ins-title absolute bottom-0 left-0 text-2xl bg-[#00000062] p-2 w-full">
                    <h3 class="text-white pl-2 ">Insight 3</h3>
                </div>
            </a>
        </div>
    </div>
</section>
