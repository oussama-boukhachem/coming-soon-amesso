<?php
/**
 * Uninstall script
 * This file is executed when the plugin is deleted
 */

// Prevent direct access
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Remove plugin options
delete_option('csa_options');
delete_site_option('csa_options');

// Drop subscribers table
global $wpdb;
if (isset($wpdb)) {
    $table_name = $wpdb->prefix . 'csa_subscribers';
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}

// Clear any cached data
wp_cache_flush();
