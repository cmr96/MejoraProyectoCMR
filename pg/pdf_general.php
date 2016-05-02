<?php
session_start();
require("fpdf.php");
require("db_configuration.php");
$connection = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($connection->connect_errno) {
	printf("Connection failed: %s\n", $connection->connect_error);
	exit();

}
if(isset($_SESSION["usu"]))
   {$correo = $_SESSION["usu"];


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Image('img/logo.jpg' , 140 ,10, 50 , 15,'JPG');
$pdf->Cell(20);
$pdf->SetFont('Arial', '', 9);
$pdf->Ln(35);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 8, '', 0);
$pdf->Cell(60,10,'INFORME COMPLETO: '.date('d-m-Y').'',2,2);
$pdf->Ln(20);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 8, 'Usuario');
$pdf->Cell(25, 8, 'Fecha');
$pdf->Cell(25, 8, 'Precio');
$pdf->Cell(30, 8, 'Observaciones');
$pdf->Cell(40, 8, 'Producto');
$pdf->Ln(8);
$pdf->SetFont('Arial');

$consulta = $connection->query('select correo, p.id_pedido, fecha, precio, observaciones, pr.nombre from pedido p, entrada_pedido ep, producto pr, usuario u where p.id_pedido=ep.id_pedido and ep.id_producto=pr.id_producto and p.id_usuario=u.id_usuario');

if ($consulta->num_rows > 0) {
		while($obj=$consulta->fetch_object()){

			$pdf->Cell(50, 8, $obj->correo, 0);
			$pdf->Cell(25, 8, $obj->fecha, 0);
			$pdf->Cell(25, 8,  $obj->precio, 0);
			$pdf->Cell(30, 8,  $obj->observaciones, 0);
			$pdf->Cell(40, 8,  $obj->nombre, 0);

			$pdf->Ln(8);
		}
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Output();

}

}

// select p.id_pedido, fecha, precio, observaciones, nombre from pedido p, entrada_pedido ep, producto pr where p.id_pedido=ep.id_pedido and ep.id_producto=pr.id_producto where p.id_usuario in (select id_usuario from usuario where correo="carlos1m2r3@hotmail.com")

?>
