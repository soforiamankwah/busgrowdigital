<?php
/**
 * Shortcodes used inside the page content.
 *
 * [bg_posts count="3"]  Latest blog cards.
 * [bg_contact_form]     Contact form.
 * [bg_contact_info]     Contact details, map link and social icons (from Busgrow Settings).
 *
 * @package busgrow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bg_sc_posts( $atts ) {
	$a = shortcode_atts( array( 'count' => 3 ), $atts );
	$q = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => (int) $a['count'],
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	ob_start();
	while ( $q->have_posts() ) {
		$q->the_post();
		bg_post_card();
	}
	wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode( 'bg_posts', 'bg_sc_posts' );

function bg_sc_contact_info() {
	$address = bg_opt( 'address' );
	$wa      = preg_replace( '/\D/', '', bg_opt( 'whatsapp' ) );
	$h       = '<div class="info">';
	$h      .= '<div class="irow"><div class="ico">' . bg_icon( 'pin' ) . '</div><div><b>Visit us</b><small>' . esc_html( $address ) . '</small></div></div>';
	$h      .= '<div class="irow"><div class="ico">' . bg_icon( 'phone' ) . '</div><div><b>Call us</b><small><a href="tel:' . esc_attr( bg_opt( 'phone_tel' ) ) . '">' . esc_html( bg_opt( 'phone' ) ) . '</a></small></div></div>';
	$h      .= '<div class="irow"><div class="ico wa">' . bg_icon( 'wa' ) . '</div><div><b>WhatsApp</b><small><a href="https://wa.me/' . esc_attr( $wa ) . '" target="_blank" rel="noopener">Chat with us on WhatsApp</a></small></div></div>';
	$h      .= '<div class="irow"><div class="ico">' . bg_icon( 'mail' ) . '</div><div><b>Email us</b><small><a href="mailto:' . esc_attr( bg_opt( 'email1' ) ) . '">' . esc_html( bg_opt( 'email1' ) ) . '</a>';
	if ( '' !== bg_opt( 'email2' ) ) {
		$h .= '<br><a href="mailto:' . esc_attr( bg_opt( 'email2' ) ) . '">' . esc_html( bg_opt( 'email2' ) ) . '</a>';
	}
	$h .= '</small></div></div>';
	$h .= '<div class="irow"><div class="ico">' . bg_icon( 'clock' ) . '</div><div><b>Hours</b><small>' . esc_html( bg_opt( 'hours' ) ) . '</small></div></div>';
	$h .= '<div class="map"><div><span class="pin">📍</span><b>Busgrow Digital Agency</b><br>' . esc_html( $address ) . '<br>';
	$h .= '<a class="btn sm" style="margin-top:14px;background:#fff;color:var(--deep);border-color:#fff" href="https://www.google.com/maps/search/?api=1&amp;query=' . rawurlencode( $address ) . '" target="_blank" rel="noopener">Open in Google Maps</a></div></div>';
	$h .= '<div><b>Follow us</b>' . bg_social_links( 'margin-top:10px' ) . '</div>';
	$h .= '</div>';
	return $h;
}
add_shortcode( 'bg_contact_info', 'bg_sc_contact_info' );
