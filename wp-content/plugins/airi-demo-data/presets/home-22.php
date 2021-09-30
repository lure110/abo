<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_airi_preset_home_22()
{
    return array(

        array(
            'key' => 'footer_background',
            'value' => array(
                'image' => '',
                'color' => '#fff'
            )
        ),

        array(
            'key' => 'footer_space',
            'value' => array(
                'padding_top' => '35px',
                'padding_bottom' => '5px'
            )
        ),

        array(
            'key' => 'footer_text_color',
            'value' => '#707070'
        ),
        array(
            'key' => 'footer_link_color|footer_heading_color',
            'value' => '#1D1D1D'
        ),

        array(
            'key' => 'footer_copyright',
            'value' => '<div class="row"><div class="col-xs-12 col-md-6"><div class="font-size-11">© 2019 AIRI All rights reserved. Designed by LA-STUDIO</div></div><div class="col-xs-12 col-md-6"><div class="text-right"><img src="https://airi.la-studioweb.com/furniture/wp-content/uploads/sites/2/2019/08/payment-method-2.png" alt="Accept Payment Method"/></div></div></div>'
        ),

        array(
            'filter_name' => 'airi/filter/footer_column_1',
            'value' => 'f-col-5'
        ),
        array(
            'filter_name' => 'airi/filter/footer_column_4',
            'value' => 'f-col-6'
        ),

        array(
            'filter_name' => 'airi/setting/option/get_single',
            'filter_func' => function( $value, $key ){
                if( $key == 'la_custom_css'){
                    $value .= '
.footer-bottom .footer-bottom-inner {
    border-top: 1px solid #D8D8D8;
}
.footer-bottom{
    position: static
}
.footer-top .widget .widget-title {
    letter-spacing: 1px;
}
@media(min-width: 1200px){
#colophon .container {
    width: 1400px;
    max-width: 96%;
}
}
';
                }
                return $value;
            },
            'filter_priority'  => 10,
            'filter_args'  => 2
        ),
    );
}