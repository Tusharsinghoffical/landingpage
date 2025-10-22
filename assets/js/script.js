// Custom JavaScript for Reliable Packers & Movers

document.addEventListener('DOMContentLoaded', function() {
    // Form validation enhancements
    const inquiryForm = document.querySelector('form');
    if (inquiryForm) {
        inquiryForm.addEventListener('submit', function(e) {
            // Check if terms checkbox is checked
            const termsCheckbox = document.getElementById('terms');
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Please agree to our Terms & Conditions and Privacy Policy to proceed.');
                termsCheckbox.focus();
                return false;
            }
        });
    }
    
    // Add animation to elements when they come into view
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.card, .service-card, .stat-number, h1, h2, h3, h4, h5, h6');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.3;
            
            if (elementPosition < screenPosition) {
                element.style.opacity = 1;
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Set initial styles for animation
    const animatedElements = document.querySelectorAll('.card, .service-card, .stat-number, h1, h2, h3, h4, h5, h6');
    animatedElements.forEach(element => {
        element.style.opacity = 0;
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    });
    
    // Trigger animation on scroll
    window.addEventListener('scroll', animateOnScroll);
    
    // Trigger once on load
    animateOnScroll();
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Mobile menu enhancement
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener('click', function() {
            navbarCollapse.classList.toggle('show');
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideNavbar = navbarCollapse && navbarCollapse.contains(event.target);
        const isClickOnToggler = navbarToggler && navbarToggler.contains(event.target);
        
        if (navbarCollapse && navbarCollapse.classList.contains('show') && 
            !isClickInsideNavbar && !isClickOnToggler) {
            navbarCollapse.classList.remove('show');
        }
    });
});

// Function to validate mobile number input in real-time
function validateMobileInput(input) {
    // Remove any non-digit characters
    input.value = input.value.replace(/\D/g, '');
    
    // Limit to 10 digits
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
}

// Add event listener to mobile input field
document.addEventListener('DOMContentLoaded', function() {
    const mobileInput = document.getElementById('mobile');
    if (mobileInput) {
        mobileInput.addEventListener('input', function() {
            validateMobileInput(this);
        });
    }
});

// Responsive adjustments
function adjustForMobile() {
    const whatsappBtn = document.querySelector('.whatsapp-chat-btn');
    if (window.innerWidth <= 768 && whatsappBtn) {
        whatsappBtn.style.bottom = '80px'; // Move above mobile nav
    } else if (whatsappBtn) {
        whatsappBtn.style.bottom = '20px'; // Default position
    }
}

// Run on load and resize
window.addEventListener('load', adjustForMobile);
window.addEventListener('resize', adjustForMobile);