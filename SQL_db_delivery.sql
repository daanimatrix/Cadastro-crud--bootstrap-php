--
-- Base de Dados: `db_delivery`
--
CREATE DATABASE IF NOT EXISTS `db_delivery` 
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

USE `db_delivery`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produtos`
--

CREATE TABLE IF NOT EXISTS `tb_produtos` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(40) NOT NULL,
  `TIPO` varchar(30) NOT NULL,
  `FOTO` varchar(50) NOT NULL,
  `VALOR` float NOT NULL,
  PRIMARY KEY (`ID`)
) DEFAULT CHARSET=utf8;


-- ------------------------

--
-- Usuário BD
-- 

CREATE USER IF NOT EXISTS 'aluno'@'localhost' IDENTIFIED BY 'aluno';

GRANT ALL PRIVILEGES ON `db_delivery` . * TO 'aluno'@'localhost';