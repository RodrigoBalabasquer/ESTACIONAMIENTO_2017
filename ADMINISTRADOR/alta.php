<html>
<head>
	<title>ALTA de EMPLEADOS</title>
	  
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
 </head>
<body>
	<a class="btn btn-info" href="../Administrar.php">Menu principal</a>
<?php     
	//require_once("clases\producto.php");
?>
	<div class="container">
	
		<div class="page-header">
			<h1>Empleados</h1>      
		</div>
		<div class="CajaInicio animated bounceInRight">
			<form id="FormIngreso" method="post" enctype="multipart/form-data" action="administracion.php" >
				<input type="text" name="nombre" placeholder="Ingrese nombre"/>
				<input type="text" name="apellido" placeholder="Ingrese apellido"/>
                <input type="text" name="edad" placeholder="Ingrese edad"/>
				<input type="password" name="contraseña" placeholder="Ingrese contraseña"/> 
                <input type="submit" class="btn btn-primary" name="guardar" />
			</form>
		
		</div>
	</div>
</body>
</html>