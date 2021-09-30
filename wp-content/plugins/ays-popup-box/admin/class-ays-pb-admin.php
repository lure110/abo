<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Ays_Pb
 * @subpackage Ays_Pb/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ays_Pb
 * @subpackage Ays_Pb/admin
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Ays_Pb_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $popupbox_obj;
    private $settings_obj;
    private $popup_categories_obj;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version )
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_filter('set-screen-option', [__CLASS__, 'set_screen'], 10, 3);
        $per_page_array = array(
            'popupboxes_per_page',
        );
        foreach($per_page_array as $option_name){
            add_filter('set_screen_option_'.$option_name, array(__CLASS__, 'set_screen'), 10, 3);
        }
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook_suffix) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ays_Pb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ays_Pb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        
        // You need styling for the datepicker. For simplicity I've linked to the jQuery UI CSS on a CDN.
 
        wp_enqueue_style( $this->plugin_name.'-icon', plugin_dir_url( __FILE__ ) . 'css/ays-pb-icon.css', array(), $this->version, 'all' );
        
        if(false === strpos($hook_suffix, $this->plugin_name))
            return;
        wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' );

        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'ays_pb_font_awesome', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'ays_pb_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pb_animate', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'ays-pb-select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ays-pb-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style($this->plugin_name.'-jquery-datetimepicker', plugin_dir_url(__FILE__) . 'css/jquery-ui-timepicker-addon.css', array(), $this->version, 'all');
        wp_enqueue_style('ays_code_mirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook_suffix) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ays_Pb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ays_Pb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        $wp_post_types = get_post_types('', 'objects');
        $all_post_types = array();
        foreach ($wp_post_types as $pt){
            $all_post_types[] = array(
                $pt->name,
                $pt->label
            );
        }

        if (false !== strpos($hook_suffix, "plugins.php")){
            
            wp_enqueue_script( 'sweetalert-js', '//cdn.jsdelivr.net/npm/sweetalert2@7.26.29/dist/sweetalert2.all.min.js', array('jquery'), $this->version, true );
            wp_enqueue_script($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), $this->version, true);
            wp_localize_script($this->plugin_name . '-admin', 'popup_box_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
        }

        if(false === strpos($hook_suffix, $this->plugin_name))
            return;
        wp_enqueue_script( 'jquery-effects-core' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_media();
		wp_enqueue_script( "ays_pb_popper", 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( "ays_pb_bootstrap", 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( 'select2js', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js', array('jquery'), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ays-pb-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name . 'custom-dropdown-adapter', plugin_dir_url( __FILE__ ) . 'js/ays-select2-dropdown-adapter.js', array('jquery'), $this->version, true );
        wp_localize_script($this->plugin_name, 'pb', array(
            'ajax'           => admin_url('admin-ajax.php'),
            'post_types'     => $all_post_types,
        ));
        wp_enqueue_script( $this->plugin_name."-jquery.datetimepicker.js", plugin_dir_url( __FILE__ ) . 'js/jquery-ui-timepicker-addon.js', array( 'jquery' ), $this->version, true );

        wp_enqueue_script( $this->plugin_name.'-wp-color-picker-alpha', plugin_dir_url( __FILE__ ) . 'js/wp-color-picker-alpha.min.js',array( 'wp-color-picker' ),$this->version, true );

        $color_picker_strings = array(
            'clear'            => __( 'Clear', $this->plugin_name ),
            'clearAriaLabel'   => __( 'Clear color', $this->plugin_name ),
            'defaultString'    => __( 'Default', $this->plugin_name ),
            'defaultAriaLabel' => __( 'Select default color', $this->plugin_name ),
            'pick'             => __( 'Select Color', $this->plugin_name ),
            'defaultLabel'     => __( 'Color value', $this->plugin_name ),
        );
        wp_localize_script( $this->plugin_name.'-wp-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );
	}


    // Code Mirror

        function codemirror_enqueue_scripts($hook) {
        if (false === strpos($hook, $this->plugin_name)){
            return;
        }
        if(function_exists('wp_enqueue_code_editor')){
            $cm_settings['codeEditor'] = wp_enqueue_code_editor(array(
                'type' => 'text/css',
                'codemirror' => array(
                    'inputStyle' => 'contenteditable',
                    'theme' => 'cobalt',
                   
                )
            ));

            wp_enqueue_script('wp-theme-plugin-editor');
            wp_localize_script('wp-theme-plugin-editor', 'cm_settings', $cm_settings);
        
            wp_enqueue_style('wp-codemirror');
        }
    }
    



    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */

    public function add_plugin_admin_menu() {
        
        add_menu_page( 
            __('Popup Box'),
            __('Popup Box'),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page'),
            plugin_dir_url(__FILE__) . '/assets/icons/icon.png',
            6
        );
    }
    public function add_plugin_popups_submenu() {

        $hook_popupbox = add_submenu_page(
            $this->plugin_name,
            __('Popups', $this->plugin_name),
            __('Popups', $this->plugin_name),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page')
        );

        add_action( "load-$hook_popupbox", array( $this, 'screen_option_popupbox' ) );
    }

    public function add_plugin_categories_submenu() {

        $hook_categories = add_submenu_page(
            $this->plugin_name,
            __('Categories', $this->plugin_name),
            __('Categories', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-categories',
            array($this, 'display_plugin_categories_page')
        );

        add_action( "load-$hook_categories", array( $this, 'screen_option_categories' ) );
    }

    public function add_plugin_pro_features_submenu(){
        add_submenu_page(
            $this->plugin_name,
            __('PRO Features', $this->plugin_name),
            __('PRO Features', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-pro-features',
            array($this, 'pb_display_plugin_pro_features_page')
        );
    }

    public function add_plugin_reports_submenu(){
        $results_text = __('Reports', $this->plugin_name);
        $hook_reports = add_submenu_page(
            $this->plugin_name,
            $results_text,
            $results_text,
            'manage_options',
            $this->plugin_name . '-reports',
            array($this, 'display_plugin_results_page')
        );
    }

    public function add_plugin_export_import_submenu(){
        $results_text = __('Export/Import', $this->plugin_name);
        $hook_export_import = add_submenu_page(
            $this->plugin_name,
            $results_text,
            $results_text,
            'manage_options',
            $this->plugin_name . '-export-import',
            array($this, 'display_plugin_export_import_page')
        );
    }

    public function add_plugin_subscribes_submenu(){
        $results_text = __('Subscribes', $this->plugin_name);
        $hook_subscribes = add_submenu_page(
            $this->plugin_name,
            $results_text,
            $results_text,
            'manage_options',
            $this->plugin_name . '-subscribes',
            array($this, 'display_plugin_subscribes_page')
        );
    }


    public function add_plugin_settings_submenu(){
        $hook_settings = add_submenu_page( $this->plugin_name,
            __('General Settings', $this->plugin_name),
            __('General Settings', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_plugin_settings_page') 
        );
        add_action("load-$hook_settings", array($this, 'screen_option_settings'));
    }

    public function add_plugin_how_to_use_submenu(){
        $hook_how_to_use = add_submenu_page( $this->plugin_name,
            __('How to use', $this->plugin_name),
            __('How to use', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-how-to-use',
            array($this, 'display_plugin_how_to_use_page') 
        );
        add_action("load-$hook_how_to_use", array($this, 'screen_option_settings'));
    }

    public function add_plugin_featured_plugins_submenu(){
        add_submenu_page( $this->plugin_name,
            __('Our Products', $this->plugin_name),
            __('Our Products', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-featured-plugins',
            array($this, 'display_plugin_featured_plugins_page') 
        );
    }

    public function admin_menu_styles(){

        echo "<style>
            .ays_menu_badge{
                color: #fff;
                display: inline-block;
                font-size: 10px;
                line-height: 14px;
                text-align: center;
                background: #ca4a1f;
                margin-left: 5px;
                border-radius: 20px;
                padding: 2px 5px;
            }

            #adminmenu a.toplevel_page_ays-pb div.wp-menu-image img {
                width: 32px;
                padding: 1px 0 0;
                transition: .3s ease-in-out;
            }
        </style>";

    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links( $links ) {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
            '<a href="https://ays-demo.com/popup-box-plugin-free-demo/" target="_blank">' . __('Demo', $this->plugin_name) . '</a>',
            '<a href="https://ays-pro.com/wordpress/popup-box" target="_blank" style="color:red; font-weight: bold;">' . __('Buy Now', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );

    }

    public function add_plugin_row_meta($meta, $file) {

        if ($file == AYS_PB_BASENAME) {
            $meta[] = '<a href="https://wordpress.org/support/plugin/ays-popup-box/" target="_blank">' . esc_html__( 'Free Support', $this->plugin_name ) . '</a>';
        }

        return $meta;
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page() {
		$action = (isset($_GET['action'])) ? sanitize_text_field( $_GET['action'] ) : '';
		
        switch ( $action ) {
            case 'add':
                include_once( 'partials/actions/ays-pb-admin-actions.php' );
                break;
            case 'edit':
                include_once( 'partials/actions/ays-pb-admin-actions.php' );
                break;
            default:
                include_once( 'partials/ays-pb-admin-display.php' );
        }
    }

    public function display_plugin_categories_page(){
        $action = (isset($_GET['action'])) ? sanitize_text_field($_GET['action']) : '';

        switch ($action) {
            case 'add':
                include_once('partials/actions/ays-pb-categories-actions.php');
                break;
            case 'edit':
                include_once('partials/actions/ays-pb-categories-actions.php');
                break;
            default:
                include_once('partials/ays-pb-categories-display.php');
        }
    }

    public function pb_display_plugin_pro_features_page() {
        include_once 'partials/features/popup-box-pro-features-display.php';
    }

    public function display_plugin_settings_page(){        
        include_once('partials/settings/popup-box-settings.php');
    }

    public function display_plugin_how_to_use_page(){        
        include_once('partials/how-to-use/ays-pb-how-to-use.php');
    }

    public function display_plugin_results_page(){
        include_once('partials/reports/ays-pb-reports-display.php');
    }
    public function display_plugin_export_import_page(){
        include_once('partials/export-import/ays-pb-export-import.php');
    }
    public function display_plugin_subscribes_page(){
        include_once('partials/subscribes/ays-pb-subscribes-display.php');
    }
    public function display_plugin_featured_plugins_page(){
        include_once('partials/features/ays-pb-plugin-featured-display.php');
    }
	
	public static function set_screen( $status, $option, $value ) {
        return $value;
    }
	
	public function screen_option_popupbox() {
		$option = 'per_page';
		$args   = [
			'label'   => __('PopupBox', $this->plugin_name),
			'default' => 20,
			'option'  => 'popupboxes_per_page'
		];

		add_screen_option( $option, $args );
		$this->popupbox_obj = new Ays_PopupBox_List_Table($this->plugin_name);
        $this->settings_obj = new Ays_PopupBox_Settings_Actions($this->plugin_name);
	}

    public function screen_option_categories() {
        $option = 'per_page';
        $args   = [
            'label'   => __('Categories', $this->plugin_name),
            'default' => 20,
            'option'  => 'popup_categories_per_page'
        ];

        add_screen_option($option, $args);
        $this->popup_categories_obj = new Popup_Categories_List_Table($this->plugin_name);
    }

    public function screen_option_settings() {
        $this->settings_obj = new Ays_PopupBox_Settings_Actions($this->plugin_name);
    }

    public function deactivate_plugin_option(){
        error_reporting(0);
        $request_value = $_REQUEST['upgrade_plugin'];
        $upgrade_option = get_option('ays_pb_upgrade_plugin','');
        if($upgrade_option === ''){
            add_option('ays_pb_upgrade_plugin',$request_value);
        }else{
            update_option('ays_pb_upgrade_plugin',$request_value);
        }
        echo json_encode(array('option'=>get_option('ays_pb_upgrade_plugin','')));
        wp_die();
    }

    public function get_selected_options_pb() {

        if (isset($_POST['data']) && !empty($_POST['data'])) {
            $posts = get_posts([
                'post_type'   => $_POST['data'],
                'post_status' => 'publish',
                'numberposts' => -1

            ]);
        } else {
            $posts = [];
        }

        $arr = [];
        foreach ( $posts as $post ) {
            array_push($arr, array($post->ID, $post->post_title));

        }
        echo json_encode($arr);
        wp_die();
    }

    public static function ays_pb_restriction_string($type, $x, $length){
        $output = "";
        switch($type){
            case "char":                
                if(strlen($x)<=$length){
                    $output = $x;
                } else {
                    $output = substr($x,0,$length) . '...';
                }
                break;
            case "word":
                $res = explode(" ", $x);
                if(count($res)<=$length){
                    $output = implode(" ",$res);
                } else {
                    $res = array_slice($res,0,$length);
                    $output = implode(" ",$res) . '...';
                }
            break;
        }
        return $output;
    }

    public function popup_box_admin_footer($a){
        if(isset($_REQUEST['page'])){
            if(false !== strpos($_REQUEST['page'], $this->plugin_name)){
                ?>
                <p style="font-size:13px;text-align:center;font-style:italic;">
                    <span style="margin-left:0px;margin-right:10px;" class="ays_heart_beat"><i class="ays_fa ays_fa_heart animated"></i></span>
                    <span><?php echo __( "If you love our plugin, please do big favor and rate us on", $this->plugin_name); ?></span> 
                    <a target="_blank" href='https://wordpress.org/support/plugin/ays-popup-box/reviews/'>WordPress.org</a>
                    <span class="ays_heart_beat"><i class="ays_fa ays_fa_heart animated"></i></span>
                </p>
            <?php
            }
        }
    }
}
