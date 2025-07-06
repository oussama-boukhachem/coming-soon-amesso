# Coming Soon Amesso - WordPress Plugin

A modern, lightweight coming soon plugin for WordPress 2025 with customizable templates and comprehensive features.

## Features

### 🎨 **Templates**
- **Modern** - Animated particles, gradient backgrounds, modern UI
- **Minimal** - Clean typography, simple elegance
- **Creative** - Animated shapes, vibrant colors, creative layouts
- **Business** - Professional design, corporate-ready

### ⏰ **Countdown Timer**
- Customizable launch date and time
- Real-time countdown display
- Automatic "We're Live!" message when time expires

### 📧 **Email Subscription**
- Built-in email collection system
- Subscriber management dashboard
- CSV export functionality
- Duplicate email prevention
- AJAX-powered subscription

### 🎯 **Customization Options**
- **Background Types**: Solid color, gradient, or custom image
- **Color Scheme**: Text color, background color, accent color
- **Typography**: Multiple font options per template
- **Logo Upload**: Custom logo support
- **Progress Bar**: Visual development progress indicator
- **Custom CSS**: Advanced styling options

### 🔧 **Advanced Features**
- **SEO Optimized**: Custom title, description, and favicon
- **Access Control**: Role-based bypass system
- **Analytics Integration**: Google Analytics and custom tracking code support
- **Preview Mode**: Live preview without affecting visitors
- **Responsive Design**: Mobile-friendly templates
- **Performance Optimized**: Lightweight and fast loading

### 🚀 **WordPress 2025 Ready**
- PHP 8.0+ compatibility
- WordPress 6.7+ support
- Modern WordPress standards
- Security best practices
- Translation ready

## Installation

### From GitHub (Latest Version)
1. Download the latest release from [GitHub Releases](https://github.com/oussama-boukhachem/coming-soon-amesso/releases)
2. Or clone the repository: `git clone https://github.com/oussama-boukhachem/coming-soon-amesso.git`
3. Upload the `coming-soon-amesso` folder to `/wp-content/plugins/`
4. Activate the plugin through the 'Plugins' menu in WordPress
5. Navigate to 'Coming Soon' in your admin menu
6. Configure your settings and enable coming soon mode

### From WordPress Directory (Coming Soon)
1. Search for "Coming Soon Amesso" in your WordPress admin under Plugins > Add New
2. Install and activate the plugin
3. Navigate to 'Coming Soon' in your admin menu

## Quick Setup

1. **Enable Plugin**: Toggle the coming soon mode switch
2. **Choose Template**: Select from Modern, Minimal, Creative, or Business
3. **Set Content**: Add your title, headline, and description
4. **Configure Countdown**: Set your launch date and time
5. **Customize Design**: Choose colors, upload logo, set background
6. **Enable Features**: Turn on email subscription, progress bar, etc.
7. **Preview**: Use the preview button to see your page

## Configuration

### General Settings
- **Page Title**: SEO title for your coming soon page
- **Main Headline**: Primary heading text
- **Description**: Detailed description of your upcoming launch
- **Template**: Choose your preferred design template

### Design Settings
- **Background**: Choose between solid color, gradient, or image
- **Colors**: Customize text, background, and accent colors
- **Logo**: Upload your brand logo
- **Favicon**: Set custom favicon

### Content Settings
- **SEO Title**: Custom page title for search engines
- **SEO Description**: Meta description for search engines
- **Custom Favicon**: Browser tab icon

### Features
- **Countdown Timer**: Enable/disable with custom launch date
- **Email Subscription**: Collect visitor emails with custom messages
- **Progress Bar**: Show development progress percentage
- **Social Links**: Add social media links (coming in future updates)

### Advanced Settings
- **Access Control**: Define which user roles can bypass the coming soon page
- **Custom CSS**: Add your own styling
- **Analytics Code**: Insert Google Analytics or other tracking codes

## Subscriber Management

- View all email subscribers in the admin dashboard
- Export subscriber list as CSV
- Track subscription dates and status
- Automatic duplicate prevention

## Templates Overview

### Modern Template
- Animated floating particles
- Gradient backgrounds
- Glass-morphism effects
- Smooth animations
- Mobile-optimized

### Minimal Template
- Clean typography
- Elegant simplicity
- Serif fonts
- Subtle animations
- Focused content

### Creative Template
- Animated background shapes
- Vibrant gradients
- Creative layouts
- Engaging animations
- Bold design

### Business Template
- Professional appearance
- Corporate color schemes
- Clean layouts
- Contact information
- Business-ready

## Customization

### Custom CSS
Add your own CSS in the Advanced settings tab:

```css
/* Custom styles */
.csa-title {
    font-size: 4rem !important;
}

.csa-countdown-item {
    background: rgba(255, 255, 255, 0.2) !important;
}
```

### Hooks and Filters (for developers)

```php
// Modify plugin options
add_filter('csa_default_options', function($options) {
    $options['title'] = 'My Custom Title';
    return $options;
});

// Add custom template
add_filter('csa_templates', function($templates) {
    $templates['custom'] = 'Custom Template';
    return $templates;
});

// Modify subscriber data before saving
add_filter('csa_subscriber_data', function($data) {
    // Add custom fields or validation
    return $data;
});
```

## Security Features

- CSRF protection with WordPress nonces
- SQL injection prevention
- XSS protection
- Input sanitization and validation
- Capability checks for admin functions

## Performance

- Minimal resource usage
- Optimized database queries
- Efficient asset loading
- Mobile-responsive design
- Fast loading times

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Requirements

- WordPress 5.8 or higher
- PHP 8.0 or higher
- MySQL 5.6 or higher

## Changelog

### Version 1.0.0
- Initial release
- 4 responsive templates
- Email subscription system
- Countdown timer
- Progress bar
- Comprehensive admin interface
- Role-based access control
- SEO optimization
- Analytics integration
- Custom CSS support

## Support

For support, feature requests, or bug reports:
- **GitHub Issues**: [Create an issue](https://github.com/oussama-boukhachem/coming-soon-amesso/issues)
- **Discussions**: [GitHub Discussions](https://github.com/oussama-boukhachem/coming-soon-amesso/discussions)
- **Documentation**: Check this README and plugin documentation

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This plugin is licensed under the GPL v2 or later.

## Credits

- Developed for WordPress 2025
- Modern web standards
- Responsive design principles
- User experience focused

---

**Coming Soon Amesso** - The modern way to create beautiful coming soon pages in WordPress.
