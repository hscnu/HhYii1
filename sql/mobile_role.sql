/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50728
Source Host           : localhost:3308
Source Database       : hhyii

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2021-09-04 19:43:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mobile_role
-- ----------------------------
DROP TABLE IF EXISTS `mobile_role`;
CREATE TABLE `mobile_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动增长',
  `f_tcode` varchar(20) DEFAULT '' COMMENT '树结构父',
  `f_rcode` char(6) DEFAULT '' COMMENT '角色编码，采用树结构，格式位第一位表示一级角色，子角色每级两位',
  `f_rname` varchar(40) DEFAULT ' ' COMMENT '角色名称',
  `f_type` int(11) DEFAULT '1' COMMENT '级别，1第一级，2为第二级',
  `f_opter` text COMMENT '操作说明，新格式',
  `f_sysdefault` int(11) DEFAULT '0' COMMENT '系统内部使用',
  `f_default` int(11) DEFAULT '0' COMMENT '申报人使用，1 是，0 不是',
  `f_level` int(11) DEFAULT '0' COMMENT '使用级别，1 是单位或使用级别',
  `f_optname` text COMMENT '操作名称',
  `f_show` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='菜单及权限';

-- ----------------------------
-- Records of mobile_role
-- ----------------------------
INSERT INTO `mobile_role` VALUES ('1', 'A', 'A', '消毒', '1', '', '1', '1', '1', null, '1');
INSERT INTO `mobile_role` VALUES ('2', 'B', 'B', '送冰', '1', '', '0', '0', '0', null, '1');
INSERT INTO `mobile_role` VALUES ('3', 'C', 'C', '农户种植', '1', '', '0', '0', '0', null, '1');
INSERT INTO `mobile_role` VALUES ('4', 'D', 'D', '餐饮管理', '1', '', '0', '0', '0', null, '1');
INSERT INTO `mobile_role` VALUES ('5', 'E', 'E', '入驻管理', '1', '', '0', '0', '0', null, '1');
INSERT INTO `mobile_role` VALUES ('6', ' ', '', '农户养殖', '1', '', '0', '0', '0', null, '1');
INSERT INTO `mobile_role` VALUES ('7', 'F', 'F', '捕鱼模块', '1', '', '0', '0', '0', null, '1');
INSERT INTO `mobile_role` VALUES ('8', 'Z', 'Z', '主页', '1', null, '0', '0', '0', null, '0');
