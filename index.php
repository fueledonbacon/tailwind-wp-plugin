<?php

/**
 * Plugin Name: Tailwind for WP
 * Plugin URI: https://github.com/fueledonbacon/tailwind-wp-plugin.git
 * Description: Tailwind CSS utilities
 * Version: 1.0.2
 * Author: Ryan Cwynar
 *
 * @package tailwind
 */

defined('ABSPATH') || exit;

/**
 * Load translations (if any) for the plugin from the /languages/ folder.
 * 
 * @link https://developer.wordpress.org/reference/functions/load_plugin_textdomain/
 */
add_action('init', 'tailwind_load_textdomain');

function tailwind_load_textdomain()
{
  load_plugin_textdomain('tailwind', false, basename(__DIR__) . '/languages');
}

/**
 * Makes Tailwind available in the block editor
 *
 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-registration/
 */


function tailwind_plugin_scripts()
{
  wp_enqueue_style('tailwind-style',
    plugins_url('tailwind.css', __FILE__),            // script file
    array(),  // dependencies
    filemtime(plugin_dir_path(__FILE__) . 'tailwind.css') //set version to last modified time
  );
}

add_action('wp_enqueue_scripts', 'tailwind_plugin_scripts');
add_action('admin_enqueue_scripts', 'tailwind_plugin_scripts');


