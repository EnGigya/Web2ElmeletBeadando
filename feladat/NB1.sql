CREATE DATABASE IF NOT EXISTS `NB1`
CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `NB1`;

CREATE TABLE IF NOT EXISTS `klub` (
  `id` int(11) unsigned NOT NULL,
  `csapatnev` varchar(45)  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;


INSERT INTO `klub` (`id`, `csapatnev`) VALUES
(1,	'Vasas FC'),
(2,	'Ferencvárosi TC'),
(3,	'Puskás Akadémia FC'),
(4,	'Debreceni VSC'),
(5,	'Budapest Honvéd FC'),
(6,	'Szombathelyi Haladás'),
(7,	'Paksi FC'),
(8,	'Mezőkövesd Zsóry FC'),
(9,	'Diósgyőri VTK'),
(10,	'Újpest FC'),
(11,	'Balmazújváros FC'),
(12,	'Videoton FC');




CREATE TABLE IF NOT EXISTS `poszt` (
 `id` int(11) unsigned NOT NULL,
 `nev` varchar(45)  NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

INSERT INTO `poszt` (`id`, `nev`) VALUES
(1,	'bal oldali védő'),
(2,	'jobb oldali középpályás'),
(3,	'bal szélső'),
(4,	'védekező középpályás'),
(5,	'bal oldali középpályás'),
(6,	'belső középpályás'),
(7,	'jobb szélső'),
(8,	'jobb oldali védő'),
(9,	'kapus'),
(10,	'középcsatár'),
(11,	'középső védő'),
(12,	'támadó középpályás'),
(13,	'hátravont csatár'),
(14,	'jobboldali védő');



CREATE TABLE IF NOT EXISTS `labdarugo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mezszam` int(11) unsigned NOT NULL,
  `klubid` int(11) unsigned NOT NULL,
  `posztid` int(11) unsigned NOT NULL,
  `utonev` varchar(30) COLLATE utf8_hungarian_ci,
  `vezeteknev` varchar(30) COLLATE utf8_hungarian_ci NOT NULL,
  `szulido` date DEFAULT NULL,
  `magyar` BOOLEAN, 
  `kulfoldi` BOOLEAN,
  `ertek` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (klubid) REFERENCES klub (id),
  FOREIGN KEY (posztid) REFERENCES poszt (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=51;

INSERT INTO `labdarugo` (`id`, `mezszam`, `klubid`, `posztid`, `utonev`, `vezeteknev`, `szulido`, `magyar`, `kulfoldi`, `ertek`) VALUES
(1,	18,	11,	4,	'Attila',	'Haris',	'1997.01.23',	-1,	0,	150),
(2,	31,	6,	12,	'Márió',	'Németh',	'1995.05.01',	-1,	0,	300),
(3,	77,	4,	2,	'Aleksandar',	'Jovanovic',	'1984.10.26',	0,	-1,	300),
(4,	14,	4,	8,	'Krisztián',	'Kuti',	        '1992.12.04',	-1,	0,	100),
(5,	9,	3,	10,	'Ulysse',	'Diallo',	'1992.10.26',	0,	-1,	250),
(6,	12,	3,	4,	'Balázs',	'Balogh',	'1990.06.11',	-1,	0,	400),
(7,	33,	3,	7,	'Gábor',	'Molnár',	'1994.05.16',	-1,	0,	400),
(8,	7,	7,	1,	'Tamás',	'Báló',	        '1984.01.12',	-1,	0,	100),
(9,	17,	12,	4,	'Máté',  	'Pátkai',	'1988.03.06',	-1,	0,	750),
(10,	10,	8,	4,	'Bence',	'Iszlai',	'1990.05.29',	-1,	0,	300),
(11,	28,	2,	12,	'Joseph',	'Paintsil',	'1998.02.01',	0,	-1,	400),
(12,	12,	6,	6,	'Bence',	'Kiss',	        '1999.07.01',	-1,	0,	150),
(13,	1,	9,	9,	'Erik', 	'Bukrán',	'1996.12.06',	-1,	0,	75),
(15,	23,	11,	7,	'Ádám', 	'Kovács',	'1991.04.14',	-1,	0,	150),
(16,	27,	1,	7,	'Benedek',	'Murka',	'1997.09.10',	-1,	0,	250),
(17,	19,	9,	8,	'Tibor',	'Nagy',	        '1991.08.14',	-1,	0,	150),
(18,	22,	7,	12,	'Áron',	        'Fejős',	'1997.04.17',	-1,	0,	50),
(19,	56,	11,	10,	'Miklós',	'Belényesi',	'1983.05.15',	-1,	0,	50),
(20,	1,	3,	9,	'Balázs',	'Tóth',	        '1997.09.04',	-1,	0,	50),
(21,	6,	4,	8,	'Balázs',	'Bényei',	'1990.01.10',	-1,	0,	250),
(22,	21,	6,	3,	'Tamás',	'Kiss',  	'2000.11.24',	-1,	0,	50),
(23,	25,	4,	10,	'Haris',	'Tabakovic',	'1994.06.20',	 0,	-1,	250),
(24,	14,	10,	6,	'Alassane',	'Diallo',	'1995.02.19',	 0,	-1,	200),
(25,	94,	7,	10,	'Bence',	'Daru',  	'1994.06.05',	-1,	0,	125),
(26,	99,	8,	12,	'Márk', 	'Murai',	'1996.07.15',	-1,	0,	25),
(27,	40,	1,	10,	'István',	'Ferenczi',	'1977.09.14',	-1,	0,	50),
(28,	3,	6,	8,	'Dávid',	'Tóth',         '1998.07.09',	-1,	0,	100),
(29,	4,	9,	11,	'Márk',	        'Tamás',	'1993.10.28',	-1,	0,	300),
(30,	74,	12,	9	,'Ádám',	'Kovácsik',	'1991.04.04'	,-1,	0,	450),
(31,	17,	10,	13,	'Viktor'	,'Angelov',	'1994.03.27',	0,	-1,	150),
(32,	31,	12,	5,	'Dávid'	,'Barczi',	'1989.02.01'	,-1,	0,	200),
(33	,26	,11,	5,	'Sándor',	'Vajda'	,'1991.12.14',	-1,	-1,	200),
(34,	30,	7,	1,	'János'	,'Szabó',	'1989.07.11',	-1	,0,	350),
(35,	25,	12,	1,	'Krisztián',	'Tamás',	'1995.04.18',	-1	,0	,150),
(36,	6	,11	,11	,'Krisztián'	,'Póti',	'1988.05.28',	-1,	0,	100),
(37,	14	,8	,10,	'Lazar',	'Veselinovic'	,'1986.08.04',	0,	-1,	300),
(38,	9,	9,	10,	'Patrik',	'Bacsa',	'1992.06.03',	-1,	0,	150),
(39	,1	,11,	9	,'Gergő'	,'Szécsi',	'1989.02.07',	-1,	0,	75),
(40	,2,	5,	11,	'Dávid',	'Bobál',	'1995.08.31',	-1,	0,	450),
(41,	2,	8,	8,	'Dániel'	,'Farkas',	'1993.01.13',	-1,	-1,	225),
(42,	87,	9,	11,	'Róbert',	'Tucsa',	'1998.03.17',	-1	,0	,50),
(43,	29,	2,	10,	'Tamás',	'Priskin',	'1986.09.27'	,-1,	0,	500),
(44,	55,	11,	6,	'István',	'Bódis',	'1997.01.19',	-1,	0,	100),
(45,	97,	2,	7,	'Roland',	'Varga',	'1990.01.23',	-1,	0,	1000),
(46,	16,	5,	6,	'Zsolt',	'Pölöskei',	'1991.02.19'	,-1,	0,	250),
(47,	5	,12	,8	,'Attila',	'Fiola',	'1990.02.17'	,-1,	0	,700),
(48,	13,	6,	8,	'Kristóf',	'Polgár'	,'1996.11.28',	-1,	0,	200),
(49,	42	,4	,7	,'Norbert'	,'Könyves'	,'1989.06.10'	,-1,	-1,	250),
(50,	23,	1,	4,	'Máté',	'Vida'	,'1996.03.08',	-1	,0,	700);








