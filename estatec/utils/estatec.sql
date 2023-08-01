-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/06/2023 às 19:29
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estatec`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `estagios`
--

CREATE TABLE `estagios` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `categoria` text NOT NULL,
  `assunto` text NOT NULL,
  `requisitos` text NOT NULL,
  `carga_horaria` text NOT NULL,
  `atividades` text NOT NULL,
  `salario` text NOT NULL,
  `data_validade` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `estagios`
--

INSERT INTO `estagios` (`id`, `nome`, `categoria`, `assunto`, `requisitos`, `carga_horaria`, `atividades`, `salario`, `data_validade`) VALUES
(1, 'Consultório Odontológico', 'Informática', 'ESTÁGIO', 'Estudar na ETEC, noções básicas de informática, competências socioemocionais', 'segunda a sexta, das 14:00 às 18:00', 'atividades administrativas, gerenciamento de redes sociais', 'auxílio de transporte + 700 reais', '2023-11-23'),
(4, 'Atendimento e Recepção em empresa de Ar', 'Informática', 'TRABALHO', 'Ser Formado ou estar cursando pela Etec; Ser Organizado (a), Proativo (a) e Responsável; Ensino Médio Completo; Facilidade com Informática.', 'Ter disponibilidade de trabalhar de segunda a sexta-feira das 7h30min às 18h00 e aos sábados das 8h00 às 12h00 ', 'Principais atividades: Fazer orçamento no WORD / Vendas / Atendimento ao cliente / Atendimento ao cliente por Whatzapp /  Fazer ordem de serviço no Sistema da empresa.', 'Salário inicial de R$ 1658,26 ', '2023-06-05'),
(5, 'Administrativo/Tecnologia de Madeireira', 'Logística', 'TRABALHO', 'Ser Formado ou estar cursando na Etec;  - Ensino Médio Completo;Ser Organizado (a), Proativo (a) e Responsável; Ensino Médio Completo; Facilidade com Informática – Redes Sociais e Whatsapp da empresa;Ser criativo, proativo, trabalhar em grupo e muita vontade de aprender e crescer profissionalmente na empresa.', 'Ter disponibilidade de trabalhar de segunda a sexta-feira das 7h00 às 17h00; ', 'Redes Sociais e Whatsapp da empresa.', 'Remuneração – Piso salarial da categoria', '2023-06-05'),
(6, 'Empresa de serviços financeiros e plano de saúde', 'Logística', 'ESTÁGIO', 'Estudar na Etec; \r\nNoções de informática - excel, word, boa escrita e boa comunicação;\r\nVontade de aprender; ', 'Ter disponibilidade de estagiar de segunda a sexta-feira das 13h00 às 18h00', 'Principais atividades: Suporte para equipe comercial, realizando consulta a clientes nos sistemas de pesquisa e atendimento ao cliente por WhatsApp.', 'Bolsa auxílio e auxílio transporte de R$ 600,00 + Seguro de vida ', '2023-06-02'),
(7, 'Teste', 'Logística/Informática', 'teste', 'teste', 'teste', 'teste', 'teste', '2023-12-10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rm` varchar(10) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `email`, `rm`, `senha`, `created_at`) VALUES
(3, 'Lis', 'Meneses', 'elisa@hotmial.com', '01234', '$2y$10$dplAd3cXz.71sVUOzlLU4ejXSSTAQ4VxuAR.9i.hjJ61BTM1uildS', '2023-06-24 04:52:41'),
(4, 'Ariel', 'Aio', 'arielaio@hotmail.com', '08670', '$2y$10$3VdrxfufvfGkrHTNFqq/5OIK3VfiIFLiWFLexpXbBjoegNga8J/nm', '2023-06-24 15:53:47'),
(6, 'Arthur', 'Risso', 'arthur@gmail.com', '04321', '$2y$10$4P97md8.5xgyeXDWmIkfKus34eAEXhT/UqqwlTlgmDfck26dbSmN6', '2023-06-26 09:18:57');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `estagios`
--
ALTER TABLE `estagios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `estagios`
--
ALTER TABLE `estagios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
