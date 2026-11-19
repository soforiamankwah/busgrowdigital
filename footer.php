</main>
<footer><div class="wrap">
<div class="fg">
<div><a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> home"><img src="<?php echo esc_url( bg_img( 'logo.png' ) ); ?>" alt="Busgrow Digital Agency logo" width="150" height="56"></a><p style="font-size:.92rem">Busgrow Digital Agency. Digital marketing, SEO and web design for online business growth.</p></div>
<div><h4>Quick Links</h4>
<?php
wp_nav_menu(
	array(
		'theme_location' => 'footer',
		'container'      => false,
		'items_wrap'     => '<ul>%3$s</ul>',
		'fallback_cb'    => 'bg_footer_fallback',
	)
);
?>
</div>
<div><h4>Contact</h4><ul class="ci">
<li><?php echo bg_icon( 'pin' ); ?><span><?php echo esc_html( bg_opt( 'address' ) ); ?></span></li>
<li><?php echo bg_icon( 'phone' ); ?><a href="tel:<?php echo esc_attr( bg_opt( 'phone_tel' ) ); ?>"><?php echo esc_html( bg_opt( 'phone' ) ); ?></a></li>
<li class="wa"><?php echo bg_icon( 'wa' ); ?><a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D/', '', bg_opt( 'whatsapp' ) ) ); ?>" target="_blank" rel="noopener">Chat on WhatsApp</a></li>
<li><?php echo bg_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( bg_opt( 'email1' ) ); ?>"><?php echo esc_html( bg_opt( 'email1' ) ); ?></a></li>
<?php if ( '' !== bg_opt( 'email2' ) ) : ?>
<li><?php echo bg_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( bg_opt( 'email2' ) ); ?>"><?php echo esc_html( bg_opt( 'email2' ) ); ?></a></li>
<?php endif; ?>
</ul></div>
<div><h4>Follow</h4><?php echo bg_social_links(); ?></div>
</div>
<div class="copy"><span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Busgrow Digital Agency. All rights reserved.</span><span>Digital Marketing · SEO · Online Business</span></div>
</div></footer>
<?php wp_footer(); ?>
</body>
</html>
