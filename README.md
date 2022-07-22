# KACF

## Dependencies

-   [WordPress](https://wordpress.org/)
-   [ACF (Advanced Custom Fields) PRO](https://www.advancedcustomfields.com/)

## Recommended Plugins

-   [ACF Extended](https://www.acf-extended.com/) : This plugin allows you to see the local ACF fields and insert them directly into your database

## KACF : What and why ?

The goal of KACF is to simplify the creation and duplication of blocks in multiple websites.

Once your block has been created in one site, you can reuse it in another site by simply copying and pasting the block folder into your new theme.

## Installation

### KACF + KACF Gallery

-   Clone or download the directory
-   Customize it by modifying **/screenshot.png**, **/style.css**.

### KACF only

-   Download the folder **/lib/kacf/** and insert it in your lib folder.
-   Create the folder **/gutenberg/** in your theme directory.
-   Add the lines below in the **functions.php** file:

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

-   Copy the **/gutenberg/\_base** folder and rename it as follows: **/gutenberg/_myblock_/**.
-   Add a title (and other information if necessary) in the comments of the **/gutenberg/_myblock_/template.php** file header.
-   Export the PHP block code creation (available in the ACF administration interface).
-   Import it in the file **/gutenberg/_myblock_/acf/acf.php**.
-   It's done.

## Block duplication

-   Copy the **/gutenberg/_myblock_** folder and from another site and past it into your own **/gutenber/** folder.
-   It's done.
