<?php
class Cochera
{   
    private $Fecha;
    private $Numero;
 	
  	
    public function __construct($fecha,$numero)
	{   
        $this->Fecha = $fecha;
		$this->Numero = $numero;
	}

    //Propiedades
    public function getFecha()
    {   
        return $this->Fecha;
    }
    public function getNumero()
    {   
        return $this->Numero;
    }
    
    //Rertorna un listado de cocheras con los elementos que coincida con la fecha
    public static function TraerCocherasFiltrados($fecha)
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
        
        $PdoST = $Pdo->prepare("SELECT * FROM cocheras WHERE Fecha = :fecha");
        $PdoST->bindValue(":fecha",$fecha);
        $PdoST->execute();
        $ListaCocheras= array();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaCocheras[] = new Cochera($registro['Fecha'],$registro['Cochera']);
		}
		return $ListaCocheras;
	}
    public static function GuardarBaseDatos($obj)
	{	
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
        $PdoST = $Pdo->prepare("INSERT INTO cocheras(Fecha,Cochera) VALUES (:fecha,:cochera)");
        $PdoST->bindParam(":fecha",$obj->getFecha());
        $PdoST->bindParam(":cochera",$obj->getNumero());
        $PdoST->execute();
	}
    public static function ObtenerCantidad($numero,$dia)
	{	
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
        $PdoST = $Pdo->prepare("select COUNT(Cochera) FROM cocheras WHERE Cochera='$numero' && Fecha='$dia'");
        $PdoST->execute();
        foreach($PdoST as $cant) //devuelve los valores de la base fila por fila
		{	
			$numero = $cant[0];
		}
        return $numero;
	}
}
?>
