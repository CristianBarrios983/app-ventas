<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Ventas.php";

    $obj= new ventas();

    $c= new conectar();
    $conexion=$c->conexion();
    $idventa=$_GET['idventa'];

    $sql="SELECT id_venta, fechaCompra, id_cliente FROM ventas
    WHERE id_venta ='$idventa'";

    $result=mysqli_query($conexion,$sql);

    $mostrar=mysqli_fetch_row($result);

    $venta=$mostrar[0];
    $fecha=$mostrar[1];
    $idCliente=$mostrar[2];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de venta</title>
</head>
<body>
    <?php  
        $sql="SELECT * from negocio_info";
        $result=mysqli_query($conexion,$sql);
        $validar=0;
        if(mysqli_num_rows($result) > 0){
            $validar=1;
        }
    ?>

    <?php if($validar > 0): ?>
    <?php 
        $sql="SELECT nombre,direccion,telefono from negocio_info";
        $result=mysqli_query($conexion,$sql);
        $datosnegocio=mysqli_fetch_row($result);
    ?>
    <p><?php echo $datosnegocio[0]; ?></p>
    <p>Direccion: <?php echo $datosnegocio[1]; ?></p>
    <p>Telefono: <?php echo $datosnegocio[2]; ?></p>
    <p>*************************</p>
    <?php endif; ?>
    <p>Fecha: <?php echo $fecha; ?></p>
    <p>Nro de venta: <?php echo $venta; ?></p>
    <p>Cliente: <?php echo $obj->nombreCliente($idCliente) ?></p>
    <br>
    

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Producto</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precio</th>
            </tr>
        </thead>
        <?php 
            $sql="SELECT articulos.nombre, articulos.descripcion, detalles.cantidad, detalles.precio FROM detalles
            INNER JOIN ventas ON ventas.id_venta = detalles.venta
            INNER JOIN articulos ON articulos.id_producto = detalles.producto
            WHERE detalles.venta ='$idventa'";

            $result=mysqli_query($conexion,$sql);
            $total=0;
            while($mostrar=mysqli_fetch_row($result)):
        ?>
        <tbody>
            <tr>
                <td><?php echo $mostrar[0] ?></td>
                <td><?php echo $mostrar[2]; ?></td>
                <td><?php echo "$".$mostrar[3]; ?></td>
            </tr>
        </tbody>
        <?php
            $total=$total + $mostrar[3]; 
            endwhile; 
        ?>
    </table>
    <p>Total: <?php echo "$".$total; ?></p>
    <br>
    <p>***Gracias por su compra***</p>
</body>
</html>