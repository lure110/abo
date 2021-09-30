<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


$shortcode_params = array(

    LaStudio_Shortcodes_Helper::fieldColumn(array(
        'heading' 		=> __('Items to show', 'lastudio')
    )),
    LaStudio_Shortcodes_Helper::getParamItemSpace(array(
        'std' => 'default'
    )),

    array(
        'type'       => 'checkbox',
        'heading'    => __('Enable slider', 'lastudio' ),
        'param_name' => 'enable_carousel',
        'value'      => array( __( 'Yes', 'lastudio' ) => 'yes' )
    ),

    array(
        'type' => 'textfield',
        'heading' => __('Limit', 'lastudio'),
        'description' => __('Maximum number of Images to add. Max of 20', 'lastudio'),
        'param_name' => 'limit',
        'admin_label' => true,
        'value' => 5
    ),

    array(
        'type' => 'dropdown',
        'heading' => __('Image Aspect Ration','lastudio'),
        'param_name' => 'image_aspect_ration',
        'value' => array(
            __('1:1','lastudio') => '11',
            __('16:9','lastudio') => '169',
            __('4:3','lastudio') => '43',
            __('2.35:1','lastudio') => '2351'
        ),
        'std' => '11'
    ),
    LaStudio_Shortcodes_Helper::fieldExtraClass()
);

$carousel = LaStudio_Shortcodes_Helper::paramCarouselShortCode(false);
$slides_column_idx = LaStudio_Shortcodes_Helper::getParamIndex( $carousel, 'slides_column');
if($slides_column_idx){
    unset($carousel[$slides_column_idx]);
}

$shortcode_params = array_merge( $shortcode_params, $carousel);

return apply_filters(
    'LaStudio/shortcodes/configs',
    array(
        'name'			=> __('Instagram Feed', 'lastudio'),
        'base'			=> 'la_instagram_feed',
        'icon'          => 'la-wpb-icon la_instagram_feed',
        'category'  	=> __('La Studio', 'lastudio'),
        'description'   => __('Display Instagram photos from any non-private Instagram accounts', 'lastudio'),
        'params' 		=> $shortcode_params
    ),
    'la_instagram_feed'
);