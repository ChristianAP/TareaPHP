<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="index.js">

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
    $f1 = $_POST['inicio']." 00:00:00";
    $f2 = $_POST['final']." 23:59:59";
    $name = $_POST['name'];
    if ($f1 == " 00:00:00" && $f2 == " 23:59:59" && $name == "0") {
        echo'<script type="text/javascript">
    alert("NO INGRESO NINGÚN DATO¡¡¡");
    window.location.href="index.php";
    </script>';
    }

    

?>
    <title>Document</title>
</head>
<body>
    <div id="cajaform">
        <form method="POST" action="generate.php">
        <input type="date" name="inicio" id="dateinicio">
        <input type="date" name="final" id="datefinal">
        <select name="name" id="selectname">
        <option value="0"></option>
        <?php
            while($datos = mysqli_fetch_array($select)){
        ?>
        <option value="<?php echo $datos['nombres'] ?>"> <?php echo $datos['nombres'] ?> </option>
        <?php
            }
        ?>
        </select>
        <button  class="btn btn-danger" type="submit" id="g_reporte">Generar Reporte XML</button>
        </form>
    </div>
           <br>
           <br>

    <div id="caja_reporte">
     <?php 

            if ($f1 == " 00:00:00" && $f2 == " 23:59:59") {
                $n = mysqli_query($con, "select v.idventa ,c.nombres,c.apellidos, p.nomprod , d.cantidad, v.fecha, d.precio from cliente c, producto p, venta v, detalle d
                WHERE d.idproducto = p.idproducto and d.idventa = v.idventa and v.idcliente = c.idcliente and c.nombres= '$name'");
                if ($n) {
                    $xml = new DOMDocument("");
                $xml->formatOutput=true;
                $fitness=$xml -> createElement("tienda");
                $xml -> appendChild($fitness);
                while($row=mysqli_fetch_array($n)){
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
        }else if($name == "0"){ $resp = mysqli_query($con, "select v.idventa ,c.nombres,c.apellidos, p.nomprod , d.cantidad, v.fecha, d.precio from cliente c, producto p, venta v, detalle d
            WHERE d.idproducto = p.idproducto and d.idventa = v.idventa and v.idcliente = c.idcliente and v.fecha between '$f1' and '$f2'");
            
            if ($resp) {
                $xml = new DOMDocument("");
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
        }else{
            $res = mysqli_query($con, "select v.idventa ,c.nombres,c.apellidos, p.nomprod , d.cantidad, v.fecha, d.precio from cliente c, producto p, venta v, detalle d
            WHERE d.idproducto = p.idproducto and d.idventa = v.idventa and v.idcliente = c.idcliente and v.fecha between '$f1' and '$f2' and c.nombres= '$name'");
            
            if ($res) {
                $xml = new DOMDocument("");
            $xml->formatOutput=true;
            $fitness=$xml -> createElement("tienda");
            $xml -> appendChild($fitness);
            while($row=mysqli_fetch_array($res)){
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
    
        }
       
        ?>
    
    </div>
</body>
</html>