<?php
/**
 * Single blog article.
 *
 * @package busgrow
 */

get_header();
while ( have_posts() ) {
	the_post();
	$cats = get_the_category();
	$cat  = ! empty( $cats ) ? $cats[0]->name : 'Insights';
	?>
<section><div class="wrap"><article class="art">
<a class="back" href="<?php echo esc_url( bg_url( 'blog' ) ); ?>">← All articles</a>
<span class="tag"><?php echo esc_html( $cat ); ?></span>
<h1><?php the_title(); ?></h1>
<div class="bm">By the Busgrow Team · <?php echo esc_html( get_the_date( 'M j, Y' ) ); ?> · <?php echo esc_html( bg_read_time( get_the_ID() ) ); ?></div>
	<?php if ( has_post_thumbnail() ) : ?>
<div class="cover"><?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?></div>
	<?php endif; ?>
	<?php the_content(); ?>
<div class="final"><h2>Ready to put this into action?</h2><p>Our team can handle it for you, from strategy to results.</p><a class="btn" href="<?php echo esc_url( bg_opt( 'calendly' ) ); ?>" target="_blank" rel="noopener">Book a Free Call</a></div>
</article></div></section>
	<?php
}
get_footer();
