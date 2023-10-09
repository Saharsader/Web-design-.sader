-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2023 at 05:44 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `makeup`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'کرم ها'),
(2, 'لوازم آرایش چشم'),
(3, 'لوازم آرایش لب'),
(4, 'لوازم آرایش بدن'),
(5, 'لوازم آرایش صورت'),
(6, 'لوازم آرایش ابرو'),
(7, 'لوازم آرایش ناخن'),
(8, 'ماسک ها');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `comments_text` text COLLATE utf8_persian_ci,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `name`, `product_id`, `comments_text`, `created_at`) VALUES
(2, NULL, 'شبنم', 7, 'تست پیام', 1687335264);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8_persian_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `content` text COLLATE utf8_persian_ci,
  `created_at` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `id` int(10) UNSIGNED NOT NULL,
  `tel` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `telegram` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`id`, `tel`, `mobile`, `email`, `address`, `whatsapp`, `instagram`, `telegram`) VALUES
(1, '09338142030', '09981326118', 'miss.faez.kh2030@gmail.com', 'ایران', 'whatsapp', 'instagram', 'telegram');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `order_date` int(11) NOT NULL,
  `order_count` int(11) NOT NULL,
  `complete_date` int(11) DEFAULT NULL,
  `delivery_date` int(11) DEFAULT NULL,
  `basket` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `user_id`, `product_id`, `price`, `order_date`, `order_count`, `complete_date`, `delivery_date`, `basket`, `status`) VALUES
(1, 1, 3, '35000', 1658313969, 0, 1658313982, NULL, 0, 1),
(2, 1, 7, '10000', 1672685224, 0, 1672686177, NULL, 1, 1),
(3, 1, 7, '10000', 1672685369, 1, NULL, NULL, 1, 1),
(4, 1, 6, '349000', 1687115358, 1, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `product_price` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `product_discount` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `product_count` int(200) NOT NULL,
  `product_size` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `product_type` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `product_property` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `product_color` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `product_description` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `product_img` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `product_status` enum('disable','enable') COLLATE utf8_persian_ci NOT NULL DEFAULT 'enable',
  `special` int(11) NOT NULL,
  `view` int(11) DEFAULT NULL,
  `code` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `start` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `end` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `percent` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_price`, `product_discount`, `product_count`, `product_size`, `product_type`, `product_property`, `product_color`, `product_description`, `product_img`, `product_status`, `special`, `view`, `code`, `start`, `end`, `percent`, `event`) VALUES
(1, 5, 'پودر فیکساتور آرایش فلورمار', '250000', '', 0, '', 'فلورمار', '    تثبیت کننده انواع کرم پودر و پنکیک\r\n    حفظ رطوبت پوست\r\n    افزایش ماندگاری آرایش\r\n    نمای نهایی طبیعی\r\n    دارای رنگ بندی متنوع', 'رنگ صورت شماره 1 تا 5', 'بعد از اتمام آرایش، با استفاده از براش یا پد مناسب، پودر تثبیت کننده را روی صورت خود پخش کنید. این پودر برای فیکس کردن رژ لب و آرایش چشم نیز قابل استفاده است. برای پوشاندن تتو و عیوب صورت و بدن خود، ابتدا از کرم کاموفلاژ استفاده کنید و برای تثبیت آن پودر ', '1.jpeg', 'enable', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 5, 'اسپری فیکساتور آرایش فلورمار 75 میل', '144000', '100000', 0, '', 'فلورمار', 'این محصول را می توانید قبل، بعد یا حین تجدید آرایش به صورت دایره ای از فاصله 20 سانتی متری اسپری کنید. ', '', 'اسپری فیکساتور آرایش فلورمار 75 میل اگر به دنبال تثبیت کننده آرایشی هستید که به راحتی در منزل آرایشتان را تثبیت کنید بهترین پیشنهاد اسپری فیکساتور آرایش فلورمار است.یکی از معضلات همیشگی بانوان از بین رفتن یا خراب شدن آرایش بعد از گذشت چند ساعت است. این مح', '2.jpeg', 'enable', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, 'رژ لب دوماسی ', '35000', '33000', 0, '', 'دوماسی', 'حاوی روغن‌های گیاهی\r\nحاوی ویتامین e\r\nمرطوب کننده\r\nویتامینه\r\nطبیعی', 'قرمز+زرد+سیاه+صورتی', 'آرایش لبها میتواند به جذابیت و زیبایی صورت اضافه و یا آن را کم نماید. نزدن رژ لب بهتر از زدن آن به طور نامرتب یا با رنگهای نامناسب است. با رژ لب میتوان فرم لبها را زیباتر و اصلاح نمود و با سایر اعضای صورت متناسب ساخت. .تا به حال متوجه شده‌اید که چرا رژ لب', '3.jpeg', 'enable', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 2, 'ریمل حجم دهنده اسنس', '105000', '100000', 0, '', 'اسنس ', '    حجم دهنده\r\n    بلند کننده مژه ها\r\n    دارای رنگ فوق العاده مشکی\r\n    ماندگاری بالا', '', 'برای داشتن چشمانی نافذ و زیبا داشتن مژه هایی حجیم و فر امری الزامی است. به همین منظور استفاده از ریمل مشکی اسنس تاثیر به سزایی در حالت و زیبایی چشمان شما دارد. از میان مارک‌های متفاوت ریمل برخی از آن‌ها برای حجیم کردن مژه‌ها ساخته شده‌اند و برخی برای حالت', '4.jpeg', 'enable', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 3, 'ماسک لب ورقه ای بایو آکوا ', '5000', '4800', 0, '', 'بایو آکوا', '    ترمیم کننده خشکی و پوسته پوسته شدن لب\r\n    لطافت بخشی به لب\r\n    خوش رنگ کننده لب\r\n    مناسب پوست خشک و معمولی\r\n    مناسب آقایان و بانوان\r\n    کشور سازنده برند: کره جنوبی', '', 'ماسک لب ورقه ای بایو آکوا حاوی کلاژن و عصاره توت فرنگی مناسب پوست خشک است. این محصول با آبرسانی از خشکی و پوسته شدن لب جلوگیری می کند و باعث نرمی و لطافت لب هایتان می شود. همچنین علاوه بر ترمیم کنندگی، رنگ ملایم زیبایی به لب هایتان خواهد داد. ماسک لب ورقه', '5.jpeg', 'enable', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 5, 'کانسیلر میبلین', '349000', '340000', 0, '', 'میبلین ', '    ماندگاری بسیار بالا\r\n    رفع نشانه های خستگی و ماندگاری بالا\r\n    پد سرخود و آنتی باکتریال\r\n    غنی شده با کلاژن\r\n    پوشش صاف و یکدست\r\n    حاوی عصاره گوچی بری', '', 'کانسیلر میبلین سری Eraser مدل Instant Anti-Age در میان کانسیلر ها دارای محبوبیت زیادی است. این کانسیلر جهت رفع تیرگی و عیوب نقاط مختلف صورت مانند دور چشم ها ،خط خنده ،خطوط بینی و پف و تیرگی دور چشم ها استفاده می گردد. پوشانندگی این محصول بسیار بالا بوده و', '6.jpeg', 'enable', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 4, 'تاتو موقت اکلیلی کودک', '10000', '', 0, '', 'آی ایکس', '    دارای طرح عروسکی\r\n    به صورت برچسبی\r\n    پاک کردن آسان\r\n    مناسب کودکان', '', 'تاتو های موقت عموما مشکلی برای پوست ایجاد نمی کنند و برای هر سنی مناسب می باشند. به دلیل وجود طرح های بسیار متنوع و زیبا نیاز هر سلیقه ای را تامین می کند و برای پوشاندن موقتی جای زخم، جوش و... مناسب خواهد بود. این تتو ها به صورت برچسبی طراحی شده اند و برا', '7.jpeg', 'enable', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 'کرم تقویت کننده ابرو', '69000', '', 0, '', 'سریتا', 'افزایش رشد ، استحکام و ضخامت ابرو\r\nتقویت فولیکول های ابرو\r\nغنی از پپتید ها و ویتامین های تقویت کننده\r\nرطوبت رسانی مناسب و افزایش الاستیسیته', '', 'کرم تقویت کننده ابرو سریتا برای ابروهای رنگ شده، تاتو شده و تیغ زده و ابروهای برداشته شده بسیار مناسب است. این محصول فرم کرمی شکل دارد که ماساژ راحت و افزایش تحریک رویش ابرو را در پی خواهد داشت. کرم تقویت کننده ابرو سریتا با افزایش خون رسانی و بهبود تغذیه', '8.jpeg', 'enable', 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `ticket_text` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `ticket_title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `ticket_text`, `ticket_title`, `user_id`, `reply_id`) VALUES
(1, 'salam', 'salam2', 8, 0),
(7, '11', '11', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `family` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8_persian_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `code` bigint(20) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `permission` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `family`, `email`, `phone`, `code`, `password`, `address`, `permission`, `created_at`) VALUES
(1, 'سحر ', 'صادر', 'sahar.sr1379@gmail.com', '09913417696', 123, 'e10adc3949ba59abbe56e057f20f883e', 'ایران', 'admin', NULL),
(3, 'تینا ', 'طاق', 'Taghetina1382@gmail.com', '09981326118', 456, 'e10adc3949ba59abbe56e057f20f883e', 'ایران', 'admin', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `information`
--
ALTER TABLE `information`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
