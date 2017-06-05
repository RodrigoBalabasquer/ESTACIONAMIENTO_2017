<html>
<head>
	<title>REABILITACION DE EMPLEADOS</title>
	  
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <script type="text/javascript">
			//Reabilita a un empleado
            function Reabilitar(valor)
            {   
                var opcion = "Reabilitar";
				$.ajax(
			{
				type: 'POST',
				url: 'administracion.php',
				dataType: 'text',
                data:"Legajo="+valor+"&opcion="+opcion,
				async:true
			})
			.done(function(resultado)
			{	
				$("#div").html(resultado);
                window.location.href = "../Administrar.php";
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
		<div class="CajaInicio animated bounceInRight">
		<?php
		include_once "../CLASES/Personal.php";
		$Empleados = Personal::TraerEmpleadosFiltrados("Suspendido");
		
		echo "<table border>
		<thead>
			<tr>
				<th>  Nombre</th>
				<th>  Apellido    </th>
				<th>  DNI   </th>
				<th></th>
			</tr> 
		</thead>";   	
		foreach ($Empleados as $obj){
			$legajo = $obj->getLegajo();
			echo " 	<tr>
						<td>".$obj->getNombre()."</td>
						<td>".$obj->getApellido()."</td>
						<td>".$obj->getDni()."</td>
						<td><input type='button' value='Reabilitar' onclick='Reabilitar($legajo)'><td>
					</tr>";
		}	
		echo "</table>";	
		?>
		<div>
	<div>
	<div id='div'>    </div>
</body>
</html>