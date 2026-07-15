<?php
require_once __DIR__ . '/db.php';

if (!$pdo) {
    die("Database connection failed. Please make sure MySQL is running.");
}

try {
    $sql = "
    CREATE TABLE IF NOT EXISTS `admins` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `username` VARCHAR(50) NOT NULL UNIQUE,
      `password` VARCHAR(255) NOT NULL,
      `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

    INSERT INTO `admins` (`username`, `password`) VALUES 
    ('admin', '$2y$10$755Qm3n.hhNXkaL4oz53ZeEAuIxi3Lyh32LhBml2jgBYROYTi2kfy')
    ON DUPLICATE KEY UPDATE `password` = VALUES(`password`);
    ";

    $pdo->exec($sql);
    echo "SUCCESS: Created admins table and seeded default admin!";
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
