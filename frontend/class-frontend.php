<?php
/**
 * Frontend functionality
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class CSA_Frontend {
    
    private $options;
    
    public function __construct() {
        $this->options = get_option('csa_options');
        
        add_action('template_redirect', array($this, 'show_coming_soon_page'));
        add_action('wp_ajax_csa_subscribe', array($this, 'handle_subscription'));
        add_action('wp_ajax_nopriv_csa_subscribe', array($this, 'handle_subscription'));
        add_action('wp_head', array($this, 'add_custom_head_code'));
    }
    
    /**
     * Show coming soon page if enabled
     */
    public function show_coming_soon_page() {
        // Don't show if coming soon is disabled
        if (empty($this->options['enabled'])) {
            return;
        }
        
        // Don't show to users with bypass roles
        if (is_user_logged_in() && $this->user_can_bypass()) {
            return;
        }
        
        // Don't show on admin pages
        if (is_admin()) {
            return;
        }
        
        // Don't show for AJAX requests
        if (wp_doing_ajax()) {
            return;
        }
        
        // Don't show for REST API requests
        if (defined('REST_REQUEST') && REST_REQUEST) {
            return;
        }
        
        // Don't show for login/register pages
        if ($GLOBALS['pagenow'] === 'wp-login.php') {
            return;
        }
        
        // Show preview if requested
        if (isset($_GET['csa_preview']) && current_user_can('manage_options')) {
            $this->render_coming_soon_page();
            exit;
        }
        
        // Show coming soon page
        $this->render_coming_soon_page();
        exit;
    }
    
    /**
     * Check if current user can bypass coming soon
     */
    private function user_can_bypass() {
        if (!is_user_logged_in()) {
            return false;
        }
        
        $user = wp_get_current_user();
        $bypass_roles = $this->options['bypass_roles'];
        
        foreach ($user->roles as $role) {
            if (in_array($role, $bypass_roles)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Render the coming soon page
     */
    private function render_coming_soon_page() {
        // Set proper HTTP status
        status_header(200);
        
        // Set no-cache headers
        nocache_headers();
        
        // Get template
        $template = $this->options['template'];
        $template_file = CSA_PLUGIN_PATH . "templates/{$template}.php";
        
        if (!file_exists($template_file)) {
            $template_file = CSA_PLUGIN_PATH . 'templates/modern.php';
        }
        
        // Load template
        include $template_file;
    }
    
    /**
     * Handle email subscription
     */
    public function handle_subscription() {
        check_ajax_referer('csa_nonce', 'nonce');
        
        $email = sanitize_email($_POST['email']);
        
        if (!is_email($email)) {
            wp_send_json_error(array('message' => __('Please enter a valid email address.', 'coming-soon-amesso')));
        }
        
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'csa_subscribers';
        
        // Check if email already exists
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table_name WHERE email = %s",
            $email
        ));
        
        if ($existing) {
            wp_send_json_error(array('message' => __('This email is already subscribed.', 'coming-soon-amesso')));
        }
        
        // Insert new subscriber
        $result = $wpdb->insert(
            $table_name,
            array(
                'email' => $email,
                'date_subscribed' => current_time('mysql'),
                'status' => 'active'
            ),
            array('%s', '%s', '%s')
        );
        
        if ($result === false) {
            wp_send_json_error(array('message' => __('Failed to subscribe. Please try again.', 'coming-soon-amesso')));
        }
        
        // Send notification email to admin (optional)
        $admin_email = get_option('admin_email');
        $subject = sprintf(__('New subscriber: %s', 'coming-soon-amesso'), $email);
        $message = sprintf(__('A new user has subscribed to your coming soon page: %s', 'coming-soon-amesso'), $email);
        
        wp_mail($admin_email, $subject, $message);
        
        wp_send_json_success(array('message' => __('Thank you for subscribing! We\'ll notify you when we launch.', 'coming-soon-amesso')));
    }
    
    /**
     * Add custom head code
     */
    public function add_custom_head_code() {
        if (empty($this->options['enabled']) || (is_user_logged_in() && $this->user_can_bypass())) {
            return;
        }
        
        // Add favicon
        if (!empty($this->options['favicon'])) {
            echo '<link rel="icon" type="image/x-icon" href="' . esc_url($this->options['favicon']) . '">' . "\n";
        }
        
        // Add analytics code
        if (!empty($this->options['analytics_code'])) {
            echo $this->options['analytics_code'] . "\n";
        }
        
        // Add custom CSS
        if (!empty($this->options['custom_css'])) {
            echo '<style type="text/css">' . "\n" . $this->options['custom_css'] . "\n" . '</style>' . "\n";
        }
    }
    
    /**
     * Get option value
     */
    public function get_option($key, $default = '') {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }
    
    /**
     * Get formatted countdown date
     */
    public function get_countdown_timestamp() {
        return strtotime($this->options['countdown_date']) * 1000; // JavaScript timestamp
    }
    
    /**
     * Get social media links (for future use)
     */
    public function get_social_links() {
        return isset($this->options['social_links']) ? $this->options['social_links'] : array();
    }
}
