# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.10)
# Database: teaconf
# Generation Time: 2013-04-19 16:43:54 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table node
# ------------------------------------------------------------

CREATE TABLE `node` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `section_id` int(11) unsigned DEFAULT NULL COMMENT '所属分区',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `alias` varchar(255) DEFAULT NULL COMMENT '别名',
  `describe` varchar(255) DEFAULT NULL COMMENT '描述',
  `listorder` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  `topics_count` int(11) unsigned DEFAULT '0' COMMENT '主题总数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `node` WRITE;
/*!40000 ALTER TABLE `node` DISABLE KEYS */;

INSERT INTO `node` (`id`, `section_id`, `name`, `alias`, `describe`, `listorder`, `created_at`, `topics_count`)
VALUES
	(1,1,'PHP','php','PHP',0,1362147999,1),
	(2,1,'Yii','yii','Yii framework',0,1362147999,5),
	(3,2,'工具','tools','tools',0,1362147999,1),
	(4,3,'Android','android','android',0,1362147999,0),
	(5,3,'iPhone','iphone','iphone',0,1362147999,0),
	(6,4,'公告','announcement','Announcement',0,1362147999,0),
	(7,4,'反馈','feedback','Feedback',0,1362147999,0);

/*!40000 ALTER TABLE `node` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table post
# ------------------------------------------------------------

CREATE TABLE `post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) unsigned DEFAULT NULL COMMENT '所属话题',
  `reply_id` int(11) unsigned DEFAULT '0' COMMENT '父级ID',
  `created_at` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  `created_by` char(20) DEFAULT NULL COMMENT '创建人',
  `creator_id` int(11) unsigned DEFAULT NULL COMMENT '创建人ID',
  `content` text COMMENT '内容',
  `likes_count` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table post_likes
# ------------------------------------------------------------

CREATE TABLE `post_likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `post_id` int(11) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table section
# ------------------------------------------------------------

CREATE TABLE `section` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '分区名 ',
  `listorder` int(11) unsigned DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;

INSERT INTO `section` (`id`, `name`, `listorder`)
VALUES
	(1,'PHP',1),
	(2,'分享',0),
	(3,'Mobile',0),
	(4,'Teaconf',0);

/*!40000 ALTER TABLE `section` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table topic
# ------------------------------------------------------------

CREATE TABLE `topic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `node_id` int(11) unsigned DEFAULT NULL COMMENT '所属节点',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `created_at` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  `created_by` char(20) DEFAULT NULL COMMENT '创建人',
  `creator_id` int(11) unsigned DEFAULT NULL COMMENT '创建人ID',
  `last_posted_at` int(11) unsigned DEFAULT NULL COMMENT '最后回复时间',
  `last_posted_by` char(20) DEFAULT NULL COMMENT '最后回复人',
  `last_poster_id` int(11) unsigned DEFAULT NULL COMMENT '最后回复人ID',
  `views` int(11) unsigned DEFAULT '0' COMMENT '查看数',
  `posts_count` int(11) unsigned DEFAULT '0' COMMENT '回复数',
  `watch_count` int(11) unsigned DEFAULT '0' COMMENT '关注数',
  `likes_count` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table topic_likes
# ------------------------------------------------------------

CREATE TABLE `topic_likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table topic_watch
# ------------------------------------------------------------

CREATE TABLE `topic_watch` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user
# ------------------------------------------------------------

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) DEFAULT NULL COMMENT '用户名',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  `secure_code` varchar(255) DEFAULT NULL COMMENT '重要操作安全码',
  `signature` varchar(255) DEFAULT NULL COMMENT '签名',
  `avatar_small` varchar(255) DEFAULT NULL COMMENT '小头像',
  `avatar_middle` varchar(255) DEFAULT NULL COMMENT '中头像',
  `avatar_large` varchar(255) DEFAULT NULL COMMENT '大头像',
  `weibo` varchar(255) DEFAULT NULL COMMENT 'weibo id',
  `qq` varchar(255) DEFAULT NULL COMMENT 'qq id',
  `created_at` int(11) unsigned DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) unsigned DEFAULT '0' COMMENT '修改时间',
  `last_posted_at` int(11) unsigned DEFAULT '0' COMMENT '最后发帖时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_auth
# ------------------------------------------------------------

CREATE TABLE `user_auth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `provider_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `refersh_token` varchar(255) DEFAULT NULL,
  `expires` int(11) unsigned DEFAULT NULL,
  `created_at` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `provider` (`provider`,`provider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
