<?php
class Cochera
{
    private $Numero;
 	private $Caracteristica;
    private $Cantidad;
  	

    public function __construct($numero,$caracteristica,$cantidad)
	{
		$this->Numero = $numero;
		$this->Caracteristica = $caracteristica;
        $this->Cantidad = $cantidad;
    }

    //Propiedades
    public function getNumero()
    {   
        return $this->Numero;
    }
    public function getCaracteristica()
    {
        return $this->Caracteristica;
    }
    public function getCantidad()
    {
        return $this->Cantidad;
    }
    public static function TraerCocherasFiltrados($id)
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
        
        $PdoST = $Pdo->prepare("SELECT * FROM cocheras WHERE id=:id");
        $PdoST->bindValue(":id",$id);
        $PdoST->execute();
        $ListaCocheras= array();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaCocheras[] = new Cochera($registro['Cochera'],$registro['Caracteristica'],$registro['Cantidad']);
		}
		return $ListaCocheras;
	}
}
?>
