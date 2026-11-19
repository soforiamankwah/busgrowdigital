<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>
<header>
<div class="wrap bar">
<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> home"><img src="<?php echo esc_url( bg_img( 'logo.png' ) ); ?>" alt="Busgrow Digital Agency logo" width="150" height="56"></a>
<nav id="nav" aria-label="Main navigation">
<?php
wp_nav_menu(
	array(
		'theme_location' => 'primary',
		'container'      => false,
		'items_wrap'     => '<ul>%3$s</ul>',
		'fallback_cb'    => 'bg_nav_fallback',
	)
);
?>
<a class="btn sm m-cta" href="<?php echo esc_url( bg_opt( 'calendly' ) ); ?>" target="_blank" rel="noopener">Book a Call</a>
</nav>
<a class="btn sm nav-cta" href="<?php echo esc_url( bg_opt( 'calendly' ) ); ?>" target="_blank" rel="noopener">Book a Call</a>
<button class="burger" id="burger" aria-label="Toggle menu" aria-expanded="false"><span></span><span></span><span></span></button>
</div>
</header>
<main id="main">
