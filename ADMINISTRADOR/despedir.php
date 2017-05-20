<html>
<head>
	<title>DESPIDO DE EMPLEADOS</title>
	  
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
				<input type="text" name="legajo" placeholder="Ingrese legajo"/> 
                <input type="submit" class="btn btn-primary" name="eliminar" />
			</form>
		
		</div>
	</div>
</body>
</html>