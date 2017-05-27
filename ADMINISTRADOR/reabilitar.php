<html>
<head>
	<title>REABILITACION DE EMPLEADOS</title>
	  
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <script type="text/javascript">
            function reabilitar()
            {   
                var opcion = "Reabilitar";
				$.ajax(
			{
				type: 'POST',
				url: 'administracion.php',
				dataType: 'text',
                data:"Legajo="+$("#legajo").val()+"&opcion="+opcion,
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
			<input type="text" id="legajo" placeholder="Ingrese legajo"/> 
        	<input type="button" class="btn btn-primary" value="Reabilitar" onclick="reabilitar()"  />
		</div>
		<div id="div">

		</div>
	</div>
</body>
</html>