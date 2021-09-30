<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_airi_preset_home_21()
{
    return array(

        array(
            'filter_name' => 'airi/setting/option/get_single',
            'filter_func' => function( $value, $key ){
                if( $key == 'la_custom_css'){
                    $value .= '
.site-footer ul li {
    text-transform: uppercase;
}
.site-footer .la-contact-info .la-contact-item {
    text-transform: uppercase;
}
.site-footer .la-contact-info .la-contact-item:before {
    color: #d2a35c;
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