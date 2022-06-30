<?php
/*
 * title: KACF Galerie
 ** icon: 
 ** keywords: 
 ** post_types:
 ** description: Récupère et affiche les blocs des pages différentes de la page active
 ** category: 
 */
?>

<?php
// get the current page id
$current_page_id = get_the_ID();

// retrieve the current acf block name
$current_acf_block_name = $block['name'] ?? 'acf/kacf-gallery';

// get all pages
$pages = get_pages();

// get all registered blocks
$registered_blocks = acf_get_block_types();

// main variable storing all blocks informations
$gallery_blocks = array(
    'css' => array(),
    'blocks' => array()
);

// retrieve global styles to add them later in each block shadow DOM
global $wp_styles;
foreach ($wp_styles->queue as $handle) {
    $src = $wp_styles->registered[$handle]->src;
    if ($src && count(explode('http', $src)) > 1) $gallery_blocks['css'][] = $src;
}

// loop through the pages
foreach ($pages as $page) {
    // get the looped page ID
    $page_id = $page->ID;

    if ($page_id == $current_page_id) continue;

    // get content of the looped page
    $post = get_post($page->ID);
    $content = $post->post_content;

    // continue if no blocks
    if (!has_blocks($content)) continue;

    $blocks = parse_blocks($post->post_content);

    // loop through the blocks
    foreach ($blocks as $acf_block) {
        $block_name = $acf_block['blockName'];

        // continue if the block doesn't have name
        if (!$block_name) continue;

        // continue if current block is a KACF gallery block
        if ($acf_block['attrs']['name'] == $current_acf_block_name) continue;

        // get the looped block informations (map with registered blocks)
        $registered_block = $registered_blocks[$block_name];

        $keywords = $registered_blocks ? $registered_block['keywords'] : array('unclassified');

        // create class for the wrapper div
        $classes = 'kacf-filter';

        if (!$keywords) continue;

        // update class with keywords to filter wrappers
        foreach ($keywords as $keyword) {
            if (!$keyword) continue;
            $classes .= ' kacf-filter-' . $keyword;
        }

        // retrieve the ID (MUST BE the first keyword according to KACF logic)
        $reference = $keywords[0];

        // get the block js and css
        $css_src = $registered_blocks[$block_name]['enqueue_style'];
        $js_src = $registered_blocks[$block_name]['enqueue_script'];

        // set up block informations
        $gallery_blocks['blocks'][] = array(
            'wrapper' => wp_unique_id('kacf-gallery-block-wrapper-'),
            'name' => $block_name,
            'reference' => $reference,
            'classes' => $classes,
            'content' => render_block($acf_block),
            'css' => $css_src,
            'js' => $js_src,
        );

        // unregister the block css and the block js
        // these scripts are going to be load in shadow DOM
        wp_dequeue_style('block-' . acf_slugify($block_name));
        wp_dequeue_script('block-' . acf_slugify($block_name));
    }
}

wp_localize_script('block-acf-kacf-gallery', 'galleryBlocks', $gallery_blocks);

?>

<section class="kacf-gallery">
    <input placeholder="<?php _e('Saisissez du texte pour trouver un bloc...', 'kacf') ?>" class="kacf-gallery__input" type="text" onkeyup="handleGalleryInputChange(this)" />

    <span class="kacf-popover"></span>

    <p class="kacf-result-count"><?php _e('Nombre de blocs : ', 'kacf') ?><span class="kacf-result-count__count"><?php echo count($gallery_blocks) ?></span></p>
    <div class="kacf-block-gallery">
        <?php foreach ($gallery_blocks['blocks'] as $gallery_block) : ?>
            <!-- kacf gallery block container -->
            <div data-reference="<?php echo $gallery_block['reference'] ?>" id="<?php echo $gallery_block['wrapper'] ?>" class="<?php echo $gallery_block['classes'] ?>"></div>
        <?php endforeach; ?>
    </div>
</section>