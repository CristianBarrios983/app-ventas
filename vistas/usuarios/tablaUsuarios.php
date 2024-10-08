<?php
    session_start();
    require_once "../../clases/Conexion.php";
    $c= new conectar();
    $conexion=$c->conexion();

    $sql="SELECT id_usuario,nombre,apellido,usuario,email,roles.rol FROM usuarios
    INNER JOIN roles ON roles.id_rol = usuarios.rol";
    $result=mysqli_query($conexion,$sql);
?>

<table class="table table-hover text-center" id="tablaUsuarios">
  <thead class="table-dark">
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Usuario</th>
      <th scope="col">Email</th>
      <th scope="col">Rol</th>
      <th scope="col" colspan="2">Acciones</th>
    </tr>
  </thead>
  <tbody>
  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while($mostrar=mysqli_fetch_row($result)): ?>
    <tr>
      <td><?php echo $mostrar[1]; ?></td>
      <td><?php echo $mostrar[2]; ?></td>
      <td><?php echo $mostrar[3]; ?></td>
      <td><?php echo $mostrar[4]; ?></td>
      <td class="text-success"><?php echo $mostrar[5]; ?></td>
      <td>
          <span data-bs-toggle="modal" data-bs-target="#actualizaUsuarioModal" class="btn btn-warning btn-xs rounded-0" onclick="agregaDatosUsuario('<?php echo $mostrar[0]; ?>')">
                <span class="bi bi-pen-fill"></span>
            </span>
      </td>
      <td>
          <span class="btn btn-danger btn-xs rounded-0" onclick="eliminarUsuario('<?php echo $mostrar[0] ;?>')">
                <span class="bi bi-trash3-fill"></span>
            </span>
      </td>
    </tr>
    <?php endwhile;?>
  <?php else: ?>
      <tr>
              <td colspan="7">No hay usuarios registrados.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

