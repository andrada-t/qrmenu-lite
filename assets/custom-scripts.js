/**
 * QRLITE CUSTOM SCRIPTS - TABLE OF CONTENTS
 * 
 * Link Manipulation
 * Copy to clipboard
 * Builder Element Importer
 * Builder Accordion
 * Builder Repeater
 * Builder Media Uploader
 * Colorpicker Clearer
 * Builder Links Drag and Drop
 * Builder Icon Picker
 * Builder Tooltips
 */

(function ($) {
    'use strict';
    
    jQuery(document).ready(function () {

        /**
         * Link Manipulation
         * Set a new query string on the current website url
         * 
         * @param {string}  key     url query string key
         * @param {string}  value   url query string value
         */ 
        function qrlite_setget_param(key,value) {
            if (history.pushState) {
                var params = new URLSearchParams(window.location.search);
                params.set(key, value);
                var newUrl = window.location.origin 
                + window.location.pathname 
                + '?' + params.toString();
                window.history.pushState({path:newUrl},'',newUrl);
            }
        }
        function qrlite_setlink_param(){
            var post_id = jQuery('#qrlite_post_id').val();
            if(post_id){
                qrlite_setget_param('links_page',post_id);
            }
        }
        qrlite_setlink_param();

        function qrlite_current_builder_tab_param(){

            // Default
            if (!qrlite_url_has_param('tab')) {
                qrlite_setget_param('tab', 'links');
            }

            jQuery( '.qrlite-nav-tabs button' ).on( "click", function(){

                var button = jQuery(this);
                var button_attr = button.attr('data-attr');
                var button_attr_val = button.attr('data-attr-val');

                if(button_attr && button_attr_val){
                    qrlite_setget_param(button_attr, button_attr_val);
                }
            });
        }
        qrlite_current_builder_tab_param();

        /**
         * Check if current link has a given parameter
         * 
         * @param {string}  parameter     url query string key
         */ 
        function qrlite_url_has_param(parameter){
            var currentUrl = window.location.href;
            var searchParams = new URLSearchParams(currentUrl);
            if (searchParams.has(parameter)) {
                return true;
            }else{
                return false;
            }
        }

        /**
         * Removes a query string by parameter
         * 
         * @param {string}  parameter     url query string key
         */ 
        function qrlite_remove_param(parameter) {
            const url = new URL(window.location.href);
            const searchParams = url.searchParams;
            searchParams.delete(parameter);

            const newURL = url.origin + url.pathname + '?' + searchParams.toString();
            history.replaceState(null, '', newURL);
        }
        function qrlite_remove_param_update_url(){
            var currentUrl = window.location.href;
            var searchParams = new URLSearchParams(currentUrl);
            var givenParameter = 'use_template';
            if (searchParams.has(givenParameter)) {
                qrlite_remove_param('use_template');
            }
        }
        qrlite_remove_param_update_url();


        /**
         * Copy to clipboard
         * 
         * @param {string}  text     clipboard copied text
         */ 
        function qrlite_copy_to_clipboard(text) {
            var textField = document.createElement('textarea');
            textField.innerText = text;
            document.body.appendChild(textField);
            textField.select();
            textField.focus(); //SET FOCUS on the TEXTFIELD
            document.execCommand('copy');
            textField.remove();
            jQuery('#qrlite-copy-links-page').attr('data-bs-title', 'Copied');
        }
        jQuery( '#qrlite-copy-links-page' ).on( "click", function(){
            var clipboardText = "";
            clipboardText = jQuery( '.qrlite-links-page-url' ).val(); 
            qrlite_copy_to_clipboard( clipboardText );
         });


        /**
         * Builder Element Importer
         */ 
        jQuery('.qrlite-element-importer-btn').on( "click", function(e) {
            e.preventDefault();

            var element_type = jQuery(this).attr('data-element-type');

            // AJAX request
            jQuery.ajax({
                url: qrlite_builder_ajax.url,
                type: 'POST',
                data: {
                    action: 'qrlite_import_element',
                    element_type: element_type,
                    nonce: qrlite_builder_ajax.nonce
                },
                success: function(response) {
                    // Handle the response
                    if(element_type == 'social-icon'){
                        var append_to = jQuery('.qrlite-social-icons-group');
                    } else if(element_type == 'typography'){
                        var append_to = jQuery('.qrlite-typography-group');
                    } else if(element_type == 'timeline'){
                        var append_to = jQuery('.qrlite-timeline-group');
                    }else{
                        var append_to = jQuery('.qrlite-buttons-group-inner');
                    }
                    append_to.append(response);
                },
                complete: function(response) {
                    // Re-init functions on ajax success
                    qrlite_repeater_init();
                    qrlite_accordions_init();
                    qrlite_accordions_main_init();
                    qrlite_media_uploader_field_init();
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                }
            });
        });


        /**
         * Builder Element Importer
         */
        jQuery(".main-card").each(function() {
            var dataId = $(this).attr('id');
            var menuBtnClass = ' .qrlite-nav-menu-btn';
            var selector = '#' + dataId + menuBtnClass;
            //alert(selector);
            jQuery(selector).on( "click", function(e) {
                e.preventDefault();

                var element_type = jQuery(this).attr('data-element-type');
                // AJAX request
                jQuery.ajax({
                    url: qrlite_builder_ajax.url,
                    type: 'POST',
                    data: {
                        action: 'qrlite_import_element',
                        element_type: element_type,
                        nonce: qrlite_builder_ajax.nonce
                    },
                    success: function(response) {
                        // Handle the response
                        var menuBtnClassw = ' .qrlite-buttons-group-inners';
                        var selectors = '#' + dataId + menuBtnClassw;
                        var append_to = jQuery(selectors);
                        append_to.append(response);
                    },
                    complete: function(response) {
                        // Re-init functions on ajax success
                        qrlite_repeater_init();
                        qrlite_accordions_init();
                        qrlite_accordions_main_init();
                        qrlite_media_uploader_field_init();
                    },
                    error: function(errorThrown) {
                        console.log(errorThrown);
                    }
                });
            });
         });
        /**
         * Builder Accordion
         */ 
        function qrlite_accordions_init(){
            var myAccordion = new gianniAccordion({
                elements: ".qrlite-accordion-card .qrlite-accordion-card-inner",
                trigger: "[data-accordion-element-trigger]",
                content: "[data-accordion-element-content]",
            });

            myAccordion.on("elementSelected", (data)=>{
                //
            });
        }
        qrlite_accordions_init();

        /**
         * Builder Accordion
         */ 
        function qrlite_accordions_main_init(){
            var myAccordion = new gianniAccordion({
                elements: ".qrlite-accordion-cards .accordion-item",
                trigger: "[data-accordion-element-trigger]",
                content: "[data-accordion-element-content]",
            });

            myAccordion.on("elementSelected", (data)=>{
                //
            });
        }
        qrlite_accordions_main_init();

        /**
         * Builder Repeater
         */ 
        function qrlite_repeater_init(){
            jQuery('.qrlite-buttons-group, .qrlite-sm-group').repeater({
                repeaters: [{
                    selector: '.inner-repeater'
                }],
                show: function () {
                    jQuery(this).slideDown();
                    qrlite_accordions_init();
                    qrlite_accordions_main_init();
                    qrlite_media_uploader_field_init();
                    qrlite_schedule_toggle();
                },
                hide: function (deleteElement) {
                    // alert confirmation here
                    jQuery(this).slideUp(deleteElement);
                },
                ready: function (setIndexes) {
                    qrlite_schedule_toggle();
                },
                // initEmpty: true,
                isFirstItemUndeletable: false
            });
        }
        qrlite_repeater_init();


        /**
         * Builder Media Uploader
         */ 
        function qrlite_media_uploader_field_init(){
            jQuery('.qrlite_image_preview_box').each(function( e ) {
                var current_btn = $(this);
                current_btn.click(function(e) {
                    e.preventDefault();
                    var image = wp.media({
                        title: 'Upload Image',
                        multiple: false
                    }).open().on('select', function(e) {
                        var uploadedImage = image.state().get('selection').first();
                        var imageSrc = uploadedImage.toJSON().url;
                        var imageID = uploadedImage.toJSON().id;
                        current_btn.parent().find('input.uploader-pid').val(imageID);
                        current_btn.parent().find('input.uploader-img-url').val(imageSrc);
                        current_btn.parent().find('.qrlite_image_preview_box').removeClass('upload-now');
                        current_btn.parent().find('.qrlite_image_preview_box').html('<img alt="bio" class="img-rounded" width="80" src="' + imageSrc + '">');
                    });
                });
            });
        }
        qrlite_media_uploader_field_init();
        jQuery('.media-uploader-clearer').each(function( e ) {
            var current_btn = jQuery(this);
            current_btn.click(function(e) {
                current_btn.parent().parent().find('.qrlite_image_preview_box').html('').addClass('upload-now');
                current_btn.parent().parent().find('input').attr('value', '');
            });
        });


        /**
         * Colorpicker Clearer
         */ 
        jQuery('.colorpicker-clearer').each(function( e ) {
            var current_btn = jQuery(this);
            current_btn.click(function(e) {
                current_btn.parent().find('.form-control-color').val('transparent');
                current_btn.parent().find('.form-control-color').attr('value', 'transparent');
            });
        });

        /**
         * Builder Links Drag and Drop
         */ 
        jQuery(".qrlite-buttons-group").sortable({
            items: '.accordion-item',
            cursor: 'pointer',
            axis: 'y',
            dropOnEmpty: false,
            start: function (e, ui) {
                ui.item.addClass("selected");
            },
            stop: function (e, ui) {
                ui.item.removeClass("selected");
            }
        });

        /**
         * Builder Schedule toggle
         */ 
        function qrlite_schedule_toggle(){
            var schedule_btn = jQuery(".qrlite_schedule_toggle");
            var schedule_checkbox = schedule_btn.parent().find('.btn_schedule_input');


            if (schedule_btn.length) {

                if (schedule_checkbox.checked) {
                    schedule_checkbox.parent().find( "fieldset" ).fadeIn('slow');
                }else{
                    schedule_checkbox.parent().find( "fieldset" ).fadeOut('slow');
                }
                
                schedule_checkbox.change(function(){
                    if (this.checked) {
                        schedule_checkbox.parent().find( "fieldset" ).fadeIn('slow');
                    }else{
                        schedule_checkbox.parent().find( "fieldset" ).fadeOut('slow');
                    }
                });
            }
        }
        qrlite_schedule_toggle();

        /**
         * Builder Tooltips
         */ 
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
     
} (jQuery) );
