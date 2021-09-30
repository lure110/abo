<?php

function lahb_cart( $atts, $uniqid, $once_run_flag = true ) {

    if ( !$once_run_flag ){
        return '<div data-element-id="'.esc_attr( $uniqid ).'" class="lahb-element lahb-element--placeholder"></div>';
    }

    $com_uniqid = 'cart' . $uniqid;

	extract( LAHB_Helper::component_atts( array(
		'cart_icon'         => 'dl-icon-cart3',
		'cart_text'         => '',
		'show_tooltip'	    => 'false',
        'tooltip'	        => 'Cart',
        'tooltip_position'	=> 'tooltip-on-bottom',
		'extra_class'	    => '',
	), $atts ));



    $out = '';
    if(strlen($cart_icon) < 2){
        $cart_icon = 'dl-icon-cart3';
    }

    $icon = lahb_rename_icon($cart_icon);

    // tooltip
    $tooltip = $tooltip_class = '';
    if ( $show_tooltip == 'true' && !empty($tooltip_text) ) :
        
        $tooltip_position   = ( isset( $tooltip_position ) && $tooltip_position ) ? $tooltip_position : 'tooltip-on-bottom';
        $tooltip_class      = ' lahb-tooltip ' . $tooltip_position;
        $tooltip            = ' data-tooltip=" ' . esc_attr( LAHB_Helper::translate_string($tooltip_text, $com_uniqid) ) . ' "';

    endif;

    $cart_count = '';

    // styles
    if ( $once_run_flag ) :

        $dynamic_style = '';
        $dynamic_style .= lahb_styling_tab_output( $atts, 'icon', '#lastudio-header-builder .cart_' . esc_attr( $uniqid ) . ' > .la-cart-modal-icon .cart-i_icon i', '#lastudio-header-builder .cart_' . esc_attr( $uniqid ) . ':hover > .la-cart-modal-icon .cart-i_icon i'  );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'text', '#lastudio-header-builder .cart_' . esc_attr( $uniqid ) . ' .header-cart-text' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'counter', '#lastudio-header-builder .cart_' . esc_attr( $uniqid ) . ' .header-cart-count-icon' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'box', '#lastudio-header-builder .cart_' . esc_attr( $uniqid ) . '' );
        $dynamic_style .= lahb_styling_tab_output( $atts, 'tooltip', '#lastudio-header-builder .cart_' . esc_attr( $uniqid ) .'.lahb-tooltip[data-tooltip]:before' );

        if ( $dynamic_style ) :
            LAHB_Helper::set_dynamic_styles( $dynamic_style );
        endif;
    endif;

    // extra class
    $extra_class = $extra_class ? ' ' . $extra_class : '';

    $cart_url = '';
    $wc_cart_price = '';
    $wc_cart_item = '';
    if (LAHB_Helper::is_frontend_builder()) {
        $cart_count = 0;
    }
    else {
        if(function_exists('WC')){
            if(!WC()->cart->is_empty()){
                $cart_count = WC()->cart->get_cart_contents_count();
                $t_text = '<span class="la-cart-text">'. esc_html_x('%s items','front-view', 'lastudio-header-builder') .'</span>';
                $wc_cart_price = sprintf('<span class="la-cart-total-price">%s</span>', WC()->cart->get_cart_total());
                $wc_cart_item = sprintf($t_text, WC()->cart->get_cart_contents_count());
            }
            else{
                $cart_count = 0;
            }

            $cart_url = wc_get_cart_url();
        }
        else{
            $cart_count = 0;
        }
    }

    $c_text = '';
    if(!empty($cart_text)){
        $tmp_c_text = '';
        $tmp_c_text .= '<span class="header-cart-text">';
        $tmp_c_text .= esc_html( LAHB_Helper::translate_string($cart_text, $com_uniqid) );
        $tmp_c_text .= '</span>';
        $tmp_c_text = str_replace('[cart_price]', $wc_cart_price, $tmp_c_text);
        $tmp_c_text = str_replace('[cart_item]', $wc_cart_item, $tmp_c_text);
        $c_text = $tmp_c_text;
    }

    // render
    $out = '<div data-element-id="'.esc_attr( $uniqid ).'" class="lahb-element lahb-icon-wrap lahb-cart' . esc_attr( $tooltip_class . $extra_class ) . ' lahb-header-woo-cart-toggle cart_'.esc_attr( $uniqid ).'"' . $tooltip . '><a href="' . esc_url($cart_url) . '" class="la-cart-modal-icon lahb-icon-element hcolorf ">';
    $out .= '<span class="cart-i_icon"><span class="header-cart-count-icon colorb component-target-badget la-cart-count" data-cart_count= ' . $cart_count . ' >';
    $out .=  $cart_count;
    $out .= '</span><i data-icon="'.$icon.'" class="'.$icon.'"></i></span>';
    $out .= $c_text.'</a>';
    $out .= '</div>';
    return $out;

}

LAHB_Helper::add_element( 'cart', 'lahb_cart', ['tooltip'] );