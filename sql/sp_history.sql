/*
Navicat MySQL Data Transfer

Source Server         : xampp
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : hmv

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-04-15 16:49:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sp_history
-- ----------------------------
DROP TABLE IF EXISTS `sp_history`;
CREATE TABLE `sp_package` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `order_id` int(10) unsigned DEFAULT '0' COMMENT '订单ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_name` varchar(255) DEFAULT '0' COMMENT '商品名称',
  `goods_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

