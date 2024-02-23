<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<div data-repeater-item class="qrlite-bio-links-inner-dropdown qrlite-accordion-card" data-element-type="menu-item">
    <div class="qrlite-accordion-card-inner">
        <div class="qrlite-accordion-title relative" data-accordion-element-trigger>
            <div class="menu-description">
                <div class="title-sub"> 
                    <?php esc_html_e('Menu Item', 'qrlite'); ?>
                </div>
            </div>
            <div class="part-delete-hide">
                <div class="hide-menu-tooltip"><?php
                    echo esc_html(qrlite_checkbox('', '', 'hide_menu', ''));?>
                    <span class="tooltiptext"><?php echo esc_html__('Hide Menu','qrlite'); ?></span>
                </div>
                <i data-repeater-delete class="fa fa-solid fa-trash"></i>
            </div>
        </div>

        <div data-accordion-element-content class="qrlite-accordion-content">
            <div class="accordion-body">
                <div class="card-body d-flex">
                    <div class="col-md-8">
                        <input type="hidden" name="btn_type" value="menu_item" />
                        <?php
                        echo esc_html(qrlite_input('text', 'dish_title', '', esc_html__('Dish Title', 'qrlite'), 'dish_title', true)); ?>
                        <div class="row group-toggles">
                            <?php
                            echo esc_html(qrlite_input('text', 'dish_price', '', esc_html__('Price', 'qrlite'), 'dish_price', true, 'col-md-6'));
                            echo esc_html(qrlite_input('text', 'dish_sale_price', '', esc_html__('Discounted Price', 'qrlite'), 'dish_sale_price', true, 'col-md-6')); ?>
                        </div>
                        <?php
                        echo esc_html(qrlite_textarea('dish_description', '', esc_html__('Dish Description', 'qrlite'), 'dish_description', true)); ?>
                        <div class="row group-toggles">
                            <?php
                            echo esc_html(qrlite_input('text', 'grams', '', esc_html__('Portion size', 'qrlite'), 'grams', true, 'col-md-6'));
                            echo esc_html(qrlite_input('text', 'preparation_time', '', esc_html__('Preparation Time', 'qrlite'), 'preparation_time', true, 'col-md-6')); ?>
                        </div>
                        <?php
                        echo esc_html(qrlite_input('text', 'dish_promotion', '', esc_html__('Dish Promotion', 'qrlite'), 'dish_promotion', true, ''));
                        echo esc_html(qrlite_media_uploader('dish_image', '', '', esc_html__('Image', 'qrlite'), '')); ?>
                    </div>
                    <div class="col-md-4"><?php
                        echo esc_html(qrlite_checkbox('col-md-12',  '', 'out_of_stock', esc_html__('Out of Stock', 'qrlite')));
                        echo esc_html(qrlite_input('text', 'dish_subcateg', '', esc_html__('Subcategory', 'qrlite'), 'dish_subcateg', true)); ?>
                        <div class="qrlite-delimitator"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>