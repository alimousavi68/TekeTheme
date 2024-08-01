<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blogistic
 */
use Blogistic\CustomizerDefault as BIT;
$single_post_content_alignment = BIT\blogistic_get_customizer_option( 'single_post_content_alignment' );
?>
<article <?php blogistic_schema_article_attributes(); ?> id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-inner">
		<?php
			$single_post_layout = BIT\blogistic_get_customizer_option( 'single_post_layout' );
			if( in_array( $single_post_layout, [ 'layout-one' ] ) ) :
				$single_thumbnail_option = BIT\blogistic_get_customizer_option( 'single_thumbnail_option' );
				$single_category_option = BIT\blogistic_get_customizer_option( 'single_category_option' );
				if( $single_thumbnail_option ) :
						?>
						<header class="entry-header" >
							<?php
								$single_image_size = BIT\blogistic_get_customizer_option( 'single_image_size' );
								blogistic_post_thumbnail( $single_image_size );
								if( $single_category_option ) blogistic_get_post_categories( get_the_ID(), 20 );
							?>
						</header><!-- .entry-header -->
					<?php
				endif;
				get_template_part( 'template-parts/single/partial', 'meta' );
			endif;

			// social share
			$elementClass = 'post-format-ss-wrap';
			echo '<div class="'. esc_attr( $elementClass ) .'">';
			echo '</div><!-- .post-format-ss-wrap -->';
		?>
		<div <?php blogistic_schema_article_body_attributes(); ?> class="entry-content<?php echo esc_attr( ' content-alignment--' . $single_post_content_alignment ); ?>">
			<?php
				do_action( 'blogistic_before_single_content_hook' );
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'blogistic' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);
				do_action( 'blogistic_after_single_content_hook' );

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blogistic' ),
						'after'  => '</div>',
					)
				);
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php
				$tag_count = get_tags([ 'object_ids' => get_the_ID() ]);
				if( count( $tag_count ) != 0 ) :
					blogistic_tags_list();
				endif;
					blogistic_entry_footer();
			?>
		</footer><!-- .entry-footer -->

	</div>

	<?php
		$author_box_option = BIT\blogistic_get_customizer_option( 'single_author_box_option' );
		$single_author_image_option = BIT\blogistic_get_customizer_option( 'single_author_box_image_option' );
		$single_author_title_option = BIT\blogistic_get_customizer_option( 'single_author_info_box_title_option' );
		$single_author_description_option = BIT\blogistic_get_customizer_option( 'single_author_info_box_description_option' );
		if( $author_box_option ) : 
	?>
			<div class="post-card author-wrap">
				<div class="bmm-author-thumb-wrap">
					<?php
						if( $single_author_image_option ) echo '<figure class="post-thumb">'. get_avatar( get_the_author_meta( 'ID' ) ) .'</figure>';
					?>
					<div class="author-elements">
						<?php
							if( $single_author_title_option ) echo '<h2 class="author-name"><a href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) .'">'. get_the_author() .'</a></h2>';
							if( $single_author_description_option && ! empty( get_the_author_meta( 'description' ) ) ) echo '<div class="author-desc">'. get_the_author_meta( 'description' ) .'</div>';
						?>
					</div>
				</div>
			</div>
		<?php endif;
		

		$post_navigation_option = BIT\blogistic_get_customizer_option( 'single_post_navigation_option' );
		if( $post_navigation_option ) :
			$post_navigation_thumbnail_option = BIT\blogistic_get_customizer_option( 'single_post_navigation_thumbnail_option' );
			$post_navigation_date_option = BIT\blogistic_get_customizer_option( 'single_post_navigation_show_date' );
			$prev_post_date = $prev_post_thumbnail = $prev_post_navigation_sub_title = '';
			$next_post_date = $next_post_thumbnail = $next_post_navigation_sub_title = '';
			$previous = get_previous_post();
			$next = get_next_post();
			
			// date
			if( $post_navigation_date_option ) :
				$prev_post_date = ! empty( $previous ) ? '<span class="nav-post-date">' . blogistic_posted_on( $previous->ID, '', [ 'return' => true ] ) . '</span>' : '';
				$next_post_date = ! empty( $next ) ? '<span class="nav-post-date">' . blogistic_posted_on( $next->ID, '', [ 'return' => true ] ) . '</span>' : '';
			endif;

			// thumbnail
			if( $post_navigation_thumbnail_option ) :
				$prev_post_thumbnail = ( ! empty( $previous ) ) ? get_the_post_thumbnail_url( $previous->ID ) : '';
				$next_post_thumbnail = ( ! empty( $next ) ) ? get_the_post_thumbnail_url( $next->ID  ) : '';
			endif;

			// sub-title
			$prev_post_navigation_sub_title = '<span class="nav-subtitle"><i class="fa-solid fa-arrow-left"></i></span>';
			$next_post_navigation_sub_title = '<span class="nav-subtitle"><i class="fa-solid fa-arrow-right"></i></span>';

			// title
			$post_navigation_title = '<span class="nav-title">%title</span>';	
			
			echo get_the_post_navigation(
				[
					'prev_text' => '<div class="button-thumbnail">'. $prev_post_navigation_sub_title .'<figure class="nav-thumb" style="background-image:url('. $prev_post_thumbnail .')"></figure></div><div class="nav-post-elements">'. $prev_post_date . '<div class="nav-title-wrap">' . $post_navigation_title. '</div></div>',
					'next_text' => '<div class="nav-post-elements">'. $next_post_date . '<div class="nav-title-wrap">' . $post_navigation_title .'</div></div><div class="button-thumbnail"><figure class="nav-thumb" style="background-image:url('. $next_post_thumbnail .')"></figure>'. $next_post_navigation_sub_title .'</div>'
				]
			);
		endif;
	?>
		
	<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php
	/**
	 * hook - blogistic_single_post_append_hook
	 * 
	 * @since 1.0.0
	 */
	do_action( 'blogistic_single_post_append_hook' );