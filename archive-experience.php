<?php
/**
 * Template Name: Archive experience
 *
 * Responsive Optimized by Coder WP
 * @package kailash
 */

get_header();
?>

<div class="wapper-list-experience px-4 md:px-0">
    <div class="container mx-auto c-list-experience mb-12">

        <div class="head-list-experience">
            <h2 class="text-3xl md:text-4xl font-semibold text-black my-8 md:my-[3rem]"><?php pll_e('Kinh nghiệm') ?>
            </h2>
        </div>

        <div class="content-list-experience">
            <div class="desc-list-member mb-8 md:mb-[3rem] text-base text-justify md:text-left">
                <?php
                $current_page_id = get_queried_object_id();
                $content = get_post_field('post_content', $current_page_id);
                echo apply_filters('the_content', $content);
                ?>
            </div>

            <div class="content-list-experience space-y-10 md:space-y-16">
                <?php
                // 1. QUERY CẤP 1 (PARENTS) - GIỮ NGUYÊN LOGIC
                $args_parent = array(
                    'post_type' => 'experience',
                    'posts_per_page' => -1,
                    'post_parent' => 0,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'language',
                            'field' => 'slug',
                            'terms' => pll_current_language(),
                        ),
                    ),
                );
                $parent_query = new WP_Query($args_parent);

                if ($parent_query->have_posts()):
                    while ($parent_query->have_posts()):
                        $parent_query->the_post();
                        $parent_id = get_the_ID();
                        ?>

                        <div
                            class="experience-group-block border-b border-gray-200 pb-10 last:border-0 grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">

                            <div class="img-experience col-span-1">
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="w-full">
                                        <a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-lg shadow-sm">
                                            <?php the_post_thumbnail('large', ['class' => '!w-full h-[240px] md:min-h-[240px] object-cover hover:scale-105 transition-transform duration-500']); ?>
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <img class="w-full h-[240px] object-cover rounded-lg"
                                        src="https://dummyimage.com/380x240/737373/fff&text=Kailash" />
                                <?php endif; ?>
                            </div>

                            <div class="list-experience col-span-1 lg:col-span-2">

                                <div class="level-1-info mb-4">
                                    <h3 class="text-xl md:text-2xl font-bold text-[#aa7d59] mb-3">
                                        <a href="<?php the_permalink(); ?>"
                                            class="hover:underline hover:text-[#125f4b] transition-colors">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                </div>

                                <?php
                                $args_child = array(
                                    'post_type' => 'experience',
                                    'posts_per_page' => -1,
                                    'post_parent' => $parent_id,
                                    'orderby' => 'menu_order',
                                    'order' => 'ASC',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'language',
                                            'field' => 'slug',
                                            'terms' => pll_current_language(),
                                        ),
                                    ),
                                );

                                $child_query = new WP_Query($args_child);

                                if ($child_query->have_posts()):
                                    ?>
                                    <ul class="list_arrow grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                                        <?php while ($child_query->have_posts()):
                                            $child_query->the_post(); ?>

                                            <li class="pl-0 mb-1">
                                                <a href="<?php the_permalink(); ?>"
                                                    class="block py-1 text-gray-700 hover:text-[#125f4b] hover:translate-x-1 transition-transform duration-300 relative pl-4">
                                                    <?php the_title(); ?>
                                                </a>
                                            </li>

                                        <?php endwhile; ?>
                                    </ul>
                                    <?php
                                endif;
                                wp_reset_postdata();
                                ?>
                            </div>

                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>