<?php
/**
 * Theme hooks and functions
 * 
 * @package Blogistic
 * @since 1.0.0
 */
use Blogistic\CustomizerDefault as BIT;
if( ! function_exists( 'blogistic_single_related_posts' ) ) :
    /**
     * Single related posts
     * 
     * @package Blogistic
     */
    function blogistic_single_related_posts() {
        if( get_post_type() != 'post' ) return;
        $single_post_related_posts_option = BIT\blogistic_get_customizer_option( 'single_post_related_posts_option' );
        if( ! $single_post_related_posts_option ) return;
        $related_posts_title = BIT\blogistic_get_customizer_option( 'single_post_related_posts_title' );
        $related_posts_filter_by = BIT\blogistic_get_customizer_option( 'related_posts_filter_by' );
        $related_posts_layouts = BIT\blogistic_get_customizer_option( 'related_posts_layouts' );
        $related_posts_no_of_column = BIT\blogistic_get_customizer_option( 'related_posts_no_of_column' );
        $related_posts_author_option = BIT\blogistic_get_customizer_option( 'related_posts_author_option' );
        $related_posts_date_option = BIT\blogistic_get_customizer_option( 'related_posts_date_option' );
        $related_posts_comment_option = BIT\blogistic_get_customizer_option( 'related_posts_comment_option' );
        $related_posts_args = array(
            'posts_per_page'   => 4,
            'post__not_in'  => array( get_the_ID() ),
            'ignore_sticky_posts'    => true
        );
        if( $related_posts_filter_by == 'categories' ) :
            $post_categories = wp_get_post_categories( get_the_ID() );
            $related_posts_args['category__in'] = $post_categories;
        endif;
        $related_posts = new WP_Query( apply_filters( 'blogistic_query_args_filter', $related_posts_args ) );
        if( ! $related_posts->have_posts() ) return;
        $elementClass = 'single-related-posts-section-wrap layout--list';
        $elementClass .= ' layout--'. $related_posts_layouts;
        $elementClass .= ' column--' . blogistic_convert_number_to_numeric_string( $related_posts_no_of_column );
  ?>
            <div class="<?php echo esc_attr( $elementClass ); ?>">
                <div class="single-related-posts-section">
                    <?php
                        if( $related_posts_title ) echo '<h2 class="blogistic-block-title"><span>' .esc_html( $related_posts_title ). '</span></h2>';
                            echo '<div class="single-related-posts-wrap">';
                                while( $related_posts->have_posts() ) : $related_posts->the_post();
                            ?>
                                <article post-id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                    <?php if( has_post_thumbnail() ) : ?>
                                        <figure class="post-thumb-wrap <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
                                            <?php blogistic_post_thumbnail( 'medium' ); ?>
                                        </figure>
                                    <?php endif; ?>
                                    <div class="post-element">
                                        <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                        <div class="post-meta">
                                            <?php
                                                if( $related_posts_author_option ) blogistic_posted_by();
                                                if( $related_posts_date_option ) blogistic_posted_on();
                                                if( $related_posts_comment_option ) :
                                                    $comments_num = '<span class="comments-context">' .get_comments_number(). '</span>';
                                                    if( BIT\blogistic_get_customizer_option( 'single_comments_icon' ) ) {
                                                        $single_comments_icon = BIT\blogistic_get_customizer_option( 'single_comments_icon' );
                                                        $icon_html = blogistic_get_icon_control_html($single_comments_icon);
                                                        if( $icon_html ) $comments_num = $icon_html . $comments_num ;
                                                    }
                                                    echo '<a class="post-comments-num" href="'. esc_url(get_the_permalink()) .'#commentform">' .$comments_num. '</a>';
                                                endif;
                                            ?>
                                        </div>
                                    </div>
                                </article>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            echo '</div>';
                    ?>
                </div>
            </div>
    <?php
    }
endif;
add_action( 'blogistic_single_post_append_hook', 'blogistic_single_related_posts' );

if( ! function_exists( 'blogistic_archive_header_html' ) ) :
    /**
     * Archive info box hook
     * 
     * @since 1.0.0
     */
    function blogistic_archive_header_html() {
        if( ! is_archive() ) return;
        if( is_category() && ! BIT\blogistic_get_customizer_option( 'archive_category_info_box_option' ) ) return;
        if( is_tag() && ! BIT\blogistic_get_customizer_option( 'archive_tag_info_box_option' ) ) return;
        if( is_author() && ! BIT\blogistic_get_customizer_option( 'archive_author_info_box_option' ) ) return;
        echo '<header class="page-header">';
            echo '<div class="blogistic-container">';
                echo '<div class="row my-1">';
                    if( is_category() ) {
                        $archive_category_info_box_icon_option = BIT\blogistic_get_customizer_option( 'archive_category_info_box_icon_option' );
                        $archive_category_info_box_icon = BIT\blogistic_get_customizer_option( 'archive_category_info_box_icon' );
                        $archive_category_info_box_title_option = BIT\blogistic_get_customizer_option( 'archive_category_info_box_title_option' );
                        $archive_category_info_box_description_option = BIT\blogistic_get_customizer_option( 'archive_category_info_box_description_option' );
                        $archive_category_info_box_title_tag = BIT\blogistic_get_customizer_option( 'archive_category_info_box_title_tag' );
                        $icon_html = blogistic_get_icon_control_html( $archive_category_info_box_icon );
                        echo '<div class="archive-title">';
                            if( $icon_html && $archive_category_info_box_icon_option ) echo $icon_html;
                            if( $archive_category_info_box_title_option ) the_archive_title( '<'. esc_attr( $archive_category_info_box_title_tag ) .' class="page-title">', '</'. esc_attr( $archive_category_info_box_title_tag ) .'>' );
                        echo '</div>';
                        if( $archive_category_info_box_description_option ) the_archive_description( '<div class="archive-description">', '</div>' );
                    } else if( is_tag() ) {
                        $archive_tag_info_box_icon_option = BIT\blogistic_get_customizer_option( 'archive_tag_info_box_icon_option' );
                        $archive_tag_info_box_icon = BIT\blogistic_get_customizer_option( 'archive_tag_info_box_icon' );
                        $archive_tag_info_box_title_option = BIT\blogistic_get_customizer_option( 'archive_tag_info_box_title_option' );
                        $archive_tag_info_box_description_option = BIT\blogistic_get_customizer_option( 'archive_tag_info_box_description_option' );
                        $archive_tag_info_box_title_tag = BIT\blogistic_get_customizer_option( 'archive_tag_info_box_title_tag' );
                        $icon_html = blogistic_get_icon_control_html($archive_tag_info_box_icon);
                        echo '<div class="archive-title">';
                            if( $icon_html && $archive_tag_info_box_icon_option ) echo $icon_html;
                            if( $archive_tag_info_box_title_option ) the_archive_title( '<'. esc_attr( $archive_tag_info_box_title_tag ) .' class="page-title">', '</'. esc_attr( $archive_tag_info_box_title_tag ) .'>' );
                        echo '</div>';
                        if( $archive_tag_info_box_description_option ) the_archive_description( '<div class="archive-description">', '</div>' );
                    } else if( is_author() ) {
                        $archive_author_info_box_image_option = BIT\blogistic_get_customizer_option( 'archive_author_info_box_image_option' );
                        $archive_author_info_box_title_option = BIT\blogistic_get_customizer_option( 'archive_author_info_box_title_option' );
                        $archive_author_info_box_description_option = BIT\blogistic_get_customizer_option( 'archive_author_info_box_description_option' );
                        $archive_author_info_box_title_tag = BIT\blogistic_get_customizer_option( 'archive_author_info_box_title_tag' );
                        echo '<div class="archive-title">';
                            if( $archive_author_info_box_image_option ) {
                                $author_image = get_avatar( get_queried_object_id(), 90 );
                                if( $author_image ) echo $author_image;
                            }
                            if( $archive_author_info_box_title_option ) the_archive_title( '<'. esc_attr( $archive_author_info_box_title_tag ) .' class="page-title">', '</'. esc_attr( $archive_author_info_box_title_tag ) .'>' );
                        echo '</div>';
                        if( $archive_author_info_box_description_option ) the_archive_description( '<div class="archive-description">', '</div>' );
                    } else {
                        the_archive_title( '<h1 class="page-title">', '</h1>' );
                    }
                    echo '</div><!-- .row-->';
                echo '</div><!-- .blogistic-container -->';
        echo '</header><!-- .page-header -->';
    }
    add_action( 'blogistic_page_header_hook', 'blogistic_archive_header_html' );
endif;

if( ! function_exists( 'blogistic_shooting_star_animation_html' ) ) :
    /**
     * Background animation one
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_shooting_star_animation_html() {
        $elementClass = 'blogistic-background-animation';
        ?>
            <div class="<?php echo esc_attr( $elementClass ); ?>">
                <?php
                    for( $i = 0; $i < 13; $i++ ) :
                        echo '<span class="item"></span>';
                    endfor;
                ?>
            </div>
        <?php
    }
endif;

if( ! function_exists( 'blogistic_get_opening_div_main_wrap' ) ) :
    /**
     * Renders the opening div to wrap main content
     */
    function blogistic_get_opening_div_main_wrap() {
        $wrapperClass = 'blogistic-main-wrap';
        if( is_single() ) :
            $single_image_box_shadow = blogistic_get_box_shadow_option_class( 'single_image_box_shadow', true );
            $single_page_box_shadow = blogistic_get_box_shadow_option_class( 'single_page_box_shadow');
            $single_reorder_option = BIT\blogistic_get_customizer_option( 'single_reorder_option' );
            if( $single_image_box_shadow ) $wrapperClass .= $single_image_box_shadow;
            if( $single_page_box_shadow ) $wrapperClass .= $single_page_box_shadow;
            if( ! empty( $single_reorder_option ) && is_array( $single_reorder_option ) ) :
                $wrapperClass .= ' ' . implode( '-', array_column( $single_reorder_option, 'value' ) );
            endif;
        endif;

        echo '<div id="blogistic-main-wrap" class="'. esc_attr( $wrapperClass ) .'">';
    }
    add_action( 'blogistic_main_content_opening', 'blogistic_get_opening_div_main_wrap', 10 );
endif;

if( ! function_exists( 'blogistic_get_page_header_hook' ) ) :
    function blogistic_get_page_header_hook() {
        /**
         * Hook - blogistic_page_header_hook
         * 
         * Hooked - blogistic_archive_header_html - 10
         */
        do_action( 'blogistic_page_header_hook' );
    }
    add_action( 'blogistic_main_content_opening', 'blogistic_get_page_header_hook', 20 );
endif;

if( ! function_exists( 'blogistic_get_opening_div_container' ) ) :
    /**
     * Renders the opening div for .blogistic-container class
     * 
     * @since 1.0.0
     */
    function blogistic_get_opening_div_container() {
        echo '<div class="blogistic-container">';
    }
    add_action( 'blogistic_main_content_opening', 'blogistic_get_opening_div_container', 30 );
endif;

if( ! function_exists( 'blogistic_get_single_content_exclude_layout_three' ) ) :
    /**
     * Renders contents of single post excluding layout three
     * 
     * @since 1.0.0
     */
    function blogistic_get_single_content_exclude_layout_three() {
        /**
         * hook - blogistic_before_main_content
         * 
         * hooked - blogistic_breadcrumb_html - 10
         * hooked - blogistic_single_header_html - 20
         */
        if( has_action( 'blogistic_before_main_content' ) ) do_action( 'blogistic_before_main_content' );
    }
    add_action( 'blogistic_main_content_opening', 'blogistic_get_single_content_exclude_layout_three', 40 );
endif;

if( ! function_exists( 'blogistic_get_opening_div_row' ) ) :
    /**
     * Renders the opening div for .rowclass
     * 
     * @since 1.0.0
     */
    function blogistic_get_opening_div_row() {
        echo '<div class="row">';
    }
    add_action( 'blogistic_main_content_opening', 'blogistic_get_opening_div_row', 50 );
endif;

if( ! function_exists( 'blogistic_get_closing_div_row' ) ) :
    /**
     * Renders the opening div for .rowclass
     * 
     * @since 1.0.0
     */
    function blogistic_get_closing_div_row() {
        echo '</div><!-- .row-->';
    }
    add_action( 'blogistic_main_content_closing', 'blogistic_get_closing_div_row', 10 );
endif;

if( ! function_exists( 'blogistic_get_closing_div_container' ) ) :
    /**
     * Renders the opening div for .rowclass
     * 
     * @since 1.0.0
     */
    function blogistic_get_closing_div_container() {
        echo '</div><!-- .row-->';
    }
    add_action( 'blogistic_main_content_closing', 'blogistic_get_closing_div_container', 20 );
endif;

if( ! function_exists( 'blogistic_get_before_footer_hook' ) ) :
    /**
     * Renders the opening div for .rowclass
     * 
     * @since 1.0.0
     */
    function blogistic_get_before_footer_hook() {
        /**
         * hook - blogistic_before_footer_hook
         * 
         * hooked - blogistic_footer_advertisement_part - 10
         * hooked - blogistic_you_may_have_missed_html - 100
         */
        if( is_single() ) do_action( 'blogistic_before_footer_hook' );
    }
    add_action( 'blogistic_main_content_closing', 'blogistic_get_before_footer_hook', 30 );
endif;

if( ! function_exists( 'blogistic_get_closing_div_main_wrap' ) ) :
    /**
     * Renders the opening div for .rowclass
     * 
     * @since 1.0.0
     */
    function blogistic_get_closing_div_main_wrap() {
        echo '</div><!-- .blogistic-main-wrap -->';
    }
    add_action( 'blogistic_main_content_closing', 'blogistic_get_closing_div_main_wrap', 40);
endif;