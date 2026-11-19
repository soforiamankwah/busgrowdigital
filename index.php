<?php
/**
 * Blog listing (posts page, categories, tags and search).
 *
 * @package busgrow
 */

get_header();
?>
<div class="hero hero-page"><div class="wrap">
<span class="eyebrow" style="color:var(--light)">The Busgrow Blog</span>
<h1>
<?php
if ( is_home() ) {
	echo 'Digital marketing insights that drive growth';
} elseif ( is_search() ) {
	echo 'Search results for “' . esc_html( get_search_query() ) . '”';
} else {
	echo wp_kses_post( get_the_archive_title() );
}
?>
</h1>
<p class="lead" style="max-width:640px;font-size:1.15rem;margin-top:16px">Guides on search engine optimization, paid ads, web design, social media and email marketing for your online business.</p>
</div></div>
<section><div class="wrap">
<?php if ( have_posts() ) : ?>
<div class="g3" id="all-blog">
	<?php
	while ( have_posts() ) {
		the_post();
		bg_post_card();
	}
	?>
</div>
	<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '&larr; Newer', 'next_text' => 'Older &rarr;' ) ); ?>
<?php else : ?>
<p class="lead">No articles yet. Check back soon.</p>
<?php endif; ?>
<div class="final" style="margin-top:64px"><h2>Want results like these for your brand?</h2><p>Skip the guesswork. Let our team build and run a growth plan for you.</p><a class="btn" href="<?php echo esc_url( bg_url( 'contact' ) ); ?>">Book a Free Strategy Call</a></div>
</div></section>
<?php
get_footer();
