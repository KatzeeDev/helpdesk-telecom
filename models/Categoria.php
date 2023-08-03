<?php
class Categoria extends Conectar
{
    /**
     *? Descripcion de get_categoria
     *  Esta función realiza una consulta a la base de datos y obtiene una lista de todas las categorías que estén activas (con un estado igual a 1) en la tabla "tm_categoria".
     * @return array
     * @author Matias
     */
    public function get_categoria()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_categoria WHERE estado=1;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}
?>