<?php
require_once ("../Estacionamiento.php");
if($_POST["opcion"] == "Lugares")
{
    $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
    $PdoST = $Pdo->prepare("SELECT * FROM estacionamiento WHERE Estado = 'Disponible'");
    $PdoST->execute();
    $ListaDeEstacionamientos = array();
    foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
    {	
        $ListaDeEstacionamientos[] = new Estacionamiento($registro['Piso'],$registro['Cochera'],$registro['Condicion'],$registro['Estado']);
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
    $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
    $PdoST1 = $Pdo->prepare("UPDATE estacionamiento SET Estado='Ocupado' WHERE Cochera = :numero");
    $PdoST1->bindParam(":numero",$_POST['numero']);
    $PdoST2 = $Pdo->prepare("INSERT INTO Vehiculos(Patente,Color,Marca,Hora,Minuto,Dia,Mes,Anio) VALUES (:patente,:color,:marca,:hora,:minuto,:dia,:mes,:anio)");
    $PdoST2->bindParam(":patente",$_POST['patente']);
    $PdoST2->bindParam(":color",$_POST['color']);
    $PdoST2->bindParam(":marca",$_POST['marca']);
    $fecha = getdate();
    $PdoST2->bindParam(":dia",$fecha["mday"]);
    $PdoST2->bindParam(":mes",$fecha["mon"]);
    $PdoST2->bindParam(":anio",$fecha["year"]);
    $PdoST2->bindParam(":hora",$fecha["hours"]);
    $PdoST2->bindParam(":minuto",$fecha["minutes"]);
    
    $PdoST1->execute();
    $PdoST2->execute();

}

?>