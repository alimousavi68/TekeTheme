<?php
/**
 * Includes helper hooks and function of the theme
 * 
 * @package Blogistic
 * @since 1.0.0
 */
use Blogistic\CustomizerDefault as BIT;

if (!function_exists('blogistic_top_header_html')):
    /**
     * calls top header hook
     * MARK: TOP HEADER
     * 
     * @since 1.0.0
     */
    function blogistic_top_header_html()
    {
        if (!BIT\blogistic_get_customizer_option('top_header_option'))
            return;
        require get_template_directory() . '/inc/hooks/top-header-hooks.php';
        $elementClass = 'top-header';
        ?>
        <div class="<?php echo esc_attr($elementClass); ?>">
            <div class="blogistic-container">
                <div class="row">
                    <?php
                    /**
                     * hook - blogistic_top_header_hook
                     * 
                     * @hooked - blogistic_top_header_date_time_part - 10
                     * @hooked - blogistic_top_header_social_part - 15
                     */
                    if (has_action('blogistic_top_header_hook'))
                        do_action('blogistic_top_header_hook');
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
endif;

if (!function_exists('blogistic_header_html')):
    /**
     * Calls header hook
     * MARK: HEADER
     * 
     * @since 1.0.0
     */
    function blogistic_header_html()
    {
        require get_template_directory() . '/inc/hooks/header-hooks.php';
        $menu_aligment = BIT\blogistic_get_customizer_option('menu_options_menu_alignment');
        $header_sortable_options = BIT\blogistic_get_customizer_option('header_sortable_options');
        $elementClass = 'main-header';
        $elementClass .= ' menu-alignment--' . $menu_aligment;
        ?>
        <div class="<?php echo esc_attr($elementClass); ?>">
            <div class="blogistic-container">
                <div class="row">
                    <?php
                    if (!is_null($header_sortable_options) && is_array($header_sortable_options)):
                        foreach ($header_sortable_options as $index => $re_order):
                            switch ($re_order['value']):
                                case 'site-branding':
                                    ?>
                                    <div class="site-branding-section">
                                        <?php
                                        /**
                                         * hook - blogistic_header__site_branding_section_hook
                                         * 
                                         * @hooked - blogistic_header_menu_part - 10
                                         * @hooked - blogistic_header_ads_banner_part - 20
                                         */
                                        if (has_action('blogistic_header__site_branding_section_hook'))
                                            do_action('blogistic_header__site_branding_section_hook');
                                        ?>
                                    </div>
                                    <?php
                                    break;
                                case 'nav-menu':
                                    /**
                                     * hook - blogistic_header__menu_section_hook
                                     * 
                                     * @hooked - blogistic_header_menu_part - 10
                                     * @hooked - blogistic_header_search_part - 20
                                     */
                                    if (has_action('blogistic_header__menu_section_hook'))
                                        do_action('blogistic_header__menu_section_hook');
                                    break;
                                case 'custom-button':
                                    /**
                                     * hook - blogistic_header__custom_button_section_hook
                                     */
                                    if (has_action('blogistic_header__custom_button_section_hook'))
                                        do_action('blogistic_header__custom_button_section_hook');
                                    break;
                                case 'search':
                                    /**
                                     * hook - blogistic_header_search_hook
                                     */
                                    if (has_action('blogistic_header_search_hook'))
                                        do_action('blogistic_header_search_hook');
                                    break;
                                case 'theme-mode':
                                    /**
                                     * hook - blogistic_header_theme_mode_hook
                                     */
                                    if (has_action('blogistic_header_theme_mode_hook'))
                                        do_action('blogistic_header_theme_mode_hook');
                                    break;
                                case 'off-canvas':
                                    /**
                                     * hook - blogistic_header_off_canvas_hook
                                     */
                                    if (has_action('blogistic_header_off_canvas_hook'))
                                        do_action('blogistic_header_off_canvas_hook');
                                    break;
                            endswitch;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
endif;

if (!function_exists('blogistic_get_post_format')):
    /**
     * Gets the post format string
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_get_post_format($id = null)
    {
        $post_format = ($id) ? get_post_format($id) : get_post_format();
        return apply_filters('blogistic_post_format_string_filter', $post_format);
    }
endif;

if (!function_exists('blogistic_main_banner_html')):
    /**
     * Main banner html
     * MARK: MAIN BANNER
     * 
     * @since 1.0.0
     */
    function blogistic_main_banner_html()
    {
        $main_banner_render_in = BIT\blogistic_get_customizer_option('main_banner_render_in');
        if (!BIT\blogistic_get_customizer_option('main_banner_option') || is_paged()):
            return;
        elseif ($main_banner_render_in == 'front_page' && !is_front_page()):
            return;
        elseif ($main_banner_render_in == 'posts_page' && !is_home()):
            return;
        elseif ($main_banner_render_in == 'both' && (!is_front_page() && !is_home())):
            return;
        endif;

        // post query
        $main_banner_post_categories = BIT\blogistic_get_customizer_option('main_banner_slider_categories');
        $main_banner_posts_to_include = BIT\blogistic_get_customizer_option('main_banner_slider_posts_to_include');
        $main_banner_post_order = BIT\blogistic_get_customizer_option('main_banner_post_order');
        $main_banner_no_of_posts_to_show = BIT\blogistic_get_customizer_option('main_banner_no_of_posts_to_show');
        $hide_posts_with_no_featured_image = BIT\blogistic_get_customizer_option('main_banner_hide_post_with_no_featured_image');

        $post_categories_id_args = (!empty($main_banner_post_categories)) ? implode(",", array_column(json_decode($main_banner_post_categories), 'value')) : '';
        $post_to_include_id_args = (!empty($main_banner_posts_to_include)) ? array_column(json_decode($main_banner_posts_to_include), 'value') : '';

        // post elements
        $show_title = BIT\blogistic_get_customizer_option('main_banner_post_elements_show_title');
        $show_categories = BIT\blogistic_get_customizer_option('main_banner_post_elements_show_categories');
        $show_date = BIT\blogistic_get_customizer_option('main_banner_post_elements_show_date');
        $show_author = BIT\blogistic_get_customizer_option('main_banner_post_elements_show_author');
        $show_excerpt = BIT\blogistic_get_customizer_option('main_banner_post_elements_show_excerpt');

        // image settings and slider settings
        $main_banner_layouts = BIT\blogistic_get_customizer_option('main_banner_layouts');
        $banner_class = 'blogistic-main-banner-section';
        $banner_class .= ' layout--' . $main_banner_layouts;
        $main_banner_image_sizes = BIT\blogistic_get_customizer_option('main_banner_image_sizes');
        $main_banner_show_arrow_on_hover = BIT\blogistic_get_customizer_option('main_banner_show_arrow_on_hover');
        $banner_class .= ($main_banner_show_arrow_on_hover) ? ' arrow-on-hover--on ' : '';

        $main_banner_aligment = BIT\blogistic_get_customizer_option('main_banner_post_elements_alignment');
        $banner_class .= ' banner-align--' . $main_banner_aligment;

        $show_arrow = BIT\blogistic_get_customizer_option('main_banner_show_arrows');
        $banner_class .= ($show_arrow) ? ' main-banner-arrow-show' : '';

        $main_banner_design_post_title_html_tag = BIT\blogistic_get_customizer_option('main_banner_design_post_title_html_tag');
        ?>
        <section class="<?php echo esc_attr($banner_class) ?>" id="blogistic-main-banner-section">
            <div class="blogistic-container">
                <div class="row">
                    <div class="main-banner-wrap">
                        <?php
                        $post_order = explode('-', $main_banner_post_order);
                        $post_query_args = [
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'posts_per_page' => absint($main_banner_no_of_posts_to_show),
                            'order' => $post_order[1],
                            'order_by' => $post_order[1],
                            'ignore_sticky_posts' => true
                        ];
                        if (isset($main_banner_post_categories))
                            $post_query_args['cat'] = $post_categories_id_args;
                        if (isset($main_banner_posts_to_include))
                            $post_query_args['post__in'] = $post_to_include_id_args;
                        if ($hide_posts_with_no_featured_image):
                            $post_query_args['meta_query'] = [
                                [
                                    'key' => '_thumbnail_id',
                                    'compare' => 'EXISTS'
                                ]
                            ];
                        endif;
                        $post_query = new \WP_Query(apply_filters('blogistic_query_args_filter', $post_query_args));
                        if ($post_query->have_posts()):
                            while ($post_query->have_posts()):
                                $post_query->the_post();
                                ?>
                                <article class="post-item">
                                    <figure class="post-thumb">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail())
                                                the_post_thumbnail($main_banner_image_sizes); ?>
                                        </a>
                                    </figure>
                                    <div class="post-elements">
                                        <div class="post-meta">
                                            <?php
                                            if ($show_categories)
                                                blogistic_get_post_categories(get_the_ID(), 2);
                                            ?>
                                        </div>
                                        <?php
                                        if ($show_title)
                                            the_title('<' . esc_attr($main_banner_design_post_title_html_tag) . ' class="post-title"><a href="' . esc_url(get_the_permalink()) . '">', '</a></' . esc_attr($main_banner_design_post_title_html_tag) . '>');
                                        if ($show_excerpt)
                                            echo '<div class="post-excerpt"><span class="excerpt-content">' . get_the_excerpt() . '</span></div>';
                                        ?>
                                        <div class="author-date-wrap">
                                            <?php
                                            if ($show_author)
                                                blogistic_posted_by('banner');
                                            if ($show_date)
                                                blogistic_posted_on(get_the_ID(), 'banner');
                                            ?>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
    add_action('blogistic_header_after_hook', 'blogistic_main_banner_html', 20);
endif;

if (!function_exists('blogistic_carousel_html')):
    /**
     * Main banner html
     * MARK: CAROUSEL
     * 
     * @since 1.0.0
     */
    function blogistic_carousel_html()
    {
        $carousel_render_in = BIT\blogistic_get_customizer_option('carousel_render_in');
        if (!BIT\blogistic_get_customizer_option('carousel_option') || is_paged()):
            return;
        elseif ($carousel_render_in == 'front_page' && !is_front_page()):
            return;
        elseif ($carousel_render_in == 'posts_page' && !is_home()):
            return;
        elseif ($carousel_render_in == 'both' && (!is_front_page() && !is_home())):
            return;
        endif;
        $carousel_layouts = BIT\blogistic_get_customizer_option('carousel_layouts');
        // post query
        $carousel_post_categories = BIT\blogistic_get_customizer_option('carousel_slider_categories');
        $carousel_post_tags = BIT\blogistic_get_customizer_option('carousel_slider_tags');
        $carousel_post_authors = BIT\blogistic_get_customizer_option('carousel_slider_authors');
        $carousel_posts_to_include = BIT\blogistic_get_customizer_option('carousel_slider_posts_to_include');
        $carousel_posts_to_exclude = BIT\blogistic_get_customizer_option('carousel_slider_posts_to_exclude');
        $carousel_post_order = BIT\blogistic_get_customizer_option('carousel_post_order');
        $carousel_no_of_posts_to_show = BIT\blogistic_get_customizer_option('carousel_no_of_posts_to_show');
        $carousel_post_offset = BIT\blogistic_get_customizer_option('carousel_post_offset');
        $hide_posts_with_no_featured_image = BIT\blogistic_get_customizer_option('carousel_hide_post_with_no_featured_image');

        $post_categories_id_args = (!empty($carousel_post_categories)) ? implode(",", array_column(json_decode($carousel_post_categories), 'value')) : '';
        $post_authors_id_args = (!empty($carousel_post_authors)) ? implode(",", array_column(json_decode($carousel_post_authors), 'value')) : '';
        $post_tags_id_args = (!empty($carousel_post_tags)) ? array_column(json_decode($carousel_post_tags), 'value') : '';
        $post_to_include_id_args = (!empty($carousel_posts_to_include)) ? array_column(json_decode($carousel_posts_to_include), 'value') : '';
        $post_to_exclude_id_args = (!empty($carousel_posts_to_exclude)) ? array_column(json_decode($carousel_posts_to_exclude), 'value') : '';

        // post elements
        $show_title = BIT\blogistic_get_customizer_option('carousel_post_elements_show_title');
        $show_categories = BIT\blogistic_get_customizer_option('carousel_post_elements_show_categories');
        $show_date = BIT\blogistic_get_customizer_option('carousel_post_elements_show_date');
        $show_author = BIT\blogistic_get_customizer_option('carousel_post_elements_show_author');
        $show_excerpt = BIT\blogistic_get_customizer_option('carousel_post_elements_show_excerpt');

        // image settings and slider settings
        $carousel_image_sizes = BIT\blogistic_get_customizer_option('carousel_image_sizes');
        $carousel_show_arrow_on_hover = BIT\blogistic_get_customizer_option('carousel_show_arrow_on_hover');
        $carousel_no_of_columns = absint(BIT\blogistic_get_customizer_option('carousel_no_of_columns'));
        $carousel_image_box_shadow = blogistic_get_box_shadow_option_class('carousel_image_box_shadow', true);
        $carousel_box_shadow = blogistic_get_box_shadow_option_class('carousel_box_shadow');

        // element class
        $elementClass = 'blogistic-carousel-section';
        $elementClass .= ($carousel_show_arrow_on_hover) ? ' arrow-on-hover--on' : '';
        $elementClass .= ($carousel_no_of_columns) ? ' no-of-columns--' . blogistic_convert_number_to_numeric_string($carousel_no_of_columns) : '';

        $carousel_aligment = BIT\blogistic_get_customizer_option('carousel_post_elements_alignment');
        $elementClass .= ' carousel-align--' . $carousel_aligment;

        $carousel_show_arrow = BIT\blogistic_get_customizer_option('carousel_show_arrows');
        $elementClass .= ($carousel_show_arrow) ? ' carousel-banner-arrow-show' : '';
        $elementClass .= ' carousel-layout--' . $carousel_layouts;
        if ($carousel_image_box_shadow)
            $elementClass .= $carousel_image_box_shadow;
        if ($carousel_box_shadow)
            $elementClass .= $carousel_box_shadow;

        $carousel_design_post_title_html_tag = BIT\blogistic_get_customizer_option('carousel_design_post_title_html_tag');
        ?>
        <section class="<?php echo esc_attr($elementClass); ?>" id="blogistic-carousel-section">
            <div class="blogistic-container">
                <div class="row">
                    <div class="carousel-wrap">
                        <?php
                        $post_order = explode('-', $carousel_post_order);
                        $post_query_args = [
                            'post_type' => 'events',
                            'post_status' => 'publish',
                            'offset' => absint($carousel_post_offset),
                            'posts_per_page' => absint($carousel_no_of_posts_to_show),
                            'order' => $post_order[1],
                            'order_by' => $post_order[1],
                            'ignore_sticky_posts' => true
                        ];
                        if (isset($carousel_post_categories))
                            $post_query_args['cat'] = $post_categories_id_args;
                        if (isset($carousel_post_tags))
                            $post_query_args['tag__in'] = $post_tags_id_args;
                        if (isset($carousel_post_tags))
                            $post_query_args['author'] = $post_authors_id_args;
                        if (isset($carousel_posts_to_include))
                            $post_query_args['post__in'] = $post_to_include_id_args;
                        if (isset($carousel_posts_to_exclude))
                            $post_query_args['post__not_in'] = $post_to_exclude_id_args;
                        if ($hide_posts_with_no_featured_image):
                            $post_query_args['meta_query'] = [
                                [
                                    'key' => '_thumbnail_id',
                                    'compare' => 'EXISTS'
                                ]
                            ];
                        endif;
                        $post_query = new \WP_Query(apply_filters('blogistic_query_args_filter', $post_query_args));
                        if ($post_query->have_posts()):
                            while ($post_query->have_posts()):
                                $post_query->the_post();
                                ?>
                                <article class="post-item">
                                    <figure class="post-thumb">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail())
                                                the_post_thumbnail($carousel_image_sizes); ?>
                                        </a>
                                    </figure>
                                    <div class="post-elements">
                                        <div class="post-meta">
                                            <?php
                                            if ($show_categories)
                                                blogistic_get_post_categories(get_the_ID(), 2);
                                            if ($show_date)
                                                blogistic_posted_on(get_the_ID(), 'carousel');
                                            ?>
                                        </div>
                                        <?php
                                        if ($show_title)
                                            the_title('<' . esc_attr($carousel_design_post_title_html_tag) . ' class="post-title"><a href="' . esc_url(get_the_permalink()) . '">', '</a></' . esc_attr($carousel_design_post_title_html_tag) . '>');
                                        if ($show_excerpt)
                                            echo '<div class="post-excerpt"><span class="excerpt-content">' . esc_html(get_the_excerpt()) . '</span></div>';
                                        if ($show_author)
                                            blogistic_posted_by('carousel');
                                        ?>
                                    </div>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
    add_action('blogistic_header_after_hook', 'blogistic_carousel_html', 30);
endif;

if (!function_exists('blogistic_get_icon_control_html')):
    /**
     * Generates output for icon control
     * 
     * @since 1.0.0
     */
    function blogistic_get_icon_control_html($archive_date_icon)
    {
        if ($archive_date_icon['type'] == 'none')
            return;
        switch ($archive_date_icon['type']) {
            case 'svg':
                $output = '<img src="' . esc_url(wp_get_attachment_url($archive_date_icon['value'])) . '"/>';
                break;
            default:
                $output = '<i class="' . esc_attr($archive_date_icon['value']) . '"></i>';
        }
        return $output;
    }
endif;

if (!function_exists('blogistic_convert_number_to_numeric_string')):
    /**
     * Function to convert int parameter to numeric string
     * MARK: CONVERT NUMBER TO STRING
     * 
     * @return string
     */
    function blogistic_convert_number_to_numeric_string($int)
    {
        switch ($int) {
            case 2:
                return "two";
                break;
            case 3:
                return "three";
                break;
            case 4:
                return "four";
                break;
            case 5:
                return "five";
                break;
            case 6:
                return "six";
                break;
            case 7:
                return "seven";
                break;
            case 8:
                return "eight";
                break;
            case 9:
                return "nine";
                break;
            case 10:
                return "ten";
                break;
            default:
                return "one";
        }
    }
endif;

if (!function_exists('blogistic_post_read_time')):
    /**
     * Function derives the read time
     * @return float
     */
    function blogistic_post_read_time($string = '')
    {
        $read_time = 0;
        if (empty($string)) {
            return 0 . esc_html__(' min', 'blogistic');
        } else {
            $read_time = apply_filters('blogistic_content_read_time', round(str_word_count(wp_strip_all_tags($string)) / 100), 2);
            if ($read_time == 0) {
                return 1 . esc_html__(' min', 'blogistic');
            } else {
                return $read_time . esc_html__(' mins', 'blogistic');
            }
        }
    }
endif;

if (!function_exists('blogistic_get_post_categories')):
    /**
     * Function contains post categories html
     * @return float
     */
    function blogistic_get_post_categories($post_id, $number = 1, $args = [])
    {
        $hide_on_mobile = '';
        $n_categories = wp_get_post_categories($post_id, array('number' => absint($number)));
        if (array_key_exists('hide_on_mobile', $args)):
            $hide_on_mobile = (!$args['hide_on_mobile']) ? ' hide-on-mobile' : '';
        endif;
        echo '<ul class="post-categories' . esc_attr($hide_on_mobile) . '">';
        foreach ($n_categories as $n_category):
            echo '<li class="cat-item ' . esc_attr('cat-' . $n_category) . '"><a href="' . esc_url(get_category_link($n_category)) . '" rel="category tag">' . get_cat_name($n_category) . '</a></li>';
        endforeach;
        echo '</ul>';
    }
endif;

if (!function_exists('blogistic_loader_html')):
    /**
     * Preloader html
     * MARK: PRELOADER
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_loader_html()
    {
        if (!BIT\blogistic_get_customizer_option('preloader_option'))
            return;
        $elementClass = 'blogistic_loading_box preloader-style--three';
        ?>
        <div class="<?php echo esc_attr($elementClass); ?>" id="blogistic-preloader">
            <div class="box">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
                <div class="four"></div>
                <div class="five"></div>
            </div>
        </div>
        <?php
    }
    add_action('blogistic_page_prepend_hook', 'blogistic_loader_html', 1);
endif;

if (!function_exists('blogistic_custom_header_html')):
    /**
     * Site custom header html
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_custom_header_html()
    {
        /**
         * Get custom header markup
         * 
         * @since 1.0.0 
         */
        the_custom_header_markup();
    }
    add_action('blogistic_page_prepend_hook', 'blogistic_custom_header_html', 20);
endif;

if (!function_exists('blogistic_pagination_fnc')):
    /**
     * Renders pagination html
     * MARK: PAGINATION
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_pagination_fnc()
    {
        if (is_null(paginate_links())) {
            return;
        }
        $archive_pagination_type = BIT\blogistic_get_customizer_option('archive_pagination_type');
        // the_post_navigation
        switch ($archive_pagination_type) {
            case 'default':
                the_posts_navigation();
                break;
            default:
                echo '<div class="pagination">' . wp_kses_post(paginate_links(array('prev_text' => '<i class="fas fa-chevron-left"></i>', 'next_text' => '<i class="fas fa-chevron-right"></i>', 'type' => 'list'))) . '</div>';
        }

    }
    add_action('blogistic_pagination_link_hook', 'blogistic_pagination_fnc');
endif;

if (!function_exists('blogistic_scroll_to_top_html')):
    /**
     * Scroll to top fnc
     * MARK: SCROLL TO TOP
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_scroll_to_top_html()
    {
        if (!BIT\blogistic_get_customizer_option('blogistic_scroll_to_top_option'))
            return;
        $stt_text = BIT\blogistic_get_customizer_option('stt_text');
        $stt_icon = BIT\blogistic_get_customizer_option('stt_icon');
        $stt_alignment = BIT\blogistic_get_customizer_option('stt_alignment');
        $scroll_to_top_mobile_option = BIT\blogistic_get_customizer_option('scroll_to_top_mobile_option');
        $classes = 'align--' . $stt_alignment;
        if (!$scroll_to_top_mobile_option)
            $classes .= ' hide-on-mobile';
        ?>
        <div id="blogistic-scroll-to-top" class="blogistic-scroll-btn <?php echo esc_attr($classes); ?>">
            <?php
            if ($stt_text) {
                echo '<span class="icon-text">' . apply_filters('blogsitic_stt_text_filter', esc_html($stt_text)) . '</span>';
            }
            if ($stt_icon['type'] == 'icon') {
                if ($stt_icon['value'] != 'fas fa-ban'):
                    echo '<span class="icon-holder"><i class="' . esc_attr($stt_icon['value']) . '"></i></span>';
                endif;
            } else {
                if ($stt_icon['type'] != 'none')
                    echo '<span class="icon-holder">' . wp_get_attachment_image($stt_icon['value'], 'full') . '</span>';
            }
            ?>
        </div><!-- #blogistic-scroll-to-top -->
        <?php
    }
    add_action('blogistic_after_footer_hook', 'blogistic_scroll_to_top_html');
endif;

require get_template_directory() . '/inc/hooks/footer-hooks.php'; // footer hooks.
if (!function_exists('footer_sections_html')):
    /**
     * Calls footer hooks
     * MARK: THEME FOOTER
     * 
     * @since 1.0.0
     */
    function footer_sections_html()
    {
        if (!BIT\blogistic_get_customizer_option('footer_option'))
            return;
        ?>
        <div class="main-footer boxed-width">
            <div class="footer-inner blogistic-container">
                <div class="row">
                    <div class="footer-inner-wrap">
                        <?php
                        /**
                         * hook - blogistic_footer_hook
                         * 
                         * @hooked - blogistic_footer_widgets_area_part - 10
                         */
                        if (has_action('blogistic_footer_hook'))
                            do_action('blogistic_footer_hook');
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
endif;

if (!function_exists('blogistic_bottom_footer_sections_html')):
    /**
     * Calls bottom footer hooks
     * MARK: BOTTOM FOOTER
     * 
     * @since 1.0.0
     */
    function blogistic_bottom_footer_sections_html()
    {
        if (!BIT\blogistic_get_customizer_option('bottom_footer_option'))
            return;
        ?>
        <div class="bottom-footer">
            <div class="blogistic-container">
                <div class="row">
                    <?php
                    /**
                     * hook - blogistic_bottom_footer_sections_html
                     * 
                     * @hooked - blogistic_bottom_footer_menu_part - 20
                     * @hooked - blogistic_bottom_footer_copyright_part - 3020
                     */
                    if (has_action('blogistic_botttom_footer_hook'))
                        do_action('blogistic_botttom_footer_hook');
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
endif;

if (!function_exists('blogistic_breadcrumb_trail')):
    /**
     * Theme default breadcrumb function.
     *
     * @since 1.0.0
     */
    function blogistic_breadcrumb_trail()
    {
        if (!function_exists('breadcrumb_trail')) {
            // load class file
            require_once get_template_directory() . '/inc/breadcrumb-trail/breadcrumb-trail.php';
        }

        // arguments variable
        $breadcrumb_args = array(
            'container' => 'div',
            'show_browse' => false
        );
        breadcrumb_trail($breadcrumb_args);
    }
    add_action('blogistic_breadcrumb_trail_hook', 'blogistic_breadcrumb_trail');
endif;

if (!function_exists('blogistic_breadcrumb_html')):
    /**
     * Theme breadcrumb
     * MARK: BREADCRUMB
     *
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_breadcrumb_html()
    {
        $site_breadcrumb_option = BIT\blogistic_get_customizer_option('site_breadcrumb_option');
        if (!$site_breadcrumb_option)
            return;
        if (is_front_page() || is_home())
            return;
        $site_breadcrumb_type = BIT\blogistic_get_customizer_option('site_breadcrumb_type');
        ?>
        <div class="rowblogistic-breadcrumb-element">
            <div class="blogistic-breadcrumb-wrap">
                <?php
                switch ($site_breadcrumb_type) {
                    case 'yoast':
                        if (blogistic_compare_wand([blogistic_function_exists('yoast_breadcrumb')]))
                            yoast_breadcrumb();
                        break;
                    case 'rankmath':
                        if (blogistic_compare_wand([blogistic_function_exists('rank_math_the_breadcrumbs')]))
                            rank_math_the_breadcrumbs();
                        break;
                    case 'bcn':
                        if (blogistic_compare_wand([blogistic_function_exists('bcn_display')]))
                            bcn_display();
                        break;
                    default:
                        do_action('blogistic_breadcrumb_trail_hook');
                        break;
                }
                ?>
            </div>
        </div><!-- .row-->
        <?php
    }
endif;
add_action('blogistic_before_main_content', 'blogistic_breadcrumb_html', 10);

if (!function_exists('blogistic_single_header_html')):
    /**
     * Theme single post header html
     * MARK: SINGLE HEADER
     *
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_single_header_html()
    {
        $single_post_layout = BIT\blogistic_get_customizer_option('single_post_layout');
        $single_image_size = BIT\blogistic_get_customizer_option('single_image_size');
        if (in_array($single_post_layout, ['layout-one']))
            return;
        if (!is_single())
            return;
        global $post;
        ?>
        <div class="rowblogistic-single-header">
            <?php
            $single_thumbnail_option = BIT\blogistic_get_customizer_option('single_thumbnail_option');
            if ($single_thumbnail_option):
                ?>
                <header class="entry-header">
                    <div class="post-thumb-wrap">
                        <?php
                        blogistic_post_thumbnail($single_image_size);
                        ?>
                    </div>
                    <div class="single-header-content-wrap">
                        <?php get_template_part('template-parts/single/partial', 'meta'); ?>
                    </div>
                </header><!-- .entry-header -->
                <?php
            endif;
            ?>
        </div><!-- .row-->
        <?php
    }
endif;
add_action('blogistic_before_main_content', 'blogistic_single_header_html', 20);

if (!function_exists('blogistic_theme_mode_switch')):
    /**
     * Function to return either icon html or image html
     * 
     * @param type
     * @since 1.0.0
     */
    function blogistic_theme_mode_switch($mode, $theme_mode)
    {
        $elementClass = ($theme_mode == 'light') ? 'lightmode' : 'darkmode';
        switch ($mode['type']):
            case 'icon':
                echo '<i class="' . esc_attr($mode['value'] . ' ' . $elementClass) . '"></i>';
                break;
            case 'svg':
                echo '<img class="' . esc_attr($elementClass) . '" src="' . esc_url(wp_get_attachment_image_url($mode['value'], 'full')) . '">';
                break;
        endswitch;
    }
endif;

if (!function_exists('blogistic_category_collection_html')):
    /**
     * Category Collection html part
     * MARK: CATEGORY COLLECTION
     * 
     * @since 1.0.0
     * @package Blogistic
     */
    function blogistic_category_collection_html()
    {
        $category_collection_render_in = BIT\blogistic_get_customizer_option('category_collection_render_in');
        if (!BIT\blogistic_get_customizer_option('category_collection_option') || is_paged()):
            return;
        elseif ($category_collection_render_in == 'front_page' && !is_front_page()):
            return;
        elseif ($category_collection_render_in == 'posts_page' && !is_home()):
            return;
        elseif ($category_collection_render_in == 'both' && (!is_front_page() && !is_home())):
            return;
        endif;
        if (!BIT\blogistic_get_customizer_option('category_collection_option'))
            return;
        $category_collection_layout = BIT\blogistic_get_customizer_option('category_collection_layout');
        $category_collection_show_count = BIT\blogistic_get_customizer_option('category_collection_show_count');
        $category_collection_number_of_columns = BIT\blogistic_get_customizer_option('category_collection_number_of_columns');
        $category_to_include = BIT\blogistic_get_customizer_option('category_to_include');
        $category_to_exclude = BIT\blogistic_get_customizer_option('category_to_exclude');
        $category_collection_number = BIT\blogistic_get_customizer_option('category_collection_number');
        $category_collection_orderby = BIT\blogistic_get_customizer_option('category_collection_orderby');
        $category_collection_sort = explode('-', $category_collection_orderby);
        $category_collection_offset = BIT\blogistic_get_customizer_option('category_collection_offset');
        $category_collection_hide_empty = BIT\blogistic_get_customizer_option('category_collection_hide_empty');
        $category_collection_slider_option = BIT\blogistic_get_customizer_option('category_collection_slider_option');
        $category_collection_image_size = BIT\blogistic_get_customizer_option('category_collection_image_size');
        $category_collection_hover_effects = BIT\blogistic_get_customizer_option('category_collection_hover_effects');
        $category_collection_box_shadow = blogistic_get_box_shadow_option_class('category_collection_box_shadow');
        $sectionClass = 'blogistic-category-collection-section';
        $sectionClass .= ' layout--' . $category_collection_layout;
        $sectionClass .= ' hover-effect--' . $category_collection_hover_effects;
        $sectionClass .= ' column--' . blogistic_convert_number_to_numeric_string(absint($category_collection_number_of_columns['desktop']));
        $sectionClass .= ' tab-column--' . blogistic_convert_number_to_numeric_string(absint($category_collection_number_of_columns['tablet']));
        $sectionClass .= ' mobile-column--' . blogistic_convert_number_to_numeric_string(absint($category_collection_number_of_columns['smartphone']));
        if ($category_collection_box_shadow)
            $sectionClass .= $category_collection_box_shadow;
        if ($category_collection_slider_option)
            $sectionClass .= ' slider-enabled';
        if ($category_collection_show_count)
            $sectionClass .= ' category-count--enabled';
        $category_args = [
            'number' => absint($category_collection_number),
            'exclude' => (!empty($category_to_exclude)) ? array_column(json_decode($category_to_exclude), 'value') : [],
            'include' => (!empty($category_to_include)) ? array_column(json_decode($category_to_include), 'value') : [],
            'hide_empty' => is_bool($category_collection_hide_empty),
            'offset' => absint($category_collection_offset),
            'orderby' => $category_collection_sort[1],
            'order' => $category_collection_sort[0]
        ];
        $get_all_categories = get_categories($category_args);
        ?>
        <section class="<?php echo esc_attr($sectionClass); ?>" id="blogistic-category-collection-section">
            <div class="blogistic-container">
                <div class="row">
                    <div class="category-collection-wrap">
                        <?php
                        if (!is_null($get_all_categories) && is_array($get_all_categories)):
                            foreach ($get_all_categories as $cat_key => $cat_value):
                                $category_query_args = [
                                    'post_type' => 'events',
                                    'cat' => absint($cat_value->term_id),
                                    'meta_query' => [
                                        [
                                            'key' => '_thumbnail_id',
                                            'compare' => 'EXISTS'
                                        ]
                                    ],
                                    'ignore_stick_posts' => true
                                ];
                                $category_query = new WP_Query(apply_filters('blogistic_query_args_filter', $category_query_args));
                                if ($category_query->have_posts()):
                                    $thumbnail_id = ($category_query->posts[0]->ID != null) ? $category_query->posts[0]->ID : '';
                                else:
                                    $thumbnail_id = '';
                                endif;
                                ?>
                                <div class="category-wrap">
                                    <figure class="category-thumb">
                                        <a href="<?php echo get_term_link($cat_value->term_id, 'category'); ?>">
                                            <?php if ($thumbnail_id):
                                                echo wp_kses_post(get_the_post_thumbnail($thumbnail_id));
                                            endif;
                                            ?>




                                        </a>
                                    </figure>
                                    <div class="category-item cat-meta">
                                        <div class="category-item-inner">
                                            <div class="category-name">
                                                <a href="<?php echo get_term_link($cat_value->term_id, 'category'); ?>">
                                                    <span class="category-label"><?php echo esc_html($cat_value->name); ?></span>
                                                    <?php if ($category_collection_show_count)
                                                        echo '<span class="category-count">' . esc_html($cat_value->count . ' posts') . '</span>'; ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="category-item-second cat-meta">
                                        <div class="category-item-inner">
                                            <div class="category-name">
                                                <a href="<?php echo get_term_link($cat_value->term_id, 'category'); ?>">
                                                    <span class="category-label"><?php echo esc_html($cat_value->name); ?></span>
                                                    <?php if ($category_collection_show_count)
                                                        echo '<span class="category-count">' . esc_html($cat_value->count . ' posts') . '</span>'; ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
    add_action('blogistic_header_after_hook', 'blogistic_category_collection_html', 20);
endif;

if (!function_exists('blogistic_button_html')):
    /**
     * View all html
     * MARK: ARCHIVE BUTTON
     * 
     * @package Newsis Pro
     * @since 1.0.0
     */
    function blogistic_button_html($args)
    {
        if (!$args['show_button'])
            return;
        $global_button_label = BIT\blogistic_get_customizer_option('global_button_label');
        $global_button_icon_picker = BIT\blogistic_get_customizer_option('global_button_icon_picker');
        $archive_read_more_button_on_mobile = BIT\blogistic_get_customizer_option('show_readmore_button_mobile_option');
        $read_more_button_hide_on_mobile = (!$archive_read_more_button_on_mobile) ? ' hide-on-mobile' : '';

        $classes = isset($args['classes']) ? 'post-link-button' . ' ' . $args['classes'] : 'post-button';
        $classes .= $read_more_button_hide_on_mobile;
        $link = isset($args['link']) ? $args['link'] : get_the_permalink();
        $text = isset($args['text']) ? $args['text'] : apply_filters('blogistic_global_button_label_fitler', $global_button_label);
        $icon = isset($args['icon']) ? $args['icon'] : $global_button_icon_picker['value'];
        echo apply_filters('blogistic_button_html', sprintf('<a class="%1$s" href="%2$s">%3$s<span class="button-icon"><i class="%4$s"></i></span></a>', esc_attr($classes), esc_url($link), '<span class="button-text">' . esc_html($text) . '</span>', esc_attr($icon)));
    }
    add_action('blogistic_section_block_view_all_hook', 'blogistic_button_html', 10, 1);
endif;