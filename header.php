<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blogistic
 */
use Blogistic\CustomizerDefault as BIT;

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<style>
		@media (max-width: 567px) {
			.main-header .site-branding-section {
				flex: 100% !important;
			}

			.image-content {
				flex: 0 0 100% !important;
			}
		}
	</style>

	<?php wp_head(); ?>
</head>

<body  <?php body_class('p-0'); ?>  <?php blogistic_schema_body_attributes(); ?> class="p-0">
	<?php wp_body_open(); ?>

	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'blogistic'); ?></a>
		<?php
		if (did_action('elementor/loaded') && class_exists('Nekit_Render_Templates_Html')):
			$Nekit_render_templates_html = new Nekit_Render_Templates_Html();
			if ($Nekit_render_templates_html->is_template_available('header')) {
				$header_rendered = true;
				echo $Nekit_render_templates_html->current_builder_template();
			} else {
				$header_rendered = false;
			}
		else:
			$header_rendered = false;
		endif;

		if (!$header_rendered):
			/**
			 * hook - blogistic_page_prepend_hook
			 * 
			 * hooked - blogistic_loader_html - 1
			 * hooked - blogistic_custom_header_html - 20
			 * 
			 * @package Blogistic
			 * @since 1.0.0
			 */
			do_action("blogistic_page_prepend_hook");
			?>
			<header id="masthead" class="site-header layout--one">
				<?php
				/**
				 * Function - blogistic_top_header_html
				 * 
				 * @since 1.0.0
				 * 
				 */
				blogistic_top_header_html();

				/**
				 * Function - blogistic_header_html
				 * 
				 * @since 1.0.0
				 * 
				 */
				blogistic_header_html();
				?>
			</header><!-- #masthead -->
			<?php
			blogistic_header_main_advertisement_part();

			/**
			 * Hook - blogistic_header_after_hook
			 * 
			 * Hooked  - blogistic_header_advertisement_part - 10
			 * Hooked  - blogistic_main_banner_html - 20
			 * Hooked  - blogistic_category_collection_html - 20
			 * Hooked  - blogistic_carousel_html - 30
			 * 
			 * @since 1.0.0
			 */
			do_action('blogistic_header_after_hook');
		endif;
