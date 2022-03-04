/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  zayro
 * Created: 3/12/2018
 */

ALTER TABLE `archivos` ADD `img_factura` VARCHAR(50) NOT NULL AFTER `fecha_carga`;

ALTER TABLE `archivos` ADD `num_factura` VARCHAR(50) NOT NULL AFTER `img_factura`;

ALTER TABLE `archivos` ADD `validacion` BOOLEAN NOT NULL AFTER `num_factura`;

INSERT INTO `categoria_productos` (`id`, `nombre`) VALUES ('0', 'sin asignar');