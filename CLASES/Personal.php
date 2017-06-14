<?php
class Personal
{
    private $nombre;
 	private $apellido;
	private $usuario;
    private $legajo;
	private $dni;
  	private $contraseña;
    private $edad;
	private $estado;
	private $nivel;

    public function __construct($usuario,$nombre,$apellido,$dni,$legajo=null,$contraseña,$edad,$estado,$nivel)
	{	
		$this->usuario = $usuario;
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->dni = $dni;
		$this->legajo = $legajo;
		$this->contraseña = $contraseña;
        $this->edad = $edad;
		$this->estado = $estado;
		$this->nivel = $nivel;
	}

    //Propiedades
	public function getUsuario()
    {   
        return $this->usuario;
    }
    public function getNombre()
    {   
        return $this->nombre;
    }
    public function getApellido()
    {
        return $this->apellido;
    }
	public function getDni()
    {
        return $this->dni;
    }
    public function getLegajo()
    {
        return $this->legajo;
    }
    public function getContrasenia()
    {
        return $this->contraseña;
    }
    public function getEdad()
    {
        return $this->edad;
    }
	public function getEstado()
    {
        return $this->estado;
    }
	public function getNivel()
    {
        return $this->nivel;
    }

	//Guarda un empleado en la base de datos
    public static function GuardarBaseDatos($obj)
	{	
		$valor = true;
		try
		{
			$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
			$PdoST = $Pdo->prepare("INSERT INTO personal(Legajo,Usuario,Nombre,Apellido,DNI,Contrasenia,Edad,Estado,Nivel) VALUES(null,:usuario,:nombre,:apellido,:dni,:contrasenia,:edad,:estado,:nivel)");
			$PdoST->bindParam(":usuario",$obj->getUsuario());
			$PdoST->bindParam(":nombre",$obj->getNombre());
			$PdoST->bindParam(":apellido",$obj->getApellido()); 
			$PdoST->bindParam(":dni",$obj->getDni()); 
			$PdoST->bindParam(":contrasenia",$obj->getContrasenia());
            $PdoST->bindParam(":edad",$obj->getEdad());
			$PdoST->bindParam(":estado",$obj->getEstado());
			$PdoST->bindParam(":nivel",$obj->getNivel());
			$PdoST->execute();
			
		}
		catch(Exception $e)
		{
			$valor = false;
			echo $e->getMessage();
		}
		return $valor;
	}
	//Borra un empleado en la base de datos
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
	//Permite suspender o reabilitar a un empleado en la base de datos
	public static function ModificarBaseDatos($obj,$modificacion)
	{	
		$valor = true;
		try
		{
			$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
			$PdoST = $Pdo->prepare("UPDATE personal SET Estado =:estado WHERE Legajo = :legajo");
			$PdoST->bindParam(":estado",$modificacion);
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
	//Retorna un listado con todos el personal
    public static function TraerTodosLosEmpleados()
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

		$PdoST = $Pdo->prepare("SELECT * FROM personal WHERE 1");

    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaEmpleados[] = new Personal($registro['Usuario'],$registro['Nombre'],$registro['Apellido'],$registro['DNI'],$registro['Legajo'],$registro['Contrasenia'],$registro['Edad'],$registro['Estado'],$registro['Nivel']);
		}
		return $ListaEmpleados;
	}
	public static function Validar($dni)
	{	
		$valor=true;
		$empleados = Personal::TraerTodosLosEmpleados();
		foreach($empleados as $empleado)
		{
			if($empleado->getDni()==$dni)
			{
				$valor=false;
				break;
			}
		}
		return $valor;
	}
	public static function TraerEmpleadosFiltrados($valor)
	{
		$Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");

		$PdoST = $Pdo->prepare("SELECT * FROM personal WHERE Estado = :valor && Nivel = 0");
		$PdoST->bindParam(":valor",$valor);
    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaEmpleados[] = new Personal($registro['Ususario'],$registro['Nombre'],$registro['Apellido'],$registro['DNI'],$registro['Legajo'],$registro['Contrasenia'],$registro['Edad'],$registro['Estado'],$registro['Nivel']);
		}
		return $ListaEmpleados;
	}
	//Retorna el indice del personal que comparta el codigo
	public static function ObtenerIndice($array,$codigo1)
	{	
		
		foreach($array as $valor)
		{
			if($valor->getLegajo() == $codigo1)
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