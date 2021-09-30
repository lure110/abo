<?php

if(!function_exists('airi_override_yikes_mailchimp_page_data')){
    function airi_override_yikes_mailchimp_page_data($page_data, $form_id){
        $new_data = new stdClass();
        if(isset($page_data->ID)){
            $new_data->ID = $page_data->ID;
        }
        return $new_data;
    }
    add_filter('yikes-mailchimp-page-data', 'airi_override_yikes_mailchimp_page_data', 10, 2);
}

if(!function_exists('airi_override_theme_default')){
    function airi_override_theme_default(){
        $header_layout = Airi()->layout()->get_header_layout();
        $title_layout = Airi()->layout()->get_page_title_bar_layout();
        if($header_layout == 'default' && (empty($title_layout) || $title_layout == 'hide') && !is_404()) :
            ?>
            <div class="page-title-section">
                <?php
                if(!empty(Airi()->breadcrumbs())){
                    echo Airi()->breadcrumbs()->get_title();
                }
                do_action('airi/action/breadcrumbs/render_html');
                ?>
            </div>
            <?php
        endif;
    }
    add_action('airi/action/before_render_main_inner', 'airi_override_theme_default');
}

if(!function_exists('airi_override_dokan_main_query')){
    function airi_override_dokan_main_query( $query ) {
        if(function_exists('dokan_is_store_page') && dokan_is_store_page() && isset($query->query['term_section'])){
            $query->set('posts_per_page', 0);
            WC()->query->product_query( $query );
        }
    }
    add_action('pre_get_posts', 'airi_override_dokan_main_query', 11);
}


if(!function_exists('airi_dokan_dashboard_wrap_before')){
    function airi_dokan_dashboard_wrap_before(){
        echo '<div id="main" class="site-main"><div class="container"><div class="row"><main id="site-content" class="col-md-12 col-xs-12 site-content">';
    }
    add_filter('dokan_dashboard_wrap_before', 'airi_dokan_dashboard_wrap_before');
}

if(!function_exists('airi_dokan_dashboard_wrap_after')){
    function airi_dokan_dashboard_wrap_after(){
        echo '</main></div></div></div>';
    }
    add_filter('dokan_dashboard_wrap_after', 'airi_dokan_dashboard_wrap_after');
}


/**
 * @desc: adding the custom badges to product
 * @since: 1.0.3
 */

if(!function_exists('airi_add_custom_badge_for_product')){
    function airi_add_custom_badge_for_product(){
        global $product;
        $product_badges = Airi()->settings()->get_post_meta( $product->get_id(), 'product_badges' );
        if(empty($product_badges)){
            return;
        }
        $_tmp_badges = array();
        foreach($product_badges as $badge){
            if(!empty($badge['text'])){
                $_tmp_badges[] = $badge;
            }
        }
        if(empty($_tmp_badges)){
            return;
        }
        foreach($_tmp_badges as $i => $badge){
            $attribute = array();
            if(!empty($badge['bg'])){
                $attribute[] = 'background-color:' . esc_attr($badge['bg']);
            }
            if(!empty($badge['color'])){
                $attribute[] = 'color:' . esc_attr($badge['color']);
            }
            $el_class = ($i%2==0) ? 'odd' : 'even';
            if(!empty($badge['el_class'])){
                $el_class .= ' ';
                $el_class .= $badge['el_class'];
            }

            echo sprintf(
                '<span class="la-custom-badge %1$s" style="%3$s"><span>%2$s</span></span>',
                esc_attr($el_class),
                esc_html($badge['text']),
                (!empty($attribute) ? esc_attr(implode(';', $attribute)) : '')
            );
        }
    }
    add_action( 'woocommerce_before_shop_loop_item_title', 'airi_add_custom_badge_for_product', 9 );
    add_action( 'woocommerce_before_single_product_summary', 'airi_add_custom_badge_for_product', 9 );
}

/**
 * @desc: kick-off the function when theme has new version
 * @since: 1.0.0
 */
if(!function_exists('airi_hook_update_the_theme')){
    function airi_hook_update_the_theme(){
        $current_version = get_option('airi_opts_db_version', false);
        if( class_exists('LaStudio_Cache_Helper') && version_compare( '1.0.0', $current_version) > 0 ) {
            LaStudio_Cache_Helper::get_transient_version('icon_library', true);
            $current_version = '1.0.0';
            update_option('airi_opts_db_version', $current_version);
        }
    }
    add_action( 'after_setup_theme', 'airi_hook_update_the_theme', 0 );
}

/*
 * @desc: custom block after add-to-cart on single product page
 * @since: 1.0.0
 */
if(!function_exists('airi_custom_block_after_add_cart_form_on_single_product')){
    function airi_custom_block_after_add_cart_form_on_single_product(){
        if(is_active_sidebar('s-p-after-add-cart')){
            echo '<div class="extradiv-after-frm-cart">';
            dynamic_sidebar('s-p-after-add-cart');
            echo '</div>';
            echo '<div class="clearfix"></div>';
        }
    }
    add_action('woocommerce_single_product_summary', 'airi_custom_block_after_add_cart_form_on_single_product', 52);
}

if(!function_exists('airi_override_portfolio_content_type_args')){
    function airi_override_portfolio_content_type_args( $args, $post_type_name ) {
        if($post_type_name == 'la_portfolio'){
            $label = esc_html(Airi()->settings()->get('portfolio_custom_name'));
            $label2 = esc_html(Airi()->settings()->get('portfolio_custom_name2'));
            $slug = sanitize_title(Airi()->settings()->get('portfolio_custom_slug'));
            if(!empty($label)){
                $args['label'] = $label;
                $args['labels']['name'] = $label;
            }
            if(!empty($label2)){
                $args['labels']['singular_name'] = $label2;
            }
            if(!empty($slug)){
                if(!empty($args['rewrite'])){
                    $args['rewrite']['slug'] = $slug;
                }
                else{
                    $args['rewrite'] = array( 'slug' => $slug );
                }
            }
        }

        return $args;
    }
    add_filter('register_post_type_args', 'airi_override_portfolio_content_type_args', 99, 2);
}

if(!function_exists('airi_override_portfolio_tax_type_args')){
    function airi_override_portfolio_tax_type_args( $args, $tax_name ) {

        if( $tax_name == 'la_portfolio_category' ) {
            $label = esc_html(Airi()->settings()->get('portfolio_cat_custom_name'));
            $label2 = esc_html(Airi()->settings()->get('portfolio_cat_custom_name2'));
            $slug = sanitize_title(Airi()->settings()->get('portfolio_cat_custom_slug'));
            if(!empty($label)){
                $args['labels']['name'] = $label;
            }
            if(!empty($label2)){
                $args['labels']['singular_name'] = $label2;
            }
            if(!empty($slug)){
                if(!empty($args['rewrite'])){
                    $args['rewrite']['slug'] = $slug;
                }
                else{
                    $args['rewrite'] = array( 'slug' => $slug );
                }
            }
        }
        else if( $tax_name == 'la_portfolio_skill' ) {
            $label = esc_html(Airi()->settings()->get('portfolio_skill_custom_name'));
            $label2 = esc_html(Airi()->settings()->get('portfolio_skill_custom_name2'));
            $slug = sanitize_title(Airi()->settings()->get('portfolio_skill_custom_slug'));
            if(!empty($label)){
                $args['labels']['name'] = $label;
            }
            if(!empty($label2)){
                $args['labels']['singular_name'] = $label2;
            }
            if(!empty($slug)){
                if(!empty($args['rewrite'])){
                    $args['rewrite']['slug'] = $slug;
                }
                else{
                    $args['rewrite'] = array( 'slug' => $slug );
                }
            }
        }

        return $args;
    }
    add_filter('register_taxonomy_args', 'airi_override_portfolio_tax_type_args', 99, 2);
}



/*
 * @desc: Ensure that a specific theme is never updated. This works by removing the theme from the list of available updates.
 * @since: 1.0.1
 */

add_filter('http_request_args', 'airi_hidden_theme_update_from_repository', 10, 2);
if(!function_exists('airi_hidden_theme_update_from_repository')){
    function airi_hidden_theme_update_from_repository( $response, $url ){
        $pos = strpos($url, '//api.wordpress.org/themes/update-check');
        if($pos === 5 || $pos === 6){
            $themes = json_decode( $response['body']['themes'], true );
            if(isset($themes['themes']['airi'])){
                unset($themes['themes']['airi']);
            }
            if(isset($themes['themes']['airi-child'])){
                unset($themes['themes']['airi-child']);
            }
            $response['body']['themes'] = json_encode( $themes );
        }
        return $response;
    }
}

/**
 * @desc: Support book store
 */

if(!function_exists('airi_is_wcbs')){
    function airi_is_wcbs(){
        return taxonomy_exists('pa_writer') && taxonomy_exists('pa_format');
    }
}

if(!function_exists('airi_wcbs_add_writer_to_the_product_list')){
    function airi_wcbs_add_writer_to_the_product_list(){
        global $product;
        if(($writer = $product->get_attribute('pa_writer')) && !empty($writer)){
            printf(
                '<div class="product_item--writer"><span>%1$s </span></span><a href="%2$s">%3$s</a></div>',
                esc_html_x('by', 'front-view', 'airi'),
                $product->get_permalink(),
                esc_html( $writer )
            );
        }
    }
}
add_filter('woocommerce_shop_loop_item_title', 'airi_wcbs_add_writer_to_the_product_list');

if(!function_exists('airi_lahb_add_icon_to_libs')){

    add_filter('lastudio/header-builder/all-icons', 'airi_lahb_add_icon_to_libs');

    function airi_lahb_add_icon_to_libs( $icons ){
        $dlicons = array("dl-icon-heart","dl-icon-search1","dl-icon-cart1","dl-icon-menu1","dl-icon-heart2","dl-icon-compare1","dl-icon-compare2","dl-icon-compare3","dl-icon-compare4","dl-icon-menu2","dl-icon-cart2","dl-icon-search3","dl-icon-search2","dl-icon-close","dl-icon-clock","dl-icon-stats1","dl-icon-search4","dl-icon-search5","dl-icon-search6","dl-icon-search7","dl-icon-search8","dl-icon-search9","dl-icon-comment1","dl-icon-cart3","dl-icon-cart4","dl-icon-cart5","dl-icon-cart6","dl-icon-cart7","dl-icon-cart8","dl-icon-cart9","dl-icon-cart10","dl-icon-cart11","dl-icon-cart12","dl-icon-cart13","dl-icon-cart14","dl-icon-cart15","dl-icon-cart16","dl-icon-cart17","dl-icon-cart18","dl-icon-cart19","dl-icon-cart20","dl-icon-cart21","dl-icon-cart22","dl-icon-cart23","dl-icon-cart24","dl-icon-cart25","dl-icon-cart26","dl-icon-heart3","dl-icon-comment","dl-icon-user1","dl-icon-user2","dl-icon-user3","dl-icon-user4","dl-icon-user5","dl-icon-user6","dl-icon-user7","dl-icon-user8","dl-icon-user9","dl-icon-user10","dl-icon-user11","dl-icon-dress","dl-icon-pumps","dl-icon-tshirt","dl-icon-diamon","dl-icon-key","dl-icon-cart27","dl-icon-cart28","dl-icon-menu3","dl-icon-user12","dl-icon-search10","dl-icon-star","dl-icon-down","dl-icon-left","dl-icon-right","dl-icon-up","dl-icon-check","dl-icon-android-add","dl-icon-plus-circled","dl-icon-zoom-in","dl-icon-menu5","dl-icon-menu4","dl-icon-format-video","dl-icon-format-image","dl-icon-format-gallery","dl-icon-format-music","dl-icon-format-link","dl-icon-format-quote","dl-icon-view-1","dl-icon-view","dl-icon-cart29","dl-icon-heart4","dl-icon-compare", "dl-icon-check-circle1", "dl-icon-check-circle2", "dl-icon-cart30", "dl-icon-search-list");
        return array_merge($icons, $dlicons);
    }
}

if(!function_exists('airi_lahb_filter_logo_id')){
    add_filter('LaStudio_Builder/logo_id', 'airi_lahb_filter_logo_id');
    function airi_lahb_filter_logo_id( $value ){
        $value = Airi()->settings()->get('logo', false);
        return $value;
    }
}

if(!function_exists('airi_lahb_filter_logo_transparency_id')){
    add_filter('LaStudio_Builder/logo_transparency_id', 'airi_lahb_filter_logo_transparency_id');
    function airi_lahb_filter_logo_transparency_id( $value ){
        $value = Airi()->settings()->get('logo_transparency', false);
        return $value;
    }
}


if(!function_exists('airi_wc_add_qty_control_plus')){
    function airi_wc_add_qty_control_plus(){
        echo '<span class="qty-plus">+</span>';
    }
}

if(!function_exists('airi_wc_add_qty_control_minus')){
    function airi_wc_add_qty_control_minus(){
        echo '<span class="qty-minus">-</span>';
    }
}

add_action('woocommerce_after_quantity_input_field', 'airi_wc_add_qty_control_plus');
add_action('woocommerce_before_quantity_input_field', 'airi_wc_add_qty_control_minus');

add_action('LaStudio_Builder/UpdateDynamicStrings', 'airi_lahb_action_publish_header');
if(!function_exists('airi_lahb_action_publish_header')){
    function airi_lahb_action_publish_header(){
        $all_option = Airi()->settings()->get_all();
        $all_option['enable_header_builder'] = 'yes';
        update_option(Airi::get_option_name(), $all_option);
    }
}

add_action( 'wp_ajax_lastudio_ig_feed', 'airi_ajax_get_ig_feed' );
add_action( 'wp_ajax_nopriv_lastudio_ig_feed', 'airi_ajax_get_ig_feed' );

if(!function_exists('airi_ajax_get_ig_feed')){
    function airi_ajax_get_ig_feed(){
        // check token first;
        $token = Airi()->settings()->get('instagram_token', '');
        if(empty($token)){
            wp_send_json_error(['msg' => __('Invalid Token', 'airi')]);
        }
        $life_time = get_transient('lastudio_ig_token');
        if(empty($life_time)){
            $ig_refresh_token_url = add_query_arg([
                'grant_type' => 'ig_refresh_token',
                'access_token' => $token
            ], 'https://graph.instagram.com/refresh_access_token');
            $response = wp_remote_get($ig_refresh_token_url);
            // request failed
            if ( is_wp_error( $response ) ) {
                wp_send_json_error(['msg' => __('Invalid Token [1]', 'airi')]);
            }
            $code = (int) wp_remote_retrieve_response_code( $response );
            if ( $code !== 200 ) {
                wp_send_json_error(['msg' => __('Invalid Token [2]', 'airi')]);
            }
            $body = wp_remote_retrieve_body($response);
            $body = json_decode($body, true);
            $expires_in = (int) $body['expires_in'] - DAY_IN_SECONDS;
            if($expires_in > 0){
                $token = $body['access_token'];
                $all_option = get_option(Airi::get_option_name(), []);
                $all_option['instagram_token'] = $token;
                update_option(Airi::get_option_name(), $all_option);
                set_transient('lastudio_ig_token', $body , $expires_in);
            }
            else{
                wp_send_json_error(['msg' => __('Token Expired [3]', 'airi')]);
            }
        }

        $cache = get_transient('lastudio_ig_feed');
        if(empty($cache)){
            $ig_feed_url = add_query_arg([
                'fields'        => 'caption,media_type,media_url,thumbnail_url,permalink,timestamp',
                'access_token'  => $token,
                'limit'         => 20
            ], 'https://graph.instagram.com/me/media');

            $response = wp_remote_get($ig_feed_url);
            if ( is_wp_error( $response ) ) {
                wp_send_json_error(['msg' => __('Invalid Token [4]', 'airi')]);
            }
            $code = (int) wp_remote_retrieve_response_code( $response );
            if ( $code !== 200 ) {
                wp_send_json_error(['msg' => __('Invalid Token [5]', 'airi')]);
            }
            $data = wp_remote_retrieve_body($response);
            $data = json_decode($data, true);
            $cache = $data['data'];
            set_transient('lastudio_ig_feed', $cache, HOUR_IN_SECONDS * 12);
        }
        if(empty($cache)){
            wp_send_json_error(['msg' => __('Invalid Token [6]', 'airi')]);
        }
        else{
            wp_send_json_success($cache);
        }
    }
}
