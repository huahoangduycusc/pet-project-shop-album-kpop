-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 14, 2020 lúc 01:58 PM
-- Phiên bản máy phục vụ: 10.4.8-MariaDB
-- Phiên bản PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shop389`
--
CREATE DATABASE IF NOT EXISTS `shop389` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `shop389`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blockuser`
--

CREATE TABLE `blockuser` (
  `block_id` int(11) NOT NULL,
  `lydo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ngayhethan` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(29, 'LIGHTSTICK'),
(30, 'ALBUMS'),
(31, 'GOODS');

--
-- Bẫy `category`
--
DELIMITER $$
CREATE TRIGGER `del_category` BEFORE DELETE ON `category` FOR EACH ROW DELETE FROM product 
WHERE category_id = old.category_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment_photo`
--

CREATE TABLE `comment_photo` (
  `photo_id` int(11) NOT NULL,
  `photo_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `fb_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `fb_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `seen` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `feedback`
--

INSERT INTO `feedback` (`fb_id`, `title`, `description`, `email`, `fb_date`, `user_id`, `seen`) VALUES
(3, 'Test gửi feedback', '3434', 'hhduya18138@cusc.ctu.edu.vn', '2020-01-02 04:11:04', 28, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `forum_chuyenmuc`
--

CREATE TABLE `forum_chuyenmuc` (
  `forum_id` int(11) NOT NULL,
  `forum_name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `forum_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_quyenhan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `forum_chuyenmuc`
--

INSERT INTO `forum_chuyenmuc` (`forum_id`, `forum_name`, `forum_desc`, `forum_quyenhan`) VALUES
(1, 'Thông Báo', 'Nơi cập nhật những thông tin mới nhất từ BQT', 9),
(2, 'Góp ý - Hỏi Đáp', 'Bạn có góp ý gì hay có bất cứ câu hỏi nào hãy đăng bài tại đây chúng tôi sẽ giải đáp', 0),
(3, 'Xử Lý Vi Phạm', 'Xử lý những trường hợp vi phạm khi tham gia diễn đàn.', 0),
(4, 'Góc Thảo Luận K-POP', 'Chuyên mục thảo luận chung về các nhóm nhạc K-POP hiện nay.', 0),
(5, 'Blog Radio', 'Chia sẻ và lắng nghe và tâm sự của bạn.', 0),
(6, 'Trai Tài Gái Sắc', 'Góc giao lưu tâm sự, chia sẻ những hình ảnh của mình tại đây.', 0),
(8, 'Goods K-Pop', 'Góc thảo luận các sản phẩm của các thần tượng K-POPs.', 0),
(9, 'Chém Gió Thôn', 'Góc tán gẫu, trò chuyện, chém gió chuyện trên trời dưới đất!', 0);

--
-- Bẫy `forum_chuyenmuc`
--
DELIMITER $$
CREATE TRIGGER `del_chuyenmuc` BEFORE DELETE ON `forum_chuyenmuc` FOR EACH ROW DELETE FROM `forum_topic` 
WHERE `forum_id` = old.forum_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `forum_topic`
--

CREATE TABLE `forum_topic` (
  `topic_id` int(11) NOT NULL,
  `topic_name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `topic_time` int(11) NOT NULL,
  `topic_view` int(11) NOT NULL,
  `topic_chuy` int(1) NOT NULL,
  `topic_chuy_1` int(11) NOT NULL,
  `topic_ghim` int(1) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `forum_topic`
--

INSERT INTO `forum_topic` (`topic_id`, `topic_name`, `topic_time`, `topic_view`, `topic_chuy`, `topic_chuy_1`, `topic_ghim`, `forum_id`, `user_id`) VALUES
(31, 'Thông báo mở diễn đàn thảo luận KPOP', 1579006681, 103, 2, 1579233737, 1, 1, 27),
(32, 'V/v Quy định khi đăng bài trên diễn đàn !', 1579001843, 9, 1, 1579261043, 0, 1, 27),
(33, 'Hỏi về việc mua đồ trên shop', 1579006264, 20, 0, 1579264416, 0, 2, 29),
(34, 'Về lightstick của BLACKPINK', 1579005365, 1, 0, 1579264565, 0, 8, 28),
(35, 'hướng dẫn khi mua đồ trên SHOP 389', 1579005465, 1, 0, 1579264665, 0, 2, 28),
(36, 'BTS sắp comeback vào tháng 2 năm nay', 1579005492, 1, 0, 1579264692, 0, 4, 28),
(37, 'Cần nhượng lại album của twice', 1579005559, 2, 0, 1579264759, 0, 8, 30);

--
-- Bẫy `forum_topic`
--
DELIMITER $$
CREATE TRIGGER `del _topic_comment` BEFORE DELETE ON `forum_topic` FOR EACH ROW DELETE FROM topic_comment 
WHERE topic_id = old.topic_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_topic_theodoi` BEFORE DELETE ON `forum_topic` FOR EACH ROW DELETE FROM `topic_theodoi` 
WHERE topic_id = old.topic_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giftcode`
--

CREATE TABLE `giftcode` (
  `code_id` int(11) NOT NULL,
  `giftcode` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `discount` int(11) NOT NULL,
  `fromday` datetime NOT NULL,
  `today` datetime NOT NULL,
  `sudung` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `giftcode`
--

INSERT INTO `giftcode` (`code_id`, `giftcode`, `discount`, `fromday`, `today`, `sudung`) VALUES
(3, 'Gxd28j!f1M1577885589', 200002, '2020-01-01 00:00:00', '2020-01-04 00:00:00', 28);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `idols`
--

CREATE TABLE `idols` (
  `idol_id` int(11) NOT NULL,
  `idol_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `idol_photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `idols`
--

INSERT INTO `idols` (`idol_id`, `idol_name`, `idol_photo`) VALUES
(11, 'RED VELVET', 'photo/idols/191229151513.jpg'),
(12, 'EXO', 'photo/idols/191229151522.jpg'),
(13, 'SNSD', 'photo/idols/191229151527.jpg'),
(14, 'BTS', 'photo/idols/200102180137.jpg'),
(15, 'BLACKPINK', 'photo/idols/200102180147.jpg'),
(16, 'T-ARA', 'photo/idols/200102180201.jpg');

--
-- Bẫy `idols`
--
DELIMITER $$
CREATE TRIGGER `idol_del` BEFORE DELETE ON `idols` FOR EACH ROW DELETE FROM product 
WHERE idol_id = old.idol_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `fullname` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `order_date` datetime NOT NULL,
  `status` int(2) NOT NULL,
  `ship_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_price` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `method_ship_id` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `lastupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`order_id`, `fullname`, `phone`, `order_date`, `status`, `ship_address`, `total_price`, `user_id`, `method_ship_id`, `admin`, `lastupdate`) VALUES
(38, 'hứa hoàng duy', '0777448997', '2020-01-01 22:01:56', 0, '2322222222223', 970000, 27, 3, 0, '2020-01-01 10:01:56'),
(39, 'hứa hoàng duy', '0777448997', '2020-01-01 22:06:22', 0, '2323232323', 1050000, 27, 6, 0, '2020-01-01 10:06:22'),
(40, 'hứa hoàng duy', '2232323', '2020-01-01 22:10:21', 0, '23232323', 399000, 27, 1, 0, '2020-01-01 10:10:21'),
(41, 'hứa hoàng duy', '0777448997', '2020-01-01 22:26:16', 0, 'fgfgdgdgdgf', 250000, 27, 1, 0, '2020-01-01 10:26:16'),
(42, 'hứa hoàng duy', 'êr', '2020-01-02 11:41:05', 0, 'ưerewrwrewr', 889500, 28, 3, 0, '2020-01-02 11:41:05'),
(44, 'hứa hoàng duy', 'qwqwq', '2020-01-02 18:07:41', 0, 'wwqwqwqw', 237500, 28, 1, 0, '2020-01-02 06:07:41'),
(45, 'hứa hoàng duy', '0777448997', '2020-01-02 18:08:08', 0, 'sdsdsdsdsd', 550000, 28, 4, 0, '2020-01-02 06:08:08'),
(46, 'hứa hoàng duy', '0777448997', '2020-01-02 22:35:34', 2, 'test mua hàng nhanh.....................', 459500, 28, 3, 28, '2020-01-02 10:36:10'),
(49, 'hứa hoàng duy', '0777448997', '2020-01-03 18:07:48', 0, 'test mua hàng nhanh............', 1067500, 28, 3, 0, '2020-01-03 06:07:48'),
(50, 'hứa hoàng duy', '0777448997', '2020-01-03 18:10:47', 0, 'test mua nhanh', 450000, 28, 1, 0, '2020-01-03 06:10:47'),
(51, 'hứa hoàng duy', '0777448997', '2020-01-03 18:12:31', 0, 'test mua sản phẩm giỏ hàng........', 630000, 28, 3, 0, '2020-01-03 06:12:31'),
(52, 'hứa hoàng duy', '0777448997', '2020-01-04 17:04:23', 0, '2334343', 940000, 28, 3, 0, '2020-01-04 05:04:23'),
(53, 'hứa hoàng duy', '0777448997', '2020-01-04 17:30:49', 0, 'eweeweweweew', 349998, 28, 4, 0, '2020-01-04 05:30:49'),
(55, 'hứa hoàng duy', '0777448997', '2020-01-05 11:07:49', 0, 'test mua hàng.............', 840000, 28, 4, 0, '2020-01-05 11:07:49'),
(56, 'hứa hoàng duy', '0777448997', '2020-01-10 19:03:24', 1, 'test mua hàng........', 270000, 28, 3, 27, '2020-01-11 11:28:29');

--
-- Bẫy `order`
--
DELIMITER $$
CREATE TRIGGER `del_order` BEFORE DELETE ON `order` FOR EACH ROW DELETE FROM orderdetails 
WHERE order_id = old.order_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderdetails`
--

CREATE TABLE `orderdetails` (
  `details_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orderdetails`
--

INSERT INTO `orderdetails` (`details_id`, `product_id`, `order_id`, `quantity`, `price`) VALUES
(26, 46, 38, 2, 450000),
(27, 45, 39, 2, 450000),
(28, 24, 40, 1, 399000),
(29, 41, 41, 1, 250000),
(30, 35, 42, 1, 430000),
(31, 36, 42, 1, 389500),
(33, 25, 44, 1, 237500),
(34, 44, 45, 1, 450000),
(35, 36, 46, 1, 389500),
(38, 50, 49, 5, 199500),
(39, 49, 50, 1, 450000),
(40, 41, 51, 1, 100000),
(41, 48, 51, 2, 230000),
(42, 24, 52, 1, 420000),
(43, 45, 52, 1, 450000),
(44, 42, 53, 1, 450000),
(46, 32, 55, 2, 140000),
(47, 48, 55, 2, 230000),
(48, 41, 56, 2, 100000);

--
-- Bẫy `orderdetails`
--
DELIMITER $$
CREATE TRIGGER `del_details` BEFORE DELETE ON `orderdetails` FOR EACH ROW UPDATE `product` SET `quantity` = `quantity` + old.quantity
WHERE `product_id` = old.product_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `photo`
--

CREATE TABLE `photo` (
  `photo_id` int(11) NOT NULL,
  `photo_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `photo`
--

INSERT INTO `photo` (`photo_id`, `photo_name`, `product_id`) VALUES
(13, 'photo/product/1912302135500.jpg', 22),
(14, 'photo/product/1912302139200.jpg', 23),
(17, 'photo/product/1912302148180.jpg', 24),
(18, 'photo/product/1912302148181.jpg', 24),
(19, 'photo/product/1912302148182.jpg', 24),
(20, 'photo/product/1912302155570.jpg', 25),
(21, 'photo/product/1912302203150.jpg', 26),
(22, 'photo/product/1912302211220.jpg', 27),
(23, 'photo/product/1912302212530.jpg', 28),
(24, 'photo/product/1912302214030.jpg', 29),
(25, 'photo/product/1912302216060.jpg', 30),
(26, 'photo/product/1912302216350.jpg', 31),
(27, 'photo/product/1912302217510.jpg', 32),
(28, 'photo/product/1912311111440.jpg', 33),
(29, 'photo/product/1912311112200.jpg', 34),
(30, 'photo/product/1912311113010.jpg', 35),
(31, 'photo/product/1912311114540.jpg', 36),
(32, 'photo/product/1912311115320.jpg', 37),
(38, 'photo/product/2001011808330.jpg', 41),
(39, 'photo/product/2001011809390.jpg', 42),
(40, 'photo/product/2001011809480.jpg', 43),
(41, 'photo/product/2001011809590.jpg', 44),
(42, 'photo/product/2001011810070.jpg', 45),
(43, 'photo/product/2001011810170.jpg', 46),
(44, 'photo/product/2001031104080.jpg', 47),
(45, 'photo/product/2001031104081.jpg', 47),
(46, 'photo/product/2001031104082.jpg', 47),
(47, 'photo/product/2001031108350.jpg', 48),
(48, 'photo/product/2001031108351.jpg', 48),
(49, 'photo/product/2001031108352.jpg', 48),
(50, 'photo/product/2001031801020.jpg', 49),
(51, 'photo/product/2001031801021.jpg', 49),
(52, 'photo/product/2001031801022.jpg', 49),
(53, 'photo/product/2001031803480.jpg', 50),
(54, 'photo/product/2001031803481.jpg', 50),
(55, 'photo/product/2001031803482.jpg', 50);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_price` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `lastdate` datetime NOT NULL,
  `quantity` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `idol_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `description`, `lastdate`, `quantity`, `sale_id`, `category_id`, `idol_id`, `supplier_id`) VALUES
(22, 'Girls Generation Official Fanlight (Lightstick)', 600000, 'Introducing Red Velvet\'s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2019-12-30 09:35:50', 10, 5, 29, 13, 2),
(23, 'Girls Generation Handy Fan', 300000, 'Introducing Girls Generation mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power', '2019-12-30 09:39:20', 15, 5, 31, 13, 2),
(24, 'Pre - Order - Red Velvet The ReVe Festival', 420000, '&lt;TRACK LIST&gt; \r\n\r\n01 Psycho \r\n\r\n02 In &amp; Out \r\n\r\n03 Remember Forever \r\n\r\n04 눈 맞추고, 손 맞대고 (EyesLocked, Hands Locked) \r\n\r\n05 Ladies Night \r\n\r\n06 Jumpin\r\n\r\n07 Love Is The Way  \r\n\r\n08 카풀 (Carpool) \r\n\r\n09 음파음파 (Umpah Umpah) \r\n\r\n10 LP \r\n\r\n11 안녕, 여름 (Parade) \r\n\r\n12 친구가 아냐 (Bing Bing) \r\n\r\n13 Milkshake \r\n\r\n14 Sunny Side Up! \r\n\r\n15 짐살라빔 (Zimzalabim) \r\n\r\n16 La Rouge (Special Track) \r\n\r\n&lt;ALBUM SPEC&gt;\r\n\r\n \r\n**TBD \r\n\r\n1.Cover \r\n\r\n- 2 versions (Green ver. / Pink ver.) \r\n\r\n2. Booklet  \r\n\r\n-1ea (176p) \r\n\r\n3. Member Handwriting Postcard \r\n\r\n-1ea (Random 1 out of 5) \r\n\r\n4. Photo Card \r\n\r\n-1ea (Random 1 out of 10) \r\n\r\n5. Poster (folded) **Only for the initial order \r\n\r\n&lt;h2&gt;-1ea (Random 1 out of 6: Group 1 / Member 5) &lt;/h2&gt;\r\n\r\n \r\n• All Pre - Order - Red Velvet Mini Album The ReVe Festival Finale (Finale Ver.) will begin shipping starting 1/6/20.\r\n\r\n• Order Processing Time: (1-3 days, 3-5 days during high volume) after order confirmation. Make sure your address is in English at check-out. \r\n', '2020-01-01 06:11:08', 0, 5, 30, 11, 2),
(25, 'Forever Young Album BlackPink 3Th', 250000, 'One of two covers (Green Ver. and Pink Ver.) will be supplied at random. \r\n\r\nThe album includes 1 booklet (176p), 1 member handwriting postcard (random 1 out of 5), 1 photo card (random 1), and 1 poster (folded, random 1 out of 6). \r\n\r\n\r\n&lt;TRACK LIST&gt; \r\n\r\n01 Psycho \r\n\r\n02 In &amp; Out \r\n\r\n03 Remember Forever \r\n\r\n04 눈 맞추고, 손 맞대고 (EyesLocked, Hands Locked) \r\n\r\n05 Ladies Night \r\n\r\n06 Jumpin\r\n\r\n07 Love Is The Way  \r\n\r\n08 카풀 (Carpool) \r\n\r\n09 음파음파 (Umpah Umpah) \r\n\r\n10 LP \r\n\r\n11 안녕, 여름 (Parade) \r\n\r\n12 친구가 아냐 (Bing Bing) \r\n\r\n13 Milkshake \r\n\r\n14 Sunny Side Up! \r\n\r\n15 짐살라빔 (Zimzalabim) \r\n\r\n16 La Rouge (Special Track) \r\n\r\n&lt;ALBUM SPEC&gt;\r\n\r\n \r\n**TBD \r\n\r\n1.Cover \r\n\r\n- 2 versions (Green ver. / Pink ver.) \r\n\r\n2. Booklet  \r\n\r\n-1ea (176p) \r\n\r\n3. Member Handwriting Postcard \r\n\r\n-1ea (Random 1 out of 5) \r\n\r\n4. Photo Card \r\n\r\n-1ea (Random 1 out of 10) \r\n\r\n5. Poster (folded) **Only for the initial order \r\n\r\n-1ea (Random 1 out of 6: Group 1 / Member 5) \r\n\r\n \r\n• All Pre - Order - Red Velvet Mini Album The ReVe Festival Finale (Finale Ver.) will begin shipping starting 1/6/20.\r\n\r\n• Order Processing Time: (1-3 days, 3-5 days during high volume) after order confirmation. Make sure your address is in English at check-out. \r\n\r\n• Notice: Pre-Orders have a strict no cancellation policy', '2020-01-02 06:05:16', 11, 5, 30, 15, 5),
(26, 'Red Velvet Fanlight (Lightstick) 2019', 340000, 'Introducing Red Velvets mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2019-12-30 10:03:15', 10, 5, 29, 11, 2),
(27, 'BLACKPINK Fanlight 2019 (Lightstick)', 370000, 'Introducing Red Velvet&#039;s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2020-01-02 06:06:18', 11, 5, 29, 15, 5),
(28, 'Lightsick BigBang 2019 (Fanlight) Version 3', 450000, 'Introducing Red Velvet&#039;s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2019-12-30 10:12:53', 1, 5, 29, 12, 5),
(29, 'ARMY BOMB version 4 BTS Lightstick', 560000, 'Introducing Red Velvet&#039;s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2020-01-02 06:06:03', 1, 5, 29, 14, 6),
(30, 'Lightstick KPOP GOT7 GROUP 2019 Version 1', 320000, 'Introducing Red Velvet&#039;s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2020-01-05 11:05:22', 10, 5, 29, 11, 2),
(31, 'Lightstick KPOP 2NE1  GROUP 2019 Version 4', 230000, 'Introducing Red Velvet&#039;s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2020-01-05 11:05:40', 5, 1, 29, 12, 2),
(32, 'Lightstick KPOP EXO GROUP 2019 Version 3', 140000, 'Introducing Red Velvet&#039;s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2020-01-05 11:07:18', 8, 5, 29, 12, 2),
(33, 'Lightstick KPOP BOY Supper Junior 2019 Version 1', 340000, 'Introducing Red Velvet&#039;s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2020-01-05 11:04:39', 2, 5, 29, 12, 2),
(34, 'Lightstick KPOP GIRL GROUP ITZY 2019 Version 2', 340000, 'Introducing Red Velvet&#039;s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2020-01-05 11:04:19', 2, 5, 29, 13, 3),
(35, 'Lightstick KPOP G-DLE GROUP 2019 Version 1', 430000, 'Introducing Red Velvet&#039;s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2020-01-05 11:03:30', 1, 1, 29, 11, 3),
(36, 'Lightstick KPOP EXTRO GROUP 2019 Version 1', 410000, 'Introducing Red Velvet&#039;s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2020-01-05 11:03:49', 1, 5, 29, 13, 2),
(37, 'Lightstick KPOP BOY GROUP 2019 Version 1', 380000, 'Introducing Red Velvet&#039;s mini handheld electric fan. It is small enough to take everywhere and can keep you cool on a hot/humid day.\r\n\r\nContent\r\n- Fan body, wrist strap, and USB charging cable\r\n- Three-stage wind speed control function\r\n- Up to 8 hours of operation with 2,200mAh high capacity battery\r\n- Rechargeable with USB port\r\n- Comes with a random sticker\r\n\r\nHow it works\r\n- When the handle operation button is pressed once, the fan operates at low speed. Press once more for medium speed. Press again for high speed. Press one last time to turn off the power.', '2020-01-05 11:02:50', 3, 5, 29, 11, 2),
(41, 'Pre - Order Album Love Your self 2019 BTS', 100000, '&lt;TRACK LIST&gt; \r\n\r\n1. Starry Night (Feat. Crush) \r\n\r\n2. Black \r\n\r\n3. Butterfly \r\n\r\n4. I Don’t Mind \r\n\r\n5. 보여 (Think About You) \r\n\r\n6. 말린 장미 (Dry Flower) \r\n\r\n \r\n\r\n&lt;ALBUM SPEC&gt; \r\n\r\n1. Cover \r\n\r\n-1 version \r\n\r\n2. Booklet \r\n\r\n-1ea (80p) \r\n\r\n3. Poster **Only for the initial order \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n3. Postcard \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n4. Photo Card  \r\n\r\n-1ea (Random 1 out of 4) \r\n\r\n \r\n\r\n• All Pre-Orders for BoA The 2nd Mini Album ‘Starry Night’ (Album + Unfolded Poster) will begin shipping starting 12/23/19.\r\n\r\n• Order Processing Time: (1-3 days, 3-5 days during high volume) after order confirmation. Make sure your address is in English at check-out. ', '2020-01-02 06:21:07', 2, 1, 30, 14, 6),
(42, 'Pre - Order Album You are GOT7 2019', 450000, '&lt;TRACK LIST&gt; \r\n\r\n1. Starry Night (Feat. Crush) \r\n\r\n2. Black \r\n\r\n3. Butterfly \r\n\r\n4. I Don’t Mind \r\n\r\n5. 보여 (Think About You) \r\n\r\n6. 말린 장미 (Dry Flower) \r\n\r\n \r\n\r\n&lt;ALBUM SPEC&gt; \r\n\r\n1. Cover \r\n\r\n-1 version \r\n\r\n2. Booklet \r\n\r\n-1ea (80p) \r\n\r\n3. Poster **Only for the initial order \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n3. Postcard \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n4. Photo Card  \r\n\r\n-1ea (Random 1 out of 4) \r\n\r\n \r\n\r\n• All Pre-Orders for BoA The 2nd Mini Album ‘Starry Night’ (Album + Unfolded Poster) will begin shipping starting 12/23/19.\r\n\r\n• Order Processing Time: (1-3 days, 3-5 days during high volume) after order confirmation. Make sure your address is in English at check-out. ', '2020-01-02 06:20:43', 1, 1, 30, 12, 2),
(43, 'Pre - Order Album Love Your self 2019 BTS', 450000, '&lt;TRACK LIST&gt; \r\n\r\n1. Starry Night (Feat. Crush) \r\n\r\n2. Black \r\n\r\n3. Butterfly \r\n\r\n4. I Don’t Mind \r\n\r\n5. 보여 (Think About You) \r\n\r\n6. 말린 장미 (Dry Flower) \r\n\r\n \r\n\r\n&lt;ALBUM SPEC&gt; \r\n\r\n1. Cover \r\n\r\n-1 version \r\n\r\n2. Booklet \r\n\r\n-1ea (80p) \r\n\r\n3. Poster **Only for the initial order \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n3. Postcard \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n4. Photo Card  \r\n\r\n-1ea (Random 1 out of 4) \r\n\r\n \r\n\r\n• All Pre-Orders for BoA The 2nd Mini Album ‘Starry Night’ (Album + Unfolded Poster) will begin shipping starting 12/23/19.\r\n\r\n• Order Processing Time: (1-3 days, 3-5 days during high volume) after order confirmation. Make sure your address is in English at check-out. ', '2020-01-02 06:20:12', 2, 1, 30, 12, 2),
(44, 'Pre - Order  Gee Single Girl Generation 2012', 450000, '&lt;TRACK LIST&gt; \r\n\r\n1. Starry Night (Feat. Crush) \r\n\r\n2. Black \r\n\r\n3. Butterfly \r\n\r\n4. I Don’t Mind \r\n\r\n5. 보여 (Think About You) \r\n\r\n6. 말린 장미 (Dry Flower) \r\n\r\n \r\n\r\n&lt;ALBUM SPEC&gt; \r\n\r\n1. Cover \r\n\r\n-1 version \r\n\r\n2. Booklet \r\n\r\n-1ea (80p) \r\n\r\n3. Poster **Only for the initial order \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n3. Postcard \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n4. Photo Card  \r\n\r\n-1ea (Random 1 out of 4) \r\n\r\n \r\n\r\n• All Pre-Orders for BoA The 2nd Mini Album ‘Starry Night’ (Album + Unfolded Poster) will begin shipping starting 12/23/19.\r\n\r\n• Order Processing Time: (1-3 days, 3-5 days during high volume) after order confirmation. Make sure your address is in English at check-out. ', '2020-01-03 06:04:29', 1, 1, 30, 13, 2),
(45, 'Pre - Order Album Feel Special 2019 Twice', 450000, '&lt;TRACK LIST&gt; \r\n\r\n1. Starry Night (Feat. Crush) \r\n\r\n2. Black \r\n\r\n3. Butterfly \r\n\r\n4. I Don’t Mind \r\n\r\n5. 보여 (Think About You) \r\n\r\n6. 말린 장미 (Dry Flower) \r\n\r\n \r\n\r\n&lt;ALBUM SPEC&gt; \r\n\r\n1. Cover \r\n\r\n-1 version \r\n\r\n2. Booklet \r\n\r\n-1ea (80p) \r\n\r\n3. Poster **Only for the initial order \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n3. Postcard \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n4. Photo Card  \r\n\r\n-1ea (Random 1 out of 4) \r\n\r\n \r\n\r\n• All Pre-Orders for BoA The 2nd Mini Album ‘Starry Night’ (Album + Unfolded Poster) will begin shipping starting 12/23/19.\r\n\r\n• Order Processing Time: (1-3 days, 3-5 days during high volume) after order confirmation. Make sure your address is in English at check-out. ', '2020-01-03 10:02:52', 0, 1, 30, 16, 2),
(46, 'Pre - Order Album I Need U Girl 2013 BTS', 450000, '&lt;TRACK LIST&gt; \r\n\r\n1. Starry Night (Feat. Crush) \r\n\r\n2. Black \r\n\r\n3. Butterfly \r\n\r\n4. I Don’t Mind \r\n\r\n5. 보여 (Think About You) \r\n\r\n6. 말린 장미 (Dry Flower) \r\n\r\n \r\n\r\n&lt;ALBUM SPEC&gt; \r\n\r\n1. Cover \r\n\r\n-1 version \r\n\r\n2. Booklet \r\n\r\n-1ea (80p) \r\n\r\n3. Poster **Only for the initial order \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n3. Postcard \r\n\r\n-1ea (Random 1 out of 2) \r\n\r\n4. Photo Card  \r\n\r\n-1ea (Random 1 out of 4) \r\n\r\n \r\n\r\n• All Pre-Orders for BoA The 2nd Mini Album ‘Starry Night’ (Album + Unfolded Poster) will begin shipping starting 12/23/19.\r\n\r\n• Order Processing Time: (1-3 days, 3-5 days during high volume) after order confirmation. Make sure your address is in English at check-out. ', '2020-01-02 06:19:54', 1, 1, 30, 14, 2),
(47, 'Red Velvet Voice Key Chain from 2nd Concert', 120000, 'Enjoy this collectible voice key chain from Red Velvet’s 2nd Tour – REDMARE. You have the option to choose from individual members.\r\n\r\nContent + Care\r\n- Voice Key Chain(1ea) + Photo Card(1ea)\r\n- Size : 4.7 X 4.7 (CM)\r\n- Material: Brass, PVC, Rubber\r\n\r\n*Battery included(MSDS Document included)”', '2020-01-03 11:04:08', 11, 1, 31, 11, 2),
(48, 'Korea&#039;s Exclusive Product: Red Velvet Perfect Velvet Mini Binder Notebook', 230000, '6-Ring Clear PVC Cover Red Velvet mini binder notebook! Keep your notes in tact with this beautiful journal.\r\n\r\nSize\r\n\r\n- 7 * 9.25 * 0.75\r\n\r\n• Made in the Korea', '2020-01-03 11:08:34', 8, 1, 31, 11, 2),
(49, 'EXO Stationery Set', 450000, 'Time to take notes with EXO, enjoy this stationary kit and keep all your work together with this set!\r\n \r\n&lt;Item Size&gt;\r\nClear File: 10 * 13 * 2 (inch)\r\nNote Pad: 9 * 12.5 (inch)\r\nNote: 5 * 7.25 (inch)\r\nSticky Note: 2.5 * 2.5 (inch)\r\n \r\n• Order Processing Time: (1-3 days, 3-5 days during high volume) after order confirmation. Make sure your address is in English at check-out.', '2020-01-03 06:01:02', 4, 1, 31, 12, 2),
(50, 'Korea&#039;s Exclusive Product: f(x) Heart Charm Bracelet', 210000, 'f(x) Heart Charm Bracelet.\r\n\r\nPackage Size\r\n- 3.15 * 3.15 * 0.08\r\n\r\nOrder Processing Time: (1-3 days, 3-5 days during high volume) after order confirmation. Make sure your address is in English at check-out.\r\n\r\n• Made in Korea\r\n• This is an official SM Town and Store merchandise.', '2020-01-03 06:05:38', 0, 5, 31, 16, 2);

--
-- Bẫy `product`
--
DELIMITER $$
CREATE TRIGGER `del_photo` BEFORE DELETE ON `product` FOR EACH ROW DELETE FROM photo 
WHERE product_id = old.product_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_review` BEFORE DELETE ON `product` FOR EACH ROW DELETE FROM productreview 
WHERE product_id = old.product_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `product` BEFORE DELETE ON `product` FOR EACH ROW DELETE FROM orderdetails 
WHERE product_id = old.product_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productreview`
--

CREATE TABLE `productreview` (
  `review_id` int(11) NOT NULL,
  `title` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `rate` int(1) NOT NULL,
  `review_date` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `productreview`
--

INSERT INTO `productreview` (`review_id`, `title`, `message`, `rate`, `review_date`, `product_id`, `user_id`) VALUES
(35, 'tesst binh luận san phẩm', 'tesst binh luận san phẩm', 1, 1577888401, 46, 29),
(36, 'test commenttttttttttt', 'test commenttttttttttttest commenttttttttttt', 2, 1577890604, 45, 29),
(37, 'tesst binh luận san phẩm', 'tesst binh luận san phẩm', 3, 1577890633, 43, 29),
(38, 'test đánh giá bình luận', '223323đsd', 4, 1577890667, 44, 29),
(40, 'đánh giá tố', 'test đánh giá sản phẩm.....', 5, 1578023542, 46, 28),
(41, 'sản phẩm khá tốt', 'sản phẩm khá tốt .... test', 3, 1578049598, 50, 28),
(43, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(44, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(45, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(46, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(47, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(48, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(49, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(50, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(51, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(52, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(53, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(55, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(56, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(57, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(58, 'test bình luận sản phẩm', 'test bình luận sản phẩm', 3, 1578655998, 46, 28),
(59, 'test bình luận sản phẩm', 'test ............', 4, 1578657583, 49, 28);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `saleoff`
--

CREATE TABLE `saleoff` (
  `sale_id` int(11) NOT NULL,
  `sale_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sale_content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `fromday` date NOT NULL,
  `today` date NOT NULL,
  `discount` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `saleoff`
--

INSERT INTO `saleoff` (`sale_id`, `sale_name`, `sale_content`, `fromday`, `today`, `discount`) VALUES
(1, 'Normal', 'Đây không phải là khuyến mãi !', '2019-12-24', '0000-00-00', 0),
(5, 'Sale off 20% all products', 'Sale off 20% all products\r\nSale off 20% all products\r\nSale off 20% all products\r\n\r\nThân!', '2020-01-01', '2020-01-03', 5);

--
-- Bẫy `saleoff`
--
DELIMITER $$
CREATE TRIGGER `del_sale` BEFORE DELETE ON `saleoff` FOR EACH ROW UPDATE product SET sale_id = 1 
WHERE sale_id = old.sale_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipmethod`
--

CREATE TABLE `shipmethod` (
  `ship_id` int(11) NOT NULL,
  `ship_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ship_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `shipmethod`
--

INSERT INTO `shipmethod` (`ship_id`, `ship_name`, `ship_price`) VALUES
(1, 'Nhận hàng trực tiếp', 0),
(3, 'Giao hàng thường (15 ngày)', 70000),
(4, 'Giao hàng nhanh (7 ngày)', 100000),
(6, 'Giao hàng nhanh (3 ngày)', 150000);

--
-- Bẫy `shipmethod`
--
DELIMITER $$
CREATE TRIGGER `del_method` BEFORE DELETE ON `shipmethod` FOR EACH ROW UPDATE `order` SET  method_ship_id = 1 
WHERE method_ship_id = old.ship_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `company_address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `company_name`, `company_address`, `phone`) VALUES
(2, 'SM Entertaiment', 'Seoul Han quoc, ', '09990'),
(3, 'JYP Entertaiment', 'Seol Korea', '32232'),
(5, 'YG ENTERTAIMENT', 'SEOUL, KOREA NOUTH', '0923242'),
(6, 'BIGHIT ENTERTAIMENT', 'Seoul, Korea Hàn quốc', '093434411');

--
-- Bẫy `supplier`
--
DELIMITER $$
CREATE TRIGGER `del_supplier` BEFORE DELETE ON `supplier` FOR EACH ROW DELETE FROM product 
WHERE supplier_id = old.supplier_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongbao`
--

CREATE TABLE `thongbao` (
  `thongbao_id` int(11) NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `daxem` int(1) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `thoigian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thongbao`
--

INSERT INTO `thongbao` (`thongbao_id`, `message`, `daxem`, `user_id`, `thoigian`) VALUES
(17, '<a href=\"/shop389/forum/view.php?id=31\">hoangduy bình luận bài viết mà bạn theo dõi</a>', 1, 30, 1578992926),
(18, '<a href=\"/shop389/forum/view.php?id=33\">kimjennie bình luận bài viết mà bạn theo dõi</a>', 1, 29, 1579005311),
(19, '<a href=\"/shop389/forum/view.php?id=33\">admin bình luận bài viết mà bạn theo dõi</a>', 1, 29, 1579005801),
(20, '<a href=\"/shop389/forum/view.php?id=33\">huahoangduy bình luận bài viết mà bạn theo dõi</a>', 0, 29, 1579006264),
(21, '<a href=\"/shop389/forum/view.php?id=31\">duykhanh bình luận bài viết mà bạn theo dõi</a>', 0, 30, 1579006681);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `topic_comment`
--

CREATE TABLE `topic_comment` (
  `comment_id` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `comment_time` int(11) NOT NULL,
  `comment_trichdan` text COLLATE utf8_unicode_ci NOT NULL,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `topic_comment`
--

INSERT INTO `topic_comment` (`comment_id`, `message`, `comment_time`, `comment_trichdan`, `topic_id`, `user_id`, `type`) VALUES
(50, 'Thông báo mở diễn đàn thảo luận KPOP\r\n\r\nTrân trọng !', 1578974537, '', 31, 27, 1),
(51, 'test chat..........', 1578974654, '', 31, 30, 0),
(52, 'test thông báo...............', 1578979694, '<div class=\"quote\"><div class=\"user\">Trích dẫn bài viết của <a href=\"profile.php.php?id=30\">hoangduy</a></div>\r\n                <div class=\"quote2\">test chat..........</div></div>', 31, 27, 0),
(54, 'gfgfgfgfgfgfgfgf', 1578992666, '', 31, 30, 0),
(55, 'ttryyyyyyyyyyyyyyyyyyyyyyyyyyyyy', 1578992689, '', 31, 30, 0),
(56, 'ttttttttttttttttttttttttttt', 1578992775, '', 31, 27, 0),
(57, 'dddđfffffffffffffffffffff', 1578992855, '', 31, 27, 0),
(58, 'rtttttttttttttttttttttttttttttttttttt', 1578992926, '', 31, 27, 0),
(59, 'V/v Quy định khi đăng bài trên diễn đàn !\r\n\r\nTest............', 1579001843, '', 32, 27, 1),
(60, 'Hỏi về việc mua đồ trên shop\r\nHỏi về việc mua đồ trên shop\r\ntest...', 1579005216, '', 33, 29, 1),
(61, 'hỏi gì cứ hỏi???', 1579005311, '', 33, 28, 0),
(62, 'Về lightstick của BLACKPINK\r\ntest.........', 1579005365, '', 34, 28, 1),
(63, 'hướng dẫn khi mua đồ trên SHOP 389', 1579005465, '', 35, 28, 1),
(64, 'BTS sắp comeback vào tháng 2 năm nay', 1579005492, '', 36, 28, 1),
(65, 'Cần nhượng lại album của twice', 1579005559, '', 37, 30, 1),
(66, 'ffffffffffffff', 1579005772, '', 33, 29, 0),
(67, 'có bất kỳ câu hỏi nào hãy bình luận tại đây!', 1579005801, '', 33, 27, 0),
(68, 'hello mn..........', 1579006264, '', 33, 31, 0),
(69, 'spam...............', 1579006681, '', 31, 32, 0);

--
-- Bẫy `topic_comment`
--
DELIMITER $$
CREATE TRIGGER `del_like_comment` BEFORE DELETE ON `topic_comment` FOR EACH ROW DELETE FROM `topic_like` 
WHERE `comment_id` = old.comment_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_photo_comment` BEFORE DELETE ON `topic_comment` FOR EACH ROW DELETE FROM `comment_photo` 
WHERE `comment_id` = old.comment_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `topic_like`
--

CREATE TABLE `topic_like` (
  `like_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `topic_like`
--

INSERT INTO `topic_like` (`like_id`, `comment_id`, `user_id`) VALUES
(41, 50, 30),
(42, 50, 27),
(43, 60, 28),
(44, 50, 28);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `topic_theodoi`
--

CREATE TABLE `topic_theodoi` (
  `theodoi_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `topic_theodoi`
--

INSERT INTO `topic_theodoi` (`theodoi_id`, `topic_id`, `user_id`) VALUES
(26, 31, 30),
(27, 32, 27),
(28, 33, 29),
(29, 34, 28),
(30, 35, 28),
(31, 36, 28),
(32, 37, 30);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `mob` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `yob` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `right` int(11) NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fullname`, `gender`, `address`, `phone`, `email`, `dob`, `mob`, `yob`, `status`, `right`, `photo`, `post`) VALUES
(27, 'admin', '$2y$10$xJ0g6TW3VnhiXUu.di3x3OT0kOm8G72xZfSNHWSAqQh1WxvcURMk2', 'admin shop38', '1', 'Hậu giang', '2222222', 'hdhdhdh@gamil.com', '27', '12', '2003', 1579005998, 9, 'photo/users/200113120640.png', 150),
(28, 'hhd389', '$2y$10$xJ0g6TW3VnhiXUu.di3x3OT0kOm8G72xZfSNHWSAqQh1WxvcURMk2', 'hua hoang duy', '1', 'can tho, hau giang', '0303333', 'hdhdhdh@gamil.com', '27', '12', '1990', 1579005515, 0, 'photo/users/200103105157.png', 2009),
(29, 'kimjennie', '$2y$10$xJ0g6TW3VnhiXUu.di3x3OT0kOm8G72xZfSNHWSAqQh1WxvcURMk2', 'Kim jennie', '2', 'test .........', '222222222', 'hhduya18138@cusc.ctu.edu.vn', '1', '4', '1930', 1579005891, 0, 'photo/users/200101213306.jpg', 4),
(30, 'hoangduy', '$2y$10$xJ0g6TW3VnhiXUu.di3x3OT0kOm8G72xZfSNHWSAqQh1WxvcURMk2', 'hoang duy', '1', 'test .........', '222222222', 'hhduya182138@cusc.ctu.edu.vn', '1', '4', '2002', 1579005582, 0, 'photo/users/200101213306.jpg', 5),
(31, 'huahoangduy', '$2y$10$BegImRTR1re5kjM58WD6.u2fL1Spl5cs/GuOZpo4Omv6OHOs/xFuG', 'hứa hoàng duy', '1', 'Hậu giang', 'hjhssssssss@gmail.com', '1', '1', '1', '1930', 1579006452, 0, 'photo/users/male.png', 1),
(32, 'duykhanh', '$2y$10$/SFqJTobT6jjruJoEAqTFusIk0tmnBarytZR83VG6aR5MZlO3sahS', 'êr', '1', 'trống', '', 'hhduya183138@cusc.ctu.edu.vn', '1', '1', '1930', 1579006698, 0, 'photo/users/male.png', 1);

--
-- Bẫy `users`
--
DELIMITER $$
CREATE TRIGGER `del_comment` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM productreview WHERE user_id = old.user_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_giftcode` BEFORE DELETE ON `users` FOR EACH ROW UPDATE `giftcode` SET sudung = 0 WHERE sudung = old.user_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_user_feedback` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM feedback
WHERE user_id = old.user_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_user_order` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM `order`
WHERE user_id = old.user_id
$$
DELIMITER ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `blockuser`
--
ALTER TABLE `blockuser`
  ADD PRIMARY KEY (`block_id`),
  ADD KEY `fk_blockuser_users1` (`user_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `comment_photo`
--
ALTER TABLE `comment_photo`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `fk_comment_photo_topic_comment1` (`comment_id`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`fb_id`),
  ADD KEY `fk_feedback_users1` (`user_id`);

--
-- Chỉ mục cho bảng `forum_chuyenmuc`
--
ALTER TABLE `forum_chuyenmuc`
  ADD PRIMARY KEY (`forum_id`);

--
-- Chỉ mục cho bảng `forum_topic`
--
ALTER TABLE `forum_topic`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `fk_forum_topic_forum_chuyenmuc1` (`forum_id`),
  ADD KEY `fk_forum_topic_users1` (`user_id`);

--
-- Chỉ mục cho bảng `giftcode`
--
ALTER TABLE `giftcode`
  ADD PRIMARY KEY (`code_id`);

--
-- Chỉ mục cho bảng `idols`
--
ALTER TABLE `idols`
  ADD PRIMARY KEY (`idol_id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_Order_users1` (`user_id`),
  ADD KEY `fk_order_shipmethod1` (`method_ship_id`);

--
-- Chỉ mục cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`details_id`),
  ADD KEY `fk_orderdetails_product` (`product_id`),
  ADD KEY `fk_orderdetails_Order1` (`order_id`);

--
-- Chỉ mục cho bảng `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `fk_photo_product1` (`product_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_product_saleoff1` (`sale_id`),
  ADD KEY `fk_product_category1` (`category_id`),
  ADD KEY `fk_product_idols1` (`idol_id`),
  ADD KEY `fk_product_Supplier1` (`supplier_id`);

--
-- Chỉ mục cho bảng `productreview`
--
ALTER TABLE `productreview`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `fk_productreview_product1` (`product_id`),
  ADD KEY `fk_productreview_users1` (`user_id`);

--
-- Chỉ mục cho bảng `saleoff`
--
ALTER TABLE `saleoff`
  ADD PRIMARY KEY (`sale_id`);

--
-- Chỉ mục cho bảng `shipmethod`
--
ALTER TABLE `shipmethod`
  ADD PRIMARY KEY (`ship_id`);

--
-- Chỉ mục cho bảng `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Chỉ mục cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  ADD PRIMARY KEY (`thongbao_id`),
  ADD KEY `fk_thongbao_users1` (`user_id`);

--
-- Chỉ mục cho bảng `topic_comment`
--
ALTER TABLE `topic_comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_topic_comment_forum_topic1` (`topic_id`),
  ADD KEY `fk_topic_comment_users1` (`user_id`);

--
-- Chỉ mục cho bảng `topic_like`
--
ALTER TABLE `topic_like`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `fk_topic_like_topic_comment1` (`comment_id`),
  ADD KEY `fk_topic_like_users1` (`user_id`);

--
-- Chỉ mục cho bảng `topic_theodoi`
--
ALTER TABLE `topic_theodoi`
  ADD PRIMARY KEY (`theodoi_id`),
  ADD KEY `fk_topic_theodoi_forum_topic1` (`topic_id`),
  ADD KEY `fk_topic_theodoi_users1` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `blockuser`
--
ALTER TABLE `blockuser`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `comment_photo`
--
ALTER TABLE `comment_photo`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `feedback`
--
ALTER TABLE `feedback`
  MODIFY `fb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `forum_chuyenmuc`
--
ALTER TABLE `forum_chuyenmuc`
  MODIFY `forum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `forum_topic`
--
ALTER TABLE `forum_topic`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `giftcode`
--
ALTER TABLE `giftcode`
  MODIFY `code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `idols`
--
ALTER TABLE `idols`
  MODIFY `idol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `photo`
--
ALTER TABLE `photo`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `productreview`
--
ALTER TABLE `productreview`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT cho bảng `saleoff`
--
ALTER TABLE `saleoff`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `shipmethod`
--
ALTER TABLE `shipmethod`
  MODIFY `ship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  MODIFY `thongbao_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `topic_comment`
--
ALTER TABLE `topic_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT cho bảng `topic_like`
--
ALTER TABLE `topic_like`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `topic_theodoi`
--
ALTER TABLE `topic_theodoi`
  MODIFY `theodoi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `blockuser`
--
ALTER TABLE `blockuser`
  ADD CONSTRAINT `fk_blockuser_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `comment_photo`
--
ALTER TABLE `comment_photo`
  ADD CONSTRAINT `fk_comment_photo_topic_comment1` FOREIGN KEY (`comment_id`) REFERENCES `topic_comment` (`comment_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `forum_topic`
--
ALTER TABLE `forum_topic`
  ADD CONSTRAINT `fk_forum_topic_forum_chuyenmuc1` FOREIGN KEY (`forum_id`) REFERENCES `forum_chuyenmuc` (`forum_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_forum_topic_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_Order_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_shipmethod1` FOREIGN KEY (`method_ship_id`) REFERENCES `shipmethod` (`ship_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `fk_orderdetails_Order1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orderdetails_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `fk_photo_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_Supplier1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_idols1` FOREIGN KEY (`idol_id`) REFERENCES `idols` (`idol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_saleoff1` FOREIGN KEY (`sale_id`) REFERENCES `saleoff` (`sale_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `productreview`
--
ALTER TABLE `productreview`
  ADD CONSTRAINT `fk_productreview_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productreview_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  ADD CONSTRAINT `fk_thongbao_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `topic_comment`
--
ALTER TABLE `topic_comment`
  ADD CONSTRAINT `fk_topic_comment_forum_topic1` FOREIGN KEY (`topic_id`) REFERENCES `forum_topic` (`topic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_topic_comment_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `topic_like`
--
ALTER TABLE `topic_like`
  ADD CONSTRAINT `fk_topic_like_topic_comment1` FOREIGN KEY (`comment_id`) REFERENCES `topic_comment` (`comment_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_topic_like_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `topic_theodoi`
--
ALTER TABLE `topic_theodoi`
  ADD CONSTRAINT `fk_topic_theodoi_forum_topic1` FOREIGN KEY (`topic_id`) REFERENCES `forum_topic` (`topic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_topic_theodoi_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
