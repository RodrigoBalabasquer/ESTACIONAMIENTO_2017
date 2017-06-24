<!doctype html>
<html>
<head>
	<title>Retiro de Vehiculos</title>
	  
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../estilo.css">
        <script type="text/javascript">
            //Retira el vehiculo y muestra sus datos
            function retirar()
            {   
                var formulario = document.getElementById('formulario');
				if(formulario.checkValidity())
                {
                    $.ajax(
                    {
                        type: 'POST',
                        url: '../API-REST/ApiRest.php/Retirar',
                        dataType: 'text',
                        data: "patente="+$("#Patente").val(),
                        async:true
                    })
                    .done(function(resultado)
                    {	
                        $("#lista").html(resultado);
                    })
                    .fail(function (jqXHR, textStatus, errorThrown)
                    {
                        $("#lista").html(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                    });
                }
            }

        </script>
 </head>
<body>
    <?php
    session_start();
    if($_SESSION["Nivel"] == 1)
    {
        ?>
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
                            <li><a href="./alta.php">Ingreso empleado</a></li>
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
                            <li><a href="./Monitorear.php">Busqueda de actividades</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <?php
                   echo '<li><a href="#"><span class="glyphicon glyphicon-user center-block" style="width:200px;">'." ".$_SESSION['Apellido']." ".$_SESSION['Nombre'].'</a></li>';
                ?>
                </ul>
            </div>
        </nav>
        <br>
        <?php
    }
    if($_SESSION["Nivel"] == 0)
    {
        ?>
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
                    <li class="active"><a href="../Trabajar.php">Menu principal</a></li>
                    <li class="active"><a href="./ingresar.php">Ingreso vehiculo</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <?php
                   echo '<li><a href="#"><span class="glyphicon glyphicon-user center-block" style="width:200px;">'." ".$_SESSION['Apellido']." ".$_SESSION['Nombre'].'</a></li>';
                ?>
                </ul>
            </div>
        </nav>
        <br>
        <?php
    }
    ?>
    <div  class="container" style="padding-top: 1em;">
    <div class="page-header">
			<h1>Retiro de vehiculo</h1>      
	</div>
    <form id="formulario" action="" method="post" onsubmit="return false;">
        <input type="text" class="form-control" id="Patente" placeholder="Ingrese patente" required/>
        <br>
        <input type="submit" class="btn btn-primary" value="Retirar" onclick="retirar()" />
        <div id="lista" class="list-group">
            
        </div>
        </div>
     </form>
    
</body>
</html>