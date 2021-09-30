<?php
/**
 * Main Lighthouse functions
 *
 * @since 2.2.0
 */

/**
 * Plugin initialization.
 *
 * Set up textdomain and error reporting.
 */
function lighthouse_init() {
    load_plugin_textdomain('lighthouse', false, dirname(plugin_basename(__FILE__)) . '/languages/');

    $lhf_error_reporting = get_option('lhf_error_reporting');
    if ((int) $lhf_error_reporting === 1) {
        echo '<div class="error notice is-dismissible"><p>Lighthouse error/warning reporting is enabled! <a href="' . admin_url('options-general.php?page=lighthouse&tab=lhf_tweaks') . '">Disable it</a>.</p></div>';

        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    } else {
        error_reporting(0);
        ini_set("display_errors", 0);
    }
}

/**
 * Plugin installation.
 *
 * Add options and remove unused/old ones.
 */
function lighthouse_install() {
    add_option('lighthouse_zen', 0);

    add_option('lighthouse_version_parameter', 0);
    add_option('lighthouse_emoji', 0);
    add_option('lighthouse_canonical', 0);
    add_option('lighthouse_author_archive', 0);

    add_option('lighthouse_normalize_scheme', 0);

    add_option('lighthouse_head_cleanup', 0);
    add_option('lighthouse_rss_links', 0);

    add_option('lighthouse_xmlrpc', 0);
    add_option('lighthouse_comment_cookies', 0);
    add_option('lighthouse_core_autoupdates', 0);
    add_option('lighthouse_plugin_autoupdates', 0);
    add_option('lighthouse_embed', 0);

    add_option('lighthouse_hsts', 0);

    add_option('lighthouse_http_headers', 0);
    add_option('lighthouse_compress_html', 0);

    add_option('lhf_error_reporting', 0);

    add_option('lhf_error_log', '');
    add_option('lhf_error_log_size', 100);
    add_option('lhf_error_monitoring', 0);
    add_option('lhf_error_monitoring_dashboard', 0);

    add_option('lighthouse_comment_html', 0);
    add_option('lighthouse_dashicons_frontend', 0);
    add_option('lighthouse_comment_reply', 0);

    add_option('lighthouse_widget_pages', 0);
    add_option('lighthouse_widget_calendar', 0);
    add_option('lighthouse_widget_archives', 0);
    add_option('lighthouse_widget_links', 0);
    add_option('lighthouse_widget_meta', 0);
    add_option('lighthouse_widget_search', 0);
    add_option('lighthouse_widget_text', 0);
    add_option('lighthouse_widget_categories', 0);
    add_option('lighthouse_widget_posts', 0);
    add_option('lighthouse_widget_comments', 0);
    add_option('lighthouse_widget_rss', 0);
    add_option('lighthouse_widget_tag', 0);

    add_option('lighthouse_widget_html', 0);
    add_option('lighthouse_widget_media', 0);
    add_option('lighthouse_widget_tag', 0);

    // delete old options
    delete_option('lighthouse_smilies');
    delete_option('lighthouse_canonical_sf');
    delete_option('lighthouse_rsd_links');
    delete_option('lighthouse_wlw_links');
    delete_option('lighthouse_shortlink');
    delete_option('lighthouse_generator');
    delete_option('lighthouse_xmlrpc_safe');
    delete_option('lighthouse_hsts_simple');
    delete_option('lighthouse_nofollow_author');
    delete_option('lighthouse_backup');
    delete_option('lighthouse_backup');
    delete_option('lighthouse_remove_pings');

    delete_option('lighthouse_clean_style_tag');
    delete_option('lighthouse_clean_script_tag');
    delete_option('lighthouse_clean_css_attr');
    delete_option('lighthouse_opensans_frontend');
    delete_option('lighthouse_attribution');
    delete_option('lighthouse_gravatar_alt');

    delete_option('lighthouse_adjacent');
    delete_option('lighthouse_genericons_frontend');
    delete_option('lighthouse_content_conversion');
    delete_option('lighthouse_fancybox');

    delete_option('lighthouse_bad_queries');
    delete_option('lighthouse_jqueryui');
    delete_option('lighthouse_nofollow_comment');

    delete_option('lighthouse_script_html5shiv');
    delete_option('lighthouse_style_masonry');
    delete_option('lighthouse_script_modernizr');
    delete_option('lighthouse_script_jquery');
    delete_option('lighthouse_style_normalize');
    delete_option('lighthouse_style_pure');
    delete_option('lighthouse_style_dashicons');
    delete_option('lighthouse_style_entypo');
    delete_option('lighthouse_style_fa');

    delete_option('lighthouse_gravatar_cache');
    delete_option('wpgc_dir');
    delete_option('wpgc_url');
    delete_option('wpgc_exp');
    delete_option('wpgc_cc');
    delete_option('wpgc_dir');
    delete_option('lighthouse_compress_scripts');
    delete_option('lighthouse_transients');
    delete_option('lighthouse_devicepx');

    delete_option('lighthouse_disable_author_archives');
    delete_option('lighthouse_http_headers');

    delete_option('lighthouse_recent_comments_css');
    delete_option('lighthouse_remove_gallery_style');
    delete_option('lighthouse_remove_srcset');

    delete_option('lighthouse_clean_attributes');
    delete_option('lighthouse_scripts_to_footer');

    delete_option('lighthouse_jquery_migrate');
    delete_option('lighthouse_taxonomy_archive');

    if (file_exists(WP_CONTENT_DIR . '/lighthouse-cache')) {
        lhfDeleteTree(WP_CONTENT_DIR . '/lighthouse-cache');
    }
    if (file_exists(WP_CONTENT_DIR . '/uploads/lighthouse')) {
        lhfDeleteTree(WP_CONTENT_DIR . '/uploads/lighthouse');
    }
}

/**
 * Delete folder and contents.
 *
 */
function lhfDeleteTree($dir) {
    $files = glob($dir . '*', GLOB_MARK);

    foreach ($files as $file) {
        if (substr($file, -1) == '/') {
            lhfDeleteTree($file);
        } else {
            unlink($file);
        }
    }

    rmdir($dir);
}

/**
 * Move scripts to footer.
 *
 * Remove all enqueued scripts and styles and enqueue them
 * in the theme's footer. It only works with properly
 * enqueued functions.
 */
function lhf_scripts_to_footer() {
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);

    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
}

/**
 * Remove version parameter.
 *
 * Remove version parameter ('ver', 'v', 'sv') from scripts and styles.
 *
 * @return string
 */
function lhf_remove_script_version($src) {
    return esc_url(remove_query_arg(['ver', 'v', 'sv'], $src));
}

/**
 * Remove version parameter.
 *
 * Remove version parameter ('ver', 'v', 'sv') from scripts and styles.
 */
function lhf_disable_emojis() {
    if ((int) get_option('lighthouse_emoji') === 1) {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

        remove_action('init', 'smilies_init', 5);

        remove_filter('comment_text', 'make_clickable', 9);
        remove_filter('the_content', 'convert_bbcode');
        remove_filter('the_content', 'convert_gmcode');
        remove_filter('the_content', 'convert_smilies');
        remove_filter('the_content', 'convert_chars');

        add_filter('option_use_smilies', '__return_false');
        add_filter('emoji_svg_url', '__return_false');
    }
}

function lhf_disable_author_archive() {
    // If we are on author archive
    if (is_author()) {
        global $wp_query;

        $wp_query->set_404();
    } else {
        redirect_canonical();
    }
}

function lhfSizeConversion($size) {
    $unit = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

    return round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $unit[$i];
}

/**
 * Check OS memory
 *
 * @since 0.1.4
 * @author Ciprian Popescu
 *
 * @param string $type Memory check type (available, peak or current usage)
 * @return string
 */
function lhfGetMemory($type = 'usage') {
    $size = 0;

    if ((string) $type === 'available') {
        $memoryAvailable = filter_var(ini_get("memory_limit"), FILTER_SANITIZE_NUMBER_INT);
        $memoryAvailable = $memoryAvailable * 1024 * 1024;
        $size = (int) $memoryAvailable;
    } else if ((string) $type === 'peak') {
        $size = (int) memory_get_peak_usage(true);
    } else if ((string) $type === 'usage') {
        $size = (int) memory_get_usage(true);
    }

    return lhfSizeConversion($size);
}

function lhf_get_message() {
    global $wpdb, $wp_version;

    $all_pass = true;

    $php_min_version_check = version_compare(LIGHTHOUSE_CHECK_PHP_MIN_VERSION, PHP_VERSION, '<=');
    $php_rec_version_check = version_compare(LIGHTHOUSE_CHECK_PHP_REC_VERSION, PHP_VERSION, '<=');

    $wp_min_version_check = version_compare(LIGHTHOUSE_CHECK_WP_MIN_VERSION, $wp_version, '<=');
    $wp_rec_version_check = version_compare(LIGHTHOUSE_CHECK_WP_REC_VERSION, $wp_version, '<=');

    $message = '<p>' . sprintf(__('Your server is running PHP version <b>%1$s</b> and MySQL version <b>%2$s</b> on <b>' . sanitize_text_field($_SERVER['SERVER_SOFTWARE']) . '</b> with <b>' . WP_MEMORY_LIMIT . '</b> (WordPress) memory.', 'lighthouse'), PHP_VERSION, $wpdb->db_version()) . '</p>';

    $message .= '<p>
        Current memory usage is ' . lhfGetMemory('usage') . ' (' . lhfGetMemory('peak') . ') out of ' . lhfGetMemory('available') . ' allocated.';

        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            $message .= '<br><small>Current CPU load is ' . implode(', ', $load) . '</small>';
        }
    $message .= '</p>';

    $success = '';
    $warning = '';
    $error = '';

    if (!$wp_min_version_check) {
        $error .= '<p><b>' . __('Warning:', 'lighthouse') . '</b> ' . sprintf(__('Lighthouse requires WordPress %s or higher.', 'lighthouse'), LIGHTHOUSE_CHECK_WP_MIN_VERSION) . '</p>';
        $all_pass = false;
    }
    if (!$wp_rec_version_check) {
        $error .= '<p><b>' . __('Warning:', 'lighthouse') . '</b> ' . sprintf(__('Lighthouse recommends WordPress %s or higher.', 'lighthouse'), LIGHTHOUSE_CHECK_WP_REC_VERSION) . '</p>';
        $all_pass = false;
    }

    if (!$php_min_version_check) {
        $error .= '<p><b>' . __('Warning:', 'lighthouse') . '</b> ' . sprintf(__('WordPress 4.3+ requires PHP version %s or higher.', 'lighthouse'), LIGHTHOUSE_CHECK_PHP_MIN_VERSION) . '</p>';
        $all_pass = false;
    }
    if (version_compare($wpdb->db_version(), '5.5.3', '<')) {
        $warning .= '<p><b>' . __('Error:', 'lighthouse') . '</b> ' . sprintf(__("WordPress <code>utf8mb4</code> support requires MySQL version %s or higher.", 'lighthouse'), $wpdb->db_version(), '5.5.3' ) . '</p>';
        $all_pass = false;
    }

    if (!$php_rec_version_check) {
        $warning .= '<p><strong>' . __('Warning:', 'lighthouse') . '</strong> ' . sprintf(__('For performance and security reasons, we recommend running PHP version %s or higher.', 'lighthouse'), LIGHTHOUSE_CHECK_PHP_REC_VERSION) . '</p>';
        $all_pass = false;
    }

    if ($_SERVER['HTTP_ACCEPT_ENCODING'] == 'gzip' || function_exists('ob_gzhandler') || ini_get('zlib.output_compression')) {
        $success .= '<p><code>gzip</code> is available on your server.</p>';
    } else {
        $error .= '<p><strong>' . __('Error:', 'lighthouse') . '</strong> ' . sprintf(__('For performance reasons, we strongly recommend enabling %s on your server.', 'lighthouse'), '<code>gzip</code>') . '</p>';
    }

    $isSecure = false;
    $isProtocol = wp_get_server_protocol();
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $success .= '<p><code>HTTPS</code> (<code>' . $isProtocol . '</code>) is enabled for your domain.</p>';
    } else if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
        $error .= '<p><strong>' . __('Error:', 'lighthouse') . '</strong> ' . __('For security reasons, we strongly recommend getting an SSL certificate for your domain.', 'lighthouse') . '</p>';
    }

    if ($error) {
        $message .= '<div class="lhf-notice lhf-notice-error">' . $error . '</div>';
    }
    if ($warning) {
        $message .= '<div class="lhf-notice lhf-notice-warning">' . $warning . '</div>';
    }
    if ($success) {
        $message .= '<div class="lhf-notice lhf-notice-success">' . $success . "</div>";
    }

    return $message;
}



function lhf_dequeue_dashicons() {
    if (current_user_can('update_core')) {
        return;
    }

    wp_dequeue_style('dashicons');
    wp_deregister_style('dashicons');
}

function lhf_unregister_post_type($post_type) {
    global $wp_post_types;

    if (isset($wp_post_types[$post_type])) {
        unset($wp_post_types[$post_type]);
        return true;
    }

    return false;
}



function lhf_src_scheme($url) {
    if (is_admin()) {
        return $url;
    }

    return str_replace(['http:', 'https:'], '', $url);
}



function lhf_remove_xmlrpc_methods($methods) {
    unset($methods['pingback.ping']);
    unset($methods['pingback.extensions.getPingbacks']);

    unset($methods['system.multicall']);
    unset($methods['system.listMethods']);
    unset($methods['system.getCapabilities']);

    unset($methods['wp.getUsersBlogs']);

    return $methods;
}
function lhf_remove_x_pingback($headers) {
    unset($headers['X-Pingback']);

    return $headers;
}
function lhf_remove_pingback_url($output, $show) {
    if ((string) $show === 'pingback_url') {
        $output = '';
    }

    return $output;
}



// No self pings
function lhf_no_self_ping($links) {
    $home = get_option('home');
    foreach ($links as $l => $link) {
        if (0 === strpos($link, $home)) {
            unset($links[$l]);
        }
    }
}

// Unregister all default WP Widgets
function lhf_unregister_default_wp_widgets() {
    if ((int) get_option('lighthouse_widget_pages') === 1) {
        unregister_widget('WP_Widget_Pages');
    }
    if ((int) get_option('lighthouse_widget_calendar') === 1) {
        unregister_widget('WP_Widget_Calendar');
    }
    if ((int) get_option('lighthouse_widget_archives') === 1) {
        unregister_widget('WP_Widget_Archives');
    }
    if ((int) get_option('lighthouse_widget_links') === 1) {
        unregister_widget('WP_Widget_Links');
    }
    if ((int) get_option('lighthouse_widget_meta') === 1) {
        unregister_widget('WP_Widget_Meta');
    }
    if ((int) get_option('lighthouse_widget_search') === 1) {
        unregister_widget('WP_Widget_Search');
    }
    if ((int) get_option('lighthouse_widget_text') === 1) {
        unregister_widget('WP_Widget_Text');
    }
    if ((int) get_option('lighthouse_widget_categories') === 1) {
        unregister_widget('WP_Widget_Categories');
    }
    if ((int) get_option('lighthouse_widget_posts') === 1) {
        unregister_widget('WP_Widget_Recent_Posts');
    }
    if ((int) get_option('lighthouse_widget_comments') === 1) {
        unregister_widget('WP_Widget_Recent_Comments');
    }
    if ((int) get_option('lighthouse_widget_rss') === 1) {
        unregister_widget('WP_Widget_RSS');
    }
    if ((int) get_option('lighthouse_widget_tag') === 1) {
        unregister_widget('WP_Widget_Tag_Cloud');
    }
    if ((int) get_option('lighthouse_widget_html') === 1) {
        unregister_widget('WP_Widget_Custom_HTML');
    }
    if ((int) get_option('lighthouse_widget_media') === 1) {
        unregister_widget('WP_Widget_Media');
    }
    if ((int) get_option('lighthouse_widget_nav') === 1) {
        unregister_widget('WP_Nav_Menu_Widget');
    }
}

function lhf_strict_transport_security() {
    header('Strict-Transport-Security: max-age=10886400; includeSubDomains; preload');
}




/**
 * Disable embeds on init.
 *
 * - Removes the needed query vars.
 * - Disables oEmbed discovery.
 * - Completely removes the related JavaScript.
 *
 */
function lhf_disable_embeds_init() {
    if ((int) get_option('lighthouse_embed') === 1) {
        global $wp;

        $wp->public_query_vars = array_diff($wp->public_query_vars, [
            'embed'
        ]);

        add_filter('embed_oembed_discover', '__return_false');
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        remove_action('rest_api_init', 'wp_oembed_register_route');
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');

        remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);

        if (!is_admin()) {
            wp_deregister_script('wp-embed');
        }
    }
}

function lhf_capital_p_bangit() {
    remove_filter('the_title',    'capital_P_dangit', 11);
    remove_filter('the_content',  'capital_P_dangit', 11);
    remove_filter('comment_text', 'capital_P_dangit', 31);
}
function lhf_taxonomies() {
    global $wp_taxonomies;

    unset($wp_taxonomies['link_category']);
    unset($wp_taxonomies['post_format']);
}
function lhf_admin_bar() {
    global $wp_admin_bar;

    if (!is_admin_bar_showing()) {
        return;
    }

    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('my-account');
    $wp_admin_bar->remove_menu('appearance');
    $wp_admin_bar->remove_menu('new-content');
    $wp_admin_bar->remove_menu('my-account-with-avatar');
}
function lhf_dashboard_widgets() {
    remove_meta_box('dashboard_browser_nag', 'dashboard', 'normal');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');

    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
}
function lhf_note() {
    $screen = get_current_screen();

    if ($screen->id === 'settings_page_lighthouse') {
        print '<div id="message" class="updated notice is-dismissible"><p>' . __('Lighthouse Zen mode is active.', 'lighthouse') . '</p></div>';
    }
}



/**
 * Returns an authentication error if a user who is not logged in tries to query the REST API
 * @param $access
 * @return WP_Error
 */
function lighthouse_only_allow_logged_in_rest_access($access) {
    if (!is_user_logged_in()) {
        return new WP_Error('rest_cannot_access', __('Only authenticated users can access the REST API.', 'lighthouse'), ['status' => rest_authorization_required_code()]);
    }

    return $access;
}



/**
 * TGM Plugin Activation
 */
function lhf_register_required_plugins() {
    $plugins = [
        [
            'name' => 'GitHub Updater',
            'slug' => 'github-updater',
            'source' => 'https://github.com/afragen/github-updater/archive/master.zip',
            'external_url' => 'https://github.com/afragen/github-updater',
            'required' => true
        ]
    ];

    $config = [
        'id' => 'lighthouse',
        'default_path' => '',
        'menu' => 'tgmpa-install-plugins',
        'parent_slug' => 'plugins.php',
        'capability' => 'manage_options',
        'has_notices' => true,
        'dismissable' => true,
        'dismiss_msg' => '',
        'is_automatic' => false,
        'message' => ''
    ];

    tgmpa($plugins, $config);
}
