<?php 
require_once "../modelos/Diagnostico.php";

$diagnostico=new Diagnostico();

$iddiagnostico=isset($_POST["iddiagnostico"])? limpiarCadena($_POST["iddiagnostico"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$enfermedad=isset($_POST["enfermedad"])? limpiarCadena($_POST["enfermedad"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($iddiagnostico)){
			$rspta=$diagnostico->insertar($codigo,$enfermedad);
			echo $rspta ? "Diagnóstico registrado" : "Diagnóstico no se pudo registrar";
		}
		else {
			$rspta=$diagnostico->editar($iddiagnostico,$codigo,$enfermedad);
			echo $rspta ? "Diagnóstico actualizado" : "Diagnóstico no se pudo actualizar";
		}
	break;

	case 'eliminar':
		$rspta=$diagnostico->eliminar($iddiagnostico);
 		echo $rspta ? "Diagnóstico eliminado" : "Diagnóstico no se puede eliminar";
	break;
	case 'mostrar':
		$rspta=$diagnostico->mostrar($iddiagnostico);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$texto=$_GET['texto'];
		$rspta=$diagnostico->listar($texto);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button title="Editar" class="btn btn-warning" onclick="mostrar('.$reg->iddiagnostico.')"><i class="fa fa-pencil"></i></button>'.
 					' <button title="Eliminar" class="btn btn-danger" onclick="eliminar('.$reg->iddiagnostico.')"><i class="fa fa-close"></i></button>',
 				"1"=>$reg->codigo,
 				"2"=>$reg->enfermedad
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>