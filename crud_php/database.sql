CREATE DATABASE IF NOT EXISTS `gamesellingplat_db`;

USE `gamesellingplat_db`;

CREATE TABLE IF NOT EXISTS `categorias` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `jogos` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    `descricao` TEXT,
    `preco` DECIMAL(10, 2) NOT NULL,
    `categoria_id` INT(11) NOT NULL, 
    `imagem` VARCHAR(255),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`categoria_id`) REFERENCES `categorias`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserir dados de exemplo na tabela categorias
INSERT INTO categorias (`nome`) VALUES
('Aventura'),
('Sobrevivencia'),
('Mundo Aberto'),
('Multi-Jogador'),
('Terror'),
('Misterio e Investigação'),
('Dinossauros');

INSERT INTO jogos (nome, descricao, preco, categoria_id) VALUES
('The Isle', 'Cresça, se aventure, domine e se divirta', 59.90, 7),
('Sea of Thieves', 'Piratas traiçoeiros em um mar aberto, quem vai conquistar o grande tesouro dos mares, você?', 120.90, 3);

