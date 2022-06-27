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
$current_acf_block_name = parse_blocks(get_the_content())[0]['attrs']['name'];

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

        // update class with keywords to filter wrappers
        foreach ($keywords as $keyword) {
            if (!$keyword) continue;
            $classes .= ' kacf-filter-' . $keyword;
        }

        // retrieve the ID (MUST BE the first keyword according to KACF logic)
        $reference = $keywords[0];

        $gallery_blocks[] = array(
            'name' => $block_name,
            'reference' => $reference,
            'classes' => $classes,
            'content' => $acf_block,
        );
    }
}

?>

<h2>Gallerie de blocks</h2>

<input type="text" onkeyup="handleGalleryInputChange(this)" />

<div id="block-gallery">
    <h3>Début de la gallerie des blocks</h3>
    <?php foreach ($gallery_blocks as $gallery_block) : ?>
        <div data-reference="<?php echo $gallery_block['reference'] ?>" class="<?php echo $gallery_block['classes'] ?>">
            <?php echo render_block($gallery_block['content']); ?>
        </div>
    <?php endforeach; ?>
    <h3>Fin de la gallerie des blocks</h3>
</div>

<?php
// create the block popover information
echo '<span class="kacf-popover"></span>';
