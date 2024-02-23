<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<div class="modal fade" id="qrlite_share_modal" tabindex="-1" aria-labelledby="qrlite_share_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header p-4">
        <h5 class="modal-title"><?php echo esc_html__('Share your Menu', 'qrlite'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo esc_html__('Close', 'qrlite'); ?>"></button>
      </div>

      <div class="modal-body p-4">
        <label for="basic-url" class="form-label"><?php echo esc_html__('Your Menu URL', 'qrlite'); ?></label>
        <div class="input-group mb-3">
          <input  type="text" class="form-control qrlite-links-page-url" disabled placeholder="<?php echo esc_html__('Links Page', 'qrlite'); ?>" aria-label="<?php echo esc_html__('Links Page', 'qrlite'); ?>" aria-describedby="qrlite-copy-links-page" value="<?php echo esc_url(get_permalink($current_post_id)); ?>">
          <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_html__('Copy', 'qrlite'); ?>" class="btn btn-outline-secondary" type="button" id="qrlite-copy-links-page"><i class="far fa-copy"></i></button>
          <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_html__('Preview', 'qrlite'); ?>" class="btn btn-outline-primary" href="<?php echo esc_url(get_permalink($current_post_id)); ?>" target="_blank"><i class="far fa-eye"></i></a>
        </div>
        <div class="mb-3 qrlite-qr relative">
          <label><?php echo esc_html__('QR Code', 'qrlite'); ?></label>
          <div class="clearfix"></div>
          <?php $qr = 'https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl='.esc_url(get_permalink($current_post_id)).'&choe=UTF-8'; ?>
          <a href="<?php echo esc_url($qr); ?>" target="_blank">
            <img class="qrlite-qr" src="<?php echo esc_url($qr); ?>" alt="qr" />
          </a>
  
        </div>
      </div>
      <div class="modal-footer text-left">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php esc_html_e('Save Changes', 'qrlite'); ?></button>
      </div>
    </div>
  </div>
</div>