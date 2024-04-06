<?php
require_once "../modelos/Ginecologia.php";

$ginecologia = new Ginecologia();

$idatencion = isset($_POST["idatencion"]) ? limpiarCadena($_POST["idatencion"]) : "";


switch ($_GET["op"]) {
    case "mostrarDatosGinecologia":
        $res = $ginecologia->obtenerGinecologia($idatencion);
        echo json_encode($res);
        break;
}
