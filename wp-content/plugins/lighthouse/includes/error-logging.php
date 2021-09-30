<?php
function lhf_phpErrorsWidget() {
    $logfile = (string) trim(get_option('lhf_error_log')); // Enter the server path to your logs file here
    $displayErrorsLimit = (int) get_option('lhf_error_log_size'); // The maximum number of errors to display in the widget
    $fileCleared = false;
    $userCanClearLog = current_user_can('manage_options');

    // Clear file?
    if ($userCanClearLog && isset($_GET["lhf-php-errors"]) && $_GET["lhf-php-errors"] == "clear") {
        $handle = fopen($logfile, "w");
        fclose($handle);
        $fileCleared = true;
    }

    // Read file
    if (file_exists($logfile)) {
        $errors = file($logfile);
        $errors = array_reverse($errors);

        echo '<h3 id="lhf-error-log">Error log</h3>';

        if ($fileCleared) {
            echo '<p><em>File cleared.</em></p>';
        }
        if ($errors) {
            echo '<p>' . 
                count($errors) . ' errors, warnings or notices found.';

                if ($userCanClearLog) {
                    echo ' <a href="' . admin_url('options-general.php?page=lighthouse&tab=lhf_errors&lhf-php-errors=clear#lhf-error-log') . '" onclick="return confirm(\'Are you sure?\');">Clear log file</a>';
                }
            echo '</p>
            <div id="lhf-php-errors" class="li-errors">
                <ol class="li-main">';
                    $i = 0;
                    foreach ($errors as $error) {
                        echo '<li class="li-error">';
                            $errorOutput = stripslashes_deep($error);

                            echo $errorOutput;
                        echo '</li>';
                        $i++;

                        if ($i > $displayErrorsLimit) {
                            echo '<li class="li-more"><em>More than ' . $displayErrorsLimit . ' errors, warnings or notices in found in log...</em></li>';
                            break;
                        }
                    }
                echo '</ol>
            </div>';
        } else {
            echo '<p>Nothing logged.</p>';
        }
    } else {
        echo '<p><em>There was a problem reading the error log file.</em></p>';
    }
}
 
// Add widgets
function lhf_dashboardWidgets() {
    wp_add_dashboard_widget('lhf-php-errors', 'Lighthouse PHP Errors, Warnings &amp; Notices', 'lhf_phpErrorsWidget');   
}

if ((int) get_option('lhf_error_monitoring') === 1) {
    if ((int) get_option('lhf_error_monitoring_dashboard') === 1) {
        add_action('wp_dashboard_setup', 'lhf_dashboardWidgets');
    }
}
