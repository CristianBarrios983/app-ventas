<?php
    class clientes{
        public function agregaClientes($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $idusuario=$_SESSION['id_usuario'];

            $sql="INSERT into clientes (id_usuario,nombre,apellido,direccion,email,telefono)
                                                            values ('$idusuario',
                                                                    '$datos[0]',
                                                                    '$datos[1]',
                                                                    '$datos[2]',
                                                                    '$datos[3]',
                                                                    '$datos[4]')";
            return mysqli_query($conexion,$sql);
        }
        public function obtenDatosCliente($idcliente){

            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_cliente,nombre,apellido,direccion,email,telefono from clientes where id_cliente = '$idcliente'";
            $result=mysqli_query($conexion,$sql);

            $mostrar=mysqli_fetch_row($result);

            $datos=array(
                'id_cliente' => $mostrar[0],
                'nombre' => $mostrar[1],
                'apellido' => $mostrar[2],
                'direccion' => $mostrar[3],
                'email' => $mostrar[4],
                'telefono' => $mostrar[5]
            );
            return $datos;
        }

        public function actualizaCliente($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="UPDATE clientes set nombre='$datos[1]',
                                        apellido='$datos[2]',
                                        direccion='$datos[3]',
                                        email='$datos[4]',
                                        telefono='$datos[5]'
                                        where id_cliente='$datos[0]'";
            return mysqli_query($conexion,$sql);
        }

        public function eliminaCliente($idcliente){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="DELETE from clientes where id_cliente='$idcliente'";

            return mysqli_query($conexion,$sql);
        }
    }
?>