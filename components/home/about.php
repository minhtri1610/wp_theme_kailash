<section class="relative overflow-hidden mb-[5rem]" id="about">
    <div class="inner-about flex flex-wrap justify-between items-center px-[40px] h-[730px] pt-[8.5em]">
        <div class="content-about grid grid-cols-2 gap-4 container">
            <div class="text-about ml-[2rem]">
                <h2><a href="" class="text-4xl font-bold text-white"><?php pll_e('Giới thiệu'); ?></a></h2>
                <p class="text-white">Our fundamental mission is to realize
                an affluent and fair society based on the rule of law.
                    Committed to "Leading You Forward", we aim
                    to contribute to the growth of our clients and our society.</p>
            </div>
            <div class="view-about view-white flex justify-end items-end mr-[0rem] link">
                <a href="" class=""><?php pll_e('Giới thiệu'); ?></a>
            </div>
        </div>
        
        <div class="img-about">
            <img class="w-full h-auto left-[calc((100%_-_1208px)_/_2)] absolute top-0 z-[-1]" src="<?php echo get_template_directory_uri(); ?>/assets/images/home/about/about_us_pc.jpg" alt="">
        </div>
    </div>

    <div class="list-about container">
        <div class="grid grid-cols-3 gap-3 ">
            <a href="" class="col-span-1 -ml-[12px] group">
                <div class="item-message relative 
                after:content-[''] 
                after:absolute 
                after:inset-0 
                after:bg-white/50 
                after:opacity-0 
                after:transition-all 
                after:duration-300 
                group-hover:after:opacity-100">
                    <img class="w-full block h-[270px] object-cover" src="<?php echo get_template_directory_uri(); ?>/assets/images/home/about/about_us01.jpg" alt="">
                    <p class="absolute bottom-0 left-0 px-3 py-4 text-white bg-[#00000075] w-full">Message from the Managing Partner</p>
                </div>
            </a>

            <a href="" class="col-span-1 group">
                <div class="item-message relative
                after:content-[''] 
                after:absolute 
                after:inset-0 
                after:bg-white/50 
                after:opacity-0 
                after:transition-all 
                after:duration-300 
                group-hover:after:opacity-100">
                    <img class="w-full block h-[270px] object-cover" src="<?php echo get_template_directory_uri(); ?>/assets/images/home/about/about_us02.jpg" alt="">
                    <p class="absolute bottom-0 left-0 px-3 py-4 text-white bg-[#00000075] w-full">Diversity, Equity & Inclusion​</p>
                </div>
            </a>

            <a href="" class="col-span-1 group">
                <div class="item-message relative
                after:content-[''] 
                after:absolute 
                after:inset-0 
                after:bg-white/50 
                after:opacity-0 
                after:transition-all 
                after:duration-300 
                group-hover:after:opacity-100">
                    <img class="w-full block h-[270px] object-cover" src="<?php echo get_template_directory_uri(); ?>/assets/images/home/about/about_us03.jpg" alt="">
                    <p class="absolute bottom-0 left-0 px-3 py-4 text-white bg-[#00000075] w-full">Responsible Business​</p>
                </div>
            </a>
        </div>
    </div>
</section>
