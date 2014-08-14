
--
-- Table structure for table `sf_news`
--

CREATE TABLE IF NOT EXISTS `sf_news` (
  `id_news` int(10) NOT NULL auto_increment,
  `title` varchar(200) collate latin1_spanish_ci NOT NULL,
  `sub_title` varchar(150) collate latin1_spanish_ci default NULL,
  `body` text collate latin1_spanish_ci NOT NULL,
  `date` date default NULL,
  `summary` text collate latin1_spanish_ci NOT NULL,
  `author` varchar(100) collate latin1_spanish_ci default NULL,
  `image` varchar(50) collate latin1_spanish_ci default NULL,
  `status` set('0','1') collate latin1_spanish_ci NOT NULL,
  `home` set('1','0') collate latin1_spanish_ci NOT NULL,
  `permalink` text collate latin1_spanish_ci,
  `home_title` varchar(58) collate latin1_spanish_ci default NULL,
  `category` varchar(20) collate latin1_spanish_ci default NULL,
  PRIMARY KEY  (`id_news`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ;
