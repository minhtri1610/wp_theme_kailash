<section class="relative overflow-hidden mb-10 md:mb-[5rem]" id="about">
    
    <div class="inner-about flex flex-wrap justify-between items-center px-4 md:px-[40px] h-auto md:h-[730px] pt-20 md:pt-[8.5em] pb-10 md:pb-0 relative">
        
        <div class="content-about grid grid-cols-1 md:grid-cols-2 gap-4 container relative z-10 mx-auto">
            
            <div class="text-about ml-0 md:ml-[2rem] text-center md:text-left mb-6 md:mb-0">
                <h2><a href="" class="text-3xl md:text-4xl font-bold text-white mb-4 block"><?php pll_e('Giới thiệu'); ?></a></h2>
                <p class="text-white text-base md:text-lg leading-relaxed">
                    Our fundamental mission is to realize an affluent and fair society based on the rule of law.
                    Committed to "Leading You Forward", we aim to contribute to the growth of our clients and our society.
                </p>
            </div>

            <div class="view-about view-white flex justify-center md:justify-end items-end mr-0 md:mr-[0rem] link">
                <a href="<?php echo site_url('/ve-chung-toi'); ?>" class="text-white border-b border-white pb-1 hover:text-gray-200 transition-colors">
                    <?php pll_e('Xem chi tiết'); ?>
                </a>
            </div>
        </div>
        
        <div class="img-about absolute top-0 left-0 w-full h-full z-0 pointer-events-none">
            <img class="w-full h-full object-cover lg:w-auto lg:h-auto lg:left-[calc((100%_-_1208px)_/_2)] absolute top-0 z-[-1]" 
                 src="<?php echo get_template_directory_uri(); ?>/assets/images/home/about/about_us_pc.jpg" 
                 alt="">
            
            <div class="absolute inset-0 bg-black/40 lg:bg-transparent z-[-1]"></div>
        </div>
    </div>

    <div class="list-about container mx-auto -mt-10 md:mt-0 relative z-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-3">
            
            <a href="<?php echo site_url('/ve-chung-toi'); ?>" class="col-span-1 ml-0 md:-ml-[12px] group overflow-hidden rounded-lg md:rounded-none">
                <div class="item-message relative h-full
                after:content-[''] after:absolute after:inset-0 after:bg-white/20 after:opacity-0 after:transition-all after:duration-300 group-hover:after:opacity-100">
                    <img class="w-full block h-[200px] md:h-[270px] object-cover transition-transform duration-500 group-hover:scale-105" src="<?php echo get_template_directory_uri(); ?>/assets/images/home/about/about_us01.jpg" alt="">
                    <p class="absolute bottom-0 left-0 px-3 py-4 text-white bg-[#00000075] w-full text-sm md:text-base font-medium backdrop-blur-sm">
                        Message from the Managing Partner
                    </p>
                </div>
            </a>

            <a href="<?php echo site_url('/ve-chung-toi'); ?>" class="col-span-1 group overflow-hidden rounded-lg md:rounded-none">
                <div class="item-message relative h-full
                after:content-[''] after:absolute after:inset-0 after:bg-white/20 after:opacity-0 after:transition-all after:duration-300 group-hover:after:opacity-100">
                    <img class="w-full block h-[200px] md:h-[270px] object-cover transition-transform duration-500 group-hover:scale-105" src="<?php echo get_template_directory_uri(); ?>/assets/images/home/about/about_us02.jpg" alt="">
                    <p class="absolute bottom-0 left-0 px-3 py-4 text-white bg-[#00000075] w-full text-sm md:text-base font-medium backdrop-blur-sm">
                        Diversity, Equity & Inclusion​
                    </p>
                </div>
            </a>

            <a href="<?php echo site_url('/ve-chung-toi'); ?>" class="col-span-1 group overflow-hidden rounded-lg md:rounded-none">
                <div class="item-message relative h-full
                after:content-[''] after:absolute after:inset-0 after:bg-white/20 after:opacity-0 after:transition-all after:duration-300 group-hover:after:opacity-100">
                    <img class="w-full block h-[200px] md:h-[270px] object-cover transition-transform duration-500 group-hover:scale-105" src="<?php echo get_template_directory_uri(); ?>/assets/images/home/about/about_us03.jpg" alt="">
                    <p class="absolute bottom-0 left-0 px-3 py-4 text-white bg-[#00000075] w-full text-sm md:text-base font-medium backdrop-blur-sm">
                        Responsible Business​
                    </p>
                </div>
            </a>

        </div>
    </div>
</section>
