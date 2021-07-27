/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50728
Source Host           : localhost:3308
Source Database       : hhyii

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2021-07-27 19:56:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mobile_menu
-- ----------------------------
DROP TABLE IF EXISTS `mobile_menu`;
CREATE TABLE `mobile_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(50) DEFAULT NULL COMMENT '导航中文名',
  `url` varchar(50) DEFAULT NULL COMMENT '导航URL',
  `class` varchar(100) DEFAULT NULL COMMENT '图标样式',
  `f_show` varchar(2) DEFAULT NULL COMMENT '是否显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mobile_menu
-- ----------------------------
INSERT INTO `mobile_menu` VALUES ('1', '投稿', 'newscolumn/index', 'icon ion-ios-home-outline', null);
INSERT INTO `mobile_menu` VALUES ('2', '阅读', 'Article/select', 'icon ion-ios-paper-outline', null);
INSERT INTO `mobile_menu` VALUES ('3', '我的投稿', 'Article/myarticle', 'icon ion-ios-eye-outline', null);
INSERT INTO `mobile_menu` VALUES ('4', '随手记', 'Hand/index', 'icon ion-ios-compose-outline', null);
INSERT INTO `mobile_menu` VALUES ('5', '我', 'Article/my', 'icon ion-ios-person-outline', null);
