<?php
/**
 * Plugin Name: Coming Soon Amesso
 * Plugin URI: https://github.com/oussama-boukhachem/coming-soon-amesso
 * Description: A modern, lightweight coming soon plugin with customizable templates and features for WordPress 2025.
 * Version: 1.0.0
 * Author: Oussama Boukhachem
 * Author URI: https://oussama-boukhachem.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: coming-soon-amesso
 * Domain Path: /languages
 * Requires at least: 5.8
 * Tested up to: 6.7
 * Requires PHP: 8.0
 * Network: false
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CSA_VERSION', '1.0.0');
define('CSA_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CSA_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('CSA_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Main plugin class
class ComingSoonAmesso {
    
    private static $instance = null;
    
    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        add_action('plugins_loaded', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Load text domain for translations
        load_plugin_textdomain('coming-soon-amesso', false, dirname(CSA_PLUGIN_BASENAME) . '/languages');
        
        // Initialize admin
        if (is_admin()) {
            require_once CSA_PLUGIN_PATH . 'admin/class-admin.php';
            new CSA_Admin();
        }
        
        // Initialize frontend
        require_once CSA_PLUGIN_PATH . 'frontend/class-frontend.php';
        new CSA_Frontend();
        
        // Load utilities
        require_once CSA_PLUGIN_PATH . 'includes/class-utils.php';
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        // Set default options
        $default_options = array(
            'enabled' => false,
            'title' => __('Coming Soon', 'coming-soon-amesso'),
            'headline' => __('We\'re launching something amazing!', 'coming-soon-amesso'),
            'description' => __('Our website is under construction. We\'ll be here soon with our new awesome site.', 'coming-soon-amesso'),
            'template' => 'modern',
            'background_type' => 'color',
            'background_color' => '#1a1a1a',
            'background_image' => '',
            'text_color' => '#ffffff',
            'accent_color' => '#007cba',
            'countdown_enabled' => true,
            'countdown_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'email_enabled' => true,
            'email_placeholder' => __('Enter your email address', 'coming-soon-amesso'),
            'email_button_text' => __('Notify Me', 'coming-soon-amesso'),
            'social_enabled' => true,
            'social_links' => array(),
            'seo_title' => __('Coming Soon', 'coming-soon-amesso'),
            'seo_description' => __('We\'re launching something amazing! Stay tuned.', 'coming-soon-amesso'),
            'bypass_roles' => array('administrator'),
            'custom_css' => '',
            'analytics_code' => '',
            'favicon' => '',
            'logo' => '',
            'progress_bar_enabled' => false,
            'progress_percentage' => 75
        );
        
        add_option('csa_options', $default_options);
        
        // Create email subscribers table
        $this->create_subscribers_table();
    }
    
    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Clean up if needed
    }
    
    /**
     * Create subscribers table
     */
    private function create_subscribers_table() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'csa_subscribers';
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            email varchar(100) NOT NULL,
            date_subscribed datetime DEFAULT CURRENT_TIMESTAMP,
            status varchar(20) DEFAULT 'active',
            PRIMARY KEY (id),
            UNIQUE KEY email (email)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

// Initialize the plugin
ComingSoonAmesso::get_instance();
