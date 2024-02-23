<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// process the form
require_once('builder.fields.php');
require_once('builder.save.php');

// Generate the settings panel page
add_action('qrlite_page_builder_frontend', 'qrlite_page_builder_body');
function qrlite_page_builder_body($post_id = '') {

    $qrlite_nonce = esc_attr(wp_create_nonce('qrlite_nonce_action'));
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $username = $current_user->user_login;

    if ($post_id) {
        $current_post_id = $post_id;
    }else{
        if (isset($_GET['links_page'])) {
            $current_post_id = absint(sanitize_text_field($_GET['links_page'])); //post id
        }else{
            if (isset($_POST['post_id']) && isset($_POST['qrlite_nonce'])) {
                $nonce = sanitize_text_field($_POST['qrlite_nonce']);
                if (wp_verify_nonce($nonce, 'qrlite_nonce_action')) {
                    $current_post_id = absint(sanitize_text_field($_POST['post_id'])); //post id
                } else {
                    die('Security check failed!');
                }
            }else{
                $current_post_id = '';
                $current_post_link = '';
            }
        }
    }

    $qrlite_configuration = array();
    if (isset($_GET['use_template']) && !empty($_GET['use_template'])) {
        $qrlite_configuration = qrlite_quickstart_template(sanitize_title($_GET['use_template']));
    }else{
        if (get_post_meta( $current_post_id, 'qrlite_configuration', true )) {
            $qrlite_configuration = get_post_meta( $current_post_id, 'qrlite_configuration', true );
        }
    }

    $nav_menu_groups =              ((array_key_exists('qrlite-nav-menu-group', $qrlite_configuration))?$qrlite_configuration['qrlite-nav-menu-group']:array());
    $nav_menu_inner_groups =        ((array_key_exists('qrlite-nav-menu-inner-group', $qrlite_configuration))?$qrlite_configuration['qrlite-nav-menu-inner-group']:array());
    $container_width =              ((array_key_exists('container_width', $qrlite_configuration))?$qrlite_configuration['container_width']:"650");
    $container_tb_space =           ((array_key_exists('container_tb_space', $qrlite_configuration))?$qrlite_configuration['container_tb_space']:"100");
    $user_name =                    ((array_key_exists('user_name', $qrlite_configuration))?$qrlite_configuration['user_name']:"");
    $user_bio =                     ((array_key_exists('user_bio', $qrlite_configuration))?$qrlite_configuration['user_bio']:"");
    $alignment =                    ((array_key_exists('alignment', $qrlite_configuration))?$qrlite_configuration['alignment']:"left");
    $template_version =             ((array_key_exists('template_version', $qrlite_configuration))?$qrlite_configuration['template_version']:"v1");
    $template_column =              ((array_key_exists('template_column', $qrlite_configuration))?$qrlite_configuration['template_column']:"1");
    $template_layout =              ((array_key_exists('template_layout', $qrlite_configuration))?$qrlite_configuration['template_layout']:"block");
    $body_bg_color =                ((array_key_exists('body_bg_color', $qrlite_configuration))?$qrlite_configuration['body_bg_color']:"");
    $body_text_color =              ((array_key_exists('body_text_color', $qrlite_configuration))?$qrlite_configuration['body_text_color']:"");
    $body_accent_color =              ((array_key_exists('body_accent_color', $qrlite_configuration))?$qrlite_configuration['body_accent_color']:"");
    $seo_page_slug =                ((array_key_exists('seo_page_slug', $qrlite_configuration))?$qrlite_configuration['seo_page_slug']:esc_attr($username));
    $seo_page_slug_id =             ((array_key_exists('seo_page_slug_id', $qrlite_configuration))?$qrlite_configuration['seo_page_slug_id']:"");
    $seo_page_title =               ((array_key_exists('seo_page_title', $qrlite_configuration))?$qrlite_configuration['seo_page_title']:esc_attr($username));

    $brand_logo = QRLITE_LOGO_PATH;
    $settings = get_option('qrlite-main-settings');
    if ($settings) {
        $whitelabel_logo_id = ((array_key_exists('qrlite_whitelabel_logo_id', $settings))?$settings['qrlite_whitelabel_logo_id']:"");
        if (!empty($whitelabel_logo_id)) {
            $brand_logo = wp_get_attachment_url($whitelabel_logo_id);
        }
    }
    ?>

    <?php if ( 
        is_admin() || 
        (!is_admin() && function_exists('user_has_active_plans') && user_has_active_plans()) ||
        (!is_admin() && qrlite_free_accounts_enabled())
        ) { ?>
        <div class="wrap relative">
            <!-- Header -->
            <header class="p-2 bg-white text-black">
                <div class="">
                    <div class="d-flex flex-wrap align-items-center justify-content-between qrlite-wrapper">
                        <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                            <img src="<?php echo esc_url($brand_logo); ?>" alt="logo" width="150" />
                        </a>
 
                        <div class="text-end">
                            <button type="button" class="btn btn-outline-light qrlite-seo-modal" data-bs-toggle="modal" data-bs-target="#qrlite_seo_modal"><?php esc_html_e('SEO Settings', 'qrlite'); ?></button>
                            <button type="button" class="btn btn-warning qrlite_share_modal" data-bs-toggle="modal" data-bs-target="#qrlite_share_modal"><i class="fas fa-external-link-alt"></i> <?php esc_html_e('Share', 'qrlite'); ?></button>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Preview" class="btn btn-primary" href="<?php echo esc_url(get_permalink($current_post_id)); ?>" target="_blank"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Container -->
            <div class="container-fluid pb-3 qrlite-settings-full-container">
                <div class="d-grid gap-3">
                    <!-- Builder -->
                    <div class="bg-light border mt-3 meek-preview-box" >
                        <ul class="nav nav-tabs qrlite-nav-tabs col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button data-attr="tab" data-attr-val="links" class="nav-link <?php if(qrlite_builder_active_tab() == 'links'){echo esc_attr('active');} ?>" id="links-tab" data-bs-toggle="tab" data-bs-target="#links" type="button" role="tab" aria-controls="general-settings" aria-selected="true">
                                <i class="fa-solid fa-book-open-reader"></i> <?php esc_html_e('Menus', 'qrlite'); ?></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button data-attr="tab" class="nav-link <?php if(qrlite_builder_active_tab() == 'profile'){echo esc_attr('active');} ?>" data-attr="tab" data-attr-val="profile" id="advanced-settings-tab" data-bs-toggle="tab" data-bs-target="#advanced-settings" type="button" role="tab" aria-controls="advanced-settings" aria-selected="false">
                                <?php esc_html_e('Restaurant', 'qrlite'); ?></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button data-attr="tab" class="nav-link <?php if(qrlite_builder_active_tab() == 'settings'){echo esc_attr('active');} ?>" id="general-settings-tab" data-bs-toggle="tab" data-bs-target="#general-settings" type="button" role="tab" data-attr-val="settings" aria-controls="social-media-settings" aria-selected="false">
                                <i class="fa-solid fa-gear"></i> <?php esc_html_e('Settings', 'qrlite'); ?></button>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-light border p-3 mt-3 qrlite-main">
                        <form id="ajax-general-settings-form" class="qrlite-configuration-form" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>" />
                            <input type="hidden" name="qrlite_nonce" value="<?php echo esc_attr($qrlite_nonce); ?>" />
                            <input type="hidden" id="qrlite_post_id" name="post_id" value="<?php echo esc_attr($current_post_id); ?>" />

                            <div class="tab-content">
                                <div id="links" class="tab-pane show <?php if(qrlite_builder_active_tab() == 'links'){echo esc_attr('active');} ?>" role="tabpanel" aria-labelledby="links-tab">
                                    <button type="button" class="mb-2 btn btn-sm btn-secondary qrlite-btn-styles-modal" data-bs-toggle="modal" data-bs-target="#qrlite_btn_styles_modal"><i class="fas fa-paint-brush"></i> <?php esc_html_e('Styling', 'qrlite'); ?></button>
                                    <div class="qrlite-delimitator"></div>
                                    <h4><?php echo esc_html__('Edit Menu:','qrlite'); ?></h4>
                                    
                                    <div class="qrlite-buttons-group">
                                        <div class="qrlite-bio-links-inner-dropdowns qrlite-accordion-cards">
                                            <div data-repeater-list="qrlite-nav-menu-group" class="qrlite-buttons-group-inner accordion">
                                                <?php 
                                                if ($nav_menu_groups) {
                                                    foreach ($nav_menu_groups as $key => $nav_menu) { ?>
                                                        <div id="group-inner-<?php echo esc_attr($key); ?>" class="qrlite-accordion-card-inner main-card">
                                                            <div data-repeater-item class="accordion-item qrlite-bio-links-inner-dropdown">
                                                                <div data-accordion-element-trigger class="qrlite-accordion-contents">
                                                                    <div class="qrlite-accordion-title primary relative">
                                                                        <i class="fas fa-grip-vertical qrlite-reorder-btn"></i>
                                                                        <?php 
                                                                        if(!empty($nav_menu['category'])) {
                                                                            echo esc_html($nav_menu['category']);
                                                                            do_action('qrlite_builder_after_title');
                                                                        } else {
                                                                            echo esc_html__('New Menu','qrlite');
                                                                        }
                                                                        ?>
                                                                        <i data-repeater-delete class="fa fa-solid fa-trash"></i>
                                                                    </div>
                                                                </div> 
                                                                <div data-accordion-element-content class="qrlite-accordion-content_main">
                                                                    <div class="accordion-body">
                                                                        <div class="card-body">
                                                                        <?php 
                                                                        echo esc_html(qrlite_input('text', 'category', $nav_menu['category'], esc_html__('Name', 'qrlite'), 'category', true));
                                                                        ?>
                                                                        </div>
                                                                    </div>
                                                                <!-- innner repeater -->
                                                                <div class="inner-repeater">
                                                                    <div data-repeater-list="qrlite-nav-menu-inner-group" class="qrlite-buttons-group-inners accordion">
                                                                        <h5 class="qrlite-heading"><?php echo esc_html__('Items: ','qrlite'); ?></h5>
                                                                        <?php 
                                                                        if ($nav_menu['qrlite-nav-menu-inner-group']) {
                                                                            foreach ($nav_menu['qrlite-nav-menu-inner-group'] as $key => $nav_menu_inner) { 
                                                                                $photo_id = '';
                                                                                $photo_img = '';
                                                                                if(array_key_exists('dish_image', $nav_menu_inner)){
                                                                                    $photo_id = $nav_menu_inner['dish_image'];
                                                                                }
                                                                                $attachment_url = '';
                                                                                if (wp_get_attachment_url($photo_id)) {
                                                                                    $attachment_url = wp_get_attachment_url($photo_id);
                                                                                }
                                                                                $badge_alignment = '';
                                                                                if(array_key_exists('badge_alignment', $nav_menu_inner)){if(!empty($nav_menu_inner['badge_alignment'])){$badge_alignment = $nav_menu_inner['badge_alignment'];} else {$badge_alignment = 'center';}}
                                                                                $hide_menu = '';
                                                                                if(array_key_exists('hide_menu', $nav_menu_inner)){if(!empty($nav_menu_inner['hide_menu'])){$hide_menu = $nav_menu_inner['hide_menu'];} else {$hide_menu = 'off';}}
                                                                                $out_of_stock = '';
                                                                                if(array_key_exists('out_of_stock', $nav_menu_inner)){if(!empty($nav_menu_inner['out_of_stock'])){$out_of_stock = $nav_menu_inner['out_of_stock'];} else {$out_of_stock = 'off';}}
                                                                                ?>

                                                                                <div data-repeater-item class="qrlite-bio-links-inner-dropdown qrlite-accordion-card">
                                                                                    <div class="qrlite-accordion-card-inner">
                                                                                        <div class="qrlite-accordion-title relative" data-accordion-element-trigger>
                                                                                            <div class="menu-description">
                                                                                                <?php if(!empty($attachment_url)) { ?>
                                                                                                    <img src="<?php echo esc_url($attachment_url); ?>" alt="menu-items-image">
                                                                                                <?php } ?>
                                                                                                <div class="title-sub">
                                                                                                    <?php 
                                                                                                    if(!empty($nav_menu_inner['dish_title'])) {
                                                                                                        echo esc_html($nav_menu_inner['dish_title']);
                                                                                                    } else {
                                                                                                        echo esc_html__('Menu Item','qrlite');
                                                                                                    }
                                                                                                    if(!empty($nav_menu_inner['dish_description'])){ ?>
                                                                                                        <p><?php echo esc_html($nav_menu_inner['dish_description'])?></p>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                                <?php if(!empty($nav_menu_inner['dish_price'])) { ?>
                                                                                                    <div class="menu-description-price">
                                                                                                       <?php echo esc_html(qrlite_get_currency_formatted($nav_menu_inner['dish_price'])); ?>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                            <div class="part-delete-hide">
                                                                                                <div class="hide-menu-tooltip">
                                                                                                    <?php
                                                                                                    echo esc_html(qrlite_checkbox('', $hide_menu, 'hide_menu', '')); ?>
                                                                                                    <span class="tooltiptext"><?php echo esc_html__('Hide Menu','qrlite'); ?></span>
                                                                                                </div>
                                                                                                <i data-repeater-delete class="fa fa-solid fa-trash"></i>
                                                                                            </div>
                                                                                        </div>
                                                                            
                                                                                        <div data-accordion-element-content class="qrlite-accordion-content">
                                                                                            <div class="accordion-body">
                                                                                                <div class="card-body d-flex">
                                                                                                    <div class="col-md-8">
                                                                                                    <?php 
                                                                                                                                           
                                                                                                        echo esc_html(qrlite_input('text', 'dish_title', $nav_menu_inner['dish_title'], esc_html__('Dish Title', 'qrlite'), 'dish_title', true)); ?>
                                                                                                        <div class="row group-toggles">
                                                                                                            <?php
                                                                                                            echo esc_html(qrlite_input('text', 'dish_price', $nav_menu_inner['dish_price'], esc_html__('Price', 'qrlite'), 'dish_price', true, 'col-md-6'));
                                                                                                            echo esc_html(qrlite_input('text', 'dish_sale_price', $nav_menu_inner['dish_sale_price'], esc_html__('Sale Price', 'qrlite'), 'dish_sale_price', true, 'col-md-6')); ?>
                                                                                                        </div>
                                                                                                        <?php
                                                                                                        echo esc_html(qrlite_textarea('dish_description', $nav_menu_inner['dish_description'], esc_html__('Dish Description', 'qrlite'), 'dish_description', true)); ?>
                                                                                                        <div class="row group-toggles">
                                                                                                            <?php
                                                                                                            echo esc_html(qrlite_input('text', 'grams', $nav_menu_inner['grams'], esc_html__('Portion size', 'qrlite'), 'grams', true, 'col-md-6'));
                                                                                                            echo esc_html(qrlite_input('text', 'preparation_time', $nav_menu_inner['preparation_time'], esc_html__('Preparation Time', 'qrlite'), 'preparation_time', true, 'col-md-6')); ?>
                                                                                                        </div>
                                                                                                        <?php
                                                                                                        echo esc_html(qrlite_input('text', 'dish_promotion', $nav_menu_inner['dish_promotion'], esc_html__('Dish Promotion', 'qrlite'), 'dish_promotion', true, '')); 
                                                                                                        echo esc_html(qrlite_media_uploader('dish_image', esc_attr($photo_id), esc_url($photo_img), esc_html__('Image', 'qrlite'), '')); ?>
                                                                                                    </div>
                                                                                                    <div class="col-md-4"><?php
                                                                                                        echo esc_html(qrlite_checkbox('col-md-12',  $out_of_stock, 'out_of_stock', esc_html__('Out of Stock', 'qrlite')));
                                                                                                        echo esc_html(qrlite_input('text', 'dish_subcateg', $nav_menu_inner['dish_subcateg'], esc_html__('Subcategory', 'qrlite'), 'dish_subcateg', true)); ?>
                                                                                                        <div class="qrlite-delimitator"></div>
                                                                                                        
                                                                                                        <div class="row group-toggles"> <?php
                                                                                                            $nutritional_status =       ((array_key_exists('nutritional_status', $nav_menu_inner))?$nav_menu_inner['nutritional_status']:'');
                                                                                                            $calories =       ((array_key_exists('calories', $nav_menu_inner))?$nav_menu_inner['calories']:'');
                                                                                                            $fat =       ((array_key_exists('fat', $nav_menu_inner))?$nav_menu_inner['fat']:'');
                                                                                                            $carbs =       ((array_key_exists('carbs', $nav_menu_inner))?$nav_menu_inner['carbs']:'');
                                                                                                            $proteins =       ((array_key_exists('proteins', $nav_menu_inner))?$nav_menu_inner['proteins']:''); ?>
                                                                                                        </div>
                                                                                                    </div>   
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }else{
                                                                            require_once('elements/menu-item.php');
                                                                        }
                                                                        ?> 
                                                                    </div>
                                                                    <div class="relative">
                                                                        <a class="btn btn-dark btn-sm qrlite-nav-menu-btn" data-element-type="menu-item" data-qrlite-nonce="<?php echo esc_attr($qrlite_nonce);?>"><i class="fa fa-solid fa-plus"></i> <?php esc_html_e('Add Item', 'qrlite'); ?></a>
                                                                        
                                                                    </div>
                                                                </div>
                                                               </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        }
                                                    }else{
                                                        require_once('elements/nav-menu.php');
                                                    }
                                                    ?> 
                                                </div>   
                                        </div>
                                        <div class="relative">
                                            <a class="btn btn-dark btn-sm qrlite-element-importer-btn" data-element-type="nav-menu"><i class="fa fa-solid fa-plus"></i> <?php esc_html_e('Add Category', 'qrlite'); ?></a>
                                        </div>
                                    </div>
                                </div>

                                <div id="advanced-settings" class="tab-pane fade show <?php if(qrlite_builder_active_tab() == 'profile'){echo esc_attr('active');} ?>" role="tabpanel" aria-labelledby="advanced-settings-tab">
                                    <h4><?php esc_html_e('Add details', 'qrlite'); ?></h4>
                                    <?php 
                                        echo esc_html(qrlite_input('text', 'user_name', $user_name, esc_html__('Name', 'qrlite'), 'user_name', true));
                                        echo esc_html(qrlite_textarea('user_bio', $user_bio, esc_html__('Description', 'qrlite'), 'user_bio', true));?>
                                </div>

                                <div id="general-settings" class="tab-pane show <?php if(qrlite_builder_active_tab() == 'settings'){echo esc_attr('active');} ?> " role="tabpanel" aria-labelledby="general-settings-tab">
                                    <h4><?php esc_html_e('Settings', 'qrlite'); ?></h4>
                                    <?php 
                                    echo esc_html(qrlite_input_number('container_width', esc_attr($container_width), esc_html__('Container Width', 'qrlite'), '600', 'container_width', true));
                                    echo esc_html(qrlite_input_number('container_tb_space', esc_attr($container_tb_space), esc_html__('Container Top/Bottom Space', 'qrlite'), '80', 'container_tb_space', true)); ?>
                                    <div class="qrlite-delimitator"></div>
                                    <h4><?php esc_html_e('Background & Colors', 'qrlite'); ?></h4>
                                    <div class="row"><?php
                                        echo esc_html(qrlite_colorpicker('body_text_color', esc_attr($body_text_color), esc_html__('Body Text Color', 'qrlite'), 'body_text_color','col-md-4'));
                                        echo esc_html(qrlite_colorpicker('body_bg_color', esc_attr($body_bg_color), esc_html__('Body Background Color', 'qrlite'), 'body_bg_color','col-md-4'));
                                        echo esc_html(qrlite_colorpicker('body_accent_color', esc_attr($body_accent_color), esc_html__('Body Accent Color', 'qrlite'), 'body_accent_color','col-md-4')); ?>
                                    </div>
                                </div>
                                
                                <button name="qrlite_form_configuration" type="submit" class="btn btn-primary btn-lg"><i class="far fa-save"></i> <?php esc_html_e('Save Changes', 'qrlite'); ?></button>
                            </div>
                            <?php require_once('parts/modal-button-styles.php'); ?>
                            <?php require_once('parts/modal-share.php'); ?>
                            <?php require_once('parts/modal-seo.php'); ?>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    <?php }else{ ?>
        <?php do_action('qrlite_no_active_plans_notice', 'builder'); ?>
    <?php } ?>

    <?php
}
