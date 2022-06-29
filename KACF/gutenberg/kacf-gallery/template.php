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

require_once dirname(__FILE__) . '/../../lib/less/lessc.inc.php';
$less = new lessc;

// get the current page id
$current_page_id = get_the_ID();

// retrieve the current acf block name
$current_acf_block_name = $block['name'] ?? 'acf/kacf-gallery';

// get all pages
$pages = get_pages();

// get all registered blocks
$registered_blocks = acf_get_block_types();

$gallery_blocks = array();



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

        // get the block css src
        $css_src = $registered_blocks[$block_name]['enqueue_style'];
        // get the block css content
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $css_src);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $css = curl_exec($ch);
        curl_close($ch);

        $gallery_blocks[] = array(
            'name' => $block_name,
            'reference' => $reference,
            'classes' => $classes,
            'content' => $acf_block,
            'css' => $css,
        );
    }
}

?>

<section class="kacf-gallery">
    <input placeholder="<?php _e('Saisissez du texte pour trouver un bloc...', 'kacf') ?>" class="kacf-gallery__input" type="text" onkeyup="handleGalleryInputChange(this)" />

    <span class="kacf-popover"></span>

    <p class="kacf-result-count"><?php _e('Nombre de blocs : ', 'kacf') ?><span class="kacf-result-count__count"><?php echo count($gallery_blocks) ?></span></p>
    <div class="kacf-block-gallery">
        <?php foreach ($gallery_blocks as $gallery_block) : ?>
            <div data-reference="<?php echo $gallery_block['reference'] ?>" class="<?php echo $gallery_block['classes'] ?>">
                <!-- render the block -->
                <?php echo render_block($gallery_block['content']); ?>
                <!-- remove the old style -->
                <?php wp_dequeue_style('block-' . acf_slugify($gallery_block['name'])); ?>
                <!-- insert the new scoped style -->
                <style>
                    <?php
                    $scoped_css = '.kacf-filter-' . explode('acf/', $gallery_block['name'])[1] . '{' . $gallery_block['css'] . '}';
                    echo $less->compile($scoped_css);
                    ?>
                </style>
            </div>
        <?php endforeach; ?>
    </div>
</section>