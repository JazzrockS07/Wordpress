<?php
/**
 * ThemeMascot functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 */

global $charitab_mascot_theme_info;
$charitab_mascot_theme_info = wp_get_theme();

if (!function_exists('charitab_mascot_core_plugin_installed')) {
	/**
	 * Core Plugin installed?
	 */
	function charitab_mascot_core_plugin_installed() {
		return defined( 'MASCOT_CORE_CHARITAB_VERSION' );
	}
}

/* VARIABLE DEFINITIONS
================================================== */
define( 'CHARITAB_MASCOT_AUTHOR', 'ThemeMascot' );
define( 'CHARITAB_MASCOT_FRAMEWORK_VERSION', '1.0' );
define( 'CHARITAB_MASCOT_TEMPLATE_URI', get_template_directory_uri() );
define( 'CHARITAB_MASCOT_CHILD_THEME_URI', get_stylesheet_directory_uri() );
define( 'CHARITAB_MASCOT_TEMPLATE_DIR', get_template_directory() );
define( 'CHARITAB_MASCOT_STYLESHEET_DIR', get_stylesheet_directory() );

define( 'CHARITAB_MASCOT_ASSETS_URI', CHARITAB_MASCOT_TEMPLATE_URI . '/assets' );
define( 'CHARITAB_MASCOT_ASSETS_DIR', CHARITAB_MASCOT_TEMPLATE_DIR . '/assets' );

define( 'CHARITAB_MASCOT_ADMIN_ASSETS_URI', CHARITAB_MASCOT_TEMPLATE_URI . '/admin/assets' );
define( 'CHARITAB_MASCOT_ADMIN_ASSETS_DIR', CHARITAB_MASCOT_TEMPLATE_DIR . '/admin/assets' );

define( 'CHARITAB_MASCOT_FRAMEWORK_FOLDER', 'mascot-framework' );
define( 'CHARITAB_MASCOT_FRAMEWORK_URI', CHARITAB_MASCOT_TEMPLATE_URI . '/'. CHARITAB_MASCOT_FRAMEWORK_FOLDER );
define( 'CHARITAB_MASCOT_FRAMEWORK_DIR', CHARITAB_MASCOT_TEMPLATE_DIR . '/'. CHARITAB_MASCOT_FRAMEWORK_FOLDER );

define( 'CHARITAB_MASCOT_LANG_DIR', CHARITAB_MASCOT_TEMPLATE_DIR . '/languages' );

define( 'CHARITAB_MASCOT_THEME_NAME', $charitab_mascot_theme_info->get( 'Name' ) );
define( 'CHARITAB_MASCOT_THEME_SHORT', strtolower($charitab_mascot_theme_info->get( 'Name' )) );
define( 'CHARITAB_MASCOT_THEME_VERSION', $charitab_mascot_theme_info->get( 'Version' ) );
define( 'CHARITAB_MASCOT_POST_EXCERPT_LENGTH', 25 );
define( 'CHARITAB_MASCOT_MENUZORD_MEGAMENU_BREAKPOINT_BW', '1199px' );
define( 'CHARITAB_MASCOT_MENUZORD_MEGAMENU_BREAKPOINT_FW', '1200px' );


/* Initial Actions
================================================== */
add_action( 'after_setup_theme', 		'charitab_mascot_action_after_setup_theme' );
add_action( 'wp_enqueue_scripts', 		'charitab_mascot_action_wp_enqueue_scripts' );
add_action( 'widgets_init', 			'charitab_mascot_action_widgets_init' );
add_action( 'wp_head', 					'charitab_mascot_action_wp_head',1 );
add_action( 'wp_head', 					'charitab_mascot_action_wp_head_at_the_end', 100 );

//admin actions
add_action( 'admin_enqueue_scripts',	'charitab_mascot_action_theme_admin_enqueue_scripts' );

add_action( 'wp_footer', 				'charitab_mascot_action_wp_footer' );


/* MASCOT FRAMEWORK
================================================== */
require_once( CHARITAB_MASCOT_FRAMEWORK_DIR . '/mascot-framework.php' );




if(!function_exists('charitab_mascot_action_after_setup_theme')) {
	/**
	 * After Setup Theme
	 */
	function charitab_mascot_action_after_setup_theme() {
		//Theme Support
		global $supported_post_formats;
		$supported_post_formats = array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' );
		
		//This feature enables Post Formats support for this theme
		add_theme_support( 'post-formats', $supported_post_formats );

		//This feature enables Automatic Feed Links for post and comment in the head
		add_theme_support( 'automatic-feed-links' );

		//This feature enables Post Thumbnails support for this theme
		add_theme_support( 'post-thumbnails' );

		//Woocommerce theme suport
		add_theme_support( 'woocommerce' );

		// Custom Backgrounds
		add_theme_support( 'custom-background', array(
			'default-color' => 'fff',
		) );

		//This feature enables plugins and themes to manage the document title tag. This should be used in place of wp_title() function
		add_theme_support( 'title-tag' );

		//This feature allows the use of HTML5 markup for the search forms, comment forms, comment lists, gallery, and caption
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );


		// add excerpt support for pages
		add_post_type_support( 'page', 'excerpt' );

		//Thumbnail Sizes
		set_post_thumbnail_size( 672, 448, true );
		add_image_size( 'charitab_mascot_featured_image', 1100 );

		add_image_size( 'charitab_mascot_square', 550, 550, true );
		add_image_size( 'charitab_mascot_square_150', 150, 150, true );
		add_image_size( 'charitab_mascot_square_120', 120, 120, true );
		add_image_size( 'charitab_mascot_square_64', 64, 64, true );
		add_image_size( 'charitab_mascot_widget_100', 100, 70, true );

		add_image_size( 'charitab_mascot_bootstrap_3col', 260, 173, true );
		add_image_size( 'charitab_mascot_bootstrap_4col', 360, 240, true );
		add_image_size( 'charitab_mascot_bootstrap_6col', 560, 373, true );

		add_image_size( 'charitab_mascot_wide', 900, 600, true );
		add_image_size( 'charitab_mascot_height', 600, 816, true );
		add_image_size( 'charitab_mascot_height_small', 350, 476, true );
		add_image_size( 'charitab_mascot_large_width', 1800, 600, true );
		add_image_size( 'charitab_mascot_large_height', 900, 1224, true );
		add_image_size( 'charitab_mascot_large_width_height', 1800, 1200, true );

		//Content Width
		if ( ! isset( $content_width ) ) $content_width = 1170;

		//Theme Textdomain
		load_theme_textdomain( 'charitab-wp', get_template_directory() . '/languages' );

		//Register Nav Menus
		register_nav_menus( array(
			'primary' 					=> esc_html__( 'Primary Navigation Menu', 'charitab-wp' ),
			'page-404-helpful-links' 	=> esc_html__( 'Page 404 Helpful Links', 'charitab-wp' ),
			'column1-header-top-nav' 	=> esc_html__( 'Column 1 - Header Top Navigation', 'charitab-wp' ),
			'column2-header-top-nav' 	=> esc_html__( 'Column 2 - Header Top Navigation', 'charitab-wp' ),
			'column1-footer-nav' 		=> esc_html__( 'Columns 1 - Footer Bottom Navigation', 'charitab-wp' ),
			'column2-footer-nav' 		=> esc_html__( 'Columns 2 - Footer Bottom Navigation', 'charitab-wp' ),
			'column3-footer-nav' 		=> esc_html__( 'Columns 3 - Footer Bottom Navigation', 'charitab-wp' ),
		) );

		require_once( 'gutenberg-functions.php' );
	}
}


if(!function_exists('charitab_mascot_action_wp_enqueue_scripts')) {
	/**
	 * Enqueue Script/Style
	 */
	function charitab_mascot_action_wp_enqueue_scripts() {
		wp_enqueue_script( 'jquery-ui-core');
		wp_enqueue_script( 'jquery-ui-tabs');
		wp_enqueue_script( 'jquery-ui-accordion');
		
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );

		if( !is_admin() ){

			/**
			 * Enqueue Style
			 */

			if( is_rtl() ) {
				wp_enqueue_style( 'bootstrap-rtl', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/bootstrap-rtl.min.css' );
			} else {
				wp_enqueue_style( 'bootstrap', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/bootstrap.min.css' );
			}
			wp_enqueue_style( 'animate-css', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/animate.min.css' );

			wp_register_style( 'charitab-mascot-preloader', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/preloader.css' );

			/**
			 * Enqueue Fonts
			 */
			//font-awesome icons
			wp_deregister_style( 'font-awesome' );
			wp_enqueue_style( 'font-awesome', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/font-awesome.min.css' );
			wp_enqueue_style( 'font-awesome-animation', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/font-awesome-animation.min.css' );

			if( charitab_mascot_get_redux_option( 'page-settings-use-flaticon-current-theme' ) ) {
				wp_enqueue_style( 'flaticon-set-current-theme', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/flaticon-set-current-theme.css' );
			}
			if( charitab_mascot_get_redux_option( 'page-settings-use-elegant-icons' ) ) {
				wp_enqueue_style( 'elegant-icons', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/elegant-icons.css' );
			}
			if( charitab_mascot_get_redux_option( 'page-settings-use-pe-icon-7-stroke' ) ) {
				wp_enqueue_style( 'pe-icon-7-stroke', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/pe-icon-7-stroke.css' );
			}
			if( charitab_mascot_get_redux_option( 'page-settings-use-icomoon' ) ) {
				wp_enqueue_style( 'icomoon', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/fonts/icomoon/icomoon.css' );
			}
			if( charitab_mascot_get_redux_option( 'page-settings-use-ion-icons' ) ) {
				wp_enqueue_style( 'ion-icons', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/ionicons.css' );
			}
			if( charitab_mascot_get_redux_option( 'page-settings-use-simple-line' ) ) {
				wp_enqueue_style( 'simple-line', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/simple-line-icons.css' );
			}


			//google fonts
			wp_enqueue_style( 'charitab-mascot-google-fonts', charitab_mascot_google_fonts_url(), null, false, 'all' );



			/**
			 * Enqueue Script
			 */
			wp_enqueue_script( 'popper', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/popper.min.js', array('jquery'), false, true );
			wp_enqueue_script( 'bootstrap', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/bootstrap.min.js', array('jquery'), false, true );
			wp_enqueue_script( 'charitab-mascot-menuzord-megamenu', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/menuzord/js/menuzord.js', array('jquery'), false, true );

			//external plugins single file:
			wp_enqueue_script( 'jquery-appear', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jquery.appear.js', array('jquery'), false, true );
			wp_enqueue_script( 'isotope', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/isotope.pkgd.min.js', array('jquery'), false, true );
			wp_enqueue_script( 'imagesloaded', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/imagesloaded.pkgd.min.js', array('jquery'), false, true );
			wp_enqueue_script( 'scrolltofixed', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jquery-scrolltofixed-min.js', array('jquery'), false, true );
			wp_enqueue_script( 'easing', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jquery.easing.min.js', array('jquery'), false, true );
			wp_enqueue_script( 'fitvids', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jquery.fitvids.js', array('jquery'), false, true );
			wp_enqueue_script( 'localscroll', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jquery.localscroll.min.js', array('jquery'), false, true );
			wp_enqueue_script( 'scrollto', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jquery.scrollto.min.js', array('jquery'), false, true );
			wp_enqueue_script( 'wow', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/wow.min.js', array('jquery'), false, true );

			//external plugins js & css:
			//used when needed:
			wp_register_script( 'owl-carousel', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/owl-carousel/owl.carousel.min.js', array('jquery'), false, true );
			wp_register_script( 'owl-filter', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/owl-carousel/jquery.owl-filter.js', array('jquery'), false, true );
			wp_register_script( 'owl-carousel2-thumbs', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/owl.carousel2.thumbs.min.js', array('jquery'), false, true );
			wp_enqueue_style( 'owl-carousel', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/owl-carousel/assets/owl.carousel.min.css' );

			
			wp_register_script( 'lightgallery', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/lightgallery/js/lightgallery-all.min.js', array('jquery'), false, true );
			wp_register_style( 'lightgallery', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/lightgallery/css/lightgallery.min.css' );
			wp_register_script( 'mousewheel', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jquery.mousewheel.min.js', array('jquery'), false, true );
			wp_register_script( 'lightgallery-custom', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/tm-custom-lightgallery.js', array('jquery'), false, true );


			wp_register_script( 'nivo-lightbox', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/nivo-lightbox/nivo-lightbox.min.js', array('jquery'), false, true );
			wp_register_style( 'nivo-lightbox', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/nivo-lightbox/nivo-lightbox.min.css' );
			wp_register_style( 'nivo-lightbox-theme', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/nivo-lightbox/themes/default/default.css' );

			wp_register_script( 'prettyphoto', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/prettyphoto/js/jquery.prettyphoto.js', array('jquery'), false, true );
			wp_register_style( 'prettyphoto', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/prettyphoto/css/prettyphoto.css' );
			
			wp_register_script( 'magnific-popup', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), false, true );
			wp_register_style( 'magnific-popup', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/magnific-popup/magnific-popup.css' );
			
			wp_register_script( 'flipclock', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/flipclock/flipclock.min.js', array('jquery'), false, true );
			wp_register_style( 'flipclock', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/flipclock/flipclock.css' );
			
			wp_register_script( 'flexslider', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/flexslider/jquery.flexslider-min.js', array('jquery'), false, true );
			wp_register_style( 'flexslider', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/flexslider/flexslider.css' );
			
			wp_register_script( 'bxslider', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/bxslider/jquery.bxslider.min.js', array('jquery'), false, true );
			wp_register_style( 'bxslider', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/bxslider/jquery.bxslider.min.css' );
			
			wp_register_script( 'instafeed', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/instafeed.min.js', array('jquery'), false, true );
			wp_register_script( 'jflickrfeed', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jflickrfeed.min.js', array('jquery'), false, true );
			wp_register_script( 'animatenumbers', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jquery.animatenumbers.min.js', array('jquery'), false, true );
			wp_register_script( 'countdown', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jquery.countdown.min.js', array('jquery'), false, true );
			wp_register_script( 'final-countdown', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jquery.final-countdown.min.js', array('jquery'), false, true );
			wp_register_script( 'final-countdown-kinetic', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/kinetic.js', array('jquery'), false, true );

			wp_register_script( 'event-move', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/twentytwenty/jquery.event.move.js', array('jquery'), false, true );
			wp_register_script( 'twentytwenty', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/twentytwenty/jquery.twentytwenty.js', array('jquery'), false, true );
			wp_register_style( 'twentytwenty', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/twentytwenty/twentytwenty.css' );

			//Register Google Map Scripts
			$google_maps_api_key = charitab_mascot_get_redux_option( 'theme-api-settings-gmaps-api-key' );
			if( $google_maps_api_key ) {
				wp_register_script( 'google-maps-api', 'https://maps.google.com/maps/api/js?key=' . $google_maps_api_key, array(), false, true );
			} else {
				wp_register_script( 'google-maps-api', 'https://maps.google.com/maps/api/js', array(), false, true );
			}
			wp_register_script( 'google-maps-init', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/google-map-init.js', array('jquery'), false, true );


			//CD timeline vertical
			wp_register_script( 'timeline-cd-vertical', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-cd-vertical/js/timeline-cd-vertical.js', array('jquery'), false, true );
			wp_register_style( 'timeline-cd-vertical', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-cd-vertical/css/timeline-cd-vertical.css' );
			wp_register_style( 'timeline-cd-vertical-rtl', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-cd-vertical/css/timeline-cd-vertical-rtl.css' );


			//CD timeline horizontal
			wp_register_script( 'timeline-cd-horizontal', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-cd-horizontal/js/timeline-cd-horizontal.js', array('jquery'), false, true );
			wp_register_style( 'timeline-cd-horizontal', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-cd-horizontal/css/timeline-cd-horizontal.css' );
			wp_register_style( 'timeline-cd-horizontal-rtl', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-cd-horizontal/css/timeline-cd-horizontal-rtl.css' );


			//Horizontal Vertical timeline
			wp_register_script( 'timeline-horizontal-vertical', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-horizontal-vertical/js/timeline-horizontal-vertical.min.js', array('jquery'), false, true );
			wp_register_script( 'timeline-horizontal-vertical-custom', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-horizontal-vertical/js/custom.js', array('jquery'), false, true );
			wp_register_style( 'timeline-horizontal-vertical', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-horizontal-vertical/css/timeline-horizontal-vertical.css' );
			wp_register_style( 'timeline-horizontal-vertical-rtl', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-horizontal-vertical/css/timeline-horizontal-vertical-rtl.css' );



			//responsive vertical timeline CP
			wp_register_style( 'timeline-cp-responsive-vertical', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-cp-responsive-vertical/timeline-cp-responsive-vertical.css' );
			wp_register_style( 'timeline-cp-responsive-vertical-rtl', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/timeline-cp-responsive-vertical/timeline-cp-responsive-vertical-rtl.css' );


			wp_register_script( 'jquery-swiper', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/swiper-slider/js/swiper.jquery.min.js', array('jquery'), false, true );
			wp_register_style( 'jquery-swiper', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/swiper-slider/css/swiper.min.css' );

			

			wp_register_script( 'menufullpage', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/menufullpage/menufullpage.min.js', array('jquery'), false, true );



			wp_register_script( 'jquery-fullpage', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/slider-fullpage/fullpage.min.js', array('jquery'), false, true );
			wp_register_style( 'jquery-fullpage', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/slider-fullpage/fullpage.min.css' );
			wp_register_style( 'jquery-fullpage-rtl', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/slider-fullpage/fullpage.min-rtl.css' );
			


			wp_register_script( 'jquery-multiscroll', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/slider-multiscroll/jquery.multiscroll.extensions.min.js', array('jquery'), false, true );
			wp_register_script( 'jquery-multiscroll-responsive', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/slider-multiscroll/multiscroll.responsiveexpand.min.js', array('jquery'), false, true );
			wp_register_style( 'jquery-multiscroll', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/slider-multiscroll/jquery.multiscroll.css' );
			wp_register_style( 'jquery-multiscroll-rtl', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/slider-multiscroll/jquery.multiscroll-rtl.css' );
			



			wp_register_script( 'jquery-pagepiling', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/slider-pagepiling/jquery.pagepiling.min.js', array('jquery'), false, true );
			wp_register_style( 'jquery-pagepiling', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/slider-pagepiling/jquery.pagepiling.css' );
			wp_register_style( 'jquery-pagepiling-rtl', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/slider-pagepiling/jquery.pagepiling-rtl.css' );



			
			wp_register_script( 'jquery-datatables', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/datatables/js/jquery.datatables.min.js', array('jquery'), false, true );
			wp_register_style( 'jquery-datatables', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/datatables/css/jquery.datatables.min.css' );
			
			wp_register_script( 'jquery-easypiechart', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/plugins/jquery.easypiechart.min.js', array('jquery'), false, true );


			//Theme Custom JS
			wp_enqueue_script( 'charitab-mascot-custom', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/js/custom.js', array('jquery'), false, true );



			//Enqueue comment-reply.js 
			if ( is_singular() && comments_open() && get_option('thread_comments') ) {
				wp_enqueue_script( 'comment-reply' );
			}


			//style main for this theme
			if( is_rtl() ) {
				wp_enqueue_style( 'charitab-mascot-style-main-rtl', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/style-main-rtl.css', array(), CHARITAB_MASCOT_THEME_VERSION );
			} else {
				wp_enqueue_style( 'charitab-mascot-style-main', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/style-main.css', array(), CHARITAB_MASCOT_THEME_VERSION );
			}

			//Theme Color
			$mascot_primary_theme_color = '';
			$page_metabox_change_primary_theme_color = charitab_mascot_get_rwmb_group( 'charitab_mascot_' . "page_mb_theme_color_settings", 'change_primary_theme_color', charitab_mascot_get_page_id() );

			if( $page_metabox_change_primary_theme_color ) {
				//Theme Color from page meta box
				$mascot_primary_theme_color = charitab_mascot_get_rwmb_group( 'charitab_mascot_' . "page_mb_theme_color_settings", 'primary_theme_color', charitab_mascot_get_page_id() );
			
			} else if ( !_empty( charitab_mascot_get_redux_option( 'theme-color-settings-theme-color-type' ) ) ) {
				//Theme Color from Theme Options
				if( charitab_mascot_get_redux_option( 'theme-color-settings-theme-color-type' ) == 'predefined' ) {
					//Primary Theme Color
					$mascot_primary_theme_color = !_empty( charitab_mascot_get_redux_option( 'theme-color-settings-primary-theme-color' ) ) ? charitab_mascot_get_redux_option( 'theme-color-settings-primary-theme-color' ) : '';
				} else if ( charitab_mascot_get_redux_option( 'theme-color-settings-theme-color-type' ) == 'custom' ) {
					//Custom Theme Color
					$redux_css_file_name = charitab_mascot_get_redux_option( 'theme-color-settings-custom-theme-color-filename' );
					if( !empty( $redux_css_file_name ) ) {
						$mascot_primary_theme_color = $redux_css_file_name . '.css';
					} else if ( !is_multisite() ) {
						if ( file_exists( CHARITAB_MASCOT_ASSETS_DIR . '/css/colors/custom-theme-color.css' ) ) {
							$mascot_primary_theme_color = 'custom-theme-color.css';
						}
					} else {
						if ( file_exists( CHARITAB_MASCOT_ASSETS_DIR . '/css/colors/custom-theme-color-msid-' . charitab_mascot_get_multisite_blog_id() . '.css' ) ) {
							$mascot_primary_theme_color = 'custom-theme-color-msid-' . charitab_mascot_get_multisite_blog_id() . '.css';
						}
					}
				}
			} else {
				$mascot_primary_theme_color = 'theme-skin-color-set1.css';
			}

			wp_enqueue_style( 'charitab-mascot-primary-theme-color', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/colors/' . $mascot_primary_theme_color );


			//Attach Premade CSS File into the header
			$mascot_premade_sitewise_css_file = charitab_mascot_get_redux_option( 'theme-color-settings-premade-sitewise-css-file' );
			if( !empty($mascot_premade_sitewise_css_file) ) {
				wp_enqueue_style( 'charitab-mascot-premade-sitewise-css-file', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/sites/' . $mascot_premade_sitewise_css_file );
			}


			if( is_rtl() ) {
				wp_enqueue_style( 'charitab-mascot-style-main-rtl-extra', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/style-main-rtl-extra.css' );
			}

			//Dynamic Style
			if ( !is_multisite() ) {
				if ( file_exists( CHARITAB_MASCOT_ASSETS_DIR . '/css/dynamic-style.css' ) ) {
					wp_enqueue_style( 'charitab-mascot-dynamic-style', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/dynamic-style.css' );
				}
			} else {
				if ( file_exists( CHARITAB_MASCOT_ASSETS_DIR . '/css/dynamic-style-msid-' . charitab_mascot_get_multisite_blog_id() . '.css' ) ) {
					wp_enqueue_style( 'charitab-mascot-dynamic-style', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/dynamic-style-msid-' . charitab_mascot_get_multisite_blog_id() . '.css' );
				}
			}

		}
	}
}



if(!function_exists('charitab_mascot_action_theme_admin_enqueue_scripts')) {
	/**
	 * Add Admin Scripts
	 */
	function charitab_mascot_action_theme_admin_enqueue_scripts() {
		wp_enqueue_style( 'font-awesome', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/font-awesome.min.css' );
		wp_enqueue_style( 'pe-icon-7-stroke', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/pe-icon-7-stroke.css' );
		wp_enqueue_style( 'ion-icons', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/ionicons.css' );
		wp_enqueue_style( 'flaticon-set-charitab', CHARITAB_MASCOT_TEMPLATE_URI . '/assets/css/flaticon-set-charitab.css' );
			
		wp_enqueue_style( 'charitab-mascot-custom-admin', CHARITAB_MASCOT_TEMPLATE_URI . '/admin/assets/css/custom-admin.css' );

		wp_enqueue_script( 'charitab-mascot-admin-js', CHARITAB_MASCOT_TEMPLATE_URI . '/admin/assets/js/admin.js', array('jquery'), null, true );
	}
}



if(!function_exists('charitab_mascot_detect_visual_composer_and_add_class')) {
	/**
	 * Detect VC Enabled in Page Content and then add class to body
	 */
	function charitab_mascot_detect_visual_composer_and_add_class( $classes ) {
		$vc_enabled = get_post_meta( get_the_ID() , '_wpb_vc_js_status', true);
		if (  is_archive() ) {
			$classes[] = 'tm_wpb_vc_js_status_false';
		} else if ( $vc_enabled != 'false' && $vc_enabled == true ) {
			$classes[] = 'tm_wpb_vc_js_status_true';
		} else {
			$classes[] = 'tm_wpb_vc_js_status_false';
		}
		return $classes;
	}
	add_filter( 'body_class','charitab_mascot_detect_visual_composer_and_add_class' );
}



if(!function_exists('charitab_mascot_google_fonts_url')) {
	/**
	 * @return string Google fonts URL
	 */
	function charitab_mascot_google_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		//fonts
		$fonts = apply_filters( 'charitab_mascot_google_web_fonts', $fonts );

		//font subsets
		$subsets = apply_filters('charitab_mascot_google_font_subset', 'latin,latin-ext');

		if ( !empty( $fonts ) ) {
			$fonts_url = add_query_arg(
				array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( $subsets ),
				),
				'https://fonts.googleapis.com/css'
			);
		}		

		return apply_filters( 'google_web_fonts_url', $fonts_url );
	}
}


if(!function_exists('charitab_mascot_primary_google_fonts')) {
	/**
	 * @return primary google fonts used in this theme
	 */
	function charitab_mascot_primary_google_fonts( $fonts ) {

		/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Google font: on or off', 'charitab-wp' ) ) {
			$fonts[] = 'Open Sans:300,400,500,600,700,800';
			$fonts[] = 'Merriweather:300,400,700,900';
			$fonts[] = 'Playfair Display:400,400i,700,700i';
		}

		return $fonts;
	}
	add_filter( 'charitab_mascot_google_web_fonts', 'charitab_mascot_primary_google_fonts' );
}

require_once __DIR__.'/vendor/autoload.php';

/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
	// $cols contains the current number of products per page based on the value stored on Options -> Reading
	// Return the number of products you wanna show per page.
	$cols = 500;
	return $cols;
}

function misha_print_all_fields ($fields)  {

	// if (! current_user_can ('manage_options'))
	// return; // если ваш сайт работает

	echo '<pre>'.print_r($fields,1).'</pre>' ; // оборачиваем результаты в тег pre html, чтобы сделать его более понятным
	exit;

}

// WooCommerce Change Checkout Fields
add_filter( 'woocommerce_checkout_fields' , 'custom_change_wc_checkout_fields' );

// Change label text and add JS
function custom_change_wc_checkout_fields( $fields ) {
	$fields['billing']['billing_first_name']['custom_attributes']['onblur'] = 'onblur_first_name()';
	$fields['billing']['billing_last_name']['custom_attributes']['onblur'] = 'onblur_last_name()';
	$fields['billing']['billing_state']['label'] = 'State';
	$fields['billing']['billing_state']['custom_attributes']['onblur'] = 'onblur_location()';
	return $fields;
}

add_action( 'wp_footer', 'misha_checkout_js' );
function misha_checkout_js(){

	// we need it only on our checkout page
/*	if( !is_checkout() ) return;

	?>
	<script xmlns="http://www.w3.org/1999/html">
			function onblur_first_name() {
				var y = document.getElementById("my_field_first_name").value;
				var x = document.getElementById("1").value;
				if (y === "") {
					document.getElementById("my_field_first_name").value = x;
				}
			}
			function onblur_last_name() {
				var y = document.getElementById("my_field_last_name").value;
				var x = document.getElementById("2").value;
				if (y === "") {
					document.getElementById("my_field_last_name").value = x;
				}
			}
			function onblur_location() {
				var y = document.getElementById("my_field_location").value;
				var x = document.getElementById("10").value;
				if (y === "") {
					document.getElementById("my_field_location").value = x;
				}
			}
	</script>
	<?php
*/

	//we need it only on our product page
	if (!is_product() ) return;

	?>

	<script type="text/javascript">
		function countChar(val) {
			var len = val.value.length;
			if (len > 150) {
				val.value = val.value.substring(0, 150);
			} else {
				$('#left').text(" left ");
				$('#charNum').text(150 - len);
				$('#symbols').text(" symbols");
			}
		}
	</script>
	<script type="text/javascript">
		function escapeHtml(text) {
			return text
				.replace(/&/g, "&amp;")
				.replace(/</g, "&lt;")
				.replace(/>/g, "&gt;")
				.replace(/"/g, "&quot;")
				.replace(/'/g, "&#039;");
		}
		function view_comment() {
			var comment = $('#pr-field').val().replace(/([^>])\n/g, '$1<br/>');
			document.getElementById("image-comment").innerHTML = escapeHtml(comment);
			document.getElementById("img-single-product").style.opacity='0.3';
//			document.getElementById("img-single-product").style.filter="grayscale(100%)";
		}

		function view_name() {
			document.getElementById("img-single-product").style.opacity='0.3';
//			document.getElementById("img-single-product").style.filter="grayscale(100%)";
			var fname = escapeHtml($('#pr-field-first-name').val());
			var lname = escapeHtml($('#pr-field-last-name').val());
			var how = escapeHtml($('#pr-field-how').val());
			if (fname ||lname) {
				if (how === 'Full') {
					document.getElementById("image-name").innerHTML = fname+' '+lname;
				} else if (how === 'First') {
					document.getElementById("image-name").innerHTML = fname+' '+lname.substring(0,1)+'.';
				} else if (how === 'Initials') {
					document.getElementById("image-name").innerHTML = fname.substring(0,1)+'.'+lname.substring(0,1)+'.';
				} else if (how === 'Anonymous') {
					document.getElementById("image-name").innerHTML = 'Anonymous';
				} else {
					document.getElementById("image-name").innerHTML = fname+' '+lname;
				}
			} else {
				document.getElementById("image-name").innerHTML = '';
			}
		}

		function view_city() {
			document.getElementById("img-single-product").style.opacity='0.3';
//			document.getElementById("img-single-product").style.filter="grayscale(100%)";
			var city = escapeHtml($('#pr-field-city').val());
			if (city) {
				document.getElementById('image-city').innerHTML = city+',';
			} else {
				document.getElementById('image-city').innerHTML = '';
			}
		}

		function view_location() {
			document.getElementById("img-single-product").style.opacity='0.3';
//			document.getElementById("img-single-product").style.filter="grayscale(100%)";
			document.getElementById('image-location').innerHTML = escapeHtml($('#pr-field-state').val());
		}

		function view_how() {
			var fname = escapeHtml($('#pr-field-first-name').val());
			var lname = escapeHtml($('#pr-field-last-name').val());
			var how = escapeHtml($('#pr-field-how').val());
			if (how === 'Full') {
				document.getElementById("image-name").innerHTML = fname+' '+lname;
			} else if (how === 'First') {
				document.getElementById("image-name").innerHTML = fname+' '+lname.substring(0,1)+'.';
			} else if (how === 'Initials') {
				document.getElementById("image-name").innerHTML = fname.substring(0,1)+'.'+lname.substring(0,1)+'.';
			} else if (how === 'Anonymous') {
				document.getElementById("image-name").innerHTML = 'Anonymous';
			}
		}


	</script>


	<?php
}


/**
 * Add the field to the checkout
 */
/*
add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );

function my_custom_checkout_field( $checkout ) {

	echo '<div id="my_custom_checkout_field">';

	woocommerce_form_field( 'my_field_first_name', array(
		'type'          => 'text',
		'class'         => array('my_field_first_name form-row-wide'),
		'label'         => __('First Name'),
		'placeholder'   => __('Enter First Name'),
		'required'		=> true,
	), $checkout->get_value( 'my_field_first_name' ));

	woocommerce_form_field( 'my_field_last_name', array(
		'type'          => 'text',
		'class'         => array('my_field_last_name form-row-wide'),
		'label'         => __('Last Name'),
		'placeholder'   => __('Enter Last Name'),
		'required'		=> true,
	), $checkout->get_value( 'my_field_last_name' ));

	woocommerce_form_field( 'my_field_location', array(
		'type'          => 'text',
		'class'         => array('my_field_location form-row-wide'),
		'label'         => __('Location'),
		'placeholder'   => __('Enter Location'),
		'required'		=> true,
	), $checkout->get_value( 'my_field_location' ));

	woocommerce_form_field( 'my_field_how', array(
		'type'          => 'select',
		'class'         => array('my_field_how form-row-wide'),
		'label'         => __('How to show'),
		'options'     => array(
							'Initials' => __('Initials (John S.)'),
							'Full' => __('Full Name (John Smith)'),
							'Anonymous' => __('Anonymous')
						),
		'default' => 'Initials',
		'required'		=> true,
	), $checkout->get_value( 'my_field_how' ));

	echo '</div>';

}
*/

/**
 * Process the checkout
 */
/*
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
	// Check if set, if its not set add an error.
	if ( ! $_POST['my_field_first_name'] )
		wc_add_notice( __( 'Please enter First Name field in addiitional information.' ), 'error' );
	if ( ! $_POST['my_field_last_name'] )
		wc_add_notice( __( 'Please enter Last Name field in addiitional information.' ), 'error' );
	if ( ! $_POST['my_field_last_name'] )
		wc_add_notice( __( 'Please enter Last Name field in addiitional information.' ), 'error' );
	if ( ! $_POST['my_field_how'] )
		wc_add_notice( __( 'Please enter how to show field in addiitional information.' ), 'error' );
	require_once __DIR__.'/vendor/autoload.php';

}
*/
/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {
/*	if ( ! empty( $_POST['my_field_first_name'] ) | ! empty( $_POST['my_field_last_name'] )|! empty( $_POST['my_field_how'] )|!empty($_POST['my_field_location'])) {
		update_post_meta( $order_id, 'First Name', sanitize_text_field( $_POST['my_field_first_name'] ) );
		update_post_meta( $order_id, 'Last Name', sanitize_text_field( $_POST['my_field_last_name'] ) );
		update_post_meta( $order_id, 'Location', sanitize_text_field( $_POST['my_field_location'] ) );
		update_post_meta( $order_id, 'How to show', sanitize_text_field( $_POST['my_field_how'] ) );
*/

		// Getting an instance of the order object

		$order = new WC_Order( $order_id );
		$items = $order->get_items();

		//Loop through them, you can get all the relevant data:
/*		$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];

		$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];
		$mpdf = new \Mpdf\Mpdf([
			'fontDir' => array_merge($fontDirs, [
				__DIR__ . '/pdf/fontDir',
			]),
			'fontdata' => $fontData + [
					'Pinyon' => [
						'R' => 'PinyonScript-Regular.ttf'
					]
				]

		]);
*/
		$mpdf = new \Mpdf\Mpdf(
			['format'=>'A4-L']

		);
	// подключаем стили
		// подключаем файл стилей
		$stylesheet = file_get_contents(__DIR__.'/pdf/style_pdf.css');
		$mpdf->WriteHTML($stylesheet,1);
		$i=0;


		//$mpdf->WriteHTML('<pre>'.print_r($items,1).'</pre>','',false,false); debug WC_ORDER

		foreach ( $items as $item ) {
			$i=$i+1;
			if ($i>1) {
				$mpdf->AddPage();
			}
			$product_id = $item['product_id'];
			$product = $item['name'];
			$comment = $item['Dedication'];
			$first = $item['First Name'];
			$last = $item['Last Name'];
			$state = $item['City'].', '.$item['State/Country'];
			$how = $item['How to show'];
			$imagefile = get_post_meta($product_id,'imagefile',true);
			date_default_timezone_set('UTC');
			$date=date('F j, Y');

			update_post_meta($product_id, "owner", $first);
			update_post_meta($product_id, "owner_last_name", $last);
			update_post_meta($product_id, "location", $state);
			update_post_meta($product_id, "how_to_show", $how);
			update_post_meta($product_id, "owner_comment", $comment);
//			$html = file_get_contents(__DIR__.'/pdf/Certificate.html');
			$mpdf->WriteHTML('

<body style="position:relative; margin: 0; padding: 0;">
<div style="position:absolute; height: 20cm; margin: auto; z-index: 1"><img src="/wp-content/themes/charitab-wp/img/s-1.png" width="100%" height="100%" alt=""/></div>
<div style="position:absolute; width: 30cm; height: 20cm; margin: auto; z-index: 2">
	<div style="position: relative; padding: 2.3cm 3.7cm;  height: 20cm; margin: auto;">
	
		<div style="position:relative; width:2.2cm; margin: auto; border:solid 0.15cm #ffffff;"><img src="/wp-content/themes/charitab-wp/img/WB_Foundation_LogoRGB144_2019-1.jpg" width="100%" height="auto" alt=""/></div>
		
		<div style="position:relative; text-align: center; width:22cm"><!--border:solid 0.1cm #b29201;  height: 12.8cm; -->
			
			<div style="font-family:\'amiri\', serif; font-size: 1.7cm; text-transform: uppercase; padding:0.8cm 0 0; color:#004588; letter-spacing: 0.3cm; line-height: 1.6cm;">Certificate</div>
			<div style="font-family:\'amiri\', serif; font-size:0.36cm; color:#004588;  text-transform: uppercase; letter-spacing: 0.1cm; line-height: 0.55cm; font-style: italic;">OF THE WIEDMANN BIBLE FAMILY <br>PICTURE ADOPTION</div>
			<div style="font-family: \'pinyon\', cursive; font-size: 0.6cm; padding:0.7cm 0 0.2cm; color:#004588; letter-spacing: 0.03cm;">This Sertifies that</div>
			<div style="font-family: \'pinyon\', cursive; font-size: 1.2cm; color:#b34b00; letter-spacing: 0.05cm;">'.$first.' '.$last.'</div>
			<div style="font-family: \'pinyon\', cursive; font-size: 0.6cm; padding:0.3cm 0 0.2cm; color:#004588; letter-spacing: 0.03cm;">Adopted picture '.$product.' in the Wiedmann Bible for one year</div>
			<div style="position:relative; float:left; margin-left:0.3cm; padding-bottom:0.2cm; padding-top: 3.8cm; width: 7cm;">
				<div style="font-family:\'pinyon\', cursive; font-size: 0.7cm; color:#b34b00;">'.$date.'</div>
				<div style="font-family:\'amiri\', serif; font-size: 0.25cm; text-transform: uppercase; padding:0.2cm 0 0; color:#004588; letter-spacing: 0.1cm; border-top: solid 0.03cm #004588; width: 7cm;">date</div>
			</div>
			<div style="position:relative; float:left; margin-left:0.7cm; width:6cm; padding-top: 0.6cm;">
				<div style="position: relative;  border: solid 0.03cm #b29201;"><img style="position: absolute; bottom: -1cm; z-index: 200; border:solid 0.3cm #ffffff;" src="https://wiedmann.s3.amazonaws.com/images/l_'.$imagefile.'" width="100%" height="auto" alt=""/></div>
			</div>
			<div style="position:relative;float:right; margin-right:0.3cm; padding-bottom:0.2cm;  padding-top: 3.8cm; width: 7cm;">
				<div style="font-family: \'pinyon\', cursive; font-size: 0.7cm; color:#b34b00; ">Carolin D. Rossinsky</div>
				<div style="font-family:\'amiri\', serif; font-size: 0.25cm; text-transform: uppercase; padding:0.2cm 0 0; color:#004588; letter-spacing: 0.1cm; border-top: solid 0.03cm #004588; width: 7cm;">president</div>
			</div>
		</div>
	</div>
</div>
</body>

			',2);
			//$mpdf->WriteHTML('<h1>product_id:'.$product_id.'</h1><br><h1>product:'.$product.'</h1><br><h1>comment:'.$comment.'</h1>','',false,false);

		}

		$mpdf->Output(__DIR__.'/pdf/tmp/certificate_'.$order_id.'.pdf');
//	}
}

/**
 * Display field value on the order edit page
 */
/*
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
	echo '<p><strong>'.__('First Name').':</strong> ' . get_post_meta( $order->id, 'First Name', true ) . '</p>';
	echo '<p><strong>'.__('Last Name').':</strong> ' . get_post_meta( $order->id, 'Last Name', true ) . '</p>';
	echo '<p><strong>'.__('Location').':</strong> ' . get_post_meta( $order->id, 'Location', true ) . '</p>';
	echo '<p><strong>'.__('How to show').':</strong> ' . get_post_meta( $order->id, 'How to show', true ) . '</p>';
}
*/

add_action ('woocommerce_order_status_cancelled','custom_fields_to_zero');

function custom_fields_to_zero($order_id) {
	$order = new WC_Order( $order_id );
	$items = $order->get_items();

	foreach ( $items as $item ) {
		$product_id = $item['product_id'];

		update_post_meta ($product_id,"owner","");
		update_post_meta ($product_id,"owner_last_name","");
		update_post_meta ($product_id,"location","");
		update_post_meta ($product_id,"owner_comment","");
		update_post_meta ($product_id,"how_to_show","");
	}
}


/*
 * add JS to checkout
 */
/*
add_filter( 'woocommerce_checkout_fields', 'misha_no_email_validation' );

function misha_no_email_validation( $fields ){

	unset( $fields['billing']['billing_email']['validate'] );
	return $fields;

}

add_action( 'woocommerce_after_checkout_validation', 'misha_validate_fname_lname', 10, 2);

function misha_validate_fname_lname( $fields, $errors ){

	if ( preg_match( '/\\d/', $fields[ 'billing_first_name' ] ) || preg_match( '/\\d/', $fields[ 'billing_last_name' ] )  ){
		$errors->add( 'validation', 'Your first or last name contains a number. Really?' );
	}
}
*/
/*
 * Скрыть категорию
 */



add_filter( 'get_terms', 'get_subcategory_terms', 10, 3 );

function get_subcategory_terms( $terms, $taxonomies, $args ) {

	$new_terms = array();

	// если находится в товарной категории и на странице магазина
	if ( in_array( 'product_cat', $taxonomies ) && ! is_admin() && is_shop() ) {

		foreach ( $terms as $key => $term ) {

			if ( ! in_array( $term->slug, array( 'gold' ) ) ) {
				$new_terms[] = $term;
			}

		}

		$terms = $new_terms;
	}

	return $terms;
}

add_filter( 'get_terms', 'get_subcategory_terms2', 10, 3 );

function get_subcategory_terms2( $terms, $taxonomies, $args ) {

	$new_terms = array();

	// если находится в товарной категории и на странице магазина
	if ( in_array( 'product_cat', $taxonomies ) && ! is_admin() && is_shop() ) {

		foreach ( $terms as $key => $term ) {

			if ( ! in_array( $term->slug, array( 'silver' ) ) ) {
				$new_terms[] = $term;
			}

		}

		$terms = $new_terms;
	}

	return $terms;
}

add_filter( 'get_terms', 'get_subcategory_terms3', 10, 3 );

function get_subcategory_terms3( $terms, $taxonomies, $args ) {

	$new_terms = array();

	// если находится в товарной категории и на странице магазина
	if ( in_array( 'product_cat', $taxonomies ) && ! is_admin() && is_shop() ) {

		foreach ( $terms as $key => $term ) {

			if ( ! in_array( $term->slug, array( 'premium' ) ) ) {
				$new_terms[] = $term;
			}

		}

		$terms = $new_terms;
	}

	return $terms;
}

/*
* Добавить настраиваемое поле ввода текста на страницу продукта
*/

function  plugin_republic_add_text_field () {
	?>
	<br>
	<div  class="pr-field-wrap">
		<label  for="pr-field" class="product-label-textarea"><?php _e('Dedication ','plugin-Republic');?></label>
		<textarea  rows="3" name='pr-field'  id='pr-field' value='' placeholder="max 150 symbols" class="product-input-form" maxlength="150" onkeyup="countChar(this);view_comment();"></textarea>
	</div>
	<div class="left-symbols">
		<span id="left"></span>
		<span id="charNum"></span>
		<span id="symbols"></span>
	</div>
	<div  class="pr-field-wrap">
		<label  for="pr-field-first-name" class="product-label-form"><?php _e('First Name ','plugin-Republic');?></label>
		<input  type="text"  name='pr-field-first-name'  class="product-input-form" id='pr-field-first-name' value='' onkeyup="view_name()">
	</div>
	<div  class="pr-field-wrap">
		<label  for="pr-field-last-name" class="product-label-form"><?php _e('Last Name ','plugin-Republic');?></label>
		<input  type="text" name='pr-field-last-name'  class="product-input-form" id='pr-field-last-name' value='' onkeyup="view_name()">
	</div>
	<div  class="pr-field-wrap">
		<label  for="pr-field-city" class="product-label-form"><?php _e('City ','plugin-Republic');?></label>
		<input  type="text"  name='pr-field-city'  class="product-input-form" id='pr-field-city' value='' onkeyup="view_city()">
	</div>
	<div  class="pr-field-wrap">
		<label  for="pr-field-state" class="product-label-form"><?php _e('State/Country ','plugin-Republic');?></label>
		<input  type="text"  name='pr-field-state'  class="product-input-form" id='pr-field-state' value='' onkeyup="view_location()">
	</div>
	<div class="pr-field-wrap">
		<label  for="pr-field-how" class="product-label-form"><?php _e('How to show ','plugin-Republic');?></label>
		<select type="select" size="1" name="pr-field-how" id="pr-field-how" class="product-select-form" onchange="view_how()">
			<option value="Full">Full Name (John Smith)</option>
			<option value="First">First Name (John S.)</option>
			<option value="Initials">Initials (J.S.)</option>
		    <option value="Anonymous">Anonymous</option>
		</select>
	</div>
	<br>
	<?php
}

add_action ('woocommerce_before_add_to_cart_button', 'plugin_republic_add_text_field');


/**
 * Validate our custom text input field value
 */
function plugin_republic_add_to_cart_validation( $passed, $product_id, $quantity, $variation_id=null ) {
/*	if( empty( $_POST['pr-field'] ) ) {
		$passed = false;
		wc_add_notice( __( 'Dedication is a required field.', 'plugin-republic' ), 'error' );
	}
*/
	if( empty( $_POST['pr-field-first-name'] ) ) {
		$passed = false;
		wc_add_notice( __( 'First Name is a required field.', 'plugin-republic' ), 'error' );
	}
	if( empty( $_POST['pr-field-last-name'] ) ) {
		$passed = false;
		wc_add_notice( __( 'Last Name is a required field.', 'plugin-republic' ), 'error' );
	}
	if( empty( $_POST['pr-field-city'] ) ) {
		$passed = false;
		wc_add_notice( __( 'City is a required field.', 'plugin-republic' ), 'error' );
	}
	if( empty( $_POST['pr-field-state'] ) ) {
		$passed = false;
		wc_add_notice( __( 'State/Country is a required field.', 'plugin-republic' ), 'error' );
	}
	return $passed;
}
add_filter( 'woocommerce_add_to_cart_validation', 'plugin_republic_add_to_cart_validation', 10, 4 );

/**
 * Add custom cart item data
 */
function plugin_republic_add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
	if( !empty( $_POST['pr-field'] ) ) {
		$cart_item_data['pr_field'] = $_POST['pr-field'];
	}
	if( isset( $_POST['pr-field-first-name'] ) ) {
		$cart_item_data['pr_field-first-name'] = sanitize_text_field( $_POST['pr-field-first-name'] );
	}
	if( isset( $_POST['pr-field-last-name'] ) ) {
		$cart_item_data['pr_field-last-name'] = sanitize_text_field( $_POST['pr-field-last-name'] );
	}
	if( isset( $_POST['pr-field-city'] ) ) {
		$cart_item_data['pr_field-city'] = sanitize_text_field( $_POST['pr-field-city'] );
	}
	if( isset( $_POST['pr-field-state'] ) ) {
		$cart_item_data['pr_field-state'] = sanitize_text_field( $_POST['pr-field-state'] );
	}
	if( isset( $_POST['pr-field-how'] ) ) {
		$cart_item_data['pr_field-how'] = sanitize_text_field( $_POST['pr-field-how'] );
	}
	return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'plugin_republic_add_cart_item_data', 10, 3 );

/**
 * Display custom item data in the cart
 */

function plugin_republic_get_item_data( $item_data, $cart_item_data ) {
	if( isset( $cart_item_data['pr_field'] ) ) {
		$item_data[] = array(
			'key'     => __( 'Dedication', 'plugin-republic' ),
			'value'   =>  wc_clean($cart_item_data['pr_field'])
		);
	}
	if( isset( $cart_item_data['pr_field-first-name'] ) ) {
		$item_data[] = array(
			'key'     => __( 'Name', 'plugin-republic' ),
			'value'   => wc_clean( $cart_item_data['pr_field-first-name']).' '.wc_clean( $cart_item_data['pr_field-last-name'])
		);
	}
	if( isset( $cart_item_data['pr_field-city'] ) ) {
		$item_data[] = array(
			'key'     => __( 'Location', 'plugin-republic' ),
			'value'   => wc_clean( $cart_item_data['pr_field-city']).' '.wc_clean( $cart_item_data['pr_field-state'] )
		);
	}
	return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'plugin_republic_get_item_data', 10, 2 );


/**
 * Add custom meta to order
 */

function plugin_republic_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
	if( isset( $values['pr_field'] ) ) {
		$item->add_meta_data(
			__( 'Dedication', 'plugin-republic' ),
			$values['pr_field'],
			true
		);
	}
	if( isset( $values['pr_field-first-name'] ) ) {
		$item->add_meta_data(
			__( 'First Name', 'plugin-republic' ),
			$values['pr_field-first-name'],
			true
		);
	}
	if( isset( $values['pr_field-last-name'] ) ) {
		$item->add_meta_data(
			__( 'Last Name', 'plugin-republic' ),
			$values['pr_field-last-name'],
			true
		);
	}
	if( isset( $values['pr_field-city'] ) ) {
		$item->add_meta_data(
			__( 'City', 'plugin-republic' ),
			$values['pr_field-city'],
			true
		);
	}
	if( isset( $values['pr_field-state'] ) ) {
		$item->add_meta_data(
			__( 'State/Country', 'plugin-republic' ),
			$values['pr_field-state'],
			true
		);
	}
	if( isset( $values['pr_field-how'] ) ) {
		$item->add_meta_data(
			__( 'How to show', 'plugin-republic' ),
			$values['pr_field-how'],
			true
		);
	}
}
add_action( 'woocommerce_checkout_create_order_line_item', 'plugin_republic_checkout_create_order_line_item', 10, 4 );




/**
 * Add certificate to order
 */

add_filter( 'woocommerce_email_attachments', 'attach_certificate_pdf_to_email', 10, 3);
function attach_certificate_pdf_to_email ( $attachments , $id, $object ) {

//    $allowed_statuses = array( 'customer_invoice', 'customer_completed_order' );
    
//    if( isset( $status ) && in_array ( $status, $allowed_statuses ) ) {

        $your_pdf_path = get_template_directory() . '/pdf/tmp/certificate_'.$object->id.'.pdf';
	$attachments[] = $your_pdf_path;
//    }
    return $attachments;
        
        
}

add_filter( 'woocommerce_email_attachments', 'attach_certificate_pdf_to_email2', 10, 3);
function attach_certificate_pdf_to_email2 ( $attachments , $id, $object ) {

	//    $allowed_statuses = array( 'customer_invoice', 'customer_completed_order' );

	//    if( isset( $status ) && in_array ( $status, $allowed_statuses ) ) {


	$your_pdf_path = get_template_directory() . '/pdf/tmpbill/Charity-bill_'.$object->id.'.pdf';

	$attachments[] = $your_pdf_path;
	//    }
	return $attachments;


}

add_action('woocommerce_email_order_details', 'ts_email_order_details', 10, 4);
function ts_email_order_details($order, $sent_to_admin, $plain_text, $email) {
	$id=$order->id;
	$salutation = get_post_meta($id,'_billing_salutation',true);
	$salutat = ucfirst($salutation);
	if (!empty($salutat)) {
		$salut = $salutat.'.';
	} else {
		$salut = 'Mr.(Mrs.)';
	}
	echo 'Dear '.$salut.' '.$order->get_billing_last_name().',<br>';
	echo '<br>Thank you for being a part of the Wiedmann Bible Family! We are in receipt of your donation of $'.$order->get_total().'  on '.date('F j, Y').' order #'.$order->get_order_number().' to adopt a Wiedmann Bible painting. Your generosity helps further our mission to engage more people with the Bible visually through events, exhibits and education.  We appreciate your support very much.<br>';
	echo 'No goods or services were received in return for this gift.<br>';
	echo 'As a 501(c)(3) non-profit organization, tax laws require us to notify you that this letter is the official acknowledgment of your donation.<br>';
  	echo 'Our Federal Tax ID number is 83-3278854.<br>';
  	echo 'For details about income tax deductions for charitable contributions please see IRS Publication 526, Charitable Contributions, or consult your tax adviser.<br><br>';
  	echo 'Wishing you many blessings,<br>Carolyn D. Rossinsky<br>';
  	echo 'President<br>';
  	echo 'Wiedmann Bible Foundation, Inc.<br><br>';

  	//add pdf
	$mpdf = new \Mpdf\Mpdf(
		['format'=>'A4']

	);
	$stylesheet = file_get_contents(__DIR__.'/pdf/style_pdf.css');
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML('
		<div style="font-family:Arial; margin-left:150px; margin-right:80px; padding-top:30px;">
			<div style="width:2.2cm; margin: auto;"><img src="/wp-content/themes/charitab-wp/img/WB_Foundation_LogoRGB144_2019-1.jpg" width="100%" height="auto" alt=""></div>
			<div>
				<br>
				From: 
				<br>
				Wiedmann Bible Foundation, Inc.
				<br>
				120 Kingsport Road 
				<br>
				Holly Springs, NC 27540 
				<br>
				'.date('F j, Y').'
				<br>
				<br> 
				To: 
				<br>
				'.$salut.' '.$order->get_billing_first_name().' '.$order->get_billing_last_name().'
				<br>
				'.$order->get_billing_address_1().'
				<br>
				'.$order->get_billing_city().', '.$order->get_billing_state().' '.$order-> get_billing_postcode().'
				<br>
				<br>
				Re: Your Charitable Donation '.date('Y').' 
				<br>
				<br>
				<br>
				Dear '.$salut.' '.$order->get_billing_last_name().',
				<br><br> 
				Thank you for being a part of the Wiedmann Bible Family! We are in receipt of 
				your donation of $'.$order->get_total().'  on '.date('F j, Y').' order #'.$order->get_order_number().' to adopt a Wiedmann Bible painting. Your 
				generosity helps further our mission to engage more people with the Bible 
				visually through events, exhibits and education.  We appreciate your support 
				very much! 
				<br>
				<br>
				No goods or services were received in return for this gift.
				<br>
				<br>
				As a 501(c)(3) non-profit organization, tax laws require us to notify you that this letter is the official acknowledgment of your donation.
				<br>
				<br> 
				Our Federal Tax ID number is 83-3278854. 
				<br>
				<br>
				For details about income tax deductions for charitable contributions please see IRS Publication 526, Charitable Contributions, or consult your tax adviser.
				<br>
				<br>
				Wishing you many blessings, 
				<br>
				<br>
				<br>
				<br>
				<img src="/wp-content/themes/charitab-wp/pdf/сr-signature.png" width="50%" height="auto" alt="">
				<br><br>
				President 
				<br><br>
				Wiedmann Bible Foundation, Inc.
			</div>
		</div>
	',2);
	$mpdf->Output(__DIR__.'/pdf/tmpbill/Charity-bill_'.$id.'.pdf');
}

add_action ('woocommerce_product_thumbnails','visual_editor_product');

function visual_editor_product() {
	echo '
		<div class="image-product-comment">
			<div id="image-comment"></div>
			<br>
			<div id="image-name"></div>
			<div>
			<span id="image-city"></span> <span id="image-location"></span>
			</div>
		</div>
	';
}

add_action( 'woocommerce_review_order_before_payment', 'action_function_checkout' );
function action_function_checkout( $checkout ){
    echo '<a href="https://family.wiedmannbible.org/shop/" class="checkout-button button alt wc-forward btn btn-theme-colored1 btn-sm">
		Adopt more pictures</a><br><br>';
}

//replace text for button in checkout

add_filter( 'woocommerce_order_button_html', 'misha_custom_button_html' );

function misha_custom_button_html( $button_html ) {
	$button_html = str_replace( 'Place order', 'Donate Now', $button_html );
	return $button_html;
}