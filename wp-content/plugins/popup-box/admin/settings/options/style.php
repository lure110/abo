<?php
/**
 * Style parameters
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

$animation = [
	'fadeIn' => 'fadeIn',
];

//region General Style
$width = array(
	'label'   => esc_attr__( 'Modal Width', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[width]',
		'id'    => 'width',
		'value' => isset( $param['width'] ) ? $param['width'] : '550',
		'min'   => '0',
		'step'  => '1',
	],
	'addon'   => [
		'name'    => 'param[width_unit]',
		'value'   => isset( $param['width_unit'] ) ? $param['width_unit'] : 'px',
		'id'      => 'width_unit',
		'options' => [
			'auto' => esc_attr__( 'auto', $this->plugin['text'] ),
			'px'   => esc_attr__( 'px', $this->plugin['text'] ),
			'%'    => esc_attr__( '%', $this->plugin['text'] ),
		],
	],
	'tooltip' => esc_attr__( 'Set Modal Window width', $this->plugin['text'] ),
);

$height = array(
	'label'   => esc_attr__( 'Modal Height', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[height]',
		'id'    => 'height',
		'value' => isset( $param['height'] ) ? $param['height'] : '350',
		'min'   => '0',
		'step'  => '1',
	],
	'addon'   => [
		'name'    => 'param[height_unit]',
		'value'   => isset( $param['height_unit'] ) ? $param['height_unit'] : 'auto',
		'id'      => 'height_unit',
		'options' => [
			'auto' => esc_attr__( 'auto', $this->plugin['text'] ),
			'px'   => esc_attr__( 'px', $this->plugin['text'] ),
			'%'    => esc_attr__( '%', $this->plugin['text'] ),
		],
	],
	'tooltip' => esc_attr__( 'Set Modal Window height.', $this->plugin['text'] ),
);

$zindex = array(
	'label'   => esc_attr__( 'Z-index', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[zindex]',
		'id'    => 'zindex',
		'value' => isset( $param['zindex'] ) ? $param['zindex'] : '999',
		'min'   => '0',
		'step'  => '1',
	],
	'tooltip' => esc_attr__( 'The z-index property specifies the stack order of an element. An element with greater stack order is always in front of an element with a lower stack order.', $this->plugin['text'] ),
);

$location = array(
	'label'   => esc_attr__( 'Location', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[location]',
		'id'    => 'location',
		'value' => isset( $param['location'] ) ? $param['location'] : '-center',
	],
	'options' => [
		'-center'       => esc_attr__( 'Center', $this->plugin['text'] ),
		'-topCenter'    => esc_attr__( 'Top Center', $this->plugin['text'] ),
		'-bottomCenter' => esc_attr__( 'Bottom Center', $this->plugin['text'] ),
		'-left'         => esc_attr__( 'Left Center', $this->plugin['text'] ),
		'-topLeft'      => esc_attr__( 'Top Left', $this->plugin['text'] ),
		'-bottomLeft'   => esc_attr__( 'Bottom Left', $this->plugin['text'] ),
		'-right'        => esc_attr__( 'Right Center', $this->plugin['text'] ),
		'-topRight'     => esc_attr__( 'Top Right', $this->plugin['text'] ),
		'-bottomRight'  => esc_attr__( 'Bottom Right', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Specify popup location.', $this->plugin['text'] ),
	'func'    => 'popupLocation()',
);

$top = array(
	'label'   => esc_attr__( 'Top', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[top]',
		'id'    => 'top',
		'value' => isset( $param['top'] ) ? $param['top'] : '0',
		'step'  => '1',
	],
	'addon'   => [
		'name'    => 'param[top_unit]',
		'value'   => isset( $param['top_unit'] ) ? $param['top_unit'] : 'px',
		'id'      => 'top_unit',
		'options' => [
			'px' => esc_attr__( 'px', $this->plugin['text'] ),
			'em' => esc_attr__( 'em', $this->plugin['text'] ),
		],
	],
	'tooltip' => esc_attr__( 'Property affects the top vertical position of a popup.', $this->plugin['text'] ),
);

$bottom = array(
	'label'   => esc_attr__( 'Bottom', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[bottom]',
		'id'    => 'bottom',
		'value' => isset( $param['bottom'] ) ? $param['bottom'] : '0',
		'step'  => '1',
	],
	'addon'   => [
		'name'    => 'param[bottom_unit]',
		'value'   => isset( $param['bottom_unit'] ) ? $param['bottom_unit'] : 'px',
		'id'      => 'bottom_unit',
		'options' => [
			'px' => esc_attr__( 'px', $this->plugin['text'] ),
			'em' => esc_attr__( 'em', $this->plugin['text'] ),
		],
	],
	'tooltip' => esc_attr__( 'Property affects the bottom vertical position of a popup.', $this->plugin['text'] ),
);

$left = array(
	'label'   => esc_attr__( 'Left', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[left]',
		'id'    => 'left',
		'value' => isset( $param['left'] ) ? $param['left'] : '0',
		'step'  => '1',
	],
	'addon'   => [
		'name'    => 'param[left_unit]',
		'value'   => isset( $param['left_unit'] ) ? $param['left_unit'] : 'px',
		'id'      => 'left_unit',
		'options' => [
			'px' => esc_attr__( 'px', $this->plugin['text'] ),
			'em' => esc_attr__( 'em', $this->plugin['text'] ),
		],
	],
	'tooltip' => esc_attr__( 'Property affects the left horizontal position of a popup.', $this->plugin['text'] ),
);

$right = array(
	'label'   => esc_attr__( 'Right', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[right]',
		'id'    => 'right',
		'value' => isset( $param['right'] ) ? $param['right'] : '0',
		'step'  => '1',
	],
	'addon'   => [
		'name'    => 'param[right_unit]',
		'value'   => isset( $param['right_unit'] ) ? $param['right_unit'] : 'px',
		'id'      => 'right_unit',
		'options' => [
			'px' => esc_attr__( 'px', $this->plugin['text'] ),
			'em' => esc_attr__( 'em', $this->plugin['text'] ),
		],
	],
	'tooltip' => esc_attr__( 'Property affects the right horizontal position of a popup.', $this->plugin['text'] ),
);

$popup_animation = array(
	'label'   => esc_attr__( 'Animation', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[popup_animation]',
		'id'    => 'popup_animation',
		'value' => isset( $param['popup_animation'] ) ? $param['popup_animation'] : 'fadeIn',
	],
	'options' => $animation,
	'tooltip' => esc_attr__( 'Set the Animation for popup.', $this->plugin['text'] ),
);

$padding = array(
	'label'   => esc_attr__( 'Padding', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[padding]',
		'id'    => 'padding',
		'value' => isset( $param['padding'] ) ? $param['padding'] : '15',
		'min'   => '0',
		'step'  => '1',
	],
	'addon'   => [
		'unit' => 'px',
	],
	'tooltip' => esc_attr__( 'Used to generate space around a popup content, inside of any defined borders.', $this->plugin['text'] ),
);

$radius = array(
	'label'   => esc_attr__( 'Radius', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[radius]',
		'id'    => 'radius',
		'value' => isset( $param['radius'] ) ? $param['radius'] : '0',
		'min'   => '0',
		'step'  => '1',
	],
	'addon'   => [
		'unit' => 'px',
	],
	'tooltip' => esc_attr__( 'Defines the radius of the corners for popup.', $this->plugin['text'] ),
);

$shadow = array(
	'label'    => esc_attr__( 'Shadow', $this->plugin['text'] ),
	'attr'     => [
		'name'  => 'param[shadow]',
		'id'    => 'shadow',
		'value' => isset( $param['shadow'] ) ? $param['shadow'] : '8',
		'min'   => '0',
		'step'  => '1',
	],
	'checkbox' => [
		'name'  => 'param[shadow_checkbox]',
		'id'    => 'shadow_checkbox',
		'class' => 'checkLabel',
		'value' => isset( $param['shadow_checkbox'] ) ? $param['shadow_checkbox'] : 1,
	],
	'addon'    => [
		'unit' => 'px',
	],
	'tooltip'  => esc_attr__( 'Attaches shadows to an popup', $this->plugin['text'] ),
);

$shadow_color = array(
	'label'   => esc_attr__( 'Shadow Color', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[shadow_color]',
		'id'    => 'shadow_color',
		'value' => isset( $param['shadow_color'] ) ? $param['shadow_color'] : 'rgba(0, 0, 0, 0.5)',
	],
	'tooltip' => esc_attr__( 'The color of the shadow.', $this->plugin['text'] ),
);

$background = array(
	'label'   => esc_attr__( 'Background', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[background]',
		'id'    => 'background',
		'value' => isset( $param['background'] ) ? $param['background'] : '#ffffff',
	],
	'tooltip' => esc_attr__( 'Background of popup.', $this->plugin['text'] ),
);

$background_img = array(
	'label'    => esc_attr__( 'Background Image', $this->plugin['text'] ),
	'attr'     => [
		'name'        => 'param[background_img]',
		'id'          => 'background_img',
		'value'       => isset( $param['background_img'] ) ? $param['background_img'] : '',
		'placeholder' => esc_attr__( 'Enter Image URL', $this->plugin['text'] ),
	],
	'checkbox' => [
		'name'  => 'param[background_img_checkbox]',
		'id'    => 'background_img_checkbox',
		'class' => 'checkLabel',
		'value' => isset( $param['background_img_checkbox'] ) ? $param['background_img_checkbox'] : 0,
	],
	'tooltip'  => esc_attr__( 'Set the image for popup background.', $this->plugin['text'] ),
);
//endregion

//region Content
$content_font = array(
	'label'   => esc_attr__( 'Font Family', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[content_font]',
		'id'    => 'content_font',
		'value' => isset( $param['content_font'] ) ? $param['content_font'] : 'Times New Roman',
	],
	'options' => [
		'inherit'         => esc_attr__( 'Use Your Themes', $this->plugin['text'] ),
		'Sans-Serif'      => 'Sans-Serif',
		'Tahoma'          => 'Tahoma',
		'Georgia'         => 'Georgia',
		'Comic Sans MS'   => 'Comic Sans MS',
		'Arial'           => 'Arial',
		'Lucida Grande'   => 'Lucida Grande',
		'Times New Roman' => 'Times New Roman',
	],
	'tooltip' => esc_attr__( 'Select the Font for Content.', $this->plugin['text'] ),
);

$content_size = array(
	'label'   => esc_attr__( 'Main Font Size', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[content_size]',
		'id'    => 'content_size',
		'value' => isset( $param['content_size'] ) ? $param['content_size'] : '16',
		'min'   => '0',
		'step'  => '1',
	],
	'addon'   => [
		'unit' => 'px',
	],
	'tooltip' => esc_attr__( 'Set the main Font size for content.', $this->plugin['text'] ),
);

$content_padding = array(
	'label'   => esc_attr__( 'Padding', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[content_padding]',
		'id'    => 'content_padding',
		'value' => isset( $param['content_padding'] ) ? $param['content_padding'] : '15',
	],
	'addon'   => [
		'unit' => 'px'
	],
	'tooltip' => esc_attr__( 'Specify popup content inner padding.', $this->plugin['text'] ),
);

$border_style = array(
	'label'   => esc_attr__( 'Border Style', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[border_style]',
		'id'    => 'border_style',
		'value' => isset( $param['border_style'] ) ? $param['border_style'] : 'none',
	],
	'options' => [
		'none'   => esc_attr__( 'None', $this->plugin['text'] ),
		'solid'  => esc_attr__( 'Solid', $this->plugin['text'] ),
		'dotted' => esc_attr__( 'Dotted', $this->plugin['text'] ),
		'dashed' => esc_attr__( 'Dashed', $this->plugin['text'] ),
		'double' => esc_attr__( 'Double', $this->plugin['text'] ),
		'groove' => esc_attr__( 'Groove', $this->plugin['text'] ),
		'inset'  => esc_attr__( 'Inset', $this->plugin['text'] ),
		'outset' => esc_attr__( 'Outset', $this->plugin['text'] ),
		'ridge'  => esc_attr__( 'Ridge', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Choose a border style.', $this->plugin['text'] ),
	'func'    => 'checkBorder()',
);

$border_width = array(
	'label'   => esc_attr__( 'Border Thickness', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[border_width]',
		'id'    => 'border_width',
		'value' => isset( $param['border_width'] ) ? $param['border_width'] : '1',
		'min'   => '0',
		'step'  => '1',
	],
	'addon'   => [
		'unit' => 'px',
	],
	'tooltip' => esc_attr__( 'Specify border width.', $this->plugin['text'] ),
);

$border_radius = array(
	'label'   => esc_attr__( 'Border Radius', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[border_radius]',
		'id'    => 'border_radius',
		'value' => isset( $param['border_radius'] ) ? $param['border_radius'] : '0',
		'min'   => '0',
		'step'  => '1',
	],
	'addon'   => [
		'unit' => 'px',
	],
	'tooltip' => esc_attr__( 'Specify border radius.', $this->plugin['text'] ),
);

$border_color = array(
	'label' => esc_attr__( 'Border Color', $this->plugin['text'] ),
	'attr'  => [
		'name'  => 'param[border_color]',
		'id'    => 'border_color',
		'value' => isset( $param['border_color'] ) ? $param['border_color'] : '#d4af37',

	],
);
//endregion

//region Overlay
$overlay = array(
	'label'    => esc_attr__( 'Overlay', $this->plugin['text'] ),
	'attr'     => [
		'name'  => 'param[overlay]',
		'id'    => 'overlay',
		'value' => isset( $param['overlay'] ) ? $param['overlay'] : 'rgba(0, 0, 0, .75)',
	],
	'checkbox' => [
		'name'  => 'param[overlay_checkbox]',
		'id'    => 'overlay_checkbox',
		'class' => 'checkLabel',
		'value' => isset( $param['overlay_checkbox'] ) ? $param['overlay_checkbox'] : 1,
	],
	'tooltip'  => esc_attr__( 'Shows or hides the popup overlay.', $this->plugin['text'] ),
);

$overlay_animation = array(
	'label'   => esc_attr__( 'Animation', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[overlay_animation]',
		'id'    => 'overlay_animation',
		'value' => isset( $param['overlay_animation'] ) ? $param['overlay_animation'] : 'fadeIn',
	],
	'options' => $animation,
	'tooltip' => esc_attr__( 'Set the Animation for overlay.', $this->plugin['text'] ),
);
//endregion

//region Close Button
$close = array(
	'label'   => esc_attr__( 'Close button', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[close]',
		'id'    => 'close',
		'value' => isset( $param['close'] ) ? $param['close'] : '-text',
	],
	'options' => [
		'-text' => esc_attr__( 'Text', $this->plugin['text'] ),
		'-icon' => esc_attr__( 'Icon', $this->plugin['text'] ),
		'-tag'  => esc_attr__( 'Box', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Enable close button for the popup and sets the style.', $this->plugin['text'] ),
	'func'    => 'closeButton()',
);

$close_size = array(
	'label'   => esc_attr__( 'Size', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[close_size]',
		'id'    => 'close_size',
		'value' => isset( $param['close_size'] ) ? $param['close_size'] : '16',
		'min'   => '0',
		'step'  => '1',
	],
	'addon'   => [
		'unit' => 'px',
	],
	'tooltip' => esc_attr__( 'Sets close button size', $this->plugin['text'] ),
);

$close_text = array(
	'label'   => esc_attr__( 'Text', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[close_text]',
		'id'    => 'close_text',
		'value' => isset( $param['close_text'] ) ? $param['close_text'] : 'Close',
	],
	'tooltip' => esc_attr__( 'Sets the button text.', $this->plugin['text'] ),
);

$close_location = array(
	'label'   => esc_attr__( 'Location', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[close_location]',
		'id'    => 'close_location',
		'value' => isset( $param['close_location'] ) ? $param['close_location'] : '-topRight',
	],
	'options' => [
		'-topRight'    => esc_attr__( 'Top Right', $this->plugin['text'] ),
		'-topLeft'     => esc_attr__( 'Top Left', $this->plugin['text'] ),
		'-bottomRight' => esc_attr__( 'Bottom Right', $this->plugin['text'] ),
		'-bottomLeft'  => esc_attr__( 'Bottom Left', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Location the button.', $this->plugin['text'] ),
);

$close_place = array(
	'label'   => esc_attr__( 'Place', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[close_place]',
		'id'    => 'close_place',
		'value' => isset( $param['close_place'] ) ? $param['close_place'] : '',
	],
	'options' => [
		''       => esc_attr__( 'Inside', $this->plugin['text'] ),
		'-outer' => esc_attr__( 'Outside', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Places the button relative to the popup.', $this->plugin['text'] ),
);

$close_color = array(
	'label'   => esc_attr__( 'Color', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[close_color]',
		'id'    => 'close_color',
		'value' => isset( $param['close_color'] ) ? $param['close_color'] : '#383838',
	],
	'tooltip' => esc_attr__( 'Sets close button color', $this->plugin['text'] ),
);

$close_background = array(
	'label'   => esc_attr__( 'Background', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[close_background]',
		'id'    => 'close_background',
		'value' => isset( $param['close_background'] ) ? $param['close_background'] : '#00d1b2',
	],
	'tooltip' => esc_attr__( 'Sets close button background', $this->plugin['text'] ),
);
//endregion

//region Mobile
$mobile = array(
	'label'    => esc_attr__( 'Show on mobile', $this->plugin['text'] ),
	'attr'     => [
		'name'  => 'param[mobile]',
		'id'    => 'mobile',
		'value' => isset( $param['mobile'] ) ? $param['mobile'] : '480',
		'min'   => '0',
		'step'  => '1',
	],
	'checkbox' => [
		'name'  => 'param[mobile_checkbox]',
		'id'    => 'mobile_checkbox',
		'class' => 'checkLabel',
		'value' => isset( $param['mobile_checkbox'] ) ? $param['mobile_checkbox'] : 1,
	],
	'addon'    => [
		'unit' => 'px',
	],
	'tooltip'  => esc_attr__( 'Enables the popup on smaller devices and Sets the breakpoint for smaller devices.', $this->plugin['text'] ),
);

$mobile_width = array(
	'label'   => esc_attr__( 'Width', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[mobile_width]',
		'id'    => 'mobile_width',
		'value' => isset( $param['mobile_width'] ) ? $param['mobile_width'] : '100',
		'min'   => '0',
		'step'  => '1',
	],
	'addon'   => [
		'name'    => 'param[mobile_width_unit]',
		'value'   => isset( $param['mobile_width_unit'] ) ? $param['mobile_width_unit'] : '%',
		'options' => [
			'%'  => esc_attr__( '%', $this->plugin['text'] ),
			'px' => esc_attr__( 'px', $this->plugin['text'] ),
		],

	],
	'tooltip' => esc_attr__( 'Set the popup width on the mobile devices.', $this->plugin['text'] ),
);
//endregion