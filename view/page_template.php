<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html style="margin-top: 0 !important;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php wp_head(); ?>
    </head>
    <body>
        <?php 
            add_filter( 'show_admin_bar', '__return_false' );
        ?>

        <div class="qrlite-bio-links-page qrlite-bio-links-page-<?php the_ID(); ?>">
            <!-- Header -->
            <div class="qrlite-bio-header">
                <?php do_action('qrlite_page_header', get_the_ID()); ?>
            </div>

            <!-- Content -->
            <div class="qrlite-bio-links-page-inner">
                <?php do_action('qrlite_page_content', get_the_ID()); ?>
            </div>

            <!-- Footer -->
            <?php do_action('qrlite_page_footer', get_the_ID()); ?>
        </div>

        <?php wp_footer(); ?>
    </body>
</html>
