<?php
class Subcategoria extends Conectar
{
    /**
     * ? Descripcion de get_subcategoria
     *  La función recibe como parámetro el "cat_id" de una categoría específica. 
     * La función construye una consulta SQL que se utiliza para obtener todas las filas de la tabla "tm_subcategoria" que tengan el "cat_id" especificado en el parámetro y cuyo valor en la columna "est" sea igual a 1.
     *  En resumen, esta función obtiene y devuelve una lista de todas las subcategorías que pertenecen a la categoría especificada por su "cat_id" y que estén activas (con un valor de "est" igual a 1) en la tabla "tm_subcategoria".
     * @param mixed $cat_id
     * @return array
     * @author Matias
     */
    public function get_subcategoria($cat_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_subcategoria WHERE cat_id=? AND est=1;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cat_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}
?>