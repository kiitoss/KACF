# KACF

Repository core:

- **/lib/kacf/**
- **/gutenberg/kacf-gallery/**

The other elements are examples and the basics of the theme.

## Dependencies

- [WordPress](https://wordpress.org/)
- [ACF (Advanced Custom Fields)](https://www.advancedcustomfields.com/)

## Half-dependencies

- [LESS Compiler](https://lesscss.org/) or [SASS Compiler](https://sass-lang.com/) is required to use the KACF Gallery block (LESS is already included in this directory).

## Recommended Plugins

- [ACF Extended](https://www.acf-extended.com/) : This plugin allows you to see the local ACF fields and insert them directly into your database

## KACF : What and why ?

The goal of KACF is to simplify the creation and duplication of blocks in multiple websites.

Once your block has been created in one site, you can reuse it in another site by simply copying and pasting the block folder into your new theme.

To help you manage all your blocks, you will find the **kacf-gallery** block. This block retrieves all blocks from all pages of your website and adds them all in one section, where you can search for blocks with keywords and see them live.

## Installation

### KACF + KACF Gallery

- Clone or download the directory
- Customize it by modifying **/screenshot.png**, **/style.css**.

### KACF only

- Download the folder **/lib/kacf/** and insert it in your lib folder.
- Create the folder **/gutenberg/** in your theme directory.
- Add the lines below in the **functions.php** file:

```php
require dirname(__FILE__) . '/lib/kacf/kacf.inc.php';
new kacf();
```

There are some options in the KACF class to customize the architecture of your theme.

```php
new kacf(
  $gutpath = '/gutenberg/', // path of your gutenberg folder
  $add_hooks = true, // add action and filter to launch the KACF class
  $relative_paths = array(
    'php' => 'template.php', // php template path inside the block folder
    'css' => 'less/index.php', // css path inside the block folder
    'js' => 'js/script.js', // js path inside the block folder
    'acf' => 'acf/acf.php' // acf path inside the block folder
  ),
  $unregister_default_blocks = true // unregister the WP core blocks
);
```

## Block creation

- Copy the **/gutenberg/\_base** folder and rename it as follows: **/gutenberg/_myblock_/**.
- Add a title (and other information if necessary) in the comments of the **/gutenberg/_myblock_/template.php** file header.
- Export the PHP block code creation (available in the ACF administration interface).
- Import it in the file **/gutenberg/_myblock_/acf/acf.php**.
- It's done.

## Block duplication

- Copy the **/gutenberg/_myblock_** folder and from another site and past it into your own **/gutenber/** folder.
- It's done.

## Insert new block in gallery

- Once your block has been added to the **/gutenberg/** folder, you can add it to any page on your website.
- Choose a page for your gallery, and add the **kacf-gallery** block to the page to automatically retrieve all blocks from all pages.

## Deeper

To avoid conflicts between block styles inserted by the KACF Gallery block, each CSS file is taken out of the queue ([`wp_dequeue_style()`](https://developer.wordpress.org/reference/functions/wp_dequeue_style/)), curled, wrapped in a specific single class and embedded in the HTML code between `<style>` tags.
