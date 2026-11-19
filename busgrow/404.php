<?php
/**
 * 404 page.
 *
 * @package busgrow
 */

get_header();
?>
<div class="hero hero-page"><div class="wrap"><span class="eyebrow" style="color:var(--light)">Error 404</span><h1>We couldn’t find that page</h1><p class="lead" style="max-width:640px;font-size:1.15rem;margin-top:16px">The page may have moved or no longer exists. Try one of the links below.</p><div class="cta-row" style="margin-top:24px"><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to Home</a><a class="btn ghost" href="<?php echo esc_url( bg_url( 'contact' ) ); ?>">Contact Us</a></div></div></div>
<?php
get_footer();
