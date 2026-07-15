<?php
// Determine the current active page
$current_page = basename($_SERVER['PHP_SELF']);

// Determine canonical URL dynamically if not set
if (!isset($canonical_url)) {
    $request_scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $clean_uri = preg_replace('/\.php$/', '', strtok($_SERVER['REQUEST_URI'], '?'));
    if ($clean_uri === '/index' || $clean_uri === '/') {
        $clean_uri = '';
    }
    $canonical_url = "https://dileepsanjayatours.com" . $clean_uri;
}

// Fallbacks for SEO variables
$default_desc = "Experience the best of Sri Lanka with Dileep Sanjaya Tours. We offer customized cultural tours, wildlife safaris, beach holidays, and local guide services.";
$seo_desc = isset($meta_description) ? $meta_description : $default_desc;
$seo_title = isset($page_title) ? $page_title : "Dileep Sanjaya Tours | Sri Lanka Travel Agency";
$seo_keywords = isset($meta_keywords) ? $meta_keywords : "Sri Lanka tours, customized travel packages, wildlife safari, beach holidays, Sri Lanka travel agency, Ella train ride, Sigiriya tour, Mirissa whale watching";
$seo_image = isset($og_image) ? $og_image : "https://dileepsanjayatours.com/images/logo.png";
$seo_type = isset($og_type) ? $og_type : "website";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Base Path for clean URLs -->
    <base href="<?php echo htmlspecialchars(rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($seo_desc); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($seo_keywords); ?>">
    
    <title><?php echo htmlspecialchars($seo_title); ?></title>
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url); ?>">
    
    <!-- Favicon Links (Elephant/Logo icon) -->
    <link rel="icon" type="image/png" sizes="32x32" href="images/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/logo.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/logo.png">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?php echo htmlspecialchars($seo_type); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($seo_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($seo_desc); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($seo_image); ?>">
    <meta property="og:site_name" content="Dileep Sanjaya Tours">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo htmlspecialchars($canonical_url); ?>">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($seo_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($seo_desc); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($seo_image); ?>">

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Structured Data Schema.org (JSON-LD) -->
    <?php if (isset($schema_json_ld)): ?>
    <script type="application/ld+json">
        <?php echo $schema_json_ld; ?>
    </script>
    <?php endif; ?>
</head>
<?php $is_home = ($current_page == 'index.php' || $current_page == ''); ?>
<body class="<?php echo $is_home ? 'preloader-active' : ''; ?>">

<?php if ($is_home): ?>
    <!-- Preloader / Splash Screen -->
    <div id="preloader">
        <div class="preloader-content">
            <img src="images/logo.png" alt="Dileep Sanjaya Tours Logo" class="preloader-logo" onerror="this.src='https://placehold.co/100x80/0d4f5c/ffffff?text=DST';">
            <div class="preloader-spinner"></div>
            <p class="preloader-tagline">Discover the Heart of Sri Lanka</p>
        </div>
    </div>
<?php endif; ?>

    <!-- Header Navigation -->
    <header class="site-header">
        <div class="container nav-container">
            <!-- Brand Logo -->
            <a href="index.php" class="logo-link" title="Dileep Sanjaya Tours Home">
                <img src="images/logo.png" alt="Dileep Sanjaya Tours Logo" class="logo-img" onerror="this.src='https://placehold.co/80x60/0d4f5c/ffffff?text=DST';">
                <div class="logo-text">
                    Dileep Sanjaya
                    <span>TOURS</span>
                </div>
            </a>

            <!-- Navigation Menu -->
            <nav class="nav-bar">
                <button class="nav-toggle" aria-label="Toggle navigation menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <ul class="nav-menu">
                    <li>
                        <a href="index.php" class="nav-link <?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : ''; ?>">Home</a>
                    </li>
                    <li>
                        <a href="packages.php" class="nav-link <?php echo ($current_page == 'packages.php' || $current_page == 'package-details.php') ? 'active' : ''; ?>">Packages</a>
                    </li>
                    <li>
                        <a href="about.php" class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About Us</a>
                    </li>
                    <li>
                        <a href="gallery.php" class="nav-link <?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>">Gallery</a>
                    </li>
                    <li>
                        <a href="reviews.php" class="nav-link <?php echo ($current_page == 'reviews.php' || $current_page == 'submit-review.php') ? 'active' : ''; ?>">Reviews</a>
                    </li>
                    <li>
                        <a href="contact.php" class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact Us</a>
                    </li>
                    <li>
                        <a href="https://wa.me/94752574781" target="_blank" rel="noopener noreferrer" class="btn btn-secondary nav-btn"><i class="fa-brands fa-whatsapp"></i> Book Now</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
