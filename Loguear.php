<?php
    
    $resultado = "NO OK";
    if($_POST['opcion'] == "Login")
    {
        $resultado = "No encontrado";
        include_once "Personal.php";
        $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
		$PdoST = $Pdo->prepare("SELECT * FROM personal WHERE 1");
    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaDePersonal[] = new Personal($registro['Nombre'],$registro['Apellido'],$registro['Legajo'],$registro['Contrasenia'],$registro['Edad']);
        }

        foreach ($ListaDePersonal as $per)
        {
            if($per->getNombre() == $_POST["Nombre"] && $per->getApellido() == $_POST["Apellido"] && $per->getContrasenia() == $_POST["PASSWORD"])
            {   
                $resultado ="Empleado";                
                if($per->getLegajo() == 1)
                {
                    $resultado = "Aministrador";
                }
                break;
            }
        }

        session_start();
        $_SESSION["Nombre"] = $_POST["Nombre"];
        $_SESSION["Apellido"] = $_POST["Apellido"];
        $_SESSION["Contraseña"] = $_POST['PASSWORD'];
    }
    
    echo $resultado;
?>