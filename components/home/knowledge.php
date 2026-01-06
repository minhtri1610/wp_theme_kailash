<section id="knowledge" class="container mx-auto mt-8 md:mt-[3em] px-4">
    <div class="wapper-knowledge grid grid-cols-1 md:grid-cols-3 gap-y-10 md:gap-8">
        
        <?php
        $base_ids = array(67, 71, 66); 

        foreach ($base_ids as $original_id) :
            
            $translated_id = (function_exists('pll_get_post')) ? pll_get_post($original_id) : $original_id;
            $exp_id = $translated_id ? $translated_id : $original_id;

            $cat_title = get_the_title($exp_id);
            $cat_link  = get_permalink($exp_id);

            $args = array(
                'post_type'      => 'knowledge',
                'posts_per_page' => 5, 
                'post_status'    => 'publish',
                'meta_query'     => array(
                    array(
                        'key'     => 'knowledge_related_experience', 
                        'value'   => '"' . $exp_id . '"', 
                        'compare' => 'LIKE'
                    )
                )
            );
            $knowledge_query = new WP_Query($args);
        ?>

            <div class="kn-items">
                <div class="kn-head flex justify-between items-center mb-4 md:mb-0">
                    <h2 class="text-2xl md:text-3xl font-bold text-black mb-0">
                        <?php echo esc_html($cat_title); ?>
                    </h2>
                </div>
                
                <div class="kn-content">
                    <?php if ($knowledge_query->have_posts()) : ?>
                        <?php while ($knowledge_query->have_posts()) : $knowledge_query->the_post(); 
                            $sub_exps = get_field('knowledge_related_experience');
                        ?>
                            <div class="kn-item flex flex-col border-b border-gray-300 py-3 md:py-4 last:border-0">
                                <a class="text-[#0e0e0e] hover:text-[#125f4b] text-lg md:text-xl font-medium md:font-normal leading-snug" href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                                
                                <?php if($sub_exps): ?>
                                    <div class="kn-list-sub flex flex-wrap mt-1 md:mt-0">
                                        <?php 
                                        foreach($sub_exps as $sub_id): 
                                            if($sub_id == $exp_id) continue; 
                                        ?>
                                            <span class="border rounded-xl outline-1 border-[#125f4b] px-2 py-0.5 md:py-0 my-1 md:my-2 text-xs md:text-sm text-[#125f4b]">
                                                <?php echo get_the_title($sub_id); ?>
                                            </span>
                                        <?php 
                                            break; 
                                        endforeach; 
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <p class="text-[#0e0e0e] text-xs md:text-sm italic mt-1 md:mt-0">
                                    <i class="fa-solid fa-calendar-days text-[#125f4b] mr-1"></i> 
                                    <?php echo get_the_date('Y-m-d'); ?>
                                </p>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm italic py-4">
                            <?php if(function_exists('pll_e')) { pll_e('Chưa có bài viết.'); } else { echo 'Chưa có bài viết.'; } ?>
                        </p>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>

                <div class="kn-footer flex justify-end mt-4 md:mt-3">
                    <a href="<?php echo esc_url($cat_link); ?>" class="text-black text-sm md:text-base hover:text-[#125f4b] transition-colors">
                        View All <i class="fa-solid fa-angles-right ml-1"></i>
                    </a>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
</section>
