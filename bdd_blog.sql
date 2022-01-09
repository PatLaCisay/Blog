-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 05 Octobre 2021 à 19:05
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `bdd_blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `id_message` int(11) NOT NULL,
  `pseudo_comm` varchar(25) NOT NULL,
  `comm` text NOT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `id_message` (`id_message`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `id_message`, `pseudo_comm`, `comm`) VALUES
(1, 1, 'Dédé la déconne', 'Et bah ça en fait une belle pièce !!\r\nFicelle de caleçon ;D'),
(2, 4, 'Dédé la déconne', 'Les sandres ça adore la nuit, peut-être qu''ils sortent en boîte comme les sardines ! lol !'),
(3, 1, 'Lulu la Frite', 'Merci mon Dédé !'),
(8, 3, 'Dominique le boss', 'Bien vu'),
(9, 3, 'Arnaud', 'PAS maaaaaaaaaaaaaaaaL'),
(10, 1, 'Arthur', 'Bien joué !'),
(11, 6, 'Loulou', 'Bien vu chackal'),
(12, 6, 'Lucas', 'Très  belle prise '),
(17, 6, 'Lulu la Frite', 'Merci:)'),
(18, 6, 'Lucas', 'Yooooooo'),
(19, 6, 'Lucas', 'Entrez le ici'),
(20, 6, 'Lucas', 'Entrez le ici'),
(21, 6, 'Lucas', 'Entrez le ici'),
(22, 6, 'Lucas', 'Entrez le ici'),
(23, 6, 'Lucas', 'Entrez le ici'),
(24, 6, 'Lucas', 'Entrez le ici'),
(25, 6, 'Lucas', 'Entrez le ici'),
(26, 6, 'Lucas', 'Entrez le ici'),
(27, 6, 'Lucas', 'Entrez le ici'),
(28, 6, 'Lucas', 'Entrez le ici'),
(29, 6, 'Lucas', 'Entrez le ici'),
(30, 6, 'Lucas', 'Entrez le ici'),
(31, 6, 'Lucas', 'Entrez le ici'),
(32, 6, 'Lucas', 'Entrez le ici'),
(33, 6, 'Lucas', 'Entrez le ici'),
(34, 6, 'Lucas', 'Entrez le ici'),
(35, 4, 'Lucas Esperandieu', 'Pas mal, j''en ai prit un plus gros !');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(25) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id_message`, `pseudo`, `titre`, `contenu`) VALUES
(1, 'Lulu la Frite', 'Enorme brochet en bord de Seine', 'Alors que je pêchais tranquillement avec mon vieux frère, une décharge fulgurante vint m''arracher le bras !\r\n\r\nTout était calme et le soleil commençait à descendre, je pêchais au jerkbait en toute détente quand soudain, UN VERITABLE GOLGOTH VINT ME TABASSER MA LIGNE !!!\r\n\r\nMenant un combat sans merci, ce MONSTRE d''eau douce faillit plus d''une fois à rompre ma ligne !\r\n\r\nHeureusement, je parvins à contrer ses attaques et finis par le mettre au sec B-)\r\n\r\nCe prince des eaux douces est directement repartis à l''eau, n''oubliez pas LES PLUS GROS POISSONS SONT LES PLUS GROS GENITEURS, LES PRESERVER C''EST PRESERVER L''ESPECE !!'),
(3, 'Lulu la Frite', 'Très belle perche en surface', 'Regardez la taille de cette perche !\r\n\r\nNe lésinez pas sur les leurres de surface quand il s''agit de pêcher ce genre de Golgoth !\r\n\r\nElle faisait 50cm.									'),
(4, 'Lulu la Frite', 'Joli Sandre !!', 'Alors que la nuit tombait en même temps que les trombes d''eau, mon frère et moi restions stoïques. \r\n\r\nSoudain, plusieurs touches aussi brutales qu''inattendues survinrent !\r\n\r\nNous savions qu''il s''agissait de sandre et la persévérance permit à mon frère de sortir cette belle pièce.\r\n\r\nQu''est ce qu''on a rigolé !!		'),
(6, 'Lulu la Frite', 'Partie de pêche avec les copains !', 'J''ai amené les copains aux bords de l''eau pour leur faire découvrir ma passion !\r\n\r\nIls ont TOUS attrapé un brochet :O !!\r\n\r\nMerci à Côme et à son lac bourré de poissons !!'),
(7, 'SuperBass2000', 'Incroyable pêche avec Lulu', 'Salut les pechix !!\r\n\r\nAvec Lulu on est parti décaniller des Bass la semaine denière.\r\n\r\nOn s''est bien amusé !!');

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE IF NOT EXISTS `profil` (
  `pseudo` varchar(25) NOT NULL,
  `mdp` varchar(25) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `profil`
--

INSERT INTO `profil` (`pseudo`, `mdp`, `admin`) VALUES
('Arnaud', 'coucou', 0),
('Arthur', '1234', 0),
('Dédé la déconne', '12345', 0),
('Dominique le boss', 'azertyuiop', 0),
('Loulou', '12345', 0),
('Lucas Esperandieu', '45', 0),
('Lucas89', 'lulu2', 0),
('Lulu la Frite', 'toto123', 1),
('SuperBass2000', '0', 0),
('toto', 'rer', 0);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`id_message`) REFERENCES `message` (`id_message`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`pseudo`) REFERENCES `profil` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
