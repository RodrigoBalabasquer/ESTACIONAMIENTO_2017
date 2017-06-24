<html>
<head>
	<title>Registro de actividades</title>
	  
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="../estilo.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

        <script type="text/javascript">
			//Muestra la informacion de las actividades realizadas el dia de la fecha
            function Mostrar()
            {	
				var formulario = document.getElementById('formulario');
				if(formulario.checkValidity())
                {
					$.ajax(
					{
						type: 'POST',
						url: '../API-REST/ApiRest.php/Monitorear',
						dataType: 'text',
						data:"fecha="+$("#fecha").val(),
						async:true
					})
					.done(function(resultado)
					{	
						$("#div").html(resultado);
						
					})
					.fail(function (jqXHR, textStatus, errorThrown)
					{
						$("#div").html(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
					});
				}
			}
            //Limita el maximo del input tipo date a la fecha actual
			window.onload= function()
			{
				var fecha = document.getElementById("fecha");
				var d = new Date();
				if(d.getMonth() >=9)
				{
					var mes = d.getMonth()+1;
				}
				else
				{
					var mes = String(d.getMonth()+1);
					 mes = "0"+mes;
				}
				if(d.getDate() >=10)
				{
					var dia = d.getDate();
				}
				else
				{
					var dia = String(d.getDate());
					dia = "0"+dia;
				}
				fecha.max = d.getFullYear()+"-"+mes+"-"+dia;
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
                            <li><a href="./egresar.php">Retiro de vehiculo</a></li>
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
    ?>
	<div class="container">
	 <form id="formulario" action="" method="post" onsubmit="return false;">
		<div class="page-header">
			<h1>Ingrese Fecha</h1>
        </div>
        <input type="date" class="form-control" min="2017-05-26"  id="fecha"  required>  
            <br>
            <input type="submit" value="Aceptar" class="btn btn-primary btn-lg" onclick="Mostrar()">    
		<div id="div">

		</div>
	</div>
	</form>
</body>
</html>