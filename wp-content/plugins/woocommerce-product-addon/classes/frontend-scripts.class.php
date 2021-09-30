<?php
/**
 * PPOM Scripts Class
 * 
 * It will register/enqueue all ppom scripts to frontent
*/


if ( ! defined( 'ABSPATH' ) ) { exit; }


class PPOM_FRONTEND_SCRIPTS {
	
	/**
	 * Return scripts URL.
	 * 
	 * @var URL
	 *
	*/
	private static $scripts_url =  PPOM_URL;
	
	/**
	 * Return current ppom version.
	 * 
	 * @var string
	 *
	*/
	private static $version =  PPOM_VERSION;
	
	public static $option_data =  [];
	

	/**
	 * Main Init
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts' ) );
	}


	/**
	 * Register Script
	 *
	*/
	private static function register_script( $handle, $path, $deps = array( 'jquery' ), $version = PPOM_VERSION, $in_footer = true ) {
		wp_register_script( $handle, $path, $deps, $version, $in_footer );
	}
	

	/**
	 * Register and Enqueue Scripts.
	 *
	*/
	private static function enqueue_script( $handle, $path = '', $deps = array( 'jquery' ), $version = PPOM_VERSION, $in_footer = true ) {
		if (!wp_script_is( $handle, 'registered' ) && $path ) {
			self::register_script( $handle, $path, $deps, $version, $in_footer );
		}
		wp_enqueue_script( $handle );
	}
	

	/**
	 * Register Styles.
	 *
	*/
	private static function register_style( $handle, $path, $deps = array(), $version, $media = 'all' ) {
		wp_register_style( $handle, $path, $deps, $version, $media );
	}
	

	/**
	 * Register and Enqueue Styles.
	 *
	*/
	private static function enqueue_style( $handle, $path = '', $deps = array(), $version = PPOM_VERSION, $media = 'all') {
		if (!wp_script_is( $handle, 'registered' ) && $path ) {
			self::register_style( $handle, $path, $deps, $version, $media, $has_rtl );
		}
		wp_enqueue_style( $handle );
	}
	

	/**
	 * Register all PPOM Scripts.
	 */
	private static function register_scripts() {
		
		$ppom_price_js = ppom_get_price_table_calculation();

		$register_scripts = array(
			'PPOM-sm-popup' => array(
				'src'     => self::$scripts_url.'/js/ppom-simple-popup.js',
				'deps'    => array( 'jquery' ),
				'version' => '1.0',
			),
			'ppom-tooltip' => array(
				'src'     => self::$scripts_url.'/js/ppom-tooltip.js',
				'deps'    => array( 'jquery' ),
				'version' => '1.0',
			),
			'ppom-price' => array(
				'src'     => self::$scripts_url."/js/price/{$ppom_price_js}",
				'deps'    => array( 'jquery','ppom-inputs' ,'accounting'),
				'version' => self::$version,
			),
			'ppom-ajax-validation' => array(
				'src'     => self::$scripts_url."/js/ppom-validation.js",
				'deps'    => array( 'jquery' ),
				'version' => self::$version,
			),
			'ppom-inputmask' => array(
				'src'     => self::$scripts_url.'/js/inputmask/jquery.inputmask.min.js',
				'deps'    => array( 'jquery' ),
				'version' => '5.0.6',
			),
			'iris' => array(
				'src'     => admin_url( 'js/iris.min.js' ),
				'deps'    => array( 
			            		'jquery',
			            		'jquery-ui-core',
			            		'jquery-ui-draggable', 
			            		'jquery-ui-slider'
			        		),
				'version' => '1.0.7',
			),
			'ppom-zoom' => array(
				'src'     => self::$scripts_url.'/js/image-tooltip.js',
				'deps'    => array( 'jquery' ),
				'version' => self::$version,
			),
			'ppom-bs-slider' => array(
				'src'     => self::$scripts_url.'/js/bs-slider/bootstrap-slider.min.js',
				'deps'    => array( 'jquery' ),
				'version' => '10.0.0',
			),
			'ppom-croppie-lib' => array(
				'src'     => self::$scripts_url.'/js/croppie/croppie.min.js',
				'deps'    => array( 'jquery' ),
				'version' => '2.6.4',
			),
			'ppom-exif' => array(
				'src'     => self::$scripts_url.'/js/exif.js',
				'deps'    => array( 'jquery' ),
				'version' => self::$version,
			),
			'ppom-modal-lib' => array(
				'src'     => self::$scripts_url.'/js/ppom-modal.js',
				'deps'    => array( 'jquery' ),
				'version' => '1.1.1',
			),
			'ppom-file-upload' => array(
				'src'     => self::$scripts_url.'/js/file-upload.js',
				'deps'    => array('jquery', 'plupload','ppom-price'),
				'version' => self::$version,
			),
			'ppom-inputs' => array(
				'src'     => self::$scripts_url.'/js/ppom.inputs.js',
				'deps'    => array( 'jquery', 'jquery-ui-datepicker' ),
				'version' => self::$version,
			),
		);
		
		$register_scripts = apply_filters('ppom_frontend_scripts_before_register', $register_scripts);
		
		foreach ( $register_scripts as $handle => $props ) {
			$is_footer = isset($props['footer']) ? $props['footer'] : true ;
			self::register_script( $handle, $props['src'], $props['deps'], $props['version'], $is_footer );
		}
	}
	

	/**
	 * Register Styles
	 */
	private static function register_styles() {
		
		$register_styles = array(
			'ppom-main' => array(
				'src'     => self::$scripts_url.'/css/ppom-style.css',
				'deps'    => array(),
				'version' => self::$version,
			),
			'ppom-sm-popup' => array(
				'src'     => self::$scripts_url.'/css/ppom-simple-popup.css',
				'deps'    => array(),
				'version' => self::$version,
			),
			'ppom-bootstrap' => array(
				'src'     => self::$scripts_url.'/css/bootstrap/bootstrap.css',
				'deps'    => array(),
				'version' => '4.0.0',
			),
			'ppom-bootstrap-modal' => array(
				'src'     => self::$scripts_url.'/css/bootstrap/bootstrap.modal.css',
				'deps'    => array(),
				'version' => '4.0.0',
			),
			'prefix-font-awesome' => array(
				'src'     => '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css',
				'deps'    => array(),
				'version' => '4.0.3',
			),
			'jqueryui' => array(
				'src'     => self::$scripts_url.'/js/ui/css/smoothness/jquery-ui-1.10.3.custom.min.css',
				'deps'    => array(),
				'version' => '1.10.3',
			),
			'ppom-bs-slider-css' => array(
				'src'     => self::$scripts_url.'/js/bs-slider/bootstrap-slider.min.css',
				'deps'    => array(),
				'version' => '10.0.0',
			),
			'ppom-croppie-lib' => array(
				'src'     => self::$scripts_url.'/js/croppie/croppie.css',
				'deps'    => array(),
				'version' => '2.6.4',
			),
			'ppom-modal-lib' => array(
				'src'     => self::$scripts_url.'/css/ppom-modal.css',
				'deps'    => array(),
				'version' => '1.1.1',
			),
			'ppom-divider-input' => array(
				'src'     => self::$scripts_url.'/css/divider.css',
				'deps'    => array(),
				'version' => '1.0',
			),
		);
		
		$register_styles = apply_filters('ppom_frontend_styles_before_register', $register_styles);
		
		foreach ( $register_styles as $handle => $props ) {
			self::register_style( $handle, $props['src'], $props['deps'], $props['version'], 'all' );
		}
	}
	
	
	/**
	 * Load Frontend Scripts.
	 */
	public static function load_scripts() {
		
		global $post;
		

		if ( ! did_action( 'before_woocommerce_init' ) ) {
			return;
		}
		
		// Register all scripts/styles
		self::register_scripts();
		self::register_styles();
		
		
		if (!is_object($post)) return;
		
		$product_id = $post->ID;
		
		
		if (get_post_type($post->ID) != 'product' && $product_id = get_post_meta($post->ID, 'product_id', true)) {
			self::load_scripts_by_product_id($product_id);
		} elseif ( is_product() ) {
			self::load_scripts_by_product_id($product_id);
		}
	}
	
	
	/**
	 * Load Frontend Scripts by product ID.
	 */
	public static function load_scripts_by_product_id($product_id, $ppom_id=null, $display_location='') {
		
		if ( $product_id ) {
			
			$product = wc_get_product($product_id);
			
			$ppom = new PPOM_Meta( $product_id );
			// $ppom = new PPOM_Meta( $product_id );
			
			if ( $ppom->fields ) {
				
				$ppom_meta_settings = $ppom->ppom_settings;
				$ppom_meta_fields	= $ppom->fields;
	
				if( !empty($ppom_id) ) {
					$ppom_meta_fields	= $ppom->get_fields_by_id($ppom_id);
					$ppom_meta_settings	= $ppom->get_settings_by_id($ppom_id);
				}
				
				if( ! $ppom_meta_fields ) return '';
				
			    $ppom_conditional_fields  = array();
			    $croppie_options		  = array();
			    $global_js_vars		      = array();
			    $file_js_vars		      = array();
			    $input_js_vars		      = array();
			    $ppom_file_inputs		  = array();
			    $inputs_meta_updated      = array();
			    $show_price_per_unit	  = false;
			    
			    self::enqueue_style( 'ppom-main' );
			    self::enqueue_style( 'ppom-sm-popup' );
        		self::enqueue_script( 'PPOM-sm-popup' );
        		
        		if ( $ppom->inline_css != '') {
					wp_add_inline_style( 'ppom-main', $ppom->inline_css );
			    }
			    
			    if( ppom_load_bootstrap_css() ) {
        			self::enqueue_script( 'ppom-tooltip' );
        			self::enqueue_style( 'ppom-bootstrap' );
        			self::enqueue_style( 'ppom-bootstrap-modal' );
			    }
			    
			    if( ppom_load_fontawesome() ) {
			    	self::enqueue_style( 'prefix-font-awesome' );
			    }
							
        		self::enqueue_script( 'ppom-price' );
        		
        		if( $ppom->ajax_validation_enabled ) {
        			self::enqueue_script( 'ppom-ajax-validation' );
				}
				
				$enable_file_rename = apply_filters('ppom_upload_file_rename', true, $ppom_meta_fields);
				
				$file_js_vars['enable_file_rename'] = $enable_file_rename;
				
				/* Global JS Inputs Vars */
				$global_js_vars = array(
					'ajaxurl'    => admin_url( 'admin-ajax.php', (is_ssl() ? 'https' : 'http') ),
					'plugin_url' => PPOM_URL,
					'product_id' => $product_id,
				);
				
				$decimal_palces = wc_get_price_decimals();
				
				if( $ppom_meta_fields ) {
					
				    foreach($ppom_meta_fields as $field){
						
						$type			= isset($field['type']) ? $field['type'] : '';
						$title			= ( isset($field['title']) ? $field ['title'] : '');
						$data_name		= ( isset($field['data_name']) ? $field ['data_name'] : $title);
						$data_name		= sanitize_key( $data_name );
						$field['data_name'] = $data_name;
						$field['title']		= stripslashes($title);
						
						// updated single inputs meta to new variable
						$fields_meta = $field;
						
						// change input type in js file
						$fields_meta['field_type'] = apply_filters('ppom_js_fields', $type, $fields_meta);
						
						if( isset($field['options']) && $type != 'bulkquantity') {
							$field['options'] = ppom_convert_options_to_key_val($field['options'], $field, $product);
						}
						
						// Allow other types to be hooked
						$type = apply_filters('ppom_load_input_script_type', $type, $field, $product);
						
						switch( $type ) {
						    
						    case 'text':
						    	if( !empty($field['input_mask']) ) {
						    		self::enqueue_script( 'ppom-inputmask' );
				                }
				            	break;
				            	
						    case 'date':
						        if(isset($field['jquery_dp']) && $field['jquery_dp'] == 'on') {
						        	self::enqueue_style( 'jqueryui' );
						        }
						        break;
						        
							case 'daterange':
								// Check if value is in GET 
								if( !empty($_GET[$data_name]) ) {
									
									$value    = $_GET[$data_name];
									$to_dates = explode(' - ', $value);
									$fields_meta['start_date'] = $to_dates[0];
									$fields_meta['end_date'] = $to_dates[0];
								}
					        break;
						        
							case 'color':
								self::enqueue_script( 'iris' );
								
								if( !empty($_GET[$data_name]) ) {
									
									$fields_meta['default_color'] = $_GET[$data_name];
								}
				    	    	break;
				    	    	
				    	    case 'image':
				    	    	self::enqueue_script( 'ppom-zoom' );
				    	    	break;
				    	    	
				    	    case 'pricematrix':
				    	    	if( isset($field['show_slider']) && $field['show_slider'] == 'on' ) {
				    	    		self::enqueue_script( 'ppom-bs-slider' );
				    	    		self::enqueue_style( 'ppom-bs-slider-css' );
				    	    	}
				    	    	
				    	    	if( isset($field['show_price_per_unit']) && $field['show_price_per_unit'] == 'on' ) {
				    	    		$show_price_per_unit = true;
				    	    	}
				    	    	break;
				    	    	
				    	    case 'cropper':
				    	    	
				    	    	self::enqueue_style( 'ppom-croppie-lib' );
				    	    	self::enqueue_script( 'ppom-croppie-lib' );
				    	    	self::enqueue_script( 'ppom-exif' );
				    	    	
								$ppom_file_inputs[] = $field;

						        if( isset($field['legacy_cropper']) && $field['legacy_cropper'] == 'on' ) {
						        	add_thickbox();
						        	self::enqueue_style( 'jcrop' );
						        	self::enqueue_script( 'jcrop' );
						        }
						        
				    	    	self::enqueue_script( 'ppom-file-upload' );
						        
						        // Croppie options
								$croppie_options[$data_name]	= ppom_get_croppie_options($field);
						        
				    	    	$plupload_lang = !empty($field['language']) ? $field['language'] : 'en';
				    	    	
				    	    	self::enqueue_script( 'pluploader-language', "//cdnjs.cloudflare.com/ajax/libs/plupload/2.1.9/i18n/{$plupload_lang}.js");
				    	    	
				    	    	$file_js_vars['croppie_options'] = $croppie_options;
				    	    	break;
				    	    	
							case 'file':
								
				    	    	$ppom_file_inputs[] = $field;
				    	    	
				    	    	self::enqueue_script( 'ppom-file-upload' );
				    	    	$plupload_lang = !empty($field['language']) ? $field['language'] : 'en';
				    	    	self::enqueue_script( 'pluploader-language', "//cdnjs.cloudflare.com/ajax/libs/plupload/2.1.9/i18n/{$plupload_lang}.js");
								break;
								
							case 'bulkquantity':
					
								$fields_meta['options'] = stripslashes($fields_meta['options']);
								
								// To make bulkquantity option WOOCS ready
								$bulkquantities_options = json_decode($fields_meta['options'], true);
								$bulkquantities_new_options = array();
								foreach($bulkquantities_options as $bq_opt) {
									$bq_array = array();
									foreach($bq_opt as $key => $value) {
										
										if( $key != 'Quantity Range' ) {
											$bq_array[$key] = apply_filters('ppom_option_price', $value);
										} else {
											$bq_array[$key] = $value;
										}
									}
									$bulkquantities_new_options[] = $bq_array;
								}
								
								$fields_meta['options'] = json_encode($bulkquantities_new_options);
							break;
								
							case 'fixedprice':
								// Fixed price addon has option to control decimnal places
								if( class_exists('NM_PPOM_FixedPrice') ) {
									$decimal_palces = !empty($field['decimal_place']) ? $field['decimal_place'] : PPOM_FP()->default_decimal_places();
								}
								break;
									
							case 'quantities':
								add_filter('woocommerce_quantity_input_classes', 'ppom_hooks_hide_cart_quantity', 99, 2);
								break;
							
							case 'divider':
								self::enqueue_style( 'ppom-divider-input' );
								break;
						}
						
						$inputs_meta_updated[] = $fields_meta;
						
						// Conditional fields
						if( isset($field['logic']) && $field['logic'] == 'on' && !empty($field['conditions']) ){
							
							$field_conditions = $field['conditions'];
							
							//WPML Translation
							$condition_rules = $field_conditions['rules'];
							$rule_index = 0;
							foreach($condition_rules as $rule) {
								if( !isset($field_conditions['rules'][$rule_index]['element_values']) ) continue;
								
								$field_conditions['rules'][$rule_index]['element_values'] = ppom_wpml_translate($rule['element_values'], 'PPOM');
								$rule_index++;
							}
							
							$ppom_conditional_fields[$data_name] = $field_conditions;
						}
							
						/**
						 * creating action space to render hooks for more addons
						 **/
						do_action('ppom_hooks_inputs', $field, $data_name);
				    }
				}
				
				self::enqueue_script( 'ppom-inputs' );
				
				if ( $ppom->inline_js != '') {
					wp_add_inline_script( 'ppom-inputs', $ppom->inline_js );
			    }
			    
			    // Add admin settings css
			    if (get_option('ppom_css_output')) {
			    	wp_add_inline_style( 'ppom-main', html_entity_decode(get_option('ppom_css_output')) );
			    }
				
				$file_js_vars['file_inputs'] = $ppom_file_inputs;
				
				$input_js_vars['ppom_inputs']              = $inputs_meta_updated;
				$input_js_vars['field_meta']               = $inputs_meta_updated;
				$input_js_vars['wc_no_decimal']	           = $decimal_palces;
				$input_js_vars['wc_product_price']         = ppom_get_product_price($product, '', 'product');
				$input_js_vars['wc_product_regular_price'] = ppom_get_product_regular_price($product);
				$input_js_vars['product_title']            = sprintf(__("%s", "ppom"), $product->get_title());
				$input_js_vars['show_price_per_unit']      = $show_price_per_unit;
				$input_js_vars['show_option_price']        = $ppom->price_display;
				$input_js_vars['product_id']               = $product_id;
				
				$input_js_vars = apply_filters('ppom_input_vars', $input_js_vars, $product);
				
				// Conditional fields
				if( !empty($ppom_conditional_fields) || apply_filters('ppom_enqueue_conditions_js', false)) {
					$input_js_vars['conditions'] = $ppom_conditional_fields;
					
					$ppom_conditions_script = ppom_get_conditions_mode() === 'new' ? 'ppom-conditions-v2' : 'ppom-conditions';
					$ppom_conditions_script = apply_filters('ppom_conditional_script_file', $ppom_conditions_script, $product);
					
					self::enqueue_script( 'ppom-conditions', self::$scripts_url."/js/{$ppom_conditions_script}.js", array('jquery','ppom-inputs') );
					
					self::localize_script( 'ppom-conditions', 'ppom_input_vars', $input_js_vars, $global_js_vars );
				}
				
				self::localize_script( 'ppom-file-upload', 'ppom_file_vars', $file_js_vars, $global_js_vars );
				self::localize_script( 'ppom-inputs', 'ppom_input_vars', $input_js_vars, $global_js_vars );
				self::localize_script( 'ppom-price', 'ppom_input_vars', $input_js_vars, $global_js_vars );
			}
			
			do_action('ppom_after_scripts_loaded', $ppom, $product);
		}
	}


	/**
	 * Localize Scripts Data
	 *
	*/
	private static function localize_script( $handle, $js_var_name, $js_vars, $global_js_vars=array() ) {
		
		if ( wp_script_is( $handle ) ) {
			
			$inputs_vars_meta = self::get_localize_data( $handle, $js_vars, $global_js_vars );
			
			if ( empty($inputs_vars_meta) ) { return; }
			
			wp_localize_script( $handle, $js_var_name, $inputs_vars_meta );
		}
	}
	
	private static function get_localize_data($handle, $js_vars, $global_js_vars){
		
		switch ($handle) {
			
			case 'ppom-file-upload':
				
				$localize_data = array(
					'file_upload_path_thumb' => ppom_get_dir_url(true),
					'file_upload_path'       => ppom_get_dir_url(),
					'mesage_max_files_limit' => __(' files allowed only', "ppom"),
					'delete_file_msg'	     => __("Are you sure?", "ppom"),
					'aviary_api_key'	     => '',
					'plupload_runtime'	     => (ppom_if_browser_is_ie()) ? 'html5,html4' : 'html5,silverlight,html4,browserplus,gear',
					'ppom_file_upload_nonce' => wp_create_nonce( 'ppom_uploading_file_action' ),
					'ppom_file_delete_nonce' => wp_create_nonce( 'ppom_deleting_file_action' ),
				);
				
				break;
			
			case 'ppom-inputs':
			case 'ppom-price':
			case 'ppom-conditions':
				
				$ppom_label_discount_price = ppom_get_option('ppom_label_discount_price', __( 'Discount Price', 'ppom' ));
				$ppom_label_product_price  = ppom_get_option('ppom_label_product_price', __( 'Product Price', 'ppom' ));
				$ppom_label_option_total   = ppom_get_option('ppom_label_option_total', __( 'Option Total', 'ppom' ));
				$ppom_label_fixed_fee      = ppom_get_option('ppom_label_fixed_fee', __( 'Fixed Fee', 'ppom' ));
				$ppom_label_total_discount = ppom_get_option('ppom_label_total_discount', __( 'Total Discount', 'ppom' ));
				$ppom_label_total          = ppom_get_option('ppom_label_total', __( 'Total', 'ppom' ));
				
				$localize_data = array(
					'ppom_validate_nonce'       => wp_create_nonce( 'ppom_validating_action' ),
					'wc_thousand_sep'           => wc_get_price_thousand_separator(),
					'wc_currency_pos'           => get_option( 'woocommerce_currency_pos' ),
					'wc_decimal_sep'            => get_option('woocommerce_price_decimal_sep'),
					'total_discount_label'      => sprintf(__("%s", 'ppom'), $ppom_label_total_discount),
					'price_matrix_heading'      => sprintf(__("%s", 'ppom'), $ppom_label_discount_price),
					'product_base_label'        => sprintf(__("%s", 'ppom'), $ppom_label_product_price),
					'option_total_label'        => sprintf(__("%s", 'ppom'), $ppom_label_option_total),
					'fixed_fee_heading'         => sprintf(__("%s", 'ppom'), $ppom_label_fixed_fee),
					'total_without_fixed_label' => sprintf(__("%s", 'ppom'), $ppom_label_total),
					'product_quantity_label'    => __("Product Quantity", "ppom"),
					'per_unit_label'            => __("unit", "ppom"),
					'text_quantity'             => __("Quantity","ppom"),
					'is_shortcode'              => 'no',
					'is_mobile'                 => ppom_is_mobile(),
					'tax_prefix'                => ppom_tax_label_display(),
				);
				
				break;
		}
		
		$localize_data = array_merge($js_vars, $localize_data, $global_js_vars);
	
		return apply_filters( 'ppom_get_localize_script_data', $localize_data, $handle );
	}
}

PPOM_FRONTEND_SCRIPTS::init();