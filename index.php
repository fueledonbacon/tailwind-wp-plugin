<?php

/**
 * Plugin Name: Tailwind for WP
 * Plugin URI: https://github.com/fueledonbacon/tailwind-wp-plugin.git
 * Description: Tailwind CSS utilities
 * Version: 1.0.0
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
 * Add custom image size for block featured image.
 * 
 * @link https://developer.wordpress.org/reference/functions/add_image_size/
 */
add_action('init', 'tailwind_add_image_size');

function tailwind_add_image_size()
{
  add_image_size('tailwindFeatImg', 250, 250, array('center', 'center'));
}

/** 
 * Register custom image size with sizes list to make it available.
 * 
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/image_size_names_choose
 */
add_filter('image_size_names_choose', 'tailwind_custom_sizes');

function tailwind_custom_sizes($sizes)
{
  return array_merge($sizes, array(
    'tailwindFeatImg' => __('Tailwind Featured Image'),
  ));
}

/**
 * Makes Tailwind available in the block editor
 *
 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-registration/
 */
add_action('init', 'tailwind_register_blocks');
add_action('enqueue_block_editor_assets', 'tailwind_register_blocks');

function tailwind_register_blocks()
{

  // If Block Editor is not active, bail.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Register the front-end stylesheet.
  wp_register_style(
    'tailwind-style',                    // label
    plugins_url('dist/tailwind.css', __FILE__),            // CSS file
    array(),    // dependencies
    filemtime(plugin_dir_path(__FILE__) . 'dist/tailwind.css')  // set version as file last modified time
  );
}

// Custom PHP Below

function tailwind_plugin_scripts()
{
  wp_enqueue_style('tailwind-style',
    plugins_url('dist/tailwind.css', __FILE__),            // script file
    array(),  // dependencies
    filemtime(plugin_dir_path(__FILE__) . 'dist/tailwind.css') //set version to last modified time
  );
}

add_action('wp_enqueue_scripts', 'tailwind_plugin_scripts');


