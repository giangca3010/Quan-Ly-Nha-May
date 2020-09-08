-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 14, 2020 lúc 03:43 PM
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
-- Cấu trúc bảng cho bảng `chi_phi`
--

CREATE TABLE `chi_phi` (
  `id_cp` int(11) UNSIGNED NOT NULL,
  `name_dx` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_create` int(11) DEFAULT NULL,
  `user_dx` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_phanloai` int(11) DEFAULT NULL,
  `total` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `total_thuc` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `chuy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_duyet` int(11) NOT NULL DEFAULT 0,
  `type` int(11) DEFAULT NULL,
  `id_bank` int(11) DEFAULT NULL,
  `date_need` datetime DEFAULT NULL,
  `date_money` datetime DEFAULT NULL,
  `tam_ung` int(11) DEFAULT NULL,
  `stt` int(11) DEFAULT NULL,
  `con_lai` int(11) DEFAULT NULL,
  `user_duyet` int(11) DEFAULT NULL COMMENT 'người duyệt trước kế toán',
  `user_check` int(11) NOT NULL COMMENT 'người check thông tin',
  `tra_lai` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_phi`
--

INSERT INTO `chi_phi` (`id_cp`, `name_dx`, `user_create`, `user_dx`, `role_id`, `status`, `id_phanloai`, `total`, `total_thuc`, `chuy`, `status_duyet`, `type`, `id_bank`, `date_need`, `date_money`, `tam_ung`, `stt`, `con_lai`, `user_duyet`, `user_check`, `tra_lai`, `created_at`, `updated_at`) VALUES
(2, 'Máy móc', 5, 5, NULL, 1, 2, '780907', '780907', 'tử tế lại', 6, 0, 1, '2020-02-14 06:07:00', '2020-02-14 04:29:00', 780907, 1581679953, 0, 40, 26, 0, '2020-02-14 11:32:33', '2020-02-14 14:23:43'),
(3, 'Máy móc lần 2', 5, 5, NULL, 2, 3, '543543', '543543', 'hihi', 6, NULL, 10, '2020-02-14 04:29:00', '2020-02-14 04:29:00', 543543, 1581690422, 0, NULL, 26, 0, '2020-02-14 14:27:02', '2020-02-14 14:31:02');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chi_phi`
--
ALTER TABLE `chi_phi`
  ADD PRIMARY KEY (`id_cp`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chi_phi`
--
ALTER TABLE `chi_phi`
  MODIFY `id_cp` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
