/**
 * Coming Soon Amesso Admin JavaScript
 */

(function($) {
    'use strict';
    
    class CSAAdmin {
        constructor() {
            this.init();
        }
        
        init() {
            this.initTabs();
            this.initColorPickers();
            this.initMediaUpload();
            this.initFormHandling();
            this.initToggleHandling();
            this.initRangeSliders();
            this.initBackgroundType();
            this.initExportHandling();
        }
        
        initTabs() {
            $('.csa-tab-btn').on('click', (e) => {
                e.preventDefault();
                const tabId = $(e.target).data('tab');
                
                // Remove active class from all tabs and content
                $('.csa-tab-btn').removeClass('active');
                $('.csa-tab-content').removeClass('active');
                
                // Add active class to clicked tab and corresponding content
                $(e.target).addClass('active');
                $(`#tab-${tabId}`).addClass('active');
            });
        }
        
        initColorPickers() {
            $('.csa-color-picker').wpColorPicker({
                change: function(event, ui) {
                    // Trigger change event for live preview if needed
                    $(this).trigger('colorchange', ui.color.toString());
                }
            });
        }
        
        initMediaUpload() {
            $('.csa-upload-btn').on('click', (e) => {
                e.preventDefault();
                
                const button = $(e.target);
                const field = button.data('field');
                const hiddenInput = $(`#csa_${field}`);
                const preview = button.siblings('.csa-image-preview');
                
                // Create media frame
                const frame = wp.media({
                    title: 'Select or Upload Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false,
                    library: {
                        type: 'image'
                    }
                });
                
                // Handle image selection
                frame.on('select', () => {
                    const attachment = frame.state().get('selection').first().toJSON();
                    
                    hiddenInput.val(attachment.url);
                    
                    // Update preview
                    preview.html(`
                        <img src="${attachment.url}" alt="">
                        <button type="button" class="csa-remove-image">&times;</button>
                    `);
                });
                
                frame.open();
            });
            
            // Remove image handler
            $(document).on('click', '.csa-remove-image', (e) => {
                e.preventDefault();
                
                const preview = $(e.target).parent();
                const fieldName = preview.siblings('.csa-upload-btn').data('field');
                
                $(`#csa_${fieldName}`).val('');
                preview.empty();
            });
        }
        
        initFormHandling() {
            $('#csa-settings-form').on('submit', (e) => {
                e.preventDefault();
                this.saveSettings();
            });
        }
        
        initToggleHandling() {
            $('#csa-enable-toggle').on('change', (e) => {
                const enabled = $(e.target).is(':checked');
                this.updateToggleState(enabled);
            });
        }
        
        initRangeSliders() {
            $('input[type="range"]').on('input', (e) => {
                const value = $(e.target).val();
                $(e.target).siblings('.csa-range-value').text(value + '%');
            });
        }
        
        initBackgroundType() {
            $('input[name="background_type"]').on('change', () => {
                this.updateBackgroundFields();
            });
            
            // Initial setup
            this.updateBackgroundFields();
        }
        
        initExportHandling() {
            $('#csa-export-subscribers').on('click', (e) => {
                e.preventDefault();
                this.exportSubscribers();
            });
        }
        
        updateToggleState(enabled) {
            // Update hidden field for enabled state
            if (enabled) {
                if ($('input[name="enabled"]').length === 0) {
                    $('#csa-settings-form').append('<input type="hidden" name="enabled" value="1">');
                }
            } else {
                $('input[name="enabled"]').remove();
            }
            
            // Auto-save when toggling
            this.saveSettings();
        }
        
        updateBackgroundFields() {
            const selectedType = $('input[name="background_type"]:checked').val();
            
            // Hide all background fields
            $('.csa-bg-color-field, .csa-bg-image-field').removeClass('show');
            
            // Show relevant field
            if (selectedType === 'color' || selectedType === 'gradient') {
                $('.csa-bg-color-field').addClass('show');
            } else if (selectedType === 'image') {
                $('.csa-bg-image-field').addClass('show');
            }
        }
        
        saveSettings() {
            const form = $('#csa-settings-form');
            const saveBtn = $('.csa-save-btn');
            const saveMessage = $('.csa-save-message');
            
            // Show loading state
            form.addClass('csa-loading');
            saveBtn.text(csa_ajax.strings.saving);
            saveMessage.removeClass('success error').text('');
            
            // Prepare form data
            const formData = new FormData(form[0]);
            formData.append('action', 'csa_save_settings');
            formData.append('nonce', csa_ajax.nonce);
            
            // Send AJAX request
            $.ajax({
                url: csa_ajax.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: (response) => {
                    if (response.success) {
                        saveMessage.addClass('success').text(response.data.message);
                    } else {
                        saveMessage.addClass('error').text(response.data.message || csa_ajax.strings.error);
                    }
                },
                error: () => {
                    saveMessage.addClass('error').text(csa_ajax.strings.error);
                },
                complete: () => {
                    // Remove loading state
                    form.removeClass('csa-loading');
                    saveBtn.text(csa_ajax.strings.saved);
                    
                    // Clear message after 3 seconds
                    setTimeout(() => {
                        saveMessage.removeClass('success error').text('');
                    }, 3000);
                }
            });
        }
        
        exportSubscribers() {
            const button = $('#csa-export-subscribers');
            const originalText = button.text();
            
            button.text('Exporting...').prop('disabled', true);
            
            $.ajax({
                url: csa_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'csa_export_subscribers',
                    nonce: csa_ajax.nonce
                },
                success: (response) => {
                    if (response.success) {
                        // Create download link
                        const blob = new Blob([atob(response.data.data)], { type: 'text/csv' });
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = response.data.filename;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                    } else {
                        alert(response.data.message || 'Export failed');
                    }
                },
                error: () => {
                    alert('Export failed');
                },
                complete: () => {
                    button.text(originalText).prop('disabled', false);
                }
            });
        }
    }
    
    // Initialize when document is ready
    $(document).ready(() => {
        new CSAAdmin();
    });
    
})(jQuery);
