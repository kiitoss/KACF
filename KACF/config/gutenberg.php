<?php

require dirname(__FILE__) . '/../lib/kacf/kacf.inc.php';
global $KACF;
$KACF = new kacf('/gutenberg/');

/**
 * Register new ACF blocks directly took from the folder
 */
function kacf_register_acf_blocks()
{
    global $KACF;
    $KACF->register_acf_blocks();
}
add_action('acf/init', 'kacf_register_acf_blocks');


/**
 * Update the WordPress allowed blocks
 */
function kacf_allowed_block_types()
{
    global $KACF;
    return $KACF->get_registered_blocks();
}
add_filter('allowed_block_types', 'kacf_allowed_block_types');
