<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Blogistic
 */
use Blogistic\CustomizerDefault as BIT;
get_header();

if( did_action( 'elementor/loaded' ) && class_exists( 'Nekit_Render_Templates_Html' ) ) :
	$Nekit_render_templates_html = new Nekit_Render_Templates_Html();
	if( $Nekit_render_templates_html->is_template_available('single') ) {
		$single_rendered = true;
		echo $Nekit_render_templates_html->current_builder_template();
	} else {
		$single_rendered = false;
	}
else :
	$single_rendered = false;
endif;

if( ! $single_rendered ) :
	do_action( 'blogistic_main_content_opening' );
	$single_sidebar_layout = BIT\blogistic_get_customizer_option( 'single_sidebar_layout' );
	if( in_array( $single_sidebar_layout, [ 'left-sidebar', 'both-sidebar' ] ) ) get_sidebar( 'left' );
	?>
		<main id="primary" class="site-main">
			<?php
				echo '<div class="blogistic-inner-content-wrap">'; //inner-content-wrap
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'single' );
					endwhile; // End of the loop.
				echo '</div><!-- .blogistic-inner-content-wrap -->'; //inner-content-wrap
			?>
		</main><!-- #main -->
	<?php
	$array['position'] = ['right-sidebar', 'both-sidebar'];
	if( in_array( $single_sidebar_layout, [ 'right-sidebar', 'both-sidebar' ] ) ) get_sidebar();
	do_action( 'blogistic_main_content_closing' );
endif;

get_footer();