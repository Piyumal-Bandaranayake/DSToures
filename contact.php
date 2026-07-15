<?php
$page_title = "Contact Us | Book Your Custom Sri Lanka Tour | Dileep Sanjaya Tours";
$meta_description = "Get in touch with Dileep Sanjaya Tours to plan your custom Sri Lanka tour itinerary. Direct phone, email, and WhatsApp booking support available.";
$meta_keywords = "book Sri Lanka tour, contact Dileep Sanjaya, Sri Lanka private driver booking, customized tour planner Sri Lanka";
$canonical_url = "https://dileepsanjayatours.com/contact";

include 'includes/header.php';

// Form processing logic
$status = '';
$message_text = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $message = strip_tags(trim($_POST["message"]));

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($phone)) {
        $status = 'error';
        $message_text = 'Please complete all form fields and enter a valid email address.';
    } else {
        $recipient = "dileepsanjaya3@gmail.com";
        $subject = "New Inquiry from Dileep Sanjaya Tours Website";
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Phone: $phone\n\n";
        $email_content .= "Message:\n$message\n";
        
        $email_headers = "From: $name <$email>";

        // Using @mail to suppress server warnings if sendmail is not configured on local environment
        if (@mail($recipient, $subject, $email_content, $email_headers)) {
            $status = 'success';
            $message_text = 'Thank you! Your inquiry has been sent successfully. Dileep will contact you shortly.';
        } else {
            // Provide a friendly fallback if PHP mail fails (e.g. on local XAMPP without smtp configuration)
            $status = 'fallback';
            $message_text = 'Thank you for your message! Since you are on a local environment or mail server is disabled, please click the WhatsApp button to chat with Dileep directly or email him at dileepsanjaya3@gmail.com';
        }
    }
}
?>

<!-- Inner Page Header -->
<section class="inner-header">
    <div class="container">
        <h1 data-aos="fade-up">Contact Us</h1>
        <div class="breadcrumbs" data-aos="fade-up" data-aos-delay="150">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Contact Us</span>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            
            <!-- Contact Form wrapper -->
            <div class="contact-form-wrapper" data-aos="fade-right">
                <h3>Send Us a Message</h3>
                
                <?php if ($status === 'success'): ?>
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i> <?php echo $message_text; ?>
                    </div>
                <?php elseif ($status === 'fallback'): ?>
                    <div class="alert alert-success" style="background-color: #eaf6ff; border-color: #bde0ff; color: #0056b3;">
                        <i class="fa-solid fa-circle-info"></i> <?php echo $message_text; ?>
                    </div>
                <?php elseif ($status === 'error'): ?>
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-circle-xmark"></i> <?php echo $message_text; ?>
                    </div>
                <?php endif; ?>

                <form action="contact.php" method="POST" id="contactForm" novalidate>
                    <div class="form-group">
                        <label for="name">Your Name *</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
                        <span class="form-feedback">Name is required</span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                        <span class="form-feedback">Please enter a valid email address</span>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone / WhatsApp Number *</label>
                        <input type="tel" name="phone" id="phone" class="form-control" placeholder="e.g. +94 75 257 4781" required>
                        <span class="form-feedback">Phone number is required</span>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Inquiry / Message *</label>
                        <textarea name="message" id="message" class="form-control" placeholder="Tell us about your tour plans, preferred dates, and number of guests..." required></textarea>
                        <span class="form-feedback">Message is required</span>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Submit Inquiry</button>
                </form>
            </div>

            <!-- Contact Information Wrapper -->
            <div class="contact-info-wrapper" data-aos="fade-left">
                <div class="info-box">
                    <h4><i class="fa-solid fa-circle-info"></i> Owner & Operator</h4>
                    <p><strong>Dileep Sanjaya</strong></p>
                    <p>Personalized tours, transport logistics, and itinerary curation.</p>
                </div>

                <div class="info-box">
                    <h4><i class="fa-solid fa-phone"></i> Direct Contact Details</h4>
                    <p>Feel free to call, email, or message Dileep directly on WhatsApp.</p>
                    <p style="margin-top: 15px;">
                        <strong>Phone / WhatsApp:</strong><br>
                        <a href="tel:+94752574781"><i class="fa-solid fa-phone" style="color: var(--secondary); font-size:0.9rem;"></i> +94 75 257 4781</a>
                    </p>
                    <p style="margin-top: 10px;">
                        <strong>Email:</strong><br>
                        <a href="mailto:dileepsanjaya3@gmail.com"><i class="fa-solid fa-envelope" style="color: var(--secondary); font-size:0.9rem;"></i> dileepsanjaya3@gmail.com</a>
                    </p>
                </div>

                <div class="info-box">
                    <h4><i class="fa-solid fa-hashtag"></i> Follow Our Journey</h4>
                    <p>Connect with us on social media for travel inspiration, photos, and guest testimonials.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/dileep.sanjaya?mibextid=wwXIfr&mibextid=wwXIfr" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://wa.me/94752574781" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://www.instagram.com/dileepsanjaya?igsh=MXQ5emM0N2M5MW5hNA%3D%3D&utm_source=qr" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-btn" aria-label="TripAdvisor"><i class="fa-brands fa-tripadvisor"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Embedded Google Map -->
        <div class="map-wrapper" data-aos="fade-up">
            <iframe 
                src="https://maps.google.com/maps?q=6.9284222,79.9669390&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

<?php
include 'includes/footer.php';
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('contactForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get fields
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const message = document.getElementById('message').value.trim();
            
            // Validation
            if (!name || !email || !phone || !message) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Formulate WhatsApp message template
            const waMessage = "Hello Dileep Sanjaya Tours,\n\n" + 
                              "I have an inquiry from the website:\n\n" +
                              "✍ *Name:* " + name + "\n" +
                              "✉ *Email:* " + email + "\n" +
                              "📞 *Phone:* " + phone + "\n\n" +
                              "💬 *Message:* " + message;
            
            const encodedMessage = encodeURIComponent(waMessage);
            const waUrl = "https://wa.me/94752574781?text=" + encodedMessage;
            
            // Redirect to WhatsApp
            window.open(waUrl, '_blank');
        });
    }
});
</script>
