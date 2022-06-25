<?php

/**
 * Enqueue gallery scripts
 */
function kacf_gallery_scripts()
{
  wp_enqueue_script('kacf-gallery', get_template_directory_uri() . '/gallery/js/main.js', array('jquery'), 1.1, true);
  wp_enqueue_style('kacf-gallery', get_template_directory_uri() . '/gallery/less/index.php');
}
add_action('wp_enqueue_scripts', 'kacf_gallery_scripts');


/**
 * Generate the gallery
 */
function kacf_gallery()
{
  // return if admin page or not main page
  if (is_admin() || !is_front_page() || !is_page()) return;

  // get the page ID
  $current_page_id = get_the_ID();

  // get all pages
  $pages = get_pages();

  // get all registered blocks
  $registered_blocks = acf_get_block_types();

  // loop through the pages
  foreach ($pages as $page) {
    // get the looped page ID
    $page_id = $page->ID;

    // continue if the looped page is the main page
    if ($page_id == $current_page_id) continue;

    // get content of the looped page
    $post = get_post($page->ID);
    $content = $post->post_content;

    // continue if no blocks
    if (!has_blocks($content)) continue;

    $blocks = parse_blocks($post->post_content);

    // loop through the blocks
    foreach ($blocks as $block) {
      $block_name = $block['blockName'];
      if (!$block_name) continue;

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

      // echo the wrapper and the block content
      echo '<div data-reference="' . $reference . '" class="' . $classes . '">';
      echo render_block($block);
      echo '</div>';
    }
  }

  // create the block popover information
  echo '<span id="kacf-popover"></span>';
}
add_action('the_content', 'kacf_gallery', 15);
