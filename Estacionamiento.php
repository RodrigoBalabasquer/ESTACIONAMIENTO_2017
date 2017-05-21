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

    

}

?>