-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th5 07, 2024 lúc 04:43 PM
-- Phiên bản máy phục vụ: 5.7.31
-- Phiên bản PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `training_laravel`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `quantity` int(11) NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cartitem_cart_id_foreign` (`cart_id`),
  KEY `cartitem_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `quantity`, `cart_id`, `product_id`, `created_at`, `updated_at`) VALUES
(12, 8, 1, 5, '2023-05-18 20:45:43', '2023-05-18 20:46:06'),
(3, 3, 1, 2, '2023-05-17 00:49:50', '2023-05-18 19:50:58'),
(10, 3, 2, 8, '2023-05-17 02:30:23', '2023-05-17 04:54:34'),
(9, 5, 2, 17, '2023-05-17 02:05:30', '2023-05-17 04:01:41'),
(11, 2, 1, 3, '2023-05-17 22:48:52', '2023-05-18 19:50:23'),
(18, 4, 6, 1, '2023-11-02 01:54:42', '2023-11-02 02:06:47'),
(14, 2, 3, 4, '2023-10-26 23:27:24', '2023-10-27 00:11:23'),
(15, 1, 4, 5, '2023-10-26 23:51:43', '2023-10-26 23:51:43'),
(16, 1, 4, 7, '2023-10-26 23:53:35', '2023-10-26 23:53:35'),
(19, 1, 6, 3, '2023-11-02 01:55:53', '2023-11-02 01:55:53'),
(24, 1, 7, 1, '2023-11-02 10:46:43', '2023-11-02 10:46:43'),
(23, 1, 7, 2, '2023-11-02 10:46:21', '2023-11-03 00:52:45'),
(25, 1, 7, 5, '2023-11-02 10:46:53', '2023-11-02 10:46:53'),
(26, 1, 8, 6, '2023-11-23 09:11:06', '2023-11-23 09:11:06'),
(28, 1, 9, 1, '2023-11-28 20:42:49', '2023-11-28 20:42:49'),
(29, 1, 9, 58, '2023-11-28 22:00:33', '2023-11-28 22:00:33');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
