<?php
require_once 'data/packages_data.php';
require_once 'db.php';

// If legacy ID is passed directly, redirect 301 to clean slug-based URL
if (isset($_GET['id']) && !isset($_GET['slug'])) {
    $legacy_id = (int)$_GET['id'];
    if (isset($packages[$legacy_id])) {
        $package_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $packages[$legacy_id]['title']), '-'));
        $base_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $base_dir . "tour/" . $package_slug);
        exit();
    }
}

// Get and validate ID or Slug
$id = 0;
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
} elseif (isset($_GET['slug'])) {
    $slug = trim($_GET['slug']);
    foreach ($packages as $pkg_id => $pkg) {
        $pkg_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $pkg['title']), '-'));
        if ($pkg_slug === $slug) {
            $id = $pkg_id;
            break;
        }
    }
}

if ($id <= 0 || !isset($packages[$id])) {
    // If not found, redirect to packages page
    header("Location: packages.php");
    exit();
}

$package = $packages[$id];

// Fetch package ratings from database reviews
$avg_rating = 5.0;
$review_count = 0;
if ($pdo) {
    try {
        $stmt_reviews = $pdo->prepare("SELECT COUNT(*) as count, AVG(rating) as avg_rating FROM reviews WHERE package_name = ? AND status = 'approved'");
        $stmt_reviews->execute([$package['title']]);
        $rev_stats = $stmt_reviews->fetch();
        if ($rev_stats && $rev_stats['count'] > 0) {
            $review_count = intval($rev_stats['count']);
            $avg_rating = round(floatval($rev_stats['avg_rating']), 1);
        }
    } catch (PDOException $e) {
        error_log("Failed to fetch reviews stats for package: " . $e->getMessage());
    }
}

// Fallback rating from static data
$rating_val = $review_count > 0 ? $avg_rating : (isset($package['rating']) ? $package['rating'] : 5.0);
$rating_count = $review_count > 0 ? $review_count : (isset($package['reviews']) ? $package['reviews'] : 1);

// Generate slug-based canonical URL
$package_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $package['title']), '-'));
$canonical_url = "https://dileepsanjayatours.com/tour/" . $package_slug;

// Dynamic SEO Variables
$page_title = $package['title'] . " | Dileep Sanjaya Tours Sri Lanka";
$meta_description = substr(strip_tags($package['description']), 0, 155) . "...";
$meta_keywords = strtolower($package['title']) . ", Sri Lanka private tour, customized tour Sri Lanka, " . implode(", ", array_slice($package['highlights'], 0, 2));
$og_image = "https://dileepsanjayatours.com/" . $package['image'];
$og_type = "article";

// Generate JSON-LD TouristTrip Schema
$schema_data = [
    "@context" => "https://schema.org",
    "@type" => "TouristTrip",
    "name" => $package['title'],
    "description" => $package['description'],
    "image" => "https://dileepsanjayatours.com/" . $package['image'],
    "touristType" => "Tourists",
    "offers" => [
        "@type" => "Offer",
        "price" => (string)$package['price'],
        "priceCurrency" => "USD",
        "priceSpecification" => [
            "@type" => "PriceSpecification",
            "price" => (string)$package['price'],
            "priceCurrency" => "USD",
            "valueAddedTaxIncluded" => "true"
        ],
        "url" => $canonical_url,
        "eligibleQuantity" => [
            "@type" => "QuantitativeValue",
            "minValue" => "2",
            "unitText" => "Person"
        ]
    ],
    "itinerary" => []
];

// Populate itinerary in structured data
if (isset($package['itinerary'])) {
    foreach ($package['itinerary'] as $day => $step) {
        $schema_data["itinerary"][] = [
            "@type" => "HowToSection",
            "name" => $step['day'] . ": " . $step['title'],
            "description" => $step['description']
        ];
    }
}

// Add aggregate rating
$schema_data["aggregateRating"] = [
    "@type" => "AggregateRating",
    "ratingValue" => (string)$rating_val,
    "reviewCount" => (string)$rating_count,
    "bestRating" => "5",
    "worstRating" => "1"
];

$schema_json_ld = json_encode($schema_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

include 'includes/header.php';
?>

<!-- Inner Page Header with custom background if available, or fallback -->
<section class="inner-header" style="background: linear-gradient(135deg, rgba(13, 79, 92, 0.85), rgba(26, 158, 110, 0.75)), url('<?php echo $package['image']; ?>') no-repeat center center/cover;">
    <div class="container">
        <span class="package-tag" style="position: static; display: inline-block; margin-bottom: 15px; background-color: var(--accent); color: var(--primary-dark);"><?php echo htmlspecialchars($package['tag']); ?></span>
        <h1><?php echo htmlspecialchars($package['title']); ?></h1>
        <div class="breadcrumbs">
            <a href="index.php">Home</a>
            <span>/</span>
            <a href="packages.php">Packages</a>
            <span>/</span>
            <span>Details</span>
        </div>
    </div>
</section>

<!-- Package Details Section -->
<section class="package-details-section" style="padding: 80px 0; background-color: var(--bg-cream);">
    <div class="container">
        <!-- Centered Details Layout -->
        <div style="max-width: 900px; margin: 0 auto;">
            
            <!-- Details Column -->
            <div class="details-main-content" style="background-color: var(--bg-white); padding: 40px; border-radius: 20px; box-shadow: var(--shadow); border: 1px solid var(--border-color);">
                
                <!-- Main image -->
                <img src="<?php echo $package['image']; ?>" alt="<?php echo htmlspecialchars($package['title']); ?>" style="width: 100%; height: 400px; object-fit: cover; border-radius: 15px; margin-bottom: 30px; box-shadow: var(--shadow);">
                
                <!-- Title and Meta Info -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px;">
                    <div>
                        <h2 style="font-size: 2.2rem; margin-bottom: 10px; color: var(--primary);"><?php echo htmlspecialchars($package['title']); ?></h2>
                        <div style="display: flex; align-items: center; gap: 15px; font-size: 0.95rem; color: var(--text-muted);">
                            <span><i class="fa-solid fa-clock" style="color: var(--secondary);"></i> <?php echo htmlspecialchars($package['duration']); ?></span>
                            <?php if (isset($package['rating']) && isset($package['reviews'])): ?>
                            <span>
                                <i class="fa-solid fa-star" style="color: var(--accent);"></i> 
                                <strong><?php echo $package['rating']; ?></strong> (<?php echo $package['reviews']; ?> reviews)
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.9rem; color: var(--text-muted); display: block;">Tour Price</span>
                        <span style="font-size: 2.2rem; color: var(--secondary); font-weight: 700; display: block; line-height: 1;">$<?php echo $package['price']; ?> <span style="font-size: 1rem; font-weight: 500; color: var(--text-muted);">/ person</span></span>
                        <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-top: 5px;">(Min 3 Persons)</span>
                    </div>
                </div>

                <!-- Description -->
                <div style="margin-bottom: 35px;">
                    <h3 style="font-size: 1.5rem; margin-bottom: 15px; color: var(--primary);">Overview</h3>
                    <p style="color: var(--text-muted); font-size: 1.05rem; line-height: 1.8;"><?php echo htmlspecialchars($package['description']); ?></p>
                </div>

                <!-- Highlights -->
                <div style="margin-bottom: 35px;">
                    <h3 style="font-size: 1.5rem; margin-bottom: 20px; color: var(--primary);">Tour Highlights</h3>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 15px;">
                        <?php foreach ($package['highlights'] as $highlight): ?>
                            <li style="display: flex; align-items: flex-start; gap: 15px; font-size: 1.05rem; color: var(--text-dark);">
                                <i class="fa-solid fa-circle-check" style="color: var(--secondary); font-size: 1.3rem; margin-top: 3px;"></i>
                                <span><?php echo htmlspecialchars($highlight); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Itinerary -->
                <?php if (isset($package['itinerary'])): ?>
                <div style="margin-top: 40px; border-top: 1px solid var(--border-color); padding-top: 30px;">
                    <h3 style="font-size: 1.5rem; margin-bottom: 25px; color: var(--primary);">Day-by-Day Itinerary</h3>
                    <div class="itinerary-timeline" style="position: relative; padding-left: 30px;">
                        <!-- Vertical Line -->
                        <div style="position: absolute; left: 9px; top: 10px; bottom: 10px; width: 2px; background-color: var(--secondary); opacity: 0.3;"></div>
                        
                        <?php foreach ($package['itinerary'] as $day_num => $step): ?>
                            <div class="itinerary-item" style="position: relative; margin-bottom: 30px;">
                                <!-- Bullet point -->
                                <div style="position: absolute; left: -30px; top: 4px; width: 20px; height: 20px; border-radius: 50%; background-color: var(--secondary); border: 4px solid var(--bg-white); box-shadow: 0 0 0 2px var(--secondary);"></div>
                                <h4 style="font-size: 1.15rem; margin-bottom: 8px; color: var(--primary); display: flex; align-items: center; gap: 10px;">
                                    <span style="background-color: var(--secondary); color: var(--bg-white); padding: 2px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;"><?php echo htmlspecialchars($step['day']); ?></span>
                                    <span><?php echo htmlspecialchars($step['title']); ?></span>
                                </h4>
                                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-left: 0;"><?php echo htmlspecialchars($step['description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick WhatsApp Booking Card at the bottom -->
        <div class="info-box" style="background-color: var(--primary-dark); color: var(--bg-white); border-color: var(--primary-dark); text-align: center; padding: 40px 30px; border-radius: 20px; margin-top: 50px; box-shadow: var(--shadow); max-width: 800px; margin-left: auto; margin-right: auto;">
            <h4 style="color: var(--bg-white); font-size: 1.6rem; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; gap: 10px;"><i class="fa-brands fa-whatsapp" style="color: #25d366; font-size: 2rem;"></i> Book via WhatsApp</h4>
            <p style="color: #c4d7da; margin-bottom: 25px; font-size: 1.05rem;">Send a direct WhatsApp message to Dileep with your travel dates and number of people to secure your booking instantly.</p>
            <a href="https://wa.me/94752574781?text=Hi%20Dileep,%20I%20want%20to%20book%20the%20%22<?php echo urlencode($package['title']); ?>%22%20tour." target="_blank" rel="noopener noreferrer" class="btn btn-accent" style="width: auto; padding: 12px 35px; display: inline-flex; align-items: center; gap: 8px; font-size: 1.1rem;"><i class="fa-brands fa-whatsapp"></i> Book Now</a>
        </div>
    </div>
</section>

<?php
include 'includes/footer.php';
?>
