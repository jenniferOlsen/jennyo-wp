<?php

/**
 Class for genearating custom styles
 */
class Smartlib_Custom_Styles{

	static $default_config;
	static $instance;

	function __construct($config){

		self::$default_config = $config;
	}

	function header_css_output(){

		 $ouput_css ='';
     $css_propeties_array = self::$default_config->css_propeties_array;
		if(count($css_propeties_array)>0){
			foreach($css_propeties_array as $property_key => $property_values){

				$css_property = get_theme_mod($property_key);
				if(strlen($css_property)>0){

						$unit = isset($property_values['unit'])?$property_values['unit']:'';//add px support from slider

						$ouput_css .= $property_values['selectors'] .'{'.$property_values['property'].':'.$css_property.$unit.'}';
				}

			}
		}
    //first register and enqueue the actual 'smartlib_main' stylesheet.

		/*add layout settings*/
   	    $ouput_css .= $this->layout_width_css();
		$output_header_style = $this->navbar_styles();

		wp_add_inline_style( 'smartlib_main',  $ouput_css.$output_header_style );


	}

	public static function getInstance($config) {
		if(self::$instance === null) {
			self::$instance = new Smartlib_Custom_Styles($config);
		}
		return self::$instance;
	}

	/*
	 * Add Google Fonts Header
	 */
	public static function header_fonts_output(){
    $smartlib_fonts = self::$default_config->smartlib_fonts;
		$google_fonts = Kirki_Fonts::get_google_fonts();


		$atached_fonts_array = array();

		foreach($smartlib_fonts as $key_font => $name_font){
            $option =  get_theme_mod($key_font);
					if($option){
                        $atached_fonts_array[$key_font] = get_theme_mod($key_font);
                    }

		}

		$atached_unique_fonts_array = array_unique($atached_fonts_array);

		foreach($atached_unique_fonts_array as $font){
			if(array_key_exists($font, $google_fonts)){

				$variants_string = isset($google_fonts[$font]['variants'])? ':'. implode(',', $google_fonts[$font]['variants']):'';
				$subsets_string = isset($google_fonts[$font]['subsets'])? '&subset='. implode(',', $google_fonts[$font]['subsets']):'';

				$font_family =  str_replace(' ', '+', $font);

				$font_face_url = '//fonts.googleapis.com/css?family='.$font_family.$variants_string.$subsets_string;
			  $font_face = "<link href='".$font_face_url."' rel='stylesheet' type='text/css'>";
			  echo  $font_face;
			}
		}
	}


	/*
	 * Prepare CSS with sizes of containers
	 */
	private function layout_width_css(){

		//get default layout sizes with keys
		$layout_sizes = self::$default_config->layout_sizes;
		$layout_settings = array();
		$layout_values = array();


		if(count($layout_sizes)>0){

			/*
			 * prepare first array of set and default sizes
			 */

			foreach($layout_sizes as $key_value=>$container_array){

				$size = '';

				if(strlen($container_array['customizer_key'])>0)
				$size = get_theme_mod($container_array['customizer_key']);

					if(strlen($size)>0){
						$layout_settings[$key_value] = $size;//get size from get_theme_mod
					}else{
						$layout_settings[$key_value] =$container_array['size'];//get default value
					}

			}

			/*
			 * prepare array with all calculated values
			 * based on layout_sizes config array
			 * if size should be calculated just do it
			 */
			foreach($layout_settings as $key => $size){
						if(is_array($size)){
							$returned_size = 0;
							$i = 0;
							foreach($size as $value){
								if($i==0){
									$returned_size=(int)$layout_settings[$value]; //first  param: minuend
								}else{
									$returned_size=(int)$returned_size - (int)$layout_settings[$value];//second param: subtrahend
								}
								$i++;

							}
							$layout_values[$key] = $returned_size;
						}else{
							$layout_values[$key] =  $size;
						}
			}
			$ouput_css = '@media (min-width:'.$layout_sizes['layout']['size'].'px) {';

				foreach($layout_sizes as $key_value=>$container_array){

					$ouput_css .= $container_array['container'].'{width:'.$layout_values[$key_value].'px}';

				}

			$ouput_css .='}';

			return $ouput_css ;
		}
	}

	/*
	 * Display Man Navbar CSS
	 */
	private function navbar_styles($type='default'){
		$navbar_background = get_theme_mod('smartlib_background_navbar_'.$type);
		$background_opacity = get_theme_mod('smartlib_background_navbar_opacity_'.$type, '1');

		$output_css = '';
		if(strlen($navbar_background)> 0){
			$output_css .= '.smartlib-bottom-navbar{background:'.$this->background_rgba($navbar_background, $background_opacity).'}';
		}

		return $output_css;
	}


   /*
    * returns rgba bacground string from hex color and opacity
    */
	private function background_rgba( $colour, $opacity ='1' ) {
		if ( $colour[0] == '#' ) {
			$colour = substr( $colour, 1 );
		}
		if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
			return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );
		return 'rgba('.$r.','.$g.','.$b.','.$opacity.')';

	}
}