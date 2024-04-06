<?php
require_once "../modelos/Resultado.php";
require_once "../modelos/Obstetrica.php";
require_once "../modelos/Ginecologia.php";
require_once "../modelos/Diagnostico.php";

$resultado = new Resultado();
$obstetrica = new Obstetrica();
$ginecologia = new Ginecologia();
$diagnostico = new Diagnostico();

//DATOS DE OBSTETRICA START
$paridadObs = isset($_POST['paridadPaciente']) ? limpiarCadena($_POST['paridadPaciente']) : "";
$fur = isset($_POST['furPaciente']) ? limpiarCadena($_POST['furPaciente']) : "";
$fpp = isset($_POST['fppPaciente']) ? limpiarCadena($_POST['fppPaciente']) : "";
$amenorrea = isset($_POST['amenorreoPaciente']) ? limpiarCadena($_POST['amenorreoPaciente']) : "";
$gestional = isset($_POST['eGestionalPaciente']) ? limpiarCadena($_POST['eGestionalPaciente']) : "";
$talla = isset($_POST['tallaPaciente']) ? limpiarCadena($_POST['tallaPaciente']) : "";
$imc = isset($_POST['imcPaciente']) ? limpiarCadena($_POST['imcPaciente']) : "";
$tipeo = isset($_POST['tipeoPaciente']) ? limpiarCadena($_POST['tipeoPaciente']) : "";
$egh = isset($_POST['eghPaciente']) ? limpiarCadena($_POST['eghPaciente']) : "";
$vdrl = isset($_POST['vdrlPaciente']) ? limpiarCadena($_POST['vdrlPaciente']) : "";
$vhi = isset($_POST['vhiPaciente']) ? limpiarCadena($_POST['vhiPaciente']) : "";
$pap = isset($_POST['papPaciente']) ? limpiarCadena($_POST['papPaciente']) : "";
$seguro = isset($_POST['seguroPaciente']) ? limpiarCadena($_POST['seguroPaciente']) : "";
$hto1 = isset($_POST['hto1Paciente']) ? limpiarCadena($_POST['hto1Paciente']) : "";
$hto2 = isset($_POST['hto2Paciente']) ? limpiarCadena($_POST['hto2Paciente']) : "";
$hb1 = isset($_POST['hb1Paciente']) ? limpiarCadena($_POST['hb1Paciente']) : "";
$hb2 = isset($_POST['hb2Paciente']) ? limpiarCadena($_POST['hb2Paciente']) : "";
$glisema1 = isset($_POST['glisema1Paciente']) ? limpiarCadena($_POST['glisema1Paciente']) : "";
$glisema2 = isset($_POST['glisema2Paciente']) ? limpiarCadena($_POST['glisema2Paciente']) : "";
$ego1 = isset($_POST['ego1Paciente']) ? limpiarCadena($_POST['ego1Paciente']) : "";
$ego2 = isset($_POST['ego2Paciente']) ? limpiarCadena($_POST['ego2Paciente']) : "";
$antecedentesPaciente = isset($_POST['antecedentesPacienteObs']) ? limpiarCadena($_POST['antecedentesPacienteObs']) : "";
$vacunas = isset($_POST['vacunaPaciente']) ? limpiarCadena($_POST['vacunaPaciente']) : "";
$otros = isset($_POST['otrosPaciente']) ? limpiarCadena($_POST['otrosPaciente']) : "";
$examenFisicoOBS = isset($_POST['examen_fisicoOBS']) ? limpiarCadena($_POST['examen_fisicoOBS']) : "";
$alergiasObs = isset($_POST['alergiasObs']) ? limpiarCadena($_POST['alergiasObs']) : "";
//DATOS DE OBSTETRICA END

//DATOS DE GINECOLOGIA START
$paridadGine = isset($_POST['paridadPacienteG']) ? limpiarCadena($_POST['paridadPacienteG']) : "";
$fecharegla = isset($_POST['furPacienteG']) ? limpiarCadena($_POST['furPacienteG']) : "";
$fechaparto = isset($_POST['fupPacienteG']) ? limpiarCadena($_POST['fupPacienteG']) : "";
$climaterio = isset($_POST['climaterioPacienteG']) ? limpiarCadena($_POST['climaterioPacienteG']) : "";
$menarquia = isset($_POST['menarquiaPacienteG']) ? limpiarCadena($_POST['menarquiaPacienteG']) : "";
$menopausia = isset($_POST['menopausiaPacienteG']) ? limpiarCadena($_POST['menopausiaPacienteG']) : "";
$metdfamiliar = isset($_POST['mpfPacienteG']) ? limpiarCadena($_POST['mpfPacienteG']) : "";
$ciclosregulares = isset($_POST['cmrPacienteG']) ? limpiarCadena($_POST['cmrPacienteG']) : "";
$ultmcitologia = isset($_POST['ultpapPacienteG']) ? limpiarCadena($_POST['ultpapPacienteG']) : "";
$consultarpor = isset($_POST['cxPacienteG']) ? limpiarCadena($_POST['cxPacienteG']) : "";
$presentaenfermedade = isset($_POST['pePacienteG']) ? limpiarCadena($_POST['pePacienteG']) : "";
//---ANTECEDENTES
$antecedentesmedic = isset($_POST['medicosPacienteG']) ? limpiarCadena($_POST['medicosPacienteG']) : "";
$antecedentesquirurgico = isset($_POST['quirurgicosPacienteG']) ? limpiarCadena($_POST['quirurgicosPacienteG']) : "";
$ultrasonografia = isset($_POST['ultraPacienteG']) ? limpiarCadena($_POST['ultraPacienteG']) : "";
$mamografia = isset($_POST['mamografiasPacienteG']) ? limpiarCadena($_POST['mamografiasPacienteG']) : "";
//---EXAMEN FISICO P1
$tensionarterial = isset($_POST['taPacienteG']) ? limpiarCadena($_POST['taPacienteG']) : "";
$frecucardiaca = isset($_POST['fcPacienteG']) ? limpiarCadena($_POST['fcPacienteG']) : "";
$frecurespiratoria = isset($_POST['frPacienteG']) ? limpiarCadena($_POST['frPacienteG']) : "";
$temperaturaPaciente = isset($_POST['temPacienteG']) ? limpiarCadena($_POST['temPacienteG']) : "";
$peso = isset($_POST['pesoPacienteG']) ? limpiarCadena($_POST['pesoPacienteG']) : "";
$talla = isset($_POST['tallaPacienteG']) ? limpiarCadena($_POST['tallaPacienteG']) : "";
//----EXAMEN FISICO P2
$cabeza = isset($_POST['cabezaPacienteG']) ? limpiarCadena($_POST['cabezaPacienteG']) : "";
$cuello = isset($_POST['cuelloPacienteG']) ? limpiarCadena($_POST['cuelloPacienteG']) : "";
$torax = isset($_POST['toraxPacienteG']) ? limpiarCadena($_POST['toraxPacienteG']) : "";
$abdomen = isset($_POST['abdomenPacienteG']) ? limpiarCadena($_POST['abdomenPacienteG']) : "";
$gentlesexternos = isset($_POST['gePacienteG']) ? limpiarCadena($_POST['gePacienteG']) : "";
$especulo = isset($_POST['spPacienteG']) ? limpiarCadena($_POST['spPacienteG']) : "";
$impdiagnost = isset($_POST['indiagPacienteG']) ? limpiarCadena($_POST['indiagPacienteG']) : "";
$tratamientoGINE = isset($_POST['trataPacienteG']) ? limpiarCadena($_POST['trataPacienteG']) : "";
$proximacita = isset($_POST['pCitaPacienteG']) ? limpiarCadena($_POST['pCitaPacienteG']) : "";
$examenFisicoGINE = isset($_POST['examen_fisicoGINE']) ? limpiarCadena($_POST['examen_fisicoGINE']) : "";
$alergiasGINE = isset($_POST['alerPacienteG']) ? limpiarCadena($_POST['alerPacienteG']) : "";
//DATOS DE GINECOLOGIA END

$idresultado = isset($_POST["idresultado"]) ? limpiarCadena($_POST["idresultado"]) : "";
$idatencion = isset($_POST["idatencion"]) ? limpiarCadena($_POST["idatencion"]) : "";

//Datos para actualizar el triaje
$presion_arterial = isset($_POST["presion_arterial"]) ? limpiarCadena($_POST["presion_arterial"]) : "";
$temperatura = isset($_POST["temperatura"]) ? limpiarCadena($_POST["temperatura"]) : "";
$frecuencia_respiratoria = isset($_POST["frecuencia_respiratoria"]) ? limpiarCadena($_POST["frecuencia_respiratoria"]) : "";
$frecuencia_cardiaca = isset($_POST["frecuencia_cardiaca"]) ? limpiarCadena($_POST["frecuencia_cardiaca"]) : "";
$saturacion = isset($_POST["saturacion"]) ? limpiarCadena($_POST["saturacion"]) : "";
$peso = isset($_POST["pesoT"]) ? limpiarCadena($_POST["pesoT"]) : "";
$talla = isset($_POST["tallaT"]) ? limpiarCadena($_POST["tallaT"]) : "";
$imc = isset($_POST["imcT"]) ? limpiarCadena($_POST["imcT"]) : "";

//Datos para insertar el resultado
$motivo_consulta = isset($_POST["motivo_consulta"]) ? limpiarCadena($_POST["motivo_consulta"]) : "";
$tiempo_enfermedad = isset($_POST["tiempo_enfermedad"]) ? limpiarCadena($_POST["tiempo_enfermedad"]) : "";
$antecedentes = isset($_POST["antecedentes"]) ? limpiarCadena($_POST["antecedentes"]) : "";
$examen_fisico = isset($_POST["examen_fisico"]) ? limpiarCadena($_POST["examen_fisico"]) : "";
$tratamiento = isset($_POST["tratamiento"]) ? limpiarCadena($_POST["tratamiento"]) : "";
$proxima_cita = isset($_POST["proxima_cita"]) ? limpiarCadena($_POST["proxima_cita"]) : "";
$plan = isset($_POST["plan"]) ? limpiarCadena($_POST["plan"]) : "";
$tel_ref = isset($_POST["tel_ref"]) ? limpiarCadena($_POST["tel_ref"]) : "";
$nombre_ref = isset($_POST["nombre_ref"]) ? limpiarCadena($_POST["nombre_ref"]) : "";
$fecha_in_enfer = isset($_POST["fecha_in_mal"]) ? limpiarCadena($_POST["fecha_in_mal"]) : "";
$padece_enfermedades = isset($_POST["p_enfermedades"]) ? limpiarCadena($_POST["p_enfermedades"]) : "";
$toma_medicamento = isset($_POST["toma_medicamento"]) ? limpiarCadena($_POST["toma_medicamento"]) : "";

//Datos que se actualizaran en el paciente
$alergia = isset($_POST["alergia"]) ? limpiarCadena($_POST["alergia"]) : "";
$intervenciones_quirurgicas = isset($_POST["intervenciones_quirurgicas"]) ? limpiarCadena($_POST["intervenciones_quirurgicas"]) : "";
$vacunas_completas = isset($_POST["vacunas_completas"]) ? limpiarCadena($_POST["vacunas_completas"]) : "";

$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
//GUARDAR EL TIPO DE CONSULTA GENERADO
$TIPO__CONSULTA = isset($_POST["tipoConsulta"]) ? limpiarCadena($_POST["tipoConsulta"]) : "";

//OBTENER ID OBSTETRICA
$idobstetricaPaciente = isset($_POST['idobstetricaPacienteGnrl']) ? limpiarCadena($_POST['idobstetricaPacienteGnrl']) : "";

//DATOS PARA LA CONSULTA GENERAL
$fechainimal = isset($_POST['fecha_in_mal']) ? limpiarCadena($_POST['fecha_in_mal']) : "";
$tomamedic = isset($_POST['toma_medicamento']) ? limpiarCadena($_POST['toma_medicamento']) : "";
$padeceenfer = isset($_POST['p_enfermedades']) ? limpiarCadena($_POST['p_enfermedades']) : "";
$telref = isset($_POST['tel_ref']) ? limpiarCadena($_POST['tel_ref']) : "";
$nomref = isset($_POST['nombre_ref']) ? limpiarCadena($_POST['nombre_ref']) : "";

//ID GINECOLOGIA PARA ACTUALIZAR REGISTRO
$idginecologia = isset($_POST['idginecologia']) ? limpiarCadena($_POST['idginecologia']) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idresultado)) {
			$rspta = $resultado->insertar(
				$idatencion,
				$TIPO__CONSULTA,
				$motivo_consulta,
				$tiempo_enfermedad,
				$antecedentes,
				$examen_fisico,
				$tratamiento,
				$proxima_cita,
				(isset($_POST["iddiagnostico"]) ? $_POST["iddiagnostico"] : $diagnostico->mostrarXcodigo("00")),
				(isset($_POST["tipo"]) ? $_POST["tipo"] : array("0")),
				$plan,
				$alergia,
				$intervenciones_quirurgicas,
				$vacunas_completas,
				$idpersona,
				$_POST["medicamento"],
				$_POST["presentacion"],
				$_POST["dosis"],
				$_POST["duracion"],
				$_POST["cantidad"],
				$presion_arterial,
				$temperatura,
				$frecuencia_respiratoria,
				$frecuencia_cardiaca,
				$saturacion,
				$peso,
				$talla,
				$imc,
				$tel_ref,
				$nombre_ref,
				$fecha_in_enfer,
				$padece_enfermedades,
				$toma_medicamento
			);
			if ($TIPO__CONSULTA != "Consulta médica general") {
				if ($TIPO__CONSULTA == "Consulta Ginecologica") {
					$ginecologia->insertarDatosGinecologia(
						$idatencion,
						$idpersona,
						$paridadGine,
						$fecharegla,
						$fechaparto,
						$climaterio,
						$menarquia,
						$menopausia,
						$metdfamiliar,
						$ciclosregulares,
						$ultmcitologia,
						$consultarpor,
						$presentaenfermedade,
						$antecedentesmedic,
						$antecedentesquirurgico,
						$ultrasonografia,
						$mamografia,
						$cabeza,
						$cuello,
						$torax,
						$abdomen,
						$gentlesexternos,
						$especulo,
						$impdiagnost,
						$tensionarterial,
						$frecucardiaca,
						$frecurespiratoria,
						$temperaturaPaciente,
						$peso,
						$talla,
						$tratamiento,
						$proximacita,
						$examenFisicoGINE,
						$alergiasGINE
					);
				} else {
					$validaDatosObstetrica = isset($_POST['validaDatosObstetrica']) ? limpiarCadena($_POST['validaDatosObstetrica']) : "";
					if ($validaDatosObstetrica == "G") {
						$obstetrica->insertarObstetrica(
							$idatencion,
							$idpersona,
							$paridadObs,
							$fur,
							$fpp,
							$amenorrea,
							$gestional,
							$talla,
							$imc,
							$tipeo,
							$egh,
							$vdrl,
							$vhi,
							$pap,
							$hto1,
							$hto2,
							$hb1,
							$hb2,
							$glisema1,
							$glisema2,
							$ego1,
							$ego2,
							$antecedentesPaciente,
							$vacunas,
							$otros,
							$seguro,
							$examenFisicoOBS,
							$alergiasObs
						);
					} else {
						$obstetrica->actualizarObstetrica(
							$idobstetricaPaciente,
							$idatencion,
							$idpersona,
							$paridadObs,
							$fur,
							$fpp,
							$amenorrea,
							$gestional,
							$talla,
							$imc,
							$tipeo,
							$egh,
							$vdrl,
							$vhi,
							$pap,
							$hto1,
							$hto2,
							$hb1,
							$hb2,
							$glisema1,
							$glisema2,
							$ego1,
							$ego2,
							$antecedentesPaciente,
							$vacunas,
							$otros,
							$seguro,
							$examenFisicoOBS,
							$alergiasObs
						);
					}
				}
			}
			echo $rspta ? "Plan de Atención registrado " : "Plan de Atención no se pudo registrar";
		} else {
			$rspta = $resultado->editar(
				$idatencion,
				$idresultado,
				$motivo_consulta,
				$tiempo_enfermedad,
				$antecedentes,
				$examen_fisico,
				$tratamiento,
				$proxima_cita,
				$_POST["iddiagnostico"],
				$_POST["tipo"],
				$plan,
				$alergia,
				$intervenciones_quirurgicas,
				$vacunas_completas,
				$idpersona,
				$_POST["medicamento"],
				$_POST["presentacion"],
				$_POST["dosis"],
				$_POST["duracion"],
				$_POST["cantidad"],
				$presion_arterial,
				$temperatura,
				$frecuencia_respiratoria,
				$frecuencia_cardiaca,
				$saturacion,
				$peso,
				$talla,
				$imc
			);
			if ($TIPO__CONSULTA == "Consulta médica general") {
				$resultado->actualizarConsultaGeneral(
					$motivo_consulta,
					$tiempo_enfermedad,
					$antecedentes,
					$examen_fisico,
					$proxima_cita,
					$plan,
					$fechainimal,
					$tomamedic,
					$padeceenfer,
					$telref,
					$nomref,
					$idresultado
				);
			} else if ($TIPO__CONSULTA == "Consulta Ginecologica") {
				$rspta = $ginecologia->actualizarDatosGinecologia(
					$idginecologia,
					$paridadGine,
					$fecharegla,
					$fechaparto,
					$climaterio,
					$menarquia,
					$menopausia,
					$metdfamiliar,
					$ciclosregulares,
					$ultmcitologia,
					$consultarpor,
					$presentaenfermedade,
					$antecedentesmedic,
					$antecedentesquirurgico,
					$ultrasonografia,
					$mamografia,
					$cabeza,
					$cuello,
					$torax,
					$abdomen,
					$gentlesexternos,
					$especulo,
					$impdiagnost,
					$tensionarterial,
					$frecucardiaca,
					$frecurespiratoria,
					$temperaturaPaciente,
					$peso,
					$talla,
					$tratamientoGINE,
					$proximacita,
					$examenFisicoGINE,
					$alergiasGINE
				);
			} else {
				$obstetrica->actualizarObstetrica(
					$idobstetricaPaciente,
					$idatencion,
					$idpersona,
					$paridadObs,
					$fur,
					$fpp,
					$amenorrea,
					$gestional,
					$talla,
					$imc,
					$tipeo,
					$egh,
					$vdrl,
					$vhi,
					$pap,
					$hto1,
					$hto2,
					$hb1,
					$hb2,
					$glisema1,
					$glisema2,
					$ego1,
					$ego2,
					$antecedentesPaciente,
					$vacunas,
					$otros,
					$seguro,
					$examenFisicoOBS,
					$alergiasObs
				);
			}
			echo $rspta ? "Plan de Atención Actualizado" : "Plan de Atención no se puede actualizar";
		}
		break;

	case 'mostrar':
		$rspta = $resultado->mostrar($idatencion);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;

	case 'modificar':
		$rspta = $resultado->modificar($idatencion);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;

	case 'listar':
		require_once "../modelos/Atencion.php";

		$atencion = new Atencion();
		$rspta = $atencion->listarPlan();
		//Vamos a declarar un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$estado = '';
			if ($reg->estado == 'Anulado') {
				$estado = '<span class="label bg-red">Anulado</span>';
			} else if ($reg->estado == 'En Espera') {
				$estado = '<span class="label bg-orange">En espera</span>';
			} else {
				$estado = '<span class="label bg-blue">' . $reg->estado . '</span>';
			}
			$data[] = array(
				"0" => '<button title="Atender especialista" class="btn btn-info" onclick="mostrar(' . $reg->idatencion . ')"><i class="fa fa-eye"></i></button>',
				"1" => $reg->fecha . ' - ' . $reg->hora,
				"2" => $reg->registrador,
				"3" => $reg->servicio,
				"4" => $reg->especialista,
				"5" => $reg->paciente,
				"6" => $reg->costo,
				"7" => $estado
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"icostoRecords" => count($data), //enviamos el costo registros al datatable
			"icostoDisplayRecords" => count($data), //enviamos el costo registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;

	case 'diagnosticos':
		require_once "../modelos/Diagnostico.php";
		$diagnostico = new Diagnostico();
		$texto = $_GET['texto'];

		$rspta = $diagnostico->listarDiagnostico($texto);

		//Mostramos la lista de permisos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object()) {
			echo '<li><button type="button" class="btn btn-warning btn-sm" onclick="agregar(' . $reg->iddiagnostico . ',\'' . $reg->nenfermedad . '\')"><i class="fa fa-plus"></i></button>&nbsp;' . $reg->nenfermedad . '</li>';
		}
		break;

	case 'detalles':
		$idresultado = $_GET['idresultado'];

		$rspta = $resultado->listarDetalles($idresultado);
		$cont = 100;
		$opciones = '';

		//Mostramos la lista de permisos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object()) {
			$opciones = ($reg->tipo == 'P') ? '<option value="P" selected>Primera</option><option value="S">Subsecuente</option>'
				: '<option value="P">Primera</option><option value="S" selected>Subsecuente</option>';

			echo '<tr class="filas" id="fila' . $cont . '">' .
				'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' . $cont . ')"><i class="fa fa-trash"></i></button></td>' .
				'<td><select name="tipo[]" 	class="form-control">' . $opciones . '</select></td>' .
				'<td><input type="hidden" name="iddiagnostico[]" value="' . $reg->iddiagnostico . '">' . $reg->nenfermedad . '</td>' .
				'</tr>';
		}
		break;


	case 'recetas':
		$idatencion = $_GET['idatencion'];

		$rspta = $resultado->listarRecetas($idatencion);
		$cont = 100;

		//Mostramos la lista de permisos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object()) {
			echo '<tr class="filasr" id="filar' . $cont . '">' .
				'<td><button type="button" class="btn btn-sm btn-danger" onclick="eliminarReceta(' . $cont . ')"><i class="fa fa-trash"></i></button></td>' .
				'<td><input type="text" class="form-control" name="medicamento[]" value="' . $reg->medicamento . '" required=""></td>' .
				'<td><input type="text" class="form-control" name="presentacion[]" value="' . $reg->presentacion . '"></td>' .
				'<td><input type="text" class="form-control" name="dosis[]" value="' . $reg->dosis . '"></td>' .
				'<td><input type="text" class="form-control" name="duracion[]" value="' . $reg->duracion . '"></td>' .
				'<td><input type="text" class="form-control" name="cantidad[]" value="' . $reg->cantidad . '"></td>' .
				'</tr>';
		}
		break;
}
