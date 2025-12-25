<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kailash
 */

$settings_page = get_page_by_path('theme-settings');
$option_id = $settings_page ? $settings_page->ID : false;
if (!$option_id) $option_id = get_option('page_on_front'); // Fallback

// Lấy ngôn ngữ hiện tại
$lang = function_exists('pll_current_language') ? pll_current_language() : 'vi';

// Lấy dữ liệu Text (Có dịch)
$company_name    = get_field('company_name_' . $lang, $option_id);
$tax_id          = get_field('tax_id', $option_id); // MST thường không đổi
$company_address = get_field('company_address_' . $lang, $option_id);

// Fallback
if (!$company_name)    $company_name = get_field('company_name', $option_id);
if (!$company_address) $company_address = get_field('company_address', $option_id);

// Lấy dữ liệu Số/Link (Dùng chung)
$company_phone   = get_field('company_phone', $option_id);
$company_email   = get_field('company_email', $option_id);
$social_facebook = get_field('social_facebook', $option_id);
$social_linkedin = get_field('link_linkedin', $option_id);

?>
<!doctype html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/icons/favicon-32x32.png" type="image/x-icon">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"/>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">

	<header id="masthead" class="site-header sticky top-0 z-50 w-full">
		<!-- pc nav -->
		<nav class="bg-white border-b border-gray-200 hidden sm:flex flex-row" id="menu-pc">
			<div class="logo basis-1/6 flex justify-center items-center">
				<a href="<?php echo home_url(); ?>">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-crop.png" alt="" class="w-[170px] mt-[25px]">
				</a>
			</div>
			<div class="menu basis-4/6 flex items-center justify-center flex-col">
				<!-- language nav -->
				<section class="mb-3 self-end flex items-center">
					<span class="mr-3"><i class="fa-solid fa-mobile-screen-button"></i> <?php echo esc_html($company_phone); ?> | </span>
					<a class="mr-3" href="<?php echo home_url('/wp-login.php'); ?>"><i class="fa-solid fa-right-to-bracket"></i></a>
					<?php
						wp_nav_menu(array(
							'theme_location' => 'lang_menu',
							'container'      => false,
							'menu_class'     => 'top-menu flex flex-row content-center justify-center space-x-4', // Dùng Tailwind để style menu
							'fallback_cb'    => false,
						));
						?>
				</section>
				<?php

				wp_nav_menu(array(
					'theme_location' => 'primary_menu',
					'container'      => false,
					'menu_class'     => 'top-menu flex flex-row content-center justify-center space-x-4', // Dùng Tailwind để style menu
					'fallback_cb'    => false,
				));
				?>
			</div>
			<div class="sub-logo basis-1/6">
				<img class="w-[170px] float-right" src="<?php echo get_template_directory_uri(); ?>/assets/images/header_arrows.png" alt="">
			</div>
		</nav>
		
		<!-- mobile nav -->
		<nav class="bg-white border-b border-gray-200 sm:hidden flex flex-row" id="mobile-menu">
			<div class="logo basis-1/2 flex md:justify-center justify-start items-center">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-crop.png" alt="" class="sm:w-[170px] w-[120px] mx-2 my-3">
			</div>
			<div class="menu basis-1/2">

				<!-- language nav -->
				<section class="flex justify-end items-center h-full self-end">
					<?php
						wp_nav_menu(array(
							'theme_location' => 'lang_menu',
							'container'      => false,
							'menu_class'     => 'top-menu flex flex-row content-center justify-center space-x-4', // Dùng Tailwind để style menu
							'fallback_cb'    => false,
						));
						?>


						<button id="mobile-menu-button" class="p-2 text-gray-700">
							<svg id="icon-hamburger" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>

                            <svg id="icon-close" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
							<!-- <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
							</svg> -->
						</button>
				</section>
			</div>

			<?php
				wp_nav_menu(array(
					'menu_id'        => 'mobile-list-item',
					'theme_location' => 'primary_menu',
					'container'      => false,
					'menu_class'     => 'top-menu flex flex-col sticky flex-row content-center hidden justify-start space-x-4',   // Dùng Tailwind để style menu
					'fallback_cb'    => false,
				));
			?>

		</nav>
	</header>

