<?php

class Smartlib_Features
{

    static $instance;
    public $default_config;

    public function __construct($conObj)
    {
        self::$instance =& $this;

        $this->default_config = $conObj;

        //add extra fields to category edit form hook
        add_action( 'edit_category_form_fields', array($this, 'smartadapt_extra_category_fields') );
        add_action( 'category_add_form_fields', array($this, 'smartadapt_extra_category_fields') );

        // save extra category extra fields hook
        add_action( 'edited_category',  array($this,'save_extra_category_fileds') );
        add_action( 'created_category',  array($this,'save_extra_category_fileds') );
    }

    //add extra fields to category edit form callback function
    public function smartadapt_extra_category_fields( $tag ) { //check for existing featured ID
        $cat_extra_data['smartlib_layout_category'] = 0;
        if(is_object($tag)){
            $term_id        = $tag->term_id;
            $cat_extra_data = get_option( 'category_' . $term_id );
        }

        ?>
        <fieldset class="smartadapt-fieldset">

            <h4 style="margin-bottom: 40px"><?php _e( 'Category layout', 'bootframe-core' ); ?></h4>
            <div class="smartadapt-form-proversion-info-outer">

                <div class="smartadapt-form-block">
                    <div class="smartadapt-form-line">
                        <label for="cat_extra_data_0" class="smartadapt-radio-label"><?php _e( 'Default Settings', 'smartadapt' ); ?></label><input type="radio" name="cat_extra_data[smartlib_layout_category]" id="cat_extra_data_0" style="float: left; width: auto" value="0" <?php echo $cat_extra_data['smartlib_layout_category'] == 0 ? 'checked=checked' : ''; ?>><br />
                    </div>
                    <div class="smartadapt-form-line">
                        <label for="cat_extra_data_1 class="smartadapt-radio-label"><?php _e( 'No Sidebar', 'smartadapt' ); ?></label><input type="radio" name="cat_extra_data[smartlib_layout_category]" id="cat_extra_data_1" style="float: left; width: auto" value="1" <?php echo $cat_extra_data['smartlib_layout_category'] == 1 ? 'checked=checked' : ''; ?>><br />
                    </div>

                </div>
            </div>
        </fieldset>
    <?php
    }

    public function save_extra_category_fileds( $term_id ) {

        if ( isset( $_POST['cat_extra_data'] ) ) {
            $term_id  = $term_id;
            $cat_meta = get_option( 'category_' . $term_id );
            $cat_keys = array_keys( $_POST['cat_extra_data'] );
            foreach ( $cat_keys as $key ) {
                if ( isset( $_POST['cat_extra_data'][$key] ) ) {
                    $cat_meta[$key] = $_POST['cat_extra_data'][$key];
                }
            }
            //save the option array
            if ( isset( $cat_meta ) && ! update_option( 'category_' . $term_id, $cat_meta ) ) add_option( 'category_' . $term_id, $cat_meta );
        }
    }


}





