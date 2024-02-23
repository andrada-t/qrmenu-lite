<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<div class="modal fade" id="qrlite_btn_styles_modal" tabindex="-1" aria-labelledby="qrlite_btn_styles_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header p-4">
        <h4 class="modal-title"><?php echo esc_html__('Customize Menu:', 'qrlite'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo esc_html__('Close', 'qrlite'); ?>"></button>
      </div>

      <div class="modal-body p-4">
        <div class="row">
          <div class="col-md-3 mb-2">
            <h5><?php echo esc_html__('Variant: ','qrlite'); ?></h3>
            <div class="list-inline col-md-12 mb-2">
              <div class="relative">
                <input <?php if ($template_version == 'v1'){echo esc_attr('checked'); } ?> type="radio" name="template_version" id="btn_style_1" class=" qrlite-hidden-radio" value="v1">
                <label for="btn_style_1">
                  <span class="badge bg-primary"><?php esc_html_e('Variant 1', 'qrlite'); ?></span>
                  <div class="tick_container">
                    <div class="tick"><i class="fa fa-check"></i></div>
                  </div>
                </label>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-2">
            <h5><?php echo esc_html__('Columns: ','qrlite'); ?></h3>
            <div class="list-inline col-md-12 mb-2">
              <div class="relative">
                <input <?php if ($template_column == '1'){echo esc_attr('checked'); } ?> type="radio" name="template_column" id="btn_column_1" class="d-none qrlite-hidden-radio" value="1">
                <label for="btn_column_1">
                  <span class="badge bg-primary"><?php esc_html_e('#1 Column', 'qrlite'); ?></span>
                  <div class="tick_container">
                    <div class="tick"><i class="fa fa-check"></i></div>
                  </div>
                </label>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-2">
            <h5><?php echo esc_html__('Layout: ','qrlite'); ?></h5>
            <div class="list-inline col-md-12 mb-2">
              <div class="relative">
                <input <?php if ($template_layout == 'block'){echo esc_attr('checked'); } ?> type="radio" name="template_layout" id="btn_layout_1" class="d-none qrlite-hidden-radio" value="block">
                <label for="btn_layout_1">
                  <span class="badge bg-primary"><?php esc_html_e('Grid', 'qrlite'); ?></span>
                  <div class="tick_container">
                    <div class="tick"><i class="fa fa-check"></i></div>
                  </div>
                </label>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-2 d-al">
            <h5><?php echo esc_html__('Alignment: ','qrlite'); ?></h5>
            <?php echo esc_html(qrlite_alignment_group('alignment', esc_attr($alignment), '')); ?>
          </div>
        </div>
      </div>

      <div class="modal-footer text-left">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php esc_html_e('Save Changes', 'qrlite'); ?></button>
      </div>
    </div>
  </div>
</div>