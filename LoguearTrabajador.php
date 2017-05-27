<?php
    session_start();
    date_default_timezone_set ('America/Argentina/Buenos_Aires');
    $Pdo = new PDO("mysql:host=localhost;dbname=tp-estacionamiento","root","");
    $PdoST = $Pdo->prepare("INSERT INTO empleados(Legajo,Nombre,Apellido,Turno,Dia,Mes,Anio,CantidadOperaciones,id) VALUES (:legajo,:nombre,:apellido,:turno,:dia,:mes,:anio,:oper,null)");
    
    $PdoST->bindParam(":legajo",$_SESSION["Legajo"]);
    $PdoST->bindParam(":nombre",$_SESSION["Nombre"]);
    $PdoST->bindParam(":apellido",$_SESSION["Apellido"]); 
    $fecha = getdate();
    $PdoST->bindParam(":dia",$fecha["mday"]);
    $PdoST->bindParam(":mes",$fecha["mon"]);
    $PdoST->bindParam(":anio",$fecha["year"]);
    $PdoST->bindValue(":oper",0);
    $turno = "";
    if($fecha["hours"] >= 6 && $fecha["hours"] <12)
    {   
        $turno = "mañana";
        $PdoST->bindParam(":turno",$turno);
    }
    if($fecha["hours"] >= 12 && $fecha["hours"] <19)
    {   
        $turno = "tarde";
        $PdoST->bindParam(":turno",$turno);
    }
    if($fecha["hours"] >= 19 || $fecha["hours"] <6)
    {   
        $turno = "noche";
        $PdoST->bindParam(":turno",$turno);
    }
    $PdoST->execute();
    $ID = $Pdo->lastInsertId("empleados");
    $_SESSION["Turno"] = $turno;
    $_SESSION["Dia"] = $fecha["mday"];
    $_SESSION["Mes"] = $fecha["mon"];
    $_SESSION["Anio"] = $fecha["year"];
    $_SESSION["Cantidad"] = 0;
    $_SESSION["Id"] = (int)$ID;
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