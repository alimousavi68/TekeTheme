<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blogistic
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
use Blogistic\CustomizerDefault as BIT;
$widgets_box_shadow = blogistic_get_box_shadow_option_class( 'widgets_box_shadow');
$asideClass = 'widget-area';
if( $widgets_box_shadow ) $asideClass .= $widgets_box_shadow;
?>

<aside id="secondary" class="<?php echo esc_attr( $asideClass ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
