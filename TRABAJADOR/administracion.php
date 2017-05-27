<?php
require_once ("../CLASES/Estacionamiento.php");
require_once ("../CLASES/Vehiculo.php");
require_once ("../CLASES/Empleado.php");
date_default_timezone_set ('America/Argentina/Buenos_Aires');
if($_POST["opcion"] == "Lugares")
{
    $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
    $PdoST = $Pdo->prepare("SELECT * FROM estacionamiento WHERE Estado = 'Disponible'");
    $PdoST->execute();
    $ListaDeEstacionamientos = array();
    foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
    {	
        $ListaDeEstacionamientos[] = new Estacionamiento($registro['Piso'],$registro['Cochera'],$registro['Condicion'],$registro['Estado'],$registro['Cantidad']);
    }
    
    
   

    echo    '<div class="CajaInicio animated bounceInRight">
			<input type="text" id="Color" placeholder="Ingrese color"/>
			<input type="text" id="Patente" placeholder="Ingrese patente"/>
			<input type="text" id="Marca" placeholder="Ingrese marca"/>
			</div>';
    echo "<a href='#' class='list-group-item active'>Lugares disponibles</a>"; 	
    foreach ($ListaDeEstacionamientos as $cont)
    {
        $piso = $cont->getPiso();
        $numero = $cont->getNumero();
        if($cont->getCondicion() != "NORMAL")
        {
            echo "<a onclick=aceptar('$numero') class='list-group-item list-group-item-danger'>Planta $piso Estacionamiento $numero Solo para discapacitados o Embarazadas</a>";
        }   
        else
        {
            echo "<a onclick=aceptar('$numero') class='list-group-item list-group-item-info'>Planta $piso Estacionamiento $numero </a>";
        }
        
    }	
}
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