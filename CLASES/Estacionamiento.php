<?php
class Estacionamiento
{
    private $Piso;
 	private $Numero;
    private $Condicion;
  	private $Estado;
	private $Cantidad;
    

    public function __construct($piso,$numero,$condicion,$estado,$cantidad)
	{
		$this->Piso = $piso;
		$this->Numero = $numero;
		$this->Condicion = $condicion;
		$this->Estado = $estado;
		$this->Cantidad = $cantidad;
    }

    //Propiedades
    public function getPiso()
    {   
        return $this->Piso;
        
    }
    public function getNumero()
    {
        return $this->Numero;
        
    }
    public function getCondicion()
    {
        return $this->Condicion;
    }
    public function getEstado()
    {
        return $this->Estado;
        
    }
	public function getCantidad()
    {
        return $this->Cantidad;
        
    }
	//Modifica el estado de las cocheras del estacionamiento, valores que puede cambiar activo/suspendido
    public static function ModificarBaseDatos($obj,$modificacion)
	{	
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
		$PdoST = $Pdo->prepare("UPDATE estacionamiento SET Estado =:estado WHERE Cochera = :numero");
		$PdoST->bindParam(":estado",$modificacion);
		$PdoST->bindParam(":numero",$obj->getNumero());
		$PdoST->execute();
	}
	//Incrementa la cantidad de veces que fue usada una cochera
	public static function IncrementarBaseDatos($obj)
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
		$PdoST = $Pdo->prepare("UPDATE estacionamiento SET Cantidad =Cantidad + 1 WHERE Cochera = :numero");
		$PdoST->bindParam(":numero",$obj->getNumero());
		$PdoST->execute();
	}
	//Retorna un listado con todas las cocheras del estacionamiento
    public static function TraerTodasLasCocheras()
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

		$PdoST = $Pdo->prepare("SELECT * FROM estacionamiento WHERE 1");

    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaCocheras[] = new Estacionamiento($registro['Piso'],$registro['Cochera'],$registro['Condicion'],$registro['Estado'],$registro['Cantidad']);
		}
		return $ListaCocheras;
	}
	//Retorna un listado con todas las cocheras mas usadas del estacionamiento
	public static function TraerLasCocherasMayor($mayor)
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

		$PdoST = $Pdo->prepare("SELECT * FROM estacionamiento WHERE Cantidad =:cantidad");
		$PdoST->bindParam(":cantidad",$mayor);
    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaCocheras[] = new Estacionamiento($registro['Piso'],$registro['Cochera'],$registro['Condicion'],$registro['Estado'],$registro['Cantidad']);
		}
		return $ListaCocheras;
	}
	//Retorna un listado con todas las cocheras menos usadas del estacionamiento
	public static function TraerLasCocherasMenor($menor)
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

		$PdoST = $Pdo->prepare("SELECT * FROM estacionamiento WHERE Cantidad =:cantidad");
		$PdoST->bindParam(":cantidad",$menor);
    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaCocheras[] = new Estacionamiento($registro['Piso'],$registro['Cochera'],$registro['Condicion'],$registro['Estado'],$registro['Cantidad']);
		}
		return $ListaCocheras;
	}
	//Retorna un listado con todas las cocheras no usadas del estacionamiento
	public static function TraerLasCocherasCero()
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

		$PdoST = $Pdo->prepare("SELECT * FROM estacionamiento WHERE Cantidad = 0");
		$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaCocheras[] = new Estacionamiento($registro['Piso'],$registro['Cochera'],$registro['Condicion'],$registro['Estado'],$registro['Cantidad']);
		}
		return $ListaCocheras;
	}
	//Devuelve true si alguna cochera no fue usada
	public static function ObtenerCantidadCero($array)
	{	
		$valor = false;
		foreach($array as $valor)
		{
			if($valor->getCantidad() == 0)
			{	
				$valor = true;
				break;
			}
		}
		return $valor;
	}
	//Devuelve el mayor numero de uso que hubo en las cocheras
	public static function ObtenerMayorCantidad($array)
	{
		$mayor = 0;
		foreach($array as $valor)
		{
			if($valor->getCantidad() > $mayor)
			{
				$mayor = $valor->getCantidad();
			}
		}
		return $mayor;
	}
	//Devuelve el menor numero de uso que hubo en las cocheras
	public static function ObtenerMenorCantidad($array)
	{
		$menor = 10000;
		foreach($array as $valor)
		{
			if($valor->getCantidad() < $menor && $valor->getCantidad() != 0)
			{
				$menor = $valor->getCantidad();
			}
		}
		return $menor;
	}
	//Devuelve el indice que corresponde a la cochera con comparta el mismo codigo
	public static function ObtenerIndice($array,$codigo)
	{	
		
		foreach($array as $valor)
		{
			if($valor->getNumero() == $codigo)
			{
				$numero = array_search($valor,$array);
				break;
			}
			$numero = -1;
		}
		return $numero;
	}
	//Al finalizar el dia resetea las cantidades de uso del estacionamiento
	public static function Reset($array)
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
		$PdoST1 = $Pdo->prepare("UPDATE estacionamiento SET Cantidad= 0 WHERE Estado = 'Disponible'");
		$PdoST1->execute();
		$PdoST2 = $Pdo->prepare("UPDATE estacionamiento SET Cantidad= 1 WHERE Estado = 'Ocupado'");
		$PdoST2->execute();
	}

}

?>