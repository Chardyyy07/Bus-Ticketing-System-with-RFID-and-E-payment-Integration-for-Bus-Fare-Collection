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

INSERT INTO `tbl_users` (`id`, `user_role_id`, `full_name`, `username`, `email`, `mobile`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'anya', 'any@', 'anya@anya', '213', '$2y$10$lzu/Jm9qm3sqnfeFjzWXue3PEBlsKMf.PagqdB2QFnQ4lovWl50GW', 1, '2023-06-17 00:33:14', '2023-06-16 16:33:14'),
(2, 1, 'chard', 'chard', 'chard@chard', '2313', '$2y$10$mtO/0fyt5pyhHIStA.79VOyvd6alYidtz8lAl70zbp7xEUmUhmm1W', 1, '2023-06-17 00:33:58', '2023-06-16 16:33:58'),
(3, 1, 'yor', 'yor@yor', 'yor@yor', '123', '$2y$10$ysd3l00wvt45goBszjF2aekb.6z7TcJzW2kvKbk9SY5uGuDYvgvD.', 1, '2023-06-17 00:36:33', '2023-06-16 16:36:33');

CREATE TABLE IF NOT EXISTS `tbl_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_user_role` (`id`, `user_role`) VALUES
  (1, 'Admin'),
  (2, 'Editor'),
  (3, 'User Only');
