<?php
/**
 * Customizer: Appearance > Customize > Busgrow Settings.
 *
 * @package busgrow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bg_customize( $wp_customize ) {
	$wp_customize->add_section(
		'bg_settings',
		array(
			'title'       => 'Busgrow Settings',
			'description' => 'Contact details and social links used in the header, footer and Contact page.',
			'priority'    => 30,
		)
	);
	$labels = array(
		'calendly'  => 'Booking link (header "Book a Call" button)',
		'phone'     => 'Phone number (as shown)',
		'phone_tel' => 'Phone number for tap-to-call (e.g. +233554520083)',
		'whatsapp'  => 'WhatsApp number (digits only, with country code)',
		'email1'    => 'Main email (also receives contact form messages)',
		'email2'    => 'Second email',
		'address'   => 'Address',
		'hours'     => 'Opening hours',
		'linkedin'  => 'LinkedIn page URL',
		'instagram' => 'Instagram page URL',
		'facebook'  => 'Facebook page URL',
		'tiktok'    => 'TikTok page URL',
		'youtube'   => 'YouTube channel URL',
		'snapchat'  => 'Snapchat page URL',
	);
	foreach ( bg_defaults() as $key => $value ) {
		$wp_customize->add_setting(
			'bg_' . $key,
			array(
				'default'           => $value,
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'bg_' . $key,
			array(
				'label'   => isset( $labels[ $key ] ) ? $labels[ $key ] : $key,
				'section' => 'bg_settings',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'bg_customize' );
