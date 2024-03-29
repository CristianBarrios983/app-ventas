<?php
    class articulos{

        public function agregaImagen($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $fecha=date("Y-m-d");

            $sql="INSERT into imagenes (nombre,ruta,fechaSubida) 
                        values ('$datos[0]','$datos[1]','$fecha')";

            $result=mysqli_query($conexion,$sql);

            return mysqli_insert_id($conexion);
        }
        public function actualizaImagen($datos) {
            $c = new conectar();
            $conexion = $c->conexion();
        
            $fecha = date("Y-m-d");
        
            $sql = "UPDATE imagenes SET nombre='$datos[1]',
                                        ruta='$datos[2]',
                                        fechaSubida='$fecha'
                                        WHERE id_imagen='$datos[0]'";
        
            return mysqli_query($conexion, $sql);
        }
        public function insertaArticulo($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $fecha=date("Y-m-d");

            $sql="INSERT into articulos (id_categoria,id_imagen,id_usuario,nombre,descripcion,cantidad,precio,fechaCaptura) 
                                values ('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$fecha')";

            return mysqli_query($conexion,$sql);
        }
        public function obtieneDatosArticulo($idarticulo){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_producto,
                            id_categoria,
                            nombre,
                            descripcion,
                            cantidad,
                            precio
                            from articulos where id_producto='$idarticulo'";
            $result=mysqli_query($conexion,$sql);

            $mostrar=mysqli_fetch_row($result);
            $datos=array(
                "id_producto" => $mostrar[0],
                "id_categoria" => $mostrar[1],
                "nombre" => $mostrar[2],
                "descripcion" => $mostrar[3],
                "cantidad" => $mostrar[4],
                "precio" => $mostrar[5]
            );
            return $datos;
        }
        public function actualizaArticulo($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="UPDATE articulos set id_categoria='$datos[1]',
                                        nombre='$datos[2]',
                                        descripcion='$datos[3]',
                                        precio='$datos[4]'
                                        where id_producto='$datos[0]'";
            return mysqli_query($conexion,$sql);
        }

        public function eliminaArticulo($idarticulo){
            $c= new conectar();
            $conexion=$c->conexion();

            $idimagen=self::obtenerIdImg($idarticulo);

            $sql="DELETE from articulos 
                                where id_producto='$idarticulo'";
            $result=mysqli_query($conexion,$sql);

            if($result){
                $ruta=self::obtenerRutaImagen($idimagen);

                $sql="DELETE from imagenes 
                                    where id_imagen='$idimagen'";
                $result=mysqli_query($conexion,$sql);
                    if($result){
                        if(unlink($ruta)){
                            return 1;
                        }
                    }
            }
        }
        public function obtenerIdImg($idProducto){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_imagen from articulos where id_producto='$idProducto'";
            $result=mysqli_query($conexion,$sql);

            return mysqli_fetch_row($result)[0];
        }
        public function obtenerRutaImagen($idImg){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT ruta from imagenes where id_imagen='$idImg'";
            $result=mysqli_query($conexion,$sql);

            return mysqli_fetch_row($result)[0];
        }

        public function actualizaStock($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="UPDATE articulos set cantidad='$datos[1]'
                                        where id_producto='$datos[0]'";
            return mysqli_query($conexion,$sql);
        }
    }
?>