-- SQL to create the reviews table

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `rating` INT NOT NULL,
  `review_text` TEXT NOT NULL,
  `package_name` VARCHAR(150) DEFAULT NULL,
  `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  `response_text` TEXT DEFAULT NULL,
  `responded_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SQL to create the admins table and seed the initial admin
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`username`, `password`) VALUES 
('admin', '$2y$10$755Qm3n.hhNXkaL4oz53ZeEAuIxi3Lyh32LhBml2jgBYROYTi2kfy')
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`);
