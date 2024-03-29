<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Supervisor"){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <?php require_once "menu.php"; ?>
</head>
<body>
    <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="section-title">
              <h2 class="my-3">Categorias</h2>
            </div>
          </div>
        </div>
        <div class="row">
             <?php if($_SESSION['rol'] == "Administrador"): ?>
             <div class="col-sm-4">
                <div class="card rounded-0">
                  <div class="card-body p-4">
                    <form id="frmCategorias">
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="categoria" id="categoria" placeholder="Categoria">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary rounded-0 d-block w-100" id="btnAgregaCategoria">Registrar</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php endif; ?>
            <div class="col-sm-6">
                <div id="tablaCategoriaLoad"></div>
            </div>
        </div>
    </div>


<!-- Modal actualiza categoria Bootstrap 5.3.3 -->
<div class="modal fade" id="actualizaCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar datos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form id="frmCategoriaU">
            <div class="mb-3">
                <input type="text" hidden="" id="idcategoria" name="idcategoria">
            </div>
            <div class="mb-3">
                <label for="" class="form-label text-secondary fs-6">Categoria</label>
                <input type="text" id="categoriaU" name="categoriaU" class="form-control form-control-lg fs-6 rounded-0">
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
        <button id="btnActualizaCategoria" type="button" class="btn btn-primary rounded-0" data-bs-dismiss="modal">Actualizar</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>

<!-- script para agregar categoria nueva -->
<script type="text/javascript">
    $(document).ready(function(){

        $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");
        $('#btnAgregaCategoria').click(function(){

            vacios=validarFormVacio('frmCategorias');

            if(vacios > 0){
                alertify.alert("Los campos no deben estar vacios");
                return false;
            }
            
        datos=$('#frmCategorias').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/categorias/agregaCategoria.php",
            success:function(r){
                if(r==1){
                    //Esta linea permite limpiar los registros
                    $('#frmCategorias')[0].reset();
                    $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");
                    alertify.success("Categoria agregada exitosamente");
                }else{
                    alertify.error("No se pudo agregar la categoria :(");
                }
            }
        });
    });
    })
</script>

<!-- script para traer datos de categorias -->
<script>
    function agregaDato(idCategoria,categoria){
        $('#idcategoria').val(idCategoria);
        $('#categoriaU').val(categoria);
    }

    function eliminaCategoria(idcategoria){
        alertify.confirm('¿Desea eliminar esta categoria?', function(){ 
            // alertify.success('Ok') 
            $.ajax({
                type:"POST",
                data:"idcategoria=" + idcategoria,
                url:"../procesos/categorias/eliminarCategoria.php",
                success:function(r){
                    if(r==1){
                        $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");
                        alertify.success("Eliminado con exito");
                    }else{
                        alertify.error("No se pudo eliminar");
                    }
                }
            });
        }, function(){ 
            alertify.error('Cancelar')});
    }
</script>

<!-- script para actualizar datos categoria -->
<script>
    $(document).ready(function(){
        $('#btnActualizaCategoria').click(function(){
            datos=$('#frmCategoriaU').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"../procesos/categorias/actualizaCategoria.php",
                success:function(r){
                    if(r==1){
                        $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");
                        alertify.success("Actualizado con exito");
                    }else{
                        alertify.error("No se pudo actualizar")
                    }
                }
            });
        });
    })
</script>

<?php
        }else{
            header("location:inicio.php");
        }
    }else{
        header("location:../index.php");
    }
?>