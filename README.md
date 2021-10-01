# crudv2

<h3>TABELAS</h3>
<p>CREATE TABLE `movies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `original_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` double(3,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
</p>

<p>CREATE TABLE `tb_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_nivel` int(11) DEFAULT 1,
  `nome` varchar(250) DEFAULT NULL,
  `sobrenome` varchar(250) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `primeiro_acesso` int(1) DEFAULT 1,
  `excluido` int(1) DEFAULT 0,
  `fk_orgao` int(11) DEFAULT NULL,
  `ultimo_acesso` datetime DEFAULT NULL,
  `data_criacao` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
</p>

<p>
 Alterar os dados de acesso em config/config.php e o caminho em public/.htaccess
  </p>
