<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Vendedor"){
            require_once "../clases/Conexion.php";
            require_once "../clases/Ventas.php";

            $c= new conectar();
            $conexion=$c->conexion();
        
            $obj= new ventas();
        
            $sql="SELECT id_venta,fechaCompra,id_cliente, usuarios.nombre, ventas.total from ventas 
            INNER JOIN usuarios ON ventas.id_usuario = usuarios.id_usuario
            GROUP BY id_venta";
            $result=mysqli_query($conexion,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas realizadas</title>
    <?php require_once "menu.php"; ?>
</head>
<body>
    
<div class="container">
    <!-- Modal detalles de venta -->
    <div class="modal fade" id="abremodalDetalles" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles de venta</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            

                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- Detalles aqui -->
                    </tbody>
                </table>
                    
                <p>Cantidad de productos: <span id="cantidadProductos" class="fw-bold"></span></p>
                <p>Total de venta: <span id="totalVenta" class="fw-bold"></span></p>

        </div>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
        <div class="section-title">
            <h2 class="my-3">Reportes y ventas</h2>
        </div>
        </div>
    </div>
    <table class="table table-hover text-center" id="tablaVentasRealizadas">
    <thead class="table-dark">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Fecha</th>
        <th scope="col">Cliente</th>
        <th scope="col">Usuario</th>
        <th scope="col">Total</th>
        <th scope="col" colspan="3">Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while($mostrar=mysqli_fetch_row($result)): ?>
        <tr>
        <th scope="row"><?php echo $mostrar[0]; ?></th>
        <td><?php echo $mostrar[1]; ?></td>
        <td>
            <?php
                if($obj->nombreCliente($mostrar[2])==" "){
                    echo "Sin cliente";
                }else{
                    echo $obj->nombreCliente($mostrar[2]);
                }
            ?>
        </td>
        <td><?php echo $mostrar[3]; ?></td>
        <td>
            <?php
                echo '<label class="fw-bold text-success">$</label>'.$mostrar[4];
            ?>
        </td>
        <td><a target="_blank" href="../procesos/ventas/crearTicketPdf.php?idventa=<?php echo $mostrar[0] ?>" class="btn btn-danger btn-xs rounded-0">
                                <span class="bi bi-ticket-detailed"></span>
                            </a></td> 
        <td><a target="_blank" href="../procesos/ventas/crearReportePdf.php?idventa=<?php echo $mostrar[0] ?>" class="btn btn-primary btn-xs rounded-0">
                                <span class="bi bi-filetype-pdf"></span>
                            </a>   </td>
        <!-- Detalles de venta -->
        <td><a data-bs-toggle="modal" data-bs-target="#abremodalDetalles" class="btn btn-success btn-xs rounded-0" onclick="verDetalles(<?php echo $mostrar[0] ?>)">
            <span class="bi bi-card-list"></span>
        </a>   </td>
        </tr>
        <?php endwhile;?>
    <?php else: ?>
        <tr>
            <td colspan="8">No hay ventas realizadas.</td>
        </tr>
    <?php endif; ?>
    </tbody>
    </table>
</div>

<script src="../js/ventasRealizadas/ventasRealizadas.js"></script>

<?php
        }else{
            header("location:inicio.php");
        }
    }else{
        header("location:../index.php");
    }
?>