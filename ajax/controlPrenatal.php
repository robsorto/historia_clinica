<?php


require_once "../modelos/ControlPrenatal.php";

$control = new ControlPrenatal();

$idobstetrica = isset($_POST['idobstetricaPacienteModal']) ? limpiarCadena($_POST['idobstetricaPacienteModal']) : "";
$fechacontrol = isset($_POST['fechaPacienteCP']) ? limpiarCadena($_POST['fechaPacienteCP']) : "";
$edadrgl = isset($_POST['amenorreaPacienteCP']) ? limpiarCadena($_POST['amenorreaPacienteCP']) : "";
$peso = isset($_POST['pesoPacienteCP']) ? limpiarCadena($_POST['pesoPacienteCP']) : "";
$auterina = isset($_POST['auPacienteCP']) ? limpiarCadena($_POST['auPacienteCP']) : "";
$presionart = isset($_POST['taPacienteCP']) ? limpiarCadena($_POST['taPacienteCP']) : "";
$pulso = isset($_POST['pulsoPacienteCP']) ? limpiarCadena($_POST['pulsoPacienteCP']) : "";
$frecfetal = isset($_POST['fcfPacienteCP']) ? limpiarCadena($_POST['fcfPacienteCP']) : "";
$movfetal = isset($_POST['mPacienteCP']) ? limpiarCadena($_POST['mPacienteCP']) : "";
$medicamentocp = isset($_POST['medicamentoPacienteCP']) ? limpiarCadena($_POST['medicamentoPacienteCP']) : "";
$signosalarm = isset($_POST['saPacienteCP']) ? limpiarCadena($_POST['saPacienteCP']) : "";
$ultrasonografia = isset($_POST['ultraPacienteCP']) ? limpiarCadena($_POST['ultraPacienteCP']) : "";
$proxcita = isset($_POST['pcPacienteCP']) ? limpiarCadena($_POST['pcPacienteCP']) : "";

$idobstetricaPaciente = isset($_POST['idobstetricaPacienteGnrl']) ? limpiarCadena($_POST['idobstetricaPacienteGnrl']) : "";
$idGeneralControl = '';

if ($idobstetrica == '') {
    $idGeneralControl = $idobstetricaPaciente;
} else {
    $idGeneralControl = $idobstetrica;
}
if ($idGeneralControl == '') {
    $idGeneralControl = isset($_POST['idObstetrica_G']) ? limpiarCadena($_POST['idObstetrica_G']) : "";
}

//ID PARA MOSTRAR DATOS Y ACTUALIZAR
$idControl = isset($_POST['idControl']) ? limpiarCadena($_POST['idControl']) : "";

$idatencion = isset($_POST['idatencion']) ? limpiarCadena($_POST['idatencion']) : "";

switch ($_GET["op"]) {

    case "listar":
        $res = $control->obtenerDatosControlPrenatal($idGeneralControl);
        $data = array();

        while ($reg = $res->fetch_object()) {
            $data[] = array(
                "0" => $reg->fecha_control,
                "1" => $reg->amonorrea,
                "2" => $reg->peso,
                "3" => $reg->au,
                "4" => $reg->ta,
                "5" => $reg->pulso,
                "6" => $reg->fcf,
                "7" => $reg->m,
                "8" => $reg->medicamento,
                "9" => $reg->signos_alarmas,
                "10" => $reg->ultrasonografia,
                "11" => $reg->proxima_cita
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
    case "guardaryeditardatos":

        if ($idGeneralControl == '' && $idControl == '') {
            echo 'Debe agregar una consulta de tipo obstetrica para poder almacenar los controles prenatales';
        } else {
            if ($idControl == '') {
                $res = $control->guardarControlPrenatal(
                    $idGeneralControl,
                    $fechacontrol,
                    $edadrgl,
                    $peso,
                    $auterina,
                    $presionart,
                    $pulso,
                    $frecfetal,
                    $movfetal,
                    $medicamentocp,
                    $signosalarm,
                    $ultrasonografia,
                    $proxcita,
                    $idatencion
                );
                echo $res ? "Control Prenatal registrado " : "Control Prenatal no se pudo registrar";
            } else {
                $res = $control->actualizarControlPrenatal(
                    $idControl,
                    $fechacontrol,
                    $edadrgl,
                    $peso,
                    $auterina,
                    $presionart,
                    $pulso,
                    $frecfetal,
                    $movfetal,
                    $medicamentocp,
                    $signosalarm,
                    $ultrasonografia,
                    $proxcita
                );
                echo $res ? "Control Prenatal actualizado " : "Control Prenatal no se pudo actualizar";
            }
        }
        break;
    case "verificarListado":
        $res = $control->verificarListadoControlPrenatal($idGeneralControl);
        echo json_encode([
            "respuesta" => $res->resultado
        ]);
        break;
    case "obtenerControlPrenatalEditar":
        $res = $control->listarControlPrenatalIdAtencion($idatencion);
        $data = array();
        if (!is_null($res)) {
            while ($reg = $res->fetch_object()) {
                $data[] = array(
                    "0" => $reg->fecha_control,
                    "1" => $reg->edad_rgl_primera,
                    "2" => $reg->peso,
                    "3" => $reg->altr_uterina,
                    "4" => $reg->prson_arterial,
                    "5" => $reg->pulso,
                    "6" => $reg->frecu_cardiaca_fetal,
                    "7" => $reg->mov_fetal,
                    "8" => $reg->medicamento,
                    "9" => $reg->signos_alarmas,
                    "10" => $reg->ultrasonografia,
                    "11" => $reg->proxima_cita,
                    "12" => '<button title="Actualizar Registro" type="button" class="btn btn-info" id="control-editar-' . $reg->id_control . '"
                    onclick="mostrarControlPrenatalEditar(' . $reg->id_control . ')"><i class="fa fa-eye"></i></button>'
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "icostoRecords" => count($data), //enviamos el costo registros al datatable
            "icostoDisplayRecords" => count($data), //enviamos el costo registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case "buscarControlPrenatal":
        $res =  $control->buscarControl($idControl);
        echo json_encode($res);
        break;
}
