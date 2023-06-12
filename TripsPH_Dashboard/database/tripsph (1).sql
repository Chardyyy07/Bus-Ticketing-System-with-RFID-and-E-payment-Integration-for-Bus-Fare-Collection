CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_users` (`id`, `user_role_id`, `full_name`, `username`, `email`, `mobile`, `password`, `created_at`, `updated_at`) VALUES
  (1, 1, 'Richard', 'Chardyy', 'richarfloresjohn@gmail.com', '01312312312', '0192023a7bbd73250516f069df18b500', '2020-03-12 16:23:01', '2020-03-12 16:23:01'),
  (2, 1, 'john', 'doe', 'john_doe@example.com', '0112322', '0192023a7bbd73250516f069df18b500', '2020-03-12 16:23:01', '2020-03-12 16:23:01'),
  (3, 2, 'ahsan', 'zameer', 'ahsan@example.com', '03111', '3d68b18bd9042ad3dc79643bde1ff351', '2020-03-12 16:23:01', '2020-03-12 16:23:01'),
  (4, 3, 'sarah', 'khan', 'sarah@example.com', '12312312', 'ec26202651ed221cf8f993668c459d46', '2020-03-12 16:23:01', '2020-03-12 16:23:01'),
  (5, 3, 'salman', 'ahmed', 'salman@example.com', '21312321', '97502267ac1b12468f69c14dd70196e9', '2020-03-12 16:23:01', '2020-03-12 16:23:01');

CREATE TABLE IF NOT EXISTS `tbl_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `tbl_user_role` (`id`, `user_role`) VALUES
  (1, 'Admin'),
  (2, 'Editor'),
  (3, 'User Only');

