<?php

// define theme version
define('KACFv', time());

// define gutenberg repesitory paths
define('TPL', get_template_directory() . '/gutenberg/');
define('GUT', get_template_directory_uri() . '/gutenberg/');

// define global variable for ACF allowed blocks
global $ALLOWED_BLOCKS;
$ALLOWED_BLOCKS = array();

/**
 * Get the ACF block data from the PHP file
 * The data can be found in the header of the template file
 */
function kacf_get_acf_block_comment_data($file_path)
{
    // use the wordpress built-in function get_file_data
    $data = get_file_data(
        $file_path,
        array(
            'name' => 'name',
            'title' => 'title',
            'icon' => 'icon',
            'keywords' => 'keywords',
            'post_types' => 'post_types',
            'description' => 'description',
            'category' => 'category',
        )
    );

    // the data MUST contain at least the block name and the block title
    if (!$data['name'] || !$data['title']) return null;

    // set default icon
    if (!$data['icon']) $data['icon'] = 'align-full-width';

    // split keywords
    $keywords = $data['keywords']
        ? preg_split('/[, ]/', $data['keywords'])
        : array();
    $data['keywords'] = $keywords;

    // split post types or set default
    $post_types = $data['post_types']
        ? preg_split('/[, ]/', $data['post_types'])
        : array('page');
    $data['post_types'] = $post_types;

    // set the render template of the block
    $data['render_template'] = $file_path;

    return $data;
}


/**
 * Register a new ACF block
 */
function kacf_register_acf_block($data, $relative_path)
{
    global $ALLOWED_BLOCKS;

    // register the block with its data
    acf_register_block_type(array(
        'name'              => $data['name'],
        'title'             => __($data['title'], 'kacf'),
        'description'       => $data['description'],
        'category'          => $data['category'],
        'render_template'   => $data['render_template'],
        'icon'              => $data['icon'],
        'keywords'          => $data['keywords'],
        'post_types'        => $data['post_types'],
        'mode'              => 'edit',
        'enqueue_style' => GUT . $relative_path . '/less/index.php',
        'enqueue_script' => GUT . $relative_path . '/js/script.js',
    ));

    // load the ACF field generator if exists
    $acf_php_file_path = TPL . $relative_path . '/acf/acf.php';
    if (file_exists($acf_php_file_path) && filesize($acf_php_file_path)) {
        include $acf_php_file_path;
    }

    // allow user to use this new block
    $ALLOWED_BLOCKS[] = 'acf/' . $data['name'];
}


/**
 * Register new ACF blocks directly took from the folder
 */
function kacf_register_acf_blocks()
{
    // check the possibility to add new blocks
    if (!function_exists('acf_register_block_type')) return;

    // get all directories under the gutenberg directory
    $dirs = array_filter(glob(TPL . '*'), 'is_dir');

    // loop through these directories
    foreach ($dirs as $dir) {
        // get the file path
        $file_path = $dir . '/template.php';

        // retrieve the data in the header comments of the file
        $data = kacf_get_acf_block_comment_data($file_path);

        // abort if data is missing
        if (!$data) continue;

        // get the directory relative path
        // necessary to enqueue styles and scripts
        $relative_path = implode('', explode(TPL, $dir));

        // register the new acf block
        kacf_register_acf_block($data, $relative_path);
    }
}
add_action('acf/init', 'kacf_register_acf_blocks');


/**
 * Update the WordPress allowed blocks
 */
function kacf_allowed_block_types()
{
    global $ALLOWED_BLOCKS;
    return $ALLOWED_BLOCKS;
}
add_filter('allowed_block_types', 'kacf_allowed_block_types');
