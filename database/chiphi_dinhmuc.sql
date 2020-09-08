-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 18, 2020 lúc 03:27 PM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `nhamay`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chiphi_dinhmuc`
--

CREATE TABLE `chiphi_dinhmuc` (
  `id` int(11) UNSIGNED NOT NULL,
  `item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `p` int(11) NOT NULL,
  `start_p` date NOT NULL,
  `end_p` date NOT NULL,
  `dm_mua` int(11) NOT NULL,
  `dm_tieuthu` int(11) NOT NULL,
  `dm_khotoithieu` int(11) NOT NULL,
  `dm_ngaymua` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chiphi_dinhmuc`
--

INSERT INTO `chiphi_dinhmuc` (`id`, `item`, `code`, `p`, `start_p`, `end_p`, `dm_mua`, `dm_tieuthu`, `dm_khotoithieu`, `dm_ngaymua`, `created_at`, `updated_at`) VALUES
(1, 'Keo', 'keo502', 2, '2020-01-27', '2020-02-23', 20, 2, 4, 7, NULL, NULL),
(2, 'Keo', 'keo502', 3, '2020-02-24', '2020-03-22', 20, 3, 4, 7, NULL, NULL),
(3, 'Nuoc', 'nuoc', 2, '2020-01-27', '2020-02-23', 40, 1, 2, 7, NULL, NULL),
(4, 'Nuoc', 'nuoc', 3, '2020-02-24', '2020-03-22', 40, 2, 2, 7, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chiphi_dinhmuc`
--
ALTER TABLE `chiphi_dinhmuc`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chiphi_dinhmuc`
--
ALTER TABLE `chiphi_dinhmuc`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
