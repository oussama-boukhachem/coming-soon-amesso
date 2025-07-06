<?php
/**
 * Admin functionality
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class CSA_Admin {
    
    private $options;
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_csa_save_settings', array($this, 'save_settings'));
        add_action('wp_ajax_csa_export_subscribers', array($this, 'export_subscribers'));
        add_action('wp_ajax_csa_upload_media', array($this, 'upload_media'));
        
        $this->options = get_option('csa_options');
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('Coming Soon', 'coming-soon-amesso'),
            __('Coming Soon', 'coming-soon-amesso'),
            'manage_options',
            'coming-soon-amesso',
            array($this, 'admin_page'),
            'dashicons-visibility',
            25
        );
        
        add_submenu_page(
            'coming-soon-amesso',
            __('Settings', 'coming-soon-amesso'),
            __('Settings', 'coming-soon-amesso'),
            'manage_options',
            'coming-soon-amesso',
            array($this, 'admin_page')
        );
        
        add_submenu_page(
            'coming-soon-amesso',
            __('Subscribers', 'coming-soon-amesso'),
            __('Subscribers', 'coming-soon-amesso'),
            'manage_options',
            'csa-subscribers',
            array($this, 'subscribers_page')
        );
    }
    
    /**
     * Initialize admin settings
     */
    public function admin_init() {
        register_setting('csa_settings', 'csa_options', array($this, 'sanitize_options'));
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'coming-soon-amesso') === false && strpos($hook, 'csa-') === false) {
            return;
        }
        
        wp_enqueue_media();
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');
        
        wp_enqueue_script(
            'csa-admin-js',
            CSA_PLUGIN_URL . 'admin/js/admin.js',
            array('jquery', 'wp-color-picker'),
            CSA_VERSION,
            true
        );
        
        wp_enqueue_style(
            'csa-admin-css',
            CSA_PLUGIN_URL . 'admin/css/admin.css',
            array(),
            CSA_VERSION
        );
        
        wp_localize_script('csa-admin-js', 'csa_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('csa_nonce'),
            'strings' => array(
                'saving' => __('Saving...', 'coming-soon-amesso'),
                'saved' => __('Settings saved!', 'coming-soon-amesso'),
                'error' => __('Error saving settings.', 'coming-soon-amesso')
            )
        ));
    }
    
    /**
     * Main admin page
     */
    public function admin_page() {
        ?>
        <div class="wrap csa-admin-wrap">
            <h1><?php _e('Coming Soon Settings', 'coming-soon-amesso'); ?></h1>
            
            <div class="csa-admin-header">
                <div class="csa-toggle-container">
                    <label class="csa-switch">
                        <input type="checkbox" id="csa-enable-toggle" <?php checked($this->options['enabled']); ?>>
                        <span class="csa-slider"></span>
                    </label>
                    <span class="csa-toggle-label">
                        <?php _e('Enable Coming Soon Mode', 'coming-soon-amesso'); ?>
                    </span>
                </div>
                
                <div class="csa-preview-btn">
                    <a href="<?php echo home_url('?csa_preview=1'); ?>" target="_blank" class="button button-secondary">
                        <?php _e('Preview Page', 'coming-soon-amesso'); ?>
                    </a>
                </div>
            </div>
            
            <div class="csa-admin-content">
                <div class="csa-tabs">
                    <nav class="csa-tab-nav">
                        <button class="csa-tab-btn active" data-tab="general"><?php _e('General', 'coming-soon-amesso'); ?></button>
                        <button class="csa-tab-btn" data-tab="design"><?php _e('Design', 'coming-soon-amesso'); ?></button>
                        <button class="csa-tab-btn" data-tab="content"><?php _e('Content', 'coming-soon-amesso'); ?></button>
                        <button class="csa-tab-btn" data-tab="features"><?php _e('Features', 'coming-soon-amesso'); ?></button>
                        <button class="csa-tab-btn" data-tab="advanced"><?php _e('Advanced', 'coming-soon-amesso'); ?></button>
                    </nav>
                    
                    <form id="csa-settings-form">
                        <?php wp_nonce_field('csa_nonce', 'csa_nonce'); ?>
                        
                        <!-- General Tab -->
                        <div class="csa-tab-content active" id="tab-general">
                            <div class="csa-section">
                                <h3><?php _e('Basic Settings', 'coming-soon-amesso'); ?></h3>
                                
                                <div class="csa-field">
                                    <label for="csa_title"><?php _e('Page Title', 'coming-soon-amesso'); ?></label>
                                    <input type="text" id="csa_title" name="title" value="<?php echo esc_attr($this->options['title']); ?>" />
                                </div>
                                
                                <div class="csa-field">
                                    <label for="csa_headline"><?php _e('Main Headline', 'coming-soon-amesso'); ?></label>
                                    <input type="text" id="csa_headline" name="headline" value="<?php echo esc_attr($this->options['headline']); ?>" />
                                </div>
                                
                                <div class="csa-field">
                                    <label for="csa_description"><?php _e('Description', 'coming-soon-amesso'); ?></label>
                                    <textarea id="csa_description" name="description" rows="4"><?php echo esc_textarea($this->options['description']); ?></textarea>
                                </div>
                                
                                <div class="csa-field">
                                    <label for="csa_template"><?php _e('Template', 'coming-soon-amesso'); ?></label>
                                    <select id="csa_template" name="template">
                                        <option value="modern" <?php selected($this->options['template'], 'modern'); ?>><?php _e('Modern', 'coming-soon-amesso'); ?></option>
                                        <option value="minimal" <?php selected($this->options['template'], 'minimal'); ?>><?php _e('Minimal', 'coming-soon-amesso'); ?></option>
                                        <option value="creative" <?php selected($this->options['template'], 'creative'); ?>><?php _e('Creative', 'coming-soon-amesso'); ?></option>
                                        <option value="business" <?php selected($this->options['template'], 'business'); ?>><?php _e('Business', 'coming-soon-amesso'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Design Tab -->
                        <div class="csa-tab-content" id="tab-design">
                            <div class="csa-section">
                                <h3><?php _e('Background', 'coming-soon-amesso'); ?></h3>
                                
                                <div class="csa-field">
                                    <label><?php _e('Background Type', 'coming-soon-amesso'); ?></label>
                                    <div class="csa-radio-group">
                                        <label>
                                            <input type="radio" name="background_type" value="color" <?php checked($this->options['background_type'], 'color'); ?>>
                                            <?php _e('Solid Color', 'coming-soon-amesso'); ?>
                                        </label>
                                        <label>
                                            <input type="radio" name="background_type" value="image" <?php checked($this->options['background_type'], 'image'); ?>>
                                            <?php _e('Background Image', 'coming-soon-amesso'); ?>
                                        </label>
                                        <label>
                                            <input type="radio" name="background_type" value="gradient" <?php checked($this->options['background_type'], 'gradient'); ?>>
                                            <?php _e('Gradient', 'coming-soon-amesso'); ?>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="csa-field csa-bg-color-field">
                                    <label for="csa_background_color"><?php _e('Background Color', 'coming-soon-amesso'); ?></label>
                                    <input type="text" id="csa_background_color" name="background_color" value="<?php echo esc_attr($this->options['background_color']); ?>" class="csa-color-picker" />
                                </div>
                                
                                <div class="csa-field csa-bg-image-field">
                                    <label><?php _e('Background Image', 'coming-soon-amesso'); ?></label>
                                    <div class="csa-media-upload">
                                        <input type="hidden" id="csa_background_image" name="background_image" value="<?php echo esc_attr($this->options['background_image']); ?>" />
                                        <button type="button" class="button csa-upload-btn" data-field="background_image"><?php _e('Choose Image', 'coming-soon-amesso'); ?></button>
                                        <div class="csa-image-preview">
                                            <?php if (!empty($this->options['background_image'])): ?>
                                                <img src="<?php echo esc_url($this->options['background_image']); ?>" alt="">
                                                <button type="button" class="csa-remove-image">&times;</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="csa-field">
                                    <label for="csa_text_color"><?php _e('Text Color', 'coming-soon-amesso'); ?></label>
                                    <input type="text" id="csa_text_color" name="text_color" value="<?php echo esc_attr($this->options['text_color']); ?>" class="csa-color-picker" />
                                </div>
                                
                                <div class="csa-field">
                                    <label for="csa_accent_color"><?php _e('Accent Color', 'coming-soon-amesso'); ?></label>
                                    <input type="text" id="csa_accent_color" name="accent_color" value="<?php echo esc_attr($this->options['accent_color']); ?>" class="csa-color-picker" />
                                </div>
                                
                                <div class="csa-field">
                                    <label><?php _e('Logo', 'coming-soon-amesso'); ?></label>
                                    <div class="csa-media-upload">
                                        <input type="hidden" id="csa_logo" name="logo" value="<?php echo esc_attr($this->options['logo']); ?>" />
                                        <button type="button" class="button csa-upload-btn" data-field="logo"><?php _e('Choose Logo', 'coming-soon-amesso'); ?></button>
                                        <div class="csa-image-preview">
                                            <?php if (!empty($this->options['logo'])): ?>
                                                <img src="<?php echo esc_url($this->options['logo']); ?>" alt="">
                                                <button type="button" class="csa-remove-image">&times;</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Content Tab -->
                        <div class="csa-tab-content" id="tab-content">
                            <div class="csa-section">
                                <h3><?php _e('SEO Settings', 'coming-soon-amesso'); ?></h3>
                                
                                <div class="csa-field">
                                    <label for="csa_seo_title"><?php _e('SEO Title', 'coming-soon-amesso'); ?></label>
                                    <input type="text" id="csa_seo_title" name="seo_title" value="<?php echo esc_attr($this->options['seo_title']); ?>" />
                                </div>
                                
                                <div class="csa-field">
                                    <label for="csa_seo_description"><?php _e('SEO Description', 'coming-soon-amesso'); ?></label>
                                    <textarea id="csa_seo_description" name="seo_description" rows="3"><?php echo esc_textarea($this->options['seo_description']); ?></textarea>
                                </div>
                                
                                <div class="csa-field">
                                    <label><?php _e('Favicon', 'coming-soon-amesso'); ?></label>
                                    <div class="csa-media-upload">
                                        <input type="hidden" id="csa_favicon" name="favicon" value="<?php echo esc_attr($this->options['favicon']); ?>" />
                                        <button type="button" class="button csa-upload-btn" data-field="favicon"><?php _e('Choose Favicon', 'coming-soon-amesso'); ?></button>
                                        <div class="csa-image-preview">
                                            <?php if (!empty($this->options['favicon'])): ?>
                                                <img src="<?php echo esc_url($this->options['favicon']); ?>" alt="">
                                                <button type="button" class="csa-remove-image">&times;</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Features Tab -->
                        <div class="csa-tab-content" id="tab-features">
                            <div class="csa-section">
                                <h3><?php _e('Countdown Timer', 'coming-soon-amesso'); ?></h3>
                                
                                <div class="csa-field">
                                    <label class="csa-checkbox">
                                        <input type="checkbox" name="countdown_enabled" value="1" <?php checked($this->options['countdown_enabled']); ?>>
                                        <?php _e('Enable Countdown Timer', 'coming-soon-amesso'); ?>
                                    </label>
                                </div>
                                
                                <div class="csa-field">
                                    <label for="csa_countdown_date"><?php _e('Launch Date', 'coming-soon-amesso'); ?></label>
                                    <input type="datetime-local" id="csa_countdown_date" name="countdown_date" value="<?php echo esc_attr(date('Y-m-d\TH:i', strtotime($this->options['countdown_date']))); ?>" />
                                </div>
                            </div>
                            
                            <div class="csa-section">
                                <h3><?php _e('Email Subscription', 'coming-soon-amesso'); ?></h3>
                                
                                <div class="csa-field">
                                    <label class="csa-checkbox">
                                        <input type="checkbox" name="email_enabled" value="1" <?php checked($this->options['email_enabled']); ?>>
                                        <?php _e('Enable Email Subscription', 'coming-soon-amesso'); ?>
                                    </label>
                                </div>
                                
                                <div class="csa-field">
                                    <label for="csa_email_placeholder"><?php _e('Email Placeholder Text', 'coming-soon-amesso'); ?></label>
                                    <input type="text" id="csa_email_placeholder" name="email_placeholder" value="<?php echo esc_attr($this->options['email_placeholder']); ?>" />
                                </div>
                                
                                <div class="csa-field">
                                    <label for="csa_email_button_text"><?php _e('Button Text', 'coming-soon-amesso'); ?></label>
                                    <input type="text" id="csa_email_button_text" name="email_button_text" value="<?php echo esc_attr($this->options['email_button_text']); ?>" />
                                </div>
                            </div>
                            
                            <div class="csa-section">
                                <h3><?php _e('Progress Bar', 'coming-soon-amesso'); ?></h3>
                                
                                <div class="csa-field">
                                    <label class="csa-checkbox">
                                        <input type="checkbox" name="progress_bar_enabled" value="1" <?php checked($this->options['progress_bar_enabled']); ?>>
                                        <?php _e('Enable Progress Bar', 'coming-soon-amesso'); ?>
                                    </label>
                                </div>
                                
                                <div class="csa-field">
                                    <label for="csa_progress_percentage"><?php _e('Progress Percentage', 'coming-soon-amesso'); ?></label>
                                    <input type="range" id="csa_progress_percentage" name="progress_percentage" min="0" max="100" value="<?php echo esc_attr($this->options['progress_percentage']); ?>">
                                    <span class="csa-range-value"><?php echo esc_html($this->options['progress_percentage']); ?>%</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Advanced Tab -->
                        <div class="csa-tab-content" id="tab-advanced">
                            <div class="csa-section">
                                <h3><?php _e('Access Control', 'coming-soon-amesso'); ?></h3>
                                
                                <div class="csa-field">
                                    <label><?php _e('Bypass Roles', 'coming-soon-amesso'); ?></label>
                                    <div class="csa-checkbox-group">
                                        <?php
                                        $roles = wp_roles()->get_names();
                                        foreach ($roles as $role_key => $role_name):
                                        ?>
                                        <label class="csa-checkbox">
                                            <input type="checkbox" name="bypass_roles[]" value="<?php echo esc_attr($role_key); ?>" <?php checked(in_array($role_key, $this->options['bypass_roles'])); ?>>
                                            <?php echo esc_html($role_name); ?>
                                        </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="csa-section">
                                <h3><?php _e('Custom Code', 'coming-soon-amesso'); ?></h3>
                                
                                <div class="csa-field">
                                    <label for="csa_custom_css"><?php _e('Custom CSS', 'coming-soon-amesso'); ?></label>
                                    <textarea id="csa_custom_css" name="custom_css" rows="8" class="csa-code-editor"><?php echo esc_textarea($this->options['custom_css']); ?></textarea>
                                </div>
                                
                                <div class="csa-field">
                                    <label for="csa_analytics_code"><?php _e('Analytics Code (Google Analytics, etc.)', 'coming-soon-amesso'); ?></label>
                                    <textarea id="csa_analytics_code" name="analytics_code" rows="6" class="csa-code-editor"><?php echo esc_textarea($this->options['analytics_code']); ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="csa-form-footer">
                            <button type="submit" class="button button-primary csa-save-btn">
                                <?php _e('Save Settings', 'coming-soon-amesso'); ?>
                            </button>
                            <span class="csa-save-message"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Subscribers page
     */
    public function subscribers_page() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'csa_subscribers';
        $subscribers = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date_subscribed DESC");
        $total_subscribers = count($subscribers);
        
        ?>
        <div class="wrap csa-admin-wrap">
            <h1><?php _e('Email Subscribers', 'coming-soon-amesso'); ?></h1>
            
            <div class="csa-subscribers-header">
                <div class="csa-stats">
                    <div class="csa-stat-box">
                        <span class="csa-stat-number"><?php echo $total_subscribers; ?></span>
                        <span class="csa-stat-label"><?php _e('Total Subscribers', 'coming-soon-amesso'); ?></span>
                    </div>
                </div>
                
                <button type="button" class="button button-secondary" id="csa-export-subscribers">
                    <?php _e('Export CSV', 'coming-soon-amesso'); ?>
                </button>
            </div>
            
            <?php if ($subscribers): ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e('Email', 'coming-soon-amesso'); ?></th>
                        <th><?php _e('Date Subscribed', 'coming-soon-amesso'); ?></th>
                        <th><?php _e('Status', 'coming-soon-amesso'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscribers as $subscriber): ?>
                    <tr>
                        <td><?php echo esc_html($subscriber->email); ?></td>
                        <td><?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($subscriber->date_subscribed))); ?></td>
                        <td>
                            <span class="csa-status csa-status-<?php echo esc_attr($subscriber->status); ?>">
                                <?php echo esc_html(ucfirst($subscriber->status)); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="csa-empty-state">
                <p><?php _e('No subscribers yet.', 'coming-soon-amesso'); ?></p>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }
    
    /**
     * Save settings via AJAX
     */
    public function save_settings() {
        check_ajax_referer('csa_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die();
        }
        
        $options = array();
        $options['enabled'] = isset($_POST['enabled']) ? (bool)$_POST['enabled'] : false;
        $options['title'] = sanitize_text_field($_POST['title']);
        $options['headline'] = sanitize_text_field($_POST['headline']);
        $options['description'] = sanitize_textarea_field($_POST['description']);
        $options['template'] = sanitize_text_field($_POST['template']);
        $options['background_type'] = sanitize_text_field($_POST['background_type']);
        $options['background_color'] = sanitize_hex_color($_POST['background_color']);
        $options['background_image'] = esc_url_raw($_POST['background_image']);
        $options['text_color'] = sanitize_hex_color($_POST['text_color']);
        $options['accent_color'] = sanitize_hex_color($_POST['accent_color']);
        $options['countdown_enabled'] = isset($_POST['countdown_enabled']) ? (bool)$_POST['countdown_enabled'] : false;
        $options['countdown_date'] = sanitize_text_field($_POST['countdown_date']);
        $options['email_enabled'] = isset($_POST['email_enabled']) ? (bool)$_POST['email_enabled'] : false;
        $options['email_placeholder'] = sanitize_text_field($_POST['email_placeholder']);
        $options['email_button_text'] = sanitize_text_field($_POST['email_button_text']);
        $options['social_enabled'] = isset($_POST['social_enabled']) ? (bool)$_POST['social_enabled'] : false;
        $options['seo_title'] = sanitize_text_field($_POST['seo_title']);
        $options['seo_description'] = sanitize_textarea_field($_POST['seo_description']);
        $options['bypass_roles'] = isset($_POST['bypass_roles']) ? array_map('sanitize_text_field', $_POST['bypass_roles']) : array();
        $options['custom_css'] = wp_strip_all_tags($_POST['custom_css']);
        $options['analytics_code'] = wp_kses($_POST['analytics_code'], array(
            'script' => array(
                'src' => array(),
                'type' => array(),
                'async' => array(),
                'defer' => array()
            )
        ));
        $options['favicon'] = esc_url_raw($_POST['favicon']);
        $options['logo'] = esc_url_raw($_POST['logo']);
        $options['progress_bar_enabled'] = isset($_POST['progress_bar_enabled']) ? (bool)$_POST['progress_bar_enabled'] : false;
        $options['progress_percentage'] = intval($_POST['progress_percentage']);
        
        update_option('csa_options', $options);
        
        wp_send_json_success(array('message' => __('Settings saved successfully!', 'coming-soon-amesso')));
    }
    
    /**
     * Export subscribers
     */
    public function export_subscribers() {
        check_ajax_referer('csa_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die();
        }
        
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'csa_subscribers';
        $subscribers = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date_subscribed DESC");
        
        if (empty($subscribers)) {
            wp_send_json_error(array('message' => __('No subscribers to export.', 'coming-soon-amesso')));
        }
        
        $filename = 'coming-soon-subscribers-' . date('Y-m-d') . '.csv';
        $csv_data = "Email,Date Subscribed,Status\n";
        
        foreach ($subscribers as $subscriber) {
            $csv_data .= sprintf(
                '"%s","%s","%s"' . "\n",
                $subscriber->email,
                $subscriber->date_subscribed,
                $subscriber->status
            );
        }
        
        wp_send_json_success(array(
            'filename' => $filename,
            'data' => base64_encode($csv_data)
        ));
    }
    
    // The sanitize_options method has been removed as sanitization is handled in save_settings.
}
