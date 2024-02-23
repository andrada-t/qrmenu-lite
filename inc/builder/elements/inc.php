<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function qrlite_available_element_types(){
    
    $available_elements = array(
        'menu-item',
        'nav-menu',
    );

    return $available_elements;
}


function qrlite_import_element() {

    if (isset($_POST['element_type']) && isset($_POST['qrlite_nonce'])) {
        $nonce = sanitize_text_field($_POST['qrlite_nonce']);

        if (wp_verify_nonce($nonce, 'qrlite_nonce_action')) {
            $type = sanitize_title($_POST['element_type']);

            $available_elements = qrlite_available_element_types();

            if (in_array($type, $available_elements)) {
                require_once($type.'.php');
            }else{
                echo esc_html__('Upgrade your subscription', 'qrlite');
            }

            wp_die();
        } else {
            die('Security check failed!');
        }    
    } else {
        $type = sanitize_text_field($_POST['element_type']);
        $available_elements = qrlite_available_element_types();

        if (in_array($type, $available_elements)) {
            require_once($type.'.php');
        }else{
            echo esc_html__('Upgrade your subscription', 'qrlite');
        }
        wp_die();
    }

}
add_action( 'wp_ajax_qrlite_import_element', 'qrlite_import_element' );
add_action( 'wp_ajax_nopriv_qrlite_import_element', 'qrlite_import_element' );