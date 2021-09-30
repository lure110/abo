<?php
/**
 * Shortcode Generation options
 *
 * @package     WP_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$shortcode_type = array(
	'label'   => esc_attr__( 'Shortcode Type', $this->plugin['text'] ),
	'attr'    => [
		'id'    => 'shortcode_type',
		'value' => 'button',
	],
	'options' => [
		'button' => esc_attr__( 'Button', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Select the shortcode type.', $this->plugin['text'] ),
);


//region Shortcode Button
$shortcode_btn_type = array(
	'label'   => esc_attr__( 'Button Type', $this->plugin['text'] ),
	'attr'    => [
		'id'    => 'shortcode_btn_type',
		'value' => 'close',
	],
	'options' => [
		'close' => esc_attr__( 'Popup Close Button', $this->plugin['text'] ),
		'link'  => esc_attr__( 'Button with Link', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Set the type of the popup button', $this->plugin['text'] ),
);

$shortcode_btn_size = array(
	'label'   => esc_attr__( 'Button Size', $this->plugin['text'] ),
	'attr'    => [
		'id'    => 'shortcode_btn_size',
		'value' => 'normal',
	],
	'options' => [
		'small'  => esc_attr__( 'Small', $this->plugin['text'] ),
		'normal' => esc_attr__( 'Normal', $this->plugin['text'] ),
		'medium' => esc_attr__( 'Medium', $this->plugin['text'] ),
		'large'  => esc_attr__( 'Large', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Select the size of the button.', $this->plugin['text'] ),
);

$shortcode_btn_fullwidth = array(
	'label'   => esc_attr__( 'Full Width', $this->plugin['text'] ),
	'attr'    => [
		'id'    => 'shortcode_btn_fullwidth',
		'value' => isset( $param['shortcode_btn_fullwidth'] ) ? $param['shortcode_btn_fullwidth'] : '',
	],
	'options' => [
		'' => esc_attr__( 'No', $this->plugin['text'] ),
		'yes' => esc_attr__( 'Yes', $this->plugin['text'] ),
	],
	'tooltip'    => esc_attr__( 'Set the fullwidth option for button.', $this->plugin['text'] ),
);

$shortcode_btn_text = array(
	'label'   => esc_attr__( 'Button Text', $this->plugin['text'] ),
	'attr'    => [
		'name'        => 'param[shortcode_btn_text]',
		'id'          => 'shortcode_btn_text',
		'value'       => 'Close Popup',
		'placeholder' => esc_attr__( 'Enter Text', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Set the text for button.', $this->plugin['text'] ),
);

$shortcode_btn_color = array(
	'label'   => esc_attr__( 'Text Color', $this->plugin['text'] ),
	'attr'    => [
		'id'    => 'shortcode_btn_color',
		'value' => '#ffffff',
	],
	'tooltip' => esc_attr__( 'Set the color for button text.', $this->plugin['text'] ),
);

$shortcode_btn_bgcolor = array(
	'label'   => esc_attr__( 'Background Color', $this->plugin['text'] ),
	'attr'    => [
		'id'    => 'shortcode_btn_bgcolor',
		'value' => '#00d1b2',
	],
	'tooltip' => esc_attr__( 'Set the color for button background.', $this->plugin['text'] ),
);

$shortcode_btn_link = array(
	'label'   => esc_attr__( 'Link', $this->plugin['text'] ),
	'attr'    => [
		'id'          => 'shortcode_btn_link',
		'value'       => '',
		'placeholder' => esc_attr__( 'Enter URL', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Enter the URL for button link', $this->plugin['text'] ),
);

$shortcode_btn_target = array(
	'label'   => esc_attr__( 'Target', $this->plugin['text'] ),
	'attr'    => [
		'id'    => 'shortcode_btn_target',
		'value' => '_blank',
	],
	'options' => [
		'_blank' => esc_attr__( 'New tab', $this->plugin['text'] ),
		'_self'  => esc_attr__( 'Same tab', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Target for opening the URL.', $this->plugin['text'] ),
);
//endregion
