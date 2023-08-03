<?php
// Llamamos la clases que necesitamos
require_once("../config/conexion.php");
require_once("../models/documento.php");
$documento = new Documento();

//  Opciones del Controlador
switch ($_GET["op"]) {
    // Hacemos Manejo de Json Para Poder Listar en el Datatable, formato de json segun documentacion
    case "listar":
        $datos = $documento->get_documento_x_ticket($_POST["tick_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            // Array usando un Href con la ruta donde se encuentran los archivos segun el ticket id
            $sub_array[] = '<a href="../../public/document/' . $_POST["tick_id"] . '/' . $row["doc_nom"] . '" target="_blank">' . $row["doc_nom"] . '</a>';
            // Icono 
            $sub_array[] = '<a type="button" href="../../public/document/' . $_POST["tick_id"] . '/' . $row["doc_nom"] . '" target="_blank" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></a>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;
}
?>