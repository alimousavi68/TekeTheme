<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Blogistic
 */
use Blogistic\CustomizerDefault as BIT;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function blogistic_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}
	
	if( is_archive() || is_home() ) {
		$archive_post_layout = BIT\blogistic_get_customizer_option( 'archive_post_layout' );
		$archive_sidebar_layout = BIT\blogistic_get_customizer_option( 'archive_sidebar_layout' );
		$archive_post_column = BIT\blogistic_get_customizer_option( 'archive_post_column' );
		$classes[] = 'archive-desktop-column--' . esc_attr( blogistic_convert_number_to_numeric_string( $archive_post_column['desktop'] ) );
		$classes[] = 'archive-tablet-column--' . esc_attr( blogistic_convert_number_to_numeric_string( $archive_post_column['tablet'] ) );
		$classes[] = 'archive-mobile-column--' . esc_attr( blogistic_convert_number_to_numeric_string( $archive_post_column['smartphone'] ) );
		$classes[] = 'archive--' . esc_attr( $archive_post_layout )  . '-layout';
		$classes[] = 'archive--' . esc_attr( $archive_sidebar_layout );
	}

	if( is_single() ) {
		$single_post_layout = BIT\blogistic_get_customizer_option( 'single_post_layout' );
		$single_sidebar_layout = BIT\blogistic_get_customizer_option( 'single_sidebar_layout' );
		$classes[] = 'single-post--' . esc_attr( $single_post_layout );
		$classes[] = 'single--' . esc_attr( $single_sidebar_layout );
	}

	if( is_search() ) {
		$search_page_sidebar_layout = BIT\blogistic_get_customizer_option( 'search_page_sidebar_layout' );
		$archive_post_layout = BIT\blogistic_get_customizer_option( 'archive_post_layout' );
		$archive_post_column = BIT\blogistic_get_customizer_option( 'archive_post_column' );
		$classes[] = 'archive-desktop-column--' . esc_attr( blogistic_convert_number_to_numeric_string( $archive_post_column['desktop'] ) );
		$classes[] = 'archive-tablet-column--' . esc_attr( blogistic_convert_number_to_numeric_string( $archive_post_column['tablet'] ) );
		$classes[] = 'archive-mobile-column--' . esc_attr( blogistic_convert_number_to_numeric_string( $archive_post_column['smartphone'] ) );
		$classes[] = 'search-page--' . $search_page_sidebar_layout;
		$classes[] = 'archive--' . esc_attr( $archive_post_layout ) . '-layout';
	}

	if( is_404() ) {
		$error_page_sidebar_layout = BIT\blogistic_get_customizer_option( 'error_page_sidebar_layout' );
		$classes[] = 'error-page--' . $error_page_sidebar_layout;
	}

	if( is_page() ) {
		$page_settings_sidebar_layout = BIT\blogistic_get_customizer_option( 'page_settings_sidebar_layout' );
		$classes[] = 'page--' . esc_attr( $page_settings_sidebar_layout );
	}

	$classes[] = 'blogistic-light-mode';

	$website_layout = BIT\blogistic_get_customizer_option ('website_layout');
	if( $website_layout ) $classes[] = $website_layout;
	
	$title_hover = BIT\blogistic_get_customizer_option( 'post_title_hover_effects' );
	$classes[] = 'title-hover--' . esc_attr( $title_hover );

	$image_hover = BIT\blogistic_get_customizer_option( 'site_image_hover_effects' );
	$classes[] = 'image-hover--' . esc_attr( $image_hover );

	$global_sidebar_option = BIT\blogistic_get_customizer_option( 'sidebar_sticky_option' );
	$classes[] = 'blogistic-stickey-sidebar--'. esc_attr( $global_sidebar_option ? 'enabled' : 'disabled' );
	$classes[] = ' blogistic_font_typography';
	
	$site_background_animation = BIT\blogistic_get_customizer_option( 'site_background_animation' );
	$classes[] = 'background-animation--' . $site_background_animation;

	$archive_hide_image_placeholder  = BIT\blogistic_get_customizer_option( 'archive_hide_image_placeholder' );	
	if( $archive_hide_image_placeholder ) $classes[] = 'archive-image-placeholder--enabled';

	return $classes;
}
add_filter( 'body_class', 'blogistic_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function blogistic_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'blogistic_pingback_header' );

if( ! function_exists( 'blogistic_get_multicheckbox_categories_simple_array' ) ) :
	/**
	 * Return array of categories prepended with "*" key.
	 * 
	 */
	function blogistic_get_multicheckbox_categories_simple_array() {
		$categories_list = get_categories([ 'number' => 6 ]);
		$cats_array = [];
		foreach( $categories_list as $cat ) :
			$cats_array[] = [
				'value'	=> esc_html( $cat->term_id ),
				'label'	=> esc_html( str_replace ( [ '\'', '"' ], '', $cat->name ) )  . ' (' .absint( $cat->count ). ')'
			];
		endforeach;
		return $cats_array;
	}
endif;

if( ! function_exists( 'blogistic_get_multicheckbox_tags_simple_array' ) ) :
	/**
	 * Return array of tags prepended with "*" key.
	 * 
	 */
	function blogistic_get_multicheckbox_tags_simple_array() {
		$tags_list = get_tags(['number'=>6]);
		$tags_array = [];
		foreach( $tags_list as $tag ) :
			$tags_array[] = array( 
				'value'	=> esc_html( $tag->term_id ),
				'label'	=> esc_html(str_replace(array('\'', '"'), '', $tag->name))  . ' (' .absint( $tag->count ). ')'
			);
		endforeach;
		return $tags_array;
	}
endif;

if( ! function_exists( 'blogistic_get_multicheckbox_users_simple_array' ) ) :
	/**
	 * Return array of users prepended with "*" key.
	 * 
	 */
	function blogistic_get_multicheckbox_users_simple_array() {
		$users_list = get_users(['number' => 6]);
		$users_array = [];
		foreach( $users_list as $user ) :
			$users_array[] = array( 
				'value'	=> esc_html( $user->ID ),
				'label'	=> esc_html(str_replace(array('\'', '"'), '', $user->display_name))
			);
		endforeach;
		return $users_array;
	}
endif;

if( ! function_exists( 'blogistic_get_multicheckbox_posts_simple_array' ) ) :
	/**
	 * Return array of posts prepended with "*" key.
	 * 
	 */
	function blogistic_get_multicheckbox_posts_simple_array() {
		$post_args = array( 'numberposts' => 6 );
		$posts_list = get_posts( apply_filters( 'blogistic_query_args_filter', $post_args ) );
		$posts_array = [];
		foreach( $posts_list as $postItem ) :
			$posts_array[] = array( 
				'value'	=> esc_html( $postItem->ID ),
				'label'	=> esc_html(str_replace(array('\'', '"'), '', $postItem->post_title))
			);
		endforeach;
		return $posts_array;
	}
endif;

if( ! function_exists( 'blogistic_get_categories_html' ) ) :
	/**
	 * Return categories in <ul> <li> form
	 * 
	 * @since 1.0.0
	 */
	function blogistic_get_categories_html() {
		$blogistic_categoies = get_categories( [ 'object_ids' => get_the_ID() ] );
		$post_cagtegories_html = '<ul class="post-categories">';
		foreach( $blogistic_categoies as $category_key => $category_value ) :
			$post_cagtegories_html .= '<li class="cat-item item-'. ( $category_key + 1 ) .'">'. esc_html( $category_value->name ) .'</li>';
		endforeach;
		$post_cagtegories_html .= '</ul>';
		return $post_cagtegories_html;
	}
endif;

if( ! function_exists( 'blogistic_post_order_args' ) ) :
	/**
	 * Return post order args
	 * 
	 * @since 1.0.0
	 */
	function blogistic_post_order_args() {
		return [
			'date-desc' =>  esc_html__( 'Newest - Oldest', 'blogistic' ),
			'date-asc' =>  esc_html__( 'Oldest - Newest', 'blogistic' ),
			'title-asc' =>  esc_html__( 'A - Z', 'blogistic' ),
			'title-desc' =>  esc_html__( 'Z - A', 'blogistic' ),
			'rand-desc' =>  esc_html__( 'Random', 'blogistic' )
		];
	}
endif;

if( ! function_exists( 'blogistic_get_image_sizes_option_array' ) ) :
	/**
	 * Get list of image sizes
	 * 
	 * @since 1.0.0
	 * @package Blogistic
	 */
	function blogistic_get_image_sizes_option_array() {
		$image_sizes = get_intermediate_image_sizes();
		foreach( $image_sizes as $image_size ) :
			$sizes[$image_size] = $image_size;
		endforeach;
		return $sizes;
	}
endif;

add_filter( 'get_the_archive_title_prefix', 'blogistic_prefix_string' );
function blogistic_prefix_string($prefix) {
	return apply_filters( 'blogistic_archive_page_title_prefix', false );
}

if( ! function_exists( 'blogistic_widget_control_get_tags_options' ) ) :
	/**
	 * @since 1.0.0
	 * @package Blogistic
	 */
	function blogistic_widget_control_get_tags_options() {
        check_ajax_referer( 'blogistic_widget_nonce', 'security' );
        $searchKey = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ): '';
        $to_exclude = isset( $_POST['exclude'] ) ? sanitize_text_field( wp_unslash( $_POST['exclude'] ) ): '';
        $type = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ): '';
		if( $type == 'category' ) :
			$posts_list = get_categories( [ 'number' => 4, 'search' => esc_html( $searchKey ), 'exclude' => explode( ',', $to_exclude ) ] );
		elseif( $type == 'tag' ) :
			$posts_list = get_tags( [ 'number' => 4, 'search' => esc_html( $searchKey ), 'exclude' => explode( ',', $to_exclude ) ] );
		elseif( $type == 'user' ):
			$posts_list = new \WP_User_Query([ 'number' => 4, 'search' => esc_html( $searchKey ), 'exclude' => explode( ',', $to_exclude ) ]);
			if( ! empty( $posts_list->get_results() ) ):
				foreach( $posts_list->get_results() as $user ) :
					$user_array[] = [
						'id'	=>	$user->ID,
						'text'	=>	$user->display_name
					];
				endforeach;
				wp_send_json_success( $user_array );
			else:
				wp_send_json_success( '' );
			endif;
		else:
			$post_args = [
				'post_type' =>  'post',
				'post_status'=>  'publish',
				'posts_per_page'    =>  6,
				'post__not_in' => explode( ',', $to_exclude ),
				's' => esc_html( $searchKey )
			];
			$posts_query = new \WP_Query( apply_filters( 'blogistic_query_args_filter', $post_args ) );
			if( $posts_query->have_posts() ) :
				while( $posts_query->have_posts() ) :
					$posts_query->the_post();
					$post_array[] =	[
						'id'	=>	get_the_ID(),
						'text'	=>	get_the_title()
					];
				endwhile;
				wp_send_json_success( $post_array );
			endif;
		endif;
		if( ! empty( $posts_list ) ) :
			foreach( $posts_list as $postItem ) :
				$posts_array[] = [	
					'id'	=> esc_html( $postItem->term_taxonomy_id ),
					'text'	=> esc_html( $postItem->name .'('. $postItem->count .')' )
				];
			endforeach;
			wp_send_json_success( $posts_array );
		endif;
        wp_die();
    }
	add_action( 'wp_ajax_blogistic_widget_control_get_tags_options', 'blogistic_widget_control_get_tags_options' );
	
endif;

if( ! function_exists( 'blogistic_customizer_social_icons' ) ) :
	/**
	 * Function to get social icons from customizer
	 * 
	 * @since 1.0.0
	 * @package Blogistic
	 */
	function blogistic_customizer_social_icons() {
		$social_icons_target = BIT\blogistic_get_customizer_option( 'social_icons_target' );
		$social_icons = BIT\blogistic_get_customizer_option( 'social_icons' );
		$social_icon_official_color_inherit = BIT\blogistic_get_customizer_option( 'social_icon_official_color_inherit' );
		$social_icons_decode = json_decode( $social_icons );
		$elementClass = 'blogistic-social-icon';
		if( $social_icon_official_color_inherit ) $elementClass .= ' official-color--enabled';
		echo '<div class="'. esc_attr( $elementClass ) .'">';
			foreach( $social_icons_decode as $social_icon ) :
				if( $social_icon->item_option == 'show' ) echo '<a href="'. esc_url( $social_icon->icon_url ) .'"><i class="'. esc_attr( $social_icon->icon_class ) .'"></i></a>';
			endforeach;
		echo '</div>';
	}
endif;

require get_template_directory() . '/inc/extras/helpers.php';
require get_template_directory() . '/inc/extras/extras.php';
require get_template_directory() . '/inc/widgets/widgets.php'; // widget handlers
require get_template_directory() . '/inc/hooks/hooks.php'; // hooks handlers

/**
 * GEt appropriate color value
 * 
 * @since 1.0.0
 */
if(! function_exists('blogistic_get_color_format')):
    function blogistic_get_color_format($color) {
      if( str_contains( $color, '--blogistic-global-preset' ) ) {
        return( 'var( ' .esc_html( $color ). ' )' );
      } else {
        return $color;
      }
    }
endif;

if( ! function_exists( 'blogistic_current_styles' ) ) :
	/**
	 * Generates the current changes in styling of the theme.
	 * 
	 * @package Blogistic
	 * @since 1.0.0
	 */
	function blogistic_current_styles() {
		// enqueue inline style
		ob_start();
			// preset colors
			$bcPresetCode = function($var,$id) {
				blogistic_assign_preset_var($var,$id);
			};
			$bcPresetCode( "--blogistic-global-preset-color-1", "preset_color_1" );$bcPresetCode( "--blogistic-global-preset-color-2", "preset_color_2" );$bcPresetCode( "--blogistic-global-preset-color-3", "preset_color_3" );$bcPresetCode( "--blogistic-global-preset-color-4", "preset_color_4" );$bcPresetCode( "--blogistic-global-preset-color-5", "preset_color_5" );$bcPresetCode( "--blogistic-global-preset-color-6", "preset_color_6" );$bcPresetCode( "--blogistic-global-preset-color-7", "preset_color_7" );$bcPresetCode( "--blogistic-global-preset-color-8", "preset_color_8" );$bcPresetCode( "--blogistic-global-preset-color-9", "preset_color_9" );$bcPresetCode( "--blogistic-global-preset-color-10", "preset_color_10" );$bcPresetCode( "--blogistic-global-preset-color-11", "preset_color_11" );$bcPresetCode( "--blogistic-global-preset-color-12", "preset_color_12" );$bcPresetCode( "--blogistic-global-preset-gradient-color-1", "preset_gradient_1" );$bcPresetCode( "--blogistic-global-preset-gradient-color-2", "preset_gradient_2" );$bcPresetCode( "--blogistic-global-preset-gradient-color-3", "preset_gradient_3" );$bcPresetCode( "--blogistic-global-preset-gradient-color-4", "preset_gradient_4" );$bcPresetCode( "--blogistic-global-preset-gradient-color-5", "preset_gradient_5" );$bcPresetCode( "--blogistic-global-preset-gradient-color-6", "preset_gradient_6" );$bcPresetCode( "--blogistic-global-preset-gradient-color-7", "preset_gradient_7" );$bcPresetCode( "--blogistic-global-preset-gradient-color-8", "preset_gradient_8" );$bcPresetCode( "--blogistic-global-preset-gradient-color-9", "preset_gradient_9" );$bcPresetCode( "--blogistic-global-preset-gradient-color-10", "preset_gradient_10" );$bcPresetCode( "--blogistic-global-preset-gradient-color-11", "preset_gradient_11" );$bcPresetCode( "--blogistic-global-preset-gradient-color-12", "preset_gradient_12" );

			/** Value Change With Responsive **/
			blogistic_value_change_responsive('body .site-branding img', 'blogistic_site_logo_width','width');
			blogistic_value_change_responsive('body .site-header .mode-toggle i','blogistic_theme_mode_icon_size','font-size');
			blogistic_value_change_responsive('body .site-header .mode-toggle img', 'blogistic_theme_mode_icon_size','width');
			blogistic_value_change_responsive('body .blogistic-carousel-section .post-date i','carousel_design_post_date_icon_size','font-size');
			blogistic_value_change_responsive('body .blogistic-carousel-section .post-date img','carousel_design_post_date_icon_size','width');
			blogistic_value_change_responsive('.back_to_home_btn a i','error_page_button_icon_size','font-size');
			blogistic_value_change_responsive('.back_to_home_btn a img','error_page_button_icon_size','width');
			blogistic_value_change_responsive('.main-header .blogistic-container .row','header_vertical_padding','padding-top');
			blogistic_value_change_responsive('.main-header .blogistic-container .row','header_vertical_padding','padding-bottom');
			blogistic_value_change_responsive('.blogistic-category-collection-section .category-wrap a','category_collection_image_radius','border-radius');
			blogistic_value_change_responsive('body .bottom-inner-wrapper .footer-logo img', 'bottom_footer_logo_width','width');
			blogistic_value_change_responsive('.single #blogistic-main-wrap .blogistic-container','single_article_width','width', '%');
			
			blogistic_spacing_control( '.post-thumnail-inner-wrapper', 'archive_image_border_radius', 'border-radius' );
			blogistic_spacing_control( 'body footer .bottom-inner-wrapper', 'bottom_footer_padding', 'padding' );
			
			/** Value Change **/
			blogistic_value_change('body .blogistic-carousel-section article.post-item','carousel_section_border_radius','border-radius');
			blogistic_value_change('body #blogistic-main-wrap > .blogistic-container > .row#primary .blogistic-inner-content-wrap article.post .blogistic-article-inner','archive_section_border_radius','border-radius');
			blogistic_value_change('body .widget, body #widget_block','sidebar_border_radius','border-radius');
			blogistic_value_change('body.single-post .entry-header .post-thumbnail img, body.single-post .post-thumbnail.no-single-featured-image, body.single-post #blogistic-main-wrap .blogistic-container .row#primary .blogistic-inner-content-wrap article > div, body.single-post #blogistic-main-wrap .blogistic-container .row#primary nav.navigation, body.single-post #blogistic-main-wrap .blogistic-container .row#primary .single-related-posts-section-wrap.layout--list, body.single-post #primary article .post-card .bmm-author-thumb-wrap','single_image_border_radius','border-radius');
			blogistic_value_change('body.page-template-default.blogistic_font_typography #primary article .post-thumbnail img','page_image_border_radius','border-radius');
			blogistic_value_change('.single .blogistic-table-of-content.display--fixed .toc-wrapper', 'toc_sticky_width','width');
			blogistic_value_change('.page .blogistic-table-of-content.display--fixed .toc-wrapper', 'page_toc_sticky_width','width');

			/** Color Group (no Gradient) (Variable) **/
			$bcColorAssign = function($var,$id) {
				blogistic_assign_var($var,$id);
			};
			blogistic_assign_var('--blogistic-global-preset-theme-color','theme_color');
			blogistic_assign_var('--blogistic-global-preset-gradient-theme-color','gradient_theme_color');
			/** Text Color (Variable) **/
			blogistic_variable_color('--blogistic-menu-color', 'header_menu_color');
			blogistic_variable_color('--blogistic-menu-color-submenu', 'header_sub_menu_color');
			blogistic_variable_color('--blogistic-cateegory-collection-color', 'category_collection_text_color');
			blogistic_variable_color('--blogistic-custom-button-color', 'blogistic_custom_button_text_color');
			blogistic_variable_color('--blogistic-custom-button-icon-color', 'blogistic_custom_button_icon_color');
			blogistic_variable_color('--blogistic-theme-mode-color', 'blogistic_theme_mode_light_icon_color');
			blogistic_variable_color('--blogistic-theme-darkmode-color', 'blogistic_theme_mode_dark_icon_color');
			blogistic_variable_color('--blogistic-search-icon-color', 'blogistic_search_icon_color');
			blogistic_variable_color('--blogistic-breadcrumb-link-color', 'breadcrumb_link_color');
			blogistic_variable_color('--blogistic-canvas-icon-color', 'canvas_menu_icon_color');
			blogistic_variable_color('--blogistic-pagination-color', 'pagination_text_color');
			blogistic_variable_color('--blogistic-footer-title-text', 'footer_title_color');
			blogistic_variable_color('--blogistic-bottom-footer-link-color', 'bottom_footer_link_color');
			blogistic_variable_color('--blogistic-ajax-pagination-color', 'pagination_button_text_color');

			/** variable text color single **/
			blogistic_variable_color_single('--blogistic-breadcrumb-color', 'breadcrumb_text_color');
			blogistic_variable_color_single('--blogistic-bottom-footer-text-color','bottom_footer_text_color');
			blogistic_variable_color_single('--blogistic-footer-white-text','footer_text_color');
			blogistic_variable_color_single('--blogistic-animation-object-color','animation_object_color');
			blogistic_variable_color_single('--blogistic-youmaymissed-block-title-color','you_may_have_missed_title_color');
			/** Background Color (Variable) **/
			blogistic_variable_bk_color('--blogistic-custom-button-bk-color','header_custom_button_background_color_group');
			blogistic_variable_bk_color('--blogistic-ajax-pagination--bkcolor','pagination_button_background_color');
			blogistic_variable_bk_color('--blogistic-404-button-bkcolor','error_page_button_background_color');
			blogistic_variable_bk_color('--blogistic-scroll-top-bk-color','stt_background_color_group');

			blogistic_border_option('body #primary article .blogistic-article-inner .post-thumnail-inner-wrapper','archive_image_border','border');
			blogistic_border_option('body.single-post #blogistic-main-wrap .blogistic-container .row.entry-header .post-thumbnail img, body.single-post.single-post--layout-three #blogistic-main-wrap .blogistic-container-fluid .post-thumbnail img','single_image_border','border');
			blogistic_border_option('body.page-template-default #primary article .post-thumbnail img','page_image_border','border');
			blogistic_border_option('footer.site-footer','footer_border_top','border-top');
			blogistic_border_option('footer.site-footer .bottom-footer','bottom_footer_border_top','border-top');
			blogistic_border_option('body article .post-footer','archive_border_bottom_color','border-top');
			blogistic_border_option('body .widget_block .wp-block-group__inner-container .wp-block-heading, body section.widget  .widget-title, body .widget_block.widget_search .wp-block-search__label','widgets_border_bottom_color','border-bottom');
			blogistic_border_option('.widget ul.wp-block-latest-posts li, .widget ol.wp-block-latest-comments li, .widget ul.wp-block-archives li, .widget ul.wp-block-categories li, .widget ul.wp-block-page-list li, .widget .widget ul.menu li, aside .widget_blogistic_post_grid_widget .post-grid-wrap .post-item, aside .widget_blogistic_post_list_widget .post-list-wrap .post-item, .canvas-menu-sidebar .widget_blogistic_post_list_widget .post-list-wrap .post-item, .canvas-menu-sidebar ul.wp-block-latest-posts li, .canvas-menu-sidebar ol.wp-block-latest-comments li, .canvas-menu-sidebar  ul.wp-block-archives li, .canvas-menu-sidebar  ul.wp-block-categories li, .canvas-menu-sidebar ul.wp-block-page-list li, .canvas-menu-sidebar .widget ul.menu li', 'widgets_secondary_border_bottom_color','border-bottom');
			// Category Bk Color
			blogistic_category_bk_colors_styles();
			blogistic_tags_bk_colors_styles();

			/* Typography (Variable) */
			$bTypoCode = function($identifier,$id) {
				blogistic_get_typo_style($identifier,$id);
			};
			$bTypoCode( "--blogistic-site-title", 'site_title_typo' );
			$bTypoCode( "--blogistic-site-description", 'site_description_typo' );
			$bTypoCode("--blogistic-menu", 'main_menu_typo');
			$bTypoCode("--blogistic-submenu", 'main_menu_sub_menu_typo');
			$bTypoCode("--blogistic-custom-button", 'blogistic_custom_button_text_typography');
			$bTypoCode("--blogistic-post-title-font","archive_title_typo");
			$bTypoCode("--blogistic-post-content-font","archive_excerpt_typo");
			$bTypoCode("--blogistic-date-font","archive_date_typo");
			$bTypoCode("--blogistic-readtime-font","archive_read_time_typo");
			$bTypoCode("--blogistic-comment-font","archive_comment_typo");
			$bTypoCode("--blogistic-category-collection-font","category_collection_typo");
			$bTypoCode("--blogistic-category-font","archive_category_typo");
			$bTypoCode("--blogistic-widget-block-font","sidebar_block_title_typography");
			$bTypoCode("--blogistic-widget-title-font","sidebar_post_title_typography");
			$bTypoCode("--blogistic-widget-date-font","sidebar_date_typography");
			$bTypoCode("--blogistic-widget-category-font","sidebar_category_typography");
			$bTypoCode("--blogistic-author-font", "archive_author_typo");
			$bTypoCode("--blogistic-readmore-font", "global_button_typo");
			$bTypoCode("--blogistic-youmaymissed-block-title-font", "you_may_have_missed_design_section_title_typography");
			$bTypoCode("--blogistic-youmaymissed-title-font", "you_may_have_missed_design_post_title_typography");
			$bTypoCode("--blogistic-youmaymissed-category-font", "you_may_have_missed_design_post_categories_typography");
			$bTypoCode("--blogistic-youmaymissed-date-font", "you_may_have_missed_design_post_date_typography");
			$bTypoCode("--blogistic-youmaymissed-author-font", "you_may_have_missed_design_post_author_typography");

			/* typo vale change */
			blogistic_get_typo_style_value('.blogistic-main-banner-section .main-banner-wrap .post-elements .post-title', 'main_banner_design_post_title_typography');
			blogistic_get_typo_style_value('.blogistic-main-banner-section .post-categories .cat-item a','main_banner_design_post_categories_typography');
			blogistic_get_typo_style_value('.blogistic-main-banner-section .main-banner-wrap .post-elements .post-excerpt','main_banner_design_post_excerpt_typography');
			blogistic_get_typo_style_value('.blogistic-main-banner-section .main-banner-wrap .post-elements .post-date','main_banner_design_post_date_typography');
			blogistic_get_typo_style_value('.blogistic-main-banner-section .main-banner-wrap .byline','main_banner_design_post_author_typography');
			blogistic_get_typo_style_value('.blogistic-carousel-section .carousel-wrap .post-elements .post-title', 'carousel_design_post_title_typography');
			blogistic_get_typo_style_value('.blogistic-carousel-section .post-categories .cat-item a','carousel_design_post_categories_typography');
			blogistic_get_typo_style_value('.blogistic-carousel-section .carousel-wrap .post-elements .post-excerpt','carousel_design_post_excerpt_typography');
			blogistic_get_typo_style_value('.blogistic-carousel-section .carousel-wrap .post-elements .post-date','carousel_design_post_date_typography');
			blogistic_get_typo_style_value('.blogistic-carousel-section .carousel-wrap .byline','carousel_design_post_author_typography');
			blogistic_get_typo_style_value('#blogistic-main-wrap #primary .not-found .page-title','error_page_title_typo');
			blogistic_get_typo_style_value('#blogistic-main-wrap #primary .not-found .page-content p','error_page_content_typo');
			blogistic_get_typo_style_value('#blogistic-main-wrap #primary .not-found .page-content .back_to_home_btn span','error_page_button_text_typo');

			/* typo vale body */
			blogistic_get_typo_style_body_value('body.blogistic_font_typography.archive.category .page-header .page-title, .archive.date .page-header .page-title','archive_category_info_box_title_typo');
			blogistic_get_typo_style_body_value('body.blogistic_font_typography.archive.category .page-header .archive-description','archive_category_info_box_description_typo');
			blogistic_get_typo_style_body_value('body.blogistic_font_typography.archive.tag .page-header .page-title','archive_tag_info_box_title_typo');
			blogistic_get_typo_style_body_value('body.blogistic_font_typography.archive.tag .page-header .archive-description','archive_tag_info_box_description_typo');
			blogistic_get_typo_style_body_value('body.blogistic_font_typography.archive.author .page-header .page-title','archive_author_info_box_title_typo');
			blogistic_get_typo_style_body_value('body.blogistic_font_typography.archive.author .page-header .archive-description','archive_author_info_box_description_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography .site-main article .entry-content','single_content_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography .site-main article .entry-title','single_title_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography .site-main article .post-meta-wrap .byline','single_author_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography .post-meta-wrap .post-date','single_date_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography #primary .blogistic-inner-content-wrap .post-meta  .post-read-time','single_read_time_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography #primary article .post-categories .cat-item a','single_category_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography .single-header-content-wrap .entry-title','single_title_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography .single-header-content-wrap .post-meta-wrap .byline','single_author_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography .single-header-content-wrap.post-meta .post-date','single_date_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography .single-header-content-wrap .post-meta  .post-read-time','single_read_time_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography .single-header-content-wrap .post-meta  .post-comments-num','single_read_time_typo');
			blogistic_get_typo_style_body_value('body.single-post.blogistic_font_typography .single-header-content-wrap .post-categories .cat-item a','single_category_typo');
			blogistic_get_typo_style_body_value('body .blogistic-widget-loader .load-more','sidebar_pagination_button_typo');
			blogistic_get_typo_style_body_value('body.page.blogistic_font_typography #blogistic-main-wrap #primary article .entry-title','page_title_typo');
			blogistic_get_typo_style_body_value('body.page.blogistic_font_typography article .entry-content','page_content_typo');
			blogistic_get_typo_style_body_value('body .blogistic-breadcrumb-wrap ul li','breadcrumb_typo');
			blogistic_get_typo_style_body_value('body footer .footer-inner .widget_block .wp-block-group__inner-container .wp-block-heading, body footer .footer-inner section.widget .widget-title, body footer .footer-inner .wp-block-heading', 'footer_title_typography');
			blogistic_get_typo_style_body_value('body footer .footer-inner ul.wp-block-latest-posts a, body footer .footer-inner ol.wp-block-latest-comments li footer, body footer .footer-inner ul.wp-block-archives a, body footer .footer-inner ul.wp-block-categories a, body footer .footer-inner ul.wp-block-page-list a, body footer .footer-inner .widget_blogistic_post_grid_widget .post-grid-wrap .post-title, body footer .footer-inner .menu .menu-item a, body footer .footer-inner .widget_blogistic_category_collection_widget .categories-wrap .category-item .category-name, body footer .widget_blogistic_post_list_widget .post-list-wrap .post-title a', 'footer_text_typography');
			blogistic_get_typo_style_body_value('body .bottom-inner-wrapper .site-info', 'bottom_footer_text_typography');
			blogistic_get_typo_style_body_value('body .bottom-inner-wrapper .site-info a', 'bottom_footer_link_typography');
			blogistic_get_typo_style_body_value('body article h1','heading_one_typo');
			blogistic_get_typo_style_body_value('body article h2','heading_two_typo');
			blogistic_get_typo_style_body_value('body article h3','heading_three_typo');
			blogistic_get_typo_style_body_value('body article h4','heading_four_typo');
			blogistic_get_typo_style_body_value('body article h5','heading_five_typo');
			blogistic_get_typo_style_body_value('body article h6','heading_six_typo');
			blogistic_get_typo_style_body_value('body aside h1.wp-block-heading','sidebar_heading_one_typography');
			blogistic_get_typo_style_body_value('body aside h2.wp-block-heading','sidebar_heading_two_typo');
			blogistic_get_typo_style_body_value('body aside h3.wp-block-heading','sidebar_heading_three_typo');
			blogistic_get_typo_style_body_value('body aside h4.wp-block-heading','sidebar_heading_four_typo');
			blogistic_get_typo_style_body_value('body aside h5.wp-block-heading','sidebar_heading_five_typo');
			blogistic_get_typo_style_body_value('body aside h6.wp-block-heading','sidebar_heading_six_typo');

			/* Image Ratio */
			blogistic_image_ratio('body .blogistic-main-banner-section article.post-item .post-thumb','main_banner_responsive_image_ratio');
			blogistic_image_ratio('body .blogistic-carousel-section article.post-item .post-thumb, body .blogistic-carousel-section.carousel-layout--two article.post-item .post-thumb','carousel_responsive_image_ratio');
			blogistic_image_ratio('body .blogistic-category-collection-section .category-wrap:before','category_collection_image_ratio');
			
			blogistic_image_ratio_variable('--blogistic-post-image-ratio','archive_responsive_image_ratio');
			blogistic_image_ratio_variable('--blogistic-list-post-image-ratio','archive_responsive_image_ratio');
			blogistic_image_ratio_variable('--blogistic-single-post-image-ratio','single_responsive_image_ratio');
			blogistic_image_ratio_variable('--blogistic-single-page-image-ratio', 'page_responsive_image_ratio' );
			blogistic_image_ratio_variable('--blogistic-youmaymissed-image-ratio', 'you_may_have_missed_responsive_image_ratio' );

			/* box shadow */
			blogistic_box_shadow_styles('.blogistic-category-collection-section.box-shadow--enabled .category-wrap .category-thumb a','category_collection_box_shadow');
			blogistic_box_shadow_styles('body .blogistic-carousel-section.carousel-layout--two.box-shadow--enabled article.post-item','carousel_box_shadow');
			blogistic_box_shadow_styles('body #primary .image-box-shadow--enabled article .blogistic-article-inner .post-thumnail-inner-wrapper','archive_image_box_shadow');
			blogistic_box_shadow_styles('body.single-post #blogistic-main-wrap.image-box-shadow--enabled .blogistic-container .row#primary .blogistic-inner-content-wrap .post-thumbnail img, body.single-post--layout-three .image-box-shadow--enabled .post-thumbnail img, body.single-post--layout-four .image-box-shadow--enabled .post-thumbnail img, body.single-post--layout-five .image-box-shadow--enabled .post-thumbnail img, body.single-post--layout-two .image-box-shadow--enabled .blogistic-single-header header','single_image_box_shadow');
			blogistic_box_shadow_styles('body.page-template-default #primary article.image-box-shadow--enabled .post-thumbnail img','page_image_box_shadow');
			blogistic_box_shadow_styles('body .blogistic-breadcrumb-element .blogistic-breadcrumb-wrap','breadcrumb_box_shadow');
			blogistic_box_shadow_styles('body #blogistic-main-wrap > .blogistic-container > .row#primary .box-shadow--enabled article .blogistic-article-inner, body.search-results #blogistic-main-wrap > .blogistic-container .row#primary .box-shadow--enabled article .blogistic-article-inner','archive_box_shadow');
			blogistic_box_shadow_styles('body.search.search-results #blogistic-main-wrap .blogistic-container .page-header','search_box_shadow');
			blogistic_box_shadow_styles('body.archive.category .site #blogistic-main-wrap .page-header .blogistic-container .row, body.archive.date #blogistic-main-wrap .page-header .blogistic-container .row', 'category_box_shadow');
			blogistic_box_shadow_styles('body.archive.author .site #blogistic-main-wrap .page-header .blogistic-container .row', 'author_box_shadow');
			blogistic_box_shadow_styles('body.archive.tag .site #blogistic-main-wrap .page-header .blogistic-container .row', 'tag_box_shadow');
			blogistic_box_shadow_styles('body .box-shadow--enabled .widget, body .box-shadow--enabled #widget_block','widgets_box_shadow');
			blogistic_box_shadow_styles('body.page #primary article.page.box-shadow--enabled, body.error404 #primary .error-404','page_box_shadow');
			blogistic_box_shadow_styles('body.single-post #blogistic-main-wrap.box-shadow--enabled .blogistic-container .row#primary .post-inner, body.single-post #blogistic-main-wrap.box-shadow--enabled .blogistic-container .row#primary .comments-area, body.single-post .box-shadow--enabled .single-related-posts-section-wrap, body.single-post .box-shadow--enabled #primary article .post-card .bmm-author-thumb-wrap, body.single-post #blogistic-main-wrap.box-shadow--enabled .blogistic-container .row#primary nav.navigation','single_page_box_shadow');

			blogistic_initial_bk_color_variable('--blogistic-top-header-bk-color', 'top_header_section_background');

			/* Main banner background color */
			blogistic_initial_bk_color ('body .blogistic-category-collection-section.layout--one .category-wrap .cat-meta .category-name .category-label','category_collection_content_background');
			blogistic_initial_bk_color ('body .canvas-menu-sidebar','blogistic_canvas_menu_background_color');
			blogistic_initial_bk_color ('body #blogistic-main-wrap > .blogistic-container > .row#primary article .blogistic-article-inner, body.archive--block-layout #blogistic-main-wrap > .blogistic-container > .row#primary article .blogistic-article-inner, body.search-results.blogistic_font_typography #blogistic-main-wrap > .blogistic-container > .row#primary article .blogistic-article-inne, body.search.search-results #blogistic-main-wrap .blogistic-container .page-header','archive_inner_background_color');
			blogistic_initial_bk_color ('body .widget, body #widget_block','widgets_inner_background_color');
			blogistic_initial_bk_color ('body.page #blogistic-main-wrap #primary article.page','page_background_color');
			blogistic_initial_bk_color ('body.page #blogistic-main-wrap #primary article.page','page_background_color');
			blogistic_initial_bk_color ('body.error404 #blogistic-main-wrap #primary .not-found','error_page_background_color');
			blogistic_initial_bk_color('body.single-post #blogistic-main-wrap .blogistic-container .row#primary .post-inner, body.single-post #blogistic-main-wrap .blogistic-container .row#primary .comments-area, body.single-post #primary article .post-card .bmm-author-thumb-wrap, body.single-post #blogistic-main-wrap .blogistic-container .row#primary nav.navigation, body.single-post #blogistic-main-wrap .blogistic-container .row#primary .single-related-posts-section-wrap, .blogistic-table-of-content.display--fixed .toc-wrapper','single_page_background_color');

			/* Main banner background color group */
			$background_image = get_theme_mod( 'background_image' );
			if( ! $background_image ) :
				blogistic_get_background_style('body.boxed--layout.blogistic_font_typography:before','site_background_color');
				blogistic_get_background_style('body.blogistic_font_typography:before','site_background_color');
			else:
				echo 'body:before{ display: none; }';
			endif;
			blogistic_get_background_style('.blogistic-breadcrumb-element .blogistic-breadcrumb-wrap', 'breadcrumb_background_color');
			blogistic_get_background_style('header.site-header .main-header', 'header_background');
			blogistic_get_background_style('footer.site-footer .main-footer', 'footer_background_color');
			blogistic_get_background_style('footer.site-footer .bottom-footer', 'bottom_footer_background_color');
			blogistic_get_background_style ('body.archive.category .site #blogistic-main-wrap .page-header .blogistic-container .row','archive_category_info_box_background');
			blogistic_get_background_style ('body.archive.tag .site #blogistic-main-wrap .page-header .blogistic-container .row','archive_tag_info_box_background');
			blogistic_get_background_style ('body.archive.author .site #blogistic-main-wrap .page-header .blogistic-container .row','archive_author_info_box_background');
		$current_styles = ob_get_clean();
		return apply_filters( 'blogistic_current_styles', wp_strip_all_tags($current_styles) );
	}
endif;

if( ! function_exists( 'blogistic_custom_excerpt_more' ) ) :
	/**
	 * Filters the excerpt content
	 * 
	 * @since 1.0.0
	 */
	function blogistic_custom_excerpt_more($more) {
		if( is_admin() ) return $more;
		return '';
	}
	add_filter('excerpt_more', 'blogistic_custom_excerpt_more');
endif;

if( ! function_exists( 'blogistic_check_youtube_api_key' ) ) :
	/**
	 * function to check whether the api key is valid or not
	 * 
	 * @since 1.0.0
	 * @package Blogistic
	 */
	function blogistic_check_youtube_api_key( $api_key ) {
		$api_url = "https://www.googleapis.com/youtube/v3/videos?key=" . $api_key . "&part=snippet,contentDetails";
        $remote_get_video_info = wp_remote_get( $api_url );
		return $remote_get_video_info;
	}
endif;

if( ! function_exists( 'blogistic_random_post_archive_advertisement_part' ) ) :
    /**
     * Blogistic main banner element
     * 
     * @since 1.0.0
     */
    function blogistic_random_post_archive_advertisement_part( $ads_rendered ) {
		if( is_null( $ads_rendered ) ) return;
        $advertisement_repeater = BIT\blogistic_get_customizer_option( 'advertisement_repeater' );
        $advertisement_repeater_decoded = json_decode( $advertisement_repeater );
        $random_post_archive_advertisement = array_values(array_filter( $advertisement_repeater_decoded, function( $element ) {
            if( property_exists( $element, 'item_checkbox_random_post_archives' ) ) return ( $element->item_checkbox_random_post_archives == true && $element->item_option == 'show' ) ? $element : ''; 
        }));
        if( empty( $random_post_archive_advertisement ) ) return;
        $image_option = array_column( $random_post_archive_advertisement, 'item_image_option' );
        $alignment = array_column( $random_post_archive_advertisement, 'item_alignment' );
        $elementClass = 'alignment--' . $alignment[0];
        $elementClass .= ' image-option--' . ( ( $image_option[0] == 'full_width' ) ? 'full-width' : 'original' );
        ?>
            <div class="blogistic-advertisement-block post <?php echo esc_html( $elementClass ); ?>">
                <a href="<?php echo esc_url( $random_post_archive_advertisement[$ads_rendered]->item_url ); ?>" target="<?php echo esc_attr( $random_post_archive_advertisement[$ads_rendered]->item_target ); ?>" rel="<?php echo esc_attr( $random_post_archive_advertisement[$ads_rendered]->item_rel_attribute ); ?>">
                    <img src="<?php echo esc_url( wp_get_attachment_image_url( $random_post_archive_advertisement[$ads_rendered]->item_image, 'full' ) ); ?>">
                </a>
            </div>
        <?php
    }
 endif;

 if( ! function_exists( 'blogistic_random_post_archive_advertisement_number' ) ) :
    /**
     * Blogistic archive ads number
     * 
     * @since 1.0.0
     */
    function blogistic_random_post_archive_advertisement_number() {
        $advertisement_repeater = BIT\blogistic_get_customizer_option( 'advertisement_repeater' );
        $advertisement_repeater_decoded = json_decode( $advertisement_repeater );
        $random_post_archive_advertisement = array_filter( $advertisement_repeater_decoded, function( $element ) {
            if( property_exists( $element, 'item_checkbox_random_post_archives' ) ) return ( $element->item_checkbox_random_post_archives == true && $element->item_option == 'show' ) ? $element : ''; 
        });
        return sizeof( $random_post_archive_advertisement );
    }
 endif;

 if( ! function_exists( 'blogistic_algorithm_to_push_ads_in_archive' ) ) :
	/**
	 * Algorithm to push ads into archive
	 * 
	 * @since 1.0.0
	 */
	function blogistic_algorithm_to_push_ads_in_archive( $args = [] ) {
		global $wp_query;
		$archive_ads_number = blogistic_random_post_archive_advertisement_number();
		if( $archive_ads_number <= 0 ) return;
		if( empty( $args ) ) :
			$max_number_of_pages = absint( $wp_query->max_num_pages );
			$paged = absint( ( get_query_var( 'paged' ) == 0 ) ? 0 : ( get_query_var( 'paged' ) - 1 ) );
		else:
			if( ( $args['paged'] - 1 ) == $archive_ads_number ) return;
			$max_number_of_pages = absint( $args['max_number_of_pages'] );
			$paged = absint( $args['paged'] - 1 );
		endif;
		$count = 1;
		$ads_id = 0;
		$loop_var = 0;
		for( $i = $archive_ads_number ; $i > 0; $i-- ) :
			if( $count <= $max_number_of_pages ):
				$ads_to_render_in_a_single_page = ceil( $i / $max_number_of_pages );
				$ads_to_render = [];
				if( $ads_to_render_in_a_single_page > 1 ) :
					$to_loop = $ads_id + $ads_to_render_in_a_single_page;
					for( $j = $ads_id; $j < $to_loop; $j++ ) :
						if( ! in_array( $ads_id, $ads_to_render ) ) $ads_to_render[] = $ads_id;
						$ads_id++;
					endfor;
					$ads_to_render_in_current_page[$loop_var] = $ads_to_render;
				else:
					$ads_to_render_in_current_page[$loop_var] = $ads_id;
					$ads_id++;
				endif;
				$count++;
				$loop_var++;
			endif;
		endfor;
		$current_page_count = empty( $args ) ? absint( $wp_query->post_count ) : absint( $args['post_count'] );
		$ads_of_current_page = ( array_key_exists( $paged, $ads_to_render_in_current_page ) ) ? $ads_to_render_in_current_page[$paged] : null;
		$ads_count = is_array( $ads_of_current_page ) ? sizeof( $ads_of_current_page ) : 1;
		$random_numbers = [];
		for( $i = 0; $i < $ads_count; $i++ ) :
			if( ! in_array( $i, $random_numbers ) ) :
				$random_numbers[] = rand( 0, ( $current_page_count - 1 ) );
			else:
				$random_numbers[] = rand( 0, ( $current_page_count - 1 ) );
			endif;
		endfor;
		return [
			'random_numbers'	=>	$random_numbers,
			'ads_to_render'	=>	$ads_of_current_page
		];
	}
 endif;

 if( ! function_exists( 'blogistic_get_box_shadow_option' ) ) :
	/**
	 * Get box shadow option ( none or adjust )
	 * 
	 * @since 1.0.0
	 */
	function blogistic_get_box_shadow_option_class( $control, $for_image = false ) {
		$box_shadow = BIT\blogistic_get_customizer_option( $control );
		$return_value = false;
		if( ! empty( $box_shadow ) && is_array( $box_shadow ) && array_key_exists( 'option', $box_shadow ) ) :
			if( $box_shadow['option'] == 'adjust' && $for_image ) $return_value = ' image-box-shadow--enabled';
			if( $box_shadow['option'] == 'adjust' && ! $for_image ) $return_value = ' box-shadow--enabled';
		endif;
		return $return_value;
	}
 endif;

if (!function_exists('blogistic_create_elementor_kit')) {
	/**
	 * Create Elementor default kit
	 * 
	 * @since 1.0.2
	 */
    function blogistic_create_elementor_kit() {
        if (!did_action('elementor/loaded')) {
            return;
        }
        $kit = Elementor\Plugin::$instance->kits_manager->get_active_kit();
        if (!$kit->get_id()) {
			$created_default_kit = Elementor\Plugin::$instance->kits_manager->create_default();
            update_option('elementor_active_kit', $created_default_kit);
        }
    }
	add_action( 'init', 'blogistic_create_elementor_kit' );
}