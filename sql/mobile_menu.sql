/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50728
Source Host           : localhost:3308
Source Database       : hhyii

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2021-08-04 22:40:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mobile_menu
-- ----------------------------
DROP TABLE IF EXISTS `mobile_menu`;
CREATE TABLE `mobile_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_code` varchar(4) DEFAULT NULL,
  `typename` varchar(50) DEFAULT NULL COMMENT '导航中文名',
  `url` varchar(50) DEFAULT NULL COMMENT '导航URL',
  `class` varchar(100) DEFAULT NULL COMMENT '图标样式',
  `f_show` varchar(2) DEFAULT NULL COMMENT '是否显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mobile_menu
-- ----------------------------
INSERT INTO `mobile_menu` VALUES ('1', 'A01', '我', 'Delivery/my', 'icon ion-ios-person-outline', '1');
INSERT INTO `mobile_menu` VALUES ('2', 'A02', '签收', 'Sign_mobile/index', 'icon ion-android-checkbox', '1');
INSERT INTO `mobile_menu` VALUES ('3', 'A03', '配送', 'Delivery_mobile/index', 'icon ion-android-car', '1');
INSERT INTO `mobile_menu` VALUES ('4', 'B01', '渔船（添加订单）', 'ice/create', 'icon ion-plus-circled', null);
INSERT INTO `mobile_menu` VALUES ('5', 'B02', '渔船（我的订单）', 'ice/index_query', 'icon ion-clipboard', null);
INSERT INTO `mobile_menu` VALUES ('6', 'B03', '渔船（确认收货）', 'ice/index_confirm_receipt', 'icon ion-checkmark-round', null);
INSERT INTO `mobile_menu` VALUES ('7', 'B04', '物流人员（确认订单）', 'ice/index_confirm_order', 'icon ion-checkmark-round', null);
INSERT INTO `mobile_menu` VALUES ('8', 'B05', '物流人员（开始配送）', 'ice/index_confirm_deliver', 'icon ion-paper-airplane', null);
INSERT INTO `mobile_menu` VALUES ('9', 'B06', '物流人员（确认收货）', 'ice/index_confirm_receipt', 'icon ion-checkmark-round', null);
INSERT INTO `mobile_menu` VALUES ('10', 'B07', '物流人员（查询订单）', 'ice/index_query', 'icon ion-clipboard', null);
INSERT INTO `mobile_menu` VALUES ('11', 'C01', '产量上报', 'proreport/index', 'icon ion-ios-plus-outline', null);
INSERT INTO `mobile_menu` VALUES ('12', 'C02', '订单管理', 'orders/index', 'icon ion-ios-paper', null);
INSERT INTO `mobile_menu` VALUES ('13', 'C03', '配送状态', 'delivery/index', 'icon ion-ios-briefcase', null);
INSERT INTO `mobile_menu` VALUES ('14', 'C04', '我', 'plant/my', 'icon ion-ios-person', null);
INSERT INTO `mobile_menu` VALUES ('15', 'D01', '美食广场', 'restaurant/user', 'icon ion-ios-pricetags-outline', null);
INSERT INTO `mobile_menu` VALUES ('16', 'D02', '添加评价', 'evaluation/create', 'icon ion-ios-compose-outline', null);
INSERT INTO `mobile_menu` VALUES ('17', 'E01', '添加入驻', 'residence/index_add_residence', 'icon ion-ios-person', null);
INSERT INTO `mobile_menu` VALUES ('18', 'E02', '添加待审核', 'residence/index_add_examine', 'icon ion-ios-person', null);
INSERT INTO `mobile_menu` VALUES ('19', 'E03', '意向入驻审核', 'residence/index_residence_examine', 'icon ion-ios-person', null);
INSERT INTO `mobile_menu` VALUES ('20', 'E04', '意向入驻列表', 'residence/index_residence_list', 'icon ion-ios-person', null);
INSERT INTO `mobile_menu` VALUES ('21', 'E05', '审核未通过列表', 'residence/index_examine_fail_list', 'icon ion-ios-person', null);
INSERT INTO `mobile_menu` VALUES ('22', 'E06', '添加渔船', 'fishingBoat/index_add_ship', 'icon ion-ios-person', null);
INSERT INTO `mobile_menu` VALUES ('23', 'E07', '添加待审核', 'fishingBoat/index_add_examine', 'icon ion-ios-person', null);
INSERT INTO `mobile_menu` VALUES ('24', 'E08', '渔船入驻审核', 'fishingBoat/index_ship_examine', 'icon ion-ios-person', null);
INSERT INTO `mobile_menu` VALUES ('25', 'E09', '渔船入驻列表', 'fishingBoat/index_ship_list', 'icon ion-ios-person', null);
INSERT INTO `mobile_menu` VALUES ('26', 'E10', '审核未通过列表', 'fishingBoat/index_examine_fail_list', 'icon ion-ios-person', null);
INSERT INTO `mobile_menu` VALUES ('27', 'F01', '渔民申报', 'catchfish/index', 'icon ion-ios-upload', null);
INSERT INTO `mobile_menu` VALUES ('28', 'F02', '拍卖信息', 'auction_info/index', 'icon ion-ios-list-outline', null);
INSERT INTO `mobile_menu` VALUES ('29', 'F03', '拍卖审批', 'auction_examine/index', 'icon ion-ios-compose-outline', null);
INSERT INTO `mobile_menu` VALUES ('30', 'F04', '今日热拍', 'auction_today/index', 'icon ion-ios-cart-outline', null);
INSERT INTO `mobile_menu` VALUES ('31', 'F05', '捕鱼上报', 'fishingreport/index', 'icon ion-ios-upload', null);
