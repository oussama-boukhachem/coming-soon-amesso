<?php
/**
 * Creative Template
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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: <?php echo esc_attr($frontend->get_option('text_color', '#ffffff')); ?>;
            overflow-x: hidden;
            background: linear-gradient(45deg, 
                <?php echo esc_attr($frontend->get_option('background_color', '#667eea')); ?>, 
                <?php echo esc_attr($frontend->get_option('accent_color', '#764ba2')); ?>);
            min-height: 100vh;
            position: relative;
        }
        
        <?php if ($frontend->get_option('background_type') === 'image' && $frontend->get_option('background_image')): ?>
        body {
            background: url('<?php echo esc_url($frontend->get_option('background_image')); ?>') center/cover no-repeat;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, 
                <?php echo esc_attr($frontend->get_option('background_color', '#667eea')); ?>cc, 
                <?php echo esc_attr($frontend->get_option('accent_color', '#764ba2')); ?>cc);
            z-index: 1;
        }
        <?php endif; ?>
        
        .csa-background-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .csa-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite linear;
        }
        
        .csa-shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .csa-shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 20%;
            right: 10%;
            animation-delay: 5s;
        }
        
        .csa-shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 15%;
            animation-delay: 10s;
        }
        
        .csa-shape:nth-child(4) {
            width: 100px;
            height: 100px;
            bottom: 30%;
            right: 20%;
            animation-delay: 15s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }
        
        .csa-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 2;
        }
        
        .csa-content {
            text-align: center;
            max-width: 700px;
            position: relative;
        }
        
        .csa-logo {
            margin-bottom: 40px;
            transform: scale(0);
            animation: logoAppear 1s ease-out 0.5s forwards;
        }
        
        .csa-logo img {
            max-width: 180px;
            height: auto;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
        }
        
        .csa-title {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #fff, rgba(255, 255, 255, 0.8));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transform: translateY(50px);
            opacity: 0;
            animation: slideUp 1s ease-out 0.3s forwards;
        }
        
        .csa-headline {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 30px;
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 1s ease-out 0.6s forwards;
        }
        
        .csa-description {
            font-size: 1.1rem;
            margin-bottom: 50px;
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 1s ease-out 0.9s forwards;
            line-height: 1.8;
        }
        
        .csa-countdown {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-bottom: 60px;
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 1s ease-out 1.2s forwards;
        }
        
        .csa-countdown-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }
        
        .csa-countdown-item:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .csa-countdown-number {
            display: block;
            font-size: 3rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
            margin-bottom: 10px;
        }
        
        .csa-countdown-label {
            display: block;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.8;
        }
        
        .csa-progress {
            margin-bottom: 50px;
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 1s ease-out 1.5s forwards;
        }
        
        .csa-progress-text {
            font-size: 1rem;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .csa-progress-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            height: 12px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            overflow: hidden;
        }
        
        .csa-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #fff, rgba(255, 255, 255, 0.8));
            border-radius: 6px;
            width: <?php echo esc_attr($frontend->get_option('progress_percentage', 75)); ?>%;
            position: relative;
            transition: width 2s ease-out;
        }
        
        .csa-progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(100%);
            }
        }
        
        .csa-email-section {
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 1s ease-out 1.8s forwards;
        }
        
        .csa-email-form {
            display: flex;
            max-width: 450px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 60px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .csa-email-input {
            flex: 1;
            padding: 20px 25px;
            border: none;
            background: transparent;
            color: #fff;
            font-size: 1rem;
        }
        
        .csa-email-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .csa-email-input:focus {
            outline: none;
        }
        
        .csa-email-submit {
            padding: 20px 30px;
            border: none;
            background: linear-gradient(45deg, #fff, rgba(255, 255, 255, 0.9));
            color: <?php echo esc_attr($frontend->get_option('accent_color', '#764ba2')); ?>;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 50px;
            margin: 5px;
        }
        
        .csa-email-submit:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .csa-email-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            font-weight: 500;
            display: none;
            backdrop-filter: blur(10px);
        }
        
        .csa-email-message.success {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }
        
        .csa-email-message.error {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        
        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes logoAppear {
            to {
                transform: scale(1);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .csa-title {
                font-size: 2.5rem;
            }
            
            .csa-headline {
                font-size: 1.2rem;
            }
            
            .csa-countdown {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            
            .csa-countdown-item {
                padding: 20px 15px;
            }
            
            .csa-countdown-number {
                font-size: 2rem;
            }
            
            .csa-email-form {
                flex-direction: column;
                border-radius: 20px;
            }
            
            .csa-email-input,
            .csa-email-submit {
                border-radius: 15px;
            }
        }
        
        /* Loading animation */
        .csa-loading .csa-email-submit {
            position: relative;
            color: transparent;
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
            border-top-color: <?php echo esc_attr($frontend->get_option('accent_color', '#764ba2')); ?>;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        <?php echo $frontend->get_option('custom_css'); ?>
    </style>
    
    <?php echo $frontend->get_option('analytics_code'); ?>
</head>
<body>
    <div class="csa-background-shapes">
        <div class="csa-shape"></div>
        <div class="csa-shape"></div>
        <div class="csa-shape"></div>
        <div class="csa-shape"></div>
    </div>
    
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
            <?php endif; ?>
            
            <?php if ($frontend->get_option('progress_bar_enabled')): ?>
            <div class="csa-progress">
                <div class="csa-progress-text">
                    <?php printf(__('Development Progress: %s%%', 'coming-soon-amesso'), $frontend->get_option('progress_percentage', 75)); ?>
                </div>
                <div class="csa-progress-container">
                    <div class="csa-progress-bar"></div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ($frontend->get_option('email_enabled')): ?>
            <div class="csa-email-section">
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
                    document.getElementById('countdown').innerHTML = '<div class="csa-countdown-item" style="grid-column: 1 / -1;"><span class="csa-countdown-number">🎉</span><span class="csa-countdown-label"><?php _e('We\'re Live!', 'coming-soon-amesso'); ?></span></div>';
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
