-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 14, 2020 lúc 03:44 PM
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
-- Cấu trúc bảng cho bảng `line_dexuat`
--

CREATE TABLE `line_dexuat` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_chiphi` int(11) NOT NULL,
  `ten` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `so_luong` int(11) NOT NULL,
  `donvi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thanh_tien` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `giamgia` int(11) NOT NULL,
  `soluong_thuc` int(11) DEFAULT NULL,
  `tien_thuc` int(11) DEFAULT NULL,
  `money_thucte` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `line_dexuat`
--

INSERT INTO `line_dexuat` (`id`, `id_chiphi`, `ten`, `so_luong`, `donvi`, `thanh_tien`, `money`, `giamgia`, `soluong_thuc`, `tien_thuc`, `money_thucte`, `content`, `created_at`, `updated_at`) VALUES
(1, 2, 'máy 1', 1, 'cái', '234342', '234342', 0, NULL, NULL, '234342', NULL, '2020-02-14 12:04:28', '2020-02-14 12:04:28'),
(2, 2, 'máy 2', 1, 'cái', '546565', '546565', 0, NULL, NULL, '546565', NULL, '2020-02-14 12:04:28', '2020-02-14 12:04:28'),
(3, 3, 'máy 1', 1, 'cái', '543543', '543543', 0, NULL, NULL, '543543', NULL, '2020-02-14 14:30:05', '2020-02-14 14:30:05');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `line_dexuat`
--
ALTER TABLE `line_dexuat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `line_dexuat`
--
ALTER TABLE `line_dexuat`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
