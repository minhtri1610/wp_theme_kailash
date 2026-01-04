<?php
/**
 * Custom Breadcrumbs Function for Kailash Theme
 * * Hướng dẫn sử dụng:
 * 1. Include file này vào functions.php: require get_template_directory() . '/inc/breadcrumbs.php';
 * 2. Gọi hàm kailash_breadcrumbs() ở bất kỳ file template nào.
 */

function kailash_breadcrumbs() {
    
    // Config Style (Tailwind CSS)
    $wrapper_class = 'breadcrumb text-sm text-gray-500 mb-6 flex items-center flex-wrap';
    $link_class    = 'hover:text-[#125f4b] transition-colors';
    $current_class = 'text-gray-900 font-medium';
    $separator     = '<span class="mx-2 text-gray-400">/</span>';
    $home_text     = function_exists('pll_e') ? pll__('Trang chủ') : 'Trang chủ';

    // Không hiển thị trên trang chủ
    if ( is_front_page() || is_home() ) {
        return;
    }

    echo '<div class="' . esc_attr($wrapper_class) . '">';

    // 1. Link Trang chủ
    echo '<a href="' . esc_url(home_url('/')) . '" class="' . esc_attr($link_class) . '">' . $home_text . '</a>';
    echo $separator;

    // 2. Xử lý cho Custom Post Types (Experience, People, Knowledge)
    if ( is_singular('experience') || is_singular('people') || is_singular('knowledge') ) {
        
        // Lấy Post Type Object để lấy tên và Link Archive
        $post_type_obj = get_post_type_object( get_post_type() );
        $archive_link  = get_post_type_archive_link( get_post_type() );
        
        // Hiển thị Link đến trang Archive (Ví dụ: Dịch vụ, Cộng sự...)
        if ( $archive_link ) {
            // Fix tên hiển thị cho đa ngôn ngữ nếu cần, hoặc lấy mặc định
            $archive_title = $post_type_obj->labels->menu_name; 
            // Nếu muốn custom tên cụ thể cho Experience
            if(get_post_type() == 'experience') $archive_title = function_exists('pll__') ? pll__('Kinh Nghiệm') : 'Kinh Nghiệm';

            if(get_post_type() == 'knowledge') $archive_title = function_exists('pll__') ? pll__('Ấn Phẩm') : 'Ấn Phẩm';
            
            echo '<a href="' . esc_url($archive_link) . '" class="' . esc_attr($link_class) . '">' . esc_html($archive_title) . '</a>';
            echo $separator;
        }

        // Xử lý trang con (Hierarchical - VD: Experience Level 2)
        global $post;
        if ( $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $parent_link = get_permalink($parent_id);
            $parent_title = get_the_title($parent_id);

            // Nếu có nhiều cấp cha, có thể dùng get_post_ancestors() để lặp, ở đây xử lý 1 cấp cha
            echo '<a href="' . esc_url($parent_link) . '" class="' . esc_attr($link_class) . '">' . esc_html($parent_title) . '</a>';
            echo $separator;
        }

        // Hiển thị tên bài viết hiện tại
        echo '<span class="' . esc_attr($current_class) . '">' . get_the_title() . '</span>';

    } 
    // 3. Xử lý cho Page (Hierarchical)
    elseif ( is_page() ) {
        global $post;
        if ( $post->post_parent ) {
            $anc = get_post_ancestors( $post->ID );
            $anc = array_reverse($anc);
            foreach ( $anc as $ancestor ) {
                echo '<a href="' . esc_url(get_permalink($ancestor)) . '" class="' . esc_attr($link_class) . '">' . get_the_title($ancestor) . '</a>';
                echo $separator;
            }
        }
        echo '<span class="' . esc_attr($current_class) . '">' . get_the_title() . '</span>';
    }
    // 4. Xử lý cho Bài viết thường (Post)
    elseif ( is_single() ) {
        $categories = get_the_category();
        if ( $categories ) {
            $cat = $categories[0];
            echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '" class="' . esc_attr($link_class) . '">' . esc_html($cat->name) . '</a>';
            echo $separator;
        }
        echo '<span class="' . esc_attr($current_class) . '">' . get_the_title() . '</span>';
    }
    // 5. Xử lý trang Lưu trữ (Archive)
    elseif ( is_post_type_archive() ) {
         echo '<span class="' . esc_attr($current_class) . '">' . post_type_archive_title('', false) . '</span>';
    }
    // 6. Trang tìm kiếm
    elseif ( is_search() ) {
        echo '<span class="' . esc_attr($current_class) . '">Search: ' . get_search_query() . '</span>';
    }
    // 7. Trang 404
    elseif ( is_404() ) {
        echo '<span class="' . esc_attr($current_class) . '">Error 404</span>';
    }

    echo '</div>';
}
