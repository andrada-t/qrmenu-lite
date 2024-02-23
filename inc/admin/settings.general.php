<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'cmb2_admin_init', 'qrlite_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function qrlite_register_theme_options_metabox() {
	$currency_code_options = qrlite_get_currencies();
	foreach ( $currency_code_options as $code => $name ) {
		$currency_code_options[ $code ] = $name . ' (' . qrlite_get_currency_symbol( $code ) . ')';
	}
	$cmb = new_cmb2_box( array(
		'id'           => 'qrlite_settings',
		'title'        => esc_html__('General Settings', 'qrlite'),
		'description'  => esc_html__('Customize your general settings here.', 'qrlite'),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'qrlite-main-settings',
		'icon_url'     => 'dashicons-palmtree',
		'display_cb'   => 'qrlite_general_settings_page',
	) );

	
	$cmb->add_field( array(
	    'name' => esc_html__('Builder Settings', 'qrlite'),
	    'id'   => 'qrlite_title_b_settings',
	    'type' => 'title',
	) );
	$cmb->add_field( array(
	    'name' => esc_html__('Sharing Panel', 'qrlite'),
	    'desc' => esc_html__('Show or Hide the Sharing panel across all of the public pages (Enabled by default)', 'qrlite'),
	    'id'   => 'qrlite_sharing',
	    'type' => 'checkbox',
	) );

	$cmb->add_field( array(
	    'name' => esc_html__('Restaurant Options', 'qrlite'),
	    'id'   => 'qrlite_title_r_settings',
	    'type' => 'title',
	) );

	$cmb->add_field( array(
	    'name' => esc_html__('Currency', 'qrlite'),
	    'desc' => esc_html__('This controls what currency prices are listed for the menu items.', 'qrlite'),
	    'id'   => 'qrlite_currency',
	    'type' => 'select',
	    'default'  => 'USD',
	    'options'  => $currency_code_options,
	) );
	$cmb->add_field( array(
		'name'    => esc_html__( 'Currency position', 'qrlite' ),
		'desc'    => esc_html__( 'This controls the position of the currency  symbol.', 'qrlite' ),
		'id'      => 'qrlite_currency_pos',
		'default'  => 'right',
		'type'     => 'select',
		'options'  => array(
			'left'        => esc_html__( 'Left', 'qrlite' ),
			'right'       => esc_html__( 'Right', 'qrlite' ),
			'left_space'  => esc_html__( 'Left with space', 'qrlite' ),
			'right_space' => esc_html__( 'Right with space', 'qrlite' ),
		),
	) );

}

function qrlite_general_settings_page( $hookup ) {
	?>
	<div class="wrap cmb2-options-page option-<?php echo esc_attr($hookup->option_key); ?>">
        <?php do_action('qrlite_before_wrap_tab_content', 'general'); ?>
        <div class="tab-content">
			<form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="<?php echo esc_attr($hookup->cmb->cmb_id); ?>" enctype="multipart/form-data" encoding="multipart/form-data">
				<input type="hidden" name="action" value="<?php echo esc_attr( $hookup->option_key ); ?>">
				<?php $hookup->options_page_metabox(); ?>
				<?php submit_button( esc_attr( $hookup->cmb->prop( 'save_button' ) ), 'primary', 'submit-cmb' ); ?>
			</form>
        </div>
	</div>
	<?php
}