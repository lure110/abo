<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


/**
 * MetaBox
 *
 * @param array $sections An array of our sections.
 * @return array
 */
function airi_metaboxes_section_post( $sections )
{
    $sections['post'] = array(
        'name'      => 'post',
        'title'     => esc_html_x('Post', 'admin-view', 'airi'),
        'icon'      => 'laicon-file',
        'fields'    => array(
            array(
                'id'            => 'custom_author',
                'type'          => 'text',
                'title'         => esc_html_x('Custom Post Author', 'admin-view', 'airi')
            ),
            array(
                'type'          => 'heading',
                'wrap_class'    => 'small-heading',
                'content'       => esc_html_x('For post format QUOTE', 'admin-view', 'airi')
            ),
            array(
                'id'            => 'format_quote_content',
                'type'          => 'textarea',
                'title'         => esc_html_x('Quote Content', 'admin-view', 'airi')
            ),
            array(
                'id'            => 'format_quote_author',
                'type'          => 'text',
                'title'         => esc_html_x('Quote Author', 'admin-view', 'airi')
            ),
            array(
                'id'            => 'format_quote_background',
                'type'          => 'color_picker',
                'title'         => esc_html_x('Quote Background Color', 'admin-view', 'airi'),
                'default'       => '#343538'
            ),
            array(
                'id'            => 'format_quote_color',
                'type'          => 'color_picker',
                'title'         => esc_html_x('Quote Text Color', 'admin-view', 'airi'),
                'default'       => '#fff'
            ),

            array(
                'type'          => 'heading',
                'wrap_class'    => 'small-heading',
                'content'       => esc_html_x('For post format LINK', 'admin-view', 'airi')
            ),
            array(
                'id'            => 'format_link',
                'type'          => 'text',
                'title'         => esc_html_x('Custom Link', 'admin-view', 'airi')
            ),

            array(
                'type'          => 'heading',
                'wrap_class'    => 'small-heading',
                'content'       => esc_html_x('For post format VIDEO & AUDIO', 'admin-view', 'airi')
            ),
            array(
                'id'            => 'format_video_url',
                'type'          => 'text',
                'title'         => esc_html_x('Custom Video Link', 'admin-view', 'airi'),
                'desc'          => esc_html_x('Insert Youtube or Vimeo embed link', 'admin-view', 'airi'),
            ),
            array(
                'id'            => 'format_embed',
                'type'          => 'textarea',
                'title'         => esc_html_x('Embed Code', 'admin-view', 'airi'),
                'desc'          => esc_html_x('Insert Youtube or Vimeo or Audio embed code.', 'admin-view', 'airi'),
                'sanitize'      => false
            ),
            array(
                'id'             => 'format_embed_aspect_ration',
                'type'           => 'select',
                'title'          => esc_html_x('Embed aspect ration', 'admin-view', 'airi'),
                'options'        => array(
                    'origin'        => 'origin',
                    '169'           => '16:9',
                    '43'            => '4:3',
                    '235'           => '2.35:1'
                )
            ),
            array(
                'type'          => 'heading',
                'wrap_class'    => 'small-heading',
                'content'       => esc_html_x('For post format GALLERY', 'admin-view', 'airi')
            ),
            array(
                'id'            => 'format_gallery',
                'type'          => 'gallery',
                'title'         => esc_html_x('Gallery Images', 'admin-view', 'airi')
            )
        )
    );
    return $sections;
}