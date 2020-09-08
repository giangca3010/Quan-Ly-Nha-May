-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 12, 2020 lúc 07:49 PM
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
-- Cơ sở dữ liệu: `zip`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zip13_costcenters`
--

CREATE TABLE `zip13_costcenters` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `_lft` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `_rgt` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `warehouse` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `zip13_costcenters`
--

INSERT INTO `zip13_costcenters` (`id`, `name`, `code`, `slug`, `type`, `_lft`, `_rgt`, `parent_id`, `created_at`, `updated_at`, `user_id`, `warehouse`) VALUES
(1, 'HNI Time City', 'HNI_TC', 'hni-time-city', 'default', 1, 2, NULL, '2019-05-01 14:11:36', '2019-06-26 14:13:35', 1, 'Hà Nội'),
(2, 'HNI Royal City', 'HNI_RC', 'hni-royal-city', 'default', 3, 4, NULL, '2019-05-01 14:11:36', '2019-06-26 14:13:43', 1, 'Hà Nội'),
(3, 'HNI Savico', 'HNI_SVC', 'hni-savico', 'default', 5, 6, NULL, '2019-05-01 14:11:36', '2019-06-26 14:13:51', 1, 'Hà Nội'),
(4, 'HNI IPH', 'HNI_IPH', 'hni-iph', 'default', 7, 8, NULL, '2019-05-01 14:11:36', '2019-06-26 14:14:01', 1, 'Hà Nội'),
(5, 'HNI Phạm Ngọc Thạch', 'HNI_PNT', 'hni-pham-ngoc-thach', 'default', 9, 10, NULL, '2019-05-01 14:11:36', '2019-06-26 14:14:08', 1, 'Hà Nội'),
(6, 'HNI Bắc Từ Liêm', 'HNI_BTL', 'hni-bac-tu-liem', 'default', 11, 12, NULL, '2019-05-01 14:11:36', '2019-06-26 14:14:17', 1, 'Hà Nội'),
(7, 'HNI Mê Linh', 'HNI_ML', 'hni-me-linh', 'default', 13, 14, NULL, '2019-05-01 14:11:36', '2019-06-26 14:14:26', 1, 'Hà Nội'),
(8, 'HCM Thảo Điền', 'HCM_TDN', 'hcm-thao-dien', 'default', 15, 16, NULL, '2019-05-01 14:11:36', '2019-06-26 14:14:37', NULL, 'Hồ Chí Minh'),
(9, 'HCM Quận 9', 'HCM_Q9', 'hcm-quan-9', 'default', 17, 18, NULL, '2019-05-01 14:11:36', '2019-06-26 14:15:14', NULL, 'Hồ Chí Minh'),
(10, 'DNI Biên Hòa', 'DNI_BH', 'dni-bien-hoa', 'default', 19, 20, NULL, '2019-05-01 14:11:36', '2019-06-26 14:15:04', NULL, 'Hồ Chí Minh'),
(11, 'HCM Sư Vạn Hạnh', 'HCM_SVH', 'hcm-su-van-hanh', 'default', 21, 22, NULL, '2019-05-01 14:11:36', '2019-06-26 14:15:23', NULL, 'Hồ Chí Minh'),
(12, 'HCM Thủ Đức', 'HCM_TDC', 'hcm-thu-duc', 'default', 23, 24, NULL, '2019-05-01 14:11:36', '2019-06-26 14:15:33', NULL, 'Hồ Chí Minh'),
(13, 'HCM Phan Văn Trị', 'HCM_PVT', 'hcm-phan-van-tri', 'default', 25, 26, NULL, '2019-05-01 14:11:36', '2019-06-26 14:15:41', NULL, 'Hồ Chí Minh'),
(14, 'HCM Phú Thọ', 'HCM_PT', 'hcm-phu-tho', 'default', 27, 28, NULL, '2019-05-01 14:11:36', '2019-06-26 14:15:48', NULL, 'Hồ Chí Minh'),
(15, 'HCM Phổ Quang', 'HCM_PQG', 'hcm-pho-quang', 'default', 29, 30, NULL, '2019-05-01 14:11:36', '2019-06-26 14:15:56', NULL, 'Hồ Chí Minh'),
(16, 'LAN Vincom Long An', 'LAN_LA', 'lan-vincom-long-an', 'default', 31, 32, NULL, '2019-05-01 14:11:36', '2019-06-26 14:16:09', NULL, 'Miền Nam'),
(17, 'CTO Vincom Xuân Khánh', 'CTO_XK_', 'cto-vincom-xuan-khanh', 'default', 33, 34, NULL, '2019-05-01 14:11:36', '2019-06-26 14:17:10', NULL, 'Miền Nam'),
(18, 'AGG Vincom An Giang', 'AGG_AG', 'agg-vincom-an-giang', 'default', 35, 36, NULL, '2019-05-01 14:11:36', '2019-06-26 14:16:30', NULL, 'Miền Nam'),
(19, 'VLG Vincom Vĩnh Long', 'VLG_VL', 'vlg-vincom-vinh-long', 'default', 37, 38, NULL, '2019-05-01 14:11:36', '2019-06-26 14:17:24', NULL, 'Miền Nam'),
(20, 'KGG Vincom Rạch Giá', 'KGG_RG', 'kgg-vincom-rach-gia', 'default', 39, 40, NULL, '2019-05-01 14:11:36', '2019-06-26 14:17:46', NULL, 'Miền Nam'),
(21, 'CAU Vincom Cà Mau', 'CAU_CM', 'cau-vincom-ca-mau', 'default', 41, 42, NULL, '2019-05-01 14:11:36', '2019-06-26 14:18:04', NULL, 'Miền Nam'),
(22, 'DNG Vincom Đà Nẵng', 'DNG_DN', 'dng-vincom-da-nang', 'default', 43, 44, NULL, '2019-05-01 14:11:36', '2019-06-26 14:18:22', NULL, 'Miền Nam'),
(23, 'KHA Nha Trang', 'KHA_NT', 'kha-nha-trang', 'default', 45, 46, NULL, '2019-05-01 14:11:37', '2019-06-26 14:12:17', NULL, 'Miền Nam'),
(24, 'HUE Vincom Huế', 'HUE', 'hue-vincom-hue', 'default', 47, 48, NULL, '2019-05-01 14:11:37', '2019-06-26 14:12:27', NULL, 'Miền Bắc'),
(25, 'HPG Vincom Hải Phòng', 'HPG_HP', 'hpg-vincom-hai-phong', 'default', 49, 50, NULL, '2019-05-01 14:11:37', '2019-06-26 14:12:37', NULL, 'Miền Bắc'),
(26, 'THA Vincom Thanh Hóa', 'THA_TH', 'tha-vincom-thanh-hoa', 'default', 51, 52, NULL, '2019-05-01 14:11:37', '2019-06-26 14:12:52', NULL, 'Miền Bắc'),
(27, 'TBH Vincom Thái Bình', 'TBH_TB', 'tbh-vincom-thai-binh', 'default', 53, 54, NULL, '2019-05-01 14:11:37', '2019-06-26 14:13:01', NULL, 'Miền Bắc'),
(28, 'HNM Phủ Lý', 'HNM_PL', 'hnm-phu-ly', 'default', 55, 56, NULL, '2019-05-01 14:11:37', '2019-06-26 14:13:09', NULL, 'Miền Bắc'),
(29, 'QNH Vincom Hạ Long', 'QNH_HL', 'qnh-vincom-ha-long', 'default', 57, 58, NULL, '2019-05-01 14:11:37', '2019-06-26 14:13:18', NULL, 'Miền Bắc'),
(30, 'HTH Vincom Hà Tĩnh', 'HTH_HT', 'hth-vincom-ha-tinh', 'default', 59, 60, NULL, '2019-05-01 14:11:37', '2019-06-26 14:13:28', NULL, 'Miền Bắc'),
(31, 'BigC Trường Chinh', 'HCM_BIGC', 'bigc-truong-chinh', 'default', 65, 66, NULL, '2019-05-13 14:15:08', '2019-06-26 14:11:46', NULL, 'Hồ Chí Minh'),
(32, 'Zip Skylake', 'HNI_SSKY', 'zip-skylake', 'default', 63, 64, NULL, '2019-05-13 14:15:08', '2019-06-26 14:11:46', 1, 'Hà Nội'),
(33, 'HCM Quận 7', 'HCM_Q7', 'hcm-quan-7', 'default', 67, 68, NULL, '2019-05-01 14:11:36', '2019-06-26 14:15:14', NULL, 'Hồ Chí Minh'),
(34, 'Vincom 3/2', 'HCM_32', 'vincom-3-2', 'default', 69, 70, NULL, '2019-05-01 14:11:36', '2019-06-26 14:15:14', NULL, 'Hồ Chí Minh'),
(35, 'Bình Dương', 'HCM_BD', 'binh-duong', 'default', 71, 72, NULL, '2019-05-01 14:11:36', '2019-06-26 14:15:14', NULL, 'Hồ Chí Minh'),
(36, 'Vincom Cần Thơ', 'CT_HV', 'vincom-hung-vuong', 'default', 73, 74, NULL, '2019-05-01 14:11:36', '2019-06-26 14:17:46', NULL, 'Miền Nam'),
(37, 'Artermis\r\n', 'HNI_AT', 'Artermis\r\n', 'default', 75, 76, NULL, '2019-05-13 14:15:08', '2019-06-26 14:11:46', 1, 'Hà Nội'),
(38, 'The Garden', 'HNI_TG', 'The-Garden\r\n\r\n', 'default', 77, 78, NULL, '2019-05-13 14:15:08', '2019-06-26 14:11:46', 1, 'Hà Nội');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `zip13_costcenters`
--
ALTER TABLE `zip13_costcenters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zip13_costcenters__lft__rgt_parent_id_index` (`_lft`,`_rgt`,`parent_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `zip13_costcenters`
--
ALTER TABLE `zip13_costcenters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
