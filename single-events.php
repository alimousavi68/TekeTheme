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

if (did_action('elementor/loaded') && class_exists('Nekit_Render_Templates_Html')):
	$Nekit_render_templates_html = new Nekit_Render_Templates_Html();
	if ($Nekit_render_templates_html->is_template_available('single')) {
		$single_rendered = true;
		echo $Nekit_render_templates_html->current_builder_template();
	} else {
		$single_rendered = false;
	}
else:
	$single_rendered = false;
endif;
?>
<style>
	p{
		text-align: justify;
	}
</style>
<?php
if (!$single_rendered):

	?>
	<div class="blogistic-container d-flex p-0 justify-content-center w-100">
		<main id="primary" class="site-main">
			<?php
			echo '<div class="blogistic-inner-content-wrap">'; //inner-content-wrap
			while (have_posts()):
				the_post();
				?>
				<style>
					body {
						font-family: Arial, sans-serif;
						line-height: 1.6;
						direction: rtl;
						text-align: right;
						margin: 0;
						padding: 0;
					}

					.container {
						display: flex;
						flex-direction: row;
						justify-content: space-between;
						align-items: flex-start;
						margin: 20px;
					}

					.text-content {
						flex: 1;
						margin-left: 20px;
					}

					.image-content {
						flex: 0 0 300px;
					}

					.image-content img {
						max-width: 100%;
						border-radius: 10px;
					}

					h1 {
						font-size: 24px;
						margin-bottom: 10px;
					}

					p {
						margin-bottom: 10px;
					}
				</style>
				<div class=" d-flex flex-column gap-3">
					<div class="d-flex row m-0">
					<div class="col-12 col-lg-4 image-content ">
							<?php
							the_post_thumbnail('large');
							?>
						</div>
						<div class="col-12 col-lg-8 text-content">
							<h1><?php the_title(); ?></h1>
							<p> <?php the_excerpt(); ?></p>
						</div>
						
					</div>
					<div class="i8-content ">
						<?php the_content(); ?>
					</div>
				</div>
				<?php
			endwhile; // End of the loop.
			echo '</div><!-- .blogistic-inner-content-wrap -->'; //inner-content-wrap
			?>
		</main><!-- #main -->
	</div>
	<?php
	// 	$array['position'] = ['right-sidebar', 'both-sidebar'];
// 	if (in_array($single_sidebar_layout, ['right-sidebar', 'both-sidebar']))
// 		get_sidebar();
// 	do_action('blogistic_main_content_closing');
endif;

get_footer();