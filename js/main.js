/**
 * Dileep Sanjaya Tours - Custom JavaScript
 * Handles: Mobile Menu, Package Filter, Lightbox, Form Validation
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // --- Mobile Menu Toggle ---
    const navToggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
            
            // Accessible attributes
            const expanded = navToggle.getAttribute('aria-expanded') === 'true' || false;
            navToggle.setAttribute('aria-expanded', !expanded);
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('active');
                navToggle.classList.remove('active');
                navToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // --- Package & Gallery Category Filter ---
    const filterButtons = document.querySelectorAll('.filter-btn');
    const filterItems = document.querySelectorAll('.package-card, .gallery-item');

    if (filterButtons.length > 0 && filterItems.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                button.classList.add('active');

                const filterValue = button.getAttribute('data-filter');

                filterItems.forEach(item => {
                    if (filterValue === 'all') {
                        // Check original display type
                        if (item.classList.contains('gallery-item')) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'flex';
                        }
                    } else {
                        const category = item.getAttribute('data-category');
                        if (category === filterValue) {
                            if (item.classList.contains('gallery-item')) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'flex';
                            }
                        } else {
                            item.style.display = 'none';
                        }
                    }
                });
            });
        });
    }

    // --- Custom Lightbox for Gallery ---
    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCaption = document.getElementById('lightbox-caption');
    const lightboxClose = document.getElementById('lightbox-close');

    if (galleryItems.length > 0 && lightbox && lightboxImg) {
        galleryItems.forEach(item => {
            item.addEventListener('click', () => {
                const img = item.querySelector('img');
                const title = item.querySelector('h4') ? item.querySelector('h4').textContent : '';
                
                if (img) {
                    lightboxImg.src = img.src;
                    lightboxImg.alt = img.alt || 'Gallery Image';
                    if (lightboxCaption) {
                        lightboxCaption.textContent = title;
                    }
                    lightbox.classList.add('active');
                    document.body.style.overflow = 'hidden'; // Disable page scrolling
                }
            });
        });

        const closeLightbox = () => {
            lightbox.classList.remove('active');
            document.body.style.overflow = ''; // Enable page scrolling
            lightboxImg.src = '';
        };

        if (lightboxClose) {
            lightboxClose.addEventListener('click', closeLightbox);
        }

        // Close lightbox clicking on overlay
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox || e.target.classList.contains('lightbox-content')) {
                closeLightbox();
            }
        });

        // Close with escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                closeLightbox();
            }
        });
    }

    // --- Contact Form JavaScript Validation ---
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            let isValid = true;

            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');
            const messageInput = document.getElementById('message');

            // Reset validation states
            const formGroups = contactForm.querySelectorAll('.form-group');
            formGroups.forEach(group => group.classList.remove('invalid'));

            // Name validation
            if (!nameInput.value.trim()) {
                setError(nameInput, 'Name is required');
                isValid = false;
            }

            // Email validation
            if (!emailInput.value.trim()) {
                setError(emailInput, 'Email is required');
                isValid = false;
            } else if (!isValidEmail(emailInput.value.trim())) {
                setError(emailInput, 'Please enter a valid email address');
                isValid = false;
            }

            // Phone validation
            if (!phoneInput.value.trim()) {
                setError(phoneInput, 'Phone number is required');
                isValid = false;
            }

            // Message validation
            if (!messageInput.value.trim()) {
                setError(messageInput, 'Message is required');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault(); // Stop form submission if invalid
            }
        });

        function setError(input, message) {
            const formGroup = input.closest('.form-group');
            if (formGroup) {
                formGroup.classList.add('invalid');
                const feedback = formGroup.querySelector('.form-feedback');
                if (feedback) {
                    feedback.textContent = message;
                }
            }
        }

        function isValidEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
    }

    // --- Animated Number Counters ---
    const counters = document.querySelectorAll('.counter');

    if (counters.length > 0) {
        const countUp = (counter) => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            
            // Adjust step to reach target over ~2 seconds (2000ms / 20ms = 100 steps)
            const increment = Math.max(1, target / 100); 

            if (count < target) {
                counter.innerText = Math.min(target, Math.ceil(count + increment));
                setTimeout(() => countUp(counter), 20);
            } else {
                counter.innerText = target;
            }
        };

        const observerOptions = {
            threshold: 0.1
        };

        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    countUp(counter);
                    observer.unobserve(counter); // Trigger once
                }
            });
        }, observerOptions);

        counters.forEach(counter => {
            counterObserver.observe(counter);
        });
    }

    // --- Hero Slideshow ---
    const slides = document.querySelectorAll('.hero-slideshow .slide');
    if (slides.length > 0) {
        let currentSlide = 0;
        const intervalTime = window.innerWidth <= 768 ? 2500 : 5000;
        setInterval(() => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }, intervalTime);
    }
});
