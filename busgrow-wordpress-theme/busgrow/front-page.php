<?php
/**
 * Front page: shows the content of the page set as the homepage.
 *
 * @package busgrow
 */

if ( ! is_page() ) {
	// Site is set to show latest posts: use the blog listing instead.
	get_template_part( 'index' );
	return;
}

get_header();
while ( have_posts() ) {
	the_post();
	the_content();
}
get_footer();
