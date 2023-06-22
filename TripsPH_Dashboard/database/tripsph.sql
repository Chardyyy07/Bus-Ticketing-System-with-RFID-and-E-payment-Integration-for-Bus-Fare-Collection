

-- (don't copy)Database Name: `tripsph`

-- (copy)Table Name: `users` for the users sa admin
SET time_zone = "+08:00";

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- (copy)Data ni tbl_users
INSERT INTO `tbl_users` (`id`, `user_role_id`, `full_name`, `username`, `email`, `mobile`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Anya Forger', 'anyapeanut', 'anya@anya', '911', '$2y$10$EqgwvYW9IeTJFX/FOWpuk.AkFpiOHhzq/j7nqBjy0/AvGTXva4I5W', 1, '2023-06-17 06:42:38', '2023-06-17 06:42:41'),
(2, 2, 'Loid Forger', 'Starlight', 'loid@loid', '911', '$2y$10$bsxUXMaaTJRrjLn07uS/euhBhkz05kr.Pjm4geuGMh8sOGiI.e3aK', 1, '2023-06-17 06:43:39', '2023-06-17 06:43:47'),
(3, 3, 'Yor Forger', 'YorAssassin', 'yor@yor', '911', '$2y$10$Hfbganfaunj54se//hpvEu7s4yTKMdX/2YDeRFcoYKejRsZKD9Mli', 1, '2023-06-17 06:45:37', '2023-06-18 03:18:27');

-- (copy)Table Name: `tbl_user_role` for the role like admin,editor and user only
CREATE TABLE IF NOT EXISTS `tbl_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_user_role` (`id`, `user_role`) VALUES
  (1, 'Admin'),
  (2, 'Editor'),
  (3, 'User Only');


-- (copy)Table Name: `tbl_fare_matrix` for the fare matrix wala pang backend lalagyan ko palang
SET time_zone = "+08:00";

CREATE TABLE `tbl_fare_matrix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(10) DEFAULT NULL,
  `to` varchar(10) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `tbl_landmark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `landmark` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `tbl_load_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rfid` varchar(12) NOT NULL,
  `load` varchar(20) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
