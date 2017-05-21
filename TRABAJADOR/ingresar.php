<!doctype html>
<html>
<head>
	<title>Ingreso de Vehiculos</title>
	  
		<meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <script type="text/javascript">
            window.onload = function()
            {
                $.ajax(
                {
                    type: 'POST',
                    url: 'administracion.php',
                    dataType: 'text',
                    data: "opcion="+"Lugares",
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
            function aceptar(numero)
            {   
                $.ajax(
                {
                    type: 'POST',
                    url: 'administracion.php',
                    dataType: 'text',
                    data: "opcion="+"Ocupar"+"&numero="+numero+"&color="+$("#Color").val()+"&patente="+$("#Patente").val()+"&marca="+$("#Marca").val(),
                    async:true
                })
                .done(function(resultado)
                {	
                    window.location.href ="ingresar.php";
                })
                .fail(function (jqXHR, textStatus, errorThrown)
                {
                    alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
                });
            }
        

        </script>
 </head>
<body>
	<a class="btn btn-info" href="../Trabajar.php">Menu principal</a>
    <div  class="container" style="padding-top: 1em;">
            <div id="lista" class="list-group">
                
            </div>
    </div>
	
</body>
</html>