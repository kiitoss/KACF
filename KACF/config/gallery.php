<?php

function kacf_gallery_scripts()
{
  wp_enqueue_script('kacf-gallery', get_template_directory_uri() . '/js/gallery.js', array('jquery'), 1.1, true);
}
add_action('wp_enqueue_scripts', 'kacf_gallery_scripts');


function kacf_gallery()
{
  if (is_admin() || !is_front_page() || !is_page()) return;

  $current_page_id = get_the_ID();

  $pages = get_pages();

  $registered_blocks = acf_get_block_types();

  foreach ($pages as $page) {
    $page_id = $page->ID;

    if ($page_id == $current_page_id) continue;

    $post = get_post($page->ID);
    $content = $post->post_content;

    if (has_blocks($content)) {
      $blocks = parse_blocks($post->post_content);
      foreach ($blocks as $block) {
        $block_name = $block['blockName'];
        $keywords = $registered_blocks[$block_name]['keywords'];
        if (!$keywords) $keywords = array('unclassified');

        $classes = 'kacf-filter';

        foreach ($keywords as $keyword) {
          if (!$keyword) continue;
          $classes .= ' kacf-filter-' . $keyword;
        }

        echo '<div class="' . $classes . '">';
        echo render_block($block);
        echo '</div>';
      }
    }
  }
}
add_action('the_content', 'kacf_gallery', 15);
