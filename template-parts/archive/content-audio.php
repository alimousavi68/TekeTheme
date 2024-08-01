<?php
/**
 * Template part for displaying posts with audio format
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blogistic
 */
use Blogistic\CustomizerDefault as BIT;
$custom_class = 'has-featured-image';
if( ! has_post_thumbnail() ) $custom_class = 'no-featured-image';
$archive_show_social_share = BIT\blogistic_get_customizer_option( 'archive_show_social_share' );
$archive_button_option = BIT\blogistic_get_customizer_option( 'archive_button_option' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $custom_class ); ?>>
    <div class="blogistic-article-inner">
        <figure class="post-thumbnail-wrapper">
            <div class="post-thumnail-inner-wrapper">
                <?php
                    $archive_image_size = BIT\blogistic_get_customizer_option( 'archive_image_size' );
                    blogistic_post_thumbnail( $archive_image_size );
                    
                    if( has_block('core/audio') ) :
                        $blocksArray = parse_blocks( get_the_content() );
                        foreach( $blocksArray as $singleBlock ) :
                            if( 'core/audio' === $singleBlock['blockName'] ) { echo wp_kses_post( apply_filters( 'the_content', render_block( $singleBlock ) ) ); break; }
                        endforeach;
                    endif;
                ?>        
            </div>
            <?php
                if( BIT\blogistic_get_customizer_option( 'archive_category_option' ) ) blogistic_get_post_categories( get_the_ID(), 1 );
                echo '<div class="post-format-ss-wrap">';
                    $control_id = is_string( blogistic_get_post_format() ) ? blogistic_get_post_format() . '_post_format_icon_picker' : 'standard_post_format_icon_picker';
                    $icon_picker = BIT\blogistic_get_customizer_option( $control_id );
                    $post_format_icon = blogistic_get_icon_control_html( $icon_picker );
                    $postFormatClass = 'post-format-icon';
                    if( ! empty( $icon_picker ) && is_array( $icon_picker ) && array_key_exists( 'type', $icon_picker ) && $icon_picker['type'] == 'svg' ) $postFormatClass .= ' type--svg';
                    if( $post_format_icon ) echo '<span class="'. esc_attr( $postFormatClass ) .'">'. $post_format_icon .'</span>';
                echo '</div><!-- .post-format-ss-wrap -->';
            ?>
        </figure>
        <div class="inner-content">
            <div class="content-wrap">
                <?php
                    if( BIT\blogistic_get_customizer_option( 'archive_date_option' ) ) blogistic_posted_on( '', '' );
                    if( BIT\blogistic_get_customizer_option( 'archive_title_option' ) ) :
                        $archive_title_tag = BIT\blogistic_get_customizer_option( 'archive_title_tag' );
                        the_title( '<' .esc_html( $archive_title_tag ). ' class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></' .esc_html( $archive_title_tag ). '>' );
                    endif;
                    if( BIT\blogistic_get_customizer_option( 'archive_excerpt_option' ) ) {
                        echo '<div class="post-excerpt">';
                            echo get_the_excerpt();
                        echo '</div>';
                    }
                    /**
                     * hook - blogistic_section_block_view_all_hook
                     * archive post button
                     */
                    if( has_action( 'blogistic_section_block_view_all_hook' ) ) do_action( 'blogistic_section_block_view_all_hook', [ 'show_button' => $archive_button_option ] );
                ?>
            </div>
            <?php
                $archive_author_option = BIT\blogistic_get_customizer_option( 'archive_author_option' );
                $archive_read_time_option = BIT\blogistic_get_customizer_option( 'archive_read_time_option' );
                $archive_comments_option = BIT\blogistic_get_customizer_option( 'archive_comments_option' );
                if( $archive_author_option || $archive_read_time_option || $archive_comments_option ) : ?>
                    <div class="post-footer">
                        <?php if( $archive_author_option ) blogistic_posted_by(); ?>
                        <span class="post-meta">
                            <?php
                                if( $archive_read_time_option ) :
                                    $read_time = '<span class="time-context">' . blogistic_post_read_time( get_the_content() ) . '</span>';
                                    if( BIT\blogistic_get_customizer_option( 'archive_read_time_icon' ) ) {
                                        $archive_read_time_icon = BIT\blogistic_get_customizer_option( 'archive_read_time_icon' );
                                        $icon_html = blogistic_get_icon_control_html($archive_read_time_icon);
                                        if( $icon_html ) $read_time = $read_time . $icon_html;
                                    }
                                    echo '<span class="post-read-time">' .$read_time. '</span>';
                                endif;

                                if( $archive_comments_option ) :
                                    $comments_num = '<span class="comments-context">' .get_comments_number(). '</span>';
                                    if( BIT\blogistic_get_customizer_option( 'archive_comments_icon' ) ) {
                                        $archive_comments_icon = BIT\blogistic_get_customizer_option( 'archive_comments_icon' );
                                        $icon_html = blogistic_get_icon_control_html($archive_comments_icon);
                                        if( $icon_html ) $comments_num = $comments_num . $icon_html;
                                    }
                                    echo '<a class="post-comments-num" href="'. esc_url(get_the_permalink()) .'#commentform">' .$comments_num. '</a>';
                                endif;
                            ?>
                        </span>
                    </div>
                <?php 
                endif;
            ?>
        </div>
    </div>
    <?php
        blogistic_entry_footer();
        /**
         * hook - blogistic_archive_button_html_hook
         * 
         * @since 1.0.0
         */
        do_action( 'blogistic_archive_post_append_hook' );
    ?>
</article>