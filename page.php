<?php
/**
 * The template for displaying all pages
 *
 * Đây là template mặc định cho các trang như: Chính sách bảo mật, Điều khoản...
 *
 * @package kailash
 */

get_header();
?>

<div class="wrapper-page bg-white min-h-screen py-16">
    <div class="container mx-auto px-4">
        
        <?php
        while ( have_posts() ) :
            the_post();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <!-- 1. Header Trang -->
                <header class="entry-header mb-12 text-left">
                    <h1 class="text-3xl font-bold text-[#125f4b] mb-6 capitalize">
                        <?php the_title(); ?>
                    </h1>
                    
                    <!-- Breadcrumb (Nếu có hàm này) -->
                    <?php if (function_exists('kailash_breadcrumbs')) : ?>
                        <div class="flex justify-center">
                            <?php kailash_breadcrumbs(); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <!-- 2. Nội dung chi tiết -->
                <!-- Sử dụng class 'prose' của Tailwind để format văn bản tự động (H2, H3, ul, ol...) -->
                <div class="entry-content max-w-4xl mx-auto text-gray-700 leading-relaxed text-justify prose prose-lg prose-headings:text-[#125f4b] prose-a:text-[#125f4b]">
                    <?php
                    the_content();

                    // Phân trang cho nội dung dài (nếu có dùng thẻ <!--nextpage-->)
                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kailash' ),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div>

            </article>

        <?php
        endwhile; 
        ?>

    </div>
</div>

<?php
get_footer();
