<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
* Parse About Me Block
* @param $post_id :     integer (*qrlite Post ID)
*
*/
add_action('qrlite_page_content', 'qrlite_frontend_about_me_block', 10, 2);
function qrlite_frontend_about_me_block($post_id) {
    
    if (is_singular('qrlite-link')) {
        $configuration = get_post_meta( $post_id, 'qrlite_configuration', true );
        $about_us_title = ((array_key_exists('user_name', $configuration))?$configuration['user_name']:"");
        $about_us_description = ((array_key_exists('user_bio', $configuration))?$configuration['user_bio']:"");
        if(!empty($about_us_title)){ ?>
            <h2 class="qrmenu-about-me-title"><?php echo esc_html($about_us_title); ?></h2> <?php
        }
        if(!empty($about_us_description)){ ?>
            <p class="qrmenu-about-me-description"><?php echo esc_html($about_us_description); ?></p> <?php
        }
    } 
    ?>

    <!-- Modal -->
    <div id="qrlite-item-img-modal">
        <div id="qrlite-item-img-content">
            <img src="" alt="<?php echo esc_html__('Menu Item', 'qrlite');?>" id="qrlite-modal-image">
        </div>
    </div>

<?php
}

/**
* Parse Botton Links Block
* @param $post_id :     integer (*QRLITE Post ID)
*
*/
add_action('qrlite_page_content', 'qrlite_frontend_buttons_block', 30, 2);
function qrlite_frontend_buttons_block($post_id) {
    
    if (is_singular('qrlite-link')) {
        $configuration      = get_post_meta( $post_id, 'qrlite_configuration', true );
        $template_version   = $configuration['template_version'];
        $template_column    = $configuration['template_column'];
        $template_layout    = $configuration['template_layout'];
        $nav_menu_groups    = $configuration['qrlite-nav-menu-group'];
        $alignment          = $configuration['alignment'];
        $about_us_title     = ((array_key_exists('user_name', $configuration))?$configuration['user_name']:"");
        $count = 0; ?>
        <nav class="qrlite-tabs">
            <div class="d-flex">
                <p class="restaurant-title"><?php echo esc_html($about_us_title); ?></p>
                <ul id="qrlite-scroll">
                    <?php
                    foreach ($nav_menu_groups as $key => $nav_menu) { 
                        if(!empty($nav_menu['category'])) { ?>
                            <li><a href="#<?php echo esc_html(strtolower($nav_menu['category']));?>" class="list-icon-title">
                                <p class="tab-title"><?php echo esc_html($nav_menu['category']);?></p>
                            </a></li> <?php
                        } 
                    }  ?> 
                    
                </ul>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cart"></button>
            </div>
        </nav>
        <?php
        foreach ($nav_menu_groups as $key => $nav_menu) { 
            $nav_menu_inner_groups = $nav_menu['qrlite-nav-menu-inner-group'];

            $nav_menus = 'nav_menus' . $count;

            if(!empty($nav_menu['category'])){ ?>
                <div id="<?php echo esc_html(strtolower($nav_menu['category']));?>" class="qrlite-category-header"><h4><?php echo esc_html($nav_menu['category']);?></h4></div><?php
            }

            if ($nav_menu_inner_groups) {
                ${$nav_menus} = array();
                foreach ($nav_menu_inner_groups as $nav_menu) {

                    $btn_img = ((array_key_exists('dish_image', $nav_menu))?wp_get_attachment_url($nav_menu['dish_image']):"");
                    $btn_img_url = ((array_key_exists('dish_image_url', $nav_menu))?$nav_menu['dish_image_url']:"");
                    if (!$btn_img) {
                        $btn_img = $btn_img_url;
                    }

                    ${$nav_menus}[] = array(
                        'dish_heading' => ((array_key_exists('dish_heading', $nav_menu))?$nav_menu['dish_heading']:""),
                        'item_type' => ((array_key_exists('item_type', $nav_menu))?$nav_menu['item_type']:"product"),
                        'dish_image' => array(
                             'url' => $btn_img
                        ),
                        //
                        'out_of_stock' => ((array_key_exists('out_of_stock', $nav_menu))?$nav_menu['out_of_stock']:""),
                        'hide_menu' => ((array_key_exists('hide_menu', $nav_menu))?$nav_menu['hide_menu']:""),
                        'preparation_time' => ((array_key_exists('preparation_time', $nav_menu))?$nav_menu['preparation_time']:""), 
                        'dish_title' => ((array_key_exists('dish_title', $nav_menu))?$nav_menu['dish_title']:"Menu Item"),
                        'dish_price' => ((array_key_exists('dish_price', $nav_menu))?$nav_menu['dish_price']:""),
                        'dish_sale_price' => ((array_key_exists('dish_sale_price', $nav_menu))?$nav_menu['dish_sale_price']:""),
                        'dish_description' => ((array_key_exists('dish_description', $nav_menu))?$nav_menu['dish_description']:""),
                        'grams' => ((array_key_exists('grams', $nav_menu))?$nav_menu['grams']:""),
                        'dish_promotion' => ((array_key_exists('dish_promotion', $nav_menu))?$nav_menu['dish_promotion']:""),
                        'calories' => ((array_key_exists('calories', $nav_menu))?$nav_menu['calories']:""),
                        'fat' => ((array_key_exists('fat', $nav_menu))?$nav_menu['fat']:""),
                        'carbs' => ((array_key_exists('carbs', $nav_menu))?$nav_menu['carbs']:""),
                        'proteins' => ((array_key_exists('proteins', $nav_menu))?$nav_menu['proteins']:""),
                    );
                }
                echo do_shortcode('[qrlite-menu-items tab1="'.base64_encode(serialize(${$nav_menus})).'"  version="'.esc_attr($template_version).'" columns="'.esc_attr($template_column).'" layout_display="'.esc_attr($template_layout).'" alignment="'.esc_attr($alignment).'"]'); 
            } 
        $count++;
        } ?>
          
   <?php }
}


/**
* Minifying the CSS
* @param $css :     string (CSS rules)
*
*/
function qrlite_minify_css($css){
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
    return $css;
}


/**
* Function to generate custom dynamic CSS on the frontend template
*
*/
function qrlite_dynamic_css(){

    $css = '';
    if (is_singular('qrlite-link')) {
        
        wp_enqueue_style('qrlite-custom', QRLITE_PLUGIN_URL . 'assets/custom-style.css');

        $configuration = get_post_meta( get_the_ID(), 'qrlite_configuration', true );

        //Body Image 
        $body_bg_color = ((array_key_exists('body_bg_color', $configuration))?$configuration['body_bg_color']:"");
        $body_text_color = ((array_key_exists('body_text_color', $configuration))?$configuration['body_text_color']:"");

        $attachment_url = '';
        if ($attachment_url || $body_bg_color) {
            $css .= 'body{
                        background-color: '.$body_bg_color.'!important;
                        background-size: 100% 100%;
                        background-position: center;
                        background-repeat: no-repeat;
                        background-attachment: fixed;
                    }';
        }

        if (!empty($configuration['container_width'])) {
            $css .= '
                .qrlite-bio-links-page-inner,
                .qrlite-media-container,
                .qrlite-inner-timeline{
                    width: '.esc_attr($configuration['container_width']).'px;
                    margin: 0 auto;
                    position: relative;
                }
            ';
        }
        $css .= '.qrlite-bio-links-page-inner  {
                    padding: '.esc_attr($configuration['container_tb_space']).'px 0;
                    margin-bottom: 60px;
                }
                ';
        if(!empty($configuration['body_text_color'])) {
            $css .= '.qrlite-about-me-title, .qrlite-about-me-description, .button.header-info, .qrlite-category-header  {
                        color: '.esc_attr($configuration['body_text_color']).';
                    }';
        } else {
            $css .= '.qrlite-about-me-title, .qrlite-about-me-description  {
                        color: #222;
                    }';
        }

        if(!empty($configuration['body_accent_color'])) {
            $css .= '.qrlite-header-restaurant button,
                    .qrlite-header-restaurant button.btn:hover,
                    body .qrlite-bio-links-page .qrlite-back-to-top:hover,
                    body .qrlite-menu-items-bottom-content .add-to-cart:hover, 
                    body .qrlite-menu-items-bottom-content .add-to-cart:active,
                    body .qrlite-tabs.sticky .btn-primary i,
                    body .qrlite-cart-footer button,
                    .qrlite-cart-info .input-group .minus-item, .qrlite-cart-info .input-group .plus-item  {
                        background: '.esc_attr($configuration['body_accent_color']).';
                    }
                    .qrlite-bio-links-page .qrlite-share-panel .qrlite-panel_button i,
                    body .qrlite-bio-links-page .qrlite-back-to-top,
                    body .qrlite-menu-items-bottom-content .add-to-cart .dashicons  {
                        color: '.esc_attr($configuration['body_accent_color']). ';
                    }
                    body .qrlite-menu-items-bottom-content .add-to-cart,
                    body .qrlite-menu-items-bottom-content .add-to-cart:hover, 
                    body .qrlite-menu-items-bottom-content .add-to-cart:active,
                    .qrlite-cart-info .input-group .minus-item, .qrlite-cart-info .input-group .plus-item{
                        border-color: '.esc_attr($configuration['body_accent_color']). ';
                    }';
        }

        wp_add_inline_style( 'qrlite-custom', qrlite_minify_css($css) );
    }
}
add_action('wp_enqueue_scripts', 'qrlite_dynamic_css' );


/**
* Page link generate unique ID
* 
*/
function qrlite_generate_link_id(){
    $link_id = uniqid('-', true);
    $link_slug = substr($link_id, strlen($link_id) - 5, strlen($link_id));

    return '-'.$link_slug;
}


function qrlite_qr_code_generator($post_id = '', $width_x_height = ''){
    $size = '500x500';
    if (!empty($width_x_height)) {
        $size = $width_x_height;
    }
    $qr_img = 'https://chart.googleapis.com/chart?chs='.esc_attr($size).'&cht=qr&chl='.get_permalink($post_id).'&choe=UTF-8';
    $qr_link = 'https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl='.get_permalink($post_id).'&choe=UTF-8';
    ?>
        <a href="<?php echo esc_url($qr_link); ?>" target="_blank"><img class="qrlite-qr" src="<?php echo esc_url($qr_img); ?>" alt="qr" /></a>
    <?php
}
add_action('qrlite_builder_qr', 'qrlite_qr_code_generator', 10, 2);
add_action('qrlite_sharing_panel_qr', 'qrlite_qr_code_generator', 10, 2);


//Check last tab seen
function qrlite_builder_active_tab(){
    if (isset($_GET['tab']) && !empty($_GET['tab'])) {
        return sanitize_title($_GET['tab']);
    }else{
        return 'links';
    }
}

//Check nr. of products per category
add_action('qrlite_builder_after_title','qrlite_get_nr_products_per_category');
function qrlite_get_nr_products_per_category($post_id = ''){
    if ($post_id) {
        $current_post_id = $post_id;
    }else{
        if (isset($_GET['links_page'])) {
            $current_post_id = absint(sanitize_text_field($_GET['links_page']));
        }else{
            if (isset($_POST['post_id']) && isset($_POST['qrlite_nonce']) ) {
                $nonce = sanitize_text_field($_POST['qrlite_nonce']);
                $current_post_id = absint(sanitize_text_field($_POST['post_id']));

                if (wp_verify_nonce($nonce, 'qrlite_nonce_action')) {
                    $current_post_id = absint($_POST['post_id']);
                } else {
                    die('Security check failed!');
                }
            }else{
                $current_post_id = '';
                $current_post_link = '';
            }
        }
    }
    $configuration = get_post_meta( $current_post_id, 'qrlite_configuration', true );
    if(!empty($configuration['qrlite-nav-menu-group'])) {
        $nav_menu_groups    = $configuration['qrlite-nav-menu-group'];
        $counter = 0;
        foreach ($nav_menu_groups as $key => $nav_menu) { 
            $counter = 0;
            foreach ($nav_menu['qrlite-nav-menu-inner-group'] as $key => $nav_menu_inner) { 
                $counter ++;
            }
        } ?>
        <span class="qrlite-cat-count">(<?php echo esc_html($counter);?>)</span> <?php
    }
}


/**
 * Get Base Currency Code.
 *
 * @return string
 */
function qrlite_get_currency() {
    $settings = get_option('qrlite-main-settings');
    if ($settings) {
        $user_currency = ((array_key_exists('qrlite_currency', $settings))?$settings['qrlite_currency']:array());
        if(!empty($user_currency)) {
            return $user_currency;
        } else {
            return 'USD';
        }
    }
}


/**
 * Get the price format depending on the currency position.
 *
 */
function qrlite_get_currency_pos() {
    $settings = get_option('qrlite-main-settings');
    if ($settings) {
        $user_currency_pos = ((array_key_exists('qrlite_currency_pos', $settings))?$settings['qrlite_currency_pos']:array());
        if(!empty($user_currency)) {
            return $user_currency_pos;
        } else {
            return 'left';
        }
        
    }

}


/**
 * Get the price formatted.
 *
 */
function qrlite_get_currency_formatted($dish_price) {
    $currency_pos = qrlite_get_currency_pos(); 
    switch ( $currency_pos ) {
        case 'left':
            echo esc_html(qrlite_get_currency()).' '.esc_html($dish_price);
            break;
        case 'right':
            echo esc_html($dish_price).' '.esc_html(qrlite_get_currency());
            break;
    }
}

/**
 * Get the price formatted.
 *
 */
function qrlite_get_currency_sale_formatted($dish_sale_price) {
    $currency_pos = qrlite_get_currency_pos(); 
    switch ( $currency_pos ) {
        case 'left':
            echo esc_html(qrlite_get_currency()).' '.esc_html($dish_sale_price);
            break;
        case 'right':
            echo esc_html($dish_sale_price).' '.esc_html(qrlite_get_currency());
            break;
    }
}
/**
 * Get full list of currency codes.
 *
 *
 * @return array
 */
function qrlite_get_currencies() {
    static $currencies;

    if ( ! isset( $currencies ) ) {
        $currencies = array_unique(
            apply_filters(
                'qrlite_currencies',
                array(
                    'AED' => esc_html__( 'United Arab Emirates dirham', 'qrlite' ),
                    'AFN' => esc_html__( 'Afghan afghani', 'qrlite' ),
                    'ALL' => esc_html__( 'Albanian lek', 'qrlite' ),
                    'AMD' => esc_html__( 'Armenian dram', 'qrlite' ),
                    'ANG' => esc_html__( 'Netherlands Antillean guilder', 'qrlite' ),
                    'AOA' => esc_html__( 'Angolan kwanza', 'qrlite' ),
                    'ARS' => esc_html__( 'Argentine peso', 'qrlite' ),
                    'AUD' => esc_html__( 'Australian dollar', 'qrlite' ),
                    'AWG' => esc_html__( 'Aruban florin', 'qrlite' ),
                    'AZN' => esc_html__( 'Azerbaijani manat', 'qrlite' ),
                    'BAM' => esc_html__( 'Bosnia and Herzegovina convertible mark', 'qrlite' ),
                    'BBD' => esc_html__( 'Barbadian dollar', 'qrlite' ),
                    'BDT' => esc_html__( 'Bangladeshi taka', 'qrlite' ),
                    'BGN' => esc_html__( 'Bulgarian lev', 'qrlite' ),
                    'BHD' => esc_html__( 'Bahraini dinar', 'qrlite' ),
                    'BIF' => esc_html__( 'Burundian franc', 'qrlite' ),
                    'BMD' => esc_html__( 'Bermudian dollar', 'qrlite' ),
                    'BND' => esc_html__( 'Brunei dollar', 'qrlite' ),
                    'BOB' => esc_html__( 'Bolivian boliviano', 'qrlite' ),
                    'BRL' => esc_html__( 'Brazilian real', 'qrlite' ),
                    'BSD' => esc_html__( 'Bahamian dollar', 'qrlite' ),
                    'BTC' => esc_html__( 'Bitcoin', 'qrlite' ),
                    'BTN' => esc_html__( 'Bhutanese ngultrum', 'qrlite' ),
                    'BWP' => esc_html__( 'Botswana pula', 'qrlite' ),
                    'BYR' => esc_html__( 'Belarusian ruble (old)', 'qrlite' ),
                    'BYN' => esc_html__( 'Belarusian ruble', 'qrlite' ),
                    'BZD' => esc_html__( 'Belize dollar', 'qrlite' ),
                    'CAD' => esc_html__( 'Canadian dollar', 'qrlite' ),
                    'CDF' => esc_html__( 'Congolese franc', 'qrlite' ),
                    'CHF' => esc_html__( 'Swiss franc', 'qrlite' ),
                    'CLP' => esc_html__( 'Chilean peso', 'qrlite' ),
                    'CNY' => esc_html__( 'Chinese yuan', 'qrlite' ),
                    'COP' => esc_html__( 'Colombian peso', 'qrlite' ),
                    'CRC' => esc_html__( 'Costa Rican col&oacute;n', 'qrlite' ),
                    'CUC' => esc_html__( 'Cuban convertible peso', 'qrlite' ),
                    'CUP' => esc_html__( 'Cuban peso', 'qrlite' ),
                    'CVE' => esc_html__( 'Cape Verdean escudo', 'qrlite' ),
                    'CZK' => esc_html__( 'Czech koruna', 'qrlite' ),
                    'DJF' => esc_html__( 'Djiboutian franc', 'qrlite' ),
                    'DKK' => esc_html__( 'Danish krone', 'qrlite' ),
                    'DOP' => esc_html__( 'Dominican peso', 'qrlite' ),
                    'DZD' => esc_html__( 'Algerian dinar', 'qrlite' ),
                    'EGP' => esc_html__( 'Egyptian pound', 'qrlite' ),
                    'ERN' => esc_html__( 'Eritrean nakfa', 'qrlite' ),
                    'ETB' => esc_html__( 'Ethiopian birr', 'qrlite' ),
                    'EUR' => esc_html__( 'Euro', 'qrlite' ),
                    'FJD' => esc_html__( 'Fijian dollar', 'qrlite' ),
                    'FKP' => esc_html__( 'Falkland Islands pound', 'qrlite' ),
                    'GBP' => esc_html__( 'Pound sterling', 'qrlite' ),
                    'GEL' => esc_html__( 'Georgian lari', 'qrlite' ),
                    'GGP' => esc_html__( 'Guernsey pound', 'qrlite' ),
                    'GHS' => esc_html__( 'Ghana cedi', 'qrlite' ),
                    'GIP' => esc_html__( 'Gibraltar pound', 'qrlite' ),
                    'GMD' => esc_html__( 'Gambian dalasi', 'qrlite' ),
                    'GNF' => esc_html__( 'Guinean franc', 'qrlite' ),
                    'GTQ' => esc_html__( 'Guatemalan quetzal', 'qrlite' ),
                    'GYD' => esc_html__( 'Guyanese dollar', 'qrlite' ),
                    'HKD' => esc_html__( 'Hong Kong dollar', 'qrlite' ),
                    'HNL' => esc_html__( 'Honduran lempira', 'qrlite' ),
                    'HRK' => esc_html__( 'Croatian kuna', 'qrlite' ),
                    'HTG' => esc_html__( 'Haitian gourde', 'qrlite' ),
                    'HUF' => esc_html__( 'Hungarian forint', 'qrlite' ),
                    'IDR' => esc_html__( 'Indonesian rupiah', 'qrlite' ),
                    'ILS' => esc_html__( 'Israeli new shekel', 'qrlite' ),
                    'IMP' => esc_html__( 'Manx pound', 'qrlite' ),
                    'INR' => esc_html__( 'Indian rupee', 'qrlite' ),
                    'IQD' => esc_html__( 'Iraqi dinar', 'qrlite' ),
                    'IRR' => esc_html__( 'Iranian rial', 'qrlite' ),
                    'IRT' => esc_html__( 'Iranian toman', 'qrlite' ),
                    'ISK' => esc_html__( 'Icelandic kr&oacute;na', 'qrlite' ),
                    'JEP' => esc_html__( 'Jersey pound', 'qrlite' ),
                    'JMD' => esc_html__( 'Jamaican dollar', 'qrlite' ),
                    'JOD' => esc_html__( 'Jordanian dinar', 'qrlite' ),
                    'JPY' => esc_html__( 'Japanese yen', 'qrlite' ),
                    'KES' => esc_html__( 'Kenyan shilling', 'qrlite' ),
                    'KGS' => esc_html__( 'Kyrgyzstani som', 'qrlite' ),
                    'KHR' => esc_html__( 'Cambodian riel', 'qrlite' ),
                    'KMF' => esc_html__( 'Comorian franc', 'qrlite' ),
                    'KPW' => esc_html__( 'North Korean won', 'qrlite' ),
                    'KRW' => esc_html__( 'South Korean won', 'qrlite' ),
                    'KWD' => esc_html__( 'Kuwaiti dinar', 'qrlite' ),
                    'KYD' => esc_html__( 'Cayman Islands dollar', 'qrlite' ),
                    'KZT' => esc_html__( 'Kazakhstani tenge', 'qrlite' ),
                    'LAK' => esc_html__( 'Lao kip', 'qrlite' ),
                    'LBP' => esc_html__( 'Lebanese pound', 'qrlite' ),
                    'LKR' => esc_html__( 'Sri Lankan rupee', 'qrlite' ),
                    'LRD' => esc_html__( 'Liberian dollar', 'qrlite' ),
                    'LSL' => esc_html__( 'Lesotho loti', 'qrlite' ),
                    'LYD' => esc_html__( 'Libyan dinar', 'qrlite' ),
                    'MAD' => esc_html__( 'Moroccan dirham', 'qrlite' ),
                    'MDL' => esc_html__( 'Moldovan leu', 'qrlite' ),
                    'MGA' => esc_html__( 'Malagasy ariary', 'qrlite' ),
                    'MKD' => esc_html__( 'Macedonian denar', 'qrlite' ),
                    'MMK' => esc_html__( 'Burmese kyat', 'qrlite' ),
                    'MNT' => esc_html__( 'Mongolian t&ouml;gr&ouml;g', 'qrlite' ),
                    'MOP' => esc_html__( 'Macanese pataca', 'qrlite' ),
                    'MRU' => esc_html__( 'Mauritanian ouguiya', 'qrlite' ),
                    'MUR' => esc_html__( 'Mauritian rupee', 'qrlite' ),
                    'MVR' => esc_html__( 'Maldivian rufiyaa', 'qrlite' ),
                    'MWK' => esc_html__( 'Malawian kwacha', 'qrlite' ),
                    'MXN' => esc_html__( 'Mexican peso', 'qrlite' ),
                    'MYR' => esc_html__( 'Malaysian ringgit', 'qrlite' ),
                    'MZN' => esc_html__( 'Mozambican metical', 'qrlite' ),
                    'NAD' => esc_html__( 'Namibian dollar', 'qrlite' ),
                    'NGN' => esc_html__( 'Nigerian naira', 'qrlite' ),
                    'NIO' => esc_html__( 'Nicaraguan c&oacute;rdoba', 'qrlite' ),
                    'NOK' => esc_html__( 'Norwegian krone', 'qrlite' ),
                    'NPR' => esc_html__( 'Nepalese rupee', 'qrlite' ),
                    'NZD' => esc_html__( 'New Zealand dollar', 'qrlite' ),
                    'OMR' => esc_html__( 'Omani rial', 'qrlite' ),
                    'PAB' => esc_html__( 'Panamanian balboa', 'qrlite' ),
                    'PEN' => esc_html__( 'Sol', 'qrlite' ),
                    'PGK' => esc_html__( 'Papua New Guinean kina', 'qrlite' ),
                    'PHP' => esc_html__( 'Philippine peso', 'qrlite' ),
                    'PKR' => esc_html__( 'Pakistani rupee', 'qrlite' ),
                    'PLN' => esc_html__( 'Polish z&#x142;oty', 'qrlite' ),
                    'PRB' => esc_html__( 'Transnistrian ruble', 'qrlite' ),
                    'PYG' => esc_html__( 'Paraguayan guaran&iacute;', 'qrlite' ),
                    'QAR' => esc_html__( 'Qatari riyal', 'qrlite' ),
                    'RON' => esc_html__( 'Romanian leu', 'qrlite' ),
                    'RSD' => esc_html__( 'Serbian dinar', 'qrlite' ),
                    'RUB' => esc_html__( 'Russian ruble', 'qrlite' ),
                    'RWF' => esc_html__( 'Rwandan franc', 'qrlite' ),
                    'SAR' => esc_html__( 'Saudi riyal', 'qrlite' ),
                    'SBD' => esc_html__( 'Solomon Islands dollar', 'qrlite' ),
                    'SCR' => esc_html__( 'Seychellois rupee', 'qrlite' ),
                    'SDG' => esc_html__( 'Sudanese pound', 'qrlite' ),
                    'SEK' => esc_html__( 'Swedish krona', 'qrlite' ),
                    'SGD' => esc_html__( 'Singapore dollar', 'qrlite' ),
                    'SHP' => esc_html__( 'Saint Helena pound', 'qrlite' ),
                    'SLL' => esc_html__( 'Sierra Leonean leone', 'qrlite' ),
                    'SOS' => esc_html__( 'Somali shilling', 'qrlite' ),
                    'SRD' => esc_html__( 'Surinamese dollar', 'qrlite' ),
                    'SSP' => esc_html__( 'South Sudanese pound', 'qrlite' ),
                    'STN' => esc_html__( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra', 'qrlite' ),
                    'SYP' => esc_html__( 'Syrian pound', 'qrlite' ),
                    'SZL' => esc_html__( 'Swazi lilangeni', 'qrlite' ),
                    'THB' => esc_html__( 'Thai baht', 'qrlite' ),
                    'TJS' => esc_html__( 'Tajikistani somoni', 'qrlite' ),
                    'TMT' => esc_html__( 'Turkmenistan manat', 'qrlite' ),
                    'TND' => esc_html__( 'Tunisian dinar', 'qrlite' ),
                    'TOP' => esc_html__( 'Tongan pa&#x2bb;anga', 'qrlite' ),
                    'TRY' => esc_html__( 'Turkish lira', 'qrlite' ),
                    'TTD' => esc_html__( 'Trinidad and Tobago dollar', 'qrlite' ),
                    'TWD' => esc_html__( 'New Taiwan dollar', 'qrlite' ),
                    'TZS' => esc_html__( 'Tanzanian shilling', 'qrlite' ),
                    'UAH' => esc_html__( 'Ukrainian hryvnia', 'qrlite' ),
                    'UGX' => esc_html__( 'Ugandan shilling', 'qrlite' ),
                    'USD' => esc_html__( 'United States (US) dollar', 'qrlite' ),
                    'UYU' => esc_html__( 'Uruguayan peso', 'qrlite' ),
                    'UZS' => esc_html__( 'Uzbekistani som', 'qrlite' ),
                    'VEF' => esc_html__( 'Venezuelan bol&iacute;var', 'qrlite' ),
                    'VES' => esc_html__( 'Bol&iacute;var soberano', 'qrlite' ),
                    'VND' => esc_html__( 'Vietnamese &#x111;&#x1ed3;ng', 'qrlite' ),
                    'VUV' => esc_html__( 'Vanuatu vatu', 'qrlite' ),
                    'WST' => esc_html__( 'Samoan t&#x101;l&#x101;', 'qrlite' ),
                    'XAF' => esc_html__( 'Central African CFA franc', 'qrlite' ),
                    'XCD' => esc_html__( 'East Caribbean dollar', 'qrlite' ),
                    'XOF' => esc_html__( 'West African CFA franc', 'qrlite' ),
                    'XPF' => esc_html__( 'CFP franc', 'qrlite' ),
                    'YER' => esc_html__( 'Yemeni rial', 'qrlite' ),
                    'ZAR' => esc_html__( 'South African rand', 'qrlite' ),
                    'ZMW' => esc_html__( 'Zambian kwacha', 'qrlite' ),
                )
            )
        );
    }

    return $currencies;
}

/**
 * Get all available Currency symbols.
 *
 */
function qrlite_get_currency_symbols() {

    $symbols = apply_filters(
        'qrlite_currency_symbols',
        array(
            'AED' => '&#x62f;.&#x625;',
            'AFN' => '&#x60b;',
            'ALL' => 'L',
            'AMD' => 'AMD',
            'ANG' => '&fnof;',
            'AOA' => 'Kz',
            'ARS' => '&#36;',
            'AUD' => '&#36;',
            'AWG' => 'Afl.',
            'AZN' => '&#8380;',
            'BAM' => 'KM',
            'BBD' => '&#36;',
            'BDT' => '&#2547;&nbsp;',
            'BGN' => '&#1083;&#1074;.',
            'BHD' => '.&#x62f;.&#x628;',
            'BIF' => 'Fr',
            'BMD' => '&#36;',
            'BND' => '&#36;',
            'BOB' => 'Bs.',
            'BRL' => '&#82;&#36;',
            'BSD' => '&#36;',
            'BTC' => '&#3647;',
            'BTN' => 'Nu.',
            'BWP' => 'P',
            'BYR' => 'Br',
            'BYN' => 'Br',
            'BZD' => '&#36;',
            'CAD' => '&#36;',
            'CDF' => 'Fr',
            'CHF' => '&#67;&#72;&#70;',
            'CLP' => '&#36;',
            'CNY' => '&yen;',
            'COP' => '&#36;',
            'CRC' => '&#x20a1;',
            'CUC' => '&#36;',
            'CUP' => '&#36;',
            'CVE' => '&#36;',
            'CZK' => '&#75;&#269;',
            'DJF' => 'Fr',
            'DKK' => 'kr.',
            'DOP' => 'RD&#36;',
            'DZD' => '&#x62f;.&#x62c;',
            'EGP' => 'EGP',
            'ERN' => 'Nfk',
            'ETB' => 'Br',
            'EUR' => '&euro;',
            'FJD' => '&#36;',
            'FKP' => '&pound;',
            'GBP' => '&pound;',
            'GEL' => '&#x20be;',
            'GGP' => '&pound;',
            'GHS' => '&#x20b5;',
            'GIP' => '&pound;',
            'GMD' => 'D',
            'GNF' => 'Fr',
            'GTQ' => 'Q',
            'GYD' => '&#36;',
            'HKD' => '&#36;',
            'HNL' => 'L',
            'HRK' => 'kn',
            'HTG' => 'G',
            'HUF' => '&#70;&#116;',
            'IDR' => 'Rp',
            'ILS' => '&#8362;',
            'IMP' => '&pound;',
            'INR' => '&#8377;',
            'IQD' => '&#x62f;.&#x639;',
            'IRR' => '&#xfdfc;',
            'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
            'ISK' => 'kr.',
            'JEP' => '&pound;',
            'JMD' => '&#36;',
            'JOD' => '&#x62f;.&#x627;',
            'JPY' => '&yen;',
            'KES' => 'KSh',
            'KGS' => '&#x441;&#x43e;&#x43c;',
            'KHR' => '&#x17db;',
            'KMF' => 'Fr',
            'KPW' => '&#x20a9;',
            'KRW' => '&#8361;',
            'KWD' => '&#x62f;.&#x643;',
            'KYD' => '&#36;',
            'KZT' => '&#8376;',
            'LAK' => '&#8365;',
            'LBP' => '&#x644;.&#x644;',
            'LKR' => '&#xdbb;&#xdd4;',
            'LRD' => '&#36;',
            'LSL' => 'L',
            'LYD' => '&#x62f;.&#x644;',
            'MAD' => '&#x62f;.&#x645;.',
            'MDL' => 'MDL',
            'MGA' => 'Ar',
            'MKD' => '&#x434;&#x435;&#x43d;',
            'MMK' => 'Ks',
            'MNT' => '&#x20ae;',
            'MOP' => 'P',
            'MRU' => 'UM',
            'MUR' => '&#x20a8;',
            'MVR' => '.&#x783;',
            'MWK' => 'MK',
            'MXN' => '&#36;',
            'MYR' => '&#82;&#77;',
            'MZN' => 'MT',
            'NAD' => 'N&#36;',
            'NGN' => '&#8358;',
            'NIO' => 'C&#36;',
            'NOK' => '&#107;&#114;',
            'NPR' => '&#8360;',
            'NZD' => '&#36;',
            'OMR' => '&#x631;.&#x639;.',
            'PAB' => 'B/.',
            'PEN' => 'S/',
            'PGK' => 'K',
            'PHP' => '&#8369;',
            'PKR' => '&#8360;',
            'PLN' => '&#122;&#322;',
            'PRB' => '&#x440;.',
            'PYG' => '&#8370;',
            'QAR' => '&#x631;.&#x642;',
            'RMB' => '&yen;',
            'RON' => 'lei',
            'RSD' => '&#1088;&#1089;&#1076;',
            'RUB' => '&#8381;',
            'RWF' => 'Fr',
            'SAR' => '&#x631;.&#x633;',
            'SBD' => '&#36;',
            'SCR' => '&#x20a8;',
            'SDG' => '&#x62c;.&#x633;.',
            'SEK' => '&#107;&#114;',
            'SGD' => '&#36;',
            'SHP' => '&pound;',
            'SLL' => 'Le',
            'SOS' => 'Sh',
            'SRD' => '&#36;',
            'SSP' => '&pound;',
            'STN' => 'Db',
            'SYP' => '&#x644;.&#x633;',
            'SZL' => 'E',
            'THB' => '&#3647;',
            'TJS' => '&#x405;&#x41c;',
            'TMT' => 'm',
            'TND' => '&#x62f;.&#x62a;',
            'TOP' => 'T&#36;',
            'TRY' => '&#8378;',
            'TTD' => '&#36;',
            'TWD' => '&#78;&#84;&#36;',
            'TZS' => 'Sh',
            'UAH' => '&#8372;',
            'UGX' => 'UGX',
            'USD' => '&#36;',
            'UYU' => '&#36;',
            'UZS' => 'UZS',
            'VEF' => 'Bs F',
            'VES' => 'Bs.S',
            'VND' => '&#8363;',
            'VUV' => 'Vt',
            'WST' => 'T',
            'XAF' => 'CFA',
            'XCD' => '&#36;',
            'XOF' => 'CFA',
            'XPF' => 'Fr',
            'YER' => '&#xfdfc;',
            'ZAR' => '&#82;',
            'ZMW' => 'ZK',
        )
    );

    return $symbols;
}

/**
 * Get Currency symbol.
 *
 */
function qrlite_get_currency_symbol( $currency = '' ) {
    if ( ! $currency ) {
        $currency = qrlite_get_currencies();
    }

    $symbols = qrlite_get_currency_symbols();

    $currency_symbol = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : '';

    return apply_filters( 'qrlite_currency_symbol', $currency_symbol, $currency );
}

