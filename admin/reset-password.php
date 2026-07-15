<?php
session_start();
require_once '../db.php';

// Authentication Check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = isset($_POST['current_password']) ? trim($_POST['current_password']) : '';
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $error = "New password and confirmation password do not match.";
    } elseif (strlen($new_password) < 6) {
        $error = "New password must be at least 6 characters long.";
    } elseif ($pdo) {
        try {
            // Fetch current password hash from database
            $stmt = $pdo->prepare("SELECT password FROM admins WHERE username = ?");
            $stmt->execute([$_SESSION['admin_user']]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($current_password, $admin['password'])) {
                // Update password
                $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $update_stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE username = ?");
                $update_stmt->execute([$new_hash, $_SESSION['admin_user']]);
                
                // End session and redirect
                session_unset();
                session_destroy();
                header("Location: login.php?reset=success");
                exit();
            } else {
                $error = "Incorrect current password.";
            }
        } catch (PDOException $e) {
            $error = "Error updating password: " . $e->getMessage();
        }
    } else {
        $error = "Database connection is not available.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | DST Admin</title>
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
        .reset-card {
            background: #ffffff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            max-width: 500px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #4b5563;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s;
            box-sizing: border-box;
        }
        .form-group input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 79, 92, 0.15);
        }
        .password-wrapper {
            position: relative;
        }
        .password-wrapper input {
            padding-right: 40px !important;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
            z-index: 10;
        }
        .toggle-password:hover {
            color: var(--primary);
        }
        .btn-submit {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background-color: var(--primary-dark);
        }
        .error-banner {
            background-color: #fef2f2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #fca5a5;
            font-size: 0.9rem;
        }
        .success-banner {
            background-color: #f0fdf4;
            color: #15803d;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #bbf7d0;
            font-size: 0.9rem;
        }
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
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
            <li>
                <a href="gallery.php"><i class="fa-solid fa-images"></i> Gallery</a>
            </li>
            <li class="active">
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
                <h1>Reset Password</h1>
            </div>
            <div class="user-menu">
                <span style="font-weight: 500; color: var(--text-dark);"><i class="fa-solid fa-user-tie"></i> Welcome, <?php echo htmlspecialchars($_SESSION['admin_user']); ?></span>
            </div>
        </div>

        <div class="reset-card">
            <?php if (!empty($error)): ?>
                <div class="error-banner">
                    <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="success-banner">
                    <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form action="reset-password.php" method="POST">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
                        <i class="fa-solid fa-eye toggle-password"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="new_password" name="new_password" required autocomplete="new-password">
                        <i class="fa-solid fa-eye toggle-password"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password">
                        <i class="fa-solid fa-eye toggle-password"></i>
                    </div>
                </div>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-save"></i> Update Password</button>
            </form>
        </div>
    </div>

    <script>
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function() {
            const input = this.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
    </script>
</body>
</html>
