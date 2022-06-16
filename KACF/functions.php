<?php

include dirname(__FILE__) . "/config/gutenberg.php";

/**
 * Load the site styles and scripts
 */
function kiitoss_loader()
{
    // wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    // wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.0.2', true);

    wp_enqueue_style('kiitoss', get_template_directory_uri() . '/lib/less/index.php?fichier=index');
    wp_enqueue_script('kiitoss', get_template_directory_uri() . '/js/main.js', array('jquery'), 1.1, true);
}
add_action('wp_enqueue_scripts', 'kiitoss_loader');

/**
 * Load the css file for admin pages
 */
function kiitoss_admin_css()
{
    wp_enqueue_style('kiitoss-admin-css', get_template_directory_uri() . '/lib/less/index.php?fichier=admin');
}
add_action('admin_print_styles', 'kiitoss_admin_css', 11);
