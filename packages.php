<?php
require_once 'data/packages_data.php';

$page_title = "Sri Lanka Tour Packages & Custom Itineraries | Dileep Sanjaya Tours";
$meta_description = "Browse our curated Sri Lanka tour packages. From wildlife safaris in Yala to cultural sites in Sigiriya, Ella train rides, and beach holidays. Fully customizable.";
$meta_keywords = "Sri Lanka tour packages, customized itineraries, adventure tours, cultural holidays, Yala safari packages, Sri Lanka travel package";
$canonical_url = "https://dileepsanjayatours.com/packages";

include 'includes/header.php';
?>

<!-- Inner Page Header -->
<section class="inner-header">
    <div class="container">
        <h1 data-aos="fade-up">Our Tour Packages</h1>
        <div class="breadcrumbs" data-aos="fade-up" data-aos-delay="150">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Packages</span>
        </div>
    </div>
</section>

<!-- Packages Grid & Filter Section -->
<section class="packages-section" style="background-color: var(--bg-cream);">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Select Your Sri Lankan Adventure</h2>
            <p>Use the filters below to browse packages by tour category. All tours can be fully customized by Dileep.</p>
        </div>

        <!-- Filter Buttons -->
      

        <!-- Packages Grid -->
        <div class="packages-grid">
            <?php 
            $delay = 0;
            foreach ($packages as $pkg): 
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
            $delay = ($delay + 150) % 450; // Staggers row items: 0ms, 150ms, 300ms, then resets to 0ms for the next row
            endforeach; 
            ?>
        </div>
    </div>
</section>

<?php
include 'includes/footer.php';
?>
