<!doctype html>
<html>
<head>
	<title>Ingreso de Vehiculos</title>
	  
		<meta charset="UTF-8">
        <script type="text/javascript" src="../jquery-3.2.1.min.js"></script>
        <link href="../bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="../bootstrap-3.3.7/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="../estilo1.css">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <link rel="stylesheet" href="../bootstrap-select/dist/css/bootstrap-select.min.css">
        <script type="text/javascript" src="../bootstrap-select/dist/js/bootstrap-select.min.js"></script>
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">-->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>-->
        <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
        <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">-->
        
        
        
        <script type="text/javascript">
            //Carga un listado de las cocheras disponibles
            window.onload = function()
            {
                $.ajax(
                    {
                        type: 'POST',
                        url: '../API-REST/ApiRest.php/Lista',
                        dataType: 'text',
                        data: "valor="+$("#select").val(),
                        async:true
                    })
                    .done(function(resultado)
                    {	
                        $('#lista').html(resultado);
                    })
                    .fail(function (jqXHR, textStatus, errorThrown)
                    {
                        $('#lista').html(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                    });
            }
            function Lista()
                {
                    $.ajax(
                    {
                        type: 'POST',
                        url: '../API-REST/ApiRest.php/Lista',
                        dataType: 'text',
                        data: "opcion="+"Lugares"+"&valor="+$("#select").val(),
                        async:true
                    })
                    .done(function(resultado)
                    {	
                        $('#lista').html(resultado);
                    })
                    .fail(function (jqXHR, textStatus, errorThrown)
                    {
                        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                    });
                }
            //Carga en el cuadro de texto la cochera seleccionada
            function aceptar(numero)
            {   
                $("#text").val(numero);
            }
            //Ingresa un vehiculo
            function Ocupar()
			{
				var formulario = document.getElementById('formulario');
				if(formulario.checkValidity())
                {   
                    var archivo = $("#Foto")[0];
                    var formData = new FormData();
                    formData.append("foto",archivo.files[0]);
                    formData.append("numero",$("#text").val());
                    formData.append("color",$("#Color").val());
                    formData.append("patente",$("#Patente").val());
                    formData.append("marca",$("#Marca").val());
                    $.ajax(
                    {
                        type: 'POST',
                        url: '../API-REST/ApiRest.php/Ocupar',
                        dataType: 'text',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        async: true
                        //data: "numero="+$("#text").val()+"&color="+$("#Color").val()+"&patente="+$("#Patente").val()+"&marca="+$("#Marca").val()+"&foto="+$("#Foto").val(),
                    })
                    .done(function(resultado)
                    {	
                        if(resultado == 'A')
                        {
                            //window.location.href = "../Administrar.php";
                            
                        }
                        if(resultado == 'B')
                        {   
                            alert("Vehiculo ingresado");
                            //window.location.href = "../Trabajar.php";
                        }
                        if(resultado == 'C')
                        {
                            alert("La patente ya fue ingresada");
                        }
                            
                        $("#div").html(resultado);
                    })
                    .fail(function (jqXHR, textStatus, errorThrown)
                    {
                        $("#div").html(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                    });
                    
                }
			}

        </script>
 </head>
<body>
	<?php
    error_reporting(0);
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
                            <li><a href="./egresar.php">Retiro de vehiculo</a></li>
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
                    <li class="active"><a href="./egresar.php">Retiro de vehiculo</a></li>
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
			<h1>Ingreso de vehiculos</h1>      
		    </div>
            <select class="selectpicker" id="select" onchange="Lista()">
            <option value="1">Primer Piso</option>
            <option value="2">Segundo Piso</option>
            <option value="3">Tercer Piso</option>
            </select>
            <br>
            <br>
            <form id="formulario" action="" method="post" onsubmit="return false;">
                <input type="text" class="form-control" id="Color" placeholder="Ingrese color" required/>
                <br>
                <input type="text" class="form-control" id="Patente" placeholder="Ingrese patente" required/>
                <br>
                <input type="text" class="form-control" id="Marca" placeholder="Ingrese marca" required/>
                <br>
                <h2> Ingrese foto del vehiculo<h2>
                <br>
                <input type="file" class="btn btn-primary" id="Foto" required/>
                <br>
                <div id="lista" class="list-group">
                
                </div>
                <br>
                <h3>Valor Seleccionado<input type="text" id="text" readonly required/></h3>
                <br>
                <input type="submit" onclick="Ocupar()" class="btn btn-primary" value="Ocupar cochera seleccionada" id="submit"/>
            </form>
            <div id='div'>
            <div>
    </div>
</body>
</html>