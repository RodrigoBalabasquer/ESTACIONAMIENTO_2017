<?php
require_once ("../CLASES/Personal.php");
require_once ("../CLASES/Empleado.php");
require_once ("../CLASES/Estacionamiento.php");
require_once ("../CLASES/Vehiculo.php");
require_once ("../CLASES/Cochera.php");
date_default_timezone_set ('America/Argentina/Buenos_Aires');
//Actualiza la cantidad de operaciones que realiza el empleado y lo desconecta
if($_POST["opcion"] == "Log-out")
{
    session_start();

    $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

    $PdoST = $Pdo->prepare("UPDATE empleados SET CantidadOperaciones = :cantidad WHERE id = :ID");
    $PdoST->bindParam(":cantidad",$_SESSION['Cantidad']);
    $PdoST->bindParam(":ID",$_SESSION['Id']);
    $PdoST->execute();
    
    session_unset();
    
}
?>