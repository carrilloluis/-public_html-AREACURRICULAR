USE `t3st`;
DROP TABLE IF EXISTS `CurricularArea_`;
DELIMITER //
CREATE TABLE IF NOT EXISTS `CurricularArea_` (
  `id` CHAR(8) CHARACTER SET ascii NOT NULL PRIMARY KEY, -- COMMENT 'Identificador interno de una Asignautura para un Grado Académico en la Base de Datos'
  `level_id` CHAR(2) CHARACTER SET ascii NOT NULL, -- COMMENT Identificador PK del NIVEL ACADÉMICO, ejem: B0 // primaria, F0
  `grade_id` INTEGER UNSIGNED NOT NULL, -- COMMENT 'Identificador interno del grado',
  `course_id` TINYINT(1) UNSIGNED NOT NULL, -- COMMENT 'Identificador de la asignatura o curso'
  `is_active` BIT(1) NOT NULL DEFAULT b'1' -- COMMENT 'Está habilitado: SI o NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
DELIMITER ;

-- April/2022
DROP TABLE IF EXISTS `CurricularAreaProposal_`;
DELIMITER //
CREATE TABLE IF NOT EXISTS `CurricularAreaProposal_` (
  `id` CHAR(8) CHARACTER SET ascii NOT NULL PRIMARY KEY, -- COMMENT 'Identificador interno de una Asignautura para un Grado Académico en la Base de Datos'
  `start_date` DATE NOT NULL, -- COMMENT 'Fecha inicial de vigencia'
  `level_id` CHAR(2) CHARACTER SET ascii NOT NULL, -- COMMENT Identificador PK del NIVEL ACADÉMICO, ejem: B0 // primaria, F0
  `grade_id` INTEGER UNSIGNED NOT NULL, -- COMMENT 'Identificador interno del grado',
  `course_id` TINYINT(1) UNSIGNED NOT NULL, -- COMMENT 'Identificador de la asignatura o curso'
  `is_active` BIT(1) NOT NULL DEFAULT b'1' -- COMMENT 'Está habilitado: SI o NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
DELIMITER ;