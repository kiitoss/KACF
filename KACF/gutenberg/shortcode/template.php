<?php
/*
 * name: shortcode
 * title: Code court
 ** icon: shortcode
 ** keywords: code court, shortcode
 ** post_types:
 ** description:
 ** category: idcom
 */
?>

<?php
$shortcode = get_field('shortcode');
?>

<section class="shortcode">
    <?php echo do_shortcode($shortcode) ?>
</section>