<?php
/**
 * Utility functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class CSA_Utils {
    
    /**
     * Get plugin options
     */
    public static function get_options() {
        return get_option('csa_options', array());
    }
    
    /**
     * Get specific option value
     */
    public static function get_option($key, $default = '') {
        $options = self::get_options();
        return isset($options[$key]) ? $options[$key] : $default;
    }
    
    /**
     * Update plugin options
     */
    public static function update_options($options) {
        return update_option('csa_options', $options);
    }
    
    /**
     * Check if coming soon mode is enabled
     */
    public static function is_enabled() {
        return (bool) self::get_option('enabled', false);
    }
    
    /**
     * Format time remaining for countdown
     */
    public static function format_time_remaining($timestamp) {
        $now = time();
        $diff = $timestamp - $now;
        
        if ($diff <= 0) {
            return array('expired' => true);
        }
        
        $days = floor($diff / (60 * 60 * 24));
        $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($diff % (60 * 60)) / 60);
        $seconds = $diff % 60;
        
        return array(
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds,
            'expired' => false
        );
    }
    
    /**
     * Get subscriber count
     */
    public static function get_subscriber_count() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'csa_subscribers';
        
        return $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'active'");
    }
    
    /**
     * Validate email
     */
    public static function validate_email($email) {
        return is_email($email);
    }
    
    /**
     * Sanitize color value
     */
    public static function sanitize_color($color) {
        // Remove any non-hex characters
        $color = preg_replace('/[^#a-fA-F0-9]/', '', $color);
        
        // Ensure it starts with #
        if (strpos($color, '#') !== 0) {
            $color = '#' . $color;
        }
        
        // Validate hex color format
        if (!preg_match('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/', $color)) {
            return '#000000'; // Default to black
        }
        
        return $color;
    }
    
    /**
     * Get template list
     */
    public static function get_templates() {
        return array(
            'modern' => __('Modern', 'coming-soon-amesso'),
            'minimal' => __('Minimal', 'coming-soon-amesso'),
            'creative' => __('Creative', 'coming-soon-amesso'),
            'business' => __('Business', 'coming-soon-amesso')
        );
    }
    
    /**
     * Log debug message
     */
    public static function log($message, $level = 'info') {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log("[Coming Soon Amesso - {$level}] " . $message);
        }
    }
    
    /**
     * Check if current request is preview
     */
    public static function is_preview() {
        return isset($_GET['csa_preview']) && current_user_can('manage_options');
    }
    
    /**
     * Get current page URL
     */
    public static function get_current_url() {
        $protocol = is_ssl() ? 'https://' : 'http://';
        return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Format date for display
     */
    public static function format_date($date, $format = null) {
        if ($format === null) {
            $format = get_option('date_format') . ' ' . get_option('time_format');
        }
        
        return date_i18n($format, strtotime($date));
    }
    
    /**
     * Get plugin version
     */
    public static function get_version() {
        return CSA_VERSION;
    }
    
    /**
     * Check if pro features are available (for future use)
     */
    public static function is_pro() {
        return apply_filters('csa_is_pro', false);
    }
}
