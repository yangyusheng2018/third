/*
Navicat MySQL Data Transfer

Source Server         : conn1
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : domain

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-11-06 20:03:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for domain
-- ----------------------------
DROP TABLE IF EXISTS `domain`;
CREATE TABLE `domain` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `is_delete` int(11) DEFAULT NULL,
  `suffix` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `language` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `cloudflare` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `vps` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `remarks` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `dbs` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `template` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ax` int(4) DEFAULT '0',
  `bx` int(4) DEFAULT '0',
  `cx` int(4) DEFAULT '0',
  `c1x` int(4) DEFAULT '0',
  `url` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `imgurl` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of domain
-- ----------------------------
INSERT INTO `domain` VALUES ('1', '5', 'admin.com.mx', '1541435956', '1540983694', '1541435956', '1', '.biz', 'AR', 's063', '165.227.100.152-2', '1970', '福而非女儿', 'E:\\A-采集\\蒙语采集\\db-----------1', '127.0.0.12', '0', '0', '0', '0', null, null);
INSERT INTO `domain` VALUES ('10', '5', 'admin', null, '1540985930', '1541088434', '0', '', 'FR', '', '', '2018', '', '', '', '1', '2', '0', '0', null, null);
INSERT INTO `domain` VALUES ('11', '5', 'Jessica Rothstein', null, '1541059113', '1541414563', null, '', 'ZA', 's063', '165.227.100.152-2', '1970', '分各个人托管人', 'E:\\A-采集\\蒙语采集\\db-----------1', '127.0.0.12', '9', '3', '0', '9', '', null);
INSERT INTO `domain` VALUES ('12', '5', 'y', null, '1541088422', '1541088422', null, '', 'EN', '', '', '1541088421', '', '', '', '1', '0', '0', '0', null, null);
INSERT INTO `domain` VALUES ('13', '5', 'yangyusheng', null, '1541089262', '1541504223', null, '', 'EN', '', '', '1970', '', '', '', '0', '0', '0', '0', '14/1223/11/20370273_435117511.shtml', null);

-- ----------------------------
-- Table structure for history
-- ----------------------------
DROP TABLE IF EXISTS `history`;
CREATE TABLE `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `domain_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `le` int(11) DEFAULT NULL,
  `bl` int(11) DEFAULT NULL,
  `dp` int(11) DEFAULT NULL,
  `wby` int(11) DEFAULT NULL,
  `aby` int(11) DEFAULT NULL,
  `acr` int(11) DEFAULT NULL,
  `suffix` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `is_xp` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `googel` int(11) DEFAULT NULL,
  `rank` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `remark` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `imageurl` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `is_delete` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of history
-- ----------------------------
INSERT INTO `history` VALUES ('2', '5', null, 'yangyusheng', '0', '0', '0', '1', '0', '0', '', null, '2018', null, '1541497529', '0', '', '', null, null);
INSERT INTO `history` VALUES ('3', '5', null, 'Jessica Rothstein', '0', '0', '0', '0', '0', '0', '', null, '1541499720', '1541501059', '1541501059', '0', '', '', null, '1');
INSERT INTO `history` VALUES ('4', '5', null, 'Jessica Rothstein', '0', '0', '0', '0', '0', '0', '', null, '1541499774', null, '1541504433', '0', '', '', '/upload/goods/4/1541499776.jpg,/upload/goods/4/1541500857.jpg,', null);
INSERT INTO `history` VALUES ('5', '5', null, 'admin', '0', '0', '0', '0', '0', '0', '', null, '1541504244', null, '1541504245', '0', '', '', '', null);
INSERT INTO `history` VALUES ('6', '5', null, '杨玉胜', '0', '0', '0', '0', '0', '0', '', null, '1541504270', null, '1541504270', '0', '', '', '', null);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(25) NOT NULL,
  `role` int(2) NOT NULL,
  `status` int(2) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `login_time` int(11) DEFAULT NULL,
  `login_count` int(10) DEFAULT NULL,
  `is_delete` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('5', 'yang', 'c4ca4238a0b923820dcc509a6f75849b', '', '0', '1', '1540974597', '1540974597', null, null, '5', '0');
