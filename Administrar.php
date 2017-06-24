<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administrador</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="estilo.css">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <script type="text/javascript">
            //Desconecta al trabajador
            function Borrar()
            {   
                $.ajax(
                {
                    type: 'POST',
                    url: 'ACTIVIDAD/administracion.php',
                    dataType: 'text',
                    data: "opcion="+"Log-out",
                    async:true
                })
                .done(function(resultado)
                {	
                    //$("#div").html(resultado);
                    window.location.href ="index.php";
                })
                .fail(function (jqXHR, textStatus, errorThrown)
                {
                    alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                });
            }
        </script>

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
                <ul class="nav navbar-nav navbar-right">
                <?php
                error_reporting(0);
                   session_start();
                   echo '<li><a href="#"><span class="glyphicon glyphicon-user center-block" style="width:200px;">'." ".$_SESSION['Apellido']." ".$_SESSION['Nombre'].'</a></li>';

                ?>
                </ul>
            </div>
            </nav>
            <br>
            <div class="container">
                <div class="page-header">
                    <h1>Administrador</h1>      
                </div>
                <div class="CajaInicio animated bounceInRight">
                    <form id="FormIngreso">
                        <a href="ACTIVIDAD/alta.php" class="list-group-item  list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">Contratar Empleado</h4>
                        </a>
                        <a href="ACTIVIDAD/suspender.php" class="list-group-item  list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">Suspender Empleados</h4>
                        </a>
                        <a href="ACTIVIDAD/reabilitar.php" class="list-group-item  list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">Reabilitar Empleados</h4>
                        </a>
                        <a href="ACTIVIDAD/despedir.php" class="list-group-item  list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">Despedir Empleados</h4>
                        </a>
                        <a href="ACTIVIDAD/Lista.php" class="list-group-item  list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">Datos de Empleados</h4>
                        </a>
                        <a href="ACTIVIDAD/Monitorear.php" class="list-group-item  list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">Monitorear Actividad</h4>
                        </a>
                        <a href="ACTIVIDAD/ingresar.php" class="list-group-item  list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">Ingresar Vehiculo</h4>
                        </a>
                        <a href="ACTIVIDAD/egresar.php" class="list-group-item  list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">Retirar Vehiculo</h4>
                        </a>
                        <br>
                        <input type="button" class="MiBotonUTN" value="Desconectar" onclick="Borrar()">
                    </form>
                </div>
            </div>
    </body>
</html>
