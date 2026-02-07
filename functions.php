<?php
/**
 * kailash functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kailash
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.6');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kailash_setup()
{
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on kailash, use a find and replace
     * to change 'kailash' to the name of your theme in all the template files.
     */
    load_theme_textdomain('kailash', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'primary_menu' => esc_html__('Primary', 'kailash'),
            'lang_menu' => esc_html__('Language Menu', 'kailash'),
            'footer_menu' => esc_html__('Footer Menu', 'kailash'),
        )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    // add_theme_support(
    // 	'custom-background',
    // 	apply_filters(
    // 		'kailash_custom_background_args',
    // 		array(
    // 			'default-color' => 'ffffff',
    // 			'default-image' => '',
    // 		)
    // 	)
    // 	);

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'kailash_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kailash_content_width()
{
    $GLOBALS['content_width'] = apply_filters('kailash_content_width', 640);
}
add_action('after_setup_theme', 'kailash_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kailash_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'kailash'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here.', 'kailash'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}
add_action('widgets_init', 'kailash_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function kailash_scripts()
{
    wp_enqueue_style('kailash-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('kailash-style', 'rtl', 'replace');

    wp_enqueue_style('kailash-tailwind', get_template_directory_uri() . '/style.css', array('kailash-style'), '1.0.6');

    wp_enqueue_script('kailash-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
    wp_enqueue_script('menu-js', get_template_directory_uri() . '/assets/js/menu.js', [], false, true);

    wp_enqueue_style(
        'my-homepage-style', // Tên định danh (handle) duy nhất
        get_template_directory_uri() . '/assets/css/home.css', // Đường dẫn tới file
        array(), // Các file CSS phụ thuộc (nếu có)
        '1.0.6' // Phiên bản (tốt cho cache)
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'kailash_scripts');

function add_tailwind_classes_to_a($atts, $item, $args)
{
    // Chỉ áp dụng cho menu có theme_location là 'lang_menu'
    if ('primary_menu' === $args->theme_location) {
        $atts['class'] = 'text-[1.3rem] py-0 px-4 hover:text-[#00a174]';

        // Style riêng cho item active
        if ($item->current) {
            $atts['class'] .= ' font-bold text-[#05654a]'; // Thêm class nếu là trang hiện tại
        }
    }

    if ('footer_menu' === $args->theme_location) {
        $atts['class'] = 'text-[1.3rem] text-white hover:text-[#00a174]';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_tailwind_classes_to_a', 10, 3);


function my_remove_admin_menus()
{
    // --- Các menu mặc định của WordPress ---

    // remove_menu_page( 'index.php' );                  // Dashboard (Bảng tin)
    remove_menu_page('edit.php');                   // Posts (Bài viết)
    remove_menu_page('upload.php');                 // Media (Thư viện)
    // remove_menu_page( 'edit.php?post_type=page' );    // Pages (Trang)
    remove_menu_page('edit-comments.php');          // Comments (Bình luận) - Thường ẩn cái này

    // remove_menu_page( 'themes.php' );                 // Appearance (Giao diện)
    // remove_menu_page( 'plugins.php' );                // Plugins (Gói mở rộng)
    // remove_menu_page( 'users.php' );                  // Users (Thành viên)
    // remove_menu_page( 'tools.php' );                  // Tools (Công cụ)
    // remove_menu_page( 'options-general.php' );        // Settings (Cài đặt)

    // --- Ví dụ ẩn Plugin (xem cách lấy slug ở mục 3 bên dưới) ---
    // remove_menu_page( 'wpcf7' );                      // Contact Form 7
    remove_menu_page('woocommerce');                // WooCommerce
}
add_action('admin_menu', 'my_remove_admin_menus');



/**
 * 1. Đổi Logo trang Login
 */
function my_custom_login_logo()
{
    // Đường dẫn đến file logo của bạn.
    // Ví dụ: theme-cua-ban/assets/images/logo-login.png
    $logo_url = get_stylesheet_directory_uri() . '/assets/images/logo-green.png';
    ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url(<?php echo $logo_url; ?>);
            /* WordPress mặc định kích thước logo là 84x84px. 
                   Nếu logo bạn là hình chữ nhật ngang, hãy chỉnh lại height/width và background-size bên dưới */
            height: 100px;
            /* Chiều cao logo */
            width: 320px;
            /* Chiều rộng tối đa của khung login */
            background-size: contain;
            /* Co dãn ảnh cho vừa khung */
            background-repeat: no-repeat;
            background-position: center;
            padding-bottom: 30px;
        }
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'my_custom_login_logo');

/**
 * Hook tùy chỉnh sắp xếp: Có số hiện trước (Tăng dần), Null/Rỗng hiện sau
 */
add_filter('posts_clauses', 'kailash_advanced_sort_logic', 10, 2);

function kailash_advanced_sort_logic($clauses, $query)
{
    // 1. Chỉ chạy khi có tham số 'kailash_custom_sort'
    if (!$query->get('kailash_custom_sort')) {
        return $clauses;
    }

    global $wpdb;

    // 2. Tìm Alias (Tên bảng phụ) của meta_key 'sap_xep'
    // WordPress thường đặt tên là mt1, mt2... Đoạn này dùng Regex để tìm chính xác bảng nào join với key 'sap_xep'
    preg_match('/(\w+)\.meta_key\s*=\s*[\'"]sap_xep[\'"]/', $clauses['join'], $matches);

    $alias = isset($matches[1]) ? $matches[1] : false;

    // Nếu tìm thấy bảng meta (Tức là query có join bảng postmeta)
    if ($alias) {
        // 3. Viết lại câu lệnh ORDER BY

        // Logic SQL:
        // - CASE WHEN: Nếu giá trị NULL hoặc Rỗng ('') -> Gán là 1. Nếu có số -> Gán là 0.
        // - Sort ASC cái nhóm trên: Nhóm 0 (Có số) sẽ lên đầu. Nhóm 1 (Rỗng) xuống cuối.
        // - Sau đó sort tiếp giá trị số (meta_value+0) ASC.
        // - Cuối cùng sort theo ngày đăng (post_date) DESC cho đẹp.

        $clauses['orderby'] = " 
            CASE 
                WHEN {$alias}.meta_value IS NULL THEN 1 
                WHEN {$alias}.meta_value = '' THEN 1 
                ELSE 0 
            END ASC, 
            ({$alias}.meta_value+0) ASC, 
            {$wpdb->posts}.post_date DESC
        ";
    }

    return $clauses;
}

/**
 * Hook sắp xếp theo Position: Co-founder > Partner > Advisor
 */
add_filter('posts_clauses', 'kailash_sort_people_by_position', 20, 2);
function kailash_sort_people_by_position($clauses, $query)
{
    if (!$query->get('kailash_sort_by_position')) {
        return $clauses;
    }

    global $wpdb;

    // Join bảng postmeta để lấy position
    $clauses['join'] .= " LEFT JOIN {$wpdb->postmeta} AS pm_pos ON ({$wpdb->posts}.ID = pm_pos.post_id AND pm_pos.meta_key = 'position') ";

    // Logic: Co-founder (1) > Partner (2) > Advisor (3) > Khác (4)
    $clauses['orderby'] = "
        CASE 
            WHEN pm_pos.meta_value LIKE '%Co-founder%' THEN 1
            WHEN pm_pos.meta_value LIKE '%Partner%' THEN 2
            WHEN pm_pos.meta_value LIKE '%Advisor%' THEN 3
            ELSE 4
        END ASC,
        {$wpdb->posts}.menu_order ASC, 
        {$wpdb->posts}.post_date DESC
    ";

    return $clauses;
}

/**
 * 2. Đổi Link khi click vào Logo (Trỏ về trang chủ thay vì WordPress.org)
 */
function my_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'my_login_logo_url');

/**
 * 3. Đổi dòng chữ Title khi di chuột vào Logo (Thay vì "Powered by WordPress")
 */
function my_login_logo_url_title()
{
    return get_bloginfo('name');
}
add_filter('login_headertext', 'my_login_logo_url_title');

function kailash_change_posts_per_page($query)
{
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('people')) {
        $query->set('posts_per_page', 12);
    }
}
add_action('pre_get_posts', 'kailash_change_posts_per_page');

/**
 * Thêm Meta Box: Banner Link & Button Text
 */
function kailash_add_banner_meta_boxes()
{
    add_meta_box(
        'banner_options',      // ID
        'Thông tin Banner',    // Title
        'kailash_banner_callback', // Callback function
        'banner',              // Post type
        'normal',              // Context
        'high'                 // Priority
    );
}
add_action('add_meta_boxes', 'kailash_add_banner_meta_boxes');

// Hiển thị form nhập liệu
function kailash_banner_callback($post)
{
    // Lấy giá trị đã lưu
    $banner_link = get_post_meta($post->ID, '_banner_link', true);
    $btn_text = get_post_meta($post->ID, '_banner_btn_text', true);

    // Nonce field để bảo mật
    wp_nonce_field('kailash_save_banner_data', 'kailash_banner_nonce');
    ?>
    <p>
        <label for="banner_link" style="font-weight:bold; display:block; margin-bottom:5px;">Link liên kết:</label>
        <input type="url" id="banner_link" name="banner_link" value="<?php echo esc_attr($banner_link); ?>"
            class="widefat" placeholder="https://...">
    </p>
    <p>
        <label for="banner_btn_text" style="font-weight:bold; display:block; margin-bottom:5px; margin-top:15px;">Chữ trên
            nút (Mặc định: View More):</label>
        <input type="text" id="banner_btn_text" name="banner_btn_text" value="<?php echo esc_attr($btn_text); ?>"
            class="widefat" placeholder="Ví dụ: Xem ngay">
    </p>
    <?php
}

// Lưu dữ liệu
function kailash_save_banner_meta($post_id)
{
    if (!isset($_POST['kailash_banner_nonce']) || !wp_verify_nonce($_POST['kailash_banner_nonce'], 'kailash_save_banner_data'))
        return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!current_user_can('edit_post', $post_id))
        return;

    if (isset($_POST['banner_link'])) {
        update_post_meta($post_id, '_banner_link', sanitize_text_field($_POST['banner_link']));
    }
    if (isset($_POST['banner_btn_text'])) {
        update_post_meta($post_id, '_banner_btn_text', sanitize_text_field($_POST['banner_btn_text']));
    }
}
add_action('save_post', 'kailash_save_banner_meta');

function kailash_add_insight_meta_boxes()
{
    add_meta_box(
        'insight_options',
        'Link liên kết',
        'kailash_insight_callback',
        'insight',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kailash_add_insight_meta_boxes');

function kailash_insight_callback($post)
{
    $link = get_post_meta($post->ID, '_insight_link', true);
    wp_nonce_field('save_insight_meta', 'insight_nonce');
    ?>
    <p>
        <label for="insight_link" style="font-weight:bold;">Đường dẫn (URL):</label>
        <input type="url" id="insight_link" name="insight_link" value="<?php echo esc_attr($link); ?>" class="widefat"
            placeholder="https://...">
    </p>
    <?php
}

function kailash_save_insight_meta($post_id)
{
    if (!isset($_POST['insight_nonce']) || !wp_verify_nonce($_POST['insight_nonce'], 'save_insight_meta'))
        return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (isset($_POST['insight_link'])) {
        update_post_meta($post_id, '_insight_link', sanitize_text_field($_POST['insight_link']));
    }
}
add_action('save_post', 'kailash_save_insight_meta');

/**
 * Tạo Role "Knowledge Editor" và phân quyền
 * Chạy 1 lần khi khởi tạo theme
 */
function kailash_add_custom_roles()
{

    // 1. Giữ lại Role "Knowledge Editor" nếu cần dùng
    // (Xóa và tạo lại để đảm bảo cập nhật quyền mới nhất nếu có thay đổi)
    remove_role('knowledge_editor');
    add_role('knowledge_editor', 'Editor guest', array(
        'read' => true,
        'upload_files' => true,
    ));

    // 2. Lấy danh sách TẤT CẢ các role hiện có trên hệ thống
    global $wp_roles;
    if (!isset($wp_roles)) {
        $wp_roles = new WP_Roles();
    }
    $all_roles = $wp_roles->get_names();

    // 3. Phân quyền cho từng role
    foreach ($all_roles as $role_key => $role_name) {
        $role_obj = get_role($role_key);
        if (!$role_obj)
            continue;

        // --- Cấp quyền CƠ BẢN cho TẤT CẢ user (để ai cũng thấy menu và đăng bài được) ---
        $role_obj->add_cap('read'); // Đảm bảo quyền đọc
        $role_obj->add_cap('upload_files'); // Cho phép upload ảnh

        // Quyền liên quan đến Knowledge
        $role_obj->add_cap('edit_knowledges');           // Thấy menu "Knowledge", tạo bài mới
        $role_obj->add_cap('publish_knowledges');        // Đăng bài trực tiếp (không cần duyệt)
        $role_obj->add_cap('edit_published_knowledges'); // Sửa bài đã đăng (của chính mình)
        $role_obj->add_cap('delete_knowledges');         // Xóa bài (của chính mình)
        $role_obj->add_cap('delete_published_knowledges'); // Xóa bài đã đăng (của chính mình - cần thiết để 'move to trash')

        // --- Cấp quyền QUẢN LÝ (Full quyền) cho các role cao cấp ---
        // Bao gồm: Administrator, Editor, và role custom Knowledge Editor
        if (in_array($role_key, array('administrator', 'editor', 'knowledge_editor'))) {
            $role_obj->add_cap('edit_others_knowledges');      // Sửa bài người khác
            $role_obj->add_cap('delete_others_knowledges');    // Xóa bài người khác
            $role_obj->add_cap('read_private_knowledges');     // Đọc bài riêng tư
            //$role_obj->add_cap( 'delete_published_knowledges' ); // Đã add ở trên
        }
    }
}
// Hook vào 'admin_init' để chạy lệnh này
add_action('admin_init', 'kailash_add_custom_roles');

/**
 * Implement the Custom Header feature.
 */
// require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
// if ( defined( 'JETPACK__VERSION' ) ) {
// 	require get_template_directory() . '/inc/jetpack.php';
// }

require get_template_directory() . '/inc/post-types.php';

/**
 * Tải các hàm tùy chỉnh của Polylang.
 */
require get_template_directory() . '/inc/polylang.php';

// breadcrum
require get_template_directory() . '/inc/breadcrumb.php';
