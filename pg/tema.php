<?php
session_start();
if ($_GET['tema']==="azul") {
unset($_SESSION["tema"]);
    $_SESSION["tema"]=array("temalogo11","temalogo21","temamedio1","temabordecab1","temabordepie1","temali11","temali21","temali31","temali41","temali51","temali61","temacone11","temacone21");
}
if ($_GET['tema']==="verde") {
unset($_SESSION["tema"]);
 $_SESSION["tema"]=array("temalogo12","temalogo22","temamedio2","temabordecab2","temabordepie2","temali12","temali22","temali32","temali42","temali52","temali62","temacone12","temacone22");
}
if ($_GET['tema']==="rojo") {
unset($_SESSION["tema"]);
 $_SESSION["tema"]=array("temalogo13","temalogo23","temamedio3","temabordecab3","temabordepie3","temali13","temali23","temali33","temali43","temali53","temali63","temacone13","temacone23");
}
header("location: panel.php");
?>

// TEMA POR DEFECTO PARA INICIO DE PAGINA
<?PHP
if(!isset($_SESSION["tema"])){
    $_SESSION["tema"]=array("temalogo11","temalogo21","temamedio1","temabordecab1","temabordepie1","temali11","temali21","temali31","temali41","temali51","temali61","temacone11","temacone21");}
?>



// TEMA EN DIV
<div class="<?php echo $_SESSION['tema'][1]; ?>">
