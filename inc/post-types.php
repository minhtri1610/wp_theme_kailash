<?php
/**
 * Register Custom Post Types
 */

function register_my_cpts() {
    // 1. CPT Experience (Phân cấp cha/con) -> URL: /dich-vu/
    register_post_type( 'experience', array(
        'labels' => array( 
            'name' => 'Experience', 
            'singular_name' => 'Experience',
            'menu_name' => 'Experience'
        ),
        'public' => true,
        'hierarchical' => true, // QUAN TRỌNG: Cho phép tạo cấp cha/con (Level 1 > Level 2)
        'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt' ),
        'has_archive' => true,
        'rewrite' => array('slug' => _x('experience_slug', 'URL slug', 'kailash'), 'with_front' => false), // Sửa slug thành 'dich-vu'
        'show_in_rest' => true, // Bật Gutenberg Editor (Nên dùng)
        'menu_icon' => 'dashicons-awards',
        'menu_position' => 5,
    ));

    // 2. CPT People (Nhân sự) -> URL: /cong-su/
    register_post_type( 'people', array(
        'labels' => array( 
            'name' => 'People', 
            'singular_name' => 'Person',
            'menu_name' => 'People',
            'add_new' => 'Add Person',
            'add_new_item' => 'Add New Person',
            'edit_item' => 'Edit Person',
            'new_item' => 'New Person',
            'view_item' => 'View Person',
            'search_items' => 'Search People',
            'not_found' => 'No people found',
            'not_found_in_trash' => 'No people found in Trash',
            'all_items' => 'All People',
        ),
        'public' => true,
        'supports' => array( 'title', 'thumbnail', 'excerpt'), 
        'has_archive' => true, // Bật trang lưu trữ
        'rewrite' => array('slug' => _x('people_slug', 'URL slug', 'kailash'), 'with_front' => false), // Sửa slug thành 'cong-su'
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-businessperson',
        'menu_position' => 10,
    ));

    // 3. CPT Knowledge (Kiến thức/Tin tức) -> URL: /kien-thuc/
    register_post_type( 'knowledge', array(
        'labels' => array( 
            'name' => 'Knowledge', 
            'singular_name' => 'Knowledge',
            'menu_name' => 'Knowledge'
        ),
        'public' => true,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'has_archive' => true, // Bật trang lưu trữ
        'rewrite' => array('slug' => _x('knowledge_slug', 'URL slug', 'kailash'), 'with_front' => false), // Sửa slug thành 'kien-thuc'
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-book',
        'menu_position' => 15,
        'taxonomies'  => array( 'post_tag' ), 
    ));

    register_post_type( 'banner', array(
        'labels' => array( 
            'name'          => 'Banner Home', 
            'singular_name' => 'Banner',
            'menu_name'     => 'Banner Home',
            'add_new'       => 'Thêm Slide',
            'add_new_item'  => 'Thêm Slide Mới',
        ),
        'public'        => true, // Không cần đường dẫn riêng cho từng slide
        'publicly_queryable'  => false, // Tắt FALSE để KHÔNG truy cập được qua URL (domain.com/banner/...)
        'exclude_from_search' => true,  // Loại bỏ khỏi kết quả tìm kiếm của web
        'show_in_nav_menus'   => false,
        'show_ui'       => true,  // Hiển thị trong Admin
        'menu_icon'     => 'dashicons-images-alt2', // Icon hình ảnh
        'menu_position' => 4,     // Đưa lên đầu menu cho dễ thấy
        'supports'      => array( 'title', 'thumbnail', 'page-attributes' ), 
        // 'title' -> Tiêu đề lớn
        // 'thumbnail' -> Ảnh nền
        // 'page-attributes' -> Để dùng ô "Order" sắp xếp thứ tự slide
    ));

    register_post_type( 'insight', array(
        'labels' => array( 
            'name'          => 'Banner Insight', 
            'singular_name' => 'Insight',
            'menu_name'     => 'Insight',
            'add_new'       => 'Add Insight',
            'add_new_item'  => 'Add Insight New',
        ),
        'public'              => true,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'show_ui'             => true,
        'menu_icon'           => 'dashicons-visibility', // Icon con mắt
        'menu_position'       => 5,
        'supports'            => array( 'title', 'thumbnail', 'page-attributes' ), 
    ));

    register_post_type( 'recent_work', array(
        'labels' => array( 
            'name' => 'Recent Work', 
            'singular_name' => 'Project', 
            'menu_name' => 'Recent Work',
            'add_new' => 'Add Project',
            'add_new_item' => 'Add New Project'
        ),
        'public' => true,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ), // Editor dùng cho nội dung chi tiết
        'has_archive' => true,
        'rewrite' => array('slug' => _x('projects', 'URL slug', 'kailash'), 'with_front' => false),
        'show_in_rest' => true,
        'menu_position' => 9, // Nằm dưới Knowledge
        'menu_icon' => 'dashicons-portfolio', // Icon cặp hồ sơ
    ));

}
add_action( 'init', 'register_my_cpts' );

// function register_my_cpts() {
//     // 1. CPT Experience (Phân cấp cha/con)
//     // Cấu trúc mong muốn: Experience (Archive) > Level 1 (Parent) > Level 2 (Child)
//     register_post_type( 'experience', array(
//         'labels' => array( 
//             'name' => 'Experience', 
//             'singular_name' => 'Experience',
//             'menu_name' => 'Experience'
//         ),
//         'public' => true,
//         'hierarchical' => true, // QUAN TRỌNG: Cho phép tạo cấp cha/con (Level 1 > Level 2)
//         'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt' ),
//         'has_archive' => true,
//         'rewrite' => array('slug' => 'experience'),
//         'show_in_rest' => true, // Bật Gutenberg Editor (Nên dùng)
//         'menu_icon' => 'dashicons-awards',
//     ));

//     // 2. CPT People (Nhân sự)
//     register_post_type( 'people', array(
//         'labels' => array( 
//             'name' => 'People', 
//             'singular_name' => 'Person',
//             'menu_name' => 'People'
//         ),
//         'public' => true,
//         'supports' => array( 'title', 'thumbnail', 'excerpt', 'editor' ), 
//         'show_in_rest' => true,
//         'menu_icon' => 'dashicons-businessperson',
//     ));

//     // 3. CPT Knowledge (Kiến thức/Tin tức)
//     register_post_type( 'knowledge', array(
//         'labels' => array( 
//             'name' => 'Knowledge', 
//             'singular_name' => 'Knowledge',
//             'menu_name' => 'Knowledge'
//         ),
//         'public' => true,
//         'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
//         'show_in_rest' => true,
//         'menu_icon' => 'dashicons-book',
//     ));
// }
// add_action( 'init', 'register_my_cpts' );

// function register_my_cpts() {
//     // 1. CPT Experience (Phân cấp cha/con)
//     register_post_type( 'experience', array(
//         'labels' => array( 'name' => 'Experience', 'singular_name' => 'Experience' ),
//         'public' => true,
//         'hierarchical' => true, // QUAN TRỌNG: Cho phép cấp cha/con
//         'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt' ),
//         'has_archive' => true,
//         'rewrite' => array('slug' => 'experience'),
//     ));

//     // 2. CPT People (Nhân sự)
//     register_post_type( 'people', array(
//         'labels' => array( 'name' => 'People', 'singular_name' => 'Person' ),
//         'public' => true,
//         'supports' => array( 'title', 'thumbnail', 'excerpt' ), // Không cần hierarchical
//     ));

//     // 3. CPT Knowledge (Kiến thức/Tin tức)
//     register_post_type( 'knowledge', array(
//         'labels' => array( 'name' => 'Knowledge', 'singular_name' => 'Knowledge' ),
//         'public' => true,
//         'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
//     ));
// }
// add_action( 'init', 'register_my_cpts' );

/**
 * Kích hoạt Excerpt (Tóm tắt) cho Page
 */
function kailash_add_excerpt_support_for_page() {
    add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'kailash_add_excerpt_support_for_page' );
