<html>
<head>
	<title>Registro de actividades</title>
	  
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

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
    if($_SESSION != null)
    {
        
    	if($_SESSION["Nivel"] == 1)
		{
			echo '<a class="btn btn-info" href="../Administrar.php">Menu principal</a>';
		}
		if($_SESSION["Nivel"] == 0)
		{
			echo '<a class="btn btn-info" href="../Trabajar.php">Menu principal</a>';
		}
    ?>
    
	<div class="container">
	 <form id="formulario" action="" method="post" onsubmit="return false;">
		<div class="page-header">
			<h1>Ingrese Fecha</h1>
            <input type="date" class="form-control" min="2017-05-26"  id="fecha"  required>  
            <br>
            <input type="submit" value="Aceptar" class="btn btn-primary btn-lg" onclick="Mostrar()">    
		</div>
		<div id="div">

		</div>
	</div>
	</form>
	<?php
    }
    ?>
</body>
</html>