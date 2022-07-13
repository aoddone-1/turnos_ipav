DROP TABLE `ipav`.`bdigital_cuotasxresumen`;
DROP TABLE `ipav`.`bdigital_resumenes`;
DROP TABLE `ipav`.`bdigital_cuotas`;
DROP TABLE `ipav`.`bdigital_adhesiones`;
DROP TABLE `ipav`.`bdigital_adjudicatarios`;
DROP TABLE `ipav`.`totem_impresionesxcuotas`;
DROP TABLE `ipav`.`turnos`;
DROP TABLE `ipav`.`turnos_usuario`;
DROP TABLE `ipav`.`turnos_diasnolaborables`;
DROP TABLE `ipav`.`turnos_empleado`;
DROP TABLE `ipav`.`turnos_parametros`;
DROP TABLE `ipav`.`turnos_tareasxdelegacion`;
DROP TABLE `ipav`.`turnos_tarea`;
DROP TABLE `ipav`.`ipav_videos`;
DROP TABLE `ipav`.`ipav_visitas`;
DROP TABLE `ipav`.`ipav_usuarios`;
DROP TABLE `ipav`.`ipav_serviciosdigitales`;
DROP TABLE `ipav`.`ipav_noticias`;
DROP TABLE `ipav`.`ipav_planesviviendas`;
DROP TABLE `ipav`.`ipav_localidades`;
DROP TABLE `ipav`.`ipav_provincias`;
DROP TABLE `ipav`.`ipav_enlaces`;
DROP TABLE `ipav`.`ipav_contacto`;
DROP TABLE `ipav`.`ipav_formularios`;
DROP TABLE `ipav`.`ipav_gerencia`;
DROP TABLE `ipav`.`ipav_delegacion`;


CREATE TABLE `ipav_delegacion` (
  `id_delegacion` int NOT NULL AUTO_INCREMENT,
  `nom_delegacion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `mapa` varchar(1000) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_delegacion`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

CREATE TABLE `ipav_gerencia` (
  `id_gerencia` int NOT NULL AUTO_INCREMENT,
  `nom_gerencia` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `gerente` varchar(90) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imggerencia` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nivel` int NOT NULL,
  `url` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_gerencia`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;


CREATE TABLE `ipav_formularios` (
  `id_formulario` int NOT NULL AUTO_INCREMENT,
  `titulo_formulario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `gerencia_formulario` int NOT NULL,
  `enlace_formulario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion_formulario` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `cantdescarga_formulario` int NOT NULL DEFAULT '0',
  `fecha_formulario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_formulario`),
  KEY `fk_formulario_to_gerencia_idx` (`gerencia_formulario`),
  CONSTRAINT `fk_formulario_to_gerencia` FOREIGN KEY (`gerencia_formulario`) REFERENCES `ipav_gerencia` (`id_gerencia`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE `ipav_contacto` (
  `id_con` int NOT NULL AUTO_INCREMENT,
  `delegacion_con` int NOT NULL,
  `gerencia_con` int DEFAULT NULL,
  `oficina_con` varchar(45) DEFAULT NULL,
  `codarea_con` text NOT NULL,
  `telefonos_con` text NOT NULL,
  `nrointer_con` text,
  `emails_con` text,
  `mostrar_con` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_con`),
  KEY `fk_con_to_delegacion_idx` (`delegacion_con`),
  KEY `fk_con_to_gerencia_idx` (`gerencia_con`),
  CONSTRAINT `fk_con_to_delegacion` FOREIGN KEY (`delegacion_con`) REFERENCES `ipav_delegacion` (`id_delegacion`),
  CONSTRAINT `fk_con_to_gerencia` FOREIGN KEY (`gerencia_con`) REFERENCES `ipav_gerencia` (`id_gerencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `ipav_enlaces` (
  `id_enlace` int NOT NULL AUTO_INCREMENT,
  `titulo_enlace` varchar(250) NOT NULL,
  `resumen_enlace` text NOT NULL,
  `texto_enlace` text NOT NULL,
  `url_enlace` varchar(100) NOT NULL,
  `imagen_enlace` varchar(100) NOT NULL,
  PRIMARY KEY (`id_enlace`),
  UNIQUE KEY `url_enlace_UNIQUE` (`url_enlace`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `ipav_provincias` (
  `idprovincias` int NOT NULL AUTO_INCREMENT,
  `nombre_provincia` varchar(45) NOT NULL,
  PRIMARY KEY (`idprovincias`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `ipav_localidades` (
  `id_loc` int NOT NULL AUTO_INCREMENT,
  `nombre_loc` varchar(100) NOT NULL,
  `descrip_loc` text NOT NULL,
  `idpro_loc` int NOT NULL,
  `url_slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mapas_loc` varchar(500) DEFAULT NULL,
  `actualizado_loc` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `codigopostal` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_loc`),
  UNIQUE KEY `URL_MULTIMEDIA` (`url_slug`),
  KEY `FK_localidad_to_provincia_idx` (`idpro_loc`),
  CONSTRAINT `FK_localidad_to_provincia` FOREIGN KEY (`idpro_loc`) REFERENCES `ipav_provincias` (`idprovincias`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `ipav_planesviviendas` (
  `id_plan` int NOT NULL AUTO_INCREMENT,
  `nombreplan` varchar(45) NOT NULL,
  `resumen` text NOT NULL,
  `descripcion` text NOT NULL,
  `imagen_plan` varchar(45) NOT NULL,
  `enlace_plan` varchar(45) NOT NULL,
  `mostrar_plan` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_plan`),
  UNIQUE KEY `enlace_plan_UNIQUE` (`enlace_plan`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `ipav_noticias` (
  `id_noticia` int NOT NULL AUTO_INCREMENT,
  `titulo_not` varchar(255) NOT NULL,
  `resumen_not` text NOT NULL,
  `cuerpo_not` text NOT NULL,
  `imagen_not` varchar(45) NOT NULL,
  `enlace_not` varchar(255) NOT NULL,
  `fecha_not` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mostrar_not` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_noticia`),
  UNIQUE KEY `enlace_not_UNIQUE` (`enlace_not`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `ipav_serviciosdigitales` (
  `id_servicio` int NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(45) NOT NULL,
  `resumen_servicio` text,
  `imagen_servicio` varchar(45) NOT NULL,
  `enlace_servicio` varchar(45) DEFAULT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  `activar_servicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_servicio`),
  UNIQUE KEY `enlace_servicio_UNIQUE` (`enlace_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `ipav_usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name_lastname` varchar(100) NOT NULL,
  `user_type` varchar(45) NOT NULL,
  `first_time` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `ipav_visitas` (
  `idvisita` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `icono` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `enlace` varchar(300) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `visitas` int NOT NULL,
  `mesanio` varchar(300) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_ultvisita` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idvisita`),
  KEY `enlace_idx` (`enlace`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

CREATE TABLE `ipav_videos` (
  `id_video` int NOT NULL AUTO_INCREMENT,
  `titulo_video` varchar(100) NOT NULL,
  `tipo_video` varchar(45) NOT NULL,
  `url_video` varchar(100) NOT NULL,
  `url_portada` varchar(100) DEFAULT NULL,
  `fecha_video` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_video`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

CREATE TABLE `turnos_tarea` (
  `id_tarea` int NOT NULL AUTO_INCREMENT,
  `id_gerencia` int NOT NULL,
  `nombreTarea` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `mensaje` varchar(2000) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `resaltar` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_tarea`),
  KEY `tarea_to_gerencia_idx` (`id_gerencia`),
  CONSTRAINT `tarea_to_gerencia` FOREIGN KEY (`id_gerencia`) REFERENCES `ipav_gerencia` (`id_gerencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

CREATE TABLE `turnos_tareasxdelegacion` (
  `iddelegacion` int NOT NULL,
  `idtarea` int NOT NULL,
  `privacidad` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'PUBLICO',
  `hora_inicio_atencion` time NOT NULL,
  `hora_fin_atencion` time NOT NULL,
  `tienepuestos` tinyint NOT NULL DEFAULT '0',
  `fecha_limite` date DEFAULT NULL,
  PRIMARY KEY (`iddelegacion`,`idtarea`),
  KEY `idtarea_to_tarea_idx` (`idtarea`),
  CONSTRAINT `tareaxdelegacion_to_delegacion` FOREIGN KEY (`iddelegacion`) REFERENCES `ipav_delegacion` (`id_delegacion`),
  CONSTRAINT `tareaxdelegacion_to_tarea` FOREIGN KEY (`idtarea`) REFERENCES `turnos_tarea` (`id_tarea`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;



CREATE TABLE `turnos_parametros` (
  `id_parametro` int NOT NULL AUTO_INCREMENT,
  `id_delegacion` int NOT NULL,
  `id_gerencia` int NOT NULL,
  `turnosmismohorario` int NOT NULL,
  `cantDiarios` int NOT NULL,
  `intervalo` int NOT NULL,
  PRIMARY KEY (`id_parametro`),
  KEY `parametros_to_delegacion_idx` (`id_delegacion`),
  KEY `parametros_to_gerencia_idx` (`id_gerencia`),
  CONSTRAINT `parametros_to_delegacion` FOREIGN KEY (`id_delegacion`) REFERENCES `ipav_delegacion` (`id_delegacion`),
  CONSTRAINT `parametros_to_gerencia` FOREIGN KEY (`id_gerencia`) REFERENCES `ipav_gerencia` (`id_gerencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

CREATE TABLE `turnos_empleado` (
  `cuit` bigint NOT NULL,
  `num_doc` bigint NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_delegacion` int NOT NULL,
  `id_gerencia` int NOT NULL,
  `tipo_acceso` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`cuit`),
  KEY `empleado_to_delegacion_idx` (`id_delegacion`),
  KEY `emplado_to_gerencia_idx` (`id_gerencia`),
  CONSTRAINT `emplado_to_gerencia` FOREIGN KEY (`id_gerencia`) REFERENCES `ipav_gerencia` (`id_gerencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `empleado_to_delegacion` FOREIGN KEY (`id_delegacion`) REFERENCES `ipav_delegacion` (`id_delegacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

CREATE TABLE `turnos_diasnolaborables` (
  `fecha` date NOT NULL,
  `marca` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;


CREATE TABLE `turnos_usuario` (
  `cuit` bigint NOT NULL,
  `num_doc` int NOT NULL,
  `nrotramite` bigint NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_localidad` int DEFAULT NULL,
  `domicilio` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `numero` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `dpto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `celular` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_hora_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ultimo_ingreso` datetime DEFAULT NULL,
  PRIMARY KEY (`cuit`),
  KEY `fk_usario_to_localidad_idx` (`id_localidad`),
  CONSTRAINT `fk_usario_to_localidad` FOREIGN KEY (`id_localidad`) REFERENCES `ipav_localidades` (`id_loc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

CREATE TABLE `turnos` (
  `id_turno` int NOT NULL AUTO_INCREMENT,
  `cuit` bigint NOT NULL,
  `fecha_turno` date DEFAULT NULL,
  `hora_turno` time DEFAULT NULL,
  `id_tarea` int NOT NULL,
  `id_gerencia` int NOT NULL,
  `estado_turno` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'EN ESPERA',
  `usuariocuit_inicioAtencion` bigint DEFAULT NULL,
  `fechaHora_inicioAtencion` datetime DEFAULT NULL,
  `usuariocuit_finAtencion` bigint DEFAULT NULL,
  `fechaHora_finAtencion` datetime DEFAULT NULL,
  `observacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_delegacion` int NOT NULL,
  `fecha_hora_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `puesto` int NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

CREATE TABLE `totem_impresionesxcuotas` (
  `id_impresion` int NOT NULL AUTO_INCREMENT,
  `cod_hipote` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `documento` int NOT NULL,
  `num_cuota` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `totem_impresion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha_hora_impresion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_impresion`,`cod_hipote`,`documento`,`num_cuota`),
  KEY `fk_totem_to_impresion_idx` (`cod_hipote`,`documento`,`num_cuota`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;





CREATE TABLE `bdigital_adjudicatarios` (
  `documento` int NOT NULL,
  `cod_hipote` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellido_nombre` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `domicilio` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `localidad` int NOT NULL,
  `codigopostal` varchar(5) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `proyecto` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `casa` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  `motivo_desactivo` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `ultima_busqueda` datetime DEFAULT NULL,
  `cant_busqueda` int NOT NULL DEFAULT '0',
  `tipo_emision` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'BOLETA',
  `ultima_busqueda_totem` datetime DEFAULT NULL,
  PRIMARY KEY (`documento`,`cod_hipote`),
  KEY `adjudicatarios_ibfk_1_idx` (`localidad`),
  CONSTRAINT `adjudicatarios_ibfk_1` FOREIGN KEY (`localidad`) REFERENCES `ipav_localidades` (`id_loc`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

CREATE TABLE `bdigital_adhesiones` (
  `cod_hipote` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documento` int NOT NULL,
  `correo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_alta` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_baja` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_hipote`,`documento`),
  KEY `adhesiones_ibfk_1` (`documento`,`cod_hipote`),
  CONSTRAINT `adhesiones_ibfk_1` FOREIGN KEY (`documento`, `cod_hipote`) REFERENCES `bdigital_adjudicatarios` (`documento`, `cod_hipote`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

CREATE TABLE `bdigital_cuotas` (
  `documento` int NOT NULL,
  `cod_hipote` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `num_cuota` int NOT NULL,
  `numero_prestamo` int NOT NULL,
  `inscripto` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `digito` int NOT NULL,
  `periodo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `cantidad_cuotas_vencidas` int NOT NULL,
  `plazo_inicial` int NOT NULL,
  `fec_vencimiento` date NOT NULL,
  `vencimiento_nuevo` date DEFAULT NULL,
  `amortizacion` decimal(9,2) NOT NULL,
  `interes` decimal(9,2) NOT NULL,
  `cuota_real` decimal(9,2) NOT NULL,
  `cuota_subsidiada` decimal(9,2) NOT NULL,
  `importe_total` decimal(9,2) NOT NULL,
  `importe_total_nuevo` decimal(9,2) DEFAULT '0.00',
  `seguro_incendio` decimal(9,2) NOT NULL,
  `descuento` decimal(9,2) NOT NULL,
  `seguro_vida` decimal(9,2) NOT NULL,
  `actualizacion` decimal(9,2) NOT NULL DEFAULT '0.00',
  `fecha_actualizacion` datetime DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `ultima_descarga` datetime DEFAULT NULL,
  `cant_descarga` int DEFAULT '0',
  `fec_limite_bancos` date NOT NULL,
  `cuotaminima` decimal(9,2) NOT NULL DEFAULT '0.00',
  `actualizadaweb` tinyint NOT NULL DEFAULT '0',
  `impresion_totem` datetime DEFAULT NULL,
  `impresa_totem` tinyint NOT NULL DEFAULT '0',
  `confirmado` datetime DEFAULT NULL,
  PRIMARY KEY (`documento`,`cod_hipote`,`num_cuota`,`numero_prestamo`) USING BTREE,
  KEY `index_totem` (`impresa_totem`,`impresion_totem`,`confirmado`,`actualizadaweb`),
  KEY `index_descarga_web` (`cant_descarga`,`ultima_descarga`),
  KEY `index_actualizacion` (`confirmado`,`actualizadaweb`,`actualizacion`,`fecha_actualizacion`,`vencimiento_nuevo`,`fecha_pago`,`fec_vencimiento`),
  KEY `index_codHipote` (`cod_hipote`) ,
  KEY `index_periodo` (`periodo`),
  CONSTRAINT `cuotas_ibfk_1` FOREIGN KEY (`documento`, `cod_hipote`) REFERENCES `bdigital_adjudicatarios` (`documento`, `cod_hipote`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;


CREATE TABLE `bdigital_resumenes` (
  `id_resumen` int NOT NULL AUTO_INCREMENT,
  `num_resumen` int NOT NULL,
  `cod_hipote` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documento` int NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vigente` tinyint NOT NULL DEFAULT '1',
  `creado_web` tinyint NOT NULL DEFAULT '1',
  `pagado` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_resumen`,`num_resumen`),
  KEY `FK_resumenes_to_adjudicatario_idx` (`documento`,`cod_hipote`) /*!80000 INVISIBLE */,
  KEY `fk_resumentes_to_cuotasxresumen` (`num_resumen`,`documento`,`cod_hipote`),
  CONSTRAINT `FK_resumenes_to_adjudicatario` FOREIGN KEY (`documento`, `cod_hipote`) REFERENCES `bdigital_adjudicatarios` (`documento`, `cod_hipote`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5865 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

CREATE TABLE `bdigital_cuotasxresumen` (
  `num_resumen` int NOT NULL,
  `documento` int NOT NULL,
  `cod_hipote` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `num_cuota` int NOT NULL,
  `numero_prestamo` int NOT NULL,
  `confirmado` datetime DEFAULT NULL,
  PRIMARY KEY (`num_resumen`,`documento`,`cod_hipote`,`num_cuota`,`numero_prestamo`),
  KEY `idx_cuotasxresumentes_to_resumen` (`num_resumen`,`documento`,`cod_hipote`,`num_cuota`) /*!80000 INVISIBLE */,
  CONSTRAINT `fk_cuotasxresumentes_to_resumen` FOREIGN KEY (`num_resumen`, `documento`, `cod_hipote`) REFERENCES `bdigital_resumenes` (`num_resumen`, `documento`, `cod_hipote`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
