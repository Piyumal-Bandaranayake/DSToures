<?php
session_start();
require_once '../db.php';

// Authentication Check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Fetch stats for dashboard
$stats = [
    'total' => 0,
    'pending' => 0,
    'approved' => 0,
    'rejected' => 0
];

if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT status, COUNT(*) as count FROM reviews GROUP BY status");
        while ($row = $stmt->fetch()) {
            if ($row['status'] === 'pending') $stats['pending'] = intval($row['count']);
            if ($row['status'] === 'approved') $stats['approved'] = intval($row['count']);
            if ($row['status'] === 'rejected') $stats['rejected'] = intval($row['count']);
        }
        $stats['total'] = $stats['pending'] + $stats['approved'] + $stats['rejected'];
    } catch (PDOException $e) {
        error_log("Dashboard stats query failed: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Dileep Sanjaya Tours</title>
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
            margin-bottom: 35px;
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #e5e7eb;
        }
        .stat-card.blue { border-color: var(--primary); }
        .stat-card.orange { border-color: var(--accent); }
        .stat-card.green { border-color: var(--secondary); }
        .stat-card.red { border-color: #ef4444; }
        
        .stat-card h3 {
            margin: 0 0 5px 0;
            font-size: 0.9rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-family: var(--font-body);
        }
        .stat-card .number {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-dark);
        }
        .stat-card .icon-box {
            font-size: 2.2rem;
            color: #d1d5db;
        }
        .dashboard-welcome {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
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
            <li class="active">
                <a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            </li>
            <li>
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
                <h1>Overview Dashboard</h1>
            </div>
            <div class="user-menu">
                <span style="font-weight: 500; color: var(--text-dark);"><i class="fa-solid fa-user-tie"></i> Welcome, <?php echo htmlspecialchars($_SESSION['admin_user']); ?></span>
            </div>
        </div>

        <!-- Statistics Widgets -->
        <div class="stats-grid">
            <div class="stat-card blue">
                <div>
                    <h3>Total Reviews</h3>
                    <div class="number"><?php echo $stats['total']; ?></div>
                </div>
                <div class="icon-box"><i class="fa-solid fa-comments"></i></div>
            </div>
            <div class="stat-card orange">
                <div>
                    <h3>Pending Approval</h3>
                    <div class="number"><?php echo $stats['pending']; ?></div>
                </div>
                <div class="icon-box" style="color: var(--accent);"><i class="fa-solid fa-hourglass-half"></i></div>
            </div>
            <div class="stat-card green">
                <div>
                    <h3>Approved Reviews</h3>
                    <div class="number"><?php echo $stats['approved']; ?></div>
                </div>
                <div class="icon-box" style="color: var(--secondary);"><i class="fa-solid fa-circle-check"></i></div>
            </div>
            <div class="stat-card red">
                <div>
                    <h3>Rejected Reviews</h3>
                    <div class="number"><?php echo $stats['rejected']; ?></div>
                </div>
                <div class="icon-box" style="color: #ef4444;"><i class="fa-solid fa-circle-xmark"></i></div>
            </div>
        </div>

        <!-- Welcome Banner -->
        <div class="dashboard-welcome">
            <h2 style="margin-top: 0; color: var(--primary); font-family: var(--font-heading);">Dileep Sanjaya Tours Administration</h2>
            <p style="color: var(--text-muted); margin-bottom: 20px;">Use the sidebar navigation to moderate reviews, toggle approval status, and manage client feedback. Approved reviews automatically appear on the home page testimonials carousel and the public reviews catalog page.</p>
            <a href="reviews.php" class="btn btn-secondary"><i class="fa-solid fa-star"></i> Go to Reviews Moderation</a>
        </div>
    </div>

</body>
</html>
