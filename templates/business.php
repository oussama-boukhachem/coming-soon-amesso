<?php
/**
 * Business Template
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: <?php echo esc_attr($frontend->get_option('text_color', '#2c3e50')); ?>;
            background: <?php echo esc_attr($frontend->get_option('background_color', '#f8f9fa')); ?>;
            <?php if ($frontend->get_option('background_type') === 'image' && $frontend->get_option('background_image')): ?>
            background: url('<?php echo esc_url($frontend->get_option('background_image')); ?>') center/cover no-repeat;
            <?php endif; ?>
        }
        
        <?php if ($frontend->get_option('background_type') === 'image' && $frontend->get_option('background_image')): ?>
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            z-index: 1;
        }
        <?php endif; ?>
        
        .csa-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            z-index: 2;
        }
        
        .csa-content {
            text-align: center;
            max-width: 800px;
            background: #fff;
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
            position: relative;
        }
        
        .csa-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: <?php echo esc_attr($frontend->get_option('accent_color', '#007bff')); ?>;
            border-radius: 2px;
        }
        
        .csa-logo {
            margin-bottom: 40px;
        }
        
        .csa-logo img {
            max-width: 200px;
            height: auto;
        }
        
        .csa-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2c3e50;
            letter-spacing: -0.5px;
        }
        
        .csa-headline {
            font-size: 1.4rem;
            font-weight: 500;
            margin-bottom: 30px;
            color: #495057;
        }
        
        .csa-description {
            font-size: 1.1rem;
            margin-bottom: 50px;
            color: #6c757d;
            line-height: 1.8;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .csa-countdown-section {
            margin-bottom: 50px;
        }
        
        .csa-countdown-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 30px;
            color: #495057;
        }
        
        .csa-countdown {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .csa-countdown-item {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 25px 20px;
            transition: all 0.3s ease;
        }
        
        .csa-countdown-item:hover {
            border-color: <?php echo esc_attr($frontend->get_option('accent_color', '#007bff')); ?>;
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 123, 255, 0.1);
        }
        
        .csa-countdown-number {
            display: block;
            font-size: 2.5rem;
            font-weight: 700;
            color: <?php echo esc_attr($frontend->get_option('accent_color', '#007bff')); ?>;
            line-height: 1;
            margin-bottom: 10px;
        }
        
        .csa-countdown-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6c757d;
        }
        
        .csa-progress-section {
            margin-bottom: 50px;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 15px;
            border: 1px solid #e9ecef;
        }
        
        .csa-progress-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #495057;
        }
        
        .csa-progress-container {
            position: relative;
            width: 100%;
            height: 12px;
            background: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 15px;
        }
        
        .csa-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, <?php echo esc_attr($frontend->get_option('accent_color', '#007bff')); ?>, #0056b3);
            border-radius: 6px;
            width: <?php echo esc_attr($frontend->get_option('progress_percentage', 75)); ?>%;
            transition: width 2s ease-out;
            position: relative;
        }
        
        .csa-progress-percentage {
            font-size: 1rem;
            font-weight: 600;
            color: <?php echo esc_attr($frontend->get_option('accent_color', '#007bff')); ?>;
        }
        
        .csa-email-section {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 15px;
            border: 1px solid #e9ecef;
            margin-bottom: 30px;
        }
        
        .csa-email-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        
        .csa-email-subtitle {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 30px;
        }
        
        .csa-email-form {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
            gap: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .csa-email-input {
            flex: 1;
            padding: 18px 20px;
            border: 2px solid #e9ecef;
            border-right: none;
            font-size: 1rem;
            background: #fff;
            color: #495057;
        }
        
        .csa-email-input:focus {
            outline: none;
            border-color: <?php echo esc_attr($frontend->get_option('accent_color', '#007bff')); ?>;
        }
        
        .csa-email-submit {
            padding: 18px 30px;
            border: 2px solid <?php echo esc_attr($frontend->get_option('accent_color', '#007bff')); ?>;
            background: <?php echo esc_attr($frontend->get_option('accent_color', '#007bff')); ?>;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .csa-email-submit:hover {
            background: #0056b3;
            border-color: #0056b3;
            transform: translateY(-1px);
        }
        
        .csa-email-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            font-weight: 500;
            display: none;
        }
        
        .csa-email-message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .csa-email-message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .csa-footer {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .csa-contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .csa-contact-item {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .csa-contact-item strong {
            color: #495057;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .csa-content {
                padding: 40px 20px;
                margin: 20px;
            }
            
            .csa-title {
                font-size: 2.5rem;
            }
            
            .csa-headline {
                font-size: 1.2rem;
            }
            
            .csa-countdown {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
            
            .csa-countdown-item {
                padding: 20px 15px;
            }
            
            .csa-countdown-number {
                font-size: 2rem;
            }
            
            .csa-email-form {
                flex-direction: column;
            }
            
            .csa-email-input {
                border-right: 2px solid #e9ecef;
                border-bottom: none;
            }
            
            .csa-contact-info {
                flex-direction: column;
                gap: 10px;
            }
        }
        
        /* Loading state */
        .csa-loading .csa-email-submit {
            opacity: 0.7;
            position: relative;
        }
        
        .csa-loading .csa-email-submit::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Animations */
        .csa-content {
            animation: fadeInUp 0.8s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            
            <h2 class="csa-headline"><?php echo esc_html($frontend->get_option('headline')); ?></h2>
            
            <p class="csa-description"><?php echo esc_html($frontend->get_option('description')); ?></p>
            
            <?php if ($frontend->get_option('countdown_enabled')): ?>
            <div class="csa-countdown-section">
                <h3 class="csa-countdown-title"><?php _e('Launch Countdown', 'coming-soon-amesso'); ?></h3>
                <div class="csa-countdown" id="countdown">
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
            <div class="csa-progress-section">
                <div class="csa-progress-title">
                    <?php _e('Development Progress', 'coming-soon-amesso'); ?>
                </div>
                <div class="csa-progress-container">
                    <div class="csa-progress-bar"></div>
                </div>
                <div class="csa-progress-percentage">
                    <?php echo esc_html($frontend->get_option('progress_percentage', 75)); ?>% <?php _e('Complete', 'coming-soon-amesso'); ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ($frontend->get_option('email_enabled')): ?>
            <div class="csa-email-section">
                <h3 class="csa-email-title"><?php _e('Stay Updated', 'coming-soon-amesso'); ?></h3>
                <p class="csa-email-subtitle"><?php _e('Be the first to know when we launch. Subscribe to our newsletter.', 'coming-soon-amesso'); ?></p>
                
                <form class="csa-email-form" id="emailForm">
                    <input 
                        type="email" 
                        class="csa-email-input" 
                        name="email" 
                        placeholder="<?php echo esc_attr($frontend->get_option('email_placeholder')); ?>" 
                        required
                    >
                    <button type="submit" class="csa-email-submit">
                        <?php echo esc_html($frontend->get_option('email_button_text')); ?>
                    </button>
                </form>
                
                <div class="csa-email-message" id="emailMessage"></div>
            </div>
            <?php endif; ?>
            
            <div class="csa-footer">
                <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. <?php _e('All rights reserved.', 'coming-soon-amesso'); ?></p>
                
                <div class="csa-contact-info">
                    <div class="csa-contact-item">
                        <strong><?php _e('Email:', 'coming-soon-amesso'); ?></strong> <?php echo get_option('admin_email'); ?>
                    </div>
                    <div class="csa-contact-item">
                        <strong><?php _e('Website:', 'coming-soon-amesso'); ?></strong> <?php echo home_url(); ?>
                    </div>
                </div>
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
                    document.querySelector('.csa-countdown-section').innerHTML = '<h3 class="csa-countdown-title"><?php _e('We\'re Live!', 'coming-soon-amesso'); ?></h3><p><?php _e('Thank you for waiting. We\'re now live!', 'coming-soon-amesso'); ?></p>';
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
