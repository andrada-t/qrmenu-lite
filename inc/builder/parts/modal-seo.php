<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<div class="modal fade" id="qrlite_seo_modal" tabindex="-1" aria-labelledby="qrlite_seo_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header p-4">
        <h5 class="modal-title"><?php esc_html_e('SEO Settings', 'qrlite'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_html_e('Close', 'qrlite'); ?>"></button>
      </div>

      <div class="modal-body p-4">
        
        <label for="basic-url" class="form-label"><?php esc_html_e('Your Menu Title', 'qrlite'); ?></label>
        <div class="input-group mb-3">
          <span class="input-group-text" id="seo_page_title"><?php esc_html_e('Title', 'qrlite'); ?></span>
          <input type="text" class="form-control" aria-describedby="seo_page_title" name="seo_page_title" value="<?php echo esc_attr($seo_page_title); ?>" />
        </div>
        <label for="basic-url" class="form-label"><?php esc_html_e('Your Menu URL', 'qrlite'); ?></label>
        
        <div class="input-group mb-3">
          <span class="input-group-text" id="seo_page_slug"><?php echo esc_url(get_site_url()); ?></span>
          <input type="text" class="form-control" aria-describedby="seo_page_slug" name="seo_page_slug" value="<?php echo esc_attr($seo_page_slug); ?>" />
          
          <input type="hidden" name="seo_page_slug_id" value="<?php echo esc_attr($seo_page_slug_id); ?>" />
        </div>
      </div>
      <div class="modal-footer text-left">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php esc_html_e('Save Changes', 'qrlite'); ?></button>
      </div>
    </div>
  </div>
</div>