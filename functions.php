<?php 
/*
Theme Name: Basic Commerce Showroom
Theme URI: https://wordpress.org/themes/twentyseventeen/
Author: Basic Data
Author URI: https://www.basicdata.io/
Description: 
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: basiccommerceshowroom
Tags: one-column, two-columns, right-sidebar, flexible-header, accessibility-ready, custom-colors, custom-header, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, post-formats, rtl-language-support, sticky-post, theme-options, threaded-comments, translation-ready
This theme, like WordPress, is licensed under the GPL.
Use it to make something cool, have fun, and share what you've learned with others.
*/

include 'admin/admin_customizer.php';
include 'admin/widgets_templates.php';
include 'includes/bdt-login-screen.php';
include 'includes/bdt-woocommerce.php';

add_action( 'wp_enqueue_scripts', 'bdt_enqueue_script', 999 );

function bdt_enqueue_script() {
	wp_enqueue_script( 'bdt-jquery','https://code.jquery.com/jquery-3.3.1.slim.min.js',  array( 'jquery' ),'',true  );
	wp_enqueue_script( 'bdt-js-popper','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js',  array( 'jquery' ),'',true  );	
	wp_enqueue_script( 'bdt-js-bootstrap', get_template_directory_uri() . '/bootstrap/dist/js/bootstrap.min.js', array( 'jquery' ), '', true  );
	wp_enqueue_script('jquery');
	wp_enqueue_style( 'bdt_bootstrap', get_template_directory_uri() . '/bootstrap/dist/css/bootstrap.min.css' ); 
	wp_enqueue_style( 'bdt_main_css', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script( 'bdt_mobile_css', get_template_directory_uri() . '/assets/css/bdt_mobile_styles.css' );

	wp_enqueue_script( 'bdt-js-icons',  'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js',  array( 'jquery' ),'',true  );
	wp_enqueue_script( 'bdt-js-widgets',  'https://peptest.basicdata.io/wp-content/plugins/yith-woocommerce-ajax-product-filter-premium/assets/js/yith-wcan-frontend.min.js',  array( 'jquery' ),'',true  );
	
	//Custom Icons
	wp_register_style('basic-data-icons',  get_template_directory_uri().'/assets/basic-data-icons/css/basic-data-icons.css');
	wp_enqueue_style('basic-data-icons');
	
	

}

// Theme Support
function bdt_theme_support() {
   add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 200,
        'single_image_width'    => 500,
		'gallery_thumbnail_image_width' => 180,

        'product_grid'          => array(
			'max_columns'     => 4,
            'default_rows'    => 4,
			 'default_columns' => 1),
    ) );
	
	 add_theme_support( 'widgets' );
 
	
	add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'title-tag' );

}

add_action( 'after_setup_theme', 'bdt_theme_support' );

// Register Custom Navigation Walker
require_once get_template_directory() . '/bootstrap/wp-bootstrap-navwalker-master/class-wp-bootstrap-navwalker.php';


function is_bdt_mobile(  ){
	
	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

?>
