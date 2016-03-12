/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50546
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50546
File Encoding         : 65001

Date: 2016-03-12 07:40:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for blog_banner
-- ----------------------------
DROP TABLE IF EXISTS `blog_banner`;
CREATE TABLE `blog_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '1: right; 2: bottom; 3: post image',
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_banner
-- ----------------------------
INSERT INTO `blog_banner` VALUES ('1', 'Ads 1', 'bn-ads.jpg', '1', null);
INSERT INTO `blog_banner` VALUES ('2', 'Ads 2', 'bn-ads.jpg', '1', null);
INSERT INTO `blog_banner` VALUES ('3', 'Ads bottom', 'bn-bot.jpg', '2', null);
INSERT INTO `blog_banner` VALUES ('23', null, '1457139631-01.jpg', '3', null);
INSERT INTO `blog_banner` VALUES ('24', null, '1457139632-00.jpg', '3', null);
INSERT INTO `blog_banner` VALUES ('40', null, '1457401129-01.jpg', '3', null);
INSERT INTO `blog_banner` VALUES ('41', null, '1457401129-02.jpg', '3', null);
INSERT INTO `blog_banner` VALUES ('42', null, '1457401155-04.jpg', '3', null);

-- ----------------------------
-- Table structure for blog_category
-- ----------------------------
DROP TABLE IF EXISTS `blog_category`;
CREATE TABLE `blog_category` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_category
-- ----------------------------
INSERT INTO `blog_category` VALUES ('1', 'Investment Strategies', 'investment-strategies');
INSERT INTO `blog_category` VALUES ('2', 'Property Trends', null);
INSERT INTO `blog_category` VALUES ('3', 'General Property News', null);
INSERT INTO `blog_category` VALUES ('4', 'Cat 4', null);
INSERT INTO `blog_category` VALUES ('5', 'Property News', null);
INSERT INTO `blog_category` VALUES ('6', 'Home Decor', null);
INSERT INTO `blog_category` VALUES ('7', 'Singapore Living', null);
INSERT INTO `blog_category` VALUES ('8', 'Tips & Guides', null);

-- ----------------------------
-- Table structure for blog_comment
-- ----------------------------
DROP TABLE IF EXISTS `blog_comment`;
CREATE TABLE `blog_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `author_id` bigint(80) unsigned DEFAULT NULL,
  `post_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_comment
-- ----------------------------
INSERT INTO `blog_comment` VALUES ('1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut\r\n\r\nLabore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '1', '2016-03-02 17:23:38', '1', '8');

-- ----------------------------
-- Table structure for blog_featured_post
-- ----------------------------
DROP TABLE IF EXISTS `blog_featured_post`;
CREATE TABLE `blog_featured_post` (
  `id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_featured_post
-- ----------------------------
INSERT INTO `blog_featured_post` VALUES ('5');
INSERT INTO `blog_featured_post` VALUES ('6');
INSERT INTO `blog_featured_post` VALUES ('7');
INSERT INTO `blog_featured_post` VALUES ('8');
INSERT INTO `blog_featured_post` VALUES ('9');

-- ----------------------------
-- Table structure for blog_lookup
-- ----------------------------
DROP TABLE IF EXISTS `blog_lookup`;
CREATE TABLE `blog_lookup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_lookup
-- ----------------------------
INSERT INTO `blog_lookup` VALUES ('1', 'Right', '1', 'banner_type', '1');
INSERT INTO `blog_lookup` VALUES ('2', 'Bottom', '2', 'banner_type', '2');
INSERT INTO `blog_lookup` VALUES ('3', 'Post Image', '3', 'banner_type', '3');
INSERT INTO `blog_lookup` VALUES ('4', 'Active', '1', 'status', '1');
INSERT INTO `blog_lookup` VALUES ('5', 'Inactive', '2', 'status', '2');

-- ----------------------------
-- Table structure for blog_post
-- ----------------------------
DROP TABLE IF EXISTS `blog_post`;
CREATE TABLE `blog_post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_content` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `featured_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '1: post; 2: page',
  `status` tinyint(4) DEFAULT NULL COMMENT '1: active; 2:inactive',
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `view_count` bigint(20) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_post
-- ----------------------------
INSERT INTO `blog_post` VALUES ('5', 'Santander research suggests buoyant UK property market', '<p>Get motivated to upgrade your closet with features from these professionally-designed walk-ins.</p>', '<p>21212</p>', 'bn-1.jpg', '1', '1', 'santander-research-suggests-buoyant-uk-property-market', '16', '2016-03-01 15:24:58', '2016-03-09 17:11:21', '1');
INSERT INTO `blog_post` VALUES ('6', 'Is there room for creative thinking in the real estate market?', 'Get motivated to upgrade your closet with features from these professionally-designed walk-ins.', '2121', '01.jpg', '1', '1', 'is-there-room-for-creative-thinking-in-the-real-estate-market', '5', '2016-03-02 09:04:14', '2016-03-10 08:39:57', '1');
INSERT INTO `blog_post` VALUES ('7', 'Never fight somebody buying a property on emotion', '<p>Get motivated to upgrade your closet with features from these professionally-designed walk-ins.</p>', '3434', '02.jpg', '1', '1', 'never-fight-somebody-buying-a-property-on-emotion', '9', '2016-03-02 09:04:16', '2016-03-11 16:22:22', '1');
INSERT INTO `blog_post` VALUES ('8', 'Is the Hong Kong property market slowing down?', '<p>Get motivated to upgrade your closet with features from these professionally-designed walk-ins.</p>', '<p>rrer</p>', '', '1', '1', 'is-the-hong-kong-property-market-slowing-down', '34', '2016-03-02 09:04:19', '2016-03-09 17:11:21', '1');
INSERT INTO `blog_post` VALUES ('9', 'Is buy to leave a problem for London property markets?', 'Get motivated to upgrade your closet with features from these professionally-designed walk-ins.', 'rer3', '04.jpg', '1', '1', 'is-buy-to-leave-a-problem-for-london-property-markets', '23', '2016-03-02 09:04:22', '2016-03-11 16:22:34', '1');
INSERT INTO `blog_post` VALUES ('16', 'dsdsdsd', '', '<p>77</p>', null, '1', '1', 'dsdsdsd', '3', '2016-03-07 12:07:25', '2016-03-09 17:11:21', '1');
INSERT INTO `blog_post` VALUES ('10', 'Discover Hong Kong - Official Travel Guide', '', '<p>Hong Kong is a city, and former British colony, in southeastern China. Vibrant and densely populated, it’s a major port and global financial center famed for its tower-studded skyline. It’s also known for its lively food scene – from Cantonese dim sum to extravagant high tea – and its shopping, with options spanning chaotic Temple Street Night Market to the city’s innumerable bespoke tailors.</p>', null, null, '1', 'discover-hong-kong-official-travel-guide', '7', null, '2016-03-09 17:11:21', '1');
INSERT INTO `blog_post` VALUES ('11', 'Things to do in Hong Kong', '', '<p>232424</p>', null, null, '1', 'things-to-do-in-hong-kong', '3', null, '2016-03-09 17:11:21', '1');
INSERT INTO `blog_post` VALUES ('12', 'Hong Kong - The World Factbook', '', '<p>2121212</p>', null, null, '1', 'hong-kong-the-world-factbook', null, null, '2016-03-09 17:11:21', '1');
INSERT INTO `blog_post` VALUES ('15', 'Test', '', '<p>addsd</p>', null, '1', '1', 'test', null, '2016-03-05 09:19:16', '2016-03-09 17:11:21', '1');

-- ----------------------------
-- Table structure for blog_post_banner
-- ----------------------------
DROP TABLE IF EXISTS `blog_post_banner`;
CREATE TABLE `blog_post_banner` (
  `post_id` bigint(20) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_post_banner
-- ----------------------------
INSERT INTO `blog_post_banner` VALUES ('5', '23');
INSERT INTO `blog_post_banner` VALUES ('5', '24');
INSERT INTO `blog_post_banner` VALUES ('8', '40');
INSERT INTO `blog_post_banner` VALUES ('8', '41');
INSERT INTO `blog_post_banner` VALUES ('8', '42');

-- ----------------------------
-- Table structure for blog_post_category
-- ----------------------------
DROP TABLE IF EXISTS `blog_post_category`;
CREATE TABLE `blog_post_category` (
  `post_id` bigint(20) unsigned NOT NULL,
  `category_id` int(20) NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_post_category
-- ----------------------------
INSERT INTO `blog_post_category` VALUES ('5', '1');
INSERT INTO `blog_post_category` VALUES ('5', '2');
INSERT INTO `blog_post_category` VALUES ('5', '5');
INSERT INTO `blog_post_category` VALUES ('6', '1');
INSERT INTO `blog_post_category` VALUES ('7', '1');
INSERT INTO `blog_post_category` VALUES ('8', '3');
INSERT INTO `blog_post_category` VALUES ('8', '5');
INSERT INTO `blog_post_category` VALUES ('9', '1');
INSERT INTO `blog_post_category` VALUES ('10', '1');

-- ----------------------------
-- Table structure for blog_subscriber
-- ----------------------------
DROP TABLE IF EXISTS `blog_subscriber`;
CREATE TABLE `blog_subscriber` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_subscriber
-- ----------------------------
INSERT INTO `blog_subscriber` VALUES ('1', 'abc@m.mm');
INSERT INTO `blog_subscriber` VALUES ('2', 'a@m.mm');
INSERT INTO `blog_subscriber` VALUES ('3', 'b@m.mm');
INSERT INTO `blog_subscriber` VALUES ('4', 'c@m.mm');
INSERT INTO `blog_subscriber` VALUES ('5', 'd@m.mm');
INSERT INTO `blog_subscriber` VALUES ('6', 'e@m.mm');

-- ----------------------------
-- Table structure for blog_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_user`;
CREATE TABLE `blog_user` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(6) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_user
-- ----------------------------
INSERT INTO `blog_user` VALUES ('1', 'admin', 'mIdNNyoW-s0TlHOA0BCNdBHdrLuyvdHm', '$2y$13$FIzKltkSSUZ15irVpyZ6QucChhlnNEftlxy81dZjiyL.EqsqkMr8C', null, 'admin@m.mm', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
