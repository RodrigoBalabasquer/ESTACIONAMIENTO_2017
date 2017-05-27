<html>
<head>
	<title>LISTA DE EMPLEADOS</title>
	  
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <script type="text/javascript">
            window.onload = function()
            {   
                var opcion = "Lista";
				$.ajax(
			{
				type: 'POST',
				url: 'administracion.php',
				dataType: 'text',
                data:"opcion="+opcion,
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
			<h1>Lista de empleados</h1>      
		</div>
		
		<div id="div">

		</div>
	</div>
</body>
</html>