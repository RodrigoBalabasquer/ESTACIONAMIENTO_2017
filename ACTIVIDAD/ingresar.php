<!doctype html>
<html>
<head>
	<title>Ingreso de Vehiculos</title>
	  
		<meta charset="UTF-8">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
       
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
        
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
                        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
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
            //Ingresa un vehiculo
            function aceptar(numero)
            {   
                $("#text").val(numero);
            }
            
            function Ocupar()
			{
				var formulario = document.getElementById('formulario');
				if(formulario.checkValidity())
                {
                    $.ajax(
                    {
                        type: 'POST',
                        url: '../API-REST/ApiRest.php/Ocupar',
                        dataType: 'text',
                        data: "numero="+$("#text").val()+"&color="+$("#Color").val()+"&patente="+$("#Patente").val()+"&marca="+$("#Marca").val(),
                        async:true
                    })
                    .done(function(resultado)
                    {	
                        alert(resultado);
                        window.location.href = "../Administrar.php";
                        //$("#div").html(resultado);
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
    session_start();
    if($_SESSION["Nivel"] == 1)
    {
        echo '<a class="btn btn-info" href="../Administrar.php">Menu principal</a>';
    }
    if($_SESSION["Nivel"] == 0)
    {
        echo '<a class="btn btn-info" href="../Trabajar.php">Menu principal</a>';
    }
    ?>
    
    <div  class="container" style="padding-top: 1em;">
            
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
                <div id="lista" class="list-group">
                
                </div>
                Valor Seleccionado<input type="text" id="text" required/>
                <br>
                <input type="submit" onclick="Ocupar()" class="btn btn-primary" value="Ocupar cochera seleccionada" id="submit"/>
            </form>
            <div id='div'>
            <div>
    </div>
	
</body>
</html>