<!DOCTYPE html> <!-- html -->
<html <?php language_attributes() ?> xmlns:fb="http://ogp.me/ns/fb#">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
  <meta name="HandheldFriendly" content="true">
  <meta name="apple-touch-fullscreen" content="yes">
  <title><?php echo wp_title() ?></title>
  <?php wp_enqueue_script("jquery") ?>
  <?php wp_head() ?>
</head> <!-- head -->

<body <?php body_class(); ?>>
  <!-- body -->
  <header>
  </header> <!-- header -->

  <main role="main" id="main">
    <!-- main -->