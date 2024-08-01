<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blogistic
 */

 use Blogistic\CustomizerDefault as BIT;

 if( did_action( 'elementor/loaded' ) && class_exists( 'Nekit_Render_Templates_Html' ) ) :
	$Nekit_render_templates_html = new Nekit_Render_Templates_Html();
	if( $Nekit_render_templates_html->is_template_available('footer') ) {
		$footer_rendered = true;
		echo $Nekit_render_templates_html->current_builder_template();
	} else {
		$footer_rendered = false;
	}
 else :
	$footer_rendered = false;
 endif;

 	if( ! $footer_rendered ) :
		/**
		 * hook - blogistic_before_footer_hook
		 * 
		 * hooked - blogistic_footer_advertisement_part - 10
		 * hooked - blogistic_you_may_have_missed_html - 100
		 */
		! is_single() && do_action( 'blogistic_before_footer_hook' );
		?>
		<footer id="colophon" class="site-footer dark_bk">
			<?php
				/**
				 * Function - footer_sections_html
				 * 
				 * @since 1.0.0
				 * 
				 */
				footer_sections_html();
				
				/**
				 * Function - blogistic_bottom_footer_sections_html
				 * 
				 * @since 1.0.0
				 * 
				 */
				blogistic_bottom_footer_sections_html();
			?>
		</footer><!-- #colophon -->
		<?php
		/**
		* hook - blogistic_after_footer_hook
		*
		* @hooked - blogistic_scroll_to_top
		*
		*/
		if( has_action( 'blogistic_after_footer_hook' ) ) {
			do_action( 'blogistic_after_footer_hook' );
		}

		/**
		 * hook - blogistic_animation_hook
		 * 
		 * hooked - blogistic_get_background_and_cursor_animation
		 */
		do_action( 'blogistic_animation_hook' );
	endif;
?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
