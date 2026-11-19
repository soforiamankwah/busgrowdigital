<?php
/**
 * One-time site setup that runs when the theme is activated:
 * creates the pages, sets the homepage and blog page, builds the menu
 * and adds the starter blog articles. Existing pages are never overwritten.
 *
 * @package busgrow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/posts-data.php';

function bg_page_defs() {
	return array(
		array(
			'slug'    => 'home',
			'title'   => 'Home',
			'file'    => 'home.html',
			'excerpt' => 'Busgrow Digital Agency helps businesses grow online with digital marketing, search engine optimization, web design and paid ads. Book a free strategy call.',
		),
		array(
			'slug'    => 'about',
			'title'   => 'About',
			'file'    => 'about.html',
			'excerpt' => 'Learn the story, mission and values behind Busgrow Digital Agency, your partner for SEO and online business growth.',
		),
		array(
			'slug'    => 'services',
			'title'   => 'Services',
			'file'    => 'services.html',
			'excerpt' => 'Web design, search engine optimization, PPC, social media, content, email marketing, analytics, strategy and CRM lead management services.',
		),
		array(
			'slug'    => 'lets-grow',
			'title'   => 'Let’s Grow',
			'file'    => 'lets-grow.html',
			'excerpt' => 'Browse websites, SEO, ads and social campaigns that helped online businesses grow.',
		),
		array(
			'slug'    => 'blog',
			'title'   => 'Blog',
			'file'    => '',
			'excerpt' => '',
		),
		array(
			'slug'    => 'contact',
			'title'   => 'Contact',
			'file'    => 'contact.html',
			'excerpt' => 'Contact Busgrow to book a free digital marketing strategy call. Call, email or send a message.',
		),
	);
}

function bg_attach_image( $post_id, $file ) {
	$path = get_template_directory() . '/assets/img/' . $file;
	if ( ! file_exists( $path ) ) {
		return;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$upload = wp_upload_bits( $file, null, file_get_contents( $path ) );
	if ( ! empty( $upload['error'] ) ) {
		return;
	}
	$attachment = array(
		'post_mime_type' => 'image/jpeg',
		'post_title'     => preg_replace( '/\.[^.]+$/', '', $file ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	);
	$att_id = wp_insert_attachment( $attachment, $upload['file'], $post_id );
	if ( $att_id && ! is_wp_error( $att_id ) ) {
		wp_update_attachment_metadata( $att_id, wp_generate_attachment_metadata( $att_id, $upload['file'] ) );
		set_post_thumbnail( $post_id, $att_id );
	}
}

function bg_create_post( $p ) {
	if ( get_page_by_path( $p['slug'], OBJECT, 'post' ) ) {
		return;
	}
	$cat_id = 0;
	$term   = term_exists( $p['cat'], 'category' );
	if ( ! $term ) {
		$term = wp_insert_term( $p['cat'], 'category' );
	}
	if ( is_array( $term ) ) {
		$cat_id = (int) $term['term_id'];
	}
	$ts = strtotime( $p['date'] . ' 09:00:00' );
	if ( ! $ts || $ts > time() ) {
		$ts = time() - DAY_IN_SECONDS;
	}
	$args = array(
		'post_title'   => $p['title'],
		'post_name'    => $p['slug'],
		'post_content' => $p['content'],
		'post_excerpt' => $p['excerpt'],
		'post_status'  => 'publish',
		'post_type'    => 'post',
		'post_date'    => gmdate( 'Y-m-d H:i:s', $ts ),
	);
	if ( $cat_id ) {
		$args['post_category'] = array( $cat_id );
	}
	$id = wp_insert_post( wp_slash( $args ) );
	if ( $id && ! is_wp_error( $id ) ) {
		bg_attach_image( $id, $p['image'] );
	}
}

function bg_install_site() {
	if ( get_option( 'bg_install_done' ) ) {
		return;
	}
	if ( '' === get_option( 'permalink_structure' ) ) {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
	}

	$defs  = bg_page_defs();
	$ids   = array();
	$fresh = array();
	foreach ( $defs as $def ) {
		$existing = get_page_by_path( $def['slug'] );
		if ( $existing ) {
			$ids[ $def['slug'] ] = (int) $existing->ID;
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_title'  => $def['title'],
				'post_name'   => $def['slug'],
				'post_status' => 'publish',
				'post_type'   => 'page',
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			$ids[ $def['slug'] ]   = (int) $id;
			$fresh[ $def['slug'] ] = true;
		}
	}

	if ( ! empty( $fresh['home'] ) && ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}
	if ( ! empty( $fresh['blog'] ) && ! empty( $ids['blog'] ) ) {
		update_option( 'page_for_posts', $ids['blog'] );
	}

	$map = array( '{{img}}' => get_template_directory_uri() . '/assets/img' );
	foreach ( $ids as $slug => $id ) {
		$map[ '{{u:' . $slug . '}}' ] = get_permalink( $id );
	}
	foreach ( $defs as $def ) {
		$slug = $def['slug'];
		if ( empty( $fresh[ $slug ] ) ) {
			continue;
		}
		$content = '';
		if ( '' !== $def['file'] ) {
			$path = get_template_directory() . '/inc/pages/' . $def['file'];
			if ( file_exists( $path ) ) {
				$content = strtr( file_get_contents( $path ), $map );
			}
		}
		wp_update_post(
			wp_slash(
				array(
					'ID'           => $ids[ $slug ],
					'post_content' => $content,
					'post_excerpt' => $def['excerpt'],
				)
			)
		);
		if ( '' !== $def['file'] ) {
			update_post_meta( $ids[ $slug ], '_wp_page_template', 'template-full.php' );
		}
	}

	$menu_name = 'Busgrow Main Menu';
	if ( ! wp_get_nav_menu_object( $menu_name ) ) {
		$menu_id = wp_create_nav_menu( $menu_name );
		if ( $menu_id && ! is_wp_error( $menu_id ) ) {
			$order = array( 'home', 'about', 'services', 'lets-grow', 'blog', 'contact' );
			foreach ( $order as $slug ) {
				if ( empty( $ids[ $slug ] ) ) {
					continue;
				}
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'     => get_the_title( $ids[ $slug ] ),
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $ids[ $slug ],
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					)
				);
			}
			$locations = get_theme_mod( 'nav_menu_locations' );
			if ( ! is_array( $locations ) ) {
				$locations = array();
			}
			$locations['primary'] = $menu_id;
			$locations['footer']  = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	foreach ( bg_default_posts() as $post_data ) {
		bg_create_post( $post_data );
	}

	update_option( 'bg_install_done', 1 );
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'bg_install_site' );
