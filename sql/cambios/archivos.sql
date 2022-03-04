/*
Navicat MariaDB Data Transfer

Source Server         : local mariadb
Source Server Version : 100122
Source Host           : localhost:3307
Source Database       : vandino

Target Server Type    : MariaDB
Target Server Version : 100122
File Encoding         : 65001

Date: 2019-01-19 13:42:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for archivos
-- ----------------------------
DROP TABLE IF EXISTS `archivos`;
CREATE TABLE `archivos` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(50) DEFAULT '0',
  `fecha_factura` date DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `milimetros` tinyint(4) DEFAULT NULL,
  `metros` double DEFAULT NULL,
  `fecha_carga` datetime DEFAULT CURRENT_TIMESTAMP,
  `img_factura` varchar(50) NOT NULL,
  `num_factura` varchar(50) NOT NULL,
  `validacion` tinyint(1) NOT NULL DEFAULT '0',
  `id_almacen` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
SET FOREIGN_KEY_CHECKS=1;
