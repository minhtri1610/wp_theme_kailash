<?php
/**
 * kailash functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kailash
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kailash_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on kailash, use a find and replace
		* to change 'kailash' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'kailash', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary_menu' => esc_html__( 'Primary', 'kailash' ),
			'lang_menu' => esc_html__( 'Language Menu', 'kailash' ),
			'footer_menu'  => esc_html__( 'Footer Menu', 'kailash' ),
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
	// );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'kailash_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kailash_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'kailash_content_width', 640 );
}
add_action( 'after_setup_theme', 'kailash_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kailash_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'kailash' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'kailash' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'kailash_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function kailash_scripts() {
	wp_enqueue_style( 'kailash-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'kailash-style', 'rtl', 'replace' );

	wp_enqueue_style( 'kailash-tailwind', get_template_directory_uri() . '/style.css', array('kailash-style'), '1.0.0' );

	wp_enqueue_script( 'kailash-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
    wp_enqueue_script('menu-js', get_template_directory_uri() . '/assets/js/menu.js', [], false, true);

	wp_enqueue_style(
		'my-homepage-style', // Tên định danh (handle) duy nhất
		get_template_directory_uri() . '/assets/css/home.css', // Đường dẫn tới file
		array(), // Các file CSS phụ thuộc (nếu có)
		'1.0.0' // Phiên bản (tốt cho cache)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'kailash_scripts' );

function add_tailwind_classes_to_a($atts, $item, $args) {
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


function my_remove_admin_menus() {
    // --- Các menu mặc định của WordPress ---
    
    // remove_menu_page( 'index.php' );                  // Dashboard (Bảng tin)
    remove_menu_page( 'edit.php' );                   // Posts (Bài viết)
    remove_menu_page( 'upload.php' );                 // Media (Thư viện)
    // remove_menu_page( 'edit.php?post_type=page' );    // Pages (Trang)
    remove_menu_page( 'edit-comments.php' );          // Comments (Bình luận) - Thường ẩn cái này
    
    // remove_menu_page( 'themes.php' );                 // Appearance (Giao diện)
    // remove_menu_page( 'plugins.php' );                // Plugins (Gói mở rộng)
    // remove_menu_page( 'users.php' );                  // Users (Thành viên)
    // remove_menu_page( 'tools.php' );                  // Tools (Công cụ)
    // remove_menu_page( 'options-general.php' );        // Settings (Cài đặt)
    
    // --- Ví dụ ẩn Plugin (xem cách lấy slug ở mục 3 bên dưới) ---
    // remove_menu_page( 'wpcf7' );                      // Contact Form 7
    remove_menu_page( 'woocommerce' );                // WooCommerce
}
add_action( 'admin_menu', 'my_remove_admin_menus' );



/**
 * 1. Đổi Logo trang Login
 */
function my_custom_login_logo() {
    // Đường dẫn đến file logo của bạn.
    // Ví dụ: theme-cua-ban/assets/images/logo-login.png
    $logo_url = get_stylesheet_directory_uri() . '/assets/images/logo-green.png'; 
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo $logo_url; ?>);
            /* WordPress mặc định kích thước logo là 84x84px. 
               Nếu logo bạn là hình chữ nhật ngang, hãy chỉnh lại height/width và background-size bên dưới */
            height: 100px; /* Chiều cao logo */
            width: 320px;  /* Chiều rộng tối đa của khung login */
            background-size: contain; /* Co dãn ảnh cho vừa khung */
            background-repeat: no-repeat;
            background-position: center;
            padding-bottom: 30px;
        }
    </style>
    <?php
}
add_action( 'login_enqueue_scripts', 'my_custom_login_logo' );

/**
 * Hook xử lý sắp xếp: Đưa giá trị NULL xuống cuối khi sort ASC
 */
add_filter( 'posts_orderby', 'kailash_sort_nulls_last', 10, 2 );

function kailash_sort_nulls_last( $orderby, $query ) {
    // 1. Chỉ chạy nếu có tham số 'sort_nulls_last' trong args
    if ( ! $query->get( 'sort_nulls_last' ) ) {
        return $orderby;
    }

    // 2. Lấy thông tin các mệnh đề meta_query
    // Để tìm xem bảng chứa 'sap_xep' (clause_co_gia_tri) đang có tên alias là gì (ví dụ mt1, mt2...)
    $clauses = $query->meta_query->get_clauses();

    // Tìm alias của mệnh đề 'clause_co_gia_tri'
    if ( isset( $clauses['clause_co_gia_tri']['alias'] ) ) {
        $alias = $clauses['clause_co_gia_tri']['alias'];

        // 3. Chèn logic SQL: "Nếu NULL thì tính là 1, có giá trị thì tính là 0"
        // Khi sort ASC: 0 sẽ đứng trước 1 -> Tức là CÓ GIÁ TRỊ đứng trước NULL
        $custom_sql = "CASE WHEN {$alias}.meta_value IS NULL THEN 1 ELSE 0 END, ";
        
        // Nối vào chuỗi orderby mặc định
        return $custom_sql . $orderby;
    }

    return $orderby;
}

/**
 * 2. Đổi Link khi click vào Logo (Trỏ về trang chủ thay vì WordPress.org)
 */
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

/**
 * 3. Đổi dòng chữ Title khi di chuột vào Logo (Thay vì "Powered by WordPress")
 */
function my_login_logo_url_title() {
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );

function kailash_change_posts_per_page( $query ) {
    if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'people' ) ) {
        $query->set( 'posts_per_page', 12 );
    }
}
add_action( 'pre_get_posts', 'kailash_change_posts_per_page' );

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
