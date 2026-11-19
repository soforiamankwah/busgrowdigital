<?php
/**
 * Default page template: title banner plus the page content.
 *
 * @package busgrow
 */

get_header();
while ( have_posts() ) {
	the_post();
	?>
<div class="hero hero-page"><div class="wrap"><h1><?php the_title(); ?></h1></div></div>
<section><div class="wrap"><article class="art"><?php the_content(); ?></article></div></section>
	<?php
}
get_footer();
