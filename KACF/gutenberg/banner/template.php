<?php
/*
 * name: banner
 * title: Bannière
 ** icon: admin-site
 ** keywords: banner, bannière
 ** post_types:
 ** description:
 ** category:
 */
?>

<?php
$image = get_field('image');
$breadcrumb = get_field('breadcrumb');
?>

<section class="banner">
    <div class="container-fluid">
        <img width=<?= $image['width'] ?> height=<?= $image['height'] ?> src="<?= esc_url($image['url']) ?>" alt="<?= esc_html($image['alt']) ?>" data-aos="fade-right" data-aos-duration="600">
        <?php if ($breadcrumb['show'] == 'y') : ?>
            <div class="container">
                <?php
                if (function_exists('yoast_breadcrumb')) :
                    yoast_breadcrumb('<p id="breadcrumbs">' . ($breadcrumb['text-before-breadcrumb'] ? '<span class="label">' . $breadcrumb['text-before-breadcrumb'] . '</span>' : ''), '</p>');
                endif;
                ?>
            </div>
        <?php endif; ?>
    </div>
</section>