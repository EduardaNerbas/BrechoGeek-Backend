-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 179.188.16.162
-- Generation Time: 19-Jun-2026 às 21:18
-- Versão do servidor: 5.7.32-35-log
-- PHP Version: 5.6.40-0+deb8u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brecho`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id_carrinho` int(11) NOT NULL,
  `fk_id_usuario` int(11) NOT NULL,
  `fk_id_produto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `carrinho`
--

INSERT INTO `carrinho` (`id_carrinho`, `fk_id_usuario`, `fk_id_produto`) VALUES
(5, 20, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nome_categoria`) VALUES
(1, 'Roupas e Camisetas'),
(2, 'Action Figures e Colecionáveis'),
(3, 'Jogos e Consoles'),
(4, 'Quadrinhos e Mangás'),
(5, 'Livros e RPG'),
(6, 'Acessórios e Decoração'),
(7, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `nome_produto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `descricao` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagem_produto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'padrao.png',
  `fk_id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `nome_produto`, `preco`, `descricao`, `imagem_produto`, `fk_id_usuario`) VALUES
(4, 'Bolsa de Controle Remoto', 40.00, 'Uma bolsa em formato de controle remoto', 'prod_6a30ac33e0f42.jpg', 17),
(5, 'Ursinho da Sonserina', 150.00, 'Um adorável ursinho de pelúcia com a roupa da sonserina', 'prod_6a35a7c1186db.jpg', 18),
(6, 'Garrafa do mapa do maroto', 79.00, '', 'prod_6a35cceba3d56.jpg', 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_categorias`
--

CREATE TABLE `produto_categorias` (
  `fk_id_produto` int(11) NOT NULL,
  `fk_id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `produto_categorias`
--

INSERT INTO `produto_categorias` (`fk_id_produto`, `fk_id_categoria`) VALUES
(4, 1),
(5, 2),
(5, 6),
(6, 6),
(4, 7),
(6, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(257) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(257) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `email`, `senha`) VALUES
(2, 'teste4', 'teste@xampp.com', '$2y$10$X.PEm0.Q90qoB1jPX4gpeuSxClXXAXRXKBKy2rGlPtd4Go41hpYbS'),
(4, 'Eduarda', 'eduarda@gmail.com', '$2y$10$fAphy03Z8/Na73Tks3bBlOd7RcgoUo5VVfZvkXQXTf6uuBGSE/wSG'),
(6, '1', '1@gmail.com', '$2y$10$2SzNDSyYqtzOAij0HFcUjuCI8XwKa7iVTAbneMt3gvPBASYJM9qQG'),
(8, '1', '1@hotmail.com', '$2y$10$sopL4ZlzxyIzsNCsiTk/Tu5cIbF9TxDu0MzhbNfOHc7QLp77ZU7t6'),
(11, 'a', 'a@gmail.com', '$2y$10$5DB4jOFLZGalxxa7SwDx8Ogd6HBGNK.dAsqoEE87SuaLHDipkclcG'),
(13, 'a', 'b@gmail.com', '$2y$10$ZlE1w9BIRu1bc1/H1mzW0u1j/0qwNLXRKmx0o5bFLm8N3NFhuW1TS'),
(14, 'aa', 'aa@gmail.com', '$2y$10$5IYGM8AG3VCknS4tVbBuk.BLCYL310ecbYdWCe/HjwX3o3DxYmTXC'),
(17, '2', '2@gmail.com', '$2y$10$t4D4VvSPPLzUXktgS3/kje/IQoaRzIz69WKd1GcaG3bCF7xf6ipQW'),
(18, 'Daca', 'daca@gmail.com', '$2y$12$zAZWUxyd1WYazWFuidXFhO0kibpXpOm8lpgppdNo/LmIMJkwzTYjy'),
(19, 'daca', 'daca2@gmail.com', '$2y$12$Ysf9Si5bM/5iyjtDfGtsUej7yB/WKUX0eOcLnPHg9IwaUErMVmYZO'),
(20, 'Julia', 'arya@gmail.com', '$2y$12$ss1HUkeWkE1Yq7oKoLZuseCafg5QInE6HVAPcNRZz8s9XKjVRYMYm'),
(21, 'joao', 'joao@gmail.com', '$2y$12$iljMKH10qlkg6RpnHs9cAeVPgnUOtrokRebEuTXDPkSKh/hg7p0Pm'),
(22, 'fulana', 'vercel@gmail.com', '$2y$12$ckw4e7xErKRmkdyalJdaOODa/9cwvunnmRZuZHOCYLC/EKj9KyP6O');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id_carrinho`),
  ADD UNIQUE KEY `uq_usuario_produto` (`fk_id_usuario`,`fk_id_produto`),
  ADD KEY `fk_produto_carrinho` (`fk_id_produto`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `fk_id_usuario_produto` (`fk_id_usuario`);

--
-- Indexes for table `produto_categorias`
--
ALTER TABLE `produto_categorias`
  ADD PRIMARY KEY (`fk_id_produto`,`fk_id_categoria`),
  ADD KEY `fk_categoria_produto` (`fk_id_categoria`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id_carrinho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `fk_produto_carrinho` FOREIGN KEY (`fk_id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_carrinho` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `fk_id_usuario_produto` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `produto_categorias`
--
ALTER TABLE `produto_categorias`
  ADD CONSTRAINT `fk_categoria_produto` FOREIGN KEY (`fk_id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_produto_categoria` FOREIGN KEY (`fk_id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
