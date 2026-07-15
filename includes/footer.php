    <!-- Floating Review Widget -->
    <a href="submit-review.php" class="review-float" title="Write a Review">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>

    <!-- Floating WhatsApp Widget -->
    <a href="https://wa.me/94752574781" class="whatsapp-float" target="_blank" rel="noopener noreferrer" title="Chat with Dileep Sanjaya Tours on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <!-- About Column -->
                <div class="footer-col">
                    <img src="images/logo.png" alt="Dileep Sanjaya Tours Logo" style="height: 50px; width: auto; margin-bottom: 15px;" onerror="this.style.display='none';">
                    <h3>Dileep Sanjaya Tours</h3>
                    <p>Offering personalized tour services across Sri Lanka. Experience local experts, beautiful beaches, breathtaking hill country views, rich historical sites, and exciting wildlife safaris customized just for you.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/dileep.sanjaya?mibextid=wwXIfr&mibextid=wwXIfr" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://wa.me/94752574781" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://www.instagram.com/dileepsanjaya?igsh=MXQ5emM0N2M5MW5hNA%3D%3D&utm_source=qr" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-btn" aria-label="TripAdvisor"><i class="fa-brands fa-tripadvisor"></i></a>
                    </div>
                </div>

                <!-- Quick Links Column -->
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="index.php"><i class="fa-solid fa-chevron-right"></i> Home</a></li>
                        <li><a href="packages.php"><i class="fa-solid fa-chevron-right"></i> Tour Packages</a></li>
                        <li><a href="about.php"><i class="fa-solid fa-chevron-right"></i> About Dileep</a></li>
                        <li><a href="gallery.php"><i class="fa-solid fa-chevron-right"></i> Gallery</a></li>
                        <li><a href="contact.php"><i class="fa-solid fa-chevron-right"></i> Contact Us</a></li>
                    </ul>
                </div>

                <!-- Contact Details Column -->
                <div class="footer-col">
                    <h3>Contact Info</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <div>
                                <strong>Phone / WhatsApp:</strong><br>
                                <a href="tel:+94752574781">+94 75 257 4781</a>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-envelope"></i>
                            <div>
                                <strong>Email:</strong><br>
                                <a href="mailto:dileepsanjaya3@gmail.com">dileepsanjaya3@gmail.com</a>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-location-dot"></i>
                            <div>
                                <strong>Location:</strong><br>
                                Sri Lanka
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; <?php echo date("Y"); ?> Dileep Sanjaya Tours. All Rights Reserved. Built for beautiful Ceylon travels. <a href="admin/login.php" style="margin-left: 10px; color: inherit; opacity: 0.5;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'" title="Admin Portal"><i class="fa-solid fa-lock"></i></a></p>
                <p>Designed with <i class="fa-solid fa-heart" style="color: var(--accent);"></i> by Local Experts</p>
            </div>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({ duration: 800, once: true, offset: 100 });

        // Preloader fade out (Home page only)
        <?php if ($current_page == 'index.php' || $current_page == ''): ?>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            const body = document.body;
            
            // Minimum show duration of 1.2s
            setTimeout(function() {
                if (preloader) {
                    preloader.classList.add('fade-out');
                    body.classList.remove('preloader-active');
                    
                    setTimeout(function() {
                        preloader.style.display = 'none';
                    }, 500);
                }
            }, 1200);
        });
        <?php endif; ?>

        // Sticky header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header.site-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>

    <!-- Main JavaScript File -->
    <script src="js/main.js"></script>
</body>
</html>
