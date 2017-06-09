<!doctype html>
<html>
<head>
	<title>ALTA de EMPLEADOS</title>
	  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script type="text/javascript">
			/*window.onload = function()
			{
				var formulario = document.getElementById('formulario');
				var boton_enviar = document.getElementById('submit');
				boton_enviar.onclick = function()
					{
						if(formulario.checkValidity())
						{
							var opcion = "Agregar";
							var contrasenia = $("#dni").val();
							$.ajax(
							{
								type: 'POST',
								url: '../API-REST/ApiRest.php/agregar',
								dataType: 'text',
								data:"Nombre="+$("#nombre").val()+"&PASSWORD="+contrasenia+"&Apellido="+$("#apellido").val()+"&Edad="+$("#edad").val()+"&Dni="+$("#dni").val()+"&opcion="+opcion,
								async:true
							})
							.done(function(resultado)
							{	
								$("#div").html(resultado);
								
							})
							.fail(function (jqXHR, textStatus, errorThrown)
							{
								alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
							});
						}
					}
			}*/
			
		</script>
 </head>
<body>
	<a class="btn btn-info" href="../Administrar.php">Menu principal</a>

	<div class="container">
	
		<div class="page-header">
			<h1>Ingreso de Empleados</h1>      
		</div>
		<form action="alta.php" method="post" >
		<div class="CajaInicio animated bounceInRight">
		<!--<form id="formulario" action="" method="post" onsubmit="return false;">-->
			<input type="text" class="form-control" name="Nombre" id="nombre" placeholder="Ingrese nombre" required/>
			<br>
			<input type="text" class="form-control" name="Apellido" id="apellido" placeholder="Ingrese apellido" required/>
			<br>
			<input type="text" class="form-control" name="Dni" id="dni" minlength="7" maxlength="8" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" placeholder="Ingrese DNI" required/>
			<br>
			<input type="text" class="form-control" name="Edad" id="edad" placeholder="Ingrese edad" required/>
			<br>
			<!--<input type="button" class="btn btn-primary" value="Agregar" onclick="guardar()" />-->
			<input type="submit" class="btn btn-primary" name="Ingresar" value="Agregar" id="submit"/>
		</form>

		<?php
        ///***********************************************************************************************///
        ///COMO CLIENTE DEL SERVICIO WEB///
        ///***********************************************************************************************///
                
        //1.- INCLUIMOS LA LIBRERIA NUSOAP DENTRO DE NUESTRO ARCHIVO
                require_once('../lib/nusoap.php');

        //2.- INDICAMOS URL DEL WEB SERVICE
                $host = 'http://localhost/TP-Estacionamiento/SERVIDOR/servidor.php';
                
        //3.- CREAMOS LA INSTANCIA COMO CLIENTE
                $client = new nusoap_client($host . '?wsdl');

        //3.- CHECKEAMOS POSIBLES ERRORES AL INSTANCIAR
                $err = $client->getError();
                if ($err) 
                {
                    echo '<h2>ERROR EN LA CONSTRUCCION DEL WS:</h2><pre>' . $err . '</pre>';
                    die();
                }

        //4.- INVOCAMOS AL METODO SOAP, PASANDOLE EL PARAMETRO DE ENTRADA
                $result = array();
                if(isset($_POST['Ingresar']))
                {
                    $result = $client->call('Contratar',array($_POST["Nombre"],$_POST["Apellido"],$_POST["Dni"],$_POST["Edad"]));
                
                

        //5.- CHECKEAMOS POSIBLES ERRORES AL INVOCAR AL METODO DEL WS 
                if ($client->fault) 
                {
                    echo '<h2>ERROR AL INVOCAR METODO:</h2><pre>';
                    print_r($result);
                    echo '</pre>';
                } 
                else 
                {// CHECKEAMOS POR POSIBLES ERRORES
                    $err = $client->getError();
                    if ($err) 
                    {//MOSTRAMOS EL ERROR
                        echo '<h2>ERROR EN EL CLIENTE:</h2><pre>' . $err . '</pre>';
                    } 
                    else 
                    {//MOSTRAMOS EL RESULTADO DEL METODO DEL WS.
                        echo '<pre>'.$result.'</pre>';
                    }
                }
                }
        ?>
		</div>
		
	</div>
</body>
</html>