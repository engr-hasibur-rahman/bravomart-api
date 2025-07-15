-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 10:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bravo_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_settings`
--

CREATE TABLE `about_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_settings`
--

INSERT INTO `about_settings` (`id`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, '{\"about_section\":{\"title\":\"About Bravo Mart\",\"subtitle\":\"Where Innovation Meets Seamless Online Shopping\",\"description\":null,\"image\":763,\"image_url\":null},\"story_section\":{\"title\":\"Our Story\",\"subtitle\":\"From a Bold Vision to a Trusted Marketplace: How BravoMart Was Built to Transform the Future of eCommerce\",\"steps\":[{\"title\":\"Our Vision and Beginning\",\"subtitle\":\"Transforming the eCommerce Landscape with a Vision to Connect Buyers and Sellers Seamlessly\",\"image\":761},{\"title\":\"Overcoming Challenges\",\"subtitle\":\"Navigating Obstacles with Innovation to Build a Reliable and Secure Marketplace\",\"image\":762},{\"title\":\"Our Future Vision\",\"subtitle\":\"Continuing to Innovate and Grow, Building a Sustainable eCommerce Ecosystem for the Future\",\"image\":759}]},\"mission_and_vision_section\":{\"title\":\"Our Mission & Vision\",\"subtitle\":\"At BravoMart, we are committed to revolutionizing eCommerce by creating a seamless, secure, and customer-centric marketplace. Our mission is to empower businesses with the tools they need to succeed while providing shoppers with a hassle-free and rewarding experience.\",\"steps\":[{\"title\":\"Our Mission\",\"subtitle\":\"Make online shopping easy, reliable, and enjoyable for customers. Enable sellers to grow by offering powerful tools and support. Deliver competitive prices, quality products, and exceptional service. Foster a trusted marketplace built on transparency and efficiency.\",\"description\":\"Make online shopping easy, reliable, and enjoyable for customers. Enable sellers to grow by offering powerful tools and support. Deliver competitive prices, quality products, and exceptional service. Foster a trusted marketplace built on transparency and efficiency.\",\"image\":760},{\"title\":\"Our vision\",\"subtitle\":\"Revolutionize digital commerce by integrating cutting-edge technology. Expand globally, connecting millions of buyers and sellers worldwide. Create a thriving community where businesses succeed and customers shop with confidence. Lead with innovation, continuously improving our platform to adapt to future trends.\",\"description\":\"Revolutionize digital commerce by integrating cutting-edge technology. Expand globally, connecting millions of buyers and sellers worldwide. Create a thriving community where businesses succeed and customers shop with confidence. Lead with innovation, continuously improving our platform to adapt to future trends.\",\"image\":761}]},\"testimonial_and_success_section\":{\"title\":\"Testimonials & Success Stories\",\"subtitle\":\"From a Bold Vision to a Trusted Marketplace: How BravoMart Was Built to Transform the Future of eCommerce\",\"steps\":[{\"title\":\"John Anderson\",\"subtitle\":\"CEO at BravoMart\",\"description\":\"CEO at BravoMart\",\"image\":507},{\"title\":\"Michael Thompson\",\"subtitle\":\"COO at BravoMart\",\"description\":\"COO at BravoMart\",\"image\":506},{\"title\":\"Emily Davis\",\"subtitle\":\"Owner at The Cozy Boutique\",\"description\":\"Owner at The Cozy Boutique\",\"image\":514},{\"title\":\"David Patel\",\"subtitle\":\"Founder at SmartHome Solutions\",\"description\":\"Founder at SmartHome Solutions\",\"image\":513},{\"title\":\"Laura Gonzalez\",\"subtitle\":\"CEO at LUX Apparel\",\"description\":\"CEO at LUX Apparel\",\"image\":512}]}}', 1, '2025-03-18 00:46:33', '2025-05-22 09:26:15');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'who created the banner',
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `title_color` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `description_color` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT NULL,
  `background_color` varchar(255) DEFAULT NULL,
  `thumbnail_image` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_text_color` varchar(255) DEFAULT NULL,
  `button_hover_color` varchar(255) DEFAULT NULL,
  `button_color` varchar(255) DEFAULT NULL,
  `redirect_url` varchar(255) DEFAULT NULL,
  `location` varchar(255) NOT NULL DEFAULT 'home_page' COMMENT 'the location of the banner Home Page or Store Page',
  `type` varchar(255) DEFAULT NULL COMMENT 'Ex: Banner-1, Banner-2, Banner-3',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `user_id`, `store_id`, `title`, `title_color`, `description`, `description_color`, `background_image`, `background_color`, `thumbnail_image`, `button_text`, `button_text_color`, `button_hover_color`, `button_color`, `redirect_url`, `location`, `type`, `status`, `created_at`, `updated_at`) VALUES
(4, 8, NULL, 'TAKE ON THE DAY!', '#434f5b', 'Explore our e-commerce fashion collection for a modern con', '#4e6276', '718', '#8cd4f1', '714', 'Shop Now', '#ffffff', '#0c729a', '#1f9ba9', 'https://lucide.dev/icons/package-search', 'home_page', 'Banner-2', 1, '2025-03-10 03:46:42', '2025-05-14 09:55:26'),
(7, 8, NULL, 'New Coupon Discount', '#0057ee', 'Enjoy coupon discount', '#005dff', '738', '#0a3eb5', '740', 'Buy Now', '#ffff', '#0a3eb5', '#005dff', 'http://192.168.88.225:3000/admi', 'home_page', 'Banner-1', 1, '2025-03-10 04:00:32', '2025-05-20 04:01:51'),
(10, 8, NULL, 'Flawless Beauty', '#fefffe', 'Get flat 60% off', '#ffffff', '724', '#ffffff', '722', 'Shop Now', '#265387', '#003d83', '#ffffff', 'http://192.168.88.225:3010/home', 'home_page', 'Banner-3', 1, '2025-03-10 21:33:36', '2025-05-14 09:10:41');

-- --------------------------------------------------------

--
-- Table structure for table `become_seller_settings`
--

CREATE TABLE `become_seller_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `become_seller_settings`
--

INSERT INTO `become_seller_settings` (`id`, `content`, `status`, `created_at`, `updated_at`) VALUES
(21, '{\"login_register_section\":{\"register_title\":\"Create seller account.\",\"register_subtitle\":\"Enter your personal data to create your account\",\"login_title\":\"Login In\",\"login_subtitle\":\"Login in now\",\"agree_button_title\":\"I agree to the terms and conditions.\",\"social_button_enable_disable\":\"on\",\"background_image\":464,\"background_image_url\":null},\"on_board_section\":{\"title\":\"Why Start Selling on Bravo Mart?\",\"subtitle\":\"The first Unified Go-to-market Platform, Disrobed has all the tools you need to effortlessly run your sales organization\",\"steps\":[{\"title\":\"Get Started\",\"subtitle\":\"Sign up for free and begin your journey as a successful seller.\",\"image\":467},{\"title\":\"Build Your Store\",\"subtitle\":\"Customize your storefront, showcase your products, and attract customers.\",\"image\":470},{\"title\":\"Add Your Products\",\"subtitle\":\"List, manage, and optimize your inventory with ease.\",\"image\":472},{\"title\":\"Start Selling\",\"subtitle\":\"Connect with buyers, fulfill orders, and grow your sales.\",\"image\":468},{\"title\":\"Earn & Grow\",\"subtitle\":\"Boost your revenue and unlock new business opportunities.\",\"image\":469},{\"title\":\"Scale Your Business\",\"subtitle\":\"Sign up for free and begin your journey as a successful seller.\",\"image\":466}]},\"video_section\":{\"section_title\":\"What Customers are saying\",\"section_subtitle\":\"I\'ve never come across a platform that makes onboarding, scaling, and customization so effortless\\u2014seamlessly adapting to your workflow, team, clients, and evolving needs.\",\"video_url\":null},\"join_benefits_section\":{\"title\":\"Why Sell on Bravo Mart?\",\"subtitle\":\"Join thousands of successful sellers and grow your business with Bravo Mart powerful e-commerce platform.\",\"steps\":[{\"title\":\"Reach Millions of Customers\",\"subtitle\":\"Expand your business by connecting with a vast audience actively looking for products like yours.\",\"image\":477},{\"title\":\"Hassle-Free Registration\",\"subtitle\":\"Sign up effortlessly and start selling without any hidden fees or long approval processes.\",\"image\":476},{\"title\":\"Personalized Storefront\",\"subtitle\":\"Sign up for free and begin your journey as a successful seller.\",\"image\":475},{\"title\":\"Product Management\",\"subtitle\":\"Easily add, update, and manage your inventory with our intuitive seller dashboard.\",\"image\":474},{\"title\":\"Fast & Reliable Shipping\",\"subtitle\":\"Ensure smooth deliveries with SharpMart\\u2019s trusted logistics partners.\",\"image\":482},{\"title\":\"Secure & Timely Payments\",\"subtitle\":\"Get paid directly to your bank account with a transparent and reliable payment system.\",\"image\":481},{\"title\":\"Smart Marketing Tools\",\"subtitle\":\"Boost your sales with advertising, promotions, and data-driven marketing strategies.\",\"image\":null},{\"title\":\"Dedicated Seller Support\",\"subtitle\":\"Get expert guidance, training resources, and 24\\/7 assistance for your business.\",\"image\":null},{\"title\":\"Scale & Succeed\",\"subtitle\":\"Use data-driven analytics and business insights to optimize and expand your sales.\",\"image\":null}]},\"faq_section\":{\"title\":\"Frequently Ask Questions\",\"subtitle\":\"Key information and answers regarding our services and policies.\",\"steps\":[{\"question\":\"Get Started\",\"answer\":\"Sign up for free and begin your journey as a successful seller.\"},{\"question\":\"Build Your Store\",\"answer\":\"Customize your storefront, showcase your products, and attract customers.\"},{\"question\":\"Add Your Products\",\"answer\":\"List, manage, and optimize your inventory with ease.\"},{\"question\":\"Start Selling\",\"answer\":\"Connect with buyers, fulfill orders, and grow your sales.\"},{\"question\":\"Earn & Grow\",\"answer\":\"Boost your revenue and unlock new business opportunities.\"},{\"question\":\"Scale Your Business\",\"answer\":\"Sign up for free and begin your journey as a successful seller.\"}]},\"contact_section\":{\"title\":\"Need help? Our experts are here for you.\",\"subtitle\":\"Our experts are here to assist with any questions about our products, services, or more. Feel free to ask\\u2014we\'re ready to help! Let us make things easier for you.\",\"agree_button_title\":\"I would like to stay informed about future updates from Pickbazar. (You may unsubscribe at any time.)\",\"image\":465,\"image_url\":null}}', 1, '2025-03-12 21:29:15', '2025-05-22 09:24:18'),
(22, '{\"login_register_section\":{\"register_title\":\"Register Title\",\"register_subtitle\":\"Register Subtitle\",\"login_title\":\"Login Title\",\"login_subtitle\":\"Login SubTitle\",\"agree_button_title\":\"Agree button title\",\"social_button_enable_disable\":\"on\",\"background_image\":\"10\"},\"on_board_section\":{\"title\":\"Why Start Selling On BravoMart\",\"subtitle\":\"The first Unified Go-to-market Platform, Distrobird has all the tools you need to effortlessly run your sales organization.\",\"steps\":[{\"image\":\"10\",\"title\":\"Get Started\",\"subtitle\":\"Sign up for free and begin your journey as a successful seller.\"},{\"image\":\"10\",\"title\":\"Build Your Store\",\"subtitle\":\"Customize your storefront, showcase your products, and attract customers.\"}]},\"video_section\":{\"section_title\":\"What Customers are Saying\",\"section_subtitle\":\"Hear from our satisfied customers who have experienced seamless onboarding and scaling.\",\"video_url\":\"https:\\/\\/www.example.com\\/tutorial_video\"},\"join_benefits_section\":{\"title\":\"Why Sell on BravoMart?\",\"subtitle\":\"Join thousands of successful sellers and grow your business with SharpMart\\u2019s powerful e-commerce platform.\",\"steps\":[{\"image\":\"10\",\"title\":\"Reach Millions of Customers\",\"subtitle\":\"Expand your business by connecting with a vast audience actively looking for products like yours.\"},{\"image\":\"10\",\"title\":\"Hassle-Free Registration\",\"subtitle\":\"Sign up effortlessly and start selling without any hidden fees or long approval processes.\"}]},\"faq_section\":{\"title\":\"Frequently Asked Questions\",\"subtitle\":\"Key information and answers regarding our services and policies.\",\"steps\":[{\"question\":\"How is a project delivered upon completion?\",\"answer\":\"Expand your business by connecting with a vast audience actively looking for products like yours.\"},{\"question\":\"What is the registration process like?\",\"answer\":\"Sign up effortlessly and start selling without any hidden fees or long approval processes.\"}]},\"contact_section\":{\"image\":\"10\",\"title\":\"Contact Us\",\"subtitle\":\"If you have any questions, feel free to reach out to our support team.\",\"agree_button_title\":\"Submit\"}}', 1, '2025-03-12 22:00:08', '2025-03-12 22:00:08'),
(23, '{\"login_register_section\":{\"register_title\":\"Register Title\",\"register_subtitle\":\"Register Subtitle\",\"login_title\":\"Login Title\",\"login_subtitle\":\"Login SubTitle\",\"agree_button_title\":\"Agree button title\",\"social_button_enable_disable\":\"on\",\"background_image\":\"10\"},\"on_board_section\":{\"title\":\"Why Start Selling On BravoMart\",\"subtitle\":\"The first Unified Go-to-market Platform, Distrobird has all the tools you need to effortlessly run your sales organization.\",\"steps\":[{\"image\":\"10\",\"title\":\"Get Started\",\"subtitle\":\"Sign up for free and begin your journey as a successful seller.\"},{\"image\":\"10\",\"title\":\"Build Your Store\",\"subtitle\":\"Customize your storefront, showcase your products, and attract customers.\"}]},\"video_section\":{\"section_title\":\"What Customers are Saying\",\"section_subtitle\":\"Hear from our satisfied customers who have experienced seamless onboarding and scaling.\",\"video_url\":\"https:\\/\\/www.example.com\\/tutorial_video\"},\"join_benefits_section\":{\"title\":\"Why Sell on BravoMart?\",\"subtitle\":\"Join thousands of successful sellers and grow your business with SharpMart\\u2019s powerful e-commerce platform.\",\"steps\":[{\"image\":\"10\",\"title\":\"Reach Millions of Customers\",\"subtitle\":\"Expand your business by connecting with a vast audience actively looking for products like yours.\"},{\"image\":\"10\",\"title\":\"Hassle-Free Registration\",\"subtitle\":\"Sign up effortlessly and start selling without any hidden fees or long approval processes.\"}]},\"faq_section\":{\"title\":\"Frequently Asked Questions\",\"subtitle\":\"Key information and answers regarding our services and policies.\",\"steps\":[{\"question\":\"How is a project delivered upon completion?\",\"answer\":\"Expand your business by connecting with a vast audience actively looking for products like yours.\"},{\"question\":\"What is the registration process like?\",\"answer\":\"Sign up effortlessly and start selling without any hidden fees or long approval processes.\"}]},\"contact_section\":{\"image\":\"10\",\"title\":\"Contact Us\",\"subtitle\":\"If you have any questions, feel free to reach out to our support team.\",\"agree_button_title\":\"Submit\"}}', 1, '2025-03-12 22:01:24', '2025-03-12 22:01:24'),
(24, '{\"gdpr_basic_section\":{\"com_gdpr_enable_disable\":\"on\"},\"gdpr_more_info_section\":{\"steps\":[{\"title\":\"What are cookies1?\",\"subtitle\":\"Cookies are small text files stored on your device to help us remember your preferences and activity1.\",\"image\":null},{\"title\":\"What are cookies2?\",\"subtitle\":\"Cookies are small text files stored on your device to help us remember your preferences and activity2.\",\"image\":null}]}}', 1, '2025-05-27 09:14:20', '2025-05-27 09:14:20');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `visibility` enum('public','private') NOT NULL DEFAULT 'public' COMMENT 'allowed only = private , public',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = draft, 1 = published',
  `schedule_date` timestamp NULL DEFAULT NULL,
  `tag_name` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = Inactive, 1 = Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` longtext NOT NULL,
  `like_count` int(11) NOT NULL DEFAULT 0,
  `dislike_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comment_reactions`
--

CREATE TABLE `blog_comment_reactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_comment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reaction_type` enum('like','dislike') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_views`
--

CREATE TABLE `blog_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('com_canonical_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"103\";s:11:\"option_name\";s:17:\"com_canonical_url\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-05-22 09:49:27\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"103\";s:11:\"option_name\";s:17:\"com_canonical_url\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-05-22 09:49:27\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751199773),
('com_download_app_link_one', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"26\";s:11:\"option_name\";s:25:\"com_download_app_link_one\";s:12:\"option_value\";s:24:\"https://example.com/app1\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"26\";s:11:\"option_name\";s:25:\"com_download_app_link_one\";s:12:\"option_value\";s:24:\"https://example.com/app1\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_download_app_link_two', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"27\";s:11:\"option_name\";s:25:\"com_download_app_link_two\";s:12:\"option_value\";s:24:\"https://example.com/app2\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:27\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"27\";s:11:\"option_name\";s:25:\"com_download_app_link_two\";s:12:\"option_value\";s:24:\"https://example.com/app2\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:27\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_facebook_app_id', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"83\";s:11:\"option_name\";s:19:\"com_facebook_app_id\";s:12:\"option_value\";s:15:\"657727896942404\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:35:17\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"83\";s:11:\"option_name\";s:19:\"com_facebook_app_id\";s:12:\"option_value\";s:15:\"657727896942404\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:35:17\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258901),
('com_facebook_client_callback_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"85\";s:11:\"option_name\";s:32:\"com_facebook_client_callback_url\";s:12:\"option_value\";s:65:\"https://bravomartapi.bravo-soft.com/api/v1/auth/facebook/callback\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:37:08\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"85\";s:11:\"option_name\";s:32:\"com_facebook_client_callback_url\";s:12:\"option_value\";s:65:\"https://bravomartapi.bravo-soft.com/api/v1/auth/facebook/callback\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:37:08\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258901),
('com_facebook_client_secret', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"84\";s:11:\"option_name\";s:26:\"com_facebook_client_secret\";s:12:\"option_value\";s:32:\"036cf21cc49f37f130e6ee1a99f334b4\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:35:17\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"84\";s:11:\"option_name\";s:26:\"com_facebook_client_secret\";s:12:\"option_value\";s:32:\"036cf21cc49f37f130e6ee1a99f334b4\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:35:17\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258901),
('com_facebook_login_enabled', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"82\";s:11:\"option_name\";s:26:\"com_facebook_login_enabled\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-05-22 10:13:28\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"82\";s:11:\"option_name\";s:26:\"com_facebook_login_enabled\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-05-22 10:13:28\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751180230),
('com_google_app_id', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"79\";s:11:\"option_name\";s:17:\"com_google_app_id\";s:12:\"option_value\";s:72:\"483247466424-makrg9bs86r4vup300m3p3r63tpaa9v0.apps.googleusercontent.com\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:15:05\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"79\";s:11:\"option_name\";s:17:\"com_google_app_id\";s:12:\"option_value\";s:72:\"483247466424-makrg9bs86r4vup300m3p3r63tpaa9v0.apps.googleusercontent.com\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:15:05\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258901),
('com_google_client_callback_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"81\";s:11:\"option_name\";s:30:\"com_google_client_callback_url\";s:12:\"option_value\";s:63:\"https://bravomartapi.bravo-soft.com/api/v1/auth/google/callback\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:37:08\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"81\";s:11:\"option_name\";s:30:\"com_google_client_callback_url\";s:12:\"option_value\";s:63:\"https://bravomartapi.bravo-soft.com/api/v1/auth/google/callback\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:37:08\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258901),
('com_google_client_secret', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"80\";s:11:\"option_name\";s:24:\"com_google_client_secret\";s:12:\"option_value\";s:35:\"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\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:15:05\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"80\";s:11:\"option_name\";s:24:\"com_google_client_secret\";s:12:\"option_value\";s:35:\"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\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-04-06 03:15:05\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258901),
('com_google_login_enabled', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"78\";s:11:\"option_name\";s:24:\"com_google_login_enabled\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-05-22 10:13:28\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"78\";s:11:\"option_name\";s:24:\"com_google_login_enabled\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-06 03:15:05\";s:10:\"updated_at\";s:19:\"2025-05-22 10:13:28\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751180230),
('com_google_map_api_key', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"114\";s:11:\"option_name\";s:22:\"com_google_map_api_key\";s:12:\"option_value\";s:39:\"AIzaSyDiXtMtd2RjwKX7WJIajejDn1c5oNAvrm4\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-22 09:52:16\";s:10:\"updated_at\";s:19:\"2025-05-25 06:02:54\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"114\";s:11:\"option_name\";s:22:\"com_google_map_api_key\";s:12:\"option_value\";s:39:\"AIzaSyDiXtMtd2RjwKX7WJIajejDn1c5oNAvrm4\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-22 09:52:16\";s:10:\"updated_at\";s:19:\"2025-05-25 06:02:54\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258805),
('com_google_map_enable_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"113\";s:11:\"option_name\";s:29:\"com_google_map_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-22 09:52:16\";s:10:\"updated_at\";s:19:\"2025-05-25 06:05:08\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"113\";s:11:\"option_name\";s:29:\"com_google_map_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-22 09:52:16\";s:10:\"updated_at\";s:19:\"2025-05-25 06:05:08\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258805),
('com_google_recaptcha_enable_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"109\";s:11:\"option_name\";s:35:\"com_google_recaptcha_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-12 06:06:26\";s:10:\"updated_at\";s:19:\"2025-05-12 07:06:40\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"109\";s:11:\"option_name\";s:35:\"com_google_recaptcha_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-12 06:06:26\";s:10:\"updated_at\";s:19:\"2025-05-12 07:06:40\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_google_recaptcha_v3_secret_key', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"108\";s:11:\"option_name\";s:34:\"com_google_recaptcha_v3_secret_key\";s:12:\"option_value\";s:40:\"6LceTzYrAAAAACtNGBaKKcgEloInr_CDci7jwzm6\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-12 06:06:26\";s:10:\"updated_at\";s:19:\"2025-05-12 06:06:26\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"108\";s:11:\"option_name\";s:34:\"com_google_recaptcha_v3_secret_key\";s:12:\"option_value\";s:40:\"6LceTzYrAAAAACtNGBaKKcgEloInr_CDci7jwzm6\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-12 06:06:26\";s:10:\"updated_at\";s:19:\"2025-05-12 06:06:26\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_google_recaptcha_v3_site_key', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"107\";s:11:\"option_name\";s:32:\"com_google_recaptcha_v3_site_key\";s:12:\"option_value\";s:24:\"1x00000000000000000000AA\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-12 06:06:26\";s:10:\"updated_at\";s:19:\"2025-05-29 03:40:55\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"107\";s:11:\"option_name\";s:32:\"com_google_recaptcha_v3_site_key\";s:12:\"option_value\";s:24:\"1x00000000000000000000AA\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-12 06:06:26\";s:10:\"updated_at\";s:19:\"2025-05-29 03:40:55\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_help_center', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"112\";s:11:\"option_name\";s:15:\"com_help_center\";s:12:\"option_value\";s:106:\"[{\"title\":\"Payments\",\"url\":\"fdsf\"},{\"title\":\"Shipping\",\"url\":\"ddsf\"},{\"title\":\"Return Policy\",\"url\":null}]\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-19 06:20:41\";s:10:\"updated_at\";s:19:\"2025-05-19 07:01:42\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"112\";s:11:\"option_name\";s:15:\"com_help_center\";s:12:\"option_value\";s:106:\"[{\"title\":\"Payments\",\"url\":\"fdsf\"},{\"title\":\"Shipping\",\"url\":\"ddsf\"},{\"title\":\"Return Policy\",\"url\":null}]\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-05-19 06:20:41\";s:10:\"updated_at\";s:19:\"2025-05-19 07:01:42\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_home_one_category_button_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"115\";s:11:\"option_name\";s:34:\"com_home_one_category_button_title\";s:12:\"option_value\";s:14:\"All Categories\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 11:06:58\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"115\";s:11:\"option_name\";s:34:\"com_home_one_category_button_title\";s:12:\"option_value\";s:14:\"All Categories\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 11:06:58\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258805),
('com_home_one_category_section_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"117\";s:11:\"option_name\";s:35:\"com_home_one_category_section_title\";s:12:\"option_value\";s:18:\"Shop by Categories\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"117\";s:11:\"option_name\";s:35:\"com_home_one_category_section_title\";s:12:\"option_value\";s:18:\"Shop by Categories\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258806);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('com_home_one_featured_section_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"119\";s:11:\"option_name\";s:35:\"com_home_one_featured_section_title\";s:12:\"option_value\";s:8:\"Featured\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:01:58\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"119\";s:11:\"option_name\";s:35:\"com_home_one_featured_section_title\";s:12:\"option_value\";s:8:\"Featured\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:01:58\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258806),
('com_home_one_flash_sale_section_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"118\";s:11:\"option_name\";s:37:\"com_home_one_flash_sale_section_title\";s:12:\"option_value\";s:10:\"Flash Sale\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"118\";s:11:\"option_name\";s:37:\"com_home_one_flash_sale_section_title\";s:12:\"option_value\";s:10:\"Flash Sale\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258806),
('com_home_one_latest_product_section_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"121\";s:11:\"option_name\";s:41:\"com_home_one_latest_product_section_title\";s:12:\"option_value\";s:17:\"Latest Essentials\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"121\";s:11:\"option_name\";s:41:\"com_home_one_latest_product_section_title\";s:12:\"option_value\";s:17:\"Latest Essentials\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258806),
('com_home_one_popular_product_section_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"122\";s:11:\"option_name\";s:42:\"com_home_one_popular_product_section_title\";s:12:\"option_value\";s:15:\"Popular Product\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"122\";s:11:\"option_name\";s:42:\"com_home_one_popular_product_section_title\";s:12:\"option_value\";s:15:\"Popular Product\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258806),
('com_home_one_store_button_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"116\";s:11:\"option_name\";s:31:\"com_home_one_store_button_title\";s:12:\"option_value\";s:19:\"Explore Store Types\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 11:06:58\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"116\";s:11:\"option_name\";s:31:\"com_home_one_store_button_title\";s:12:\"option_value\";s:19:\"Explore Store Types\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 11:06:58\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258806),
('com_home_one_top_selling_section_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"120\";s:11:\"option_name\";s:38:\"com_home_one_top_selling_section_title\";s:12:\"option_value\";s:11:\"Top Selling\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"120\";s:11:\"option_name\";s:38:\"com_home_one_top_selling_section_title\";s:12:\"option_value\";s:11:\"Top Selling\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258806),
('com_home_one_top_store_section_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"123\";s:11:\"option_name\";s:36:\"com_home_one_top_store_section_title\";s:12:\"option_value\";s:21:\"Top Store Collections\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"123\";s:11:\"option_name\";s:36:\"com_home_one_top_store_section_title\";s:12:\"option_value\";s:21:\"Top Store Collections\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-15 06:30:05\";s:10:\"updated_at\";s:19:\"2025-06-15 07:00:04\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258806),
('com_login_page_image', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"57\";s:11:\"option_name\";s:20:\"com_login_page_image\";s:12:\"option_value\";s:3:\"501\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:12:53\";s:10:\"updated_at\";s:19:\"2025-03-18 22:31:52\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"57\";s:11:\"option_name\";s:20:\"com_login_page_image\";s:12:\"option_value\";s:3:\"501\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:12:53\";s:10:\"updated_at\";s:19:\"2025-03-18 22:31:52\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258895),
('com_login_page_social_enable_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"58\";s:11:\"option_name\";s:36:\"com_login_page_social_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:12:53\";s:10:\"updated_at\";s:19:\"2025-05-22 10:08:03\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"58\";s:11:\"option_name\";s:36:\"com_login_page_social_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:12:53\";s:10:\"updated_at\";s:19:\"2025-05-22 10:08:03\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258895),
('com_login_page_subtitle', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"56\";s:11:\"option_name\";s:23:\"com_login_page_subtitle\";s:12:\"option_value\";s:17:\"Continue Shopping\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:12:53\";s:10:\"updated_at\";s:19:\"2025-03-19 02:21:22\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"56\";s:11:\"option_name\";s:23:\"com_login_page_subtitle\";s:12:\"option_value\";s:17:\"Continue Shopping\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:12:53\";s:10:\"updated_at\";s:19:\"2025-03-19 02:21:22\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258895),
('com_login_page_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"55\";s:11:\"option_name\";s:20:\"com_login_page_title\";s:12:\"option_value\";s:7:\"Sign In\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:12:53\";s:10:\"updated_at\";s:19:\"2025-03-18 22:22:25\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"55\";s:11:\"option_name\";s:20:\"com_login_page_title\";s:12:\"option_value\";s:7:\"Sign In\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:12:53\";s:10:\"updated_at\";s:19:\"2025-03-18 22:22:25\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258895),
('com_maintenance_description', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"96\";s:11:\"option_name\";s:27:\"com_maintenance_description\";s:12:\"option_value\";s:184:\"Our website is currently undergoing scheduled maintenance.\r\nWe’re working hard to bring everything back online as quickly as possible.\r\nThank you for your patience and understanding.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:08:32\";s:10:\"updated_at\";s:19:\"2025-05-25 08:12:26\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"96\";s:11:\"option_name\";s:27:\"com_maintenance_description\";s:12:\"option_value\";s:184:\"Our website is currently undergoing scheduled maintenance.\r\nWe’re working hard to bring everything back online as quickly as possible.\r\nThank you for your patience and understanding.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:08:32\";s:10:\"updated_at\";s:19:\"2025-05-25 08:12:26\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258865),
('com_maintenance_end_date', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"98\";s:11:\"option_name\";s:24:\"com_maintenance_end_date\";s:12:\"option_value\";s:24:\"2025-04-19T18:00:00.000Z\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:08:32\";s:10:\"updated_at\";s:19:\"2025-06-18 03:12:41\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"98\";s:11:\"option_name\";s:24:\"com_maintenance_end_date\";s:12:\"option_value\";s:24:\"2025-04-19T18:00:00.000Z\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:08:32\";s:10:\"updated_at\";s:19:\"2025-06-18 03:12:41\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258865),
('com_maintenance_image', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"99\";s:11:\"option_name\";s:21:\"com_maintenance_image\";s:12:\"option_value\";s:3:\"832\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:08:32\";s:10:\"updated_at\";s:19:\"2025-05-25 07:15:34\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"99\";s:11:\"option_name\";s:21:\"com_maintenance_image\";s:12:\"option_value\";s:3:\"832\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:08:32\";s:10:\"updated_at\";s:19:\"2025-05-25 07:15:34\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258865),
('com_maintenance_mode', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:1:\"7\";s:11:\"option_name\";s:20:\"com_maintenance_mode\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-05-22 08:04:59\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:1:\"7\";s:11:\"option_name\";s:20:\"com_maintenance_mode\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-05-22 08:04:59\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_maintenance_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"95\";s:11:\"option_name\";s:21:\"com_maintenance_title\";s:12:\"option_value\";s:21:\"We’ll Be Back Soon!\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:08:32\";s:10:\"updated_at\";s:19:\"2025-05-25 08:12:26\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"95\";s:11:\"option_name\";s:21:\"com_maintenance_title\";s:12:\"option_value\";s:21:\"We’ll Be Back Soon!\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:08:32\";s:10:\"updated_at\";s:19:\"2025-05-25 08:12:26\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258865),
('com_meta_description', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"101\";s:11:\"option_name\";s:20:\"com_meta_description\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-04-30 09:44:21\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"101\";s:11:\"option_name\";s:20:\"com_meta_description\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-04-30 09:44:21\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751199773),
('com_meta_tags', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"102\";s:11:\"option_name\";s:13:\"com_meta_tags\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-05-22 09:49:27\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"102\";s:11:\"option_name\";s:13:\"com_meta_tags\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-05-22 09:49:27\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751199773),
('com_meta_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"100\";s:11:\"option_name\";s:14:\"com_meta_title\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-04-30 09:44:21\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"100\";s:11:\"option_name\";s:14:\"com_meta_title\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-04-30 09:44:21\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751199773);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('com_og_description', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"105\";s:11:\"option_name\";s:18:\"com_og_description\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-04-30 09:44:21\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"105\";s:11:\"option_name\";s:18:\"com_og_description\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-04-30 09:44:21\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751199773),
('com_og_image', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"106\";s:11:\"option_name\";s:12:\"com_og_image\";s:12:\"option_value\";s:3:\"663\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-04-30 09:44:21\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"106\";s:11:\"option_name\";s:12:\"com_og_image\";s:12:\"option_value\";s:3:\"663\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-04-30 09:44:21\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751199773),
('com_og_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"104\";s:11:\"option_name\";s:12:\"com_og_title\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-04-30 09:44:21\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"104\";s:11:\"option_name\";s:12:\"com_og_title\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-30 09:44:21\";s:10:\"updated_at\";s:19:\"2025-04-30 09:44:21\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751199773),
('com_our_info', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"77\";s:11:\"option_name\";s:12:\"com_our_info\";s:12:\"option_value\";s:227:\"[{\"title\":\"Privacy Policy\",\"url\":\"http:\\/\\/192.168.88.225:3010\\/privacy-policy\"},{\"title\":\"Terms and conditions\",\"url\":\"http:\\/\\/192.168.88.225:3010\\/terms-conditions\"},{\"title\":\"FAQ\",\"url\":\"http:\\/\\/192.168.88.225:3010\\/faq\"}]\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-25 02:45:25\";s:10:\"updated_at\";s:19:\"2025-05-19 05:09:50\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"77\";s:11:\"option_name\";s:12:\"com_our_info\";s:12:\"option_value\";s:227:\"[{\"title\":\"Privacy Policy\",\"url\":\"http:\\/\\/192.168.88.225:3010\\/privacy-policy\"},{\"title\":\"Terms and conditions\",\"url\":\"http:\\/\\/192.168.88.225:3010\\/terms-conditions\"},{\"title\":\"FAQ\",\"url\":\"http:\\/\\/192.168.88.225:3010\\/faq\"}]\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-25 02:45:25\";s:10:\"updated_at\";s:19:\"2025-05-19 05:09:50\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_our_info_enable_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"14\";s:11:\"option_name\";s:27:\"com_our_info_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-03-25 02:40:00\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"14\";s:11:\"option_name\";s:27:\"com_our_info_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-03-25 02:40:00\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_our_info_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"16\";s:11:\"option_name\";s:18:\"com_our_info_title\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"16\";s:11:\"option_name\";s:18:\"com_our_info_title\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_payment_methods_enable_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"28\";s:11:\"option_name\";s:34:\"com_payment_methods_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:27\";s:10:\"updated_at\";s:19:\"2025-04-15 11:48:47\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"28\";s:11:\"option_name\";s:34:\"com_payment_methods_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:27\";s:10:\"updated_at\";s:19:\"2025-04-15 11:48:47\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_payment_methods_image', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"29\";s:11:\"option_name\";s:25:\"com_payment_methods_image\";s:12:\"option_value\";s:15:\"734,737,732,733\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:27\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"29\";s:11:\"option_name\";s:25:\"com_payment_methods_image\";s:12:\"option_value\";s:15:\"734,737,732,733\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:27\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_product_details_page_delivery_enable_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"62\";s:11:\"option_name\";s:48:\"com_product_details_page_delivery_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 00:42:42\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"62\";s:11:\"option_name\";s:48:\"com_product_details_page_delivery_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 00:42:42\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751195891),
('com_product_details_page_delivery_subtitle', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"60\";s:11:\"option_name\";s:42:\"com_product_details_page_delivery_subtitle\";s:12:\"option_value\";s:47:\"Will ship to Bangladesh. Read item description.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 22:36:12\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"60\";s:11:\"option_name\";s:42:\"com_product_details_page_delivery_subtitle\";s:12:\"option_value\";s:47:\"Will ship to Bangladesh. Read item description.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 22:36:12\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751195891),
('com_product_details_page_delivery_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"59\";s:11:\"option_name\";s:39:\"com_product_details_page_delivery_title\";s:12:\"option_value\";s:13:\"Free Delivery\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 22:38:07\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"59\";s:11:\"option_name\";s:39:\"com_product_details_page_delivery_title\";s:12:\"option_value\";s:13:\"Free Delivery\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 22:38:07\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751195891),
('com_product_details_page_delivery_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"61\";s:11:\"option_name\";s:37:\"com_product_details_page_delivery_url\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 23:12:23\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"61\";s:11:\"option_name\";s:37:\"com_product_details_page_delivery_url\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 23:12:23\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751195891),
('com_product_details_page_related_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"67\";s:11:\"option_name\";s:38:\"com_product_details_page_related_title\";s:12:\"option_value\";s:15:\"Related Product\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-04-13 04:46:05\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"67\";s:11:\"option_name\";s:38:\"com_product_details_page_related_title\";s:12:\"option_value\";s:15:\"Related Product\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-04-13 04:46:05\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751195891),
('com_product_details_page_return_refund_enable_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"66\";s:11:\"option_name\";s:53:\"com_product_details_page_return_refund_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 00:42:42\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"66\";s:11:\"option_name\";s:53:\"com_product_details_page_return_refund_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 00:42:42\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751195891),
('com_product_details_page_return_refund_subtitle', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"64\";s:11:\"option_name\";s:47:\"com_product_details_page_return_refund_subtitle\";s:12:\"option_value\";s:49:\"30 days returns. Buyer pays for return shipping.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 22:36:13\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"64\";s:11:\"option_name\";s:47:\"com_product_details_page_return_refund_subtitle\";s:12:\"option_value\";s:49:\"30 days returns. Buyer pays for return shipping.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 22:36:13\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751195891),
('com_product_details_page_return_refund_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"63\";s:11:\"option_name\";s:44:\"com_product_details_page_return_refund_title\";s:12:\"option_value\";s:20:\"Easy Return & Refund\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 22:36:12\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"63\";s:11:\"option_name\";s:44:\"com_product_details_page_return_refund_title\";s:12:\"option_value\";s:20:\"Easy Return & Refund\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 22:36:12\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751195891),
('com_product_details_page_return_refund_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"65\";s:11:\"option_name\";s:42:\"com_product_details_page_return_refund_url\";s:12:\"option_value\";s:6:\"fb.com\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 22:36:13\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"65\";s:11:\"option_name\";s:42:\"com_product_details_page_return_refund_url\";s:12:\"option_value\";s:6:\"fb.com\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 00:42:42\";s:10:\"updated_at\";s:19:\"2025-03-18 22:36:13\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751195891),
('com_quick_access', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"76\";s:11:\"option_name\";s:16:\"com_quick_access\";s:12:\"option_value\";s:524:\"[{\"com_quick_access_title\":\"Home\",\"com_quick_access_url\":\"https:\\/\\/example.com 666\"},{\"com_quick_access_title\":\"About Us\",\"com_quick_access_url\":\"https:\\/\\/example.com\\/contact777\"},{\"com_quick_access_title\":\"Contact Us\",\"com_quick_access_url\":\"https:\\/\\/example.com\\/contact777\"},{\"com_quick_access_title\":\"Blog\",\"com_quick_access_url\":null},{\"com_quick_access_title\":\"Coupon\",\"com_quick_access_url\":null},{\"com_quick_access_title\":\"Become A Seller\",\"com_quick_access_url\":\"http:\\/\\/192.168.88.225:3000\\/become-a-seller\"}]\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-25 02:40:00\";s:10:\"updated_at\";s:19:\"2025-05-19 07:03:08\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"76\";s:11:\"option_name\";s:16:\"com_quick_access\";s:12:\"option_value\";s:524:\"[{\"com_quick_access_title\":\"Home\",\"com_quick_access_url\":\"https:\\/\\/example.com 666\"},{\"com_quick_access_title\":\"About Us\",\"com_quick_access_url\":\"https:\\/\\/example.com\\/contact777\"},{\"com_quick_access_title\":\"Contact Us\",\"com_quick_access_url\":\"https:\\/\\/example.com\\/contact777\"},{\"com_quick_access_title\":\"Blog\",\"com_quick_access_url\":null},{\"com_quick_access_title\":\"Coupon\",\"com_quick_access_url\":null},{\"com_quick_access_title\":\"Become A Seller\",\"com_quick_access_url\":\"http:\\/\\/192.168.88.225:3000\\/become-a-seller\"}]\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-25 02:40:00\";s:10:\"updated_at\";s:19:\"2025-05-19 07:03:08\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_quick_access_enable_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"13\";s:11:\"option_name\";s:31:\"com_quick_access_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-03-25 02:40:00\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"13\";s:11:\"option_name\";s:31:\"com_quick_access_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-03-25 02:40:00\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('com_quick_access_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"15\";s:11:\"option_name\";s:22:\"com_quick_access_title\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"15\";s:11:\"option_name\";s:22:\"com_quick_access_title\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_register_page_description', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"50\";s:11:\"option_name\";s:29:\"com_register_page_description\";s:12:\"option_value\";s:140:\"Sign up now to explore a wide range of products from multiple stores, enjoy seamless shopping, secure transactions, and exclusive discounts.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:26\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"50\";s:11:\"option_name\";s:29:\"com_register_page_description\";s:12:\"option_value\";s:140:\"Sign up now to explore a wide range of products from multiple stores, enjoy seamless shopping, secure transactions, and exclusive discounts.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:26\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751255029),
('com_register_page_image', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"51\";s:11:\"option_name\";s:23:\"com_register_page_image\";s:12:\"option_value\";s:3:\"501\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:33:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"51\";s:11:\"option_name\";s:23:\"com_register_page_image\";s:12:\"option_value\";s:3:\"501\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:33:32\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751255029),
('com_register_page_social_enable_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"54\";s:11:\"option_name\";s:39:\"com_register_page_social_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:27\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"54\";s:11:\"option_name\";s:39:\"com_register_page_social_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:27\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751255029),
('com_register_page_subtitle', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"49\";s:11:\"option_name\";s:26:\"com_register_page_subtitle\";s:12:\"option_value\";s:45:\"Join Bravo for an Amazing Shopping Experience\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:26\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"49\";s:11:\"option_name\";s:26:\"com_register_page_subtitle\";s:12:\"option_value\";s:45:\"Join Bravo for an Amazing Shopping Experience\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:26\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751255029),
('com_register_page_terms_page', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"52\";s:11:\"option_name\";s:28:\"com_register_page_terms_page\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:26\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"52\";s:11:\"option_name\";s:28:\"com_register_page_terms_page\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:26\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751255029),
('com_register_page_terms_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"53\";s:11:\"option_name\";s:29:\"com_register_page_terms_title\";s:12:\"option_value\";s:18:\"Terms & Conditions\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:27\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"53\";s:11:\"option_name\";s:29:\"com_register_page_terms_title\";s:12:\"option_value\";s:18:\"Terms & Conditions\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:27\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751255029),
('com_register_page_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"48\";s:11:\"option_name\";s:23:\"com_register_page_title\";s:12:\"option_value\";s:12:\"Sign Up Now!\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:26\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"48\";s:11:\"option_name\";s:23:\"com_register_page_title\";s:12:\"option_value\";s:12:\"Sign Up Now!\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-17 22:20:27\";s:10:\"updated_at\";s:19:\"2025-03-18 22:18:26\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751255029),
('com_seller_login_page_image', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"72\";s:11:\"option_name\";s:27:\"com_seller_login_page_image\";s:12:\"option_value\";s:3:\"570\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 22:31:53\";s:10:\"updated_at\";s:19:\"2025-04-06 02:27:49\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"72\";s:11:\"option_name\";s:27:\"com_seller_login_page_image\";s:12:\"option_value\";s:3:\"570\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 22:31:53\";s:10:\"updated_at\";s:19:\"2025-04-06 02:27:49\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258895),
('com_seller_login_page_social_enable_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"73\";s:11:\"option_name\";s:43:\"com_seller_login_page_social_enable_disable\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 22:31:53\";s:10:\"updated_at\";s:19:\"2025-04-05 23:13:40\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"73\";s:11:\"option_name\";s:43:\"com_seller_login_page_social_enable_disable\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 22:31:53\";s:10:\"updated_at\";s:19:\"2025-04-05 23:13:40\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258895),
('com_seller_login_page_subtitle', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"71\";s:11:\"option_name\";s:30:\"com_seller_login_page_subtitle\";s:12:\"option_value\";s:46:\"Sign in to oversee your multivendor ecosystem.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 22:31:53\";s:10:\"updated_at\";s:19:\"2025-04-06 02:33:15\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"71\";s:11:\"option_name\";s:30:\"com_seller_login_page_subtitle\";s:12:\"option_value\";s:46:\"Sign in to oversee your multivendor ecosystem.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 22:31:53\";s:10:\"updated_at\";s:19:\"2025-04-06 02:33:15\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258895),
('com_seller_login_page_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"70\";s:11:\"option_name\";s:27:\"com_seller_login_page_title\";s:12:\"option_value\";s:29:\"Sign in to Bravo Mart Account\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 22:31:53\";s:10:\"updated_at\";s:19:\"2025-04-06 02:33:15\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"70\";s:11:\"option_name\";s:27:\"com_seller_login_page_title\";s:12:\"option_value\";s:29:\"Sign in to Bravo Mart Account\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-18 22:31:53\";s:10:\"updated_at\";s:19:\"2025-04-06 02:33:15\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258895),
('com_site_comma_form_adjustment_amount', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"32\";s:11:\"option_name\";s:37:\"com_site_comma_form_adjustment_amount\";s:12:\"option_value\";s:3:\"YES\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:21\";s:10:\"updated_at\";s:19:\"2025-03-12 01:00:21\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"32\";s:11:\"option_name\";s:37:\"com_site_comma_form_adjustment_amount\";s:12:\"option_value\";s:3:\"YES\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:21\";s:10:\"updated_at\";s:19:\"2025-03-12 01:00:21\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751259004),
('com_site_contact_number', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:1:\"9\";s:11:\"option_name\";s:23:\"com_site_contact_number\";s:12:\"option_value\";s:17:\"+1 (800) 555-0199\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:44\";s:10:\"updated_at\";s:19:\"2025-03-25 02:29:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:1:\"9\";s:11:\"option_name\";s:23:\"com_site_contact_number\";s:12:\"option_value\";s:17:\"+1 (800) 555-0199\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:44\";s:10:\"updated_at\";s:19:\"2025-03-25 02:29:32\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_site_currency_symbol_position', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"46\";s:11:\"option_name\";s:33:\"com_site_currency_symbol_position\";s:12:\"option_value\";s:4:\"left\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:21\";s:10:\"updated_at\";s:19:\"2025-04-20 03:11:07\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"46\";s:11:\"option_name\";s:33:\"com_site_currency_symbol_position\";s:12:\"option_value\";s:4:\"left\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:21\";s:10:\"updated_at\";s:19:\"2025-04-20 03:11:07\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751259003),
('com_site_default_currency_to_usd_exchange_rate', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"33\";s:11:\"option_name\";s:46:\"com_site_default_currency_to_usd_exchange_rate\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:21\";s:10:\"updated_at\";s:19:\"2025-03-12 01:00:21\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"33\";s:11:\"option_name\";s:46:\"com_site_default_currency_to_usd_exchange_rate\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:21\";s:10:\"updated_at\";s:19:\"2025-03-12 01:00:21\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751259004),
('com_site_email', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"11\";s:11:\"option_name\";s:14:\"com_site_email\";s:12:\"option_value\";s:21:\"support@bravomart.com\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:44\";s:10:\"updated_at\";s:19:\"2025-03-25 02:29:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"11\";s:11:\"option_name\";s:14:\"com_site_email\";s:12:\"option_value\";s:21:\"support@bravomart.com\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:44\";s:10:\"updated_at\";s:19:\"2025-03-25 02:29:32\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_site_enable_disable_decimal_point', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"31\";s:11:\"option_name\";s:37:\"com_site_enable_disable_decimal_point\";s:12:\"option_value\";s:3:\"YES\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:21\";s:10:\"updated_at\";s:19:\"2025-03-12 01:00:21\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"31\";s:11:\"option_name\";s:37:\"com_site_enable_disable_decimal_point\";s:12:\"option_value\";s:3:\"YES\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:21\";s:10:\"updated_at\";s:19:\"2025-03-12 01:00:21\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751259004),
('com_site_favicon', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:1:\"2\";s:11:\"option_name\";s:16:\"com_site_favicon\";s:12:\"option_value\";s:3:\"617\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-04-15 07:06:06\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:1:\"2\";s:11:\"option_name\";s:16:\"com_site_favicon\";s:12:\"option_value\";s:3:\"617\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-04-15 07:06:06\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('com_site_footer_copyright', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"12\";s:11:\"option_name\";s:25:\"com_site_footer_copyright\";s:12:\"option_value\";s:40:\"© 2025 Bravo Mart. All Rights Reserved.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:44\";s:10:\"updated_at\";s:19:\"2025-03-25 02:29:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"12\";s:11:\"option_name\";s:25:\"com_site_footer_copyright\";s:12:\"option_value\";s:40:\"© 2025 Bravo Mart. All Rights Reserved.\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:44\";s:10:\"updated_at\";s:19:\"2025-03-25 02:29:32\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_site_full_address', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:1:\"8\";s:11:\"option_name\";s:21:\"com_site_full_address\";s:12:\"option_value\";s:28:\"100 Main Street, Los Angeles\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:44\";s:10:\"updated_at\";s:19:\"2025-03-25 02:29:32\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:1:\"8\";s:11:\"option_name\";s:21:\"com_site_full_address\";s:12:\"option_value\";s:28:\"100 Main Street, Los Angeles\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:44\";s:10:\"updated_at\";s:19:\"2025-03-25 02:29:32\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_site_global_currency', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"47\";s:11:\"option_name\";s:24:\"com_site_global_currency\";s:12:\"option_value\";s:3:\"USD\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:21\";s:10:\"updated_at\";s:19:\"2025-04-19 11:48:16\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"47\";s:11:\"option_name\";s:24:\"com_site_global_currency\";s:12:\"option_value\";s:3:\"USD\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:21\";s:10:\"updated_at\";s:19:\"2025-04-19 11:48:16\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751259003),
('com_site_logo', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:1:\"1\";s:11:\"option_name\";s:13:\"com_site_logo\";s:12:\"option_value\";s:3:\"620\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-04-15 08:56:49\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:1:\"1\";s:11:\"option_name\";s:13:\"com_site_logo\";s:12:\"option_value\";s:3:\"620\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-04-15 08:56:49\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_site_space_between_amount_and_symbol', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"30\";s:11:\"option_name\";s:40:\"com_site_space_between_amount_and_symbol\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:20\";s:10:\"updated_at\";s:19:\"2025-03-12 01:00:20\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"30\";s:11:\"option_name\";s:40:\"com_site_space_between_amount_and_symbol\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-12 01:00:20\";s:10:\"updated_at\";s:19:\"2025-03-12 01:00:20\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751259004),
('com_site_subtitle', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:1:\"4\";s:11:\"option_name\";s:17:\"com_site_subtitle\";s:12:\"option_value\";s:22:\"Shop Smart, Shop Bravo\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-05-22 08:04:49\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:1:\"4\";s:11:\"option_name\";s:17:\"com_site_subtitle\";s:12:\"option_value\";s:22:\"Shop Smart, Shop Bravo\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-05-22 08:04:49\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_site_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:1:\"3\";s:11:\"option_name\";s:14:\"com_site_title\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-04-15 08:07:55\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:1:\"3\";s:11:\"option_name\";s:14:\"com_site_title\";s:12:\"option_value\";s:10:\"Bravo Mart\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-04-15 08:07:55\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_site_website_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"10\";s:11:\"option_name\";s:20:\"com_site_website_url\";s:12:\"option_value\";s:32:\"https://bravomart.bravo-soft.com\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:44\";s:10:\"updated_at\";s:19:\"2025-03-25 02:31:37\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"10\";s:11:\"option_name\";s:20:\"com_site_website_url\";s:12:\"option_value\";s:32:\"https://bravomart.bravo-soft.com\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:44\";s:10:\"updated_at\";s:19:\"2025-03-25 02:31:37\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_site_white_logo', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"86\";s:11:\"option_name\";s:19:\"com_site_white_logo\";s:12:\"option_value\";s:3:\"621\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-15 06:26:53\";s:10:\"updated_at\";s:19:\"2025-04-15 08:56:49\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"86\";s:11:\"option_name\";s:19:\"com_site_white_logo\";s:12:\"option_value\";s:3:\"621\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-15 06:26:53\";s:10:\"updated_at\";s:19:\"2025-04-15 08:56:49\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('com_social_links_enable_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"17\";s:11:\"option_name\";s:31:\"com_social_links_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-03-25 02:40:00\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"17\";s:11:\"option_name\";s:31:\"com_social_links_enable_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-03-25 02:40:00\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_social_links_facebook_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"19\";s:11:\"option_name\";s:29:\"com_social_links_facebook_url\";s:12:\"option_value\";s:28:\"https://facebook.com/example\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"19\";s:11:\"option_name\";s:29:\"com_social_links_facebook_url\";s:12:\"option_value\";s:28:\"https://facebook.com/example\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_social_links_instagram_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"21\";s:11:\"option_name\";s:30:\"com_social_links_instagram_url\";s:12:\"option_value\";s:29:\"https://instagram.com/example\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"21\";s:11:\"option_name\";s:30:\"com_social_links_instagram_url\";s:12:\"option_value\";s:29:\"https://instagram.com/example\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_social_links_linkedin_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"22\";s:11:\"option_name\";s:29:\"com_social_links_linkedin_url\";s:12:\"option_value\";s:28:\"https://linkedin.com/example\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"22\";s:11:\"option_name\";s:29:\"com_social_links_linkedin_url\";s:12:\"option_value\";s:28:\"https://linkedin.com/example\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_social_links_pinterest_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"24\";s:11:\"option_name\";s:30:\"com_social_links_pinterest_url\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"24\";s:11:\"option_name\";s:30:\"com_social_links_pinterest_url\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_social_links_snapchat_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"25\";s:11:\"option_name\";s:29:\"com_social_links_snapchat_url\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"25\";s:11:\"option_name\";s:29:\"com_social_links_snapchat_url\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_social_links_title', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"18\";s:11:\"option_name\";s:22:\"com_social_links_title\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-03-25 02:40:00\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"18\";s:11:\"option_name\";s:22:\"com_social_links_title\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-03-25 02:40:00\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_social_links_twitter_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"20\";s:11:\"option_name\";s:28:\"com_social_links_twitter_url\";s:12:\"option_value\";s:27:\"https://twitter.com/example\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"20\";s:11:\"option_name\";s:28:\"com_social_links_twitter_url\";s:12:\"option_value\";s:27:\"https://twitter.com/example\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-18 11:59:40\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_social_links_youtube_url', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"23\";s:11:\"option_name\";s:28:\"com_social_links_youtube_url\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"23\";s:11:\"option_name\";s:28:\"com_social_links_youtube_url\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 03:11:26\";s:10:\"updated_at\";s:19:\"2025-05-19 04:08:25\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258873),
('com_user_email_verification', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:1:\"5\";s:11:\"option_name\";s:27:\"com_user_email_verification\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-03-10 02:09:43\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:1:\"5\";s:11:\"option_name\";s:27:\"com_user_email_verification\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-03-10 02:09:43\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('com_user_login_otp', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:1:\"6\";s:11:\"option_name\";s:18:\"com_user_login_otp\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-06-24 09:19:03\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:1:\"6\";s:11:\"option_name\";s:18:\"com_user_login_otp\";s:12:\"option_value\";N;s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-03-10 02:09:43\";s:10:\"updated_at\";s:19:\"2025-06-24 09:19:03\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903),
('max_deposit_per_transaction', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:2:\"94\";s:11:\"option_name\";s:27:\"max_deposit_per_transaction\";s:12:\"option_value\";s:5:\"50000\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-29 09:30:49\";s:10:\"updated_at\";s:19:\"2025-05-06 05:04:08\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:2:\"94\";s:11:\"option_name\";s:27:\"max_deposit_per_transaction\";s:12:\"option_value\";s:5:\"50000\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-04-29 09:30:49\";s:10:\"updated_at\";s:19:\"2025-05-06 05:04:08\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258699),
('otp_login_enabled_disable', 'O:24:\"App\\Models\\SettingOption\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"setting_options\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";s:3:\"124\";s:11:\"option_name\";s:25:\"otp_login_enabled_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-23 04:47:50\";s:10:\"updated_at\";s:19:\"2025-06-24 09:21:54\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";s:3:\"124\";s:11:\"option_name\";s:25:\"otp_login_enabled_disable\";s:12:\"option_value\";s:2:\"on\";s:8:\"autoload\";s:1:\"1\";s:10:\"created_at\";s:19:\"2025-06-23 04:47:50\";s:10:\"updated_at\";s:19:\"2025-06-24 09:21:54\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"option_name\";i:1;s:12:\"option_value\";i:2;s:8:\"autoload\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:15:\"translationKeys\";a:23:{i:0;s:11:\"option_name\";i:1;s:14:\"com_site_title\";i:2;s:17:\"com_site_subtitle\";i:3;s:14:\"com_meta_title\";i:4;s:20:\"com_meta_description\";i:5;s:13:\"com_meta_tags\";i:6;s:12:\"com_og_title\";i:7;s:18:\"com_og_description\";i:8;s:21:\"com_maintenance_title\";i:9;s:27:\"com_maintenance_description\";i:10;s:21:\"com_site_full_address\";i:11;s:23:\"com_site_contact_number\";i:12;s:25:\"com_site_footer_copyright\";i:13;s:23:\"com_register_page_title\";i:14;s:26:\"com_register_page_subtitle\";i:15;s:29:\"com_register_page_description\";i:16;s:29:\"com_register_page_terms_title\";i:17;s:20:\"com_login_page_title\";i:18;s:23:\"com_login_page_subtitle\";i:19;s:39:\"com_product_details_page_delivery_title\";i:20;s:42:\"com_product_details_page_delivery_subtitle\";i:21;s:44:\"com_product_details_page_return_refund_title\";i:22;s:47:\"com_product_details_page_return_refund_subtitle\";}}', 1751258903);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:13:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:13:\"available_for\";s:1:\"c\";s:4:\"name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"e\";s:12:\"module_title\";s:1:\"f\";s:10:\"perm_title\";s:1:\"g\";s:4:\"icon\";s:1:\"h\";s:9:\"parent_id\";s:7:\"options\";s:7:\"options\";s:6:\"module\";s:6:\"module\";s:1:\"r\";s:5:\"roles\";s:1:\"j\";s:6:\"locked\";s:1:\"k\";s:6:\"status\";}s:11:\"permissions\";a:168:{i:0;a:11:{s:1:\"a\";s:3:\"163\";s:1:\"b\";s:14:\"delivery_level\";s:1:\"c\";s:28:\"/deliveryman/withdraw-manage\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:11:\"Withdrawals\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:26:\"[\"view\",\"insert\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:6;}}i:1;a:11:{s:1:\"a\";s:4:\"4972\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:9:\"dashboard\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Dashboard\";s:1:\"g\";s:15:\"LayoutDashboard\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:2;a:11:{s:1:\"a\";s:4:\"4973\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:16:\"Order Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Order Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:3;a:11:{s:1:\"a\";s:4:\"4974\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:6:\"Orders\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:6:\"Orders\";s:1:\"g\";s:5:\"Boxes\";s:1:\"h\";s:4:\"4973\";s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:4;a:11:{s:1:\"a\";s:4:\"4975\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:20:\"/seller/store/orders\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"All Orders\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"4974\";s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:5;a:11:{s:1:\"a\";s:4:\"4976\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:35:\"/seller/store/orders/refund-request\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"Returned or Refunded\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"4974\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:6;a:11:{s:1:\"a\";s:4:\"4977\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:18:\"Product management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:18:\"Product management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:7;a:11:{s:1:\"a\";s:4:\"4978\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:8:\"Products\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:8:\"Products\";s:1:\"g\";s:11:\"Codesandbox\";s:1:\"h\";s:4:\"4977\";s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:8;a:11:{s:1:\"a\";s:4:\"4979\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:26:\"/seller/store/product/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:15:\"Manage Products\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"4978\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:9;a:11:{s:1:\"a\";s:4:\"4980\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:25:\"/seller/store/product/add\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:15:\"Add New Product\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"4978\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:10;a:11:{s:1:\"a\";s:4:\"4981\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:34:\"/seller/store/product/stock-report\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:23:\"Product Low & Out Stock\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"4978\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:11;a:11:{s:1:\"a\";s:4:\"4982\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:28:\"/seller/store/product/import\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:11:\"Bulk Import\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"4978\";s:7:\"options\";s:26:\"[\"view\",\"insert\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:12;a:11:{s:1:\"a\";s:4:\"4983\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:28:\"/seller/store/product/export\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:11:\"Bulk Export\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"4978\";s:7:\"options\";s:26:\"[\"view\",\"insert\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:13;a:11:{s:1:\"a\";s:4:\"4984\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:28:\"/seller/store/attribute/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Attributes\";s:1:\"g\";s:7:\"Layers2\";s:1:\"h\";s:4:\"4977\";s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:14;a:11:{s:1:\"a\";s:4:\"4985\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:33:\"/seller/store/product/author/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:7:\"Authors\";s:1:\"g\";s:13:\"BookOpenCheck\";s:1:\"h\";s:4:\"4977\";s:7:\"options\";s:35:\"[\"View\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:15;a:11:{s:1:\"a\";s:4:\"4986\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:20:\"Inventory Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"Inventory Management\";s:1:\"g\";s:16:\"SquareChartGantt\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:16;a:11:{s:1:\"a\";s:4:\"4987\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:31:\"/seller/store/product/inventory\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Inventory\";s:1:\"g\";s:11:\"PackageOpen\";s:1:\"h\";s:4:\"4986\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:17;a:11:{s:1:\"a\";s:4:\"4988\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:19:\"Promotional control\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:19:\"Promotional control\";s:1:\"g\";s:11:\"Proportions\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:18;a:11:{s:1:\"a\";s:4:\"4989\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:10:\"Flash Sale\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Flash Sale\";s:1:\"g\";s:3:\"Zap\";s:1:\"h\";s:4:\"4988\";s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:19;a:11:{s:1:\"a\";s:4:\"4990\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:50:\"/seller/store/promotional/flash-deals/active-deals\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"Active Deals\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"4989\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:20;a:11:{s:1:\"a\";s:4:\"4991\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:46:\"/seller/store/promotional/flash-deals/my-deals\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:8:\"My Deals\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"4989\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:21;a:11:{s:1:\"a\";s:4:\"4992\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:4:\"Chat\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:4:\"Chat\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:22;a:11:{s:1:\"a\";s:4:\"4993\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:23:\"/seller/store/chat/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Chat List\";s:1:\"g\";s:17:\"MessageSquareMore\";s:1:\"h\";s:4:\"4992\";s:7:\"options\";s:26:\"[\"view\",\"insert\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:23;a:11:{s:1:\"a\";s:4:\"4994\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:14:\"Support Ticket\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:14:\"Support Ticket\";s:1:\"g\";s:10:\"Headphones\";s:1:\"h\";N;s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:24;a:11:{s:1:\"a\";s:4:\"4995\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:33:\"/seller/store/support-ticket/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:7:\"Tickets\";s:1:\"g\";s:7:\"Headset\";s:1:\"h\";s:4:\"4994\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:25;a:11:{s:1:\"a\";s:4:\"4996\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:16:\"Feedback control\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Feedback control\";s:1:\"g\";s:18:\"MessageSquareReply\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:26;a:11:{s:1:\"a\";s:4:\"4997\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:37:\"/seller/store/feedback-control/review\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:7:\"Reviews\";s:1:\"g\";s:4:\"Star\";s:1:\"h\";s:4:\"4996\";s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:27;a:11:{s:1:\"a\";s:4:\"4998\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:40:\"/seller/store/feedback-control/questions\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Questions\";s:1:\"g\";s:10:\"CircleHelp\";s:1:\"h\";s:4:\"4996\";s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:28;a:11:{s:1:\"a\";s:4:\"4999\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:20:\"Financial Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"Financial Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:29;a:11:{s:1:\"a\";s:4:\"5000\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:32:\"/seller/store/financial/withdraw\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:11:\"Withdrawals\";s:1:\"g\";s:15:\"BadgeDollarSign\";s:1:\"h\";s:4:\"4999\";s:7:\"options\";s:17:\"[\"view\",\"insert\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:30;a:11:{s:1:\"a\";s:4:\"5001\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:30:\"/seller/store/financial/wallet\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"Store Wallet\";s:1:\"g\";s:6:\"Wallet\";s:1:\"h\";s:4:\"4999\";s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:31;a:11:{s:1:\"a\";s:4:\"5002\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:13:\"Staff control\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"Staff control\";s:1:\"g\";s:12:\"UserRoundPen\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:32;a:11:{s:1:\"a\";s:4:\"5003\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:24:\"/seller/store/staff/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Staff List\";s:1:\"g\";s:5:\"Users\";s:1:\"h\";s:4:\"5002\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:33;a:11:{s:1:\"a\";s:4:\"5004\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:13:\"Notifications\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"Notifications\";s:1:\"g\";s:17:\"MessageCircleMore\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:34;a:11:{s:1:\"a\";s:4:\"5005\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:27:\"/seller/store/notifications\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"All Notifications\";s:1:\"g\";s:4:\"Bell\";s:1:\"h\";s:4:\"5004\";s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:35;a:11:{s:1:\"a\";s:4:\"5006\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:14:\"Store Settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:14:\"Store Settings\";s:1:\"g\";s:5:\"Store\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"View\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:36;a:11:{s:1:\"a\";s:4:\"5007\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:36:\"/seller/store/settings/business-plan\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"Business Plan\";s:1:\"g\";s:17:\"BriefcaseBusiness\";s:1:\"h\";s:4:\"5006\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:37;a:11:{s:1:\"a\";s:4:\"5008\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:30:\"/seller/store/settings/notices\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:6:\"Notice\";s:1:\"g\";s:10:\"BadgeAlert\";s:1:\"h\";s:4:\"5006\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:38;a:11:{s:1:\"a\";s:4:\"5009\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:18:\"/seller/store/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"My Stores\";s:1:\"g\";s:5:\"Store\";s:1:\"h\";s:4:\"5006\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:2;}}i:39;a:11:{s:1:\"a\";s:4:\"5396\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:16:\"/admin/dashboard\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Dashboard\";s:1:\"g\";s:15:\"LayoutDashboard\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:11:{s:1:\"a\";s:4:\"5397\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:16:\"Order Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Order Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:11:{s:1:\"a\";s:4:\"5398\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:6:\"Orders\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:6:\"Orders\";s:1:\"g\";s:11:\"ListOrdered\";s:1:\"h\";s:4:\"5397\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:11:{s:1:\"a\";s:4:\"5399\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:13:\"/admin/orders\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"All Orders\";s:1:\"g\";s:11:\"ListOrdered\";s:1:\"h\";s:4:\"5398\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:11:{s:1:\"a\";s:4:\"5400\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:28:\"/admin/orders/refund-request\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"Returned or Refunded\";s:1:\"g\";s:9:\"RotateCcw\";s:1:\"h\";s:4:\"5398\";s:7:\"options\";s:26:\"[\"view\",\"update\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:11:{s:1:\"a\";s:4:\"5401\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:32:\"/admin/orders/refund-reason/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"Refund Reason\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5398\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:11:{s:1:\"a\";s:4:\"5402\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:18:\"Product management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:18:\"Product management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:11:{s:1:\"a\";s:4:\"5403\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:8:\"Products\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:8:\"Products\";s:1:\"g\";s:11:\"Codesandbox\";s:1:\"h\";s:4:\"5402\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:11:{s:1:\"a\";s:4:\"5404\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:19:\"/admin/product/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"All Products\";s:1:\"g\";s:13:\"PackageSearch\";s:1:\"h\";s:4:\"5403\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:11:{s:1:\"a\";s:4:\"5405\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:22:\"/admin/product/request\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:24:\"Product Approval Request\";s:1:\"g\";s:9:\"Signature\";s:1:\"h\";s:4:\"5403\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:11:{s:1:\"a\";s:4:\"5406\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:27:\"/admin/product/stock-report\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:23:\"Product Low & Out Stock\";s:1:\"g\";s:6:\"Layers\";s:1:\"h\";s:4:\"5403\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:11:{s:1:\"a\";s:4:\"5407\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:21:\"/admin/product/import\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:11:\"Bulk Import\";s:1:\"g\";s:6:\"FileUp\";s:1:\"h\";s:4:\"5403\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:11:{s:1:\"a\";s:4:\"5408\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:21:\"/admin/product/export\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:11:\"Bulk Export\";s:1:\"g\";s:8:\"Download\";s:1:\"h\";s:4:\"5403\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:11:{s:1:\"a\";s:4:\"5409\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:24:\"/admin/product/inventory\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"Product Inventory\";s:1:\"g\";s:16:\"SquareChartGantt\";s:1:\"h\";s:4:\"5402\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:11:{s:1:\"a\";s:4:\"5410\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"/admin/categories\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Categories\";s:1:\"g\";s:4:\"List\";s:1:\"h\";s:4:\"5402\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:11:{s:1:\"a\";s:4:\"5411\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:21:\"/admin/attribute/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Attributes\";s:1:\"g\";s:13:\"AttributeIcon\";s:1:\"h\";s:4:\"5402\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:11:{s:1:\"a\";s:4:\"5412\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:16:\"/admin/unit/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:5:\"Units\";s:1:\"g\";s:5:\"Boxes\";s:1:\"h\";s:4:\"5402\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:11:{s:1:\"a\";s:4:\"5413\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"/admin/brand/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:6:\"Brands\";s:1:\"g\";s:10:\"LayoutList\";s:1:\"h\";s:4:\"5402\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:11:{s:1:\"a\";s:4:\"5414\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:15:\"/admin/tag/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:4:\"Tags\";s:1:\"g\";s:4:\"Tags\";s:1:\"h\";s:4:\"5402\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:11:{s:1:\"a\";s:4:\"5415\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:26:\"/admin/product/author/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:7:\"Authors\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5402\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:11:{s:1:\"a\";s:4:\"5416\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"Coupon Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"Coupon Management\";s:1:\"g\";s:13:\"SquarePercent\";s:1:\"h\";s:4:\"5402\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:60;a:11:{s:1:\"a\";s:4:\"5417\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:18:\"/admin/coupon/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:7:\"Coupons\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5416\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:11:{s:1:\"a\";s:4:\"5418\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:23:\"/admin/coupon-line/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"Coupon Lines\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5416\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:11:{s:1:\"a\";s:4:\"5419\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:16:\"Store management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Store management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:11:{s:1:\"a\";s:4:\"5420\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:5:\"Store\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:5:\"Store\";s:1:\"g\";s:5:\"Store\";s:1:\"h\";s:4:\"5419\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:11:{s:1:\"a\";s:4:\"5421\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"/admin/store/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Store List\";s:1:\"g\";s:5:\"Store\";s:1:\"h\";s:4:\"5420\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:11:{s:1:\"a\";s:4:\"5422\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:16:\"/admin/store/add\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Store Add\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5420\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:11:{s:1:\"a\";s:4:\"5423\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:21:\"/admin/store/approval\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:22:\"Store Approval Request\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5420\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:11:{s:1:\"a\";s:4:\"5424\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"Slider Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"Slider Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:11:{s:1:\"a\";s:4:\"5425\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:18:\"/admin/slider/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:6:\"Slider\";s:1:\"g\";s:17:\"SlidersHorizontal\";s:1:\"h\";s:4:\"5424\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:11:{s:1:\"a\";s:4:\"5426\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:16:\"Media Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Media Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:11:{s:1:\"a\";s:4:\"5427\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:19:\"/admin/media-manage\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:5:\"Media\";s:1:\"g\";s:6:\"Images\";s:1:\"h\";s:4:\"5426\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:11:{s:1:\"a\";s:4:\"5428\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:19:\"Promotional control\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:19:\"Promotional control\";s:1:\"g\";s:11:\"Proportions\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:11:{s:1:\"a\";s:4:\"5429\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:10:\"Flash Sale\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Flash Sale\";s:1:\"g\";s:3:\"Zap\";s:1:\"h\";s:4:\"5428\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:11:{s:1:\"a\";s:4:\"5430\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:35:\"/admin/promotional/flash-deals/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"All Campaigns\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5429\";s:7:\"options\";s:35:\"[\"view\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:11:{s:1:\"a\";s:4:\"5431\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:43:\"/admin/promotional/flash-deals/join-request\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:22:\"Join Campaign Requests\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5429\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"delete\",\"update\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:11:{s:1:\"a\";s:4:\"5432\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:30:\"/admin/promotional/banner/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:7:\"Banners\";s:1:\"g\";s:12:\"AlignJustify\";s:1:\"h\";s:4:\"5428\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:11:{s:1:\"a\";s:4:\"5433\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:19:\"Feedback Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:19:\"Feedback Management\";s:1:\"g\";s:18:\"MessageSquareReply\";s:1:\"h\";N;s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:11:{s:1:\"a\";s:4:\"5434\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:30:\"/admin/feedback-control/review\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:7:\"Reviews\";s:1:\"g\";s:4:\"Star\";s:1:\"h\";s:4:\"5433\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:11:{s:1:\"a\";s:4:\"5435\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:33:\"/admin/feedback-control/questions\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Questions\";s:1:\"g\";s:10:\"CircleHelp\";s:1:\"h\";s:4:\"5433\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:11:{s:1:\"a\";s:4:\"5436\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:15:\"Blog Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:15:\"Blog Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:11:{s:1:\"a\";s:4:\"5437\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:5:\"Blogs\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:5:\"Blogs\";s:1:\"g\";s:3:\"Rss\";s:1:\"h\";s:4:\"5436\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:11:{s:1:\"a\";s:4:\"5438\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:20:\"/admin/blog/category\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:8:\"Category\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5437\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:11:{s:1:\"a\";s:4:\"5439\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"/admin/blog/posts\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:5:\"Posts\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5437\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:11:{s:1:\"a\";s:4:\"5440\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:16:\"Pages Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Pages Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:11:{s:1:\"a\";s:4:\"5441\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"/admin/pages/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Page Lists\";s:1:\"g\";s:4:\"List\";s:1:\"h\";s:4:\"5440\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:11:{s:1:\"a\";s:4:\"5442\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"Wallet Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"Wallet Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:11:{s:1:\"a\";s:4:\"5443\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:18:\"/admin/wallet/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"Wallet Lists\";s:1:\"g\";s:6:\"Wallet\";s:1:\"h\";s:4:\"5442\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:11:{s:1:\"a\";s:4:\"5444\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:26:\"/admin/wallet/transactions\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:19:\"Transaction History\";s:1:\"g\";s:7:\"History\";s:1:\"h\";s:4:\"5442\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:88;a:11:{s:1:\"a\";s:4:\"5445\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:22:\"/admin/wallet/settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:15:\"Wallet Settings\";s:1:\"g\";s:8:\"Settings\";s:1:\"h\";s:4:\"5442\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:89;a:11:{s:1:\"a\";s:4:\"5446\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:22:\"Deliveryman management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:22:\"Deliveryman management\";s:1:\"g\";s:12:\"UserRoundPen\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:11:{s:1:\"a\";s:4:\"5447\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:37:\"/admin/deliveryman/vehicle-types/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"Vehicle Types\";s:1:\"g\";s:3:\"Car\";s:1:\"h\";s:4:\"5446\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:91;a:11:{s:1:\"a\";s:4:\"5448\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:23:\"/admin/deliveryman/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Deliveryman List\";s:1:\"g\";s:12:\"UserRoundPen\";s:1:\"h\";s:4:\"5446\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:11:{s:1:\"a\";s:4:\"5449\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:19:\"Customer management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:19:\"Customer management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:11:{s:1:\"a\";s:4:\"5450\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:13:\"All Customers\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"All Customers\";s:1:\"g\";s:10:\"UsersRound\";s:1:\"h\";s:4:\"5449\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:11:{s:1:\"a\";s:4:\"5451\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:20:\"/admin/customer/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Customers\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5450\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:11:{s:1:\"a\";s:4:\"5452\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:31:\"/admin/customer/subscriber-list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:15:\"Subscriber List\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5450\";s:7:\"options\";s:26:\"[\"view\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:11:{s:1:\"a\";s:4:\"5453\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:32:\"/admin/customer/contact-messages\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Contact Messages\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5450\";s:7:\"options\";s:26:\"[\"view\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:97;a:11:{s:1:\"a\";s:4:\"5454\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"Seller management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"Seller management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:98;a:11:{s:1:\"a\";s:4:\"5455\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:11:\"All Sellers\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:11:\"All Sellers\";s:1:\"g\";s:10:\"UsersRound\";s:1:\"h\";s:4:\"5454\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:99;a:11:{s:1:\"a\";s:4:\"5456\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:18:\"/admin/seller/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:7:\"Sellers\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5455\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:100;a:11:{s:1:\"a\";s:4:\"5457\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:26:\"/admin/seller/registration\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"Register A Seller\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5455\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:101;a:11:{s:1:\"a\";s:4:\"5458\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:19:\"Employee Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:19:\"Employee Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:102;a:11:{s:1:\"a\";s:4:\"5459\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:11:\"Staff Roles\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:11:\"Staff Roles\";s:1:\"g\";s:15:\"LockKeyholeOpen\";s:1:\"h\";s:4:\"5458\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:103;a:11:{s:1:\"a\";s:4:\"5460\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"/admin/roles/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:4:\"List\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5459\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:104;a:11:{s:1:\"a\";s:4:\"5461\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:16:\"/admin/roles/add\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:8:\"Add Role\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5459\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:105;a:11:{s:1:\"a\";s:4:\"5462\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:8:\"My Staff\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:8:\"My Staff\";s:1:\"g\";s:5:\"Users\";s:1:\"h\";s:4:\"5458\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:106;a:11:{s:1:\"a\";s:4:\"5463\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"/admin/staff/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:4:\"List\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5462\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:107;a:11:{s:1:\"a\";s:4:\"5464\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:16:\"/admin/staff/add\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Add Staff\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5462\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:108;a:11:{s:1:\"a\";s:4:\"5465\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:15:\"Chat Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:15:\"Chat Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:109;a:11:{s:1:\"a\";s:4:\"5466\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:4:\"Chat\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:4:\"Chat\";s:1:\"g\";s:17:\"MessageSquareMore\";s:1:\"h\";s:4:\"5465\";s:7:\"options\";s:26:\"[\"view\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:110;a:11:{s:1:\"a\";s:4:\"5467\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:20:\"/admin/chat/settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"Chat Settings\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5466\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:111;a:11:{s:1:\"a\";s:4:\"5468\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:18:\"/admin/chat/manage\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Chat List\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5466\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:112;a:11:{s:1:\"a\";s:4:\"5469\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:14:\"Support Ticket\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:14:\"Support Ticket\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:113;a:11:{s:1:\"a\";s:4:\"5470\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:7:\"Tickets\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:7:\"Tickets\";s:1:\"g\";s:10:\"Headphones\";s:1:\"h\";s:4:\"5469\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:114;a:11:{s:1:\"a\";s:4:\"5471\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:24:\"/admin/ticket/department\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Department\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5470\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:115;a:11:{s:1:\"a\";s:4:\"5472\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:26:\"/admin/support-ticket/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:11:\"All Tickets\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5470\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:116;a:11:{s:1:\"a\";s:4:\"5473\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:20:\"Financial Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"Financial Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:117;a:11:{s:1:\"a\";s:4:\"5474\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:9:\"Financial\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Financial\";s:1:\"g\";s:15:\"BadgeDollarSign\";s:1:\"h\";s:4:\"5473\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:118;a:11:{s:1:\"a\";s:4:\"5475\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:34:\"/admin/financial/withdraw/settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:19:\"Withdrawal Settings\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5474\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:119;a:11:{s:1:\"a\";s:4:\"5476\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:37:\"/admin/financial/withdraw/method/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"Withdrawal Method\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5474\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:120;a:11:{s:1:\"a\";s:4:\"5477\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:33:\"/admin/financial/withdraw/history\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Withdraw History\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5474\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:121;a:11:{s:1:\"a\";s:4:\"5478\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:33:\"/admin/financial/withdraw/request\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"Withdraw Requests\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5474\";s:7:\"options\";s:35:\"[\"view\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:122;a:11:{s:1:\"a\";s:4:\"5479\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:29:\"/admin/financial/cash-collect\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"Cash Collect\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5474\";s:7:\"options\";s:35:\"[\"view\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:123;a:11:{s:1:\"a\";s:4:\"5480\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:20:\"Report and analytics\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"Report and analytics\";s:1:\"g\";s:4:\"Logs\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:124;a:11:{s:1:\"a\";s:4:\"5481\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:29:\"/admin/report-analytics/order\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"Order Report\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5480\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:125;a:11:{s:1:\"a\";s:4:\"5482\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:13:\"Notifications\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"Notifications\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:126;a:11:{s:1:\"a\";s:4:\"5483\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:20:\"/admin/notifications\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"Notifications\";s:1:\"g\";s:4:\"Bell\";s:1:\"h\";s:4:\"5482\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:127;a:11:{s:1:\"a\";s:4:\"5484\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"Notice Management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"Notice Management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:128;a:11:{s:1:\"a\";s:4:\"5485\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:20:\"/admin/store-notices\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:7:\"Notices\";s:1:\"g\";s:20:\"MessageSquareWarning\";s:1:\"h\";s:4:\"5484\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:129;a:11:{s:1:\"a\";s:4:\"5486\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:19:\"Business Operations\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:19:\"Business Operations\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:130;a:11:{s:1:\"a\";s:4:\"5487\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:37:\"/admin/business-operations/store-type\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Store Type\";s:1:\"g\";s:5:\"Store\";s:1:\"h\";s:4:\"5486\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:131;a:11:{s:1:\"a\";s:4:\"5488\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:36:\"/admin/business-operations/area/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Area Setup\";s:1:\"g\";s:6:\"Locate\";s:1:\"h\";s:4:\"5486\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:132;a:11:{s:1:\"a\";s:4:\"5489\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:12:\"Subscription\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"Subscription\";s:1:\"g\";s:12:\"PackageCheck\";s:1:\"h\";s:4:\"5486\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:133;a:11:{s:1:\"a\";s:4:\"5490\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:52:\"/admin/business-operations/subscription/package/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"Subscription Package\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5489\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:134;a:11:{s:1:\"a\";s:4:\"5491\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:50:\"/admin/business-operations/subscription/store/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:18:\"Store Subscription\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5489\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:135;a:11:{s:1:\"a\";s:4:\"5492\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:46:\"/admin/business-operations/commission/settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:19:\"Commission Settings\";s:1:\"g\";s:12:\"BadgePercent\";s:1:\"h\";s:4:\"5486\";s:7:\"options\";s:26:\"[\"view\",\"update\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:136;a:11:{s:1:\"a\";s:4:\"5493\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:16:\"Payment Gateways\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Payment Gateways\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:137;a:11:{s:1:\"a\";s:4:\"5494\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:32:\"/admin/payment-gateways/settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Payment Settings\";s:1:\"g\";s:10:\"CreditCard\";s:1:\"h\";s:4:\"5493\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:138;a:11:{s:1:\"a\";s:4:\"5495\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:12:\"SMS Gateways\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"SMS Gateways\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:139;a:11:{s:1:\"a\";s:4:\"5496\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:28:\"/admin/sms-provider/settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"SMS Gateway Settings\";s:1:\"g\";s:10:\"CreditCard\";s:1:\"h\";s:4:\"5495\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:140;a:11:{s:1:\"a\";s:4:\"5497\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:17:\"System management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"System management\";s:1:\"g\";s:0:\"\";s:1:\"h\";N;s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:141;a:11:{s:1:\"a\";s:4:\"5498\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:41:\"/admin/system-management/general-settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"General Settings\";s:1:\"g\";s:8:\"Settings\";s:1:\"h\";s:4:\"5497\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:142;a:11:{s:1:\"a\";s:4:\"5499\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:38:\"/admin/system-management/page-settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"Page Settings\";s:1:\"g\";s:11:\"FileSliders\";s:1:\"h\";s:4:\"5497\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:143;a:11:{s:1:\"a\";s:4:\"5500\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:43:\"/admin/system-management/page-settings/home\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Home Page\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5499\";s:7:\"options\";s:35:\"[\"view\",\"insert\",\"update\",\"delete\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:144;a:11:{s:1:\"a\";s:4:\"5501\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:47:\"/admin/system-management/page-settings/register\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"Register Page\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5499\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:145;a:11:{s:1:\"a\";s:4:\"5502\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:44:\"/admin/system-management/page-settings/login\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"Login Page\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5499\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:146;a:11:{s:1:\"a\";s:4:\"5503\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:54:\"/admin/system-management/page-settings/product-details\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"Product Details Page\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5499\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:147;a:11:{s:1:\"a\";s:4:\"5504\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:51:\"/admin/system-management/page-settings/blog-details\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:9:\"Blog Page\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5499\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:148;a:11:{s:1:\"a\";s:4:\"5505\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:44:\"/admin/system-management/page-settings/about\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:10:\"About Page\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5499\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:149;a:11:{s:1:\"a\";s:4:\"5506\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:46:\"/admin/system-management/page-settings/contact\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"Contact Page\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5499\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:150;a:11:{s:1:\"a\";s:4:\"5507\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:52:\"/admin/system-management/page-settings/become-seller\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"Become A Seller Page\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5499\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:151;a:11:{s:1:\"a\";s:4:\"5508\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:19:\"appearance_settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:19:\"Appearance Settings\";s:1:\"g\";s:10:\"MonitorCog\";s:1:\"h\";s:4:\"5497\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:152;a:11:{s:1:\"a\";s:4:\"5509\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:43:\"/admin/system-management/menu-customization\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:18:\"Menu Customization\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5508\";s:7:\"options\";s:44:\"[\"view\",\"insert\",\"update\",\"delete\",\"others\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:153;a:11:{s:1:\"a\";s:4:\"5510\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:45:\"/admin/system-management/footer-customization\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"Footer Customization\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5508\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:154;a:11:{s:1:\"a\";s:4:\"5511\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:45:\"/admin/system-management/maintenance-settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:20:\"Maintenance Settings\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5508\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:155;a:11:{s:1:\"a\";s:4:\"5512\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:14:\"Email Settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:14:\"Email Settings\";s:1:\"g\";s:5:\"Mails\";s:1:\"h\";s:4:\"5497\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:156;a:11:{s:1:\"a\";s:4:\"5513\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:44:\"/admin/system-management/email-settings/smtp\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:13:\"SMTP Settings\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5512\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:157;a:11:{s:1:\"a\";s:4:\"5514\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:59:\"/admin/system-management/email-settings/email-template/list\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:15:\"Email Templates\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5512\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:158;a:11:{s:1:\"a\";s:4:\"5515\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:37:\"/admin/system-management/seo-settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"SEO Settings\";s:1:\"g\";s:11:\"SearchCheck\";s:1:\"h\";s:4:\"5497\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:159;a:11:{s:1:\"a\";s:4:\"5516\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:45:\"/admin/system-management/gdpr-cookie-settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:15:\"Cookie Settings\";s:1:\"g\";s:6:\"Cookie\";s:1:\"h\";s:4:\"5497\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:160;a:11:{s:1:\"a\";s:4:\"5517\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:11:\"Third-Party\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:11:\"Third-Party\";s:1:\"g\";s:6:\"Blocks\";s:1:\"h\";s:4:\"5497\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:161;a:11:{s:1:\"a\";s:4:\"5518\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:44:\"/admin/system-management/google-map-settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:19:\"Google Map Settings\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5517\";s:7:\"options\";s:8:\"[\"view\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:162;a:11:{s:1:\"a\";s:4:\"5519\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:42:\"/admin/system-management/firebase-settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:17:\"Firebase Settings\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5517\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:163;a:11:{s:1:\"a\";s:4:\"5520\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:46:\"/admin/system-management/social-login-settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:21:\"Social Login Settings\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5517\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:164;a:11:{s:1:\"a\";s:4:\"5521\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:43:\"/admin/system-management/recaptcha-settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:18:\"Recaptcha Settings\";s:1:\"g\";s:0:\"\";s:1:\"h\";s:4:\"5517\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:165;a:11:{s:1:\"a\";s:4:\"5522\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:41:\"/admin/system-management/cache-management\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:16:\"Cache Management\";s:1:\"g\";s:11:\"DatabaseZap\";s:1:\"h\";s:4:\"5497\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:166;a:11:{s:1:\"a\";s:4:\"5523\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:49:\"/admin/system-management/database-update-controls\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:15:\"Database Update\";s:1:\"g\";s:8:\"Database\";s:1:\"h\";s:4:\"5497\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:167;a:11:{s:1:\"a\";s:4:\"5524\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:12:\"app-settings\";s:1:\"d\";s:3:\"api\";s:1:\"e\";N;s:1:\"f\";s:12:\"App settings\";s:1:\"g\";s:10:\"Smartphone\";s:1:\"h\";s:4:\"5497\";s:7:\"options\";s:17:\"[\"view\",\"update\"]\";s:6:\"module\";N;s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:3:{i:0;a:6:{s:1:\"a\";s:1:\"6\";s:1:\"b\";s:14:\"delivery_level\";s:1:\"c\";s:12:\"Delivery Man\";s:1:\"d\";s:3:\"api\";s:1:\"j\";s:1:\"1\";s:1:\"k\";s:1:\"1\";}i:1;a:6:{s:1:\"a\";s:1:\"2\";s:1:\"b\";s:11:\"store_level\";s:1:\"c\";s:11:\"Store Admin\";s:1:\"d\";s:3:\"api\";s:1:\"j\";s:1:\"1\";s:1:\"k\";s:1:\"1\";}i:2;a:6:{s:1:\"a\";s:1:\"1\";s:1:\"b\";s:12:\"system_level\";s:1:\"c\";s:11:\"Super Admin\";s:1:\"d\";s:3:\"api\";s:1:\"j\";s:1:\"1\";s:1:\"k\";s:1:\"1\";}}}', 1751343107);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `user_id`, `user_type`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', '2025-05-31 03:05:36', '2025-05-31 03:05:36'),
(2, 1, 'customer', '2025-05-31 03:05:36', '2025-05-31 03:05:36'),
(3, 1, 'store', '2025-05-31 03:05:36', '2025-05-31 03:05:36'),
(4, 2, 'deliveryman', '2025-05-31 03:05:36', '2025-05-31 03:05:36');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_chat_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` varchar(255) NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_type` varchar(255) NOT NULL,
  `message` longtext DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: unseen, 1: seen',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `state_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Port Addison', 18, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(2, 'Lake Reilly', 41, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(3, 'Lake Derick', 63, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(4, 'Keelytown', 94, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(5, 'Lake Sylviaside', 52, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(6, 'Torphyborough', 60, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(7, 'East Shaniechester', 41, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(8, 'Port Cletaberg', 72, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(9, 'Prosaccofort', 20, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(10, 'Grantchester', 26, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(11, 'South Derrickshire', 55, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(12, 'Estellashire', 13, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(13, 'West Paulineland', 47, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(14, 'Lake Tyra', 78, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(15, 'Nitzscheberg', 11, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(16, 'East Ed', 68, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(17, 'Schadenmouth', 58, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(18, 'Nitzscheborough', 31, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(19, 'Lednerville', 84, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(20, 'Armanifort', 37, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(21, 'West Leone', 92, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(22, 'Laneview', 26, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(23, 'Bogisichstad', 17, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(24, 'DuBuqueland', 46, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(25, 'East Davonstad', 51, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(26, 'West Bridiemouth', 60, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(27, 'Kohlerside', 8, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(28, 'East Maddisonton', 30, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(29, 'North Telly', 39, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(30, 'Rodriguezland', 64, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(31, 'Port Emiemouth', 62, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(32, 'Soniastad', 55, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(33, 'New Alexis', 43, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(34, 'Watersmouth', 82, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(35, 'Tonifort', 35, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(36, 'Lake Jarret', 37, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(37, 'Port Freddyland', 28, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(38, 'Napoleonchester', 33, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(39, 'Peterview', 40, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(40, 'North Damianstad', 38, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(41, 'Krisfort', 58, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(42, 'Saulport', 96, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(43, 'Lake Carleyhaven', 64, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(44, 'North Deion', 79, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(45, 'Matildestad', 17, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(46, 'Ryanmouth', 86, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(47, 'Gleichnerfort', 80, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(48, 'Oberbrunnerton', 56, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(49, 'Lake Verliemouth', 25, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(50, 'East Garrybury', 59, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(51, 'South Michelhaven', 24, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(52, 'New Kris', 89, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(53, 'Gerardomouth', 86, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(54, 'Gerlachshire', 60, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(55, 'Lake Berniceport', 1, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(56, 'Lake Aurelia', 2, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(57, 'East Nigel', 5, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(58, 'North Sabrynaberg', 39, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(59, 'Ziemannport', 66, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(60, 'East Kirsten', 38, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(61, 'Ellisburgh', 80, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(62, 'Rennerside', 19, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(63, 'South Augustine', 41, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(64, 'New Dannybury', 10, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(65, 'Goyetteshire', 33, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(66, 'Klingchester', 34, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(67, 'Loyceview', 70, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(68, 'Dellabury', 34, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(69, 'Lake Filibertoside', 4, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(70, 'New Mossie', 34, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(71, 'Lake Shayne', 65, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(72, 'Roselynborough', 48, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(73, 'East Annechester', 40, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(74, 'North Bethelbury', 23, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(75, 'East Gusland', 69, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(76, 'Beiertown', 26, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(77, 'Fisherstad', 37, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(78, 'West Ara', 33, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(79, 'East Mekhi', 53, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(80, 'West Monroemouth', 44, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(81, 'West Joeshire', 91, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(82, 'East Sammy', 42, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(83, 'West Isaac', 67, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(84, 'West Laurenceton', 1, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(85, 'Kylaville', 42, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(86, 'New Margarettborough', 81, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(87, 'East Yasmeenburgh', 67, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(88, 'Gottliebshire', 89, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(89, 'Gleichnerville', 57, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(90, 'East Favianberg', 40, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(91, 'Reingerberg', 91, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(92, 'Hoppeview', 3, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(93, 'Blickstad', 43, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(94, 'Karifort', 66, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(95, 'North Irwinmouth', 79, 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(96, 'Hilariotown', 14, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(97, 'South Elenor', 12, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(98, 'West Eloisa', 36, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(99, 'Hagenesfurt', 79, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(100, 'Beierport', 88, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(101, 'Kalimouth', 54, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(102, 'Hanktown', 67, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(103, 'Mortimerstad', 23, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(104, 'New Gwendolynmouth', 145, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(105, 'East Tyresetown', 129, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(106, 'Stromanside', 193, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(107, 'Babyburgh', 71, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(108, 'Keiraburgh', 188, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(109, 'East Antonia', 10, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(110, 'Kiehnmouth', 122, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(111, 'West Tristianburgh', 103, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(112, 'North Georgette', 79, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(113, 'Port Chelsea', 142, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(114, 'Karenfurt', 85, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(115, 'West Pearl', 88, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(116, 'New Dorianbury', 79, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(117, 'New Michaelaborough', 54, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(118, 'East Alanis', 81, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(119, 'East Ara', 173, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(120, 'Karliemouth', 185, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(121, 'Leopoldton', 194, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(122, 'Alfredton', 166, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(123, 'Neiltown', 155, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(124, 'Port Adellaville', 177, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(125, 'Lake Gonzaloville', 31, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(126, 'East Alfview', 178, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(127, 'Port Osbaldoland', 76, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(128, 'Johnstonfurt', 141, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(129, 'Marielaberg', 39, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(130, 'South Goldenton', 16, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(131, 'West Tylerton', 182, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(132, 'Rheamouth', 103, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(133, 'Gradyville', 58, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(134, 'Damonberg', 75, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(135, 'Danikaside', 104, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(136, 'Port Aldahaven', 39, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(137, 'Cassinburgh', 124, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(138, 'Torpport', 7, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(139, 'Port Marcville', 122, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(140, 'Jackelineside', 143, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(141, 'North Alessandrochester', 92, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(142, 'Homenickview', 95, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(143, 'South Gabrielle', 183, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(144, 'Lebsackchester', 21, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(145, 'Port Andreane', 51, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(146, 'West Elroyside', 16, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(147, 'West Arlenemouth', 94, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(148, 'Robertaborough', 52, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(149, 'Lueilwitzstad', 160, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(150, 'New Halieburgh', 48, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(151, 'Rodriguezshire', 170, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(152, 'Wehnerfort', 82, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(153, 'Samirview', 165, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(154, 'Bodeburgh', 90, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(155, 'Wizaport', 152, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(156, 'South Arvid', 105, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(157, 'Lake Emmet', 35, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(158, 'Lake Tad', 195, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(159, 'West Morris', 185, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(160, 'Mireyastad', 160, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(161, 'East Pierce', 20, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(162, 'Wendellborough', 140, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(163, 'Corwinchester', 62, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(164, 'Clareborough', 79, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(165, 'Port Santiago', 192, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(166, 'Howellstad', 165, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(167, 'West Clark', 149, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(168, 'Lake Clayville', 16, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(169, 'Hadleyton', 2, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(170, 'Robertsburgh', 52, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(171, 'Heaneyfurt', 71, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(172, 'Cleoraside', 197, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(173, 'North Willamouth', 19, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(174, 'O\'Keefeborough', 119, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(175, 'North Porter', 47, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(176, 'Parisside', 195, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(177, 'Boscoborough', 112, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(178, 'Wernerstad', 33, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(179, 'Grahamchester', 162, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(180, 'Schmidtshire', 179, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(181, 'West Sherwoodtown', 148, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(182, 'North Birdie', 110, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(183, 'Reingerside', 49, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(184, 'New Eliza', 72, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(185, 'East Vern', 2, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(186, 'Feestside', 93, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(187, 'Maryjaneside', 171, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(188, 'Cordellberg', 106, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(189, 'East Eveline', 163, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(190, 'South Noemy', 122, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(191, 'Lake Tysonmouth', 12, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(192, 'Lake Magdalena', 94, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(193, 'New Glennatown', 75, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(194, 'Flatleytown', 120, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(195, 'West Elza', 38, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(196, 'Daughertyview', 30, 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(197, 'New Ernestinamouth', 19, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(198, 'Thaliamouth', 50, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(199, 'South Catalinaborough', 138, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(200, 'Wardborough', 71, 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(201, 'Landentown', 139, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(202, 'Dibbertmouth', 71, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(203, 'West Tinaview', 4, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(204, 'North Jaeden', 173, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(205, 'Koeppmouth', 167, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(206, 'Williamside', 207, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(207, 'Jaidafurt', 215, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(208, 'Kraigburgh', 170, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(209, 'West Eloisabury', 241, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(210, 'South Madysonshire', 122, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(211, 'Ornfurt', 243, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(212, 'New Johnnyton', 127, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(213, 'South Ana', 164, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(214, 'Wintheiserbury', 155, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(215, 'Robbview', 37, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(216, 'Allieton', 96, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(217, 'West Macie', 32, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(218, 'South Cornelius', 37, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(219, 'Orloton', 212, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(220, 'East Cristalmouth', 31, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(221, 'Danielabury', 251, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(222, 'Howeberg', 143, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(223, 'South Taylor', 157, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(224, 'Elmershire', 182, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(225, 'North Jaclynfurt', 21, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(226, 'Bergeview', 78, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(227, 'Walkerside', 3, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(228, 'Kautzerville', 279, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(229, 'Waltershire', 45, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(230, 'West Travis', 178, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(231, 'North Bethanybury', 51, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(232, 'Kossmouth', 52, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(233, 'Walshberg', 112, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(234, 'Nicohaven', 17, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(235, 'Dannieberg', 175, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(236, 'Lake Eden', 278, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(237, 'South Cameron', 232, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(238, 'Schummhaven', 221, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(239, 'South Margot', 198, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(240, 'Lake Ethan', 282, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(241, 'Port Miracle', 270, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(242, 'Lilianechester', 273, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(243, 'West Colemanton', 233, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(244, 'New Jessieside', 299, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(245, 'Littelmouth', 258, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(246, 'East Emmettbury', 86, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(247, 'South Christyville', 73, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(248, 'South Leo', 24, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(249, 'Joehaven', 57, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(250, 'Reggiestad', 123, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(251, 'Willardbury', 38, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(252, 'North Eusebiomouth', 178, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(253, 'North Amirshire', 173, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(254, 'West Vesta', 210, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(255, 'South Asiabury', 226, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(256, 'Trompfurt', 231, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(257, 'Port Earl', 53, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(258, 'New Marge', 68, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(259, 'Lubowitzland', 21, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(260, 'West Lilla', 231, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(261, 'East Gaylehaven', 154, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(262, 'South Kip', 271, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(263, 'Murphybury', 190, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(264, 'East Vladimir', 35, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(265, 'Kayachester', 294, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(266, 'Haleybury', 264, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(267, 'Lake Kingtown', 270, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(268, 'Lake Neldaview', 256, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(269, 'East Hester', 42, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(270, 'Port Lula', 98, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(271, 'Lake Marquesstad', 58, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(272, 'Prohaskaland', 179, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(273, 'East Kristian', 158, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(274, 'Schuppehaven', 45, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(275, 'East Urielmouth', 207, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(276, 'North Pearline', 140, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(277, 'Lesterville', 271, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(278, 'South Magdalenborough', 10, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(279, 'Bethanyhaven', 69, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(280, 'Schmidtbury', 204, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(281, 'South Maci', 279, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(282, 'Tyreekstad', 187, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(283, 'North Anahi', 80, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(284, 'South Crystel', 116, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(285, 'West Stanford', 3, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(286, 'Boscobury', 127, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(287, 'Linwoodfort', 94, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(288, 'Franeckiberg', 109, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(289, 'East Lane', 280, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(290, 'Port Nora', 18, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(291, 'East Horacetown', 213, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(292, 'North Kelvinfort', 77, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(293, 'Bartellland', 62, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(294, 'East Eastonbury', 70, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(295, 'Volkmanbury', 213, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(296, 'Port Delphine', 66, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(297, 'Lake Octaviamouth', 2, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(298, 'West Marlon', 159, 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(299, 'North Cheyanne', 252, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(300, 'Hayleyfort', 273, 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(301, 'Noeliamouth', 28, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(302, 'Kubstad', 86, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(303, 'East Howell', 264, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(304, 'Lake Jocelynstad', 20, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(305, 'East Leta', 260, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(306, 'South Alverta', 355, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(307, 'Klingmouth', 105, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(308, 'West Philip', 208, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(309, 'Lillieland', 94, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(310, 'Bartonside', 155, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(311, 'North Eusebiobury', 193, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(312, 'Chadrickstad', 259, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(313, 'Littelborough', 367, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(314, 'Port Rubie', 101, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(315, 'South Deangelo', 38, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(316, 'Langworthstad', 167, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(317, 'Smithchester', 304, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(318, 'Morissetteland', 263, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(319, 'East Constancebury', 90, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(320, 'Batzport', 201, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(321, 'North Juanitabury', 143, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(322, 'West Siennamouth', 125, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(323, 'Port Addiemouth', 365, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(324, 'Lake Pattieshire', 270, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(325, 'Ameliaberg', 332, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(326, 'South Grace', 136, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(327, 'Jakubowskiland', 141, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(328, 'Bonitaport', 390, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(329, 'West Marc', 299, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(330, 'Lake Kassandra', 251, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(331, 'Stokestown', 312, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(332, 'Port Electachester', 136, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(333, 'Lake Aurore', 206, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(334, 'New Marcellaburgh', 103, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(335, 'Port Jamelburgh', 284, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(336, 'Barbaraport', 270, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(337, 'Carolefort', 92, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(338, 'Port Janelle', 292, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(339, 'Handside', 325, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(340, 'Adamberg', 119, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(341, 'New Adela', 264, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(342, 'Lake Geraldport', 38, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(343, 'Aimeemouth', 112, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(344, 'Lindgrenmouth', 3, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(345, 'North Izaiah', 233, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(346, 'Port Antoinette', 260, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(347, 'Lake Augustine', 296, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(348, 'Nicklausberg', 166, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(349, 'Fisherhaven', 131, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(350, 'Willshire', 218, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(351, 'Wymanshire', 146, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(352, 'Feestton', 267, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(353, 'Jasonborough', 329, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(354, 'Vicenteberg', 218, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(355, 'Benedictburgh', 395, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(356, 'Conroyview', 239, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(357, 'Koeppshire', 118, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(358, 'Camillaland', 189, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(359, 'South Ahmad', 324, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(360, 'Delfinahaven', 74, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(361, 'Peteton', 8, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(362, 'East Laurence', 132, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(363, 'South Glenfurt', 112, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(364, 'West Allisonshire', 22, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(365, 'Blandafurt', 193, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(366, 'Damionmouth', 259, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(367, 'North Lafayette', 133, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(368, 'New Kacie', 101, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(369, 'Leslyfort', 323, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(370, 'Jermainehaven', 263, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(371, 'Lake Akeem', 155, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(372, 'Javierhaven', 83, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(373, 'Port Janiyaburgh', 383, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(374, 'East Maverickview', 232, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(375, 'Port Nikitamouth', 147, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(376, 'North Cortney', 317, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(377, 'East Kennachester', 123, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(378, 'Greenholtmouth', 378, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(379, 'Luestad', 398, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(380, 'Myrtismouth', 65, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(381, 'Port Calista', 7, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(382, 'Micheleville', 197, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(383, 'West Elna', 221, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(384, 'North Justine', 207, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(385, 'Port Candidashire', 52, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(386, 'New Aurelioburgh', 370, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(387, 'Luciousland', 394, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(388, 'West Grant', 39, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(389, 'East Danial', 352, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(390, 'Fadelfort', 39, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(391, 'Alishaside', 363, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(392, 'West Jaime', 220, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(393, 'Boydville', 200, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(394, 'East Wilfrid', 289, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(395, 'Morissetteton', 166, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(396, 'Abelardomouth', 272, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(397, 'East Haileeside', 123, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(398, 'South Keanu', 301, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(399, 'Toyberg', 149, 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(400, 'North Kaylahhaven', 234, 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(401, 'North Luzmouth', 30, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(402, 'Mitchellland', 380, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(403, 'East Ruthie', 191, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(404, 'Blockfort', 245, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(405, 'Aricstad', 227, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(406, 'Wizaside', 469, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(407, 'Douglasstad', 485, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(408, 'Lake Zackeryberg', 460, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(409, 'Terryport', 45, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(410, 'Dallasshire', 165, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(411, 'Thielhaven', 458, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(412, 'Richmondfort', 192, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(413, 'New Marleeland', 106, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(414, 'South Karli', 37, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(415, 'Raeganside', 264, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(416, 'New Kendrick', 252, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(417, 'Rosalindaview', 144, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(418, 'Corwinville', 223, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(419, 'East Guido', 144, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(420, 'South Alleneshire', 491, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(421, 'West Berylborough', 124, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(422, 'Danielside', 495, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(423, 'Litzyborough', 148, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(424, 'New Roderick', 341, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(425, 'Denesikfort', 55, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(426, 'Schambergerborough', 57, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(427, 'Lindsayshire', 142, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(428, 'New Othotown', 194, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(429, 'Lake Sageberg', 203, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(430, 'Lolitaton', 211, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(431, 'West Mitchel', 157, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(432, 'North Abigayle', 339, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(433, 'Lake Royfort', 471, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(434, 'Schoenstad', 310, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(435, 'Rickland', 52, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(436, 'East Naomieview', 297, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(437, 'East Kayachester', 325, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(438, 'West Libbieshire', 403, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(439, 'Port Mazie', 494, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(440, 'Gleichnerland', 393, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(441, 'East Oliverfurt', 262, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(442, 'Rodriguezburgh', 428, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(443, 'McKenziemouth', 146, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(444, 'Abshirehaven', 479, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(445, 'New Horacio', 407, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(446, 'Kassulkeborough', 125, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(447, 'East Melliehaven', 60, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(448, 'South Barneychester', 304, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(449, 'Port Deronmouth', 58, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(450, 'East Vanfort', 112, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(451, 'West Kenyonland', 128, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(452, 'Keelingshire', 240, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(453, 'South Ludie', 346, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(454, 'New Vicenteville', 14, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(455, 'Port Tarynfort', 409, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(456, 'New Lysannechester', 82, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(457, 'Patienceport', 492, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(458, 'Lake Lucioburgh', 471, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(459, 'Velvaview', 104, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(460, 'North Flavio', 199, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(461, 'New Chloe', 292, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(462, 'Sydnifort', 353, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(463, 'Colinton', 177, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(464, 'Vandervortland', 468, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(465, 'Brisaville', 282, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(466, 'Emmanuellestad', 495, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(467, 'Langport', 336, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(468, 'Lake Wilhelmfort', 377, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(469, 'East Santa', 412, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(470, 'East Ottis', 486, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(471, 'New Laurieview', 151, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(472, 'Port Bretland', 142, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(473, 'Arvelbury', 331, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(474, 'Ciaraborough', 433, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(475, 'Dareland', 345, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(476, 'Volkmanhaven', 414, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(477, 'North Charitychester', 414, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(478, 'Emardshire', 432, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(479, 'Pagacberg', 123, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(480, 'East Daynahaven', 171, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(481, 'Mohammadview', 143, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(482, 'Littelland', 227, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(483, 'Blairstad', 369, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(484, 'Wilfridmouth', 186, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(485, 'Port Derek', 327, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(486, 'Wildermanside', 141, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(487, 'East Winfield', 465, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(488, 'Kadefurt', 487, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(489, 'Langworthburgh', 358, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(490, 'Halvorsonchester', 252, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(491, 'Port Mayetown', 447, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(492, 'South Meghanside', 418, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(493, 'Port Emerson', 149, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(494, 'Lake Salmaburgh', 290, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(495, 'Khalidtown', 194, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(496, 'Wildermanhaven', 255, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(497, 'Lake Issacmouth', 342, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(498, 'North Monique', 171, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(499, 'East Willy', 183, 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(500, 'Daughertybury', 384, 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(501, 'Yasmineview', 287, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(502, 'Nikolausmouth', 474, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(503, 'Lebsackshire', 532, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(504, 'Port Deonte', 229, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(505, 'North Marisoltown', 204, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(506, 'North Ernesto', 454, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(507, 'Elizabethview', 537, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(508, 'Lake Dessie', 99, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(509, 'New Lonieville', 161, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(510, 'East Ewaldbury', 585, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(511, 'West Marleeshire', 590, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(512, 'Rodrigueztown', 481, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(513, 'East Hannahview', 370, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(514, 'Porterland', 132, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(515, 'Lake Rogelio', 420, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(516, 'Lake Myles', 18, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(517, 'Port Devon', 228, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(518, 'West Leonora', 484, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(519, 'North Deonberg', 246, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(520, 'South Arneton', 593, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(521, 'Port Taylor', 169, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(522, 'Merlhaven', 60, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(523, 'South Edwina', 381, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(524, 'New Cullen', 233, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(525, 'Ferryside', 59, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(526, 'Dickiberg', 147, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(527, 'Helenefort', 135, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(528, 'Hillsmouth', 303, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(529, 'East Ubaldomouth', 574, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(530, 'West Corymouth', 17, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(531, 'South Sheilaport', 19, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(532, 'East Ulicesfurt', 523, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(533, 'Stiedemannberg', 327, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(534, 'Roweberg', 60, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(535, 'Madonnastad', 474, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(536, 'Muhammadville', 388, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(537, 'North Meggieland', 125, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(538, 'Lake Tobin', 297, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(539, 'South Rhiannastad', 25, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(540, 'Millsland', 474, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(541, 'East Arlie', 565, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(542, 'East Darrellshire', 398, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(543, 'East Kurtmouth', 511, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(544, 'Lake Hubert', 586, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(545, 'Herthaberg', 267, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(546, 'North Myrlside', 32, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(547, 'North Delphaland', 304, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(548, 'Lake Kasandrastad', 341, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(549, 'Mertzshire', 438, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(550, 'Murazikchester', 136, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(551, 'South Matteoburgh', 33, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(552, 'Mullerstad', 266, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(553, 'New Antoinettemouth', 387, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(554, 'South Stacey', 600, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(555, 'East Brianne', 280, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(556, 'North Claudine', 122, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(557, 'North Braden', 52, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(558, 'New Maryseburgh', 567, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(559, 'South Jamie', 520, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(560, 'Amaliamouth', 424, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(561, 'Schummland', 528, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(562, 'Lake Russellhaven', 516, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(563, 'East Jon', 392, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(564, 'Hammesshire', 67, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(565, 'Port Priscilla', 166, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(566, 'Port Theofurt', 491, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(567, 'Runolfssonbury', 42, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(568, 'North Myra', 14, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(569, 'Wilfredoland', 415, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(570, 'Beckerstad', 448, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(571, 'New Greg', 238, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(572, 'Calistachester', 33, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(573, 'Jeffereyville', 94, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(574, 'West Robyn', 307, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(575, 'Kuphalburgh', 384, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(576, 'West Lonnieton', 89, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(577, 'Floydfort', 509, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(578, 'South Noraview', 234, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(579, 'Huelchester', 37, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(580, 'Lake Ervintown', 93, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(581, 'Ofeliamouth', 155, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(582, 'East Arjun', 165, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(583, 'Strosinstad', 240, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(584, 'Samsonfort', 556, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(585, 'Elsashire', 53, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(586, 'Lake Judymouth', 62, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(587, 'West Alfredo', 345, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(588, 'Shieldsfort', 396, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(589, 'Salmastad', 10, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(590, 'South Gissellemouth', 81, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(591, 'Port Bridgetbury', 356, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(592, 'East Shannon', 228, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(593, 'Dakotaland', 88, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(594, 'Fritschmouth', 195, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(595, 'Dantown', 204, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(596, 'Ebertberg', 131, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(597, 'Sauerport', 484, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(598, 'West Rubyville', 196, 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(599, 'East Flossie', 204, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(600, 'Roelton', 596, 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(601, 'West Myrahaven', 581, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(602, 'Murphymouth', 371, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(603, 'Williamsontown', 84, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(604, 'Watsicaview', 353, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(605, 'Clintton', 472, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(606, 'Zboncakton', 631, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(607, 'East Davonteland', 74, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(608, 'Newtonville', 132, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(609, 'Cassandrachester', 193, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(610, 'Port Delores', 287, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(611, 'Port Rickyside', 358, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(612, 'East Otiliaburgh', 571, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(613, 'Ebertmouth', 568, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(614, 'Lake Gust', 6, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(615, 'Larsonport', 139, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(616, 'Schillerside', 143, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(617, 'Pollichstad', 384, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(618, 'Drewfort', 565, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(619, 'Trompbury', 688, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(620, 'Quitzonberg', 536, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(621, 'North Lenore', 642, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(622, 'Serenaburgh', 90, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(623, 'Framiville', 437, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(624, 'Violaborough', 405, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(625, 'Waltonstad', 346, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(626, 'Hodkiewiczchester', 280, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(627, 'Stoltenbergview', 657, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(628, 'Port Maeveland', 643, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(629, 'O\'Keefeport', 187, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(630, 'West Erwinstad', 182, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(631, 'Rodriguezstad', 158, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(632, 'Antoninafort', 152, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(633, 'Lake Stuart', 388, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(634, 'West Dayton', 19, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(635, 'Feestview', 215, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(636, 'Wizatown', 231, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(637, 'Declanbury', 287, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(638, 'Lincolnville', 245, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(639, 'Port Aimeeburgh', 328, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(640, 'Rohanshire', 128, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(641, 'New Alvera', 419, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(642, 'Fabianhaven', 20, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(643, 'East Amparo', 194, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(644, 'Adelaport', 553, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(645, 'North Rod', 686, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(646, 'Fredericfurt', 322, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(647, 'Hagenesfurt', 377, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(648, 'Hoppemouth', 7, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(649, 'North Penelopeside', 203, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(650, 'Beckerstad', 390, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(651, 'Homenickville', 334, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(652, 'Hagenesview', 537, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(653, 'South Moises', 261, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(654, 'Adelinechester', 118, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(655, 'East Rahulview', 392, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(656, 'Port Donborough', 397, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(657, 'South Earlville', 59, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(658, 'Monahanfort', 223, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(659, 'South Serenity', 257, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(660, 'South Lance', 313, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(661, 'East Brandonville', 372, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(662, 'New Milford', 185, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(663, 'Christinashire', 226, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(664, 'Caspermouth', 321, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(665, 'Hesselfort', 522, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(666, 'Rosinaborough', 650, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(667, 'West Xzavierton', 549, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(668, 'Wittingside', 603, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(669, 'Lake Cordell', 446, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53');
INSERT INTO `cities` (`id`, `name`, `state_id`, `status`, `created_at`, `updated_at`) VALUES
(670, 'Crookston', 332, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(671, 'Fadelstad', 621, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(672, 'Port Hermann', 557, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(673, 'East Brad', 478, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(674, 'East Fausto', 541, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(675, 'McLaughlinmouth', 220, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(676, 'Framihaven', 505, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(677, 'North Selmer', 130, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(678, 'Archibaldville', 70, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(679, 'East Maximemouth', 520, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(680, 'Stephenland', 652, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(681, 'Rutherfordstad', 170, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(682, 'Hansenchester', 589, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(683, 'Jakobstad', 539, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(684, 'Lake Mckayla', 117, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(685, 'Port Priscillatown', 442, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(686, 'Port Sherwoodbury', 470, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(687, 'Mayaburgh', 503, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(688, 'Patrickside', 382, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(689, 'Tobytown', 274, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(690, 'Lindsayview', 330, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(691, 'Jonathonburgh', 244, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(692, 'North Huldaberg', 28, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(693, 'New Rosinamouth', 647, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(694, 'Lake Olen', 144, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(695, 'Casimerton', 177, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(696, 'Torphyview', 431, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(697, 'Krystelmouth', 156, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(698, 'Demetriusside', 123, 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(699, 'Karianeshire', 304, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(700, 'North Hudson', 384, 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(701, 'Port Waino', 534, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(702, 'Millerborough', 411, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(703, 'South Adah', 367, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(704, 'DuBuquetown', 95, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(705, 'Demetriustown', 33, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(706, 'Nicolasstad', 515, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(707, 'Hudsonville', 590, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(708, 'South Zellaview', 387, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(709, 'Port Nathan', 320, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(710, 'East Robbie', 564, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(711, 'Magnoliaville', 382, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(712, 'Port Maureenmouth', 634, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(713, 'Larsonton', 780, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(714, 'West Devantestad', 795, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(715, 'South Edwardo', 720, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(716, 'Parkerfort', 155, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(717, 'Bahringerland', 209, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(718, 'North Rachelleshire', 289, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(719, 'West Felton', 569, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(720, 'South Evalyn', 393, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(721, 'Danielchester', 466, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(722, 'Lake Russ', 232, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(723, 'South Abelardo', 240, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(724, 'South Wardbury', 271, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(725, 'Vanessahaven', 228, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(726, 'Goldnertown', 412, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(727, 'Lake Candaceborough', 566, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(728, 'Urielborough', 566, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(729, 'East Coltontown', 443, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(730, 'Lake Rodrickmouth', 424, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(731, 'East Nolan', 313, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(732, 'Nolanchester', 281, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(733, 'Jessikastad', 581, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(734, 'Yostport', 209, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(735, 'South Cletusstad', 229, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(736, 'Lake Kittyport', 380, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(737, 'McCulloughmouth', 383, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(738, 'Enochchester', 18, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(739, 'Hoppehaven', 446, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(740, 'West Maefurt', 594, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(741, 'Vanessaberg', 130, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(742, 'North Berneiceshire', 448, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(743, 'Volkmanbury', 723, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(744, 'Estelleshire', 542, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(745, 'O\'Konchester', 548, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(746, 'West Kyleechester', 539, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(747, 'Alainachester', 685, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(748, 'Port Tavares', 417, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(749, 'Lake Lloyd', 18, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(750, 'Uptonbury', 613, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(751, 'East Estefaniatown', 593, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(752, 'Sanfordshire', 19, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(753, 'Lilyanmouth', 175, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(754, 'Alaynamouth', 33, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(755, 'Goldnerburgh', 347, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(756, 'South Crystal', 730, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(757, 'Rontown', 7, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(758, 'West Aurorebury', 434, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(759, 'Lethaborough', 453, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(760, 'Isidroport', 579, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(761, 'Bergnaumside', 187, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(762, 'Schowaltermouth', 788, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(763, 'New Santina', 698, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(764, 'Bernitahaven', 619, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(765, 'New Macey', 419, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(766, 'Willaton', 544, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(767, 'Lake Dudleyville', 463, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(768, 'Port Birdie', 3, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(769, 'East Margret', 414, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(770, 'Lake Finn', 221, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(771, 'Lake Gunnerview', 639, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(772, 'New Marlin', 667, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(773, 'Bechtelarfort', 172, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(774, 'O\'Connertown', 49, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(775, 'Edenfort', 155, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(776, 'Vontown', 104, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(777, 'South Stanchester', 659, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(778, 'East Monteside', 745, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(779, 'Toreyfort', 383, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(780, 'East Gloria', 570, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(781, 'Port Dortha', 686, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(782, 'Port Mervin', 405, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(783, 'Blickside', 183, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(784, 'Bogisichmouth', 183, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(785, 'Cummingsfurt', 724, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(786, 'East Giovanny', 192, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(787, 'Madelynnfort', 765, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(788, 'West Marcos', 672, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(789, 'West Kian', 754, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(790, 'South Scot', 643, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(791, 'Eleazarfurt', 393, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(792, 'West Ana', 783, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(793, 'East Willa', 357, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(794, 'Feestton', 385, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(795, 'East Arielview', 705, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(796, 'Emmerichtown', 745, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(797, 'Emeliatown', 513, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(798, 'Granttown', 495, 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(799, 'Port Lenoreburgh', 566, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(800, 'Dustinstad', 183, 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(801, 'Maureenville', 133, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(802, 'Juniuschester', 121, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(803, 'Lomashire', 438, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(804, 'Considinehaven', 822, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(805, 'Port Zelmaland', 706, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(806, 'New Imanistad', 329, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(807, 'Cooperton', 813, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(808, 'East Jana', 408, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(809, 'Creminport', 214, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(810, 'Connellymouth', 417, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(811, 'East Aliciafort', 516, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(812, 'New Kaelyn', 291, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(813, 'South Estellland', 894, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(814, 'East Loraton', 299, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(815, 'Port Floymouth', 403, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(816, 'New Ashton', 473, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(817, 'Bartonport', 787, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(818, 'Rolfsontown', 246, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(819, 'Albaton', 679, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(820, 'Pollichburgh', 296, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(821, 'Giovannaside', 340, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(822, 'Brownburgh', 569, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(823, 'Boscotown', 179, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(824, 'Denashire', 803, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(825, 'Leuschketown', 597, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(826, 'Pfannerstillville', 58, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(827, 'Hobartchester', 665, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(828, 'Port Vallie', 4, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(829, 'Christopmouth', 849, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(830, 'Nicolasbury', 867, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(831, 'Lake Connerville', 346, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(832, 'Jerroldberg', 421, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(833, 'West Braulio', 809, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(834, 'East Burdetteville', 823, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(835, 'Ismaelberg', 723, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(836, 'West Faustino', 488, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(837, 'Hillsbury', 516, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(838, 'Lake Annie', 585, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(839, 'Taureanstad', 187, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(840, 'Makenzieshire', 404, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(841, 'Karolannborough', 11, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(842, 'Jastchester', 624, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(843, 'Noeliaburgh', 264, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(844, 'Manteland', 802, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(845, 'North Kennithside', 373, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(846, 'South Hettiechester', 487, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(847, 'Koeppton', 186, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(848, 'Winfieldberg', 292, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(849, 'Dibbertstad', 769, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(850, 'Maximehaven', 893, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(851, 'Kingmouth', 884, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(852, 'Rubiebury', 313, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(853, 'West Jordanburgh', 86, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(854, 'Thompsonmouth', 884, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(855, 'South Patriciamouth', 715, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(856, 'North Lavina', 443, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(857, 'Ziemannchester', 98, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(858, 'Lake Kaileeview', 191, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(859, 'Hermannberg', 825, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(860, 'South Taya', 262, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(861, 'South Matteo', 39, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(862, 'Lake Margretmouth', 158, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(863, 'North Serenity', 183, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(864, 'Lake Myrtishaven', 631, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(865, 'Hudsonton', 339, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(866, 'West Aniyahville', 822, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(867, 'Port Rollinburgh', 182, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(868, 'Lake Addisonville', 701, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(869, 'Pfannerstillton', 191, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(870, 'Kozeyville', 507, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(871, 'South Leonie', 96, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(872, 'Kovacekshire', 42, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(873, 'New Annettestad', 339, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(874, 'Cindyfurt', 308, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(875, 'South Americaburgh', 288, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(876, 'West Osborne', 884, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(877, 'West Alessandroberg', 307, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(878, 'Patsyport', 365, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(879, 'East Daltontown', 104, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(880, 'New Hayden', 206, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(881, 'Leximouth', 443, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(882, 'Boylehaven', 881, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(883, 'Port Zachariahberg', 365, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(884, 'Natalieport', 59, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(885, 'West Madaline', 817, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(886, 'West Barton', 21, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(887, 'Boyerport', 357, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(888, 'North Garett', 745, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(889, 'Lake Lorenzo', 829, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(890, 'East Adrianna', 350, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(891, 'Schimmelmouth', 541, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(892, 'Julianafurt', 164, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(893, 'East Angelica', 109, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(894, 'Wolffport', 817, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(895, 'Lake Georgette', 270, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(896, 'Rhiannonton', 745, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(897, 'Dareton', 330, 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(898, 'Gusikowskiborough', 723, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(899, 'Thelmaland', 588, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(900, 'Camyllemouth', 792, 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(901, 'Emardtown', 87, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(902, 'North Emiliaport', 577, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(903, 'North Damonland', 719, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(904, 'Bryanamouth', 676, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(905, 'West Santiagobury', 452, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(906, 'Daltonview', 866, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(907, 'Schmittside', 501, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(908, 'Boehmport', 697, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(909, 'Port Isaias', 619, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(910, 'East Sadye', 274, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(911, 'Geraldinemouth', 123, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(912, 'Lake Josiah', 451, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(913, 'Shakiraland', 779, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(914, 'Torreyfort', 218, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(915, 'Orvillemouth', 808, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(916, 'North Mariahport', 331, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(917, 'North Della', 561, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(918, 'New Arne', 88, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(919, 'Port Aleenfort', 961, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(920, 'Lake Burdette', 325, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(921, 'Feestside', 80, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(922, 'Darylfurt', 627, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(923, 'South Elsestad', 655, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(924, 'Westmouth', 285, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(925, 'Huelsville', 828, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(926, 'South Constancefurt', 796, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(927, 'West Lisaview', 941, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(928, 'Heavenside', 648, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(929, 'Sengerview', 208, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(930, 'Kuphalfort', 176, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(931, 'Port Jaylin', 853, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(932, 'Naderside', 482, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(933, 'Angelinestad', 981, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(934, 'North Haleigh', 388, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(935, 'Lessieport', 629, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(936, 'Haagtown', 726, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(937, 'Port Quinn', 305, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(938, 'Ritaberg', 739, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(939, 'East Kenya', 609, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(940, 'Halvorsonton', 774, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(941, 'North Dawsonshire', 778, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(942, 'West Rogerville', 105, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(943, 'Cummingsfort', 694, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(944, 'Port Orrin', 483, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(945, 'New Amosberg', 124, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(946, 'New Letitia', 667, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(947, 'West Nicholas', 17, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(948, 'Odessabury', 237, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(949, 'Port Cydney', 784, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(950, 'Buckridgeport', 312, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(951, 'Nicolaberg', 646, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(952, 'Prosaccoshire', 582, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(953, 'East Peggiemouth', 243, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(954, 'Lake Annabellfort', 670, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(955, 'Durganview', 701, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(956, 'Conroychester', 566, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(957, 'South Jaidenstad', 972, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(958, 'South Leopoldborough', 632, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(959, 'West Omer', 46, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(960, 'South Pearl', 611, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(961, 'West Carrie', 182, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(962, 'Welchmouth', 176, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(963, 'North Hortense', 589, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(964, 'New Alyshaport', 359, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(965, 'McLaughlinport', 20, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(966, 'North Wendellview', 267, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(967, 'Port Creolaburgh', 748, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(968, 'Rhodabury', 916, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(969, 'Kenyatown', 936, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(970, 'East Zackery', 604, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(971, 'Bayerton', 127, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(972, 'North Uniqueville', 40, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(973, 'East Icie', 655, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(974, 'Boscoburgh', 236, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(975, 'Purdyhaven', 1, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(976, 'Avisland', 462, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(977, 'South Hunterbury', 319, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(978, 'South Kenyattashire', 942, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(979, 'Langoshhaven', 662, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(980, 'Lake Bennyton', 174, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(981, 'West Lucious', 471, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(982, 'North Taliahaven', 44, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(983, 'Stoltenberghaven', 578, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(984, 'Jasonfort', 505, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(985, 'East Durward', 857, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(986, 'South Carsonhaven', 399, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(987, 'Pfannerstillland', 862, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(988, 'Greenholtfort', 442, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(989, 'Swaniawskimouth', 637, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(990, 'Sadyebury', 605, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(991, 'Port Alphonsomouth', 825, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(992, 'Skylashire', 351, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(993, 'Dollyhaven', 385, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(994, 'Port Alayna', 492, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(995, 'Tretown', 468, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(996, 'South Rolandomouth', 308, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(997, 'Lake Alexander', 103, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(998, 'Geoland', 856, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(999, 'New Estaburgh', 362, 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(1000, 'North Zackmouth', 345, 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(1001, 'Hesselside', 465, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1002, 'Gabriellaview', 398, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1003, 'Jobury', 590, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1004, 'New Renetown', 100, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1005, 'Alizamouth', 642, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1006, 'Dietrichport', 953, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1007, 'Trevorhaven', 294, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1008, 'Chelseabury', 653, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1009, 'West Malliefort', 350, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1010, 'North Isabellport', 754, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1011, 'South Caden', 35, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1012, 'New Jamar', 101, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1013, 'Jakeland', 408, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1014, 'Davismouth', 387, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1015, 'New Liliana', 612, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1016, 'West Reina', 836, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1017, 'Brakusside', 264, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1018, 'Gilbertland', 51, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1019, 'Concepcionmouth', 724, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1020, 'Lake Cortneyburgh', 64, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1021, 'East Barton', 875, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1022, 'West Normaside', 76, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1023, 'Hoegermouth', 1083, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1024, 'South Roberta', 1087, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1025, 'McClureport', 1004, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1026, 'Lake Carissa', 203, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1027, 'Port Peter', 209, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1028, 'East Lavon', 652, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1029, 'Lake Mableland', 990, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1030, 'New Violetshire', 865, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1031, 'North Bernard', 575, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1032, 'Port Crystelport', 1070, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1033, 'Kennedyville', 434, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1034, 'Port Macibury', 1049, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1035, 'Deckowberg', 936, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1036, 'West Kaitlinport', 391, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1037, 'East Estebanbury', 317, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1038, 'Braunberg', 607, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1039, 'North Bryon', 1010, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1040, 'South Chanelletown', 3, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1041, 'North Lilachester', 827, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1042, 'Wadeland', 536, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1043, 'Larsonfurt', 903, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1044, 'Ratkestad', 336, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1045, 'North Dayton', 364, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1046, 'Lake Buddymouth', 416, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1047, 'Lubowitzmouth', 697, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1048, 'Rosaleeton', 115, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1049, 'Kathryneside', 417, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1050, 'Freddyborough', 153, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1051, 'North Grovermouth', 699, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1052, 'East Christastad', 469, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1053, 'East Sabinamouth', 453, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1054, 'Maximillianhaven', 1088, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1055, 'Port Sadiefort', 392, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1056, 'Litteltown', 332, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1057, 'Robinburgh', 792, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1058, 'Audreyville', 526, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1059, 'Cheyenneton', 257, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1060, 'Kassulkeport', 541, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1061, 'Cassinstad', 653, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1062, 'North Delaney', 78, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1063, 'North Ana', 444, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1064, 'North Monserratmouth', 127, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1065, 'West Archibald', 23, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1066, 'Hermistonville', 19, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1067, 'Port Delaney', 547, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1068, 'Port Junius', 58, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1069, 'West Alvina', 529, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1070, 'Ratkechester', 737, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1071, 'Lake Richardfurt', 96, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1072, 'Rooseveltton', 23, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1073, 'Ziemeview', 13, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1074, 'Paulinestad', 993, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1075, 'North Braulio', 871, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1076, 'Nelschester', 531, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1077, 'Wolffstad', 7, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1078, 'South Alberthaburgh', 87, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1079, 'Reingerfort', 7, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1080, 'Olsonbury', 895, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1081, 'Solonside', 307, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1082, 'McLaughlinstad', 518, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1083, 'North Miguelmouth', 1088, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1084, 'West Jimmyberg', 117, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1085, 'Carrollmouth', 929, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1086, 'Bertstad', 1001, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1087, 'Framifurt', 435, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1088, 'Marksbury', 87, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1089, 'Lake Virgiefort', 937, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1090, 'South Lafayettemouth', 220, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1091, 'Port Alanatown', 924, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1092, 'West Isaiah', 1099, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1093, 'Champlinton', 399, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1094, 'Johnsbury', 808, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1095, 'Lottieville', 729, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1096, 'East Elsieside', 77, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1097, 'Larsonstad', 415, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1098, 'Port Arnaldo', 913, 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1099, 'Breanafort', 158, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1100, 'East Kenyatta', 781, 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1101, 'Melynahaven', 864, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1102, 'East Rahulmouth', 916, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1103, 'Schultzborough', 137, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1104, 'Yundtland', 910, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1105, 'Devenberg', 228, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1106, 'East Abdulmouth', 707, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1107, 'North Felix', 676, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1108, 'Hankport', 900, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1109, 'Lake Normafort', 904, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1110, 'Robelside', 905, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1111, 'Port Willowville', 875, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1112, 'Port Denisfurt', 1053, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1113, 'North Nicolas', 631, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1114, 'North Gunnar', 6, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1115, 'Faustinoberg', 1154, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1116, 'North Edmondton', 614, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1117, 'East Arlo', 1132, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1118, 'Tommiestad', 177, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1119, 'Lakinton', 786, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1120, 'Kundeville', 1097, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1121, 'Gonzalostad', 859, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1122, 'West Annabelleberg', 633, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1123, 'East Dana', 272, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1124, 'North Justenberg', 35, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1125, 'Lake Aniyafort', 997, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1126, 'Aniyahfort', 852, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1127, 'East Eunice', 1014, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1128, 'North Alene', 1048, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1129, 'Evangelineview', 726, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1130, 'Schambergerview', 12, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1131, 'New Madaline', 1125, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1132, 'Barneyside', 549, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1133, 'Beiershire', 1096, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1134, 'New Cliftonmouth', 631, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1135, 'North Calista', 884, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1136, 'Markschester', 799, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1137, 'Port Samanta', 125, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1138, 'Douglaston', 785, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1139, 'Friedaview', 1162, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1140, 'Jordibury', 1149, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1141, 'Albertochester', 744, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1142, 'Angelitamouth', 935, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1143, 'Gerhardberg', 1055, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1144, 'New Malika', 942, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1145, 'New Abdiel', 604, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1146, 'West Elinorshire', 426, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1147, 'Lake Theresechester', 327, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1148, 'Reingerhaven', 672, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1149, 'Lake Bridget', 345, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1150, 'West Maritzaside', 804, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1151, 'North Dorothymouth', 1030, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1152, 'South Allenehaven', 571, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1153, 'Port Isacview', 544, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1154, 'Koeppshire', 156, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1155, 'Baileeport', 73, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1156, 'Littelbury', 147, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1157, 'Bayerbury', 596, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1158, 'North Tess', 379, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1159, 'Gildabury', 486, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1160, 'South Hertashire', 517, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1161, 'New Rodger', 485, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1162, 'East Xzaviermouth', 839, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1163, 'East Ulisesview', 530, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1164, 'Brittanyville', 143, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1165, 'South Liabury', 459, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1166, 'Cedrickstad', 1119, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1167, 'Kuphalville', 209, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1168, 'North Cristobalmouth', 761, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1169, 'Nannieborough', 893, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1170, 'Remingtonbury', 343, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1171, 'North Rubieview', 869, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1172, 'Chazstad', 1152, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1173, 'Erickabury', 854, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1174, 'North Alainashire', 1052, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1175, 'Champlinview', 933, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1176, 'Trinityview', 1013, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1177, 'Lake Edgardotown', 819, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1178, 'Francescoborough', 268, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1179, 'Port Reneview', 1014, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1180, 'New Dorothychester', 711, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1181, 'South Maurice', 1038, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1182, 'Gibsonstad', 44, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1183, 'East Alejandra', 305, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1184, 'South Jasper', 1170, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1185, 'Lake Reba', 336, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1186, 'South Mateoview', 1127, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1187, 'Nolanfurt', 124, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1188, 'Kubburgh', 112, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1189, 'Schulistmouth', 71, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1190, 'Port Aditya', 832, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1191, 'South Elinorport', 508, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1192, 'South Demarioburgh', 483, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1193, 'East Ninamouth', 691, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1194, 'Lake Alisonview', 657, 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1195, 'Lincolnmouth', 665, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1196, 'South Connie', 1188, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1197, 'New Giaborough', 583, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1198, 'Bauchstad', 1013, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1199, 'North Felixborough', 280, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1200, 'Murraystad', 1165, 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1201, 'New Glenna', 353, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1202, 'Durgantown', 425, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1203, 'Champlinland', 967, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1204, 'Mayerton', 295, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1205, 'Faheytown', 190, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1206, 'New Janieland', 807, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1207, 'Collierburgh', 1239, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1208, 'North Chase', 96, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1209, 'South Romaineburgh', 1229, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1210, 'Rogahnview', 1126, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1211, 'Lake Cathrynfort', 221, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1212, 'Davidmouth', 490, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1213, 'Ebertview', 421, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1214, 'Port Katelynchester', 813, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1215, 'Tristinville', 772, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1216, 'Marksmouth', 427, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1217, 'Jacktown', 997, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1218, 'Framiland', 288, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1219, 'New Ruby', 1123, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1220, 'Port Jacynthefurt', 924, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1221, 'Port Alekmouth', 676, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1222, 'North Albertoshire', 26, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1223, 'Tiannaside', 395, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1224, 'Sabrinamouth', 550, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1225, 'Mathewburgh', 410, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1226, 'West Rosaville', 57, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1227, 'Port Tysonberg', 521, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1228, 'West Alanastad', 249, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1229, 'East Ozellachester', 376, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1230, 'South Hailieton', 1164, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1231, 'Hansenburgh', 1284, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1232, 'Miracleland', 1080, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1233, 'Marleyborough', 919, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1234, 'McDermotttown', 914, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1235, 'Leratown', 1154, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1236, 'East Unique', 619, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1237, 'Bogisichstad', 246, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1238, 'Spencerville', 128, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1239, 'Burleyton', 1255, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1240, 'New Hubertfort', 1074, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1241, 'Okunevaside', 206, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1242, 'Gislasonberg', 70, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1243, 'New Vincenza', 203, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1244, 'New Ulises', 462, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1245, 'East Dorthymouth', 945, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1246, 'Port Gennaro', 280, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1247, 'North Albertaberg', 58, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1248, 'Lake Rasheedside', 800, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1249, 'Arnulfofurt', 207, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1250, 'Yostfort', 373, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1251, 'Edenmouth', 703, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1252, 'West Andreaneland', 846, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1253, 'Mitchellstad', 1272, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1254, 'Borerborough', 17, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1255, 'East Karson', 953, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1256, 'Port Kaileehaven', 570, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1257, 'Cortneyside', 290, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1258, 'Marianaside', 90, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1259, 'Thielview', 473, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1260, 'Antoniachester', 131, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1261, 'Lake Victor', 1065, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1262, 'West Ambrosemouth', 1124, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1263, 'Waylonberg', 1203, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1264, 'South Maryse', 89, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1265, 'North Jasper', 762, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1266, 'Powlowskiport', 381, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1267, 'West Carissaburgh', 518, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1268, 'West Frederiqueberg', 1086, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1269, 'Marksland', 746, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1270, 'Katlynshire', 205, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1271, 'Feeneyland', 1065, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1272, 'Leonardoport', 1050, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1273, 'Lake Myrl', 928, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1274, 'Fadeltown', 160, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1275, 'Cheyannestad', 731, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1276, 'East Diego', 1045, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1277, 'Elainaview', 595, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1278, 'Wisozkmouth', 273, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1279, 'North Shayne', 178, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1280, 'Lake Ricardo', 352, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1281, 'West Abnerberg', 763, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1282, 'New Theodoremouth', 875, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1283, 'Muellerstad', 545, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1284, 'Lake Yadira', 438, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1285, 'Stehrhaven', 864, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1286, 'Conroytown', 303, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1287, 'South Gretchenton', 302, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1288, 'New Dylanville', 955, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1289, 'Jaskolskiview', 1239, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1290, 'South Presley', 339, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1291, 'Dollyland', 494, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1292, 'Enolaborough', 525, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1293, 'Lake Presley', 1138, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1294, 'Collinsside', 1229, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1295, 'Kiehnstad', 528, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1296, 'Brookefurt', 1265, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1297, 'Port Ledastad', 228, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1298, 'Meganeberg', 355, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1299, 'Emmetton', 477, 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1300, 'East Fayeview', 195, 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `contact_settings`
--

CREATE TABLE `contact_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_settings`
--

INSERT INTO `contact_settings` (`id`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, '{\"contact_form_section\":{\"title\":\"Contact Us\",\"subtitle\":\"Feel free to connect with our team and turn your ideas into reality. Our dedicated customer support team is available 24\\/7 to assist you\"},\"contact_details_section\":{\"address\":\"545 Mavis Island, Chicago\",\"phone\":\"15549595959\",\"email\":\"hello.mail@gmail.com\",\"website\":\"#\",\"image\":590,\"image_url\":null,\"social\":[{\"url\":\"https:\\/\\/facebook.com\",\"icon\":\"FaFacebook\"},{\"url\":\"https:\\/\\/X.com\",\"icon\":\"FaTwitter\"},{\"url\":\"https:\\/\\/linkedIn.com\",\"icon\":\"FaLinkedin\"},{\"url\":\"https:\\/\\/instagram.com\",\"icon\":\"FaInstagram\"}]},\"map_section\":{\"coordinates\":{\"lat\":40.7127753,\"lng\":-74.0059728}}}', 1, '2025-03-18 22:47:49', '2025-05-22 09:25:35');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us_messages`
--

CREATE TABLE `contact_us_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `reply` text DEFAULT NULL,
  `replied_by` bigint(20) UNSIGNED DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = new, 1 = reviewed, 2 = resolved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `dial_code` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `languages` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `dial_code`, `latitude`, `longitude`, `timezone`, `region`, `languages`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Comoros', 'WS', '+51', '-46.527518', '-157.833577', 'Europe/Isle_of_Man', 'Japan', 'English, German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(2, 'Mauritius', 'SR', '+50', '-66.108703', '-99.574609', 'America/Argentina/Rio_Gallegos', 'Japan', 'French, English, Chinese', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(3, 'Libyan Arab Jamahiriya', 'YF', '+49', '15.512584', '102.21319', 'Asia/Beirut', 'Japan', 'French, English, Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(4, 'Syrian Arab Republic', 'HI', '+59', '1.469807', '146.360967', 'Europe/Paris', 'Japan', 'Spanish, German, French', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(5, 'Slovakia (Slovak Republic)', 'HQ', '+82', '-33.268099', '92.236026', 'Asia/Vientiane', 'Japan', 'French', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(6, 'Algeria', 'NW', '+68', '-80.23682', '-52.629478', 'America/Cayman', 'Japan', 'English, Chinese', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(7, 'Canada', 'PL', '+36', '87.760503', '61.656565', 'America/Fort_Nelson', 'Japan', 'Spanish, French', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(8, 'Brunei Darussalam', 'HH', '+40', '15.062083', '-161.779066', 'America/Argentina/Ushuaia', 'Japan', 'Chinese, German', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(9, 'Singapore', 'LE', '+1', '-19.739929', '-107.969778', 'Africa/Dar_es_Salaam', 'Japan', 'French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(10, 'Ireland', 'EU', '+4', '12.971051', '-116.910192', 'Asia/Srednekolymsk', 'Japan', 'Spanish, German, English', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(11, 'Kuwait', 'LH', '+92', '15.413982', '-145.480248', 'Africa/Kigali', 'Japan', 'French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(12, 'Greece', 'IA', '+72', '-4.072908', '-93.136168', 'Europe/Tirane', 'Japan', 'German, Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(13, 'Eritrea', 'NE', '+26', '54.716869', '78.732809', 'Africa/Malabo', 'Japan', 'English', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(14, 'Faroe Islands', 'QM', '+96', '-28.678658', '-19.074612', 'Asia/Makassar', 'Japan', 'English, French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(15, 'Bouvet Island (Bouvetoya)', 'ZV', '+63', '-72.231161', '-79.627568', 'Pacific/Rarotonga', 'Japan', 'Chinese, French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(16, 'French Polynesia', 'FS', '+78', '81.406746', '43.16807', 'Africa/Lubumbashi', 'Japan', 'Spanish, English', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(17, 'United States Virgin Islands', 'RW', '+61', '-11.859251', '5.12899', 'Asia/Dili', 'Japan', 'English, Chinese, French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(18, 'Sri Lanka', 'UZ', '+63', '-2.732505', '-112.984789', 'Asia/Kuching', 'Japan', 'German, Spanish, English', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(19, 'United States Minor Outlying Islands', 'NS', '+46', '-88.434809', '-37.28117', 'Asia/Urumqi', 'Japan', 'Chinese, English, German', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(20, 'Papua New Guinea', 'WC', '+31', '87.172145', '23.776842', 'Atlantic/Azores', 'Japan', 'French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(21, 'Cambodia', 'FT', '+16', '-45.41618', '-12.623796', 'Indian/Christmas', 'Japan', 'German, French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(22, 'French Polynesia', 'EA', '+5', '-48.281128', '108.39331', 'Africa/Lubumbashi', 'Japan', 'German, French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(23, 'Nigeria', 'YY', '+43', '67.065614', '145.376897', 'America/Chicago', 'Japan', 'German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(24, 'Rwanda', 'AN', '+13', '41.402285', '-6.700741', 'Antarctica/Troll', 'Japan', 'Chinese', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(25, 'South Georgia and the South Sandwich Islands', 'NH', '+99', '-21.339075', '-76.369185', 'America/Montserrat', 'Japan', 'English, German, French', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(26, 'Mongolia', 'QH', '+39', '62.086296', '-3.895354', 'Africa/Conakry', 'Japan', 'German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(27, 'Kazakhstan', 'YA', '+15', '-21.193535', '-170.470036', 'Pacific/Efate', 'Japan', 'English, French, Spanish', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(28, 'Andorra', 'VR', '+83', '-89.24582', '29.455155', 'Europe/Belgrade', 'Japan', 'Spanish, French', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(29, 'Suriname', 'UX', '+14', '85.025647', '86.780618', 'America/Ojinaga', 'Japan', 'English', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(30, 'Estonia', 'XK', '+97', '8.485308', '-140.711744', 'Pacific/Tarawa', 'Japan', 'German, Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(31, 'Palau', 'VW', '+21', '27.346415', '-132.922233', 'America/Winnipeg', 'Japan', 'Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(32, 'Sudan', 'RV', '+22', '-71.763097', '173.243576', 'America/Ciudad_Juarez', 'Japan', 'German, Chinese, English', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(33, 'Brunei Darussalam', 'PV', '+76', '63.133292', '104.691074', 'America/Indiana/Vevay', 'Japan', 'German, Chinese', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(34, 'Ecuador', 'CD', '+7', '-11.256533', '30.886875', 'America/Punta_Arenas', 'Japan', 'German', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(35, 'Brazil', 'HS', '+49', '-35.147719', '-84.10926', 'Australia/Eucla', 'Japan', 'French, English, Chinese', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(36, 'Ukraine', 'QB', '+51', '-71.566267', '29.739527', 'America/Sao_Paulo', 'Japan', 'German, Spanish, English', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(37, 'Lao People\'s Democratic Republic', 'KC', '+15', '-1.424208', '-118.983505', 'Africa/Bujumbura', 'Japan', 'German, English, French', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(38, 'Slovakia (Slovak Republic)', 'OT', '+47', '-14.144677', '-5.253832', 'Asia/Makassar', 'Japan', 'German', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(39, 'Norfolk Island', 'VE', '+24', '73.433133', '53.940576', 'Europe/Zagreb', 'Japan', 'Spanish, English, Chinese', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(40, 'Macedonia', 'TO', '+13', '-20.648872', '-48.428316', 'Asia/Vientiane', 'Japan', 'French, Chinese, German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(41, 'Libyan Arab Jamahiriya', 'RC', '+88', '-86.598434', '-59.458932', 'America/Swift_Current', 'Japan', 'Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(42, 'Malaysia', 'XP', '+72', '25.899455', '-160.080068', 'America/Rankin_Inlet', 'Japan', 'Chinese', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(43, 'Barbados', 'VF', '+98', '29.032725', '134.823794', 'America/Boise', 'Japan', 'Spanish', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(44, 'French Southern Territories', 'CA', '+8', '-48.757991', '-92.856521', 'Asia/Seoul', 'Japan', 'Spanish, Chinese, German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(45, 'Palestinian Territories', 'PZ', '+84', '52.983535', '83.071739', 'America/Vancouver', 'Japan', 'Chinese, English', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(46, 'Albania', 'CZ', '+32', '11.97971', '72.711499', 'Australia/Brisbane', 'Japan', 'Chinese', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(47, 'Malaysia', 'HJ', '+73', '-39.261801', '-130.72648', 'Pacific/Palau', 'Japan', 'German, English, Chinese', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(48, 'Hong Kong', 'UQ', '+39', '-38.485024', '49.686577', 'America/Argentina/Catamarca', 'Japan', 'Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(49, 'United States Virgin Islands', 'NX', '+59', '70.06032', '-139.665576', 'Africa/Maseru', 'Japan', 'English, French', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(50, 'Sweden', 'FY', '+83', '58.985139', '-87.533525', 'America/Argentina/Salta', 'Japan', 'English, French, Chinese', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(51, 'Antigua and Barbuda', 'JL', '+92', '-69.005905', '-33.111266', 'Indian/Reunion', 'Japan', 'German, English', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(52, 'Slovenia', 'IK', '+56', '45.988488', '161.787541', 'Pacific/Funafuti', 'Japan', 'German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(53, 'China', 'DM', '+74', '33.149212', '-22.78919', 'America/Anguilla', 'Japan', 'French, German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(54, 'Japan', 'KP', '+68', '-68.867126', '93.435977', 'America/Marigot', 'Japan', 'English', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(55, 'Switzerland', 'PN', '+47', '-57.710643', '21.348973', 'Pacific/Chatham', 'Japan', 'Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(56, 'Macedonia', 'SE', '+67', '-13.954582', '106.654907', 'Pacific/Funafuti', 'Japan', 'German', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(57, 'Croatia', 'JB', '+96', '79.306894', '151.994151', 'Africa/El_Aaiun', 'Japan', 'German, French', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(58, 'Guadeloupe', 'BQ', '+23', '-35.112283', '104.238703', 'Indian/Kerguelen', 'Japan', 'Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(59, 'Hungary', 'FF', '+4', '-11.616716', '33.688314', 'Europe/Zagreb', 'Japan', 'French, Spanish', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(60, 'Egypt', 'CR', '+35', '-23.187338', '-71.958884', 'Europe/Vienna', 'Japan', 'Spanish, French', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(61, 'Christmas Island', 'YZ', '+82', '76.234827', '-144.764919', 'Africa/Casablanca', 'Japan', 'Chinese, French, Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(62, 'Puerto Rico', 'KM', '+83', '-85.88217', '145.750202', 'Asia/Bahrain', 'Japan', 'Spanish', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(63, 'Mali', 'PI', '+79', '37.330322', '108.635369', 'Africa/Djibouti', 'Japan', 'German, French, English', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(64, 'Ghana', 'VA', '+52', '-41.309384', '-100.680622', 'America/Paramaribo', 'Japan', 'Spanish, Chinese', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(65, 'Singapore', 'NC', '+18', '75.278262', '-140.15858', 'Asia/Kolkata', 'Japan', 'Chinese, Spanish', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(66, 'Cape Verde', 'RL', '+79', '-4.772442', '58.16603', 'Asia/Bishkek', 'Japan', 'French, German', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(67, 'Saint Martin', 'FC', '+26', '-80.431668', '-133.216323', 'America/Guyana', 'Japan', 'Spanish, French, German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(68, 'Libyan Arab Jamahiriya', 'DJ', '+41', '-29.752499', '0.66338', 'America/Port_of_Spain', 'Japan', 'French, English', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(69, 'Papua New Guinea', 'US', '+46', '69.289617', '170.730321', 'America/Eirunepe', 'Japan', 'French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(70, 'Ukraine', 'EQ', '+66', '48.719105', '-161.931555', 'America/Jamaica', 'Japan', 'Spanish, English', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(71, 'Bahamas', 'NB', '+94', '77.506371', '-19.920898', 'Africa/Tunis', 'Japan', 'German, French, English', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(72, 'Singapore', 'CV', '+14', '-82.859539', '43.672259', 'Pacific/Gambier', 'Japan', 'Spanish, English', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(73, 'Canada', 'EO', '+80', '63.414233', '-153.13735', 'Indian/Kerguelen', 'Japan', 'Spanish, English, French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(74, 'United States of America', 'LX', '+70', '-2.132639', '-109.23092', 'Europe/Sofia', 'Japan', 'German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(75, 'Austria', 'CS', '+73', '-21.376841', '-133.988401', 'Antarctica/Palmer', 'Japan', 'French, English', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(76, 'Mozambique', 'NY', '+15', '4.022734', '99.015446', 'Asia/Aden', 'Japan', 'French, English', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(77, 'Cocos (Keeling) Islands', 'ZK', '+4', '53.026686', '133.472776', 'America/Cayman', 'Japan', 'Chinese, German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(78, 'French Guiana', 'RZ', '+47', '12.586645', '-83.577957', 'Europe/Volgograd', 'Japan', 'German, Spanish, Chinese', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(79, 'Armenia', 'UR', '+52', '77.034603', '60.645358', 'Asia/Famagusta', 'Japan', 'Chinese', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(80, 'Portugal', 'IL', '+45', '-48.234431', '156.324093', 'Africa/Porto-Novo', 'Japan', 'Spanish, French', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(81, 'Bhutan', 'DA', '+79', '76.715304', '41.230643', 'Europe/San_Marino', 'Japan', 'French, English, Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(82, 'Brunei Darussalam', 'SU', '+88', '82.447698', '-128.453461', 'Antarctica/Casey', 'Japan', 'Chinese', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(83, 'Kazakhstan', 'EB', '+12', '52.871065', '-133.522895', 'Europe/Belgrade', 'Japan', 'Spanish, Chinese, French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(84, 'Timor-Leste', 'IR', '+18', '-33.963931', '-151.490454', 'America/Blanc-Sablon', 'Japan', 'French, Chinese, Spanish', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(85, 'Panama', 'VU', '+36', '-33.110839', '161.097062', 'America/Caracas', 'Japan', 'French, English, Spanish', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(86, 'Lao People\'s Democratic Republic', 'CM', '+10', '82.812582', '-169.171964', 'America/Argentina/Rio_Gallegos', 'Japan', 'German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(87, 'Egypt', 'ZQ', '+75', '-43.016578', '-116.676004', 'Pacific/Pago_Pago', 'Japan', 'German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(88, 'Malawi', 'DX', '+72', '-55.241772', '133.770596', 'Europe/Kirov', 'Japan', 'German, Chinese', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(89, 'Anguilla', 'DF', '+88', '81.68514', '23.12191', 'Africa/Mogadishu', 'Japan', 'Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(90, 'Turks and Caicos Islands', 'GV', '+66', '56.660252', '-162.431012', 'Australia/Melbourne', 'Japan', 'German, Chinese, Spanish', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(91, 'Timor-Leste', 'VL', '+30', '-32.590937', '118.012974', 'America/Scoresbysund', 'Japan', 'Chinese, English', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(92, 'Monaco', 'SM', '+39', '-46.844895', '-137.577845', 'Asia/Atyrau', 'Japan', 'French, German', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(93, 'American Samoa', 'MQ', '+49', '-55.995488', '171.318442', 'Asia/Ashgabat', 'Japan', 'German, English, Spanish', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(94, 'Falkland Islands (Malvinas)', 'QA', '+64', '-4.14515', '99.316388', 'America/Cambridge_Bay', 'Japan', 'German, Chinese', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(95, 'Tunisia', 'BL', '+12', '28.806661', '-32.115217', 'America/Recife', 'Japan', 'French, German', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(96, 'Marshall Islands', 'FX', '+5', '33.949249', '110.562824', 'America/Paramaribo', 'Japan', 'French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(97, 'Liechtenstein', 'XY', '+53', '-47.299059', '142.338283', 'America/Argentina/San_Juan', 'Japan', 'Spanish, German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(98, 'Egypt', 'WG', '+38', '-16.105026', '-176.143476', 'America/St_Barthelemy', 'Japan', 'Spanish, French', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(99, 'Holy See (Vatican City State)', 'VO', '+79', '40.772555', '140.960189', 'Pacific/Palau', 'Japan', 'English, Chinese', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(100, 'Sudan', 'HG', '+46', '52.564872', '-157.225735', 'Europe/Brussels', 'Japan', 'German', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(101, 'Tuvalu', 'KI', '+29', '21.167719', '-176.033367', 'Europe/Vienna', 'India', 'English, Chinese', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(102, 'Guadeloupe', 'EP', '+5', '-6.937744', '-63.178423', 'Asia/Samarkand', 'India', 'Chinese, English, French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(103, 'Bermuda', 'JF', '+65', '88.957633', '-129.22213', 'Pacific/Rarotonga', 'India', 'French, English, German', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(104, 'Marshall Islands', 'AW', '+97', '-8.309975', '161.662655', 'Asia/Kathmandu', 'India', 'French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(105, 'Malawi', 'ZX', '+40', '-59.660777', '4.553234', 'Pacific/Kiritimati', 'India', 'Chinese', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(106, 'Comoros', 'VE', '+15', '3.391217', '-2.198395', 'America/St_Barthelemy', 'India', 'Chinese, German, French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(107, 'Kyrgyz Republic', 'SA', '+24', '-71.887829', '106.8265', 'Africa/Douala', 'India', 'German, Spanish, English', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(108, 'Estonia', 'BK', '+94', '70.627761', '-5.172265', 'Africa/Bangui', 'India', 'English', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(109, 'Croatia', 'EJ', '+10', '71.593513', '117.32643', 'America/Paramaribo', 'India', 'Chinese', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(110, 'Namibia', 'HH', '+54', '-61.293442', '179.211602', 'Pacific/Gambier', 'India', 'French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(111, 'Maldives', 'YK', '+5', '31.710439', '16.114238', 'America/Atikokan', 'India', 'Spanish, German, French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(112, 'Syrian Arab Republic', 'LI', '+89', '61.200654', '64.99806', 'Europe/Madrid', 'India', 'English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(113, 'Panama', 'CV', '+3', '23.671457', '2.148443', 'Pacific/Kosrae', 'India', 'Chinese, French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(114, 'United States Virgin Islands', 'JA', '+13', '16.700528', '-16.567894', 'Asia/Tomsk', 'India', 'German, Chinese, French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(115, 'Dominica', 'JG', '+49', '-5.121122', '-29.856405', 'America/Fort_Nelson', 'India', 'Chinese, English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(116, 'Russian Federation', 'PU', '+46', '46.596507', '165.021741', 'Africa/Ndjamena', 'India', 'Chinese, English, German', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(117, 'Iceland', 'YM', '+49', '80.76766', '136.328443', 'Africa/Harare', 'India', 'English, Chinese, Spanish', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(118, 'Anguilla', 'BU', '+89', '-66.978986', '30.659043', 'Antarctica/Macquarie', 'India', 'Spanish, Chinese, French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(119, 'Antigua and Barbuda', 'AT', '+14', '40.844543', '143.535999', 'America/Guadeloupe', 'India', 'Chinese, English', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(120, 'Malaysia', 'YZ', '+98', '4.040926', '-120.476113', 'Antarctica/Troll', 'India', 'French, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(121, 'Uruguay', 'ND', '+29', '45.490511', '160.16075', 'Europe/Prague', 'India', 'Spanish', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(122, 'New Caledonia', 'SW', '+71', '77.137001', '-175.102669', 'Atlantic/Canary', 'India', 'English, Spanish, French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(123, 'Jordan', 'HT', '+21', '-2.792561', '-86.601123', 'Asia/Tehran', 'India', 'Spanish, Chinese, French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(124, 'Kuwait', 'MW', '+25', '-80.01186', '150.262405', 'Asia/Qatar', 'India', 'French, Chinese', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(125, 'Micronesia', 'LZ', '+51', '-50.815032', '-106.784146', 'Asia/Bahrain', 'India', 'English, French, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(126, 'Guinea', 'QG', '+40', '83.602206', '8.500495', 'America/Indiana/Vevay', 'India', 'English, German, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(127, 'Philippines', 'WI', '+76', '65.629205', '28.824816', 'Africa/Freetown', 'India', 'French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(128, 'Cyprus', 'VP', '+46', '-18.631839', '-16.604292', 'Europe/Copenhagen', 'India', 'English, German, Chinese', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(129, 'Djibouti', 'OX', '+55', '-62.413945', '178.390688', 'Pacific/Kosrae', 'India', 'French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(130, 'Somalia', 'UR', '+49', '70.086354', '-168.198227', 'Europe/Skopje', 'India', 'English, Chinese', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(131, 'Liberia', 'CU', '+34', '-74.191884', '139.107132', 'Africa/Banjul', 'India', 'English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(132, 'Tokelau', 'CP', '+18', '-12.946556', '-126.058316', 'America/Danmarkshavn', 'India', 'English', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(133, 'New Caledonia', 'MF', '+57', '-0.38429', '54.514253', 'America/North_Dakota/Center', 'India', 'English, Spanish, Chinese', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(134, 'Uzbekistan', 'VN', '+72', '68.031091', '99.359522', 'Pacific/Niue', 'India', 'Chinese, German, English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(135, 'Lao People\'s Democratic Republic', 'FH', '+79', '26.378642', '26.969692', 'Australia/Eucla', 'India', 'English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(136, 'Cambodia', 'JO', '+16', '63.63582', '76.078678', 'Europe/Prague', 'India', 'Spanish, French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(137, 'Niue', 'MZ', '+56', '21.327729', '-58.21894', 'Asia/Famagusta', 'India', 'English, Chinese', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(138, 'Uganda', 'MY', '+4', '10.120955', '153.949892', 'America/Chihuahua', 'India', 'Spanish, Chinese', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(139, 'Poland', 'WZ', '+50', '17.946577', '-177.322467', 'America/Barbados', 'India', 'Spanish, Chinese, French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(140, 'Reunion', 'DF', '+89', '-7.353154', '84.907082', 'Africa/Abidjan', 'India', 'French, Chinese', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(141, 'Cayman Islands', 'ZS', '+17', '32.442011', '29.244272', 'Africa/Dar_es_Salaam', 'India', 'French, Chinese', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(142, 'Spain', 'ZQ', '+51', '-75.301507', '151.795924', 'Antarctica/Davis', 'India', 'German', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(143, 'Nauru', 'MD', '+29', '12.71418', '-99.168443', 'America/Lower_Princes', 'India', 'French, German', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(144, 'Equatorial Guinea', 'PY', '+1', '-50.419836', '-61.592519', 'Africa/Tunis', 'India', 'Chinese, French, German', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(145, 'Greenland', 'OR', '+41', '-41.979735', '-73.330622', 'Pacific/Saipan', 'India', 'Chinese, French, English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(146, 'Egypt', 'JB', '+56', '-36.981909', '-33.605887', 'Asia/Srednekolymsk', 'India', 'Chinese', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(147, 'Japan', 'GG', '+21', '11.852703', '-137.895411', 'Asia/Yerevan', 'India', 'French, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(148, 'Bermuda', 'FF', '+15', '-14.56743', '-38.326642', 'Europe/Lisbon', 'India', 'Spanish, English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(149, 'Bosnia and Herzegovina', 'JY', '+2', '-26.401201', '98.746008', 'Indian/Antananarivo', 'India', 'Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(150, 'Angola', 'BM', '+4', '56.63488', '84.355417', 'Africa/Mbabane', 'India', 'Chinese, German, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(151, 'Iraq', 'TK', '+39', '75.699125', '-41.111212', 'America/Argentina/Jujuy', 'India', 'French, English, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(152, 'Rwanda', 'ES', '+64', '-44.254797', '95.348182', 'Pacific/Midway', 'India', 'Chinese, French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(153, 'Falkland Islands (Malvinas)', 'WV', '+57', '-53.304671', '114.484484', 'America/Whitehorse', 'India', 'Spanish, Chinese', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(154, 'Gibraltar', 'VY', '+40', '56.580514', '7.222144', 'Asia/Kuching', 'India', 'Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(155, 'Costa Rica', 'UL', '+88', '84.750604', '169.144768', 'Asia/Irkutsk', 'India', 'German', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(156, 'Japan', 'PO', '+73', '75.20537', '-160.036753', 'Africa/Mogadishu', 'India', 'Chinese, Spanish, German', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(157, 'Costa Rica', 'SS', '+10', '52.377823', '-162.301941', 'Australia/Adelaide', 'India', 'Spanish, English', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(158, 'Myanmar', 'XF', '+5', '-34.199196', '173.723159', 'Africa/Tripoli', 'India', 'French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(159, 'Switzerland', 'WJ', '+33', '88.705847', '146.740935', 'Africa/Bujumbura', 'India', 'German, French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(160, 'France', 'NK', '+85', '-17.384698', '-61.705086', 'Asia/Ashgabat', 'India', 'English', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(161, 'Vietnam', 'DK', '+2', '67.169305', '-179.842423', 'America/Marigot', 'India', 'German, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(162, 'Maldives', 'PG', '+71', '30.45961', '-92.277884', 'Asia/Vladivostok', 'India', 'Chinese, English, German', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(163, 'Guam', 'PQ', '+62', '45.476555', '-110.964285', 'America/St_Johns', 'India', 'English, German, French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(164, 'Liberia', 'HK', '+45', '-56.035952', '87.893675', 'America/Campo_Grande', 'India', 'Spanish', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(165, 'Qatar', 'FU', '+78', '-0.478501', '-54.60761', 'Europe/Podgorica', 'India', 'French, Chinese, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(166, 'Lao People\'s Democratic Republic', 'PH', '+8', '-77.206862', '13.564359', 'America/Juneau', 'India', 'Spanish, French, English', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(167, 'Palau', 'EQ', '+60', '-68.118917', '-110.188438', 'Antarctica/Casey', 'India', 'Spanish, French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(168, 'Cocos (Keeling) Islands', 'FT', '+42', '-48.938687', '98.546877', 'America/Ojinaga', 'India', 'Chinese', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(169, 'Italy', 'YV', '+6', '4.645088', '-129.024185', 'Asia/Jerusalem', 'India', 'Chinese, French, Spanish', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(170, 'Nigeria', 'BD', '+92', '18.630827', '11.280823', 'America/Kentucky/Louisville', 'India', 'French, German, English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(171, 'Cape Verde', 'QL', '+95', '36.500079', '123.954709', 'America/Paramaribo', 'India', 'Chinese, Spanish, French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(172, 'Bermuda', 'OD', '+77', '75.838218', '156.485998', 'Africa/Lome', 'India', 'German, Spanish, French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(173, 'Portugal', 'PD', '+10', '32.802055', '-8.420236', 'Pacific/Port_Moresby', 'India', 'Chinese', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(174, 'Heard Island and McDonald Islands', 'JR', '+38', '-85.221118', '1.206697', 'America/Havana', 'India', 'German', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(175, 'South Georgia and the South Sandwich Islands', 'RE', '+58', '-55.845248', '-175.465849', 'Asia/Kuala_Lumpur', 'India', 'German, Chinese, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(176, 'Holy See (Vatican City State)', 'BY', '+66', '17.742583', '66.609379', 'America/Port-au-Prince', 'India', 'English, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(177, 'Zambia', 'PA', '+31', '24.524296', '7.615893', 'America/Port_of_Spain', 'India', 'Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(178, 'Palestinian Territories', 'OS', '+33', '50.454691', '89.641409', 'America/Nassau', 'India', 'French, English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(179, 'Guadeloupe', 'JZ', '+95', '13.407613', '25.908075', 'Europe/Zagreb', 'India', 'German, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(180, 'Saint Lucia', 'NF', '+42', '-0.799266', '-58.882433', 'Asia/Samarkand', 'India', 'German, French, English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(181, 'Madagascar', 'DB', '+23', '69.392026', '-137.221814', 'Africa/Addis_Ababa', 'India', 'English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(182, 'Aruba', 'CJ', '+74', '-17.202685', '-110.215457', 'Pacific/Guadalcanal', 'India', 'Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(183, 'Anguilla', 'AZ', '+63', '-32.962531', '-120.509402', 'Australia/Lord_Howe', 'India', 'German', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(184, 'Ukraine', 'UH', '+47', '70.442839', '-167.493521', 'Pacific/Easter', 'India', 'Chinese, French, German', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(185, 'Bahrain', 'VD', '+49', '35.454539', '160.998477', 'America/Indiana/Knox', 'India', 'French, Spanish', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(186, 'Angola', 'PB', '+49', '68.260296', '-140.535385', 'Africa/Gaborone', 'India', 'Spanish, German', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(187, 'Brunei Darussalam', 'QV', '+72', '-82.669431', '-65.964134', 'America/Belem', 'India', 'French', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(188, 'Denmark', 'TX', '+63', '-11.595843', '28.293923', 'Pacific/Tongatapu', 'India', 'German, Spanish', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(189, 'Holy See (Vatican City State)', 'OM', '+49', '49.005491', '146.197971', 'America/Argentina/La_Rioja', 'India', 'Chinese', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(190, 'Benin', 'ZR', '+52', '74.161327', '-32.683733', 'Asia/Thimphu', 'India', 'Chinese, Spanish', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(191, 'Oman', 'KV', '+44', '-67.472548', '95.238011', 'Africa/Addis_Ababa', 'India', 'German, Spanish, English', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(192, 'Thailand', 'AG', '+21', '-6.100009', '38.213069', 'America/Bahia', 'India', 'French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(193, 'Honduras', 'UV', '+55', '-59.989355', '-30.614272', 'America/Puerto_Rico', 'India', 'French, Chinese, German', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(194, 'Mauritania', 'NL', '+67', '4.758724', '-166.464213', 'Asia/Qostanay', 'India', 'German, French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(195, 'Yemen', 'HF', '+37', '65.151515', '-54.917431', 'Asia/Hong_Kong', 'India', 'French, German, English', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(196, 'Saint Martin', 'KR', '+68', '-10.596273', '-177.877199', 'America/Guatemala', 'India', 'German', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(197, 'Bangladesh', 'IN', '+20', '35.153939', '-139.026871', 'America/Port_of_Spain', 'India', 'Chinese, Spanish', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(198, 'Rwanda', 'BL', '+71', '-69.59406', '11.668578', 'America/Puerto_Rico', 'India', 'German', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(199, 'Holy See (Vatican City State)', 'OW', '+57', '70.378338', '137.840864', 'Asia/Jayapura', 'India', 'French, German, Chinese', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(200, 'Indonesia', 'HU', '+32', '-57.413414', '-78.144201', 'America/Argentina/Ushuaia', 'India', 'French', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(201, 'Belgium', 'UT', '+8', '28.815071', '66.842078', 'America/Argentina/Catamarca', 'Brazil', 'Chinese, Spanish, English', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(202, 'France', 'PN', '+91', '56.096933', '-6.779431', 'America/Fort_Nelson', 'Brazil', 'Spanish, German', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(203, 'Djibouti', 'SB', '+34', '-58.03019', '51.80324', 'America/Scoresbysund', 'Brazil', 'French', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(204, 'Cambodia', 'HU', '+70', '4.275426', '-166.179914', 'Europe/Amsterdam', 'Brazil', 'German, Spanish, Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(205, 'Brazil', 'CI', '+68', '32.602515', '18.525976', 'Africa/Maseru', 'Brazil', 'Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(206, 'Bahrain', 'UO', '+89', '51.847149', '111.804272', 'America/New_York', 'Brazil', 'Chinese', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(207, 'Israel', 'ZH', '+73', '53.799394', '-8.273008', 'America/Argentina/Rio_Gallegos', 'Brazil', 'Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(208, 'Pakistan', 'JB', '+7', '63.13685', '5.595382', 'Asia/Kathmandu', 'Brazil', 'English', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(209, 'Burkina Faso', 'ET', '+5', '-56.665915', '-154.846435', 'Pacific/Nauru', 'Brazil', 'Chinese', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(210, 'Timor-Leste', 'US', '+5', '11.307395', '14.392406', 'Europe/Simferopol', 'Brazil', 'English', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(211, 'Heard Island and McDonald Islands', 'ZM', '+15', '16.076755', '-179.606574', 'America/Managua', 'Brazil', 'French, Chinese, English', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(212, 'Uruguay', 'ZQ', '+1', '-72.480593', '94.301663', 'Asia/Riyadh', 'Brazil', 'German, Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(213, 'Poland', 'ME', '+13', '75.066738', '113.767357', 'America/Port_of_Spain', 'Brazil', 'Spanish, German, English', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(214, 'Nauru', 'GM', '+34', '37.28159', '-33.25227', 'Asia/Jakarta', 'Brazil', 'German, Chinese, Spanish', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(215, 'Greece', 'PI', '+84', '-42.495114', '-150.96088', 'Asia/Bishkek', 'Brazil', 'Chinese', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(216, 'Afghanistan', 'XT', '+3', '29.860047', '99.343336', 'America/Ciudad_Juarez', 'Brazil', 'English, Spanish, German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(217, 'Northern Mariana Islands', 'FY', '+86', '21.730536', '88.430803', 'Asia/Baku', 'Brazil', 'Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(218, 'Dominica', 'DU', '+80', '-0.529803', '-54.635225', 'America/Belize', 'Brazil', 'French, English, Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(219, 'Guam', 'GE', '+27', '80.951814', '57.301095', 'America/Argentina/Mendoza', 'Brazil', 'German', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(220, 'Hungary', 'UK', '+58', '82.620509', '74.096167', 'Pacific/Wallis', 'Brazil', 'Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(221, 'United States Minor Outlying Islands', 'SN', '+2', '-25.424487', '142.514517', 'Europe/Volgograd', 'Brazil', 'Chinese, Spanish', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(222, 'Morocco', 'SO', '+30', '-4.982399', '-79.710316', 'Africa/Asmara', 'Brazil', 'Chinese, Spanish, English', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(223, 'Tokelau', 'YZ', '+1', '44.774272', '140.239844', 'Europe/Zagreb', 'Brazil', 'German, French, Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(224, 'Kiribati', 'WM', '+50', '75.291141', '-81.568207', 'Europe/Paris', 'Brazil', 'Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(225, 'Saint Kitts and Nevis', 'UA', '+75', '73.876225', '-29.505284', 'Europe/Istanbul', 'Brazil', 'English, German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(226, 'Central African Republic', 'VE', '+51', '17.436031', '-32.988779', 'Africa/Asmara', 'Brazil', 'German, French, Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(227, 'Barbados', 'QS', '+61', '44.859091', '176.628277', 'America/Asuncion', 'Brazil', 'Spanish, French, English', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(228, 'Poland', 'NO', '+21', '14.758372', '-18.940053', 'America/Argentina/Ushuaia', 'Brazil', 'German', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(229, 'Lao People\'s Democratic Republic', 'WC', '+92', '77.702421', '-171.750756', 'Asia/Vientiane', 'Brazil', 'Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(230, 'Sweden', 'PQ', '+70', '24.049091', '-34.698587', 'Pacific/Galapagos', 'Brazil', 'English, French', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(231, 'Swaziland', 'NZ', '+45', '72.345536', '150.703779', 'Africa/Bujumbura', 'Brazil', 'Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(232, 'Romania', 'TG', '+25', '-19.082565', '-50.777534', 'America/Araguaina', 'Brazil', 'German, French, Spanish', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(233, 'Albania', 'XX', '+49', '-15.695332', '-98.118985', 'America/Lima', 'Brazil', 'Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(234, 'Aruba', 'HK', '+24', '77.758515', '79.32659', 'America/Indiana/Knox', 'Brazil', 'Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(235, 'Iceland', 'GC', '+66', '64.186973', '-25.415801', 'Asia/Baghdad', 'Brazil', 'Chinese, French', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(236, 'Kazakhstan', 'RN', '+10', '38.023896', '22.990706', 'America/Argentina/Salta', 'Brazil', 'Spanish, English, French', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(237, 'Botswana', 'OS', '+26', '-74.748124', '-50.673865', 'America/Miquelon', 'Brazil', 'English, Spanish, German', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(238, 'Monaco', 'MU', '+70', '25.824931', '136.204447', 'America/Fortaleza', 'Brazil', 'French', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(239, 'Mexico', 'KZ', '+16', '13.851558', '12.916809', 'Europe/Kyiv', 'Brazil', 'Chinese, German', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(240, 'Mauritius', 'PR', '+47', '86.336171', '98.955113', 'Pacific/Fiji', 'Brazil', 'Chinese, Spanish', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(241, 'Belarus', 'QE', '+80', '-63.363518', '-32.902459', 'Europe/Prague', 'Brazil', 'Spanish, French, Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(242, 'Honduras', 'OA', '+71', '-72.011704', '52.297834', 'Asia/Jakarta', 'Brazil', 'French, English, German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(243, 'Albania', 'VJ', '+50', '-31.509786', '-34.379279', 'Asia/Bishkek', 'Brazil', 'English, Spanish, German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(244, 'Armenia', 'HF', '+95', '44.537867', '62.758654', 'Antarctica/Casey', 'Brazil', 'English, Spanish, Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(245, 'Saint Martin', 'AE', '+22', '53.616023', '36.34905', 'America/Port_of_Spain', 'Brazil', 'German', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(246, 'Malta', 'CN', '+85', '46.846035', '157.926877', 'Africa/Dakar', 'Brazil', 'English, French', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(247, 'Italy', 'UB', '+42', '11.523544', '-83.134246', 'America/Noronha', 'Brazil', 'French, English, German', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(248, 'Central African Republic', 'SE', '+66', '-79.537064', '7.708838', 'America/Bahia', 'Brazil', 'Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(249, 'Lithuania', 'TT', '+99', '45.797894', '-23.910249', 'Africa/Brazzaville', 'Brazil', 'English, French', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(250, 'Mongolia', 'UW', '+64', '5.318218', '134.859088', 'America/Indiana/Vevay', 'Brazil', 'Chinese, English, French', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(251, 'Namibia', 'ED', '+23', '-81.884769', '-89.889024', 'Asia/Taipei', 'Brazil', 'French, German', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(252, 'Equatorial Guinea', 'SM', '+81', '39.196531', '129.47745', 'America/Fortaleza', 'Brazil', 'Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(253, 'Botswana', 'BE', '+83', '-71.960146', '94.463696', 'Pacific/Rarotonga', 'Brazil', 'English, Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(254, 'Lao People\'s Democratic Republic', 'JM', '+81', '38.480531', '103.730382', 'Africa/Maseru', 'Brazil', 'German, Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(255, 'Saint Vincent and the Grenadines', 'CC', '+39', '24.577955', '104.030305', 'Africa/El_Aaiun', 'Brazil', 'German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(256, 'Australia', 'DT', '+27', '-84.381151', '-141.897278', 'Africa/Banjul', 'Brazil', 'French, Spanish, German', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(257, 'Grenada', 'GP', '+71', '-12.871505', '-14.424764', 'Asia/Jerusalem', 'Brazil', 'English, Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(258, 'Northern Mariana Islands', 'TJ', '+89', '-27.733815', '41.043166', 'Africa/Casablanca', 'Brazil', 'Chinese, Spanish', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(259, 'Swaziland', 'RQ', '+67', '7.345321', '-160.065407', 'Asia/Dushanbe', 'Brazil', 'French, English', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(260, 'Macedonia', 'JG', '+79', '31.197619', '12.853012', 'Asia/Damascus', 'Brazil', 'French', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(261, 'Cayman Islands', 'IS', '+93', '14.536604', '-115.150661', 'America/Fort_Nelson', 'Brazil', 'English', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(262, 'Spain', 'PX', '+75', '53.887985', '-16.367193', 'Europe/Kirov', 'Brazil', 'French, Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(263, 'Slovakia (Slovak Republic)', 'QV', '+96', '-69.000896', '116.503826', 'America/Argentina/Jujuy', 'Brazil', 'Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(264, 'Korea', 'QB', '+37', '22.272555', '147.143951', 'Europe/Vilnius', 'Brazil', 'German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(265, 'Bhutan', 'EW', '+16', '53.947796', '-120.082177', 'America/Argentina/Salta', 'Brazil', 'Chinese', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(266, 'Greece', 'VI', '+63', '21.018056', '-45.815984', 'America/Tortola', 'Brazil', 'German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(267, 'Iran', 'QR', '+34', '-50.613811', '-57.494384', 'Europe/Minsk', 'Brazil', 'Spanish', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(268, 'India', 'BD', '+77', '41.458555', '-143.661901', 'Asia/Barnaul', 'Brazil', 'Chinese', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(269, 'Chile', 'NS', '+19', '-64.615705', '-177.773464', 'America/Martinique', 'Brazil', 'Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(270, 'Timor-Leste', 'FW', '+74', '16.19424', '75.26593', 'Asia/Kamchatka', 'Brazil', 'Chinese', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(271, 'Botswana', 'DG', '+40', '77.558811', '-67.433374', 'America/Guyana', 'Brazil', 'German, Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(272, 'Burkina Faso', 'XN', '+13', '-69.761039', '107.567277', 'Asia/Bahrain', 'Brazil', 'French, English, German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(273, 'Burundi', 'NB', '+48', '66.989305', '48.322545', 'Asia/Bahrain', 'Brazil', 'French, English, Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(274, 'Nigeria', 'UZ', '+94', '19.038416', '170.697738', 'Asia/Magadan', 'Brazil', 'English, German, Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(275, 'Saudi Arabia', 'WT', '+36', '-38.207723', '-160.258557', 'Asia/Bangkok', 'Brazil', 'German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(276, 'Falkland Islands (Malvinas)', 'ZZ', '+85', '-0.207983', '78.003986', 'Europe/Oslo', 'Brazil', 'Chinese, German', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(277, 'Malaysia', 'FR', '+3', '23.545033', '-92.92037', 'Asia/Irkutsk', 'Brazil', 'Spanish, French', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(278, 'Mali', 'VR', '+63', '-29.650199', '144.187211', 'America/Swift_Current', 'Brazil', 'Spanish, Chinese, German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(279, 'Guyana', 'BQ', '+55', '-84.387741', '-110.381413', 'Pacific/Kwajalein', 'Brazil', 'French, Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(280, 'Ecuador', 'OI', '+51', '47.519224', '147.028997', 'Asia/Kathmandu', 'Brazil', 'English, French', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(281, 'Tokelau', 'FV', '+17', '52.912067', '-42.623303', 'America/Goose_Bay', 'Brazil', 'Chinese, Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(282, 'Saint Lucia', 'IU', '+40', '-67.472147', '-37.401507', 'Europe/Amsterdam', 'Brazil', 'Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(283, 'Saint Helena', 'YH', '+41', '-75.740092', '-116.901994', 'Africa/Gaborone', 'Brazil', 'Spanish, French', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(284, 'Ghana', 'HV', '+15', '-35.324948', '-37.775943', 'America/Nome', 'Brazil', 'German, Chinese, French', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(285, 'Moldova', 'FD', '+97', '-56.256161', '-44.888941', 'Africa/Malabo', 'Brazil', 'Spanish, English, Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(286, 'Lao People\'s Democratic Republic', 'TN', '+97', '-36.247415', '-46.495412', 'Africa/Freetown', 'Brazil', 'Spanish', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(287, 'Kazakhstan', 'XA', '+64', '39.17342', '-154.025207', 'Asia/Karachi', 'Brazil', 'Spanish, French, Chinese', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(288, 'French Guiana', 'KT', '+36', '-63.910106', '-11.625605', 'America/Tijuana', 'Brazil', 'French, German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(289, 'Romania', 'WH', '+60', '44.182407', '67.863166', 'Europe/Zagreb', 'Brazil', 'German, Chinese, French', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(290, 'Cote d\'Ivoire', 'MS', '+44', '-27.137465', '163.496815', 'America/Recife', 'Brazil', 'English, Spanish', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(291, 'Sri Lanka', 'GV', '+88', '-18.48907', '-73.924999', 'Pacific/Wake', 'Brazil', 'German, English, Chinese', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(292, 'Angola', 'CF', '+92', '-61.086922', '-160.702169', 'Europe/Podgorica', 'Brazil', 'Spanish, Chinese, German', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(293, 'New Zealand', 'KG', '+88', '65.564553', '-173.846294', 'America/Danmarkshavn', 'Brazil', 'German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(294, 'Niger', 'IN', '+68', '-65.708026', '-60.514564', 'America/Martinique', 'Brazil', 'English', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(295, 'Lithuania', 'BI', '+8', '27.698717', '-75.440517', 'Europe/Sarajevo', 'Brazil', 'Chinese, German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(296, 'Pakistan', 'EE', '+99', '36.282438', '-146.095272', 'America/Scoresbysund', 'Brazil', 'Spanish', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(297, 'Bouvet Island (Bouvetoya)', 'GN', '+48', '1.56703', '152.230513', 'Africa/Juba', 'Brazil', 'French, German', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(298, 'Malawi', 'MO', '+52', '11.641482', '-160.62349', 'America/Ojinaga', 'Brazil', 'English, French', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(299, 'Niue', 'YU', '+19', '66.589584', '-127.630556', 'Africa/Sao_Tome', 'Brazil', 'Spanish, English, Chinese', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(300, 'Bouvet Island (Bouvetoya)', 'WY', '+88', '87.952358', '35.141275', 'Europe/Vienna', 'Brazil', 'German, Chinese', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(301, 'Guernsey', 'XJ', '+29', '62.43566', '-95.124655', 'Europe/Bratislava', 'South Africa', 'Chinese, French', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(302, 'Estonia', 'KG', '+95', '66.728509', '51.23728', 'Pacific/Norfolk', 'South Africa', 'French, Chinese, German', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(303, 'Switzerland', 'BE', '+15', '-4.166108', '39.48711', 'Europe/Astrakhan', 'South Africa', 'Spanish, French, German', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(304, 'Cayman Islands', 'OX', '+88', '34.209156', '19.264051', 'Asia/Omsk', 'South Africa', 'Chinese', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(305, 'Svalbard & Jan Mayen Islands', 'VF', '+59', '-2.366607', '-176.088796', 'Europe/Malta', 'South Africa', 'French, English', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(306, 'Namibia', 'VJ', '+50', '87.14231', '4.326058', 'Asia/Famagusta', 'South Africa', 'English, Spanish', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(307, 'Jersey', 'ZW', '+41', '33.194568', '97.748639', 'Europe/Kyiv', 'South Africa', 'English, German, Chinese', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(308, 'Finland', 'WK', '+39', '81.032778', '166.399164', 'Asia/Taipei', 'South Africa', 'French', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(309, 'Angola', 'GV', '+96', '-6.397711', '-78.04498', 'Africa/Johannesburg', 'South Africa', 'English', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(310, 'Vietnam', 'QE', '+59', '-66.742953', '71.933622', 'Africa/Kinshasa', 'South Africa', 'English, German, Chinese', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(311, 'Cape Verde', 'DY', '+54', '71.684829', '-6.403897', 'America/Winnipeg', 'South Africa', 'Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(312, 'Guernsey', 'SI', '+70', '-51.342687', '-148.289783', 'Europe/Vatican', 'South Africa', 'German', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(313, 'Niger', 'BL', '+8', '24.146326', '-15.748581', 'Asia/Seoul', 'South Africa', 'French, Chinese, English', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(314, 'Niue', 'XP', '+78', '48.176019', '29.092659', 'America/Boise', 'South Africa', 'Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(315, 'Puerto Rico', 'QJ', '+31', '-78.938738', '-129.128828', 'Africa/Monrovia', 'South Africa', 'English', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(316, 'Antigua and Barbuda', 'NF', '+53', '-54.847272', '17.640387', 'Asia/Kathmandu', 'South Africa', 'French, Spanish', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11');
INSERT INTO `countries` (`id`, `name`, `code`, `dial_code`, `latitude`, `longitude`, `timezone`, `region`, `languages`, `status`, `created_at`, `updated_at`) VALUES
(317, 'Jordan', 'LC', '+52', '-52.282915', '50.0013', 'Europe/Moscow', 'South Africa', 'Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(318, 'El Salvador', 'VW', '+27', '-22.033176', '47.472525', 'Asia/Aden', 'South Africa', 'English, German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(319, 'Austria', 'QW', '+48', '-84.395924', '118.561999', 'America/Cuiaba', 'South Africa', 'French, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(320, 'Kiribati', 'HY', '+78', '-35.42861', '-21.570263', 'Europe/Kirov', 'South Africa', 'Spanish, English, Chinese', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(321, 'Papua New Guinea', 'WP', '+42', '-34.466813', '178.528215', 'Africa/Bamako', 'South Africa', 'German, English, Spanish', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(322, 'Mongolia', 'CQ', '+62', '23.835356', '-1.165822', 'Asia/Irkutsk', 'South Africa', 'Chinese, French, English', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(323, 'Bahrain', 'RF', '+88', '67.911626', '146.879134', 'Indian/Reunion', 'South Africa', 'German, French', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(324, 'Heard Island and McDonald Islands', 'TB', '+26', '-68.21953', '-161.183513', 'Antarctica/Davis', 'South Africa', 'French', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(325, 'Romania', 'NM', '+54', '63.600164', '-111.259355', 'America/Indiana/Tell_City', 'South Africa', 'French, German, Chinese', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(326, 'Austria', 'GC', '+36', '65.286033', '76.049457', 'America/Caracas', 'South Africa', 'German, French, Chinese', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(327, 'Belize', 'CX', '+19', '65.776253', '98.946242', 'America/Halifax', 'South Africa', 'Chinese, German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(328, 'Cameroon', 'SY', '+49', '-3.146964', '48.708501', 'America/Asuncion', 'South Africa', 'German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(329, 'Romania', 'DX', '+12', '67.956922', '-172.549833', 'America/Monterrey', 'South Africa', 'English, German', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(330, 'Guernsey', 'ZV', '+86', '74.458499', '56.892167', 'Pacific/Kwajalein', 'South Africa', 'French', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(331, 'Ethiopia', 'BA', '+30', '-14.60054', '-11.946406', 'Asia/Damascus', 'South Africa', 'Chinese, English, German', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(332, 'Iraq', 'AM', '+65', '72.990949', '-13.625234', 'Europe/Helsinki', 'South Africa', 'German, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(333, 'Mauritius', 'PF', '+45', '-61.864738', '22.908696', 'Antarctica/Mawson', 'South Africa', 'Chinese', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(334, 'Ireland', 'LI', '+32', '-75.908092', '-175.360864', 'Atlantic/St_Helena', 'South Africa', 'Chinese, French', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(335, 'Sierra Leone', 'XK', '+47', '43.774208', '-28.803722', 'Asia/Brunei', 'South Africa', 'Spanish, Chinese', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(336, 'Qatar', 'AW', '+28', '27.104234', '68.35566', 'Asia/Baghdad', 'South Africa', 'Chinese, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(337, 'United Arab Emirates', 'YU', '+16', '75.281096', '114.114657', 'Africa/Gaborone', 'South Africa', 'Chinese, English, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(338, 'Northern Mariana Islands', 'IK', '+20', '53.482647', '-160.75085', 'Asia/Jerusalem', 'South Africa', 'French, German, English', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(339, 'Saint Vincent and the Grenadines', 'UJ', '+40', '11.587895', '-84.634739', 'Pacific/Gambier', 'South Africa', 'English', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(340, 'Dominica', 'YX', '+15', '12.516922', '-138.739283', 'America/Atikokan', 'South Africa', 'Chinese, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(341, 'San Marino', 'YH', '+77', '-82.119676', '-86.600553', 'Pacific/Kiritimati', 'South Africa', 'French, German, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(342, 'Chad', 'DZ', '+38', '-19.287287', '-110.245009', 'Australia/Broken_Hill', 'South Africa', 'English', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(343, 'India', 'EO', '+23', '-86.973372', '158.183688', 'Pacific/Easter', 'South Africa', 'German', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(344, 'Macedonia', 'WH', '+82', '1.96731', '146.784375', 'Pacific/Easter', 'South Africa', 'Spanish, Chinese, English', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(345, 'Argentina', 'ZM', '+39', '60.924849', '-162.303978', 'Europe/Madrid', 'South Africa', 'French, English, German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(346, 'Sao Tome and Principe', 'XQ', '+67', '50.445966', '-106.954053', 'Europe/Lisbon', 'South Africa', 'Chinese', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(347, 'Iran', 'PV', '+33', '59.316117', '-83.076262', 'Pacific/Nauru', 'South Africa', 'French', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(348, 'Russian Federation', 'CN', '+48', '-9.991829', '-1.186495', 'Africa/Blantyre', 'South Africa', 'German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(349, 'Guam', 'FA', '+86', '59.75441', '118.84722', 'America/Rankin_Inlet', 'South Africa', 'English, Spanish, Chinese', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(350, 'Guam', 'EV', '+57', '-1.271707', '-109.429295', 'America/Campo_Grande', 'South Africa', 'German, French, Spanish', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(351, 'Haiti', 'JS', '+22', '68.76846', '87.255987', 'Africa/Maputo', 'South Africa', 'German, English', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(352, 'Antigua and Barbuda', 'IZ', '+24', '-3.903726', '-39.766388', 'Africa/Johannesburg', 'South Africa', 'English', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(353, 'Dominican Republic', 'XY', '+89', '-62.264409', '-121.498258', 'Europe/San_Marino', 'South Africa', 'French, English', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(354, 'Faroe Islands', 'UB', '+50', '8.982851', '-104.038272', 'Australia/Perth', 'South Africa', 'French, English, Chinese', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(355, 'Sierra Leone', 'OT', '+12', '-6.707658', '-35.003367', 'America/Kentucky/Monticello', 'South Africa', 'French, English, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(356, 'Central African Republic', 'JL', '+99', '74.115848', '22.988179', 'Asia/Muscat', 'South Africa', 'German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(357, 'Latvia', 'LG', '+73', '88.666649', '-34.605825', 'America/Kentucky/Monticello', 'South Africa', 'German, French, English', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(358, 'Germany', 'LW', '+60', '-72.1737', '-3.758689', 'America/Resolute', 'South Africa', 'English, German', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(359, 'Mauritania', 'TO', '+7', '8.539739', '-7.040423', 'Europe/Vaduz', 'South Africa', 'German, French', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(360, 'Falkland Islands (Malvinas)', 'KP', '+99', '2.656193', '50.355024', 'America/Paramaribo', 'South Africa', 'French, Spanish', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(361, 'Lithuania', 'YY', '+75', '-5.91103', '-168.908577', 'Africa/Windhoek', 'South Africa', 'Chinese', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(362, 'Sri Lanka', 'QZ', '+92', '66.23731', '-26.97116', 'Pacific/Kiritimati', 'South Africa', 'English, French, Chinese', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(363, 'Luxembourg', 'PE', '+57', '33.542194', '22.897472', 'Pacific/Tarawa', 'South Africa', 'English, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(364, 'Albania', 'TJ', '+20', '7.367777', '-134.471616', 'America/Sitka', 'South Africa', 'Chinese, German, English', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(365, 'Lithuania', 'NR', '+76', '53.291627', '-11.435849', 'Asia/Qostanay', 'South Africa', 'German, Chinese, English', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(366, 'Macao', 'PG', '+80', '21.469056', '99.439424', 'Antarctica/Davis', 'South Africa', 'German, Chinese', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(367, 'Tonga', 'FS', '+9', '5.116665', '-36.91357', 'Pacific/Fiji', 'South Africa', 'French', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(368, 'Macao', 'YC', '+96', '39.065556', '-23.037518', 'Pacific/Kiritimati', 'South Africa', 'French', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(369, 'Yemen', 'FM', '+84', '-69.138743', '-81.102135', 'America/Dawson_Creek', 'South Africa', 'French, German', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(370, 'United States Minor Outlying Islands', 'UY', '+66', '-39.244904', '96.441928', 'Europe/Monaco', 'South Africa', 'German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(371, 'Yemen', 'IY', '+87', '80.739766', '57.87822', 'America/Marigot', 'South Africa', 'Chinese', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(372, 'Isle of Man', 'NW', '+52', '80.197174', '69.746936', 'Asia/Taipei', 'South Africa', 'Chinese', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(373, 'Netherlands', 'TA', '+45', '76.403486', '-42.520438', 'America/Boa_Vista', 'South Africa', 'German, English, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(374, 'Armenia', 'ST', '+73', '8.792062', '16.587556', 'Indian/Christmas', 'South Africa', 'French', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(375, 'Qatar', 'HT', '+99', '58.717959', '118.128886', 'America/Dominica', 'South Africa', 'Chinese, English', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(376, 'Liechtenstein', 'LM', '+7', '39.04734', '-20.919956', 'Asia/Seoul', 'South Africa', 'English, German, Chinese', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(377, 'Afghanistan', 'AK', '+59', '-87.32941', '65.462832', 'America/Dawson_Creek', 'South Africa', 'German', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(378, 'Cyprus', 'FD', '+98', '-10.168311', '-122.914889', 'Africa/Libreville', 'South Africa', 'German, English', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(379, 'Belarus', 'AD', '+79', '31.4512', '23.794219', 'Antarctica/Rothera', 'South Africa', 'Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(380, 'Belgium', 'HZ', '+97', '5.761734', '-33.764041', 'Pacific/Palau', 'South Africa', 'German, Chinese', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(381, 'Vietnam', 'JR', '+6', '-87.808237', '142.24346', 'Asia/Shanghai', 'South Africa', 'French, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(382, 'Guinea', 'BY', '+62', '-70.848894', '-97.734877', 'Pacific/Port_Moresby', 'South Africa', 'Spanish, Chinese, French', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(383, 'Indonesia', 'IM', '+38', '-67.282558', '67.962345', 'Pacific/Marquesas', 'South Africa', 'English, German', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(384, 'Nauru', 'OE', '+30', '-85.92797', '176.670882', 'Asia/Aqtobe', 'South Africa', 'English, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(385, 'Kiribati', 'YM', '+71', '21.011224', '40.871387', 'Pacific/Efate', 'South Africa', 'Spanish, English', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(386, 'Liberia', 'WU', '+23', '-87.368956', '163.562932', 'America/Sao_Paulo', 'South Africa', 'German, English, Spanish', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(387, 'Mali', 'WQ', '+39', '-75.747569', '-165.578333', 'Africa/Harare', 'South Africa', 'Spanish, German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(388, 'Estonia', 'DF', '+98', '7.704264', '155.258867', 'America/Halifax', 'South Africa', 'French', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(389, 'Singapore', 'FB', '+18', '54.69081', '71.175835', 'Africa/Ndjamena', 'South Africa', 'Chinese, German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(390, 'French Guiana', 'HD', '+88', '49.108643', '-175.702909', 'Africa/Algiers', 'South Africa', 'Spanish', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(391, 'Niger', 'FZ', '+52', '-64.213648', '151.886937', 'Europe/Stockholm', 'South Africa', 'Chinese, Spanish, German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(392, 'Georgia', 'IV', '+57', '-38.679764', '-74.442809', 'Europe/Istanbul', 'South Africa', 'French, English, Chinese', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(393, 'Chile', 'JB', '+21', '-53.09563', '-37.620658', 'Europe/Oslo', 'South Africa', 'French', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(394, 'Bhutan', 'ZQ', '+92', '53.049252', '119.145827', 'America/Goose_Bay', 'South Africa', 'English', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(395, 'Argentina', 'IF', '+87', '70.154067', '-113.582204', 'Europe/Helsinki', 'South Africa', 'Chinese, German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(396, 'Guinea-Bissau', 'SO', '+26', '89.779572', '-115.264926', 'Africa/Lagos', 'South Africa', 'German, French, Spanish', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(397, 'Paraguay', 'TV', '+73', '-26.193091', '20.9713', 'America/Argentina/La_Rioja', 'South Africa', 'French, Chinese', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(398, 'Macao', 'RX', '+83', '-27.635603', '10.154284', 'Asia/Srednekolymsk', 'South Africa', 'German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(399, 'American Samoa', 'NQ', '+98', '38.712666', '-129.10996', 'America/Eirunepe', 'South Africa', 'English, Spanish, Chinese', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(400, 'Uruguay', 'WA', '+6', '-54.945292', '-127.962646', 'Asia/Ust-Nera', 'South Africa', 'Chinese, Spanish, German', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(401, 'Cayman Islands', 'XL', '+88', '-64.836815', '126.416529', 'Africa/Sao_Tome', 'USA', 'French, Spanish', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(402, 'Antigua and Barbuda', 'UY', '+69', '33.421048', '158.497782', 'Atlantic/Reykjavik', 'USA', 'German', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(403, 'United States Minor Outlying Islands', 'GH', '+23', '-80.021756', '-89.645625', 'America/Santo_Domingo', 'USA', 'Spanish, English', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(404, 'Romania', 'JC', '+7', '-28.011346', '87.204196', 'Africa/Sao_Tome', 'USA', 'Spanish, Chinese, English', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(405, 'Macao', 'NH', '+23', '69.832022', '-176.86862', 'Asia/Atyrau', 'USA', 'French, German', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(406, 'Hong Kong', 'MD', '+28', '-63.425727', '-22.638367', 'Antarctica/Syowa', 'USA', 'French', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(407, 'Madagascar', 'WT', '+20', '-44.803137', '10.323754', 'America/Metlakatla', 'USA', 'Spanish, English, Chinese', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(408, 'Macedonia', 'DS', '+36', '-63.156739', '168.206444', 'Asia/Dushanbe', 'USA', 'Spanish, Chinese', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(409, 'Uganda', 'UZ', '+4', '47.091934', '-40.33017', 'Asia/Gaza', 'USA', 'English, German, Chinese', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(410, 'Slovenia', 'HZ', '+30', '86.392592', '-139.751941', 'Europe/Saratov', 'USA', 'English, Spanish, German', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(411, 'Moldova', 'DE', '+70', '-85.183523', '48.047087', 'Asia/Tokyo', 'USA', 'French', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(412, 'Sierra Leone', 'UF', '+28', '-50.664554', '44.953822', 'Asia/Ulaanbaatar', 'USA', 'French, German, Spanish', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(413, 'Kazakhstan', 'XK', '+53', '45.706388', '97.091968', 'America/Nassau', 'USA', 'German', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(414, 'Turkmenistan', 'RE', '+78', '58.445658', '-67.365299', 'Europe/Andorra', 'USA', 'Chinese', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(415, 'Thailand', 'ND', '+32', '88.956418', '32.748337', 'Pacific/Norfolk', 'USA', 'Chinese', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(416, 'Zimbabwe', 'HQ', '+32', '43.353832', '-159.048061', 'Pacific/Pohnpei', 'USA', 'Spanish, Chinese', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(417, 'Liberia', 'YI', '+66', '68.378069', '-38.787283', 'Asia/Riyadh', 'USA', 'Spanish', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(418, 'Italy', 'ZF', '+30', '13.926531', '-106.061051', 'Asia/Qatar', 'USA', 'French, English, German', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(419, 'Micronesia', 'VI', '+85', '-48.648585', '-145.503372', 'America/Manaus', 'USA', 'German', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(420, 'Iceland', 'BK', '+95', '87.544745', '69.142246', 'America/Guyana', 'USA', 'English', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(421, 'American Samoa', 'IO', '+72', '-55.955997', '7.836064', 'America/Argentina/San_Juan', 'USA', 'Spanish, Chinese, English', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(422, 'Sierra Leone', 'CS', '+35', '82.305281', '102.20792', 'Europe/Madrid', 'USA', 'Chinese, French, English', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(423, 'Togo', 'KN', '+20', '74.105687', '-87.757029', 'Pacific/Chuuk', 'USA', 'French, German, English', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(424, 'Djibouti', 'AH', '+46', '60.019106', '-68.229502', 'America/Curacao', 'USA', 'Chinese', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(425, 'Panama', 'FZ', '+99', '85.922281', '-69.114984', 'Pacific/Funafuti', 'USA', 'English', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(426, 'Russian Federation', 'YZ', '+30', '-34.300968', '-179.809666', 'Asia/Shanghai', 'USA', 'Chinese', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(427, 'Peru', 'VN', '+45', '55.470887', '67.295309', 'Europe/Tallinn', 'USA', 'Spanish, German', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(428, 'Palau', 'AR', '+66', '58.91512', '43.929947', 'Asia/Phnom_Penh', 'USA', 'Spanish, Chinese, German', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(429, 'China', 'PE', '+50', '-76.830228', '-169.390195', 'Africa/Lubumbashi', 'USA', 'Spanish', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(430, 'Kenya', 'JM', '+9', '46.174213', '148.886478', 'America/Havana', 'USA', 'French, German, Chinese', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(431, 'Mongolia', 'XA', '+44', '23.847032', '-30.754266', 'Europe/Chisinau', 'USA', 'Chinese, Spanish, German', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(432, 'United Kingdom', 'ZN', '+5', '38.739286', '-113.553092', 'America/Coyhaique', 'USA', 'Spanish', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(433, 'Turkmenistan', 'HR', '+11', '66.522857', '139.326179', 'Africa/Dar_es_Salaam', 'USA', 'Spanish, French, English', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(434, 'Falkland Islands (Malvinas)', 'QL', '+11', '-64.75252', '-9.25923', 'America/Guayaquil', 'USA', 'French, Spanish', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(435, 'Cote d\'Ivoire', 'VR', '+34', '-21.813885', '-165.061052', 'America/Port-au-Prince', 'USA', 'English, German, Chinese', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(436, 'Equatorial Guinea', 'CX', '+47', '-40.769179', '20.337124', 'Indian/Maldives', 'USA', 'Spanish, German, French', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(437, 'Netherlands Antilles', 'DL', '+14', '86.238517', '32.358292', 'Pacific/Guadalcanal', 'USA', 'English, Chinese, German', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(438, 'Maldives', 'DV', '+74', '-88.738555', '47.20039', 'America/Cayenne', 'USA', 'English, Spanish, German', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(439, 'Libyan Arab Jamahiriya', 'PC', '+81', '-73.108523', '-154.730841', 'Asia/Muscat', 'USA', 'Spanish', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(440, 'Papua New Guinea', 'LL', '+23', '-55.126591', '101.449821', 'Atlantic/St_Helena', 'USA', 'Chinese, Spanish, French', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(441, 'Georgia', 'ZP', '+96', '-15.969185', '-178.645469', 'Indian/Mayotte', 'USA', 'French, Spanish, English', 1, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(442, 'Turkmenistan', 'OD', '+47', '-49.471322', '93.92221', 'America/Argentina/Salta', 'USA', 'Chinese, French, English', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(443, 'Russian Federation', 'PU', '+26', '-9.777726', '92.74843', 'America/Cancun', 'USA', 'English', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(444, 'San Marino', 'WN', '+93', '68.868648', '49.673744', 'Europe/Amsterdam', 'USA', 'German, Chinese', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(445, 'Holy See (Vatican City State)', 'JZ', '+99', '4.235245', '-95.654198', 'America/St_Kitts', 'USA', 'German, Spanish, Chinese', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(446, 'Fiji', 'BP', '+20', '47.065983', '102.276403', 'Antarctica/McMurdo', 'USA', 'French', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(447, 'Afghanistan', 'AP', '+3', '-84.67562', '-132.287767', 'Indian/Maldives', 'USA', 'Spanish, German', 0, '2025-05-24 03:56:17', '2025-05-24 03:56:17'),
(448, 'Pitcairn Islands', 'ZS', '+3', '60.382761', '-6.71182', 'America/Edmonton', 'USA', 'French, English', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(449, 'Grenada', 'VY', '+82', '4.806083', '-176.189531', 'Pacific/Tongatapu', 'USA', 'Spanish', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(450, 'Mali', 'SX', '+69', '-38.677974', '49.779047', 'America/Denver', 'USA', 'Spanish, German', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(451, 'Kenya', 'VE', '+19', '-44.378302', '-57.00122', 'America/St_Thomas', 'USA', 'German', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(452, 'Brazil', 'CZ', '+63', '72.822488', '-23.777222', 'America/Anchorage', 'USA', 'Spanish', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(453, 'Morocco', 'YG', '+68', '1.715656', '-99.559047', 'America/Caracas', 'USA', 'English, French', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(454, 'Panama', 'FC', '+28', '56.724218', '120.623852', 'Africa/Maputo', 'USA', 'French', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(455, 'Pitcairn Islands', 'OW', '+48', '15.505963', '-2.564812', 'Asia/Aqtobe', 'USA', 'Spanish', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(456, 'Portugal', 'ZC', '+8', '56.798812', '68.098471', 'America/Indiana/Vevay', 'USA', 'English', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(457, 'Korea', 'QC', '+20', '44.818061', '-145.480814', 'Pacific/Port_Moresby', 'USA', 'Spanish, English, Chinese', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(458, 'Tuvalu', 'RA', '+56', '56.182997', '-134.976193', 'America/Indiana/Vincennes', 'USA', 'French, Spanish', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(459, 'Armenia', 'BQ', '+55', '-65.248863', '-121.63718', 'Africa/Kampala', 'USA', 'English, German', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(460, 'Antigua and Barbuda', 'HX', '+63', '66.640554', '171.294152', 'Africa/Tunis', 'USA', 'Chinese, Spanish, French', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(461, 'Heard Island and McDonald Islands', 'UB', '+21', '35.288657', '-13.062133', 'Europe/Warsaw', 'USA', 'Chinese', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(462, 'Slovakia (Slovak Republic)', 'QX', '+11', '40.831809', '-138.744075', 'America/Vancouver', 'USA', 'Chinese, English, German', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(463, 'Bermuda', 'IL', '+13', '67.828439', '160.495386', 'Europe/Vaduz', 'USA', 'Spanish, English', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(464, 'Germany', 'FL', '+92', '-43.624556', '-134.933132', 'Asia/Yangon', 'USA', 'Chinese, German, Spanish', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(465, 'Cameroon', 'ZY', '+66', '-39.542167', '158.760407', 'America/North_Dakota/New_Salem', 'USA', 'Chinese', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(466, 'South Africa', 'NY', '+57', '-62.25146', '14.640415', 'Africa/Lubumbashi', 'USA', 'German, Chinese', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(467, 'Saint Lucia', 'CU', '+39', '61.496494', '-44.59875', 'America/Araguaina', 'USA', 'German', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(468, 'Reunion', 'AM', '+95', '-51.665628', '48.115166', 'Europe/Stockholm', 'USA', 'German, French', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(469, 'Liberia', 'ME', '+77', '83.506035', '73.865134', 'Asia/Brunei', 'USA', 'German', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(470, 'Central African Republic', 'PB', '+4', '80.682165', '-178.554597', 'Asia/Yangon', 'USA', 'Chinese, German', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(471, 'Micronesia', 'ZE', '+21', '-1.356801', '-168.793799', 'Asia/Shanghai', 'USA', 'German, Chinese, French', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(472, 'Serbia', 'IW', '+57', '-44.929526', '-134.67795', 'Asia/Ashgabat', 'USA', 'Spanish, Chinese', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(473, 'Tokelau', 'KF', '+77', '29.398822', '5.742311', 'Asia/Muscat', 'USA', 'German, French, Spanish', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(474, 'Kenya', 'WD', '+34', '39.649428', '16.347927', 'America/Cuiaba', 'USA', 'Chinese, German', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(475, 'Eritrea', 'JE', '+2', '-41.985715', '176.061017', 'Africa/Lubumbashi', 'USA', 'Spanish, English, German', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(476, 'Korea', 'LJ', '+19', '-60.121238', '-27.363146', 'Asia/Dushanbe', 'USA', 'Chinese', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(477, 'Mali', 'ES', '+72', '-41.41282', '-61.182984', 'America/Matamoros', 'USA', 'Spanish, Chinese, German', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(478, 'New Zealand', 'LO', '+88', '47.550689', '-179.219887', 'Europe/Stockholm', 'USA', 'English', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(479, 'Spain', 'YJ', '+9', '49.014836', '85.005413', 'Asia/Almaty', 'USA', 'German, Spanish', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(480, 'Macao', 'DZ', '+30', '-13.401002', '-122.198362', 'Indian/Mauritius', 'USA', 'Chinese', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(481, 'Northern Mariana Islands', 'YQ', '+4', '40.029239', '-149.825091', 'Asia/Aqtobe', 'USA', 'German, Chinese, French', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(482, 'Japan', 'TS', '+16', '-7.18037', '-110.338692', 'Asia/Chita', 'USA', 'English', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(483, 'Latvia', 'JJ', '+91', '-52.68841', '-127.659212', 'Europe/Bucharest', 'USA', 'French', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(484, 'Northern Mariana Islands', 'QD', '+93', '59.864829', '-49.422597', 'Asia/Ho_Chi_Minh', 'USA', 'German, Spanish', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(485, 'Tunisia', 'DT', '+80', '4.838943', '172.696422', 'Asia/Kabul', 'USA', 'French, English', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(486, 'Reunion', 'QU', '+48', '1.573193', '139.148773', 'Africa/Lagos', 'USA', 'German, Spanish', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(487, 'Spain', 'GA', '+77', '-53.803561', '-151.113285', 'Pacific/Rarotonga', 'USA', 'Spanish', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(488, 'Vanuatu', 'VF', '+59', '-70.684106', '-119.798284', 'America/Cayenne', 'USA', 'English, Chinese', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(489, 'Italy', 'DW', '+23', '-88.70382', '59.45754', 'Pacific/Tongatapu', 'USA', 'Spanish, German, French', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(490, 'Equatorial Guinea', 'CB', '+67', '-27.550606', '116.291489', 'America/Chicago', 'USA', 'English, German', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(491, 'Cyprus', 'XD', '+34', '-71.74132', '-40.930145', 'America/Argentina/Catamarca', 'USA', 'German, Chinese', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(492, 'Latvia', 'DG', '+65', '76.695894', '51.303901', 'America/Cuiaba', 'USA', 'English, Spanish', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(493, 'Turkmenistan', 'MF', '+11', '14.563244', '30.564816', 'Asia/Beirut', 'USA', 'Chinese, English', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(494, 'Papua New Guinea', 'QR', '+36', '25.545039', '-165.630313', 'Asia/Bishkek', 'USA', 'French, English, Chinese', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(495, 'Costa Rica', 'WM', '+27', '74.105011', '-38.69831', 'Asia/Irkutsk', 'USA', 'Chinese', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(496, 'United Arab Emirates', 'VC', '+89', '-36.641015', '83.471953', 'Europe/Minsk', 'USA', 'English, French', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(497, 'United Arab Emirates', 'GK', '+5', '-73.930343', '92.316548', 'America/Indiana/Tell_City', 'USA', 'French', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(498, 'Saint Martin', 'MZ', '+95', '-19.844848', '99.773041', 'Asia/Gaza', 'USA', 'German, French, Chinese', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(499, 'Saint Kitts and Nevis', 'XB', '+80', '-27.236835', '172.16209', 'Africa/Brazzaville', 'USA', 'French, English, Spanish', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(500, 'Myanmar', 'NT', '+15', '78.723989', '130.161473', 'Europe/Athens', 'USA', 'Spanish', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(501, 'New Caledonia', 'HN', '+77', '-30.387689', '-99.02974', 'Asia/Yerevan', 'Japan', 'Spanish', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(502, 'Austria', 'TV', '+25', '7.248123', '104.383321', 'America/Nome', 'Japan', 'Chinese, English', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(503, 'Marshall Islands', 'YT', '+11', '-4.311895', '132.330275', 'Europe/Saratov', 'Japan', 'Chinese, French, English', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(504, 'Guernsey', 'PF', '+21', '37.604484', '70.441261', 'Pacific/Chatham', 'Japan', 'Spanish', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(505, 'Cayman Islands', 'SE', '+1', '-22.605005', '87.654343', 'America/Miquelon', 'Japan', 'English', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(506, 'Falkland Islands (Malvinas)', 'MT', '+84', '4.74634', '53.576658', 'Africa/Freetown', 'Japan', 'English, French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(507, 'Zambia', 'IF', '+38', '-12.723214', '-130.914197', 'America/Thule', 'Japan', 'French, Chinese, Spanish', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(508, 'Dominican Republic', 'KJ', '+24', '-16.459726', '-56.264877', 'America/Denver', 'Japan', 'French, German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(509, 'Romania', 'CA', '+13', '45.991115', '157.412806', 'America/Lima', 'Japan', 'Spanish, German, French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(510, 'Argentina', 'UY', '+69', '70.762041', '-139.449138', 'America/Asuncion', 'Japan', 'French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(511, 'Iraq', 'NA', '+82', '18.082632', '59.985437', 'Europe/Amsterdam', 'Japan', 'Chinese, Spanish, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(512, 'Turks and Caicos Islands', 'PJ', '+81', '32.822146', '-108.907094', 'Asia/Pyongyang', 'Japan', 'Spanish', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(513, 'Benin', 'ZW', '+29', '38.536266', '6.424689', 'America/Dawson', 'Japan', 'Spanish', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(514, 'Iran', 'UG', '+64', '-23.527783', '-175.19824', 'Europe/Warsaw', 'Japan', 'English, German, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(515, 'Mozambique', 'JZ', '+96', '31.993268', '-72.385022', 'Europe/Vienna', 'Japan', 'French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(516, 'Mauritius', 'GP', '+96', '-79.907748', '-60.839114', 'America/Boise', 'Japan', 'Spanish', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(517, 'Panama', 'BP', '+71', '30.898004', '-91.341665', 'America/Sitka', 'Japan', 'Chinese, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(518, 'Saint Kitts and Nevis', 'VI', '+63', '26.518572', '-52.498471', 'Europe/Vilnius', 'Japan', 'Chinese, English, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(519, 'Greenland', 'NM', '+7', '53.070926', '86.213447', 'Asia/Yekaterinburg', 'Japan', 'German, Chinese, Spanish', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(520, 'Afghanistan', 'TD', '+2', '87.804408', '25.257311', 'Pacific/Kiritimati', 'Japan', 'French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(521, 'Libyan Arab Jamahiriya', 'UW', '+37', '83.469339', '-29.038469', 'America/Blanc-Sablon', 'Japan', 'Chinese', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(522, 'Guatemala', 'IH', '+65', '78.065516', '156.048446', 'Asia/Makassar', 'Japan', 'French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(523, 'Palestinian Territories', 'GL', '+61', '82.971293', '124.255438', 'America/Moncton', 'Japan', 'French, English', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(524, 'Philippines', 'KB', '+37', '83.887698', '86.525576', 'Europe/Andorra', 'Japan', 'Spanish, English', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(525, 'Bahamas', 'FQ', '+32', '-38.679955', '13.523698', 'Pacific/Bougainville', 'Japan', 'Chinese, English, German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(526, 'Andorra', 'LK', '+35', '-31.034633', '-91.458285', 'Atlantic/St_Helena', 'Japan', 'German', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(527, 'Cape Verde', 'KM', '+29', '87.589635', '-90.039193', 'Africa/Kinshasa', 'Japan', 'Chinese, Spanish, German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(528, 'Maldives', 'QT', '+23', '30.127348', '-131.408589', 'America/Iqaluit', 'Japan', 'German, English, Spanish', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(529, 'Lebanon', 'EN', '+65', '68.97906', '-92.517945', 'America/Grand_Turk', 'Japan', 'Chinese, English, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(530, 'Venezuela', 'LQ', '+49', '-20.480091', '-5.552598', 'Pacific/Funafuti', 'Japan', 'English, Chinese', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(531, 'Egypt', 'NT', '+35', '-75.149792', '-162.863377', 'Europe/San_Marino', 'Japan', 'German, English', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(532, 'Gambia', 'EE', '+40', '67.602354', '-139.949441', 'Asia/Phnom_Penh', 'Japan', 'French, Chinese, German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(533, 'Palau', 'TH', '+73', '63.210025', '-25.733823', 'America/Araguaina', 'Japan', 'Spanish', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(534, 'Saint Helena', 'UD', '+26', '53.717092', '27.978146', 'Europe/Prague', 'Japan', 'German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(535, 'Nigeria', 'YV', '+41', '-74.56008', '-130.321329', 'Europe/Zagreb', 'Japan', 'English, Chinese, Spanish', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(536, 'Burkina Faso', 'WU', '+64', '-7.063301', '21.189418', 'Pacific/Pitcairn', 'Japan', 'Spanish', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(537, 'Albania', 'CS', '+31', '-20.941685', '73.750295', 'Europe/Zagreb', 'Japan', 'Chinese, French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(538, 'Morocco', 'WG', '+43', '-20.73797', '46.820022', 'America/Araguaina', 'Japan', 'Chinese, German', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(539, 'Ghana', 'WT', '+75', '-55.2669', '-47.412854', 'Asia/Kamchatka', 'Japan', 'Spanish, Chinese, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(540, 'United Arab Emirates', 'ZJ', '+93', '-88.229832', '-47.692916', 'America/St_Lucia', 'Japan', 'Chinese, Spanish, German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(541, 'British Virgin Islands', 'ZE', '+99', '13.767397', '-98.695731', 'Asia/Kuwait', 'Japan', 'Chinese, German, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(542, 'Malta', 'EY', '+79', '25.839292', '147.178467', 'Indian/Chagos', 'Japan', 'English', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(543, 'Sudan', 'NK', '+72', '-18.177168', '93.644647', 'Pacific/Wake', 'Japan', 'English, French, Chinese', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(544, 'Grenada', 'SR', '+45', '-4.716755', '-39.731021', 'Asia/Sakhalin', 'Japan', 'Chinese', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(545, 'Morocco', 'UT', '+42', '-67.546846', '92.344833', 'Europe/Minsk', 'Japan', 'Chinese', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(546, 'Saudi Arabia', 'HI', '+53', '12.533189', '91.553634', 'Africa/Ndjamena', 'Japan', 'Chinese, French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(547, 'Bhutan', 'IG', '+77', '11.871448', '-46.208759', 'America/Panama', 'Japan', 'English, Spanish, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(548, 'Iran', 'SO', '+8', '-11.127844', '-143.788969', 'Europe/Skopje', 'Japan', 'Spanish, German', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(549, 'Luxembourg', 'PB', '+58', '-67.182907', '-66.206998', 'Africa/Malabo', 'Japan', 'English', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(550, 'Holy See (Vatican City State)', 'KN', '+6', '52.950402', '72.668091', 'Asia/Brunei', 'Japan', 'German, French, Spanish', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(551, 'Cape Verde', 'AC', '+46', '38.7251', '173.135698', 'America/Thule', 'Japan', 'English', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(552, 'Kyrgyz Republic', 'YW', '+26', '-61.823033', '-126.952391', 'America/Guadeloupe', 'Japan', 'Spanish, Chinese', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(553, 'Tokelau', 'SG', '+74', '-63.798559', '174.57957', 'Antarctica/Rothera', 'Japan', 'German', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(554, 'Morocco', 'NU', '+95', '80.127593', '-32.139484', 'Pacific/Saipan', 'Japan', 'English', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(555, 'Myanmar', 'XH', '+56', '9.7541', '-14.266059', 'America/Dawson_Creek', 'Japan', 'Chinese, Spanish, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(556, 'Canada', 'JR', '+70', '26.230319', '-159.93929', 'Asia/Colombo', 'Japan', 'French, Chinese', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(557, 'Namibia', 'CU', '+2', '43.804637', '80.612011', 'America/Belize', 'Japan', 'Chinese', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(558, 'Montenegro', 'XK', '+0', '-49.491909', '-145.767828', 'Australia/Broken_Hill', 'Japan', 'English, German, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(559, 'Turkey', 'LY', '+37', '-38.415796', '151.729216', 'Europe/Lisbon', 'Japan', 'Spanish, English', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(560, 'Slovenia', 'WR', '+82', '-82.129743', '81.278092', 'Indian/Reunion', 'Japan', 'French, English, German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(561, 'Luxembourg', 'HP', '+0', '-45.330249', '20.722365', 'Asia/Samarkand', 'Japan', 'Chinese, Spanish, French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(562, 'Greenland', 'JQ', '+84', '85.333298', '-67.410838', 'Pacific/Guadalcanal', 'Japan', 'French, Chinese, German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(563, 'Saint Helena', 'XF', '+28', '-57.179063', '-170.530584', 'Africa/Kinshasa', 'Japan', 'French, Spanish', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(564, 'Brazil', 'AO', '+75', '-45.527964', '20.124513', 'America/Hermosillo', 'Japan', 'Spanish', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(565, 'Saint Barthelemy', 'HA', '+29', '37.791824', '143.430636', 'America/Lower_Princes', 'Japan', 'French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(566, 'Grenada', 'OP', '+48', '5.355438', '-119.74337', 'Pacific/Palau', 'Japan', 'German, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(567, 'Holy See (Vatican City State)', 'OA', '+59', '-74.343262', '-93.433364', 'Europe/Berlin', 'Japan', 'Spanish', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(568, 'American Samoa', 'JS', '+33', '-52.578327', '-139.388673', 'UTC', 'Japan', 'Spanish, German, Chinese', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(569, 'Seychelles', 'OY', '+24', '-43.746825', '-1.481303', 'Africa/Maputo', 'Japan', 'Spanish, German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(570, 'Barbados', 'SA', '+67', '-0.320229', '5.243732', 'America/Belem', 'Japan', 'German', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(571, 'Singapore', 'PN', '+4', '-36.13518', '73.560945', 'Pacific/Pohnpei', 'Japan', 'German, English, Spanish', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(572, 'Marshall Islands', 'DD', '+57', '-87.770906', '161.568765', 'Asia/Atyrau', 'Japan', 'Chinese', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(573, 'Azerbaijan', 'GT', '+17', '-83.460833', '-170.071909', 'Pacific/Chuuk', 'Japan', 'German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(574, 'Niue', 'XW', '+25', '-11.43683', '-104.300941', 'Africa/Douala', 'Japan', 'French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(575, 'Zimbabwe', 'VK', '+42', '76.951738', '84.423294', 'America/Sitka', 'Japan', 'German, English, French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(576, 'Malaysia', 'RM', '+24', '44.160794', '134.539015', 'Europe/Prague', 'Japan', 'German, English', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(577, 'Czech Republic', 'OC', '+58', '-62.8061', '34.524872', 'Africa/El_Aaiun', 'Japan', 'Chinese, Spanish, French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(578, 'Norfolk Island', 'MK', '+26', '16.648999', '-147.55943', 'America/Detroit', 'Japan', 'French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(579, 'Nepal', 'RD', '+51', '27.795736', '12.883591', 'Africa/Ceuta', 'Japan', 'Spanish, English, French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(580, 'Philippines', 'UN', '+65', '-74.838068', '149.077391', 'America/Anguilla', 'Japan', 'German, English', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(581, 'Cayman Islands', 'SU', '+88', '21.276645', '-158.46074', 'America/Manaus', 'Japan', 'French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(582, 'Guadeloupe', 'BT', '+69', '6.609581', '117.820911', 'Europe/Madrid', 'Japan', 'English, French, Spanish', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(583, 'Liberia', 'CG', '+5', '87.607734', '62.884416', 'Africa/Sao_Tome', 'Japan', 'Spanish, English, German', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(584, 'Dominica', 'ZH', '+8', '58.734772', '-47.626641', 'Europe/Astrakhan', 'Japan', 'Spanish, Chinese, German', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(585, 'Mongolia', 'VT', '+19', '59.805804', '-134.527266', 'Pacific/Pohnpei', 'Japan', 'German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(586, 'Iraq', 'NY', '+66', '-86.601502', '95.021811', 'America/Maceio', 'Japan', 'French, Chinese', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(587, 'Tanzania', 'RK', '+70', '68.504674', '-37.986694', 'UTC', 'Japan', 'Spanish', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(588, 'Congo', 'AF', '+46', '-88.001026', '30.023833', 'Asia/Phnom_Penh', 'Japan', 'French, Spanish, German', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(589, 'Kiribati', 'MA', '+72', '-58.43829', '126.202439', 'Pacific/Kanton', 'Japan', 'German, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(590, 'Venezuela', 'VC', '+44', '-53.558819', '-5.011062', 'Pacific/Easter', 'Japan', 'Spanish, German, English', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(591, 'Japan', 'HH', '+29', '26.303708', '-5.306594', 'America/Indiana/Marengo', 'Japan', 'Chinese, Spanish', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(592, 'Estonia', 'XM', '+21', '-65.118066', '-25.643238', 'Asia/Amman', 'Japan', 'Chinese, Spanish, German', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(593, 'Cape Verde', 'VA', '+89', '-56.42303', '6.863961', 'Pacific/Gambier', 'Japan', 'English, Chinese, French', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(594, 'Cameroon', 'UU', '+97', '60.361008', '11.100734', 'America/Chihuahua', 'Japan', 'German, French', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(595, 'Faroe Islands', 'YZ', '+82', '-22.850459', '-61.644405', 'Asia/Kamchatka', 'Japan', 'English', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(596, 'Qatar', 'VE', '+33', '4.021935', '-47.887965', 'America/Rankin_Inlet', 'Japan', 'Spanish, German', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(597, 'Uzbekistan', 'OQ', '+77', '12.484538', '174.545088', 'Europe/Copenhagen', 'Japan', 'Chinese', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(598, 'Switzerland', 'OR', '+55', '-42.182594', '30.558897', 'America/Guyana', 'Japan', 'Spanish, Chinese', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(599, 'Chile', 'QP', '+33', '-29.601729', '-119.604744', 'America/Metlakatla', 'Japan', 'French, Chinese', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(600, 'Montserrat', 'FC', '+7', '-22.405221', '114.739091', 'Atlantic/Cape_Verde', 'Japan', 'French, German, Spanish', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(601, 'Bulgaria', 'UM', '+88', '64.352654', '-79.642964', 'America/Argentina/San_Juan', 'Italy', 'Chinese, French, Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(602, 'Turkey', 'LV', '+70', '74.696256', '97.366116', 'Pacific/Chatham', 'Italy', 'German, Spanish, Chinese', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(603, 'Netherlands', 'ER', '+46', '81.929133', '-128.53075', 'Asia/Yangon', 'Italy', 'Spanish, German', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(604, 'Kazakhstan', 'QO', '+24', '75.090441', '129.420272', 'Europe/Monaco', 'Italy', 'Chinese, Spanish, French', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(605, 'United States Minor Outlying Islands', 'CC', '+83', '82.593739', '102.119899', 'Africa/Conakry', 'Italy', 'German, English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(606, 'Morocco', 'OL', '+31', '-3.478598', '30.306669', 'Europe/Riga', 'Italy', 'French', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(607, 'Russian Federation', 'BE', '+87', '12.770362', '56.781768', 'America/St_Thomas', 'Italy', 'English, French', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(608, 'Sweden', 'WS', '+29', '17.546135', '69.96377', 'Africa/Luanda', 'Italy', 'French, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(609, 'Puerto Rico', 'SQ', '+38', '-82.198454', '-154.418749', 'Europe/Kyiv', 'Italy', 'German, French, English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(610, 'Saint Pierre and Miquelon', 'CE', '+60', '-88.185246', '51.374487', 'Asia/Yekaterinburg', 'Italy', 'Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(611, 'Czech Republic', 'DC', '+45', '-74.554711', '-119.667227', 'America/Paramaribo', 'Italy', 'Chinese, German, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(612, 'Monaco', 'TD', '+47', '79.799748', '-79.074324', 'America/Swift_Current', 'Italy', 'German, Spanish, Chinese', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(613, 'Cote d\'Ivoire', 'VL', '+1', '-54.251996', '-133.287026', 'America/Indiana/Winamac', 'Italy', 'German, French, English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(614, 'United States Minor Outlying Islands', 'AR', '+56', '81.427492', '75.001821', 'Africa/Tunis', 'Italy', 'English, German, Chinese', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(615, 'Thailand', 'CB', '+16', '-0.995308', '-172.15735', 'Africa/Libreville', 'Italy', 'Spanish', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(616, 'Uzbekistan', 'TA', '+8', '-21.947331', '-30.294532', 'Africa/Johannesburg', 'Italy', 'Spanish, French', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(617, 'Benin', 'ZH', '+77', '-0.134928', '-36.45432', 'Antarctica/McMurdo', 'Italy', 'German, French, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(618, 'Nigeria', 'OO', '+81', '-24.559523', '-131.373813', 'Atlantic/Bermuda', 'Italy', 'English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(619, 'Rwanda', 'PD', '+36', '9.488421', '20.631055', 'Asia/Ashgabat', 'Italy', 'French, Chinese, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(620, 'Angola', 'UD', '+74', '-37.727762', '139.035282', 'Australia/Broken_Hill', 'Italy', 'Chinese, German, Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(621, 'Reunion', 'ZX', '+29', '34.563627', '-84.222329', 'Asia/Tehran', 'Italy', 'German', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(622, 'Tonga', 'MB', '+15', '73.341999', '124.253423', 'Europe/Simferopol', 'Italy', 'Chinese, Spanish', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(623, 'Uruguay', 'GT', '+42', '-56.630005', '0.010666', 'Africa/Blantyre', 'Italy', 'Spanish, French, Chinese', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(624, 'Bolivia', 'UC', '+33', '-54.931971', '87.290754', 'Asia/Kathmandu', 'Italy', 'Chinese', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(625, 'Tuvalu', 'RM', '+36', '10.773846', '169.520296', 'America/Argentina/San_Luis', 'Italy', 'German', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(626, 'Cook Islands', 'ID', '+24', '77.906225', '85.04113', 'Africa/Tunis', 'Italy', 'Spanish, French', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(627, 'Venezuela', 'EB', '+48', '-67.067404', '55.839701', 'Pacific/Efate', 'Italy', 'Spanish', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(628, 'Seychelles', 'NW', '+98', '47.090138', '95.341073', 'Asia/Kamchatka', 'Italy', 'French, Spanish, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(629, 'Senegal', 'KA', '+85', '17.242585', '136.714396', 'Africa/Nairobi', 'Italy', 'German, Spanish, French', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(630, 'Palestinian Territories', 'ZF', '+11', '43.941626', '-57.226247', 'America/Anguilla', 'Italy', 'French, Spanish, German', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(631, 'Algeria', 'LI', '+51', '68.427049', '89.618496', 'Asia/Gaza', 'Italy', 'English, Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(632, 'United Kingdom', 'VZ', '+55', '38.557927', '100.963184', 'Africa/Cairo', 'Italy', 'Spanish, Chinese', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(633, 'Norfolk Island', 'ZP', '+16', '5.974201', '95.729274', 'America/Swift_Current', 'Italy', 'German, Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53');
INSERT INTO `countries` (`id`, `name`, `code`, `dial_code`, `latitude`, `longitude`, `timezone`, `region`, `languages`, `status`, `created_at`, `updated_at`) VALUES
(634, 'Thailand', 'MW', '+34', '35.072385', '-152.416534', 'Australia/Perth', 'Italy', 'Chinese', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(635, 'Saint Vincent and the Grenadines', 'IC', '+63', '89.430781', '-78.137413', 'Africa/Djibouti', 'Italy', 'German, English, Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(636, 'Tunisia', 'ET', '+58', '23.803198', '10.773262', 'America/Swift_Current', 'Italy', 'Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(637, 'Palestinian Territories', 'MY', '+52', '55.229368', '172.334091', 'America/St_Vincent', 'Italy', 'Spanish, Chinese', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(638, 'Canada', 'FZ', '+87', '74.34061', '75.690542', 'America/Asuncion', 'Italy', 'Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(639, 'Kenya', 'OK', '+26', '-30.22337', '-176.641569', 'Africa/Niamey', 'Italy', 'English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(640, 'Christmas Island', 'XW', '+3', '78.620352', '58.37994', 'Pacific/Easter', 'Italy', 'Spanish, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(641, 'Iceland', 'HU', '+9', '15.572192', '-170.978521', 'America/Argentina/Mendoza', 'Italy', 'Chinese, Spanish, French', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(642, 'Burkina Faso', 'XS', '+36', '56.395441', '149.941322', 'Asia/Srednekolymsk', 'Italy', 'Spanish', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(643, 'Egypt', 'RS', '+49', '-35.065501', '162.303748', 'Pacific/Tongatapu', 'Italy', 'English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(644, 'United Kingdom', 'IU', '+87', '-4.57686', '137.854736', 'Asia/Dhaka', 'Italy', 'French, German', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(645, 'Seychelles', 'WY', '+55', '0.509885', '86.269236', 'Africa/Ouagadougou', 'Italy', 'German, Chinese', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(646, 'Turks and Caicos Islands', 'ZQ', '+42', '69.105621', '-164.27388', 'America/Paramaribo', 'Italy', 'English, Chinese, French', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(647, 'Guatemala', 'JD', '+47', '-31.955221', '72.466118', 'America/Boa_Vista', 'Italy', 'German, French, Chinese', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(648, 'Cook Islands', 'EP', '+2', '48.149133', '-79.680205', 'Pacific/Wallis', 'Italy', 'English, French, German', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(649, 'Bolivia', 'NQ', '+99', '-2.178657', '141.096032', 'Antarctica/Rothera', 'Italy', 'German, French', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(650, 'Colombia', 'MU', '+24', '47.552077', '-98.248724', 'Australia/Lindeman', 'Italy', 'Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(651, 'Rwanda', 'LO', '+78', '-58.443049', '66.416071', 'Europe/Isle_of_Man', 'Italy', 'German, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(652, 'Bulgaria', 'AS', '+87', '6.6923', '170.498454', 'Europe/Moscow', 'Italy', 'German, Chinese', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(653, 'Tokelau', 'XQ', '+31', '-82.209041', '-72.873759', 'America/Indiana/Knox', 'Italy', 'French, English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(654, 'Ethiopia', 'FK', '+26', '89.485387', '-165.086621', 'Asia/Bishkek', 'Italy', 'Spanish, Chinese, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(655, 'Gambia', 'UH', '+73', '53.889916', '-163.296987', 'Australia/Hobart', 'Italy', 'Chinese, French, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(656, 'British Indian Ocean Territory (Chagos Archipelago)', 'OU', '+74', '-35.040629', '176.017612', 'Europe/Stockholm', 'Italy', 'Spanish, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(657, 'Turkey', 'RX', '+90', '48.694064', '110.704178', 'Asia/Pontianak', 'Italy', 'Spanish, Chinese, French', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(658, 'American Samoa', 'JB', '+63', '-32.613632', '-52.375852', 'America/Tijuana', 'Italy', 'Chinese, French', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(659, 'Tajikistan', 'XU', '+39', '-15.706407', '-127.811694', 'Pacific/Auckland', 'Italy', 'French, Chinese, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(660, 'Burundi', 'YY', '+1', '-41.361072', '149.443797', 'Asia/Irkutsk', 'Italy', 'English, Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(661, 'Cape Verde', 'RK', '+2', '52.184984', '-42.694569', 'America/La_Paz', 'Italy', 'Spanish, French, Chinese', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(662, 'Turkey', 'ZK', '+91', '-59.40414', '56.371409', 'Atlantic/Madeira', 'Italy', 'Chinese, Spanish', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(663, 'Solomon Islands', 'UJ', '+89', '-45.551026', '163.701209', 'Asia/Oral', 'Italy', 'Spanish, German, English', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(664, 'Chad', 'EQ', '+88', '36.207535', '-142.51517', 'Europe/Paris', 'Italy', 'Spanish, French, German', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(665, 'Mauritania', 'TC', '+84', '60.940341', '-137.930018', 'Africa/Lubumbashi', 'Italy', 'English, German', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(666, 'Costa Rica', 'HD', '+10', '24.624801', '82.540071', 'Australia/Perth', 'Italy', 'English, French', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(667, 'Cayman Islands', 'ZA', '+33', '-5.300445', '-128.600089', 'Asia/Phnom_Penh', 'Italy', 'Spanish, English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(668, 'Luxembourg', 'YV', '+3', '48.303975', '-8.404849', 'America/Paramaribo', 'Italy', 'Spanish, English, German', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(669, 'Maldives', 'MS', '+14', '-33.68648', '34.685466', 'Antarctica/Macquarie', 'Italy', 'Chinese, Spanish, French', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(670, 'Cote d\'Ivoire', 'WW', '+8', '83.130656', '179.81932', 'Asia/Aqtau', 'Italy', 'German, English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(671, 'Slovenia', 'MT', '+93', '-6.6806', '97.712105', 'Atlantic/Cape_Verde', 'Italy', 'French', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(672, 'Maldives', 'NI', '+43', '89.605691', '-33.819558', 'Europe/Monaco', 'Italy', 'German, French, Chinese', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(673, 'Kazakhstan', 'PK', '+94', '-14.132956', '34.995113', 'Asia/Riyadh', 'Italy', 'English, Spanish, Chinese', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(674, 'Pitcairn Islands', 'JP', '+8', '18.55412', '179.413497', 'America/Grenada', 'Italy', 'Chinese, Spanish', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(675, 'Denmark', 'ND', '+49', '-12.010292', '51.627566', 'America/Asuncion', 'Italy', 'Chinese', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(676, 'Cyprus', 'KX', '+83', '-89.132457', '120.8696', 'Indian/Chagos', 'Italy', 'English, Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(677, 'Falkland Islands (Malvinas)', 'AO', '+15', '55.57407', '-157.036459', 'Europe/Tirane', 'Italy', 'German, Spanish, French', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(678, 'Finland', 'HC', '+76', '-49.401616', '-129.89133', 'Asia/Baku', 'Italy', 'English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(679, 'San Marino', 'XH', '+28', '80.339244', '-57.92', 'Europe/Kirov', 'Italy', 'English, Chinese, French', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(680, 'Iraq', 'LB', '+95', '28.87318', '-115.008092', 'America/Detroit', 'Italy', 'French', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(681, 'Latvia', 'HY', '+8', '-18.318637', '72.513937', 'Asia/Famagusta', 'Italy', 'Chinese, French', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(682, 'Libyan Arab Jamahiriya', 'BQ', '+66', '-39.362631', '74.462905', 'Europe/Volgograd', 'Italy', 'Spanish, Chinese, English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(683, 'Tokelau', 'ZY', '+92', '-18.645501', '-151.629729', 'Europe/Vatican', 'Italy', 'French, English, German', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(684, 'Marshall Islands', 'TO', '+82', '86.778312', '-40.5432', 'America/Argentina/Buenos_Aires', 'Italy', 'Spanish', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(685, 'South Georgia and the South Sandwich Islands', 'VE', '+9', '-29.830314', '-85.89018', 'Asia/Jakarta', 'Italy', 'Chinese, English, German', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(686, 'Indonesia', 'XD', '+91', '57.792898', '-18.817225', 'Europe/Vienna', 'Italy', 'Spanish, Chinese', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(687, 'Egypt', 'UX', '+17', '-82.145658', '21.55714', 'Asia/Bishkek', 'Italy', 'French', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(688, 'Macedonia', 'KO', '+53', '-68.446417', '175.89006', 'America/North_Dakota/New_Salem', 'Italy', 'English, Spanish', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(689, 'Cocos (Keeling) Islands', 'WP', '+18', '89.132572', '57.043241', 'Africa/Bissau', 'Italy', 'French, English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(690, 'Greenland', 'SF', '+69', '55.893177', '3.301151', 'Africa/Gaborone', 'Italy', 'Spanish, English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(691, 'British Virgin Islands', 'UR', '+97', '-75.000989', '133.852153', 'Atlantic/Azores', 'Italy', 'German', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(692, 'Ireland', 'RT', '+88', '7.664206', '101.921038', 'Europe/Simferopol', 'Italy', 'Chinese', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(693, 'Guam', 'YM', '+5', '76.590059', '-82.951784', 'America/Aruba', 'Italy', 'English, French', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(694, 'New Zealand', 'FI', '+99', '12.007846', '78.381141', 'America/Goose_Bay', 'Italy', 'English, German', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(695, 'Lesotho', 'AV', '+53', '76.391254', '123.864206', 'UTC', 'Italy', 'German, English, Spanish', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(696, 'Bangladesh', 'TX', '+7', '-47.33959', '25.383565', 'Asia/Aqtau', 'Italy', 'French', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(697, 'Angola', 'NC', '+20', '-26.455712', '174.905945', 'America/Dominica', 'Italy', 'French, English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(698, 'Burundi', 'UG', '+64', '-77.873828', '142.300902', 'Europe/Moscow', 'Italy', 'Spanish, German', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(699, 'Bouvet Island (Bouvetoya)', 'OW', '+19', '-1.392476', '54.501211', 'Europe/Isle_of_Man', 'Italy', 'French, Chinese', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(700, 'Pakistan', 'PM', '+2', '-78.28045', '-158.270001', 'Asia/Ashgabat', 'Italy', 'English', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(701, 'Norway', 'WR', '+68', '81.952846', '-67.419612', 'Asia/Ho_Chi_Minh', 'Mexico', 'Spanish, English', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(702, 'Netherlands Antilles', 'YI', '+96', '-14.652923', '110.641784', 'Africa/Algiers', 'Mexico', 'English, Spanish, Chinese', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(703, 'Portugal', 'DS', '+82', '87.137948', '47.233698', 'America/Phoenix', 'Mexico', 'English', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(704, 'Kyrgyz Republic', 'MN', '+34', '-5.755599', '122.943233', 'America/Indiana/Knox', 'Mexico', 'German, Chinese, Spanish', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(705, 'Nepal', 'DZ', '+3', '-59.144145', '-117.216754', 'Europe/San_Marino', 'Mexico', 'Spanish', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(706, 'Saint Barthelemy', 'HW', '+86', '-79.457265', '-29.827328', 'Africa/Bissau', 'Mexico', 'Spanish', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(707, 'Djibouti', 'XS', '+64', '-87.9832', '95.756595', 'Asia/Omsk', 'Mexico', 'French, German', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(708, 'Barbados', 'MK', '+73', '43.497466', '-128.087476', 'Europe/Busingen', 'Mexico', 'Spanish, French', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(709, 'Togo', 'QH', '+85', '21.740793', '-71.710373', 'Asia/Yekaterinburg', 'Mexico', 'German', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(710, 'Lebanon', 'LO', '+2', '70.358792', '94.643972', 'Europe/Prague', 'Mexico', 'Chinese, French, English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(711, 'Holy See (Vatican City State)', 'DK', '+21', '26.797424', '41.63004', 'Asia/Hebron', 'Mexico', 'Spanish, German, Chinese', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(712, 'Madagascar', 'MP', '+16', '-7.217974', '-118.122929', 'Asia/Damascus', 'Mexico', 'English, German, Chinese', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(713, 'Saint Vincent and the Grenadines', 'CY', '+21', '4.136418', '170.036253', 'America/Whitehorse', 'Mexico', 'Spanish, Chinese', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(714, 'Tunisia', 'JK', '+44', '-39.914302', '-80.205497', 'America/Rankin_Inlet', 'Mexico', 'Spanish', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(715, 'Korea', 'NA', '+93', '45.12848', '24.882389', 'America/Campo_Grande', 'Mexico', 'French, Chinese, English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(716, 'Libyan Arab Jamahiriya', 'DI', '+16', '52.729998', '138.050071', 'Pacific/Niue', 'Mexico', 'French, Spanish', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(717, 'Vietnam', 'GD', '+68', '-82.986062', '-16.502583', 'America/Yakutat', 'Mexico', 'German', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(718, 'Saint Helena', 'HV', '+79', '63.966617', '-131.744278', 'America/Bogota', 'Mexico', 'Spanish', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(719, 'Cameroon', 'WH', '+16', '-56.041738', '174.670959', 'Antarctica/Casey', 'Mexico', 'Spanish', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(720, 'Belarus', 'WG', '+45', '-23.841382', '141.888296', 'America/St_Barthelemy', 'Mexico', 'French, German', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(721, 'Saint Pierre and Miquelon', 'ZA', '+95', '81.595746', '-179.55415', 'America/Eirunepe', 'Mexico', 'French', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(722, 'Chile', 'VV', '+69', '11.055273', '-168.171271', 'Asia/Bahrain', 'Mexico', 'French, Spanish, German', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(723, 'Belgium', 'HZ', '+28', '9.206143', '18.026178', 'Pacific/Kiritimati', 'Mexico', 'German', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(724, 'Cameroon', 'YC', '+47', '35.577854', '109.858051', 'Asia/Magadan', 'Mexico', 'Chinese, German, English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(725, 'Equatorial Guinea', 'FG', '+19', '-37.994444', '178.6093', 'Asia/Damascus', 'Mexico', 'French', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(726, 'Rwanda', 'DB', '+64', '46.108477', '32.40971', 'America/Denver', 'Mexico', 'French, English, Chinese', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(727, 'Uganda', 'OV', '+50', '23.820597', '-12.228705', 'Asia/Urumqi', 'Mexico', 'French', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(728, 'Cambodia', 'ED', '+94', '12.822674', '-167.336509', 'America/Fortaleza', 'Mexico', 'Spanish, French', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(729, 'Niger', 'MJ', '+59', '-86.207731', '36.028892', 'Europe/Guernsey', 'Mexico', 'German, English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(730, 'Holy See (Vatican City State)', 'VJ', '+78', '-7.509496', '6.544522', 'Asia/Kuwait', 'Mexico', 'French, German, English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(731, 'Guatemala', 'AI', '+65', '20.224294', '8.551684', 'Asia/Manila', 'Mexico', 'German, Chinese', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(732, 'United Arab Emirates', 'EU', '+51', '15.309748', '118.204359', 'America/Lower_Princes', 'Mexico', 'French, Chinese', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(733, 'Macedonia', 'UO', '+94', '-15.205614', '-146.81187', 'America/Montevideo', 'Mexico', 'French, Spanish', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(734, 'New Caledonia', 'CN', '+22', '-69.960126', '157.052873', 'Asia/Hebron', 'Mexico', 'English', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(735, 'Estonia', 'YP', '+21', '-12.960854', '-33.488983', 'Indian/Kerguelen', 'Mexico', 'Spanish, Chinese, English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(736, 'Cameroon', 'TP', '+95', '69.261386', '-76.510091', 'Europe/Jersey', 'Mexico', 'Chinese, English', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(737, 'Iran', 'DN', '+60', '-7.12993', '130.368386', 'Africa/Dar_es_Salaam', 'Mexico', 'Chinese, English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(738, 'Brazil', 'AA', '+12', '44.924351', '-27.979114', 'Indian/Maldives', 'Mexico', 'French, Spanish', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(739, 'Norway', 'KI', '+40', '-80.655938', '-52.855896', 'Europe/Monaco', 'Mexico', 'German, French, English', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(740, 'Afghanistan', 'DY', '+95', '32.237246', '-15.535195', 'America/Resolute', 'Mexico', 'French, English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(741, 'Costa Rica', 'FZ', '+95', '23.689548', '95.041238', 'America/Bogota', 'Mexico', 'English, German', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(742, 'Saint Kitts and Nevis', 'ZT', '+65', '57.343244', '-6.105929', 'Asia/Makassar', 'Mexico', 'French, Chinese, Spanish', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(743, 'Malawi', 'LB', '+65', '1.56198', '-32.392396', 'Europe/Dublin', 'Mexico', 'Chinese, Spanish, French', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(744, 'Ecuador', 'PT', '+3', '-84.346016', '129.739897', 'Pacific/Saipan', 'Mexico', 'Spanish', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(745, 'Philippines', 'SQ', '+79', '-75.483642', '-89.787637', 'America/Atikokan', 'Mexico', 'Spanish, French, English', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(746, 'Cook Islands', 'TB', '+37', '43.016862', '-58.777383', 'America/St_Thomas', 'Mexico', 'Spanish', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(747, 'Croatia', 'QF', '+9', '-23.414287', '74.823183', 'America/Guyana', 'Mexico', 'Chinese, German', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(748, 'Saint Martin', 'TN', '+61', '-33.312917', '65.976574', 'America/Argentina/Jujuy', 'Mexico', 'French, English', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(749, 'Barbados', 'KF', '+43', '85.578484', '177.108821', 'Pacific/Chuuk', 'Mexico', 'German, Spanish, English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(750, 'France', 'NI', '+94', '65.035239', '39.504937', 'Pacific/Wallis', 'Mexico', 'German, Spanish', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(751, 'Somalia', 'HU', '+10', '35.736845', '-31.037266', 'Africa/Kinshasa', 'Mexico', 'German, English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(752, 'Bouvet Island (Bouvetoya)', 'HY', '+79', '-24.572064', '-124.612935', 'Asia/Barnaul', 'Mexico', 'Spanish, French, Chinese', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(753, 'Sao Tome and Principe', 'HJ', '+53', '0.248297', '-152.919284', 'Europe/Podgorica', 'Mexico', 'English, German', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(754, 'Mexico', 'KZ', '+23', '-5.629923', '-68.711604', 'Africa/Sao_Tome', 'Mexico', 'English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(755, 'Afghanistan', 'LE', '+63', '28.036844', '-176.044987', 'Europe/Berlin', 'Mexico', 'German, English, French', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(756, 'Solomon Islands', 'SD', '+94', '-34.605789', '33.284024', 'Africa/El_Aaiun', 'Mexico', 'English, Chinese, French', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(757, 'Taiwan', 'RO', '+11', '-26.700316', '-121.427432', 'America/Atikokan', 'Mexico', 'French', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(758, 'British Indian Ocean Territory (Chagos Archipelago)', 'GX', '+34', '13.368135', '-116.768792', 'Asia/Hong_Kong', 'Mexico', 'English, French, German', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(759, 'Poland', 'ES', '+55', '-79.461346', '95.495689', 'America/Metlakatla', 'Mexico', 'German, French', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(760, 'Netherlands', 'WE', '+40', '-58.963018', '9.846323', 'America/Port_of_Spain', 'Mexico', 'French, English, German', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(761, 'Aruba', 'QB', '+85', '68.991292', '70.436906', 'Asia/Famagusta', 'Mexico', 'Spanish, Chinese, French', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(762, 'Andorra', 'UC', '+79', '30.636984', '-141.660393', 'Africa/Tunis', 'Mexico', 'Chinese', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(763, 'Albania', 'JQ', '+38', '64.735309', '-9.247871', 'Europe/Samara', 'Mexico', 'Spanish', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(764, 'Cambodia', 'BC', '+4', '-16.131963', '150.504755', 'Europe/Brussels', 'Mexico', 'Chinese, Spanish', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(765, 'Japan', 'OR', '+13', '-14.494014', '-149.1038', 'Africa/Harare', 'Mexico', 'English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(766, 'Finland', 'SY', '+25', '-30.297804', '37.352856', 'Asia/Novokuznetsk', 'Mexico', 'Chinese', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(767, 'Tuvalu', 'QD', '+63', '-75.059873', '-92.6275', 'Africa/Ndjamena', 'Mexico', 'French, Chinese', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(768, 'Netherlands', 'IU', '+0', '26.643511', '163.7407', 'Asia/Novokuznetsk', 'Mexico', 'Spanish, Chinese, German', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(769, 'Tajikistan', 'UZ', '+8', '66.878611', '99.883579', 'America/Aruba', 'Mexico', 'German, Chinese', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(770, 'Jamaica', 'FE', '+51', '-67.853615', '93.015539', 'Asia/Kamchatka', 'Mexico', 'English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(771, 'Vanuatu', 'LM', '+58', '10.865758', '73.618288', 'Europe/Luxembourg', 'Mexico', 'English, German', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(772, 'Colombia', 'SA', '+10', '28.405669', '-162.842329', 'America/Santarem', 'Mexico', 'German, French', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(773, 'Niue', 'OE', '+89', '-89.351628', '87.681019', 'Australia/Melbourne', 'Mexico', 'Chinese', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(774, 'Lao People\'s Democratic Republic', 'MM', '+81', '-34.097722', '82.324975', 'America/Santarem', 'Mexico', 'German, English, French', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(775, 'Saint Helena', 'AG', '+91', '80.001873', '20.724859', 'Asia/Ho_Chi_Minh', 'Mexico', 'Chinese, Spanish, French', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(776, 'Cote d\'Ivoire', 'SP', '+76', '50.214014', '164.888698', 'America/Resolute', 'Mexico', 'Chinese, Spanish, French', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(777, 'Ukraine', 'OG', '+15', '-29.020501', '132.364285', 'America/Rio_Branco', 'Mexico', 'Chinese', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(778, 'Somalia', 'QQ', '+36', '56.763452', '121.002199', 'Antarctica/Mawson', 'Mexico', 'French, Chinese, Spanish', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(779, 'Tonga', 'NS', '+89', '-45.83138', '13.894948', 'America/Argentina/Salta', 'Mexico', 'English', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(780, 'Netherlands', 'HS', '+56', '79.221007', '-59.583504', 'Europe/Monaco', 'Mexico', 'English, Spanish, German', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(781, 'Mauritius', 'WS', '+96', '-41.219757', '-84.948565', 'Europe/Busingen', 'Mexico', 'German, French', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(782, 'Czech Republic', 'VS', '+70', '-12.84616', '173.451667', 'America/Yakutat', 'Mexico', 'English', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(783, 'Montserrat', 'LZ', '+23', '-65.610805', '-1.81019', 'America/Aruba', 'Mexico', 'English, French, Spanish', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(784, 'French Polynesia', 'RV', '+82', '-82.451872', '-8.776652', 'Indian/Maldives', 'Mexico', 'Spanish, French', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(785, 'Greece', 'OM', '+52', '63.486589', '175.198798', 'Africa/Niamey', 'Mexico', 'German, Spanish', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(786, 'Turks and Caicos Islands', 'TU', '+5', '-11.27911', '149.754214', 'Pacific/Norfolk', 'Mexico', 'Spanish, German, French', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(787, 'Slovakia (Slovak Republic)', 'RS', '+52', '-5.488923', '-58.199832', 'America/Cayenne', 'Mexico', 'French, Spanish, Chinese', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(788, 'Myanmar', 'VU', '+50', '9.330115', '-84.440761', 'America/Rankin_Inlet', 'Mexico', 'French, German', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(789, 'Wallis and Futuna', 'AJ', '+97', '-39.664602', '133.961445', 'America/Tegucigalpa', 'Mexico', 'Spanish', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(790, 'Western Sahara', 'UY', '+72', '78.083473', '4.04426', 'Africa/Banjul', 'Mexico', 'French, Spanish, German', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(791, 'Pitcairn Islands', 'JS', '+12', '-10.197357', '75.928775', 'Asia/Taipei', 'Mexico', 'English, Chinese, German', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(792, 'Burkina Faso', 'GP', '+27', '38.082031', '44.925509', 'Asia/Amman', 'Mexico', 'German', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(793, 'French Polynesia', 'KR', '+79', '-12.669636', '-73.967288', 'America/Campo_Grande', 'Mexico', 'Chinese, German', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(794, 'Taiwan', 'CL', '+25', '-5.592681', '-15.909034', 'Pacific/Kiritimati', 'Mexico', 'Chinese, English', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(795, 'Bosnia and Herzegovina', 'SX', '+62', '-87.943906', '-89.919304', 'Atlantic/Bermuda', 'Mexico', 'Chinese, Spanish, German', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(796, 'Ecuador', 'GM', '+88', '61.234021', '-153.486101', 'America/Paramaribo', 'Mexico', 'Chinese, Spanish, English', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(797, 'Mayotte', 'YK', '+14', '26.091148', '-78.077121', 'Europe/Malta', 'Mexico', 'French, Chinese, English', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(798, 'Afghanistan', 'FK', '+88', '-37.59156', '154.007617', 'America/Dominica', 'Mexico', 'German', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(799, 'Uganda', 'CE', '+5', '83.006337', '99.41872', 'Asia/Bangkok', 'Mexico', 'German, English, French', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(800, 'Iraq', 'YD', '+61', '45.678254', '142.077911', 'Pacific/Pohnpei', 'Mexico', 'Chinese, Spanish', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(801, 'Sao Tome and Principe', 'AT', '+12', '45.917106', '-43.966031', 'Antarctica/DumontDUrville', 'Germany', 'German', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(802, 'France', 'CD', '+9', '-22.18894', '-41.274568', 'America/Ciudad_Juarez', 'Germany', 'English, Chinese, German', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(803, 'Hong Kong', 'WC', '+2', '44.475925', '173.672108', 'Asia/Yerevan', 'Germany', 'German, French, Chinese', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(804, 'Poland', 'WF', '+37', '69.791161', '-170.108537', 'Europe/Madrid', 'Germany', 'Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(805, 'New Zealand', 'HG', '+92', '17.05547', '112.583259', 'America/Barbados', 'Germany', 'German, French', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(806, 'Chile', 'ZD', '+3', '-32.830359', '133.46954', 'Atlantic/Canary', 'Germany', 'English, Spanish', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(807, 'Guam', 'ZU', '+44', '-31.917293', '-15.482848', 'America/New_York', 'Germany', 'German, French', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(808, 'French Southern Territories', 'RP', '+57', '23.694335', '113.907008', 'America/Tijuana', 'Germany', 'French', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(809, 'Mongolia', 'TN', '+23', '25.136286', '-82.132772', 'America/El_Salvador', 'Germany', 'French, Chinese', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(810, 'Niger', 'YP', '+79', '53.820272', '-18.844346', 'Asia/Kuala_Lumpur', 'Germany', 'French', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(811, 'Wallis and Futuna', 'JU', '+61', '43.308103', '-144.50988', 'Europe/Paris', 'Germany', 'French, Chinese, Spanish', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(812, 'Jamaica', 'CE', '+58', '31.426949', '150.75133', 'Africa/Ceuta', 'Germany', 'German, English, Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(813, 'Brunei Darussalam', 'NQ', '+56', '64.200393', '137.58853', 'America/Curacao', 'Germany', 'Chinese', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(814, 'Costa Rica', 'EE', '+59', '-23.082426', '-54.381889', 'Pacific/Galapagos', 'Germany', 'French', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(815, 'El Salvador', 'DM', '+30', '-52.912649', '-147.514936', 'Asia/Kamchatka', 'Germany', 'German', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(816, 'Saint Pierre and Miquelon', 'ED', '+9', '21.685508', '-154.134902', 'Indian/Kerguelen', 'Germany', 'French', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(817, 'New Zealand', 'MZ', '+6', '-42.590912', '23.346167', 'Asia/Bahrain', 'Germany', 'English, Chinese, German', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(818, 'Guadeloupe', 'WX', '+75', '-7.180107', '-132.226761', 'America/Cancun', 'Germany', 'German, English, French', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(819, 'El Salvador', 'YW', '+81', '-69.678657', '-142.69848', 'Asia/Muscat', 'Germany', 'Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(820, 'Ecuador', 'OY', '+37', '-13.272012', '-77.593387', 'Antarctica/Palmer', 'Germany', 'English, Spanish, Chinese', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(821, 'Dominica', 'UJ', '+90', '-18.556425', '147.374945', 'Antarctica/Davis', 'Germany', 'German, French, Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(822, 'United States Minor Outlying Islands', 'VX', '+60', '-36.171545', '-61.043952', 'America/Recife', 'Germany', 'Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(823, 'Macedonia', 'FW', '+25', '-14.141338', '50.521939', 'Asia/Qatar', 'Germany', 'Spanish, Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(824, 'Iraq', 'SA', '+63', '1.92792', '-81.945805', 'America/Belize', 'Germany', 'German, Spanish', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(825, 'Senegal', 'MH', '+8', '55.527127', '-118.042689', 'Europe/Kaliningrad', 'Germany', 'German, English, Chinese', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(826, 'Belize', 'MG', '+93', '6.434329', '116.604842', 'America/Argentina/Rio_Gallegos', 'Germany', 'German, Chinese, English', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(827, 'Mayotte', 'VP', '+76', '50.461313', '-34.678483', 'Pacific/Palau', 'Germany', 'French', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(828, 'Colombia', 'RV', '+76', '-49.353153', '18.745627', 'Asia/Baghdad', 'Germany', 'French, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(829, 'Trinidad and Tobago', 'EI', '+58', '55.006114', '167.093395', 'America/Cancun', 'Germany', 'Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(830, 'Luxembourg', 'OP', '+95', '-11.265093', '79.486279', 'Asia/Pontianak', 'Germany', 'German, English', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(831, 'Kiribati', 'LJ', '+55', '52.50748', '-82.622872', 'America/Port_of_Spain', 'Germany', 'Chinese, French, English', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(832, 'French Polynesia', 'XO', '+53', '-17.261543', '178.681459', 'Asia/Phnom_Penh', 'Germany', 'English, German, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(833, 'Switzerland', 'KN', '+41', '-72.439662', '-177.077402', 'Asia/Khandyga', 'Germany', 'Spanish, English', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(834, 'Singapore', 'GC', '+49', '-18.697422', '-174.447985', 'America/Juneau', 'Germany', 'French, Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(835, 'Kuwait', 'HV', '+48', '89.943936', '-34.823383', 'America/Kentucky/Louisville', 'Germany', 'English', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(836, 'Liechtenstein', 'BH', '+54', '-62.187055', '-164.525689', 'Europe/Kirov', 'Germany', 'English', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(837, 'Jersey', 'CN', '+73', '24.440337', '36.51413', 'America/Yakutat', 'Germany', 'English, Spanish, Chinese', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(838, 'Botswana', 'MS', '+11', '51.227224', '-115.664797', 'America/Recife', 'Germany', 'Chinese, French', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(839, 'Cambodia', 'PZ', '+93', '27.440588', '-158.048064', 'Australia/Hobart', 'Germany', 'Spanish, Chinese, French', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(840, 'Zimbabwe', 'HN', '+30', '12.886711', '53.469743', 'America/North_Dakota/Beulah', 'Germany', 'French, Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(841, 'Barbados', 'LS', '+89', '-40.438971', '-42.273238', 'Europe/Moscow', 'Germany', 'French, Spanish', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(842, 'Myanmar', 'JW', '+83', '-9.421624', '9.392698', 'Africa/Malabo', 'Germany', 'Chinese, German, English', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(843, 'Austria', 'JF', '+48', '-20.945023', '-114.362268', 'Europe/Podgorica', 'Germany', 'Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(844, 'Bangladesh', 'EY', '+27', '-39.18095', '-58.721069', 'Australia/Eucla', 'Germany', 'German, English', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(845, 'Cocos (Keeling) Islands', 'UN', '+2', '37.325335', '126.498724', 'Pacific/Easter', 'Germany', 'Chinese, Spanish', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(846, 'Cuba', 'OL', '+66', '-67.982', '-164.481169', 'Africa/Johannesburg', 'Germany', 'Spanish, German, French', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(847, 'Slovakia (Slovak Republic)', 'LZ', '+0', '57.008586', '177.276839', 'Europe/Riga', 'Germany', 'German', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(848, 'Montenegro', 'NM', '+7', '49.515228', '-123.301619', 'UTC', 'Germany', 'English, French, German', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(849, 'Wallis and Futuna', 'FX', '+92', '-59.009178', '135.850128', 'America/Creston', 'Germany', 'Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(850, 'Malta', 'UF', '+32', '-3.930965', '-26.987899', 'Asia/Ulaanbaatar', 'Germany', 'English', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(851, 'Azerbaijan', 'LM', '+86', '41.043413', '-12.86628', 'America/Argentina/San_Luis', 'Germany', 'English, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(852, 'Somalia', 'GS', '+42', '-64.242825', '30.504701', 'America/Juneau', 'Germany', 'German', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(853, 'Guernsey', 'QX', '+8', '78.989653', '75.984113', 'Asia/Almaty', 'Germany', 'English, Chinese, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(854, 'Cameroon', 'HE', '+33', '16.626293', '-23.472957', 'Asia/Bishkek', 'Germany', 'English, French, German', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(855, 'Isle of Man', 'KQ', '+61', '-42.419971', '-22.220181', 'Europe/Busingen', 'Germany', 'Chinese, French', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(856, 'Anguilla', 'EC', '+4', '-87.314826', '-82.953013', 'America/Kentucky/Louisville', 'Germany', 'French, Chinese, German', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(857, 'Cocos (Keeling) Islands', 'AM', '+39', '-8.936676', '-1.980354', 'Africa/Dar_es_Salaam', 'Germany', 'Spanish, Chinese, German', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(858, 'British Indian Ocean Territory (Chagos Archipelago)', 'FA', '+21', '15.547326', '44.177724', 'Africa/Windhoek', 'Germany', 'Spanish, French', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(859, 'Kuwait', 'UG', '+41', '43.298913', '-3.001689', 'Pacific/Guam', 'Germany', 'Chinese, French', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(860, 'New Caledonia', 'PQ', '+28', '51.027899', '-78.065144', 'Europe/Zurich', 'Germany', 'Chinese, German, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(861, 'Guinea-Bissau', 'BR', '+27', '67.943847', '-144.457454', 'America/Curacao', 'Germany', 'Chinese, English, Spanish', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(862, 'Germany', 'JC', '+44', '32.396198', '-138.821041', 'Pacific/Kanton', 'Germany', 'Spanish, German', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(863, 'Turkey', 'SR', '+57', '-31.213519', '-72.791259', 'America/Indiana/Vincennes', 'Germany', 'Chinese, French, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(864, 'Australia', 'ZL', '+54', '52.272446', '-154.909957', 'America/Indiana/Tell_City', 'Germany', 'German, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(865, 'Tokelau', 'NG', '+61', '2.375508', '-67.379577', 'Europe/Malta', 'Germany', 'French, German, Chinese', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(866, 'Iceland', 'XZ', '+84', '10.549139', '130.392632', 'Australia/Melbourne', 'Germany', 'German', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(867, 'Chad', 'RB', '+23', '44.968904', '-131.437992', 'America/Cancun', 'Germany', 'French, Chinese, German', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(868, 'Morocco', 'BE', '+15', '-9.454364', '-72.05774', 'Asia/Hong_Kong', 'Germany', 'Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(869, 'Korea', 'BZ', '+45', '-72.989454', '119.77549', 'America/Kralendijk', 'Germany', 'Spanish', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(870, 'Argentina', 'UC', '+24', '25.74675', '178.005581', 'America/Boise', 'Germany', 'Chinese, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(871, 'Poland', 'AI', '+22', '-50.766471', '110.788712', 'Europe/Chisinau', 'Germany', 'German, Spanish', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(872, 'Colombia', 'EQ', '+3', '-28.491183', '-19.371017', 'Asia/Kathmandu', 'Germany', 'Spanish, Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(873, 'New Zealand', 'HU', '+22', '31.892165', '-171.956194', 'Africa/Lubumbashi', 'Germany', 'Chinese', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(874, 'Niue', 'YA', '+77', '64.591363', '89.312258', 'Pacific/Palau', 'Germany', 'Chinese, German', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(875, 'Ecuador', 'DR', '+90', '-5.704946', '53.033184', 'Africa/Lome', 'Germany', 'Chinese, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(876, 'Cuba', 'DW', '+83', '-67.367408', '-16.845917', 'America/Curacao', 'Germany', 'German, Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(877, 'Morocco', 'PG', '+65', '41.509352', '-22.4734', 'Africa/Conakry', 'Germany', 'Chinese, Spanish', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(878, 'Germany', 'PD', '+5', '-64.624482', '-77.255384', 'America/Grenada', 'Germany', 'Chinese, German, English', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(879, 'British Virgin Islands', 'PH', '+37', '-8.119225', '-124.633563', 'Africa/Nouakchott', 'Germany', 'German', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(880, 'Hong Kong', 'DK', '+64', '62.219273', '101.854368', 'Africa/Addis_Ababa', 'Germany', 'English, German, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(881, 'Monaco', 'OZ', '+68', '22.748136', '111.203285', 'Pacific/Port_Moresby', 'Germany', 'Chinese, German', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(882, 'British Virgin Islands', 'SX', '+10', '-72.69456', '-125.678981', 'Asia/Yakutsk', 'Germany', 'Chinese, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(883, 'El Salvador', 'JB', '+70', '8.389408', '137.987173', 'America/Indiana/Tell_City', 'Germany', 'Spanish, French, Chinese', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(884, 'Cocos (Keeling) Islands', 'DO', '+0', '4.395062', '81.904512', 'Pacific/Galapagos', 'Germany', 'French', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(885, 'Guatemala', 'AS', '+61', '-85.346909', '-154.208855', 'America/Noronha', 'Germany', 'French, English', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(886, 'Christmas Island', 'AR', '+6', '-37.448161', '39.670164', 'Asia/Nicosia', 'Germany', 'Chinese', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(887, 'Central African Republic', 'AE', '+91', '-14.927183', '-61.669682', 'America/St_Lucia', 'Germany', 'English, Chinese, French', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(888, 'Ghana', 'VI', '+83', '-34.344559', '79.162969', 'Antarctica/Macquarie', 'Germany', 'German', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(889, 'Luxembourg', 'PR', '+27', '-4.446445', '-168.98925', 'Africa/Lubumbashi', 'Germany', 'Chinese, German, Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(890, 'Sweden', 'WI', '+96', '13.657568', '31.316858', 'America/Guayaquil', 'Germany', 'German, Spanish, English', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(891, 'French Guiana', 'CA', '+97', '57.556639', '93.789872', 'Europe/Bucharest', 'Germany', 'Spanish', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(892, 'Somalia', 'IJ', '+13', '11.700575', '-13.291782', 'Africa/Blantyre', 'Germany', 'English, French, German', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(893, 'Saint Lucia', 'KO', '+85', '9.630956', '-42.00606', 'Africa/Abidjan', 'Germany', 'French', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(894, 'Grenada', 'QR', '+59', '30.524355', '-50.461197', 'Europe/Mariehamn', 'Germany', 'Spanish, German', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(895, 'United Arab Emirates', 'PI', '+22', '-2.04031', '64.192677', 'Antarctica/Palmer', 'Germany', 'Chinese, Spanish, French', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(896, 'Western Sahara', 'NJ', '+98', '-10.361097', '-89.759575', 'Indian/Mauritius', 'Germany', 'English, French', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(897, 'Faroe Islands', 'GY', '+49', '14.63655', '-142.479706', 'America/Argentina/Tucuman', 'Germany', 'French, German', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(898, 'Andorra', 'SB', '+76', '44.51673', '-28.70982', 'America/Nome', 'Germany', 'Spanish, English, German', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(899, 'Namibia', 'NV', '+34', '-69.96098', '31.076638', 'America/Indiana/Vincennes', 'Germany', 'Chinese, Spanish, French', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(900, 'Benin', 'YL', '+58', '-77.808554', '115.131865', 'Asia/Dili', 'Germany', 'Spanish, Chinese, French', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(901, 'Malaysia', 'FF', '+58', '-84.262441', '63.140696', 'America/Chicago', 'Mexico', 'Chinese, English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(902, 'New Caledonia', 'DH', '+87', '-59.474052', '-103.074174', 'Pacific/Kwajalein', 'Mexico', 'English, German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(903, 'Czech Republic', 'XT', '+13', '-56.593778', '151.833722', 'Asia/Tomsk', 'Mexico', 'German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(904, 'Estonia', 'UT', '+34', '36.419684', '-75.131245', 'Atlantic/Reykjavik', 'Mexico', 'English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(905, 'Chad', 'JJ', '+43', '8.849627', '141.083574', 'America/Los_Angeles', 'Mexico', 'English, German, Spanish', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(906, 'Bouvet Island (Bouvetoya)', 'XN', '+27', '83.750046', '68.17323', 'America/Tortola', 'Mexico', 'English, Chinese', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(907, 'Turks and Caicos Islands', 'AZ', '+31', '88.605522', '-119.325194', 'Asia/Manila', 'Mexico', 'Chinese, German, French', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(908, 'Andorra', 'LB', '+70', '43.490935', '173.072769', 'America/Manaus', 'Mexico', 'English, Chinese', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(909, 'Iran', 'YQ', '+95', '16.883197', '-74.888731', 'Europe/Bratislava', 'Mexico', 'German, Spanish, Chinese', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(910, 'Honduras', 'PP', '+30', '-57.935684', '-103.549321', 'America/Coyhaique', 'Mexico', 'Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(911, 'Gibraltar', 'DW', '+29', '48.512257', '-96.974687', 'Africa/Maseru', 'Mexico', 'French', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(912, 'United States of America', 'KC', '+68', '76.42457', '-0.58503', 'America/Argentina/Buenos_Aires', 'Mexico', 'Chinese, French', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(913, 'Kuwait', 'VJ', '+7', '42.594509', '21.041679', 'Africa/Windhoek', 'Mexico', 'Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(914, 'Norway', 'WV', '+83', '-19.57941', '48.006578', 'America/Bahia', 'Mexico', 'English, German', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(915, 'Denmark', 'NX', '+75', '-45.764803', '116.933755', 'America/Santarem', 'Mexico', 'Spanish, English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(916, 'Malawi', 'DG', '+76', '1.439009', '-179.524161', 'Pacific/Easter', 'Mexico', 'English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(917, 'Suriname', 'WF', '+4', '75.09218', '-112.567217', 'America/Indiana/Petersburg', 'Mexico', 'French, Chinese, Spanish', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(918, 'Romania', 'IE', '+34', '55.647445', '14.660428', 'Pacific/Chuuk', 'Mexico', 'German, English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(919, 'Mozambique', 'DR', '+63', '-38.929881', '102.527677', 'America/Winnipeg', 'Mexico', 'German, Spanish', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(920, 'Gibraltar', 'FO', '+47', '34.447946', '163.21311', 'Asia/Seoul', 'Mexico', 'Spanish, German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(921, 'Austria', 'TW', '+87', '-1.797494', '-87.736607', 'Asia/Kuching', 'Mexico', 'German, English, Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(922, 'Morocco', 'GV', '+1', '-15.16489', '150.302835', 'America/Fort_Nelson', 'Mexico', 'English, Chinese, Spanish', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(923, 'Saint Barthelemy', 'RR', '+85', '-38.266102', '165.481729', 'America/Tortola', 'Mexico', 'German', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(924, 'Kazakhstan', 'SB', '+95', '-47.765368', '-43.887344', 'Europe/Mariehamn', 'Mexico', 'German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(925, 'Sweden', 'VZ', '+47', '-57.068325', '-67.903145', 'America/La_Paz', 'Mexico', 'French, Chinese, English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(926, 'Sierra Leone', 'GI', '+71', '-69.127543', '-45.018251', 'Asia/Samarkand', 'Mexico', 'French, Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(927, 'Cameroon', 'AA', '+85', '68.598819', '-79.667421', 'Pacific/Kosrae', 'Mexico', 'Chinese, Spanish, English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(928, 'Oman', 'ZC', '+41', '-21.778219', '113.770512', 'America/St_Kitts', 'Mexico', 'Chinese, French, Spanish', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(929, 'Mauritania', 'XD', '+54', '-34.449119', '10.505048', 'America/Anguilla', 'Mexico', 'German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(930, 'Iraq', 'ZF', '+92', '71.59979', '-43.762041', 'Asia/Srednekolymsk', 'Mexico', 'German, French, Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(931, 'Slovenia', 'YF', '+90', '37.933157', '138.705038', 'America/Creston', 'Mexico', 'English, German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(932, 'Papua New Guinea', 'JG', '+69', '26.367871', '-137.606698', 'America/North_Dakota/Beulah', 'Mexico', 'English, Spanish', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(933, 'Yemen', 'PG', '+82', '-81.707421', '98.508073', 'Africa/Juba', 'Mexico', 'English, German', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(934, 'Malta', 'TR', '+68', '-79.811866', '-74.968599', 'Asia/Riyadh', 'Mexico', 'French, English, Chinese', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(935, 'Italy', 'TQ', '+57', '21.969097', '-163.840185', 'America/North_Dakota/New_Salem', 'Mexico', 'Chinese, Spanish', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(936, 'Saint Lucia', 'YY', '+37', '44.218918', '57.305657', 'Asia/Irkutsk', 'Mexico', 'Spanish, Chinese, German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(937, 'Malawi', 'PD', '+40', '-4.615144', '-124.774729', 'Asia/Ashgabat', 'Mexico', 'English, Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(938, 'United States Minor Outlying Islands', 'RZ', '+48', '3.757978', '0.940733', 'America/Danmarkshavn', 'Mexico', 'French, English, Spanish', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(939, 'Reunion', 'KR', '+29', '39.541435', '-84.319215', 'America/El_Salvador', 'Mexico', 'English', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(940, 'Panama', 'ZA', '+18', '-38.036631', '-95.630948', 'America/Puerto_Rico', 'Mexico', 'German, Chinese, Spanish', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(941, 'Saint Martin', 'EV', '+68', '67.536158', '43.74949', 'Africa/Windhoek', 'Mexico', 'French, Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(942, 'Comoros', 'BU', '+90', '87.635683', '53.233258', 'Antarctica/Davis', 'Mexico', 'French', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(943, 'Tanzania', 'AF', '+67', '-1.201856', '63.365659', 'Antarctica/Macquarie', 'Mexico', 'Chinese, English, French', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(944, 'Anguilla', 'QD', '+54', '46.230816', '76.839113', 'America/Dominica', 'Mexico', 'Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(945, 'Tajikistan', 'GO', '+81', '-38.653332', '53.774714', 'Europe/Skopje', 'Mexico', 'Chinese, English, German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(946, 'Madagascar', 'NB', '+6', '-81.805107', '112.913175', 'Africa/Johannesburg', 'Mexico', 'Spanish, Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(947, 'Spain', 'KU', '+89', '9.958757', '85.734593', 'Africa/Porto-Novo', 'Mexico', 'Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37');
INSERT INTO `countries` (`id`, `name`, `code`, `dial_code`, `latitude`, `longitude`, `timezone`, `region`, `languages`, `status`, `created_at`, `updated_at`) VALUES
(948, 'United States Minor Outlying Islands', 'IK', '+56', '-19.179423', '-17.733707', 'Pacific/Norfolk', 'Mexico', 'Spanish, German, French', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(949, 'Cameroon', 'UI', '+26', '-35.762862', '144.714642', 'Europe/Gibraltar', 'Mexico', 'Chinese, French', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(950, 'Tuvalu', 'RE', '+61', '-20.690504', '-87.226472', 'Europe/Vatican', 'Mexico', 'Spanish', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(951, 'Austria', 'EY', '+29', '-28.917029', '-145.188131', 'Pacific/Guam', 'Mexico', 'Spanish, English, Chinese', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(952, 'Kenya', 'TT', '+74', '67.218505', '165.256479', 'America/Blanc-Sablon', 'Mexico', 'Chinese', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(953, 'Brazil', 'AX', '+61', '-49.784659', '-126.153121', 'Pacific/Wallis', 'Mexico', 'German, Spanish, English', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(954, 'United States Minor Outlying Islands', 'ZU', '+85', '0.753447', '85.89', 'Africa/Addis_Ababa', 'Mexico', 'Chinese, French', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(955, 'Argentina', 'BT', '+71', '15.313874', '90.297624', 'Asia/Bishkek', 'Mexico', 'English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(956, 'Panama', 'JK', '+66', '-78.136106', '-130.141198', 'Europe/San_Marino', 'Mexico', 'French, English, Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(957, 'Russian Federation', 'KO', '+23', '65.263565', '109.332182', 'Europe/Athens', 'Mexico', 'Spanish, German, English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(958, 'Samoa', 'ZK', '+66', '3.096077', '83.673336', 'Africa/Asmara', 'Mexico', 'German, English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(959, 'Italy', 'BR', '+98', '-76.873028', '-175.36156', 'America/La_Paz', 'Mexico', 'French, Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(960, 'Niue', 'GG', '+58', '-65.241703', '106.796301', 'Europe/Bucharest', 'Mexico', 'German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(961, 'United States Virgin Islands', 'HF', '+11', '68.401923', '-111.918515', 'Africa/Ndjamena', 'Mexico', 'Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(962, 'Guernsey', 'CT', '+89', '40.802788', '-132.718813', 'Asia/Beirut', 'Mexico', 'English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(963, 'Jamaica', 'PC', '+49', '64.056538', '-79.151855', 'Antarctica/Casey', 'Mexico', 'English', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(964, 'Tunisia', 'ZX', '+49', '19.349727', '149.326567', 'Europe/Zurich', 'Mexico', 'Spanish, Chinese, German', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(965, 'Colombia', 'MC', '+90', '-33.785988', '-57.183522', 'Europe/Bratislava', 'Mexico', 'French, Spanish', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(966, 'Martinique', 'HG', '+52', '68.574209', '154.487439', 'Africa/Asmara', 'Mexico', 'French, English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(967, 'Bahamas', 'AU', '+73', '8.646052', '-78.759533', 'Asia/Vientiane', 'Mexico', 'French, German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(968, 'Bolivia', 'KE', '+4', '39.61744', '-131.368294', 'Asia/Macau', 'Mexico', 'Chinese, German, English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(969, 'Taiwan', 'SD', '+1', '24.352947', '-49.968726', 'Asia/Tokyo', 'Mexico', 'Chinese, German, Spanish', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(970, 'Poland', 'LO', '+11', '42.231948', '3.402139', 'Pacific/Norfolk', 'Mexico', 'Chinese, Spanish, English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(971, 'Kenya', 'YH', '+12', '49.055753', '-148.884851', 'Africa/Bissau', 'Mexico', 'German, Spanish, Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(972, 'Bhutan', 'FU', '+74', '76.942229', '9.399095', 'America/Asuncion', 'Mexico', 'Spanish, Chinese, English', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(973, 'Tajikistan', 'FT', '+12', '-22.805586', '24.864333', 'Atlantic/South_Georgia', 'Mexico', 'French', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(974, 'Kyrgyz Republic', 'WU', '+5', '57.760249', '140.026107', 'Antarctica/Casey', 'Mexico', 'English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(975, 'Uganda', 'TV', '+76', '17.628304', '-17.111294', 'Africa/Freetown', 'Mexico', 'English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(976, 'South Africa', 'AI', '+29', '-42.109606', '-66.678867', 'Asia/Kuwait', 'Mexico', 'German, French', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(977, 'Bangladesh', 'JF', '+68', '63.831696', '-49.355935', 'Pacific/Marquesas', 'Mexico', 'French', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(978, 'Nicaragua', 'HN', '+89', '-29.236383', '-171.915488', 'America/Atikokan', 'Mexico', 'French', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(979, 'Solomon Islands', 'LR', '+97', '2.799861', '105.100245', 'Europe/Prague', 'Mexico', 'Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(980, 'Ireland', 'ZW', '+19', '7.057485', '65.862005', 'Europe/Gibraltar', 'Mexico', 'English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(981, 'Haiti', 'QP', '+27', '55.726703', '31.230838', 'America/El_Salvador', 'Mexico', 'Spanish, French, Chinese', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(982, 'Norfolk Island', 'DO', '+10', '-8.973619', '79.450778', 'Asia/Kuwait', 'Mexico', 'French', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(983, 'Morocco', 'RF', '+38', '18.775125', '-105.318461', 'Asia/Manila', 'Mexico', 'Spanish, English', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(984, 'Belize', 'OA', '+37', '74.455008', '-6.805612', 'America/St_Thomas', 'Mexico', 'French, English', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(985, 'South Georgia and the South Sandwich Islands', 'WT', '+53', '-50.614601', '-172.855267', 'Pacific/Tongatapu', 'Mexico', 'Chinese, Spanish, German', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(986, 'Saint Lucia', 'LU', '+22', '-34.606756', '-106.771269', 'America/Vancouver', 'Mexico', 'German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(987, 'Saint Martin', 'AL', '+85', '-79.310729', '129.183304', 'Asia/Sakhalin', 'Mexico', 'French, English', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(988, 'Jersey', 'AY', '+92', '-16.201386', '31.544952', 'America/Iqaluit', 'Mexico', 'German, English, Spanish', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(989, 'Antarctica (the territory South of 60 deg S)', 'OM', '+11', '-21.67721', '21.402039', 'America/Bogota', 'Mexico', 'Chinese, French', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(990, 'Jordan', 'VD', '+3', '34.725849', '-80.247573', 'Australia/Lord_Howe', 'Mexico', 'German, Spanish, Chinese', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(991, 'Malaysia', 'TE', '+49', '44.402951', '149.507348', 'America/Indiana/Vevay', 'Mexico', 'Chinese, English, German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(992, 'Puerto Rico', 'WD', '+74', '-56.976268', '133.9291', 'Africa/Conakry', 'Mexico', 'English, Spanish', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(993, 'Bulgaria', 'NC', '+19', '83.535333', '-16.691257', 'Australia/Melbourne', 'Mexico', 'German, English', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(994, 'Bermuda', 'KJ', '+49', '33.062441', '33.259242', 'America/Argentina/Cordoba', 'Mexico', 'Spanish, English', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(995, 'United Kingdom', 'CJ', '+37', '-50.530324', '-48.351706', 'America/Port_of_Spain', 'Mexico', 'English, German', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(996, 'Cyprus', 'PI', '+74', '-37.952004', '141.540872', 'Pacific/Tongatapu', 'Mexico', 'English, German', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(997, 'Serbia', 'OZ', '+83', '54.679485', '-83.459949', 'Europe/Monaco', 'Mexico', 'Spanish, German', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(998, 'Guinea', 'EM', '+15', '-39.192623', '161.537862', 'Africa/Tripoli', 'Mexico', 'French, Spanish', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(999, 'Tuvalu', 'FZ', '+46', '22.346366', '147.418801', 'America/Tegucigalpa', 'Mexico', 'Chinese, German, English', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(1000, 'Antarctica (the territory South of 60 deg S)', 'CV', '+58', '-88.047187', '-12.656497', 'Europe/Brussels', 'Mexico', 'Spanish', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(1001, 'Myanmar', 'KZ', '+93', '83.721625', '59.307965', 'America/Argentina/Buenos_Aires', 'Italy', 'French', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1002, 'Western Sahara', 'QI', '+48', '12.584187', '-22.28119', 'Africa/Harare', 'Italy', 'Spanish, Chinese, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1003, 'Costa Rica', 'OQ', '+71', '87.905493', '138.294969', 'Asia/Vientiane', 'Italy', 'Spanish, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1004, 'Lao People\'s Democratic Republic', 'MP', '+50', '41.029854', '-75.59133', 'America/Campo_Grande', 'Italy', 'Spanish, Chinese', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1005, 'Burundi', 'VE', '+89', '61.210346', '112.505472', 'Asia/Dushanbe', 'Italy', 'Chinese, English, Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1006, 'Monaco', 'ZT', '+63', '-28.370213', '24.357579', 'Europe/Minsk', 'Italy', 'German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1007, 'Northern Mariana Islands', 'RL', '+67', '-7.2358', '83.948494', 'Europe/Rome', 'Italy', 'Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1008, 'Libyan Arab Jamahiriya', 'MX', '+45', '50.049871', '-158.255', 'Europe/Vienna', 'Italy', 'Chinese, English, German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1009, 'Romania', 'UY', '+47', '-52.991003', '174.709804', 'America/Chicago', 'Italy', 'French', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1010, 'Saint Vincent and the Grenadines', 'DI', '+6', '-47.861811', '-168.530456', 'Australia/Broken_Hill', 'Italy', 'German, Chinese, Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1011, 'Peru', 'YE', '+98', '-81.657231', '-149.528206', 'Pacific/Majuro', 'Italy', 'German, French, Chinese', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1012, 'Uruguay', 'JB', '+53', '-82.665588', '-96.150801', 'America/St_Vincent', 'Italy', 'Chinese, French, Spanish', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1013, 'Nepal', 'RH', '+8', '8.483202', '-154.924778', 'Africa/Conakry', 'Italy', 'English, Chinese, Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1014, 'Dominican Republic', 'TZ', '+55', '-32.830841', '140.280911', 'Asia/Almaty', 'Italy', 'Spanish', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1015, 'Bhutan', 'VT', '+56', '-9.262751', '-153.951646', 'America/La_Paz', 'Italy', 'English, Spanish, German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1016, 'Singapore', 'FX', '+63', '-23.083339', '-114.995361', 'Asia/Makassar', 'Italy', 'English', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1017, 'Iran', 'OG', '+49', '-53.261322', '-49.14757', 'America/Argentina/Ushuaia', 'Italy', 'English, Chinese', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1018, 'Albania', 'AY', '+47', '-51.201053', '-125.545471', 'Africa/Sao_Tome', 'Italy', 'German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1019, 'Saint Pierre and Miquelon', 'QT', '+78', '-22.96621', '-27.989961', 'America/New_York', 'Italy', 'English', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1020, 'Panama', 'PG', '+44', '49.629962', '101.121112', 'Africa/Ndjamena', 'Italy', 'Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1021, 'Lebanon', 'HC', '+16', '31.436984', '-168.945754', 'Europe/Skopje', 'Italy', 'French, English, Spanish', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1022, 'Tonga', 'IJ', '+70', '25.638842', '-36.250113', 'Africa/Maseru', 'Italy', 'German, English, Spanish', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1023, 'Samoa', 'MQ', '+18', '-42.318004', '-115.56381', 'America/Denver', 'Italy', 'Spanish, English, German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1024, 'Yemen', 'RP', '+15', '22.431247', '115.712128', 'Pacific/Wake', 'Italy', 'French, Spanish, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1025, 'Latvia', 'IS', '+45', '-21.322134', '137.316618', 'Asia/Urumqi', 'Italy', 'German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1026, 'Palau', 'KA', '+12', '26.153468', '-84.921675', 'America/Swift_Current', 'Italy', 'French, Spanish, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1027, 'El Salvador', 'FJ', '+38', '-25.269904', '-170.294975', 'Asia/Tomsk', 'Italy', 'German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1028, 'Kuwait', 'WD', '+23', '-82.917989', '-9.721768', 'Europe/Skopje', 'Italy', 'Chinese, English, Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1029, 'Myanmar', 'XM', '+39', '87.588827', '26.582905', 'Africa/Banjul', 'Italy', 'Chinese', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1030, 'Madagascar', 'BU', '+6', '-21.683037', '4.17279', 'Europe/Vilnius', 'Italy', 'Chinese, French, Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1031, 'Malawi', 'NX', '+65', '-60.506179', '-132.635704', 'America/Santiago', 'Italy', 'Chinese, French, Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1032, 'Puerto Rico', 'VW', '+40', '39.905662', '-58.158499', 'America/Atikokan', 'Italy', 'English', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1033, 'Northern Mariana Islands', 'ZG', '+30', '46.250864', '-42.375529', 'Asia/Srednekolymsk', 'Italy', 'Chinese', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1034, 'Norway', 'BY', '+73', '67.265514', '89.591166', 'Pacific/Midway', 'Italy', 'French', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1035, 'Gibraltar', 'ON', '+94', '45.743136', '-175.634118', 'America/Indiana/Indianapolis', 'Italy', 'Chinese, Spanish, French', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1036, 'Afghanistan', 'EY', '+35', '20.111892', '46.181727', 'Indian/Comoro', 'Italy', 'Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1037, 'Peru', 'UX', '+53', '18.964833', '-111.320894', 'Antarctica/Macquarie', 'Italy', 'Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1038, 'Turkmenistan', 'QQ', '+3', '-85.21109', '-104.236492', 'Atlantic/Azores', 'Italy', 'Spanish, French', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1039, 'Guinea-Bissau', 'VC', '+2', '70.084596', '169.147799', 'Europe/Athens', 'Italy', 'French, English', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1040, 'Peru', 'ZP', '+94', '-20.203746', '-54.773128', 'Asia/Yangon', 'Italy', 'Chinese, German, French', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1041, 'Spain', 'TL', '+35', '29.375785', '-75.200532', 'Europe/Skopje', 'Italy', 'Chinese', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1042, 'Australia', 'UC', '+0', '5.993733', '-95.945395', 'America/Montevideo', 'Italy', 'Chinese, English, French', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1043, 'Australia', 'FS', '+82', '57.711093', '-10.795213', 'Europe/Berlin', 'Italy', 'Chinese, English, French', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1044, 'Canada', 'JD', '+42', '72.565984', '39.379877', 'America/Resolute', 'Italy', 'Chinese', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1045, 'Kazakhstan', 'OK', '+85', '-4.246437', '-71.848105', 'America/Ojinaga', 'Italy', 'German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1046, 'Belgium', 'KS', '+71', '-48.896161', '8.327736', 'America/Fort_Nelson', 'Italy', 'English, German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1047, 'Saint Vincent and the Grenadines', 'HF', '+85', '64.340931', '116.708548', 'Europe/Sarajevo', 'Italy', 'Chinese', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1048, 'Brazil', 'DC', '+18', '75.341413', '108.018124', 'America/Martinique', 'Italy', 'Chinese, Spanish, German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1049, 'Jordan', 'UV', '+8', '-84.903076', '166.194622', 'Asia/Bishkek', 'Italy', 'Spanish, English', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1050, 'Ghana', 'EU', '+54', '-56.345052', '163.743904', 'America/Merida', 'Italy', 'Spanish, French', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1051, 'Cape Verde', 'JJ', '+26', '-79.742481', '100.411364', 'Pacific/Tahiti', 'Italy', 'German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1052, 'Jamaica', 'IE', '+26', '-54.069924', '23.937587', 'Asia/Riyadh', 'Italy', 'English, Chinese', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1053, 'Montserrat', 'IZ', '+39', '52.48535', '-75.406172', 'America/Boa_Vista', 'Italy', 'Spanish, English, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1054, 'Monaco', 'GI', '+77', '65.874626', '-4.508704', 'Asia/Aden', 'Italy', 'Chinese, French', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1055, 'Samoa', 'SL', '+96', '-70.039683', '13.371341', 'Europe/Saratov', 'Italy', 'Spanish, German, English', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1056, 'Korea', 'RG', '+87', '-17.339962', '71.072315', 'Pacific/Noumea', 'Italy', 'German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1057, 'Tunisia', 'GQ', '+4', '7.598474', '-170.91473', 'America/Chihuahua', 'Italy', 'German, French', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1058, 'Lao People\'s Democratic Republic', 'AU', '+20', '85.861186', '-139.757558', 'Europe/Lisbon', 'Italy', 'Chinese, French', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1059, 'Congo', 'HR', '+69', '-83.889632', '169.657264', 'Pacific/Marquesas', 'Italy', 'Spanish, German, French', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1060, 'Cambodia', 'YA', '+44', '-51.76202', '-78.298601', 'America/Argentina/Jujuy', 'Italy', 'Chinese', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1061, 'Guyana', 'RW', '+15', '0.995631', '3.204682', 'America/La_Paz', 'Italy', 'French', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1062, 'Swaziland', 'RD', '+44', '1.663104', '157.361368', 'America/Argentina/La_Rioja', 'Italy', 'Chinese, French, German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1063, 'New Zealand', 'IA', '+49', '-76.194938', '-176.39643', 'Asia/Beirut', 'Italy', 'English, German, Chinese', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1064, 'Uzbekistan', 'WB', '+60', '66.123311', '-168.469064', 'Africa/Kampala', 'Italy', 'Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1065, 'Pitcairn Islands', 'WT', '+6', '-13.715508', '-75.458809', 'Africa/Tripoli', 'Italy', 'Chinese', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1066, 'Tuvalu', 'TV', '+60', '-36.522027', '-50.068182', 'Europe/Stockholm', 'Italy', 'Spanish, French', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1067, 'Rwanda', 'WM', '+90', '-42.071365', '122.100169', 'America/Punta_Arenas', 'Italy', 'French, Spanish, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1068, 'Dominican Republic', 'YH', '+61', '10.481184', '139.402253', 'America/Halifax', 'Italy', 'Chinese, English, Spanish', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1069, 'Lao People\'s Democratic Republic', 'MA', '+84', '-46.907621', '-77.040773', 'America/Cayenne', 'Italy', 'Chinese', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1070, 'Montserrat', 'BP', '+56', '89.011793', '-90.366905', 'Indian/Kerguelen', 'Italy', 'Spanish', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1071, 'Northern Mariana Islands', 'XP', '+26', '-87.628683', '-28.1797', 'America/Atikokan', 'Italy', 'Spanish, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1072, 'Greenland', 'EX', '+57', '-48.404217', '30.09513', 'America/Santiago', 'Italy', 'Chinese, French', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1073, 'Liberia', 'DW', '+43', '-29.285191', '-163.556078', 'Europe/Rome', 'Italy', 'Chinese, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1074, 'El Salvador', 'CE', '+42', '-85.48053', '-19.099193', 'America/North_Dakota/Beulah', 'Italy', 'Chinese', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1075, 'Saint Barthelemy', 'KO', '+67', '37.041018', '6.745732', 'Asia/Ulaanbaatar', 'Italy', 'German, Spanish', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1076, 'Zimbabwe', 'YT', '+90', '-27.033799', '-167.16514', 'Asia/Tomsk', 'Italy', 'English, Chinese', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1077, 'Cambodia', 'TS', '+34', '-11.50326', '-164.92646', 'Asia/Dushanbe', 'Italy', 'Chinese, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1078, 'Namibia', 'VQ', '+14', '1.22833', '-17.644141', 'Europe/Zurich', 'Italy', 'Chinese, French, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1079, 'Sweden', 'TE', '+7', '-36.891795', '-93.896861', 'Asia/Hebron', 'Italy', 'Spanish, German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1080, 'Isle of Man', 'YQ', '+98', '13.502749', '99.796794', 'Asia/Qostanay', 'Italy', 'Chinese, Spanish, English', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1081, 'Guadeloupe', 'RE', '+65', '-38.420148', '-174.298478', 'Asia/Dubai', 'Italy', 'French', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1082, 'China', 'FA', '+60', '36.597745', '-134.151163', 'America/Mazatlan', 'Italy', 'German, English, Spanish', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1083, 'Tanzania', 'UO', '+67', '-24.852607', '-99.659873', 'Europe/Monaco', 'Italy', 'French, German, English', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1084, 'Qatar', 'KX', '+48', '-35.768389', '-170.928207', 'America/Montserrat', 'Italy', 'French, Chinese', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1085, 'South Africa', 'ZA', '+4', '-46.680023', '-143.072239', 'Pacific/Easter', 'Italy', 'Chinese', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1086, 'Gabon', 'BL', '+89', '-34.813214', '-113.54843', 'Indian/Mauritius', 'Italy', 'German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1087, 'French Polynesia', 'ZI', '+67', '9.453594', '-26.081192', 'Pacific/Rarotonga', 'Italy', 'English, Chinese', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1088, 'Mexico', 'CK', '+10', '19.712903', '-93.079427', 'Asia/Ust-Nera', 'Italy', 'German, English', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1089, 'Honduras', 'SW', '+61', '74.751655', '-161.238557', 'Africa/El_Aaiun', 'Italy', 'English', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1090, 'Luxembourg', 'LR', '+2', '-72.511253', '52.8495', 'America/Argentina/Cordoba', 'Italy', 'Chinese, French', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1091, 'Monaco', 'CP', '+9', '-58.932953', '18.569159', 'Pacific/Guadalcanal', 'Italy', 'English, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1092, 'Romania', 'JY', '+28', '-77.639663', '-99.520182', 'Antarctica/Rothera', 'Italy', 'Spanish', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1093, 'South Africa', 'IP', '+37', '-6.076714', '-76.802043', 'Pacific/Chuuk', 'Italy', 'English, French, Spanish', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1094, 'Egypt', 'IN', '+7', '16.386196', '-82.494165', 'America/Bahia', 'Italy', 'German', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1095, 'Bahamas', 'NK', '+14', '53.501704', '-7.828957', 'Europe/Guernsey', 'Italy', 'Chinese', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1096, 'Antigua and Barbuda', 'CW', '+74', '44.448849', '5.389381', 'Asia/Urumqi', 'Italy', 'Spanish', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1097, 'Turkey', 'SZ', '+42', '-71.438192', '100.815337', 'Asia/Kamchatka', 'Italy', 'German, French, English', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1098, 'Uganda', 'BJ', '+70', '31.264015', '-61.247609', 'Asia/Qatar', 'Italy', 'English, German', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1099, 'Cote d\'Ivoire', 'OZ', '+83', '-28.402715', '-66.417719', 'Indian/Mahe', 'Italy', 'German, English, Chinese', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1100, 'Bhutan', 'XX', '+38', '-8.955191', '-54.087001', 'Asia/Samarkand', 'Italy', 'Spanish, French', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1101, 'Svalbard & Jan Mayen Islands', 'XG', '+0', '-5.015803', '-101.250682', 'Africa/Addis_Ababa', 'Spain', 'Spanish, French, Chinese', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1102, 'Austria', 'QD', '+40', '16.450927', '-154.996119', 'Australia/Perth', 'Spain', 'Spanish', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1103, 'Libyan Arab Jamahiriya', 'OL', '+71', '-60.585004', '153.110837', 'Africa/Nairobi', 'Spain', 'German, Spanish, English', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1104, 'Colombia', 'YL', '+51', '-16.028815', '-120.739306', 'Asia/Khandyga', 'Spain', 'Chinese, English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1105, 'Hungary', 'XQ', '+30', '-17.099478', '-2.780915', 'Asia/Ashgabat', 'Spain', 'German', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1106, 'Slovakia (Slovak Republic)', 'VC', '+27', '51.043855', '29.909665', 'Asia/Tomsk', 'Spain', 'Chinese', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1107, 'Lithuania', 'ZU', '+14', '4.50031', '28.861683', 'Europe/Gibraltar', 'Spain', 'Chinese', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1108, 'Uganda', 'UL', '+95', '74.134438', '145.176676', 'America/Guadeloupe', 'Spain', 'French, English', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1109, 'Sri Lanka', 'EO', '+84', '70.096672', '161.262681', 'Europe/Paris', 'Spain', 'Chinese, English, Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1110, 'Latvia', 'IG', '+49', '9.486779', '-3.909442', 'Antarctica/Davis', 'Spain', 'Chinese', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1111, 'Faroe Islands', 'HA', '+25', '-59.403307', '-29.683714', 'America/Guatemala', 'Spain', 'English, Chinese', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1112, 'Argentina', 'CZ', '+14', '19.582616', '-37.873542', 'America/Marigot', 'Spain', 'English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1113, 'Switzerland', 'FG', '+39', '-26.126554', '-34.51872', 'Europe/Riga', 'Spain', 'French, Chinese, German', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1114, 'Trinidad and Tobago', 'GM', '+22', '29.318434', '-134.563263', 'America/Matamoros', 'Spain', 'Spanish, English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1115, 'Sweden', 'TK', '+59', '-39.255106', '-31.947995', 'Australia/Lindeman', 'Spain', 'Spanish, French', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1116, 'Qatar', 'NW', '+1', '85.816021', '10.447929', 'Asia/Pontianak', 'Spain', 'German, English', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1117, 'Pitcairn Islands', 'DJ', '+66', '88.197474', '81.145391', 'Asia/Yekaterinburg', 'Spain', 'Chinese, French, Spanish', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1118, 'Algeria', 'ZO', '+4', '-65.599088', '5.261729', 'Africa/Ndjamena', 'Spain', 'Spanish, Chinese, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1119, 'American Samoa', 'NB', '+75', '19.090084', '-111.201232', 'Asia/Kuwait', 'Spain', 'Spanish, Chinese', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1120, 'Pitcairn Islands', 'LT', '+19', '89.015395', '144.924808', 'Asia/Macau', 'Spain', 'French, German', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1121, 'Myanmar', 'HS', '+63', '51.61511', '-125.332604', 'America/Tijuana', 'Spain', 'French, Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1122, 'Sweden', 'GD', '+34', '-53.426047', '-26.633834', 'America/Managua', 'Spain', 'Spanish, Chinese', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1123, 'Dominica', 'AH', '+92', '-78.886945', '-122.727517', 'Indian/Kerguelen', 'Spain', 'French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1124, 'Serbia', 'AQ', '+56', '-81.856671', '-140.210206', 'Asia/Kuching', 'Spain', 'German', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1125, 'Lesotho', 'RW', '+94', '47.939899', '37.909508', 'Europe/Minsk', 'Spain', 'German, Chinese', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1126, 'Korea', 'VQ', '+69', '40.750792', '57.490507', 'Antarctica/McMurdo', 'Spain', 'Chinese, English, German', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1127, 'Maldives', 'KN', '+41', '29.970365', '-150.525939', 'Europe/Stockholm', 'Spain', 'Chinese, English, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1128, 'Latvia', 'OU', '+61', '-63.355495', '-83.070577', 'Africa/Nouakchott', 'Spain', 'French, Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1129, 'Nauru', 'KH', '+50', '-19.64122', '-78.825074', 'America/Cuiaba', 'Spain', 'Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1130, 'American Samoa', 'AL', '+7', '72.241007', '-46.200179', 'America/Argentina/Buenos_Aires', 'Spain', 'Spanish, English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1131, 'Latvia', 'AU', '+9', '9.534129', '-99.059086', 'Africa/Johannesburg', 'Spain', 'Chinese, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1132, 'Brunei Darussalam', 'CC', '+60', '-6.435905', '-128.539291', 'Europe/Tallinn', 'Spain', 'German', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1133, 'Turks and Caicos Islands', 'QI', '+73', '-3.919525', '-78.581051', 'Asia/Oral', 'Spain', 'Spanish', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1134, 'Zambia', 'NF', '+36', '20.981019', '-141.604364', 'America/Scoresbysund', 'Spain', 'Chinese', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1135, 'Ethiopia', 'AI', '+4', '67.185834', '-134.005802', 'Pacific/Midway', 'Spain', 'English, French, German', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1136, 'Philippines', 'GG', '+33', '-16.063121', '-102.760806', 'America/Bahia_Banderas', 'Spain', 'German, Chinese', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1137, 'Lebanon', 'GQ', '+59', '-36.952707', '160.123599', 'Asia/Tomsk', 'Spain', 'Chinese, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1138, 'Myanmar', 'UK', '+13', '53.595112', '-125.642456', 'Europe/Amsterdam', 'Spain', 'French', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1139, 'Senegal', 'UJ', '+34', '-68.362362', '-99.026114', 'Antarctica/Troll', 'Spain', 'Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1140, 'Kyrgyz Republic', 'VZ', '+77', '17.731605', '-165.869802', 'Australia/Hobart', 'Spain', 'Spanish, English', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1141, 'Belarus', 'WF', '+23', '-26.753174', '166.917334', 'Asia/Tehran', 'Spain', 'French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1142, 'Malta', 'UN', '+61', '88.887603', '175.628807', 'Asia/Dili', 'Spain', 'German, French, Chinese', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1143, 'Bangladesh', 'TA', '+13', '-18.545711', '-128.928266', 'America/Eirunepe', 'Spain', 'German, French, Spanish', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1144, 'Algeria', 'QR', '+6', '-26.009765', '-138.334782', 'America/Curacao', 'Spain', 'Chinese, English, German', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1145, 'Marshall Islands', 'CP', '+90', '81.885503', '-52.762818', 'Pacific/Niue', 'Spain', 'English, Chinese', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1146, 'British Virgin Islands', 'EM', '+38', '36.872987', '93.895868', 'America/North_Dakota/Center', 'Spain', 'Spanish', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1147, 'El Salvador', 'SZ', '+98', '-5.946908', '115.809281', 'America/Indiana/Vincennes', 'Spain', 'Spanish, French', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1148, 'United States of America', 'GN', '+18', '-47.444981', '-3.113562', 'America/Nome', 'Spain', 'English, German, Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1149, 'Argentina', 'VT', '+5', '11.905612', '-90.991864', 'Europe/Kyiv', 'Spain', 'French, German', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1150, 'United Kingdom', 'ZA', '+69', '45.18908', '99.336226', 'America/St_Kitts', 'Spain', 'English, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1151, 'Bangladesh', 'QJ', '+82', '-74.693678', '-120.063736', 'Pacific/Majuro', 'Spain', 'Spanish, Chinese, German', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1152, 'Grenada', 'IA', '+94', '29.264517', '-84.213958', 'Europe/Sofia', 'Spain', 'German, English, Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1153, 'Zambia', 'YZ', '+19', '40.947989', '174.050733', 'America/St_Johns', 'Spain', 'Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1154, 'Germany', 'FC', '+69', '-10.88985', '-132.065138', 'America/Bogota', 'Spain', 'Spanish, German, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1155, 'Niger', 'JY', '+32', '48.110619', '-73.106222', 'Asia/Bishkek', 'Spain', 'Chinese, English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1156, 'Montserrat', 'DL', '+36', '-69.583979', '-168.694074', 'Africa/Windhoek', 'Spain', 'Chinese', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1157, 'Latvia', 'WH', '+36', '1.081333', '124.127766', 'America/Santarem', 'Spain', 'English, Chinese', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1158, 'Guyana', 'IY', '+75', '8.667032', '7.068094', 'Asia/Ashgabat', 'Spain', 'Spanish', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1159, 'Germany', 'YS', '+58', '17.367165', '29.594012', 'America/Thule', 'Spain', 'English', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1160, 'Albania', 'QM', '+59', '-9.247062', '46.034927', 'Pacific/Midway', 'Spain', 'Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1161, 'Wallis and Futuna', 'ZZ', '+31', '43.779231', '-106.850938', 'Africa/Porto-Novo', 'Spain', 'German, Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1162, 'Afghanistan', 'CX', '+0', '-21.055431', '-85.116025', 'Pacific/Marquesas', 'Spain', 'English, German, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1163, 'Cote d\'Ivoire', 'QT', '+22', '-51.612909', '-25.083377', 'Africa/Addis_Ababa', 'Spain', 'Spanish, Chinese, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1164, 'Liberia', 'SI', '+26', '37.394936', '-153.369114', 'America/Cancun', 'Spain', 'Spanish, German, English', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1165, 'Vietnam', 'HI', '+44', '50.332015', '-118.445865', 'Asia/Kolkata', 'Spain', 'Chinese, Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1166, 'Botswana', 'ZP', '+24', '-29.328251', '-128.439697', 'America/Guayaquil', 'Spain', 'German', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1167, 'San Marino', 'YU', '+27', '35.882688', '33.356847', 'America/Nassau', 'Spain', 'French, English, German', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1168, 'Saudi Arabia', 'BE', '+80', '30.807302', '-96.797333', 'Africa/Johannesburg', 'Spain', 'English, French, Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1169, 'Suriname', 'NJ', '+16', '25.310834', '-177.019718', 'America/Winnipeg', 'Spain', 'English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1170, 'Senegal', 'FA', '+37', '74.308345', '31.776763', 'Europe/Budapest', 'Spain', 'French, Chinese', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1171, 'Isle of Man', 'EU', '+48', '86.124686', '79.672792', 'Indian/Mayotte', 'Spain', 'French', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1172, 'Korea', 'OW', '+86', '-38.395745', '-37.485301', 'Africa/Ouagadougou', 'Spain', 'English, German', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1173, 'Algeria', 'QZ', '+14', '26.327199', '158.717979', 'America/Argentina/Mendoza', 'Spain', 'Spanish, Chinese, German', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1174, 'Nigeria', 'IK', '+54', '-10.939178', '-0.495749', 'Europe/Volgograd', 'Spain', 'Chinese', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1175, 'Rwanda', 'AD', '+66', '-37.009787', '-77.265228', 'America/Nuuk', 'Spain', 'German, French, English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1176, 'Lesotho', 'IO', '+62', '83.306064', '125.693846', 'Europe/Samara', 'Spain', 'English, French, German', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1177, 'Jamaica', 'EV', '+3', '40.723509', '-151.338326', 'Atlantic/Reykjavik', 'Spain', 'English, Chinese, French', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1178, 'South Georgia and the South Sandwich Islands', 'OI', '+45', '31.232295', '97.875947', 'Africa/Conakry', 'Spain', 'German, Chinese, English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1179, 'Libyan Arab Jamahiriya', 'PL', '+3', '-35.817385', '-116.493836', 'Africa/Bissau', 'Spain', 'English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1180, 'Cayman Islands', 'EC', '+80', '-41.365183', '-148.705647', 'Africa/Tunis', 'Spain', 'English', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1181, 'Bahamas', 'WN', '+16', '-56.872203', '78.378869', 'America/Kralendijk', 'Spain', 'French, English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1182, 'Seychelles', 'NV', '+38', '-68.906196', '98.944105', 'Indian/Mauritius', 'Spain', 'German, English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1183, 'Martinique', 'SX', '+89', '-20.709495', '106.614697', 'Europe/Minsk', 'Spain', 'French, English, Chinese', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1184, 'Benin', 'RV', '+43', '-12.472702', '-72.102642', 'Africa/Mbabane', 'Spain', 'English, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1185, 'Kazakhstan', 'DS', '+9', '49.193467', '157.111093', 'Asia/Baghdad', 'Spain', 'German, English, Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1186, 'Macedonia', 'KQ', '+49', '34.330323', '136.380089', 'Asia/Tbilisi', 'Spain', 'Spanish, English, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1187, 'Nigeria', 'KR', '+22', '-58.758245', '-55.874852', 'America/Manaus', 'Spain', 'English', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1188, 'Slovenia', 'HY', '+99', '-56.22302', '-8.611078', 'Europe/Minsk', 'Spain', 'German, French, Chinese', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1189, 'Isle of Man', 'JL', '+12', '89.324963', '-86.723523', 'America/Punta_Arenas', 'Spain', 'German, Chinese, French', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1190, 'Vietnam', 'UF', '+33', '68.850954', '-12.221605', 'Pacific/Guadalcanal', 'Spain', 'French, Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1191, 'Marshall Islands', 'QA', '+56', '65.241837', '52.782057', 'America/Grenada', 'Spain', 'Chinese, English', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1192, 'French Polynesia', 'YR', '+53', '57.798651', '-60.737196', 'Africa/Cairo', 'Spain', 'English, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1193, 'Turkey', 'PY', '+96', '29.411937', '136.591626', 'Pacific/Tarawa', 'Spain', 'Spanish', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1194, 'Zambia', 'YK', '+86', '40.964718', '83.584194', 'Asia/Magadan', 'Spain', 'German, English, Spanish', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1195, 'Paraguay', 'WD', '+0', '32.200089', '153.041557', 'Pacific/Saipan', 'Spain', 'English, Chinese, French', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1196, 'Lithuania', 'QW', '+10', '60.328659', '-66.368857', 'Asia/Tashkent', 'Spain', 'Spanish, German', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1197, 'Afghanistan', 'MO', '+79', '-78.722752', '54.916418', 'Asia/Hebron', 'Spain', 'English, Spanish, French', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1198, 'Liechtenstein', 'YP', '+87', '-0.16025', '-114.271957', 'America/Argentina/Rio_Gallegos', 'Spain', 'Chinese, Spanish, French', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1199, 'Georgia', 'UR', '+65', '23.446704', '61.486063', 'America/Regina', 'Spain', 'Spanish, German', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1200, 'Qatar', 'AF', '+96', '-4.680036', '-164.466738', 'Asia/Colombo', 'Spain', 'Spanish', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1201, 'Sudan', 'YN', '+95', '-77.320545', '-0.823497', 'Pacific/Kiritimati', 'USA', 'German', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1202, 'Belgium', 'TG', '+87', '44.728032', '-15.259779', 'Asia/Srednekolymsk', 'USA', 'Chinese, English, French', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1203, 'Israel', 'LV', '+22', '59.397444', '18.433103', 'Asia/Famagusta', 'USA', 'English, German', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1204, 'Andorra', 'WR', '+1', '-26.215899', '-118.962937', 'Asia/Khandyga', 'USA', 'French, Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1205, 'Cook Islands', 'VQ', '+96', '-8.935852', '-111.872734', 'Asia/Brunei', 'USA', 'Spanish, Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1206, 'Costa Rica', 'XL', '+63', '-75.632986', '-132.471099', 'Africa/Accra', 'USA', 'French', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1207, 'Latvia', 'SQ', '+32', '-64.323548', '152.517878', 'Pacific/Norfolk', 'USA', 'Chinese', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1208, 'Netherlands', 'NY', '+77', '-49.502685', '84.067831', 'Africa/Sao_Tome', 'USA', 'French, German', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1209, 'France', 'GX', '+85', '-25.432598', '-97.906926', 'America/Havana', 'USA', 'German, French, English', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1210, 'Colombia', 'CQ', '+13', '-9.311222', '128.063544', 'Europe/Dublin', 'USA', 'German, French, English', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1211, 'Yemen', 'QV', '+88', '-18.808174', '-78.398823', 'Europe/Budapest', 'USA', 'Chinese', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1212, 'Ireland', 'LG', '+95', '24.884656', '-110.844036', 'Africa/Niamey', 'USA', 'Chinese, French', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1213, 'Ireland', 'IO', '+42', '-49.297501', '-89.089141', 'America/Hermosillo', 'USA', 'German, English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1214, 'Syrian Arab Republic', 'WF', '+72', '-30.959706', '-2.649509', 'Europe/Jersey', 'USA', 'Spanish, Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1215, 'Thailand', 'PP', '+73', '-5.536046', '-59.222479', 'Pacific/Norfolk', 'USA', 'English, Spanish', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1216, 'Greece', 'OC', '+24', '29.331398', '173.1432', 'Africa/Bamako', 'USA', 'French, Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1217, 'Saudi Arabia', 'HE', '+19', '59.618404', '-146.530149', 'Asia/Ust-Nera', 'USA', 'Chinese, Spanish, French', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1218, 'Samoa', 'ZP', '+45', '42.828854', '-33.36848', 'Asia/Magadan', 'USA', 'English', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1219, 'Guadeloupe', 'ZX', '+42', '-26.437653', '128.849881', 'Pacific/Auckland', 'USA', 'English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1220, 'Saint Pierre and Miquelon', 'AI', '+39', '44.955954', '-48.786159', 'America/Cancun', 'USA', 'French', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1221, 'Martinique', 'TH', '+86', '-16.95893', '137.270847', 'America/Santo_Domingo', 'USA', 'English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1222, 'Guinea', 'LT', '+73', '54.136915', '-2.863564', 'Europe/Vilnius', 'USA', 'Spanish, English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1223, 'Turkey', 'WA', '+94', '-41.678585', '96.867165', 'Asia/Tokyo', 'USA', 'English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1224, 'United States Virgin Islands', 'KM', '+90', '-25.398904', '-25.810972', 'Europe/Minsk', 'USA', 'French, German', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1225, 'United States Minor Outlying Islands', 'BC', '+88', '28.127872', '93.614621', 'Asia/Shanghai', 'USA', 'English, German', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1226, 'Lithuania', 'XN', '+24', '47.86394', '-153.522421', 'Africa/Lagos', 'USA', 'Spanish, German', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1227, 'Tuvalu', 'EW', '+78', '19.187268', '-72.186003', 'Asia/Tbilisi', 'USA', 'Spanish, German', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1228, 'San Marino', 'WO', '+89', '43.738235', '95.633514', 'Asia/Beirut', 'USA', 'German, Chinese, Spanish', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1229, 'Albania', 'UW', '+6', '-48.915889', '-80.524669', 'Asia/Jerusalem', 'USA', 'French, English', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1230, 'Cyprus', 'DK', '+81', '8.617521', '-77.181786', 'America/Ciudad_Juarez', 'USA', 'English, German, French', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1231, 'Puerto Rico', 'JO', '+98', '88.765694', '123.631563', 'America/Chihuahua', 'USA', 'French', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1232, 'Reunion', 'KE', '+50', '64.810992', '16.896828', 'America/Indiana/Knox', 'USA', 'Spanish, German', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1233, 'Palestinian Territories', 'UG', '+16', '19.466605', '76.100512', 'America/Nuuk', 'USA', 'French, Spanish, Chinese', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1234, 'Bolivia', 'CA', '+92', '-47.424938', '134.674551', 'America/Nome', 'USA', 'French', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1235, 'Bahamas', 'ZH', '+18', '-52.914921', '14.86077', 'Africa/Cairo', 'USA', 'Spanish, Chinese, French', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1236, 'Cameroon', 'XS', '+40', '23.983708', '-34.255419', 'Asia/Dili', 'USA', 'French, Spanish, Chinese', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1237, 'Fiji', 'BX', '+16', '-39.594282', '-8.325429', 'America/Swift_Current', 'USA', 'Spanish, French, Chinese', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1238, 'Andorra', 'AQ', '+45', '72.592119', '-114.379011', 'America/Indiana/Tell_City', 'USA', 'French, Chinese', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1239, 'Central African Republic', 'CR', '+55', '-87.767483', '137.887842', 'America/Montserrat', 'USA', 'Spanish, English, German', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1240, 'Puerto Rico', 'PG', '+48', '17.461801', '43.962514', 'Indian/Reunion', 'USA', 'Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1241, 'Mali', 'CH', '+74', '-79.23297', '-136.24063', 'Pacific/Pago_Pago', 'USA', 'Chinese, German', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1242, 'Brazil', 'RM', '+12', '-9.8608', '-3.942599', 'America/Puerto_Rico', 'USA', 'Chinese', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1243, 'Austria', 'VT', '+69', '79.601952', '158.458976', 'Pacific/Pohnpei', 'USA', 'Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1244, 'Afghanistan', 'JN', '+94', '-82.352111', '-153.935782', 'America/Guatemala', 'USA', 'Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1245, 'Qatar', 'CX', '+81', '14.972994', '7.121178', 'America/Sao_Paulo', 'USA', 'Spanish, French, English', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1246, 'El Salvador', 'ZN', '+63', '79.708062', '-100.487295', 'America/Sao_Paulo', 'USA', 'Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1247, 'Guernsey', 'SU', '+10', '-58.990395', '-136.654651', 'Europe/Prague', 'USA', 'French', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1248, 'New Zealand', 'EY', '+40', '68.115348', '-129.506186', 'Pacific/Auckland', 'USA', 'French, German, English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1249, 'Lesotho', 'UO', '+72', '15.931021', '-49.665593', 'Indian/Chagos', 'USA', 'French', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1250, 'Chad', 'QP', '+29', '-47.914961', '-165.295799', 'Asia/Hebron', 'USA', 'Chinese, Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1251, 'Palau', 'RU', '+48', '33.971429', '-22.977198', 'Pacific/Chatham', 'USA', 'French', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1252, 'Morocco', 'DF', '+65', '12.440185', '165.082951', 'America/Grenada', 'USA', 'Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1253, 'Kazakhstan', 'AU', '+37', '-68.265659', '-140.34364', 'America/Nassau', 'USA', 'Spanish, German', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1254, 'Tunisia', 'NB', '+23', '-11.456344', '23.282546', 'Asia/Khandyga', 'USA', 'Spanish, English', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1255, 'Central African Republic', 'OG', '+74', '-25.872233', '98.651361', 'Asia/Omsk', 'USA', 'German, English, French', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1256, 'Iceland', 'HT', '+72', '-10.598397', '82.41577', 'America/Port-au-Prince', 'USA', 'English, Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1257, 'Turkey', 'NK', '+47', '-54.759756', '-24.606428', 'America/Sao_Paulo', 'USA', 'English, German', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1258, 'Puerto Rico', 'BZ', '+6', '-75.371096', '175.10862', 'Asia/Hovd', 'USA', 'Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1259, 'Norfolk Island', 'SX', '+11', '86.0291', '120.981993', 'Africa/Luanda', 'USA', 'English', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1260, 'Egypt', 'QY', '+13', '-37.468283', '-108.183585', 'Europe/Stockholm', 'USA', 'Spanish, English, Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1261, 'Guernsey', 'TM', '+54', '6.539526', '94.557833', 'America/Glace_Bay', 'USA', 'Chinese, French, Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1262, 'Chile', 'TZ', '+2', '74.467261', '-0.940927', 'Antarctica/Syowa', 'USA', 'English, Chinese, Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1263, 'Yemen', 'DL', '+21', '48.942819', '3.01969', 'America/Costa_Rica', 'USA', 'French, German, Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1264, 'United States of America', 'OB', '+48', '-73.086631', '-0.910829', 'Asia/Tomsk', 'USA', 'Spanish, German, English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1265, 'Chile', 'MI', '+74', '34.747736', '110.092367', 'America/Santo_Domingo', 'USA', 'Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59');
INSERT INTO `countries` (`id`, `name`, `code`, `dial_code`, `latitude`, `longitude`, `timezone`, `region`, `languages`, `status`, `created_at`, `updated_at`) VALUES
(1266, 'Armenia', 'UU', '+39', '88.460085', '-119.338024', 'America/New_York', 'USA', 'English, Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1267, 'Bouvet Island (Bouvetoya)', 'TA', '+48', '43.121034', '-77.795908', 'Europe/Ulyanovsk', 'USA', 'German, Chinese, French', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1268, 'Uzbekistan', 'XJ', '+73', '16.376577', '-75.566853', 'America/St_Vincent', 'USA', 'French, English, Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1269, 'Egypt', 'YB', '+30', '-46.089745', '-40.779496', 'Europe/Bratislava', 'USA', 'Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1270, 'United States Minor Outlying Islands', 'JQ', '+53', '-0.056176', '-157.525687', 'Africa/Mogadishu', 'USA', 'Chinese, German', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1271, 'France', 'SO', '+3', '-77.803682', '53.605168', 'Africa/Gaborone', 'USA', 'German', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1272, 'Chile', 'IM', '+74', '18.354356', '66.719202', 'America/Vancouver', 'USA', 'Chinese', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1273, 'Switzerland', 'PY', '+3', '40.272838', '8.994752', 'America/Phoenix', 'USA', 'Chinese, German, Spanish', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1274, 'Gambia', 'QH', '+19', '31.761746', '44.751781', 'America/Swift_Current', 'USA', 'German, Chinese, English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1275, 'Greenland', 'LY', '+0', '-62.125915', '128.016346', 'Antarctica/Rothera', 'USA', 'German', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1276, 'Chad', 'ZC', '+41', '11.698802', '-134.775283', 'America/Marigot', 'USA', 'French, German', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1277, 'Greenland', 'UH', '+20', '-10.380077', '-143.469279', 'Africa/Harare', 'USA', 'Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1278, 'Macao', 'GW', '+1', '-84.438437', '153.34056', 'America/Argentina/Catamarca', 'USA', 'German, English, Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1279, 'Brunei Darussalam', 'LR', '+98', '-17.850177', '-10.959984', 'Asia/Ashgabat', 'USA', 'English', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1280, 'Albania', 'WL', '+4', '46.104365', '-117.823226', 'America/Montevideo', 'USA', 'French', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1281, 'Croatia', 'JZ', '+80', '-23.984268', '-17.909051', 'Africa/Cairo', 'USA', 'Chinese, English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1282, 'Serbia', 'UZ', '+79', '11.758335', '114.81942', 'America/Montevideo', 'USA', 'German, French, Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1283, 'Belgium', 'TJ', '+93', '-28.156727', '117.674988', 'Asia/Kamchatka', 'USA', 'English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1284, 'Kyrgyz Republic', 'LC', '+71', '75.009688', '-11.061173', 'Europe/Moscow', 'USA', 'English, French', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1285, 'French Southern Territories', 'TV', '+23', '36.573285', '165.998861', 'Asia/Thimphu', 'USA', 'Chinese, French', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1286, 'Pakistan', 'YH', '+1', '19.11282', '142.107163', 'Europe/Prague', 'USA', 'English, French, Spanish', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1287, 'Eritrea', 'GO', '+64', '-29.193093', '84.326693', 'Africa/Ceuta', 'USA', 'Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1288, 'Jamaica', 'OK', '+32', '72.107266', '61.012377', 'America/Thule', 'USA', 'Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1289, 'Turkey', 'LO', '+85', '-53.477685', '-142.872215', 'Antarctica/Vostok', 'USA', 'German, English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1290, 'Micronesia', 'SD', '+40', '8.940033', '113.504468', 'America/New_York', 'USA', 'English, Spanish', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1291, 'Wallis and Futuna', 'YT', '+3', '35.552173', '37.59415', 'America/Toronto', 'USA', 'Spanish, English, Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1292, 'Bosnia and Herzegovina', 'IA', '+4', '-8.038667', '-68.97644', 'Europe/Zurich', 'USA', 'Spanish', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1293, 'China', 'GF', '+69', '-11.836027', '-139.977245', 'America/Indiana/Winamac', 'USA', 'German', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1294, 'Seychelles', 'QJ', '+23', '13.099349', '-87.826551', 'America/New_York', 'USA', 'English, Spanish, Chinese', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1295, 'Cuba', 'LS', '+88', '-3.817699', '175.890149', 'Indian/Kerguelen', 'USA', 'English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1296, 'Moldova', 'LA', '+19', '-71.148526', '106.25015', 'America/Nassau', 'USA', 'English, Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1297, 'Saint Kitts and Nevis', 'LM', '+12', '-60.127495', '94.856559', 'America/Belem', 'USA', 'German, English', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1298, 'Korea', 'VL', '+63', '26.122225', '-133.123486', 'Pacific/Niue', 'USA', 'Spanish, Chinese, English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1299, 'Nauru', 'CF', '+75', '49.686153', '44.529643', 'Pacific/Galapagos', 'USA', 'English', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1300, 'Algeria', 'SK', '+7', '-11.690709', '-155.992195', 'Europe/Lisbon', 'USA', 'Spanish', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_lines`
--

CREATE TABLE `coupon_lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `discount_type` varchar(255) NOT NULL COMMENT 'percentage or amount',
  `discount` double NOT NULL,
  `min_order_value` double DEFAULT NULL,
  `max_discount` double DEFAULT NULL,
  `usage_limit` int(10) UNSIGNED DEFAULT NULL COMMENT 'Global usage limit for the coupon',
  `usage_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Number of times the coupon has been used globally',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `birth_day` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `def_lang` varchar(255) DEFAULT NULL,
  `firebase_token` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `apple_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `email_verify_token` text DEFAULT NULL,
  `email_verified` int(11) NOT NULL DEFAULT 0 COMMENT '0=unverified, 1=verified',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `verified` int(11) NOT NULL DEFAULT 0 COMMENT '0: not verified, 1: verified',
  `verify_method` varchar(255) NOT NULL DEFAULT 'email',
  `activity_notification` tinyint(1) NOT NULL DEFAULT 1,
  `marketing_email` tinyint(1) NOT NULL DEFAULT 0,
  `marketing_sms` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive, 2: suspended',
  `online_at` timestamp NULL DEFAULT NULL,
  `deactivated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `phone`, `image`, `birth_day`, `gender`, `def_lang`, `firebase_token`, `google_id`, `facebook_id`, `apple_id`, `password`, `password_changed_at`, `email_verify_token`, `email_verified`, `email_verified_at`, `verified`, `verify_method`, `activity_notification`, `marketing_email`, `marketing_sms`, `status`, `online_at`, `deactivated_at`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Customer', NULL, 'customer@gmail.com', NULL, '871', '1995-06-01', 'male', 'en', NULL, NULL, NULL, NULL, '$2y$12$e24onCxh4dWA9WMGxrlxC.9irzxhS494FnbXAtUR14sX5.3p3MhuK', NULL, NULL, 1, '2025-06-30 08:10:59', 1, 'email', 1, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'home' COMMENT 'home, office, others',
  `email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `road` varchar(255) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `floor` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_deactivation_reasons`
--

CREATE TABLE `customer_deactivation_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliveryman_deactivation_reasons`
--

CREATE TABLE `deliveryman_deactivation_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deliveryman_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_man_reviews`
--

CREATE TABLE `delivery_man_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deliveryman_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `review` longtext DEFAULT NULL COMMENT 'Customer’s feedback about the deliveryman',
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Rating from 1 to 5',
  `is_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indicates if the review has been verified by the admin',
  `reviewed_at` timestamp NULL DEFAULT NULL COMMENT 'The time when the review was created',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_men`
--

CREATE TABLE `delivery_men` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehicle_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `identification_type` enum('nid','passport','driving_license') DEFAULT NULL COMMENT 'Type of ID provided',
  `identification_number` varchar(255) DEFAULT NULL COMMENT 'Unique identification number',
  `identification_photo_front` varchar(255) DEFAULT NULL COMMENT 'Front image of ID',
  `identification_photo_back` varchar(255) DEFAULT NULL COMMENT 'Back image of ID',
  `address` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','inactive') NOT NULL DEFAULT 'pending',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_men`
--

INSERT INTO `delivery_men` (`id`, `user_id`, `store_id`, `vehicle_type_id`, `area_id`, `identification_type`, `identification_number`, `identification_photo_front`, `identification_photo_back`, `address`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 3, NULL, NULL, 1, 'nid', '123456789', NULL, NULL, NULL, 'approved', NULL, NULL, NULL, '2025-06-30 08:54:37', '2025-06-30 08:54:37');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 - Inactive, 1 - Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `type`, `name`, `subject`, `body`, `status`, `created_at`, `updated_at`) VALUES
(1, 'register', 'User Registration', 'Welcome', '<h2>Hello, @name</h2>', 1, '2025-03-10 01:43:11', '2025-04-16 09:50:44'),
(2, 'password-reset', 'Password Reset', 'Reset Your Password for Laravel', '<h2>Hello @name,</h2><p>We received a request to reset your password. Use this code:</p><h2>@reset_code</h2><p><i>If this wasn’t you, please ignore this email.</i></p>', 1, '2025-03-10 01:43:11', '2025-04-15 05:32:46'),
(3, 'store-creation', 'New Store Created', 'A New Store Has Been Created on Laravel', '<h1>Hello, @owner_name,</h1>\n                           <p>Your store <strong>@store_name</strong> has been successfully created!</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(4, 'subscription-expired', 'Subscription Expired Notification', 'Your Subscription Has Expired!', '<h1>Hello, @owner_name,</h1>\n                           <p>Your subscription for the store <strong>@store_name</strong> has expired on @expiry_date.</p>\n                           <p>Please renew your subscription to continue using our services.</p>', 1, '2025-03-10 01:43:11', '2025-03-25 00:00:44'),
(5, 'subscription-renewed', 'Subscription Renewal Confirmation', 'Your Subscription Has Been Successfully Renewed!', '<h1>Hello, @owner_name,</h1>\n                           <p>Your subscription for the store <strong>@store_name</strong> has been successfully renewed.</p>\n                           <p>New Expiry Date: @new_expiry_date</p>\n                           <p>Thank you for staying with us!</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(6, 'order-created', 'New Order Created', 'You Have a New Order!', '<h1>Hello @customer_name,</h1>\n                           <p>Your order (Order ID: @order_id) has been successfully placed.</p>\n                           <p>Order Amount: @order_amount</p>\n                           <p>We will notify you once your order status changes.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(7, 'order-created-store', 'New Order Created for Your Store', 'You Have a New Order in Your Store!', '<h1>Hello @store_owner_name,</h1>\n                           <p>Your store <strong>@store_name</strong> has received a new order (Order ID: @order_id).</p>\n                           <p>Order Amount: @order_amount</p>\n                           <p>Please process the order as soon as possible.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(8, 'order-created-admin', 'New Order Created', 'New Order Placed on the Platform!', '<h1>Hello Admin,</h1>\n                           <p>A new order (Order ID: @order_id) has been placed on the platform.</p>\n                           <p>Order Amount: @order_amount</p>\n                           <p>Please review the order details and take necessary action.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(9, 'order-status-pending', 'Order Pending Notification', 'Your Order Status: Pending', '<h1>Hello @customer_name,</h1>\n                           <p>Your order (Order ID: @order_id) is now <strong>pending</strong>.</p>\n                           <p>We will notify you once the order status changes.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(10, 'order-status-confirmed', 'Order Confirmed Notification', 'Your Order Status: Confirmed', '<h1>Hello @customer_name,</h1>\n                           <p>Your order (Order ID: @order_id) has been <strong>confirmed</strong>!</p>\n                           <p>We will notify you once it is processed.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(11, 'order-status-processing', 'Order Processing Notification', 'Your Order Status: Processing', '<h1>Hello @customer_name,</h1>\n                           <p>Your order (Order ID: @order_id) is now <strong>being processed</strong>.</p>\n                           <p>We will notify you once it is shipped.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(12, 'order-status-shipped', 'Order Shipped Notification', 'Your Order Status: Shipped', '<h1>Hello @customer_name,</h1>\n                           <p>Your order (Order ID: @order_id) has been <strong>shipped</strong>!</p>\n                           <p>It is on its way to you and will arrive soon.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(13, 'order-status-delivered', 'Order Delivered Notification', 'Your Order Has Been Delivered!', '<h1>Hello @customer_name,</h1>\n                           <p>Your order (Order ID: @order_id) has been <strong>delivered</strong>!</p>\n                           <p>We hope you enjoy your purchase!</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(14, 'order-status-cancelled', 'Order Cancelled Notification', 'Your Order Has Been Cancelled', '<h1>Hello @customer_name,</h1>\n                           <p>Your order (Order ID: @order_id) has been <strong>cancelled</strong>.</p>\n                           <p>If you have any questions, please contact our support team.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(15, 'refund-customer', 'Refund Processed', 'Your Refund has Been Processed', '<h1>Hello @customer_name,</h1>\n                           <p>Your refund for Order ID: @order_id has been successfully processed.</p>\n                           <p>Refund Amount: @refund_amount</p>\n                           <p>The amount will be credited back to your account shortly.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(16, 'refund-store', 'Refund Processed for Your Store', 'A Refund has Been Processed for an Order in Your Store', '<h1>Hello @store_owner_name,</h1>\n                           <p>A refund has been processed for an order in your store (Order ID: @order_id).</p>\n                           <p>Refund Amount: @refund_amount</p>\n                           <p>Please ensure your account is updated accordingly.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(17, 'wallet-balance-added-customer', 'Customer Wallet Balance Added', 'Your Wallet Balance Has Been Updated', '<h1>Hello @customer_name,</h1>\n                           <p>Your wallet balance has been successfully updated.</p>\n                           <p>New Balance: @balance</p>\n                           <p>Thank you for using our service!</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(18, 'wallet-balance-added-store', 'Store Wallet Balance Added', 'Your Store Wallet Balance Has Been Updated', '<h1>Hello @store_owner_name,</h1>\n                           <p>Your store\'s wallet balance has been successfully updated.</p>\n                           <p>Store: @store_name</p>\n                           <p>New Balance: @balance</p>\n                           <p>Thank you for being a part of our platform!</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(19, 'store-withdrawal-request', 'Store Withdrawal Request', 'A Withdrawal Request Has Been Submitted', '<h1>Hello Admin,</h1>\n                           <p>A withdrawal request has been submitted by @store_owner_name for their store <strong>@store_name</strong>.</p>\n                           <p>Requested Amount: @amount</p>\n                           <p>Please review and take the necessary action.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(20, 'store-withdrawal-approved', 'Store Withdrawal Approved', 'Your Withdrawal Request Has Been Approved', '<h1>Hello @store_owner_name,</h1>\n                           <p>Your withdrawal request for your store <strong>@store_name</strong> has been approved.</p>\n                           <p>Amount: @amount</p>\n                           <p>The amount will be transferred to your account shortly.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(21, 'store-withdrawal-declined', 'Store Withdrawal Declined', 'Your Withdrawal Request Has Been Declined', '<h1>Hello @store_owner_name,</h1>\n                           <p>Your withdrawal request for your store <strong>@store_name</strong> has been declined.</p>\n                           <p>Amount: @amount</p>\n                           <p>If you have any questions, please contact the support team.</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(22, 'deliveryman-withdrawal-request', 'Deliveryman Withdrawal Request', 'Your Withdrawal Request Has Been Received', '<h1>Hello @deliveryman_name,</h1>\n                       <p>Your withdrawal request has been successfully submitted for the amount of @amount.</p>\n                       <p>Your request is being reviewed by the admin. You will receive a confirmation email once your request has been processed.</p>\n                       <p>Thank you for your hard work!</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(23, 'deliveryman-earning', 'Delivery Earnings Notification', 'You Have New Earnings!', '<h1>Hello, @deliveryman_name,</h1>\n                            <p>You\'ve received a new earning:</p>\n                            <p><strong>Order ID:</strong> @order_id</p>\n                            <p><strong>Order Amount:</strong> @order_amount</p>\n                            <p><strong>Earnings:</strong> @earnings_amount</p>\n                            <p>Thank you for your hard work!</p>', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11'),
(24, 'seller-register-for-admin', 'User Registration', 'Hello Admin, A New Seller Just Joined BravoMart!', '<ul>\n<li><strong>Name:</strong> @name</li>\n<li><strong>Email:</strong> @email</li>\n<li><strong>Phone:</strong> @phone</li>\n</ul>\n', 1, '2025-03-10 01:43:11', '2025-03-10 01:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flash_sales`
--

CREATE TABLE `flash_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_color` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `description_color` varchar(255) DEFAULT NULL,
  `background_color` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_text_color` varchar(255) DEFAULT NULL,
  `button_hover_color` varchar(255) DEFAULT NULL,
  `button_bg_color` varchar(255) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `timer_bg_color` varchar(255) DEFAULT NULL,
  `timer_text_color` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `discount_type` varchar(255) DEFAULT NULL COMMENT 'percentage or amount',
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `special_price` decimal(10,2) DEFAULT NULL COMMENT 'special price for product',
  `purchase_limit` int(10) UNSIGNED DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flash_sale_products`
--

CREATE TABLE `flash_sale_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flash_sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `type`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 'gdpr', '{\"gdpr_basic_section\":{\"com_gdpr_title\":\"GDPR & Cookie Settings\",\"com_gdpr_message\":\"We use cookies to personalize your experience and to analyze our traffic. You can choose to accept or decline.\",\"com_gdpr_more_info_label\":\"More Information\",\"com_gdpr_more_info_link\":\"http:\\/\\/localhost:3010\\/\\/privacy-policy\",\"com_gdpr_accept_label\":\"Accept\",\"com_gdpr_decline_label\":\"Decline\",\"com_gdpr_manage_label\":\"Manage\",\"com_gdpr_manage_title\":\"Manage Cookie Preferences\",\"com_gdpr_expire_date\":\"2025-05-28\",\"com_gdpr_show_delay\":\"500\",\"com_gdpr_enable_disable\":\"on\"},\"gdpr_more_info_section\":{\"steps\":[{\"title\":\"What are cookies?1\",\"descriptions\":\"Cookies are small text files stored on your device to help us remember your preferences and activity.1\"},{\"title\":\"What are cookies?2\",\"descriptions\":\"Cookies are small text files stored on your device to help us remember your preferences and activity.2\"}]}}', 1, '2025-05-27 08:57:09', '2025-05-28 08:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `linked_social_accounts`
--

CREATE TABLE `linked_social_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` varchar(255) NOT NULL,
  `provider_name` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `live_locations`
--

CREATE TABLE `live_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trackable_type` varchar(255) NOT NULL,
  `trackable_id` bigint(20) UNSIGNED NOT NULL,
  `ref` varchar(255) DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `format` varchar(255) DEFAULT NULL,
  `file_size` text DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `user_id`, `name`, `format`, `file_size`, `path`, `alt_text`, `dimensions`, `created_at`, `updated_at`) VALUES
(586, 2, 'Grocery logo.png', 'admin', '45.68 KB', 'uploads/media-uploader/default/grocery-logo1744532665.png', NULL, '1714 x 1667 pixels', '2025-06-30 08:22:18', '2025-06-30 08:22:18'),
(592, 2, 'bakery bg.png', 'admin', '676.43 KB', 'uploads/media-uploader/default/bakery-bg1744540327.png', NULL, '3417 x 1300 pixels', NULL, NULL),
(747, 1, 'Premium.png', 'png', '12.64 KB', 'uploads/media-uploader/default/premium1747743543.png', NULL, '368 x 368 pixels', '2025-06-30 08:48:19', '2025-06-30 08:48:19'),
(748, 1, 'Basic Package.png', 'png', '13.04 KB', 'uploads/media-uploader/default/basic-package1747743546.png', NULL, '384 x 384 pixels', '2025-06-30 08:45:46', '2025-06-30 08:45:46'),
(749, 1, 'Standard.png', 'png', '21.61 KB', 'uploads/media-uploader/default/standard1747743548.png', NULL, '413 x 413 pixels', '2025-06-30 08:46:53', '2025-06-30 08:46:53'),
(750, 1, 'Trial.png', 'png', '5.48 KB', 'uploads/media-uploader/default/trial1747743664.png', NULL, '130 x 130 pixels', '2025-06-30 08:43:47', '2025-06-30 08:43:47'),
(751, 1, 'Enterprize.png', 'png', '4.77 KB', 'uploads/media-uploader/default/enterprice1747743667.png', NULL, '142 x 142 pixels', '2025-06-30 08:48:19', '2025-06-30 08:48:19'),
(765, 2, 'storea.png', 'png', '36.69 KB', 'uploads/media-uploader/default/storea1747819273.png', NULL, '301 x 301 pixels', '2025-06-30 08:39:08', '2025-06-30 08:39:08'),
(871, 1, 'Frame 1984077917.png', 'png', '239.7 KB', 'uploads/media-uploader/default/frame-19840779171748769231.png', NULL, '400 x 400 pixels', '2025-06-30 08:16:23', '2025-06-30 08:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_path` varchar(255) DEFAULT NULL,
  `menu_level` int(11) DEFAULT NULL,
  `menu_path` varchar(255) DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `page_id`, `name`, `url`, `icon`, `position`, `parent_id`, `parent_path`, `menu_level`, `menu_path`, `is_visible`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'About', 'about-us', NULL, 5, NULL, NULL, 0, NULL, 1, 1, '2025-03-19 21:20:57', '2025-06-16 08:50:40'),
(2, NULL, 'Coupon', 'coupon', NULL, 0, 5, '5', 1, 'Pages', 1, 1, '2025-03-19 21:20:57', '2025-06-16 08:49:44'),
(3, NULL, 'Product', 'product', NULL, 1, NULL, NULL, 0, NULL, 1, 1, '2025-04-07 02:36:45', '2025-06-16 08:50:20'),
(4, NULL, 'Become A Seller', 'become-a-seller', NULL, 0, 5, '5', 1, 'Pages', 1, 1, '2025-04-07 02:37:33', '2025-06-16 08:49:08'),
(5, NULL, 'Pages', NULL, NULL, 4, NULL, NULL, 0, NULL, 1, 1, '2025-04-07 02:38:24', '2025-06-16 08:45:31'),
(6, NULL, 'Blog', 'blogs', NULL, 6, NULL, NULL, 0, NULL, 1, 1, '2025-04-07 02:39:02', '2025-06-16 08:45:09'),
(7, NULL, 'Privacy & Policy', 'privacy-policy', NULL, 0, 5, '5', 1, 'Pages', 1, 1, '2025-04-07 02:39:36', '2025-06-16 08:48:43'),
(8, NULL, 'Terms and conditions', 'terms-conditions', NULL, 0, 5, '5', 1, 'Pages', 1, 1, '2025-04-07 02:40:19', '2025-06-16 08:48:22'),
(9, NULL, 'Shipping & Delivery Policy', 'terms-conditions', NULL, 0, 5, '5', 1, 'Pages', 1, 1, '2025-04-07 02:40:50', '2025-06-16 08:46:34'),
(10, NULL, 'Contact', 'contact-us', NULL, 0, 5, '5', 1, 'Pages', 1, 1, '2025-04-07 02:41:11', '2025-06-16 08:46:03'),
(11, NULL, 'Home', '/', NULL, 0, NULL, NULL, 0, NULL, 1, 1, '2025-04-07 02:50:01', '2025-06-16 08:41:59'),
(12, NULL, 'Store', 'store/list', NULL, 3, NULL, NULL, 0, NULL, 1, 1, '2025-04-07 02:50:01', '2025-06-16 08:42:20'),
(13, NULL, 'Categories', 'product-category/list', NULL, 2, NULL, NULL, 0, NULL, 1, 1, '2025-04-07 02:50:01', '2025-06-16 08:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_08_19_063216_create_permission_tables', 1),
(5, '2024_08_19_101423_create_settings_table', 1),
(6, '2024_08_20_031637_create_personal_access_tokens_table', 1),
(7, '2024_08_22_055123_create_modules_table', 1),
(8, '2024_09_01_040725_create_common_table', 1),
(9, '2024_09_18_054554_create_media_table', 1),
(11, '2024_12_01_084123_create_product_variants_table', 1),
(12, '2024_12_01_104154_create_product_authors', 1),
(13, '2024_12_02_061049_create_tags_table', 1),
(14, '2024_12_02_061315_create_units_table', 1),
(16, '2024_12_05_072243_create_system_management_table', 1),
(17, '2024_12_08_041032_create_stores_table', 1),
(18, '2024_12_09_071947_create_linked_social_accounts_table', 1),
(19, '2024_12_10_085252_create_blog_categories_table', 1),
(20, '2024_12_10_085444_create_blogs_table', 1),
(21, '2024_12_10_085521_create_blog_comments_table', 1),
(22, '2024_12_14_041146_create_customer_addresses_table', 1),
(24, '2024_12_14_114842_create_countries_table', 1),
(25, '2024_12_14_114939_create_states_table', 1),
(26, '2024_12_14_114946_create_cities_table', 1),
(27, '2024_12_14_114952_create_areas_table', 1),
(28, '2024_12_17_040318_create_banners_table', 1),
(29, '2024_12_17_060550_create_subscribers_table', 1),
(30, '2024_12_18_120550_create_tickets_table', 1),
(31, '2024_12_18_121039_create_departments_table', 1),
(32, '2024_12_18_123832_create_ticket_messages_table', 1),
(33, '2024_12_21_044253_create_product_tags_table', 1),
(35, '2024_12_23_123354_create_pages_table', 1),
(36, '2024_12_24_123547_create_payment_gateways_table', 1),
(37, '2025_01_01_085646_create_coupon_lines_table', 1),
(38, '2025_01_02_044507_create_wallets_table', 1),
(39, '2025_01_02_045253_create_wallet_transactions_table', 1),
(40, '2025_01_02_065302_create_wishlists_table', 1),
(41, '2025_01_02_092436_create_product_attribute_values_table', 1),
(44, '2025_01_06_053513_create_store_notices_table', 1),
(45, '2025_01_06_055258_create_store_notice_recipients_table', 1),
(46, '2025_01_06_095020_create_withdraw_gateways_table', 1),
(49, '2025_01_13_115827_create_delivery_men_table', 1),
(50, '2025_01_13_121305_create_vehicle_types_table', 1),
(52, '2025_01_13_122304_create_delivery_man_reviews_table', 1),
(54, '2025_01_20_054032_create_contact_us_messages_table', 1),
(56, '2025_01_20_085241_create_order_masters_table', 1),
(57, '2025_01_20_085258_create_order_details_table', 1),
(58, '2025_01_21_040554_create_order_activities_table', 1),
(59, '2025_01_21_040744_create_order_delivery_histories_table', 1),
(60, '2025_01_29_071946_create_reviews_table', 1),
(61, '2025_01_30_085856_create_review_reactions_table', 1),
(62, '2025_02_05_113010_create_customer_deactivation_reasons_table', 1),
(63, '2025_02_06_112640_create_product_queries_table', 1),
(64, '2025_02_19_100636_create_wallet_withdrawals_transactions_table', 1),
(65, '2025_02_20_091323_create_order_refund_reasons_table', 1),
(66, '2025_02_20_091655_create_order_refunds_table', 1),
(67, '2025_02_22_060508_create_email_templates_table', 1),
(69, '2025_02_24_112001_create_universal_notifications_table', 1),
(70, '2025_03_04_053458_create_blog_views_table', 1),
(71, '2025_03_05_032116_create_blog_comment_reactions_table', 1),
(72, '2025_03_05_081045_create_deliveryman_deactivation_reasons_table', 1),
(73, '2025_03_10_074239_create_product_views_table', 2),
(74, '2025_03_11_040543_create_become_seller_settings_table', 3),
(76, '2025_01_05_044745_create_flash_sales_table', 4),
(78, '2025_03_18_045614_create_about_settings_table', 6),
(79, '2025_03_18_082233_create_contact_settings_table', 7),
(82, '2024_12_04_082107_create_coupons_table', 10),
(83, '2024_12_22_051501_create_customers_table', 11),
(88, '0001_01_01_000000_create_users_table', 14),
(91, '2025_04_07_063538_create_web_push_tokens_table', 16),
(95, '2025_01_12_072301_create_subscriptions_table', 17),
(96, '2025_01_13_100217_create_store_subscriptions_table', 17),
(97, '2025_01_13_121616_create_subscription_histories_table', 17),
(99, '2025_04_07_050816_create_push_subscriptions_table', 18),
(100, '2025_05_06_062702_create_live_locations_table', 18),
(102, '2025_01_05_044804_create_flash_sale_products_table', 20),
(103, '2024_12_01_084047_create_products_table', 21),
(104, '2025_05_19_054302_create_store_types_table', 22),
(106, '2025_01_20_085135_create_orders_table', 23),
(107, '2025_03_19_075141_create_menus_table', 24),
(108, '2025_05_26_123500_create_general_settings_table', 25),
(109, '2024_12_14_064131_create_sliders_table', 26),
(110, '2025_02_22_090326_create_order_addresses_table', 27),
(111, '2025_05_27_103715_create_chats_table', 28),
(113, '2025_05_27_103736_create_chat_messages_table', 29),
(114, '2025_06_04_091421_add_online_at_to_customers_table', 30),
(115, '2025_06_04_091421_add_online_at_to_users_table', 30),
(116, '2025_01_14_104513_create_system_commissions_table', 31),
(117, '2025_06_04_091421_add_online_at_to_stores_table', 32),
(118, '2025_06_22_050642_create_sms_providers_table', 33),
(119, '2025_06_22_050752_create_user_otps_table', 33);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'admin', 8),
(1, 'App\\Models\\User', 8),
(1, 'App\\Models\\User', 27),
(1, 'App\\Models\\User', 29),
(1, 'App\\Models\\User', 30),
(1, 'App\\Models\\User', 32),
(1, 'App\\Models\\User', 33),
(1, 'App\\Models\\User', 62),
(1, 'App\\Models\\User', 65),
(1, 'App\\Models\\User', 84),
(1, 'App\\Models\\User', 89),
(2, 'admin', 1),
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 11),
(2, 'App\\Models\\User', 12),
(2, 'App\\Models\\User', 13),
(2, 'App\\Models\\User', 14),
(2, 'App\\Models\\User', 15),
(2, 'App\\Models\\User', 16),
(2, 'App\\Models\\User', 30),
(2, 'App\\Models\\User', 32),
(2, 'App\\Models\\User', 38),
(2, 'App\\Models\\User', 39),
(2, 'App\\Models\\User', 40),
(2, 'App\\Models\\User', 41),
(2, 'App\\Models\\User', 43),
(2, 'App\\Models\\User', 44),
(2, 'App\\Models\\User', 45),
(2, 'App\\Models\\User', 49),
(2, 'App\\Models\\User', 50),
(2, 'App\\Models\\User', 52),
(2, 'App\\Models\\User', 53),
(2, 'App\\Models\\User', 54),
(2, 'App\\Models\\User', 55),
(2, 'App\\Models\\User', 56),
(2, 'App\\Models\\User', 57),
(2, 'App\\Models\\User', 67),
(2, 'App\\Models\\User', 70),
(2, 'App\\Models\\User', 72),
(2, 'App\\Models\\User', 73),
(2, 'App\\Models\\User', 76),
(2, 'App\\Models\\User', 77),
(2, 'App\\Models\\User', 78),
(2, 'App\\Models\\User', 79),
(2, 'App\\Models\\User', 81),
(2, 'App\\Models\\User', 82),
(2, 'App\\Models\\User', 83),
(2, 'App\\Models\\User', 86),
(2, 'App\\Models\\User', 87),
(2, 'App\\Models\\User', 91),
(2, 'App\\Models\\User', 92),
(2, 'App\\Models\\User', 96),
(2, 'admin', 98),
(2, 'admin', 100),
(2, 'admin', 101),
(2, 'admin', 102),
(6, 'App\\Models\\User', 32),
(6, 'App\\Models\\User', 51),
(6, 'App\\Models\\User', 71),
(6, 'App\\Models\\User', 93),
(6, 'admin', 99),
(6, 'admin', 105),
(6, 'admin', 106),
(6, 'admin', 107),
(6, 'admin', 108),
(17, 'App\\Models\\User', 85),
(17, 'App\\Models\\User', 88),
(17, 'admin', 103);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `available_to_seller` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_master_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `invoice_date` timestamp NULL DEFAULT NULL,
  `order_type` varchar(255) DEFAULT NULL COMMENT 'regular, pos',
  `delivery_option` varchar(255) DEFAULT NULL COMMENT 'home_delivery, parcel, takeaway',
  `delivery_type` varchar(255) DEFAULT NULL COMMENT 'standard, express, freight',
  `delivery_time` varchar(255) DEFAULT NULL,
  `order_amount` decimal(8,2) DEFAULT NULL,
  `order_amount_store_value` decimal(8,2) DEFAULT NULL,
  `order_amount_admin_commission` decimal(8,2) DEFAULT NULL,
  `product_discount_amount` decimal(8,2) DEFAULT NULL,
  `flash_discount_amount_admin` decimal(8,2) DEFAULT NULL,
  `coupon_discount_amount_admin` decimal(8,2) DEFAULT NULL,
  `shipping_charge` decimal(8,2) DEFAULT NULL,
  `delivery_charge_admin` decimal(8,2) DEFAULT NULL,
  `delivery_charge_admin_commission` decimal(8,2) DEFAULT NULL,
  `order_additional_charge_name` varchar(255) DEFAULT NULL,
  `order_additional_charge_amount` decimal(8,2) DEFAULT NULL,
  `order_additional_charge_store_amount` decimal(8,2) DEFAULT NULL,
  `order_admin_additional_charge_commission` decimal(8,2) DEFAULT NULL,
  `is_reviewed` tinyint(1) DEFAULT NULL,
  `confirmed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `cancel_request_by` bigint(20) UNSIGNED DEFAULT NULL,
  `cancel_request_at` timestamp NULL DEFAULT NULL,
  `cancelled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `delivery_completed_at` timestamp NULL DEFAULT NULL,
  `refund_status` varchar(255) DEFAULT NULL COMMENT 'requested, processing, refunded, rejected',
  `status` varchar(255) NOT NULL DEFAULT 'pending' COMMENT 'pending, confirmed, processing , shipped, delivered, cancelled, on_hold',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_activities`
--

CREATE TABLE `order_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ref_id` bigint(20) UNSIGNED DEFAULT NULL,
  `collected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `activity_from` varchar(255) DEFAULT NULL,
  `activity_type` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `activity_value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_addresses`
--

CREATE TABLE `order_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_master_id` bigint(20) UNSIGNED DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'home' COMMENT 'home, office, others',
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `road` varchar(255) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `floor` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery_histories`
--

CREATE TABLE `order_delivery_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `deliveryman_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text DEFAULT NULL COMMENT 'Reason for ignoring or cancelling delivery',
  `status` enum('accepted','ignored','delivered','cancelled') NOT NULL COMMENT 'accepted, ignored, delivered, cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `behaviour` varchar(255) DEFAULT NULL COMMENT 'service, digital, consumable, combo',
  `product_sku` varchar(255) DEFAULT NULL,
  `variant_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`variant_details`)),
  `product_campaign_id` bigint(20) UNSIGNED DEFAULT NULL,
  `base_price` decimal(15,2) DEFAULT NULL,
  `admin_discount_type` varchar(255) DEFAULT NULL,
  `admin_discount_rate` decimal(15,2) DEFAULT NULL,
  `admin_discount_amount` decimal(15,2) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `quantity` decimal(15,2) DEFAULT NULL,
  `line_total_price_with_qty` decimal(15,2) DEFAULT NULL,
  `coupon_discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `line_total_excluding_tax` decimal(15,2) DEFAULT NULL,
  `tax_rate` decimal(15,2) DEFAULT NULL,
  `tax_amount` decimal(15,2) DEFAULT NULL,
  `total_tax_amount` decimal(15,2) DEFAULT NULL,
  `line_total_price` decimal(15,2) DEFAULT NULL,
  `admin_commission_type` varchar(255) DEFAULT NULL,
  `admin_commission_rate` decimal(15,2) NOT NULL DEFAULT 0.00,
  `admin_commission_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_masters`
--

CREATE TABLE `order_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_address_id` varchar(255) DEFAULT NULL,
  `order_amount` decimal(15,2) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_title` varchar(255) DEFAULT NULL,
  `coupon_discount_amount_admin` decimal(15,2) DEFAULT NULL,
  `product_discount_amount` decimal(15,2) DEFAULT NULL,
  `flash_discount_amount_admin` decimal(15,2) DEFAULT NULL,
  `shipping_charge` decimal(15,2) DEFAULT NULL,
  `additional_charge_name` varchar(255) DEFAULT NULL,
  `additional_charge_amount` decimal(15,2) DEFAULT NULL,
  `additional_charge_commission` decimal(15,2) DEFAULT NULL,
  `paid_amount` decimal(15,2) DEFAULT NULL,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL COMMENT 'pending , paid, failed',
  `transaction_ref` varchar(255) DEFAULT NULL,
  `transaction_details` varchar(255) DEFAULT NULL,
  `order_notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_refunds`
--

CREATE TABLE `order_refunds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `order_refund_reason_id` bigint(20) UNSIGNED NOT NULL,
  `customer_note` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','refunded') NOT NULL DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `reject_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_refund_reasons`
--

CREATE TABLE `order_refund_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `slug` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` longtext DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft' COMMENT 'draft, published,unpublished',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Terms and conditions', 'terms-conditions', '<h2>📄 <strong>Terms and Conditions</strong></h2><p>Welcome to <strong>Bravo Mart</strong>. These Terms and Conditions outline the rules and regulations for the use of our platform.</p><p>By accessing or using , you agree to comply with and be bound by these terms. If you disagree with any part of the terms, you must not use our services.</p><p></p><hr><h3>1. 🛍️ <strong>Use of Our Platform</strong></h3><ul><li><p>You must be at least <strong>18 years old</strong> or use the site under the supervision of a guardian.</p></li><li><p>You agree to use the platform only for lawful purposes.</p></li><li><p>Any fraudulent, abusive, or illegal activity is strictly prohibited.</p></li><li><p></p></li></ul><hr><h3>2. 👤 <strong>User Accounts</strong></h3><ul><li><p>You are responsible for maintaining the confidentiality of your account and password.</p></li><li><p>You agree to provide accurate and complete information during registration.</p></li><li><p><strong>Bravo Mart</strong> reserves the right to suspend or terminate accounts found in violation of our terms.</p></li></ul><hr><p></p><h3>3. 🛒 <strong>Orders &amp; Transactions</strong></h3><ul><li><p>All orders placed through the website are subject to product availability and confirmation of the order price.</p></li><li><p>We reserve the right to cancel or limit the quantity of any order for any reason.</p></li></ul><hr><p></p><h3>4. 📦 <strong>Vendor Responsibilities</strong></h3><ul><li><p>Sellers must ensure accurate listing information, stock availability, and timely fulfillment.</p></li><li><p>Products must meet the quality and safety standards as defined in our <strong>Seller Policy</strong>.</p></li><li><p>Misuse of the platform by vendors may lead to account suspension.</p></li></ul><hr><p></p><h3>5. 💳 <strong>Pricing &amp; Payment</strong></h3><ul><li><p>All prices are listed in <strong>$</strong> and are inclusive of applicable taxes unless stated otherwise.</p></li><li><p>We reserve the right to modify prices at any time without prior notice.</p></li></ul><hr><p></p><h3>6. 🔄 Returns, Refunds &amp; Cancellations</h3><ul><li><p>Please refer to our <strong>Return &amp; Refund Policy</strong> for information on returns, exchanges, and cancellations.</p></li></ul><hr><p></p><h3>7. 🔐 <strong>Privacy Policy</strong></h3><ul><li><p>Your use of our site is also governed by our <strong>Privacy Policy</strong>, which outlines how we collect, use, and protect your personal data.</p></li></ul><hr><p></p><h3>8. 🚫 <strong>Prohibited Activities</strong></h3><p>Users are prohibited from:</p><ul><li><p>Violating any applicable laws</p></li><li><p>Infringing on the intellectual property rights of others</p></li><li><p>Uploading or transmitting viruses or malicious code</p></li><li><p>Attempting to gain unauthorized access to other accounts</p></li></ul><hr><p></p><h3>9. 📜 <strong>Intellectual Property</strong></h3><ul><li><p>All content, design, logos, and trademarks on the platform are the property of <strong>Bravo Mart </strong>or its licensors.</p></li><li><p>You may not use any content without prior written consent.</p></li></ul><hr><p></p><h3>10. ⚖️ <strong>Limitation of Liability</strong></h3><ul><li><p>We shall not be held liable for any indirect, incidental, or consequential damages arising from the use of or inability to use the platform.</p></li></ul><hr><p></p><h3>11. 🛠️ <strong>Modifications</strong></h3><ul><li><p>We reserve the right to update or modify these terms at any time.</p></li><li><p>Continued use of the platform after changes implies acceptance of the revised terms.</p></li></ul><hr><p></p><h3>12. 📞 <strong>Contact Us</strong></h3><p>If you have any questions about these Terms, please contact us at:</p><p><strong>Email:</strong> bravomart.support@gmail.com<br><strong>Phone:</strong> +2001700000000</p>', 'Buy Products Online - My Amazing Store', 'Find the best deals on products at My Amazing Store. Quality items at affordable prices.', 'buy products, store, amazing deals, affordable prices', 'publish', '2025-03-20 01:28:54', '2025-05-22 05:54:15'),
(5, 'Privacy Policy', 'privacy-policy', '<h1><strong>Privacy Policy</strong><br></h1><h2>Privacy &amp; Information Security Policy</h2><p>Welcome to <strong>BravoMart</strong>. These Terms and Conditions (\"Terms\") govern your use of our multivendor e-commerce platform and apply to all users, including buyers, sellers, and visitors. By accessing or using our platform, you agree to comply with these Terms.</p><p>Our platform provides a marketplace where independent vendors can list and sell products, and buyers can browse and purchase products. While we facilitate these transactions, we are not directly involved in the sale or fulfillment of products.</p><p>Please review these Terms carefully. If you do not agree, you should discontinue use of our platform. For any questions or assistance, contact us at bravo.mart.support@gmail.</p><h2>Information We Collect</h2><p></p><h3>1. Personal Information</h3><ul><li><p><strong>Full Name:</strong> Used for identification, billing, and shipping purposes.</p></li><li><p><strong>Email Address:</strong> Required for account creation, communications, and order confirmations.</p></li><li><p><strong>Phone Number:</strong> Used for account verification, order updates, and customer support.</p></li><li><p><strong>Billing &amp; Shipping Address:</strong> Necessary for processing payments and delivering purchased items.<br></p></li></ul><h3>2. Account Information</h3><ul><li><p><strong>Username:</strong> Chosen by the user for logging in and account recognition.</p></li><li><p><strong>Password:</strong> Securely encrypted and stored to protect user accounts.</p></li><li><p><strong>Profile Details:</strong> Includes avatar, preferences, saved addresses, and communication settings.<br></p></li></ul><h3>3. Payment Information</h3><ul><li><p><strong>Transaction History:</strong> Records of payments, purchases, refunds, and disputes.</p></li><li><p><strong>Billing Information:</strong> Includes payment method (credit/debit card, digital wallets, etc.).</p></li><li><p><strong>Third-Party Payment Data:</strong> When we do not store full credit card details, our payment partners securely process transactions and store necessary details.</p></li></ul><h3>4. Device &amp; Usage Data<br></h3><ul><li><p><strong>IP Address:</strong> Helps detect fraud, maintain security, and personalize content based on location.</p></li><li><p><strong>Browser Type &amp; Operating System:</strong> Used for optimizing the website experience.</p></li><li><p><strong>Cookies &amp; Tracking Technologies:</strong> Enable session management, user authentication, and marketing improvements.</p></li><li><p><strong>Analytics Data:</strong> Collected through third-party tools (e.g., Google Analytics) to analyze user behavior, website traffic, and engagement metrics.</p></li></ul><h3>5. Vendor-Specific Data</h3><ul><li><p><strong>Business Details:</strong> Such as business name, registration details, and tax identification.</p></li><li><p><strong>Store Information:</strong> Includes store name, logo, policies, and contact details.</p></li><li><p><strong>Uploaded Content:</strong> Product listings, descriptions, images, and other media required for selling on the platform.</p></li></ul><h2>Data Protection, Security &amp; Tracking Technologies</h2><h3>1. Data Protection &amp; Security</h3><ul><li><p><strong>Encryption &amp; Secure Storage:</strong> All sensitive data, including passwords and payment information, is encrypted and stored securely.</p></li><li><p><strong>Secure Payment Processing:</strong> Transactions are handled through PCI-DSS-compliant payment gateways, ensuring financial data protection.</p></li><li><p><strong>Access Control:</strong> Only authorized personnel have access to sensitive data, and strict security protocols are in place.</p></li><li><p><strong>Fraud Prevention:</strong> We use automated security tools and monitoring systems to detect fraudulent activities.</p></li><li><p><strong>Regular Security Audits:</strong> We conduct periodic assessments and updates to enhance data security measures.</p></li></ul><h3>2. Cookies &amp; Tracking Technologies</h3><ul><li><p><strong>Essential Cookies:</strong> Necessary for website functionality, including login authentication and shopping cart management.</p></li><li><p><strong>Performance &amp; Analytics Cookies:</strong> Help us analyze user behavior, track website traffic, and improve user experience.</p></li><li><p><strong>Advertising &amp; Marketing Cookies:</strong> Used for personalized ads and remarketing campaigns based on browsing activity.</p></li><li><p><strong>Third-Party Tracking:</strong> Some cookies are placed by third-party services (e.g., Google Analytics, Facebook Pixel) to help us understand and optimize engagement.</p></li></ul>', 'Buy Products Online - Amazing Store', 'Find the best deals on products at My Amazing Store. Quality items at affordable prices.', 'buy products, store, amazing deals, affordable prices', 'publish', '2025-04-08 02:40:57', '2025-05-22 05:48:57'),
(6, 'Refund Policies', 'refund-policies', '🧾 Refund & Return Policy\nWe strive to ensure a seamless shopping experience for all our customers. Please read our Refund & Return Policy carefully to understand how returns and refunds work on our multivendor platform.\n\n🛒 General Return Policy\nCustomers can request a return within 30 days of receiving the product.\nReturns are accepted only if the item is:\n\nDamaged during transit\n\nDefective or malfunctioning\n\nIncorrect or not as described\n\nThe item must be unused, in its original packaging, and with all original tags/labels attached.\n\n🔄 Vendor-Specific Return Policies\nEach vendor may have unique return policies based on the product type. Always check the return policy mentioned on the individual store/product page.\nIf a vendor doesn\'t define a specific policy, the general return policy will apply.\n\n💸 Refund Process\nAfter the returned item is received and inspected, refunds will be processed to the original payment method within 7–10 business days.\n\nCustomers may choose store credit instead of a direct refund.\n\n🚫 Non-Returnable Items\nItems marked as non-returnable or final sale\n\nPerishable goods (e.g., food, flowers)\n\nPersonal care/hygiene items (e.g., makeup, undergarments)\n\nDownloadable or digital products\n\n📦 Return Shipping\nIf the return is due to vendor error (wrong item, defective, or damaged), return shipping is covered by the vendor.\n\nIf due to customer reasons (e.g., change of mind, wrong size), customer pays the return shipping.\n\n📦 Customer Return Policies by Store Type\n🥦 Grocery\nReturns accepted within 24 hours\n\nOnly for damaged, expired, or wrong items\n\nItems must not be opened or consumed\n\n🍞 Bakery\nReturns within 24 hours\n\nAccepted if spoiled, damaged, or incorrect\n\nMust be in original condition and packaging\n\n💊 Medicine (Health & Wellness)\nReturns within 3 days\n\nOnly if damaged, incorrect, sealed and unused\n\nPrescription medications are non-returnable\n\n💄 Makeup\nReturns within 7 days\n\nMust be sealed, unused, and in original packaging\n\nUsed products cannot be returned due to hygiene concerns\n\n👜 Bags\nReturns within 14 days\n\nItem must be unused, with tags and original packaging\n\n👗 Clothing\nReturns within 14 days\n\nTry-on allowed, but item must be unworn, unwashed, and with tags attached\n\nExchanges allowed for size issues\n\n🛋️ Furniture\nReturns within 7 days\n\nMust be unassembled, in original condition and packaging\n\nCustom-made items are non-returnable\n\n📚 Books\nReturns within 7 days\n\nMust be in new condition, no marks or damage\n\nDigital books are non-refundable\n\n📱 Gadgets (Electronics)\nReturns within 14 days\n\nMust be unused and in original packaging\n\nIf opened, only accepted if defective or non-functional\n\nWarranty claims follow vendor-specific terms\n\n🐾 Animals & Pets\nReturns within 48 hours\n\nOnly accepted for wrong or unhealthy delivery\n\nMust include photo/video proof\n\nLive animals handled case-by-case\n\n🐟 Fish\nReturns within 24 hours\n\nOnly for dead-on-arrival or wrong species\n\nMust report within 1 hour of delivery with visual proof\n\nTank conditions and water temperature may be checked', 'Refund Policies', 'Refund Policies', 'Refund Policies', 'publish', '2025-04-13 08:54:30', '2025-05-22 06:33:54'),
(18, 'Shipping & Delivery Policy', 'test-page', '<h2>🚚 <strong>Shipping &amp; Delivery Policy</strong></h2><p></p><p>We are committed to delivering your order accurately, in good condition, and always on time.</p><h3>⏱️ Shipping Timeframes</h3><ul><li><p>Orders are usually processed and shipped within <strong>1–2 business days</strong>.</p></li><li><p>Delivery time depends on the shipping address and chosen delivery method:</p><ul><li><p><strong>Local delivery</strong>: 1–3 days</p></li><li><p><strong>National shipping</strong>: 3–7 days</p></li><li><p><strong>International</strong> (if applicable): 7–21 days</p></li><li><p></p></li></ul></li></ul><h3>💰 <strong>Shipping Charges</strong></h3><ul><li><p>Free shipping for orders above <strong>[e.g., $50]</strong></p></li><li><p>A standard shipping fee applies for smaller orders (calculated at checkout).</p></li><li><p></p></li></ul><h3>📦 <strong>Delivery Partners</strong></h3><p>We use trusted logistics partners like <strong>[Courier Names]</strong> to ensure timely and safe delivery.</p><h3>📍 Order Tracking</h3><p>Once your order is shipped, you will receive an email/SMS with a <strong>tracking number</strong> to monitor the delivery status.</p><h3>📌 <strong>Delivery Attempts</strong></h3><ul><li><p>We will attempt delivery <strong>up to 3 times</strong>.</p></li><li><p>After failed attempts, the order may be returned to the seller.</p></li><li><p></p></li></ul><h3>📦 D<strong>amaged or Missing Items</strong></h3><ul><li><p>If you receive a damaged product or find items missing, please contact us within <strong>48 hours</strong> of delivery with photos and order details.</p></li></ul>', NULL, NULL, NULL, 'publish', '2025-05-05 12:30:07', '2025-05-22 06:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `auth_credentials` longtext DEFAULT NULL,
  `is_test_mode` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 Inactive, 1 Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `name`, `slug`, `image`, `description`, `auth_credentials`, `is_test_mode`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PayPal', 'paypal', '633', NULL, '{\"paypal_sandbox_client_id\":null,\"paypal_sandbox_client_secret\":null,\"paypal_sandbox_client_app_id\":null,\"paypal_live_client_id\":null,\"paypal_live_client_secret\":null,\"paypal_live_app_id\":null}', 1, 1, '2025-03-10 01:43:09', '2025-04-15 11:53:34'),
(2, 'Stripe', 'stripe', '634', NULL, '{\"stripe_public_key\":\"sk_test_51QjCbjFQkOXqMwIhjWIxb8NKEkgx5gXc8mmREA3ARAA5e8laAkq0RVXrFjtgPBGIABzmrMgRwLAXikBQW7xp9iwM00SxLhiBWj\",\"stripe_secret_key\":null}', 1, 1, '2025-03-10 01:43:09', '2025-05-28 09:46:03'),
(3, 'Razorpay', 'razorpay', '636', NULL, '{\"razorpay_api_key\":null,\"razorpay_api_secret\":null}', 1, 1, '2025-03-10 01:43:09', '2025-04-15 11:53:46'),
(4, 'Paytm', 'paytm', '635', NULL, '{\"paytm_merchant_key\":null,\"paytm_merchant_mid\":null,\"paytm_merchant_website\":null,\"paytm_channel\":null,\"paytm_industry_type\":null}', 1, 1, '2025-03-10 01:43:09', '2025-04-15 11:53:42'),
(5, 'Cash On Delivery', 'cash_on_delivery', '637', NULL, NULL, 1, 1, '2025-03-10 01:43:09', '2025-04-15 11:53:50');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `available_for` varchar(255) NOT NULL DEFAULT 'system_level',
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `module_title` varchar(255) DEFAULT NULL,
  `perm_title` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  `options` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `available_for`, `name`, `guard_name`, `module_title`, `perm_title`, `icon`, `parent_id`, `options`, `created_at`, `updated_at`, `module`) VALUES
(163, 'delivery_level', '/deliveryman/withdraw-manage', 'api', NULL, 'Withdrawals', '', NULL, '[\"view\",\"insert\",\"others\"]', '2025-03-10 01:42:59', '2025-03-10 01:42:59', NULL),
(4972, 'store_level', 'dashboard', 'api', NULL, 'Dashboard', 'LayoutDashboard', NULL, '[\"view\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4973, 'store_level', 'Order Management', 'api', NULL, 'Order Management', '', NULL, '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4974, 'store_level', 'Orders', 'api', NULL, 'Orders', 'Boxes', '4973', '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4975, 'store_level', '/seller/store/orders', 'api', NULL, 'All Orders', '', '4974', '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4976, 'store_level', '/seller/store/orders/refund-request', 'api', NULL, 'Returned or Refunded', '', '4974', '[\"view\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4977, 'store_level', 'Product management', 'api', NULL, 'Product management', '', NULL, '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4978, 'store_level', 'Products', 'api', NULL, 'Products', 'Codesandbox', '4977', '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4979, 'store_level', '/seller/store/product/list', 'api', NULL, 'Manage Products', '', '4978', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4980, 'store_level', '/seller/store/product/add', 'api', NULL, 'Add New Product', '', '4978', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4981, 'store_level', '/seller/store/product/stock-report', 'api', NULL, 'Product Low & Out Stock', '', '4978', '[\"view\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4982, 'store_level', '/seller/store/product/import', 'api', NULL, 'Bulk Import', '', '4978', '[\"view\",\"insert\",\"update\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4983, 'store_level', '/seller/store/product/export', 'api', NULL, 'Bulk Export', '', '4978', '[\"view\",\"insert\",\"update\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4984, 'store_level', '/seller/store/attribute/list', 'api', NULL, 'Attributes', 'Layers2', '4977', '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4985, 'store_level', '/seller/store/product/author/list', 'api', NULL, 'Authors', 'BookOpenCheck', '4977', '[\"View\",\"insert\",\"update\",\"delete\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4986, 'store_level', 'Inventory Management', 'api', NULL, 'Inventory Management', 'SquareChartGantt', NULL, '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4987, 'store_level', '/seller/store/product/inventory', 'api', NULL, 'Inventory', 'PackageOpen', '4986', '[\"view\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4988, 'store_level', 'Promotional control', 'api', NULL, 'Promotional control', 'Proportions', NULL, '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4989, 'store_level', 'Flash Sale', 'api', NULL, 'Flash Sale', 'Zap', '4988', '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4990, 'store_level', '/seller/store/promotional/flash-deals/active-deals', 'api', NULL, 'Active Deals', '', '4989', '[\"view\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4991, 'store_level', '/seller/store/promotional/flash-deals/my-deals', 'api', NULL, 'My Deals', '', '4989', '[\"view\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4992, 'store_level', 'Chat', 'api', NULL, 'Chat', '', NULL, '[\"view\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4993, 'store_level', '/seller/store/chat/list', 'api', NULL, 'Chat List', 'MessageSquareMore', '4992', '[\"view\",\"insert\",\"update\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4994, 'store_level', 'Support Ticket', 'api', NULL, 'Support Ticket', 'Headphones', NULL, '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4995, 'store_level', '/seller/store/support-ticket/list', 'api', NULL, 'Tickets', 'Headset', '4994', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4996, 'store_level', 'Feedback control', 'api', NULL, 'Feedback control', 'MessageSquareReply', NULL, '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4997, 'store_level', '/seller/store/feedback-control/review', 'api', NULL, 'Reviews', 'Star', '4996', '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4998, 'store_level', '/seller/store/feedback-control/questions', 'api', NULL, 'Questions', 'CircleHelp', '4996', '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(4999, 'store_level', 'Financial Management', 'api', NULL, 'Financial Management', '', NULL, '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(5000, 'store_level', '/seller/store/financial/withdraw', 'api', NULL, 'Withdrawals', 'BadgeDollarSign', '4999', '[\"view\",\"insert\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(5001, 'store_level', '/seller/store/financial/wallet', 'api', NULL, 'Store Wallet', 'Wallet', '4999', '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(5002, 'store_level', 'Staff control', 'api', NULL, 'Staff control', 'UserRoundPen', NULL, '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(5003, 'store_level', '/seller/store/staff/list', 'api', NULL, 'Staff List', 'Users', '5002', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(5004, 'store_level', 'Notifications', 'api', NULL, 'Notifications', 'MessageCircleMore', NULL, '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(5005, 'store_level', '/seller/store/notifications', 'api', NULL, 'All Notifications', 'Bell', '5004', '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(5006, 'store_level', 'Store Settings', 'api', NULL, 'Store Settings', 'Store', NULL, '[\"View\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(5007, 'store_level', '/seller/store/settings/business-plan', 'api', NULL, 'Business Plan', 'BriefcaseBusiness', '5006', '[\"view\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(5008, 'store_level', '/seller/store/settings/notices', 'api', NULL, 'Notice', 'BadgeAlert', '5006', '[\"view\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(5009, 'store_level', '/seller/store/list', 'api', NULL, 'My Stores', 'Store', '5006', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-01 04:31:09', '2025-06-01 04:31:09', NULL),
(5396, 'system_level', '/admin/dashboard', 'api', NULL, 'Dashboard', 'LayoutDashboard', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5397, 'system_level', 'Order Management', 'api', NULL, 'Order Management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5398, 'system_level', 'Orders', 'api', NULL, 'Orders', 'ListOrdered', '5397', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5399, 'system_level', '/admin/orders', 'api', NULL, 'All Orders', 'ListOrdered', '5398', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5400, 'system_level', '/admin/orders/refund-request', 'api', NULL, 'Returned or Refunded', 'RotateCcw', '5398', '[\"view\",\"update\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5401, 'system_level', '/admin/orders/refund-reason/list', 'api', NULL, 'Refund Reason', '', '5398', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5402, 'system_level', 'Product management', 'api', NULL, 'Product management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5403, 'system_level', 'Products', 'api', NULL, 'Products', 'Codesandbox', '5402', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5404, 'system_level', '/admin/product/list', 'api', NULL, 'All Products', 'PackageSearch', '5403', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5405, 'system_level', '/admin/product/request', 'api', NULL, 'Product Approval Request', 'Signature', '5403', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5406, 'system_level', '/admin/product/stock-report', 'api', NULL, 'Product Low & Out Stock', 'Layers', '5403', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5407, 'system_level', '/admin/product/import', 'api', NULL, 'Bulk Import', 'FileUp', '5403', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5408, 'system_level', '/admin/product/export', 'api', NULL, 'Bulk Export', 'Download', '5403', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5409, 'system_level', '/admin/product/inventory', 'api', NULL, 'Product Inventory', 'SquareChartGantt', '5402', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5410, 'system_level', '/admin/categories', 'api', NULL, 'Categories', 'List', '5402', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5411, 'system_level', '/admin/attribute/list', 'api', NULL, 'Attributes', 'AttributeIcon', '5402', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5412, 'system_level', '/admin/unit/list', 'api', NULL, 'Units', 'Boxes', '5402', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5413, 'system_level', '/admin/brand/list', 'api', NULL, 'Brands', 'LayoutList', '5402', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5414, 'system_level', '/admin/tag/list', 'api', NULL, 'Tags', 'Tags', '5402', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5415, 'system_level', '/admin/product/author/list', 'api', NULL, 'Authors', '', '5402', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5416, 'system_level', 'Coupon Management', 'api', NULL, 'Coupon Management', 'SquarePercent', '5402', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5417, 'system_level', '/admin/coupon/list', 'api', NULL, 'Coupons', '', '5416', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5418, 'system_level', '/admin/coupon-line/list', 'api', NULL, 'Coupon Lines', '', '5416', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5419, 'system_level', 'Store management', 'api', NULL, 'Store management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5420, 'system_level', 'Store', 'api', NULL, 'Store', 'Store', '5419', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5421, 'system_level', '/admin/store/list', 'api', NULL, 'Store List', 'Store', '5420', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5422, 'system_level', '/admin/store/add', 'api', NULL, 'Store Add', '', '5420', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5423, 'system_level', '/admin/store/approval', 'api', NULL, 'Store Approval Request', '', '5420', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5424, 'system_level', 'Slider Management', 'api', NULL, 'Slider Management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5425, 'system_level', '/admin/slider/list', 'api', NULL, 'Slider', 'SlidersHorizontal', '5424', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5426, 'system_level', 'Media Management', 'api', NULL, 'Media Management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5427, 'system_level', '/admin/media-manage', 'api', NULL, 'Media', 'Images', '5426', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5428, 'system_level', 'Promotional control', 'api', NULL, 'Promotional control', 'Proportions', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5429, 'system_level', 'Flash Sale', 'api', NULL, 'Flash Sale', 'Zap', '5428', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5430, 'system_level', '/admin/promotional/flash-deals/list', 'api', NULL, 'All Campaigns', '', '5429', '[\"view\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5431, 'system_level', '/admin/promotional/flash-deals/join-request', 'api', NULL, 'Join Campaign Requests', '', '5429', '[\"view\",\"insert\",\"delete\",\"update\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5432, 'system_level', '/admin/promotional/banner/list', 'api', NULL, 'Banners', 'AlignJustify', '5428', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5433, 'system_level', 'Feedback Management', 'api', NULL, 'Feedback Management', 'MessageSquareReply', NULL, '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5434, 'system_level', '/admin/feedback-control/review', 'api', NULL, 'Reviews', 'Star', '5433', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5435, 'system_level', '/admin/feedback-control/questions', 'api', NULL, 'Questions', 'CircleHelp', '5433', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5436, 'system_level', 'Blog Management', 'api', NULL, 'Blog Management', '', NULL, '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5437, 'system_level', 'Blogs', 'api', NULL, 'Blogs', 'Rss', '5436', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5438, 'system_level', '/admin/blog/category', 'api', NULL, 'Category', '', '5437', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5439, 'system_level', '/admin/blog/posts', 'api', NULL, 'Posts', '', '5437', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5440, 'system_level', 'Pages Management', 'api', NULL, 'Pages Management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5441, 'system_level', '/admin/pages/list', 'api', NULL, 'Page Lists', 'List', '5440', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5442, 'system_level', 'Wallet Management', 'api', NULL, 'Wallet Management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5443, 'system_level', '/admin/wallet/list', 'api', NULL, 'Wallet Lists', 'Wallet', '5442', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5444, 'system_level', '/admin/wallet/transactions', 'api', NULL, 'Transaction History', 'History', '5442', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5445, 'system_level', '/admin/wallet/settings', 'api', NULL, 'Wallet Settings', 'Settings', '5442', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5446, 'system_level', 'Deliveryman management', 'api', NULL, 'Deliveryman management', 'UserRoundPen', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5447, 'system_level', '/admin/deliveryman/vehicle-types/list', 'api', NULL, 'Vehicle Types', 'Car', '5446', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5448, 'system_level', '/admin/deliveryman/list', 'api', NULL, 'Deliveryman List', 'UserRoundPen', '5446', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5449, 'system_level', 'Customer management', 'api', NULL, 'Customer management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5450, 'system_level', 'All Customers', 'api', NULL, 'All Customers', 'UsersRound', '5449', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5451, 'system_level', '/admin/customer/list', 'api', NULL, 'Customers', '', '5450', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5452, 'system_level', '/admin/customer/subscriber-list', 'api', NULL, 'Subscriber List', '', '5450', '[\"view\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5453, 'system_level', '/admin/customer/contact-messages', 'api', NULL, 'Contact Messages', '', '5450', '[\"view\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5454, 'system_level', 'Seller management', 'api', NULL, 'Seller management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5455, 'system_level', 'All Sellers', 'api', NULL, 'All Sellers', 'UsersRound', '5454', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5456, 'system_level', '/admin/seller/list', 'api', NULL, 'Sellers', '', '5455', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5457, 'system_level', '/admin/seller/registration', 'api', NULL, 'Register A Seller', '', '5455', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5458, 'system_level', 'Employee Management', 'api', NULL, 'Employee Management', '', NULL, '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5459, 'system_level', 'Staff Roles', 'api', NULL, 'Staff Roles', 'LockKeyholeOpen', '5458', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5460, 'system_level', '/admin/roles/list', 'api', NULL, 'List', '', '5459', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5461, 'system_level', '/admin/roles/add', 'api', NULL, 'Add Role', '', '5459', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5462, 'system_level', 'My Staff', 'api', NULL, 'My Staff', 'Users', '5458', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5463, 'system_level', '/admin/staff/list', 'api', NULL, 'List', '', '5462', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5464, 'system_level', '/admin/staff/add', 'api', NULL, 'Add Staff', '', '5462', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5465, 'system_level', 'Chat Management', 'api', NULL, 'Chat Management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5466, 'system_level', 'Chat', 'api', NULL, 'Chat', 'MessageSquareMore', '5465', '[\"view\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5467, 'system_level', '/admin/chat/settings', 'api', NULL, 'Chat Settings', '', '5466', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5468, 'system_level', '/admin/chat/manage', 'api', NULL, 'Chat List', '', '5466', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5469, 'system_level', 'Support Ticket', 'api', NULL, 'Support Ticket', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5470, 'system_level', 'Tickets', 'api', NULL, 'Tickets', 'Headphones', '5469', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5471, 'system_level', '/admin/ticket/department', 'api', NULL, 'Department', '', '5470', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5472, 'system_level', '/admin/support-ticket/list', 'api', NULL, 'All Tickets', '', '5470', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5473, 'system_level', 'Financial Management', 'api', NULL, 'Financial Management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5474, 'system_level', 'Financial', 'api', NULL, 'Financial', 'BadgeDollarSign', '5473', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5475, 'system_level', '/admin/financial/withdraw/settings', 'api', NULL, 'Withdrawal Settings', '', '5474', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5476, 'system_level', '/admin/financial/withdraw/method/list', 'api', NULL, 'Withdrawal Method', '', '5474', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5477, 'system_level', '/admin/financial/withdraw/history', 'api', NULL, 'Withdraw History', '', '5474', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5478, 'system_level', '/admin/financial/withdraw/request', 'api', NULL, 'Withdraw Requests', '', '5474', '[\"view\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5479, 'system_level', '/admin/financial/cash-collect', 'api', NULL, 'Cash Collect', '', '5474', '[\"view\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5480, 'system_level', 'Report and analytics', 'api', NULL, 'Report and analytics', 'Logs', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5481, 'system_level', '/admin/report-analytics/order', 'api', NULL, 'Order Report', '', '5480', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5482, 'system_level', 'Notifications', 'api', NULL, 'Notifications', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5483, 'system_level', '/admin/notifications', 'api', NULL, 'Notifications', 'Bell', '5482', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5484, 'system_level', 'Notice Management', 'api', NULL, 'Notice Management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5485, 'system_level', '/admin/store-notices', 'api', NULL, 'Notices', 'MessageSquareWarning', '5484', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5486, 'system_level', 'Business Operations', 'api', NULL, 'Business Operations', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5487, 'system_level', '/admin/business-operations/store-type', 'api', NULL, 'Store Type', 'Store', '5486', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5488, 'system_level', '/admin/business-operations/area/list', 'api', NULL, 'Area Setup', 'Locate', '5486', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5489, 'system_level', 'Subscription', 'api', NULL, 'Subscription', 'PackageCheck', '5486', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5490, 'system_level', '/admin/business-operations/subscription/package/list', 'api', NULL, 'Subscription Package', '', '5489', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5491, 'system_level', '/admin/business-operations/subscription/store/list', 'api', NULL, 'Store Subscription', '', '5489', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5492, 'system_level', '/admin/business-operations/commission/settings', 'api', NULL, 'Commission Settings', 'BadgePercent', '5486', '[\"view\",\"update\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5493, 'system_level', 'Payment Gateways', 'api', NULL, 'Payment Gateways', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5494, 'system_level', '/admin/payment-gateways/settings', 'api', NULL, 'Payment Settings', 'CreditCard', '5493', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5495, 'system_level', 'SMS Gateways', 'api', NULL, 'SMS Gateways', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5496, 'system_level', '/admin/sms-provider/settings', 'api', NULL, 'SMS Gateway Settings', 'CreditCard', '5495', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5497, 'system_level', 'System management', 'api', NULL, 'System management', '', NULL, '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5498, 'system_level', '/admin/system-management/general-settings', 'api', NULL, 'General Settings', 'Settings', '5497', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5499, 'system_level', '/admin/system-management/page-settings', 'api', NULL, 'Page Settings', 'FileSliders', '5497', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5500, 'system_level', '/admin/system-management/page-settings/home', 'api', NULL, 'Home Page', '', '5499', '[\"view\",\"insert\",\"update\",\"delete\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5501, 'system_level', '/admin/system-management/page-settings/register', 'api', NULL, 'Register Page', '', '5499', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5502, 'system_level', '/admin/system-management/page-settings/login', 'api', NULL, 'Login Page', '', '5499', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5503, 'system_level', '/admin/system-management/page-settings/product-details', 'api', NULL, 'Product Details Page', '', '5499', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5504, 'system_level', '/admin/system-management/page-settings/blog-details', 'api', NULL, 'Blog Page', '', '5499', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5505, 'system_level', '/admin/system-management/page-settings/about', 'api', NULL, 'About Page', '', '5499', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5506, 'system_level', '/admin/system-management/page-settings/contact', 'api', NULL, 'Contact Page', '', '5499', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5507, 'system_level', '/admin/system-management/page-settings/become-seller', 'api', NULL, 'Become A Seller Page', '', '5499', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5508, 'system_level', 'appearance_settings', 'api', NULL, 'Appearance Settings', 'MonitorCog', '5497', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5509, 'system_level', '/admin/system-management/menu-customization', 'api', NULL, 'Menu Customization', '', '5508', '[\"view\",\"insert\",\"update\",\"delete\",\"others\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5510, 'system_level', '/admin/system-management/footer-customization', 'api', NULL, 'Footer Customization', '', '5508', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5511, 'system_level', '/admin/system-management/maintenance-settings', 'api', NULL, 'Maintenance Settings', '', '5508', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5512, 'system_level', 'Email Settings', 'api', NULL, 'Email Settings', 'Mails', '5497', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5513, 'system_level', '/admin/system-management/email-settings/smtp', 'api', NULL, 'SMTP Settings', '', '5512', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5514, 'system_level', '/admin/system-management/email-settings/email-template/list', 'api', NULL, 'Email Templates', '', '5512', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5515, 'system_level', '/admin/system-management/seo-settings', 'api', NULL, 'SEO Settings', 'SearchCheck', '5497', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5516, 'system_level', '/admin/system-management/gdpr-cookie-settings', 'api', NULL, 'Cookie Settings', 'Cookie', '5497', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5517, 'system_level', 'Third-Party', 'api', NULL, 'Third-Party', 'Blocks', '5497', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5518, 'system_level', '/admin/system-management/google-map-settings', 'api', NULL, 'Google Map Settings', '', '5517', '[\"view\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5519, 'system_level', '/admin/system-management/firebase-settings', 'api', NULL, 'Firebase Settings', '', '5517', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5520, 'system_level', '/admin/system-management/social-login-settings', 'api', NULL, 'Social Login Settings', '', '5517', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5521, 'system_level', '/admin/system-management/recaptcha-settings', 'api', NULL, 'Recaptcha Settings', '', '5517', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5522, 'system_level', '/admin/system-management/cache-management', 'api', NULL, 'Cache Management', 'DatabaseZap', '5497', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5523, 'system_level', '/admin/system-management/database-update-controls', 'api', NULL, 'Database Update', 'Database', '5497', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL),
(5524, 'system_level', 'app-settings', 'api', NULL, 'App settings', 'Smartphone', '5497', '[\"view\",\"update\"]', '2025-06-24 05:52:51', '2025-06-24 05:52:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('grocery','bakery','medicine','makeup','bags','clothing','furniture','books','gadgets','animals-pet','fish') DEFAULT NULL,
  `behaviour` enum('consumable','service','digital','combo','physical') DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `video_url` varchar(100) DEFAULT NULL,
  `gallery_images` varchar(255) DEFAULT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `return_in_days` varchar(255) DEFAULT NULL,
  `return_text` varchar(255) DEFAULT NULL,
  `allow_change_in_mind` varchar(255) DEFAULT NULL,
  `cash_on_delivery` int(11) DEFAULT NULL,
  `delivery_time_min` varchar(255) DEFAULT NULL,
  `delivery_time_max` varchar(255) DEFAULT NULL,
  `delivery_time_text` varchar(255) DEFAULT NULL,
  `max_cart_qty` int(11) DEFAULT NULL,
  `order_count` int(11) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `status` enum('draft','pending','approved','inactive','suspended') NOT NULL DEFAULT 'pending',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_image` text DEFAULT NULL,
  `available_time_starts` timestamp NULL DEFAULT NULL,
  `available_time_ends` timestamp NULL DEFAULT NULL,
  `manufacture_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_values`
--

CREATE TABLE `product_attribute_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_authors`
--

CREATE TABLE `product_authors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `born_date` date DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '1 = active, 0 = inactive',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_brand`
--

CREATE TABLE `product_brand` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_slug` varchar(255) NOT NULL,
  `brand_logo` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `seller_relation_with_brand` varchar(255) DEFAULT NULL,
  `authorization_valid_from` timestamp NULL DEFAULT NULL,
  `authorization_valid_to` timestamp NULL DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_slug` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `category_name_paths` varchar(255) DEFAULT NULL,
  `parent_path` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `category_level` int(11) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 1,
  `admin_commission_rate` double DEFAULT NULL,
  `category_thumb` varchar(255) DEFAULT NULL,
  `category_banner` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_queries`
--

CREATE TABLE `product_queries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE `product_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variant_slug` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `pack_quantity` decimal(15,2) DEFAULT NULL,
  `weight_major` decimal(15,2) DEFAULT NULL,
  `weight_gross` decimal(15,2) DEFAULT NULL,
  `weight_net` decimal(15,2) DEFAULT NULL,
  `attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attributes`)),
  `price` decimal(15,2) DEFAULT NULL,
  `special_price` decimal(15,2) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `length` decimal(15,2) DEFAULT NULL,
  `width` decimal(15,2) DEFAULT NULL,
  `height` decimal(15,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `order_count` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_views`
--

CREATE TABLE `product_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `push_subscriptions`
--

CREATE TABLE `push_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscribable_type` varchar(255) NOT NULL,
  `subscribable_id` bigint(20) UNSIGNED NOT NULL,
  `endpoint` varchar(500) NOT NULL,
  `public_key` varchar(255) DEFAULT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `content_encoding` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `reviewable_id` bigint(20) UNSIGNED NOT NULL,
  `reviewable_type` varchar(255) NOT NULL COMMENT 'product or delivery_man',
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `review` text NOT NULL,
  `rating` decimal(3,2) NOT NULL COMMENT '1-5 star rating',
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `like_count` int(11) NOT NULL DEFAULT 0,
  `dislike_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_reactions`
--

CREATE TABLE `review_reactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reaction_type` enum('like','dislike') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `available_for` varchar(255) NOT NULL DEFAULT 'system_level',
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `available_for`, `name`, `guard_name`, `locked`, `status`, `created_at`, `updated_at`) VALUES
(1, 'system_level', 'Super Admin', 'api', 1, 1, '2023-08-11 05:57:33', '2023-08-11 05:57:33'),
(2, 'store_level', 'Store Admin', 'api', 1, 1, '2023-08-11 05:57:33', '2023-08-11 05:57:33'),
(6, 'delivery_level', 'Delivery Man', 'api', 1, 1, '2023-08-11 05:57:33', '2023-08-11 05:57:33'),
(17, 'system_level', 'Admin', 'api', 0, 1, '2025-05-15 03:39:59', '2025-05-15 03:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `view` tinyint(1) DEFAULT NULL,
  `insert` tinyint(1) DEFAULT NULL,
  `update` tinyint(1) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT NULL,
  `others` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`, `view`, `insert`, `update`, `delete`, `others`) VALUES
(163, 6, 1, NULL, NULL, NULL, NULL),
(4972, 2, 1, NULL, NULL, NULL, NULL),
(4973, 2, 1, NULL, NULL, NULL, NULL),
(4974, 2, 1, NULL, NULL, NULL, NULL),
(4975, 2, 1, NULL, NULL, NULL, NULL),
(4976, 2, 1, NULL, NULL, NULL, NULL),
(4977, 2, 1, NULL, NULL, NULL, NULL),
(4978, 2, 1, NULL, NULL, NULL, NULL),
(4979, 2, 1, NULL, NULL, NULL, NULL),
(4980, 2, 1, NULL, NULL, NULL, NULL),
(4981, 2, 1, NULL, NULL, NULL, NULL),
(4982, 2, 1, NULL, NULL, NULL, NULL),
(4983, 2, 1, NULL, NULL, NULL, NULL),
(4984, 2, 1, NULL, NULL, NULL, NULL),
(4985, 2, 1, NULL, NULL, NULL, NULL),
(4986, 2, 1, NULL, NULL, NULL, NULL),
(4987, 2, 1, NULL, NULL, NULL, NULL),
(4988, 2, 1, NULL, NULL, NULL, NULL),
(4989, 2, 1, NULL, NULL, NULL, NULL),
(4990, 2, 1, NULL, NULL, NULL, NULL),
(4991, 2, 1, NULL, NULL, NULL, NULL),
(4992, 2, 1, NULL, NULL, NULL, NULL),
(4993, 2, 1, NULL, NULL, NULL, NULL),
(4994, 2, 1, NULL, NULL, NULL, NULL),
(4995, 2, 1, NULL, NULL, NULL, NULL),
(4996, 2, 1, NULL, NULL, NULL, NULL),
(4997, 2, 1, NULL, NULL, NULL, NULL),
(4998, 2, 1, NULL, NULL, NULL, NULL),
(4999, 2, 1, NULL, NULL, NULL, NULL),
(5000, 2, 1, NULL, NULL, NULL, NULL),
(5001, 2, 1, NULL, NULL, NULL, NULL),
(5002, 2, 1, NULL, NULL, NULL, NULL),
(5003, 2, 1, NULL, NULL, NULL, NULL),
(5004, 2, 1, NULL, NULL, NULL, NULL),
(5005, 2, 1, NULL, NULL, NULL, NULL),
(5006, 2, 1, NULL, NULL, NULL, NULL),
(5007, 2, 1, NULL, NULL, NULL, NULL),
(5008, 2, 1, NULL, NULL, NULL, NULL),
(5009, 2, 1, NULL, NULL, NULL, NULL),
(5396, 1, 1, NULL, NULL, NULL, NULL),
(5397, 1, 1, NULL, NULL, NULL, NULL),
(5398, 1, 1, NULL, NULL, NULL, NULL),
(5399, 1, 1, NULL, NULL, NULL, NULL),
(5400, 1, 1, NULL, NULL, NULL, NULL),
(5401, 1, 1, NULL, NULL, NULL, NULL),
(5402, 1, 1, NULL, NULL, NULL, NULL),
(5403, 1, 1, NULL, NULL, NULL, NULL),
(5404, 1, 1, NULL, NULL, NULL, NULL),
(5405, 1, 1, NULL, NULL, NULL, NULL),
(5406, 1, 1, NULL, NULL, NULL, NULL),
(5407, 1, 1, NULL, NULL, NULL, NULL),
(5408, 1, 1, NULL, NULL, NULL, NULL),
(5409, 1, 1, NULL, NULL, NULL, NULL),
(5410, 1, 1, NULL, NULL, NULL, NULL),
(5411, 1, 1, NULL, NULL, NULL, NULL),
(5412, 1, 1, NULL, NULL, NULL, NULL),
(5413, 1, 1, NULL, NULL, NULL, NULL),
(5414, 1, 1, NULL, NULL, NULL, NULL),
(5415, 1, 1, NULL, NULL, NULL, NULL),
(5416, 1, 1, NULL, NULL, NULL, NULL),
(5417, 1, 1, NULL, NULL, NULL, NULL),
(5418, 1, 1, NULL, NULL, NULL, NULL),
(5419, 1, 1, NULL, NULL, NULL, NULL),
(5420, 1, 1, NULL, NULL, NULL, NULL),
(5421, 1, 1, NULL, NULL, NULL, NULL),
(5422, 1, 1, NULL, NULL, NULL, NULL),
(5423, 1, 1, NULL, NULL, NULL, NULL),
(5424, 1, 1, NULL, NULL, NULL, NULL),
(5425, 1, 1, NULL, NULL, NULL, NULL),
(5426, 1, 1, NULL, NULL, NULL, NULL),
(5427, 1, 1, NULL, NULL, NULL, NULL),
(5428, 1, 1, NULL, NULL, NULL, NULL),
(5429, 1, 1, NULL, NULL, NULL, NULL),
(5430, 1, 1, NULL, NULL, NULL, NULL),
(5431, 1, 1, NULL, NULL, NULL, NULL),
(5432, 1, 1, NULL, NULL, NULL, NULL),
(5433, 1, 1, NULL, NULL, NULL, NULL),
(5434, 1, 1, NULL, NULL, NULL, NULL),
(5435, 1, 1, NULL, NULL, NULL, NULL),
(5436, 1, 1, NULL, NULL, NULL, NULL),
(5437, 1, 1, NULL, NULL, NULL, NULL),
(5438, 1, 1, NULL, NULL, NULL, NULL),
(5439, 1, 1, NULL, NULL, NULL, NULL),
(5440, 1, 1, NULL, NULL, NULL, NULL),
(5441, 1, 1, NULL, NULL, NULL, NULL),
(5442, 1, 1, NULL, NULL, NULL, NULL),
(5443, 1, 1, NULL, NULL, NULL, NULL),
(5444, 1, 1, NULL, NULL, NULL, NULL),
(5445, 1, 1, NULL, NULL, NULL, NULL),
(5446, 1, 1, NULL, NULL, NULL, NULL),
(5447, 1, 1, NULL, NULL, NULL, NULL),
(5448, 1, 1, NULL, NULL, NULL, NULL),
(5449, 1, 1, NULL, NULL, NULL, NULL),
(5450, 1, 1, NULL, NULL, NULL, NULL),
(5451, 1, 1, NULL, NULL, NULL, NULL),
(5452, 1, 1, NULL, NULL, NULL, NULL),
(5453, 1, 1, NULL, NULL, NULL, NULL),
(5454, 1, 1, NULL, NULL, NULL, NULL),
(5455, 1, 1, NULL, NULL, NULL, NULL),
(5456, 1, 1, NULL, NULL, NULL, NULL),
(5457, 1, 1, NULL, NULL, NULL, NULL),
(5458, 1, 1, NULL, NULL, NULL, NULL),
(5459, 1, 1, NULL, NULL, NULL, NULL),
(5460, 1, 1, NULL, NULL, NULL, NULL),
(5461, 1, 1, NULL, NULL, NULL, NULL),
(5462, 1, 1, NULL, NULL, NULL, NULL),
(5463, 1, 1, NULL, NULL, NULL, NULL),
(5464, 1, 1, NULL, NULL, NULL, NULL),
(5465, 1, 1, NULL, NULL, NULL, NULL),
(5466, 1, 1, NULL, NULL, NULL, NULL),
(5467, 1, 1, NULL, NULL, NULL, NULL),
(5468, 1, 1, NULL, NULL, NULL, NULL),
(5469, 1, 1, NULL, NULL, NULL, NULL),
(5470, 1, 1, NULL, NULL, NULL, NULL),
(5471, 1, 1, NULL, NULL, NULL, NULL),
(5472, 1, 1, NULL, NULL, NULL, NULL),
(5473, 1, 1, NULL, NULL, NULL, NULL),
(5474, 1, 1, NULL, NULL, NULL, NULL),
(5475, 1, 1, NULL, NULL, NULL, NULL),
(5476, 1, 1, NULL, NULL, NULL, NULL),
(5477, 1, 1, NULL, NULL, NULL, NULL),
(5478, 1, 1, NULL, NULL, NULL, NULL),
(5479, 1, 1, NULL, NULL, NULL, NULL),
(5480, 1, 1, NULL, NULL, NULL, NULL),
(5481, 1, 1, NULL, NULL, NULL, NULL),
(5482, 1, 1, NULL, NULL, NULL, NULL),
(5483, 1, 1, NULL, NULL, NULL, NULL),
(5484, 1, 1, NULL, NULL, NULL, NULL),
(5485, 1, 1, NULL, NULL, NULL, NULL),
(5486, 1, 1, NULL, NULL, NULL, NULL),
(5487, 1, 1, NULL, NULL, NULL, NULL),
(5488, 1, 1, NULL, NULL, NULL, NULL),
(5489, 1, 1, NULL, NULL, NULL, NULL),
(5490, 1, 1, NULL, NULL, NULL, NULL),
(5491, 1, 1, NULL, NULL, NULL, NULL),
(5492, 1, 1, NULL, NULL, NULL, NULL),
(5493, 1, 1, NULL, NULL, NULL, NULL),
(5494, 1, 1, NULL, NULL, NULL, NULL),
(5495, 1, 1, NULL, NULL, NULL, NULL),
(5496, 1, 1, NULL, NULL, NULL, NULL),
(5497, 1, 1, NULL, NULL, NULL, NULL),
(5498, 1, 1, NULL, NULL, NULL, NULL),
(5499, 1, 1, NULL, NULL, NULL, NULL),
(5500, 1, 1, NULL, NULL, NULL, NULL),
(5501, 1, 1, NULL, NULL, NULL, NULL),
(5502, 1, 1, NULL, NULL, NULL, NULL),
(5503, 1, 1, NULL, NULL, NULL, NULL),
(5504, 1, 1, NULL, NULL, NULL, NULL),
(5505, 1, 1, NULL, NULL, NULL, NULL),
(5506, 1, 1, NULL, NULL, NULL, NULL),
(5507, 1, 1, NULL, NULL, NULL, NULL),
(5508, 1, 1, NULL, NULL, NULL, NULL),
(5509, 1, 1, NULL, NULL, NULL, NULL),
(5510, 1, 1, NULL, NULL, NULL, NULL),
(5511, 1, 1, NULL, NULL, NULL, NULL),
(5512, 1, 1, NULL, NULL, NULL, NULL),
(5513, 1, 1, NULL, NULL, NULL, NULL),
(5514, 1, 1, NULL, NULL, NULL, NULL),
(5515, 1, 1, NULL, NULL, NULL, NULL),
(5516, 1, 1, NULL, NULL, NULL, NULL),
(5517, 1, 1, NULL, NULL, NULL, NULL),
(5518, 1, 1, NULL, NULL, NULL, NULL),
(5519, 1, 1, NULL, NULL, NULL, NULL),
(5520, 1, 1, NULL, NULL, NULL, NULL),
(5521, 1, 1, NULL, NULL, NULL, NULL),
(5522, 1, 1, NULL, NULL, NULL, NULL),
(5523, 1, 1, NULL, NULL, NULL, NULL),
(5524, 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting_options`
--

CREATE TABLE `setting_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `option_value` longtext DEFAULT NULL,
  `autoload` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_options`
--

INSERT INTO `setting_options` (`id`, `option_name`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES
(1, 'com_site_logo', '620', 1, '2025-03-10 02:09:43', '2025-04-15 08:56:49'),
(2, 'com_site_favicon', '617', 1, '2025-03-10 02:09:43', '2025-04-15 07:06:06'),
(3, 'com_site_title', 'Bravo Mart', 1, '2025-03-10 02:09:43', '2025-04-15 08:07:55'),
(4, 'com_site_subtitle', 'Shop Smart, Shop Bravo', 1, '2025-03-10 02:09:43', '2025-05-22 08:04:49'),
(5, 'com_user_email_verification', NULL, 1, '2025-03-10 02:09:43', '2025-03-10 02:09:43'),
(6, 'com_user_login_otp', NULL, 1, '2025-03-10 02:09:43', '2025-06-24 09:19:03'),
(7, 'com_maintenance_mode', 'on', 1, '2025-03-10 02:09:43', '2025-05-22 08:04:59'),
(8, 'com_site_full_address', '100 Main Street, Los Angeles', 1, '2025-03-10 02:09:44', '2025-03-25 02:29:32'),
(9, 'com_site_contact_number', '+1 (800) 555-0199', 1, '2025-03-10 02:09:44', '2025-03-25 02:29:32'),
(10, 'com_site_website_url', 'https://bravomart.bravo-soft.com', 1, '2025-03-10 02:09:44', '2025-03-25 02:31:37'),
(11, 'com_site_email', 'support@bravomart.com', 1, '2025-03-10 02:09:44', '2025-03-25 02:29:32'),
(12, 'com_site_footer_copyright', '© 2025 Bravo Mart. All Rights Reserved.', 1, '2025-03-10 02:09:44', '2025-03-25 02:29:32'),
(13, 'com_quick_access_enable_disable', 'on', 1, '2025-03-10 03:11:26', '2025-03-25 02:40:00'),
(14, 'com_our_info_enable_disable', 'on', 1, '2025-03-10 03:11:26', '2025-03-25 02:40:00'),
(15, 'com_quick_access_title', NULL, 1, '2025-03-10 03:11:26', '2025-05-19 04:08:25'),
(16, 'com_our_info_title', NULL, 1, '2025-03-10 03:11:26', '2025-05-19 04:08:25'),
(17, 'com_social_links_enable_disable', 'on', 1, '2025-03-10 03:11:26', '2025-03-25 02:40:00'),
(18, 'com_social_links_title', 'on', 1, '2025-03-10 03:11:26', '2025-03-25 02:40:00'),
(19, 'com_social_links_facebook_url', 'https://facebook.com/example', 1, '2025-03-10 03:11:26', '2025-05-18 11:59:40'),
(20, 'com_social_links_twitter_url', 'https://twitter.com/example', 1, '2025-03-10 03:11:26', '2025-05-18 11:59:40'),
(21, 'com_social_links_instagram_url', 'https://instagram.com/example', 1, '2025-03-10 03:11:26', '2025-05-18 11:59:40'),
(22, 'com_social_links_linkedin_url', 'https://linkedin.com/example', 1, '2025-03-10 03:11:26', '2025-05-18 11:59:40'),
(23, 'com_social_links_youtube_url', NULL, 1, '2025-03-10 03:11:26', '2025-05-19 04:08:25'),
(24, 'com_social_links_pinterest_url', NULL, 1, '2025-03-10 03:11:26', '2025-05-19 04:08:25'),
(25, 'com_social_links_snapchat_url', NULL, 1, '2025-03-10 03:11:26', '2025-05-19 04:08:25'),
(26, 'com_download_app_link_one', 'https://example.com/app1', 1, '2025-03-10 03:11:26', '2025-05-18 11:59:40'),
(27, 'com_download_app_link_two', 'https://example.com/app2', 1, '2025-03-10 03:11:27', '2025-05-18 11:59:40'),
(28, 'com_payment_methods_enable_disable', 'on', 1, '2025-03-10 03:11:27', '2025-04-15 11:48:47'),
(29, 'com_payment_methods_image', '734,737,732,733', 1, '2025-03-10 03:11:27', '2025-05-19 04:08:25'),
(30, 'com_site_space_between_amount_and_symbol', NULL, 1, '2025-03-12 01:00:20', '2025-03-12 01:00:20'),
(31, 'com_site_enable_disable_decimal_point', 'YES', 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(32, 'com_site_comma_form_adjustment_amount', 'YES', 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(33, 'com_site_default_currency_to_usd_exchange_rate', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(34, 'com_site_default_currency_to_myr_exchange_rate', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(35, 'com_site_default_currency_to_brl_exchange_rate', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(36, 'com_site_default_currency_to_zar_exchange_rate', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(37, 'com_site_default_currency_to_ngn_exchange_rate', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(38, 'com_site_default_currency_to_inr_exchange_rate', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(39, 'com_site_default_currency_to_idr_exchange_rate', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(40, 'com_site_euro_to_ngn_exchange_rate', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(41, 'com_site_usd_to_ngn_exchange_rate', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(42, 'com_site_default_payment_gateway', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(43, 'com_site_manual_payment_description', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(44, 'com_site_manual_payment_name', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(45, 'com_site_payment_gateway', NULL, 1, '2025-03-12 01:00:21', '2025-03-12 01:00:21'),
(46, 'com_site_currency_symbol_position', 'left', 1, '2025-03-12 01:00:21', '2025-04-20 03:11:07'),
(47, 'com_site_global_currency', 'USD', 1, '2025-03-12 01:00:21', '2025-04-19 11:48:16'),
(48, 'com_register_page_title', 'Sign Up Now!', 1, '2025-03-17 22:20:27', '2025-03-18 22:18:26'),
(49, 'com_register_page_subtitle', 'Join Bravo for an Amazing Shopping Experience', 1, '2025-03-17 22:20:27', '2025-03-18 22:18:26'),
(50, 'com_register_page_description', 'Sign up now to explore a wide range of products from multiple stores, enjoy seamless shopping, secure transactions, and exclusive discounts.', 1, '2025-03-17 22:20:27', '2025-03-18 22:18:26'),
(51, 'com_register_page_image', '501', 1, '2025-03-17 22:20:27', '2025-03-18 22:33:32'),
(52, 'com_register_page_terms_page', NULL, 1, '2025-03-17 22:20:27', '2025-03-18 22:18:26'),
(53, 'com_register_page_terms_title', 'Terms & Conditions', 1, '2025-03-17 22:20:27', '2025-03-18 22:18:27'),
(54, 'com_register_page_social_enable_disable', 'on', 1, '2025-03-17 22:20:27', '2025-03-18 22:18:27'),
(55, 'com_login_page_title', 'Sign In', 1, '2025-03-18 00:12:53', '2025-03-18 22:22:25'),
(56, 'com_login_page_subtitle', 'Continue Shopping', 1, '2025-03-18 00:12:53', '2025-03-19 02:21:22'),
(57, 'com_login_page_image', '501', 1, '2025-03-18 00:12:53', '2025-03-18 22:31:52'),
(58, 'com_login_page_social_enable_disable', 'on', 1, '2025-03-18 00:12:53', '2025-05-22 10:08:03'),
(59, 'com_product_details_page_delivery_title', 'Free Delivery', 1, '2025-03-18 00:42:42', '2025-03-18 22:38:07'),
(60, 'com_product_details_page_delivery_subtitle', 'Will ship to Bangladesh. Read item description.', 1, '2025-03-18 00:42:42', '2025-03-18 22:36:12'),
(61, 'com_product_details_page_delivery_url', NULL, 1, '2025-03-18 00:42:42', '2025-03-18 23:12:23'),
(62, 'com_product_details_page_delivery_enable_disable', 'on', 1, '2025-03-18 00:42:42', '2025-03-18 00:42:42'),
(63, 'com_product_details_page_return_refund_title', 'Easy Return & Refund', 1, '2025-03-18 00:42:42', '2025-03-18 22:36:12'),
(64, 'com_product_details_page_return_refund_subtitle', '30 days returns. Buyer pays for return shipping.', 1, '2025-03-18 00:42:42', '2025-03-18 22:36:13'),
(65, 'com_product_details_page_return_refund_url', 'fb.com', 1, '2025-03-18 00:42:42', '2025-03-18 22:36:13'),
(66, 'com_product_details_page_return_refund_enable_disable', 'on', 1, '2025-03-18 00:42:42', '2025-03-18 00:42:42'),
(67, 'com_product_details_page_related_title', 'Related Product', 1, '2025-03-18 00:42:42', '2025-04-13 04:46:05'),
(68, 'com_blog_details_popular_title', NULL, 1, '2025-03-18 20:42:56', '2025-06-15 06:52:47'),
(69, 'com_blog_details_related_title', NULL, 1, '2025-03-18 20:42:56', '2025-06-15 06:52:47'),
(70, 'com_seller_login_page_title', 'Sign in to Bravo Mart Account', 1, '2025-03-18 22:31:53', '2025-04-06 02:33:15'),
(71, 'com_seller_login_page_subtitle', 'Sign in to oversee your multivendor ecosystem.', 1, '2025-03-18 22:31:53', '2025-04-06 02:33:15'),
(72, 'com_seller_login_page_image', '570', 1, '2025-03-18 22:31:53', '2025-04-06 02:27:49'),
(73, 'com_seller_login_page_social_enable_disable', NULL, 1, '2025-03-18 22:31:53', '2025-04-05 23:13:40'),
(74, 'minimum_withdrawal_limit', '10', 1, '2025-03-20 02:32:30', '2025-05-15 03:39:44'),
(75, 'maximum_withdrawal_limit', '500', 1, '2025-03-20 02:32:30', '2025-05-15 03:39:44'),
(76, 'com_quick_access', '[{\"com_quick_access_title\":\"Home\",\"com_quick_access_url\":\"https:\\/\\/example.com 666\"},{\"com_quick_access_title\":\"About Us\",\"com_quick_access_url\":\"https:\\/\\/example.com\\/contact777\"},{\"com_quick_access_title\":\"Contact Us\",\"com_quick_access_url\":\"https:\\/\\/example.com\\/contact777\"},{\"com_quick_access_title\":\"Blog\",\"com_quick_access_url\":null},{\"com_quick_access_title\":\"Coupon\",\"com_quick_access_url\":null},{\"com_quick_access_title\":\"Become A Seller\",\"com_quick_access_url\":\"http:\\/\\/192.168.88.225:3000\\/become-a-seller\"}]', 1, '2025-03-25 02:40:00', '2025-05-19 07:03:08'),
(77, 'com_our_info', '[{\"title\":\"Privacy Policy\",\"url\":\"http:\\/\\/192.168.88.225:3010\\/privacy-policy\"},{\"title\":\"Terms and conditions\",\"url\":\"http:\\/\\/192.168.88.225:3010\\/terms-conditions\"},{\"title\":\"FAQ\",\"url\":\"http:\\/\\/192.168.88.225:3010\\/faq\"}]', 1, '2025-03-25 02:45:25', '2025-05-19 05:09:50'),
(78, 'com_google_login_enabled', 'on', 1, '2025-04-06 03:15:05', '2025-05-22 10:13:28'),
(79, 'com_google_app_id', '483247466424-makrg9bs86r4vup300m3p3r63tpaa9v0.apps.googleusercontent.com', 1, '2025-04-06 03:15:05', '2025-04-06 03:15:05'),
(80, 'com_google_client_secret', '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', 1, '2025-04-06 03:15:05', '2025-04-06 03:15:05'),
(81, 'com_google_client_callback_url', 'https://bravomartapi.bravo-soft.com/api/v1/auth/google/callback', 1, '2025-04-06 03:15:05', '2025-04-06 03:37:08'),
(82, 'com_facebook_login_enabled', 'on', 1, '2025-04-06 03:15:05', '2025-05-22 10:13:28'),
(83, 'com_facebook_app_id', '657727896942404', 1, '2025-04-06 03:15:05', '2025-04-06 03:35:17'),
(84, 'com_facebook_client_secret', '036cf21cc49f37f130e6ee1a99f334b4', 1, '2025-04-06 03:15:05', '2025-04-06 03:35:17'),
(85, 'com_facebook_client_callback_url', 'https://bravomartapi.bravo-soft.com/api/v1/auth/facebook/callback', 1, '2025-04-06 03:15:05', '2025-04-06 03:37:08'),
(86, 'com_site_white_logo', '621', 1, '2025-04-15 06:26:53', '2025-04-15 08:56:49'),
(87, 'com_site_global_email', 'bravomart@gmail.com', 1, '2025-04-16 04:54:09', '2025-04-16 04:54:09'),
(88, 'com_site_smtp_mail_mailer', 'smtp', 1, '2025-04-16 04:54:09', '2025-04-16 04:54:09'),
(89, 'com_site_smtp_mail_host', 'sandbox.smtp.mailtrap.io', 1, '2025-04-16 04:54:09', '2025-04-16 04:54:09'),
(90, 'com_site_smtp_mail_post', '587', 1, '2025-04-16 04:54:09', '2025-04-16 05:05:27'),
(91, 'com_site_smtp_mail_username', '77df523ed856b8', 1, '2025-04-16 04:54:09', '2025-06-02 09:13:45'),
(92, 'com_site_smtp_mail_password', 'de1975454a18e2', 1, '2025-04-16 04:54:09', '2025-06-02 09:13:45'),
(93, 'com_site_smtp_mail_encryption', 'tls', 1, '2025-04-16 04:54:09', '2025-04-16 05:02:55'),
(94, 'max_deposit_per_transaction', '50000', 1, '2025-04-29 09:30:49', '2025-05-06 05:04:08'),
(95, 'com_maintenance_title', 'We’ll Be Back Soon!', 1, '2025-04-30 09:08:32', '2025-05-25 08:12:26'),
(96, 'com_maintenance_description', 'Our website is currently undergoing scheduled maintenance.\r\nWe’re working hard to bring everything back online as quickly as possible.\r\nThank you for your patience and understanding.', 1, '2025-04-30 09:08:32', '2025-05-25 08:12:26'),
(97, 'com_maintenance_start_date', '2025-04-19T18:00:00.000Z', 1, '2025-04-30 09:08:32', '2025-06-18 03:12:41'),
(98, 'com_maintenance_end_date', '2025-04-19T18:00:00.000Z', 1, '2025-04-30 09:08:32', '2025-06-18 03:12:41'),
(99, 'com_maintenance_image', '832', 1, '2025-04-30 09:08:32', '2025-05-25 07:15:34'),
(100, 'com_meta_title', 'Bravo Mart', 1, '2025-04-30 09:44:21', '2025-04-30 09:44:21'),
(101, 'com_meta_description', 'Bravo Mart', 1, '2025-04-30 09:44:21', '2025-04-30 09:44:21'),
(102, 'com_meta_tags', 'Bravo Mart', 1, '2025-04-30 09:44:21', '2025-05-22 09:49:27'),
(103, 'com_canonical_url', NULL, 1, '2025-04-30 09:44:21', '2025-05-22 09:49:27'),
(104, 'com_og_title', 'Bravo Mart', 1, '2025-04-30 09:44:21', '2025-04-30 09:44:21'),
(105, 'com_og_description', 'Bravo Mart', 1, '2025-04-30 09:44:21', '2025-04-30 09:44:21'),
(106, 'com_og_image', '663', 1, '2025-04-30 09:44:21', '2025-04-30 09:44:21'),
(107, 'com_google_recaptcha_v3_site_key', '1x00000000000000000000AA', 1, '2025-05-12 06:06:26', '2025-05-29 03:40:55'),
(108, 'com_google_recaptcha_v3_secret_key', '6LceTzYrAAAAACtNGBaKKcgEloInr_CDci7jwzm6', 1, '2025-05-12 06:06:26', '2025-05-12 06:06:26'),
(109, 'com_google_recaptcha_enable_disable', 'on', 1, '2025-05-12 06:06:26', '2025-05-12 07:06:40'),
(110, 'com_help_center_enable_disable', NULL, 1, '2025-05-15 10:35:15', '2025-05-19 04:08:25'),
(111, 'com_help_center_title', NULL, 1, '2025-05-19 06:20:41', '2025-05-19 06:20:41'),
(112, 'com_help_center', '[{\"title\":\"Payments\",\"url\":\"fdsf\"},{\"title\":\"Shipping\",\"url\":\"ddsf\"},{\"title\":\"Return Policy\",\"url\":null}]', 1, '2025-05-19 06:20:41', '2025-05-19 07:01:42'),
(113, 'com_google_map_enable_disable', 'on', 1, '2025-05-22 09:52:16', '2025-05-25 06:05:08'),
(114, 'com_google_map_api_key', 'AIzaSyDiXtMtd2RjwKX7WJIajejDn1c5oNAvrm4', 1, '2025-05-22 09:52:16', '2025-05-25 06:02:54'),
(115, 'com_home_one_category_button_title', 'All Categories', 1, '2025-06-15 06:30:05', '2025-06-15 11:06:58'),
(116, 'com_home_one_store_button_title', 'Explore Store Types', 1, '2025-06-15 06:30:05', '2025-06-15 11:06:58'),
(117, 'com_home_one_category_section_title', 'Shop by Categories', 1, '2025-06-15 06:30:05', '2025-06-15 07:00:04'),
(118, 'com_home_one_flash_sale_section_title', 'Flash Sale', 1, '2025-06-15 06:30:05', '2025-06-15 07:00:04'),
(119, 'com_home_one_featured_section_title', 'Featured', 1, '2025-06-15 06:30:05', '2025-06-15 07:01:58'),
(120, 'com_home_one_top_selling_section_title', 'Top Selling', 1, '2025-06-15 06:30:05', '2025-06-15 07:00:04'),
(121, 'com_home_one_latest_product_section_title', 'Latest Essentials', 1, '2025-06-15 06:30:05', '2025-06-15 07:00:04'),
(122, 'com_home_one_popular_product_section_title', 'Popular Product', 1, '2025-06-15 06:30:05', '2025-06-15 07:00:04'),
(123, 'com_home_one_top_store_section_title', 'Top Store Collections', 1, '2025-06-15 06:30:05', '2025-06-15 07:00:04'),
(124, 'otp_login_enabled_disable', 'on', 1, '2025-06-23 04:47:50', '2025-06-24 09:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `platform` enum('web','mobile') NOT NULL DEFAULT 'web',
  `title` varchar(255) NOT NULL,
  `title_color` varchar(255) DEFAULT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `sub_title_color` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `description_color` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bg_image` varchar(255) DEFAULT NULL,
  `bg_color` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_text_color` varchar(255) DEFAULT NULL,
  `button_bg_color` varchar(255) DEFAULT NULL,
  `button_hover_color` varchar(255) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `redirect_url` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 - Inactive, 1 - Active',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_providers`
--

CREATE TABLE `sms_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `expire_time` int(11) NOT NULL DEFAULT 1,
  `credentials` longtext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Inactive, 1: Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_providers`
--

INSERT INTO `sms_providers` (`id`, `name`, `slug`, `logo`, `expire_time`, `credentials`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nexmo', 'nexmo', NULL, 5, '{\"nexmo_api_key\":\"d008d407\",\"nexmo_api_secret\":\"HvMKGiT0CjvZqJgT\"}', 0, NULL, '2025-06-24 11:58:28'),
(2, 'Twilio', 'twilio', NULL, 5, '{\"twilio_sid\":\"ACd9b1fe3992f74b20008f7d6a5962f883\",\"twilio_auth_key\":\"fd536f87af14b0d769220b1859f9b4ff\",\"twilio_number\":\"+16206661971\"}', 1, NULL, '2025-06-24 11:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`, `timezone`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Osaka', 6, 'Europe/Ulyanovsk', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(2, 'Osaka', 29, 'Asia/Novosibirsk', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(3, 'Osaka', 28, 'Europe/Tallinn', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(4, 'Osaka', 12, 'Antarctica/Davis', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(5, 'Osaka', 5, 'Asia/Novokuznetsk', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(6, 'Osaka', 85, 'Europe/Bucharest', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(7, 'Osaka', 33, 'America/Argentina/Ushuaia', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(8, 'Osaka', 96, 'America/Kralendijk', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(9, 'Osaka', 60, 'Africa/Nouakchott', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(10, 'Osaka', 60, 'Australia/Darwin', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(11, 'Osaka', 19, 'Europe/Vienna', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(12, 'Osaka', 27, 'Africa/Ouagadougou', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(13, 'Osaka', 46, 'Africa/Accra', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(14, 'Osaka', 97, 'America/Atikokan', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(15, 'Osaka', 61, 'Asia/Thimphu', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(16, 'Osaka', 28, 'America/Paramaribo', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(17, 'Osaka', 33, 'America/Toronto', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(18, 'Osaka', 40, 'Africa/Maputo', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(19, 'Osaka', 27, 'Asia/Tbilisi', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(20, 'Osaka', 93, 'America/Asuncion', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(21, 'Osaka', 83, 'America/Grenada', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(22, 'Osaka', 69, 'Africa/Cairo', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(23, 'Osaka', 93, 'Pacific/Galapagos', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(24, 'Osaka', 8, 'Europe/San_Marino', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(25, 'Osaka', 37, 'America/Paramaribo', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(26, 'Osaka', 69, 'America/St_Lucia', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(27, 'Osaka', 50, 'America/Boa_Vista', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(28, 'Osaka', 93, 'Atlantic/Canary', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(29, 'Osaka', 65, 'America/Guayaquil', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(30, 'Osaka', 6, 'Asia/Ulaanbaatar', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(31, 'Osaka', 65, 'Asia/Tokyo', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(32, 'Osaka', 68, 'America/Nome', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(33, 'Osaka', 52, 'Asia/Hovd', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(34, 'Osaka', 84, 'America/Grand_Turk', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(35, 'Osaka', 92, 'Asia/Jakarta', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(36, 'Osaka', 78, 'Africa/Gaborone', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(37, 'Osaka', 85, 'Europe/Busingen', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(38, 'Osaka', 70, 'Europe/Bratislava', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(39, 'Osaka', 70, 'Asia/Dhaka', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(40, 'Osaka', 9, 'Pacific/Midway', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(41, 'Osaka', 59, 'Australia/Adelaide', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(42, 'Osaka', 61, 'Europe/Brussels', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(43, 'Osaka', 59, 'America/St_Lucia', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(44, 'Osaka', 69, 'America/Chihuahua', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(45, 'Osaka', 28, 'America/Argentina/La_Rioja', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(46, 'Osaka', 96, 'Europe/Ulyanovsk', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(47, 'Osaka', 80, 'Asia/Singapore', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(48, 'Osaka', 28, 'Asia/Aqtobe', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(49, 'Osaka', 79, 'Asia/Kuching', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(50, 'Osaka', 85, 'Asia/Singapore', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(51, 'Osaka', 46, 'America/St_Kitts', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(52, 'Osaka', 18, 'America/Toronto', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(53, 'Osaka', 77, 'Asia/Thimphu', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(54, 'Osaka', 89, 'America/St_Barthelemy', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(55, 'Osaka', 88, 'America/Yakutat', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(56, 'Osaka', 83, 'Europe/Astrakhan', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(57, 'Osaka', 53, 'Asia/Aden', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(58, 'Osaka', 60, 'Europe/Madrid', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(59, 'Osaka', 21, 'America/New_York', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(60, 'Osaka', 88, 'Asia/Singapore', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(61, 'Osaka', 53, 'Asia/Nicosia', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(62, 'Osaka', 33, 'Africa/Malabo', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(63, 'Osaka', 89, 'Europe/Warsaw', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(64, 'Osaka', 97, 'Indian/Mauritius', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(65, 'Osaka', 77, 'Asia/Kathmandu', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(66, 'Osaka', 81, 'Africa/Bamako', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(67, 'Osaka', 70, 'Africa/Ouagadougou', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(68, 'Osaka', 91, 'Europe/Lisbon', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(69, 'Osaka', 88, 'Asia/Ho_Chi_Minh', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(70, 'Osaka', 28, 'Africa/Lagos', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(71, 'Osaka', 59, 'Asia/Qatar', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(72, 'Osaka', 6, 'America/Tegucigalpa', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(73, 'Osaka', 65, 'Atlantic/Canary', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(74, 'Osaka', 14, 'America/Goose_Bay', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(75, 'Osaka', 75, 'America/Chicago', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(76, 'Osaka', 12, 'America/Argentina/Cordoba', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(77, 'Osaka', 36, 'Pacific/Guadalcanal', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(78, 'Osaka', 30, 'Africa/Djibouti', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(79, 'Osaka', 36, 'Asia/Dushanbe', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(80, 'Osaka', 23, 'America/Panama', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(81, 'Osaka', 84, 'Asia/Ashgabat', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(82, 'Osaka', 7, 'America/North_Dakota/New_Salem', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(83, 'Osaka', 13, 'Europe/Warsaw', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(84, 'Osaka', 100, 'America/Jamaica', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(85, 'Osaka', 96, 'Europe/Dublin', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(86, 'Osaka', 78, 'America/Chihuahua', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(87, 'Osaka', 27, 'America/Metlakatla', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(88, 'Osaka', 56, 'Asia/Urumqi', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(89, 'Osaka', 29, 'Europe/Monaco', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(90, 'Osaka', 82, 'America/Grenada', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(91, 'Osaka', 13, 'Asia/Tomsk', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(92, 'Osaka', 66, 'Europe/London', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(93, 'Osaka', 77, 'America/Detroit', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(94, 'Osaka', 84, 'America/Creston', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(95, 'Osaka', 51, 'Antarctica/Mawson', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(96, 'Osaka', 94, 'Pacific/Tahiti', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(97, 'Osaka', 74, 'Asia/Famagusta', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(98, 'Osaka', 39, 'Europe/Ulyanovsk', 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(99, 'Osaka', 92, 'Pacific/Tongatapu', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(100, 'Osaka', 62, 'America/Kentucky/Louisville', 0, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(101, 'Uttar Pradesh', 47, 'Africa/Niamey', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(102, 'Uttar Pradesh', 199, 'Africa/Kampala', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(103, 'Uttar Pradesh', 87, 'America/Recife', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(104, 'Uttar Pradesh', 192, 'Africa/Sao_Tome', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(105, 'Uttar Pradesh', 108, 'America/Atikokan', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(106, 'Uttar Pradesh', 158, 'America/Montserrat', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(107, 'Uttar Pradesh', 189, 'Asia/Jerusalem', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(108, 'Uttar Pradesh', 158, 'America/Cuiaba', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(109, 'Uttar Pradesh', 57, 'America/Argentina/Salta', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(110, 'Uttar Pradesh', 185, 'America/Boa_Vista', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(111, 'Uttar Pradesh', 172, 'America/El_Salvador', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(112, 'Uttar Pradesh', 82, 'America/Argentina/Rio_Gallegos', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(113, 'Uttar Pradesh', 31, 'America/Argentina/Tucuman', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(114, 'Uttar Pradesh', 153, 'Asia/Brunei', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(115, 'Uttar Pradesh', 76, 'Africa/Accra', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(116, 'Uttar Pradesh', 59, 'Africa/Nouakchott', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(117, 'Uttar Pradesh', 77, 'Asia/Aden', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(118, 'Uttar Pradesh', 107, 'Pacific/Tahiti', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(119, 'Uttar Pradesh', 159, 'Europe/Isle_of_Man', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(120, 'Uttar Pradesh', 91, 'Asia/Urumqi', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(121, 'Uttar Pradesh', 10, 'Africa/Brazzaville', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(122, 'Uttar Pradesh', 100, 'Africa/Lubumbashi', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(123, 'Uttar Pradesh', 85, 'America/Cambridge_Bay', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(124, 'Uttar Pradesh', 161, 'Europe/Paris', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(125, 'Uttar Pradesh', 121, 'Europe/Podgorica', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(126, 'Uttar Pradesh', 167, 'Europe/Kirov', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(127, 'Uttar Pradesh', 5, 'Africa/Ouagadougou', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(128, 'Uttar Pradesh', 133, 'Asia/Beirut', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(129, 'Uttar Pradesh', 14, 'Australia/Lindeman', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(130, 'Uttar Pradesh', 138, 'Pacific/Easter', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(131, 'Uttar Pradesh', 165, 'Indian/Chagos', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(132, 'Uttar Pradesh', 142, 'Pacific/Majuro', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(133, 'Uttar Pradesh', 73, 'America/Cayman', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(134, 'Uttar Pradesh', 108, 'Europe/Berlin', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(135, 'Uttar Pradesh', 11, 'Europe/Bucharest', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(136, 'Uttar Pradesh', 76, 'America/Montevideo', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(137, 'Uttar Pradesh', 108, 'America/Juneau', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(138, 'Uttar Pradesh', 163, 'Asia/Jerusalem', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(139, 'Uttar Pradesh', 68, 'Europe/Athens', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(140, 'Uttar Pradesh', 92, 'America/Dominica', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(141, 'Uttar Pradesh', 15, 'America/Mexico_City', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(142, 'Uttar Pradesh', 70, 'Antarctica/Rothera', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(143, 'Uttar Pradesh', 50, 'Atlantic/Stanley', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(144, 'Uttar Pradesh', 30, 'Asia/Yerevan', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(145, 'Uttar Pradesh', 109, 'Africa/Bangui', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(146, 'Uttar Pradesh', 6, 'America/Paramaribo', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(147, 'Uttar Pradesh', 104, 'Indian/Christmas', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(148, 'Uttar Pradesh', 131, 'Africa/Ceuta', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(149, 'Uttar Pradesh', 123, 'Europe/Oslo', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(150, 'Uttar Pradesh', 104, 'America/Cancun', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(151, 'Uttar Pradesh', 111, 'Asia/Kathmandu', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(152, 'Uttar Pradesh', 62, 'America/Mexico_City', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(153, 'Uttar Pradesh', 69, 'America/Inuvik', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(154, 'Uttar Pradesh', 163, 'Pacific/Kanton', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(155, 'Uttar Pradesh', 88, 'Pacific/Noumea', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(156, 'Uttar Pradesh', 59, 'Europe/Madrid', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(157, 'Uttar Pradesh', 188, 'Africa/Malabo', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(158, 'Uttar Pradesh', 58, 'America/Argentina/Tucuman', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(159, 'Uttar Pradesh', 175, 'America/Nome', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(160, 'Uttar Pradesh', 5, 'America/Indiana/Marengo', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(161, 'Uttar Pradesh', 134, 'America/Montserrat', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(162, 'Uttar Pradesh', 78, 'Asia/Samarkand', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(163, 'Uttar Pradesh', 48, 'Africa/Nairobi', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(164, 'Uttar Pradesh', 78, 'Pacific/Noumea', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(165, 'Uttar Pradesh', 103, 'America/Bahia', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(166, 'Uttar Pradesh', 197, 'Africa/Johannesburg', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(167, 'Uttar Pradesh', 148, 'America/New_York', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(168, 'Uttar Pradesh', 63, 'Europe/Prague', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(169, 'Uttar Pradesh', 79, 'America/Argentina/Catamarca', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(170, 'Uttar Pradesh', 134, 'Indian/Mayotte', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(171, 'Uttar Pradesh', 95, 'Europe/Volgograd', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(172, 'Uttar Pradesh', 164, 'Africa/Algiers', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(173, 'Uttar Pradesh', 4, 'Pacific/Bougainville', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(174, 'Uttar Pradesh', 83, 'Africa/Bamako', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(175, 'Uttar Pradesh', 161, 'Antarctica/Casey', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(176, 'Uttar Pradesh', 128, 'America/Danmarkshavn', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(177, 'Uttar Pradesh', 32, 'Asia/Seoul', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(178, 'Uttar Pradesh', 32, 'America/Paramaribo', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(179, 'Uttar Pradesh', 187, 'Europe/Isle_of_Man', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(180, 'Uttar Pradesh', 111, 'America/Denver', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(181, 'Uttar Pradesh', 86, 'Pacific/Norfolk', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(182, 'Uttar Pradesh', 37, 'Europe/Chisinau', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(183, 'Uttar Pradesh', 29, 'America/Argentina/Mendoza', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(184, 'Uttar Pradesh', 99, 'Asia/Vientiane', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(185, 'Uttar Pradesh', 89, 'Pacific/Pitcairn', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(186, 'Uttar Pradesh', 66, 'America/Danmarkshavn', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(187, 'Uttar Pradesh', 63, 'Asia/Jayapura', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(188, 'Uttar Pradesh', 74, 'Asia/Dubai', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(189, 'Uttar Pradesh', 89, 'America/Vancouver', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(190, 'Uttar Pradesh', 59, 'Europe/Warsaw', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(191, 'Uttar Pradesh', 113, 'America/Port_of_Spain', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(192, 'Uttar Pradesh', 86, 'America/Paramaribo', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(193, 'Uttar Pradesh', 62, 'Africa/Khartoum', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(194, 'Uttar Pradesh', 140, 'Europe/Brussels', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(195, 'Uttar Pradesh', 140, 'Asia/Yangon', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(196, 'Uttar Pradesh', 119, 'Africa/Ouagadougou', 0, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(197, 'Uttar Pradesh', 4, 'Europe/Andorra', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(198, 'Uttar Pradesh', 133, 'America/Glace_Bay', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(199, 'Uttar Pradesh', 182, 'Pacific/Chuuk', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(200, 'Uttar Pradesh', 33, 'America/Martinique', 1, '2025-04-23 09:11:41', '2025-04-23 09:11:41'),
(201, 'Pernambuco', 35, 'America/Kentucky/Louisville', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(202, 'Pernambuco', 72, 'America/Marigot', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(203, 'Pernambuco', 35, 'Pacific/Chatham', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(204, 'Pernambuco', 233, 'Pacific/Bougainville', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(205, 'Pernambuco', 129, 'America/Recife', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(206, 'Pernambuco', 233, 'Pacific/Rarotonga', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(207, 'Pernambuco', 292, 'America/Argentina/Salta', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(208, 'Pernambuco', 116, 'America/Resolute', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(209, 'Pernambuco', 99, 'Asia/Makassar', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(210, 'Pernambuco', 228, 'America/Panama', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(211, 'Pernambuco', 20, 'Europe/Vilnius', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(212, 'Pernambuco', 212, 'America/Indiana/Marengo', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(213, 'Pernambuco', 180, 'Africa/Mbabane', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(214, 'Pernambuco', 89, 'Asia/Karachi', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(215, 'Pernambuco', 296, 'America/Aruba', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(216, 'Pernambuco', 66, 'Indian/Mahe', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(217, 'Pernambuco', 27, 'Europe/Istanbul', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(218, 'Pernambuco', 154, 'America/Merida', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(219, 'Pernambuco', 182, 'America/Nassau', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(220, 'Pernambuco', 94, 'Asia/Seoul', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(221, 'Pernambuco', 158, 'Antarctica/Mawson', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(222, 'Pernambuco', 58, 'America/Goose_Bay', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(223, 'Pernambuco', 158, 'Indian/Kerguelen', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(224, 'Pernambuco', 23, 'Europe/Gibraltar', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(225, 'Pernambuco', 95, 'Europe/Skopje', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(226, 'Pernambuco', 300, 'Africa/Ndjamena', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(227, 'Pernambuco', 257, 'Asia/Dhaka', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(228, 'Pernambuco', 26, 'America/Menominee', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(229, 'Pernambuco', 44, 'America/Indiana/Indianapolis', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(230, 'Pernambuco', 77, 'America/Tijuana', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(231, 'Pernambuco', 158, 'Europe/Mariehamn', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(232, 'Pernambuco', 238, 'Asia/Karachi', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(233, 'Pernambuco', 213, 'America/Kentucky/Monticello', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(234, 'Pernambuco', 275, 'Australia/Eucla', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(235, 'Pernambuco', 231, 'America/Asuncion', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(236, 'Pernambuco', 235, 'Asia/Nicosia', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(237, 'Pernambuco', 145, 'Indian/Mauritius', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(238, 'Pernambuco', 232, 'America/North_Dakota/Center', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(239, 'Pernambuco', 245, 'Pacific/Honolulu', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(240, 'Pernambuco', 141, 'Asia/Beirut', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(241, 'Pernambuco', 279, 'Indian/Mayotte', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(242, 'Pernambuco', 45, 'Africa/Gaborone', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(243, 'Pernambuco', 295, 'America/St_Thomas', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(244, 'Pernambuco', 173, 'Europe/Luxembourg', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(245, 'Pernambuco', 196, 'Asia/Tbilisi', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(246, 'Pernambuco', 289, 'Europe/Rome', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(247, 'Pernambuco', 297, 'America/Chihuahua', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(248, 'Pernambuco', 254, 'Europe/Rome', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(249, 'Pernambuco', 120, 'Pacific/Tarawa', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(250, 'Pernambuco', 87, 'Europe/Berlin', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(251, 'Pernambuco', 144, 'America/Dawson', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(252, 'Pernambuco', 46, 'America/St_Johns', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(253, 'Pernambuco', 83, 'Africa/Mbabane', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(254, 'Pernambuco', 97, 'America/Argentina/Buenos_Aires', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(255, 'Pernambuco', 254, 'Africa/Porto-Novo', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(256, 'Pernambuco', 259, 'Africa/Monrovia', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(257, 'Pernambuco', 34, 'Africa/Brazzaville', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(258, 'Pernambuco', 9, 'America/St_Lucia', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(259, 'Pernambuco', 152, 'America/Lower_Princes', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(260, 'Pernambuco', 179, 'Africa/Accra', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(261, 'Pernambuco', 6, 'Europe/Helsinki', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(262, 'Pernambuco', 50, 'Africa/Kigali', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(263, 'Pernambuco', 105, 'Europe/Amsterdam', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(264, 'Pernambuco', 288, 'America/Argentina/Buenos_Aires', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(265, 'Pernambuco', 211, 'Indian/Maldives', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(266, 'Pernambuco', 204, 'Asia/Taipei', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(267, 'Pernambuco', 68, 'Africa/Douala', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(268, 'Pernambuco', 172, 'Europe/Mariehamn', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(269, 'Pernambuco', 293, 'Antarctica/Syowa', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(270, 'Pernambuco', 174, 'Europe/Stockholm', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(271, 'Pernambuco', 190, 'Africa/Tripoli', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(272, 'Pernambuco', 225, 'Antarctica/Palmer', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(273, 'Pernambuco', 141, 'America/Guyana', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(274, 'Pernambuco', 13, 'Europe/Kirov', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(275, 'Pernambuco', 282, 'Pacific/Fiji', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(276, 'Pernambuco', 157, 'UTC', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(277, 'Pernambuco', 51, 'America/Araguaina', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(278, 'Pernambuco', 204, 'Africa/Johannesburg', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(279, 'Pernambuco', 12, 'America/Kentucky/Louisville', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(280, 'Pernambuco', 43, 'Asia/Khandyga', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(281, 'Pernambuco', 205, 'Asia/Baku', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(282, 'Pernambuco', 168, 'Africa/Cairo', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(283, 'Pernambuco', 48, 'Europe/Andorra', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(284, 'Pernambuco', 233, 'Atlantic/South_Georgia', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(285, 'Pernambuco', 203, 'America/Campo_Grande', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(286, 'Pernambuco', 167, 'Europe/Sarajevo', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(287, 'Pernambuco', 291, 'Europe/Warsaw', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(288, 'Pernambuco', 109, 'America/North_Dakota/New_Salem', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(289, 'Pernambuco', 29, 'Africa/Freetown', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(290, 'Pernambuco', 142, 'America/Mexico_City', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(291, 'Pernambuco', 195, 'Asia/Makassar', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(292, 'Pernambuco', 30, 'Asia/Aqtau', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(293, 'Pernambuco', 187, 'America/Argentina/Buenos_Aires', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(294, 'Pernambuco', 50, 'Pacific/Pago_Pago', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(295, 'Pernambuco', 43, 'Europe/Istanbul', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(296, 'Pernambuco', 214, 'America/Juneau', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(297, 'Pernambuco', 202, 'America/Argentina/Jujuy', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(298, 'Pernambuco', 100, 'Africa/Lusaka', 0, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(299, 'Pernambuco', 90, 'Antarctica/Mawson', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(300, 'Pernambuco', 118, 'Asia/Urumqi', 1, '2025-04-23 09:12:06', '2025-04-23 09:12:06'),
(301, 'Northern Cape', 309, 'Asia/Tehran', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(302, 'Northern Cape', 225, 'Asia/Baku', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(303, 'Northern Cape', 355, 'America/Goose_Bay', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(304, 'Northern Cape', 177, 'Pacific/Guam', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(305, 'Northern Cape', 289, 'America/Swift_Current', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(306, 'Northern Cape', 332, 'Pacific/Galapagos', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(307, 'Northern Cape', 142, 'Africa/Ndjamena', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(308, 'Northern Cape', 277, 'Indian/Christmas', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(309, 'Northern Cape', 161, 'America/Argentina/San_Juan', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(310, 'Northern Cape', 379, 'Africa/Porto-Novo', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(311, 'Northern Cape', 294, 'America/Hermosillo', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(312, 'Northern Cape', 305, 'America/Menominee', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(313, 'Northern Cape', 269, 'America/Mexico_City', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(314, 'Northern Cape', 215, 'America/Guyana', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(315, 'Northern Cape', 36, 'America/Belize', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(316, 'Northern Cape', 189, 'America/Dawson_Creek', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(317, 'Northern Cape', 252, 'Asia/Atyrau', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(318, 'Northern Cape', 363, 'America/Anguilla', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(319, 'Northern Cape', 288, 'America/Campo_Grande', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(320, 'Northern Cape', 270, 'Pacific/Palau', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(321, 'Northern Cape', 373, 'Asia/Urumqi', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(322, 'Northern Cape', 152, 'Asia/Khandyga', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(323, 'Northern Cape', 146, 'Pacific/Tahiti', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(324, 'Northern Cape', 274, 'America/Asuncion', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(325, 'Northern Cape', 207, 'Asia/Novokuznetsk', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(326, 'Northern Cape', 48, 'America/Metlakatla', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(327, 'Northern Cape', 257, 'America/Halifax', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(328, 'Northern Cape', 263, 'Australia/Darwin', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(329, 'Northern Cape', 8, 'Asia/Taipei', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(330, 'Northern Cape', 370, 'America/Argentina/Catamarca', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(331, 'Northern Cape', 144, 'Africa/Niamey', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(332, 'Northern Cape', 344, 'America/Vancouver', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(333, 'Northern Cape', 96, 'Asia/Krasnoyarsk', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(334, 'Northern Cape', 208, 'Europe/Vilnius', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(335, 'Northern Cape', 294, 'Asia/Jakarta', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(336, 'Northern Cape', 242, 'America/Los_Angeles', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(337, 'Northern Cape', 112, 'Africa/Gaborone', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(338, 'Northern Cape', 65, 'America/Recife', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(339, 'Northern Cape', 344, 'Asia/Dubai', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(340, 'Northern Cape', 138, 'Europe/Bucharest', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(341, 'Northern Cape', 68, 'Europe/Ulyanovsk', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(342, 'Northern Cape', 354, 'Asia/Irkutsk', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(343, 'Northern Cape', 204, 'Asia/Karachi', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(344, 'Northern Cape', 122, 'Asia/Tashkent', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(345, 'Northern Cape', 341, 'Asia/Almaty', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(346, 'Northern Cape', 258, 'Africa/Tunis', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(347, 'Northern Cape', 155, 'America/Argentina/La_Rioja', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(348, 'Northern Cape', 172, 'Atlantic/Faroe', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(349, 'Northern Cape', 269, 'Asia/Hebron', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(350, 'Northern Cape', 262, 'Pacific/Midway', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(351, 'Northern Cape', 265, 'America/Atikokan', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(352, 'Northern Cape', 73, 'Asia/Hovd', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(353, 'Northern Cape', 187, 'Antarctica/Rothera', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(354, 'Northern Cape', 186, 'Asia/Novokuznetsk', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(355, 'Northern Cape', 347, 'Africa/Gaborone', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(356, 'Northern Cape', 22, 'Africa/Casablanca', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(357, 'Northern Cape', 160, 'Pacific/Midway', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(358, 'Northern Cape', 155, 'Pacific/Bougainville', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(359, 'Northern Cape', 72, 'Pacific/Gambier', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(360, 'Northern Cape', 163, 'Australia/Hobart', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(361, 'Northern Cape', 227, 'UTC', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(362, 'Northern Cape', 363, 'America/Argentina/San_Luis', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(363, 'Northern Cape', 87, 'Pacific/Midway', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(364, 'Northern Cape', 83, 'Asia/Barnaul', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(365, 'Northern Cape', 334, 'America/Bahia_Banderas', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(366, 'Northern Cape', 89, 'America/Argentina/San_Luis', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(367, 'Northern Cape', 63, 'America/Rio_Branco', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(368, 'Northern Cape', 212, 'Africa/Kinshasa', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(369, 'Northern Cape', 395, 'America/Sao_Paulo', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(370, 'Northern Cape', 171, 'America/Whitehorse', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(371, 'Northern Cape', 128, 'Australia/Brisbane', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(372, 'Northern Cape', 180, 'America/Kralendijk', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(373, 'Northern Cape', 243, 'Europe/Budapest', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(374, 'Northern Cape', 131, 'Africa/Maseru', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(375, 'Northern Cape', 183, 'America/Managua', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(376, 'Northern Cape', 395, 'America/Araguaina', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(377, 'Northern Cape', 263, 'Asia/Anadyr', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(378, 'Northern Cape', 114, 'Asia/Hebron', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(379, 'Northern Cape', 261, 'America/Porto_Velho', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(380, 'Northern Cape', 310, 'Asia/Ulaanbaatar', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(381, 'Northern Cape', 399, 'Europe/Bucharest', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(382, 'Northern Cape', 207, 'America/Dominica', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(383, 'Northern Cape', 295, 'America/Fort_Nelson', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(384, 'Northern Cape', 266, 'Asia/Riyadh', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(385, 'Northern Cape', 353, 'America/Coyhaique', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(386, 'Northern Cape', 312, 'Pacific/Kwajalein', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(387, 'Northern Cape', 284, 'America/Jamaica', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(388, 'Northern Cape', 4, 'America/Havana', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(389, 'Northern Cape', 130, 'Africa/Bujumbura', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(390, 'Northern Cape', 224, 'America/Montserrat', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(391, 'Northern Cape', 129, 'America/Kentucky/Monticello', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(392, 'Northern Cape', 137, 'Indian/Antananarivo', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(393, 'Northern Cape', 97, 'America/Chicago', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(394, 'Northern Cape', 87, 'Africa/Tunis', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(395, 'Northern Cape', 68, 'Europe/San_Marino', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(396, 'Northern Cape', 240, 'Pacific/Noumea', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(397, 'Northern Cape', 221, 'Africa/Lagos', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(398, 'Northern Cape', 205, 'Europe/Kaliningrad', 0, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(399, 'Northern Cape', 42, 'Asia/Pyongyang', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(400, 'Northern Cape', 322, 'Asia/Kuching', 1, '2025-05-24 03:56:11', '2025-05-24 03:56:11'),
(401, 'Pennsylvania', 384, 'Europe/Andorra', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(402, 'Pennsylvania', 331, 'Europe/Sofia', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(403, 'Pennsylvania', 287, 'Africa/Libreville', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(404, 'Pennsylvania', 410, 'Asia/Qyzylorda', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(405, 'Pennsylvania', 218, 'Pacific/Norfolk', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(406, 'Pennsylvania', 109, 'Australia/Hobart', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(407, 'Pennsylvania', 241, 'Africa/Conakry', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(408, 'Pennsylvania', 208, 'America/St_Kitts', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(409, 'Pennsylvania', 240, 'Asia/Bishkek', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(410, 'Pennsylvania', 287, 'America/Matamoros', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(411, 'Pennsylvania', 281, 'Asia/Samarkand', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(412, 'Pennsylvania', 491, 'America/Belize', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(413, 'Pennsylvania', 139, 'Europe/Sofia', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(414, 'Pennsylvania', 190, 'Africa/Malabo', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(415, 'Pennsylvania', 330, 'America/Juneau', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(416, 'Pennsylvania', 380, 'Asia/Singapore', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(417, 'Pennsylvania', 28, 'Europe/Volgograd', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(418, 'Pennsylvania', 12, 'Europe/Sofia', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(419, 'Pennsylvania', 209, 'Africa/Kigali', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(420, 'Pennsylvania', 384, 'America/Juneau', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(421, 'Pennsylvania', 145, 'Africa/Nouakchott', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(422, 'Pennsylvania', 230, 'Europe/Oslo', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(423, 'Pennsylvania', 25, 'Europe/Brussels', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(424, 'Pennsylvania', 47, 'Africa/Maputo', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(425, 'Pennsylvania', 82, 'Africa/Bissau', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(426, 'Pennsylvania', 477, 'Africa/Maputo', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(427, 'Pennsylvania', 195, 'Europe/Volgograd', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(428, 'Pennsylvania', 133, 'Asia/Samarkand', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(429, 'Pennsylvania', 75, 'Asia/Jayapura', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(430, 'Pennsylvania', 299, 'Asia/Seoul', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(431, 'Pennsylvania', 158, 'America/North_Dakota/Center', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(432, 'Pennsylvania', 496, 'America/Kralendijk', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(433, 'Pennsylvania', 345, 'Asia/Tbilisi', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(434, 'Pennsylvania', 8, 'America/Bahia_Banderas', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(435, 'Pennsylvania', 379, 'Africa/Lome', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(436, 'Pennsylvania', 65, 'Indian/Mayotte', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(437, 'Pennsylvania', 377, 'Africa/Blantyre', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(438, 'Pennsylvania', 191, 'America/Anguilla', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(439, 'Pennsylvania', 208, 'America/St_Barthelemy', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(440, 'Pennsylvania', 116, 'America/Argentina/Ushuaia', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(441, 'Pennsylvania', 400, 'Asia/Tehran', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(442, 'Pennsylvania', 212, 'America/Guayaquil', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(443, 'Pennsylvania', 257, 'America/Metlakatla', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(444, 'Pennsylvania', 495, 'America/Santo_Domingo', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(445, 'Pennsylvania', 387, 'America/Danmarkshavn', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(446, 'Pennsylvania', 333, 'America/El_Salvador', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(447, 'Pennsylvania', 383, 'America/Chihuahua', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(448, 'Pennsylvania', 297, 'Africa/Freetown', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(449, 'Pennsylvania', 68, 'America/St_Thomas', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(450, 'Pennsylvania', 153, 'Antarctica/Davis', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(451, 'Pennsylvania', 394, 'Asia/Ashgabat', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(452, 'Pennsylvania', 499, 'Europe/Gibraltar', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(453, 'Pennsylvania', 444, 'Asia/Kathmandu', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(454, 'Pennsylvania', 422, 'Asia/Famagusta', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(455, 'Pennsylvania', 340, 'America/Nome', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(456, 'Pennsylvania', 25, 'America/Indiana/Vevay', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(457, 'Pennsylvania', 319, 'Asia/Tbilisi', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(458, 'Pennsylvania', 419, 'Africa/Accra', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(459, 'Pennsylvania', 456, 'Asia/Taipei', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(460, 'Pennsylvania', 359, 'Asia/Irkutsk', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(461, 'Pennsylvania', 327, 'America/Matamoros', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(462, 'Pennsylvania', 209, 'Europe/Bratislava', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(463, 'Pennsylvania', 362, 'Europe/Tirane', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(464, 'Pennsylvania', 144, 'Pacific/Rarotonga', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(465, 'Pennsylvania', 53, 'America/Sitka', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(466, 'Pennsylvania', 290, 'America/Araguaina', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(467, 'Pennsylvania', 134, 'Asia/Tokyo', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(468, 'Pennsylvania', 236, 'America/Indiana/Petersburg', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(469, 'Pennsylvania', 471, 'America/Puerto_Rico', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(470, 'Pennsylvania', 147, 'Asia/Colombo', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(471, 'Pennsylvania', 485, 'America/Campo_Grande', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(472, 'Pennsylvania', 500, 'America/Coyhaique', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(473, 'Pennsylvania', 124, 'Pacific/Majuro', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(474, 'Pennsylvania', 264, 'America/Ciudad_Juarez', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(475, 'Pennsylvania', 117, 'Pacific/Bougainville', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(476, 'Pennsylvania', 451, 'Europe/Tallinn', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(477, 'Pennsylvania', 433, 'Indian/Chagos', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(478, 'Pennsylvania', 45, 'Europe/Tallinn', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(479, 'Pennsylvania', 453, 'Asia/Oral', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(480, 'Pennsylvania', 47, 'America/Indiana/Winamac', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(481, 'Pennsylvania', 239, 'Pacific/Guam', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(482, 'Pennsylvania', 13, 'Europe/Ulyanovsk', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(483, 'Pennsylvania', 364, 'America/Edmonton', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(484, 'Pennsylvania', 306, 'Pacific/Pitcairn', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(485, 'Pennsylvania', 149, 'America/Eirunepe', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(486, 'Pennsylvania', 229, 'Africa/Abidjan', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(487, 'Pennsylvania', 171, 'Africa/Windhoek', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(488, 'Pennsylvania', 436, 'Africa/Gaborone', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(489, 'Pennsylvania', 184, 'Asia/Kuching', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(490, 'Pennsylvania', 107, 'Africa/Lome', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(491, 'Pennsylvania', 332, 'America/Inuvik', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(492, 'Pennsylvania', 167, 'Africa/Niamey', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(493, 'Pennsylvania', 377, 'Asia/Baku', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(494, 'Pennsylvania', 110, 'Africa/Lome', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(495, 'Pennsylvania', 233, 'Asia/Brunei', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(496, 'Pennsylvania', 131, 'America/Aruba', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(497, 'Pennsylvania', 178, 'Pacific/Kosrae', 1, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(498, 'Pennsylvania', 205, 'Asia/Kathmandu', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(499, 'Pennsylvania', 58, 'Asia/Kathmandu', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(500, 'Pennsylvania', 291, 'Asia/Kuching', 0, '2025-05-24 03:56:18', '2025-05-24 03:56:18'),
(501, 'Kyoto', 565, 'America/Aruba', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(502, 'Kyoto', 566, 'Asia/Muscat', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(503, 'Kyoto', 380, 'Europe/Skopje', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(504, 'Kyoto', 576, 'America/Goose_Bay', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(505, 'Kyoto', 436, 'America/Blanc-Sablon', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(506, 'Kyoto', 342, 'Asia/Yerevan', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(507, 'Kyoto', 85, 'America/Fort_Nelson', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(508, 'Kyoto', 338, 'Asia/Vladivostok', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(509, 'Kyoto', 183, 'Asia/Chita', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(510, 'Kyoto', 559, 'Europe/Istanbul', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(511, 'Kyoto', 85, 'America/Menominee', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(512, 'Kyoto', 583, 'Asia/Oral', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(513, 'Kyoto', 22, 'Asia/Tomsk', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(514, 'Kyoto', 438, 'Europe/Andorra', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(515, 'Kyoto', 523, 'America/Fort_Nelson', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(516, 'Kyoto', 366, 'America/Tijuana', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(517, 'Kyoto', 435, 'Africa/Tripoli', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(518, 'Kyoto', 62, 'Atlantic/Azores', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(519, 'Kyoto', 335, 'America/Iqaluit', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(520, 'Kyoto', 152, 'America/Porto_Velho', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(521, 'Kyoto', 365, 'Pacific/Wake', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(522, 'Kyoto', 496, 'America/Panama', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(523, 'Kyoto', 432, 'America/Metlakatla', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(524, 'Kyoto', 48, 'America/Barbados', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(525, 'Kyoto', 455, 'America/St_Barthelemy', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(526, 'Kyoto', 255, 'Indian/Cocos', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(527, 'Kyoto', 518, 'Africa/Mogadishu', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(528, 'Kyoto', 568, 'Europe/Zurich', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(529, 'Kyoto', 519, 'America/Edmonton', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(530, 'Kyoto', 18, 'Pacific/Tongatapu', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(531, 'Kyoto', 341, 'America/Managua', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(532, 'Kyoto', 202, 'Europe/Zagreb', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(533, 'Kyoto', 439, 'America/Tortola', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(534, 'Kyoto', 133, 'Africa/Luanda', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(535, 'Kyoto', 575, 'Asia/Tashkent', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(536, 'Kyoto', 330, 'Asia/Taipei', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(537, 'Kyoto', 471, 'Europe/Bratislava', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(538, 'Kyoto', 582, 'Africa/Malabo', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(539, 'Kyoto', 474, 'America/Cuiaba', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(540, 'Kyoto', 574, 'America/Swift_Current', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(541, 'Kyoto', 289, 'Pacific/Tarawa', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(542, 'Kyoto', 479, 'Africa/Kampala', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23');
INSERT INTO `states` (`id`, `name`, `country_id`, `timezone`, `status`, `created_at`, `updated_at`) VALUES
(543, 'Kyoto', 504, 'America/Port-au-Prince', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(544, 'Kyoto', 407, 'Asia/Baku', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(545, 'Kyoto', 35, 'Indian/Maldives', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(546, 'Kyoto', 126, 'America/Sao_Paulo', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(547, 'Kyoto', 128, 'Pacific/Palau', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(548, 'Kyoto', 158, 'Asia/Oral', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(549, 'Kyoto', 271, 'Asia/Khandyga', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(550, 'Kyoto', 279, 'Africa/Malabo', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(551, 'Kyoto', 59, 'America/Moncton', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(552, 'Kyoto', 201, 'America/Santarem', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(553, 'Kyoto', 41, 'Europe/Athens', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(554, 'Kyoto', 288, 'Asia/Dhaka', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(555, 'Kyoto', 191, 'Europe/Istanbul', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(556, 'Kyoto', 411, 'America/Inuvik', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(557, 'Kyoto', 284, 'Asia/Dhaka', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(558, 'Kyoto', 546, 'Indian/Kerguelen', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(559, 'Kyoto', 371, 'Asia/Colombo', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(560, 'Kyoto', 38, 'Australia/Lindeman', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(561, 'Kyoto', 318, 'Africa/Conakry', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(562, 'Kyoto', 522, 'America/Dawson', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(563, 'Kyoto', 436, 'Pacific/Kwajalein', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(564, 'Kyoto', 250, 'Asia/Atyrau', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(565, 'Kyoto', 407, 'Africa/Ouagadougou', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(566, 'Kyoto', 256, 'America/Lima', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(567, 'Kyoto', 551, 'Europe/Guernsey', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(568, 'Kyoto', 212, 'Asia/Dubai', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(569, 'Kyoto', 85, 'Asia/Thimphu', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(570, 'Kyoto', 180, 'Atlantic/Azores', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(571, 'Kyoto', 392, 'Europe/Lisbon', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(572, 'Kyoto', 500, 'America/Argentina/Mendoza', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(573, 'Kyoto', 458, 'Atlantic/Bermuda', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(574, 'Kyoto', 357, 'America/Asuncion', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(575, 'Kyoto', 546, 'Indian/Antananarivo', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(576, 'Kyoto', 509, 'Asia/Bangkok', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(577, 'Kyoto', 433, 'Pacific/Kosrae', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(578, 'Kyoto', 358, 'Europe/Dublin', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(579, 'Kyoto', 143, 'Asia/Jakarta', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(580, 'Kyoto', 270, 'America/Halifax', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(581, 'Kyoto', 436, 'America/Fort_Nelson', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(582, 'Kyoto', 389, 'Atlantic/South_Georgia', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(583, 'Kyoto', 381, 'America/Port_of_Spain', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(584, 'Kyoto', 171, 'Europe/Madrid', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(585, 'Kyoto', 13, 'Asia/Bahrain', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(586, 'Kyoto', 463, 'Europe/Saratov', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(587, 'Kyoto', 545, 'America/Sao_Paulo', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(588, 'Kyoto', 81, 'America/Guadeloupe', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(589, 'Kyoto', 121, 'Indian/Chagos', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(590, 'Kyoto', 86, 'Asia/Jayapura', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(591, 'Kyoto', 317, 'Europe/Dublin', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(592, 'Kyoto', 205, 'Pacific/Marquesas', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(593, 'Kyoto', 71, 'Africa/Monrovia', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(594, 'Kyoto', 185, 'Africa/Malabo', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(595, 'Kyoto', 45, 'Africa/Ndjamena', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(596, 'Kyoto', 278, 'America/St_Kitts', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(597, 'Kyoto', 456, 'America/Martinique', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(598, 'Kyoto', 419, 'Asia/Dushanbe', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(599, 'Kyoto', 476, 'America/St_Lucia', 1, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(600, 'Kyoto', 304, 'Africa/Khartoum', 0, '2025-05-24 03:56:23', '2025-05-24 03:56:23'),
(601, 'Campania', 311, 'Europe/Andorra', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(602, 'Campania', 513, 'Indian/Mayotte', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(603, 'Campania', 602, 'America/Cancun', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(604, 'Campania', 150, 'America/Argentina/San_Luis', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(605, 'Campania', 224, 'Europe/Lisbon', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(606, 'Campania', 30, 'Africa/Banjul', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(607, 'Campania', 116, 'America/Goose_Bay', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(608, 'Campania', 586, 'America/Indiana/Vincennes', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(609, 'Campania', 581, 'America/Argentina/Ushuaia', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(610, 'Campania', 168, 'Indian/Cocos', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(611, 'Campania', 32, 'Australia/Brisbane', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(612, 'Campania', 222, 'Asia/Urumqi', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(613, 'Campania', 270, 'Atlantic/Reykjavik', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(614, 'Campania', 421, 'America/Indiana/Indianapolis', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(615, 'Campania', 241, 'America/Punta_Arenas', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(616, 'Campania', 553, 'America/Monterrey', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(617, 'Campania', 451, 'Pacific/Easter', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(618, 'Campania', 491, 'Africa/Freetown', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(619, 'Campania', 487, 'America/St_Thomas', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(620, 'Campania', 560, 'America/Martinique', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(621, 'Campania', 512, 'Africa/Cairo', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(622, 'Campania', 238, 'America/Argentina/Rio_Gallegos', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(623, 'Campania', 631, 'Europe/Tallinn', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(624, 'Campania', 478, 'Asia/Karachi', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(625, 'Campania', 521, 'Antarctica/Palmer', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(626, 'Campania', 690, 'Europe/Amsterdam', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(627, 'Campania', 410, 'America/Kralendijk', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(628, 'Campania', 430, 'Europe/Stockholm', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(629, 'Campania', 355, 'Asia/Singapore', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(630, 'Campania', 161, 'America/Tegucigalpa', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(631, 'Campania', 189, 'Europe/Vaduz', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(632, 'Campania', 321, 'Africa/Mogadishu', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(633, 'Campania', 28, 'Europe/Andorra', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(634, 'Campania', 625, 'Antarctica/Mawson', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(635, 'Campania', 626, 'America/Chicago', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(636, 'Campania', 476, 'America/Santarem', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(637, 'Campania', 136, 'America/Danmarkshavn', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(638, 'Campania', 542, 'Pacific/Port_Moresby', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(639, 'Campania', 11, 'America/Indiana/Marengo', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(640, 'Campania', 304, 'America/Campo_Grande', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(641, 'Campania', 577, 'Asia/Srednekolymsk', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(642, 'Campania', 87, 'America/Toronto', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(643, 'Campania', 433, 'Europe/Monaco', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(644, 'Campania', 394, 'America/New_York', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(645, 'Campania', 132, 'America/Indiana/Winamac', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(646, 'Campania', 307, 'Pacific/Midway', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(647, 'Campania', 516, 'Indian/Chagos', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(648, 'Campania', 8, 'Asia/Baghdad', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(649, 'Campania', 354, 'America/North_Dakota/New_Salem', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(650, 'Campania', 535, 'Asia/Seoul', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(651, 'Campania', 91, 'America/Inuvik', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(652, 'Campania', 472, 'Asia/Novokuznetsk', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(653, 'Campania', 678, 'Asia/Makassar', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(654, 'Campania', 16, 'America/Adak', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(655, 'Campania', 306, 'Africa/Lubumbashi', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(656, 'Campania', 532, 'Africa/Khartoum', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(657, 'Campania', 394, 'Asia/Baku', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(658, 'Campania', 256, 'Asia/Jayapura', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(659, 'Campania', 618, 'Asia/Novosibirsk', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(660, 'Campania', 408, 'Europe/Bucharest', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(661, 'Campania', 295, 'America/Menominee', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(662, 'Campania', 22, 'Europe/Ulyanovsk', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(663, 'Campania', 103, 'America/Eirunepe', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(664, 'Campania', 23, 'America/Grand_Turk', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(665, 'Campania', 89, 'Pacific/Port_Moresby', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(666, 'Campania', 470, 'America/Rio_Branco', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(667, 'Campania', 681, 'Pacific/Honolulu', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(668, 'Campania', 360, 'Africa/Nouakchott', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(669, 'Campania', 605, 'Africa/Khartoum', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(670, 'Campania', 446, 'America/Argentina/Jujuy', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(671, 'Campania', 596, 'America/Guayaquil', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(672, 'Campania', 547, 'Asia/Pontianak', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(673, 'Campania', 179, 'Pacific/Auckland', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(674, 'Campania', 99, 'America/Porto_Velho', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(675, 'Campania', 102, 'Europe/Monaco', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(676, 'Campania', 168, 'Africa/Lome', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(677, 'Campania', 404, 'America/Glace_Bay', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(678, 'Campania', 578, 'Africa/Tunis', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(679, 'Campania', 125, 'Asia/Aqtau', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(680, 'Campania', 185, 'America/Asuncion', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(681, 'Campania', 403, 'Australia/Lord_Howe', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(682, 'Campania', 231, 'Asia/Krasnoyarsk', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(683, 'Campania', 270, 'Europe/Kyiv', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(684, 'Campania', 574, 'Australia/Brisbane', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(685, 'Campania', 107, 'America/Caracas', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(686, 'Campania', 446, 'Africa/Porto-Novo', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(687, 'Campania', 86, 'America/Bogota', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(688, 'Campania', 16, 'Asia/Krasnoyarsk', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(689, 'Campania', 403, 'Asia/Macau', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(690, 'Campania', 175, 'Africa/Dakar', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(691, 'Campania', 419, 'America/Eirunepe', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(692, 'Campania', 290, 'Asia/Khandyga', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(693, 'Campania', 372, 'Europe/Kirov', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(694, 'Campania', 373, 'Europe/Busingen', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(695, 'Campania', 170, 'Asia/Kuching', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(696, 'Campania', 168, 'America/Campo_Grande', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(697, 'Campania', 287, 'Australia/Eucla', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(698, 'Campania', 574, 'Pacific/Norfolk', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(699, 'Campania', 435, 'America/Vancouver', 1, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(700, 'Campania', 48, 'America/Indiana/Knox', 0, '2025-05-24 04:02:53', '2025-05-24 04:02:53'),
(701, 'Sonora', 789, 'America/Fortaleza', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(702, 'Sonora', 46, 'Atlantic/St_Helena', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(703, 'Sonora', 114, 'America/Argentina/Catamarca', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(704, 'Sonora', 736, 'Arctic/Longyearbyen', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(705, 'Sonora', 453, 'America/Goose_Bay', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(706, 'Sonora', 48, 'America/North_Dakota/New_Salem', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(707, 'Sonora', 387, 'Africa/Sao_Tome', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(708, 'Sonora', 583, 'Africa/Malabo', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(709, 'Sonora', 160, 'Atlantic/St_Helena', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(710, 'Sonora', 27, 'America/Moncton', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(711, 'Sonora', 42, 'Europe/London', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(712, 'Sonora', 322, 'America/Boise', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(713, 'Sonora', 709, 'Europe/Andorra', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(714, 'Sonora', 742, 'Atlantic/Madeira', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(715, 'Sonora', 227, 'America/Lower_Princes', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(716, 'Sonora', 645, 'Indian/Maldives', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(717, 'Sonora', 236, 'Antarctica/Vostok', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(718, 'Sonora', 524, 'Asia/Sakhalin', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(719, 'Sonora', 133, 'Asia/Barnaul', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(720, 'Sonora', 578, 'America/North_Dakota/Center', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(721, 'Sonora', 692, 'Asia/Irkutsk', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(722, 'Sonora', 21, 'America/Dawson_Creek', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(723, 'Sonora', 319, 'Australia/Brisbane', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(724, 'Sonora', 435, 'Asia/Krasnoyarsk', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(725, 'Sonora', 545, 'Asia/Omsk', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(726, 'Sonora', 771, 'America/Recife', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(727, 'Sonora', 187, 'America/Danmarkshavn', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(728, 'Sonora', 176, 'Europe/Istanbul', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(729, 'Sonora', 498, 'Africa/Asmara', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(730, 'Sonora', 704, 'America/Nassau', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(731, 'Sonora', 469, 'Africa/Libreville', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(732, 'Sonora', 114, 'Africa/Ouagadougou', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(733, 'Sonora', 483, 'UTC', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(734, 'Sonora', 496, 'America/Monterrey', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(735, 'Sonora', 86, 'Asia/Makassar', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(736, 'Sonora', 215, 'Indian/Christmas', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(737, 'Sonora', 621, 'Asia/Atyrau', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(738, 'Sonora', 203, 'Atlantic/Stanley', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(739, 'Sonora', 284, 'Asia/Yangon', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(740, 'Sonora', 719, 'Europe/Berlin', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(741, 'Sonora', 112, 'Indian/Mayotte', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(742, 'Sonora', 314, 'America/St_Vincent', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(743, 'Sonora', 556, 'America/Bahia_Banderas', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(744, 'Sonora', 339, 'Europe/Stockholm', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(745, 'Sonora', 357, 'America/El_Salvador', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(746, 'Sonora', 96, 'America/New_York', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(747, 'Sonora', 542, 'Europe/Lisbon', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(748, 'Sonora', 671, 'America/Los_Angeles', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(749, 'Sonora', 202, 'America/Swift_Current', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(750, 'Sonora', 485, 'Africa/Kampala', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(751, 'Sonora', 588, 'Pacific/Easter', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(752, 'Sonora', 400, 'America/Sitka', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(753, 'Sonora', 14, 'Atlantic/Bermuda', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(754, 'Sonora', 217, 'Asia/Anadyr', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(755, 'Sonora', 96, 'America/Porto_Velho', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(756, 'Sonora', 300, 'Pacific/Nauru', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(757, 'Sonora', 592, 'Europe/Astrakhan', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(758, 'Sonora', 723, 'Africa/Malabo', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(759, 'Sonora', 682, 'Pacific/Chatham', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(760, 'Sonora', 331, 'Asia/Magadan', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(761, 'Sonora', 199, 'Pacific/Niue', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(762, 'Sonora', 634, 'America/Blanc-Sablon', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(763, 'Sonora', 38, 'Asia/Pontianak', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(764, 'Sonora', 584, 'Antarctica/Syowa', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(765, 'Sonora', 760, 'Africa/Lagos', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(766, 'Sonora', 238, 'Africa/Douala', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(767, 'Sonora', 50, 'Africa/Bamako', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(768, 'Sonora', 143, 'America/Thule', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(769, 'Sonora', 336, 'Atlantic/Bermuda', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(770, 'Sonora', 285, 'America/Asuncion', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(771, 'Sonora', 727, 'America/Regina', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(772, 'Sonora', 61, 'Pacific/Tarawa', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(773, 'Sonora', 136, 'Asia/Hebron', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(774, 'Sonora', 611, 'Asia/Famagusta', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(775, 'Sonora', 290, 'Pacific/Kosrae', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(776, 'Sonora', 674, 'Pacific/Nauru', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(777, 'Sonora', 596, 'America/Belize', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(778, 'Sonora', 615, 'Asia/Riyadh', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(779, 'Sonora', 593, 'Europe/Tirane', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(780, 'Sonora', 127, 'America/Phoenix', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(781, 'Sonora', 711, 'Asia/Bishkek', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(782, 'Sonora', 391, 'Pacific/Rarotonga', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(783, 'Sonora', 540, 'Asia/Kathmandu', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(784, 'Sonora', 374, 'Antarctica/McMurdo', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(785, 'Sonora', 200, 'America/Fort_Nelson', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(786, 'Sonora', 219, 'Asia/Dili', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(787, 'Sonora', 466, 'America/Martinique', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(788, 'Sonora', 538, 'Asia/Gaza', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(789, 'Sonora', 772, 'America/North_Dakota/New_Salem', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(790, 'Sonora', 435, 'Asia/Seoul', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(791, 'Sonora', 219, 'Asia/Jayapura', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(792, 'Sonora', 412, 'Europe/Malta', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(793, 'Sonora', 396, 'America/St_Johns', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(794, 'Sonora', 227, 'Indian/Maldives', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(795, 'Sonora', 286, 'America/Hermosillo', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(796, 'Sonora', 277, 'America/Eirunepe', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(797, 'Sonora', 558, 'Asia/Manila', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(798, 'Sonora', 284, 'Asia/Kabul', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(799, 'Sonora', 646, 'America/Anchorage', 1, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(800, 'Sonora', 515, 'Europe/Samara', 0, '2025-05-24 04:03:18', '2025-05-24 04:03:18'),
(801, 'Baden-Württemberg', 868, 'America/St_Vincent', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(802, 'Baden-Württemberg', 223, 'Pacific/Wallis', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(803, 'Baden-Württemberg', 728, 'America/Tortola', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(804, 'Baden-Württemberg', 372, 'Africa/Conakry', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(805, 'Baden-Württemberg', 477, 'Pacific/Fiji', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(806, 'Baden-Württemberg', 215, 'Europe/Riga', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(807, 'Baden-Württemberg', 413, 'Indian/Cocos', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(808, 'Baden-Württemberg', 751, 'Indian/Comoro', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(809, 'Baden-Württemberg', 858, 'Atlantic/Azores', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(810, 'Baden-Württemberg', 94, 'America/Argentina/Buenos_Aires', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(811, 'Baden-Württemberg', 418, 'Africa/Kigali', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(812, 'Baden-Württemberg', 78, 'Africa/Cairo', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(813, 'Baden-Württemberg', 478, 'America/Montevideo', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(814, 'Baden-Württemberg', 783, 'America/Indiana/Marengo', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(815, 'Baden-Württemberg', 554, 'Asia/Novokuznetsk', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(816, 'Baden-Württemberg', 892, 'Atlantic/Reykjavik', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(817, 'Baden-Württemberg', 42, 'Australia/Broken_Hill', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(818, 'Baden-Württemberg', 50, 'America/Fortaleza', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(819, 'Baden-Württemberg', 311, 'America/Argentina/Jujuy', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(820, 'Baden-Württemberg', 721, 'Africa/Casablanca', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(821, 'Baden-Württemberg', 799, 'Indian/Mahe', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(822, 'Baden-Württemberg', 761, 'Europe/Malta', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(823, 'Baden-Württemberg', 177, 'Asia/Aqtau', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(824, 'Baden-Württemberg', 250, 'America/Vancouver', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(825, 'Baden-Württemberg', 265, 'America/Cambridge_Bay', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(826, 'Baden-Württemberg', 854, 'Arctic/Longyearbyen', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(827, 'Baden-Württemberg', 369, 'America/Belem', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(828, 'Baden-Württemberg', 871, 'America/Mazatlan', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(829, 'Baden-Württemberg', 651, 'Pacific/Kwajalein', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(830, 'Baden-Württemberg', 359, 'Pacific/Fiji', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(831, 'Baden-Württemberg', 162, 'America/Creston', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(832, 'Baden-Württemberg', 174, 'America/North_Dakota/Beulah', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(833, 'Baden-Württemberg', 49, 'Pacific/Palau', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(834, 'Baden-Württemberg', 319, 'Indian/Antananarivo', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(835, 'Baden-Württemberg', 53, 'America/Nuuk', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(836, 'Baden-Württemberg', 384, 'Europe/Sofia', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(837, 'Baden-Württemberg', 890, 'Asia/Riyadh', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(838, 'Baden-Württemberg', 865, 'Asia/Makassar', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(839, 'Baden-Württemberg', 234, 'Africa/Lubumbashi', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(840, 'Baden-Württemberg', 569, 'Asia/Kamchatka', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(841, 'Baden-Württemberg', 568, 'Africa/Gaborone', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(842, 'Baden-Württemberg', 207, 'Europe/Monaco', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(843, 'Baden-Württemberg', 141, 'Africa/Tunis', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(844, 'Baden-Württemberg', 209, 'Europe/Amsterdam', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(845, 'Baden-Württemberg', 140, 'Europe/Vatican', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(846, 'Baden-Württemberg', 61, 'Asia/Pyongyang', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(847, 'Baden-Württemberg', 290, 'Antarctica/Casey', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(848, 'Baden-Württemberg', 48, 'Asia/Kuwait', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(849, 'Baden-Württemberg', 59, 'Africa/Gaborone', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(850, 'Baden-Württemberg', 93, 'Africa/Luanda', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(851, 'Baden-Württemberg', 784, 'Pacific/Kwajalein', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(852, 'Baden-Württemberg', 488, 'America/St_Vincent', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(853, 'Baden-Württemberg', 740, 'Asia/Nicosia', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(854, 'Baden-Württemberg', 761, 'Indian/Antananarivo', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(855, 'Baden-Württemberg', 429, 'Africa/Bangui', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(856, 'Baden-Württemberg', 180, 'Asia/Qatar', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(857, 'Baden-Württemberg', 652, 'Pacific/Wallis', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(858, 'Baden-Württemberg', 260, 'America/Marigot', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(859, 'Baden-Württemberg', 81, 'Africa/Libreville', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(860, 'Baden-Württemberg', 900, 'Arctic/Longyearbyen', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(861, 'Baden-Württemberg', 46, 'Europe/Jersey', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(862, 'Baden-Württemberg', 97, 'America/Boa_Vista', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(863, 'Baden-Württemberg', 143, 'Asia/Krasnoyarsk', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(864, 'Baden-Württemberg', 329, 'America/Argentina/Tucuman', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(865, 'Baden-Württemberg', 744, 'Asia/Jayapura', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(866, 'Baden-Württemberg', 771, 'America/Barbados', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(867, 'Baden-Württemberg', 852, 'Asia/Sakhalin', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(868, 'Baden-Württemberg', 115, 'America/La_Paz', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(869, 'Baden-Württemberg', 29, 'Asia/Karachi', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(870, 'Baden-Württemberg', 94, 'Australia/Darwin', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(871, 'Baden-Württemberg', 658, 'Europe/Zurich', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(872, 'Baden-Württemberg', 482, 'Asia/Magadan', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(873, 'Baden-Württemberg', 242, 'Australia/Brisbane', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(874, 'Baden-Württemberg', 712, 'Asia/Gaza', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(875, 'Baden-Württemberg', 352, 'Antarctica/Davis', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(876, 'Baden-Württemberg', 423, 'UTC', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(877, 'Baden-Württemberg', 455, 'Asia/Chita', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(878, 'Baden-Württemberg', 751, 'America/Mexico_City', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(879, 'Baden-Württemberg', 44, 'Europe/Isle_of_Man', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(880, 'Baden-Württemberg', 262, 'America/Belize', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(881, 'Baden-Württemberg', 710, 'Australia/Eucla', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(882, 'Baden-Württemberg', 71, 'America/Belem', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(883, 'Baden-Württemberg', 570, 'America/El_Salvador', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(884, 'Baden-Württemberg', 757, 'Africa/Bamako', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(885, 'Baden-Württemberg', 532, 'America/Sitka', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(886, 'Baden-Württemberg', 432, 'America/Bahia_Banderas', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(887, 'Baden-Württemberg', 823, 'Asia/Pyongyang', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(888, 'Baden-Württemberg', 687, 'America/Indiana/Knox', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(889, 'Baden-Württemberg', 454, 'Asia/Colombo', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(890, 'Baden-Württemberg', 833, 'Asia/Seoul', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(891, 'Baden-Württemberg', 251, 'America/Nuuk', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(892, 'Baden-Württemberg', 686, 'America/Asuncion', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(893, 'Baden-Württemberg', 892, 'Asia/Almaty', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(894, 'Baden-Württemberg', 273, 'America/Montserrat', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(895, 'Baden-Württemberg', 262, 'America/Iqaluit', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(896, 'Baden-Württemberg', 328, 'Indian/Maldives', 0, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(897, 'Baden-Württemberg', 778, 'America/Regina', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(898, 'Baden-Württemberg', 852, 'Pacific/Tarawa', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(899, 'Baden-Württemberg', 758, 'America/Argentina/Tucuman', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(900, 'Baden-Württemberg', 307, 'America/Campo_Grande', 1, '2025-05-24 04:03:22', '2025-05-24 04:03:22'),
(901, 'Mexico City', 610, 'Pacific/Guadalcanal', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(902, 'Mexico City', 269, 'Europe/Astrakhan', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(903, 'Mexico City', 188, 'Asia/Tbilisi', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(904, 'Mexico City', 98, 'Asia/Bangkok', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(905, 'Mexico City', 844, 'America/Tortola', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(906, 'Mexico City', 268, 'Asia/Bahrain', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(907, 'Mexico City', 400, 'Asia/Damascus', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(908, 'Mexico City', 920, 'Pacific/Kosrae', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(909, 'Mexico City', 938, 'Africa/Ouagadougou', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(910, 'Mexico City', 40, 'Atlantic/Stanley', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(911, 'Mexico City', 349, 'America/Grand_Turk', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(912, 'Mexico City', 569, 'Asia/Dushanbe', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(913, 'Mexico City', 61, 'America/Puerto_Rico', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(914, 'Mexico City', 241, 'Asia/Kuwait', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(915, 'Mexico City', 247, 'Antarctica/Davis', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(916, 'Mexico City', 751, 'America/Detroit', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(917, 'Mexico City', 603, 'Asia/Seoul', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(918, 'Mexico City', 432, 'America/St_Lucia', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(919, 'Mexico City', 55, 'Asia/Bangkok', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(920, 'Mexico City', 898, 'America/Marigot', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(921, 'Mexico City', 879, 'America/Campo_Grande', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(922, 'Mexico City', 136, 'Atlantic/Reykjavik', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(923, 'Mexico City', 268, 'Asia/Khandyga', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(924, 'Mexico City', 117, 'Pacific/Fiji', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(925, 'Mexico City', 398, 'Indian/Chagos', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(926, 'Mexico City', 192, 'Asia/Phnom_Penh', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(927, 'Mexico City', 138, 'Asia/Anadyr', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(928, 'Mexico City', 801, 'Asia/Yangon', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(929, 'Mexico City', 963, 'Pacific/Guadalcanal', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(930, 'Mexico City', 274, 'America/Santiago', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(931, 'Mexico City', 409, 'Asia/Ust-Nera', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(932, 'Mexico City', 807, 'America/Santo_Domingo', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(933, 'Mexico City', 297, 'America/Dominica', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(934, 'Mexico City', 937, 'Africa/Windhoek', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(935, 'Mexico City', 146, 'Pacific/Port_Moresby', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(936, 'Mexico City', 668, 'Pacific/Fiji', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(937, 'Mexico City', 728, 'Europe/Sofia', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(938, 'Mexico City', 551, 'Europe/Helsinki', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(939, 'Mexico City', 294, 'America/Guyana', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(940, 'Mexico City', 498, 'Africa/Khartoum', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(941, 'Mexico City', 698, 'Africa/Kigali', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(942, 'Mexico City', 982, 'America/Indiana/Tell_City', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(943, 'Mexico City', 376, 'Africa/Lome', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(944, 'Mexico City', 889, 'Africa/Cairo', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(945, 'Mexico City', 909, 'Europe/Astrakhan', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(946, 'Mexico City', 736, 'Europe/Malta', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(947, 'Mexico City', 161, 'Europe/Copenhagen', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(948, 'Mexico City', 371, 'Asia/Damascus', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(949, 'Mexico City', 241, 'America/Cayenne', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(950, 'Mexico City', 345, 'America/Montevideo', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(951, 'Mexico City', 429, 'Pacific/Bougainville', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(952, 'Mexico City', 57, 'Antarctica/DumontDUrville', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(953, 'Mexico City', 344, 'Africa/Ceuta', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(954, 'Mexico City', 689, 'Australia/Darwin', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(955, 'Mexico City', 389, 'America/Indiana/Knox', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(956, 'Mexico City', 847, 'Asia/Damascus', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(957, 'Mexico City', 465, 'Asia/Pontianak', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(958, 'Mexico City', 839, 'Europe/Bucharest', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(959, 'Mexico City', 189, 'Antarctica/DumontDUrville', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(960, 'Mexico City', 217, 'Indian/Maldives', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(961, 'Mexico City', 862, 'Europe/Oslo', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(962, 'Mexico City', 669, 'Europe/Vaduz', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(963, 'Mexico City', 286, 'Europe/Brussels', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(964, 'Mexico City', 819, 'Pacific/Port_Moresby', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(965, 'Mexico City', 10, 'America/Argentina/La_Rioja', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(966, 'Mexico City', 766, 'Pacific/Kiritimati', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(967, 'Mexico City', 264, 'Africa/Niamey', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(968, 'Mexico City', 95, 'America/Indiana/Vevay', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(969, 'Mexico City', 696, 'Asia/Irkutsk', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(970, 'Mexico City', 424, 'America/Monterrey', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(971, 'Mexico City', 890, 'America/Goose_Bay', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(972, 'Mexico City', 94, 'America/Costa_Rica', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(973, 'Mexico City', 873, 'Asia/Vladivostok', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(974, 'Mexico City', 210, 'Asia/Qatar', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(975, 'Mexico City', 313, 'Asia/Thimphu', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(976, 'Mexico City', 831, 'America/Araguaina', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(977, 'Mexico City', 759, 'Europe/Stockholm', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(978, 'Mexico City', 914, 'America/Jamaica', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(979, 'Mexico City', 500, 'Asia/Dhaka', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(980, 'Mexico City', 342, 'America/Paramaribo', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(981, 'Mexico City', 708, 'America/Sao_Paulo', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(982, 'Mexico City', 96, 'America/Puerto_Rico', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(983, 'Mexico City', 44, 'America/Montevideo', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(984, 'Mexico City', 253, 'Asia/Almaty', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(985, 'Mexico City', 344, 'Pacific/Pago_Pago', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(986, 'Mexico City', 919, 'America/Kentucky/Louisville', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(987, 'Mexico City', 510, 'Europe/Chisinau', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(988, 'Mexico City', 143, 'Australia/Melbourne', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(989, 'Mexico City', 365, 'Africa/Kigali', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(990, 'Mexico City', 925, 'Pacific/Wake', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(991, 'Mexico City', 683, 'America/Santo_Domingo', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(992, 'Mexico City', 765, 'Pacific/Pitcairn', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(993, 'Mexico City', 453, 'Asia/Colombo', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(994, 'Mexico City', 411, 'Europe/Prague', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(995, 'Mexico City', 498, 'America/Blanc-Sablon', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(996, 'Mexico City', 976, 'Africa/Bangui', 1, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(997, 'Mexico City', 145, 'Europe/Tirane', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(998, 'Mexico City', 393, 'America/Tegucigalpa', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(999, 'Mexico City', 720, 'Atlantic/Stanley', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(1000, 'Mexico City', 422, 'Pacific/Saipan', 0, '2025-05-24 04:03:37', '2025-05-24 04:03:37'),
(1001, 'Campania', 1067, 'America/Coyhaique', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1002, 'Campania', 462, 'America/Kralendijk', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1003, 'Campania', 724, 'America/Atikokan', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1004, 'Campania', 1040, 'America/Punta_Arenas', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1005, 'Campania', 924, 'America/Indiana/Indianapolis', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1006, 'Campania', 16, 'America/Indiana/Winamac', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1007, 'Campania', 582, 'Europe/Isle_of_Man', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1008, 'Campania', 206, 'Asia/Nicosia', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1009, 'Campania', 214, 'America/Antigua', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1010, 'Campania', 195, 'Europe/Stockholm', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1011, 'Campania', 224, 'America/Barbados', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1012, 'Campania', 1027, 'America/Yakutat', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1013, 'Campania', 691, 'Europe/Lisbon', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1014, 'Campania', 947, 'Europe/Stockholm', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1015, 'Campania', 1074, 'America/Aruba', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1016, 'Campania', 618, 'Indian/Reunion', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1017, 'Campania', 351, 'Pacific/Saipan', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1018, 'Campania', 900, 'America/Mazatlan', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1019, 'Campania', 885, 'Pacific/Pitcairn', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1020, 'Campania', 547, 'America/Cancun', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1021, 'Campania', 804, 'America/Edmonton', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1022, 'Campania', 326, 'Africa/Bamako', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1023, 'Campania', 450, 'America/Barbados', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1024, 'Campania', 1094, 'Asia/Tokyo', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1025, 'Campania', 47, 'Africa/Kigali', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1026, 'Campania', 694, 'Europe/Jersey', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1027, 'Campania', 450, 'Asia/Kuwait', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1028, 'Campania', 51, 'Africa/Abidjan', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1029, 'Campania', 651, 'Pacific/Wake', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1030, 'Campania', 759, 'Indian/Chagos', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1031, 'Campania', 122, 'Pacific/Gambier', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1032, 'Campania', 99, 'Pacific/Midway', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1033, 'Campania', 1059, 'America/Antigua', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1034, 'Campania', 389, 'Asia/Ashgabat', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1035, 'Campania', 1009, 'America/St_Barthelemy', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1036, 'Campania', 39, 'Australia/Broken_Hill', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1037, 'Campania', 70, 'Europe/Helsinki', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1038, 'Campania', 767, 'Asia/Dubai', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1039, 'Campania', 997, 'America/Managua', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1040, 'Campania', 204, 'America/Grenada', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1041, 'Campania', 300, 'America/Caracas', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1042, 'Campania', 944, 'America/Bogota', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1043, 'Campania', 435, 'Australia/Hobart', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1044, 'Campania', 1025, 'Europe/Stockholm', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1045, 'Campania', 341, 'Africa/Douala', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1046, 'Campania', 951, 'Indian/Christmas', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1047, 'Campania', 262, 'America/Indiana/Tell_City', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1048, 'Campania', 667, 'Asia/Yakutsk', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1049, 'Campania', 39, 'America/Belize', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1050, 'Campania', 94, 'America/Indiana/Tell_City', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1051, 'Campania', 657, 'Asia/Kamchatka', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1052, 'Campania', 909, 'Asia/Tashkent', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1053, 'Campania', 373, 'America/Noronha', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1054, 'Campania', 469, 'America/Vancouver', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1055, 'Campania', 598, 'Asia/Vladivostok', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1056, 'Campania', 49, 'Europe/Volgograd', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1057, 'Campania', 451, 'Pacific/Pitcairn', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1058, 'Campania', 42, 'Australia/Adelaide', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1059, 'Campania', 260, 'America/Coyhaique', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1060, 'Campania', 242, 'Africa/Conakry', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1061, 'Campania', 104, 'Asia/Qatar', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1062, 'Campania', 653, 'America/Coyhaique', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1063, 'Campania', 381, 'America/Guadeloupe', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1064, 'Campania', 312, 'Pacific/Majuro', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1065, 'Campania', 971, 'Asia/Qostanay', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1066, 'Campania', 557, 'Europe/Tallinn', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1067, 'Campania', 825, 'Pacific/Chuuk', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1068, 'Campania', 1032, 'Europe/Kaliningrad', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1069, 'Campania', 251, 'Pacific/Wake', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1070, 'Campania', 411, 'Asia/Hong_Kong', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1071, 'Campania', 980, 'America/Ojinaga', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1072, 'Campania', 182, 'America/Argentina/La_Rioja', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1073, 'Campania', 133, 'Europe/Sofia', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1074, 'Campania', 749, 'Europe/Guernsey', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1075, 'Campania', 888, 'Africa/Brazzaville', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1076, 'Campania', 1057, 'Asia/Muscat', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1077, 'Campania', 161, 'Europe/Copenhagen', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1078, 'Campania', 1070, 'Europe/Copenhagen', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1079, 'Campania', 819, 'Africa/Harare', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1080, 'Campania', 365, 'Europe/Gibraltar', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1081, 'Campania', 305, 'Asia/Jayapura', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1082, 'Campania', 557, 'Indian/Christmas', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1083, 'Campania', 992, 'America/Eirunepe', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1084, 'Campania', 20, 'America/Hermosillo', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40');
INSERT INTO `states` (`id`, `name`, `country_id`, `timezone`, `status`, `created_at`, `updated_at`) VALUES
(1085, 'Campania', 6, 'Africa/Addis_Ababa', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1086, 'Campania', 82, 'Pacific/Fiji', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1087, 'Campania', 623, 'Asia/Dubai', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1088, 'Campania', 803, 'Asia/Tbilisi', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1089, 'Campania', 138, 'Asia/Barnaul', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1090, 'Campania', 851, 'Indian/Mahe', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1091, 'Campania', 961, 'Arctic/Longyearbyen', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1092, 'Campania', 530, 'Africa/Malabo', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1093, 'Campania', 834, 'Pacific/Kosrae', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1094, 'Campania', 1010, 'Europe/Paris', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1095, 'Campania', 935, 'Asia/Singapore', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1096, 'Campania', 385, 'Asia/Aden', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1097, 'Campania', 1086, 'America/Toronto', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1098, 'Campania', 431, 'America/Indiana/Vevay', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1099, 'Campania', 709, 'Asia/Phnom_Penh', 1, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1100, 'Campania', 809, 'Europe/Belgrade', 0, '2025-05-24 04:03:40', '2025-05-24 04:03:40'),
(1101, 'Andalusia', 900, 'Africa/Bissau', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1102, 'Andalusia', 476, 'Asia/Tomsk', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1103, 'Andalusia', 465, 'America/Dawson_Creek', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1104, 'Andalusia', 52, 'Asia/Gaza', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1105, 'Andalusia', 815, 'Pacific/Galapagos', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1106, 'Andalusia', 9, 'Africa/Blantyre', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1107, 'Andalusia', 1152, 'Asia/Ust-Nera', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1108, 'Andalusia', 997, 'Asia/Dubai', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1109, 'Andalusia', 350, 'Asia/Bahrain', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1110, 'Andalusia', 654, 'America/Lower_Princes', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1111, 'Andalusia', 158, 'Africa/Sao_Tome', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1112, 'Andalusia', 796, 'America/Argentina/Tucuman', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1113, 'Andalusia', 859, 'America/Whitehorse', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1114, 'Andalusia', 1149, 'America/Boa_Vista', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1115, 'Andalusia', 1051, 'Asia/Jerusalem', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1116, 'Andalusia', 321, 'Africa/Luanda', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1117, 'Andalusia', 630, 'America/Swift_Current', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1118, 'Andalusia', 604, 'Asia/Yakutsk', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1119, 'Andalusia', 1140, 'Arctic/Longyearbyen', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1120, 'Andalusia', 393, 'America/Monterrey', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1121, 'Andalusia', 1125, 'Africa/Dar_es_Salaam', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1122, 'Andalusia', 247, 'Asia/Anadyr', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1123, 'Andalusia', 243, 'Asia/Kabul', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1124, 'Andalusia', 884, 'Europe/Podgorica', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1125, 'Andalusia', 318, 'America/Indiana/Marengo', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1126, 'Andalusia', 723, 'Asia/Phnom_Penh', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1127, 'Andalusia', 763, 'Africa/Johannesburg', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1128, 'Andalusia', 306, 'Asia/Yangon', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1129, 'Andalusia', 48, 'Pacific/Tongatapu', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1130, 'Andalusia', 670, 'Europe/Helsinki', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1131, 'Andalusia', 1197, 'America/El_Salvador', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1132, 'Andalusia', 222, 'Asia/Magadan', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1133, 'Andalusia', 420, 'Pacific/Rarotonga', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1134, 'Andalusia', 124, 'Africa/Mogadishu', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1135, 'Andalusia', 759, 'Europe/Sarajevo', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1136, 'Andalusia', 1148, 'Asia/Barnaul', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1137, 'Andalusia', 1041, 'America/Grand_Turk', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1138, 'Andalusia', 98, 'Africa/Cairo', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1139, 'Andalusia', 788, 'Atlantic/Madeira', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1140, 'Andalusia', 805, 'Asia/Kuala_Lumpur', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1141, 'Andalusia', 108, 'Pacific/Marquesas', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1142, 'Andalusia', 405, 'Indian/Kerguelen', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1143, 'Andalusia', 1125, 'Europe/Berlin', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1144, 'Andalusia', 498, 'America/Merida', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1145, 'Andalusia', 654, 'America/Juneau', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1146, 'Andalusia', 179, 'Africa/Maputo', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1147, 'Andalusia', 130, 'Australia/Broken_Hill', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1148, 'Andalusia', 1008, 'Europe/Guernsey', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1149, 'Andalusia', 69, 'Asia/Chita', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1150, 'Andalusia', 42, 'America/Juneau', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1151, 'Andalusia', 328, 'Indian/Kerguelen', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1152, 'Andalusia', 78, 'Asia/Pyongyang', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1153, 'Andalusia', 838, 'America/Nome', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1154, 'Andalusia', 554, 'America/Glace_Bay', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1155, 'Andalusia', 511, 'America/Argentina/Cordoba', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1156, 'Andalusia', 363, 'Asia/Novokuznetsk', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1157, 'Andalusia', 677, 'America/Jamaica', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1158, 'Andalusia', 1195, 'Asia/Kolkata', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1159, 'Andalusia', 161, 'America/Fortaleza', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1160, 'Andalusia', 1158, 'Pacific/Wake', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1161, 'Andalusia', 80, 'America/Swift_Current', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1162, 'Andalusia', 911, 'Pacific/Pohnpei', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1163, 'Andalusia', 560, 'Europe/Moscow', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1164, 'Andalusia', 1090, 'Pacific/Easter', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1165, 'Andalusia', 878, 'America/Glace_Bay', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1166, 'Andalusia', 212, 'Asia/Karachi', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1167, 'Andalusia', 1069, 'America/Menominee', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1168, 'Andalusia', 1148, 'America/Fortaleza', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1169, 'Andalusia', 683, 'Pacific/Chuuk', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1170, 'Andalusia', 172, 'Africa/Dakar', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1171, 'Andalusia', 506, 'America/Goose_Bay', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1172, 'Andalusia', 586, 'Asia/Barnaul', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1173, 'Andalusia', 922, 'America/Santarem', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1174, 'Andalusia', 469, 'America/Nuuk', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1175, 'Andalusia', 24, 'Asia/Baghdad', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1176, 'Andalusia', 12, 'Pacific/Efate', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1177, 'Andalusia', 1138, 'Asia/Yekaterinburg', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1178, 'Andalusia', 333, 'Pacific/Midway', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1179, 'Andalusia', 854, 'America/Manaus', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1180, 'Andalusia', 103, 'Africa/Bujumbura', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1181, 'Andalusia', 981, 'Europe/Astrakhan', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1182, 'Andalusia', 693, 'Africa/Addis_Ababa', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1183, 'Andalusia', 1165, 'Africa/Maseru', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1184, 'Andalusia', 542, 'America/Resolute', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1185, 'Andalusia', 369, 'Pacific/Rarotonga', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1186, 'Andalusia', 1013, 'Pacific/Pago_Pago', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1187, 'Andalusia', 657, 'Asia/Anadyr', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1188, 'Andalusia', 1187, 'Asia/Yakutsk', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1189, 'Andalusia', 484, 'Atlantic/Canary', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1190, 'Andalusia', 963, 'Europe/Simferopol', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1191, 'Andalusia', 556, 'Europe/Zurich', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1192, 'Andalusia', 1063, 'Europe/Chisinau', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1193, 'Andalusia', 1072, 'Indian/Mauritius', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1194, 'Andalusia', 994, 'Asia/Bangkok', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1195, 'Andalusia', 157, 'America/Glace_Bay', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1196, 'Andalusia', 928, 'Africa/Khartoum', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1197, 'Andalusia', 859, 'Pacific/Kwajalein', 1, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1198, 'Andalusia', 1017, 'Antarctica/Mawson', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1199, 'Andalusia', 678, 'America/Guadeloupe', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1200, 'Andalusia', 87, 'Pacific/Galapagos', 0, '2025-05-24 04:03:55', '2025-05-24 04:03:55'),
(1201, 'New Jersey', 959, 'America/Cancun', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1202, 'New Jersey', 590, 'Indian/Kerguelen', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1203, 'New Jersey', 1278, 'Asia/Kolkata', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1204, 'New Jersey', 936, 'Pacific/Chuuk', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1205, 'New Jersey', 780, 'Atlantic/Reykjavik', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1206, 'New Jersey', 946, 'Europe/Athens', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1207, 'New Jersey', 391, 'America/Sitka', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1208, 'New Jersey', 1048, 'America/Marigot', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1209, 'New Jersey', 1057, 'Africa/Tripoli', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1210, 'New Jersey', 704, 'Africa/Mogadishu', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1211, 'New Jersey', 1079, 'Africa/Mbabane', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1212, 'New Jersey', 806, 'America/Havana', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1213, 'New Jersey', 461, 'Asia/Pontianak', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1214, 'New Jersey', 450, 'America/Belem', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1215, 'New Jersey', 52, 'Asia/Samarkand', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1216, 'New Jersey', 978, 'Asia/Bishkek', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1217, 'New Jersey', 906, 'Europe/Dublin', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1218, 'New Jersey', 327, 'Asia/Dili', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1219, 'New Jersey', 601, 'Antarctica/McMurdo', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1220, 'New Jersey', 462, 'Australia/Broken_Hill', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1221, 'New Jersey', 921, 'America/Port_of_Spain', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1222, 'New Jersey', 607, 'America/Kentucky/Monticello', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1223, 'New Jersey', 1038, 'Antarctica/Davis', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1224, 'New Jersey', 422, 'Asia/Anadyr', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1225, 'New Jersey', 797, 'America/St_Lucia', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1226, 'New Jersey', 290, 'Europe/San_Marino', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1227, 'New Jersey', 1186, 'America/St_Thomas', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1228, 'New Jersey', 1025, 'Pacific/Fiji', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1229, 'New Jersey', 150, 'Antarctica/DumontDUrville', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1230, 'New Jersey', 1060, 'Atlantic/Stanley', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1231, 'New Jersey', 963, 'America/Maceio', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1232, 'New Jersey', 461, 'America/Nuuk', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1233, 'New Jersey', 597, 'Africa/Algiers', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1234, 'New Jersey', 1210, 'Asia/Yangon', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1235, 'New Jersey', 157, 'Atlantic/Cape_Verde', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1236, 'New Jersey', 565, 'America/Indiana/Winamac', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1237, 'New Jersey', 912, 'Asia/Baghdad', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1238, 'New Jersey', 216, 'America/Monterrey', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1239, 'New Jersey', 477, 'Asia/Tbilisi', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1240, 'New Jersey', 1071, 'Africa/Bangui', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1241, 'New Jersey', 268, 'Europe/Chisinau', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1242, 'New Jersey', 376, 'America/Cayman', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1243, 'New Jersey', 557, 'America/Argentina/Catamarca', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1244, 'New Jersey', 129, 'America/Fort_Nelson', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1245, 'New Jersey', 276, 'Asia/Yekaterinburg', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1246, 'New Jersey', 1156, 'America/Indiana/Marengo', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1247, 'New Jersey', 944, 'America/Argentina/Mendoza', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1248, 'New Jersey', 206, 'America/Aruba', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1249, 'New Jersey', 877, 'America/North_Dakota/Beulah', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1250, 'New Jersey', 90, 'Asia/Singapore', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1251, 'New Jersey', 296, 'America/Dominica', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1252, 'New Jersey', 197, 'Africa/El_Aaiun', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1253, 'New Jersey', 1268, 'Europe/Oslo', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1254, 'New Jersey', 1066, 'America/Bahia_Banderas', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1255, 'New Jersey', 857, 'Pacific/Tahiti', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1256, 'New Jersey', 804, 'Atlantic/Stanley', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1257, 'New Jersey', 116, 'Africa/Brazzaville', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1258, 'New Jersey', 731, 'Australia/Lindeman', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1259, 'New Jersey', 555, 'Europe/Gibraltar', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1260, 'New Jersey', 297, 'America/Grand_Turk', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1261, 'New Jersey', 815, 'America/Campo_Grande', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1262, 'New Jersey', 1073, 'Asia/Tomsk', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1263, 'New Jersey', 493, 'America/Glace_Bay', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1264, 'New Jersey', 969, 'Asia/Dhaka', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1265, 'New Jersey', 96, 'America/Bahia_Banderas', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1266, 'New Jersey', 1230, 'Asia/Bangkok', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1267, 'New Jersey', 1231, 'Pacific/Kwajalein', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1268, 'New Jersey', 849, 'Europe/Volgograd', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1269, 'New Jersey', 547, 'America/New_York', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1270, 'New Jersey', 166, 'Europe/Lisbon', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1271, 'New Jersey', 577, 'America/Indiana/Indianapolis', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1272, 'New Jersey', 489, 'Europe/London', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1273, 'New Jersey', 353, 'Africa/Addis_Ababa', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1274, 'New Jersey', 452, 'Africa/Asmara', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1275, 'New Jersey', 506, 'Pacific/Noumea', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1276, 'New Jersey', 1087, 'Europe/Helsinki', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1277, 'New Jersey', 146, 'Pacific/Bougainville', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1278, 'New Jersey', 448, 'Pacific/Tongatapu', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1279, 'New Jersey', 219, 'Asia/Vientiane', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1280, 'New Jersey', 252, 'Asia/Dili', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1281, 'New Jersey', 1199, 'Africa/Harare', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1282, 'New Jersey', 22, 'Europe/Oslo', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1283, 'New Jersey', 1084, 'America/Paramaribo', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1284, 'New Jersey', 986, 'America/St_Vincent', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1285, 'New Jersey', 1284, 'America/Montserrat', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1286, 'New Jersey', 200, 'America/Dawson_Creek', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1287, 'New Jersey', 318, 'America/Port_of_Spain', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1288, 'New Jersey', 46, 'Indian/Reunion', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1289, 'New Jersey', 2, 'Asia/Ulaanbaatar', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1290, 'New Jersey', 808, 'Asia/Phnom_Penh', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1291, 'New Jersey', 704, 'Asia/Dubai', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1292, 'New Jersey', 646, 'Africa/Abidjan', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1293, 'New Jersey', 736, 'America/Edmonton', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1294, 'New Jersey', 627, 'Pacific/Kosrae', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1295, 'New Jersey', 752, 'America/Argentina/Catamarca', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1296, 'New Jersey', 561, 'America/Argentina/Salta', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1297, 'New Jersey', 625, 'America/Punta_Arenas', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1298, 'New Jersey', 748, 'Europe/Monaco', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1299, 'New Jersey', 41, 'America/Sao_Paulo', 0, '2025-05-24 04:09:59', '2025-05-24 04:09:59'),
(1300, 'New Jersey', 612, 'America/Argentina/Ushuaia', 1, '2025-05-24 04:09:59', '2025-05-24 04:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_type` enum('grocery','bakery','medicine','makeup','bags','clothing','furniture','books','gadgets','animals-pet','fish') DEFAULT NULL,
  `tax` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_number` varchar(255) DEFAULT NULL,
  `subscription_type` varchar(50) DEFAULT NULL,
  `admin_commission_type` varchar(255) DEFAULT NULL,
  `admin_commission_amount` decimal(10,2) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL,
  `delivery_charge` decimal(10,2) DEFAULT NULL,
  `delivery_time` varchar(50) DEFAULT NULL,
  `delivery_self_system` tinyint(1) DEFAULT 0,
  `delivery_take_away` tinyint(1) DEFAULT 0,
  `order_minimum` int(11) DEFAULT 0,
  `veg_status` int(11) DEFAULT 0 COMMENT '0 = Non-Vegetarian, 1 = Vegetarian',
  `off_day` varchar(50) DEFAULT NULL,
  `enable_saling` int(11) DEFAULT 0 COMMENT '0 = Sales disabled, 1 = Sales enabled',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_image` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0 = Pending, 1 = Active, 2 = Inactive',
  `online_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `area_id`, `store_seller_id`, `store_type`, `tax`, `tax_number`, `subscription_type`, `admin_commission_type`, `admin_commission_amount`, `name`, `slug`, `phone`, `email`, `logo`, `banner`, `address`, `latitude`, `longitude`, `is_featured`, `opening_time`, `closing_time`, `delivery_charge`, `delivery_time`, `delivery_self_system`, `delivery_take_away`, `order_minimum`, `veg_status`, `off_day`, `enable_saling`, `meta_title`, `meta_description`, `meta_image`, `status`, `online_at`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'grocery', 5.00, 'VAT123457', 'commission', 'fixed', 10.00, 'Fresh Grocer', 'fresh-grocer', '1234567891', 'freshgrocer@gmail.com', '586', '592', '456 Green Lane, City', 23.7948895, 90.4051046, 1, '07:00:00', '21:00:00', 3.00, '30-45 minutes', 1, 1, 30, 1, 'Wednesday', 1, 'Fresh Grocer - Your Neighborhood Grocery Store', 'Find fresh and organic grocery items at Fresh Grocer.', '586', 1, NULL, 2, NULL, NULL, '2025-06-30 08:19:49', '2025-06-30 08:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `store_areas`
--

CREATE TABLE `store_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `coordinates` polygon DEFAULT NULL,
  `center_latitude` decimal(10,7) DEFAULT NULL,
  `center_longitude` decimal(10,7) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Inactive, 1=Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_areas`
--

INSERT INTO `store_areas` (`id`, `code`, `state`, `city`, `name`, `coordinates`, `center_latitude`, `center_longitude`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Dhaka', 'Dhaka City', 'Gulshan', 0x00000000010300000001000000070000002d23f59eca99564004e8f7fd9bcb3740c8cedbd8ec9956404f5df92ccfcb3740957d5704ff9956406abe4a3e76cb3740355eba490c9a564003249a4011cb37402d23f59eca99564004e8f7fd9bcb37402d23f59eca99564004e8f7fd9bcb37402d23f59eca99564004e8f7fd9bcb3740, 23.7950303, 90.4045412, 1, 1, NULL, '2025-06-30 08:29:51', '2025-06-30 08:29:51');

-- --------------------------------------------------------

--
-- Table structure for table `store_area_settings`
--

CREATE TABLE `store_area_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_area_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_time_per_km` int(11) NOT NULL,
  `min_order_delivery_fee` decimal(10,2) DEFAULT NULL,
  `delivery_charge_method` varchar(255) DEFAULT NULL COMMENT 'fixed, per_km, range_wise',
  `out_of_area_delivery_charge` decimal(10,2) DEFAULT NULL,
  `fixed_charge_amount` decimal(10,2) DEFAULT NULL,
  `per_km_charge_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_area_settings`
--

INSERT INTO `store_area_settings` (`id`, `store_area_id`, `delivery_time_per_km`, `min_order_delivery_fee`, `delivery_charge_method`, `out_of_area_delivery_charge`, `fixed_charge_amount`, `per_km_charge_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 50.00, 'per_km', 100.00, NULL, 5.00, '2025-03-10 01:43:00', '2025-06-17 08:30:56'),
(2, 2, 2, 10.00, 'fixed', 150.00, 100.00, 10.00, '2025-04-06 03:58:12', '2025-04-06 03:58:12'),
(3, 6, 100, 60.00, 'range_wise', 200.00, 20.00, 5.00, '2025-04-19 11:17:32', '2025-05-17 11:53:47'),
(4, 10, 60, 60.00, 'per_km', 100.00, 70.00, 2.00, '2025-06-18 09:09:24', '2025-06-18 09:45:55');

-- --------------------------------------------------------

--
-- Table structure for table `store_area_setting_range_charges`
--

CREATE TABLE `store_area_setting_range_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_area_setting_id` bigint(20) UNSIGNED NOT NULL,
  `min_km` decimal(8,2) NOT NULL,
  `max_km` decimal(8,2) NOT NULL,
  `charge_amount` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive, 1=Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_area_setting_range_charges`
--

INSERT INTO `store_area_setting_range_charges` (`id`, `store_area_setting_id`, `min_km`, `max_km`, `charge_amount`, `status`, `created_at`, `updated_at`) VALUES
(61, 3, 5.00, 10.00, 100.00, 1, '2025-05-17 11:53:47', '2025-05-17 11:53:47');

-- --------------------------------------------------------

--
-- Table structure for table `store_area_setting_store_types`
--

CREATE TABLE `store_area_setting_store_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_area_setting_id` bigint(20) UNSIGNED NOT NULL,
  `store_type_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive, 1=Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_area_setting_store_types`
--

INSERT INTO `store_area_setting_store_types` (`id`, `store_area_setting_id`, `store_type_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(2, 1, 2, 1, '2025-03-10 01:43:00', '2025-03-10 01:43:00'),
(4, 2, 1, 1, NULL, NULL),
(5, 2, 5, 1, NULL, NULL),
(9, 3, 1, 1, NULL, NULL),
(23, 1, 4, 1, NULL, NULL),
(24, 1, 5, 1, NULL, NULL),
(26, 3, 3, 1, NULL, NULL),
(27, 1, 3, 1, NULL, NULL),
(28, 1, 6, 1, NULL, NULL),
(29, 1, 9, 1, NULL, NULL),
(30, 1, 8, 1, NULL, NULL),
(31, 1, 7, 1, NULL, NULL),
(32, 1, 10, 1, NULL, NULL),
(33, 1, 11, 1, NULL, NULL),
(34, 4, 1, 1, NULL, NULL),
(35, 4, 2, 1, NULL, NULL),
(36, 4, 3, 1, NULL, NULL),
(37, 4, 4, 1, NULL, NULL),
(38, 4, 5, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_notices`
--

CREATE TABLE `store_notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` longtext DEFAULT NULL,
  `type` enum('general','specific_store','specific_seller') NOT NULL DEFAULT 'general' COMMENT 'general, specific_store, specific_seller',
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'low' COMMENT 'Priority: low, medium, high',
  `active_date` datetime DEFAULT NULL COMMENT 'Start date of the notice',
  `expire_date` datetime DEFAULT NULL COMMENT 'End date of the notice',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_notice_recipients`
--

CREATE TABLE `store_notice_recipients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notice_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_sellers`
--

CREATE TABLE `store_sellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` double DEFAULT NULL,
  `num_of_reviews` int(11) DEFAULT NULL,
  `num_of_sale` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_sellers`
--

INSERT INTO `store_sellers` (`id`, `user_id`, `rating`, `num_of_reviews`, `num_of_sale`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, NULL, 1, NULL, NULL, '2025-06-30 08:40:58', '2025-06-30 08:40:58');

-- --------------------------------------------------------

--
-- Table structure for table `store_subscriptions`
--

CREATE TABLE `store_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `validity` int(11) NOT NULL,
  `price` double NOT NULL DEFAULT 0,
  `pos_system` tinyint(1) NOT NULL DEFAULT 0,
  `self_delivery` tinyint(1) NOT NULL DEFAULT 0,
  `mobile_app` tinyint(1) NOT NULL DEFAULT 0,
  `live_chat` tinyint(1) NOT NULL DEFAULT 0,
  `order_limit` int(11) NOT NULL DEFAULT 0,
  `product_limit` int(11) NOT NULL DEFAULT 0,
  `product_featured_limit` int(11) NOT NULL DEFAULT 0,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `transaction_ref` varchar(255) DEFAULT NULL,
  `manual_image` varchar(255) DEFAULT NULL,
  `expire_date` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=active, 2=cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_types`
--

CREATE TABLE `store_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `total_stores` bigint(20) NOT NULL DEFAULT 0,
  `additional_charge_enable_disable` tinyint(1) NOT NULL DEFAULT 0,
  `additional_charge_name` varchar(255) DEFAULT NULL,
  `additional_charge_amount` decimal(8,2) DEFAULT NULL,
  `additional_charge_type` enum('fixed','percentage') DEFAULT NULL,
  `additional_charge_commission` decimal(8,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Inactive, 1=Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_types`
--

INSERT INTO `store_types` (`id`, `name`, `type`, `image`, `description`, `total_stores`, `additional_charge_enable_disable`, `additional_charge_name`, `additional_charge_amount`, `additional_charge_type`, `additional_charge_commission`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Grocery', 'grocery', '261', 'Grocery', 7, 1, 'Packaging Charge', 10.00, 'percentage', 80.00, 1, NULL, '2025-06-16 05:10:45'),
(2, 'Bakery', 'bakery', '262', NULL, 2, 1, 'Packaging charge', 10.00, 'percentage', 5.00, 1, NULL, '2025-06-18 09:35:01'),
(3, 'Medicine', 'medicine', '263', NULL, 2, 1, 'MediSafe Fee', 10.00, 'fixed', 2.00, 1, NULL, '2025-06-18 09:35:24'),
(4, 'Makeup', 'makeup', '264', NULL, 3, 1, 'Packaging Fee', 12.00, 'percentage', 10.00, 1, NULL, '2025-06-18 09:35:46'),
(5, 'Bags', 'bags', '265', NULL, 1, 1, 'Packaging Fee', 10.00, 'percentage', 15.00, 1, NULL, '2025-06-18 09:36:03'),
(6, 'Clothing', 'clothing', '266', NULL, 3, 0, 'Packaging Fee', 10.00, 'percentage', 12.00, 1, NULL, '2025-06-18 09:36:25'),
(7, 'Furniture', 'furniture', '267', NULL, 1, 0, 'Packaging Fee', 10.00, 'percentage', 10.00, 1, NULL, '2025-06-18 09:36:46'),
(8, 'Books', 'books', '268', NULL, 2, 1, 'Packaging Fee', 5.00, 'fixed', 5.00, 1, NULL, '2025-06-18 09:37:16'),
(9, 'Gadgets', 'gadgets', '269', NULL, 7, 1, 'Packaging Fee', 10.00, 'percentage', 10.00, 1, NULL, '2025-06-18 09:37:38'),
(10, 'Animals & Pets', 'animals-pet', '270', NULL, 5, 1, 'Packaging Fee', 10.00, 'percentage', 5.00, 1, NULL, '2025-06-18 09:38:02'),
(11, 'Fish', 'fish', '271', NULL, 5, 0, 'Packaging Fee', 10.00, 'percentage', 10.00, 1, NULL, '2025-06-18 09:38:50');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_subscribed` tinyint(1) NOT NULL DEFAULT 1,
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `validity` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` double NOT NULL DEFAULT 0,
  `pos_system` tinyint(1) NOT NULL DEFAULT 0,
  `self_delivery` tinyint(1) NOT NULL DEFAULT 0,
  `mobile_app` tinyint(1) NOT NULL DEFAULT 0,
  `live_chat` tinyint(1) NOT NULL DEFAULT 0,
  `order_limit` int(11) NOT NULL DEFAULT 0,
  `product_limit` int(11) NOT NULL DEFAULT 0,
  `product_featured_limit` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `name`, `type`, `validity`, `image`, `description`, `price`, `pos_system`, `self_delivery`, `mobile_app`, `live_chat`, `order_limit`, `product_limit`, `product_featured_limit`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Trial Package', 'Weekly', 7, '750', 'Free Package', 0, 0, 0, 0, 0, 10, 10, 2, 1, '2025-04-17 07:05:16', '2025-06-18 08:52:27'),
(3, 'Basic Package', 'Monthly', 30, '748', 'Basic Package', 30, 1, 0, 0, 0, 50, 50, 5, 1, '2025-04-17 07:05:16', '2025-06-18 10:23:52'),
(4, 'Standard Package', 'Half-Yearly', 180, '749', NULL, 100, 1, 1, 0, 1, 100, 150, 10, 1, '2025-04-17 07:05:16', '2025-05-20 12:19:37'),
(5, 'Premium Package', 'Yearly', 365, '747', NULL, 200, 1, 1, 1, 1, 500, 200, 15, 1, '2025-04-17 07:05:16', '2025-05-20 12:19:20'),
(6, 'Enterprise Package', 'Extended', 1095, '751', NULL, 500, 1, 1, 1, 1, 1000, 500, 25, 1, '2025-04-17 07:05:16', '2025-05-20 12:22:24');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_histories`
--

CREATE TABLE `subscription_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_subscription_id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `validity` int(11) NOT NULL,
  `price` double NOT NULL DEFAULT 0,
  `pos_system` tinyint(1) NOT NULL DEFAULT 0,
  `self_delivery` tinyint(1) NOT NULL DEFAULT 0,
  `mobile_app` tinyint(1) NOT NULL DEFAULT 0,
  `live_chat` tinyint(1) NOT NULL DEFAULT 0,
  `order_limit` int(11) NOT NULL DEFAULT 0,
  `product_limit` int(11) NOT NULL DEFAULT 0,
  `product_featured_limit` int(11) NOT NULL DEFAULT 0,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL COMMENT 'pending , paid, failed',
  `transaction_ref` varchar(255) DEFAULT NULL,
  `manual_image` varchar(255) DEFAULT NULL,
  `expire_date` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=active, 2=cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_commissions`
--

CREATE TABLE `system_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `commission_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `commission_type` varchar(255) DEFAULT NULL,
  `commission_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `default_order_commission_rate` decimal(8,2) DEFAULT NULL,
  `default_delivery_commission_charge` decimal(8,2) DEFAULT NULL,
  `order_shipping_charge` decimal(8,2) DEFAULT NULL,
  `order_confirmation_by` varchar(255) NOT NULL DEFAULT 'deliveryman',
  `order_include_tax_amount` tinyint(1) NOT NULL DEFAULT 0,
  `order_additional_charge_enable_disable` tinyint(1) NOT NULL DEFAULT 0,
  `order_additional_charge_name` varchar(255) DEFAULT NULL,
  `order_additional_charge_amount` decimal(8,2) DEFAULT NULL,
  `order_additional_charge_commission` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_commissions`
--

INSERT INTO `system_commissions` (`id`, `subscription_enabled`, `commission_enabled`, `commission_type`, `commission_amount`, `default_order_commission_rate`, `default_delivery_commission_charge`, `order_shipping_charge`, `order_confirmation_by`, `order_include_tax_amount`, `order_additional_charge_enable_disable`, `order_additional_charge_name`, `order_additional_charge_amount`, `order_additional_charge_commission`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'fixed', 10.00, 20.00, 10.00, 1.00, 'deliveryman', 1, 1, 'Processing Fee', 0.00, 0.00, NULL, '2025-06-18 09:15:23');

-- --------------------------------------------------------

--
-- Table structure for table `system_management`
--

CREATE TABLE `system_management` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `priority` varchar(255) DEFAULT NULL COMMENT 'low,high,medium,urgent',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active',
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_role` varchar(255) DEFAULT NULL,
  `receiver_role` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `translatable_id` bigint(20) UNSIGNED NOT NULL,
  `translatable_type` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL DEFAULT 'en',
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `universal_notifications`
--

CREATE TABLE `universal_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `notifiable_type` enum('admin','store','customer','deliveryman') NOT NULL DEFAULT 'customer',
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `status` enum('unread','read') NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `activity_scope` varchar(255) DEFAULT NULL,
  `email_verify_token` text DEFAULT NULL,
  `email_verified` int(11) NOT NULL DEFAULT 0 COMMENT '0=unverified, 1=verified',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `def_lang` varchar(255) DEFAULT NULL,
  `activity_notification` tinyint(1) NOT NULL DEFAULT 1,
  `firebase_token` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `apple_id` varchar(255) DEFAULT NULL,
  `store_owner` bigint(20) UNSIGNED DEFAULT NULL COMMENT '1=store_owner',
  `store_seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`stores`)),
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Inactive,1=Active,2=Suspended',
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `online_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `deactivated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `slug`, `phone`, `email`, `activity_scope`, `email_verify_token`, `email_verified`, `email_verified_at`, `password`, `password_changed_at`, `image`, `def_lang`, `activity_notification`, `firebase_token`, `google_id`, `facebook_id`, `apple_id`, `store_owner`, `store_seller_id`, `stores`, `status`, `is_available`, `online_at`, `remember_token`, `deactivated_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Seller', NULL, 'seller', NULL, 'seller@gmail.com', 'store_level', NULL, 1, '2025-06-30 08:36:38', '$2y$12$GLk.V7aTwFT1DIkYy.AU6uXxqJPw1D8PgPUcbEn3UMIErt82ecBpC', NULL, '765', 'en', 1, NULL, NULL, NULL, NULL, 1, 1, NULL, 1, 1, NULL, NULL, NULL, NULL, '2025-06-30 08:36:38', '2025-06-30 08:36:38'),
(3, 'Deliveryman', NULL, 'deliveryman', NULL, 'deliveryman@gmail.com', 'delivery_level', NULL, 1, '2025-06-30 08:50:54', '$2y$12$KXL/yrwGkz6AHNk6aaGfVO1Fs9SwHfnn2iHPYGdM3aca7MA7LfCzK', NULL, NULL, 'en', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2025-06-30 08:50:54', '2025-06-30 08:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_otps`
--

CREATE TABLE `user_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `otp_code` varchar(255) NOT NULL,
  `expired_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

CREATE TABLE `vehicle_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `capacity` int(11) DEFAULT NULL COMMENT 'Load capacity in kilograms.',
  `speed_range` varchar(255) DEFAULT NULL COMMENT 'Average speed range, e.g., 20-40 km/h.',
  `fuel_type` enum('petrol','diesel','electric','hybrid') DEFAULT NULL,
  `max_distance` int(11) DEFAULT NULL COMMENT 'Maximum distance per trip in kilometers.',
  `extra_charge` decimal(8,2) DEFAULT NULL COMMENT 'Applicable if exceed max distance limit',
  `average_fuel_cost` decimal(8,2) DEFAULT NULL COMMENT 'Fuel cost per trip.',
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `owner_type` varchar(255) NOT NULL COMMENT 'store or deliveryman or customer',
  `balance` double NOT NULL DEFAULT 0,
  `earnings` decimal(15,2) NOT NULL DEFAULT 0.00,
  `withdrawn` decimal(15,2) NOT NULL DEFAULT 0.00,
  `refunds` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_ref` varchar(255) DEFAULT NULL,
  `transaction_details` text DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL COMMENT 'credit or debit',
  `purpose` varchar(255) DEFAULT NULL,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL COMMENT 'pending , paid, failed',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=success',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_withdrawals_transactions`
--

CREATE TABLE `wallet_withdrawals_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `owner_type` varchar(255) DEFAULT NULL COMMENT 'store or deliveryman or customer',
  `withdraw_gateway_id` bigint(20) UNSIGNED NOT NULL,
  `gateway_name` varchar(255) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `fee` decimal(15,2) NOT NULL DEFAULT 0.00,
  `gateways_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gateways_options`)),
  `details` longtext DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending' COMMENT 'pending, approved, rejected',
  `reject_reason` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `web_push_tokens`
--

CREATE TABLE `web_push_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `endpoint` varchar(255) NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `content_encoding` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_gateways`
--

CREATE TABLE `withdraw_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'stored as JSON' CHECK (json_valid(`fields`)),
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdraw_gateways`
--

INSERT INTO `withdraw_gateways` (`id`, `name`, `fields`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PayPal', '[\"Account Name:\",\"Account Holder Name:\",\"Account Number:\"]', 1, '2025-03-10 01:50:38', '2025-05-15 10:41:06'),
(2, 'Stripe', '[\"Account Name\",\"Account Number\",\"Branch Name\"]', 1, '2025-03-20 02:33:34', '2025-05-14 10:54:46'),
(3, 'Paytm', '[\"Account Name\",\"Account Number\",\"Account Type\"]', 1, '2025-03-20 02:34:25', '2025-03-20 02:34:34'),
(6, 'Wing Dalton', '[\"In totam hic id facilis cupidatat earum porro commodi delectus\"]', 1, '2025-04-23 04:54:11', '2025-05-07 03:30:28'),
(11, 'Payoneer', '[\"Account Name\"]', 1, '2025-05-15 03:52:59', '2025-05-15 03:53:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_settings`
--
ALTER TABLE `about_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areas_city_id_index` (`city_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `become_seller_settings`
--
ALTER TABLE `become_seller_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_categories_name_unique` (`name`),
  ADD UNIQUE KEY `blog_categories_slug_unique` (`slug`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comment_reactions`
--
ALTER TABLE `blog_comment_reactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_views`
--
ALTER TABLE `blog_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_chat_id_foreign` (`chat_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_state_id_index` (`state_id`);

--
-- Indexes for table `contact_settings`
--
ALTER TABLE `contact_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us_messages`
--
ALTER TABLE `contact_us_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_lines`
--
ALTER TABLE `coupon_lines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_lines_coupon_code_unique` (`coupon_code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_deactivation_reasons`
--
ALTER TABLE `customer_deactivation_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveryman_deactivation_reasons`
--
ALTER TABLE `deliveryman_deactivation_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_man_reviews`
--
ALTER TABLE `delivery_man_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_men`
--
ALTER TABLE `delivery_men`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `delivery_men_identification_number_unique` (`identification_number`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_templates_type_unique` (`type`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flash_sales`
--
ALTER TABLE `flash_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_sale_products`
--
ALTER TABLE `flash_sale_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `linked_social_accounts`
--
ALTER TABLE `linked_social_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `linked_social_accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `live_locations`
--
ALTER TABLE `live_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `live_locations_trackable_type_trackable_id_index` (`trackable_type`,`trackable_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_user_id_index` (`user_id`),
  ADD KEY `media_name_index` (`name`),
  ADD KEY `media_path_index` (`path`),
  ADD KEY `media_dimensions_index` (`dimensions`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_invoice_number_unique` (`invoice_number`);

--
-- Indexes for table `order_activities`
--
ALTER TABLE `order_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_addresses`
--
ALTER TABLE `order_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_delivery_histories`
--
ALTER TABLE `order_delivery_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_masters`
--
ALTER TABLE `order_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_refunds`
--
ALTER TABLE `order_refunds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_refund_reasons`
--
ALTER TABLE `order_refund_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`) USING HASH;

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_available_for_unique` (`name`,`guard_name`,`available_for`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_authors`
--
ALTER TABLE `product_authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_brand`
--
ALTER TABLE `product_brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_queries`
--
ALTER TABLE `product_queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variants_product_id_index` (`product_id`),
  ADD KEY `product_variants_sku_index` (`sku`);

--
-- Indexes for table `product_views`
--
ALTER TABLE `product_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `push_subscriptions_endpoint_unique` (`endpoint`),
  ADD KEY `push_subscriptions_subscribable_type_subscribable_id_index` (`subscribable_type`,`subscribable_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_reactions`
--
ALTER TABLE `review_reactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `setting_options`
--
ALTER TABLE `setting_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_providers`
--
ALTER TABLE `sms_providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sms_providers_slug_unique` (`slug`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_index` (`country_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stores_slug_unique` (`slug`);

--
-- Indexes for table `store_areas`
--
ALTER TABLE `store_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_area_settings`
--
ALTER TABLE `store_area_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_area_setting_range_charges`
--
ALTER TABLE `store_area_setting_range_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_area_setting_store_types`
--
ALTER TABLE `store_area_setting_store_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_notices`
--
ALTER TABLE `store_notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_notice_recipients`
--
ALTER TABLE `store_notice_recipients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_sellers`
--
ALTER TABLE `store_sellers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_subscriptions`
--
ALTER TABLE `store_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_types`
--
ALTER TABLE `store_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_histories`
--
ALTER TABLE `subscription_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_commissions`
--
ALTER TABLE `system_commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_management`
--
ALTER TABLE `system_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_department_id_index` (`department_id`),
  ADD KEY `tickets_customer_id_index` (`customer_id`),
  ADD KEY `tickets_store_id_index` (`store_id`);

--
-- Indexes for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_messages_ticket_id_index` (`ticket_id`),
  ADD KEY `ticket_messages_sender_id_index` (`sender_id`),
  ADD KEY `ticket_messages_receiver_id_index` (`receiver_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translations_translatable_id_translatable_type_index` (`translatable_id`,`translatable_type`),
  ADD KEY `translations_language_key_index` (`language`,`key`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `universal_notifications`
--
ALTER TABLE `universal_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_slug_unique` (`slug`);

--
-- Indexes for table `user_otps`
--
ALTER TABLE `user_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_otps_user_id_user_type_index` (`user_id`,`user_type`);

--
-- Indexes for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_types_name_unique` (`name`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallets_owner_id_owner_type_index` (`owner_id`,`owner_type`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_id` (`wallet_id`);

--
-- Indexes for table `wallet_withdrawals_transactions`
--
ALTER TABLE `wallet_withdrawals_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_withdrawals_transactions_owner_id_owner_type_status_index` (`owner_id`,`owner_type`,`status`),
  ADD KEY `wallet_withdrawals_transactions_wallet_id_index` (`wallet_id`),
  ADD KEY `wallet_withdrawals_transactions_owner_id_index` (`owner_id`),
  ADD KEY `wallet_withdrawals_transactions_withdraw_gateway_id_index` (`withdraw_gateway_id`),
  ADD KEY `wallet_withdrawals_transactions_approved_by_index` (`approved_by`);

--
-- Indexes for table `web_push_tokens`
--
ALTER TABLE `web_push_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_gateways`
--
ALTER TABLE `withdraw_gateways`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_settings`
--
ALTER TABLE `about_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `become_seller_settings`
--
ALTER TABLE `become_seller_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_comment_reactions`
--
ALTER TABLE `blog_comment_reactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_views`
--
ALTER TABLE `blog_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1301;

--
-- AUTO_INCREMENT for table `contact_settings`
--
ALTER TABLE `contact_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_us_messages`
--
ALTER TABLE `contact_us_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1301;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_lines`
--
ALTER TABLE `coupon_lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_deactivation_reasons`
--
ALTER TABLE `customer_deactivation_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deliveryman_deactivation_reasons`
--
ALTER TABLE `deliveryman_deactivation_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_man_reviews`
--
ALTER TABLE `delivery_man_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_men`
--
ALTER TABLE `delivery_men`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flash_sales`
--
ALTER TABLE `flash_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flash_sale_products`
--
ALTER TABLE `flash_sale_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `linked_social_accounts`
--
ALTER TABLE `linked_social_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `live_locations`
--
ALTER TABLE `live_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=872;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_activities`
--
ALTER TABLE `order_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_addresses`
--
ALTER TABLE `order_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_delivery_histories`
--
ALTER TABLE `order_delivery_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_masters`
--
ALTER TABLE `order_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_refunds`
--
ALTER TABLE `order_refunds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_refund_reasons`
--
ALTER TABLE `order_refund_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5525;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_authors`
--
ALTER TABLE `product_authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_brand`
--
ALTER TABLE `product_brand`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_queries`
--
ALTER TABLE `product_queries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_tags`
--
ALTER TABLE `product_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_views`
--
ALTER TABLE `product_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_reactions`
--
ALTER TABLE `review_reactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `setting_options`
--
ALTER TABLE `setting_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_providers`
--
ALTER TABLE `sms_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1301;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_areas`
--
ALTER TABLE `store_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_area_settings`
--
ALTER TABLE `store_area_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `store_area_setting_range_charges`
--
ALTER TABLE `store_area_setting_range_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `store_area_setting_store_types`
--
ALTER TABLE `store_area_setting_store_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `store_notices`
--
ALTER TABLE `store_notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_notice_recipients`
--
ALTER TABLE `store_notice_recipients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_sellers`
--
ALTER TABLE `store_sellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_subscriptions`
--
ALTER TABLE `store_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_types`
--
ALTER TABLE `store_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `subscription_histories`
--
ALTER TABLE `subscription_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_commissions`
--
ALTER TABLE `system_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_management`
--
ALTER TABLE `system_management`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `universal_notifications`
--
ALTER TABLE `universal_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_otps`
--
ALTER TABLE `user_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_withdrawals_transactions`
--
ALTER TABLE `wallet_withdrawals_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web_push_tokens`
--
ALTER TABLE `web_push_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_gateways`
--
ALTER TABLE `withdraw_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_chat_id_foreign` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
