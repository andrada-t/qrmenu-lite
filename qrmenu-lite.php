<?php
/*
 * Plugin Name:       QRMenu Lite
 * Plugin URI:        https://qrmenu.modeltheme.com/qrmenu-lite/
 * Description:       The Lite version of our Restaurant QR Menu Generator
 * Version:           1.0.1
 * Requires at least: 4.6
 * Tested up to:      6.4.3
 * Requires PHP:      7.0
 * Author:            Modeltheme
 * Author URI:        https://modeltheme.com/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       qrlite
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

include_once ABSPATH . 'wp-admin/includes/plugin.php';
if( is_plugin_active('qrlite/qrlite.php') ){
     add_action('update_option_active_plugins', 'qrlite_deactivate_qrlite');
}
function qrlite_deactivate_qrlite(){
   deactivate_plugins('qrlite/qrlite.php');
}

define('QRLITE_PLUGIN_FILE', __FILE__);
DEFINE('QRLITE_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('QRLITE_LOGO_PATH', QRLITE_PLUGIN_URL.'assets/images/logo.svg');
define('QRLITE_LOGO_DARK_PATH', QRLITE_PLUGIN_URL.'assets/images/qrlite-footer.png');
define('QRLITE_PLUGIN_PATH', dirname(QRLITE_PLUGIN_FILE));
define('QRLITE_PLUGIN_INC', trailingslashit(path_join(QRLITE_PLUGIN_PATH, 'inc')));
define('QRLITE_PLUGIN_VIEW', trailingslashit(path_join(QRLITE_PLUGIN_PATH, 'view')));
define('QRLITE_DEV_MODE', false);
define('QRLITE_CC_ID', '41476279');

if ( ! class_exists( 'CMB2_Bootstrap_2101', false ) ) {
    require_once ('vendor/cmb2/init.php');
}
if ( ! class_exists( 'CMB2_Conditionals', false ) ) {
    require_once ('vendor/cmb2-conditionals/cmb2-conditionals.php');
}
require_once('core/include.php');
require_once('inc/admin/settings.php');
require_once('inc/CPT.php');
require_once('inc/helpers.php');
require_once('inc/builder/builder.php');
require_once('inc/builder/elements/inc.php');
require_once('view/frontend.parts.php');

add_action( 'init', 'qrlite_load_textdomain' );
function qrlite_load_textdomain() {
    $domain = 'qrlite';
    load_plugin_textdomain( $domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}



add_filter('template_include', 'qrlite_page_template');
function qrlite_page_template($single_template ) {
    global $post;

    if ( isset($post->post_type) && $post->post_type === 'qrlite-link' && ! is_search() ) {
        $single_template = QRLITE_PLUGIN_VIEW . 'page_template.php';
    }

    if (is_singular('qrlite-link')) {

        $bio_link = get_the_ID();
        $configuration = get_post_meta( $bio_link, 'qrlite_configuration', true );
        $seo_indexable = ((array_key_exists('seo_indexable', $configuration))?$configuration['seo_indexable']:"off");
        
        if ($seo_indexable == 'on') {
            add_filter( 'wp_robots', 'wp_robots_no_robots' );
        }
    }

    return $single_template;
}

function qrlite_enqueue_admin_scripts($hook) {
    wp_enqueue_script('bootstrap', QRLITE_PLUGIN_URL . 'vendor/bootstrap/js/bootstrap.bundle.min.js', array('jquery'), '5.3.1', true);
    wp_enqueue_style('qrlite-custom', QRLITE_PLUGIN_URL . 'assets/custom-style.css');
    if ($hook == 'qrlite-link_page_pricing' || $hook == 'qrlite-link_page_mt-activator') {
        wp_enqueue_style('bootstrap', QRLITE_PLUGIN_URL . 'vendor/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('qrlite-custom', QRLITE_PLUGIN_URL . 'assets/custom-style.css');
    }

    if ($hook == 'admin_page_qrlite-page-builder') {
        // CSS
        wp_enqueue_style('qrlite-custom', QRLITE_PLUGIN_URL . 'assets/custom-style.css');
        wp_enqueue_style('bootstrap', QRLITE_PLUGIN_URL . 'vendor/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('font-awesome5',  QRLITE_PLUGIN_URL . 'vendor/font-awesome/all.min.css');

        wp_enqueue_style('select2', QRLITE_PLUGIN_URL . 'vendor/select2/select2.min.css');
        wp_enqueue_style('coloris', QRLITE_PLUGIN_URL . 'vendor/coloris/coloris.min.css');

        // JS
        wp_enqueue_media();
        wp_enqueue_script('bootstrap', QRLITE_PLUGIN_URL . 'vendor/bootstrap/js/bootstrap.bundle.min.js', array('jquery'), '5.3.1', true);
        wp_enqueue_script('gianniAccordion', QRLITE_PLUGIN_URL . 'vendor/gianniAccordion/gianniAccordion.min.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('gianniAccordion1', QRLITE_PLUGIN_URL . 'vendor/gianniAccordion/gianniAccordion.min2.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('jquery-repeater', QRLITE_PLUGIN_URL . 'vendor/jquery.repeater/jquery.repeater.min.js', array('jquery'), '1.2.2', true);
        wp_enqueue_script('select2', QRLITE_PLUGIN_URL . 'vendor/select2/select2.full.min.js', array('jquery'), '4.0.3', true);
        wp_enqueue_script('coloris', QRLITE_PLUGIN_URL . 'vendor/coloris/coloris.min.js', array('jquery'), '1.0.0', true);
        $script_data_array = array(
            'url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'qrlite_import_element' )
        );
        wp_enqueue_script('qrlite-custom', QRLITE_PLUGIN_URL . 'assets/custom-scripts.js', array('jquery'), '1.0', true);
        wp_localize_script( 'qrlite-custom', 'qrlite_builder_ajax', $script_data_array );
    }
}
add_action('admin_enqueue_scripts', 'qrlite_enqueue_admin_scripts');


function qrlite_frontend_enqueue_scripts() {
    $builder_endpoints = array(
        'qrlite-builder',
        'my-link-pages'
    );
    if (is_singular('qrlite-link')) {
        wp_enqueue_style('bootstrap', QRLITE_PLUGIN_URL . 'vendor/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('qrlite-custom-template-style', QRLITE_PLUGIN_URL . 'assets/custom-template-style.css');
        wp_enqueue_style( 'font-awesome5',  QRLITE_PLUGIN_URL . 'vendor/font-awesome/all.min.css');
        wp_enqueue_script('qrlite-custom-template-scripts', QRLITE_PLUGIN_URL . 'assets/custom-template-scripts.js', array('jquery'), '1.0', true);
        wp_enqueue_script('bootstrap', QRLITE_PLUGIN_URL . 'vendor/bootstrap/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);
    }
}
add_action('wp_enqueue_scripts', 'qrlite_frontend_enqueue_scripts');

function qrlite_restrict_media_library( $query ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        global $pagenow;
        if ( 'upload.php' == $pagenow || 'admin-ajax.php' == $pagenow ) {
            $query->set( 'author', get_current_user_id() );
        }
    }
}
add_action( 'pre_get_posts', 'qrlite_restrict_media_library' );

 function qrlite_load_dashicons(){
     wp_enqueue_style('dashicons');
 }
 add_action('wp_enqueue_scripts', 'qrlite_load_dashicons');

function qrlite_enable_customer_upload_capability() {
    $role = get_role( 'customer' );
    if (function_exists('has_cap')) {
        if ( ! $role->has_cap( 'upload_files' ) ) {
            $role->add_cap( 'upload_files' );
        }
        if ( ! $role->has_cap( 'delete_posts' ) ) {
            $role->add_cap( 'delete_posts' );
        }
        if ( ! $role->has_cap( 'edit_posts' ) ) {
            $role->add_cap( 'edit_posts' );
        }
        if ( ! $role->has_cap( 'publish_posts' ) ) {
            $role->add_cap( 'publish_posts' );
        }
    }
}
add_action( 'init', 'qrlite_enable_customer_upload_capability' );


// Function to sanitize input
function qrlite_sanitizeInput($input) {
    if (is_array($input)) {
        foreach ($input as $key => $value) {
            $input[$key] = qrlite_sanitizeInput($value);
        }
    } else {
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
    return $input;
}
