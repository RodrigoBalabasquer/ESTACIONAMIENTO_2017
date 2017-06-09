<?php
class Fecha
{
    private $id;
 	private $dia;
	private $mes;
    private $anio;
    
    public function __construct($id,$dia,$mes,$anio)
	{
		$this->id = $id;
        $this->dia = $dia;
		$this->mes = $mes;
        $this->anio = $anio;
    }

    //Propiedades
    public function getId()
    {   
        return $this->id;
    }
    public function getDia()
    {
        return $this->dia;
    }
	public function getMes()
    {
        return $this->mes;
    }
    public function getAnio()
    {
        return $this->anio;
    }
    
    
    function ObtenerId($dia,$mes,$anio)
    {
            $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

            $PdoST = $Pdo->prepare("SELECT * FROM fechas WHERE 1");
            $PdoST->execute();
            foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
            {	
                $DatosEmpleado[] = new Fecha($registro['id'],$registro['Dia'],$registro['Mes'],$registro['Anio']);
            }
            $id = -1;
            foreach($DatosEmpleado as $valor)
            {
                if($valor->getDia() == $dia && $valor->getMes() == $mes && $valor->getAnio() == $anio)
                {
                    $id  = $valor->getId();
                    break;
                }
            }
            return $id;
    }
    
}

?>