-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/11/2024 às 13:58
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto1`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `vaga_id` int(11) NOT NULL,
  `data_reserva` datetime DEFAULT current_timestamp(),
  `status` enum('reservado','cancelado','ocupado') DEFAULT 'reservado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('aluno','administrador') NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`, `data_cadastro`, `telefone`, `foto_perfil`) VALUES
(1, 'Carlos', 'carlos@gmail.com', '$2y$10$Rbrrdomp6l81EWsArq50IeD2M2SYdufMETNCgvqiorzpxNqF2Sqta', 'administrador', '2024-11-10 00:48:51', NULL, NULL),
(2, 'Vitor Machado', 'vitor@admin.com', '$2y$10$besWdmw8Mi.nycjsvEX4P.poTBz.E1wUc/ZBk3/hAJ6YQBqB1Xfs2', 'administrador', '2024-11-10 00:50:32', NULL, NULL),
(3, 'vitor', 'vitor@aluno.com', '$2y$10$oKHwczgCjoTlBxhi9jkuSenslsPtjWv9XUyTNXUbH1Czry05gTp56', 'aluno', '2024-11-10 01:12:14', NULL, NULL),
(4, 'leo', 'leo@aluno.com', '$2y$10$I7Oj4A24cUhhchLXhVMMaOVgcIqS95BUfDh3HodEy.twPG1IBVcDS', 'aluno', '2024-11-18 12:37:49', '345656', NULL),
(5, 'ble', 'ble@admin.com', '$2y$10$NV4wT6eLv9HEvYMfR/FKFOHxRqnuoteFXjH9g6WqhyD22ZIfUZFHG', 'administrador', '2024-11-18 13:03:02', NULL, NULL),
(6, 'vitor', 'v@admin.com', '$2y$10$szj.ehQUP4QaZjTdStMCxuzS3.4pjqlmYZ6UX9RZMmcTNhmm1FeS.', 'administrador', '2024-11-18 13:39:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vagas`
--

CREATE TABLE `vagas` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `status` enum('disponivel','ocupada') NOT NULL DEFAULT 'disponivel',
  `veiculo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vagas`
--

INSERT INTO `vagas` (`id`, `numero`, `status`, `veiculo_id`) VALUES
(2, 21, 'disponivel', NULL),
(9, 1, 'disponivel', NULL),
(10, 2, 'disponivel', NULL),
(11, 3, 'disponivel', NULL),
(12, 4, 'disponivel', NULL),
(13, 5, 'disponivel', NULL),
(14, 6, 'disponivel', NULL),
(15, 7, 'disponivel', NULL),
(16, 8, 'disponivel', NULL),
(17, 9, 'disponivel', NULL),
(18, 10, 'disponivel', NULL),
(19, 40, 'disponivel', NULL),
(20, 41, 'disponivel', NULL),
(21, 42, 'disponivel', NULL),
(22, 43, 'disponivel', NULL),
(23, 44, 'disponivel', NULL),
(24, 45, 'disponivel', NULL),
(25, 46, 'disponivel', NULL),
(26, 47, 'disponivel', NULL),
(27, 48, 'disponivel', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `veiculos`
--

CREATE TABLE `veiculos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `cor` varchar(30) NOT NULL,
  `tipo` enum('carro','moto') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `veiculos`
--

INSERT INTO `veiculos` (`id`, `usuario_id`, `placa`, `marca`, `cor`, `tipo`) VALUES
(1, 3, '123', '123', '123', 'carro'),
(2, 3, '123', '123', '123', 'carro'),
(3, 4, 'bla', 'bla', 'bla', 'carro');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `vaga_id` (`vaga_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vagas`
--
ALTER TABLE `vagas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `veiculo_id` (`veiculo_id`);

--
-- Índices de tabela `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `vagas`
--
ALTER TABLE `vagas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `veiculos`
--
ALTER TABLE `veiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`vaga_id`) REFERENCES `vagas` (`id`);

--
-- Restrições para tabelas `vagas`
--
ALTER TABLE `vagas`
  ADD CONSTRAINT `vagas_ibfk_1` FOREIGN KEY (`veiculo_id`) REFERENCES `veiculos` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `veiculos`
--
ALTER TABLE `veiculos`
  ADD CONSTRAINT `veiculos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
