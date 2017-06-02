<?php
date_default_timezone_set ('America/Argentina/Buenos_Aires');
class Vehiculo
{
    private $Patente;
 	private $Color;
    private $Marca;
  	private $Hora;
    private $Minuto;
	private $Dia;
    private $Mes;
    private $Anio;
    private $Operacion;
    private $Pago;
    private $Cochera;

    public function __construct($patente,$color,$marca,$hora,$minuto,$dia,$mes,$anio,$operacion,$pago,$cochera)
	{
		$this->Patente = $patente;
		$this->Color = $color;
        $this->Marca = $marca;
        $this->Hora = $hora;
        $this->Minuto = $minuto;
        $this->Dia = $dia;
        $this->Mes = $mes;
        $this->Anio = $anio;
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
    public function getHora()
    {
        return $this->Hora;
    }
    public function getMinuto()
    {
        return $this->Minuto;
    }
	public function getDia()
    {
        return $this->Dia;
    }
    public function getMes()
    {
        return $this->Mes;
    }
    public function getAnio()
    {
        return $this->Anio;
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
        $PdoST = $Pdo->prepare("INSERT INTO vehiculos(Patente,Color,Marca,Hora,Minuto,Dia,Mes,Anio,Operacion,Pago,Cochera) VALUES (:patente,:color,:marca,:hora,:minuto,:dia,:mes,:anio,:operacion,:pago,:cochera)");
        $PdoST->bindParam(":patente",$obj->getPatente());
        $PdoST->bindParam(":color",$obj->getColor());
        $PdoST->bindParam(":marca",$obj->getMarca());
        $PdoST->bindParam(":dia",$obj->getDia());
        $PdoST->bindParam(":mes",$obj->getMes());
        $PdoST->bindParam(":anio",$obj->getAnio());
        $PdoST->bindParam(":hora",$obj->getHora());
        $PdoST->bindParam(":minuto",$obj->getMinuto());
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
    //Retorna un listado de todos los vehiculos que hayan ingresado y no fueran retirados
    public static function TraerTodosLosAutos()
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

		$PdoST = $Pdo->prepare("SELECT * FROM vehiculos WHERE Operacion = :operacion");
        $PdoST->bindValue(":operacion","Ingreso");
    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaVehiculos[] = new Vehiculo($registro['Patente'],$registro['Color'],$registro['Marca'],$registro["Hora"],$registro["Minuto"],$registro["Dia"],$registro["Mes"],$registro["Anio"],$registro["Operacion"],$registro['Pago'],$registro['Cochera']);
		}
		return $ListaVehiculos;
	}
    //Retorna un listado de todos los vehiculos que concuerden con la fecha
    public static function TraerAutosFiltrados($dia,$mes,$anio)
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
        
        $PdoST = $Pdo->prepare("SELECT * FROM vehiculos WHERE Dia =:dia && Mes=:mes && Anio=:anio");
        $PdoST->bindValue(":dia",$dia);
        $PdoST->bindValue(":mes",$mes);
        $PdoST->bindValue(":anio",$anio);
    	$PdoST->execute();
        $ListaVehiculos = array();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaVehiculos[] = new Vehiculo($registro['Patente'],$registro['Color'],$registro['Marca'],$registro["Hora"],$registro["Minuto"],$registro["Dia"],$registro["Mes"],$registro["Anio"],$registro["Operacion"],$registro['Pago'],$registro['Cochera']);
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
    public static function ObtenerPago($auto)
    {
        $fecha1=mktime($auto->getHora(),$auto->getMinuto(),0,$auto->getMes(),$auto->getDia(),$auto->getAnio());
        $fecha = getdate();
        $fecha2=mktime($fecha["hours"],$fecha["minutes"],0,$fecha["mon"],$fecha["mday"],$fecha["year"]);
        $segundos=$fecha2-$fecha1;
        $horas=$segundos/60/60;
        $pago = 0;
        $dias = $horas/24;
        $pago = (int)$dias * 170;
        if(($horas%24) != 0)
        {
            $horasQ = $horas%24;
            if($horasQ <12)
            {
                $pago = $pago + (int)$horasQ * 10;
                if(!is_int($horasQ))
                {
                    $pago = $pago + 10;
                }
            }
            else
            {
                $pago = $pago + ((int)$horasQ - 12) * 10 + 90;
                if(!is_int($horasQ))
                {
                    $pago = $pago + 10;
                }
            }

        }
        return $pago;

    }
}

?>