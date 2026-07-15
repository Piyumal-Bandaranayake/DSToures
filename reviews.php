<?php
require_once 'db.php';

// Pagination Settings
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$reviews = [];
$total_reviews = 0;
$avg_rating = 0.0;
$total_pages = 1;

if ($pdo) {
    try {
        // Get average rating and count
        $stats_stmt = $pdo->query("SELECT COUNT(*) as count, AVG(rating) as avg_rating FROM reviews WHERE status = 'approved'");
        $stats = $stats_stmt->fetch();
        if ($stats) {
            $total_reviews = intval($stats['count']);
            $avg_rating = $stats['avg_rating'] ? round(floatval($stats['avg_rating']), 1) : 0.0;
        }

        // Get total pages
        $total_pages = ceil($total_reviews / $limit);

        // Fetch reviews for current page
        $reviews_stmt = $pdo->prepare("SELECT * FROM reviews WHERE status = 'approved' ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $reviews_stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $reviews_stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $reviews_stmt->execute();
        $reviews = $reviews_stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Failed to load reviews: " . $e->getMessage());
    }
}

// SEO variables
$page_title = "Guest Reviews & Testimonials | Dileep Sanjaya Tours";
$meta_description = "Read authentic reviews, ratings, and feedback from travelers who explored Sri Lanka with Dileep Sanjaya Tours. Currently rated " . ($avg_rating ?: '5') . "/5 stars.";
$meta_keywords = "Sri Lanka tour reviews, Dileep Sanjaya customer reviews, travel agency feedback, private driver rating Sri Lanka";
$canonical_url = "https://dileepsanjayatours.com/reviews";

// Generate Schema.org JSON-LD dynamically
$reviews_schema = [];
if (!empty($reviews)) {
    foreach ($reviews as $rev) {
        $reviews_schema[] = [
            "@type" => "Review",
            "author" => [
                "@type" => "Person",
                "name" => $rev['name']
            ],
            "datePublished" => date('Y-m-d', strtotime($rev['created_at'])),
            "reviewBody" => $rev['review_text'],
            "reviewRating" => [
                "@type" => "Rating",
                "ratingValue" => (string)$rev['rating'],
                "bestRating" => "5",
                "worstRating" => "1"
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => "Dileep Sanjaya Tours"
            ]
        ];
    }
}

$schema_data = [
    "@context" => "https://schema.org",
    "@type" => "TouristTrip",
    "name" => "Dileep Sanjaya Tours Reviews",
    "description" => "Guest reviews and travel ratings for guided tours across Sri Lanka.",
    "provider" => [
        "@type" => "LocalBusiness",
        "name" => "Dileep Sanjaya Tours"
    ]
];

if ($total_reviews > 0) {
    $schema_data["aggregateRating"] = [
        "@type" => "AggregateRating",
        "ratingValue" => (string)$avg_rating,
        "reviewCount" => (string)$total_reviews,
        "bestRating" => "5",
        "worstRating" => "1"
    ];
}

if (!empty($reviews_schema)) {
    $schema_data["review"] = $reviews_schema;
}

$schema_json_ld = json_encode($schema_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

include 'includes/header.php';
?>

<!-- Inner Page Header -->
<section class="inner-header">
    <div class="container">
        <h1 data-aos="fade-up">Customer Reviews</h1>
        <div class="breadcrumbs" data-aos="fade-up" data-aos-delay="150">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Reviews</span>
        </div>
    </div>
</section>

<main class="reviews-page" style="padding: 60px 0 80px; background-color: var(--bg-cream);">
    <div class="container">
        <!-- Review Header & Stats Summary -->
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 40px; background: var(--bg-white); padding: 30px; border-radius: 12px; box-shadow: var(--shadow);">
            <div>
                <?php if ($total_reviews > 0): ?>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 1.2rem; font-family: var(--font-body);">
                        <span style="color: var(--accent); font-weight: 700;"><?php echo $avg_rating; ?> <i class="fa-solid fa-star"></i></span>
                        <span style="color: var(--text-muted); font-size: 0.95rem;">based on <?php echo $total_reviews; ?> customer review<?php echo $total_reviews > 1 ? 's' : ''; ?></span>
                    </div>
                <?php else: ?>
                    <p style="color: var(--text-muted); font-family: var(--font-body);">No reviews published yet. Be the first to write one!</p>
                <?php endif; ?>
            </div>
            <div>
                <a href="submit-review.php" class="btn btn-accent" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; padding: 12px 24px; border-radius: 6px;">
                    <i class="fa-solid fa-pen-to-square"></i> Write a Review
                </a>
            </div>
        </div>
        <!-- Reviews Grid -->
        <div class="reviews-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; margin-bottom: 40px;">
            <?php if (empty($reviews)): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: var(--bg-white); border-radius: 12px; box-shadow: var(--shadow);">
                    <i class="fa-solid fa-comments-question" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 15px; display: block;"></i>
                    <p style="font-size: 1.1rem; color: var(--text-muted);">No approved reviews found.</p>
                </div>
            <?php else: ?>
                <?php foreach ($reviews as $rev): ?>
                    <div class="testimonial-card" style="background: var(--bg-white); padding: 30px; border-radius: 12px; box-shadow: var(--shadow); transition: var(--transition); display: flex; flex-direction: column; gap: 15px;" onmouseover="this.style.boxShadow='var(--shadow-hover)'" onmouseout="this.style.boxShadow='var(--shadow)'">
                        <!-- 1. Star Rating -->
                        <div class="stars" style="color: var(--accent); font-size: 0.95rem; margin-bottom: 5px;">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="<?php echo $i <= $rev['rating'] ? 'fa-solid' : 'fa-regular'; ?> fa-star"></i>
                            <?php endfor; ?>
                        </div>

                        <!-- 2. Review text -->
                        <p class="testimonial-text" style="color: var(--text-dark); line-height: 1.6; font-family: var(--font-body); font-size: 0.95rem; margin: 0; white-space: normal;">
                            "<?php echo htmlspecialchars($rev['review_text']); ?>"
                        </p>

                        <!-- 3. Author details row -->
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 5px; gap: 10px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <!-- User Avatar with verification badge -->
                                <div style="position: relative; width: 44px; height: 44px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; flex-shrink: 0; text-transform: uppercase;">
                                    <?php 
                                    $names = explode(' ', $rev['name']);
                                    $initials = isset($names[0]) ? substr($names[0], 0, 1) : '';
                                    $initials .= isset($names[1]) ? substr($names[1], 0, 1) : '';
                                    echo htmlspecialchars(strtoupper($initials));
                                    ?>
                                    <!-- Small verification badge overlay -->
                                    <div style="position: absolute; bottom: -2px; right: -2px; width: 16px; height: 16px; background-color: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white;">
                                        <i class="fa-solid fa-check" style="font-size: 0.55rem; color: white;"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4 style="color: var(--primary); font-size: 1rem; font-family: var(--font-heading); font-weight: 700; margin: 0; line-height: 1.2;"><?php echo htmlspecialchars($rev['name']); ?></h4>
                                    <?php if (!empty($rev['package_name'])): ?>
                                        <span style="font-size: 0.72rem; color: var(--secondary); font-weight: 500;"><i class="fa-solid fa-suitcase"></i> <?php echo htmlspecialchars($rev['package_name']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div style="text-align: right; flex-shrink: 0;">
                                <span style="font-size: 0.78rem; color: var(--text-muted); font-family: var(--font-body); display: block;">
                                    <?php echo date('M d, Y', strtotime($rev['created_at'])); ?>
                                </span>
                            </div>
                        </div>

                        <!-- 4. Owner Response box -->
                        <?php if (!empty($rev['response_text'])): ?>
                            <div style="background-color: #f9fafb; padding: 18px; border-radius: 8px; border-left: 3px solid var(--accent); margin-top: 5px; text-align: left;">
                                <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 8px; font-weight: 600; font-family: var(--font-body);">
                                    <span>Response from the owner</span>
                                    <span><?php echo date('M d, Y', strtotime($rev['responded_at'])); ?></span>
                                </div>
                                <p style="color: var(--text-dark); font-size: 0.88rem; line-height: 1.5; font-family: var(--font-body); margin: 0; font-style: italic; white-space: normal;">
                                    "<?php echo htmlspecialchars($rev['response_text']); ?>"
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div style="display: flex; justify-content: center; gap: 10px; margin-top: 40px;">
                <?php if ($page > 1): ?>
                    <a href="reviews.php?page=<?php echo $page - 1; ?>" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.9rem; border-radius: 4px;">&laquo; Prev</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="reviews.php?page=<?php echo $i; ?>" class="btn <?php echo $i === $page ? 'btn-primary' : 'btn-outline'; ?>" style="padding: 8px 16px; font-size: 0.9rem; border-radius: 4px; <?php echo $i === $page ? 'background-color: var(--primary); color: white;' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="reviews.php?page=<?php echo $page + 1; ?>" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.9rem; border-radius: 4px;">Next &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
