<?php
/*
 * title: Code court
 ** icon: shortcode
 ** keywords: 
 ** post_types:
 ** description:
 ** category: 
 */
?>

<?php
$shortcode = get_field('shortcode');
?>

<section class="shortcode">
    <?php echo do_shortcode($shortcode) ?>
</section>