-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Out-2020 às 04:21
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL COMMENT 'Código\r\n',
  `nome` varchar(100) NOT NULL COMMENT 'Nome',
  `cpf` varchar(45) NOT NULL COMMENT 'Cpf',
  `email` varchar(45) NOT NULL COMMENT 'Email',
  `login` varchar(45) NOT NULL COMMENT 'Login',
  `senha` varchar(45) NOT NULL COMMENT 'Senha',
  `status` int(11) DEFAULT NULL COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `cpf`, `email`, `login`, `senha`, `status`) VALUES
(1, 'Julio Duarte', '050.192.479-52', 'kurorollers@gmail.com', 'kurorollers@gmail.com', '123', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_endereco`
--

CREATE TABLE `cliente_endereco` (
  `id` int(11) NOT NULL COMMENT 'Código',
  `tipo_endereco_id` int(11) NOT NULL COMMENT 'Tipo do endereço',
  `cep` varchar(45) NOT NULL COMMENT 'Cep',
  `endereco` varchar(45) NOT NULL COMMENT 'Endereço',
  `numero` int(11) DEFAULT NULL COMMENT 'Número',
  `bairro` varchar(45) NOT NULL COMMENT 'Bairro',
  `cidade` varchar(45) NOT NULL COMMENT 'Cidade',
  `estado` varchar(45) NOT NULL COMMENT 'Estado',
  `cliente_id` int(11) NOT NULL COMMENT 'Cliente',
  `status` int(11) NOT NULL COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL COMMENT 'Código',
  `data_pedido` datetime NOT NULL COMMENT 'Data Pedido',
  `cliente_id` int(11) NOT NULL,
  `valor_total` varchar(45) NOT NULL COMMENT 'Total do Pedido',
  `data_retirada` datetime DEFAULT NULL COMMENT 'Data Retirada',
  `status` int(11) DEFAULT NULL COMMENT 'Status',
  `supermercado_id` int(11) NOT NULL COMMENT 'Loja',
  `cliente_endereco_id` int(11) DEFAULT NULL COMMENT 'Endereço do pedido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`id`, `data_pedido`, `cliente_id`, `valor_total`, `data_retirada`, `status`, `supermercado_id`, `cliente_endereco_id`) VALUES
(4, '2020-10-05 21:55:49', 16, '150', NULL, 0, 1, NULL),
(5, '2020-10-05 21:55:49', 15, '250', NULL, 0, 1, NULL),
(6, '2020-10-05 21:55:49', 15, '250', NULL, 0, 1, NULL),
(7, '2020-10-05 21:55:49', 15, '354', NULL, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_has_produto`
--

CREATE TABLE `pedido_has_produto` (
  `id` int(11) NOT NULL COMMENT 'Código',
  `pedido_id` int(11) NOT NULL COMMENT 'Pedido',
  `produto_id` int(11) NOT NULL COMMENT 'Produto',
  `quantidade` varchar(45) NOT NULL COMMENT 'Quantidade',
  `valor_produto` float NOT NULL COMMENT 'Valor produto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL COMMENT 'Código',
  `nome` varchar(150) NOT NULL COMMENT 'Nome',
  `descricao` varchar(45) NOT NULL COMMENT 'Descrição',
  `unidade` varchar(45) NOT NULL COMMENT 'Unidade',
  `valor` double NOT NULL COMMENT 'Preço',
  `id_marca` int(11) NOT NULL COMMENT 'Marca',
  `setor_id` int(11) NOT NULL COMMENT 'Setor',
  `estoque` varchar(45) NOT NULL COMMENT 'Estoque',
  `imagem` varchar(45) NOT NULL COMMENT 'Imagem',
  `status` int(11) NOT NULL COMMENT 'Status',
  `criado_em` date NOT NULL COMMENT 'Criado em'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_marca`
--

CREATE TABLE `produto_marca` (
  `id` int(11) NOT NULL COMMENT 'Código',
  `descricao` varchar(150) NOT NULL COMMENT 'Nome',
  `status` int(11) DEFAULT NULL COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_setor`
--

CREATE TABLE `produto_setor` (
  `id` int(11) NOT NULL COMMENT 'Código',
  `descricao` varchar(150) NOT NULL COMMENT 'Nome',
  `status` int(11) DEFAULT NULL COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `supermercado`
--

CREATE TABLE `supermercado` (
  `id` int(11) NOT NULL COMMENT 'Código',
  `nome` varchar(100) NOT NULL COMMENT 'Nome',
  `razao_social` varchar(100) NOT NULL COMMENT 'Razão social',
  `cnpj` varchar(45) NOT NULL COMMENT 'Cnpj',
  `cep` varchar(45) NOT NULL COMMENT 'Cep',
  `endereco` varchar(45) NOT NULL COMMENT 'Endereço',
  `numero` varchar(45) DEFAULT NULL COMMENT 'Número',
  `bairro` varchar(45) NOT NULL COMMENT 'Bairro',
  `cidade` varchar(45) NOT NULL COMMENT 'Cidade',
  `estado` varchar(45) NOT NULL COMMENT 'Estado',
  `status` int(11) NOT NULL COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `supermercado`
--

INSERT INTO `supermercado` (`id`, `nome`, `razao_social`, `cnpj`, `cep`, `endereco`, `numero`, `bairro`, `cidade`, `estado`, `status`) VALUES
(1, 'mercado 01', 'mercado 01', '07.635.577/0001-40', '86062320', 'rua bauru', '286', 'alvorada', 'Londrina', 'PR', 1),
(2, 'mercado 01', 'mercado 01', '07.635.577/0001-40', '86062320', 'rua bauru', '286', 'alvorada', 'Londrina', 'PR', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_endereco`
--

CREATE TABLE `tipo_endereco` (
  `id` int(11) NOT NULL COMMENT 'Código',
  `descricao` varchar(50) NOT NULL COMMENT 'Descrição',
  `status` int(11) DEFAULT NULL COMMENT 'Status\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `passwordHash` varchar(45) NOT NULL,
  `authKey` varchar(255) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `cliente` tinyint(1) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `passwordResetToken` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `cpf` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `username`, `passwordHash`, `authKey`, `access_token`, `cliente`, `created_at`, `updated_at`, `passwordResetToken`, `status`, `cpf`) VALUES
(12, 'Administrador Julio', 'julio@saviolli.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'XYCtiY46yygOsnyx5cjBdWTNcfZq4dFu', '', 0, 1601700082, 1601700082, '', 1, ''),
(14, 'Administradora Jaque', 'jaque@saviolli.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'jb8OOm8Az1FxRKrJGlo1oxxXGdcVxAQG', '', 0, 1601700082, 1601700082, '', 1, ''),
(15, 'Primeiro cliente 01', 'primeirocliente@tcc.com.br', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Fet9I9PH0XjIHc_r2Ca9fXlCrKQHRo6r', '', 1, 1601757211, 1601758201, '', 1, '050.192.479-52'),
(16, '123456', '123@tcc.com.br', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '6xC6opoysoALAiB7keCpvQ7uMeDKRT1p', '', 1, 1601944225, 1601944236, '', 1, '111.111.111-11'),
(17, 'Julio Duarte', 'kurorollers@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'rSi9edjRO1C5LK__ioy5MIudboxZvGL5', '', 1, 1601950011, 1601950820, '', 1, '050.192.479-51');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`);

--
-- Índices para tabela `cliente_endereco`
--
ALTER TABLE `cliente_endereco`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_endereco_cliente1_idx` (`cliente_id`),
  ADD KEY `fk_cliente_endereco_endereco1_idx` (`tipo_endereco_id`);

--
-- Índices para tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Pedido_cliente1_idx` (`cliente_id`),
  ADD KEY `fk_Pedido_supermercado1_idx` (`supermercado_id`),
  ADD KEY `fk_pedido_cliente_endereco1_idx` (`cliente_endereco_id`);

--
-- Índices para tabela `pedido_has_produto`
--
ALTER TABLE `pedido_has_produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Pedido_has_produto_produto1_idx` (`produto_id`),
  ADD KEY `fk_Pedido_has_produto_Pedido1_idx` (`pedido_id`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_imovel_tipo_imovel_idx` (`id_marca`),
  ADD KEY `fk_produto_setor1_idx` (`setor_id`);

--
-- Índices para tabela `produto_marca`
--
ALTER TABLE `produto_marca`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produto_setor`
--
ALTER TABLE `produto_setor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `supermercado`
--
ALTER TABLE `supermercado`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tipo_endereco`
--
ALTER TABLE `tipo_endereco`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_UNIQUE` (`username`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente_endereco`
--
ALTER TABLE `cliente_endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código';

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `pedido_has_produto`
--
ALTER TABLE `pedido_has_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código';

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código';

--
-- AUTO_INCREMENT de tabela `produto_marca`
--
ALTER TABLE `produto_marca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código';

--
-- AUTO_INCREMENT de tabela `produto_setor`
--
ALTER TABLE `produto_setor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código';

--
-- AUTO_INCREMENT de tabela `supermercado`
--
ALTER TABLE `supermercado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tipo_endereco`
--
ALTER TABLE `tipo_endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código';

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cliente_endereco`
--
ALTER TABLE `cliente_endereco`
  ADD CONSTRAINT `fk_cliente_endereco_endereco1` FOREIGN KEY (`tipo_endereco_id`) REFERENCES `tipo_endereco` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_endereco_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_Pedido_supermercado1` FOREIGN KEY (`supermercado_id`) REFERENCES `supermercado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_pedido_cliente_endereco1` FOREIGN KEY (`cliente_endereco_id`) REFERENCES `cliente_endereco` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pedido_has_produto`
--
ALTER TABLE `pedido_has_produto`
  ADD CONSTRAINT `fk_Pedido_has_produto_Pedido1` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Pedido_has_produto_produto1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `fk_imovel_tipo_imovel` FOREIGN KEY (`id_marca`) REFERENCES `produto_marca` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_produto_setor1` FOREIGN KEY (`setor_id`) REFERENCES `produto_setor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
