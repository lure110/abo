<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

/**
 * Shortcode
 */

class WPB_PCF_Shortcode_Handler {

    public function __construct() {
        add_shortcode( 'wpb-pcf-button', array( $this, 'contact_form_button_shortcode' ) );
    }

    /**
     * Shortcode handler
     *
     * @param  array  $atts
     * @param  string  $content
     *
     * @return string
     */
    public function contact_form_button_shortcode( $atts, $content = '' ) {

        ob_start();
        wpb_pcf_contact_form_button( $atts );
        $content .= ob_get_clean();

        return $content;
    }
}


/**
 * Generic function for displaying docs
 *
 * @param  array   $args
 *
 * @return void
 */
function wpb_pcf_contact_form_button( $args = array() ) {
    $defaults = array(
        'id'            => wpb_pcf_get_option( 'cf7_form_id', 'wpb_pcf_form_settings' ),
        'post_id'       => get_the_ID(),
        'class'         => '',
        'text'          => wpb_pcf_get_option( 'btn_text', 'wpb_pcf_btn_settings', esc_html__( 'Contact Us', WPB_PCF_FREE_TEXTDOMAIN ) ),
        'btn_size'      => wpb_pcf_get_option( 'btn_size', 'wpb_pcf_btn_settings', 'large' ),
        'form_style'    => ( wpb_pcf_get_option( 'form_style', 'wpb_pcf_popup_settings', 'on' ) == 'on' ? true : false ),
        'width'         => wpb_pcf_get_option( 'popup_width', 'wpb_pcf_popup_settings', 500 ) . wpb_pcf_get_option( 'popup_width_unit', 'wpb_pcf_popup_settings', 'px' ),
    );

    $args = wp_parse_args( $args, $defaults );
    
    if ( defined( 'WPCF7_PLUGIN' ) ) {
        if( $args['id'] ){
            echo apply_filters('wpb_pcf_button_html', sprintf( '<button data-id="%s" data-post_id="%s" data-form_style="%s" data-width="%s" class="wpb-pcf-form-fire wpb-pcf-btn-%s wpb-pcf-btn wpb-pcf-btn-default%s">%s</button>', esc_attr($args['id']), esc_attr($args['post_id']), esc_attr($args['form_style']), esc_attr($args['width']), esc_attr($args['btn_size']) ,( $args['class'] ? esc_attr( ' ' . $args['class']) : '' ), esc_html( $args['text'] ) ), $args);
        }else{
            printf( '<div class="wpb-pcf-alert wpb-pcf-alert-inline wpb-pcf-alert-error">%s</div>', esc_html__( 'Form id required.', WPB_PCF_FREE_TEXTDOMAIN ) );
        }
    }else{
        printf( '<div class="wpb-pcf-alert wpb-pcf-alert-inline wpb-pcf-alert-error">%s</div>', esc_html__( 'Popup for Contact Form 7 required the Contact Form 7 plugin to work with.', WPB_PCF_FREE_TEXTDOMAIN ) );
    }
}