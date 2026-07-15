<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dileep_tours');

// Admin Configuration
// Default Username: admin
// Default Password: admin123 (hashed below)
define('ADMIN_USER', 'admin');
define('ADMIN_PASS_HASH', '$2y$10$755Qm3n.hhNXkaL4oz53ZeEAuIxi3Lyh32LhBml2jgBYROYTi2kfy'); // password_hash('admin123', PASSWORD_DEFAULT)

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // If the database connection fails, define a fallback or log the error
    error_log("Database connection failed: " . $e->getMessage());
    $pdo = null;
}
