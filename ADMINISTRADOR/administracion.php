<?php
require_once ("../Personal.php");

if(isset($_POST["guardar"])) 
{

	$p = new Personal($_POST['nombre'],$_POST['apellido'],null,$_POST['contraseña'],$_POST['edad']);
			
    if(!Personal::GuardarBaseDatos($p))
    {
        $mensaje = "Lamentablemente ocurrio un error y no se pudo ingresar el empleado.";
        echo $mensaje;
        echo "  <a class='btn btn-info' href='../Administrar.php'>Menu principal</a>";
    }
    else
    {
        $mensaje = "El empleado fue ingresado correctamente.";
        echo $mensaje;
        echo "  <a class='btn btn-info' href='../Administrar.php'>Menu principal</a>";
    }
}
if(isset($_POST["eliminar"])) 
{
	$ArrayEmpleados = Personal::TraerTodosLosEmpleados();
	$indice = Personal:: ObtenerIndice($ArrayEmpleados,$_POST["legajo"]);
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
            $mensaje = "No se pudo quitar al empleado";
			echo $mensaje;
            echo "  <a class='btn btn-info' href='../Administrar.php'>Menu principal</a>";
		}
		else
		{   
             $mensaje = "Empleado eliminado exitosamente";
			echo $mensaje;
            echo "  <a class='btn btn-info' href='../Administrar.php'>Menu principal</a>";
		}	
	}
}



?>