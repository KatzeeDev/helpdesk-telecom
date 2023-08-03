<?php
class Documento extends Conectar
{
    /**
     * ? Descripcion de insert_documento
     * La función recibe como parámetros el "tick_id" y el "doc_nom" del documento que se va a insertar en la tabla. 
     * La función luego construye una consulta SQL que se utiliza para insertar una nueva fila en la tabla "td_documento" con los datos del documento especificados en los parámetros.
     * ? Descripcion de get_documento_x_ticket
     * La función recibe como parámetro el "tick_id" de un ticket específico.
     * La función luego construye una consulta SQL que se utiliza para obtener todos los documentos en la tabla "td_documento" que tengan el "tick_id" especificado en el parámetro. 
     * En resumen, esta función obtiene y devuelve una lista de todos los documentos relacionados con el ticket especificado por su "tick_id".
     * @param mixed $tick_id
     * @param mixed $doc_nom
     * @return void
     * @author Matias
     */
    public function insert_documento($tick_id, $doc_nom)
    {
        $conectar = parent::conexion();
        // Consulta SQL
        $sql = "INSERT INTO td_documento (doc_id,tick_id,doc_nom,fech_crea,est) VALUES (null,?,?,now(),1);";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(1, $tick_id);
        $sql->bindParam(2, $doc_nom);
        $sql->execute();
    }

    public function get_documento_x_ticket($tick_id)
    {
        $conectar = parent::conexion();
        // Consulta SQL
        $sql = "SELECT * FROM td_documento WHERE tick_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
    }
}
?>