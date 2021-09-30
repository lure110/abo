<?php
function lhf_minify_html($minify) {
    $search = [
        '/\>[^\S ]+/s', // strip whitespaces after tags, except space
        '/[^\S ]+\</s', // strip whitespaces before tags, except space
        '!/\*[^*]*\*+([^/][^*]*\*+)*/!', // strip inline CSS comments
        "/\t+/", // strip inline CSS comments
        '/\>\s+\</'
    ];
    $replace = [
        '>',
        '<',
        '',
        '',
        '> <'
    ];
    $minify = preg_replace($search, $replace, $minify);

    $minify = str_replace([
        ' type="text/javascript"',
        ' type="text/css"'
    ], '', $minify);

    // number_format_i18n(ob_get_status()['buffer_used'])
    $minify .= '<!-- Lighthouse HTML Minify -->';

    return $minify;
}

if (!is_admin()) {
    ob_start('lhf_minify_html');
    add_action('get_header', 'lhf_minify_html');
}
