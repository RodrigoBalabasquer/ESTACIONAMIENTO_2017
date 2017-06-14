<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once "vendor/autoload.php";
require_once ("../CLASES/Personal.php");
require_once ("../CLASES/Vehiculo.php");
require_once ("../CLASES/Estacionamiento.php");
require_once ("../CLASES/Cochera.php");

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
date_default_timezone_set ('America/Argentina/Buenos_Aires');
$app = new \Slim\App(["settings" => $config]);


//IMPLEMENTAR INSTRUCCIONES GET, POST, PUT, DELETE
//$app->METODO('/RUTEO', CALL_BACK);

$app->post('/Lista',function(Request $request, Response $response) {

    $valor = array();
    $valor = $request->getParsedBody();
    $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
    $PdoST = $Pdo->prepare("SELECT * FROM estacionamiento WHERE Estado = 'Disponible' && Piso = :piso");
    //$PdoST->bindValue(":piso",$app->request->post('valor'));
    $PdoST->bindValue(":piso",$valor['valor']);
    $PdoST->execute();
    $ListaDeEstacionamientos = array();
    foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
    {	
        $ListaDeEstacionamientos[] = new Estacionamiento($registro['Piso'],$registro['Cochera'],$registro['Condicion'],$registro['Estado']);
    }
    
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
});

$app->post('/Ocupar',function() use($app) {

    if(Vehiculo::Validar($app->request->post('patente')))
    {
        $ArrayCocheras = Estacionamiento::TraerTodasLasCocheras();
        $indice = Estacionamiento:: ObtenerIndice($ArrayCocheras,$app->request->post('numero'));
        Estacionamiento::ModificarBaseDatos($ArrayCocheras[$indice],"Ocupado");
        //Estacionamiento::IncrementarBaseDatos($ArrayCocheras[$indice]);

        $fecha = date('Y-m-d-H-i-s');
        $cochera = new Cochera($fecha,$app->request->post('numero'));
        Cochera::GuardarBaseDatos($cochera);
        $vehiculo = new Vehiculo($app->request->post('patente'),$app->request->post('color'),$app->request->post('marca'),$fecha,"Ingreso",0,$app->request->post('numero'));
        Vehiculo::GuardarBaseDatos($vehiculo);
        session_start();
        $_SESSION["Cantidad"]++;
    }
    else
    {
        echo "La patente ya fue ingresada";
    }
});

$app->post('/Retirar',function() use($app) {

    $ArrayVehiculos = Vehiculo::TraerTodosLosAutos();
    if(count($ArrayVehiculos)!=0)
    {   
        $indice = Vehiculo:: ObtenerIndice( $ArrayVehiculos,$app->request->post('patente'));
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
            $fecha = date('Y-m-d H:i:s');
            $vehiculo = new Vehiculo($ArrayVehiculos[$indice]->getPatente(),
            $ArrayVehiculos[$indice]->getColor(),$ArrayVehiculos[$indice]->getMarca(),
            $fecha,"Egreso",$Pago,$ArrayVehiculos[$indice]->getCochera());
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
    else
    {
        echo "No hay ningun vehiculo en este momento";
    }
    
    
});

$app->post('/Monitorear',function() use($app) {

    $fecha = $app->request->post('fecha');
    $vehiculos = Vehiculo::TraerAutosFiltrados($fecha);
    if(!count($vehiculos) == 0)
    {
        $valor1="Registro de autos:<br>";
        foreach($vehiculos as $vehiculo)
        {
            if($vehiculo->getOperacion() != "Egreso")
            {
                $valor1.=$vehiculo->getFecha()." ingreso un auto con la patente ".$vehiculo->getPatente().".<br>"; 
            }
            else
            {
                $valor1.=$vehiculo->getFecha()." salio un auto con la patente ".$vehiculo->getPatente()." y pago ".$vehiculo->getPago()." pesos.<br>"; 
            }
        }
        $cocheras = Estacionamiento::TraerTodasLasCocheras();
        $dia = date('Y-m-d');
        $valor1.="<br>Cocheras usadas:<br>";
        foreach($cocheras  as $cochera)
        {   
            $numero = Cochera::ObtenerCantidad($cochera->getNumero(),$dia);
            if($numero != 0)
            {
                $valor1.="Numero: ".$cochera->getNumero()." Cantidad: ".$numero."<br>";
            }
            /*if($cochera->getCaracteristica() == "Mas utilizada")
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
            }*/

        }
        echo $valor1;
    }
    else
    {
        echo "No ha habido actividad";
    }
});














//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////


$app->post('/agregar',function() use($app) {

    $contrasenia = $app->request->post('Dni');
    $p = new Personal($app->request->post('Nombre'),$app->request->post('Apellido'),$app->request->post('Dni'),
    null,$contrasenia,$app->request->post('Edad'),"Activo",0);
	if(!Personal::GuardarBaseDatos($p))
    {
        echo "Lamentablemente ocurrio un error y no se pudo ingresar el empleado.";
        echo "  <a class='btn btn-info' href='../Administrar.php'>Menu principal</a>";
    }
    else
    {
        echo "El empleado fue ingresado correctamente.";
	}
});
$app->post('/personal',function() use($app) {

    $ArrayEmpleados = Personal::TraerTodosLosEmpleados();
	$indice = Personal:: ObtenerIndice($ArrayEmpleados,$app->request->post("Legajo"));
	if(!Personal::ModificarBaseDatos($ArrayEmpleados[$indice],"Suspendido"))
    {   
        echo "No se pudo suspender al empleado";
    }
    else
    {   
        echo "Empleado suspendido exitosamente";
    }	
});
$app->put('/personal',function() use($app) {

    $ArrayEmpleados = Personal::TraerTodosLosEmpleados();
	$indice = Personal:: ObtenerIndice($ArrayEmpleados,$app->request->post("Legajo"));
	if(!Personal::ModificarBaseDatos($ArrayEmpleados[$indice],"Activo"))
    {   
        echo "No se pudo reabilitar al empleado";
    }
    else
    {   
        echo "Empleado reabilitado exitosamente";
    }		
});
$app->delete('/personal',function() use($app) {

    $ArrayEmpleados = Personal::TraerTodosLosEmpleados();
	$indice = Personal:: ObtenerIndice($ArrayEmpleados,$app->request->post("Legajo"));
	if(!Personal::ModificarBaseDatos($ArrayEmpleados[$indice],"Despedido"))
    {   
        echo "No se pudo quitar al empleado";
    }
    else
    {   
        echo "Empleado eliminado exitosamente";
    }	
});
$app->run();