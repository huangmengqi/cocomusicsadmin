-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2019 at 10:05 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_mp3_buyer`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `email`, `image`) VALUES
(1, 'admin', 'admin', 'viaviwebtech@gmail.com', 'profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_album`
--

CREATE TABLE `tbl_album` (
  `aid` int(11) NOT NULL,
  `artist_ids` varchar(255) DEFAULT NULL,
  `album_name` varchar(255) NOT NULL,
  `album_image` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_album`
--

INSERT INTO `tbl_album` (`aid`, `artist_ids`, `album_name`, `album_image`, `status`) VALUES
(1, '6,2', 'Soul of a Woman', '76626_Friendship-status-whatsapp.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_artist`
--

CREATE TABLE `tbl_artist` (
  `id` int(11) NOT NULL,
  `artist_name` varchar(255) NOT NULL,
  `artist_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_artist`
--

INSERT INTO `tbl_artist` (`id`, `artist_name`, `artist_image`) VALUES
(2, 'Arijit Singh', '17764_Friendship-Quotes-696x392.jpg'),
(6, 'A. R. Rahman', '87459_Top-30-Funny-Minions-Friendship-Quotes-Funniest1.jpg'),
(8, 'Badshah', '25816_Friendship-Day-Quotes.jpg'),
(10, 'Alka Yagnik', '91468_tmp773479278535770114.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `bid` int(11) NOT NULL,
  `banner_title` varchar(255) NOT NULL,
  `banner_sort_info` varchar(500) NOT NULL,
  `banner_image` varchar(255) NOT NULL,
  `banner_songs` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_banner`
--

INSERT INTO `tbl_banner` (`bid`, `banner_title`, `banner_sort_info`, `banner_image`, `banner_songs`, `status`) VALUES
(3, 'Bollywood Songs', 'This is demo banner', '37401_happy-friendship-day-cards.jpg', '15,14,13,11,10', 1),
(4, 'DJ Rock', 'DJ Rock Info', '74983_Friendship-Day-HD-Pics-Photos-Free-Download-3.jpg', '15,13', 1),
(5, 'Hip Hop', 'Hip Hop Info', '14736_5721832805_9e09d9fc8f.jpg', '14,12', 1),
(6, 'Old Classicals', 'Old classicals hits of all time', '18670_3042244d8eed482072bc84f60f03c49a.jpg', '18,17,13,10,9', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cid`, `category_name`, `category_image`, `status`) VALUES
(4, 'Indipop Mp3 Songs', '23393_5721832805_9e09d9fc8f.jpg', 1),
(5, 'Instrumental Songs Collections', '28075_Friendship-Day-Quotes.jpg', 1),
(6, 'Hollywood', '32706_3042244d8eed482072bc84f60f03c49a.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mp3`
--

CREATE TABLE `tbl_mp3` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `mp3_type` varchar(255) NOT NULL,
  `mp3_title` varchar(100) NOT NULL,
  `mp3_url` text NOT NULL,
  `mp3_thumbnail` varchar(255) NOT NULL,
  `mp3_duration` varchar(255) NOT NULL,
  `mp3_artist` text NOT NULL,
  `mp3_description` text NOT NULL,
  `total_rate` int(11) NOT NULL DEFAULT '0',
  `rate_avg` int(11) NOT NULL DEFAULT '0',
  `total_views` int(11) NOT NULL DEFAULT '0',
  `total_download` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_mp3`
--

INSERT INTO `tbl_mp3` (`id`, `cat_id`, `album_id`, `mp3_type`, `mp3_title`, `mp3_url`, `mp3_thumbnail`, `mp3_duration`, `mp3_artist`, `mp3_description`, `total_rate`, `rate_avg`, `total_views`, `total_download`, `status`) VALUES
(17, 4, 2, 'server_url', 'Issaqbaazi -Zero', 'http://www.viaviweb.in/envato/cc/online_mp3_app_demo/uploads/40655_Overboard.mp3', '11120_images.jpg', '1:53', 'Kishore Kumar', '<p>Issaqbaazi -Zero Info</p>\r\n', 20, 4, 2299, 226, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mp3_views`
--

CREATE TABLE `tbl_mp3_views` (
  `view_id` bigint(20) NOT NULL,
  `mp3_id` bigint(20) NOT NULL,
  `views` bigint(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_playlist`
--

CREATE TABLE `tbl_playlist` (
  `pid` int(11) NOT NULL,
  `playlist_name` varchar(255) NOT NULL,
  `playlist_image` varchar(255) NOT NULL,
  `playlist_songs` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_playlist`
--

INSERT INTO `tbl_playlist` (`pid`, `playlist_name`, `playlist_image`, `playlist_songs`, `status`) VALUES
(1, 'Playlist 1', '20374_5721832805_9e09d9fc8f.jpg', '15,14,13', 1),
(2, 'Trending Classical Songs 2017 - 2018', '96632_images.jpg', '13,12,11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `rate` int(11) NOT NULL,
  `dt_rate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE `tbl_reports` (
  `id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `envato_buyer_name` varchar(255) NOT NULL,
  `envato_purchase_code` varchar(255) NOT NULL,
  `envato_buyer_email` varchar(150) NOT NULL,
  `envato_purchased_status` int(1) NOT NULL DEFAULT '0',
  `package_name` varchar(255) NOT NULL,
  `onesignal_app_id` varchar(500) NOT NULL,
  `onesignal_rest_key` varchar(500) NOT NULL,
  `email_from` varchar(255) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `app_logo` varchar(255) NOT NULL,
  `app_email` varchar(255) NOT NULL,
  `app_version` varchar(255) NOT NULL,
  `app_author` varchar(255) NOT NULL,
  `app_contact` varchar(255) NOT NULL,
  `app_website` varchar(255) NOT NULL,
  `app_description` text NOT NULL,
  `app_developed_by` varchar(255) NOT NULL,
  `app_privacy_policy` text NOT NULL,
  `api_latest_limit` int(3) NOT NULL,
  `api_cat_order_by` varchar(255) NOT NULL,
  `api_cat_post_order_by` varchar(255) NOT NULL,
  `publisher_id` varchar(500) NOT NULL,
  `interstital_ad` varchar(500) NOT NULL,
  `interstital_ad_id` varchar(500) NOT NULL,
  `interstital_ad_click` varchar(500) NOT NULL,
  `banner_ad` varchar(500) NOT NULL,
  `banner_ad_id` varchar(500) NOT NULL,
  `song_download` varchar(255) NOT NULL DEFAULT 'true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `envato_buyer_name`, `envato_purchase_code`, `envato_buyer_email`, `envato_purchased_status`, `package_name`, `onesignal_app_id`, `onesignal_rest_key`, `email_from`, `app_name`, `app_logo`, `app_email`, `app_version`, `app_author`, `app_contact`, `app_website`, `app_description`, `app_developed_by`, `app_privacy_policy`, `api_latest_limit`, `api_cat_order_by`, `api_cat_post_order_by`, `publisher_id`, `interstital_ad`, `interstital_ad_id`, `interstital_ad_click`, `banner_ad`, `banner_ad_id`, `song_download`) VALUES
(1, '', '', '', 0, 'com.vpapps.onlinemp3', 'cdccea80-d484-48dd-8bb4-3d289100b189', 'NDBkOTcyZDEtZGM4Mi00ODE3LTk0ZDYtNmJlYTRkM2EyODVk', 'info@viaviweb.com', 'Online MP3 App', 'Webp.net-resizeimage.png', 'info@viaviweb.com', '1.0.0', 'Viavi Webtech', '+91 9227777522', 'www.viaviweb.com', '<p><strong>Online mp3&nbsp;</strong>is an Mp3 Songs app. You can stream songs from large collection of songs. You can search you favourite songs or go through your favourite categories. Get all the latest songs here and keep listening everyday.&nbsp;</p>\r\n\r\n<p>The application is specially optimized to be extremely easy to configure and detailed documentation is provided.<br />\r\n<br />\r\nThough if you have any query can contact us any time vai skype or whatsapp.<br />\r\n<br />\r\n<strong>Skype: </strong>viaviwebtech / support.viaviweb<br />\r\n<strong>WhatsApp:</strong> +919227777522</p>\r\n\r\n<h3>You can check our other Apps on Envato via below link.<br />\r\n<br />\r\n<a href=\"http://codecanyon.net/user/viaviwebtech/portfolio?ref=viaviwebtech\">https://codecanyon.net/user/viaviwebtech/portfolio?ref=viaviwebtech</a></h3>\r\n', 'Viavi Webtech', '<p><strong>We are committed to protecting your privacy</strong></p>\n\n<p>We collect the minimum amount of information about you that is commensurate with providing you with a satisfactory service. This policy indicates the type of processes that may result in data being collected about you. Your use of this website gives us the right to collect that information.&nbsp;</p>\n\n<p><strong>Information Collected</strong></p>\n\n<p>We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p>\n\n<p><strong>Information Use</strong></p>\n\n<p>We use the information collected primarily to process the task for which you visited the website. Data collected in the UK is held in accordance with the Data Protection Act. All reasonable precautions are taken to prevent unauthorised access to this information. This safeguard may require you to provide additional forms of identity should you wish to obtain information about your account details.</p>\n\n<p><strong>Cookies</strong></p>\n\n<p>Your Internet browser has the in-built facility for storing small files - &quot;cookies&quot; - that hold information which allows a website to recognise your account. Our website takes advantage of this facility to enhance your experience. You have the ability to prevent your computer from accepting cookies but, if you do, certain functionality on the website may be impaired.</p>\n\n<p><strong>Disclosing Information</strong></p>\n\n<p>We do not disclose any personal information obtained about you from this website to third parties unless you permit us to do so by ticking the relevant boxes in registration or competition forms. We may also use the information to keep in contact with you and inform you of developments associated with us. You will be given the opportunity to remove yourself from any mailing list or similar device. If at any time in the future we should wish to disclose information collected on this website to any third party, it would only be with your knowledge and consent.&nbsp;</p>\n\n<p>We may from time to time provide information of a general nature to third parties - for example, the number of individuals visiting our website or completing a registration form, but we will not use any information that could identify those individuals.&nbsp;</p>\n\n<p>In addition Dummy may work with third parties for the purpose of delivering targeted behavioural advertising to the Dummy website. Through the use of cookies, anonymous information about your use of our websites and other websites will be used to provide more relevant adverts about goods and services of interest to you. For more information on online behavioural advertising and about how to turn this feature off, please visit youronlinechoices.com/opt-out.</p>\n\n<p><strong>Changes to this Policy</strong></p>\n\n<p>Any changes to our Privacy Policy will be placed here and will supersede this version of our policy. We will take reasonable steps to draw your attention to any changes in our policy. However, to be on the safe side, we suggest that you read this document each time you use the website to ensure that it still meets with your approval.</p>\n\n<p><strong>Contacting Us</strong></p>\n\n<p>If you have any questions about our Privacy Policy, or if you want to know what information we have collected about you, please email us at hd@dummy.com. You can also correct any factual errors in that information or require us to remove your details form any list under our control.</p>\n', 15, 'category_name', 'DESC', 'pub-8356404931736973', 'true', 'ca-app-pub-3940256099942544/1033173712', '5', 'true', 'ca-app-pub-3940256099942544/6300978111', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smtp_settings`
--

CREATE TABLE `tbl_smtp_settings` (
  `id` int(5) NOT NULL,
  `smtp_host` varchar(150) NOT NULL,
  `smtp_email` varchar(150) NOT NULL,
  `smtp_password` text NOT NULL,
  `smtp_secure` varchar(20) NOT NULL,
  `port_no` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_song_suggest`
--

CREATE TABLE `tbl_song_suggest` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `song_title` varchar(500) NOT NULL,
  `song_image` varchar(255) DEFAULT NULL,
  `message` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_album`
--
ALTER TABLE `tbl_album`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `tbl_artist`
--
ALTER TABLE `tbl_artist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_mp3`
--
ALTER TABLE `tbl_mp3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_mp3_views`
--
ALTER TABLE `tbl_mp3_views`
  ADD PRIMARY KEY (`view_id`);

--
-- Indexes for table `tbl_playlist`
--
ALTER TABLE `tbl_playlist`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_song_suggest`
--
ALTER TABLE `tbl_song_suggest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_album`
--
ALTER TABLE `tbl_album`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_artist`
--
ALTER TABLE `tbl_artist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_mp3`
--
ALTER TABLE `tbl_mp3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `tbl_mp3_views`
--
ALTER TABLE `tbl_mp3_views`
  MODIFY `view_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_playlist`
--
ALTER TABLE `tbl_playlist`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_song_suggest`
--
ALTER TABLE `tbl_song_suggest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
