<?php
require_once ("../Personal.php");

if($_POST["opcion"] == "Agregar")
{

	$p = new Personal($_POST['Nombre'],$_POST['Apellido'],null,$_POST['PASSWORD'],$_POST['Edad']);
			
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



?>