<?php
/**
 * Modern Template
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: <?php echo esc_attr($frontend->get_option('text_color', '#ffffff')); ?>;
            overflow-x: hidden;
        }
        
        .csa-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            
            <?php if ($frontend->get_option('background_type') === 'color'): ?>
            background: <?php echo esc_attr($frontend->get_option('background_color', '#1a1a1a')); ?>;
            <?php elseif ($frontend->get_option('background_type') === 'gradient'): ?>
            background: linear-gradient(135deg, <?php echo esc_attr($frontend->get_option('background_color', '#1a1a1a')); ?>, <?php echo esc_attr($frontend->get_option('accent_color', '#007cba')); ?>);
            <?php elseif ($frontend->get_option('background_type') === 'image' && $frontend->get_option('background_image')): ?>
            background: url('<?php echo esc_url($frontend->get_option('background_image')); ?>') center/cover no-repeat;
            <?php else: ?>
            background: <?php echo esc_attr($frontend->get_option('background_color', '#1a1a1a')); ?>;
            <?php endif; ?>
        }
        
        <?php if ($frontend->get_option('background_type') === 'image' && $frontend->get_option('background_image')): ?>
        .csa-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        <?php endif; ?>
        
        .csa-content {
            text-align: center;
            max-width: 600px;
            position: relative;
            z-index: 2;
        }
        
        .csa-logo {
            margin-bottom: 40px;
        }
        
        .csa-logo img {
            max-width: 200px;
            height: auto;
        }
        
        .csa-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .csa-headline {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .csa-description {
            font-size: 1.1rem;
            margin-bottom: 40px;
            opacity: 0.8;
            line-height: 1.8;
        }
        
        .csa-countdown {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 50px;
            flex-wrap: wrap;
        }
        
        .csa-countdown-item {
            text-align: center;
            min-width: 80px;
        }
        
        .csa-countdown-number {
            display: block;
            font-size: 3rem;
            font-weight: bold;
            color: <?php echo esc_attr($frontend->get_option('accent_color', '#007cba')); ?>;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .csa-countdown-label {
            display: block;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.7;
            margin-top: 5px;
        }
        
        .csa-progress {
            margin-bottom: 40px;
        }
        
        .csa-progress-bar {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 15px;
        }
        
        .csa-progress-fill {
            height: 100%;
            background: <?php echo esc_attr($frontend->get_option('accent_color', '#007cba')); ?>;
            border-radius: 3px;
            transition: width 0.3s ease;
            width: <?php echo esc_attr($frontend->get_option('progress_percentage', 75)); ?>%;
        }
        
        .csa-progress-text {
            font-size: 0.9rem;
            opacity: 0.7;
        }
        
        .csa-email-form {
            display: flex;
            max-width: 400px;
            margin: 0 auto 40px;
            gap: 0;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .csa-email-input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.95);
            color: #333;
        }
        
        .csa-email-input:focus {
            outline: none;
            background: #fff;
        }
        
        .csa-email-submit {
            padding: 15px 25px;
            border: none;
            background: <?php echo esc_attr($frontend->get_option('accent_color', '#007cba')); ?>;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .csa-email-submit:hover {
            background: <?php echo esc_attr($frontend->get_option('accent_color', '#007cba')); ?>dd;
            transform: translateY(-1px);
        }
        
        .csa-email-message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            font-weight: 500;
            display: none;
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
        
        .csa-social {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }
        
        .csa-social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: inherit;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .csa-social-link:hover {
            background: <?php echo esc_attr($frontend->get_option('accent_color', '#007cba')); ?>;
            transform: translateY(-3px);
            color: white;
        }
        
        .csa-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .csa-particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite linear;
        }
        
        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
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
                gap: 20px;
            }
            
            .csa-countdown-number {
                font-size: 2rem;
            }
            
            .csa-email-form {
                flex-direction: column;
                border-radius: 10px;
            }
            
            .csa-email-input,
            .csa-email-submit {
                border-radius: 10px;
            }
        }
        
        /* Loading animation */
        .csa-loading {
            opacity: 0.7;
            pointer-events: none;
        }
        
        .csa-loading .csa-email-submit {
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
        
        <?php echo $frontend->get_option('custom_css'); ?>
    </style>
    
    <?php echo $frontend->get_option('analytics_code'); ?>
</head>
<body>
    <div class="csa-container">
        <!-- Animated particles -->
        <div class="csa-particles" id="particles"></div>
        
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
                <div class="csa-progress-bar">
                    <div class="csa-progress-fill"></div>
                </div>
                <div class="csa-progress-text">
                    <?php printf(__('Development Progress: %s%%', 'coming-soon-amesso'), $frontend->get_option('progress_percentage', 75)); ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ($frontend->get_option('email_enabled')): ?>
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
                    document.getElementById('countdown').innerHTML = '<h3><?php _e('We\'re Live!', 'coming-soon-amesso'); ?></h3>';
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
                
                // Show loading state
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
            
            // Animated particles
            function createParticles() {
                const particles = document.getElementById('particles');
                const particleCount = window.innerWidth > 768 ? 50 : 25;
                
                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'csa-particle';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.animationDelay = Math.random() * 15 + 's';
                    particle.style.animationDuration = (15 + Math.random() * 10) + 's';
                    particles.appendChild(particle);
                }
            }
            
            createParticles();
        });
    </script>
</body>
</html>
