<?php get_header(); ?>

<div class="wrapper-single-project container mx-auto px-4 py-16">
    <?php while ( have_posts() ) : the_post(); 
        // Lấy dữ liệu ACF
        $start_date = get_field('project_start_date');
        $end_date   = get_field('project_end_date');
        $people     = get_field('related_people'); // Mảng ID
        $experiences = get_field('related_experience'); // Mảng ID
    ?>

    <article class="project-detail">
        <!-- Tiêu đề & Ngày tháng -->
        <h1 class="text-4xl font-bold mb-4"><?php the_title(); ?></h1>
        <p class="text-gray-500 mb-8 italic">
            <?php 
            if($start_date) echo $start_date; 
            if($end_date) echo ' - ' . $end_date; 
            ?>
        </p>

        <!-- Nội dung chi tiết -->
        <div class="entry-content prose max-w-none mb-12">
            <?php the_content(); ?>
        </div>

        <!-- THÔNG TIN LIÊN QUAN -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-200 pt-8">
            
            <!-- 1. Lĩnh vực (Experience) -->
            <?php if($experiences): ?>
            <div>
                <h3 class="text-xl font-bold mb-4 text-[#125f4b]"><?php pll_e('Lĩnh vực liên quan'); ?></h3>
                <ul class="space-y-2">
                    <?php foreach($experiences as $exp_id): ?>
                        <li>
                            <a href="<?php echo get_permalink($exp_id); ?>" class="hover:text-[#125f4b] flex items-center">
                                <i class="fa-solid fa-check mr-2 text-xs"></i>
                                <?php echo get_the_title($exp_id); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- 2. Người thực hiện (People) -->
            <?php if($people): ?>
            <div>
                <h3 class="text-xl font-bold mb-4 text-[#125f4b]"><?php pll_e('Người phụ trách'); ?></h3>
                <div class="flex flex-col gap-4">
                    <?php foreach($people as $p_id): 
                        // Lấy avatar: Ưu tiên ACF -> Featured Image -> Default
                        $avatar = get_field('anh_dai_dien', $p_id);
                        if(!$avatar) $avatar = get_the_post_thumbnail_url($p_id, 'thumbnail');
                        // Nếu vẫn không có ảnh thì dùng ảnh mặc định (Placeholder)
                        if(!$avatar) $avatar = "https://dummyimage.com/100x100/ccc/fff&text=" . substr(get_the_title($p_id), 0, 1);
                    ?>
                        <a href="<?php echo get_permalink($p_id); ?>" class="flex items-center gap-3 bg-gray-50 p-2 rounded hover:bg-gray-100 transition-colors">
                            <img src="<?php echo esc_url($avatar); ?>" class="w-10 h-10 rounded-full object-cover">
                            <span class="font-medium text-sm"><?php echo get_the_title($p_id); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

    </article>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
