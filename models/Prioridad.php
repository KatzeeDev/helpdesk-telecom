<?php
class Prioridad extends Conectar
{
    /**
     * ? Descripcion de get_prioridad
     * La función construye una consulta SQL que se utiliza para obtener todas las filas de la tabla "tm_prioridad" cuyo valor en la columna "est" sea igual a 1. 
     * En resumen, esta función obtiene y devuelve una lista de todas las prioridades que estén activas (con un valor de "est" igual a 1) en la tabla "tm_prioridad".
     * @return array
     * @author Matias
     */

    public function get_prioridad()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_prioridad WHERE est=1;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}
?>