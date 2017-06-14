<?php
require_once ("../CLASES/Personal.php");
require_once ("../CLASES/Empleado.php");
require_once ("../CLASES/Estacionamiento.php");
require_once ("../CLASES/Vehiculo.php");
require_once ("../CLASES/Cochera.php");
date_default_timezone_set ('America/Argentina/Buenos_Aires');
//Agrega un nuevo empleado a la tabla del personal
/*if($_POST["opcion"] == "Agregar")
{}
//Elimina al empleado que coincida con el legajo ingresado 
if($_POST["opcion"] == "Eliminar") 
{}
//Cambia el estado del empleado que coincida con el legajo ingresado a suspendido
if($_POST["opcion"] == "Suspender") 
{}
//Cambia el estado del empleado que coincida con el legajo ingresado a activo
if($_POST["opcion"] == "Reabilitar") 
{}
//Muestra un listado de los empleados, los dias que se loguearon y sus actividades
if($_POST["opcion"] == "Lista") 
{}
//Muestra la informacion de toda la actividad realizada en la fecha ingresada
if($_POST["opcion"] == "Actividad") 
{}
//Retorna los datos del empleado que coincida con el legajo ingresado
function TraerDatos($legajo)
{}
//Retorna el id de la fecha ingresada
function ObtenerIdentificadorFechas($dia,$mes,$anio)
{}
//Muestra los lugares disponibles en la cochera
if($_POST["opcion"] == "Lugares")
{}
//Ocupa el lugar del estacionamiento seleccionado y registra el vehiculi con sus datos y la fecha de ingreso
if($_POST["opcion"] == "Ocupar")
{}
//Retira un vehiculo de la base de datos y muestra sus datos junto el importe a pagar
if($_POST["opcion"] == "Retirar")
{}*/
//Guarda la cantidad de operaciones que hizo el empleado y si es de turno noche guarda las cocheras mas, menos y no usadas
if($_POST["opcion"] == "Log-out")
{
    session_start();

    
    $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

    $PdoST = $Pdo->prepare("UPDATE empleados SET CantidadOperaciones = :cantidad WHERE id = :ID");
    $PdoST->bindParam(":cantidad",$_SESSION['Cantidad']);
    $PdoST->bindParam(":ID",$_SESSION['Id']);
    $PdoST->execute();
    /*if($_SESSION["Turno"] == "noche")
    {
        $ArrayCocheras = Estacionamiento::TraerTodasLasCocheras();
        $cero = Estacionamiento:: ObtenerCantidadCero($ArrayCocheras);
        $mayor = Estacionamiento:: ObtenerMayorCantidad($ArrayCocheras);
        $menor = Estacionamiento:: ObtenerMenorCantidad($ArrayCocheras);
        if($mayor > 0)
        {
            $ArrayCocherasMayor = Estacionamiento::TraerLasCocherasMayor($mayor);
            $PdoST2 = $Pdo->prepare("INSERT INTO cocheras(Fecha,Cochera,Caracteristica,Cantidad) VALUES (:fecha,:cochera,'Mas utilizada','$mayor')");
            foreach($ArrayCocherasMayor as $registro) 
            {	
                $PdoST2->bindParam(":fecha",$_SESSION['Fecha']);
                $PdoST2->bindParam(":cochera",$registro->getNumero());
                $PdoST2->execute();
            }
        }
        if($menor < 10000)
        {
            $ArrayCocherasMenor = Estacionamiento::TraerLasCocherasMenor($menor);
            $PdoST3 = $Pdo->prepare("INSERT INTO cocheras(Fecha,Cochera,Caracteristica,Cantidad) VALUES (:fecha,:cochera,'Menos utilizada','$menor')");
            foreach($ArrayCocherasMenor as $registro) 
            {	
                $PdoST3->bindParam(":fecha",$_SESSION['Fecha']);
                $PdoST3->bindParam(":cochera",$registro->getNumero());
                $PdoST3->execute();
            }
        }
        if($cero)
        {
            $ArrayCocherasCero = Estacionamiento::TraerLasCocherasCero();
            $PdoST4 = $Pdo->prepare("INSERT INTO cocheras(Fecha,Cochera,Caracteristica,Cantidad) VALUES (:fecha,:cochera,'No utilizada',0)");
            foreach($ArrayCocherasCero as $registro) 
            {	
                $PdoST4->bindParam(":fecha",$_SESSION['Fecha']);
                $PdoST4->bindParam(":cochera",$registro->getNumero());
                $PdoST4->execute();
            }
        }
        Estacionamiento:: Reset($ArrayCocheras);
    }*/
    session_unset();
    
}
?>