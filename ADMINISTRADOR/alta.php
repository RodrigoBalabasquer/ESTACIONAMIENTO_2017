<!doctype html>
<html>
<head>
	<title>ALTA de EMPLEADOS</title>
	  
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <script type="text/javascript">
            function guardar()
            {   
                var opcion = "Agregar";
				var contrasenia = $("#nombre").val()+$("#apellido").val();
                $.ajax(
			{
				type: 'POST',
				url: 'administracion.php',
				dataType: 'text',
                data:"Nombre="+$("#nombre").val()+"&PASSWORD="+contrasenia+"&Apellido="+$("#apellido").val()+"&Edad="+$("#edad").val()+"&opcion="+opcion,
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
        
        </script>
 </head>
<body>
	<a class="btn btn-info" href="../Administrar.php">Menu principal</a>

	<div class="container">
	
		<div class="page-header">
			<h1>Empleados</h1>      
		</div>
		<div class="CajaInicio animated bounceInRight">
			<input type="text" id="nombre" placeholder="Ingrese nombre"/>
			<input type="text" id="apellido" placeholder="Ingrese apellido"/>
			<input type="text" id="edad" placeholder="Ingrese edad"/>
			<input type="button" class="btn btn-primary" value="Agregar" onclick="guardar()" />
		</div>
		<div id="div">

		</div>
	</div>
</body>
</html>