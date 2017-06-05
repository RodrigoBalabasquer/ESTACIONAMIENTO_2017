<?php 
///***********************************************************************************************///
///COMO PROVEEDOR DEL SERVICIO WEB///
///***********************************************************************************************///

//1.- INCLUIMOS LA LIBRERIA NUSOAP DENTRO DE NUESTRO ARCHIVO
	require_once('../lib/nusoap.php'); 
	
//2.- CREAMOS LA INSTACIA AL SERVIDOR
	$server = new nusoap_server(); 

//3.- INICIALIZAMOS EL SOPORTE WSDL (Web Service Description Language)
	$server->configureWSDL('Mi Web Service', 'urn:testWS'); 
	


$server->wsdl->addComplexType(
									'Retorno',
									'complexType',
									'struct',
									'all',
									'',
									array('Mensaje' => array('name' => 'Mensaje', 'type' => 'xsd:string'),
										  'Legajo' => array('name' => 'Legajo', 'type' => 'xsd:int'),
										  'Turno' => array('name' => 'Turno', 'type' => 'xsd:string'),
                                          'Nivel' => array('name' => 'Nivel', 'type' => 'xsd:int'),
										  'Dia' => array('name' => 'Dia', 'type' => 'xsd:int'),
										  'Mes' => array('name' => 'Mes', 'type' => 'xsd:int'),
										  'Anio' => array('name' => 'Anio', 'type' => 'xsd:int'),
										  'Cantidad' => array('name' => 'Cantidad', 'type' => 'xsd:int'),
										  'ID' => array('name' => 'ID', 'type' => 'xsd:string')
									)
								);


//4.- REGISTRAMOS EL METODO A EXPONER
	$server->register('Loguear',                	// METODO
				array('nombre' => 'xsd:string',
                'apellido' => 'xsd:string',
                'contraseña' => 'xsd:string'),      // PARAMETROS DE ENTRADA
				
				array('return' => 'tns:Retorno'),    			// PARAMETROS DE SALIDA
				'urn:testWS',                				// NAMESPACE
				'urn:testWS#Loguear',           			// ACCION SOAP
				'rpc',                        				// ESTILO
				'encoded',                    				// CODIFICADO
				'Loguea al usuario.'   		// DOCUMENTACION
			);
	

//5.- DEFINIMOS EL METODO COMO UNA FUNCION PHP
	function Loguear($nombre,$apellido,$contraseña) 
	{   
	 	$resultado = "No encontrado";
        include_once "../CLASES/Personal.php";
        $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
		$PdoST = $Pdo->prepare("SELECT * FROM personal WHERE 1");
    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaDePersonal[] = new Personal($registro['Nombre'],$registro['Apellido'],$registro['DNI'],$registro['Legajo'],$registro['Contrasenia'],$registro['Edad'],$registro['Estado'],$registro['Nivel']);
        }
        foreach ($ListaDePersonal as $per)
        {	
			if($per->getNombre() == $nombre && $per->getApellido() == $apellido && $per->getContrasenia() == $contraseña)
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
                    //$PdoST1->execute();
                    $ID = $Pdo->lastInsertId("empleados");
                    break;
                }
                else
                {
                    $resultado = "Suspendido";
                    break;
                }
			}
		}
        if($resultado != "Suspendido" && $resultado != "No encontrado")
        {
            	return array('Mensaje' => $resultado,'Legajo' => $per->getLegajo(),'Turno' => $turno,'Nivel' => $per->getNivel(),'Dia' =>$fecha["mday"],'Mes'=>$fecha["mon"],'Anio'=>$fecha["year"],'Cantidad'=>0,'ID'=>$ID);
	    }
        else
        {
                return array('Mensaje' => $resultado,'Legajo' => 0,'Turno' => "zx",'Nivel' => 0,'Dia' =>0,'Mes'=>0,'Anio'=>0,'Cantidad'=>0,'ID'=>"0");
        }
	}
//6.- USAMOS EL PEDIDO PARA INVOCAR EL SERVICIO
	$HTTP_RAW_POST_DATA = file_get_contents("php://input");
	
	$server->service($HTTP_RAW_POST_DATA);
