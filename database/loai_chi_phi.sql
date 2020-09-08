-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 11, 2020 lúc 03:18 PM
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
-- Cấu trúc bảng cho bảng `loai_chi_phi`
--

CREATE TABLE `loai_chi_phi` (
  `id` int(11) NOT NULL,
  `name_lcp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ma_sp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sl_nk` int(11) DEFAULT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loai_chi_phi`
--

INSERT INTO `loai_chi_phi` (`id`, `name_lcp`, `ma_sp`, `sl_nk`, `note`, `created_at`, `updated_at`) VALUES
(1, 'Chi phí nguyên - vật liệu', NULL, NULL, NULL, '2020-02-07 08:22:48', '2020-02-07 08:22:48'),
(2, 'Chi phí nhân viên phân xưởng', NULL, NULL, NULL, '2020-02-07 08:22:41', '2020-02-07 08:22:41'),
(3, 'Chi phí dụng cụ sản xuất', NULL, NULL, NULL, '2020-02-07 08:22:56', '2020-02-07 08:22:56'),
(4, 'Chi phí khấu hao TSCĐ', NULL, NULL, NULL, '2020-02-07 08:23:04', '2020-02-07 08:23:04'),
(5, 'Chi phí dịch vụ mua ngoài phục vụ sản xuất', NULL, NULL, NULL, '2020-02-07 08:23:16', '2020-02-07 08:23:16'),
(6, 'Chi phí bằng tiền khác phục vụ sản xuất', NULL, NULL, NULL, '2020-02-07 08:23:26', '2020-02-07 08:23:26'),
(7, 'Chi phí vận chuyển mua hàng', NULL, NULL, NULL, '2020-02-07 08:23:36', '2020-02-07 08:23:36'),
(8, 'Chi phí vận chuyển hàng gia công', NULL, NULL, NULL, '2020-02-07 08:23:46', '2020-02-07 08:23:46'),
(9, 'Chi phí nguyên, vật liệu', NULL, NULL, NULL, '2020-02-07 08:22:48', '2020-02-07 08:22:48');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `loai_chi_phi`
--
ALTER TABLE `loai_chi_phi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `loai_chi_phi`
--
ALTER TABLE `loai_chi_phi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
