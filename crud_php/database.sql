CREATE DATABASE IF NOT EXISTS `gameSellingPlat_db`;

USE `gameSellingPlat`;

CREATE TABLE IF NOT EXISTS `categorias` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `produtos` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    `descricao` TEXT,
    `preco` DECIMAL(10, 2) NOT NULL,
    `categoria_id` INT(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`categoria_id`) REFERENCES `categorias`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserir dados de exemplo na tabela categorias
INSERT INTO `categorias` (`nome`) VALUES
('Eletrônicos'),
('Livros'),
('Vestuário');

-- Inserir dados de exemplo na tabela produtos
INSERT INTO `produtos` (`nome`, `descricao`, `preco`, `categoria_id`) VALUES
('Smartphone X', 'Um smartphone de última geração com câmera de alta resolução.', 1200.00, 1),
('O Senhor dos Anéis', 'Trilogia épica de fantasia de J.R.R. Tolkien.', 85.50, 2),
('Camiseta Básica', 'Camiseta de algodão 100% na cor preta.', 35.90, 3),
('Notebook Gamer', 'Notebook potente para jogos e tarefas exigentes.', 4500.00, 1),
('A Revolução dos Bichos', 'Uma fábula satírica de George Orwell.', 29.99, 2);
