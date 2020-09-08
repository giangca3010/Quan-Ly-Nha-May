-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 20, 2020 lúc 02:47 PM
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
-- Cấu trúc bảng cho bảng `nguyen_vat_lieu`
--

CREATE TABLE `nguyen_vat_lieu` (
  `id_nvl` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguyen_vat_lieu`
--

INSERT INTO `nguyen_vat_lieu` (`id_nvl`, `name`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Sắt hộp 25x50x1.1 ( mới )', 'CKS25X50X1.1', '', NULL, NULL),
(2, 'Tôn 3.2 ly', 'CKSN3.2', '', NULL, NULL),
(3, 'Tấm cao su 1m6 - 2m dày 2cm', 'DCS', '', NULL, NULL),
(4, 'Tấm cao su 1m8 - 2m dày 2cm', 'DCS8', '', NULL, NULL),
(5, 'Laminate màu trắng mát', 'LM.104MATTE', '', NULL, NULL),
(6, 'Cứng PU_230:046/B-4.50KINC (dùng cho lót)', 'SNCUPU_230:046', '', NULL, NULL),
(7, 'Cứng PU_230:063/B-4.50KINC (dùng cho bóng)', 'SNCUPU_230:063', '', NULL, NULL),
(8, 'Stain Yellow MM01', 'SNMM01', '', NULL, NULL),
(9, 'Stain Cafe MM02', 'SNMM02', '', NULL, NULL),
(10, 'Veneer 3 ly sản xuất loại A', 'VNGA30A', '', NULL, NULL),
(11, 'Veneer 3 ly sản xuất loại B', 'VNGA30B', '', NULL, NULL),
(12, 'Gỗ ghép thanh keo 15 ly', 'VNGK15', '', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `nguyen_vat_lieu`
--
ALTER TABLE `nguyen_vat_lieu`
  ADD PRIMARY KEY (`id_nvl`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `nguyen_vat_lieu`
--
ALTER TABLE `nguyen_vat_lieu`
  MODIFY `id_nvl` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
