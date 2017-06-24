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

//Muestra todas las cocheras disponibles
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
    if(!count($ListaDeEstacionamientos)==0)
    {
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
    }
    else
    {
        echo"<h1>No hay lugar disponible</h1>";
    }	
});

//Ingresa vehiculo y actualiza la tabla de estacionamineto
$app->post('/Ocupar[/]',function(Request $request, Response $response) {
    $valor = array();
    $valor = $request->getParsedBody();
    if(Vehiculo::Validar($valor['patente']))
    {
        $destino="../fotos/";
        $archivos = $request->getUploadedFiles();
        
        $esImagen = getimagesize($_FILES["foto"]["tmp_name"]);
        if($esImagen === FALSE) 
        {
            echo "<h2>NO HA INGRESADO UNA FOTO</h2>";
        }
        else
        {   
            $ArrayCocheras = Estacionamiento::TraerTodasLasCocheras();
            $indice = Estacionamiento:: ObtenerIndice($ArrayCocheras,$valor['numero']);
            Estacionamiento::ModificarBaseDatos($ArrayCocheras[$indice],"Ocupado");

            $nombreAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $nombreAnterior)  ;
            //var_dump($nombreAnterior);
            $extension=array_reverse($extension);
            $archivos['foto']->moveTo($destino.$valor['patente'].".".$extension[0]);

            $fecha = date('Y-m-d-H-i-s');
            $cochera = new Cochera($fecha,$valor['numero']);
            Cochera::GuardarBaseDatos($cochera);
            $vehiculo = new Vehiculo($valor['patente'],$valor['color'],$valor['marca'],$fecha,"Ingreso",0,$valor['numero'],$valor['patente'].".".$extension[0]);
            Vehiculo::GuardarBaseDatos($vehiculo);
            
            session_start();
            $_SESSION["Cantidad"]++;
            if($_SESSION["Nivel"] == 1)
            {
                echo 'A';
            }
            if($_SESSION["Nivel"] == 0)
            {
                echo 'B';
            }
        }
    }
    else
    {
        echo "C";
    }
});

//Ingresa retira y actualiza la tabla de estacionamineto
$app->post('/Retirar',function(Request $request, Response $response) {

    $valor = array();
    $valor = $request->getParsedBody();
    $ArrayVehiculos = Vehiculo::TraerTodosLosAutos();
    if(count($ArrayVehiculos)!=0)
    {   
        $indice = Vehiculo:: ObtenerIndice( $ArrayVehiculos,$valor['patente']);
        if($indice == -1)
	    {
            $mensaje = "<br><h2>La patente que ingreso no se encuentra</h2>";
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
            $fecha,"Egreso",$Pago,$ArrayVehiculos[$indice]->getCochera(),$ArrayVehiculos[$indice]->getFoto());
            Vehiculo::GuardarBaseDatos($vehiculo);
            $ArrayCocheras = Estacionamiento::TraerTodasLasCocheras();
            $indice = Estacionamiento:: ObtenerIndice($ArrayCocheras,$ArrayVehiculos[$indice]->getCochera());
            Estacionamiento::ModificarBaseDatos($ArrayCocheras[$indice],"Disponible");
            $foto = $vehiculo->getFoto();
            $Tabla ="<table class='table' border='1'>
                <caption>Datos del vehiculo</caption>
                <thead>
                    <tr>
                        <th>  Marca </th>
                        <th>  Patente</th>
                        <th>  Color</th>
                        <th>  Pago</th>
                        <th>  Foto</th>
                     </tr> 
                </thead>
                    <tr>
                        <td>".$vehiculo->getMarca()."</td>
                        <td>".$vehiculo->getPatente()."</td>
                        <td>".$vehiculo->getColor()."</td>
                        <td>".$vehiculo->getPago()."</td>
                        <th><img class='media-object' src='../fotos/$foto' width='64' height='64' alt='Generic placeholder image' ></th>
                     </tr>
                     </table>";
            echo $Tabla;
         }
    }
    else
    {
        echo "<br><h2>No hay ningun vehiculo en este momento</h2>";
    }
    
    
});

//Muestra tablas con las actividades del dia ingresado
$app->post('/Monitorear',function(Request $request, Response $response) {

    $valor = array();
    $valor = $request->getParsedBody();

    $fecha = $valor['fecha'];
    $vehiculos = Vehiculo::TraerAutosFiltrados($fecha);
    if(!count($vehiculos) == 0)
    {
        $valor1="<h2>Registro de autos:</h2><br>";
        $Tabla1 ="<table class='table' border='1'>
                <caption>Ingresos</caption>
                <thead>
                    <tr>
                        <th>  Fecha </th>
                        <th>  Marca </th>
                        <th>  Patente</th>
                        <th>  Color</th>
                        <th>  Foto</th>
                     </tr> 
                </thead>";
        $Tabla2 ="<table class='table' border='1'>
                <caption>Retiros</caption>
                <thead>
                    <tr>
                        <th>  Fecha </th>
                        <th>  Marca </th>
                        <th>  Patente</th>
                        <th>  Color</th>
                        <th>  Pago</th>
                        <th>  Foto</th>
                     </tr> 
                </thead>";
        foreach($vehiculos as $vehiculo)
        {
            $foto = $vehiculo->getFoto();
            if($vehiculo->getOperacion() != "Egreso")
            {   
                
                $Tabla1 .="<tr>
                        <td>".$vehiculo->getFecha()."</td>
                        <td>".$vehiculo->getMarca()."</td>
                        <td>".$vehiculo->getPatente()."</td>
                        <td>".$vehiculo->getColor()."</td>
                        <th><img class='media-object' src='../fotos/$foto' width='64' height='64' alt='Generic placeholder image' ></th>
                     </tr>";
            }
            else
            {
                $Tabla2 .="<tr>
                        <td>".$vehiculo->getFecha()."</td>
                        <td>".$vehiculo->getMarca()."</td>
                        <td>".$vehiculo->getPatente()."</td>
                        <td>".$vehiculo->getColor()."</td>
                        <td>".$vehiculo->getPago()."</td>
                        <th><img class='media-object' src='../fotos/$foto' width='64' height='64' alt='Generic placeholder image' ></th>
                    </tr>";
            }
        }
        $Tabla1.="</table>";
        $Tabla2.="</table>";
        $valor1.=$Tabla1."<br>".$Tabla2;

        $cocheras = Estacionamiento::TraerTodasLasCocheras();
        $valor1.="<br><h2>Cocheras usadas:</h2><br>";
        $Tabla3 ="<table class='table' border='1'>
                <caption>Cocheras</caption>
                <thead>
                    <tr>
                        <th>  Numero </th>
                        <th>  Cantidad usada </th>
                    </tr> 
                </thead>";
                
        foreach($cocheras  as $cochera)
        {   
            $numero = Cochera::ObtenerCantidad($cochera->getNumero(),$fecha);
            if($numero != 0)
            {
                $Tabla3 .="<tr>
                    <td>".$cochera->getNumero()."</td>
                    <td>".$numero."</td>
                    </tr>";
            }
        }
        $Tabla3.="</table>";
        $valor1.=$Tabla3;
        echo $valor1;
    }
    else
    {
        echo "<h2>No ha habido actividad</h2>";
    }
});



$app->run();