<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if( !function_exists('qrlite_menu_items_shortcode') ) {
	function qrlite_menu_items_shortcode($params, $content) {
	    extract( shortcode_atts( 
	      array(
	        'settings'            => '',
	        'tab1'        => '',
	        'version'     =>'',
	        'columns'     =>'',
	        'alignment'     =>'',
	        'layout_display'     =>'',
	      ), $params ) );

	    ob_start(); 

	    $tab1 = unserialize(base64_decode($tab1)); 
	    ?>
		<div class="qrlite-menu-items-container">
			<div class="qrlite-menu-tabs">
				<section class="qrlite-menu-section">
					<div class="qrlite-menu-tab1 qrlite-menu-tab1-<?php echo esc_attr($version); ?>" style="-webkit-columns:<?php echo esc_attr($columns)?>">
					<?php if ($tab1) {
						foreach ( $tab1 as $item ) {
							$item_type = $item['item_type'];
							$dish_image = $item['dish_image']['url'];
							$dish_title = $item['dish_title'];
							$dish_price = $item['dish_price'];
							$dish_sale_price = $item['dish_sale_price'];
							$dish_description = $item['dish_description'];
							$dish_promotion = $item['dish_promotion'];	
							$dish_heading = $item['dish_heading'];	
							$grams = $item['grams'];
							$hide_menu = $item['hide_menu'];
							$preparation_time = $item['preparation_time'];
				            ?>
							<?php if($item_type == "product"){?>
								<?php if(empty($item['hide_menu'])) { ?>
					              	<div class="qrlite-menu-items-inner-container-<?php echo esc_attr($version); ?>" style="text-align:<?php echo esc_attr($alignment)?>;display:<?php echo esc_attr($layout_display)?>">
					              		<?php if(!empty($dish_image)){?>
											<div class="qrlite-menu-items-img-holder">
												<div class="qrlite-menu-items-img-wrap modal-image">
													<img id="qrlite-img" src="<?php echo esc_url($dish_image); ?>" alt="<?php echo esc_html($dish_title); ?>">
												</div>
											</div>
										<?php }?>
										<div class="qrlite-menu-items-content">
											<div class="qrlite-menu-items-upper-content" style="display:<?php echo esc_attr($layout_display)?>">
										        <?php if(!empty($dish_title)){ ?>
												    <div class="qrlite-menu-items-title">
											          	<?php echo esc_html($dish_title);  ?>
											          	<?php if ( !empty($dish_promotion) ) { ?>
												          	<span class="qrlite-menu-items-label">
													        	<?php echo esc_html($dish_promotion);  ?>
													        </span>
													    <?php } ?>
												    </div>
											    <?php } ?>
											    <?php if($version == 'v2'){ ?>
											       	<div class="qrlite-menu-items-line"></div>
											    <?php } ?>
											    <div class="qrlite-menu-items-price-group">
											    <?php if(!empty($dish_price)){ ?>
												    <div class="qrlite-menu-items-price <?php if(!empty($dish_sale_price)){ ?> reduced <?php } ?>">
												        <?php qrlite_get_currency_formatted($dish_price); ?>
												    </div>
											    <?php } ?>
											    <?php if(!empty($dish_sale_price)){ ?>
												    <div class="qrlite-menu-items-price">
											          	<?php qrlite_get_currency_sale_formatted($dish_sale_price);  ?>
												    </div>
											    <?php } ?>	
											    </div>
										    </div> 
										    <div class="qrlite-menu-items-bottom-content">
											    <div class="qrlite-menu-items-description">
										          	<?php echo esc_html($dish_description);  ?>
											    </div>
											</div>
											<div class="qrlite-menu-items-nutritional-info">
												<?php if (!empty($grams)) { ?>
													<div class="nutritional-info-itm">
												    	<i class="fa-solid fa-weight-scale"></i><?php echo esc_html($grams);  ?>
												    </div>
												<?php } ?>
												
												<?php if (!empty($preparation_time)) { ?>
													<div class="nutritional-info-itm">
												    	<i class="fa-regular fa-clock"></i><?php echo esc_html($preparation_time);  ?>
												    </div>
												<?php } ?>
											</div>
										</div>
									</div>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</div>
			</section>
		</div>   
	</div>
	<?php
	    return ob_get_clean();
	}
	add_shortcode('qrlite-menu-items', 'qrlite_menu_items_shortcode');
}