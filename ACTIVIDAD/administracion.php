<?php
require_once ("../CLASES/Personal.php");
require_once ("../CLASES/Empleado.php");
require_once ("../CLASES/Estacionamiento.php");
require_once ("../CLASES/Vehiculo.php");
require_once ("../CLASES/Cochera.php");
date_default_timezone_set ('America/Argentina/Buenos_Aires');
//Agrega un nuevo empleado a la tabla del personal
if($_POST["opcion"] == "Agregar")
{
    $p = new Personal($_POST['Nombre'],$_POST['Apellido'],$_POST['Dni'],null,$_POST['PASSWORD'],$_POST['Edad'],"Activo",0);
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
	if(!Personal::ModificarBaseDatos($ArrayEmpleados[$indice],"Despedido"))
    {   
        echo "No se pudo quitar al empleado";
    }
    else
    {   
        echo "Empleado eliminado exitosamente";
    }	
}
//Cambia el estado del empleado que coincida con el legajo ingresado a suspendido
if($_POST["opcion"] == "Suspender") 
{
	$ArrayEmpleados = Personal::TraerTodosLosEmpleados();
	$indice = Personal:: ObtenerIndice($ArrayEmpleados,$_POST["Legajo"]);
	if(!Personal::ModificarBaseDatos($ArrayEmpleados[$indice],"Suspendido"))
    {   
        echo "No se pudo suspender al empleado";
    }
    else
    {   
        echo "Empleado suspendido exitosamente";
    }	
}
//Cambia el estado del empleado que coincida con el legajo ingresado a activo
if($_POST["opcion"] == "Reabilitar") 
{
	$ArrayEmpleados = Personal::TraerTodosLosEmpleados();
	$indice = Personal:: ObtenerIndice($ArrayEmpleados,$_POST["Legajo"]);
	if(!Personal::ModificarBaseDatos($ArrayEmpleados[$indice],"Activo"))
    {   
        echo "No se pudo reabilitar al empleado";
    }
    else
    {   
        echo "Empleado reabilitado exitosamente";
    }	
}
//Muestra un listado de los empleados, los dias que se loguearon y sus actividades
if($_POST["opcion"] == "Lista") 
{
	$ArrayEmpleados = Personal::TraerTodosLosEmpleados();
	foreach($ArrayEmpleados as $empleado)
	{
		if($empleado->getNivel() == 0)
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
			$DatosEmpleado[] = new Empleado($registro['Nombre'],$registro['Apellido'],$registro['Legajo'],$registro['Turno'],$registro['Dia'],$registro['Mes'],$registro['Anio'],$registro['CantidadOperaciones'],$registro['Nivel']);
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
//Muestra los lugares disponibles en la cochera
if($_POST["opcion"] == "Lugares")
{
    $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
    $PdoST = $Pdo->prepare("SELECT * FROM estacionamiento WHERE Estado = 'Disponible' && Piso = :piso");
    $PdoST->bindValue(":piso",$_POST['valor']);
    $PdoST->execute();
    $ListaDeEstacionamientos = array();
    foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
    {	
        $ListaDeEstacionamientos[] = new Estacionamiento($registro['Piso'],$registro['Cochera'],$registro['Condicion'],$registro['Estado'],$registro['Cantidad']);
    }
    
    
   

    echo    '<div class="CajaInicio animated bounceInRight">
			<input type="text" id="Color" placeholder="Ingrese color"/>
			<input type="text" id="Patente" placeholder="Ingrese patente"/>
			<input type="text" id="Marca" placeholder="Ingrese marca"/>';
    echo "<a href='#' class='list-group-item active'>Lugares disponibles</a>"; 	
    foreach ($ListaDeEstacionamientos as $cont)
    {
        $piso = $cont->getPiso();
        $numero = $cont->getNumero();
        if($cont->getCondicion() != "NORMAL")
        {
            echo "<a onclick=aceptar('$numero') class='list-group-item list-group-item-danger'>
            <h4 class='list-group-item-heading'>Planta $piso Estacionamiento $numero Solo para discapacitados o Embarazadas</h4>
            </a>";
        }   
        else
        {
            echo "<a onclick=aceptar('$numero') class='list-group-item list-group-item-info'>
            <h4 class='list-group-item-heading'>Planta $piso Estacionamiento $numero</h4>
            </a>";
        }
    }
    echo "<div>";	
}
//Ocupa el lugar del estacionamiento seleccionado y registra el vehiculi con sus datos y la fecha de ingreso
if($_POST["opcion"] == "Ocupar")
{
    

    $ArrayCocheras = Estacionamiento::TraerTodasLasCocheras();
    $indice = Estacionamiento:: ObtenerIndice($ArrayCocheras,$_POST['numero']);
    Estacionamiento::ModificarBaseDatos($ArrayCocheras[$indice],"Ocupado");
    Estacionamiento::IncrementarBaseDatos($ArrayCocheras[$indice]);

    $fecha = getdate();
    $vehiculo = new Vehiculo($_POST['patente'],$_POST['color'],$_POST['marca'],$fecha["hours"],$fecha["minutes"],$fecha["mday"],$fecha["mon"],$fecha["year"],"Ingreso",0,$_POST['numero']);
    Vehiculo::GuardarBaseDatos($vehiculo);
    session_start();
    $_SESSION["Cantidad"]++;
    

}
//Retira un vehiculo de la base de datos y muestra sus datos junto el importe a pagar
if($_POST["opcion"] == "Retirar")
{
    $ArrayVehiculos = Vehiculo::TraerTodosLosAutos();
    $indice = Vehiculo:: ObtenerIndice( $ArrayVehiculos,$_POST['patente']);
    if($indice == -1)
	{
		$mensaje = "La patente que ingreso no se encuentra";
		echo $mensaje;
    }
	else
	{	
        session_start();
        $_SESSION["Cantidad"]++;
        Vehiculo::ModificarBaseDatos($ArrayVehiculos[$indice],"IngresoFin");
        
		$Pago = Vehiculo::ObtenerPago($ArrayVehiculos[$indice]);
        $fecha = getdate();
        $vehiculo = new Vehiculo($ArrayVehiculos[$indice]->getPatente(),
        $ArrayVehiculos[$indice]->getColor(),$ArrayVehiculos[$indice]->getMarca(),
        $fecha["hours"],$fecha["minutes"],$fecha["mday"],$fecha["mon"],$fecha["year"],"Egreso",$Pago,$ArrayVehiculos[$indice]->getCochera());
        Vehiculo::GuardarBaseDatos($vehiculo);
        $ArrayCocheras = Estacionamiento::TraerTodasLasCocheras();
        $indice = Estacionamiento:: ObtenerIndice($ArrayCocheras,$ArrayVehiculos[$indice]->getCochera());
        Estacionamiento::ModificarBaseDatos($ArrayCocheras[$indice],"Disponible");
        echo "Vehiculo retirado <br>";
        echo "Patente ".$vehiculo->getPatente()."<br>";
        echo "Color ".$vehiculo->getColor()."<br>";
        echo "Marca ".$vehiculo->getMarca()."<br>";
        echo "Importe a pagar ".$vehiculo->getPago()."<br>";
    }
}
//Guarda la cantidad de operaciones que hizo el empleado y si es de turno noche guarda las cocheras mas, menos y no usadas
if($_POST["opcion"] == "Log-out")
{
    session_start();

    
    $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

    $PdoST = $Pdo->prepare("UPDATE empleados SET CantidadOperaciones = :cantidad WHERE id = :ID");
    $PdoST->bindParam(":cantidad",$_SESSION['Cantidad']);
    $PdoST->bindParam(":ID",$_SESSION['Id']);
    $PdoST->execute();
    if($_SESSION["Turno"] == "noche")
    {
        $PdoST1 = $Pdo->prepare("INSERT INTO fechas(id,Dia,Mes,Anio) VALUES (null,:dia,:mes,:anio)");
        $PdoST1->bindParam(":dia",$_SESSION["Dia"]);
        $PdoST1->bindParam(":mes",$_SESSION["Mes"]);
        $PdoST1->bindParam(":anio",$_SESSION["Anio"]);
        $PdoST1->execute();
        $ID = $Pdo->lastInsertId("Fechas");
        $ArrayCocheras = Estacionamiento::TraerTodasLasCocheras();
        $cero = Estacionamiento:: ObtenerCantidadCero($ArrayCocheras);
        $mayor = Estacionamiento:: ObtenerMayorCantidad($ArrayCocheras);
        $menor = Estacionamiento:: ObtenerMenorCantidad($ArrayCocheras);
        if($mayor > 0)
        {
            $ArrayCocherasMayor = Estacionamiento::TraerLasCocherasMayor($mayor);
            $PdoST2 = $Pdo->prepare("INSERT INTO cocheras(id,Cochera,Caracteristica,Cantidad) VALUES (:id,:cochera,'Mas utilizada','$mayor')");
            foreach($ArrayCocherasMayor as $registro) 
            {	
                $PdoST2->bindParam(":id",$ID);
                $PdoST2->bindParam(":cochera",$registro->getNumero());
                $PdoST2->execute();
            }
        }
        if($menor < 10000)
        {
            $ArrayCocherasMenor = Estacionamiento::TraerLasCocherasMenor($menor);
            $PdoST3 = $Pdo->prepare("INSERT INTO cocheras(id,Cochera,Caracteristica,Cantidad) VALUES (:id,:cochera,'Menos utilizada','$menor')");
            foreach($ArrayCocherasMenor as $registro) 
            {	
                $PdoST3->bindParam(":id",$ID);
                $PdoST3->bindParam(":cochera",$registro->getNumero());
                $PdoST3->execute();
            }
        }
        if($cero)
        {
            $ArrayCocherasCero = Estacionamiento::TraerLasCocherasCero();
            $PdoST4 = $Pdo->prepare("INSERT INTO cocheras(id,Cochera,Caracteristica,Cantidad) VALUES (:id,:cochera,'No utilizada',0)");
            foreach($ArrayCocherasCero as $registro) 
            {	
                $PdoST4->bindParam(":id",$ID);
                $PdoST4->bindParam(":cochera",$registro->getNumero());
                $PdoST4->execute();
            }
        }
        Estacionamiento:: Reset($ArrayCocheras);
    }
    session_unset();
    
}
?>