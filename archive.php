<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blogistic
 */
use Blogistic\CustomizerDefault as BIT;
get_header();

if( did_action( 'elementor/loaded' ) && class_exists( 'Nekit_Render_Templates_Html' ) ) :
	$Nekit_render_templates_html = new Nekit_Render_Templates_Html();
	if( $Nekit_render_templates_html->is_template_available('archive') ) {
		$archive_rendered = true;
		echo $Nekit_render_templates_html->current_builder_template();
	} else {
		$archive_rendered = false;
	}
else :
	$archive_rendered = false;
endif;

if( ! $archive_rendered ) :
	do_action( 'blogistic_main_content_opening' );
	$archive_sidebar_layout = BIT\blogistic_get_customizer_option( 'archive_sidebar_layout' );
	$archive_image_box_shadow = blogistic_get_box_shadow_option_class( 'archive_image_box_shadow', true );
	$archive_box_shadow = blogistic_get_box_shadow_option_class( 'archive_box_shadow');
	$elementClass = ' archive-align--' . BIT\blogistic_get_customizer_option('archive_post_elements_alignment');
	if( $archive_image_box_shadow ) $elementClass .= $archive_image_box_shadow;
	if( $archive_box_shadow ) $elementClass .= $archive_box_shadow;
	if( in_array( $archive_sidebar_layout, ['left-sidebar','both-sidebar'] )  ) get_sidebar('left');
	?>
		<main id="primary" class="site-main">
			<?php
				if ( have_posts() ) :
					$ads_info = blogistic_algorithm_to_push_ads_in_archive();
					$count = 0;
					echo '<div class="blogistic-inner-content-wrap'. esc_attr( $elementClass ) .'">'; //inner-content-wrap
						while ( have_posts() ) : the_post();
							if( ! is_null( $ads_info ) ) :
								if( in_array( $wp_query->current_post, $ads_info['random_numbers'] ) ) :
									blogistic_random_post_archive_advertisement_part( is_array( $ads_info['ads_to_render'] ) ? $ads_info['ads_to_render'][$count] : $ads_info['ads_to_render'] );
									$count++;
								endif;
							endif;
							/*
							* Include the Post-Type-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Type name) and that will be used instead.
							*/
							get_template_part( 'template-parts/archive/content', blogistic_get_post_format(), [ 'archive'	=>	true ] );
							// $post_counter++;
						endwhile;
					echo '</div>'; //  end: blogistic-inner-content-wrap
					
					/**
					 * hook - blogistic_pagination_link_hook
					 * 
					 * @package Blogistic
					 * @since 1.0.0
					 */
					do_action( 'blogistic_pagination_link_hook' );
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
			?>
		</main><!-- #main -->

	<?php
	if( in_array( $archive_sidebar_layout, ['right-sidebar','both-sidebar'] )  ) get_sidebar();

	do_action( 'blogistic_main_content_closing' );
endif;
get_footer();