<?php
    /*session_start();
    var_dump($_SESSION);*/
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administrador</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <script type="text/javascript">
        </script>

    </head>
    <body>
            <div class="container">
                <div class="page-header">
                    <h1>Administrador</h1>      
                </div>
                <div class="CajaInicio animated bounceInRight">
                    <form id="FormIngreso">
                        <a href="ADMINISTRADOR/alta.php" class="list-group-item  list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">Contratar Empleado</h4>
                        </a>
                        <!--<a href="baja.php" class="list-group-item  list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">Suspender Empleados</h4>
                        </a>-->
                        <a href="ADMINISTRADOR/despedir.php" class="list-group-item  list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">Despedir Empleados</h4>
                        </a>
                        
                    </form>
                </div>
            </div>
    </body>
</html>