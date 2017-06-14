<?php
date_default_timezone_set ('America/Argentina/Buenos_Aires');
class Vehiculo
{
    private $Patente;
 	private $Color;
    private $Marca;
  	private $Fecha;
    private $Operacion;
    private $Pago;
    private $Cochera;

    public function __construct($patente,$color,$marca,$fecha,$operacion,$pago,$cochera)
	{
		$this->Patente = $patente;
		$this->Color = $color;
        $this->Marca = $marca;
        $this->Fecha = $fecha;
        $this->Operacion= $operacion;
        $this->Pago = $pago;
        $this->Cochera = $cochera;
	}

    //Propiedades
    public function getPatente()
    {   
        return $this->Patente;
    }
    public function getColor()
    {
        return $this->Color;
    }
    public function getMarca()
    {
        return $this->Marca;
    }
    
    public function getFecha()
    {
        return $this->Fecha;
    }
    public function getOperacion()
    {
        return $this->Operacion;
    }
    public function getPago()
    {
        return $this->Pago;
    }
    public function getCochera()
    {
        return $this->Cochera;
    }
    //Guarda un vehiculo en la base de datos
    public static function GuardarBaseDatos($obj)
	{	
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
        $PdoST = $Pdo->prepare("INSERT INTO vehiculos(Patente,Color,Marca,Fecha,Operacion,Pago,Cochera) VALUES (:patente,:color,:marca,:fecha,:operacion,:pago,:cochera)");
        $PdoST->bindParam(":patente",$obj->getPatente());
        $PdoST->bindParam(":color",$obj->getColor());
        $PdoST->bindParam(":marca",$obj->getMarca());
        $PdoST->bindParam(":fecha",$obj->getFecha());
        $PdoST->bindParam(":operacion",$obj->getOperacion());
        $PdoST->bindParam(":pago",$obj->getPago());
        $PdoST->bindParam(":cochera",$obj->getCochera());
        $PdoST->execute();
	}
    //Registra que un vehiculo termino su ingreso y fue retirado del estacionamiento
    public static function ModificarBaseDatos($obj,$modificacion)
	{	
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
        $PdoST = $Pdo->prepare("UPDATE vehiculos SET Operacion =:operacion WHERE Cochera = :cochera");
        $PdoST->bindParam(":operacion",$modificacion);
        $PdoST->bindParam(":cochera",$obj->getCochera());
        $PdoST->execute();
	}

    public static function Validar($patente)
	{	
		$valor=true;
		$vehiculos = Vehiculo::TraerTodosLosAutos();
        if(count($vehiculos) != 0)
        {
            foreach($vehiculos as $vehiculo)
            {
                if($vehiculo->getPatente()==$patente)
                {
                    $valor=false;
                    break;
                }
            }
        }
		return $valor;
	}
    //Retorna un listado de todos los vehiculos que hayan ingresado y no fueran retirados
    public static function TraerTodosLosAutos()
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

		$PdoST = $Pdo->prepare("SELECT * FROM vehiculos WHERE Operacion = :operacion");
        $PdoST->bindValue(":operacion","Ingreso");
    	$PdoST->execute();
        $ListaVehiculos = array();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaVehiculos[] = new Vehiculo($registro['Patente'],$registro['Color'],$registro['Marca'],$registro["Fecha"],$registro["Operacion"],$registro['Pago'],$registro['Cochera']);
		}
		return $ListaVehiculos;
	}
    //Retorna un listado de todos los vehiculos que concuerden con la fecha
    public static function TraerAutosFiltrados($fecha)
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
        
        $PdoST = $Pdo->prepare("SELECT * FROM vehiculos WHERE Fecha LIKE '$fecha%'");
        $PdoST->execute();
        $ListaVehiculos = array();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaVehiculos[] = new Vehiculo($registro['Patente'],$registro['Color'],$registro['Marca'],$registro["Fecha"],$registro["Operacion"],$registro['Pago'],$registro['Cochera']);
		}
		return $ListaVehiculos;
	}
    //Obtendo el indice del vehiculo cuya patente concuerde con el codigo
	public static function ObtenerIndice($array,$codigo)
	{	
		
		foreach($array as $valor)
		{
			if($valor->getPatente() == $codigo)
			{
				$numero = array_search($valor,$array);
				break;
			}
			$numero = -1;
		}
		return $numero;
	}
    //Retorna el valor que debe pagar al retirar el auto
    public static function ObtenerPago($vehiculo)
    {
        $fecha1 = $vehiculo->getFecha();
        $fecha2 = date('Y-m-d H:i:s');
        $segundos = abs(strtotime($fecha2) - strtotime($fecha1));
        $horas = $segundos/60/60;
        $pago=0;
        $dias = (int)($horas/24);
        $pago = $dias *170;
        $horasQ = $horas%24;
        if($horasQ <12)
        {
            $pago = $pago + (int)$horasQ * 10;
            if(!is_int($horas))
            {
                $pago = $pago + 10;
            }
        }
        else
        {
            $pago = $pago + ((int)$horasQ - 12) * 10 + 90;
            if(!is_int($horas))
            {
                $pago = $pago + 10;
            }
        }
        return $pago;

    }
}

?>