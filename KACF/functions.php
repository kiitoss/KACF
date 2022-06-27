<?php

require dirname(__FILE__) . '/lib/kacf/kacf.inc.php';
new kacf();

/**
 * Load the site styles and scripts
 */
function kacf_loader()
{
    // wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    // wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.0.2', true);

    wp_enqueue_style('kacf', get_template_directory_uri() . '/lib/less/index.php?fichier=index');
    wp_enqueue_script('kacf', get_template_directory_uri() . '/js/main.js', array('jquery'), 1.1, true);
}
add_action('wp_enqueue_scripts', 'kacf_loader');

/**
 * Load the css file for admin pages
 */
function kacf_admin_css()
{
    wp_enqueue_style('kacf-admin-css', get_template_directory_uri() . '/lib/less/index.php?fichier=admin');
}
add_action('admin_print_styles', 'kacf_admin_css', 11);



function kacf_enable_debug()
{
    add_action('template_redirect', function () {
        // Turn on error reporting.
        error_reporting(E_ALL);

        // Sets to display errors on screen. Use 0 to turn off.
        ini_set('display_errors', 1);

        // Sets to log errors. Use 0 (or omit) to not log errors.
        ini_set('log_errors', 1);

        // Sets a log file path you can access in the theme editor.
        $log_path = get_template_directory() . '/debug.txt';
        ini_set('error_log', $log_path);
    });
}
kacf_enable_debug();
