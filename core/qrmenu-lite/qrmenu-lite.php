<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Register Widgets.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */

if( !function_exists('qrlite_custom_widgets') ) {
    function qrlite_custom_widgets( $widgets_manager ) {

        require_once( __DIR__ . '/widgets/menu-items/menu-items.elementor.php' );
        $widgets_manager->register( new \QRlite_Menu_Items() );
    }
    add_action( 'elementor/widgets/register', 'qrlite_custom_widgets' );
}

if( !function_exists('qrlite_bio_links_styles') ) {
    function qrlite_bio_links_styles() {
        wp_enqueue_style( 'qrlite-menu-items', plugins_url( 'assets/css/menu-items.css', __FILE__ ), array(), '1.0.0', 'all' );
    }
    add_action( 'wp_enqueue_scripts', 'qrlite_bio_links_styles' );
}

require_once( __DIR__ . '/widgets/menu-items/menu-items.shortcode.php' );