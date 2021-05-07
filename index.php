<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $host = "127.0.0.1";
    $usuario = "root";
    $clave = "root";
    $bd = "tienda";
    $con = mysqli_connect($host, $usuario, $clave, $bd);
    if($con -> connect_errno){
        die("Error de conexión ... !");
    }
    $select = mysqli_query($con , "select idcliente, nombres from cliente");
?>
    <title>Document</title>
</head>
<body>
    <form method="POST" action="generate.php">
    <input type="date" name="inicio" >
    <input type="date" name="final" >
    <select name="name" id="">
    <?php
        while($datos = mysqli_fetch_array($select)){
    ?>
    <option value="<?php echo $datos['nombres'] ?>"> <?php echo $datos['nombres'] ?> </option>
    <?php
        }
    ?>
    </select>
    <button type="submit">Generar reporte</button>
    </form>
    <?php 
    
    $resp = mysqli_query($con, "select c.nombres,c.apellidos, p.nomprod , d.cantidad, v.fecha, d.precio from cliente c, producto p, venta v, detalle d
    WHERE d.idproducto = p.idproducto and d.idventa = v.idventa and v.idcliente = c.idcliente ");
    if ($resp) {
        $xml = new DOMDocument("1.0");
    $xml->formatOutput=true;
    $fitness=$xml -> createElement("tienda");
    $xml -> appendChild($fitness);
    while($row=mysqli_fetch_array($resp)){
        $reporte=$xml->createElement("reporte");
        $fitness->appendChild($reporte);

        $nombres=$xml->createElement("nombres", $row['nombres']);
        $reporte->appendChild($nombres);

        $apellidos=$xml ->createElement("apellidos", $row['apellidos']);
        $reporte->appendChild($apellidos);

        $nomprod=$xml -> createElement("nomprod", $row['nomprod']);
        $reporte->appendChild($nomprod);

        $cantidad=$xml -> createElement("cantidad", $row['cantidad']);
        $reporte->appendChild($cantidad);

        $fecha=$xml -> createElement("fecha", $row['fecha']);
        $reporte->appendChild($fecha);

        $preciototal=$xml -> createElement("precio", $row['precio']);
        $reporte->appendChild($preciototal);
    }
    
    echo "<xmp>".$xml->saveXML()."</xmp>";
    $xml->save("report.xml");
    }else{
        echo "Error...!";
    }



?>
    

</body>
</html>