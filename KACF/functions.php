<?php

include dirname(__FILE__) . "/config/gutenberg.php";
include dirname(__FILE__) . "/config/gallery.php";

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
