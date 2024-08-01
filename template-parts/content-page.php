<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blogistic
 */
use Blogistic\CustomizerDefault as BIT;
$page_title_option = BIT\blogistic_get_customizer_option( 'page_title_option' );
$page_title_tag = BIT\blogistic_get_customizer_option( 'page_title_tag' );
$page_image_box_shadow = blogistic_get_box_shadow_option_class( 'page_image_box_shadow', true );
$page_box_shadow = blogistic_get_box_shadow_option_class( 'page_box_shadow');
$custom_class = '';
if( $page_image_box_shadow ) $custom_class .= $page_image_box_shadow;
if( $page_box_shadow ) $custom_class .= $page_box_shadow;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $custom_class ); ?>>
	<?php
		if( $page_title_option ) :
	?>
			<header class="entry-header">
				<?php the_title( '<' .esc_html( $page_title_tag ). ' class="entry-title">', '</' .esc_html( $page_title_tag ). '>' ); ?>
			</header><!-- .entry-header -->
	<?php
		endif;

		$page_thumbnail_option = BIT\blogistic_get_customizer_option( 'page_thumbnail_option' );
		if( $page_thumbnail_option ) :
			$page_thumbnail_option = BIT\blogistic_get_customizer_option( 'page_thumbnail_option' );
			$page_image_size = BIT\blogistic_get_customizer_option( 'page_image_size' );
			if( has_post_thumbnail() ) blogistic_post_thumbnail( $page_image_size );
		endif;
	?>

	<div class="entry-content">
		<?php
			$page_content_option = BIT\blogistic_get_customizer_option( 'page_content_option' );
			if( $page_content_option ) the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blogistic' ),
					'after'  => '</div>',
				)
			);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'blogistic' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
