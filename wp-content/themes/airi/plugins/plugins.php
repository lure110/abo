<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'tgmpa_register', 'airi_register_required_plugins' );


if(!function_exists('lasf_get_plugin_source')){
    function lasf_get_plugin_source( $new, $initial, $plugin_name, $type = 'source'){
        if(isset($new[$plugin_name], $new[$plugin_name][$type]) && version_compare($initial[$plugin_name]['version'], $new[$plugin_name]['version']) < 0 ){
            return $new[$plugin_name][$type];
        }
        else{
            return $initial[$plugin_name][$type];
        }
    }
}

if(!function_exists('airi_register_required_plugins')){

	function airi_register_required_plugins() {

        $initial_required = array(
            'lastudio' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/airi/plugins/lastudio/1.1.6/lastudio.zip',
                'version'   => '1.1.6'
            ),
            'airi-demo-data' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/airi/plugins/airi-demo-data/1.0.2/airi-demo-data.zip',
                'version'   => '1.0.2'
            ),
            'lastudio-header-builders' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/airi/plugins/lastudio-header-builders/1.1.6/lastudio-header-builders.zip',
                'version'   => '1.1.6'
            ),
            'revslider' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/shared/plugins/revslider_v6.4.6.zip',
                'version'   => '6.4.6'
            ),
            'js_composer' => array(
                'source'    => 'https://la-studioweb.com/file-resouces/shared/plugins/js_composer_v6.6.0.zip',
                'version'   => '6.6.0'
            )
        );

        $from_option = get_option('airi_required_plugins_list', $initial_required);
	    
		$plugins = array();

		$plugins[] = array(
			'name'					=> esc_html_x('WPBakery Visual Composer', 'admin-view', 'airi'),
			'slug'					=> 'js_composer',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'js_composer'),
            'required'				=> true,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'js_composer', 'version')
		);

		$plugins[] = array(
			'name'					=> esc_html_x('LA-Studio Core', 'admin-view', 'airi'),
			'slug'					=> 'lastudio',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio'),
            'required'				=> true,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio', 'version')
		);

		$plugins[] = array(
			'name'					=> esc_html_x('LA-Studio Header Builder', 'admin-view', 'airi'),
			'slug'					=> 'lastudio-header-builders',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio-header-builders'),
            'required'				=> true,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'lastudio-header-builders', 'version')
		);

		$plugins[] = array(
			'name'     				=> esc_html_x('WooCommerce', 'admin-view', 'airi'),
			'slug'     				=> 'woocommerce',
			'version'				=> '5.2.0',
			'required' 				=> false
		);

		$plugins[] = array(
			'name'     				=> esc_html_x('Envato Market', 'admin-view', 'airi'),
			'slug'     				=> 'envato-market',
			'source'   				=> 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
			'required' 				=> false,
			'version' 				=> '2.0.6'
		);

		$plugins[] = array(
			'name'					=> esc_html_x('Airi Package Demo Data', 'admin-view', 'airi'),
			'slug'					=> 'airi-demo-data',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'airi-demo-data'),
            'required'				=> true,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'airi-demo-data', 'version')
		);

		$plugins[] = array(
			'name' 					=> esc_html_x('Contact Form 7', 'admin-view', 'airi'),
			'slug' 					=> 'contact-form-7',
			'required' 				=> false
		);

		$plugins[] = array(
			'name' 					=> esc_html_x('Easy Forms for MailChimp', 'admin-view', 'airi'),
			'slug' 					=> 'yikes-inc-easy-mailchimp-extender',
			'required' 				=> false
		);

		$plugins[] = array(
			'name'					=> esc_html_x('Slider Revolution', 'admin-view', 'airi'),
			'slug'					=> 'revslider',
            'source'				=> lasf_get_plugin_source($from_option, $initial_required, 'revslider'),
            'required'				=> false,
            'version'				=> lasf_get_plugin_source($from_option, $initial_required, 'revslider', 'version')
		);

		$config = array(
			'id'           				=> 'airi',
			'default_path' 				=> '',
			'menu'         				=> 'tgmpa-install-plugins',
			'has_notices'  				=> true,
			'dismissable'  				=> true,
			'dismiss_msg'  				=> '',
			'is_automatic' 				=> false,
			'message'      				=> ''
		);

		tgmpa( $plugins, $config );

	}

}
