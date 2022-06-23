<?php
/*
 * name: articles
 * title: Article
 ** icon:
 ** keywords: article, blog
 ** post_types:
 ** description:
 ** category:
 */
?>

<?php
$title = get_field('title');
$subtitle = get_field('BCD');
?>

<section class="articles">
    <h1><?php echo $title ?></h1>
    <h2><?php echo $subtitle ?></h2>
</section>