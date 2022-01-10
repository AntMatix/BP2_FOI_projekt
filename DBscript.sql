-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.6.4-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for carshop
CREATE DATABASE IF NOT EXISTS `carshop` /*!40100 DEFAULT CHARACTER SET utf8mb3 */;
USE `carshop`;

-- Dumping structure for table carshop.klijenti
CREATE TABLE IF NOT EXISTS `klijenti` (
  `id_klijenta` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(30) NOT NULL,
  `prezime` varchar(30) NOT NULL,
  `broj_mobitela` varchar(20) NOT NULL,
  `mail` varchar(30) NOT NULL,
  `napomene` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_klijenta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.klijenti: ~2 rows (approximately)
/*!40000 ALTER TABLE `klijenti` DISABLE KEYS */;
INSERT INTO `klijenti` (`id_klijenta`, `ime`, `prezime`, `broj_mobitela`, `mail`, `napomene`) VALUES
	(1, 'Marko', 'Markovic', '+385990292394', 'markomarkovic@mymail.com', 'Nema napomena'),
	(2, 'Ana', 'Anic', '+385983929903', 'aanic@mymail.com', 'Nema napomena');
/*!40000 ALTER TABLE `klijenti` ENABLE KEYS */;

-- Dumping structure for table carshop.moguca_oprema
CREATE TABLE IF NOT EXISTS `moguca_oprema` (
  `id_oprema` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(30) NOT NULL,
  PRIMARY KEY (`id_oprema`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.moguca_oprema: ~6 rows (approximately)
/*!40000 ALTER TABLE `moguca_oprema` DISABLE KEYS */;
INSERT INTO `moguca_oprema` (`id_oprema`, `naziv`) VALUES
	(1, 'ABS'),
	(2, 'ESP'),
	(3, 'klima'),
	(4, 'dvozonska klima'),
	(5, 'elektricni podizaci stakala'),
	(6, 'Matrix farovi');
/*!40000 ALTER TABLE `moguca_oprema` ENABLE KEYS */;

-- Dumping structure for table carshop.oprema_vozila
CREATE TABLE IF NOT EXISTS `oprema_vozila` (
  `id_vozila` int(11) NOT NULL,
  `id_oprema` int(11) NOT NULL,
  PRIMARY KEY (`id_vozila`,`id_oprema`),
  KEY `oprema_vozila_moguca_oprema_id_oprema__fk` (`id_oprema`),
  CONSTRAINT `oprema_vozila_moguca_oprema_id_oprema__fk` FOREIGN KEY (`id_oprema`) REFERENCES `moguca_oprema` (`id_oprema`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `oprema_vozila_vozila_id_vozila__fk` FOREIGN KEY (`id_vozila`) REFERENCES `vozila` (`id_vozila`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.oprema_vozila: ~9 rows (approximately)
/*!40000 ALTER TABLE `oprema_vozila` DISABLE KEYS */;
INSERT INTO `oprema_vozila` (`id_vozila`, `id_oprema`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(3, 5),
	(3, 6),
	(4, 1),
	(4, 2),
	(4, 3),
	(4, 5);
/*!40000 ALTER TABLE `oprema_vozila` ENABLE KEYS */;

-- Dumping structure for table carshop.pozicije
CREATE TABLE IF NOT EXISTS `pozicije` (
  `id_pozicija` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(30) NOT NULL,
  PRIMARY KEY (`id_pozicija`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.pozicije: ~2 rows (approximately)
/*!40000 ALTER TABLE `pozicije` DISABLE KEYS */;
INSERT INTO `pozicije` (`id_pozicija`, `naziv`) VALUES
	(1, 'Referent za prodaju'),
	(2, 'Prodavac'),
	(3, 'Voditelj odjela za prodaju');
/*!40000 ALTER TABLE `pozicije` ENABLE KEYS */;

-- Dumping structure for table carshop.proizvodaci
CREATE TABLE IF NOT EXISTS `proizvodaci` (
  `id_proizvodaci` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(30) NOT NULL,
  PRIMARY KEY (`id_proizvodaci`),
  UNIQUE KEY `proizvodaci_naziv_uindex` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.proizvodaci: ~5 rows (approximately)
/*!40000 ALTER TABLE `proizvodaci` DISABLE KEYS */;
INSERT INTO `proizvodaci` (`id_proizvodaci`, `naziv`) VALUES
	(3, 'Audi'),
	(1, 'BMW'),
	(2, 'Mercedes'),
	(5, 'Peugeot'),
	(4, 'Porsche');
/*!40000 ALTER TABLE `proizvodaci` ENABLE KEYS */;

-- Dumping structure for table carshop.rezervacije
CREATE TABLE IF NOT EXISTS `rezervacije` (
  `id_rezervacije` int(11) NOT NULL AUTO_INCREMENT,
  `rezervirao` int(11) NOT NULL,
  `id_vozila` int(11) NOT NULL,
  `odobrio` int(11) NOT NULL,
  PRIMARY KEY (`rezervirao`,`id_vozila`,`odobrio`),
  UNIQUE KEY `rezervacije_pk` (`id_rezervacije`),
  KEY `rezervacije_vozila_id_vozila__fk` (`id_vozila`),
  KEY `rezervacije_zaposlenici_id_zaposlenika_fk` (`odobrio`),
  CONSTRAINT `rezervacije_klijenti_id_klijenta__fk` FOREIGN KEY (`rezervirao`) REFERENCES `klijenti` (`id_klijenta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rezervacije_vozila_id_vozila__fk` FOREIGN KEY (`id_vozila`) REFERENCES `vozila` (`id_vozila`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rezervacije_zaposlenici_id_zaposlenika_fk` FOREIGN KEY (`odobrio`) REFERENCES `zaposlenici` (`id_zaposlenika`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.rezervacije: ~4 rows (approximately)
/*!40000 ALTER TABLE `rezervacije` DISABLE KEYS */;
INSERT INTO `rezervacije` (`id_rezervacije`, `rezervirao`, `id_vozila`, `odobrio`) VALUES
	(7, 2, 3, 3),
	(8, 2, 1, 3),
	(10, 2, 2, 1);
/*!40000 ALTER TABLE `rezervacije` ENABLE KEYS */;

-- Dumping structure for table carshop.tip_transmisije
CREATE TABLE IF NOT EXISTS `tip_transmisije` (
  `id_tip_transmisije` int(11) NOT NULL AUTO_INCREMENT,
  `tip` varchar(15) NOT NULL,
  PRIMARY KEY (`id_tip_transmisije`),
  UNIQUE KEY `tip_transmisije_tip_uindex` (`tip`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.tip_transmisije: ~2 rows (approximately)
/*!40000 ALTER TABLE `tip_transmisije` DISABLE KEYS */;
INSERT INTO `tip_transmisije` (`id_tip_transmisije`, `tip`) VALUES
	(1, 'automatski'),
	(3, 'rucni'),
	(2, 'sekvencijalni');
/*!40000 ALTER TABLE `tip_transmisije` ENABLE KEYS */;

-- Dumping structure for table carshop.tip_vozila
CREATE TABLE IF NOT EXISTS `tip_vozila` (
  `id_tip_vozila` int(11) NOT NULL AUTO_INCREMENT,
  `tip` varchar(15) NOT NULL,
  PRIMARY KEY (`id_tip_vozila`),
  UNIQUE KEY `tip_vozila_tip_uindex` (`tip`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.tip_vozila: ~4 rows (approximately)
/*!40000 ALTER TABLE `tip_vozila` DISABLE KEYS */;
INSERT INTO `tip_vozila` (`id_tip_vozila`, `tip`) VALUES
	(1, 'coupe'),
	(3, 'hatchback'),
	(4, 'kabriolet'),
	(2, 'limuzina');
/*!40000 ALTER TABLE `tip_vozila` ENABLE KEYS */;

-- Dumping structure for view carshop.uredena_vozila
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `uredena_vozila` (
	`id_vozila` INT(11) NOT NULL,
	`godiste` VARCHAR(5) NOT NULL COLLATE 'utf8mb3_general_ci',
	`proizvodac` VARCHAR(30) NOT NULL COLLATE 'utf8mb3_general_ci',
	`model` VARCHAR(30) NOT NULL COLLATE 'utf8mb3_general_ci',
	`polovan` VARCHAR(2) NOT NULL COLLATE 'utf8mb4_general_ci',
	`kilometraza` VARCHAR(10) NOT NULL COLLATE 'utf8mb3_general_ci',
	`gorivo` VARCHAR(15) NULL COLLATE 'utf8mb3_general_ci',
	`br_vrata` INT(11) NOT NULL,
	`karoserija` VARCHAR(15) NOT NULL COLLATE 'utf8mb3_general_ci',
	`zapremina_motora` VARCHAR(20) NOT NULL COLLATE 'utf8mb3_general_ci',
	`snaga` VARCHAR(15) NOT NULL COLLATE 'utf8mb3_general_ci',
	`mjenjac` VARCHAR(15) NOT NULL COLLATE 'utf8mb3_general_ci',
	`pogon` VARCHAR(15) NOT NULL COLLATE 'utf8mb3_general_ci',
	`boja` VARCHAR(20) NOT NULL COLLATE 'utf8mb3_general_ci',
	`opis` VARCHAR(200) NOT NULL COLLATE 'utf8mb3_general_ci',
	`rezerviran` VARCHAR(2) NOT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view carshop.uredene_rezervacije
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `uredene_rezervacije` (
	`broj` INT(11) NOT NULL,
	`ime` VARCHAR(30) NOT NULL COLLATE 'utf8mb3_general_ci',
	`prezime` VARCHAR(30) NOT NULL COLLATE 'utf8mb3_general_ci',
	`id_vozila` INT(11) NOT NULL,
	`auto` VARCHAR(61) NOT NULL COLLATE 'utf8mb3_general_ci',
	`odobrio` VARCHAR(61) NOT NULL COLLATE 'utf8mb3_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for table carshop.vozila
CREATE TABLE IF NOT EXISTS `vozila` (
  `id_vozila` int(11) NOT NULL AUTO_INCREMENT,
  `godiste` varchar(5) NOT NULL,
  `proizvodac` int(11) NOT NULL,
  `model` varchar(30) NOT NULL,
  `polovan` tinyint(1) NOT NULL,
  `kilometraza` varchar(10) NOT NULL,
  `gorivo` int(11) NOT NULL,
  `br_vrata` int(11) NOT NULL,
  `tip_vozila` int(11) NOT NULL,
  `zapremina_motora` varchar(20) NOT NULL,
  `snaga` varchar(15) NOT NULL,
  `transmisija` int(11) NOT NULL,
  `pogon` int(11) NOT NULL,
  `boja` varchar(20) NOT NULL,
  `opis` varchar(200) NOT NULL,
  `rezerviran` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_vozila`),
  KEY `vozila_proizvodaci_id_proizvodaci__fk` (`proizvodac`),
  KEY `vozila_tip_transmisije_id_tip_transmisije__fk` (`transmisija`),
  KEY `vozila_tip_vozila_id_tip_vozila__fk` (`tip_vozila`),
  KEY `vozila_vrste_goriva_id_vrste_goriva_fk` (`gorivo`),
  KEY `vozila_vrste_pogona_id_vrste_pogona__fk` (`pogon`),
  CONSTRAINT `vozila_proizvodaci_id_proizvodaci__fk` FOREIGN KEY (`proizvodac`) REFERENCES `proizvodaci` (`id_proizvodaci`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vozila_tip_transmisije_id_tip_transmisije__fk` FOREIGN KEY (`transmisija`) REFERENCES `tip_transmisije` (`id_tip_transmisije`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vozila_tip_vozila_id_tip_vozila__fk` FOREIGN KEY (`tip_vozila`) REFERENCES `tip_vozila` (`id_tip_vozila`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vozila_vrste_goriva_id_vrste_goriva_fk` FOREIGN KEY (`gorivo`) REFERENCES `vrste_goriva` (`id_vrste_goriva`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vozila_vrste_pogona_id_vrste_pogona__fk` FOREIGN KEY (`pogon`) REFERENCES `vrste_pogona` (`id_vrste_pogona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.vozila: ~5 rows (approximately)
/*!40000 ALTER TABLE `vozila` DISABLE KEYS */;
INSERT INTO `vozila` (`id_vozila`, `godiste`, `proizvodac`, `model`, `polovan`, `kilometraza`, `gorivo`, `br_vrata`, `tip_vozila`, `zapremina_motora`, `snaga`, `transmisija`, `pogon`, `boja`, `opis`, `rezerviran`) VALUES
	(1, '2014', 1, 'F30 320i', 1, '269000', 1, 4, 2, '1997 cc', '184 ks', 1, 2, 'crna', 'Za detaljan opis nazvati', 1),
	(2, '2009', 3, 'A3', 0, '170000', 2, 4, 3, '1390 cc', '125 ks', 3, 1, 'bijela', 'Za detaljan opis nazvati', 1),
	(3, '2018', 4, '911 (992)', 0, '0', 1, 2, 1, '3745 cc', '650 ks', 2, 2, 'siva', 'Za sva pitanja, kontaktirati nas putem nase web stranice.', 1),
	(4, '2003', 5, '307', 1, '259304', 3, 4, 3, '1889 cc', '110 ks', 3, 1, 'crna', 'Nije naveden opis.', 0);
/*!40000 ALTER TABLE `vozila` ENABLE KEYS */;

-- Dumping structure for table carshop.vrste_goriva
CREATE TABLE IF NOT EXISTS `vrste_goriva` (
  `id_vrste_goriva` int(11) NOT NULL AUTO_INCREMENT,
  `gorivo` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_vrste_goriva`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.vrste_goriva: ~4 rows (approximately)
/*!40000 ALTER TABLE `vrste_goriva` DISABLE KEYS */;
INSERT INTO `vrste_goriva` (`id_vrste_goriva`, `gorivo`) VALUES
	(1, 'benzin'),
	(2, 'LPG (plin)'),
	(3, 'dizel'),
	(4, 'struja');
/*!40000 ALTER TABLE `vrste_goriva` ENABLE KEYS */;

-- Dumping structure for table carshop.vrste_pogona
CREATE TABLE IF NOT EXISTS `vrste_pogona` (
  `id_vrste_pogona` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(15) NOT NULL,
  PRIMARY KEY (`id_vrste_pogona`),
  UNIQUE KEY `vrste_pogona_naziv_uindex` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.vrste_pogona: ~2 rows (approximately)
/*!40000 ALTER TABLE `vrste_pogona` DISABLE KEYS */;
INSERT INTO `vrste_pogona` (`id_vrste_pogona`, `naziv`) VALUES
	(3, '4x4'),
	(1, 'prednji'),
	(2, 'zadnji');
/*!40000 ALTER TABLE `vrste_pogona` ENABLE KEYS */;

-- Dumping structure for table carshop.zaposlenici
CREATE TABLE IF NOT EXISTS `zaposlenici` (
  `id_zaposlenika` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(30) NOT NULL,
  `prezime` varchar(30) NOT NULL,
  `broj_mobitela` varchar(20) NOT NULL,
  `mail` varchar(30) NOT NULL,
  `pozicija` int(11) NOT NULL,
  `nadreden` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_zaposlenika`),
  KEY `zaposlenici_zaposlenik_id_zaposlenika_fk` (`nadreden`),
  KEY `zaposlenici_pozicije_id_pozicija_fk` (`pozicija`),
  CONSTRAINT `zaposlenici_pozicije_id_pozicija_fk` FOREIGN KEY (`pozicija`) REFERENCES `pozicije` (`id_pozicija`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `zaposlenici_zaposlenik_id_zaposlenika_fk` FOREIGN KEY (`nadreden`) REFERENCES `zaposlenici` (`id_zaposlenika`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table carshop.zaposlenici: ~6 rows (approximately)
/*!40000 ALTER TABLE `zaposlenici` DISABLE KEYS */;
INSERT INTO `zaposlenici` (`id_zaposlenika`, `ime`, `prezime`, `broj_mobitela`, `mail`, `pozicija`, `nadreden`) VALUES
	(1, 'Antonio', 'Matic', '+38599215613', 'ant_matic@gmail.com', 1, NULL),
	(2, 'Jelica', 'Jelavic', '+38599299031', 'j_jelavic@gmail.com', 2, 1),
	(3, 'Marko', 'Markovic', '+38599752338', 'm_markovic@gmail.com', 2, 1),
	(4, 'Goran', 'Petrovic', '+3859833661948', 'gpetrovi@car.com', 3, NULL),
	(5, 'Antonio', 'Antic', '+385996352901', 'aanti@car.com', 1, 3),
	(6, 'Ivan', 'Pilic', '+385983990482', 'ipili@car.com', 2, 1);
/*!40000 ALTER TABLE `zaposlenici` ENABLE KEYS */;

-- Dumping structure for trigger carshop.provjera_br_vrata
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE trigger provjera_br_vrata
    before insert
    on vozila
    for each row
begin
    IF NEW.br_vrata != 2 AND NEW.br_vrata != 4 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Broj vrata netocno unesen. Treba biti 2 ili 4.';
    end if;
end//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger carshop.provjera_br_vrata_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE trigger provjera_br_vrata_update
    before update
    on vozila
    for each row
begin
    IF NEW.br_vrata != 2 AND NEW.br_vrata != 4 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Broj vrata netocno unesen. Treba biti 2 ili 4.';
    end if;
end//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger carshop.provjera_mail
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE trigger provjera_mail
    before insert
    on klijenti
    for each row
begin
    IF NEW.mail NOT LIKE '%@%.%' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nepravilan format e-mail adrese. Treba biti npr. : iivi@mymail.com';
    end if;
end//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger carshop.provjera_rezervacija
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE trigger provjera_rezervacija
    before insert
    on rezervacije
    for each row
begin
    IF NEW.odobrio != 3 AND NEW.odobrio != 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nemate ovlasti odobriti rezervaciju.';
    end if;
    IF (SELECT rezerviran from vozila where id_vozila = NEW.id_vozila) = 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Navedeno je vozilo vec rezervirano.';
    end if;
    IF (SELECT rezerviran from vozila where id_vozila = NEW.id_vozila) = 0 THEN
    UPDATE vozila SET rezerviran = 1 WHERE id_vozila = NEW.id_vozila;
    end if;
end//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger carshop.provjera_rezervacija_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE trigger provjera_rezervacija_update
    before update
    on rezervacije
    for each row
begin
    IF NEW.odobrio != 3 AND NEW.odobrio != 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nemate ovlasti odobriti rezervaciju.';
    end if;
end//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger carshop.provjera_zapremina_snaga
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE trigger provjera_zapremina_snaga
    before insert
    on vozila
    for each row
begin
    IF NEW.zapremina_motora NOT LIKE '% cc' OR NEW.snaga NOT LIKE '% ks' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Zapremina motora mora biti unesena kao npr. 1983 cc te snaga motora kao npr. 110 ks';
    end if;
end//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger carshop.provjera_zapremina_snaga_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE trigger provjera_zapremina_snaga_update
    before update
    on vozila
    for each row
begin
    IF NEW.zapremina_motora NOT LIKE '% cc' OR NEW.snaga NOT LIKE '% ks' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Zapremina motora mora biti unesena kao npr. 1983 cc te snaga motora kao npr. 110 ks';
    end if;
end//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger carshop.ukloni_rezervaciju
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE trigger ukloni_rezervaciju
    after delete
    on rezervacije
    for each row
begin
    UPDATE vozila SET rezerviran = 0 WHERE ID_VOZILA = OLD.ID_VOZILA;
end//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for view carshop.uredena_vozila
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `uredena_vozila`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `uredena_vozila` AS select v.id_vozila, v.godiste, p.naziv as proizvodac, v.model, case when v.polovan = 1 then 'Da' else 'Ne' end as polovan, v.kilometraza, vg.gorivo, v.br_vrata,
       tv.tip as karoserija, v.zapremina_motora, v.snaga, tt.tip as mjenjac, vp.naziv pogon, v.boja, v.opis, case when v.rezerviran = 1 then 'Da' else 'Ne' end as rezerviran
from vozila v, proizvodaci p, vrste_goriva vg, tip_vozila tv, tip_transmisije tt, vrste_pogona vp
where v.proizvodac = p.id_proizvodaci
AND v.gorivo = vg.id_vrste_goriva
AND v.tip_vozila = tv.id_tip_vozila
AND v.transmisija = tt.id_tip_transmisije
AND v.pogon = vp.id_vrste_pogona ;

-- Dumping structure for view carshop.uredene_rezervacije
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `uredene_rezervacije`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `uredene_rezervacije` AS select r.id_rezervacije as broj, k.ime as ime, k.prezime as prezime, v.id_vozila as id_vozila, CONCAT(uv.proizvodac, ' ', uv.model) as auto, CONCAT(z.ime, ' ', z.prezime) as odobrio
from rezervacije r join klijenti k on r.rezervirao = k.id_klijenta join zaposlenici z on z.id_zaposlenika = r.odobrio
   join uredena_vozila v on r.id_vozila = v.id_vozila, uredena_vozila uv WHERE v.id_vozila = uv.id_vozila ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
