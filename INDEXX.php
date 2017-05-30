<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>INDEX</title>
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        
        <!--<script type="text/javascript">
            function Login()
            {   
                var opcion = "Login";
                $.ajax(
			{
				type: 'POST',
				url: 'Loguear.php',
				dataType: 'text',
                data:"Nombre="+$("#nombre").val()+"&PASSWORD="+$("#contraseña").val()+"&Apellido="+$("#apellido").val()+"&opcion="+opcion,
				async:true
			})
			.done(function(resultado)
			{	
				if(resultado == "Aministrador")
                {
                    window.location.href = "Administrar.php";
                }
                if(resultado == "Empleado")
                {
                    window.location.href = "LoguearTrabajador.php";
                }
                if(resultado == "No encontrado")
                {
                    alert("El usuario y/o contraseña son incorrectos");
                }
                if(resultado == "Suspendido")
                {
                    alert("Usted actualmente se encuentra suspendido");
                }
                
                
            })
			.fail(function (jqXHR, textStatus, errorThrown)
            {
			    alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
			});

            }
        
        </script>-->

    </head>
    <body>
            <form action="INDEXX.php" method="post" >
            <h1 class="list-group-item-heading">Ingresar:</h1>
            <br>
            <h4 class="list-group-item-heading">Nombre:</h4><input type="text" name="nombre" required/>
            <br>
            <h4 class="list-group-item-heading">Apellido:</h4><input type="text" name="apellido" required/>
            <br>
            <h4 class="list-group-item-heading">Contraseña:</h4><input type="password" name="contraseña"  placeholder="Contraseña" required/>
            <br>
            <input type="submit" value="Aceptar" name="btnLoguear"/>
            </form>
        <?php
        ///***********************************************************************************************///
        ///COMO CLIENTE DEL SERVICIO WEB///
        ///***********************************************************************************************///
                
        //1.- INCLUIMOS LA LIBRERIA NUSOAP DENTRO DE NUESTRO ARCHIVO
                require_once('lib/nusoap.php');

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
                $result = "";
                if(isset($_POST['btnLoguear']))
                {
                    $result = $client->call('Loguear',array($_POST["nombre"],$_POST["apellido"],$_POST["contraseña"]));
                }
                

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
                        if($result  == "Aministrador")
                        {
                            echo '<script>window.location.href = "Administrar.php"</script>';
                        }
                        if($result  == "Empleado")
                        {
                            echo '<script>window.location.href = "LoguearTrabajador.php"</script>';
                        }
                        if($result  == "No encontrado")
                        {
                            echo '<pre> El usuario y/o contraseña son incorrectos </pre>';
                        }
                        if($result  == "Suspendido")
                        {   
                            echo '<pre> Usted actualmente se encuentra suspendido </pre>';
                        }
                    }
                }
        ?>
    </body>
</html>
