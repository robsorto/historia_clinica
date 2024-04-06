<?php
require_once "../modelos/Obstetrica.php";

$obstetrica = new Obstetrica();

//DATOS DE OBSTETRICA START
$paridad = isset($_POST['paridadPaciente']) ? limpiarCadena($_POST['paridadPaciente']) : "";
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

$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$idatencion = isset($_POST["idatencion"]) ? limpiarCadena($_POST["idatencion"]) : "";
$idobstetricaPaciente = isset($_POST["idobstetricaPacienteGnrl"]) ? limpiarCadena($_POST["idobstetricaPacienteGnrl"]) : "";
$tipoGestion = isset($_POST["tipoGestion"]) ? limpiarCadena($_POST["tipoGestion"]) : "";

switch ($_GET["op"]) {
    case "mostrar":
        $res = $obstetrica->buscarObstetricaPaciente($idpersona);
        echo json_encode($res);
        break;
    case "mostrarConsultaRealizada":
        $res = $obstetrica->buscarObstetricaPacienteG($idpersona);
        echo json_encode($res);
        break;
    case "guardaryeditardatos":
        if ($tipoGestion == 'G') {
            if ($idatencion == '' || $idpersona == '') {
                echo json_encode(["idObstetrica" => '']);
            } else {
                $respuesta = $obstetrica->insertarObstetrica(
                    $idatencion,
                    $idpersona,
                    $paridad,
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
                echo json_encode(["idObstetrica" => $respuesta]);
            }
        } else {
            $obstetrica->actualizarObstetrica(
                $idobstetricaPaciente,
                $idatencion,
                $idpersona,
                $paridad,
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
        break;
    case "finalizarControl":
        try {
            $obstetrica->inactivarControlPrenatal($idpersona, $idobstetricaPaciente);
            echo json_encode([
                "cod" => "1",
                "mensaje" => "Se actualizó el control prenatal"
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "cod" => "1",
                "mensaje" => "No se puede actualizar el control prenatal " + $e->getMessage()
            ]);
        }
        break;
}
