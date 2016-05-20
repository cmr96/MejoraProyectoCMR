<?php
$connection->query("CREATE TABLE IF NOT EXISTS `entrada_pedido` (
  `id_producto` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
$connection->query("INSERT INTO `entrada_pedido` (`id_producto`, `id_pedido`, `cantidad`) VALUES
(3, 1, 1);");
$connection->query("CREATE TABLE IF NOT EXISTS `pedido` (
  `id_usuario` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `precio` int(11) NOT NULL,
  `observaciones` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;");
$connection->query("INSERT INTO `pedido` (`id_usuario`, `id_pedido`, `fecha`, `precio`, `observaciones`) VALUES
(4, 1, '2016-03-01', 15, 'Ninguna');");
$connection->query("CREATE TABLE IF NOT EXISTS `permiso` (
  `id_permiso` varchar(50) NOT NULL,
  `pedidos` varchar(50) NOT NULL,
  `productos` varchar(50) NOT NULL,
  `usuarios` varchar(50) NOT NULL,
  `tienda` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
$connection->query("INSERT INTO `permiso` (`id_permiso`, `pedidos`, `productos`, `usuarios`, `tienda`) VALUES
('admin', '1:1:1', '1:1:1', '1:1:1', '1:1:1'),
('mod', '0:0:0', '1:1:0', '0:0:0', '1:0:0'),
('user', '0:0:0', '0:0:0', '0:0:0', '1:0:0');");
$connection->query("CREATE TABLE IF NOT EXISTS `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio_unit` int(11) NOT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `caracteristicas` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;");
$connection->query("INSERT INTO `producto` (`id_producto`, `nombre`, `precio_unit`, `foto`, `stock`, `categoria`, `caracteristicas`) VALUES
(2, 'Sharkoon Shark Zone K30', 29, 'pro1.jpg', 5, 'teclado', 'teclado con una relación calidad-precio muy atractiva. El diseño del Shark Zone negro y amarillo mejora sus habilidades de juego y envía una advertencia visual a sus rivales de juego.'),
(3, 'Tacens Mars Gaming Altavoces MS1', 15, 'pro2.jpg', 3, 'altavoces', 'Los MS1 son los primeros altavoces de la gama Mars Gaming pensados por y para gamers. La gran potencia RMS de 10W que ofrecen te permitirán una inmersión total en el juego.'),
(4, 'Gigabyte GeForce GTX 960 OC WindForce 4GB DDR5', 223, 'pro3.jpg', 22, 'targeta grafica', 'Te presentamos la Gigabyte GeForce GTX 960, una gráfica en su version OC con 4GB de memoria, que elevará la potencia de tu PC a la de un autético Gamer.');");
$connection->query("CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL,
  `id_permiso` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `direccion` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;");
$connection->query("INSERT INTO `usuario` (`id_usuario`, `id_permiso`, `nombre`, `apellidos`, `password`, `correo`, `telefono`, `direccion`) VALUES
(1, 'user', 'Matilde', 'Romero Zarco', '81dc9bdb52d04dc20036dbd8313ed055', 'prueba1@hotmail.com', '111111111', 'C/San Vicente de Paul'),
(3, 'mod', 'Luis Daniel', 'Martinez Abreu', '81dc9bdb52d04dc20036dbd8313ed055', 'prueba2@hotmail.com', '222222222', 'C/Luis Mensaque'),
(4, 'admin', 'Carlos', 'Martinez Romero', '69d3669add13e8a49cf9803ff997c6f4', 'carlos1m2r3@hotmail.com', '333333333', 'C/Lopez de gomara'),
(5, 'user', 'ssccscs', 'aa', '81dc9bdb52d04dc20036dbd8313ed055', '1@1', '1234', 'aa');");
$connection->query("ALTER TABLE `entrada_pedido`
  ADD KEY `id_producto` (`id_producto`), ADD KEY `id_pedido` (`id_pedido`);");
$connection->query("ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`), ADD KEY `id_usuario` (`id_usuario`);");
$connection->query("ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id_permiso`);");
$connection->query("ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);");
$connection->query("ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`), ADD UNIQUE KEY `correo` (`correo`), ADD KEY `id_permiso` (`id_permiso`);");
$connection->query("ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;");
$connection->query("ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;");
$connection->query("ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;");
$connection->query("ALTER TABLE `entrada_pedido`
ADD CONSTRAINT `entrada_pedido_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
ADD CONSTRAINT `entrada_pedido_ibfk_2` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`);");
$connection->query("ALTER TABLE `pedido`
ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);");
$connection->query("ALTER TABLE `usuario`
ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_permiso`) REFERENCES `permiso` (`id_permiso`);");
?>
