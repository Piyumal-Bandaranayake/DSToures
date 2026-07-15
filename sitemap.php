<?php
header("Content-Type: application/xml; charset=utf-8");
require_once 'data/packages_data.php';

// Base URL
$base_url = "https://dileepsanjayatours.com";

// Current date for lastmod
$current_date = date("Y-m-d");

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Pages -->
    <url>
        <loc><?php echo $base_url; ?>/</loc>
        <lastmod><?php echo $current_date; ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?php echo $base_url; ?>/packages</loc>
        <lastmod><?php echo $current_date; ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?php echo $base_url; ?>/about</loc>
        <lastmod>2026-07-09</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?php echo $base_url; ?>/gallery</loc>
        <lastmod><?php echo $current_date; ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?php echo $base_url; ?>/reviews</loc>
        <lastmod><?php echo $current_date; ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?php echo $base_url; ?>/contact</loc>
        <lastmod>2026-07-09</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    <!-- Dynamic Tour Package Pages -->
    <?php foreach ($packages as $pkg): 
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $pkg['title']), '-'));
        $tour_url = $base_url . "/tour/" . $slug;
    ?>
    <url>
        <loc><?php echo htmlspecialchars($tour_url); ?></loc>
        <lastmod><?php echo $current_date; ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>
</urlset>
