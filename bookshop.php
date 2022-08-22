<?php
/**
* Plugin Name: Book Shop
* Plugin URI:  https://github.com/Sahil-Jaggi-97/BookShop
* Description: Your Mini Book Store
* Version:     1.0
* Author:      Sahil Jaggi
* Author URI:  https://github.com/Sahil-Jaggi-97
* License:     GPL v2 or later
* Text Domain: book-shop
**/


/*  Load Plugin Files  */
require_once( trailingslashit( dirname( __FILE__ ) ) . 'includes/autoloading.php' );


/* Initialize the Plugin  */
new BookShop\Includes\Init(__FILE__);