<!doctype html>
<html>
<head>
	<title>Retiro de Vehiculos</title>
	  
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <script type="text/javascript">
            //Retira el vehiculo y muestra sus datos
            function retirar()
            {   

                $.ajax(
                {
                    type: 'POST',
                    url: 'administracion.php',
                    dataType: 'text',
                    data: "opcion="+"Retirar"+"&patente="+$("#Patente").val(),
                    async:true
                })
                .done(function(resultado)
                {	
                    //window.location.href ="egresar.php";
                    $("#lista").html(resultado);
                })
                .fail(function (jqXHR, textStatus, errorThrown)
                {
                    alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                });
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
            <input type="text" id="Patente" placeholder="Ingrese patente"/>
            <br>
            <input type="button" class="btn btn-primary" value="Retirar" onclick="retirar()" />
            <div id="lista" class="list-group">
                
            </div>
    </div>
	
</body>
</html>