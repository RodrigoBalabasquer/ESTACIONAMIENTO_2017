<?php
class Empleado
{
    private $legajo;
  	private $turno;
    private $fecha;
    private $cantidad;
    private $nivel;
    private $id;

    public function __construct($legajo,$turno,$fecha,$id,$cantidad,$nivel)
	{
		$this->legajo = $legajo;
		$this->turno = $turno;
        $this->fecha = $fecha;
        $this->cantidad = $cantidad;
        $this->nivel = $nivel;
        $this->id = $id;
	}

    //Propiedades
    public function getLegajo()
    {
        return $this->legajo;
    }
    public function getTurno()
    {
        return $this->turno;
        
    }
    public function getFecha()
    {
        return $this->fecha;
        
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
            $DatosEmpleado = array();
            foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
            {	
                $DatosEmpleado[] = new Empleado($registro['Legajo'],$registro['Turno'],$registro['Fecha'],$registro['id'],$registro['CantidadOperaciones'],$registro['Nivel']);
            }
            return $DatosEmpleado;
    }
}

?>