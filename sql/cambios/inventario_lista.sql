/*
Navicat MariaDB Data Transfer

Source Server         : local mariadb
Source Server Version : 100122
Source Host           : localhost:3307
Source Database       : vandino

Target Server Type    : MariaDB
Target Server Version : 100122
File Encoding         : 65001

Date: 2019-01-19 13:41:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for inventario_lista
-- ----------------------------
DROP TABLE IF EXISTS `inventario_lista`;
CREATE TABLE `inventario_lista` (
  `id_inventario_lista` int(11) NOT NULL,
  `cedula_usuario` bigint(20) NOT NULL,
  `id_categoria_productos` varchar(110) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` decimal(5,2) NOT NULL,
  `espesor` int(2) NOT NULL,
  `id_almacenes` int(11) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_inventario_lista`),
  KEY `cedula_usuario` (`cedula_usuario`),
  KEY `id_inventario_lista` (`id_inventario_lista`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='almancena la carga del inventario';
SET FOREIGN_KEY_CHECKS=1;
