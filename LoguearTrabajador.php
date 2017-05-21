<?php
    session_start();
    $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
    $PdoST = $Pdo->prepare("INSERT INTO empleados(Legajo,Nombre,Apellido,Turno,Dia,Mes,Anio,CantidadOperaciones) VALUES (:legajo,:nombre,:apellido,:turno,:dia,:mes,:anio,:oper)");
    
    $PdoST->bindParam(":legajo",$_SESSION["Legajo"]);
    $PdoST->bindParam(":nombre",$_SESSION["Nombre"]);
    $PdoST->bindParam(":apellido",$_SESSION["Apellido"]); 
    $fecha = getdate();
    $PdoST->bindParam(":dia",$fecha["mday"]);
    $PdoST->bindParam(":mes",$fecha["mon"]);
    $PdoST->bindParam(":anio",$fecha["year"]);
    $PdoST->bindValue(":oper",0);
    if($fecha["hours"] >= 6 && $fecha["hours"] <12)
    {   
        $PdoST->bindValue(":turno","mañana");
    }
    if($fecha["hours"] >= 12 && $fecha["hours"] <19)
    {   
        $PdoST->bindValue(":turno","tarde");
    }
    if($fecha["hours"] >= 19 || $fecha["hours"] <6)
    {   
        $PdoST->bindValue(":turno","noche");
    }
    $PdoST->execute();
?>
<!doctype html>
<html>
    <head>
        <script type="text/javascript">
        window.onload = function()
        {
            window.location.href ="Trabajar.php";
        }
        </script>

    </head>
    
</html>