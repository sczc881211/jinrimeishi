/*
Navicat MySQL Data Transfer

Source Server         : demo
Source Server Version : 100116
Source Host           : 47.92.114.70:3306
Source Database       : demo9

Target Server Type    : MYSQL
Target Server Version : 100116
File Encoding         : 65001

Date: 2017-12-18 15:00:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cc_admin
-- ----------------------------
DROP TABLE IF EXISTS `cc_admin`;
CREATE TABLE `cc_admin` (
  `admin_id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '管理员编号',
  `admin_name` char(32) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `password` char(32) DEFAULT '' COMMENT '管理员密码',
  `phone` bigint(15) NOT NULL COMMENT '手机号',
  `email` varchar(50) DEFAULT '' COMMENT '管理员邮箱',
  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',
  `login_ip` char(50) DEFAULT '0' COMMENT '登 录IP',
  `login_time` int(11) DEFAULT '0' COMMENT '登录时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1 正常 2 禁用',
  `sex` tinyint(1) DEFAULT '1' COMMENT '性别 1 男 2 女',
  `remark` varchar(255) DEFAULT NULL COMMENT '说点什么.....',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of cc_admin
-- ----------------------------
INSERT INTO `cc_admin` VALUES ('1', 'admin', '14e1b600b1fd579f47433b88e8d85291', '13838389438', '13838389438@139.com', '1512521542', '0', '1512521542', '1', '1', '没啥');
INSERT INTO `cc_admin` VALUES ('3', 'songchao', '14e1b600b1fd579f47433b88e8d85291', '15863706046', '1@qq.com', '1512540683', '0', '0', '1', '1', '不知道说啥');

-- ----------------------------
-- Table structure for cc_article
-- ----------------------------
DROP TABLE IF EXISTS `cc_article`;
CREATE TABLE `cc_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL COMMENT '美食标题',
  `click` int(11) DEFAULT '0' COMMENT '播放量',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `up_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `video` varchar(255) DEFAULT NULL COMMENT '视频地址',
  `pic` varchar(255) DEFAULT NULL COMMENT '图片地址',
  `content` text COMMENT '美食描述',
  `status` tinyint(1) DEFAULT '1' COMMENT '美食可由后台关闭 1正常 2关闭',
  `duration` varchar(10) NOT NULL COMMENT '视频时长',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='美食表';

-- ----------------------------
-- Records of cc_article
-- ----------------------------
INSERT INTO `cc_article` VALUES ('1', '北京烤鸭', '215', '1512623341', '1513223434', '/uploads/20171214/29ba8b409e1db024eab0266ff635517e.mp4', '/uploads/20171214/4eb0ff5741cf33c103432d573cea026c.jpg', '全聚德北京烤鸭，全聚德北京烤鸭，全聚德北京烤鸭，全聚德北京烤鸭，全聚德北京烤鸭，全聚德北京烤鸭，全聚德北京烤鸭，全聚德北京烤鸭。', '1', '18:10');
INSERT INTO `cc_article` VALUES ('2', '菜煎饼', '576', '1512624678', '1513040058', '/uploads/20171212/63812c4f84d8995928196237559f555b.mp4', '/uploads/20171212/07f8cfb31411cabb513e6c186e6ef2f7.jpg', '滕州菜煎饼，滕州菜煎饼，滕州菜煎饼，滕州菜煎饼，滕州菜煎饼，滕州菜煎饼，滕州菜煎饼，滕州菜煎饼，滕州菜煎饼。', '1', '24:58');
INSERT INTO `cc_article` VALUES ('3', '风味茄子', '280', '1512984483', '1513223152', '/uploads/20171214/359dc3fe893d7651b7a17eabb90cccdb.mp4', '/uploads/20171214/187ce29d92306c6bb4bb41edee2c4ffa.jpg', '风味茄子风味茄子风味茄子风味茄子风味茄子风味茄子风味茄子风味茄子风味茄子1', '1', '9:24');
INSERT INTO `cc_article` VALUES ('4', '宫保鸡丁', '32', '1513050872', '1513233374', '/uploads/20171214/d35fd85b1c0462204a53f62d5d7326cc.mp4', '/uploads/20171214/4acd6fa0c3aa4a57f8defd044a4f1c9e.jpg', '宫保鸡丁宫保鸡丁宫保鸡丁宫保鸡丁宫保鸡丁宫保鸡丁', '1', '05:04');
INSERT INTO `cc_article` VALUES ('5', '麻婆豆腐', '76', '1513050995', null, '/uploads/20171212/28728cc35851fb96e609cad8810f688d.mp4', '/uploads/20171212/071f6359e7aaeaf2410c1cfc2fcd51c7.jpg', '麻婆豆腐麻婆豆腐麻婆豆腐麻婆豆腐', '1', '06:04');
INSERT INTO `cc_article` VALUES ('6', '甏肉干饭', '123', '1513061416', null, '/uploads/20171212/4919d223553b9dbd5cdfb9bbbcded8df.mp4', '/uploads/20171212/bf3569110ca5c7ee9bfe0412f6b028fc.jpg', '济宁甏肉干饭，济宁甏肉干饭，济宁甏肉干饭，济宁甏肉干饭，济宁甏肉干饭，济宁甏肉干饭，济宁甏肉干饭，济宁甏肉干饭。', '1', '40:31');
INSERT INTO `cc_article` VALUES ('7', '国足臭豆腐', '430', '1513064582', '1513233278', '/uploads/20171214/13a5bd2f85a2d7a1e484b258edc26a99.mp4', '/uploads/20171214/c7a0493f09c91b33ae800afcb4e6b6ec.jpg', '国足臭豆腐，闻起来臭，吃起来更臭！', '1', '15:31');
INSERT INTO `cc_article` VALUES ('8', '诸葛烤鱼', '607', '1513214296', '1513222809', '/uploads/20171214/4904866f6359c2497cb53befe72e2686.mp4', '/uploads/20171214/e55894af241918a0b90b3b5bcef8bb04.jpg', '诸葛烤鱼诸葛烤鱼诸葛烤鱼诸葛烤鱼诸葛烤鱼诸葛烤鱼诸葛烤鱼诸葛烤鱼诸葛烤鱼', '1', '30:09');
INSERT INTO `cc_article` VALUES ('9', '九转大肠', '21', '1513215250', '1513223320', '/uploads/20171214/171805bdf36cffa4a69c9a27b4fbfcc5.mp4', '/uploads/20171214/d60324e21d6bd14a0d1af5a85620b05a.jpg', '九转大肠九转大肠回家', '1', '05:14');
INSERT INTO `cc_article` VALUES ('10', '蚂蚁上树', '61', '1513223497', null, '/uploads/20171214/60dfb5ef473c74fb880cecbf2432be2d.mp4', '/uploads/20171214/0217571421e845108522ec306c4fd5a7.jpg', '蚂蚁上树蚂蚁上树蚂蚁上树', '1', '05:06');
INSERT INTO `cc_article` VALUES ('11', '拔丝山药', '62', '1513223715', null, '/uploads/20171214/ab926f15b46219298e2f68aedaaabf91.mp4', '/uploads/20171214/99fa0b3273f5974570b56d23883b2ac1.jpg', '拔丝山药拔丝山药拔丝山药拔丝山药', '1', '05:46');
INSERT INTO `cc_article` VALUES ('12', '鸭蛋粉皮', '675', '1513230153', '1513232400', '/uploads/20171214/ec9cf27b767aeffcd930832acd5e7708.mp4', '/uploads/20171214/285696e1ae0265581a8d17070be20ae5.jpg', '鸭蛋粉皮鸭蛋粉皮鸭蛋粉皮鸭蛋粉皮鸭蛋粉皮', '1', '05:08');

-- ----------------------------
-- Table structure for cc_comment
-- ----------------------------
DROP TABLE IF EXISTS `cc_comment`;
CREATE TABLE `cc_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `art_id` int(10) unsigned DEFAULT NULL COMMENT '美食id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `content` text COMMENT '评论内容',
  `status` tinyint(1) DEFAULT '1' COMMENT '评论可由后台关闭 1正常 2关闭',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='评论表';

-- ----------------------------
-- Records of cc_comment
-- ----------------------------
INSERT INTO `cc_comment` VALUES ('1', '7', '1', '1513144400', '闻起来臭，吃起来香~', '1');
INSERT INTO `cc_comment` VALUES ('2', '7', '2', '1513147233', '和熊了么', '1');
INSERT INTO `cc_comment` VALUES ('3', '1', '1', '1513156722', '很正宗', '1');
INSERT INTO `cc_comment` VALUES ('4', '2', '2', '1513157096', '逗比开发者', '1');
INSERT INTO `cc_comment` VALUES ('5', '10', '1', '1513229635', '可以', '1');
INSERT INTO `cc_comment` VALUES ('6', '8', '1', '1513229656', '感觉好麻烦', '1');
INSERT INTO `cc_comment` VALUES ('7', '3', '1', '1513229791', '好吃的很', '1');
INSERT INTO `cc_comment` VALUES ('8', '2', '1', '1513229986', '楼下好没素质啊', '1');
INSERT INTO `cc_comment` VALUES ('9', '1', '1', '1513239291', '姥姥家', '1');
INSERT INTO `cc_comment` VALUES ('10', '11', '3', '1513253042', '好吃的拔丝', '1');
INSERT INTO `cc_comment` VALUES ('11', '4', '3', '1513253130', '看着很好吃', '1');

-- ----------------------------
-- Table structure for cc_setting
-- ----------------------------
DROP TABLE IF EXISTS `cc_setting`;
CREATE TABLE `cc_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_name` char(80) DEFAULT NULL COMMENT '站点名称',
  `description` varchar(256) DEFAULT NULL COMMENT '描述',
  `category` varchar(60) DEFAULT NULL COMMENT '服务类目',
  `copyright` varchar(60) DEFAULT NULL COMMENT '主体信息',
  `logo` varchar(128) DEFAULT NULL COMMENT '公司logo',
  `up_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='系统设置';

-- ----------------------------
-- Records of cc_setting
-- ----------------------------
INSERT INTO `cc_setting` VALUES ('3', '今日美食food', '每日为您精选多种美食制作视频。满足您的吃货情怀，提高您的厨艺技能，轻松快乐每一餐', '视频', '北京淘梦网络科技有限责任公司', '/uploads/20171213/b95e7bb78732aa475271be7374ec9407.jpg', '1513127672');

-- ----------------------------
-- Table structure for cc_user
-- ----------------------------
DROP TABLE IF EXISTS `cc_user`;
CREATE TABLE `cc_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(60) DEFAULT NULL COMMENT '用户唯一标识',
  `nickName` varchar(30) NOT NULL COMMENT '用户昵称',
  `avatarUrl` varchar(200) NOT NULL COMMENT '用户头像url',
  `add_time` int(11) NOT NULL COMMENT '创建时间',
  `up_time` int(11) NOT NULL COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '用户可由后台关闭 1正常 2关闭',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of cc_user
-- ----------------------------
INSERT INTO `cc_user` VALUES ('1', 'oEMkJ0QjGceMJ4avoCRyLHXxk8yA', 'Cho Rong', 'https://wx.qlogo.cn/mmopen/vi_32/RSaVFIVhUiazeJNCwauOQxUibW0SSYSTJZgiafBLibibTmnQa4rdOsOdSOicFhLIuXT490ONcOyXc31ibkbvZSjCDYrQQ/0', '1512545310', '1513239291', '1');
INSERT INTO `cc_user` VALUES ('2', 'oEMkJ0YcCslWYZv2Fn2lE4xZ59As', 'Solaris', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eo4jpicwibZSG1FDicmRgUXkJiamnpd992UJn06lagKzlPickRXW44GiaKOZGz3NgwbM0mvILrb3f5fDyBQ/0', '1513147191', '1513157096', '1');
INSERT INTO `cc_user` VALUES ('3', 'oEMkJ0WXZU-VjZCYwtvEHsBeU1gk', '淡然浅笑', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJdy5mkNzMYkcv1OQRic9Zb9LAHZCsMSzSAezpFa4icWmTQCvxiayibBNmyJ2pWISNiaiaianksibxyF9pdVQ/0', '1513147398', '1513253130', '1');
