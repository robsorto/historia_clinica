<?php
require_once "../modelos/Exportar.php";

$export = new Exportar();

switch ($_GET["op"]) {

    case "exportarTodo":
        echo json_encode($export->exportarTodo());
        break;
}
