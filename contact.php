<?php
/**
 * Contact form: shortcode and submit handler (sends an email with wp_mail).
 *
 * @package busgrow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bg_sc_contact_form() {
	$sent = isset( $_GET['sent'] ) ? sanitize_text_field( wp_unslash( $_GET['sent'] ) ) : '';
	$h    = '<form id="cform" method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	$h   .= '<h2 style="font-size:1.6rem">Send us a message</h2>';
	$h   .= '<input type="hidden" name="action" value="bg_contact">';
	$h   .= wp_nonce_field( 'bg_contact', 'bg_nonce', true, false );
	$h   .= '<div style="position:absolute;left:-9999px" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>';
	$h   .= '<div class="two"><label>Name<input name="name" required autocomplete="name" placeholder="Your full name"></label>';
	$h   .= '<label>Email<input type="email" name="email" required autocomplete="email" placeholder="you@company.com"></label></div>';
	$h   .= '<label>Phone<input type="tel" name="phone" autocomplete="tel" placeholder="+233 ..."></label>';
	$h   .= '<label>Message<textarea name="message" rows="5" required placeholder="Tell us about your business and goals"></textarea></label>';
	$h   .= '<button class="btn" type="submit">Send Message →</button>';
	if ( '1' === $sent ) {
		$h .= '<div class="ok show" id="ok" role="status">Thank you! Your message has been sent. We’ll reply within one business day.</div>';
	} elseif ( 'error' === $sent ) {
		$h .= '<div class="ok show err" id="ok" role="alert">Sorry, your message could not be sent. Please check your details and try again, or email us directly.</div>';
	}
	$h .= '</form>';
	return $h;
}
add_shortcode( 'bg_contact_form', 'bg_sc_contact_form' );

function bg_contact_redirect( $status ) {
	$back = wp_get_referer();
	if ( ! $back ) {
		$back = home_url( '/' );
	}
	$back = remove_query_arg( 'sent', $back );
	wp_safe_redirect( add_query_arg( 'sent', $status, $back ) );
	exit;
}

function bg_handle_contact() {
	$nonce = isset( $_POST['bg_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['bg_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'bg_contact' ) ) {
		bg_contact_redirect( 'error' );
	}
	if ( ! empty( $_POST['website'] ) ) {
		bg_contact_redirect( '1' );
	}
	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	if ( '' === $name || ! is_email( $email ) || '' === $message ) {
		bg_contact_redirect( 'error' );
	}
	$to      = bg_opt( 'email1' );
	$subject = 'Website enquiry from ' . $name;
	$body    = "Name: " . $name . "\nEmail: " . $email . "\nPhone: " . $phone . "\n\n" . $message;
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );
	$ok      = wp_mail( $to, $subject, $body, $headers );
	bg_contact_redirect( $ok ? '1' : 'error' );
}
add_action( 'admin_post_nopriv_bg_contact', 'bg_handle_contact' );
add_action( 'admin_post_bg_contact', 'bg_handle_contact' );
