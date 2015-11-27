<footer class="smartlib-footer-area ">
    <!--Footer sidebar-->

                <?php do_action('smartlib_footer_sidebar', 'default'); ?>

    <!--END Footer sidebar-->
    <!--Footer bottom - customizer-->
    <section class="smartlib-content-section smartlib-bottom-footer">
        <div class="container">

            <div class="row">

                <div class="col-lg-6">
                    <p><?php smartlib_get_section_info_text('footer'); ?></p>
                </div>
                <div class="col-lg-6">
                    <?php do_action('smartlib_social_links', 'footer') ?>
                </div>
            </div>
        </div>
    </section>
    <!--END Footer bottom - customizer-->
</footer>

<?php
do_action('smartlib_after_content');
wp_footer();

?>

</body>
</html>
