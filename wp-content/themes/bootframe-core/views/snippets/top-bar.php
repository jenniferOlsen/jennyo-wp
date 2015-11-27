<div class="smartlib-top-navbar">
    <div class="container">
        <div class="row">

            <div class="col-xs-7 col-md-9">

                    <?php



                    //If WPML is installed and active
                    
                    if ( class_exists('SitePress') ) {

                        ?>
                        <nav class="nav nav-pills nav-top smartlib-language-menu">
                            <p><span class="smartlib-label-inside-menu"><?php _e('Languages', 'bootframe-core') ?>: </span></p>
                            <?php  do_action('icl_language_selector'); ?>
                        </nav>
                    <?php

                    }

                    if(function_exists('pll_the_languages')){
                        ?>
                        <nav class="nav nav-pills nav-top smartlib-language-menu">
                            <p><span class="smartlib-label-inside-menu"><?php _e('Languages', 'bootframe-core') ?>: </span></p>
                            <ul class="smartlib-polylang-languages-list"><?php  pll_the_languages(); ?></ul>
                        </nav>
                    <?php
                    }


                    ?>

                    <?php
                    if ( has_nav_menu( 'top_pages' ) ) {
                        wp_nav_menu(
                            array( 'theme_location' => 'top_pages',
                                'menu_class' => 'nav nav-pills nav-top hidden-xs hidden-sm hidden-md',
                            ) );
                    }
                    ?>

                    <p class="smartlib-top-bar-info"><?php smartlib_get_section_info_text('header'); ?></p>

            </div>
            <div class="col-xs-5 col-md-3 hidden-xs">

<?php do_action('smartlib_social_links', 'top') ?>
            </div>


        </div>
    </div>
</div>