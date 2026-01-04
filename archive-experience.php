<?php
/**
 * Template Name: Archive experience
 *
 * Trang này hiển thị danh sách tất cả "Dịch vụ".
 *
 * @package kailash
 */

get_header(); // Tải file header.php
?>

<div class="wapper-list-experience">
    <div class="container c-list-experience mb-12">
        <div class="head-list-experience">
            <h2 class="text-4xl font-semibold text-black my-[3rem]"><?php pll_e('Kinh nghiệm') ?> </h2>
        </div>

        <div class="content-list-experience">
            <div class="desc-list-member mb-[3rem]">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus saepe quas suscipit commodi voluptates, omnis sit repudiandae sed nobis! Illo, accusamus! Quidem reiciendis totam quas repellendus molestias excepturi vel magnam!
            </div>

            <div class="content-list-experience space-y-16">
                <?php
                // 1. QUERY CẤP 1 (PARENTS)
                $args_parent = array(
                    'post_type'      => 'experience',
                    'posts_per_page' => -1,
                    'post_parent'    => 0, // Chỉ lấy bài cha (Level 1)
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC'
                );
                $parent_query = new WP_Query($args_parent);

                if ($parent_query->have_posts()) :
                    while ($parent_query->have_posts()) : $parent_query->the_post();
                        $parent_id = get_the_ID(); // Lấy ID của cha để tìm con
                        ?>

                        <!-- BLOCK CHO MỖI LEVEL 1 -->
                        <div class="experience-group-block border-b border-gray-200 pb-10 last:border-0 grid grid-cols-3 gap-4">

                            <div class="img-experience col-span-1">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="w-full">
                                        <a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-lg">
                                            <?php the_post_thumbnail('large', ['class' => '!w-full min-h-[240px] object-cover hover:scale-105 transition-transform duration-500']); ?>
                                        </a>
                                    </div>
                                <?php else : ?>
                                    <img class="w-full" src="https://dummyimage.com/380x240/737373/fff&text=380x240px" />
                                <?php endif; ?>
                                
                            </div>

                            <div class="list-experience col-span-2">
                                <!-- Hiển thị thông tin LEVEL 1 -->
                                <div class="level-1-info mb-4">
                                    <h3 class="text-xl font-semibold text-[#aa7d59] mb-4">
                                        <a href="<?php the_permalink(); ?>" class="hover:underline ">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <!-- <div class="text-gray-600 text-lg">
                                        <?php the_excerpt(); ?>
                                    </div> -->
                                </div>

                                <!-- 2. QUERY CẤP 2 (CHILDREN) CỦA CHA HIỆN TẠI -->
                                <?php
                                $args_child = array(
                                    'post_type'      => 'experience',
                                    'posts_per_page' => -1,
                                    'post_parent'    => $parent_id, // Lấy con của Parent ID hiện tại
                                    'orderby'        => 'menu_order',
                                    'order'          => 'ASC'
                                );
                                $child_query = new WP_Query($args_child);
                                
                                if ($child_query->have_posts()) :
                                ?>
                                    <!-- Grid hiển thị LEVEL 2 -->

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <ul class="list_arrow">
                                        <?php while ($child_query->have_posts()) : $child_query->the_post(); ?>
                                            
                                                <li class="pl-3 mb-3"><a href="<?php the_permalink(); ?>" class="hover:text-[#125f4b]"><?php the_title(); ?></a></li>                                            

                                        <?php endwhile; ?>
                                        </ul>
                                    </div>
                                <?php 
                                else:
                                    // Nếu không có con thì có thể để trống hoặc thông báo
                                endif;
                                wp_reset_postdata(); // Quan trọng: Reset query con để không ảnh hưởng query cha
                                ?>
                            </div>
                            
                           

                        </div>
                        <!-- END BLOCK -->

                    <?php
                    endwhile;
                    wp_reset_postdata(); // Reset query cha
                endif;
                ?>
            </div>
        </div>
    </div>

</div>

<?php
get_footer(); // Tải file footer.php
?>
