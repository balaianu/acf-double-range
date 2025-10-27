<?php
/**
 * Plugin Name: ACF Double Range Field
 * Description: Adds a double (min/max) range slider field type to Advanced Custom Fields (ACF). Fully supports ACF 6+ and the block editor.
 * Version: 2.0.0
 * Author: Andrei Balaianu
 * Author URI: https://github.com/balaianu
 * Plugin URI: https://github.com/balaianu/acf-double-range
 * License: GPLv2 or later
 * Text Domain: acf-double-range
 */


if (!defined('ABSPATH')) exit;

define('ACF_DR_VERSION', '2.0.0');
define('ACF_DR_URL', plugin_dir_url(__FILE__));
define('ACF_DR_PATH', plugin_dir_path(__FILE__));

/**
 * Register the custom field type with ACF.
 */
add_action('acf/include_field_types', function() {
    require_once ACF_DR_PATH . 'fields/class-acf-field-double-range.php';
    new acf_field_double_range([
        'version' => ACF_DR_VERSION,
        'url'     => ACF_DR_URL,
        'path'    => ACF_DR_PATH,
    ]);
});

/**
 * Ensure assets are also present inside the Gutenberg editor iframe.
 */
add_action('enqueue_block_editor_assets', function () {
    // Core + slider
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-widget');
    wp_enqueue_script('jquery-ui-mouse');
    wp_enqueue_script('jquery-ui-slider');

    // Field CSS + JS
    wp_enqueue_style(
        'acf-dr-field-css',
        ACF_DR_URL . 'assets/css/field.css',
        [],
        ACF_DR_VERSION
    );

    wp_enqueue_script(
        'acf-dr-field-js',
        ACF_DR_URL . 'assets/js/field.js',
        // Important: 'acf-input' guarantees the ACF JS API is present in the iframe
        ['jquery', 'jquery-ui-slider', 'acf-input'],
        ACF_DR_VERSION,
        true
    );
});
