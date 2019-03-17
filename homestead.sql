/*
SQLyog Professional v12.09 (64 bit)
MySQL - 10.1.37-MariaDB : Database - homestead
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `app_users` */

DROP TABLE IF EXISTS `app_users`;

CREATE TABLE `app_users` (
  `tocken` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tocken`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `app_users` */

insert  into `app_users`(`tocken`,`created_at`,`updated_at`) values ('abc','2019-03-17 06:20:21','2019-03-17 06:20:21'),('dKs98_A2hLU:APA91bGF1sGoQdKgi3-8jHDY99wOnytIWXpP6LieGKrtlNGlaJkkNqNT3sivxGIwPgnczY3FbN7scpCm1zCBSxSQR9eK5mwkLhz0HDPDBMoSZpLa5pHd_zS4Uv9fbZEOBsfQFpxqz7nC','2019-03-17 10:49:51','2019-03-17 10:49:51'),('fVBw2XpD524:APA91bHzyZ0arNrUsluQ2xD-WSpiUqTbg52LUi8r73bJ1-YHuER3wxEza4Kh9tZImYWV1PD4G1eecXWpgAV3-Yh76VeianiPJPY_FmbzUbkGAaAkmriihlDc2vlTf5bu3hXl5D4FaGLQ','2019-03-17 06:24:27','2019-03-17 06:24:27');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_03_16_061503_schedule',1),(4,'2019_03_16_061520_schedule_event',1),(5,'2019_03_17_050209_app_users',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `schedule_events` */

DROP TABLE IF EXISTS `schedule_events`;

CREATE TABLE `schedule_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `schedule_events` */

insert  into `schedule_events`(`id`,`title`,`color`,`created_at`,`updated_at`,`deleted_at`) values (1,'test1','rgb(0, 115, 183)','2019-03-17 10:51:39','2019-03-17 10:51:39',NULL),(2,'test2','rgb(221, 75, 57)','2019-03-17 10:51:45','2019-03-17 10:51:45',NULL);

/*Table structure for table `schedules` */

DROP TABLE IF EXISTS `schedules`;

CREATE TABLE `schedules` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_event_id` int(11) NOT NULL,
  `start` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dayOfWeek` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `schedules` */

insert  into `schedules`(`id`,`schedule_event_id`,`start`,`end`,`dayOfWeek`,`created_at`,`updated_at`) values ('_fc11',1,'00:30','02:30','1','2019-03-17 11:49:13','2019-03-17 11:49:13'),('_fc147',2,'06:30','08:30','0','2019-03-17 11:49:29','2019-03-17 11:49:29'),('_fc21',2,'02:00','04:00','2','2019-03-17 11:49:14','2019-03-17 11:49:14'),('_fc31',1,'00:30','02:30','3','2019-03-17 11:49:16','2019-03-17 11:49:16'),('_fc45',2,'01:00','03:00','5','2019-03-17 11:49:17','2019-03-17 11:49:17'),('_fc65',2,'03:30','05:30','6','2019-03-17 11:49:19','2019-03-17 11:49:19'),('_fc81',1,'04:00','06:00','4','2019-03-17 11:49:21','2019-03-17 11:49:21'),('_fc97',2,'00:30','02:30','6','2019-03-17 11:49:22','2019-03-17 11:49:22');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values (1,'John Smith','john@gmail.com',NULL,'$2y$10$UeNXjoi.EOMjAoZ69eyhQ.usf.mRUsx3YUGVqTj7FVfnZhjcoHpYG','TxDzNtAbqi4KaqyG6fiiVSKhYty5Yts4kEIbn1bkjMqEunF0yryUMqqeDWFL','2019-03-17 06:20:07','2019-03-17 06:20:07');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
