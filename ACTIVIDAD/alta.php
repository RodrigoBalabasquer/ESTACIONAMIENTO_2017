<!doctype html>
<html>
<head>
	<title>ALTA de EMPLEADOS</title>
	  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<link rel="stylesheet" href="../estilo.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
		
 </head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <!-- El logotipo y el icono que despliega el menú se agrupan
                para mostrarlos mejor en los dispositivos móviles -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Desplegar navegación</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Home</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="../Administrar.php">Menu principal</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            Empleados<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="./despedir.php">Despido empleado</a></li>
                            <li><a href="./suspender.php">Suspencion empleado</a></li>
                            <li><a href="./reabilitar.php">Reabilitacion empleado</a></li>
                            <li><a href="./Lista.php">Busqueda de empleado</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            Vehiculos<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="./ingresar.php">Ingreso vehiculo</a></li>
                            <li><a href="./egresar.php">Retiro de vehiculo</a></li>
                            <li><a href="./Monitorear.php">Busqueda de actividades</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <?php
                   session_start();
                   echo '<li><a href="#"><span class="glyphicon glyphicon-user center-block" style="width:200px;">'." ".$_SESSION['Apellido']." ".$_SESSION['Nombre'].'</a></li>';

                ?>
                </ul>
            </div>
    </nav>
	<br>
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
			<input type="number" class="form-control" name="Edad" id="edad" min="18" placeholder="Ingrese edad" required/>
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
                        echo '<h2>'.$result.'</h2>';
                    }
                }
                }
        ?>
		</div>
		
	</div>
</body>
</html>