<?php 
///***********************************************************************************************///
///COMO PROVEEDOR DEL SERVICIO WEB///
///***********************************************************************************************///

//1.- INCLUIMOS LA LIBRERIAS DENTRO DE NUESTRO ARCHIVO
	require_once('../lib/nusoap.php'); 
    require_once "../CLASES/Personal.php";
    require_once ("../CLASES/Empleado.php");
    //error_reporting(0);
	
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
                                          'Fecha' => array('name' => 'Fecha', 'type' => 'xsd:string'),
                                          'Nivel' => array('name' => 'Nivel', 'type' => 'xsd:int'),
										  'Cantidad' => array('name' => 'Cantidad', 'type' => 'xsd:int'),
										  'ID' => array('name' => 'ID', 'type' => 'xsd:string')
									)
								);


//4.- REGISTRAMOS EL METODO A EXPONER
	$server->register('Loguear',                	// METODO
				array('usuario' => 'xsd:string',
                'contraseña' => 'xsd:string'),      // PARAMETROS DE ENTRADA
				
				array('return' => 'tns:Retorno'),    			// PARAMETROS DE SALIDA
				'urn:testWS',                				// NAMESPACE
				'urn:testWS#Loguear',           			// ACCION SOAP
				'rpc',                        				// ESTILO
				'encoded',                    				// CODIFICADO
				'Loguea al usuario.'   		// DOCUMENTACION
			);
	$server->register('Contratar',                	// METODO
				array('Nombre' => 'xsd:string',
                'Apellido' => 'xsd:string',
                'Dni' => 'xsd:string',
                'Edad' => 'xsd:string'),      // PARAMETROS DE ENTRADA
				
				array('return' => 'xsd:string'),    			// PARAMETROS DE SALIDA
				'urn:testWS',                				// NAMESPACE
				'urn:testWS#Contratar',           			// ACCION SOAP
				'rpc',                        				// ESTILO
				'encoded',                    				// CODIFICADO
				'Agrega un usuario.'   		// DOCUMENTACION
			);
    $server->register('Suspender',                	// METODO
				array('Legajo' => 'xsd:string'),      // PARAMETROS DE ENTRADA
				
				array('return' => 'xsd:string'),    			// PARAMETROS DE SALIDA
				'urn:testWS',                				// NAMESPACE
				'urn:testWS#Suspender',           			// ACCION SOAP
				'rpc',                        				// ESTILO
				'encoded',                    				// CODIFICADO
				'Suspende a un usuario.'   		// DOCUMENTACION
			);
    $server->register('Reabilitar',                	// METODO
                array('Legajo' => 'xsd:string'),      // PARAMETROS DE ENTRADA
                
                array('return' => 'xsd:string'),    			// PARAMETROS DE SALIDA
                'urn:testWS',                				// NAMESPACE
                'urn:testWS#Reabilitar',           			// ACCION SOAP
                'rpc',                        				// ESTILO
                'encoded',                    				// CODIFICADO
                'Reabilita a un usuario.'   		// DOCUMENTACION
            );
    $server->register('Despedir',                	// METODO
                array('Legajo' => 'xsd:string'),      // PARAMETROS DE ENTRADA
                
                array('return' => 'xsd:string'),    			// PARAMETROS DE SALIDA
                'urn:testWS',                				// NAMESPACE
                'urn:testWS#Despedir',           			// ACCION SOAP
                'rpc',                        				// ESTILO
                'encoded',                    				// CODIFICADO
                'Despide a un usuario.'   		// DOCUMENTACION
    );
    $server->register('Listar',                	// METODO
                array('Legajo' => 'xsd:string'),      // PARAMETROS DE ENTRADA
                
                array('return' => 'xsd:string'),    			// PARAMETROS DE SALIDA
                'urn:testWS',                				// NAMESPACE
                'urn:testWS#Listar',           			// ACCION SOAP
                'rpc',                        				// ESTILO
                'encoded',                    				// CODIFICADO
                'Despide a un usuario.'   		// DOCUMENTACION
    );

//5.- DEFINIMOS EL METODO COMO UNA FUNCION PHP
	function Loguear($usuario,$contraseña) 
	{   
	 	$resultado = "No encontrado";
        $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
		$PdoST = $Pdo->prepare("SELECT * FROM personal WHERE 1");
    	$PdoST->execute();
		foreach($PdoST as $registro) //devuelve los valores de la base fila por fila
		{	
			$ListaDePersonal[] = new Personal($registro['Usuario'],$registro['Nombre'],$registro['Apellido'],$registro['DNI'],$registro['Legajo'],$registro['Contrasenia'],$registro['Edad'],$registro['Estado'],$registro['Nivel']);
        }
        foreach ($ListaDePersonal as $per)
        {	
			if($per->getUsuario() == $usuario && $per->getContrasenia() == $contraseña)
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
                    $PdoST1 = $Pdo->prepare("INSERT INTO empleados(Legajo,Turno,Fecha,CantidadOperaciones,id,Nivel) VALUES (:legajo,:turno,:fecha,:oper,null,:nivel)");
                    
                    $PdoST1->bindParam(":legajo",$per->getLegajo());
                    $Horario = getdate();
                    $fecha = date('Y-m-d-H-i-s');
                    $PdoST1->bindParam(":fecha",$fecha);
                    $PdoST1->bindValue(":oper",0);
                    $turno = "";
                    if($Horario["hours"] >= 6 && $Horario["hours"] <12)
                    {   
                        $turno = "mañana";
                        $PdoST1->bindParam(":turno",$turno);
                    }
                    if($Horario["hours"] >= 12 && $Horario["hours"] <19)
                    {   
                        $turno = "tarde";
                        $PdoST1->bindParam(":turno",$turno);
                    }
                    if($Horario["hours"] >= 19 || $Horario["hours"] <6)
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
                    break;
                }
                else
                {   
                    if($per->getEstado() == "Suspendido")
                    {
                        $resultado = "Suspendido";
                        break;
                    }
                    else
                    {
                        $resultado = "Despedido";
                        break;
                    }
                    
                }
			}
		}
        if($resultado != "Despedido" && $resultado != "Suspendido" && $resultado != "No encontrado")
        {
                return array('Mensaje' => $resultado,'Legajo' => $per->getLegajo(),'Turno' => $turno,'Fecha' => $fecha,'Nivel' => $per->getNivel(),'Cantidad'=>0,'ID'=>$ID);
	    }
        else
        {
                return array('Mensaje' => $resultado,'Legajo' => 0,'Turno' => "zx",'Fecha' => "0000-00-00",'Nivel' => 0,'Cantidad'=>0,'ID'=>"0");
        }
	}
    function Contratar($Nombre,$Apellido,$Dni,$Edad)
    {
        $contrasenia = $Dni;
        $usuario = $Dni;
        if(Personal::Validar($Dni))
        {
            $p = new Personal($usuario,$Nombre,$Apellido,$Dni,null,$contrasenia,$Edad,"Activo",0);
            if(!Personal::GuardarBaseDatos($p))
            {
                return "Lamentablemente ocurrio un error y no se pudo ingresar el empleado.";
            }
            else
            {
                return "El empleado fue ingresado correctamente.";
            }
        }
        else
        {
            return "El dni ya fue ingresado anteriormente";
        }
        
    }
    //Cambia el estado del empleado que coincida con el legajo ingresado a suspendido
    function Suspender($Legajo)
    {
        $ArrayEmpleados = Personal::TraerTodosLosEmpleados();
        $indice = Personal:: ObtenerIndice($ArrayEmpleados,$Legajo);
        if($indice == -1)
        {
            $mensaje = "No se encuentra el empleado";
            return $mensaje;
        }
        else
        {	
            if($ArrayEmpleados[$indice]->getEstado() == 'Activo')
            {
                Personal::ModificarBaseDatos($ArrayEmpleados[$indice],"Suspendido");
                return 'Empleado Suspendido';
            }
            else
            {
                return 'El empleado '.$ArrayEmpleados[$indice]->getNombre().' no se encuentra operando actualmente';
            }
        }
    }
    function Reabilitar($Legajo)
    {
        $ArrayEmpleados = Personal::TraerTodosLosEmpleados();
        $indice = Personal:: ObtenerIndice($ArrayEmpleados,$Legajo);
        if($indice == -1)
        {
            $mensaje = "No se encuentra el empleado";
            return $mensaje;
        }
        else
        {	
            if($ArrayEmpleados[$indice]->getEstado() == 'Suspendido')
            {
                Personal::ModificarBaseDatos($ArrayEmpleados[$indice],"Activo");
                return 'Empleado Reabilitado';
            }
            else
            {   
                if($ArrayEmpleados[$indice]->getEstado() == 'Despedido')
                {
                    return 'El empleado '.$ArrayEmpleados[$indice]->getNombre().' no trabaja aqui actualmente';
                }
                else
                {
                    return 'El empleado '.$ArrayEmpleados[$indice]->getNombre().' ya estaba activo actualmente';
                }
            }
        }
    }
    function Despedir($Legajo)
    {
        $ArrayEmpleados = Personal::TraerTodosLosEmpleados();
        $indice = Personal:: ObtenerIndice($ArrayEmpleados,$Legajo);
        if($indice == -1)
        {
            $mensaje = "No se encuentra el empleado";
            return $mensaje;
        }
        else
        {	
            if($ArrayEmpleados[$indice]->getEstado() != 'Despedido')
            {
                Personal::ModificarBaseDatos($ArrayEmpleados[$indice],"Despedido");
                return 'Empleado Despedido';
            }
            else
            {   
                return 'El empleado '.$ArrayEmpleados[$indice]->getNombre().' ya estaba despedido';
            }
        }
    }
    function Listar($Legajo)
    {
        $ArrayEmpleados = Personal::TraerTodosLosEmpleados();
        $indice = Personal:: ObtenerIndice($ArrayEmpleados,$Legajo);
        if($indice == -1)
        {
            $mensaje = "No se encuentra el empleado";
            
        }
        else
        {	
            $datosEmpleado = Empleado:: ObtenerDatosEmpleado($ArrayEmpleados[$indice]->getLegajo());
            if(count($datosEmpleado)!=0)
            {
                $mensaje ="El empleado ".$ArrayEmpleados[$indice]->getNombre()." ".$ArrayEmpleados[$indice]->getApellido()." se conecto los siguientes dias:<br>";
                foreach($datosEmpleado as $dato)
                {
                    $mensaje.= $dato->getFecha()." y realizo ".$dato->getCantidad()." operaciones<br>";
                }
                $mensaje.="Actualmente se encuentra ".$ArrayEmpleados[$indice]->getEstado();
            }
            else
            {
                $mensaje = "El empleado ".$ArrayEmpleados[$indice]->getNombre()." ".$ArrayEmpleados[$indice]->getApellido()." nunca se a logueado.<br>";
                $mensaje.="Actualmente se encuentra ".$ArrayEmpleados[$indice]->getEstado();
            }
        }
        return $mensaje;
    }
//6.- USAMOS EL PEDIDO PARA INVOCAR EL SERVICIO
	$HTTP_RAW_POST_DATA = file_get_contents("php://input");
	
	$server->service($HTTP_RAW_POST_DATA);
