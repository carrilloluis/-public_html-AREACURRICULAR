-- Course_
USE `t3st`;
DROP TABLE IF EXISTS `TypeCourse_`;
DELIMITER //
CREATE TABLE IF NOT EXISTS `TypeCourse_` (
	`id` TINYINT(1) UNSIGNED NOT NULL PRIMARY KEY, -- Identificador interno de una Asignatura en la BD
	`start_date` DATE NOT NULL, -- COMMENT 'Fecha inicial de vigencia'
	`name` VARCHAR(64) CHARACTER SET utf8 NOT NULL, -- Ejemplo: Matemática como texto
	`is_active` BIT(1) NOT NULL DEFAULT b'1' -- COMMENT Está habilitado: SI o NO
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
DELIMITER ;