-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 20, 2020 lúc 08:38 PM
-- Phiên bản máy phục vụ: 10.3.16-MariaDB
-- Phiên bản PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `test`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `target`
--

CREATE TABLE `target` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_nvl` int(11) NOT NULL,
  `dm_tieuthu` int(11) NOT NULL,
  `p` int(11) NOT NULL,
  `t` int(11) NOT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `target`
--

INSERT INTO `target` (`id`, `id_nvl`, `dm_tieuthu`, `p`, `t`, `start`, `end`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 1, '2020-01-27', '2020-02-02', '2020-02-20 18:52:07', '2020-02-20 18:52:07'),
(2, 1, 2, 2, 2, '2020-02-03', '2020-02-09', '2020-02-20 18:52:07', '2020-02-20 18:52:07'),
(3, 1, 1, 2, 3, '2020-02-10', '2020-02-16', '2020-02-20 18:52:07', '2020-02-20 18:52:07'),
(4, 1, 1, 2, 4, '2020-02-17', '2020-02-23', '2020-02-20 18:52:07', '2020-02-20 18:52:07'),
(5, 1, 3, 3, 1, '2020-02-24', '2020-03-01', '2020-02-20 18:53:49', '2020-02-20 18:53:49'),
(6, 1, 2, 3, 2, '2020-03-02', '2020-03-08', '2020-02-20 18:53:49', '2020-02-20 18:53:49'),
(7, 1, 1, 3, 3, '2020-03-09', '2020-03-15', '2020-02-20 18:53:49', '2020-02-20 18:53:49'),
(8, 1, 1, 3, 4, '2020-03-16', '2020-03-22', '2020-02-20 18:53:49', '2020-02-20 18:53:49'),
(17, 3, 1, 2, 1, '2020-01-27', '2020-02-02', '2020-02-20 19:03:32', '2020-02-20 19:03:32'),
(18, 3, 2, 2, 2, '2020-02-03', '2020-02-09', '2020-02-20 19:03:32', '2020-02-20 19:03:32'),
(19, 3, 3, 2, 3, '2020-02-10', '2020-02-16', '2020-02-20 19:03:32', '2020-02-20 19:03:32'),
(20, 3, 4, 2, 4, '2020-02-17', '2020-02-23', '2020-02-20 19:03:32', '2020-02-20 19:03:32'),
(21, 2, 1, 2, 1, '2020-01-27', '2020-02-02', '2020-02-20 19:38:07', '2020-02-20 19:38:07'),
(22, 2, 1, 2, 2, '2020-02-03', '2020-02-09', '2020-02-20 19:38:07', '2020-02-20 19:38:07'),
(23, 2, 1, 2, 3, '2020-02-10', '2020-02-16', '2020-02-20 19:38:07', '2020-02-20 19:38:07'),
(24, 2, 1, 2, 4, '2020-02-17', '2020-02-23', '2020-02-20 19:38:07', '2020-02-20 19:38:07');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `target`
--
ALTER TABLE `target`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `target`
--
ALTER TABLE `target`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
