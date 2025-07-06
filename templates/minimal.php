<?php
/**
 * Minimal Template
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

$frontend = new CSA_Frontend();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    
    <title><?php echo esc_html($frontend->get_option('seo_title', get_bloginfo('name'))); ?></title>
    <meta name="description" content="<?php echo esc_attr($frontend->get_option('seo_description')); ?>">
    
    <?php if ($frontend->get_option('favicon')): ?>
    <link rel="icon" type="image/x-icon" href="<?php echo esc_url($frontend->get_option('favicon')); ?>">
    <?php endif; ?>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Georgia', serif;
            line-height: 1.6;
            color: <?php echo esc_attr($frontend->get_option('text_color', '#333333')); ?>;
            background: <?php echo esc_attr($frontend->get_option('background_color', '#ffffff')); ?>;
            <?php if ($frontend->get_option('background_type') === 'image' && $frontend->get_option('background_image')): ?>
            background: url('<?php echo esc_url($frontend->get_option('background_image')); ?>') center/cover no-repeat;
            <?php endif; ?>
        }
        
        .csa-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        .csa-content {
            text-align: center;
            max-width: 500px;
        }
        
        .csa-logo {
            margin-bottom: 40px;
        }
        
        .csa-logo img {
            max-width: 150px;
            height: auto;
        }
        
        .csa-title {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 30px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        .csa-description {
            font-size: 1.1rem;
            margin-bottom: 40px;
            font-style: italic;
            opacity: 0.8;
        }
        
        .csa-countdown {
            margin-bottom: 50px;
        }
        
        .csa-countdown-timer {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 20px;
        }
        
        .csa-countdown-item {
            text-align: center;
        }
        
        .csa-countdown-number {
            display: block;
            font-size: 2.5rem;
            font-weight: 300;
            color: <?php echo esc_attr($frontend->get_option('accent_color', '#000000')); ?>;
            line-height: 1;
        }
        
        .csa-countdown-label {
            display: block;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
            opacity: 0.6;
        }
        
        .csa-email-form {
            margin-bottom: 40px;
        }
        
        .csa-email-input {
            width: 100%;
            max-width: 300px;
            padding: 15px 0;
            border: none;
            border-bottom: 2px solid <?php echo esc_attr($frontend->get_option('accent_color', '#000000')); ?>;
            background: transparent;
            font-size: 1rem;
            text-align: center;
            color: inherit;
            margin-bottom: 20px;
        }
        
        .csa-email-input:focus {
            outline: none;
            border-bottom-color: <?php echo esc_attr($frontend->get_option('accent_color', '#000000')); ?>;
        }
        
        .csa-email-input::placeholder {
            color: inherit;
            opacity: 0.6;
        }
        
        .csa-email-submit {
            padding: 12px 30px;
            border: 2px solid <?php echo esc_attr($frontend->get_option('accent_color', '#000000')); ?>;
            background: transparent;
            color: inherit;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .csa-email-submit:hover {
            background: <?php echo esc_attr($frontend->get_option('accent_color', '#000000')); ?>;
            color: <?php echo esc_attr($frontend->get_option('background_color', '#ffffff')); ?>;
        }
        
        .csa-email-message {
            margin-top: 20px;
            font-size: 0.9rem;
            display: none;
        }
        
        .csa-email-message.success {
            color: #28a745;
        }
        
        .csa-email-message.error {
            color: #dc3545;
        }
        
        .csa-progress {
            margin-bottom: 40px;
        }
        
        .csa-progress-text {
            font-size: 0.9rem;
            margin-bottom: 15px;
            opacity: 0.7;
        }
        
        .csa-progress-bar {
            width: 100%;
            max-width: 300px;
            height: 2px;
            background: rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            position: relative;
        }
        
        .csa-progress-fill {
            height: 100%;
            background: <?php echo esc_attr($frontend->get_option('accent_color', '#000000')); ?>;
            width: <?php echo esc_attr($frontend->get_option('progress_percentage', 75)); ?>%;
            transition: width 0.3s ease;
        }
        
        .csa-footer {
            font-size: 0.8rem;
            opacity: 0.5;
            margin-top: 40px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .csa-title {
                font-size: 2rem;
            }
            
            .csa-countdown-timer {
                gap: 20px;
            }
            
            .csa-countdown-number {
                font-size: 2rem;
            }
        }
        
        /* Loading state */
        .csa-loading .csa-email-submit {
            opacity: 0.6;
            pointer-events: none;
        }
        
        <?php echo $frontend->get_option('custom_css'); ?>
    </style>
    
    <?php echo $frontend->get_option('analytics_code'); ?>
</head>
<body>
    <div class="csa-container">
        <div class="csa-content">
            <?php if ($frontend->get_option('logo')): ?>
            <div class="csa-logo">
                <img src="<?php echo esc_url($frontend->get_option('logo')); ?>" alt="<?php echo esc_attr($frontend->get_option('title')); ?>">
            </div>
            <?php endif; ?>
            
            <h1 class="csa-title"><?php echo esc_html($frontend->get_option('title', 'Coming Soon')); ?></h1>
            
            <p class="csa-description"><?php echo esc_html($frontend->get_option('description')); ?></p>
            
            <?php if ($frontend->get_option('countdown_enabled')): ?>
            <div class="csa-countdown">
                <div class="csa-countdown-timer" id="countdown">
                    <div class="csa-countdown-item">
                        <span class="csa-countdown-number" id="days">00</span>
                        <span class="csa-countdown-label"><?php _e('Days', 'coming-soon-amesso'); ?></span>
                    </div>
                    <div class="csa-countdown-item">
                        <span class="csa-countdown-number" id="hours">00</span>
                        <span class="csa-countdown-label"><?php _e('Hours', 'coming-soon-amesso'); ?></span>
                    </div>
                    <div class="csa-countdown-item">
                        <span class="csa-countdown-number" id="minutes">00</span>
                        <span class="csa-countdown-label"><?php _e('Minutes', 'coming-soon-amesso'); ?></span>
                    </div>
                    <div class="csa-countdown-item">
                        <span class="csa-countdown-number" id="seconds">00</span>
                        <span class="csa-countdown-label"><?php _e('Seconds', 'coming-soon-amesso'); ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ($frontend->get_option('progress_bar_enabled')): ?>
            <div class="csa-progress">
                <div class="csa-progress-text">
                    <?php printf(__('Progress: %s%%', 'coming-soon-amesso'), $frontend->get_option('progress_percentage', 75)); ?>
                </div>
                <div class="csa-progress-bar">
                    <div class="csa-progress-fill"></div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ($frontend->get_option('email_enabled')): ?>
            <form class="csa-email-form" id="emailForm">
                <div>
                    <input 
                        type="email" 
                        class="csa-email-input" 
                        name="email" 
                        placeholder="<?php echo esc_attr($frontend->get_option('email_placeholder')); ?>" 
                        required
                    >
                </div>
                <div>
                    <button type="submit" class="csa-email-submit">
                        <?php echo esc_html($frontend->get_option('email_button_text')); ?>
                    </button>
                </div>
                <div class="csa-email-message" id="emailMessage"></div>
            </form>
            <?php endif; ?>
            
            <div class="csa-footer">
                &copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Countdown timer
            <?php if ($frontend->get_option('countdown_enabled')): ?>
            const countdownDate = <?php echo $frontend->get_countdown_timestamp(); ?>;
            
            function updateCountdown() {
                const now = new Date().getTime();
                const distance = countdownDate - now;
                
                if (distance < 0) {
                    document.getElementById('countdown').innerHTML = '<div class="csa-countdown-item"><span class="csa-countdown-number">∞</span><span class="csa-countdown-label"><?php _e('Live', 'coming-soon-amesso'); ?></span></div>';
                    return;
                }
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                document.getElementById('days').textContent = String(days).padStart(2, '0');
                document.getElementById('hours').textContent = String(hours).padStart(2, '0');
                document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
                document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
            }
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
            <?php endif; ?>
            
            // Email subscription
            <?php if ($frontend->get_option('email_enabled')): ?>
            const emailForm = document.getElementById('emailForm');
            const emailMessage = document.getElementById('emailMessage');
            
            emailForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData();
                formData.append('action', 'csa_subscribe');
                formData.append('nonce', '<?php echo wp_create_nonce('csa_nonce'); ?>');
                formData.append('email', this.email.value);
                
                emailForm.classList.add('csa-loading');
                emailMessage.style.display = 'none';
                
                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    emailMessage.className = 'csa-email-message ' + (data.success ? 'success' : 'error');
                    emailMessage.textContent = data.data.message;
                    emailMessage.style.display = 'block';
                    
                    if (data.success) {
                        emailForm.reset();
                    }
                })
                .catch(error => {
                    emailMessage.className = 'csa-email-message error';
                    emailMessage.textContent = '<?php _e('An error occurred. Please try again.', 'coming-soon-amesso'); ?>';
                    emailMessage.style.display = 'block';
                })
                .finally(() => {
                    emailForm.classList.remove('csa-loading');
                });
            });
            <?php endif; ?>
        });
    </script>
</body>
</html>
