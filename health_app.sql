-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 02, 2025 at 09:53 AM
-- Server version: 9.1.0
-- PHP Version: 8.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `health_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `article_url` varchar(500) NOT NULL,
  `article_title` varchar(255) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_article_url` (`article_url`(250))
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `article_url`, `article_title`, `user_name`, `user_email`, `comment_text`, `created_at`) VALUES
(1, 'https://timesofindia.indiatimes.com/life-style/food-news/5-foods-to-combine-with-moringa-leaves-to-boost-immunity/photostory/124242030.cms', '5 foods to combine with moringa leaves to boost immunity', 'wonder', 'wonderawayiwu19@gmail.com', 'i like you page', '2025-10-01 14:27:05'),
(2, 'https://economictimes.indiatimes.com/magazines/panache/this-low-calorie-superfruit-is-packed-with-superpowers-has-anticancer-properties-and-heart-benefits/articleshow/124239719.cms', 'This low-calorie superfruit is packed with superpowers, has anticancer properties and heart benefits', 'james', 'wonderawayiwu19@gmail.com', 'Very Educative', '2025-10-01 14:31:12'),
(3, 'https://economictimes.indiatimes.com/magazines/panache/this-low-calorie-superfruit-is-packed-with-superpowers-has-anticancer-properties-and-heart-benefits/articleshow/124239719.cms', 'This low-calorie superfruit is packed with superpowers, has anticancer properties and heart benefits', 'wonder', 'giftyawayiwu@gmail.com', 'very nice', '2025-10-01 15:09:14'),
(4, 'https://timesofindia.indiatimes.com/life-style/food-news/reverse-type-2-diabetes-7-foods-to-balance-your-insulin-levels-and-maintain-steady-blood-sugar/photostory/123988902.cms', 'Reverse Type 2 Diabetes: 7 foods to balance your insulin levels (and maintain steady blood sugar)', 'wonder', 'giftyawayiwu@gmail.com', 'nice', '2025-10-01 15:54:34'),
(5, 'https://kdhlradio.com/ixp/150/p/minnesota-top-5-health-wellness-2025/', 'SmileHub Names Minnesota Top State For Health And Wellness', 'wonder', 'giftyawayiwu@gmail.com', 'i learnt a lot', '2025-10-02 08:19:32'),
(6, 'https://kdhlradio.com/ixp/150/p/minnesota-top-5-health-wellness-2025/', 'SmileHub Names Minnesota Top State For Health And Wellness', 'wonder', 'giftyawayiwu@gmail.com', 'that educative', '2025-10-02 08:19:42'),
(7, 'https://economictimes.indiatimes.com/magazines/panache/this-low-calorie-superfruit-is-packed-with-superpowers-has-anticancer-properties-and-heart-benefits/articleshow/124239719.cms', 'This low-calorie superfruit is packed with superpowers, has anticancer properties and heart benefits', 'eva', 'giftyawayiwu@gmail.com', 'i like this article', '2025-10-02 08:32:06'),
(8, 'https://economictimes.indiatimes.com/magazines/panache/this-low-calorie-superfruit-is-packed-with-superpowers-has-anticancer-properties-and-heart-benefits/articleshow/124239719.cms', 'This low-calorie superfruit is packed with superpowers, has anticancer properties and heart benefits', 'eva', 'giftyawayiwu@gmail.com', 'wow', '2025-10-02 09:03:32'),
(9, 'https://www.gloucestershirelive.co.uk/whats-on/shopping/shoppers-feel-more-alive-just-10541737', 'one supplement made shoppers \'feel more alive\' in just \'four days\'', 'eva', 'giftyawayiwu@gmail.com', 'jjjjj', '2025-10-02 09:29:36'),
(10, 'https://economictimes.indiatimes.com/news/india/the-ultimate-guide-to-minerals-for-a-stronger-healthier-body/slideshow/124255478.cms', 'The ultimate guide to minerals for a stronger, healthier body', 'eva', 'giftyawayiwu@gmail.com', 'very educative', '2025-10-02 09:36:37'),
(11, 'https://economictimes.indiatimes.com/news/india/the-ultimate-guide-to-minerals-for-a-stronger-healthier-body/slideshow/124255478.cms', 'The ultimate guide to minerals for a stronger, healthier body', 'eva', 'giftyawayiwu@gmail.com', 'good', '2025-10-02 09:37:11'),
(12, 'https://www.gloucestershirelive.co.uk/whats-on/shopping/shoppers-feel-more-alive-just-10541737', 'one supplement made shoppers \'feel more alive\' in just \'four days\'', 'eva', 'giftyawayiwu@gmail.com', 'wow', '2025-10-02 09:50:48'),
(13, 'https://medicalxpress.com/news/2025-09-tylenol-autism-difference-link-scientific.html', 'Tylenol, autism and the difference between finding a link and finding a cause in scientific research', 'eva', 'giftyawayiwu@gmail.com', 'very great', '2025-10-02 09:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(5, 'eva', 'eva@gmail.com', '$2y$12$m3KGIzMBQCTSsFd1YaOp9uXnJNl/kS./qJ2VD49WQf0EwJcrHiI62', '2025-09-30 13:51:48', '2025-09-30 13:51:48'),
(6, 'john', 'john@gmail.com', '$2y$12$hykrpkTyUKP1Fh.IP/s1b.flwP4yPA1CdM1h85/577w4tQj0DuCHG', '2025-10-02 09:33:05', '2025-10-02 09:33:05'),
(4, 'prince', 'princekoney@gmail.com', '$2y$12$p3qULvgP0QsRuGevxrHNtuxgVFblQZJdK1fcNn29Yi8nVu9sN8TX2', '2025-09-30 13:50:08', '2025-09-30 13:50:08');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
