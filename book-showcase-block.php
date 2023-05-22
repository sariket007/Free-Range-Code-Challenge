<?php
/**
 * Plugin Name: Book Showcase Block.
 * Plugin URI: https://github.com/sariket007/Free-Range-Code-Challenge
 * Description: The plugin for book showcase using gutenburg block.
 * Author: Sumit Sariket
 * Author URI: https://github.com/sariket007
 * Version: 1.0.0-alpha.1
 * Text Domain: book-showcase-block.
 * 
 * @package book-showcase-block.
 */

namespace SS\BOOKSHOWCASE;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SS_BOOK_SHOWCASE_DIR' ) ) {
	define( 'SS_BOOK_SHOWCASE_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
}
if (!function_exists('is_plugin_active') || !function_exists('deactivate_plugins')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

require SS_BOOK_SHOWCASE_DIR . '/inc/functions/helpers.php';
require SS_BOOK_SHOWCASE_DIR . '/inc/model/bookdata.php';
require_once SS_BOOK_SHOWCASE_DIR . '/vendor/autoload.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

$pluginActivation = new Validate_Activation();
register_activation_hook( __FILE__, [ $pluginActivation, 'activation_check' ] );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\setup' );
