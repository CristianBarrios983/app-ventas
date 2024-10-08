// Cargando datatables apenas inicia la pagina
document.addEventListener("DOMContentLoaded", function() {
    $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php", function() {
        // Inicializar DataTables después de cargar la tabla
        let dataTable = new DataTable("#tablaCategorias", {
            perPageSelect: [10,20,30,40,50,75,100],
            // Para cambiar idioma
            labels: {
                        placeholder: "Buscar...",
                        perPage: "{select} Registros por pagina",
                        noRows: "Registro no encontrado",
                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                    }
        });
    });
});

// Script para agregar categoria
$(document).ready(function(){
    $('#btnAgregaCategoria').click(function(e){

        e.preventDefault(); // Evita el comportamiento predeterminado del botón de enviar

        let esValido=validarFormulario('frmCategorias');

        if (!esValido) {
            return false; // Si la validación falla, no se envía el formulario
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
                    $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php", function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaCategorias", {
                            perPageSelect: [10,20,30,40,50,75,100],
                            labels: {
                                        placeholder: "Buscar...",
                                        perPage: "{select} Registros por pagina",
                                        noRows: "Registro no encontrado",
                                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                                    }
                        });
                    });
                    alertify.success("Categoria agregada exitosamente");

                    // Cerrar el modal solo si el registro fue exitoso
                    $('#registraCategoria').modal('hide');
                    // Eliminar el backdrop manualmente
                    $('.modal-backdrop').remove();
                }else{
                    alertify.error("No se pudo agregar la categoria :(");
                }
            }
        });
    });
});

// Funcion para agregar los datos al formulario de actualizar
function agregaDato(idCategoria,categoria){
    $('#idcategoria').val(idCategoria);
    $('#categoriaU').val(categoria);
}


// Script para actualizar categoria
$(document).ready(function(){
    $('#btnActualizaCategoria').click(function(e){

        e.preventDefault(); // Evita el comportamiento predeterminado del botón de enviar

        let esValido=validarFormulario('frmCategoriaU');

        if (!esValido) {
            return false; // Si la validación falla, no se envía el formulario
        }

        datos=$('#frmCategoriaU').serialize();

        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/categorias/actualizaCategoria.php",
            success:function(r){
                if(r==1){
                    $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php", function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaCategorias", {
                            perPageSelect: [10,20,30,40,50,75,100],
                            labels: {
                                        placeholder: "Buscar...",
                                        perPage: "{select} Registros por pagina",
                                        noRows: "Registro no encontrado",
                                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                                    }
                        });
                    });
                    alertify.success("Actualizado con exito");

                    // Cerrar el modal solo si el registro fue exitoso
                    $('#actualizaCategoria').modal('hide');
                    // Eliminar el backdrop manualmente
                    $('.modal-backdrop').remove();
                }else{
                    alertify.error("No se pudo actualizar")
                }
            }
        });
    });
})


// Funcion para eliminar categoria
function eliminaCategoria(idcategoria){
    alertify.confirm('¿Desea eliminar esta categoria?', function(){ 
        // alertify.success('Ok') 
        $.ajax({
            type:"POST",
            data:"idcategoria=" + idcategoria,
            url:"../procesos/categorias/eliminarCategoria.php",
            success:function(r){
                if(r==1){
                    $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php", function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaCategorias", {
                            perPageSelect: [10,20,30,40,50,75,100],
                            labels: {
                                        placeholder: "Buscar...",
                                        perPage: "{select} Registros por pagina",
                                        noRows: "Registro no encontrado",
                                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                                    }
                        });
                    });
                    alertify.success("Eliminado con exito");
                }else{
                    alertify.error("No se pudo eliminar");
                }
            }
        });
    }, function(){ 
        alertify.error('Cancelar')});
}

document.getElementById('registraCategoria').addEventListener('hidden.bs.modal', function () {
    $('#frmCategorias')[0].reset();
});

