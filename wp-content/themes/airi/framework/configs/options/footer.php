<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


/**
 * Footer settings
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function airi_options_section_footer( $sections )
{
    $sections['footer'] = array(
        'name'          => 'footer_panel',
        'title'         => esc_html_x('Footer', 'admin-view', 'airi'),
        'icon'          => 'fa fa-arrow-down',
        'sections' => array(
            array(
                'name'      => 'footer_layout_sections',
                'title'     => esc_html_x('Layout', 'admin-view', 'airi'),
                'icon'      => 'fa fa-cog fa-spin',
                'fields'    => array(
                    array(
                        'id'        => 'footer_layout',
                        'type'      => 'image_select',
                        'default'   => '1col',
                        'title'     => esc_html_x('Footer Layout', 'admin-view', 'airi'),
                        'radio'     => true,
                        'options'   => Airi_Options::get_config_footer_layout_opts()
                    ),
                    array(
                        'id'        => 'enable_footer_top',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'no',
                        'title'     => esc_html_x('Enable Footer Top Area', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('Turn on to display widget in the Footer Top Area', 'admin-view', 'airi'),
                        'options'   => Airi_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'        => 'footer_full_width',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'no',
                        'title'     => esc_html_x('100% Footer Width', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('Turn on to have the footer area display at 100% width according to the window size. Turn off to follow site width.', 'admin-view', 'airi'),
                        'options'   => Airi_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'        => 'enable_footer_copyright',
                        'type'      => 'radio',
                        'class'     => 'la-radio-style',
                        'default'   => 'yes',
                        'title'     => esc_html_x('Enable Footer Copyright', 'admin-view', 'airi'),
                        'options'   => Airi_Options::get_config_radio_opts(false)
                    ),
                    array(
                        'id'        => 'footer_copyright',
                        'type'      => 'code_editor',
                        'editor_setting'    => array(
                            'type' => 'text/html',
                            'codemirror' => array(
                                'indentUnit' => 2,
                                'tabSize' => 2
                            )
                        ),
                        'title'     => esc_html_x('Footer Copyright', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('Paste your custom HTML code here.', 'admin-view', 'airi')
                    ),
                    array(
                        'id'        => 'enable_header_mb_footer_bar',
                        'type'      => 'radio',
                        'default'   => 'no',
                        'class'     => 'la-radio-style',
                        'title'     => esc_html_x('Enable Mobile Footer Bar?', 'admin-view', 'airi'),
                        'options'   => array(
                            'no'            => esc_html_x('Hide', 'admin-view', 'airi'),
                            'yes'           => esc_html_x('Yes', 'admin-view', 'airi')
                        )
                    ),
                    array(
                        'id'        => 'header_mb_footer_bar_component',
                        'type'      => 'group',
                        'wrap_class'=> 'group-disable-clone',
                        'title'     => esc_html_x('Header Mobile Footer Bar Component', 'admin-view', 'airi'),
                        'button_title'    => esc_html_x('Add Icon Component ','admin-view', 'airi'),
                        'dependency'    => array('enable_header_mb_footer_bar_yes', '==', true),
                        'accordion_title' => 'type',
                        'max_item'  => 4,
                        'fields'    => array(
                            array(
                                'id'        => 'type',
                                'type'      => 'select',
                                'title'     => esc_html_x('Type', 'admin-view', 'airi'),
                                'options'  => array(
                                    'dropdown_menu'     => esc_html_x('Dropdown Menu', 'admin-view', 'airi'),
                                    'text'              => esc_html_x('Custom Text', 'admin-view', 'airi'),
                                    'link_icon'         => esc_html_x('Icon with link', 'admin-view', 'airi'),
                                    'search_1'          => esc_html_x('Search box style 01', 'admin-view', 'airi'),
                                    'cart'              => esc_html_x('Cart Icon', 'admin-view', 'airi'),
                                    'wishlist'          => esc_html_x('Wishlist Icon', 'admin-view', 'airi'),
                                    'compare'           => esc_html_x('Compare Icon', 'admin-view', 'airi')
                                )
                            ),
                            array(
                                'id'            => 'icon',
                                'type'          => 'icon',
                                'default'       => 'fa fa-share',
                                'title'         => esc_html_x('Custom Icon', 'admin-view', 'airi'),
                                'dependency'    => array( 'type', '!=', 'search_1|primary_menu' )
                            ),
                            array(
                                'id'            => 'text',
                                'type'          => 'text',
                                'title'         => esc_html_x('Custom Text', 'admin-view', 'airi'),
                                'dependency'    => array( 'type', 'any', 'text,link_text' )
                            ),
                            array(
                                'id'            => 'link',
                                'type'          => 'text',
                                'default'       => '#',
                                'title'         => esc_html_x('Link (URL)', 'admin-view', 'airi'),
                                'dependency'    => array( 'type', '!=', 'search_1|primary_menu' )
                            ),
                            array(
                                'id'            => 'menu_id',
                                'type'          => 'select',
                                'title'         => esc_html_x('Select the menu','admin-view', 'airi'),
                                'class'         => 'chosen',
                                'options'       => 'tags',
                                'query_args'    => array(
                                    'orderby'   => 'name',
                                    'order'     => 'ASC',
                                    'taxonomies'=>  'nav_menu',
                                    'hide_empty'=> false
                                ),
                                'dependency'    => array( 'type', '==', 'dropdown_menu' )
                            ),
                            array(
                                'id'            => 'el_class',
                                'type'          => 'text',
                                'default'       => '',
                                'title'         => esc_html_x('Extra CSS class for item', 'admin-view', 'airi')
                            )
                        )
                    ),
                    array(
                        'id'        => 'enable_header_mb_footer_bar_sticky',
                        'type'      => 'radio',
                        'default'   => 'always',
                        'class'     => 'la-radio-style',
                        'title'     => esc_html_x('Header Mobile Footer Bar Sticky', 'admin-view', 'airi'),
                        'dependency'    => array('enable_header_mb_footer_bar_yes', '==', true),
                        'options'   => array(
                            'always'        => esc_html_x('Always Display', 'admin-view', 'airi'),
                            'up'            => esc_html_x('Display when scroll up', 'admin-view', 'airi'),
                            'down'          => esc_html_x('Display when scroll down', 'admin-view', 'airi')
                        )
                    ),
                )
            ),
            array(
                'name'      => 'footer_styling_sections',
                'title'     => esc_html_x('Footer Styling', 'admin-view', 'airi'),
                'icon'      => 'fa fa-paint-brush',
                'fields'    => array(
                    array(
                        'id'        => 'footer_background',
                        'type'      => 'background',
                        'title'     => esc_html_x('Background', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'airi')
                    ),
                    array(
                        'id'        => 'footer_space',
                        'type'      => 'canvas',
                        'options'   => array(
                            'radius' => false
                        ),
                        'title'     => esc_html_x('Footer Space', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'airi')
                    ),
                    array(
                        'id'        => 'footer_text_color',
                        'type'      => 'color_picker',
                        'default'   => Airi_Options::get_color_default('text_color'),
                        'title'     => esc_html_x('Text Color', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'airi')
                    ),
                    array(
                        'id'        => 'footer_heading_color',
                        'type'      => 'color_picker',
                        'default'   => Airi_Options::get_color_default('heading_color'),
                        'title'     => esc_html_x('Heading Color', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'airi')
                    ),
                    array(
                        'id'        => 'footer_link_color',
                        'type'      => 'color_picker',
                        'default'   => Airi_Options::get_color_default('text_color'),
                        'title'     => esc_html_x('Link Color', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'airi')
                    ),
                    array(
                        'id'        => 'footer_link_hover_color',
                        'type'      => 'color_picker',
                        'default'   => Airi_Options::get_color_default('primary_color'),
                        'title'     => esc_html_x('Link Hover Color', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('For footer', 'admin-view', 'airi')
                    )
                )
            ),
            array(
                'name'      => 'footer_copyright_sections',
                'title'     => esc_html_x('Footer Copyright Styling', 'admin-view', 'airi'),
                'icon'      => 'fa fa-paint-brush',
                'fields'    => array(
                    array(
                        'id'        => 'footer_copyright_background_color',
                        'type'      => 'color_picker',
                        'default'   => '#000',
                        'title'     => esc_html_x('Background Color', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('For Footer Copyright', 'admin-view', 'airi')
                    ),
                    array(
                        'id'        => 'footer_copyright_text_color',
                        'type'      => 'color_picker',
                        'default'   => '#fff',
                        'title'     => esc_html_x('Text Color', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('For Footer Copyright', 'admin-view', 'airi')
                    ),
                    array(
                        'id'        => 'footer_copyright_link_color',
                        'type'      => 'color_picker',
                        'default'   => '#fff',
                        'title'     => esc_html_x('Link Color', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('For Footer Copyright', 'admin-view', 'airi')
                    ),
                    array(
                        'id'        => 'footer_copyright_link_hover_color',
                        'type'      => 'color_picker',
                        'default'   => '#fff',
                        'title'     => esc_html_x('Link Hover Color', 'admin-view', 'airi'),
                        'desc'      => esc_html_x('For Footer Copyright', 'admin-view', 'airi')
                    )
                )
            )
        )
    );
    return $sections;
}