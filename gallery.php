<?php
require_once 'db.php';
$page_title = "Sri Lanka Tour Gallery & Photos | Dileep Sanjaya Tours";
$meta_description = "See beautiful travel photos of Sri Lanka, including wildlife safaris, scenic train rides, pristine beaches, ancient temples, and our happy tourist groups.";
$meta_keywords = "Sri Lanka travel photos, Yala safari gallery, Ella train photos, Sigiriya rock pictures, Dileep Sanjaya Tours gallery";
$canonical_url = "https://dileepsanjayatours.com/gallery";

include 'includes/header.php';
?>

<!-- Inner Page Header -->
<section class="inner-header">
    <div class="container">
        <h1 data-aos="fade-up">Gallery</h1>
        <div class="breadcrumbs" data-aos="fade-up" data-aos-delay="150">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Gallery</span>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Capturing Memories</h2>
            <p>A collection of landscapes, adventures, happy guests, and our transportation fleet.</p>
        </div>

        <!-- Filter Buttons -->
        

        <!-- Gallery Grid -->
        <div class="gallery-grid">
            <?php
            $gallery_images = [];
            if ($pdo) {
                try {
                    $stmt = $pdo->query("SELECT * FROM gallery ORDER BY id ASC");
                    $db_items = $stmt->fetchAll();
                    
                    $i = 0;
                    foreach ($db_items as $item) {
                        $class = '';
                        $mod = $i % 8;
                        if ($mod === 0) $class = 'col-span-2';
                        elseif ($mod === 2) $class = 'row-span-2';
                        elseif ($mod === 7) $class = 'col-span-2';
                        
                        $gallery_images[] = [
                            'src' => (strpos($item['image_path'], 'http') === 0) ? $item['image_path'] : $item['image_path'],
                            'alt' => $item['alt_text'] ?? $item['title'],
                            'cat' => $item['category'],
                            'title' => $item['title'],
                            'class' => $class
                        ];
                        $i++;
                    }
                } catch (PDOException $e) {
                    error_log("Failed to query gallery: " . $e->getMessage());
                }
            }

            // Fallback to defaults if no images exist
            

            $delay = 0;
            foreach ($gallery_images as $img):
            ?>
            <div class="gallery-item <?php echo $img['class']; ?>" data-category="<?php echo $img['cat']; ?>" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <img src="<?php echo $img['src']; ?>" alt="<?php echo htmlspecialchars($img['alt']); ?>" loading="lazy">
                <div class="gallery-overlay">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </div>
            </div>
            <?php
            $delay = ($delay + 100) % 400; // Stagger grid layout delays
            endforeach;
            ?>
        </div>
    </div>
</section>

<!-- Custom Lightbox Modal -->
<div id="lightbox" class="lightbox">
    <div class="lightbox-content">
        <button id="lightbox-close" class="lightbox-close">&times;</button>
        <img id="lightbox-img" src="" alt="Lightbox View">
    </div>
</div>

<?php
include 'includes/footer.php';
?>
