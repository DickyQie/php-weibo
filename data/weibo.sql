/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50512
Source Host           : localhost:3306
Source Database       : weibo

Target Server Type    : MYSQL
Target Server Version : 50512
File Encoding         : 65001

Date: 2016-12-30 10:33:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mr_at
-- ----------------------------
DROP TABLE IF EXISTS `mr_at`;
CREATE TABLE `mr_at` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` varchar(255) DEFAULT NULL COMMENT '用户id',
  `post_id` int(11) unsigned DEFAULT NULL COMMENT '微博id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mr_at
-- ----------------------------

-- ----------------------------
-- Table structure for mr_collect
-- ----------------------------
DROP TABLE IF EXISTS `mr_collect`;
CREATE TABLE `mr_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `post_id` int(11) NOT NULL COMMENT '收藏微博id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否收藏：0 否；1 是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mr_collect
-- ----------------------------

-- ----------------------------
-- Table structure for mr_friends
-- ----------------------------
DROP TABLE IF EXISTS `mr_friends`;
CREATE TABLE `mr_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未关注；1:已关注',
  `addtime` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mr_friends
-- ----------------------------

-- ----------------------------
-- Table structure for mr_post
-- ----------------------------
DROP TABLE IF EXISTS `mr_post`;
CREATE TABLE `mr_post` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET gb2312 NOT NULL,
  `addtime` varchar(50) CHARACTER SET gb2312 NOT NULL,
  `username` varchar(200) NOT NULL,
  `user_id` int(8) NOT NULL,
  `pid` int(8) NOT NULL DEFAULT '0' COMMENT '上级id',
  `post_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '微博标示： 0 发布 ；1评论；2转发',
  `parent_user_id` int(8) NOT NULL DEFAULT '0' COMMENT '回复人的id',
  `pictures` text NOT NULL,
  `forward_num` int(8) NOT NULL DEFAULT '0' COMMENT '转发数量',
  `comment_num` int(8) NOT NULL DEFAULT '0' COMMENT '评论数',
  `praise_num` int(8) NOT NULL DEFAULT '0' COMMENT '点赞数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=341 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mr_post
-- ----------------------------

-- ----------------------------
-- Table structure for mr_praise
-- ----------------------------
DROP TABLE IF EXISTS `mr_praise`;
CREATE TABLE `mr_praise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `post_id` int(11) NOT NULL COMMENT '收藏微博id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mr_praise
-- ----------------------------

-- ----------------------------
-- Table structure for mr_user
-- ----------------------------
DROP TABLE IF EXISTS `mr_user`;
CREATE TABLE `mr_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `addtime` char(10) NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：0保密；1男；2女',
  `qq` varchar(50) DEFAULT NULL COMMENT 'qq号',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `posts_num` int(8) NOT NULL DEFAULT '0' COMMENT '发微博的数量',
  `follows_num` int(8) NOT NULL DEFAULT '0' COMMENT '关注数量',
  `fans_num` int(8) NOT NULL DEFAULT '0' COMMENT '粉丝数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mr_user
-- ----------------------------
INSERT INTO `mr_user` VALUES ('11', '科比', 'e10adc3949ba59abbe56e057f20f883e', '1470629025', '1', '694798056', '', '57e0ee10c62d1.jpg', '0', '0', '0');
INSERT INTO `mr_user` VALUES ('12', 'James', 'e10adc3949ba59abbe56e057f20f883e', '1470629025', '1', '', '', '', '0', '0', '0');
INSERT INTO `mr_user` VALUES ('9', 'mr', 'fdb390e945559e74475ed8c8bbb48ca5', '1470629025', '0', '694798057', '694798056@qq.com', '57c7b5e5b00f5.jpg', '0', '0', '0');
INSERT INTO `mr_user` VALUES ('10', 'andy', 'e10adc3949ba59abbe56e057f20f883e', '1470629025', '2', '694798056', 'andy@qq.com', '57df771d663f2.jpg', '0', '0', '0');
INSERT INTO `mr_user` VALUES ('13', '明日科技', 'e10adc3949ba59abbe56e057f20f883e', '1470629025', '1', '694798056', '', '', '0', '0', '0');
