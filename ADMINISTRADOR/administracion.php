<?php
require_once ("../CLASES/Personal.php");
require_once ("../CLASES/Empleado.php");
require_once ("../CLASES/Vehiculo.php");
require_once ("../CLASES/Cochera.php");

//Agrega un nuevo empleado a la tabla del personal
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
//Elimina al empleado que coincida con el legajo ingresado 
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
//Cambia el estado del empleado que coincida con el legajo ingresado a suspendido
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
//Cambia el estado del empleado que coincida con el legajo ingresado a activo
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
            echo "No se pudo reabilitar al empleado";
        }
		else
		{   
            echo "Empleado reabilitado exitosamente";
        }	
	}
}
//Muestra un listado de los empleados, los dias que se loguearon y sus actividades
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
//Muestra la informacion de toda la actividad realizada en la fecha ingresada
if($_POST["opcion"] == "Actividad") 
{
	$fecha = explode("-",$_POST["fecha"]);
	$anio = (int)$fecha[0];
	$dia = (int)$fecha[2];
	$mes = (int)$fecha[1];
	$vehiculos = Vehiculo::TraerAutosFiltrados($dia,$mes,$anio);
	$valor1="Registro de autos:<br>";
	foreach($vehiculos as $vehiculo)
	{
		if($vehiculo->getOperacion() != "Egreso")
		{
			$valor1.="A las ".$vehiculo->getHora().":".$vehiculo->getMinuto()." ingreso un auto con la patente ".$vehiculo->getPatente().".<br>"; 
		}
		else
		{
			$valor1.="A las ".$vehiculo->getHora().":".$vehiculo->getMinuto()." salio un auto con la patente ".$vehiculo->getPatente()." y pago ".$vehiculo->getPago()." pesos.<br>"; 
		}
	}
	$id = ObtenerIdentificadorFechas($dia,$mes,$anio);
	$cocheras = Cochera::TraerCocherasFiltrados($id);
	$valor1.="<br>Promedio de Cocheras:<br>";
	foreach($cocheras  as $cochera)
	{
		if($cochera->getCaracteristica() == "Mas utilizada")
		{
			$valor1.="Mas utilizada ".$cochera->getNumero()." con un cantidad de ".$cochera->getCantidad()."<br>"; 
		}
		if($cochera->getCaracteristica() == "Menos utilizada")
		{
			$valor1.="Menos utilizada ".$cochera->getNumero()." con un cantidad de ".$cochera->getCantidad()."<br>"; 
		}
		if($cochera->getCaracteristica() == "No utilizada")
		{
			$valor1.="No utilizada ".$cochera->getNumero()."<br>"; 
		}
	}
	echo $valor1;
}
//Retorna los datos del empleado que coincida con el legajo ingresado
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
//Retorna el id de la fecha ingresada
function ObtenerIdentificadorFechas($dia,$mes,$anio)
{
	$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
	$PdoST = $Pdo->prepare("SELECT * FROM fechas WHERE Dia =:dia && Mes=:mes && Anio=:anio");
	$PdoST->bindValue(":dia",$dia);
	$PdoST->bindValue(":mes",$mes);
	$PdoST->bindValue(":anio",$anio);
	$PdoST->execute();
	foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
	{	
		$Dato[] = $registro["id"];
	}
	return $Dato[0];
}
?>