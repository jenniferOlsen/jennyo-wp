<?php
/**
 * Site Origin Page Builder Integration
 */


/*
 * If plugin is instaled
 */

if (function_exists('siteorigin_panels_init')) {
    add_filter('siteorigin_panels_row_style_fields', 'smartlib_row_style_fields');

    add_filter('siteorigin_panels_row_style_attributes', 'smartlib_row_style_attributes', 10, 2);
    add_filter('siteorigin_panels_row_style_attributes', 'smartlib_row_reset_style_attributes', 10, 2);

    add_filter('siteorigin_panels_widget_style_attributes', 'smartlib_widget_style_attributes', 10, 2);

    //add new cell fields

    add_filter('siteorigin_panels_widget_style_fields', 'smartlib_widget_style_fields', 10, 2);

    add_filter('siteorigin_panels_before_row', 'smartlib_add_html_before_row', 10, 3);
    add_filter('siteorigin_panels_after_row', 'smartlib_add_html_after_row', 10, 3);


}
/**
 * Add new widget fields
 * @param $fields
 * @return mixed
 */

function smartlib_widget_style_fields($fields)
{
    $fields['half_column'] = array(
        'name' => __('Half Column', 'bootframe-core'),
        'type' => 'checkbox',
        'group' => 'attributes',
        'description' => __('Use this in the fluid section to force widget display in column.', 'bootframe-core'),
        'priority' => 1,
    );

    return $fields;
}

/**
 * Add new row fields
 * @param $fields
 * @return mixed
 */

function smartlib_row_style_fields($fields)
{
    $fields['parllax_sroll'] = array(
        'name' => __('Parallax scrolling ', 'bootframe-core'),
        'type' => 'checkbox',
        'group' => 'design',
        'description' => __('Add parallax scroll effect', 'bootframe-core'),
        'priority' => 5,
    );

    $fields['overlay_background_color'] = array(
        'name' => __('Overlay background color', 'bootframe-core'),
        'type' => 'color',
        'group' => 'design',
        'description' => __('Adds colored layer with some transparency over background image', 'bootframe-core'),
        'priority' => 6,
    );

    /*
    $fields['fluid_section'] = array(
        'name' => __('Fluid Row', 'bootframe-core'),
        'type' => 'checkbox',
        'group' => 'attributes',
        'description' => __('Use fluid row for a full width container, spanning the entire width of your viewport.', 'bootframe-core'),
        'priority' => 1,
    );
    */

    $fields['no_padding_columns'] = array(
        'name' => __('No Padding Columns', 'bootframe-core'),
        'type' => 'checkbox',
        'group' => 'attributes',
        'description' => __('All columns in this row have no padding.', 'bootframe-core'),
        'priority' => 3,
    );


    $fields['dark_section'] = array(
        'name' => __('Dark Section', 'bootframe-core'),
        'type' => 'checkbox',
        'group' => 'design',
        'description' => __('Section with dark background and light text', 'bootframe-core'),
        'priority' => 1,
    );

    return $fields;
}

/**
 * Add new row attributes
 * @param $attributes
 * @param $args
 * @return array
 */
function smartlib_row_style_attributes($attributes, $args)
{


    if (isset($attributes['class']))
        array_push($attributes['class'], 'smartlib-widgets-panel-row');

    if (isset($args) && is_array($args) && isset($attributes) && is_array($attributes)) {
        if (!empty($args['fluid_section'])) {
            array_push($attributes['class'], 'smartlib-full-width-section');
        }


        if (!empty($args['no_padding_columns'])) {
            array_push($attributes['class'], 'smartlib-no-padding-row');
        }

        if (!empty($args['parllax_sroll']) && smartlib_check_row_type($args)) {
            $attributes['data-type'] = array();
            array_push($attributes['data-type'], 'background');

            array_push($attributes['class'], 'smartlib-paralax-container');
        }
        if (!empty($args['overlay_background_color']) && smartlib_check_row_type($args)) {
            $attributes['data-overlay-color'] = array();
            array_push($attributes['class'], 'smartlib-overlay-over-background');
            array_push($attributes['data-overlay-color'], $args['overlay_background_color']);
        }

        if (!empty($args['dark_section'])) {
            array_push($attributes['class'], 'smartlib-dark-section');
        }
    }

    return $attributes;
}

/**
 * Add new widget atributes in panel
 * @param $attributes
 * @param $args
 * @return mixed
 */
function smartlib_widget_style_attributes($attributes, $args)
{

    //array_push($attributes['class'],'panel');
    //array_push($attributes['class'],'widget');
    //array_push($attributes['class'],'smartlib-widget');


    if (!empty($args['half_column'])) {
        array_push($attributes['class'], 'half-content-container');
    }

    return $attributes;
}

/**
 * If row is full-stretched add new container
 * @param $panels_data_grid
 * @param $grid_attributes
 * @return string
 */
function smartlib_add_html_before_row($panels_data_grid, $grid_attributes)
{


    $arguments = array();
    $arguments['class'] = array();
    $arguments['style'] = '';

    $section_class = 'smartlib-full-strech-section';
    $section_attributes = '';

    //get all style attrubutes from $grid_attributes
    $grid_args = $grid_attributes['style'];


    //merge additional param - prevent from reset
    $args = array_merge($grid_args, array('not_remove_attributes' => 1));

    $style = apply_filters('siteorigin_panels_row_style_attributes', $arguments, $args);

    $style_string = isset($style['style']) ? ' style="' . $style['style'] . '"' : '';

    /*Check smartlib additional attrubutes*/
    $section_class .= isset($grid_args['dark_section'])&&!empty($grid_args['dark_section']) ? ' smartlib-dark-section' : '';
    $section_class .= isset($grid_args['parllax_sroll'])&&!empty($grid_args['parllax_sroll']) ? ' smartlib-paralax-container' : '';
    $section_class .= isset($grid_args['overlay_background_color'])&&!empty($grid_args['overlay_background_color']) ? ' smartlib-overlay-over-background' : '';


    $section_attributes .= isset($grid_args['parllax_sroll'])&&!empty($grid_args['parllax_sroll']) ? ' data-type="background"' : '';
    $section_attributes .= isset($grid_args['overlay_background_color'])&&!empty($grid_args['overlay_background_color']) ? ' data-overlay-color="' . $grid_args['overlay_background_color'] . '"' : '';

    if (isset($grid_attributes['style']['row_stretch'])) {
        if ($grid_attributes['style']['row_stretch'] == 'full-stretched') {
            return '<div class="' . $section_class . '"' . $style_string . $section_attributes . '>';
        }
    }
}

/**
 *
 * If row is full-stretched add new container - close tag
 * @param $panels_data_grid
 * @param $grid_attributes
 * @return string
 */

function smartlib_add_html_after_row($panels_data_grid, $grid_attributes)
{

    if (isset($grid_attributes['style']['row_stretch'])) {
        if ($grid_attributes['style']['row_stretch'] == 'full-stretched') {
            return '</div>';
        }
    }
}

/**
 * If row is full-stretched reset style atributes in panel-row
 * @param $attributes
 * @param $args
 * @return mixed
 */
function smartlib_row_reset_style_attributes($attributes, $args)
{

    if (isset($attributes['data-stretch-type']) && $attributes['data-stretch-type'] == 'full-stretched' && !isset($args['not_remove_attributes'])) {
        $attributes['style'] = array();
    }


    return $attributes;
}

/**
 * Check type of row - return true if full-streched
 * @param $args
 * @return bool
 */
function smartlib_check_row_type($args)
{
    return (bool)(isset($args['style']['row_stretch']) && $args['style']['row_stretch'] != 'full-stretched');
}


