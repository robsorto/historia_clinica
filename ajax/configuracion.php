<?php 
require_once "../modelos/Configuracion.php";

$configuracion=new Configuracion();

$idconfiguracion=isset($_POST["idconfiguracion"])? limpiarCadena($_POST["idconfiguracion"]):"";
$razon_social=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
$ruc=isset($_POST["ruc"])? limpiarCadena($_POST["ruc"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$responsable=isset($_POST["responsable"])? limpiarCadena($_POST["responsable"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idconfiguracion)){
			$rspta=$configuracion->insertar(0,$razon_social,$ruc,$email,$telefono,$direccion,$responsable);
			echo $rspta ? "configuracion registrado" : "configuracion no se pudo registrar";
		}
		else {
			$rspta=$configuracion->editar($idconfiguracion,$razon_social,$ruc,$email,$telefono,$direccion,$responsable);
			echo $rspta ? "configuracion actualizado" : "configuracion no se pudo actualizar";
		}
	break;
	case 'mostrar':
		$rspta=$configuracion->mostrar($idconfiguracion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$configuracion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button title="Editar" class="btn btn-warning" onclick="mostrar('.$reg->idconfiguracion.')"><i class="fa fa-pencil"></i></button>',
 				"1"=>$reg->razon_social,
 				"2"=>$reg->ruc,
 				"3"=>$reg->email,
 				"4"=>$reg->telefono,
 				"5"=>$reg->direccion,
 				"6"=>$reg->responsable
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