<?php

/**
 * Child Theme Function
 *
 */

add_action( 'after_setup_theme', 'airi_child_theme_setup' );
add_action( 'wp_enqueue_scripts', 'airi_child_enqueue_styles', 20);

if( !function_exists('airi_child_enqueue_styles') ) {
    function airi_child_enqueue_styles() {
        wp_enqueue_style( 'airi-child-style',
            get_stylesheet_directory_uri() . '/style.css',
            array( 'airi-theme' ),
            wp_get_theme()->get('Version')
        );

    }
}
add_action( 'wp_enqueue_scripts', 'airi_child_scripts' );
/**
 * Enqueue scripts and styles.
 */
function airi_child_scripts() {
   wp_enqueue_script( 'airi-child', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), false, true );
}


if( !function_exists('airi_child_theme_setup') ) {
    function airi_child_theme_setup() {
        load_child_theme_textdomain( 'airi-child', get_stylesheet_directory() . '/languages' );
    }
}
/* Iskirti kategorijas kuriu nerodytu*/
add_filter( 'get_terms', 'ts_get_subcategory_terms', 10, 3 );
function ts_get_subcategory_terms( $terms, $taxonomies, $args ) {
$new_terms = array();
// if it is a product category and on the shop page
if ( in_array( 'product_cat', $taxonomies ) && ! is_admin() &&is_shop() && is_front_page() ) {
foreach( $terms as $key => $term ) {
if ( !in_array( $term->slug, array( 'kita','mod' ) ) ) { //pass the slug name here
$new_terms[] = $term;
}}
$terms = $new_terms;
}
return $terms;
}

/* Iskirti kategorijas ir ju produktus kad nerodytu*/
add_action( 'woocommerce_product_query', 'ts_custom_pre_get_posts_query' );
function ts_custom_pre_get_posts_query( $q ) {
$tax_query = (array) $q->get( 'tax_query' );
$tax_query[] = array(
'taxonomy' => 'product_cat',
'field' => 'slug',
'terms' =>array( 'kita','mod'), // Don't display products in the clothing category on the shop page.
'operator' => 'NOT IN'
);
$q->set( 'tax_query', $tax_query );
}
