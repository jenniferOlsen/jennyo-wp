<?php


class __SMARTLIB_HELPERS {


    static function conditional_is_single()
    {
        global $post;
        return is_single();
    }

    static function conditional_is_page()

    {
        global $post;
        return is_page();
    }

    static function conditional_navbar_is_fixed(){
        $option = get_theme_mod('smartlib_fixed_navbar_default', '2');

        if($option=='1'){
            return true;
        }else{
            return false;
        }

    }

    /**
     * Check if native site icon exists
     * @return bool
     */

    static function conditional_has_site_icon(){

        if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {

            return true;
        }

        return false;

    }
}