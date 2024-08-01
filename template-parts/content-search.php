<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blogistic
 */
use Blogistic\CustomizerDefault as BIT;
$custom_class = 'has-featured-image';
if( ! has_post_thumbnail() ) $custom_class = 'no-featured-image';


?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $custom_class ); ?>>
    <div class="blogistic-article-inner blogistic-article-inner">
        <figure class="post-thumbnail-wrapper">
            <div class="post-thumnail-inner-wrapper">
                <?php
                    $archive_image_size = BIT\blogistic_get_customizer_option( 'archive_image_size' );
                    blogistic_post_thumbnail( $archive_image_size );
                ?>        
            </div>
                <?php
                if( BIT\blogistic_get_customizer_option( 'archive_category_option' ) ) blogistic_get_post_categories(get_the_ID());
            ?>
        </figure>
        <div class="inner-content">
            <div class="content-wrap">
                <?php
                    if( BIT\blogistic_get_customizer_option( 'archive_date_option' ) ) blogistic_posted_on();
                    if( BIT\blogistic_get_customizer_option( 'archive_title_option' ) ) :
                        $archive_title_tag = BIT\blogistic_get_customizer_option( 'archive_title_tag' );
                        the_title( '<' .esc_html( $archive_title_tag ). ' class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></' .esc_html( $archive_title_tag ). '>' );
                    endif;
                    if( BIT\blogistic_get_customizer_option( 'archive_excerpt_option' ) ) {
                        echo '<div class="post-excerpt">';
                            the_excerpt();
                        echo '</div>';
                    }
                ?>
            </div>
            <div class="post-footer">
                <?php
                    if( BIT\blogistic_get_customizer_option( 'archive_author_option' ) ) blogistic_posted_by();
                    ?>
                <span class="post-meta">
                    <?php
                        if( BIT\blogistic_get_customizer_option( 'archive_read_time_option' ) ) :
                            
                            
                            $read_time = '<span class="time-context">' . blogistic_post_read_time( get_the_content() ) . '</span>';
                            if( BIT\blogistic_get_customizer_option( 'archive_read_time_icon' ) ) {
                                $archive_read_time_icon = BIT\blogistic_get_customizer_option( 'archive_read_time_icon' );
                                $icon_html = blogistic_get_icon_control_html($archive_read_time_icon);
                                if( $icon_html ) $read_time = $read_time . $icon_html;
                            }
                            echo '<span class="post-read-time'. esc_attr( $archive_readtime_on_mobile ) .'">' .$read_time. '</span>';
                        endif;

                        if( BIT\blogistic_get_customizer_option( 'archive_comments_option' ) ) :
                            $comments_num = '<span class="comments-context">' .get_comments_number(). '</span>';
                            if( BIT\blogistic_get_customizer_option( 'archive_comments_icon' ) ) {
                                $archive_comments_icon = BIT\blogistic_get_customizer_option( 'archive_comments_icon' );
                                $icon_html = blogistic_get_icon_control_html($archive_comments_icon);
                                if( $icon_html ) $comments_num = $comments_num . $icon_html;
                            }
                            echo '<a class="post-comments-num" href="'. esc_url(get_the_permalink()) .'#commentform">' .$comments_num. '</a>';
                        endif;

                        /**
                     * hook - blogistic_section_block_view_all_hook
                     * archive post button
                     */
                    if( has_action( 'blogistic_section_block_view_all_hook' ) ) do_action( 'blogistic_section_block_view_all_hook', [ 'show_button' => $archive_button_option ] );
                    ?>
                </span>
            </div>
        </div>
        <?php
            /**
             * hook - blogistic_archive_button_html_hook
             * 
             * @since 1.0.0
             */
            do_action( 'blogistic_archive_post_append_hook' );
        ?>
    </div>
</article>