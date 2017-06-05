<?php
class Empleado
{
    private $nombre;
 	private $apellido;
    private $legajo;
  	private $turno;
    private $dia;
	private $mes;
    private $anio;
    private $cantidad;
    private $nivel;

    public function __construct($nombre,$apellido,$legajo,$turno,$dia,$mes,$anio,$cantidad,$nivel)
	{
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->legajo = $legajo;
		$this->turno = $turno;
        $this->dia = $dia;
		$this->mes = $mes;
        $this->anio = $anio;
        $this->cantidad = $cantidad;
        $this->nivel = $nivel;
	}

    //Propiedades
    public function getNombre()
    {   
        return $this->nombre;
    }
    public function getApellido()
    {
        return $this->apellido;
    }
    public function getLegajo()
    {
        return $this->legajo;
    }
    public function getTurno()
    {
        return $this->turno;
        
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
    public function getCantidad()
    {
        return $this->cantidad;
    }
    public function getNivel()
    {
        return $this->nivel;
    }
    

}

?>