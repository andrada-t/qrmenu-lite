<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/** 
 * Supported Field Types:
 * 
 * input: text, url, number
 * colorpicker
 * textarea
 * alignment_groups
*/


/** 
 * Fieldtype: Input
 * 
 * @param type: string (text/url/number)
 * @param name: input name attribute
 * @param value: input value attribute
 * @param label: label text
 * @param id: id of the input + for of the label
 * @param floating: with/without the bootstrap's floating effect of the placeholder
 * @param div_holder_class:     string      - an extra html class 
*/
function qrlite_input($type = '', $name = '', $value = '', $label = '', $id = '', $floating = true, $div_holder_class = ''){
    if ($floating) {
        $holder_class = "form-floating";
    }else{
        $holder_class = "";
    } ?>

    <div class="<?php echo esc_attr($holder_class); ?> mb-3 <?php echo esc_attr($div_holder_class); ?>">
        <?php if(!$floating){ ?>
            <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
        <?php } ?>

        <input type="<?php echo esc_attr($type); ?>" class="form-control" name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($id); ?>" placeholder="<?php echo esc_attr($label); ?>" value="<?php echo esc_attr($value); ?>" />
        
        <?php if($floating){ ?>
            <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
        <?php } ?>
    </div>

    <?php 
}

/** 
 * Fieldtype: Input Number
 * 
 * @param name: input name attribute
 * @param value: input value attribute
 * @param label: label text
 * @param id: id of the input + for of the label
 * @param floating: with/without the bootstrap's floating effect of the placeholder
*/
function qrlite_input_number($name = '', $value = '', $label = '', $placeholder = '', $id = '', $div_holder_class = ''){
 ?>
 
    <div class="form-floating mb-3 <?php echo esc_attr($div_holder_class); ?>">
        <input type="number" class="form-control" name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($id); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" value="<?php echo esc_attr($value); ?>" />
        
        <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
     
    </div>

    <?php 
}

/** 
 * Fieldtype: Icon Picker
 * 
 * @param name:                 string      - input name attribute
 * @param value:                string      - input value attribute
 * @param label:                string      - label text
 * @param placeholder:          string      - input placeholder attribute
 * @param id:                   string      - id of the input + for of the label
*/
function qrlite_iconpicker($name = '', $value = '', $label = '', $placeholder = '', $id = ''){
    global $icons;
    ?>

    <div class="input-group mb-3 relative qrlite-icon-picker">
        <span class="input-group-text" id="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></span>
        <select id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" class="form-control">
            <option value="select"><?php echo esc_html__('Select','qrlite'); ?></option>
            <?php foreach($icons as $key => $icon) { ?>
            <option value="<?php echo esc_attr($icon); ?>"  <?php if ( $value == $icon  ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html($key); ?></option>
        <?php } ?>
        </select>
    </div>

    <?php 
}

/** 
 * Fieldtype: Colorpicker
 * 
 * @param name:                 string      - input name attribute
 * @param value:                string      - input value attribute
 * @param label:                string      - label text
 * @param id:                   integer     - id of the input + for of the label
 * @param div_holder_class:     string      - an extra html class 
*/
function qrlite_colorpicker($name = '', $value = '', $label = '', $id = '', $div_holder_class = ''){
    ?>

    <div class="form-group mb-3 relative <?php echo esc_attr($div_holder_class); ?>">
        <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
        <div class="clearfix"></div>
        <input autocomplete="off" type="text" data-coloris name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($value); ?>" class="coloris form-control form-control-color" />
    </div>
    <?php 
}

/** 
 * Fieldtype: Textarea
 * 
 * @param name: textarea name attribute
 * @param content: textarea content/value
 * @param label: label text
 * @param id: id of the textarea + for of the label
 * @param floating: with/without the bootstrap's floating effect of the placeholder
*/
function qrlite_textarea($name = '', $content = '', $label = '', $id = '', $floating = true){
    if ($floating) {
        $holder_class = "form-floating";
    }else{
        $holder_class = "";
    } ?>
    <div class="<?php echo esc_attr($holder_class); ?> mb-3">
        <textarea rows="4" type="url" class="form-control" name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($id); ?>" placeholder="<?php echo esc_attr($label); ?>"><?php echo esc_attr($content); ?></textarea>
        <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
    </div>

    <?php 
}

/** 
 * Fieldtype: Alignment group
 * 
 * @param name: radio name attribute
 * @param value: radio checked value
 * @param label: label text
*/
function qrlite_alignment_group($name = '', $value = '', $label = ''){
    $id_left = uniqid('left_');
    $id_center = uniqid('center_');
    $id_right = uniqid('right_');
    ?>

    <div class="form-group mb-3">
        <label><?php echo esc_attr($label); ?></label>
        <div class="clearfix"></div>
        <div class="btn-group" role="group">
          <input <?php if ($value == 'left'){echo esc_attr('checked'); } ?> type="radio" class="btn-check" name="<?php echo esc_attr($name); ?>" value="left" id="<?php echo esc_attr($id_left); ?>" autocomplete="off">
          <label class="btn btn-outline-secondary" for="<?php echo esc_attr($id_left); ?>"><i class="fas fa-align-left"></i></label>

          <input <?php if ($value == 'center'){echo esc_attr('checked'); } ?> type="radio" class="btn-check" name="<?php echo esc_attr($name); ?>" value="center" id="<?php echo esc_attr($id_center); ?>" autocomplete="off">
          <label class="btn btn-outline-secondary" for="<?php echo esc_attr($id_center); ?>"><i class="fas fa-align-center"></i></label>

          <input <?php if ($value == 'right'){echo esc_attr('checked'); } ?> type="radio" class="btn-check" name="<?php echo esc_attr($name); ?>" value="right" id="<?php echo esc_attr($id_right); ?>" autocomplete="off">
          <label class="btn btn-outline-secondary" for="<?php echo esc_attr($id_right); ?>"><i class="fas fa-align-right"></i></label>
        </div>
    </div>

    <?php 
}

/** 
 * Fieldtype: Padding group
 * 
 * @param name: radio name attribute
 * @param value: radio checked value
 * @param label: label text
*/
function qrlite_padding_group($name = '', $heading = '', $p_left = '', $p_right = '', $p_top = '', $p_bottom = ''){
    ?>

    <div class="form-group mb-3  row relative qrlite-padding-group">
        <div class="col-sm-12"><?php echo esc_html($heading); ?></div>
        <div class="col-sm-3">
            <div class="input-group">
                <div class="input-group-text"><?php echo esc_html__('Left', 'qrlite'); ?></div>
                <input type="number" name="<?php echo esc_attr($name); ?>[]" value="<?php echo esc_attr($p_left); ?>" class="form-control" min="0" max="200" />
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group">
                <div class="input-group-text"><?php echo esc_html__('Right', 'qrlite'); ?></div>
                <input type="number" name="<?php echo esc_attr($name); ?>[]" value="<?php echo esc_attr($p_right); ?>" class="form-control" min="0" max="200" />
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group">
                <div class="input-group-text"><?php echo esc_html__('Top', 'qrlite'); ?></div>
                <input type="number" name="<?php echo esc_attr($name); ?>[]" value="<?php echo esc_attr($p_top); ?>" class="form-control" min="0" max="200" />
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group">
                <div class="input-group-text"><?php echo esc_html__('Bottom', 'qrlite'); ?></div>
                <input type="number" name="<?php echo esc_attr($name); ?>[]" value="<?php echo esc_attr($p_bottom); ?>" class="form-control" min="0" max="200" />
            </div>
        </div>
    </div>

    <?php 
}


/** 
 * Fieldtype: Media Uploader
 * 
 * @param name: radio name attribute
 * @param value: radio checked value
 * @param label: label text
*/
function qrlite_media_uploader($name = '', $attachment_id = '', $attachment_url = '', $label = '', $benefit = ''){

    $attachment_url = '';
    if ($attachment_id) {
        if (wp_get_attachment_url($attachment_id)) {
            $attachment_url = wp_get_attachment_url($attachment_id);
        }
        $photo_status = true;
    }else{
        $attachment_id = '';
        $photo_status = false;
    } 

    $this_benefit = $benefit;

    ?>

    <div class="qrlite-image-uploader-box mb-3 relative">
        <label><?php echo esc_html($label); ?></label>
        <div class="clearfix"></div>
        <input class="uploader-pid" type="hidden" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($attachment_id); ?>">
        <input class="uploader-img-url" type="hidden" name="<?php echo esc_attr($name); ?>_url" value="<?php echo esc_url($attachment_url); ?>">
        <div class="qrlite_image_preview_box <?php if(!$photo_status){ echo esc_attr('upload-now'); } ?>">
            <?php 
                if ($attachment_url) { ?>
                    <img alt="bio" class="img-rounded" width="80" src="<?php echo esc_url($attachment_url); ?>" />';
                    <?php 
                }
            ?>
        </div>
        <div class="relative inline-block">
            <span class="media-uploader-clearer far fa-trash-alt"></span>
        </div>
        <?php do_action('qrlite_builder_'.$benefit); ?>
    </div>
    <?php 
}


/** 
 * Fieldtype: Media Uploader
 * 
 * @param name: radio name attribute
 * @param id: radio checked value
 * @param label: label text
 * @param status: radio checked value
*/
function qrlite_checkbox($div_holder_class = '', $status = '', $id = '', $label = ''){
    ?>
    <div class="mb-3 relative <?php echo esc_attr($div_holder_class); ?>">
        <input <?php if($status){ if($status[0] == 'on'){echo esc_attr('checked'); }} ?> name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id); ?>" class="form-check-input mt-0" type="checkbox" />
        <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
    </div>
    <?php 
}


/** 
 * Fieldtype: Select Weight
 * 
 * @param name:                 string      - input name attribute
 * @param value:                string      - input value attribute
 * @param label:                string      - label text
 * @param id:                   integer     - id of the input + for of the label
 * @param div_holder_class:     string      - an extra html class 
*/
function qrlite_select_weight($name = '', $value = '', $label = '', $id = '', $div_holder_class = ''){
    ?>

    <div class="form-floating mb-3 <?php echo esc_attr($div_holder_class); ?>">
        <select id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" class="form-control">
            <option value="400"  <?php if ( $value == '400' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('400','qrlite'); ?></option>
            <option value="500"  <?php if ( $value == '500' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('500','qrlite'); ?></option>
            <option value="600"  <?php if ( $value == '600' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('600','qrlite'); ?></option>
            <option value="700"  <?php if ( $value == '700' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('700','qrlite'); ?></option>
            <option value="800"  <?php if ( $value == '800' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('800','qrlite'); ?></option>
        </select>
        <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
    </div>
    <?php 
}


/** 
 * Fieldtype: Border Type
 * 
 * @param name:                 string      - input name attribute
 * @param value:                string      - input value attribute
 * @param label:                string      - label text
 * @param id:                   integer     - id of the input + for of the label
 * @param div_holder_class:     string      - an extra html class 
*/
function qrlite_border_type($name = '', $value = '', $label = '', $id = '', $div_holder_class = '', $benefit = ''){
    ?>

    <div class="form-floating mb-3 <?php echo esc_attr($div_holder_class); ?>">
        <select id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" class="form-control">
            <option value="none"  <?php if ( $value == 'none' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('None','qrlite'); ?></option>
            <option value="solid"  <?php if ( $value == 'solid' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('Solid','qrlite'); ?></option>
            <option value="dashed"  <?php if ( $value == 'dashed' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('Dashed','qrlite'); ?></option>
            <option value="dotted"  <?php if ( $value == 'dotted' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('Dotted','qrlite'); ?></option>
            <option value="double"  <?php if ( $value == 'double' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('Double','qrlite'); ?></option>
        </select>
        <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
        <?php do_action('qrlite_builder_'.$benefit); ?>
    </div>
    <?php 
}


/** 
 * Fieldtype: Font Family
 * 
 * @param name:                 string      - input name attribute
 * @param value:                string      - input value attribute
 * @param label:                string      - label text
 * @param id:                   integer     - id of the input + for of the label
 * @param div_holder_class:     string      - an extra html class 
*/
function qrlite_font_family($name = '', $value = '', $label = '', $id = '', $div_holder_class = ''){
    global $google_fonts_list;
    ?>
    
    <div class="form-floating mb-3 <?php echo esc_attr($div_holder_class); ?>">
        <select id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" class="form-control">
            <option value="select"><?php echo esc_html__('Select','qrlite'); ?></option>
            <?php foreach($google_fonts_list as $font) { ?>
            <option value="<?php echo esc_attr($font); ?>"  <?php if ( $value == $font  ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html($font); ?></option>
        <?php } ?>
        </select>
        <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
    </div>
    <?php 
}


/** 
 * Fieldtype: Button Type
 * 
 * @param name:                 string      - input name attribute
 * @param value:                string      - input value attribute
 * @param label:                string      - label text
 * @param id:                   integer     - id of the input + for of the label
 * @param div_holder_class:     string      - an extra html class 
*/
function qrlite_button_type($name = '', $value = '', $label = '', $id = '', $div_holder_class = ''){
    ?>

    <div class="form-floating mb-3 <?php echo esc_attr($div_holder_class); ?>">
        <select id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" class="form-control">
            <option value="button_link"  <?php if ( $value == 'button_link' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('Button Link','qrlite'); ?></option>
            <option value="email_link"  <?php if ( $value == 'email_link' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('Email Link','qrlite'); ?></option>
        </select>
        <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
    </div>
    <?php 
}

/** 
 * Fieldtype: Box Shadow Select
 * 
 * @param name:                 string      - input name attribute
 * @param value:                string      - input value attribute
 * @param label:                string      - label text
 * @param id:                   integer     - id of the input + for of the label
 * @param div_holder_class:     string      - an extra html class 
*/
function qrlite_bs_select($name = '', $value = '', $label = '', $id = '', $div_holder_class = '', $benefit = ''){
    ?>
     <div class="form-floating mb-3 <?php echo esc_attr($div_holder_class); ?>">
        <select id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" class="form-control">
            <option value=""  <?php if ( $value == '' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('Select','qrlite'); ?></option>
            <option value="show_shadow"  <?php if ( $value == 'show_shadow' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('Yes','qrlite'); ?></option>
            <option value="no"  <?php if ( $value == 'no' ) echo esc_attr('selected="selected"'); ?> ><?php echo esc_html__('No','qrlite'); ?></option>
        </select>
        <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
        <?php do_action('qrlite_builder_'.$benefit); ?>
    </div>
    <?php 
}

/** 
 * Fieldtype: Background position
 * 
 * @param name:                 string      - input name attribute
 * @param value:                string      - input value attribute
 * @param label:                string      - label text
 * @param id:                   integer     - id of the input + for of the label
 * @param div_holder_class:     string      - an extra html class 
*/
function qrlite_background_position($name = '', $value = '', $label = '', $id = '', $div_holder_class = '', $benefit = '' ){
    $id_left = uniqid('left_');
    $id_right = uniqid('right_');
    ?>

    <div class="form-group mb-3 relative <?php echo esc_attr($div_holder_class); ?>">
        <label><?php echo esc_attr($label); ?></label>
        <div class="btn-group" role="group">
          <input <?php if ($value == 'left'){echo esc_attr('checked'); } ?> type="radio" class="btn-check" name="<?php echo esc_attr($name); ?>" value="left" id="<?php echo esc_attr($id_left); ?>" autocomplete="off">
          <label class="btn btn-outline-secondary" for="<?php echo esc_attr($id_left); ?>"><i class="fas fa-align-left"></i></label>
          <input <?php if ($value == 'right'){echo esc_attr('checked'); } ?> type="radio" class="btn-check" name="<?php echo esc_attr($name); ?>" value="right" id="<?php echo esc_attr($id_right); ?>" autocomplete="off">
          <label class="btn btn-outline-secondary" for="<?php echo esc_attr($id_right); ?>"><i class="fas fa-align-right"></i></label>
        </div>
        <?php do_action('qrlite_builder_'.$benefit); ?>
    </div>

    <?php 
}

/** 
 * Fieldtype: Background position
 * 
 * @param name:                 string      - input name attribute
 * @param value:                string      - input value attribute
 * @param label:                string      - label text
 * @param id:                   integer     - id of the input + for of the label
 * @param div_holder_class:     string      - an extra html class 
*/
function qrlite_toggle($div_holder_class = '', $status = '', $id = '', $label = '', $left_text = '', $right_text = '' ){
    $id_left = uniqid('left_');
    $id_right = uniqid('right_');
    ?>

 
    <div class="form-group mb-3 relative <?php echo esc_attr($div_holder_class); ?>">
        <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
        <div class="btn-group" role="group">
          <input <?php if ($status == 'yes'){echo esc_attr('checked'); } ?> type="radio" class="btn-check" name="<?php echo esc_attr($id); ?>" value="yes" id="<?php echo esc_attr($id_left); ?>" autocomplete="off">
          <label class="btn btn-outline-secondary" for="<?php echo esc_attr($id_left); ?>"><?php echo esc_html($left_text); ?></label>
          <input <?php if ($status == 'off'){echo esc_attr('checked'); } ?> type="radio" class="btn-check" name="<?php echo esc_attr($id); ?>" value="off" id="<?php echo esc_attr($id_right); ?>" autocomplete="off">
          <label class="btn btn-outline-secondary" for="<?php echo esc_attr($id_right); ?>"><?php echo esc_html($right_text); ?></label>
        </div>

    </div>
    <?php 
}