/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50723
 Source Host           : localhost:3306
 Source Schema         : machinecsdb

 Target Server Type    : MySQL
 Target Server Version : 50723
 File Encoding         : 65001

 Date: 28/11/2018 21:47:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for counter
-- ----------------------------
DROP TABLE IF EXISTS `counter`;
CREATE TABLE `counter`  (
  `counterId` int(255) NOT NULL AUTO_INCREMENT COMMENT '计数器id',
  `counterName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '计数器名称',
  `counterModel` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '计数器型号',
  `counterType` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '计数器类型',
  `counterPort` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '远程端口号',
  `counterDecimal` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '进制',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '地址编号',
  `connectable` int(255) NULL DEFAULT 0 COMMENT '1可链接，0不可链接',
  `deleted` int(255) NULL DEFAULT 0 COMMENT '1删除，0不删除',
  PRIMARY KEY (`counterId`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_bin COMMENT = '压铸机计数器' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of counter
-- ----------------------------
INSERT INTO `counter` VALUES (1, '数量计数器修改后02', '数字型', '二进制', '900801', '二进制', '10.1.1.102', 1, 0);

-- ----------------------------
-- Table structure for ctrlparameter
-- ----------------------------
DROP TABLE IF EXISTS `ctrlparameter`;
CREATE TABLE `ctrlparameter`  (
  `ctrlId` int(255) NOT NULL AUTO_INCREMENT COMMENT '连轧id',
  `ctrlNo` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '控制单号',
  `rollWeight` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '连轧重量',
  `material` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '材质',
  `rollNumber` int(255) NULL DEFAULT 0 COMMENT '连轧个数',
  `rollIntervals` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '连轧间隔时间',
  `rollPressure` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '连轧压力',
  `rollName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '连轧名称',
  `rollTimes` int(255) NULL DEFAULT 0 COMMENT '0次数',
  `startTime` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '开始时间',
  `deleted` int(255) NULL DEFAULT 0 COMMENT '1删除，0不删除',
  PRIMARY KEY (`ctrlId`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin COMMENT = '控制参数表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ctrlparameter
-- ----------------------------
INSERT INTO `ctrlparameter` VALUES (1, '2018080201', '2000kg', '塑料', 4, '3分钟', '2000kpa', '121', 3, NULL, 0);
INSERT INTO `ctrlparameter` VALUES (2, '20180802012', '2000kg', '塑料', 300, '3分钟', '2000kpa', '1212121', 3, '2018-11-21 23:17:26', 0);

-- ----------------------------
-- Table structure for ctrlport
-- ----------------------------
DROP TABLE IF EXISTS `ctrlport`;
CREATE TABLE `ctrlport`  (
  `portId` int(255) NOT NULL AUTO_INCREMENT COMMENT '端口id',
  `portName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '端口名称',
  `remoteIp` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '远程连接地址',
  `remoteProtocol` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '远程链接协议',
  `remotePort` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '远程端口号',
  `remoteHost` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '远程主机名称',
  `controlMethod` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '控制方式',
  `remoteUsr` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '用户名',
  `remotePwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '密码',
  `updateTime` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '更新时间',
  `deleted` int(255) NULL DEFAULT 0 COMMENT '1删除，0不删除',
  PRIMARY KEY (`portId`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin COMMENT = '控制端口配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ctrlport
-- ----------------------------
INSERT INTO `ctrlport` VALUES (1, '压铸机控制端口01', '10.35.0.22', 'tcp/ip', '1008', 'zbdbz', '消息', 'admin', '123', '2018-11-17 14:35:22', 0);
INSERT INTO `ctrlport` VALUES (2, '21212', '12121', 'tcp/ip', '12121', '2121212', '12121', 'admin', '1212', '2018-11-17 16:52:20', 0);

-- ----------------------------
-- Table structure for ctrlsensor
-- ----------------------------
DROP TABLE IF EXISTS `ctrlsensor`;
CREATE TABLE `ctrlsensor`  (
  `sensorId` int(255) NOT NULL AUTO_INCREMENT COMMENT '传感器id',
  `sensorName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '传感器名称',
  `sensorModel` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '传感器型号',
  `sensorType` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '传感器类型',
  `sensorPort` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '端口号',
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '安装位置',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '地址编号',
  `connected` int(255) NULL DEFAULT 0 COMMENT '1链接，0不链接',
  `deleted` int(255) NULL DEFAULT 0 COMMENT '1删除，0不删除',
  PRIMARY KEY (`sensorId`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin COMMENT = '控制传感器表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ctrlsensor
-- ----------------------------
INSERT INTO `ctrlsensor` VALUES (1, '温控传感器01修改后', '数字型', '在线式', '2008', '压铸线高架式270压铸', '10230', 1, 0);

-- ----------------------------
-- Table structure for dbmanager
-- ----------------------------
DROP TABLE IF EXISTS `dbmanager`;
CREATE TABLE `dbmanager`  (
  `dbId` int(255) NOT NULL AUTO_INCREMENT COMMENT '数据库id',
  `dbName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '数据库名称',
  `opened` int(255) NULL DEFAULT 0 COMMENT '1删除，0不删除',
  `deleted` int(255) NULL DEFAULT 0 COMMENT '1删除，0不删除',
  PRIMARY KEY (`dbId`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_bin COMMENT = '数据库管理' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dbmanager
-- ----------------------------
INSERT INTO `dbmanager` VALUES (1, '卧式冷室压铸机数据库01', 0, 0);
INSERT INTO `dbmanager` VALUES (2, '卧式冷室压铸机更新后的数据库03', 1, 1);
INSERT INTO `dbmanager` VALUES (3, '卧式冷室压铸机数据库0124', 0, 1);

-- ----------------------------
-- Table structure for descriptsys
-- ----------------------------
DROP TABLE IF EXISTS `descriptsys`;
CREATE TABLE `descriptsys`  (
  `demoId` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '主键',
  `descript` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '描述信息',
  PRIMARY KEY (`demoId`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of descriptsys
-- ----------------------------
INSERT INTO `descriptsys` VALUES ('1', '数据库直接写入数据');

-- ----------------------------
-- Table structure for machine
-- ----------------------------
DROP TABLE IF EXISTS `machine`;
CREATE TABLE `machine`  (
  `machineId` int(255) NOT NULL AUTO_INCREMENT COMMENT '端口id',
  `machineName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '压铸机名称',
  `machineModel` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '压铸机型号',
  `machineType` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '压铸机类型',
  `port` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '远程端口号',
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '位置',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '地址编号',
  `updateTime` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '更新时间戳',
  `connectable` int(255) NULL DEFAULT 0 COMMENT '1可链接，0不可链接',
  `deleted` int(255) NULL DEFAULT 0 COMMENT '1删除，0不删除',
  PRIMARY KEY (`machineId`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin COMMENT = '压铸机配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of machine
-- ----------------------------
INSERT INTO `machine` VALUES (1, '自动快速卧式冷室修改后压铸机01', '库卡2011', '自动', '20008', '自动压铸机控制车间02', '10.1.1.02', NULL, 1, 1);
INSERT INTO `machine` VALUES (2, '压铸机名称1', '的方式', '第东段', '似懂非懂', '2上的', '对方的', '', 0, 0);

-- ----------------------------
-- Table structure for machineoperate
-- ----------------------------
DROP TABLE IF EXISTS `machineoperate`;
CREATE TABLE `machineoperate`  (
  `operateId` int(255) NOT NULL AUTO_INCREMENT COMMENT '操作id',
  `totalTime` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '总连轧时长',
  `ctrlId` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '连轧id',
  `rollWeight` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '连轧重量',
  `material` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '材质',
  `rollNumber` int(255) NULL DEFAULT 0 COMMENT '连轧个数',
  `rollIntervals` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '连轧间隔时间',
  `rollPressure` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '连轧压力',
  `rollTimes` int(255) NULL DEFAULT 0 COMMENT '0次数',
  `openedSensor` int(255) NULL DEFAULT 0 COMMENT '1打开，0不打开',
  `openedCounter` int(255) NULL DEFAULT 0 COMMENT '1打开，0不打开',
  `openedMachine` int(255) NULL DEFAULT 0 COMMENT '1打开，0不打开',
  `startTime` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '开始时间',
  `stopTime` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '结束时间',
  PRIMARY KEY (`operateId`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_bin COMMENT = '压铸机操作表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of machineoperate
-- ----------------------------
INSERT INTO `machineoperate` VALUES (2, '180分钟', '2018080201', '2000kg', '塑料', 4, '3分钟', '2000kpa', 3, 1, 1, 0, '2018-11-21 23:07:11', '');
INSERT INTO `machineoperate` VALUES (4, '180分钟', '20180802012', '2000kg', '塑料', 300, '3分钟', '2000kpa', 3, 0, 0, 0, '2018-11-21 23:22:23', NULL);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `roleId` int(255) NOT NULL AUTO_INCREMENT COMMENT '角色号',
  `roleName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '角色名称',
  `descript` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '角色描述',
  `deleted` int(255) NULL DEFAULT 0 COMMENT '1删除，0不删除',
  PRIMARY KEY (`roleId`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_bin COMMENT = '权限/角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (1, '系统管理员', '拥有最高权限，可维护项目', 0);
INSERT INTO `role` VALUES (2, '一般用户01', '只能使用一般查询权限，权限范围较少', 0);
INSERT INTO `role` VALUES (4, '一般用户', '只能使用一般查询权限，权限范围较少', 0);
INSERT INTO `role` VALUES (6, '一般用户02', '描述内容', 0);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `userId` int(255) NOT NULL AUTO_INCREMENT COMMENT '用户Id',
  `userName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '用户名',
  `userAccount` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '登陆账号',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '密码',
  `roleId` int(255) NULL DEFAULT 0 COMMENT '角色号，关联到权限',
  `dep` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '部门',
  `loginTime` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '登陆时间',
  `logoutTime` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '退出时间',
  `deleted` int(255) NULL DEFAULT 0 COMMENT '1删除，0不删除',
  PRIMARY KEY (`userId`) USING BTREE,
  INDEX `roleId`(`roleId`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, '系统管理员', 'admin', 'admin', 1, '人事部', '2018-11-28 21:41:56', '2018-11-28 21:41:50', 0);
INSERT INTO `user` VALUES (2, '普通操作员1', 'normal001', 'normal001', 2, '行政部', '2018-11-27 23:21:45', '2018-11-27 23:22:10', 0);
INSERT INTO `user` VALUES (3, '张三', 'zhangsan', 'zhangsan', 2, '部门01', '', '', 0);
INSERT INTO `user` VALUES (4, 'admin', 'admin1234', 'admin1234', 1, 'bumen', '2018-11-17 22:49:46', '2018-11-18 00:23:08', 0);

SET FOREIGN_KEY_CHECKS = 1;
