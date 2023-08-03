<?php
    require_once("../../config/conexion.php");
    /*  Destruir Session */
    session_destroy();
    /*Luego de cerrar session enviar a la pantalla de login */
    header("Location:".Conectar::ruta()."index.php");
    exit();
?>