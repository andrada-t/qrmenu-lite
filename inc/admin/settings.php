<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Add the settings menu
add_action('admin_menu', 'qrlite_settings_panel_menu', 5);
function qrlite_settings_panel_menu() {
    add_submenu_page(
        '',
        esc_html__( 'Builder', 'qrlite' ),
        esc_html__( 'Builder', 'qrlite' ),
        'manage_options',
        'qrlite-page-builder',
        'qrlite_page_builder_body'
    );
    add_submenu_page(
        'edit.php?post_type=qrlite-link', 
        esc_html__( 'Add New', 'qrlite' ),
        esc_html__( 'Add New', 'qrlite' ),
        'manage_options', 
        admin_url('admin.php?page=qrlite-page-builder')
    );
    add_submenu_page(
        'edit.php?post_type=qrlite-link',  // Parent menu slug
        esc_html__( 'Settings', 'qrlite' ),
        esc_html__( 'Settings', 'qrlite' ),
        'manage_options',
        'qrlite-main-settings',
        'qrlite_general_settings_page'
    ); 
}


require('settings.general.php');

function qrlite_settings_tabs($tab_id){
    ?>
        <h2 class="nav-tab-wrapper">
            <a href="?post_type=qrlite-link&page=qrlite-main-settings" class="nav-tab <?php if($tab_id == 'general'){echo esc_attr('nav-tab-active');} ?>"><?php echo esc_html__('General Settings', 'qrlite'); ?></a>
        </h2>
    <?php 
}
add_action('qrlite_before_wrap_tab_content', 'qrlite_settings_tabs');