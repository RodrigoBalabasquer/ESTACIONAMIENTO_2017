<?php
class Personal
{
    private $nombre;
 	private $apellido;
    private $legajo;
  	private $contraseña;
    private $edad;

    public function __construct($nombre,$apellido,$legajo=null,$contraseña,$edad)
	{
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->legajo = $legajo;
		$this->contraseña = $contraseña;
        $this->edad = $edad;
	}

    //Propiedades
    public function getNombre()
    {   
        if($this->nombre =="")
        {
            return null;
        }
        else
        {
            return $this->nombre;
        }
    }
    public function getApellido()
    {
        if($this->apellido =="")
        {
            return null;
        }
        else
        {
            return $this->apellido;
        }
    }
    public function getLegajo()
    {
        return $this->legajo;
    }
    public function getContrasenia()
    {
        if($this->contraseña =="")
        {
            return null;
        }
        else
        {
            return $this->contraseña;
        }
    }
    public function getEdad()
    {
        if($this->edad <18)
        {
            return null;
        }
        else
        {
            return $this->edad;
        }
    }

    public static function GuardarBaseDatos($obj)
	{	
		$valor = true;
		try
		{
			$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
			$PdoST = $Pdo->prepare("INSERT INTO personal(Legajo,Nombre,Apellido,Contrasenia,Edad) VALUES(null,:nombre,:apellido,:contrasenia,:edad)");
			$PdoST->bindParam(":nombre",$obj->getNombre());
			$PdoST->bindParam(":apellido",$obj->getApellido()); 
			$PdoST->bindParam(":contrasenia",$obj->getContrasenia());
            $PdoST->bindParam(":edad",$obj->getEdad());
			$PdoST->execute();
			
		}
		catch(Exception $e)
		{
			$valor = false;
			echo $e->getMessage();
		}
		return $valor;
	}
    public static function BorrarBaseDatos($obj)
	{	
		$valor = true;
		try
		{
			$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
			$PdoST = $Pdo->prepare("DELETE FROM personal WHERE  Legajo = :legajo");
			$PdoST->bindParam(":legajo",$obj->getLegajo());
			$PdoST->execute();
		}
		catch(Exception $e)
		{
			$valor = false;
			echo $e->getMessage();
		}
		return $valor;
	}
    public static function TraerTodosLosEmpleados()
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

		$PdoST = $Pdo->prepare("SELECT * FROM personal WHERE 1");

    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaEmpleados[] = new Personal($registro['Nombre'],$registro['Apellido'],$registro['Legajo'],$registro['Contrasenia'],$registro['Edad']);
		}
		return $ListaEmpleados;
	}

	public static function ObtenerIndice($array,$codigo)
	{	
		
		foreach($array as $valor)
		{
			if($valor->getLegajo() == $codigo)
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