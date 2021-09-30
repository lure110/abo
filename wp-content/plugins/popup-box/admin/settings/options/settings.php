<?php
/**
 * Notification settings parameters
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

//region Triggers

$triggers = array(
	'label'   => esc_attr__( 'Triggers', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[triggers]',
		'id'    => 'triggers',
		'value' => isset( $param['triggers'] ) ? $param['triggers'] : 'auto',
	],
	'options' => [
		'auto'     => esc_attr__( 'Auto', $this->plugin['text'] ),
		'click'    => esc_attr__( 'Click', $this->plugin['text'] ),
		'scrolled' => esc_attr__( 'Scrolled', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Select the trigger when the popup must be opening.', $this->plugin['text'] ),
	'func'    => 'popupType()',
);

$delay = array(
	'label'   => esc_attr__( 'Delay time', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[delay]',
		'id'    => 'delay',
		'value' => isset( $param['delay'] ) ? $param['delay'] : '0',
		'min'   => '0',
		'step'  => '1',
	],
	'addon'   => [
		'unit' => 'sec',
	],
	'tooltip' => esc_attr__( 'Delay time in seconds for opening the popup.', $this->plugin['text'] ),
);

$distance = array(
	'label'   => esc_attr__( 'Scroll distance', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[distance]',
		'id'    => 'distance',
		'value' => isset( $param['distance'] ) ? $param['distance'] : '50',
		'min'   => '0',
		'step'  => '1',
		'max'   => '100',
	],
	'addon'   => [
		'unit' => '%',
	],
	'tooltip' => esc_attr__( 'Scroll distance of the page in % for an opening popup.', $this->plugin['text'] ),
);

$cookie = array(
	'label'    => esc_attr__( 'Show only once', $this->plugin['text'] ),
	'attr'     => [
		'name'  => 'param[cookie]',
		'id'    => 'cookie',
		'value' => isset( $param['cookie'] ) ? $param['cookie'] : '1',
		'min'   => '0',
		'step'  => '1',
	],
	'checkbox' => [
		'name'  => 'param[cookie_checkbox]',
		'id'    => 'cookie_checkbox',
		'class' => 'checkLabel',
		'value' => isset( $param['cookie_checkbox'] ) ? $param['cookie_checkbox'] : 0,
	],
	'addon'    => [
		'unit' => 'days',
	],
	'tooltip'  => esc_attr__( 'Defines if the popup will set a cookie and hide it self for a period of time from the user.  Set the cookie in days.', $this->plugin['text'] ),
);

$block_page = array(
	'label'   => esc_attr__( 'Block the page', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[block_page]',
		'id'    => 'block_page',
		'value' => isset( $param['block_page'] ) ? $param['block_page'] : 0,
	],
	'tooltip' => esc_attr__( 'Block the page for scrolling.', $this->plugin['text'] ),
);
//endregion

//region Close Popup

$close_overlay = array(
	'label'   => esc_attr__( 'Overlay', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[close_overlay]',
		'id'    => 'close_overlay',
		'value' => isset( $param['close_overlay'] ) ? $param['close_overlay'] : 1,
	],
	'tooltip' => esc_attr__( 'Defines if the overlay can close the popup.', $this->plugin['text'] ),
);

$close_Esc = array(
	'label'   => esc_attr__( 'Esc', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[close_Esc]',
		'id'    => 'close_Esc',
		'value' => isset( $param['close_Esc'] ) ? $param['close_Esc'] : 1,
	],
	'tooltip' => esc_attr__( 'Enabled the ESC key to close the popup.', $this->plugin['text'] ),
);

//endregion

