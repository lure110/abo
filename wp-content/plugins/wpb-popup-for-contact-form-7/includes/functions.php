<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

/* -------------------------------------------------------------------------- */
/* Get settings option 
/* -------------------------------------------------------------------------- */

if( !function_exists('wpb_pcf_get_option') ){
    function wpb_pcf_get_option( $option, $section, $default = '' ) {
 
        $options = get_option( $section );
     
        if ( isset( $options[$option] ) ) {
            return $options[$option];
        }
     
        return $default;
    }
}



/**
 * Adding the Popup Button using action hook
 */

add_action( 'wpb_pcf_contact_form_button', 'wpb_pcf_contact_form_button', 10 );


/**
 * CF7 Shortcodes
 */

add_action( 'wpcf7_init', 'wpb_pcf_cf7_add_form_tag_for_post_title' );
 
function wpb_pcf_cf7_add_form_tag_for_post_title() {
    wpcf7_add_form_tag( 'post_title', 'wpb_pcf_cf7_post_title_tag_handler' ); // "clock" is the type of the form-tag
}
 
function wpb_pcf_cf7_post_title_tag_handler( $tag ) {
    if(isset($_POST['wpb_pcf_post_id'])){
        return '<input type="hidden" name="post_title" value="'. get_the_title( (int) $_POST['wpb_pcf_post_id'] ).'">';
    }
}


/**
 * Premium Links
 */

add_action( 'wpb_pcf_after_settings_page', function(){
    ?>
    <div class="wpb_pcf_pro_features wrap">
        <h3>Premium Features:</h3>
        <ul>
            <li>Popup buttons for the Contact Form 7 forms.</li>
            <li>Show the buttons using ShortCodes and action hooks.</li>
            <li>Show different popup buttons on different locations with different forms.</li>
            <li>Advanced settings for button and popup style configuration.</li>
            <li>Elementor widget for easy use with the Elementor page builder.</li>
            <li>Advanced popup buttons generator, for adding multiple different customized popup buttons.</li>
            <li>The popup buttons can be shown to any action hooks.</li>
            <li>Beautiful design for the forms that show in the popup.</li>
            <li>RTL Support and mobile responsive.</li>
            <li>Easy to use and customize.</li>
            <li>Online documentation and video tutorials.</li>
            <li>Quality support, and free installation if required.</li>
            <li>Tested with hundreds of popular themes and plugins.</li>
            <li>Tested with the Gutenberg Editor.</li>
            <li>Regular updates.</li>
        </ul>
        <div class="wpb-submit-button">
            <a class="button button-primary button-pro" href="https://wpbean.com/?p=34195" target="_blank">Buy PRO Version</a>
        </div>
    </div>

    <div class="wpb_pcf_pro_features wrap">
        <h3>Showing the Button:</h3>
        <p>The Popup button can be shown using different methods. Example: Using a ShortCode, Calling a PHP function, Adding our action hook, Add our PHP function to your site’s hook.</p>
        <p>Just this ShortCode where you want to show the button that will show the popup. This ShortCode has some parameters that allow you to customize it. Check the <a target="_blank" href="https://docs.wpbean.com/docs/popup-for-contact-form-7/showing-the-button/shortcode-parameters/">ShortCode Parameters</a> section for more about it.</p>
        <p>Copy this ShortCode and add where you want to show the button.</p>
        <pre class="wp-block-code"><code>[wpb-pcf-button]</code></pre>
        <div class="wpb-submit-button">
            <a class="button button-primary button-pro" href="https://docs.wpbean.com/docs/popup-for-contact-form-7/showing-the-button/" target="_blank">Detail Documentation</a>
        </div>
    </div>
    <?php
} );