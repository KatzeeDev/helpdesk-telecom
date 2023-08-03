<?php
// Creamos una clase llamada usuario que se extendera de la clase conectar. Esto con el fin de hacer el login.
class Usuario extends Conectar
{
    /**
     * ? Descripcion de login
     * .Esta funcion recibe los datos de inicio de sesión (correo electrónico, contraseña y rol) enviados a través del método POST, verifica si son válidos en la base de datos y, en caso de que lo sean, establece variables de sesión para el usuario y redirige al usuario a una página de inicio del sistema. 
     * Si los datos de inicio de sesión no son válidos, se muestra un mensaje de error al usuario.
     * ? Descripcion de insert_usuario
     * Este método se encarga de insertar un nuevo usuario en la base de datos. Toma varios parámetros, como el nombre del usuario, su apellido, su correo electrónico y su contraseña, y los utiliza para crear una nueva entrada en la tabla de usuarios de la base de datos. También encripta la contraseña del usuario antes de guardarla en la base de datos.
     * ? Descripcion de update_usuario
     * Recibetodos los parametros idnnicados luego genera un consulta Sql para actualizar y tambien encripta la contraseña
     * ? Descripcion de delete_usuario
     * Este método recibe un parámetro llamado $usu_id que representa el id del usuario. Luego, se establece la conexión con la base de datos y se prepara una consulta SQL para actualizar el registro del usuario correspondiente al id recibido. En la consulta se establece el valor del campo estado como '0' y se registra la fecha en el campo fecha_elim para indicar que el usuario fue eliminado.
     * ? Descripcion de get_usuario
     * El método get_usuario() se encarga de obtener los usuarios almacenados en la base de datos. Utiliza un procedimiento almacenado llamado sp_l_usuario_01() que devuelve una lista de usuarios y sus datos. La lista se obtiene mediante el método fetchAll() de PDO y se devuelve como resultado de la función.
     * ? Descripcion de get_usuario_x_rol
     * Este método parece ser una función que obtiene información de usuarios en una base de datos. La función utiliza una llamada de procedimiento almacenado para recuperar información de usuarios cuyo rol es 2 y cuyo estado es 1. Una vez ejecutado, la función devuelve un conjunto de resultados que representan a los usuarios que cumplen con los criterios de búsqueda.
     * ? Descripcion de get_usuario_x_id
     *  Esta función busca un usuario en la base de datos mediante su identificador ($usu_id) y devuelve todos los resultados encontrados. Utiliza un procedimiento almacenado llamado "sp_l_usuario_02" que se encarga de ejecutar la consulta SQL para obtener los datos del usuario.
     * ? Descripcion de get_usuario_total_x_id
     *  Este código se encarga de obtener el total de tickets asignados a un usuario específico. Para ello, se utiliza una consulta SQL que cuenta el número de tickets que tienen el ID de usuario dado. La consulta se prepara y ejecuta utilizando una conexión a la base de datos, y luego se devuelve el resultado obtenido.
     * ? Descripcion de get_usuario_totalabierto_x_id
     *  Este método se utiliza para contar el número total de tickets abiertos que ha creado un usuario específico. Para ello, se realiza una consulta a la base de datos en la tabla "tm_ticket" y se cuenta el número de registros que cumplan con la condición de que el identificador del usuario sea igual al especificado y el estado del ticket sea "Abierto". La información obtenida se devuelve como un resultado.
     * ? Descripcion de get_usuario_totalcerrado_x_id
     * Esta función obtiene el total de tickets cerrados para un usuario específico. Hace una consulta a la tabla de tickets, filtrando por el identificador del usuario y el estado del ticket, y cuenta cuántos registros cumplen con estos criterios. Finalmente, retorna el resultado de la consulta.
     * ? Descripcion de get_usuario_grafico
     * La función toma el identificador del usuario como argumento y utiliza una consulta preparada para ejecutar una llamada a un procedimiento almacenado en la base de datos que utiliza ese identificador para obtener la información deseada. Luego devuelve el resultado de la consulta en forma de matriz.
     * ? Descripcion de update_usuario_pass
     * Esta función actualiza la contraseña de un usuario en la base de datos. Utiliza el ID del usuario y la nueva contraseña como parámetros y luego ejecuta una consulta SQL para actualizar la contraseña en la base de datos
     * @return void
     * @author Matias
     */
    public function login()
    {
        $conectar = parent::conexion();
        // Para el tema de caracteres
        parent::set_names();
        // Vamos a preguntar con un metodo post si es igual a enviar tome los parametros que se estan enviando desde el login
        if (isset($_POST["enviar"])) {
            $correo = $_POST["usu_correo"];
            $pass = $_POST["usu_pass"];
            $rol = $_POST["rol_id"];


            // Si correo y Pass estan vacios mandaremos un retorno al index.php con una mensaje de error
            if (empty($correo) and empty($pass)) {
                header("Location:" . conectar::ruta() . "index.php?m=2");
                exit();

                // En caso de que no sea asi ejectuaremos la validacion con una sentencia Sql . Tambien utilizamos estado para ver si la cuenta esta activa o inactiva
            } else {
                $sql = "SELECT * FROM tm_usuario WHERE usu_correo=? and usu_pass=MD5(?)  and rol_id=? and estado=1"; #and rol_id=?
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $correo);
                $stmt->bindValue(2, $pass);
                $stmt->bindValue(3, $rol);
                $stmt->execute();
                // Guardaremos lo ejecutado en una variable resultado. 
                $resultado = $stmt->fetch();

                // Si devuelve datos 
                if (is_array($resultado) and count($resultado) > 0) {
                    // Variables de Session 
                    $_SESSION["usu_id"] = $resultado["usu_id"];
                    $_SESSION["usu_nom"] = $resultado["usu_nom"];
                    $_SESSION["usu_ape"] = $resultado["usu_ape"];
                    $_SESSION["rol_id"] = $resultado["rol_id"];
                    // Hace la conexion y dirige al Home
                    header("Location:" . Conectar::ruta() . "view/Home/");
                    exit();

                    // Si no devuelve datos generara mensaje de error 1 
                } else {
                    header("Location:" . Conectar::ruta() . "index.php?m=1");
                    exit();
                }
            }
        }
    }


    // CRUD Para Usuarios                      --- Mantenimiento ----


    public function insert_usuario($usu_nom, $usu_ape, $usu_correo, $usu_pass, $rol_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // Encriptar Contraseñas
        $sql = "INSERT INTO tm_usuario (usu_id, usu_nom, usu_ape, usu_correo, usu_pass, rol_id, fecha_crea, fecha_modi, fecha_elim, estado) VALUES (NULL,?,?,?,MD5(?),?,now(), NULL, NULL, '1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_nom);
        $sql->bindValue(2, $usu_ape);
        $sql->bindValue(3, $usu_correo);
        $sql->bindValue(4, $usu_pass);
        $sql->bindValue(5, $rol_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function update_usuario($usu_id, $usu_nom, $usu_ape, $usu_correo, $usu_pass, $rol_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario set
                usu_nom = ?,
                usu_ape = ?,
                usu_correo = ?,
                usu_pass = MD5(?),
                rol_id = ?,
                fecha_modi=now()
                WHERE
                usu_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_nom);
        $sql->bindValue(2, $usu_ape);
        $sql->bindValue(3, $usu_correo);
        $sql->bindValue(4, $usu_pass);
        $sql->bindValue(5, $rol_id);
        $sql->bindValue(6, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function delete_usuario($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario SET estado='0', fecha_elim=now() where usu_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    // Store Procedure Medidas de Seguridad  // Procedimientos Almacenados 

    # ANTES  $sql="SELECT * FROM tm_usuario where estado='1'";   ------> Cambiar a Procedimientos almacenados     Resultado Final    $sql="call sp_l_usuario_01()";
    public function get_usuario()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call sp_l_usuario_01()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    // Esto se usara para el Modal a la hora de asignar
    public function get_usuario_x_rol()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_usuario where estado=1 and rol_id=2";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    // Para traer los datos por id de usuario
    public function get_usuario_x_id($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call sp_l_usuario_02(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_usuario_total_x_id($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_usuario_totalabierto_x_id($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Abierto'";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_usuario_totalcerrado_x_id($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Cerrado'";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_usuario_grafico($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE    
                tm_ticket.est = 1
                and tm_ticket.usu_id = ?
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }



    // Para cambiar la contraseña 
    public function update_usuario_pass($usu_id, $usu_pass)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario
                SET
                    usu_pass = MD5(?)
                WHERE
                    usu_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_pass);
        $sql->bindValue(2, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }





}
?>