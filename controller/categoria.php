<?php
require_once("../config/conexion.php");
require_once("../models/Categoria.php");
$categoria = new Categoria();

switch ($_GET["op"]) {
    case "combo":
        $datos = $categoria->get_categoria();
        $html = "";
        $html .= "<option label='Seleccionar'></option>";
        // Nos aseguramos que la variable tenga datos
        if (is_array($datos) == true and count($datos) > 0) {
            // Creamos un for each por el tema de la cantidad de datos
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['cat_id'] . "'>" . $row['cat_nom'] . "</option>";
            }
            echo $html;
        }
        break;
}
?>