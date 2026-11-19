<?php
/**
 * Template Name: Busgrow Full Width Page
 *
 * Shows the page content edge to edge (the design sections live in the page itself).
 *
 * @package busgrow
 */

get_header();
while ( have_posts() ) {
	the_post();
	the_content();
}
get_footer();
