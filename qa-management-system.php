<?php
/**
 * Plugin Name: Q&A Management System
 * Plugin URI: https://yoursite.com
 * Description: A comprehensive Q&A management system with Bricks Builder compatibility.
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: qa-management-system
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define constants
define( 'QAMS_PATH', plugin_dir_path( __FILE__ ) );
define( 'QAMS_URL', plugin_dir_url( __FILE__ ) );
define( 'QAMS_VER', '1.0.0' );

// Autoload classes
require_once QAMS_PATH . 'includes/class-qams-post-type.php';
require_once QAMS_PATH . 'includes/class-qams-admin.php';
require_once QAMS_PATH . 'includes/class-qams-frontend.php';
require_once QAMS_PATH . 'includes/class-qams-shortcodes.php';
require_once QAMS_PATH . 'includes/class-qams-ajax.php';

// Activation/Deactivation
register_activation_hook( __FILE__, array( 'QAMS_Post_Type', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'QAMS_Post_Type', 'deactivate' ) );

// Initialize plugin
add_action( 'plugins_loaded', function() {
    load_plugin_textdomain( 'qa-management-system', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    new QAMS_Post_Type();
    new QAMS_Admin();
    new QAMS_Frontend();
    new QAMS_Shortcodes();
    new QAMS_Ajax();
});