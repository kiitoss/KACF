<?php

class kacf
{
    static public $VERSION = "v0.1.0";
    private $allowed_blocks = array();
    private $tpl = '';
    private $tpluri = '';
    private $relative_paths = array();
    private static $instance;
    public function __construct($gutpath = '/gutenberg/', $add_hooks = true, $relative_paths = array('php' => 'template.php', 'css' => 'less/index.php', 'js' => 'js/script.js', 'acf' => 'acf/acf.php'))
    {
        // check the environment validity
        $this->check_environmment_validity();

        // define gutenberg repository paths
        $this->tpl = get_template_directory() . $gutpath;
        $this->tpluri = get_template_directory_uri() . $gutpath;

        // set up php / css / js / acf relative paths
        if (!$relative_paths['php']) $relative_paths['php'] = 'template.php';
        if (!$relative_paths['css']) $relative_paths['css'] = 'less/index.php';
        if (!$relative_paths['js']) $relative_paths['js'] = 'js/script.js';
        if (!$relative_paths['acf']) $relative_paths['acf'] = 'acf/acf.php';
        $this->relative_paths = $relative_paths;

        // set up action hooks if add_hooks
        if ($add_hooks) $this->add_hooks();

        // set the KACF instance
        kacf::$instance = $this;
    }

    /**
     * Set up action hooks
     */
    private function add_hooks()
    {
        // check the environment validity
        $this->check_environmment_validity();

        // register blocks
        add_action('acf/init', array($this, 'register_acf_blocks'));
        // set up allowed block type
        add_filter('allowed_block_types_all', array($this, 'get_registered_blocks'));
    }

    /**
     * Check WP and ACF existence
     */
    private function check_environmment_validity()
    {
        // exit if the class is not load in a WP environement
        if (!class_exists('WP')) {
            trigger_error("You must use WordPress to use the KACF class.", E_USER_ERROR);
            die();
        }
        // exit if the class is not load in an ACF environement
        if (!class_exists('ACF')) {
            trigger_error("You must use ACF to use the KACF class.", E_USER_ERROR);
            die();
        }
    }

    /**
     * Return the instance of the KACF class
     */
    public static function getInstance()
    {
        if (!kacf::$instance instanceof self) {
            kacf::$instance = new self();
        }
        return kacf::$instance;
    }


    /**
     * Return the list of registered blocks
     */
    public function get_registered_blocks()
    {
        return $this->allowed_blocks;
    }

    /**
     * Get the ACF block data from the PHP file
     * The data can be found in the header of the template file
     */
    private function get_acf_block_comment_data($file_path)
    {
        // use the wordpress built-in function get_file_data
        $data = get_file_data(
            $file_path,
            array(
                'title' => 'title',
                'icon' => 'icon',
                'keywords' => 'keywords',
                'post_types' => 'post_types',
                'description' => 'description',
                'category' => 'category',
            )
        );

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
    private function register_acf_block($data, $relative_path)
    {
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
            'enqueue_style' => $this->tpluri . $relative_path . '/' . $this->relative_paths['css'],
            'enqueue_script' => $this->tpluri . $relative_path . '/' . $this->relative_paths['js'],
        ));

        // load the ACF field generator if exists
        $acf_php_file_path = $this->tpl . $relative_path . '/' . $this->relative_paths['acf'];
        if (file_exists($acf_php_file_path) && filesize($acf_php_file_path)) {
            include $acf_php_file_path;
        }

        // allow user to use this new block
        $this->allowed_blocks[] = 'acf/' . $data['name'];
    }

    /**
     * Register new ACF blocks directly took from the folder
     */
    public function register_acf_blocks()
    {
        // check the environment validity
        $this->check_environmment_validity();

        // check the possibility to add new blocks
        if (!function_exists('acf_register_block_type')) return;

        // get all directories under the gutenberg directory
        $dirs = array_filter(glob($this->tpl . '*'), 'is_dir');

        // loop through these directories
        foreach ($dirs as $dir) {
            // get the file path
            $file_path = $dir . '/' . $this->relative_paths['php'];

            // retrieve the data in the header comments of the file
            $data = $this->get_acf_block_comment_data($file_path);

            // get the directory relative path
            // necessary to enqueue styles and scripts
            $relative_path = implode('', explode($this->tpl, $dir));

            // generate the name of the block with the folder name
            $data['name'] = preg_replace('/[^a-z0-9\-\_]/', '', str_replace(' ', '-', strtolower($relative_path)));

            // continue if no block title
            if (!$data['title']) continue;

            // set the folder name as the first keyword
            array_unshift($data['keywords'], $data['name']);

            // register the new acf block
            $this->register_acf_block($data, $relative_path);
        }
    }
}
