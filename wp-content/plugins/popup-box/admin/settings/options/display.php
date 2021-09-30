<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Tergeting settings
 *
 * @package     Wow_Plugin
 * @subpackage  Settings
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */


//region Display
$show_option = array(
	'all'        => esc_attr__( 'All posts and pages', $this->plugin['text'] ),
	'onlypost'   => esc_attr__( 'All posts', $this->plugin['text'] ),
	'onlypage'   => esc_attr__( 'All pages', $this->plugin['text'] ),
	'posts'      => esc_attr__( 'Posts with certain IDs', $this->plugin['text'] ),
	'pages'      => esc_attr__( 'Pages with certain IDs', $this->plugin['text'] ),
	'postsincat' => esc_attr__( 'Posts in Categorys with IDs', $this->plugin['text'] ),
	'expost'     => esc_attr__( 'All posts. except...', $this->plugin['text'] ),
	'expage'     => esc_attr__( 'All pages, except...', $this->plugin['text'] ),
);

$show = array(
	'label'   => esc_attr__( 'Display on', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[show]',
		'id'    => 'show',
		'value' => isset( $param['show'] ) ? $param['show'] : 'all',
	],
	'options' => $show_option,
	'tooltip' => esc_attr__( 'Choose a condition to target to specific content.', $this->plugin['text'] ),
	'icon'    => '',
	'func'    => 'showChange()',
);

$id_post = array(
	'label'   => esc_attr__( 'ID\'s', $this->plugin['text'] ),
	'attr'    => [
		'name'        => 'param[id_post]',
		'id'          => 'id_post',
		'value'       => isset( $param['id_post'] ) ? $param['id_post'] : '',
		'placeholder' => esc_attr__( 'Enter IDs, separated by comma.', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'Enter IDs, separated by comma.', $this->plugin['text'] ),
);
//endregion

//region Other
$test_mode = array(
	'label'   => esc_attr__( 'Test mode', $this->plugin['text'] ),
	'attr'    => [
		'name'  => 'param[test_mode]',
		'id'    => 'test_mode',
		'value' => isset( $param['test_mode'] ) ? $param['test_mode'] : 'no',
	],
	'options' => [
		'no'  => esc_attr__( 'No', $this->plugin['text'] ),
		'yes' => esc_attr__( 'Yes', $this->plugin['text'] ),
	],
	'tooltip' => esc_attr__( 'If test mode is enabled, the notification will show for admin only', $this->plugin['text'] ),
);
//endregion