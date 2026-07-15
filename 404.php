<?php
$page_title = "Page Not Found | Dileep Sanjaya Tours";
$meta_description = "The page you are looking for does not exist. Return to the home page to discover our customized Sri Lankan tours.";
$canonical_url = "https://dileepsanjayatours.com/404";
include 'includes/header.php';
?>

<!-- 404 Section -->
<section style="padding: 100px 0; background-color: var(--bg-cream); text-align: center;">
    <div class="container" style="max-width: 600px; margin: 0 auto; padding: 0 15px;">
        <i class="fa-solid fa-compass-drafting" style="font-size: 6rem; color: var(--secondary); margin-bottom: 25px; display: block;"></i>
        <h1 style="font-size: 4rem; color: var(--primary); margin-bottom: 15px; font-family: var(--font-heading); line-height: 1;">404</h1>
        <h2 style="font-size: 1.8rem; color: var(--primary-dark); margin-bottom: 20px;">Oops! Page Not Found</h2>
        <p style="color: var(--text-muted); font-size: 1.1rem; line-height: 1.6; margin-bottom: 35px;">We couldn't find the page you were looking for. It might have been moved, deleted, or the URL might have been typed incorrectly.</p>
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="index.php" class="btn btn-primary" style="padding: 12px 30px;"><i class="fa-solid fa-house"></i> Go to Homepage</a>
            <a href="packages.php" class="btn btn-accent" style="padding: 12px 30px;"><i class="fa-solid fa-compass"></i> View Tour Packages</a>
        </div>
    </div>
</section>

<?php
include 'includes/footer.php';
?>
