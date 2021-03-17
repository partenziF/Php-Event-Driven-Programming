# HeidiSQL Dump 
#
# --------------------------------------------------------
# Host:                 localhost
# Database:             test
# Server version:       5.0.51a-community-nt
# Server OS:            Win32
# Target-Compatibility: MySQL 5.0
# Extended INSERTs:     Y
# max_allowed_packet:   1048576
# HeidiSQL version:     3.0 Revision: 572
# --------------------------------------------------------

/*!40100 SET CHARACTER SET latin1*/;


#
# Database structure for database 'test'
#

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `test` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `test`;


#
# Table structure for table 'utenti'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `utenti` (
  `P_Utente` int(11) unsigned NOT NULL auto_increment,
  `Nome` varchar(250) default NULL,
  `Cognome` varchar(250) default NULL,
  `Valore` int(11) unsigned default NULL,
  `Cancellato` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`P_Utente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;



#
# Dumping data for table 'utenti'
#

/*!40000 ALTER TABLE `utenti` DISABLE KEYS*/;
LOCK TABLES `utenti` WRITE;
INSERT IGNORE INTO `utenti` (`P_Utente`, `Nome`, `Cognome`, `Valore`, `Cancellato`) VALUES ('1','Mario','Rossi','10',0),
	('2','Giuseppe','Bianchi','20',0),
	('3','Luigi','Verdi','30',0),
	('4','Antonio','Russo','25',0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `utenti` ENABLE KEYS*/;
