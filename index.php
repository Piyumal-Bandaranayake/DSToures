<?php
require_once 'db.php';
require_once 'data/packages_data.php';

$page_title = "Sri Lanka Customized Tour Packages & Safaris | Dileep Sanjaya Tours";
$meta_description = "Embark on an unforgettable Sri Lankan holiday with Dileep Sanjaya Tours. We offer customized travel packages, wildlife safaris, beach tours, and expert local guides.";
$meta_keywords = "Sri Lanka tours, Sri Lanka travel agency, customized travel packages, wildlife safari, beach holidays, Ella train ride, Sigiriya climb, Yala safari, Mirissa whale watching";
$canonical_url = "https://dileepsanjayatours.com";

// TravelAgency Schema JSON-LD
$schema_json_ld = '{
  "@context": "https://schema.org",
  "@type": "TravelAgency",
  "name": "Dileep Sanjaya Tours",
  "image": "https://dileepsanjayatours.com/images/logo.png",
  "@id": "https://dileepsanjayatours.com/#travelagency",
  "url": "https://dileepsanjayatours.com/",
  "telephone": "+94752574781",
  "email": "dileepsanjaya3@gmail.com",
  "priceRange": "$$",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "No. 320/2, Colombo Road",
    "addressLocality": "Kaduwela",
    "addressRegion": "Western Province",
    "postalCode": "10150",
    "addressCountry": "LK"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 6.9284222,
    "longitude": 79.9669390
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
      "Sunday"
    ],
    "opens": "00:00",
    "closes": "23:59"
  },
  "sameAs": [
    "https://www.facebook.com/dileep.sanjaya?mibextid=wwXIfr&mibextid=wwXIfr",
    "https://www.instagram.com/dileepsanjaya?igsh=MXQ5emM0N2M5MW5hNA%3D%3D&utm_source=qr"
  ]
}';

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <!-- Background Slideshow -->
    <div class="hero-slideshow">
        <div class="slide active" style="background-image: linear-gradient(90deg, rgba(7, 47, 55, 0.85) 0%, rgba(13, 79, 92, 0.45) 50%, rgba(13, 79, 92, 0.1) 100%), url('images/1.jpg');"></div>
        <div class="slide" style="background-image: linear-gradient(90deg, rgba(7, 47, 55, 0.85) 0%, rgba(13, 79, 92, 0.45) 50%, rgba(13, 79, 92, 0.1) 100%), url('images/2.jpg');"></div>
        <div class="slide" style="background-image: linear-gradient(90deg, rgba(7, 47, 55, 0.85) 0%, rgba(13, 79, 92, 0.45) 50%, rgba(13, 79, 92, 0.1) 100%), url('images/3.jpg');"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title" data-aos="fade-up" data-aos-delay="200">Discover the Heart of Sri Lanka</h1>
            <p class="hero-tagline" data-aos="fade-up" data-aos-delay="350">Embark on a journey of a lifetime with personalized local itineraries, pristine beaches, scenic hill country, and rich cultural heritage.</p>
            <a href="packages.php" class="btn btn-accent" data-aos="fade-up" data-aos-delay="500"><i class="fa-solid fa-compass"></i> Explore Packages</a>
        </div>
    </div>
</section>

<!-- Short Intro Section -->
<section class="intro-section">
    <div class="container intro-grid">
        <div class="intro-text" data-aos="fade-up">
            <h3 data-aos="fade-up">Welcome to Dileep Sanjaya Tours</h3>
            <p data-aos="fade-up" data-aos-delay="100">At Dileep Sanjaya Tours, we pride ourselves on creating unforgettable travel experiences in the beautiful island of Sri Lanka. Owned and managed by Dileep Sanjaya, a passionate tourism expert, we offer you more than just a tour—we provide a gateway to understanding Sri Lankan history, nature, wildlife, and warmth.</p>
            <p data-aos="fade-up" data-aos-delay="200">Whether you want to explore the ancient ruins of Sigiriya, relax on the golden shores of Mirissa, catch a glimpse of wild leopards in Yala, or hike the lush tea plantations of Nuwara Eliya, we design tailor-made packages customized to fit your unique style and budget.</p>
            <a href="about.php" class="btn btn-outline" data-aos="fade-up" data-aos-delay="300">Read Our Story</a>
        </div>
        <div class="intro-img-wrapper" data-aos="fade-left">
            <img src="images/10.jpg" alt="Beautiful Sri Lanka Landscape" class="intro-img" loading="lazy">
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Why Choose Us?</h2>
            <p>We ensure every single trip is perfectly curated to deliver the ultimate comfort and adventure.</p>
        </div>
        <div class="features-grid">
            <!-- Feature 1 -->
            <div class="feature-card" data-aos="fade-up" data-aos-delay="0">
                <i class="fa-solid fa-map-location-dot feature-icon"></i>
                <h3>Local Expert Guide</h3>
                <p>Learn the deep secrets, cultural values, and fascinating history of Sri Lanka from native experts who know every corner.</p>
            </div>
            <!-- Feature 2 -->
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <i class="fa-solid fa-sliders feature-icon"></i>
                <h3>Custom Tours</h3>
                <p>Completely customize your itineraries, transportation choices, activities, and duration to match your ultimate dream vacation.</p>
            </div>
            <!-- Feature 3 -->
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <i class="fa-solid fa-headset feature-icon"></i>
                <h3>24/7 Support</h3>
                <p>Travel with confidence knowing that our dedicated support team is available round-the-clock for any query or assistance.</p>
            </div>
            <!-- Feature 4 -->
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <i class="fa-solid fa-tags feature-icon"></i>
                <h3>Best Price Guarantee</h3>
                <p>We provide exceptional premium tourism services at competitive rates with transparent pricing and no hidden costs.</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section" style="background-color: var(--primary); color: var(--bg-white); padding: 60px 0; text-align: center;">
    <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px;">
        <div class="stat-item" data-aos="fade-up">
            <i class="fa-solid fa-users" style="font-size: 2.5rem; color: var(--accent); margin-bottom: 15px;"></i>
            <h3 style="font-size: 2.5rem; color: var(--bg-white); margin-bottom: 5px; font-family: var(--font-body); font-weight: 700;"><span class="counter" data-target="500">0</span>+</h3>
            <p style="font-size: 1rem; color: #c4d7da; font-family: var(--font-body); font-weight: 500;">Happy Travelers</p>
        </div>
        <div class="stat-item" data-aos="fade-up" data-aos-delay="150">
            <i class="fa-solid fa-compass" style="font-size: 2.5rem; color: var(--accent); margin-bottom: 15px;"></i>
            <h3 style="font-size: 2.5rem; color: var(--bg-white); margin-bottom: 5px; font-family: var(--font-body); font-weight: 700;"><span class="counter" data-target="50">0</span>+</h3>
            <p style="font-size: 1rem; color: #c4d7da; font-family: var(--font-body); font-weight: 500;">Tours Completed</p>
        </div>
        <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
            <i class="fa-solid fa-award" style="font-size: 2.5rem; color: var(--accent); margin-bottom: 15px;"></i>
            <h3 style="font-size: 2.5rem; color: var(--bg-white); margin-bottom: 5px; font-family: var(--font-body); font-weight: 700;"><span class="counter" data-target="10">0</span>+</h3>
            <p style="font-size: 1rem; color: #c4d7da; font-family: var(--font-body); font-weight: 500;">Years Experience</p>
        </div>
    </div>
</section>

<!-- Featured Packages -->
<section class="packages-section" style="background-color: var(--bg-white);">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Featured Tour Packages</h2>
            <p>Check out our most requested travel programs in Sri Lanka</p>
        </div>
        <div class="packages-grid">
            <?php 
            // Display first 3 packages as featured
            $featured = array_slice($packages, 0, 3, true);
            $delay = 0;
            foreach ($featured as $pkg): 
            ?>
            <div class="package-card" data-category="<?php echo htmlspecialchars($pkg['category']); ?>" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="package-img-wrapper">
                    <img src="<?php echo $pkg['image']; ?>" alt="<?php echo htmlspecialchars($pkg['title']); ?>" class="package-img" loading="lazy">
                    <span class="package-tag"><?php echo htmlspecialchars($pkg['tag']); ?></span>
                    <span class="package-meta"><i class="fa-solid fa-clock"></i> <?php echo htmlspecialchars($pkg['duration']); ?></span>
                </div>
                <div class="package-content">
                    <h3><?php echo htmlspecialchars($pkg['title']); ?></h3>
                    <?php if (isset($pkg['rating']) && isset($pkg['reviews'])): ?>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; font-size: 0.85rem; color: var(--text-muted);">
                        <span class="stars" style="margin-bottom: 0; font-size: 0.9rem;">
                            <i class="fa-solid fa-star"></i>
                        </span>
                        <strong><?php echo $pkg['rating']; ?></strong> (<?php echo $pkg['reviews']; ?> reviews)
                    </div>
                    <?php endif; ?>
                    <p><?php echo htmlspecialchars(substr($pkg['description'], 0, 110)) . '...'; ?></p>
                    <div class="package-footer">
                        <div class="package-price">
                            Starting from
                            <span>$<?php echo $pkg['price']; ?></span>
                            <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 2px;">(Min 3 Persons)</span>
                        </div>
                        <a href="package-details.php?id=<?php echo $pkg['id']; ?>" class="btn btn-primary btn-sm">View Details</a>
                    </div>
                </div>
            </div>
            <?php 
            $delay += 150;
            endforeach; 
            ?>
        </div>
        <div style="text-align: center; margin-top: 50px;" data-aos="fade-up" data-aos-delay="300">
            <a href="packages.php" class="btn btn-accent"><i class="fa-solid fa-compass"></i> Explore More Packages</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>What Our Clients Say</h2>
            <p>Real reviews from travelers who experienced Sri Lanka with Dileep</p>
        </div>
        
        <?php
        $home_reviews = [];
        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT * FROM reviews WHERE status = 'approved' ORDER BY created_at DESC LIMIT 3");
                $home_reviews = $stmt->fetchAll();
            } catch (PDOException $e) {
                error_log("Failed to load reviews for home page: " . $e->getMessage());
            }
        }
        ?>

        <div class="testimonials-grid">
            <?php if (!empty($home_reviews)): ?>
                <?php 
                $count = 0;
                foreach ($home_reviews as $rev): 
                    $count++;
                    $aos_effect = $count % 2 == 0 ? 'fade-right' : 'fade-left';
                ?>
                <div class="testimonial-card" data-aos="<?php echo $aos_effect; ?>">
                    <span class="testimonial-quote">&ldquo;</span>
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="<?php echo $i <= $rev['rating'] ? 'fa-solid' : 'fa-regular'; ?> fa-star"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="testimonial-text">"<?php echo htmlspecialchars($rev['review_text']); ?>"</p>
                    <div class="testimonial-author">
                        <!-- Simple initials avatar or generic profile -->
                        <div class="author-avatar" style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary-light); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1rem; margin-right: 15px;">
                            <?php 
                            $names = explode(' ', $rev['name']);
                            $initials = isset($names[0]) ? substr($names[0], 0, 1) : '';
                            $initials .= isset($names[1]) ? substr($names[1], 0, 1) : '';
                            echo htmlspecialchars(strtoupper($initials));
                            ?>
                        </div>
                        <div class="author-info">
                            <h4><?php echo htmlspecialchars($rev['name']); ?></h4>
                            <?php if (!empty($rev['package_name'])): ?>
                                <p style="color: var(--secondary); font-size: 0.8rem;"><i class="fa-solid fa-suitcase"></i> <?php echo htmlspecialchars($rev['package_name']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback Static Testimonials if Database is empty -->
                <!-- Review 1 -->
                <div class="testimonial-card" data-aos="fade-left">
                    <span class="testimonial-quote">&ldquo;</span>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Dileep was an absolute legend of a guide! He personalized our itinerary completely on the fly based on what we wanted to see. The hotels were wonderful, the van was super comfortable, and his local knowledge made our Sigiriya visit unforgettable."</p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" alt="Mark T." class="author-img" loading="lazy">
                        <div class="author-info">
                            <h4>Mark Thompson</h4>
                            <p>United Kingdom</p>
                        </div>
                    </div>
                </div>

                <!-- Review 2 -->
                <div class="testimonial-card" data-aos="fade-right">
                    <span class="testimonial-quote">&ldquo;</span>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <p class="testimonial-text">"We did a 10-day tour covering cultural sites, the Ella train ride, and a Yala safari. Dileep is extremely professional, safe at driving, and took us to beautiful spots away from the crowd. Highly recommend Dileep Sanjaya Tours!"</p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80" alt="Sarah L." class="author-img" loading="lazy">
                        <div class="author-info">
                            <h4>Sarah & Liam</h4>
                            <p>Australia</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- See All Reviews Link -->
        <div style="text-align: center; margin-top: 40px;" data-aos="fade-up">
            <a href="reviews.php" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-comments"></i> See All Reviews
            </a>
        </div>
    </div>
</section>

<?php
$slideshow_images = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM gallery ORDER BY id DESC LIMIT 10");
        $slideshow_images = $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Failed to fetch gallery images for slideshow: " . $e->getMessage());
    }
}
if (!empty($slideshow_images)):
?>
<!-- Dynamic Gallery Slideshow Section -->
<section class="gallery-slideshow-section">
    <div style="width: 100%; overflow: hidden; padding: 10px 0;">
        <div class="gallery-slideshow-track">
            <?php 
            // Loop multiple times to ensure enough track length for seamless scrolling
            $loop_images = array_merge($slideshow_images, $slideshow_images, $slideshow_images);
            foreach ($loop_images as $img):
                $src = (strpos($img['image_path'], 'http') === 0) ? $img['image_path'] : $img['image_path'];
            ?>
            <div class="gallery-slide-item">
                <a href="gallery.php">
                    <img src="<?php echo $src; ?>" alt="<?php echo htmlspecialchars($img['alt_text'] ?? ''); ?>" loading="lazy">
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Bottom CTA Banner -->
<section class="bottom-cta">
    <div class="container cta-content" data-aos="fade-up">
        <h2>Ready to Plan Your Dream Getaway?</h2>
        <p>Let's design a custom itinerary that suits your schedule, interests, and style. Dileep is ready to help you plan via WhatsApp or email.</p>
        <div class="cta-buttons">
            <a href="https://wa.me/94752574781" target="_blank" rel="noopener noreferrer" class="btn btn-accent"><i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp</a>
            <a href="tel:+94752574781" class="btn btn-secondary"><i class="fa-solid fa-phone"></i> Call Direct</a>
        </div>
    </div>
</section>

<?php
include 'includes/footer.php';
?>
