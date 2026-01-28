SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE `sistema_aprendizaje` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sistema_aprendizaje`;

CREATE TABLE IF NOT EXISTS `resultados` (
  `id_res` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `estilo_dominante` varchar(50) DEFAULT NULL,
  `valor_activo_reflexivo` int(11) DEFAULT NULL,
  `valor_sensorial_intuitivo` int(11) DEFAULT NULL,
  `valor_visual_verbal` int(11) DEFAULT NULL,
  `valor_secuencial_global` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_res`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

INSERT INTO `resultados` (`id_res`, `usuario_id`, `estilo_dominante`, `valor_activo_reflexivo`, `valor_sensorial_intuitivo`, `valor_visual_verbal`, `valor_secuencial_global`) VALUES
(1, 1, 'Activo/Reflexivo', 1, 1, 2, 2),
(2, 2, 'Visual/Verbal', -1, -1, 0, -2),
(3, 3, 'Activo', 2, -1, 3, 1),
(4, 4, 'Activo', 2, -1, 3, 1),
(5, 5, 'Visual', 1, 1, 3, -2),
(6, 6, 'Sensorial', 0, 3, 1, 2),
(7, 7, 'Activo', 3, 2, -1, 1),
(8, 8, 'Reflexivo', -3, 1, 2, 2),
(9, 9, 'Visual', 1, -1, 3, 1),
(10, 10, 'Sensorial', 2, 3, 1, -1),
(11, 11, 'Activo', 3, 1, 2, 1),
(12, 12, 'Secuencial', 1, 0, 1, 3);

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha_nac` date NOT NULL,
  `genero` enum('M','F','Otro') NOT NULL,
  `carrera` varchar(50) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=133 ;

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `fecha_nac`, `genero`, `carrera`, `fecha_registro`) VALUES
(1, 'Daniel Chango', 'danii@uce.edu.ec', '2004-01-25', 'M', 'Sistemas', '2026-01-19 14:02:24'),
(2, 'Elvis Santamaria', 'elvis@uce.edu.ec', '2003-08-18', 'M', 'Psicologia', '2026-01-19 14:14:10'),
(3, 'Carla Méndez', 'camendez@uce.edu.ec', '1999-02-20', 'F', 'Psicologia', '2026-01-15 16:30:00'),
(4, 'Andrés López', 'alopez@uce.edu.ec', '2000-11-10', 'M', 'Sistemas', '2026-01-16 14:15:00'),
(5, 'Sofía Reyes', 'sreyes@uce.edu.ec', '1997-08-05', 'F', 'Diseno', '2026-01-16 19:20:00'),
(6, 'Roberto Vaca', 'rvaca@uce.edu.ec', '1999-12-30', 'M', 'Sistemas', '2026-01-17 13:45:00'),
(7, 'Lucía Torres', 'ltorres@uce.edu.ec', '2001-03-12', 'F', 'Administracion', '2026-01-17 21:10:00'),
(8, 'Mateo Salinas', 'msalinas@uce.edu.ec', '2000-07-22', 'M', 'Psicologia', '2026-01-18 15:05:00'),
(9, 'Elena Gómez', 'egomez@uce.edu.ec', '1998-09-18', 'F', 'Sistemas', '2026-01-18 17:40:00'),
(10, 'Ricardo Paz', 'rpaz@uce.edu.ec', '1999-05-25', 'M', 'Diseno', '2026-01-19 14:00:00'),
(11, 'Valeria Luna', 'vluna@uce.edu.ec', '2000-01-14', 'F', 'Administracion', '2026-01-19 16:20:00'),
(12, 'Fernando Ruiz', 'fruiz@uce.edu.ec', '1997-04-10', 'M', 'Sistemas', '2026-01-19 17:00:00');

ALTER TABLE `resultados`
  ADD CONSTRAINT `resultados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

