<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Save the setting value
function qrlite_page_builder_save_settings() {
    if (isset($_POST['qrlite_form_configuration']) && isset($_POST['qrlite_nonce'])) {
        $nonce = sanitize_text_field($_POST['qrlite_nonce']);
        if (wp_verify_nonce($nonce, 'qrlite_nonce_action')) {
            $post_name = isset($_POST['seo_page_slug']) ? sanitize_text_field($_POST['seo_page_slug']) : '';
            $post_title = isset($_POST['seo_page_title']) ? sanitize_text_field($_POST['seo_page_title']) : '';
            $form_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';

            if (empty(sanitize_text_field($_POST['post_id']))) {

                $post_id = wp_insert_post([
                    'post_title' => esc_attr($post_title),
                    'post_name' => esc_attr($post_name),
                    'post_status' => 'publish',
                    'post_type' => 'qrlite-link',
                    'post_author' => wp_get_current_user()->ID,
                ]);
                $_POST['post_id'] = $post_id;
                update_post_meta($post_id, 'qrlite_configuration', qrlite_sanitizeInput($_POST));
            }else{
                $post_id = $form_id;
                update_post_meta($post_id, 'qrlite_configuration', qrlite_sanitizeInput($_POST));

                $qrlite_configuration = get_post_meta( $post_id, 'qrlite_configuration', true );

                $current_post = array(
                    'ID' => $post_id,
                );
                if (get_post_field( 'post_name', $post_id ) != $post_name) {
                    $current_post['post_name'] = esc_attr($post_name);
                }
                if (get_the_title($post_id) != $post_title) {
                    $current_post['post_title'] = esc_attr($post_title);
                }

                // Update the post into the database
                wp_update_post( $current_post );
            }
        } else {
            die('Security check failed!');
        }
    }
}

add_action('admin_init', 'qrlite_page_builder_save_settings');
add_action('init', 'qrlite_page_builder_save_settings');
