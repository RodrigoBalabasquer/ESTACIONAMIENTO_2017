<html>
<head>
	<title>Registro de actividades</title>
	  
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <script type="text/javascript">
            function Mostrar()
            {
                var opcion = "Actividad";
				$.ajax(
			{
				type: 'POST',
				url: 'administracion.php',
				dataType: 'text',
                data:"opcion="+opcion+"&fecha="+$("#fecha").val(),
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
			<h1>Ingrese Fecha</h1>
            <input type="date" class="form-control" id="fecha">  
            <br>
            <input type="button" value="Aceptar" class="btn btn-primary btn-lg" onclick="Mostrar()">    
		</div>
		
		<div id="div">

		</div>
	</div>
</body>
</html>