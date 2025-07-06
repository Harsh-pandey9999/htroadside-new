/**
 * Material Design JS Components for HT Roadside Assistance
 * Provides interactive functionality for Material Design components
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all Material Design components
    initRippleEffect();
    initDrawer();
    initDropdowns();
    initTabs();
    initDialogs();
    initThemeToggle();
    initTooltips();
    initSnackbars();
    initCharts();
});

/**
 * Ripple effect for buttons and clickable elements
 */
function initRippleEffect() {
    const rippleElements = document.querySelectorAll('.md-btn, .md-drawer-item, .md-tab, .md-fab');
    
    rippleElements.forEach(element => {
        element.addEventListener('click', function(e) {
            const rect = element.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const ripple = document.createElement('span');
            ripple.classList.add('md-ripple');
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            
            element.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
}

/**
 * Navigation drawer functionality
 */
function initDrawer() {
    const drawerToggle = document.querySelector('.md-drawer-toggle');
    const drawer = document.querySelector('.md-drawer');
    const overlay = document.querySelector('.md-drawer-overlay');
    
    if (drawerToggle && drawer) {
        drawerToggle.addEventListener('click', function() {
            drawer.classList.toggle('closed');
            
            if (overlay) {
                if (drawer.classList.contains('closed')) {
                    overlay.style.display = 'none';
                } else {
                    overlay.style.display = 'block';
                }
            }
        });
        
        // Close drawer when clicking outside on mobile
        if (overlay) {
            overlay.addEventListener('click', function() {
                drawer.classList.add('closed');
                overlay.style.display = 'none';
            });
        }
        
        // Handle responsive behavior
        const handleResize = () => {
            if (window.innerWidth < 768) {
                drawer.classList.add('closed');
                if (overlay) overlay.style.display = 'none';
            } else {
                drawer.classList.remove('closed');
                if (overlay) overlay.style.display = 'none';
            }
        };
        
        window.addEventListener('resize', handleResize);
        handleResize(); // Initial call
    }
}

/**
 * Dropdown menus
 */
function initDropdowns() {
    const dropdownTriggers = document.querySelectorAll('.md-dropdown-trigger');
    
    dropdownTriggers.forEach(trigger => {
        const dropdown = trigger.nextElementSibling;
        
        if (dropdown && dropdown.classList.contains('md-dropdown-menu')) {
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('open');
                
                // Close other open dropdowns
                document.querySelectorAll('.md-dropdown-menu.open').forEach(menu => {
                    if (menu !== dropdown) {
                        menu.classList.remove('open');
                    }
                });
            });
        }
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.md-dropdown-menu.open').forEach(menu => {
            menu.classList.remove('open');
        });
    });
}

/**
 * Tabs functionality
 */
function initTabs() {
    const tabGroups = document.querySelectorAll('.md-tabs');
    
    tabGroups.forEach(tabGroup => {
        const tabs = tabGroup.querySelectorAll('.md-tab');
        const tabContents = document.querySelectorAll(`[data-tab-content="${tabGroup.dataset.tabs}"] .md-tab-content`);
        
        tabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                tabs.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');
                
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.style.display = 'none';
                });
                
                // Show corresponding tab content
                if (tabContents[index]) {
                    tabContents[index].style.display = 'block';
                }
            });
        });
        
        // Activate first tab by default
        if (tabs.length > 0 && tabContents.length > 0) {
            tabs[0].classList.add('active');
            tabContents[0].style.display = 'block';
        }
    });
}

/**
 * Dialog/Modal functionality
 */
function initDialogs() {
    const dialogTriggers = document.querySelectorAll('[data-dialog]');
    
    dialogTriggers.forEach(trigger => {
        const dialogId = trigger.dataset.dialog;
        const dialog = document.getElementById(dialogId);
        
        if (dialog) {
            const closeButtons = dialog.querySelectorAll('.md-dialog-close');
            
            trigger.addEventListener('click', function() {
                dialog.style.display = 'flex';
                setTimeout(() => {
                    dialog.classList.add('open');
                }, 10);
            });
            
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    dialog.classList.remove('open');
                    setTimeout(() => {
                        dialog.style.display = 'none';
                    }, 300);
                });
            });
            
            // Close when clicking on backdrop
            dialog.addEventListener('click', function(e) {
                if (e.target === dialog) {
                    dialog.classList.remove('open');
                    setTimeout(() => {
                        dialog.style.display = 'none';
                    }, 300);
                }
            });
        }
    });
}

/**
 * Theme toggle (light/dark mode)
 */
function initThemeToggle() {
    const themeToggle = document.querySelector('.md-theme-toggle');
    
    if (themeToggle) {
        // Check for saved theme preference or respect OS preference
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            document.documentElement.classList.add('dark');
            themeToggle.setAttribute('aria-checked', 'true');
        }
        
        themeToggle.addEventListener('click', function() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            themeToggle.setAttribute('aria-checked', isDark ? 'true' : 'false');
        });
    }
}

/**
 * Tooltips
 */
function initTooltips() {
    const tooltipTriggers = document.querySelectorAll('[data-tooltip]');
    
    tooltipTriggers.forEach(trigger => {
        const tooltipText = trigger.dataset.tooltip;
        const tooltip = document.createElement('div');
        tooltip.classList.add('md-tooltip');
        tooltip.textContent = tooltipText;
        
        trigger.addEventListener('mouseenter', function() {
            document.body.appendChild(tooltip);
            
            const triggerRect = trigger.getBoundingClientRect();
            const tooltipRect = tooltip.getBoundingClientRect();
            
            tooltip.style.top = `${triggerRect.top - tooltipRect.height - 8}px`;
            tooltip.style.left = `${triggerRect.left + (triggerRect.width / 2) - (tooltipRect.width / 2)}px`;
            
            setTimeout(() => {
                tooltip.classList.add('visible');
            }, 10);
        });
        
        trigger.addEventListener('mouseleave', function() {
            tooltip.classList.remove('visible');
            
            setTimeout(() => {
                if (tooltip.parentNode) {
                    tooltip.parentNode.removeChild(tooltip);
                }
            }, 200);
        });
    });
}

/**
 * Snackbar notifications
 */
function initSnackbars() {
    // Global function to show snackbars
    window.showSnackbar = function(message, action, duration = 4000) {
        const existingSnackbar = document.querySelector('.md-snackbar');
        if (existingSnackbar) {
            existingSnackbar.remove();
        }
        
        const snackbar = document.createElement('div');
        snackbar.classList.add('md-snackbar');
        
        const messageSpan = document.createElement('span');
        messageSpan.classList.add('md-snackbar-message');
        messageSpan.textContent = message;
        snackbar.appendChild(messageSpan);
        
        if (action) {
            const actionButton = document.createElement('button');
            actionButton.classList.add('md-snackbar-action');
            actionButton.textContent = action.text;
            actionButton.addEventListener('click', function() {
                if (typeof action.callback === 'function') {
                    action.callback();
                }
                snackbar.remove();
            });
            snackbar.appendChild(actionButton);
        }
        
        document.body.appendChild(snackbar);
        
        setTimeout(() => {
            snackbar.classList.add('visible');
        }, 10);
        
        if (duration > 0) {
            setTimeout(() => {
                snackbar.classList.remove('visible');
                setTimeout(() => {
                    snackbar.remove();
                }, 300);
            }, duration);
        }
    };
}

/**
 * Initialize charts using Chart.js
 */
function initCharts() {
    if (typeof Chart === 'undefined') return;
    
    // Set default Chart.js options to match Material Design
    Chart.defaults.font.family = getComputedStyle(document.documentElement).getPropertyValue('--md-font-family').trim();
    Chart.defaults.color = getComputedStyle(document.documentElement).getPropertyValue('--md-on-surface-medium').trim();
    
    // Find and initialize all charts with the .md-chart class
    document.querySelectorAll('.md-chart').forEach(chartElement => {
        const ctx = chartElement.getContext('2d');
        const chartType = chartElement.dataset.chartType || 'line';
        const chartData = JSON.parse(chartElement.dataset.chartData || '{}');
        
        // Apply Material Design colors if not specified
        if (chartData.datasets) {
            chartData.datasets.forEach((dataset, index) => {
                if (!dataset.backgroundColor) {
                    const colors = [
                        getComputedStyle(document.documentElement).getPropertyValue('--md-primary-500').trim(),
                        getComputedStyle(document.documentElement).getPropertyValue('--md-secondary-500').trim(),
                        getComputedStyle(document.documentElement).getPropertyValue('--md-success-500').trim(),
                        getComputedStyle(document.documentElement).getPropertyValue('--md-warning-500').trim(),
                        getComputedStyle(document.documentElement).getPropertyValue('--md-error-500').trim()
                    ];
                    
                    dataset.backgroundColor = colors[index % colors.length];
                }
                
                if (!dataset.borderColor && (chartType === 'line' || chartType === 'radar')) {
                    dataset.borderColor = dataset.backgroundColor;
                }
            });
        }
        
        // Create chart with Material Design styling
        new Chart(ctx, {
            type: chartType,
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            padding: 16,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: getComputedStyle(document.documentElement).getPropertyValue('--md-surface-5').trim(),
                        titleColor: getComputedStyle(document.documentElement).getPropertyValue('--md-on-surface-high').trim(),
                        bodyColor: getComputedStyle(document.documentElement).getPropertyValue('--md-on-surface-medium').trim(),
                        padding: 12,
                        cornerRadius: 8,
                        boxPadding: 6
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: getComputedStyle(document.documentElement).getPropertyValue('--md-neutral-200').trim(),
                            drawBorder: false
                        },
                        ticks: {
                            padding: 8
                        }
                    },
                    y: {
                        grid: {
                            color: getComputedStyle(document.documentElement).getPropertyValue('--md-neutral-200').trim(),
                            drawBorder: false
                        },
                        ticks: {
                            padding: 8
                        }
                    }
                },
                elements: {
                    line: {
                        tension: 0.4
                    },
                    point: {
                        radius: 4,
                        hoverRadius: 6
                    }
                }
            }
        });
    });
}

// Helper functions for common Material Design interactions

/**
 * Create and show a Material Design dialog programmatically
 * @param {Object} options Dialog options
 */
function createDialog(options = {}) {
    const {
        title = '',
        content = '',
        actions = [],
        size = 'medium',
        onClose = null
    } = options;
    
    // Create dialog elements
    const backdrop = document.createElement('div');
    backdrop.classList.add('md-dialog-backdrop');
    backdrop.style.display = 'flex';
    
    const dialog = document.createElement('div');
    dialog.classList.add('md-dialog', `md-dialog-${size}`);
    
    // Dialog header
    const header = document.createElement('div');
    header.classList.add('md-dialog-header');
    
    const titleElement = document.createElement('h2');
    titleElement.classList.add('md-dialog-title');
    titleElement.textContent = title;
    header.appendChild(titleElement);
    
    // Dialog content
    const contentElement = document.createElement('div');
    contentElement.classList.add('md-dialog-content');
    
    if (typeof content === 'string') {
        contentElement.innerHTML = content;
    } else if (content instanceof HTMLElement) {
        contentElement.appendChild(content);
    }
    
    // Dialog actions
    const actionsElement = document.createElement('div');
    actionsElement.classList.add('md-dialog-actions');
    
    actions.forEach(action => {
        const button = document.createElement('button');
        button.classList.add('md-btn', action.primary ? 'md-btn-filled' : 'md-btn-text');
        button.textContent = action.text;
        
        button.addEventListener('click', () => {
            if (typeof action.callback === 'function') {
                action.callback();
            }
            closeDialog();
        });
        
        actionsElement.appendChild(button);
    });
    
    // Assemble dialog
    dialog.appendChild(header);
    dialog.appendChild(contentElement);
    dialog.appendChild(actionsElement);
    backdrop.appendChild(dialog);
    
    // Add to DOM
    document.body.appendChild(backdrop);
    
    // Animation
    setTimeout(() => {
        backdrop.classList.add('open');
    }, 10);
    
    // Close dialog function
    function closeDialog() {
        backdrop.classList.remove('open');
        
        setTimeout(() => {
            document.body.removeChild(backdrop);
            if (typeof onClose === 'function') {
                onClose();
            }
        }, 300);
    }
    
    // Close when clicking on backdrop
    backdrop.addEventListener('click', function(e) {
        if (e.target === backdrop) {
            closeDialog();
        }
    });
    
    // Return dialog control object
    return {
        close: closeDialog,
        element: dialog
    };
}

/**
 * Show a loading indicator
 * @param {string} container Selector for container element
 * @param {string} type Type of loader ('circular' or 'linear')
 * @returns {Object} Control object with methods to update or hide the loader
 */
function showLoader(container = 'body', type = 'circular') {
    const containerElement = container === 'body' ? document.body : document.querySelector(container);
    
    if (!containerElement) return null;
    
    const loader = document.createElement('div');
    
    if (type === 'circular') {
        loader.classList.add('md-progress-circular');
    } else {
        loader.classList.add('md-progress-linear');
        const bar = document.createElement('div');
        bar.classList.add('md-progress-linear-bar');
        loader.appendChild(bar);
    }
    
    if (container === 'body') {
        const backdrop = document.createElement('div');
        backdrop.classList.add('md-loader-backdrop');
        backdrop.appendChild(loader);
        containerElement.appendChild(backdrop);
    } else {
        containerElement.appendChild(loader);
    }
    
    return {
        update: (progress) => {
            // For determinate progress indicators
            if (typeof progress === 'number' && progress >= 0 && progress <= 100) {
                loader.dataset.progress = progress;
                // Update visual if needed
            }
        },
        hide: () => {
            if (container === 'body') {
                const backdrop = loader.parentNode;
                backdrop.classList.add('fade-out');
                setTimeout(() => {
                    if (backdrop.parentNode) {
                        backdrop.parentNode.removeChild(backdrop);
                    }
                }, 300);
            } else {
                loader.classList.add('fade-out');
                setTimeout(() => {
                    if (loader.parentNode) {
                        loader.parentNode.removeChild(loader);
                    }
                }, 300);
            }
        }
    };
}

// Export functions for global use
window.MaterialDesign = {
    createDialog,
    showLoader,
    showSnackbar: window.showSnackbar
};
