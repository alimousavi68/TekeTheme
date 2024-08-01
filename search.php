<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Blogistic
 */

use Blogistic\CustomizerDefault as BIT;
get_header();

if( did_action( 'elementor/loaded' ) && class_exists( 'Nekit_Render_Templates_Html' ) ) :
	$Nekit_render_templates_html = new Nekit_Render_Templates_Html();
	if( $Nekit_render_templates_html->is_template_available('archive') ) {
		$search_rendered = true;
		echo $Nekit_render_templates_html->current_builder_template();
	} else {
		$search_rendered = false;
	}
else :
	$search_rendered = false;
endif;

if( ! $search_rendered ) : 
	do_action( 'blogistic_main_content_opening' );
	$search_page_sidebar_layout = BIT\blogistic_get_customizer_option( 'search_page_sidebar_layout' );
	if( in_array( $search_page_sidebar_layout, ['left-sidebar','both-sidebar'] )  ) get_sidebar('left');
	$search_page_form_show_hide = BIT\blogistic_get_customizer_option( 'search_page_form_show_hide' );
	$search_page_title = BIT\blogistic_get_customizer_option( 'search_page_title' );
	$archive_image_box_shadow = blogistic_get_box_shadow_option_class( 'archive_image_box_shadow', true );
	$archive_box_shadow = blogistic_get_box_shadow_option_class( 'archive_box_shadow');
	$elementClass = ' archive-align--' . BIT\blogistic_get_customizer_option('archive_post_elements_alignment');
	if( $archive_image_box_shadow ) $elementClass .= $archive_image_box_shadow;
	if( $archive_box_shadow ) $elementClass .= $archive_box_shadow;
	?>

		<main id="primary" class="site-main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						echo '<span class="search-page-title">'. apply_filters( 'blogistic_search_page_title_filter', esc_html( $search_page_title ) ) .'</span>';
						echo '<span>'. get_search_query() .'</span>';
						?>
					</h1>
					<?php if( $search_page_form_show_hide ) : ?>
						<div class="blogistic_search_page">
							<?php get_search_form(); ?>
						</div>
					<?php endif; ?>
				</header><!-- .page-header -->

				<?php
				echo '<div class="blogistic-inner-content-wrap'. esc_attr( $elementClass ) .'">'; //inner-content-wrap
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						// get_template_part( 'template-parts/content', 'search' );
						get_template_part( 'template-parts/archive/content', blogistic_get_post_format(), [ 'archive'	=>	false ] );

					endwhile;
				echo '</div>';

				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- #main -->

	<?php
	if( in_array( $search_page_sidebar_layout, ['right-sidebar','both-sidebar'] )  ) get_sidebar();
	do_action( 'blogistic_main_content_closing' );
endif;
get_footer();
