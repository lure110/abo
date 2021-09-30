<?php
function lighthouse_options_page() {
    if (isset($_POST['info_license_update'])) {
        update_option('lhf_license_key', sanitize_text_field($_POST['lhf_license_key']));
    }
    if (isset($_POST['info_settings_update'])) {
        update_option('lighthouse_zen', (int) $_POST['lighthouse_zen']);
        update_option('lighthouse_prefetch', (int) $_POST['lighthouse_prefetch']);
        update_option('lighthouse_prefetch_throttle', (int) $_POST['lighthouse_prefetch_throttle']);

        update_option('lighthouse_version_parameter', (int) $_POST['lighthouse_version_parameter']);
        update_option('lighthouse_emoji', (int) $_POST['lighthouse_emoji']);
        update_option('lighthouse_canonical', (int) $_POST['lighthouse_canonical']);
        update_option('lighthouse_author_archive', (int) $_POST['lighthouse_author_archive']);

        update_option('lighthouse_normalize_scheme', (int) $_POST['lighthouse_normalize_scheme']);

        update_option('lighthouse_head_cleanup', (int) $_POST['lighthouse_head_cleanup']);
        update_option('lighthouse_rss_links', (int) $_POST['lighthouse_rss_links']);

        update_option('lighthouse_comment_cookies', (int) $_POST['lighthouse_comment_cookies']);
        update_option('lighthouse_core_autoupdates', (int) $_POST['lighthouse_core_autoupdates']);
        update_option('lighthouse_plugin_autoupdates', (int) $_POST['lighthouse_plugin_autoupdates']);
        update_option('lighthouse_embed', (int) $_POST['lighthouse_embed']);

        update_option('lighthouse_compress_html', (int) $_POST['lighthouse_compress_html']);

        echo '<div id="message" class="updated notice is-dismissible"><p>' . __('Options updated successfully!', 'lighthouse') . '</p></div>';
    } else if (isset($_POST['info_payment_update'])) {
        update_option('lhf_error_reporting', (int) $_POST['lhf_error_reporting']);

        update_option('lighthouse_comment_html', (int) $_POST['lighthouse_comment_html']);
        update_option('lighthouse_dashicons_frontend', (int) $_POST['lighthouse_dashicons_frontend']);
        update_option('lighthouse_comment_reply', (int) $_POST['lighthouse_comment_reply']);

        update_option('lighthouse_no_lazy_loading', (int) $_POST['lighthouse_no_lazy_loading']);
        update_option('lighthouse_js_lazy_loading', (int) $_POST['lighthouse_js_lazy_loading']);

        update_option('lighthouse_widget_pages', (int) $_POST['lighthouse_widget_pages']);
        update_option('lighthouse_widget_calendar', (int) $_POST['lighthouse_widget_calendar']);
        update_option('lighthouse_widget_archives', (int) $_POST['lighthouse_widget_archives']);
        update_option('lighthouse_widget_links', (int) $_POST['lighthouse_widget_links']);
        update_option('lighthouse_widget_meta', (int) $_POST['lighthouse_widget_meta']);
        update_option('lighthouse_widget_search', (int) $_POST['lighthouse_widget_search']);
        update_option('lighthouse_widget_text', (int) $_POST['lighthouse_widget_text']);
        update_option('lighthouse_widget_categories', (int) $_POST['lighthouse_widget_categories']);
        update_option('lighthouse_widget_posts', (int) $_POST['lighthouse_widget_posts']);
        update_option('lighthouse_widget_comments', (int) $_POST['lighthouse_widget_comments']);
        update_option('lighthouse_widget_rss', (int) $_POST['lighthouse_widget_rss']);
        update_option('lighthouse_widget_tag', (int) $_POST['lighthouse_widget_tag']);

        update_option('lighthouse_widget_html', (int) $_POST['lighthouse_widget_html']);
        update_option('lighthouse_widget_media', (int) $_POST['lighthouse_widget_media']);
        update_option('lighthouse_widget_nav', (int) $_POST['lighthouse_widget_nav']);

        echo '<div id="message" class="updated notice is-dismissible"><p>' . __('Options updated successfully!', 'lighthouse') . '</p></div>';
    } else if (isset($_POST['info_security_update'])) {
        update_option('lighthouse_xmlrpc', (int) $_POST['lighthouse_xmlrpc']);

        if (get_option('lighthouse_xmlrpc') == 1) {
            update_option('default_ping_status', 'closed');
            update_option('default_pingback_flag', '');
        }

        update_option('lighthouse_hsts', (int) $_POST['lighthouse_hsts']);
        update_option('lighthouse_disable_rest_api', (int) $_POST['lighthouse_disable_rest_api']);

        echo '<div id="message" class="updated notice is-dismissible"><p>' . __('Options updated successfully!', 'lighthouse') . '</p></div>';
    } else if (isset($_POST['info_errors_update'])) {
        update_option('lhf_error_log', sanitize_text_field($_POST['lhf_error_log']));
        update_option('lhf_error_log_size', (int) $_POST['lhf_error_log_size']);
        update_option('lhf_error_monitoring', (int) $_POST['lhf_error_monitoring']);
        update_option('lhf_error_monitoring_dashboard', (int) $_POST['lhf_error_monitoring_dashboard']);

        echo '<div id="message" class="updated notice is-dismissible"><p>' . __('Options updated successfully!', 'lighthouse') . '</p></div>';
    }

    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'lhf_dashboard';
    ?>
    <div class="wrap">
        <h1>SpeedFactor: Lighthouse</h1>

        <h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url('options-general.php?page=lighthouse&amp;tab=lhf_dashboard'); ?>" class="nav-tab <?php echo $active_tab === 'lhf_dashboard' ? 'nav-tab-active' : ''; ?>"><?php _e('Dashboard', 'lighthouse'); ?></a>
            <a href="?page=lighthouse&amp;tab=lhf_settings" class="nav-tab <?php echo $active_tab === 'lhf_settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Performance', 'lighthouse'); ?> <span class="lighthouse-badge lighthouse-new-icon">New</span></a>
            <a href="?page=lighthouse&amp;tab=lhf_security" class="nav-tab <?php echo $active_tab === 'lhf_security' ? 'nav-tab-active' : ''; ?>"><?php _e('Security', 'lighthouse'); ?></a>
            <a href="?page=lighthouse&amp;tab=lhf_errors" class="nav-tab <?php echo $active_tab === 'lhf_errors' ? 'nav-tab-active' : ''; ?>"><?php _e('Error Logging', 'lighthouse'); ?></a>
            <a href="?page=lighthouse&amp;tab=lhf_tweaks" class="nav-tab <?php echo $active_tab === 'lhf_tweaks' ? 'nav-tab-active' : ''; ?>"><?php _e('Theme Tweaks', 'lighthouse'); ?> <span class="lighthouse-badge lighthouse-new-icon">New</span></a>
            <a href="?page=lighthouse&amp;tab=lhf_help" class="nav-tab <?php echo $active_tab === 'lhf_help' ? 'nav-tab-active' : ''; ?>"><?php _e('Help', 'lighthouse'); ?></a>
        </h2>
        <div id="poststuff">
            <div class="postbox">
                <div class="inside">
                    <div class="lhf-stats">
                        <div class="lhf-stat-element lhf-speedfactor">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 330.8 192.7"><defs/><defs><style>.cls-1{fill:#3e3127}.cls-2{fill:#637582}.cls-5{fill:#78abba}.cls-6{fill:#fff}.cls-8{fill:#ecebeb}.cls-9{fill:#c4c4c4}.cls-10{fill:#d2eef9}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><ellipse cx="185.1" cy="184.8" class="cls-1" rx="145.7" ry="7.9"/><path d="M286.2 171.2H85.7a4.8 4.8 0 01-4.7-4.7V38.9c0-2.7 2.1-7.8 4.8-7.8h200.4c2.6 0 4.8 5.1 4.8 7.8v127.6a4.8 4.8 0 01-4.8 4.7z" class="cls-2"/><path fill="#9fb1bc" d="M291 34.2v4.6c0-2.6.9-4.8-1.8-4.8H83.8c-2.6 0-2.7 2.2-2.7 4.8v-4.6a4.8 4.8 0 014.8-4.8h200.4a4.8 4.8 0 014.8 4.8z"/><path fill="#caeefc" d="M89.5 168V40.6h192.9v127.3"/><path d="M89.7 162.8h192.9v4.7H89.7z" class="cls-5"/><path d="M89.7 41.8h192.9v4.7H89.7z" class="cls-6"/><path d="M293 168.8h-4V35a2.8 2.8 0 00-2.8-2.8H85.8A2.8 2.8 0 0083 35v133h-4V35a6.8 6.8 0 016.8-6.8h200.4A6.8 6.8 0 01293 35z" class="cls-1"/><rect width="267.7" height="14.8" x="52.1" y="168.8" class="cls-2" rx="7.4"/><path fill="#455760" d="M319.8 177.2a7.4 7.4 0 01-7.4 7.5H59.6a7.4 7.4 0 01-7.5-7.5 7.3 7.3 0 011-3.7 7.4 7.4 0 006.5 3.7h252.8a7.4 7.4 0 005.3-2.1 7.3 7.3 0 001.1-1.6 7.3 7.3 0 011 3.7z"/><path d="M312.4 186.3H59.6a9.4 9.4 0 110-18.8h252.8a9.4 9.4 0 010 18.8zM59.6 171.5a5.4 5.4 0 100 10.8h252.8a5.4 5.4 0 000-10.8z" class="cls-1"/><path d="M166.2 121c-9.3 1-18.7 1.8-28 2.9L91 129.3V122l42.2-4.9c10.6-1.2 21.5-2 32.2-3.3a46.5 46.5 0 00.8 7.4z" class="cls-5"/><path d="M253.2 129.7a46.3 46.3 0 01-88.5-8.5 46.5 46.5 0 01-.8-7.3v-1.3c0-1.2 0-2.5.2-3.8v-.1a45.7 45.7 0 005.1 17.6 46.4 46.4 0 0080 3.4l7.5-10.8z" class="cls-5"/><path d="M91 168.7h-3V39.8h195.9v128.8h-3V42.8H91v125.9zM72 41.7a18.4 18.4 0 016.2-34.1l1.2-.2a16.7 16.7 0 0112.9 4.4A17.8 17.8 0 0198.2 25v.8h-2V25A15.8 15.8 0 0091 13.3a14.7 14.7 0 00-11.4-3.9l-1 .1A16.4 16.4 0 0073 40zM104 13.6a6.8 6.8 0 116.8-6.8 6.8 6.8 0 01-6.8 6.8zM104 2a4.8 4.8 0 104.8 4.8A4.8 4.8 0 00104 2zM285.9 21.3a1 1 0 01-1-1V5.5a1 1 0 012 0v14.8a1 1 0 01-1 1zM316.3 43.2h-14.4a1 1 0 010-2h14.4a1 1 0 010 2zM311.3 15.3a1 1 0 01-.8-.3 1 1 0 010-1.4l5.6-5.1a1 1 0 111.4 1.4l-5.6 5.2a1 1 0 01-.6.3zM298.2 27.4a1 1 0 01-.7-.3 1 1 0 010-1.4l7.9-7.3a1 1 0 011.4 0 1 1 0 010 1.5l-7.9 7.2a1 1 0 01-.7.3zM293.3 22.6a1 1 0 01-.6-.1 1 1 0 01-.3-1.4l3.4-5.6a1 1 0 011.4-.3 1 1 0 01.3 1.4l-3.4 5.6a1 1 0 01-.8.4zM306 35H302a1 1 0 010-2h4.2a1 1 0 010 2z" class="cls-1"/><path d="M164 112.7c-11.5 1.4-23 2.3-34.5 3.6l-78.4 9c-10.5 1.2-21.3 4.1-31.8 1.9S2 115 2 104.5v.8c0-10.6 6.8-20.5 17.3-22.7s21.3.7 31.8 1.9l78.4 9c11.4 1.3 23 2.1 34.4 3.5" class="cls-8"/><path d="M162 99.7v3.8c-11.5-1.4-23.1-2.3-34.5-3.6l-78.4-9c-10.5-1.2-21.3-4.1-31.8-1.9A22.5 22.5 0 000 109.4a17.3 17.3 0 01-.1-2c.2-10.3 6.9-20 17.2-22.2C27.8 83 38.6 86 49 87.1l78.5 9c11.4 1.3 23 2.2 34.4 3.6z" class="cls-6"/><path d="M166.2 108.1v5c-11.5 1.5-23 2.3-34.5 3.6l-78.4 9c-10.5 1.3-21.3 4.2-31.8 2a22.7 22.7 0 01-17.3-22.4 24 24 0 01.6-4.9c1.9 8.4 8 15.5 16.7 17.3a100 100 0 0031.8 3l78.4-9c11.4-1.3 23-2.2 34.5-3.6z" class="cls-9"/><path d="M253.2 119.7a46.3 46.3 0 11-1.2-36.6h-37v36.6z" class="cls-8"/><path d="M252.8 85.3h-3a46.2 46.2 0 00-85 22.3v-2.8a46.2 46.2 0 0188-19.5z" class="cls-6"/><path d="M253.2 121a46.3 46.3 0 01-89.3-17 44.2 44.2 0 01.3-5 45.6 45.6 0 005 16.4 46.4 46.4 0 0078.4 5.6z" class="cls-9"/><path d="M183.9 86.3h22.3v7.1h-22.3zM183.9 98.7h22.3v7.1h-22.3zM183.9 111.2h22.3v7.1h-22.3z" class="cls-6"/><path d="M27.6 131.3a41.9 41.9 0 01-8.8-.9A24.8 24.8 0 010 106.6v-.8A24.7 24.7 0 0118.8 82c8.3-1.8 16.7-.5 24.8.8 2.5.3 5.1.8 7.7 1l78.4 9 15.5 1.6 19 2-.5 4-18.8-2-15.6-1.6-78.4-9-7.9-1c-7.7-1.2-15.7-2.5-23.3-.9A20.7 20.7 0 004 106.2c.2 9.9 6.7 18.4 15.7 20.3 7.6 1.7 15.6.4 23.3-.8 2.6-.4 5.2-.8 7.8-1q39.2-4.6 78.5-9c5.1-.7 10.4-1.2 15.5-1.7 6.2-.6 12.6-1.2 18.9-2l.5 4c-6.3.8-12.8 1.4-19 2l-15.5 1.6-78.4 9-7.7 1.1a104.5 104.5 0 01-16 1.6z" class="cls-1"/><path d="M210.1 152.5A48.2 48.2 0 11253.8 84l1.3 2.9h-38.2v32.6h39.2L255 122a47.8 47.8 0 01-44.9 30.4zm0-92.3a44.2 44.2 0 1040 63.2h-37.2V82.8h35.8A44.4 44.4 0 00210 60.2z" class="cls-1"/><path d="M207.2 95.7H183v-9.1h24.3zm-22.3-2h20.3v-5.1H185zM207.2 108H183v-9h24.3zm-22.3-2h20.3v-5H185zM207.2 120.5H183v-9h24.3zm-22.3-2h20.3v-5H185z" class="cls-1"/><circle cx="47.4" cy="120.4" r="3.1" class="cls-9"/><circle cx="202.1" cy="139.9" r="4.3" class="cls-9"/><circle cx="270.1" cy="160.8" r="4.3" class="cls-5"/><path d="M105.3 46.3a4.3 4.3 0 01-8.6 0c0-2.3 1.9-2.3 4.3-2.3s4.3 0 4.3 2.3z" class="cls-6"/><circle cx="106.8" cy="51.9" r="2.2" class="cls-10"/><circle cx="96.5" cy="51.8" r="1.1" class="cls-10"/><circle cx="51.1" cy="116.4" r="1.2" class="cls-9"/><circle cx="207.5" cy="134.5" r="1.2" class="cls-9"/><circle cx="273.3" cy="153.3" r="1.2" class="cls-5"/><circle cx="197" cy="133.7" r="2" class="cls-9"/><circle cx="261.1" cy="154.2" r="3" class="cls-5"/><path d="M63 97h-.1l-10.7-1.3a1 1 0 11.2-2l10.7 1.2a1 1 0 010 2zM65 100.3h-.1l-6.4-.7a1 1 0 11.2-2l6.4.7a1 1 0 010 2zM295.1 176.2a.5.5 0 01-.5-.5.5.5 0 01.5-.5H306a.5.5 0 01.5.5.5.5 0 01-.5.5h-10.8zM301.9 178.3a.5.5 0 01-.5-.5.5.5 0 01.5-.5h6.4a.5.5 0 01.5.5.5.5 0 01-.5.5H302zM61.8 176.2a.5.5 0 01-.5-.5.5.5 0 01.5-.5h10.8a.5.5 0 01.5.5.5.5 0 01-.5.5H61.8zM68.5 178.3a.5.5 0 01-.5-.5.5.5 0 01.5-.5H75a.5.5 0 010 1h-6.5zM255.6 66a1 1 0 01-.7-.3 1 1 0 010-1.4L266 52.1a1 1 0 111.5 1.4l-11.3 12.2a1 1 0 01-.7.3zM267 60.6a1 1 0 01-.7-1.6l6.7-7.3a1 1 0 011.5 1.3l-6.7 7.3a1 1 0 01-.8.3zM308 159a6.8 6.8 0 116.9-6.9 6.8 6.8 0 01-6.8 6.8zm0-11.7a4.8 4.8 0 104.9 4.8 4.8 4.8 0 00-4.8-4.8zM208.6 177.3h-44.9a15.4 15.4 0 01-13.6-8.1 1 1 0 111.8-1 13.4 13.4 0 0011.8 7h45a13.4 13.4 0 0011.7-7 1 1 0 111.8 1 15.4 15.4 0 01-13.6 8z" class="cls-1"/><path d="M221.3 69a.8.8 0 01-.2 0 43.5 43.5 0 00-18.4 0 1 1 0 01-1.1-.8 1 1 0 01.7-1.2 45.2 45.2 0 0119.2.1 1 1 0 01.8 1.2 1 1 0 01-1 .8zM189.7 74.4a1 1 0 01-.8-.4 1 1 0 01.1-1.4 30.5 30.5 0 017-3.7 1 1 0 11.7 1.9 28.6 28.6 0 00-6.4 3.4 1 1 0 01-.7.2zM97.7 67.3a1.5 1.5 0 01-1.5-1.5v-6.3a1.5 1.5 0 113 0v6.3a1.5 1.5 0 01-1.5 1.5zM97.7 84.8a1.5 1.5 0 01-1.5-1.5v-10a1.5 1.5 0 013 0v10a1.5 1.5 0 01-1.5 1.5zM93.1 94.7v.4a2.9 2.9 0 002.5 2.9l23.6 3a2.9 2.9 0 003.3-3V97" class="cls-6"/></g></g></svg>

                            <p>Test your site for performance and security using <a href="https://getbutterfly.com/">SpeedFactor</a> - Unlimited automated page speed monitoring &amp; tracking.</p>

                            <p>
                                <a href="https://getbutterfly.com/" class="button button-primary">Get SpeedFactor</a>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <?php $lhfdata = get_plugin_data(LIGHTHOUSE_PLUGIN_FILE_PATH); ?>
                    <p>You are using <b>Lighthouse</b> version <b><?php echo $lhfdata['Version']; ?></b> <span class="lighthouse-badge lighthouse-pro-icon">PRO</span> <span class="alignright"><a href="https://getbutterfly.com/support/documentation/lighthouse/" rel="external">Documentation</a> | <a href="https://getbutterfly.com/wordpress-plugins/lighthouse/" rel="external">Support</a> | <a href="<?php echo admin_url('site-health.php'); ?>">Site Health</a></span></p>
                </div>
            </div>
        </div>
        <?php if ($active_tab === 'lhf_dashboard') {
            echo lhf_get_message();
        } else if ($active_tab === 'lhf_settings') { ?>
            <form method="post" action="">
                <h2><?php _e('Performance Settings', 'lighthouse'); ?></h2>
                <p>
                    Tick the checkboxes below to selectively remove/disable WordPress actions and filters. These options will reduce database queries and HTTP(S) requests, making the site lighter.
                    <br><small>A database query is a request for information from a database. An HTTP(S) request is a browser request for a file (a CSS stylesheet, a JS script, an image or the actual HTML/PHP document).</small>
                </p>
                <p>Check the <a href="https://github.com/h5bp/html5-boilerplate/blob/master/dist/.htaccess" rel="external noopener" target="_blank">HTML5 Boilerplate</a> <code>.htaccess</code> rules for further performance and optimisation.</p>
                <p>Check the <a href="https://getbutterfly.com/how-to-optimize-wordpress-native-settings-for-performance/" rel="external noopener" target="_blank">WordPress Native Settings Optimization</a> guide to squeeze even more speed from your WordPress site.</p>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label>Zen Mode</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_zen" value="1" <?php if ((int) get_option('lighthouse_zen') === 1) echo 'checked'; ?>> <span class="lhfr">recommended</span> <label>Zen mode</label><br>
                                    <small>Remove most of WordPress-related clutter, notifications, meta boxes and filters in Dashboard view</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Performance</label></th>
                            <td>
                                <p>
                                    <select name="lighthouse_prefetch" id="lighthouse_prefetch">
                                        <option value="0" <?php if ((int) get_option('lighthouse_prefetch') === 0) { echo 'selected'; } ?>>No resource prerender</option>
                                        <option value="1" <?php if ((int) get_option('lighthouse_prefetch') === 1) { echo 'selected'; } ?>>Prerender links</option>
                                        <option value="2" <?php if ((int) get_option('lighthouse_prefetch') === 2) { echo 'selected'; } ?>>Prerender and prefetch links</option>
                                    </select>
                                    <select name="lighthouse_prefetch_throttle" id="lighthouse_prefetch_throttle">
                                        <option value="500" <?php if ((int) get_option('lighthouse_prefetch_throttle') === 500) { echo 'selected'; } ?>>500ms</option>
                                        <option value="300" <?php if ((int) get_option('lighthouse_prefetch_throttle') === 300) { echo 'selected'; } ?>>300ms</option>
                                        <option value="150" <?php if ((int) get_option('lighthouse_prefetch_throttle') === 150) { echo 'selected'; } ?>>150ms (recommended)</option>
                                        <option value="100" <?php if ((int) get_option('lighthouse_prefetch_throttle') === 100) { echo 'selected'; } ?>>100ms</option>
                                        <option value="65" <?php if ((int) get_option('lighthouse_prefetch_throttle') === 65) { echo 'selected'; } ?>>65ms</option>
                                        <option value="0" <?php if ((int) get_option('lighthouse_prefetch_throttle') === 0) { echo 'selected'; } ?>>No throttle/delay</option>
                                    </select> <span class="lhfr">recommended</span> <span class="lhfn">use if needed</span>

                                    <br><small>When a user hovers over a link, a <code>prerender</code> and/or <code>prefetch</code> hints are dynamically appended to the <code>&lt;head&gt;</code> of the document, but only if those respective hints haven’t already been generated in the past.</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Theme Cleanup</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_version_parameter" value="1" <?php if ((int) get_option('lighthouse_version_parameter') === 1) echo 'checked'; ?>> <span class="lhfr">recommended</span> <label>Remove version parameter from scripts and stylesheets</label><br>
                                    <small>Remove version parameter from scripts and stylesheets URLs and helps with browser caching</small><br>

                                    <input type="checkbox" name="lighthouse_emoji" value="1" <?php if ((int) get_option('lighthouse_emoji') === 1) echo 'checked'; ?>> <span class="lhfr">recommended</span> <label>Disable emojis and smilies</label><br>
                                    <small>Disable replacing special characters with emojis and smilies</small><br>

                                    <input type="checkbox" name="lighthouse_canonical" value="1" <?php if ((int) get_option('lighthouse_canonical') === 1) echo 'checked'; ?>> <span class="lhfn">use if needed</span> <label>Disable canonical URL redirection</label><br>
                                    <small>Disable URL redirection when page not found</small><br>

                                    <input type="checkbox" name="lighthouse_author_archive" value="1" <?php if ((int) get_option('lighthouse_author_archive') === 1) echo 'checked'; ?>> <span class="lhfn">use if needed</span> <label>Disable author archive</label><br>
                                    <small>Disable author archive (helps with search engine indexation, duplicate content and security)</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Scripts and Styles Cleanup</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_normalize_scheme" value="1" <?php if ((int) get_option('lighthouse_normalize_scheme') === 1) echo 'checked'; ?>> <span class="lhfr">recommended</span> <label>Normalize HTTP(S) scheme</label><br>
                                    <small>Use the scheme/protocol of the current page or do not force a certain scheme (useful when switching from HTTP to HTTPS or to minimize mixed content warnings)</small><br>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label><code>&lt;head&gt;</code> Cleanup</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_head_cleanup" value="1" <?php if ((int) get_option('lighthouse_head_cleanup') === 1) echo 'checked'; ?>> <span class="lhfr">recommended</span> <label>Clean up theme <code>&lt;head&gt;</code></label><br>
                                    <small>Clean up RSD, WLW references, WordPress generator tag and post shortlinks (also remove WordPress-generated <code>&lt;rel&gt;</code> tags)</small><br>

                                    <input type="checkbox" name="lighthouse_rss_links" value="1" <?php if ((int) get_option('lighthouse_rss_links') === 1) echo 'checked'; ?>> <label>Hide RSS links</label><br>
                                    <small>Remove RSS links and prevent content copying and republishing</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>System Cleanup</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_comment_cookies" value="1" <?php if ((int) get_option('lighthouse_comment_cookies') === 1) echo 'checked'; ?>> <label>Disable comment cookies</label><br>
                                    <small>Disable the user information - name, email and website - being saved in browser</small><br>

                                    <input type="checkbox" name="lighthouse_core_autoupdates" value="1" <?php if ((int) get_option('lighthouse_core_autoupdates') === 1) echo 'checked'; ?>> <span class="lhfb">not recommended</span> <label>Disable core autoupdates</label><br>
                                    <small>Disable automatic WordPress updates (useful for managed sites)</small><br>

                                    <input type="checkbox" name="lighthouse_plugin_autoupdates" value="1" <?php if ((int) get_option('lighthouse_plugin_autoupdates') === 1) echo 'checked'; ?>> <span class="lhfb">not recommended</span> <label>Disable plugin autoupdates</label><br>
                                    <small>Disable automatic plugin updates (useful for managed sites)</small><br>

                                    <input type="checkbox" name="lighthouse_embed" value="1" <?php if ((int) get_option('lighthouse_embed') === 1) echo 'checked'; ?>> <label>Disable WordPress embeds</label><br>
                                    <small>Remove embed query vars, disable oEmbed discovery and completely remove the related scripts (disallow WordPress posts to be embedded on remote sites)</small><br>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Code Minification</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_compress_html" value="1" <?php if ((int) get_option('lighthouse_compress_html') === 1) echo 'checked'; ?>> <span class="lhfr">recommended</span> <label>Minify/compress HTML source code</label><br>
                                    <small>Remove all new lines from HTML source code, strip whitespaces before and after tags, strip inline CSS comments and removes script and style types from inline source code</small>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr>
                <p><input type="submit" name="info_settings_update" class="button button-primary" value="Save Changes"></p>
            </form>
        <?php } else if ($active_tab === 'lhf_security') { ?>
            <form method="post" action="">
                <h2><?php _e('Security Settings', 'lighthouse'); ?></h2>
                <p>Read the <a href="https://codex.wordpress.org/Hardening_WordPress" rel="external" target="_blank">official WordPress guidelines</a> for hardening and securing your site.</p>
                <p>Check the <a href="https://github.com/h5bp/html5-boilerplate/blob/master/dist/.htaccess" rel="external" target="_blank">HTML5 Boilerplate .htaccess</a> rules for further securing your site.</p>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label>Basic security</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_xmlrpc" value="1" <?php if ((int) get_option('lighthouse_xmlrpc') === 1) echo 'checked'; ?>> <span class="lhfr">recommended</span> <span class="lhfw">use with caution</span> <label>Disable XML-RPC</label><br>
                                    <small>Disable remote access to your WordPress site (may cause issues with some plugins)</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Advanced security (<abbr title="Secure Sockets Layer">SSL</abbr> only)</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_hsts" value="1" <?php if ((int) get_option('lighthouse_hsts') === 1) echo 'checked'; ?>> <span class="lhfw">use with caution</span> <label>Enable HTTP Strict Transport Security (<abbr title="HTTP Strict Transport Security">HSTS</abbr>) <a href="https://getbutterfly.com/wordpress-security-x/#hsts-preloading" rel="external" target="_blank"> Read more</a></label><br>
                                    <small>By adding the Strict Transport Security header to your site, you secure every visit from your visitors except for the initial visit. That still leaves your site vulnerable to MITM (man-in-the-middle) attacks for that initial visit, so there is a technique called "preloading" that will add your site to a pre-populated domain list. Once your site is on that list, the major browsers that support HSTS preloading will be notified that your site requires SSL, and every visit, even the very first one from a visitor, will automatically be forced through SSL.</small>
                                </p>

                                <p>
                                    <input type="checkbox" name="lighthouse_disable_rest_api" value="1" <?php if ((int) get_option('lighthouse_disable_rest_api') === 1) echo 'checked'; ?>> <span class="lhfb">not recommended</span> <span class="lhfw">use with caution</span> <label>Disable REST API</label><br>
                                    <small>WordPress REST API provides a method for developers to pull additional information from the site. Most of this information can be accessed without requiring authentication, a behaviour which might open security holes.</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>XSS, framing and injection</label></th>
                            <td>
                                <p>Add the following lines to your configuration files, based on your server type (<code>nginx.conf</code> or <code>.htaccess</code>):</p>
                                <h4>X-Frame-Options</h4>
                                <p>
                                    nginx: <code>add_header X-Frame-Options "SAMEORIGIN" always;</code><br>
                                    Apache: <code>Header always set X-Frame-Options "SAMEORIGIN"</code><br>
                                    <small>Valid values include <code>DENY</code> meaning your site can't be framed, <code>SAMEORIGIN</code> which allows you to frame your own site or <code>ALLOW-FROM https://example.com/</code> which lets you specify sites that are permitted to frame your own site.</small>
                                </p>

                                <h4>X-Xss-Protection</h4>
                                <p>
                                    nginx: <code>add_header X-Xss-Protection "1; mode=block" always;</code><br>
                                    Apache: <code>Header always set X-Xss-Protection "1; mode=block"</code>
                                </p>

                                <h4>X-Content-Type-Options</h4>
                                <p>
                                    nginx: <code>X-Content-Type-Options "nosniff" always;</code><br>
                                    Apache: <code>always set X-Content-Type-Options "nosniff"</code>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr>
                <p><input type="submit" name="info_security_update" class="button button-primary" value="Save Changes"></p>
            </form>
        <?php } else if ($active_tab === 'lhf_errors') { ?>
            <form method="post" action="">
                <h2><?php _e('Error Logging', 'lighthouse'); ?></h2>
                <p>Stay on top of errors, warnings and notices as they occur.</p>
                <p>This will read all errors, warnings and notices from a file generally called <code>debug.log</code> in <code>wp-content</code> folder. If Apache does not have write permissions, you may need to create the file first and set the appropriate permissions (e.g. <code>0666</code>).</p>
                <p>In order for errors to be logged, you need to edit your <code>wp-config.php</code> file and change the following values:</p>
                <p><textarea class="large-text code" rows="5">define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);</textarea></p>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label>Error monitoring</label></th>
                            <td>
                                <p>
                                    <input type="text" name="lhf_error_log" class="regular-text" value="<?php echo get_option('lhf_error_log'); ?>" placeholder="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>"> <label>Path to your error log</label>
                                    <br><small>Server path to your error log (find it in document root or in <code>wp-content</code> directory)</small>
                                    <br><small>Example #1: <code><?php echo $_SERVER['DOCUMENT_ROOT']; ?>/debug.log</code></small>
                                    <br><small>Example #2: <code><?php echo WP_CONTENT_DIR; ?>/debug.log</code></small>
                                </p>
                                <p>
                                    <input type="number" name="lhf_error_log_size" value="<?php echo get_option('lhf_error_log_size'); ?>" placeholder="100"> <label>Errors, warnings or notices to show</label>
                                    <br><small>Number of errors, warnings or notices to show in log</small>
                                </p>
                                <p>
                                    <input type="checkbox" name="lhf_error_monitoring" value="1" <?php if ((int) get_option('lhf_error_monitoring') === 1) echo 'checked'; ?>> <span class="lhfn">use if needed</span> <span class="lhfw">use with caution</span> <label>Error monitoring</label>
                                    <br><small>Display PHP errors, warnings and notices</small>
                                </p>
                                <p style="padding-left: 48px;">
                                    <input type="checkbox" name="lhf_error_monitoring_dashboard" value="1" <?php if ((int) get_option('lhf_error_monitoring_dashboard') === 1) echo 'checked'; ?>> <label>Show error monitoring widget on Dashboard</label>
                                    <br><small>Show errors, warnings and notices in a widget on Dashboard for easier access</small>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <?php
                if ((int) get_option('lhf_error_monitoring') === 1) {
                    lhf_phpErrorsWidget();
                }
                ?>

                <hr>
                <p><input type="submit" name="info_errors_update" class="button button-primary" value="Save Changes"></p>
            </form>
        <?php } else if ($active_tab === 'lhf_tweaks') { ?>
            <form method="post" action="">
                <h2><?php _e('Theme Tweaks', 'lighthouse'); ?></h2>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label>Debugging</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lhf_error_reporting" value="1" <?php if ((int) get_option('lhf_error_reporting') === 1) echo 'checked'; ?>> <span class="lhfn">use if needed</span> <span class="lhfw">use with caution</span> <label>Error reporting</label>
                                    <br><small>Display PHP errors and warnings both on front-end and back-end</small>
                                    <br><small>Note: Do not activate on live/production sites</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Theme Tweaks</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_comment_html" value="1" <?php if ((int) get_option('lighthouse_comment_html') === 1) echo 'checked'; ?>> <label>Disable HTML in WordPress comments</label><br>
                                    <input type="checkbox" name="lighthouse_dashicons_frontend" value="1" <?php if ((int) get_option('lighthouse_dashicons_frontend') === 1) echo 'checked'; ?>> <label>Remove Dashicons from front-end for non-administrators</label><br>
                                    <input type="checkbox" name="lighthouse_comment_reply" value="1" <?php if ((int) get_option('lighthouse_comment_reply') === 1) echo 'checked'; ?>> <label>Remove comment reply script (if using a third-party comments plugin)</label>
                                </p>
                                <p>
                                    <input type="checkbox" name="lighthouse_no_lazy_loading" value="1" <?php if ((int) get_option('lighthouse_no_lazy_loading') === 1) echo 'checked'; ?>> <label>Remove native/core lazy loading (if using a third-party lazy-loading plugin)</label> <span class="lhfb">not recommended</span> <span class="lhfn">use if needed</span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Widget Tweaks</label></th>
                            <td>
                                <p>Note that you should start removing widgets and replacing them with a different functionality, such as reusable blocks. Widgets are now obsolete from a development/maintenance point of view and themes should code/develop an alternate method of using reusable content.</p>
                                <p>
                                    <input type="checkbox" name="lighthouse_widget_pages" value="1" <?php if ((int) get_option('lighthouse_widget_pages') === 1) echo 'checked'; ?>> <label>Remove pages widget (<code>WP_Widget_Pages</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_calendar" value="1" <?php if ((int) get_option('lighthouse_widget_calendar') === 1) echo 'checked'; ?>> <label>Remove calendar widget (<code>WP_Widget_Calendar</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_archives" value="1" <?php if ((int) get_option('lighthouse_widget_archives') === 1) echo 'checked'; ?>> <label>Remove archive widget (<code>WP_Widget_Archives</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_links" value="1" <?php if ((int) get_option('lighthouse_widget_links') === 1) echo 'checked'; ?>> <label>Remove links widget (<code>WP_Widget_Links</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_meta" value="1" <?php if ((int) get_option('lighthouse_widget_meta') === 1) echo 'checked'; ?>> <label>Remove meta widget (<code>WP_Widget_Meta</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_search" value="1" <?php if ((int) get_option('lighthouse_widget_search') === 1) echo 'checked'; ?>> <label>Remove search widget (<code>WP_Widget_Search</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_text" value="1" <?php if ((int) get_option('lighthouse_widget_text') === 1) echo 'checked'; ?>> <label>Remove text widget (<code>WP_Widget_Text</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_categories" value="1" <?php if ((int) get_option('lighthouse_widget_categories') === 1) echo 'checked'; ?>> <label>Remove categories widget (<code>WP_Widget_Categories</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_posts" value="1" <?php if ((int) get_option('lighthouse_widget_posts') === 1) echo 'checked'; ?>> <label>Remove recent posts widget (<code>WP_Widget_Recent_Posts</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_comments" value="1" <?php if ((int) get_option('lighthouse_widget_comments') === 1) echo 'checked'; ?>> <label>Remove recent comments widget (<code>WP_Widget_Recent_Comments</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_rss" value="1" <?php if ((int) get_option('lighthouse_widget_rss') === 1) echo 'checked'; ?>> <label>Remove RSS widget (<code>WP_Widget_RSS</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_tag" value="1" <?php if ((int) get_option('lighthouse_widget_tag') === 1) echo 'checked'; ?>> <label>Remove tag cloud widget (<code>WP_Widget_Tag_Cloud</code>)</label><br>

                                    <input type="checkbox" name="lighthouse_widget_html" value="1" <?php if ((int) get_option('lighthouse_widget_html') === 1) echo 'checked'; ?>> <label>Remove custom HTML widget (<code>WP_Widget_Custom_HTML</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_media" value="1" <?php if ((int) get_option('lighthouse_widget_media') === 1) echo 'checked'; ?>> <label>Remove media widget (<code>WP_Widget_Media</code>)</label><br>
                                    <input type="checkbox" name="lighthouse_widget_nav" value="1" <?php if ((int) get_option('lighthouse_widget_nav') === 1) echo 'checked'; ?>> <label>Remove navigation widget (<code>WP_Nav_Menu_Widget</code>)</label>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr>
                <p><input type="submit" name="info_payment_update" class="button button-primary" value="Save Changes"></p>
            </form>
        <?php } else if ($active_tab === 'lhf_help') { ?>
            <h2><?php _e('Help', 'lighthouse'); ?></h2>

            <p>
                <span class="lhfr">recommended</span> We recommend enabling this option<br>
                <span class="lhfb">not recommended</span> We do not recommend enabling this option<br>
                <span class="lhfw">use with caution</span> Only enable this option if you know what you are doing<br>
                <span class="lhfn">use if needed</span> Only enable this option of you need it
            </p>
        <?php } ?>
    </div>
<?php }
