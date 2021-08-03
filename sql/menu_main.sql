/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50728
Source Host           : localhost:3308
Source Database       : hhyii

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2021-08-03 14:16:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for menu_main
-- ----------------------------
DROP TABLE IF EXISTS `menu_main`;
CREATE TABLE `menu_main` (
  `f_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '内部ID',
  `f_code` char(10) DEFAULT '' COMMENT '菜单编码',
  `f_name` varchar(50) DEFAULT ' ' COMMENT '菜单名称--跆拳道',
  `f_url` varchar(100) DEFAULT '' COMMENT '菜单连接',
  `f_image` varchar(50) DEFAULT '' COMMENT '展示图标',
  `f_show` int(4) DEFAULT '0' COMMENT '是否显示 0 否  1 是',
  `loginshow` varchar(2) DEFAULT NULL COMMENT '登录才显示',
  `f_no` varchar(11) DEFAULT NULL,
  `is_full` varchar(255) NOT NULL DEFAULT '0' COMMENT '是否全屏',
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='一级菜单名次';

-- ----------------------------
-- Records of menu_main
-- ----------------------------
INSERT INTO `menu_main` VALUES ('1', 'A', '酒楼消毒', '', '', '1', '0', 'A', '0');
INSERT INTO `menu_main` VALUES ('2', 'B', '送冰', '', '', '1', '0', 'B', '0');
INSERT INTO `menu_main` VALUES ('3', 'C', '农户种植', '', '', '1', '0', 'C', '0');
INSERT INTO `menu_main` VALUES ('4', 'D', '餐饮管理', '', '', '1', '0', 'D', '0');
INSERT INTO `menu_main` VALUES ('5', 'E', '入驻管理', '', '', '1', '0', 'E', '0');
INSERT INTO `menu_main` VALUES ('6', 'F', '农户养殖', '', '', '1', '0', 'F', '0');
INSERT INTO `menu_main` VALUES ('7', 'G', '捕鱼模块', '', '', '1', '0', 'G', '0');
