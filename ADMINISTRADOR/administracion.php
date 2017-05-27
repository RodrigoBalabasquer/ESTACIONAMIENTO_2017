<?php
require_once ("../CLASES/Personal.php");
require_once ("../CLASES/Empleado.php");

if($_POST["opcion"] == "Agregar")
{

	$p = new Personal($_POST['Nombre'],$_POST['Apellido'],null,$_POST['PASSWORD'],$_POST['Edad'],"Activo");
			
    if(!Personal::GuardarBaseDatos($p))
    {
        echo "Lamentablemente ocurrio un error y no se pudo ingresar el empleado.";
        echo "  <a class='btn btn-info' href='../Administrar.php'>Menu principal</a>";
    }
    else
    {
        echo "El empleado fue ingresado correctamente.";
	}
}
if($_POST["opcion"] == "Eliminar") 
{
	$ArrayEmpleados = Personal::TraerTodosLosEmpleados();
	$indice = Personal:: ObtenerIndice($ArrayEmpleados,$_POST["Legajo"]);
	if($indice == -1)
	{
		$mensaje = "El legajo que ingreso no se encuentra";
		echo $mensaje;
        echo "  <a class='btn btn-info' href='../Administrar.php'>Menu principal</a>";
	}
	else
	{	
		if(!Personal::BorrarBaseDatos($ArrayEmpleados[$indice]))
		{   
            echo "No se pudo quitar al empleado";
        }
		else
		{   
            echo "Empleado eliminado exitosamente";
        }	
	}
}
if($_POST["opcion"] == "Suspender") 
{
	$ArrayEmpleados = Personal::TraerTodosLosEmpleados();
	$indice = Personal:: ObtenerIndice($ArrayEmpleados,$_POST["Legajo"]);
	if($indice == -1)
	{
		$mensaje = "El legajo que ingreso no se encuentra";
		echo $mensaje;
        echo "  <a class='btn btn-info' href='../Administrar.php'>Menu principal</a>";
	}
	else
	{	
		if(!Personal::ModificarBaseDatos($ArrayEmpleados[$indice],"Suspendido"))
		{   
            echo "No se pudo suspender al empleado";
        }
		else
		{   
            echo "Empleado suspendido exitosamente";
        }	
	}
}
if($_POST["opcion"] == "Reabilitar") 
{
	$ArrayEmpleados = Personal::TraerTodosLosEmpleados();
	$indice = Personal:: ObtenerIndice($ArrayEmpleados,$_POST["Legajo"]);
	if($indice == -1)
	{
		$mensaje = "El legajo que ingreso no se encuentra";
		echo $mensaje;
        echo "  <a class='btn btn-info' href='../Administrar.php'>Menu principal</a>";
	}
	else
	{	
		if(!Personal::ModificarBaseDatos($ArrayEmpleados[$indice],"Activo"))
		{   
            echo "No se pudo suspender al empleado";
        }
		else
		{   
            echo "Empleado reabilitado exitosamente";
        }	
	}
}
if($_POST["opcion"] == "Lista") 
{
	$ArrayEmpleados = Personal::TraerTodosLosEmpleados();
	foreach($ArrayEmpleados as $empleado)
	{
		if($empleado->getLegajo() != 1)
		{
			echo "El empleado ".$empleado->getNombre()." ".$empleado->getApellido()." se conecto los siguientes dias:";
			echo "<br>";
			$Datos = TraerDatos($empleado->getLegajo());
			foreach($Datos as $dato)
			{
				echo $dato->getDia()."/".$dato->getMes()."/".$dato->getAnio()." en el horario ".$dato->getTurno()." y realizo ".$dato->getCantidad()." operaciones"; 
				echo "<br>";
			}
			echo "<br>";
		}
	}
}

function TraerDatos($legajo)
{
	$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

		$PdoST = $Pdo->prepare("SELECT * FROM empleados WHERE Legajo = :legajo");
		$PdoST->bindParam(":legajo",$legajo);
    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$DatosEmpleado[] = new Empleado($registro['Nombre'],$registro['Apellido'],$registro['Legajo'],$registro['Turno'],$registro['Dia'],$registro['Mes'],$registro['Anio'],$registro['CantidadOperaciones']);
		}
		return $DatosEmpleado;
}

?>