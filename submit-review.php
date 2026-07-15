<?php
require_once 'db.php';
require_once 'data/packages_data.php';

$page_title = "Write a Review | Share Your Experience | Dileep Sanjaya Tours";
$meta_description = "Did you travel with Dileep Sanjaya Tours? Share your review and rating about your Sri Lankan safari, cultural tour, or beach holiday.";
$meta_keywords = "submit tour review, rate travel agent Sri Lanka, feedback Dileep Sanjaya, write review private driver";
$canonical_url = "https://dileepsanjayatours.com/reviews/submit";

include 'includes/header.php';

$errors = [];
$success_message = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $package_name = isset($_POST['package_name']) ? trim($_POST['package_name']) : '';
    $review_text = isset($_POST['review_text']) ? trim($_POST['review_text']) : '';

    // Validation
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "A valid email address is required.";
    }
    if ($rating < 1 || $rating > 5) {
        $errors['rating'] = "Please select a rating between 1 and 5 stars.";
    }
    if (empty($review_text)) {
        $errors['review_text'] = "Review message cannot be empty.";
    }

    if (empty($errors)) {
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("INSERT INTO reviews (name, email, rating, review_text, package_name, status) VALUES (?, ?, ?, ?, ?, 'pending')");
                $stmt->execute([$name, $email, $rating, $review_text, $package_name]);
                $success_message = "Thank you! Your review is pending approval and will be published soon.";
                // Clear post data
                $name = $email = $package_name = $review_text = '';
                $rating = 0;
            } catch (PDOException $e) {
                $errors['db'] = "An error occurred while saving your review. Please try again later.";
            }
        } else {
            $errors['db'] = "Database connection not available. Please try again later.";
        }
    }
}
?>

<!-- Inner Page Header -->
<section class="inner-header">
    <div class="container">
        <h1 data-aos="fade-up">Write a Review</h1>
        <div class="breadcrumbs" data-aos="fade-up" data-aos-delay="150">
            <a href="index.php">Home</a>
            <span>/</span>
            <a href="reviews.php">Reviews</a>
            <span>/</span>
            <span>Write a Review</span>
        </div>
    </div>
</section>

<main class="submit-review-page" style="padding: 60px 0 80px; background-color: var(--bg-cream);">
    <div class="container" style="max-width: 600px;">
        <div class="card" style="background: var(--bg-white); padding: 40px; border-radius: 12px; box-shadow: var(--shadow);">
            <div style="text-align: center; margin-bottom: 30px;">
                <p style="color: var(--text-muted);">Share your journey with Dileep Sanjaya Tours and help other travelers!</p>
            </div>

            <?php if (!empty($success_message)): ?>
                <!-- Success Modal Overlay -->
                <div id="successModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(7, 47, 55, 0.6); display: flex; align-items: center; justify-content: center; z-index: 10000; backdrop-filter: blur(4px); transition: all 0.3s ease;">
                    <div style="background-color: var(--bg-white); padding: 40px; border-radius: 12px; max-width: 450px; width: 90%; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.15); animation: modalBounce 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative;">
                        <div style="width: 70px; height: 70px; background-color: rgba(26, 158, 110, 0.1); color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 2.2rem;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <h3 style="font-family: var(--font-heading); color: var(--primary); font-size: 1.6rem; margin-bottom: 12px;">Submitted Successfully!</h3>
                        <p style="color: var(--text-muted); font-family: var(--font-body); font-size: 0.95rem; line-height: 1.6; margin-bottom: 25px;"><?php echo htmlspecialchars($success_message); ?></p>
                        <button onclick="closeSuccessModal()" class="btn btn-primary" style="padding: 12px 30px; font-weight: 600; cursor: pointer; border-radius: 6px; border: none; width: 100%;">Okay, Great!</button>
                    </div>
                </div>
                
                <style>
                @keyframes modalBounce {
                    0% { transform: scale(0.7); opacity: 0; }
                    100% { transform: scale(1); opacity: 1; }
                }
                </style>
                
                <script>
                function closeSuccessModal() {
                    const modal = document.getElementById('successModal');
                    modal.style.opacity = '0';
                    setTimeout(() => {
                        modal.style.display = 'none';
                        window.location.href = 'reviews.php';
                    }, 300);
                }
                </script>
            <?php endif; ?>

            <?php if (!empty($errors['db'])): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 25px; border-left: 5px solid #dc3545;">
                    <p style="margin: 0; font-weight: 500;"><?php echo htmlspecialchars($errors['db']); ?></p>
                </div>
            <?php endif; ?>

            <form action="submit-review.php" method="POST" id="reviewForm" style="display: flex; flex-direction: column; gap: 20px;">
                <!-- Name -->
                <div>
                    <label for="name" style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--primary-dark);">Your Name *</label>
                    <input type="text" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required 
                           style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: var(--font-body); font-size: 1rem; transition: var(--transition);" 
                           onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-color)'">
                    <?php if (isset($errors['name'])): ?>
                        <span style="color: #dc3545; font-size: 0.85rem; margin-top: 5px; display: block;"><?php echo $errors['name']; ?></span>
                    <?php endif; ?>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--primary-dark);">Your Email *</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required 
                           style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: var(--font-body); font-size: 1rem; transition: var(--transition);"
                           onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-color)'">
                    <small style="color: var(--text-muted); display: block; margin-top: 4px;">Your email will not be published publicly.</small>
                    <?php if (isset($errors['email'])): ?>
                        <span style="color: #dc3545; font-size: 0.85rem; margin-top: 5px; display: block;"><?php echo $errors['email']; ?></span>
                    <?php endif; ?>
                </div>

                <!-- Package Dropdown -->
                <div>
                    <label for="package_name" style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--primary-dark);">Tour Package taken (Optional)</label>
                    <select id="package_name" name="package_name" 
                            style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: var(--font-body); font-size: 1rem; background-color: var(--bg-white); transition: var(--transition);"
                            onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-color)'">
                        <option value="">-- Select Package (Or leave empty) --</option>
                        <?php foreach ($packages as $pkg): ?>
                            <option value="<?php echo htmlspecialchars($pkg['title']); ?>" <?php echo (isset($package_name) && $package_name === $pkg['title']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($pkg['title']); ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="Custom Tour" <?php echo (isset($package_name) && $package_name === 'Custom Tour') ? 'selected' : ''; ?>>Custom Tailored Tour</option>
                    </select>
                </div>

                <!-- Rating -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--primary-dark);">Your Rating *</label>
                    <div class="star-rating" style="display: flex; gap: 8px; font-size: 1.8rem; color: #ccc;">
                        <input type="hidden" name="rating" id="ratingInput" value="<?php echo isset($rating) ? $rating : 0; ?>">
                        <i class="fa-solid fa-star star-btn" data-value="1" style="cursor: pointer; transition: var(--transition);"></i>
                        <i class="fa-solid fa-star star-btn" data-value="2" style="cursor: pointer; transition: var(--transition);"></i>
                        <i class="fa-solid fa-star star-btn" data-value="3" style="cursor: pointer; transition: var(--transition);"></i>
                        <i class="fa-solid fa-star star-btn" data-value="4" style="cursor: pointer; transition: var(--transition);"></i>
                        <i class="fa-solid fa-star star-btn" data-value="5" style="cursor: pointer; transition: var(--transition);"></i>
                    </div>
                    <?php if (isset($errors['rating'])): ?>
                        <span style="color: #dc3545; font-size: 0.85rem; margin-top: 5px; display: block;"><?php echo $errors['rating']; ?></span>
                    <?php endif; ?>
                </div>

                <!-- Review Text -->
                <div>
                    <label for="review_text" style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--primary-dark);">Your Review *</label>
                    <textarea id="review_text" name="review_text" rows="5" required 
                              style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: var(--font-body); font-size: 1rem; resize: vertical; transition: var(--transition);"
                              onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-color)'"><?php echo isset($review_text) ? htmlspecialchars($review_text) : ''; ?></textarea>
                    <?php if (isset($errors['review_text'])): ?>
                        <span style="color: #dc3545; font-size: 0.85rem; margin-top: 5px; display: block;"><?php echo $errors['review_text']; ?></span>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary" style="padding: 14px 20px; font-weight: 600; cursor: pointer; text-align: center; border: none; border-radius: 6px;">
                    Submit Review
                </button>
            </form>
        </div>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll(".star-btn");
    const ratingInput = document.getElementById("ratingInput");
    
    function highlightStars(rating) {
        stars.forEach(star => {
            const value = parseInt(star.getAttribute("data-value"));
            if (value <= rating) {
                star.style.color = "var(--accent)";
            } else {
                star.style.color = "#ccc";
            }
        });
    }

    // Set initial rating if exists
    if (ratingInput.value > 0) {
        highlightStars(parseInt(ratingInput.value));
    }

    stars.forEach(star => {
        star.addEventListener("mouseover", function() {
            const hoverValue = parseInt(this.getAttribute("data-value"));
            highlightStars(hoverValue);
        });

        star.addEventListener("mouseout", function() {
            const currentValue = parseInt(ratingInput.value) || 0;
            highlightStars(currentValue);
        });

        star.addEventListener("click", function() {
            const selectedValue = parseInt(this.getAttribute("data-value"));
            ratingInput.value = selectedValue;
            highlightStars(selectedValue);
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
