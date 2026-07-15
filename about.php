<?php
$page_title = "About Us | Dileep Sanjaya Tours - Expert Sri Lanka Tour Guide";
$meta_description = "Learn more about Dileep Sanjaya, your local tour guide and operator in Sri Lanka. Providing highly personalized, safe, and custom itineraries for travelers.";
$meta_keywords = "Dileep Sanjaya, local tour guide Sri Lanka, private driver Sri Lanka, custom travel agent Sri Lanka, tour operator Sigiriya";
$canonical_url = "https://dileepsanjayatours.com/about";

// Organization Schema JSON-LD
$schema_json_ld = '{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Dileep Sanjaya Tours",
  "url": "https://dileepsanjayatours.com/",
  "logo": "https://dileepsanjayatours.com/images/logo.png",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+94752574781",
    "contactType": "customer service",
    "email": "dileepsanjaya3@gmail.com",
    "areaServed": "Worldwide",
    "availableLanguage": ["English", "Sinhala"]
  },
  "sameAs": [
    "https://www.facebook.com/dileep.sanjaya?mibextid=wwXIfr&mibextid=wwXIfr",
    "https://www.instagram.com/dileepsanjaya?igsh=MXQ5emM0N2M5MW5hNA%3D%3D&utm_source=qr"
  ]
}';

include 'includes/header.php';
?>

<!-- Inner Page Header -->
<section class="inner-header">
    <div class="container">
        <h1 data-aos="fade-up">About Us</h1>
        <div class="breadcrumbs" data-aos="fade-up" data-aos-delay="150">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>About Us</span>
        </div>
    </div>
</section>

<!-- Owner's Story -->
<section class="about-story">
    <div class="container about-grid">
        <div class="story-text" data-aos="fade-right">
            <h3>Meet Dileep Sanjaya</h3>
            <p>Welcome to Sri Lanka! I am Dileep Sanjaya, the founder, owner, and primary tour coordinator of Dileep Sanjaya Tours. Tourism is not just a business for me; it is a lifetime passion. Born and raised in Sri Lanka, I have spent years exploring every highway, village pathway, waterfall trail, and historical site of this wonderful tropical nation.</p>
            <p>My goal is to show you the real Sri Lanka—beyond the typical crowded tourist paths. I want to introduce you to our delicious home-cooked rice and curries, explain the intricate history of ancient Buddhist shrines, and help you experience the beautiful local hospitality. When you travel with us, you are treated like family.</p>
            <p>We work with an experienced team of certified local drivers and expert naturalists to ensure that your safety, comfort, and happiness are guaranteed throughout the tour.</p>
            <a href="contact.php" class="btn btn-primary" data-aos="fade-up" data-aos-delay="100"><i class="fa-solid fa-paper-plane"></i> Plan With Dileep</a>
        </div>
        <div class="intro-img-wrapper" data-aos="fade-left">
            <img src="images/logo.png" alt="Dileep Sanjaya - Owner and Guide" class="intro-img" style="object-fit: contain; background-color: #ffffff; padding: 30px; box-sizing: border-box;" loading="lazy">
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="features-section">
    <div class="container">
        <div class="intro-grid">
            <div class="intro-text" data-aos="fade-up">
                <h3>Our Vision</h3>
                <p>To be the most reliable, client-oriented, and sustainable tour operator in Sri Lanka, showcasing the island's natural splendor and deep cultural roots while providing unmatched warmth and service quality.</p>
            </div>
            <div class="intro-text" data-aos="fade-up" data-aos-delay="150">
                <h3>Our Mission</h3>
                <p>To deliver exceptional, tailor-made travel itineraries designed around individual wishes, supporting local communities through eco-friendly tourism practices, and creating experiences that guests will cherish forever.</p>
            </div>
        </div>
    </div>
</section>

<!-- Why Travel With Us Section -->
<section class="about-features">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Why Travel With Us?</h2>
            <p>A few features that set Dileep Sanjaya Tours apart from others</p>
        </div>
        <div class="about-features-grid">
            <!-- Point 1 -->
            <div class="about-feat-card" data-aos="fade-up" data-aos-delay="0">
                <i class="fa-solid fa-user-tie"></i>
                <h4>Fully Dedicated Service</h4>
                <p>From the moment you arrive at the Colombo International Airport until you board your flight home, we take care of all details.</p>
            </div>

            <!-- Point 2 -->
            <div class="about-feat-card" data-aos="fade-up" data-aos-delay="100">
                <i class="fa-solid fa-car"></i>
                <h4>Premium Fleet of Vehicles</h4>
                <p>Travel in style and comfort with fully air-conditioned, modern luxury cars, vans, or mini-buses, driven by safe drivers.</p>
            </div>

            <!-- Point 3 -->
            <div class="about-feat-card" data-aos="fade-up" data-aos-delay="200">
                <i class="fa-solid fa-shield-halved"></i>
                <h4>Safety First Focus</h4>
                <p>We plan secure routes, partner with registered hotels, and provide emergency assistance for complete peace of mind.</p>
            </div>

            <!-- Point 4 -->
            <div class="about-feat-card" data-aos="fade-up" data-aos-delay="300">
                <i class="fa-solid fa-seedling"></i>
                <h4>Eco-Tourism & Local Support</h4>
                <p>We coordinate with local home-stay hosts, rural guides, and eco-parks to directly support Sri Lankan communities.</p>
            </div>
        </div>
    </div>
</section>

<?php
include 'includes/footer.php';
?>
