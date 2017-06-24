<?php
class Estacionamiento
{
    private $Piso;
 	private $Numero;
    private $Condicion;
  	private $Estado;
	
    

    public function __construct($piso,$numero,$condicion,$estado)
	{
		$this->Piso = $piso;
		$this->Numero = $numero;
		$this->Condicion = $condicion;
		$this->Estado = $estado;
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
	
	//Modifica el estado de las cocheras del estacionamiento, valores que puede cambiar activo/suspendido
    public static function ModificarBaseDatos($obj,$modificacion)
	{	
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
		$PdoST = $Pdo->prepare("UPDATE estacionamiento SET Estado =:estado WHERE Cochera = :numero");
		$PdoST->bindParam(":estado",$modificacion);
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
			$ListaCocheras[] = new Estacionamiento($registro['Piso'],$registro['Cochera'],$registro['Condicion'],$registro['Estado']);
		}
		return $ListaCocheras;
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
}

?>