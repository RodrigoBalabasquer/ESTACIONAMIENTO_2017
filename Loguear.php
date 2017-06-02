<?php
    
    //Busca que haya un personal que coincida con los datos ingresados y devuelve el valor correcto
    if($_POST['opcion'] == "Login")
    {
        $resultado = "No encontrado";
        include_once "CLASES/Personal.php";
        $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
		$PdoST = $Pdo->prepare("SELECT * FROM personal WHERE 1");
    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaDePersonal[] = new Personal($registro['Nombre'],$registro['Apellido'],$registro['Legajo'],$registro['Contrasenia'],$registro['Edad'],$registro['Estado']);
        }

        foreach ($ListaDePersonal as $per)
        {
            if($per->getNombre() == $_POST["Nombre"] && $per->getApellido() == $_POST["Apellido"] && $per->getContrasenia() == $_POST["PASSWORD"])
            {   
                if($per->getEstado() == "Activo")
                {
                    $resultado ="Empleado";                
                    if($per->getLegajo() == 1)
                    {
                        $resultado = "Aministrador";
                    }
                    break;
                }
                else
                {
                    $resultado = "Suspendido";
                    break;
                }
            }
        }
        if($resultado != "No encontrado" && $resultado != "Suspendido")
        {
            session_start();
            $_SESSION["Nombre"] = $_POST["Nombre"];
            $_SESSION["Apellido"] = $_POST["Apellido"];
            $_SESSION["Contraseña"] = $_POST['PASSWORD'];
            $_SESSION["Legajo"] = $per->getLegajo();
        }
    }
    
    echo $resultado;
?>