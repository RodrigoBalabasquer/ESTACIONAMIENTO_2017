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
                                            'Legajo' => array('name' => 'Legajo', 'type' => 'xsd:int')
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
			$ListaDePersonal[] = new Personal($registro['Nombre'],$registro['Apellido'],$registro['Legajo'],$registro['Contrasenia'],$registro['Edad'],$registro['Estado']);
        }
        foreach ($ListaDePersonal as $per)
        {
            if($per->getNombre() == $nombre && $per->getApellido() == $apellido && $per->getContrasenia() == $contraseña)
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
        return array('Mensaje' => $resultado,'Legajo' => $per->getLegajo());
    }
//6.- USAMOS EL PEDIDO PARA INVOCAR EL SERVICIO
	$HTTP_RAW_POST_DATA = file_get_contents("php://input");
	
	$server->service($HTTP_RAW_POST_DATA);