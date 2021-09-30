<?php
/*
Plugin Name: Lighthouse
Plugin URI: https://getbutterfly.com/wordpress-plugins/lighthouse/
Description: Lighthouse is a performance tuning plugin, removing lots of default WordPress behaviour, such as filters, actions, injected code, native code and third-party actions.
Author: Ciprian Popescu
Author URI: https://getbutterfly.com/
GitHub Plugin URI: wolffe/lighthouse
Version: 3.3.0

Lighthouse
Copyright (C) 2014-2021 Ciprian Popescu (getbutterfly@gmail.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

define('LIGHTHOUSE_VERSION', '3.3.0');
define('LIGHTHOUSE_PLUGIN_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));
define('LIGHTHOUSE_PLUGIN_PATH', WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)));
define('LIGHTHOUSE_PLUGIN_FILE_PATH', WP_PLUGIN_DIR . '/' . plugin_basename(__FILE__));

define('LIGHTHOUSE_CHECK_PHP_MIN_VERSION', '7.3');
define('LIGHTHOUSE_CHECK_PHP_REC_VERSION', '7.4');
define('LIGHTHOUSE_CHECK_WP_MIN_VERSION', '5.5');
define('LIGHTHOUSE_CHECK_WP_REC_VERSION', '5.6');

define('CORE_UPGRADE_SKIP_NEW_BUNDLED', true);

include_once LIGHTHOUSE_PLUGIN_PATH . '/includes/functions.php';
include_once LIGHTHOUSE_PLUGIN_PATH . '/includes/settings.php';
include_once LIGHTHOUSE_PLUGIN_PATH . '/includes/error-logging.php';



/**
 * GitHub Updater
 */
require_once dirname(__FILE__) . '/classes/class-tgm-plugin-activation.php';
add_action('tgmpa_register', 'lhf_register_required_plugins');



add_action('wp_enqueue_scripts', 'lhf_performance');

function lhf_performance() {
    if ((int) get_option('lighthouse_prefetch') === 1) {
        wp_enqueue_script('lhf-prefetch', plugins_url('/assets/prerender.js', __FILE__), [], LIGHTHOUSE_VERSION, true);
    } else if ((int) get_option('lighthouse_prefetch') === 2) {
        wp_enqueue_script('lhf-prefetch', plugins_url('/assets/prefetch.js', __FILE__), [], LIGHTHOUSE_VERSION, true);
    }

    if ((int) get_option('lighthouse_prefetch') > 0) {
        wp_localize_script('lhf-prefetch', 'lhf_ajax_var', [
            'prefetch_throttle' => (int) get_option('lighthouse_prefetch_throttle')
        ]);
    }
}



if ((int) get_option('lighthouse_compress_html') === 1) {
    include LIGHTHOUSE_PLUGIN_PATH . '/includes/minify.php';
}

register_activation_hook(__FILE__, 'lighthouse_install');

add_action('plugins_loaded', 'lighthouse_init');

add_action('admin_menu', 'lighthouse_add_option_page');
add_action('admin_enqueue_scripts', 'lhf_load_admin_style');
add_action('after_setup_theme', 'lighthouse_setup');
add_action('init', 'lighthouse_on_init', 3);
add_action('pre_ping', 'lhf_no_self_ping');
add_action('widgets_init', 'lighthouse_on_widgets_init');

if ((int) get_option('lighthouse_zen') === 1) {
    add_action('wp_before_admin_bar_render', 'lhf_admin_bar');
    add_action('wp_dashboard_setup', 'lhf_dashboard_widgets');

    lhf_capital_p_bangit();
    lhf_taxonomies();
}

if ((int) get_option('lighthouse_no_lazy_loading') === 1) {
    add_filter('wp_lazy_loading_enabled', '__return_false');
}

function lighthouse_on_init() {
    lhf_declutter_head();
    lhf_disable_emojis();
    lhf_disable_embeds_init();
}
function lighthouse_on_widgets_init() {
    lhf_unregister_default_wp_widgets();
}

function lighthouse_add_option_page() {
    add_options_page('Lighthouse', 'Lighthouse', 'manage_options', 'lighthouse', 'lighthouse_options_page');
}

function lhf_load_admin_style() {
    wp_enqueue_style('lighthouse', LIGHTHOUSE_PLUGIN_URL . '/assets/lighthouse.css', false, LIGHTHOUSE_VERSION);
}

function lighthouse_setup() {
    if ((int) get_option('lighthouse_version_parameter') === 1) {
        add_filter('script_loader_src', 'lhf_remove_script_version', 15, 1);
        add_filter('style_loader_src', 'lhf_remove_script_version', 15, 1);
    }

    if ((int) get_option('lighthouse_head_cleanup') === 1) {
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'shortlink_wp_head', 10, 0);
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
        remove_action('template_redirect', 'wp_shortlink_header', 11, 0);
    }

    if ((int) get_option('lighthouse_rss_links') === 1) {
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'feed_links', 2);
    }

    if ((int) get_option('lighthouse_adjacent') === 1) {
        remove_action('wp_head', 'index_rel_link');
        remove_action('wp_head', 'parent_post_rel_link', 10, 0);
        remove_action('wp_head', 'start_post_rel_link', 10, 0);
        remove_action('wp_head', 'parent_post_rel_link_wp_head', 10, 0);
        remove_action('wp_head', 'start_post_rel_link_wp_head', 10, 0);
        remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10,0);
        remove_action('wp_head', 'rel_canonical');
    }

    if ((int) get_option('lighthouse_author_archive') === 1) {
        add_action('template_redirect', 'lhf_disable_author_archive');
    }
    if ((int) get_option('lighthouse_canonical') === 1) {
        remove_filter('template_redirect', 'redirect_canonical');
    }

    if ((int) get_option('lighthouse_comment_html') === 1) {
        add_filter('pre_comment_content', 'esc_html');
    }

    if ((int) get_option('lighthouse_dashicons_frontend') === 1) {
        add_action('wp_enqueue_scripts', 'lhf_dequeue_dashicons');
    }
}

function lhf_declutter_head() {
    if ((int) get_option('lighthouse_comment_cookies') === 1) {
        remove_action('set_comment_cookies', 'wp_set_comment_cookies');
    }

    if ((int) get_option('lighthouse_core_autoupdates') === 1) {
        // Core
        remove_action('wp_version_check', 'wp_version_check');
        remove_action('admin_init', '_maybe_update_core');
        add_filter('pre_transient_update_core', '__return_zero');
        add_filter('pre_site_transient_update_core', '__return_zero');
    }

    if ((int) get_option('lighthouse_plugin_autoupdates') === 1) {
        // Plugins
        remove_action('load-plugins.php', 'wp_update_plugins' );
        remove_action('load-update.php', 'wp_update_plugins' );
        remove_action('admin_init', '_maybe_update_plugins' );
        remove_action('wp_update_plugins', 'wp_update_plugins' );
        remove_action('load-update-core.php', 'wp_update_plugins' );
        add_filter('pre_transient_update_plugins', '__return_zero' );
        add_filter('pre_site_transient_update_plugins', '__return_zero' );
    }

    // default
    remove_filter('the_content', 'prepend_attachment');
}

if ((int) get_option('lighthouse_xmlrpc') === 1) {
    add_filter('xmlrpc_methods', 'lhf_remove_xmlrpc_methods');
    add_filter('xmlrpc_enabled', '__return_false');
    add_filter('pre_option_default_pingback_flag', '__return_false');

    if (isset($_GET['doing_wp_cron'])) {
        remove_action('do_pings', 'do_all_pings');
        wp_clear_scheduled_hook('do_pings');
    }

    // force removal of physical tag
    add_filter('bloginfo_url', 'lhf_remove_pingback_url', 10, 2);
}

// Hide xmlrpc.php in HTTP response headers // default is on
add_filter('wp_headers', 'lhf_remove_x_pingback');

function lighthouse_load_scripts() {
    if ((int) get_option('lighthouse_comment_reply') === 1) {
       wp_dequeue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'lighthouse_load_scripts');

if ((int) get_option('lighthouse_normalize_scheme') === 1) {
    add_filter('script_loader_src', 'lhf_src_scheme');
    add_filter('style_loader_src', 'lhf_src_scheme');
}

if ((int) get_option('lighthouse_hsts') === 1) {
    add_action('send_headers', 'lhf_strict_transport_security');
}

if ((int) get_option('lighthouse_disable_rest_api') === 1) {
    add_filter('rest_authentication_errors', 'lighthouse_only_allow_logged_in_rest_access');

    add_action('plugins_loaded', function () {
        remove_filter('init', '_add_extra_api_post_type_arguments');
    });
    add_action('plugins_loaded', function () {
        remove_action('rest_api_init', 'create_initial_rest_routes', 99);
    });
}

function lhf_create_beacon() {
    $beacon = trailingslashit(ABSPATH) . 'beacon.html';

    if (!file_exists($beacon)) {
        fopen($beacon, 'w');
    }
}
add_action('init', 'lhf_create_beacon');
