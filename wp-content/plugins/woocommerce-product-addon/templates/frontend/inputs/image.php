<?php
/**
* Image Input Template
* 
* This template can be overridden by copying it to yourtheme/ppom/frontend/inputs/image.php
* 
* @version 1.0
**/

/* 
**========== Block direct access =========== 
*/
if( ! defined('ABSPATH' ) ){ exit; }

$fm = new PPOM_InputManager($field_meta, 'image');
$legacy_view      = $fm->get_meta_value('legacy_view');
$multiple_allowed = $fm->get_meta_value('multiple_allowed');
$marked_img_borderclr = $fm->get_meta_value('selected_img_bordercolor', '#f00');
$image_width   = $fm->get_meta_value('image_width', '75px');
$image_height  = $fm->get_meta_value('image_height', 'auto');

$images = ppom_convert_options_to_key_val($fm->images(), $field_meta, $product);

// If Image empty
if ( ! $images ) {
	echo '<div class="ppom-option-notice">';
        echo '<p>'. __( "Images are required, please add it.", "ppom" ) .'</p>';
    echo '</div>';
	return;
}

$inline_styles = '';
$inline_styles .= '<style>';
	$inline_styles .='.'.$fm->data_name().' .nm-boxes-outer input:checked + img {
			border: 2px solid '.esc_attr($marked_img_borderclr).' !important;
		}.'.$fm->data_name().' .pre_upload_image img{
		   height: '.esc_attr($image_height).' !important;
		   width : '.esc_attr($image_width).' !important;
		}';
$inline_styles .= '</style>';
echo $inline_styles;

// ppom_pa($images);

$product_type = $product->get_type();
?>


<div class="<?php echo esc_attr($fm->field_inner_wrapper_classes()); ?>" >

	<!-- if title of field exist -->
	<?php if ($fm->field_label()): ?>
		<label class="<?php echo esc_attr($fm->label_classes()); ?>" for="<?php echo esc_attr($fm->data_name()); ?>" ><?php echo sprintf(__("%s", "ppom"), $fm->field_label()); ?></label>
	<?php endif ?>

	<!-- Legacy View -->
	<?php 
	if ($legacy_view == 'on'){
	?>
		<div class="ppom_upload_image_box">
			
			<?php 
			foreach ($images as $image){
				
				$image_full     = isset($image['link']) ? $image['link'] : 0;
				$image_id       = isset($image['image_id']) ? $image['image_id'] : 0;
				$image_title    = isset($image['raw']) ? stripslashes($image['raw']) : '';
				$image_label    = isset($image['label']) ? stripslashes($image['label']) : '';
				$image_price    = isset($image['price']) ? $image['price'] : 0;
				$option_id      = $fm->data_name().'-'.$image_id;
				$opt_percent    = isset($value['percent']) ? $value['percent']: '';
				
				// If price set in %
				if(strpos($image['price'],'%') !== false){
					$image_price = ppom_get_amount_after_percentage($product->get_price(), $image['price']);
				}
			

	            // Actually image URL is link
	            $image_link         = isset($image['url']) ? $image['url'] : '';
				$image_url          = apply_filters('ppom_image_input_url', wp_get_attachment_thumb_url( $image_id ), $image, $field_meta);
	            
	            $checked_option = '';
	            if( ! empty($default_value) ){
				    if( is_array($default_value) ) {
				        foreach($default_value as $img_data) {
				            if( isset($img_data['image_id']) && $image['image_id'] == $img_data['image_id'] ) {
				                $checked_option = 'checked="checked"';
				            }
				        }
				    } else {
				        $checked_option = ($image['raw'] == $default_value ? 'checked=checked' : '' );
				    }
	            }
	            
	            // Loading Modals
				$modal_vars = array('image_id' => $image_id, 'image_full' => $image_full, 'image_title' => $image_label);
				ppom_load_input_templates( 'frontend/component/image/image-modals.php', $modal_vars);
	            
			?>
				<div class="pre_upload_image <?php echo esc_attr($fm->input_classes()) ?>">
					<?php if ( !empty($image_link) ){ ?>
						<a href="<?php echo esc_url($image_link); ?>">
							<img class="img-thumbnail" src="<?php echo esc_url($image_url); ?>">
						</a>
					<?php }else{ ?>
						<img class="img-thumbnail" data-model-id="modalImage<?php echo esc_attr($image_id); ?>" src="<?php echo esc_url($image_url); ?>">
					<?php } 
					
					?>

					<div class="input_image">
						<?php if ($multiple_allowed == 'on'){ ?>
							<input 
								type="checkbox" 
								name="<?php echo esc_attr($fm->form_name()); ?>[]" 
								id="<?php echo esc_attr($option_id); ?>" 
								data-price="<?php echo esc_attr($image_price); ?>" 
								class="ppom-input"
								data-label="<?php echo esc_attr($image_title); ?>" 
								data-title="<?php echo esc_attr($fm->title()); ?>" 
								data-optionid="<?php echo esc_attr($option_id); ?>" 
				                data-data_name="<?php echo esc_attr($fm->data_name()); ?>" 
				                value="<?php echo esc_attr(json_encode($image)); ?>"
				                <?php echo $checked_option; ?> 
							>
						<?php }else{ ?>
							<input 
								type="radio" 
								name="<?php echo esc_attr($fm->form_name()); ?>[]" 
								id="<?php echo esc_attr($option_id); ?>" 
								data-price="<?php echo esc_attr($image_price); ?>" 
								class="ppom-input"
								data-label="<?php echo esc_attr($image_title); ?>" 
								data-title="<?php echo esc_attr($fm->title()); ?>" 
								data-type="image" 
								data-optionid="<?php echo esc_attr($option_id); ?>" 
				                data-data_name="<?php echo esc_attr($fm->data_name()); ?>" 
				                value="<?php echo esc_attr(json_encode($image)); ?>" 
				                <?php echo $checked_option; ?> 
							>
						<?php } ?>
						<div class="p_u_i_name"><?php echo $image_label; ?></div>
					</div> <!-- input_image -->
				</div> <!-- pre_upload_image -->
			<?php
			} 
			?>
		</div> <!-- ppom_upload_image_box -->
	<?php 
	}else{
	?>
		<div class="nm-boxes-outer">
			<?php 
			$img_index = 0;

			if ($images) {
				foreach ($images as $image) {
					
					$image_full   = isset($image['link']) ? $image['link'] : 0;
					$image_id     = isset($image['image_id']) ? $image['image_id'] : 0;
					$image_title  = isset($image['raw']) ? stripslashes($image['raw']) : '';
					$image_label  = isset($image['label']) ? stripslashes($image['label']) : '';
					$image_price  = isset($image['price']) ? $image['price'] : 0;
					$option_id    = $fm->data_name().'-'.$image_id;
					$opt_percent  = isset($image['percent']) ? $image['percent']: '';
					
					// If price set in %
    				// if(strpos($image['price'],'%') !== false){
    				// 	$image_price = ppom_get_amount_after_percentage($product->get_price(), $image['price']);
    				// }
    				
    				
    				// Actually image URL is link
					$image_link = isset($image['url']) ? $image['url'] : '';
					$image_url          = apply_filters('ppom_image_input_url', wp_get_attachment_thumb_url( $image_id ), $image, $field_meta);
					
					$ppom_has_percent = $opt_percent !== '' ? 'ppom-option-has-percent' : '';
			        $option_class     = array(
			        						"ppom-option-{$option_id}",
			                            	"ppom-{$product_type}-option",
			                            	$ppom_has_percent,
			                            );
			                                
			        $option_class	= apply_filters('ppom_option_classes', implode(" ", $option_class), $field_meta);
			        $option_class	= "ppom-input {$option_class}";
    				
					$checked_option = '';
					if( ! empty($default_value) ){
					    if( is_array($default_value) ) {
					        foreach($default_value as $img_data) {
					            if( isset($img_data['image_id']) && $image['image_id'] == $img_data['image_id'] ) {
					                $checked_option = 'checked="checked"';
					            }
					        }
					    } else {
					        $checked_option = ($image['raw'] == $default_value ? 'checked=checked' : '' );
					    }
		            }

		            ?>

		            <label>
		            	<div class="pre_upload_image <?php echo esc_attr($fm->input_classes()) ?>" title="<?php echo esc_attr($image_label); ?>" data-ppom-tooltip="ppom_tooltip">
		            		
		            		<?php if ($multiple_allowed == 'on'){ ?>
								<input 
									type="checkbox" 
									name="<?php echo esc_attr($fm->form_name()); ?>[]" 
									id="<?php echo esc_attr($option_id); ?>" 
									data-price="<?php echo esc_attr($image_price); ?>" 
									data-label="<?php echo esc_attr($image_title); ?>"
									class="<?php echo esc_attr($option_class)?>"
									data-percent="<?php echo esc_attr($opt_percent); ?>"
									data-title="<?php echo esc_attr($fm->title()); ?>" 
									data-optionid="<?php echo esc_attr($option_id); ?>" 
					                data-data_name="<?php echo esc_attr($fm->data_name()); ?>" 
					                value="<?php echo esc_attr(json_encode($image)); ?>" 
					                <?php echo esc_attr($checked_option); ?>
								>
							<?php }else{ ?>
								<input 
									type="radio" 
									name="<?php echo esc_attr($fm->form_name()); ?>[]" 
									id="<?php echo esc_attr($option_id); ?>" 
									data-price="<?php echo esc_attr($image_price); ?>" 
									data-label="<?php echo esc_attr($image_title); ?>" 
									class="<?php echo esc_attr($option_class)?>"
									data-percent="<?php echo esc_attr($opt_percent); ?>"
									data-title="<?php echo esc_attr($fm->title()); ?>" 
									data-type="image" 
									data-optionid="<?php echo esc_attr($option_id); ?>" 
					                data-data_name="<?php echo esc_attr($fm->data_name()); ?>" 
					                value="<?php echo esc_attr(json_encode($image)); ?>" 
					                <?php echo esc_attr($checked_option); ?> 
								>
							<?php } 

							if ( $image['image_id'] != '' ) {
								if ( isset($image['url']) && $image['url'] != '' ) {
								?>
									<a href="<?php echo esc_url($image_link); ?>">
										<img src="<?php echo esc_url($image_url); ?>">
									</a>
								<?php	
								}else{
									$image_url = wp_get_attachment_thumb_url( $image['image_id'] );
								?>
									<img data-image-tooltip="<?php echo wp_get_attachment_url($image['image_id']); ?>" src="<?php echo esc_url($image_url); ?>" class="img-thumbnail ppom-zoom-<?php echo esc_attr($fm->data_name()); ?>">
								<?php
								}
							}else{

								if (isset($image['url']) && $image['url'] != '') {
								?>
									<a href="<?php echo esc_url($image_link); ?>">
										<img width="150" height="150" src="<?php echo esc_url($image['link']); ?>">
									</a>
								<?php
								}else{
								?>
									<img class="img-thumbnail ppom-zoom-<?php echo esc_attr($fm->data_name()); ?>" data-image-tooltip="<?php echo esc_url($image['link']); ?>" src="<?php echo esc_url($image['link']); ?>">
								<?php
								}
							?>
							<?php
							}
							?>

		            	</div> <!-- pre_upload_image -->
		            </label>
		            <?php
		            $img_index++;
				}
			}
			?>
			<div style="clear:both"></div>
		</div> <!-- nm-boxes-outer -->
	<?php
	}
	?>
</div>