<?php
/**
 * Helper functions.
 *
 * @package busgrow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default values for the settings in Appearance > Customize > Busgrow Settings.
 */
function bg_defaults() {
	return array(
		'calendly'  => 'https://calendly.com/busgrowdigital/30min',
		'phone'     => '+233 55 452 0083',
		'phone_tel' => '+233554520083',
		'whatsapp'  => '233554520083',
		'email1'    => 'hello@busgrowdigital.com',
		'email2'    => 'busgrowdigital@gmail.com',
		'address'   => 'Santa Maria, Accra, Ghana',
		'hours'     => 'Mon–Fri, 8:00am – 6:00pm',
		'linkedin'  => 'https://www.linkedin.com/',
		'instagram' => 'https://www.instagram.com/',
		'facebook'  => 'https://www.facebook.com/',
		'tiktok'    => 'https://www.tiktok.com/',
		'youtube'   => 'https://www.youtube.com/',
		'snapchat'  => 'https://www.snapchat.com/',
	);
}

/**
 * Get a setting (Customizer value or default).
 */
function bg_opt( $key ) {
	$defaults = bg_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return get_theme_mod( 'bg_' . $key, $default );
}

/**
 * URL of an image in the theme's assets/img folder.
 */
function bg_img( $file ) {
	return get_template_directory_uri() . '/assets/img/' . $file;
}

/**
 * URL of one of the main pages by slug.
 */
function bg_url( $slug ) {
	if ( 'home' === $slug ) {
		return home_url( '/' );
	}
	if ( 'blog' === $slug ) {
		$posts_page = (int) get_option( 'page_for_posts' );
		if ( $posts_page ) {
			return get_permalink( $posts_page );
		}
	}
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( $page->ID );
	}
	return home_url( '/' . $slug . '/' );
}

/**
 * Estimated reading time for a post.
 */
function bg_read_time( $post_id ) {
	$words   = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
	$minutes = (int) ceil( $words / 200 );
	if ( $minutes < 1 ) {
		$minutes = 1;
	}
	return $minutes . ' min read';
}

/**
 * Print one blog card (use inside the loop).
 */
function bg_post_card() {
	$cats = get_the_category();
	$cat  = ! empty( $cats ) ? $cats[0]->name : 'Insights';
	$url  = get_permalink();
	$img  = '';
	if ( has_post_thumbnail() ) {
		$img = get_the_post_thumbnail( get_the_ID(), 'large', array( 'alt' => get_the_title(), 'loading' => 'lazy' ) );
	}
	echo '<article class="work"><a class="im" href="' . esc_url( $url ) . '" aria-label="' . esc_attr( get_the_title() ) . '">' . $img . '</a>';
	echo '<div class="tx"><span class="tag">' . esc_html( $cat ) . '</span>';
	echo '<h3 style="margin-top:6px"><a href="' . esc_url( $url ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
	echo '<p>' . esc_html( wp_strip_all_tags( get_the_excerpt() ) ) . '</p>';
	echo '<div class="bm">' . esc_html( get_the_date( 'M j, Y' ) ) . ' · ' . esc_html( bg_read_time( get_the_ID() ) ) . '</div>';
	echo '<a class="link" href="' . esc_url( $url ) . '">Read article &rarr;</a></div></article>';
}

/**
 * Social icons.
 */
function bg_social_links( $style = '' ) {
	$map = array(
		'linkedin'  => array( 's-li', 'LinkedIn' ),
		'instagram' => array( 's-ig', 'Instagram' ),
		'facebook'  => array( 's-fb', 'Facebook' ),
		'tiktok'    => array( 's-tt', 'TikTok' ),
		'youtube'   => array( 's-yt', 'YouTube' ),
		'snapchat'  => array( 's-sc', 'Snapchat' ),
	);
	$out = '<div class="soc"';
	if ( '' !== $style ) {
		$out .= ' style="' . esc_attr( $style ) . '"';
	}
	$out .= '>';
	foreach ( $map as $key => $m ) {
		$url = bg_opt( $key );
		if ( '' === $url ) {
			continue;
		}
		$out .= '<a class="' . esc_attr( $m[0] ) . '" href="' . esc_url( $url ) . '" target="_blank" rel="noopener" aria-label="' . esc_attr( $m[1] ) . '" title="' . esc_attr( $m[1] ) . '">' . bg_social_svg( $key ) . '</a>';
	}
	return $out . '</div>';
}

/**
 * Menu fallbacks (used until a menu is assigned).
 */
function bg_nav_fallback() {
	$items = array(
		'home'      => 'Home',
		'about'     => 'About',
		'services'  => 'Services',
		'lets-grow' => 'Let’s Grow',
		'blog'      => 'Blog',
		'contact'   => 'Contact',
	);
	echo '<ul>';
	foreach ( $items as $slug => $label ) {
		echo '<li><a class="l" href="' . esc_url( bg_url( $slug ) ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

function bg_footer_fallback() {
	$items = array(
		'home'      => 'Home',
		'about'     => 'About',
		'services'  => 'Services',
		'lets-grow' => 'Let’s Grow',
		'blog'      => 'Blog',
		'contact'   => 'Contact',
	);
	echo '<ul>';
	foreach ( $items as $slug => $label ) {
		echo '<li><a href="' . esc_url( bg_url( $slug ) ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}
