<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

if ( !class_exists('WPB_PCF_Plugin_Settings' ) ):
class WPB_PCF_Plugin_Settings {

    private $settings_api;
    private $settings_name = 'wpb-popup-for-cf7';

    function __construct() {
        $this->settings_api = new WPB_PCF_WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_enqueue_scripts() {
        $screen = get_current_screen();

        $preg_match = preg_match("/_wpb-popup-for-cf7/i", $screen->id);

        if( $preg_match === 1 ){
            $this->settings_api->admin_enqueue_scripts();
        }
    }

    function admin_menu() {
        add_submenu_page( 'wpcf7',
            esc_html__( 'Popup for Contact Form 7', WPB_PCF_FREE_TEXTDOMAIN ),
            esc_html__( 'Popup', WPB_PCF_FREE_TEXTDOMAIN ),
            apply_filters( 'wpcf7_admin_management_page', 'delete_posts' ),
            $this->settings_name,
            array($this, 'plugin_page'),
        );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'wpb_pcf_form_settings',
                'title' => esc_html__( 'Form Settings', WPB_PCF_FREE_TEXTDOMAIN )
            ),
            array(
                'id'    => 'wpb_pcf_btn_settings',
                'title' => esc_html__( 'Button Settings', WPB_PCF_FREE_TEXTDOMAIN )
            ),
            array(
                'id'    => 'wpb_pcf_popup_settings',
                'title' => esc_html__( 'Popup Settings', WPB_PCF_FREE_TEXTDOMAIN )
            ),
        );

        return apply_filters( 'wpb_pcf_settings_sections', $sections );
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {

        $forms      = wp_list_pluck( get_posts(array( 'post_type' => 'wpcf7_contact_form', 'numberposts' => -1 )), 'post_title', 'ID' );

        $settings_fields = array(
            'wpb_pcf_form_settings' => array(
                array(
                    'name'    => 'cf7_form_id',
                    'label'   => esc_html__( 'Select a CF7 Form', WPB_PCF_FREE_TEXTDOMAIN ),
                    'desc'    => ( !empty($forms) ? esc_html__( 'Select a Contact Form 7 form for popup.', WPB_PCF_FREE_TEXTDOMAIN ) : sprintf('<a href="%s">%s</a>', admin_url( 'admin.php?page=wpcf7-new' ), esc_html__( 'Create a Form', WPB_PCF_FREE_TEXTDOMAIN )) ),
                    'type'    => 'select',
                    'options' => $forms,
                ),
            ),
            'wpb_pcf_btn_settings' => array(
                array(
                    'name'              => 'btn_text',
                    'label'             => esc_html__( 'Button Text', WPB_PCF_FREE_TEXTDOMAIN ),
                    'desc'              => esc_html__( 'You can add your own text for the button.', WPB_PCF_FREE_TEXTDOMAIN ),
                    'placeholder'       => esc_html__( 'Contact Us', WPB_PCF_FREE_TEXTDOMAIN ),
                    'type'              => 'text',
                    'default'           => esc_html__( 'Contact Us', WPB_PCF_FREE_TEXTDOMAIN ),
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'    => 'btn_size',
                    'label'   => esc_html__( 'Button Size', WPB_PCF_FREE_TEXTDOMAIN ),
                    'desc'    => esc_html__( 'Select button size. Default: Medium.', WPB_PCF_FREE_TEXTDOMAIN ),
                    'type'    => 'select',
                    'size'    => 'wpb-select-buttons',
                    'default' => 'large',
                    'options' => array(
                        'small'     => esc_html__( 'Small', WPB_PCF_FREE_TEXTDOMAIN ),
                        'medium'    => esc_html__( 'Medium', WPB_PCF_FREE_TEXTDOMAIN ),
                        'large'     => esc_html__( 'Large', WPB_PCF_FREE_TEXTDOMAIN ),
                    )
                ),
                array(
                    'name'    => 'btn_color',
                    'label'   => esc_html__( 'Button Color', WPB_PCF_FREE_TEXTDOMAIN ),
                    'desc'    => esc_html__( 'Choose button color.', WPB_PCF_FREE_TEXTDOMAIN ),
                    'type'    => 'color',
                    'default' => '#ffffff'
                ),
                array(
                    'name'    => 'btn_bg_color',
                    'label'   => esc_html__( 'Button Background', WPB_PCF_FREE_TEXTDOMAIN ),
                    'desc'    => esc_html__( 'Choose button background color.', WPB_PCF_FREE_TEXTDOMAIN ),
                    'type'    => 'color',
                    'default' => '#17a2b8'
                ),
                array(
                    'name'    => 'btn_hover_color',
                    'label'   => esc_html__( 'Button Hover Color', WPB_PCF_FREE_TEXTDOMAIN ),
                    'desc'    => esc_html__( 'Choose button hover color.', WPB_PCF_FREE_TEXTDOMAIN ),
                    'type'    => 'color',
                    'default' => '#ffffff'
                ),
                array(
                    'name'    => 'btn_bg_hover_color',
                    'label'   => esc_html__( 'Button Hover Background', WPB_PCF_FREE_TEXTDOMAIN ),
                    'desc'    => esc_html__( 'Choose button hover background color.', WPB_PCF_FREE_TEXTDOMAIN ),
                    'type'    => 'color',
                    'default' => '#138496'
                ),
            ),
            'wpb_pcf_popup_settings' => array(
                array(
                    'name'      => 'form_style',
                    'label'     => esc_html__( 'Enable Form Style', WPB_PCF_FREE_TEXTDOMAIN ),
                    'desc'      => esc_html__( 'Check this to enable the form style.', WPB_PCF_FREE_TEXTDOMAIN ),
                    'type'      => 'checkbox',
                    'default'   => 'on',
                ),
                array(
                    'name'              => 'popup_width',
                    'label'             => esc_html__( 'Popup Width', WPB_PCF_FREE_TEXTDOMAIN ),
                    'desc'              => esc_html__( 'Popup window width, Can be in px or %. The default width is 500px.', WPB_PCF_FREE_TEXTDOMAIN ),
                    'type'              => 'numberunit',
                    'default'           => 500,
                    'default_unit'      => 'px',
                    'sanitize_callback' => 'floatval',
                    'options' => array(
                        'px'            => esc_html__( 'Px', WPB_PCF_FREE_TEXTDOMAIN ),
                        '%'    => esc_html__( '%', WPB_PCF_FREE_TEXTDOMAIN ),
                    )
                ),
            ),
        );

        return apply_filters( 'wpb_pcf_settings_fields', $settings_fields );
    }

    function plugin_page() {
        echo '<div id="wpb-pcf-settings" class="wrap wpb-plugin-settings-wrap">';

        settings_errors();
        
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';

        do_action( 'wpb_pcf_after_settings_page' );
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;