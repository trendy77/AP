<?php
/**
 * Plugin Name: Sortable Word Count
 * Plugin URI: http://lapuvieta.lv
 * Description: Sortable word count for posts or pages.
 * Version: 1.2
 * Author: Janis Itkacs
 * Author URI: http://lapuvieta.lv
 * License: GPL2
 */

if (!defined( 'ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!is_admin()) {
    return false;
} // Don't run if not admin page

/**
 * Define variables
 */
define('META_FIELD_KEY', '_jswc_meta_word_count');
define('OPTION_FIELD_KEY', '_jswc_option_word_count');

/**
 * Deactivate plugin
 */
function jswc_deactivation() {
    if (!current_user_can('activate_plugins')) {
        return;
    }

    $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
    check_admin_referer("deactivate-plugin_{$plugin}");

    // Delete WC init option
    delete_option(OPTION_FIELD_KEY);
}
register_deactivation_hook( __FILE__, 'jswc_deactivation' );

/**
 * Init plugin
 */
function jswc_sortable_word_count_run() {

    // Update posts/pages word count
    add_action('init', 'jswc_update_posts_wc_value');

    // Add columns
    add_filter('manage_posts_columns', 'jswc_add_wc_column_table_head');
    add_filter('manage_page_posts_columns', 'jswc_add_wc_column_table_head');

    // Fill word count value
    add_action('manage_posts_custom_column', 'jswc_add_wc_column_table_content', 10, 2);
    add_action('manage_page_posts_custom_column', 'jswc_add_wc_column_table_content', 10, 2);

    // Enable sorting for columns
    add_filter('manage_edit-post_sortable_columns', 'jswc_add_wc_table_sorting');
    add_filter('manage_edit-page_sortable_columns', 'jswc_add_wc_table_sorting');

    // Sort values
    add_filter('request', 'jswc_wc_column_sort');

    // Update word count value on save
    add_action('save_post', 'jswc_update_post_wc_value');

    // Add custom styles
    add_action('admin_head', 'jswc_styles');
}

/**
 * Add Word Count column to post type
 * @param $defaults
 * @return mixed
 */
function jswc_add_wc_column_table_head( $defaults ) {
    $defaults['word_count'] = __('Word Count', 'jswc');
    return $defaults;
}

/**
 * Show word count for post type
 * @param $column_name
 */
function jswc_add_wc_column_table_content($column_name) {
    global $post;
    if ($column_name == 'word_count') {
        echo get_post_meta($post->ID, META_FIELD_KEY, true);
    }
}

/**
 * Make column word count sortable
 * @param $columns
 * @return mixed
 */
function jswc_add_wc_table_sorting($columns) {
    $columns['word_count'] = 'word_count';
    return $columns;
}

/**
 * Sort values by word count
 * @param $vars
 * @return array
 */
function jswc_wc_column_sort($vars) {
    if (isset( $vars['orderby']) && 'word_count' == $vars['orderby']) {
        $vars = array_merge( $vars, array(
            'meta_key' => META_FIELD_KEY,
            'orderby' => 'meta_value_num'
        ));
    }
    return $vars;
}

/**
 * Set word count for post type
 * @param string $post_type
 */
function jswc_update_wc_posts($post_type='post') {
    $query = new WP_Query('post_type='.$post_type.'&posts_per_page=-1');
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            $content = get_post_field('post_content', get_the_ID());
            update_post_meta(get_the_ID(), META_FIELD_KEY, str_word_count($content));
        }
    }
    wp_reset_postdata();
}

/**
 * Update for all post types
 */
function jswc_update_posts_wc_value() {
    if (get_option(OPTION_FIELD_KEY) == false) {
        // Posts
        jswc_update_wc_posts('post');
        // Pages
        jswc_update_wc_posts('page');
        // Initialized
        add_option(OPTION_FIELD_KEY, true);
    }
}

/**
 * Update Word Count on save
 * @param $post_id
 */
function jswc_update_post_wc_value( $post_id ) {
    $content = get_post_field('post_content', $post_id);
    update_post_meta($post_id, META_FIELD_KEY, str_word_count($content));
}

/**
 * Styles
 */
function jswc_styles() {
    echo '<style type="text/css">
           #word_count { width: 12%; }
           .word_count { text-align: center; }
         </style>';
}

/**
 * Run plugin
 */
jswc_sortable_word_count_run();

