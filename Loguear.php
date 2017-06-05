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
			$ListaDePersonal[] = new Personal($registro['Nombre'],$registro['Apellido'],$registro['DNI'],$registro['Legajo'],$registro['Contrasenia'],$registro['Edad'],$registro['Estado'],$registro['Nivel']);
        }
        session_start();
        foreach ($ListaDePersonal as $per)
        {
            if($per->getNombre() == $_POST["Nombre"] && $per->getApellido() == $_POST["Apellido"] && $per->getContrasenia() == $_POST["PASSWORD"])
            {   
                if($per->getEstado() == "Activo")
                {
                    if($per->getNivel() == 1)
                    {
                        $resultado = "Aministrador";
                    }
                    else
                    {
                        $resultado ="Empleado";                
                    }
                    date_default_timezone_set ('America/Argentina/Buenos_Aires');
                    $PdoST1 = $Pdo->prepare("INSERT INTO empleados(Legajo,Nombre,Apellido,Turno,Dia,Mes,Anio,CantidadOperaciones,id,Nivel) VALUES (:legajo,:nombre,:apellido,:turno,:dia,:mes,:anio,:oper,null,:nivel)");
                    
                    $PdoST1->bindParam(":legajo",$per->getLegajo());
                    $PdoST1->bindParam(":nombre",$per->getNombre());
                    $PdoST1->bindParam(":apellido",$per->getApellido()); 
                    $fecha = getdate();
                    $PdoST1->bindParam(":dia",$fecha["mday"]);
                    $PdoST1->bindParam(":mes",$fecha["mon"]);
                    $PdoST1->bindParam(":anio",$fecha["year"]);
                    $PdoST1->bindValue(":oper",0);
                    $turno = "";
                    if($fecha["hours"] >= 6 && $fecha["hours"] <12)
                    {   
                        $turno = "mañana";
                        $PdoST1->bindParam(":turno",$turno);
                    }
                    if($fecha["hours"] >= 12 && $fecha["hours"] <19)
                    {   
                        $turno = "tarde";
                        $PdoST1->bindParam(":turno",$turno);
                    }
                    if($fecha["hours"] >= 19 || $fecha["hours"] <6)
                    {   
                        $turno = "noche";
                        $PdoST1->bindParam(":turno",$turno);
                    }
                    if($resultado == "Aministrador")
                    {
                        $PdoST1->bindParam(":nivel",$per->getNivel());
                    }
                    else
                    {
                        $PdoST1->bindParam(":nivel",$per->getNivel());
                    }
                    $PdoST1->execute();
                    $ID = $Pdo->lastInsertId("empleados");
                    $_SESSION["Turno"] = $turno;
                    $_SESSION["Dia"] = $fecha["mday"];
                    $_SESSION["Mes"] = $fecha["mon"];
                    $_SESSION["Anio"] = $fecha["year"];
                    $_SESSION["Cantidad"] = 0;
                    $_SESSION["Id"] = (int)$ID;
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
            $_SESSION["Nombre"] = $_POST["Nombre"];
            $_SESSION["Apellido"] = $_POST["Apellido"];
            $_SESSION["Contraseña"] = $_POST['PASSWORD'];
            $_SESSION["Legajo"] = $per->getLegajo();
            $_SESSION["Nivel"] =$per->getNivel();
        }
        echo $resultado;
    }
    
    
?>