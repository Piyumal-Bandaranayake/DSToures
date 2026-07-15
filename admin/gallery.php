<?php
session_start();
require_once '../db.php';

// Authentication Check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$message = "";
$error = "";

// Directory for uploads
$upload_dir = '../uploads/gallery/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle Add Image Form Submission (supports standard and AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $is_ajax = isset($_POST['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    
    // File validation
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error = "Please choose a valid image file.";
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => $error]);
            exit();
        }
    } else {
        $file_tmp = $_FILES['image']['tmp_name'];
        $original_name = basename($_FILES['image']['name']);
        $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        
        if (!in_array($file_ext, $allowed_exts)) {
            $error = "Only JPG, JPEG, PNG, WEBP, and GIF images are allowed.";
            if ($is_ajax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => $error]);
                exit();
            }
        } else {
            // Generate metadata from filename
            $raw_title = pathinfo($original_name, PATHINFO_FILENAME);
            $title = ucwords(str_replace(['-', '_'], ' ', $raw_title));
            $category = 'nature'; // Default category
            $alt_text = $title;
            
            // Generate a unique filename to prevent overwrites
            $new_filename = uniqid('img_', true) . '.' . $file_ext;
            $dest_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($file_tmp, $dest_path)) {
                // Save to database. The path stored in DB should be relative to the root (so 'uploads/gallery/filename')
                $db_path = 'uploads/gallery/' . $new_filename;
                
                if ($pdo) {
                    try {
                        $stmt = $pdo->prepare("INSERT INTO gallery (image_path, title, category, alt_text) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$db_path, $title, $category, $alt_text]);
                        $message = "Image added to gallery successfully.";
                        if ($is_ajax) {
                            header('Content-Type: application/json');
                            echo json_encode(['success' => true, 'message' => $message, 'image_path' => $db_path]);
                            exit();
                        }
                    } catch (PDOException $e) {
                        $error = "Database error: " . $e->getMessage();
                        // clean up uploaded file
                        if (file_exists($dest_path)) {
                            unlink($dest_path);
                        }
                        if ($is_ajax) {
                            header('Content-Type: application/json');
                            echo json_encode(['success' => false, 'error' => $error]);
                            exit();
                        }
                    }
                }
            } else {
                $error = "Failed to upload/save the image to the destination directory.";
                if ($is_ajax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => $error]);
                    exit();
                }
            }
        }
    }
}

// Handle Delete Image
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = intval($_POST['image_id']);
    if ($pdo) {
        try {
            // Get image details to delete file
            $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
            $stmt->execute([$id]);
            $img = $stmt->fetch();
            
            if ($img) {
                $image_path = $img['image_path'];
                
                // Delete database record
                $del_stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
                $del_stmt->execute([$id]);
                
                // If it is a local file (starts with uploads/), delete it physically
                if (strpos($image_path, 'uploads/') === 0) {
                    $full_path = '../' . $image_path;
                    if (file_exists($full_path)) {
                        unlink($full_path);
                    }
                }
                
                $message = "Image deleted from gallery successfully.";
            } else {
                $error = "Image not found.";
            }
        } catch (PDOException $e) {
            $error = "Failed to delete image: " . $e->getMessage();
        }
    }
}

// Fetch all gallery images
$gallery_items = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM gallery ORDER BY id DESC");
        $gallery_items = $stmt->fetchAll();
    } catch (PDOException $e) {
        $error = "Failed to load gallery items: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery | Dileep Sanjaya Tours</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f3f4f6;
            margin: 0;
            font-family: var(--font-body);
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background-color: var(--primary-dark);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar-brand {
            padding: 10px 25px;
            font-size: 1.3rem;
            font-weight: 700;
            font-family: var(--font-heading);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
            color: var(--accent);
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 14px 25px;
            color: #d1d5db;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }
        .sidebar-menu li a:hover,
        .sidebar-menu li.active a {
            color: #ffffff;
            background-color: rgba(255,255,255,0.08);
            border-left: 4px solid var(--accent);
        }
        .sidebar-menu li a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }
        .main-content {
            flex-grow: 1;
            padding: 40px;
            overflow-y: auto;
        }
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header-title h1 {
            margin: 0;
            font-size: 2rem;
            color: var(--primary);
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid var(--secondary);
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }
        
        .gallery-split-layout {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }
        @media (max-width: 992px) {
            .gallery-split-layout {
                grid-template-columns: 1fr;
            }
        }
        
        .form-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            height: fit-content;
        }
        .form-card h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.25rem;
            color: var(--primary-dark);
            font-family: var(--font-heading);
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
        }
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-family: var(--font-body);
            font-size: 0.95rem;
            box-sizing: border-box;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 65, 87, 0.1);
        }
        
        .gallery-grid-admin {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        .gallery-card-admin {
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .gallery-card-img-wrapper {
            position: relative;
            padding-top: 66%;
            overflow: hidden;
            background-color: #f3f4f6;
        }
        .gallery-card-img-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .gallery-card-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: rgba(30, 65, 87, 0.85);
            color: #ffffff;
            padding: 3px 8px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .gallery-card-body {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .gallery-card-title {
            margin: 0 0 10px 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.3;
        }
        .gallery-card-actions {
            margin-top: auto;
        }
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                padding: 15px 0;
            }
            .sidebar-brand {
                margin-bottom: 10px;
                padding: 5px 20px;
                border-bottom: none;
            }
            .sidebar-menu {
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-start;
                gap: 5px;
                padding: 0 10px;
                margin-bottom: 10px;
            }
            .sidebar-menu li a {
                padding: 8px 15px;
                border-radius: 4px;
                font-size: 0.9rem;
            }
            .sidebar-menu li.active a,
            .sidebar-menu li a:hover {
                border-left: none;
                background-color: var(--accent);
                color: var(--primary-dark);
            }
            .main-content {
                padding: 20px;
            }
            .header-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                margin-bottom: 25px;
            }
            .header-title h1 {
                font-size: 1.6rem;
            }
        }
        
        /* Drag & Drop Upload Zone */
        .upload-dragzone {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 45px 20px;
            text-align: center;
            background-color: #f8fafc;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            margin-bottom: 10px;
        }
        .upload-dragzone:hover, .upload-dragzone.dragover {
            border-color: var(--secondary);
            background-color: rgba(26, 158, 110, 0.05);
        }
        .upload-dragzone i.upload-icon {
            font-size: 3.2rem;
            color: #94a3b8;
            margin-bottom: 15px;
            transition: color 0.3s ease;
            display: block;
        }
        .upload-dragzone:hover i.upload-icon, .upload-dragzone.dragover i.upload-icon {
            color: var(--secondary);
        }
        .upload-dragzone p {
            margin: 0 0 8px 0;
            font-size: 1.1rem;
            color: #475569;
            font-weight: 600;
        }
        .upload-dragzone span {
            font-size: 0.85rem;
            color: #94a3b8;
            display: block;
        }
        .upload-file-list {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 250px;
            overflow-y: auto;
            padding-right: 5px;
        }
        .upload-file-item {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 15px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .upload-file-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }
        .upload-file-info {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-grow: 1;
            min-width: 0;
        }
        .upload-file-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .upload-file-status {
            font-size: 0.8rem;
            font-weight: 500;
            color: #64748b;
        }
        .upload-file-progress {
            width: 100%;
            height: 6px;
            background-color: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }
        .upload-file-progress-bar {
            height: 100%;
            width: 0%;
            background-color: var(--secondary);
            transition: width 0.2s ease;
        }
        .upload-file-item.success .upload-file-progress-bar {
            background-color: #10b981;
            width: 100% !important;
        }
        .upload-file-item.error .upload-file-progress-bar {
            background-color: #ef4444;
            width: 100% !important;
        }
        .upload-file-item.success .upload-file-status {
            color: #10b981;
        }
        .upload-file-item.error .upload-file-status {
            color: #ef4444;
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-plane-departure"></i> DST Admin
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            </li>
            <li>
                <a href="reviews.php"><i class="fa-solid fa-star"></i> Reviews</a>
            </li>
            <li class="active">
                <a href="gallery.php"><i class="fa-solid fa-images"></i> Gallery</a>
            </li>
            <li>
                <a href="reset-password.php"><i class="fa-solid fa-key"></i> Reset Password</a>
            </li>
        </ul>
        <div style="padding: 0 20px;">
            <a href="logout.php" class="btn btn-outline" style="width: 100%; border-color: rgba(255,255,255,0.3); color: #ffffff; text-align: center; display: block; padding: 10px; border-radius: 6px;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="header-bar">
            <div class="header-title">
                <h1>Manage Gallery</h1>
            </div>
            <div class="user-menu">
                <span style="font-weight: 500; color: var(--text-dark);"><i class="fa-solid fa-user-tie"></i> Welcome, <?php echo htmlspecialchars($_SESSION['admin_user']); ?></span>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="gallery-single-layout" style="max-width: 800px; margin: 40px auto;">
            <!-- Add Image Form -->
            <div class="form-card" style="margin-bottom: 40px;">
                <h2>Upload Images</h2>
                <div class="upload-dragzone" id="dropzone">
                    <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                    <p>Drag & drop images here or click to browse</p>
                    <span>Supports JPG, JPEG, PNG, WEBP, and GIF (Max 5MB per file)</span>
                    <input type="file" id="image-input" style="display: none;" accept="image/*" multiple>
                </div>
                <div class="upload-file-list" id="file-list"></div>
            </div>

            <!-- Existing Gallery List -->
            <div class="existing-gallery-section">
                <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 1.25rem; color: var(--primary-dark); font-family: var(--font-heading); border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">Current Gallery Images (<?php echo count($gallery_items); ?>)</h2>
                
                <?php if (empty($gallery_items)): ?>
                    <div style="background: white; padding: 30px; text-align: center; border-radius: 10px; border: 1px dashed #d1d5db; color: #6b7280;">
                        <i class="fa-solid fa-images" style="font-size: 3rem; margin-bottom: 10px; color: #9ca3af;"></i>
                        <p>No images in gallery yet. Upload one above!</p>
                    </div>
                <?php else: ?>
                    <div class="gallery-grid-admin">
                        <?php foreach ($gallery_items as $item): ?>
                            <div class="gallery-card-admin">
                                <div class="gallery-card-img-wrapper">
                                    <img src="<?php echo (strpos($item['image_path'], 'http') === 0) ? $item['image_path'] : '../' . $item['image_path']; ?>" alt="<?php echo htmlspecialchars($item['alt_text'] ?? ''); ?>">
                                </div>
                                <div class="gallery-card-body" style="padding: 10px; display: flex; flex-direction: column; justify-content: space-between; align-items: stretch; background: #fff;">
                                    <form action="gallery.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');" style="margin: 0; width: 100%;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="image_id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" class="btn" style="background-color: #ef4444; color: white; border: none; padding: 8px 12px; width: 100%; border-radius: 4px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px;"><i class="fa-solid fa-trash-can"></i> Delete Image</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('image-input');
        const fileList = document.getElementById('file-list');

        // Click to open file explorer
        dropzone.addEventListener('click', () => fileInput.click());

        // Drag and drop handlers
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('dragover');
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }, false);

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length === 0) return;
            
            // Convert to array and process each file
            Array.from(files).forEach(file => {
                // Check if it's an image
                if (!file.type.startsWith('image/')) {
                    alert('Only image files are allowed.');
                    return;
                }
                uploadFile(file);
            });
        }

        function uploadFile(file) {
            // Create list item UI
            const itemId = 'upload-' + Math.random().toString(36).substr(2, 9);
            const itemHtml = `
                <div class="upload-file-item" id="${itemId}">
                    <div class="upload-file-header">
                        <div class="upload-file-info">
                            <i class="fa-regular fa-image" style="color: var(--primary);"></i>
                            <span class="upload-file-name" title="${escapeHtml(file.name)}">${escapeHtml(file.name)}</span>
                        </div>
                        <span class="upload-file-status">Queued</span>
                    </div>
                    <div class="upload-file-progress">
                        <div class="upload-file-progress-bar"></div>
                    </div>
                </div>
            `;
            fileList.insertAdjacentHTML('beforeend', itemHtml);
            const itemEl = document.getElementById(itemId);
            const progressBar = itemEl.querySelector('.upload-file-progress-bar');
            const statusText = itemEl.querySelector('.upload-file-status');

            // Set up form data
            const formData = new FormData();
            formData.append('action', 'add');
            formData.append('ajax', '1');
            formData.append('image', file);

            // AJAX request with XHR to track progress
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'gallery.php', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            // Track progress
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percent + '%';
                    statusText.textContent = percent + '%';
                }
            });

            // Completed handler
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            itemEl.classList.add('success');
                            statusText.textContent = 'Success';
                            // Reload page after a delay to show new images in grid
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            itemEl.classList.add('error');
                            statusText.textContent = response.error || 'Failed';
                        }
                    } catch (e) {
                        itemEl.classList.add('error');
                        statusText.textContent = 'Server Error';
                    }
                } else {
                    itemEl.classList.add('error');
                    statusText.textContent = 'Error ' + xhr.status;
                }
            };

            xhr.onerror = function() {
                itemEl.classList.add('error');
                statusText.textContent = 'Connection Error';
            };

            statusText.textContent = 'Uploading...';
            xhr.send(formData);
        }

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    });
    </script>
</body>
</html>
