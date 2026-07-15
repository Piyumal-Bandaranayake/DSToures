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

// Handle Review Actions (Approve, Reject, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['review_id'])) {
    $action = $_POST['action'];
    $review_id = intval($_POST['review_id']);

    if ($pdo) {
        try {
            if ($action === 'approve') {
                $stmt = $pdo->prepare("UPDATE reviews SET status = 'approved' WHERE id = ?");
                $stmt->execute([$review_id]);
                $message = "Review approved successfully.";
            } elseif ($action === 'reject') {
                $stmt = $pdo->prepare("UPDATE reviews SET status = 'rejected' WHERE id = ?");
                $stmt->execute([$review_id]);
                $message = "Review status changed to rejected.";
            } elseif ($action === 'delete') {
                $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
                $stmt->execute([$review_id]);
                $message = "Review deleted successfully.";
            } elseif ($action === 'reply') {
                $response_text = isset($_POST['response_text']) ? trim($_POST['response_text']) : '';
                $stmt = $pdo->prepare("UPDATE reviews SET response_text = ?, responded_at = NOW() WHERE id = ?");
                $stmt->execute([$response_text, $review_id]);
                $message = "Response saved successfully.";
            }
        } catch (PDOException $e) {
            $error = "Action failed: " . $e->getMessage();
        }
    }
}

// Get filter status from URL
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$valid_filters = ['all', 'pending', 'approved', 'rejected'];
if (!in_array($filter, $valid_filters)) {
    $filter = 'all';
}

// Fetch reviews
$reviews = [];
if ($pdo) {
    try {
        if ($filter === 'all') {
            $stmt = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC");
        } else {
            $stmt = $pdo->prepare("SELECT * FROM reviews WHERE status = ? ORDER BY created_at DESC");
            $stmt->execute([$filter]);
        }
        $reviews = $stmt->fetchAll();
    } catch (PDOException $e) {
        $error = "Failed to fetch reviews: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews | Dileep Sanjaya Tours</title>
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
        
        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }
        .filter-tab {
            padding: 8px 16px;
            background-color: #e5e7eb;
            color: #4b5563;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }
        .filter-tab.active {
            background-color: var(--primary);
            color: #ffffff;
        }
        
        /* Alert Banners */
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

        /* Reviews Table */
        .table-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 12px 14px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.9rem;
        }
        th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.05em;
        }
        tr:hover td {
            background-color: #f9fafb;
        }
        
        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        .badge-pending {
            background-color: #fef3c7;
            color: #d97706;
        }
        .badge-approved {
            background-color: #d1fae5;
            color: var(--secondary-dark);
        }
        .badge-rejected {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .stars-display {
            color: var(--accent);
            white-space: nowrap;
        }

        /* Action Buttons */
        .btn-action {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
        }
        .btn-approve {
            background-color: var(--secondary);
            color: white;
        }
        .btn-approve:hover {
            background-color: var(--secondary-dark);
        }
        .btn-reject {
            background-color: #f59e0b;
            color: white;
        }
        .btn-reject:hover {
            background-color: #d97706;
        }
        .btn-delete:hover {
            background-color: #dc2626;
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
            <li class="active">
                <a href="reviews.php"><i class="fa-solid fa-star"></i> Reviews</a>
            </li>
            <li>
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
                <h1>Review Moderation</h1>
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

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <a href="reviews.php?filter=all" class="filter-tab <?php echo $filter === 'all' ? 'active' : ''; ?>">All</a>
            <a href="reviews.php?filter=pending" class="filter-tab <?php echo $filter === 'pending' ? 'active' : ''; ?>">Pending</a>
            <a href="reviews.php?filter=approved" class="filter-tab <?php echo $filter === 'approved' ? 'active' : ''; ?>">Approved</a>
            <a href="reviews.php?filter=rejected" class="filter-tab <?php echo $filter === 'rejected' ? 'active' : ''; ?>">Rejected</a>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Package</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reviews)): ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">No reviews found matching this filter.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reviews as $rev): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--primary-dark);"><?php echo htmlspecialchars($rev['name']); ?></td>
                                <td><?php echo htmlspecialchars($rev['email']); ?></td>
                                <td>
                                    <div class="stars-display">
                                        <?php for ($i=1; $i<=5; $i++): ?>
                                            <i class="<?php echo $i <= $rev['rating'] ? 'fa-solid' : 'fa-regular'; ?> fa-star" style="font-size: 0.8rem;"></i>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                                <td title="<?php echo htmlspecialchars($rev['review_text']); ?>">
                                    <?php 
                                    $text = htmlspecialchars($rev['review_text']);
                                    echo strlen($text) > 80 ? substr($text, 0, 80) . '...' : $text; 
                                    if (!empty($rev['response_text'])) {
                                        echo '<div style="margin-top: 8px; font-size: 0.82rem; background-color: #f3f4f6; padding: 4px 8px; border-radius: 4px; border-left: 3px solid var(--accent); color: var(--text-dark); white-space: normal;"><i class="fa-solid fa-reply"></i> <strong>Replied:</strong> ' . htmlspecialchars($rev['response_text']) . '</div>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if (!empty($rev['package_name'])): ?>
                                        <span style="font-size: 0.8rem; background-color: #f3f4f6; padding: 2px 6px; border-radius: 4px; color: #4b5563;">
                                            <?php echo htmlspecialchars($rev['package_name']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted); font-size: 0.85rem;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $rev['status']; ?>">
                                        <?php echo $rev['status']; ?>
                                    </span>
                                </td>
                                <td style="font-size: 0.85rem; color: var(--text-muted); white-space: nowrap;">
                                    <?php echo date('Y-m-d H:i', strtotime($rev['created_at'])); ?>
                                </td>
                                <td style="white-space: nowrap;">
                                    <form action="reviews.php?filter=<?php echo $filter; ?>" method="POST" style="display: flex; gap: 6px; align-items: center; margin: 0;">
                                        <input type="hidden" name="review_id" value="<?php echo $rev['id']; ?>">
                                        
                                        <?php if ($rev['status'] !== 'approved'): ?>
                                            <button type="submit" name="action" value="approve" class="btn-action btn-approve" title="Approve Review">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($rev['status'] !== 'rejected'): ?>
                                            <button type="submit" name="action" value="reject" class="btn-action btn-reject" title="Reject Review">
                                                <i class="fa-solid fa-ban"></i>
                                            </button>
                                        <?php endif; ?>

                                        <button type="button" class="btn-action" style="background-color: var(--primary); color: white;" title="Reply to Review" onclick="const row = document.getElementById('reply-form-<?php echo $rev['id']; ?>'); row.style.display = row.style.display === 'none' ? 'table-row' : 'none';">
                                            <i class="fa-solid fa-reply"></i>
                                        </button>

                                        <button type="submit" name="action" value="delete" class="btn-action btn-delete" title="Delete Review" onclick="return confirm('Are you sure you want to permanently delete this review?');">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <tr id="reply-form-<?php echo $rev['id']; ?>" style="display: none; background-color: #f9fafb;">
                                <td colspan="8" style="padding: 15px 20px;">
                                    <form action="reviews.php?filter=<?php echo $filter; ?>" method="POST" style="margin: 0; display: flex; gap: 15px; align-items: flex-end; width: 100%;">
                                        <input type="hidden" name="review_id" value="<?php echo $rev['id']; ?>">
                                        <input type="hidden" name="action" value="reply">
                                        <div style="flex-grow: 1;">
                                            <label style="font-weight: 600; font-size: 0.85rem; color: var(--primary-dark); display: block; margin-bottom: 5px;">Response from Owner:</label>
                                            <textarea name="response_text" rows="2" style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px; font-family: var(--font-body); font-size: 0.9rem;" placeholder="Type response..."><?php echo htmlspecialchars($rev['response_text'] ?? ''); ?></textarea>
                                        </div>
                                        <div style="display: flex; gap: 10px; margin-bottom: 5px;">
                                            <button type="submit" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.85rem; border-radius: 4px; cursor: pointer; white-space: nowrap;"><i class="fa-solid fa-paper-plane"></i> Save Response</button>
                                            <button type="button" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.85rem; border-radius: 4px; cursor: pointer; white-space: nowrap;" onclick="document.getElementById('reply-form-<?php echo $rev['id']; ?>').style.display='none'"><i class="fa-solid fa-xmark"></i> Cancel</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
