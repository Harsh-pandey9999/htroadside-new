/**
 * Material Design JavaScript for HT Roadside Assistance
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize ripple effect
    initRippleEffect();
    
    // Initialize tabs
    initTabs();
    
    // Initialize theme toggle
    initThemeToggle();
    
    // Initialize drawer
    initDrawer();
});

/**
 * Initialize ripple effect for buttons and clickable elements
 */
function initRippleEffect() {
    const rippleElements = document.querySelectorAll('.md-btn, .md-list-item, .md-tab');
    
    rippleElements.forEach(element => {
        element.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            
            const rect = element.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
            
            element.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
}

/**
 * Initialize tabs functionality
 */
function initTabs() {
    const tabGroups = document.querySelectorAll('.md-tabs');
    
    tabGroups.forEach(tabGroup => {
        const tabs = tabGroup.querySelectorAll('.md-tab');
        const tabContents = document.querySelectorAll('.md-tab-content[data-tab-group="' + tabGroup.dataset.tabGroup + '"]');
        const indicator = tabGroup.querySelector('.md-tab-indicator');
        
        tabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                const tabId = tab.dataset.tabId;
                const content = document.querySelector('.md-tab-content[data-tab-id="' + tabId + '"]');
                if (content) {
                    content.classList.add('active');
                }
                
                // Move indicator
                if (indicator) {
                    indicator.style.left = tab.offsetLeft + 'px';
                    indicator.style.width = tab.offsetWidth + 'px';
                }
            });
            
            // Set initial active tab
            if (index === 0 && indicator) {
                tab.classList.add('active');
                const tabId = tab.dataset.tabId;
                const content = document.querySelector('.md-tab-content[data-tab-id="' + tabId + '"]');
                if (content) {
                    content.classList.add('active');
                }
                
                // Position indicator
                indicator.style.left = tab.offsetLeft + 'px';
                indicator.style.width = tab.offsetWidth + 'px';
            }
        });
    });
}

/**
 * Initialize theme toggle functionality
 */
function initThemeToggle() {
    const themeToggle = document.getElementById('theme-toggle');
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-theme');
            
            // Save theme preference to localStorage
            const isDarkTheme = document.body.classList.contains('dark-theme');
            localStorage.setItem('darkTheme', isDarkTheme);
            
            // Update toggle icon
            updateThemeToggleIcon(isDarkTheme);
        });
        
        // Check for saved theme preference
        const savedTheme = localStorage.getItem('darkTheme');
        
        if (savedTheme === 'true') {
            document.body.classList.add('dark-theme');
            updateThemeToggleIcon(true);
        } else {
            updateThemeToggleIcon(false);
        }
    }
}

/**
 * Update theme toggle icon based on current theme
 * @param {boolean} isDarkTheme - Whether dark theme is active
 */
function updateThemeToggleIcon(isDarkTheme) {
    const themeToggle = document.getElementById('theme-toggle');
    
    if (themeToggle) {
        if (isDarkTheme) {
            themeToggle.innerHTML = '<i class="material-icons">light_mode</i>';
            themeToggle.setAttribute('title', 'Switch to Light Theme');
        } else {
            themeToggle.innerHTML = '<i class="material-icons">dark_mode</i>';
            themeToggle.setAttribute('title', 'Switch to Dark Theme');
        }
    }
}

/**
 * Initialize drawer functionality
 */
function initDrawer() {
    const drawerToggle = document.getElementById('drawer-toggle');
    const drawer = document.querySelector('.md-drawer');
    const overlay = document.querySelector('.md-drawer-overlay');
    
    if (drawerToggle && drawer && overlay) {
        drawerToggle.addEventListener('click', function() {
            drawer.classList.toggle('open');
            overlay.classList.toggle('active');
        });
        
        overlay.addEventListener('click', function() {
            drawer.classList.remove('open');
            overlay.classList.remove('active');
        });
    }
}

/**
 * Show a snackbar message
 * @param {string} message - Message to display
 * @param {string} type - Type of message (success, error, info, warning)
 * @param {number} duration - Duration in milliseconds
 */
function showSnackbar(message, type = 'info', duration = 3000) {
    // Remove any existing snackbars
    const existingSnackbars = document.querySelectorAll('.md-snackbar');
    existingSnackbars.forEach(snackbar => {
        snackbar.remove();
    });
    
    // Create new snackbar
    const snackbar = document.createElement('div');
    snackbar.classList.add('md-snackbar');
    snackbar.classList.add(`md-snackbar-${type}`);
    
    snackbar.innerHTML = `
        <div class="md-snackbar-content">
            <span>${message}</span>
            <button class="md-snackbar-close">
                <i class="material-icons">close</i>
            </button>
        </div>
    `;
    
    document.body.appendChild(snackbar);
    
    // Show snackbar
    setTimeout(() => {
        snackbar.classList.add('active');
    }, 10);
    
    // Add close button functionality
    const closeButton = snackbar.querySelector('.md-snackbar-close');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            snackbar.classList.remove('active');
            setTimeout(() => {
                snackbar.remove();
            }, 300);
        });
    }
    
    // Auto-hide after duration
    setTimeout(() => {
        snackbar.classList.remove('active');
        setTimeout(() => {
            snackbar.remove();
        }, 300);
    }, duration);
}

/**
 * Initialize form validation
 * @param {string} formId - ID of the form to validate
 * @param {Object} rules - Validation rules
 * @param {function} onSuccess - Callback on successful validation
 */
function initFormValidation(formId, rules, onSuccess) {
    const form = document.getElementById(formId);
    
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;
        const errors = {};
        
        // Clear previous errors
        form.querySelectorAll('.md-input-helper-text.error').forEach(el => {
            el.remove();
        });
        
        form.querySelectorAll('.md-input.md-input-error').forEach(el => {
            el.classList.remove('md-input-error');
        });
        
        // Validate each field
        Object.keys(rules).forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            
            if (field) {
                const fieldRules = rules[fieldName];
                const fieldValue = field.value.trim();
                
                // Check required
                if (fieldRules.required && !fieldValue) {
                    isValid = false;
                    errors[fieldName] = fieldRules.required;
                }
                // Check email format
                else if (fieldRules.email && fieldValue && !validateEmail(fieldValue)) {
                    isValid = false;
                    errors[fieldName] = fieldRules.email;
                }
                // Check min length
                else if (fieldRules.minLength && fieldValue.length < fieldRules.minLength.value) {
                    isValid = false;
                    errors[fieldName] = fieldRules.minLength.message;
                }
                // Check custom validation
                else if (fieldRules.custom && !fieldRules.custom.validate(fieldValue)) {
                    isValid = false;
                    errors[fieldName] = fieldRules.custom.message;
                }
            }
        });
        
        // Display errors
        if (!isValid) {
            Object.keys(errors).forEach(fieldName => {
                const field = form.querySelector(`[name="${fieldName}"]`);
                const errorMessage = errors[fieldName];
                
                if (field) {
                    field.classList.add('md-input-error');
                    
                    const helperText = document.createElement('div');
                    helperText.classList.add('md-input-helper-text', 'error');
                    helperText.textContent = errorMessage;
                    
                    field.parentNode.appendChild(helperText);
                }
            });
        } else {
            // Call success callback
            if (typeof onSuccess === 'function') {
                onSuccess(form);
            }
        }
    });
}

/**
 * Validate email format
 * @param {string} email - Email to validate
 * @returns {boolean} - Whether email is valid
 */
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

/**
 * Initialize dropdown menu
 * @param {string} triggerId - ID of the dropdown trigger element
 * @param {string} menuId - ID of the dropdown menu element
 */
function initDropdown(triggerId, menuId) {
    const trigger = document.getElementById(triggerId);
    const menu = document.getElementById(menuId);
    
    if (!trigger || !menu) return;
    
    trigger.addEventListener('click', function(e) {
        e.stopPropagation();
        menu.classList.toggle('active');
        
        // Position the menu
        const triggerRect = trigger.getBoundingClientRect();
        menu.style.top = (triggerRect.bottom + window.scrollY) + 'px';
        menu.style.left = (triggerRect.left + window.scrollX) + 'px';
    });
    
    // Close when clicking outside
    document.addEventListener('click', function() {
        menu.classList.remove('active');
    });
    
    // Prevent menu click from closing
    menu.addEventListener('click', function(e) {
        e.stopPropagation();
    });
}

/**
 * Format a date using specified format
 * @param {Date|string} date - Date to format
 * @param {string} format - Format string
 * @returns {string} - Formatted date
 */
function formatDate(date, format = 'YYYY-MM-DD') {
    const d = new Date(date);
    
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');
    const seconds = String(d.getSeconds()).padStart(2, '0');
    
    return format
        .replace('YYYY', year)
        .replace('MM', month)
        .replace('DD', day)
        .replace('HH', hours)
        .replace('mm', minutes)
        .replace('ss', seconds);
}

/**
 * Format currency
 * @param {number} amount - Amount to format
 * @param {string} currency - Currency code
 * @returns {string} - Formatted currency
 */
function formatCurrency(amount, currency = 'USD') {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency
    }).format(amount);
}
