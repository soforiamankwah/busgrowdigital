<?php
/**
 * Theme setup, scripts and SEO helpers.
 *
 * @package busgrow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bg_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'automatic-feed-links' );
	add_post_type_support( 'page', 'excerpt' );
	set_post_thumbnail_size( 1200, 675, true );
	register_nav_menus(
		array(
			'primary' => 'Primary Menu (header)',
			'footer'  => 'Footer Menu (quick links)',
		)
	);
}
add_action( 'after_setup_theme', 'bg_setup' );

function bg_enqueue() {
	wp_enqueue_style( 'bg-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', array(), null );
	wp_enqueue_style( 'bg-style', get_stylesheet_uri(), array( 'bg-fonts' ), BG_VERSION );
	wp_enqueue_script( 'bg-main', get_template_directory_uri() . '/assets/js/main.js', array(), BG_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'bg_enqueue' );

function bg_nav_link_atts( $atts, $item, $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$atts['class'] = 'l';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'bg_nav_link_atts', 10, 3 );

function bg_document_title( $title ) {
	if ( is_front_page() ) {
		return 'Busgrow Digital Agency | Digital Marketing, SEO & Web Design';
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'bg_document_title' );

function bg_meta_description() {
	if ( defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'AIOSEO_VERSION' ) ) {
		return;
	}
	$d = '';
	if ( is_front_page() ) {
		$d = 'Busgrow Digital Agency helps businesses grow online with digital marketing, search engine optimization, web design and paid ads. Book a free strategy call.';
	} elseif ( is_singular() ) {
		$d = wp_strip_all_tags( get_the_excerpt( get_queried_object_id() ) );
	} elseif ( is_home() ) {
		$d = 'Read expert articles on digital marketing, search engine optimization, paid ads, web design, social media and email marketing.';
	}
	if ( '' !== $d ) {
		echo '<meta name="description" content="' . esc_attr( $d ) . '">' . "\n";
	}
	echo '<meta name="keywords" content="digital marketing, search engine optimization, online business">' . "\n";
	if ( ! has_site_icon() ) {
		echo '<link rel="icon" href="' . esc_url( bg_img( 'logo.png' ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'bg_meta_description', 1 );

function bg_excerpt_more( $more ) {
	return '…';
}
add_filter( 'excerpt_more', 'bg_excerpt_more' );
