<?php
session_start();
if ($_GET['tema']==="azul") {
unset($_SESSION["tema"]);
    $_SESSION["tema"]=array("img/logo.jpg","img/boton.jpg","dropbtn","dropdown-content","dropdown","desp","ul","encabezado","medio","final","get","desp21","desp22","desp23","desp24","desp25","desp26","dialog","#0C5484","fotodos","boton");
}
if ($_GET['tema']==="verde") {
unset($_SESSION["tema"]);
 $_SESSION["tema"]=array("img/logo2.jpeg","img/boton2.jpeg","dropbtn2","dropdown-content2","dropdown2","desp2","ul2","encabezado2","medio2","final2","get2","desp212","desp222","desp232","desp242","desp252","desp262","dialog2","#009263","fotodos2","boton2");
}
if ($_GET['tema']==="rojo") {
unset($_SESSION["tema"]);
 $_SESSION["tema"]=array("img/logo3.jpeg","img/boton3.jpeg","dropbtn3","dropdown-content3","dropdown3","desp33","ul3","encabezado3","medio3","final3","get3","desp213","desp223","desp233","desp243","desp253","desp263","dialog3","#931A29","fotodos3","boton3");
}
header("location: panel.php");
?>
