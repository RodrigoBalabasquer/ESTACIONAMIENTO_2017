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
    function ObtenerDatosEmpleado($legajo)
    {
            $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

            $PdoST = $Pdo->prepare("SELECT * FROM empleados WHERE Legajo = :legajo");
            $PdoST->bindParam(":legajo",$legajo);
            $PdoST->execute();
            foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
            {	
                $DatosEmpleado[] = new Empleado($registro['Nombre'],$registro['Apellido'],$registro['Legajo'],$registro['Turno'],$registro['Dia'],$registro['Mes'],$registro['Anio'],$registro['CantidadOperaciones'],$registro['Nivel']);
            }
            return $DatosEmpleado;
    }
    function VerificarOperaciones($legajo)
    {
            $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

            $PdoST = $Pdo->prepare("SELECT * FROM empleados WHERE 1");
            $PdoST->execute();
            foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
            {	
                $DatosEmpleado[] = new Empleado($registro['Nombre'],$registro['Apellido'],$registro['Legajo'],$registro['Turno'],$registro['Dia'],$registro['Mes'],$registro['Anio'],$registro['CantidadOperaciones'],$registro['Nivel']);
            }
            $retorno = false;
            foreach($DatosEmpleado as $valor)
            {
                if($valor->getLegajo() == $legajo)
                {
                    $retorno = true;
                    break;
                }
            }
            return $retorno;
    }
}

?>