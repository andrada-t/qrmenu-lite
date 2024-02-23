/**
 * QRLITE TEMPLATE CUSTOM SCRIPTS - TABLE OF CONTENTS
 * 
 * Bio Links Page Sharer panel
 */

(function ($) {
    'use strict';
    
    jQuery(document).ready(function () {

        // browser window scroll (in pixels) after which the "back to top" link is shown
        var offset = 300,
        //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //duration of the top scrolling animation (in ms)
        scroll_top_duration = 300,
        //grab the "back to top" link
        $back_to_top = jQuery('.qrlite-back-to-top');

        //hide or show the "back to top" link
        jQuery(window).on( "scroll", function(){
            ( jQuery(this).scrollTop() > offset ) ? $back_to_top.addClass('qrlite-is-visible') : $back_to_top.removeClass('qrlite-is-visible modeltema-fade-out');
            if( jQuery(this).scrollTop() > offset_opacity ) { 
                $back_to_top.addClass('qrlite-fade-out');
            }
        });

         $back_to_top.on('click touchstart', function(event){
            // event.preventDefault();
            jQuery('body,html').animate({
                scrollTop: 0 ,
                }, scroll_top_duration
            );
        });

        /**
         * Bio Links Page Sharer panel
         */ 
        function qrlite_sharer_panel_init(){
            var selector = jQuery('.qrlite-panel_button');
            if ( selector.length){
                jQuery(".qrlite-panel_button .qrlite-toggle_sidebar").on( "click", function(){
                    jQuery("div#qrlite-panel").animate({
                        right: "0px"
                    }, "fast");
                    jQuery(".qrlite-panel_button").animate({
                        right: "300px"
                    }, "fast");
                    jQuery(".qrlite-panel_button").toggle();
                    jQuery("body").css("overflow", "hidden");
                });
                jQuery(".qrlite_hide_button").on( "click", function(){
                    jQuery("#qrlite-panel").animate({
                        right: "-300px"
                    }, "fast");
                    jQuery(".qrlite-panel_button").animate({
                        right: "0px"
                    }, "fast");
                    jQuery(".qrlite-panel_button").toggle();
                    jQuery("body").css("overflow", "visible");
                });
            }
        }
        qrlite_sharer_panel_init();


    });

    jQuery(document).ready(function () {
        // grab the initial top offset of the navigation 
        var stickyNavTop = jQuery('.qrlite-tabs').offset().top;
            
        // our function that decides weather the navigation bar should have "fixed" css position or not.
        var stickyNav = function(){
            var scrollTop = jQuery(window).scrollTop(); // our current vertical position from the top
                     
            if (scrollTop > stickyNavTop) { 
                jQuery('.qrlite-tabs').addClass('sticky');
                jQuery('body').addClass('header-sticky');
            } else {
                jQuery('.qrlite-tabs').removeClass('sticky');
                jQuery('body').removeClass('header-sticky'); 
            }
        };

        stickyNav();
        // and run it again every time you scroll
        jQuery(window).on( "scroll", function() {
            stickyNav();
        });  
    });


    //Add QRlite to the body
    jQuery(document).ready(function () {
        var href = window.location.href;
            if(href.indexOf('/qrlite-builder/') > -1){
                jQuery('body').addClass('qrlite-links');
            }
    });

    jQuery(document).ready(function () {
        const box = document.getElementById('qrlite-scroll');

        let isDown = false;
        let startX;
        let startY;
        let scrollLeft;
        let scrollTop;

        box.addEventListener('mousedown', (e) => {
          isDown = true;
          startX = e.pageX - box.offsetLeft;
          startY = e.pageY - box.offsetTop;
          scrollLeft = box.scrollLeft;
          scrollTop = box.scrollTop;
          box.style.cursor = 'grabbing';
        });

        box.addEventListener('mouseleave', () => {
          isDown = false;
          box.style.cursor = 'grab';
        });

        box.addEventListener('mouseup', () => {
          isDown = false;
          box.style.cursor = 'grab';
        });

        document.addEventListener('mousemove', (e) => {
          if (!isDown) return;
          e.preventDefault();
          const x = e.pageX - box.offsetLeft;
          const y = e.pageY - box.offsetTop;
          const walkX = (x - startX) * 1; // Change this number to adjust the scroll speed
          const walkY = (y - startY) * 1; // Change this number to adjust the scroll speed
          box.scrollLeft = scrollLeft - walkX;
          box.scrollTop = scrollTop - walkY;
        });
    });

     // jQuery script to open the modal on image click
    jQuery(document).ready(function () {
        jQuery(".modal-image img").click(function () {
            jQuery("#qrlite-modal-image").attr("src", $(this).attr("src"));
            jQuery("#qrlite-item-img-modal").fadeIn();
        });

        jQuery("#qrlite-item-img-modal").click(function () {
            jQuery(this).fadeOut();
        });
    });

} (jQuery) );