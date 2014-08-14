--
-- Estructura de tabla para la tabla `sf_language`
--

DROP TABLE IF EXISTS `sf_language`;
CREATE TABLE IF NOT EXISTS `sf_language` (
  `id_language` int(11) NOT NULL auto_increment,
  `language` varchar(10) collate latin1_spanish_ci default NULL,
  `country` varchar(10) collate latin1_spanish_ci default NULL,
  `principal` set('0','1') collate latin1_spanish_ci default '0',
  `status` set('0','1') collate latin1_spanish_ci default '0',
  PRIMARY KEY  (`id_language`),
  UNIQUE KEY `culture` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `sf_language`
--

INSERT INTO `sf_language` (`id_language`, `language`, `country`, `principal`, `status`) VALUES
(1, 'en', 'US', '1', '1'),
(2, 'es', 'VE', '0', '1');
