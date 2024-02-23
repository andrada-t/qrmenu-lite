<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function qrlite_frontend_sharing_panel(){

    $settings = get_option('qrlite-main-settings');
    if ($settings) {
        $qrlite_sharing = ((array_key_exists('qrlite_sharing', $settings))?$settings['qrlite_sharing']:"off");
        if ($qrlite_sharing != 'on') {
            return;
        }
    }
    ?>
        <div class="qrlite-share-panel">
            <div id="qrlite-links-panel">
                <div id="qrlite-panel">
                    <?php
                    // Get current page URL
                    $url = esc_url(get_permalink());
                    // Get current page title
                    $title = str_replace( ' ', '%20', get_the_title());

                    // Construct sharing URLs
                    $email_url = 'mailto:?subject='.esc_html($title).'&amp;body='.esc_url($url);
                    ?>
                    <h3><?php esc_html_e('Share this link', 'qrlite'); ?></h3>
                    <div class="qrlite-social-box">
                        <a class="qrlite-social-btn qrlite-social-email" href="<?php echo esc_url($email_url); ?>" target="_blank" rel="nofollow">
                            <span><i class="fas fa-envelope"></i><?php esc_html_e('Share on Email', 'qrlite'); ?></span>
                            <i class="fas fa-share"></i>
                        </a>
                    </div>
                    <h3><?php esc_html_e('QR Code', 'qrlite'); ?></h3>
                    <div class="qrlite-qr-code text-center">
                        <?php do_action('qrlite_sharing_panel_qr', get_the_ID(), '200x200'); ?>
                    </div>
                </div>
                <div style="display: block; right: 0px;" class="qrlite-panel_button">
                    <a href="#" class="qrlite-toggle_sidebar">
                        <i class="fas fa-share-alt"></i>
                    </a>
                    <div class="clearfix"></div>
                </div>
                <div style="display: none; right: 0px;" class="qrlite-panel_button qrlite_hide_button">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>

    <?php 
}
add_action('qrlite_page_header', 'qrlite_frontend_sharing_panel');

function qrlite_frontend_back_to_top() {
    echo '<a class="qrlite-back-to-top qrlite-is-visible qrlite-fade-out" href="#0">
        <i class="fas fa-angle-up"></i>
    </a>';
}
add_action('qrlite_page_header', 'qrlite_frontend_back_to_top');