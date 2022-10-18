DROP TABLE `ipav`.`turnos`;
DROP TABLE `ipav`.`turnos_empleado`;
DROP TABLE `ipav`.`turnos_tareasxdelegacion`;
DROP TABLE `ipav`.`turnos_tarea`;
DROP TABLE `ipav`.`turnos_usuario`;
DROP TABLE `ipav`.`turnos_parametros`;
DROP TABLE `ipav`.`ipav_localidades`;
DROP TABLE `ipav`.`ipav_provincias`;
DROP TABLE `ipav`.`ipav_gerencia`;
DROP TABLE `ipav`.`ipav_delegacion`;
DROP TABLE `ipav`.`turnos_diasnolaborables`;

CREATE TABLE `turnos_diasnolaborables` (
  `fecha` date NOT NULL,
  `marca` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ipav_delegacion` (
  `id_delegacion` int(11) NOT NULL AUTO_INCREMENT,
  `nom_delegacion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mapa` varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_delegacion`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `ipav_gerencia` (
  `id_gerencia` int(11) NOT NULL AUTO_INCREMENT,
  `nom_gerencia` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `gerente` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `imggerencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nivel` int(11) NOT NULL,
  `url` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_gerencia`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `ipav_provincias` (
  `idprovincias` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_provincia` varchar(45) NOT NULL,
  PRIMARY KEY (`idprovincias`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `ipav_localidades` (
  `id_loc` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_loc` varchar(100) NOT NULL,
  `descrip_loc` text NOT NULL,
  `idpro_loc` int(11) NOT NULL,
  `url_slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mapas_loc` varchar(500) DEFAULT NULL,
  `actualizado_loc` datetime NOT NULL DEFAULT current_timestamp(),
  `codigopostal` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_loc`),
  UNIQUE KEY `URL_MULTIMEDIA` (`url_slug`),
  KEY `FK_localidad_to_provincia_idx` (`idpro_loc`),
  CONSTRAINT `FK_localidad_to_provincia` FOREIGN KEY (`idpro_loc`) REFERENCES `ipav_provincias` (`idprovincias`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `turnos_parametros` (
  `id_parametro` int(11) NOT NULL AUTO_INCREMENT,
  `id_delegacion` int(11) NOT NULL,
  `id_gerencia` int(11) NOT NULL,
  `turnosmismohorario` int(11) NOT NULL,
  `cantDiarios` int(11) NOT NULL,
  `intervalo` int(11) NOT NULL,
  PRIMARY KEY (`id_parametro`),
  KEY `parametros_to_delegacion_idx` (`id_delegacion`),
  KEY `parametros_to_gerencia_idx` (`id_gerencia`),
  CONSTRAINT `parametros_to_delegacion` FOREIGN KEY (`id_delegacion`) REFERENCES `ipav_delegacion` (`id_delegacion`),
  CONSTRAINT `parametros_to_gerencia` FOREIGN KEY (`id_gerencia`) REFERENCES `ipav_gerencia` (`id_gerencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `turnos_usuario` (
  `cuit` bigint(20) NOT NULL,
  `num_doc` int(11) NOT NULL,
  `nrotramite` bigint(20) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_localidad` int(11) DEFAULT NULL,
  `domicilio` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `numero` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dpto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `celular` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_hora_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `ultimo_ingreso` datetime DEFAULT NULL,
  PRIMARY KEY (`cuit`),
  KEY `fk_usario_to_localidad_idx` (`id_localidad`),
  CONSTRAINT `fk_usario_to_localidad` FOREIGN KEY (`id_localidad`) REFERENCES `ipav_localidades` (`id_loc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `turnos_tarea` (
  `id_tarea` int(11) NOT NULL AUTO_INCREMENT,
  `id_gerencia` int(11) NOT NULL,
  `nombreTarea` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `mensaje` varchar(2000) COLLATE utf8_spanish_ci DEFAULT NULL,
  `resaltar` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_tarea`),
  KEY `tarea_to_gerencia_idx` (`id_gerencia`),
  CONSTRAINT `tarea_to_gerencia` FOREIGN KEY (`id_gerencia`) REFERENCES `ipav_gerencia` (`id_gerencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `turnos_tareasxdelegacion` (
  `iddelegacion` int(11) NOT NULL,
  `idtarea` int(11) NOT NULL,
  `privacidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'PUBLICO',
  `hora_inicio_atencion` time NOT NULL,
  `hora_fin_atencion` time NOT NULL,
  `tienepuestos` tinyint(4) NOT NULL DEFAULT 0,
  `fecha_limite` date DEFAULT NULL,
  PRIMARY KEY (`iddelegacion`,`idtarea`),
  KEY `idtarea_to_tarea_idx` (`idtarea`),
  CONSTRAINT `tareaxdelegacion_to_delegacion` FOREIGN KEY (`iddelegacion`) REFERENCES `ipav_delegacion` (`id_delegacion`),
  CONSTRAINT `tareaxdelegacion_to_tarea` FOREIGN KEY (`idtarea`) REFERENCES `turnos_tarea` (`id_tarea`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `turnos_empleado` (
  `cuit` bigint(20) NOT NULL,
  `num_doc` bigint(20) NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_delegacion` int(11) NOT NULL,
  `id_gerencia` int(11) NOT NULL,
  `tipo_acceso` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`cuit`),
  KEY `empleado_to_delegacion_idx` (`id_delegacion`),
  KEY `emplado_to_gerencia_idx` (`id_gerencia`),
  CONSTRAINT `emplado_to_gerencia` FOREIGN KEY (`id_gerencia`) REFERENCES `ipav_gerencia` (`id_gerencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `empleado_to_delegacion` FOREIGN KEY (`id_delegacion`) REFERENCES `ipav_delegacion` (`id_delegacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `turnos` (
  `id_turno` int(11) NOT NULL AUTO_INCREMENT,
  `cuit` bigint(20) NOT NULL,
  `fecha_turno` date DEFAULT NULL,
  `hora_turno` time DEFAULT NULL,
  `id_tarea` int(11) NOT NULL,
  `id_gerencia` int(11) NOT NULL,
  `estado_turno` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'EN ESPERA',
  `usuariocuit_inicioAtencion` bigint(20) DEFAULT NULL,
  `fechaHora_inicioAtencion` datetime DEFAULT NULL,
  `usuariocuit_finAtencion` bigint(20) DEFAULT NULL,
  `fechaHora_finAtencion` datetime DEFAULT NULL,
  `observacion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_delegacion` int(11) NOT NULL,
  `fecha_hora_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `puesto` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_turno`),
  KEY `turnos_to_tareas_idx` (`id_tarea`),
  KEY `turnos_to_delegacion_idx` (`id_delegacion`),
  KEY `turnos_to_empleado_inicio_idx` (`usuariocuit_inicioAtencion`),
  KEY `turnos_to_empleado_fin_idx` (`usuariocuit_finAtencion`),
  KEY `turnos_to_usuario_idx` (`cuit`),
  KEY `turnos_to_gerencia_idx` (`id_gerencia`),
  CONSTRAINT `turnos_to_delegacion` FOREIGN KEY (`id_delegacion`) REFERENCES `ipav_delegacion` (`id_delegacion`),
  CONSTRAINT `turnos_to_empleado_fin` FOREIGN KEY (`usuariocuit_finAtencion`) REFERENCES `turnos_empleado` (`cuit`),
  CONSTRAINT `turnos_to_empleado_inicio` FOREIGN KEY (`usuariocuit_inicioAtencion`) REFERENCES `turnos_empleado` (`cuit`),
  CONSTRAINT `turnos_to_gerencia` FOREIGN KEY (`id_gerencia`) REFERENCES `ipav_gerencia` (`id_gerencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `turnos_to_tareas` FOREIGN KEY (`id_tarea`) REFERENCES `turnos_tarea` (`id_tarea`),
  CONSTRAINT `turnos_to_usuario` FOREIGN KEY (`cuit`) REFERENCES `turnos_usuario` (`cuit`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
