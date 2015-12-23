<?php
update_option( 'siteurl', 'http://dc-dev.jennyo.info' );
update_option( 'home', 'http://dc-dev.jennyo.info' );
  // Pull in parent theme
  add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
  function theme_enqueue_styles() {
      wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

  }
?>