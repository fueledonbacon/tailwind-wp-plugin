<?php

/**
 * Plugin Name: Tailwind for WP
 * Plugin URI: https://github.com/fueledonbacon/tailwind-wp-plugin.git
 * Description: Tailwind CSS utilities
 * Version: 1.0.0
 * Author: Ryan Cwynar
 *
 * @package fueledonbacon
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
 * Add custom "Podkit" block category
 * 
 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/filters/block-filters/#managing-block-categories
 */
add_filter('block_categories', 'tailwind_block_categories', 10, 2);

function tailwind_block_categories($categories, $post)
{
  $array = array_merge(
    $categories,
    array(
      array(
        'slug' => 'tailwind',
        'title' => __('Tailwind', 'tailwind'),
        'icon'  => null,
      ),
    )
  );
  return $array;
}

/**
 * Registers all block assets so that they can be enqueued through the Block Editor in
 * the corresponding context.
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

  // Register the block editor stylesheet.
  wp_register_style(
    'tailwind-editor-styles',                      // label
    plugins_url('build/editor.css', __FILE__),          // CSS file
    array('wp-edit-blocks'),                    // dependencies
    filemtime(plugin_dir_path(__FILE__) . 'build/editor.css')  // set version as file last modified time
  );

  // Register the front-end stylesheet.
  wp_register_style(
    'tailwind-front-end-styles',                    // label
    plugins_url('build/style.css', __FILE__),            // CSS file
    array(),    // dependencies
    filemtime(plugin_dir_path(__FILE__) . 'build/style.css')  // set version as file last modified time
  );

  if (function_exists('wp_set_script_translations')) {
    /**
     * Adds internationalization support. 
     * 
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/internationalization/
     * @link https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
     */
    wp_set_script_translations('tailwind-editor-script', 'tailwind', plugin_dir_path(__FILE__) . '/languages');
  }
}

// Custom PHP Below

function tailwind_plugin_scripts()
{
  wp_enqueue_style('tailwind-style',
    plugins_url('build/style.css', __FILE__),            // script file
    array('theme-style'), 
    filemtime(plugin_dir_path(__FILE__) . 'build/style.css')
  );
}

add_action('wp_enqueue_scripts', 'tailwind_plugin_scripts');


