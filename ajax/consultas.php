<?php
require_once "../modelos/Consultas.php";

$consultas = new Consultas();

switch ($_GET["op"]) {
	case 'listar':
		$fechainicio = $_GET['fechainicio'];
		$fechafin = $_GET['fechafin'];
		$rspta = $consultas->listar($fechainicio, $fechafin);
		//Vamos a declarar un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->fecha . ' - ' . $reg->hora,
				"1" => $reg->registrador,
				"2" => $reg->servicio,
				"3" => $reg->especialista,
				"4" => $reg->paciente,
				"5" => $reg->costo,
				"6" => ($reg->estado == 'Registrado') ? '<span class="label bg-green">Registrado</span>' : (($reg->estado == 'En Espera') ? '<span class="label bg-orange">En Espera</span>' : '<span class="label bg-primary">Atendido</span>')
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;

	case 'listarHistorias':
		$fechainicio = $_GET['fechainicio'];
		$fechafin = $_GET['fechafin'];
		$rspta = $consultas->listarHistorias($fechainicio, $fechafin);
		//Vamos a declarar un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->fecha . ' - ' . $reg->hora,
				"1" => $reg->registrador,
				"2" => $reg->servicio,
				"3" => $reg->especialista,
				"4" => $reg->paciente,
				"5" => $reg->costo,
				"6" => '<a target="_blank" href="../reportes/historia.php?idatencion=' . $reg->idatencion . '" ><button title="Historia Clínicas" class="btn btn-info"><i class="fa fa-file"></i></button></a>'
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;

	case 'listarPrenatal':
		$fechainicio = $_GET['fechainicio'];
		$fechafin = $_GET['fechafin'];
		$rspta = $consultas->listarPrenatal($fechainicio, $fechafin);
		$data = array();
		if (!is_null($rspta) || !empty($rspta)) {
			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0" => $reg->fecha . ' - ' . $reg->hora,
					"1" => $reg->paciente,
					"2" => $reg->servicio,
					"3" => $reg->especialista,
					"4" => $reg->costo,
					"5" => ($reg->estado == 'Registrado') ? '<span class="label bg-green">Registrado</span>' : (($reg->estado == 'En Espera') ? '<span class="label bg-orange">En Espera</span>' : '<span class="label bg-primary">Atendido</span>'),
					"6" => $reg->estado_consulta,
					"7" => '<a target="_blank" href="../reportes/prenatal.php?idpaciente='
						. $reg->idpersona . '&idobstetrica=' . $reg->id_obstetrica . '" ><button title="Historia Control Prenatal" class="btn btn-info">
					<i class="fa fa-file"></i></button></a>'
				);
			}
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;
	case 'listarGinecologia':
		$fechainicio = $_GET['fechainicio'];
		$fechafin = $_GET['fechafin'];
		$rspta = $consultas->listarGinecologia($fechainicio, $fechafin);
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->fecha . ' - ' . $reg->hora,
				"1" => $reg->paciente,
				"2" => $reg->servicio,
				"3" => $reg->especialista,
				"4" => $reg->costo,
				"5" => ($reg->estado == 'Registrado') ? '<span class="label bg-green">Registrado</span>' : (($reg->estado == 'En Espera') ? '<span class="label bg-orange">En Espera</span>' : '<span class="label bg-primary">Atendido</span>'),
				"6" => '<a target="_blank" href="../reportes/ginecologia.php?idginecologia=' . $reg->id_ginecologia . '" ><button title="Historia Ginecologia" class="btn btn-info">
					<i class="fa fa-file"></i></button></a>'
			);
		}

		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
}
