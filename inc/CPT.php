<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
* CPT Registration
*
*/
function qrlite_links_cpt() {
    register_post_type('qrlite-link',
    [
        'labels'      => [
            'name'          => esc_html__('QRMenu Lite', 'qrlite'),
            'menu_name'     => esc_html__('QRMenu Lite', 'qrlite'),
        ],
        'show_ui'             => true, 
        'show_in_menu'        => true, 
        'show_in_nav_menus'   => true, 
        'show_in_admin_bar'   => true, 
        'menu_icon' => QRLITE_PLUGIN_URL.'assets/images/menu-icon.svg',
        'public'      => true,
        'has_archive' => true,
        'capabilities' => [
            'edit_post' => 'manage_options',
            'edit_posts' => 'manage_options',
            'edit_others_posts' => 'manage_options',
            'publish_posts' => 'manage_options',
            'read_post' => 'manage_options',
            'read_private_posts' => 'manage_options',
            'delete_post' => 'manage_options',
            'create_posts' => false,
        ],
    ]
    ); 
}
add_action('init', 'qrlite_links_cpt');


/**
* Remove CPT Slug from URL
*
*/
add_filter('post_type_link', 'qrlite_remove_cpt_slug', 10, 3);
function qrlite_remove_cpt_slug($post_link, $post, $leavename) {
    if ( 'qrlite-link' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }

    return str_replace( '/' . $post->post_type . '/', '/', $post_link );
}

/**
* Parse Request to recognise the removed slug from qrlite links
*
* Just removing the slug isn't enough. Right now, you'll get a 404 page because WordPress only expects posts and pages to behave this way.
* These cases are handled in this filter callback, that runs on the 'pre_handle_404' filter.
*
*/
add_filter('pre_get_posts', 'qrlite_parse_request');
function qrlite_parse_request($query) {

    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }

    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'qrlite-link', 'page' ) );
    }

}


/**
* Handle 404
*
* This method runs after a page is not found in the database, but before a page is returned as a 404.
* These cases are handled in this filter callback, that runs on the 'pre_handle_404' filter.
*
*/
add_filter( 'pre_handle_404',
    function ($value, $query ) {
        return qrlite_parse_request_on_error( $value, $query );
    },
10, 2 );
function qrlite_parse_request_on_error($value, $query) {

    global $wp_query;

    if ( $value ) {
        return $value;
    }

    if (! $query->is_main_query() || ! empty( $query->posts ) || ! empty( $query->tax_query->table_aliases ) ) {

        return false;

    }

    if ( ! empty($query->query['name']) ) {

        $new_query = new WP_Query( [
            'post_type' => ['qrlite-link'],
            'name' => $query->query['name'],
        ] );

    } else {

        $new_query = new WP_Query( [
            'post_type' => ['qrlite-link'],
            'name' => strtolower(preg_replace('/[\W\s\/]+/', '-', ltrim(sanitize_text_field($_SERVER['REQUEST_URI'], '/')))),
        ] );

    }

    if ( ! empty( $new_query->posts ) ) {
        $wp_query = $new_query;
    }

    return false;
}


add_filter( 'post_row_actions', 'qrlite_modify_list_row_actions', 10, 2 );
function qrlite_modify_list_row_actions( $actions, $post ) {
    // Check for your post type.
    if ( $post->post_type == "qrlite-link" ) {

        // Build your links URL.
        $url = admin_url( 'admin.php?page=qrlite-page-builder&links_page=' . $post->ID );
        $edit_link = add_query_arg( array( 'action' => 'edit' ), $url );

        $actions = array_merge($actions, array(
            'edit' => sprintf( '<a href="%1$s">%2$s</a>',
            esc_url( $edit_link ),
            esc_html__( 'Edit', 'qrlite' ) )
        ));
    }

    return $actions;
}