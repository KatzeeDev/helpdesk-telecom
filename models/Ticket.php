<?php
class Ticket extends Conectar
{
    /**
     * ? Descripcion de insert_ticket
     * La función recibe como parámetros información sobre el usuario que crea el ticket, la categoría y subcategoría a la que pertenece, el título y descripción del ticket, y la prioridad del ticket. 
     * La función luego construye una consulta SQL que se utiliza para insertar una nueva fila en la tabla "tm_ticket" con la información del ticket especificada en los parámetros. 
     * En resumen, esta función inserta un nuevo ticket en la tabla "tm_ticket" de la base de datos. Además, la función también devuelve el "tick_id" del ticket recién creado.
     * ? Descripcion de listar_ticket_x_usu
     * Esta función obtiene y devuelve una lista de todos los tickets creados por el usuario especificado por su "usu_id", junto con información adicional de las tablas relacionadas.
     * ? Descripcion de listar_ticket_x_id
     * La función recibe como parámetro el "tick_id" de un ticket específico. 
     * La función luego construye una consulta SQL que se utiliza para obtener el ticket especificado por su "tick_id" y que esté activo (con un valor de "est" igual a 1) en la tabla "tm_ticket".
     * La consulta SQL también une información de otras tablas relacionadas, como "tm_categoria", "tm_subcategoria", "tm_usuario" y "tm_prioridad", para obtener información adicional sobre el ticket. 
     * En resumen, esta función obtiene y devuelve información detallada sobre el ticket especificado por su "tick_id", junto con información adicional de las tablas relacionadas.
     * ? Descripcion de listar_ticket
     * Esta función obtiene y devuelve una lista de todos los tickets activos en la base de datos, junto con información adicional de las tablas relacionadas.
     * ? Descripcion de listar_ticketdetalle_x_ticket
     * Esta función obtiene y devuelve una lista de todos los detalles del ticket especificado por su "tick_id", junto con información adicional de la tabla "tm_usuario".
     * ? Descripcion de insert_ticketdetalle
     * Esta función inserta un nuevo detalle de ticket en la base de datos y devuelve un resultado de la operación de inserción.
     * ? Descripcion de insert_ticketdetalle_cerrar
     * Esta función inserta un nuevo detalle de ticket en la base de datos, cierra el ticket especificado por su "tick_id" y devuelve un resultado de la operación de inserción.
     * ? Descripcion de insert_ticketdetalle_reabrir
     * Esta función inserta un nuevo detalle de ticket en la base de datos, reabre el ticket especificado por su "tick_id" y devuelve un resultado de la operación de inserción.
     * ? Descripcion de update_ticket
     * Esta función cambia el estado de un ticket a "Cerrado" en la base de datos y devuelve un resultado de la operación de actualización.
     * ? Descripcion de reabrir_ticket
     * Esta función cambia el estado de un ticket a "Abierto" en la base de datos y devuelve un resultado de la operación de actualización.
     * ? Descripcion de update_ticket_asignacion
     * Esta función actualiza el ticket especificado en el primer argumento, asignando el usuario especificado en el segundo argumento como el usuario encargado del ticket y estableciendo la fecha y hora actual como la fecha y hora de asignación del ticket. La función devuelve una lista de los resultados de la actualización del ticket.
     * ? Descripcion de get_ticket_total
     * La función get_ticket_total recupera el número total de tickets existentes en la base de datos. Para ello, cuenta el número de filas en la tabla tm_ticket y devuelve el resultado como un valor numérico en un arreglo con un solo elemento.
     * ? Descripcion de get_ticket_totalabierto
     * Este método retorna un conteo del total de tickets que están abiertos en la base de datos. Utiliza una sentencia SQL para seleccionar todas las filas de la tabla tm_ticket donde el campo tick_estado es igual a 'Abierto'. Luego, utiliza una cláusula de agregación para contar el número de filas en el conjunto de resultados y retorna el resultado.
     * ? Descripcion de get_ticket_totalcerrado
     * Esta función se encarga de realizar una consulta a una base de datos para obtener el total de tickets cerrados. La consulta específica se realiza sobre la tabla "tm_ticket" y filtra los tickets cuyo estado es "Cerrado". El resultado de la consulta se retorna en una variable. 
     * ? Descripcion de get_ticket_grafico
     * Esta función, llamada get_ticket_grafico, parece ser parte de un sistema de gestión de tickets. La función realiza una consulta a la base de datos para obtener información sobre las categorías de tickets existentes y el número de tickets que existen en cada categoría. La consulta agrupa los tickets por categoría y luego ordena el resultado por el número total de tickets en cada categoría. La función devuelve los resultados de la consulta para ser utilizados en un grafico para la visualizacion de datos.
     * @param mixed $usu_id
     * @param mixed $cat_id
     * @param mixed $cats_id
     * @param mixed $tick_titulo
     * @param mixed $tick_descrip
     * @param mixed $prio_id
     * @return array
     * @author Matias
     */

    public function insert_ticket($usu_id, $cat_id, $cats_id, $tick_titulo, $tick_descrip, $prio_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO tm_ticket (tick_id,usu_id,cat_id,cats_id,tick_titulo,tick_descrip,tick_estado,fech_crea,usu_asig,fech_asig,prio_id,est) VALUES (NULL,?,?,?,?,?,'Abierto',now(),NULL,NULL,?,'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->bindValue(2, $cat_id);
        $sql->bindValue(3, $cats_id);
        $sql->bindValue(4, $tick_titulo);
        $sql->bindValue(5, $tick_descrip);
        $sql->bindValue(6, $prio_id);
        $sql->execute();

        $sql1 = "select last_insert_id() as 'tick_id';";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $resultado = $sql1->fetchAll(pdo::FETCH_ASSOC);
    }

    public function listar_ticket_x_usu($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_estado,
                tm_ticket.fech_crea,
                tm_ticket.fech_cierre,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_categoria.cat_nom,
                tm_ticket.prio_id,
                tm_prioridad.prio_nom
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                INNER join tm_prioridad on tm_ticket.prio_id = tm_prioridad.prio_id
                WHERE
                tm_ticket.est = 1
                AND tm_usuario.usu_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    // Usaremos esto para el detalle de Ticket
    public function listar_ticket_x_id($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.cats_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_estado,
                tm_ticket.fech_crea,
                tm_ticket.fech_cierre,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_categoria.cat_nom,
                tm_subcategoria.cats_nom,
                tm_ticket.prio_id,
                tm_prioridad.prio_nom
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_subcategoria on tm_ticket.cats_id = tm_subcategoria.cats_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                INNER join tm_prioridad on tm_ticket.prio_id = tm_prioridad.prio_id
                WHERE
                tm_ticket.est = 1
                AND tm_ticket.tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listar_ticket()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_estado,
                tm_ticket.fech_crea,
                tm_ticket.fech_cierre,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_categoria.cat_nom,
                tm_ticket.prio_id,
                tm_prioridad.prio_nom
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                INNER join tm_prioridad on tm_ticket.prio_id = tm_prioridad.prio_id
                WHERE
                tm_ticket.est = 1
                ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listar_ticketdetalle_x_ticket($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT
                td_ticketdetalle.tickd_id,
                td_ticketdetalle.tickd_descrip,
                td_ticketdetalle.fech_crea,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.rol_id
                FROM 
                td_ticketdetalle
                INNER join tm_usuario on td_ticketdetalle.usu_id = tm_usuario.usu_id
                WHERE 
                tick_id =?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function insert_ticketdetalle($tick_id, $usu_id, $tickd_descrip)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO td_ticketdetalle (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) VALUES (NULL,?,?,?,now(),'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->bindValue(3, $tickd_descrip);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }



    // 
    public function insert_ticketdetalle_cerrar($tick_id, $usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call sp_i_ticketdetalle_01(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insert_ticketdetalle_reabrir($tick_id, $usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "	INSERT INTO td_ticketdetalle 
                    (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) 
                    VALUES 
                    (NULL,?,?,'El ticket ha sido Re-Abierto...',now(),'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    // Para establecer el estado del ticket como cerrado
    public function update_ticket($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                set	
                    tick_estado = 'Cerrado',
                    fech_cierre = now()
                where
                    tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    // Para Reabrir un Ticket
    public function reabrir_ticket($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                set	
                    tick_estado = 'Abierto'
                where
                    tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    // Para realizar la asignacion de personal
    public function update_ticket_asignacion($tick_id, $usu_asig)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                set	
                    usu_asig = ?,
                    fech_asig = now()
                where
                    tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_asig);
        $sql->bindValue(2, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }



    // Para el Home Estadisticas/Graficos      

    public function get_ticket_total()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_totalabierto()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket where tick_estado='Abierto'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_totalcerrado()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket where tick_estado='Cerrado'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_grafico()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE    
                tm_ticket.est = 1
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }



}
?>