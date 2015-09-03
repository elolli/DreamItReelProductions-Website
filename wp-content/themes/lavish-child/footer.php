<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package lavish
 * @since 1.0.3
 */
?>

<?php get_sidebar( 'bottom' ); ?>


<div class="lavish_footer">
    <div class="container">
        <div style="border-bottom:1px solid #3C3C3C"></div>
        <div class="row">
            <div class="col-md-12">
            <?php
                if (get_theme_mod('footer_social_display') == 1) {
                    include('partials/social-bar.php');
                }
                ?>
            </div>
            <div class="col-md-12">
                <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false,'menu_class' => 'footer', 'fallback_cb' => false) ); ?>
            </div>
            <div class="col-md-12" style = "text-align: center;">
                <img style = "logo " src = "http://localhost:8888/dreamitreelproductions/wp-content/uploads/2015/08/typeface3.png" />

                <div class="copyright">
                <p>
                    <?php esc_attr_e('Copyright &copy;', 'lavish'); ?> <?php _e(date('Y')); ?> <strong><?php echo esc_attr(get_bloginfo('name'));  ?></strong>. <?php esc_attr_e('All rights reserved.', 'lavish'); ?></br>
                    <span style = "margin-top: 10px;" class = "footer_links"> <a href = "#">FAQ</a> <a href = "#">Terms of Service</a></br></span>

                </p>
                </div>
                <span class = "col-xs-12 col-sm-4 social_icons">
                    <a href = "#"><img src = "http://localhost:8888/dreamitreelproductions/wp-content/uploads/2015/08/social-icons_YouTube.png"/></a>
                    <a href = "#"><img src = "http://localhost:8888/dreamitreelproductions/wp-content/uploads/2015/08/social-icons_twitter.png"/></a>
                    <a href = "#"><img src = "http://localhost:8888/dreamitreelproductions/wp-content/uploads/2015/08/social-icon_facebook.png"/></a>
                </span>
            </div>


<?php wp_footer(); ?>
</body>
</html>
