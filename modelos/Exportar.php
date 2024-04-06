<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

require "../config/Import.php";

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Exportar
{

    public function exportarTodo()
    {
        $documento = new Spreadsheet();
        $documento
            ->getProperties()
            ->setCreator("Clinica")
            ->setLastModifiedBy('Clinica Dra')
            ->setTitle('Archivo generado para historico')
            ->setDescription('Clinica general');

        ///-----------------HOJA 1 START-----------------------------
        $hoja1 = $documento->getActiveSheet();
        $hoja1->setTitle("Pacientes");

        $encabezado = [
            "ID", "APELLIDO PATERNO", "APELLIDO MATERNO", "NOMBRE", "FECHA NACIMIENTO", "GENERO", "ESTADO CIVIL",
            "ALERGIAS", "INTERVENCIONES QUIRURGICAS", "VACUNAS COMPLETAS", "TIPO DOCUMENTO", "NUMERO DOCUMENTO",
            "DIRECCION", "TELEFONO", "CORREO ELECTRONICO", "OCUPACION", "RESPONSABLE DE PACIENTE", "PROFESION", "EMPLEADO"
        ];
        $hoja1->fromArray($encabezado, null, 'A1');

        $sql = "select * from persona where es_empleado = 'N'";
        $resp =  ejecutarConsulta($sql);
        $fila = 2;
        while ($paciente = $resp->fetch_object()) {
            $hoja1->setCellValueByColumnAndRow(1, $fila, $paciente->idpersona);
            $hoja1->setCellValueByColumnAndRow(2, $fila, $paciente->apaterno);
            $hoja1->setCellValueByColumnAndRow(3, $fila, $paciente->amaterno);
            $hoja1->setCellValueByColumnAndRow(4, $fila, $paciente->nombre);
            $hoja1->setCellValueByColumnAndRow(5, $fila, $paciente->fecha_nacimiento);
            $hoja1->setCellValueByColumnAndRow(6, $fila, ($paciente->sexo == 'M' ? 'MASCULINO' :  'FEMENINO'));
            $hoja1->setCellValueByColumnAndRow(7, $fila, ($paciente->estado_civil == 'S' ? 'SOLTERO'
                : ($paciente->estado_civil == 'C' ? 'CASADO' : ($paciente->estado_civil == 'V' ? 'VIUDO'
                    : ($paciente->estado_civil == 'D' ? 'DIVORCIADO' : 'OTRO')))));
            $hoja1->setCellValueByColumnAndRow(8, $fila, $paciente->alergia);
            $hoja1->setCellValueByColumnAndRow(9, $fila, $paciente->intervenciones_quirurgicas);
            $hoja1->setCellValueByColumnAndRow(10, $fila, $paciente->vacunas_completas);
            $hoja1->setCellValueByColumnAndRow(11, $fila, $paciente->tipo_documento);
            $hoja1->setCellValueByColumnAndRow(12, $fila, $paciente->num_documento);
            $hoja1->setCellValueByColumnAndRow(13, $fila, $paciente->direccion);
            $hoja1->setCellValueByColumnAndRow(14, $fila, $paciente->telefono);
            $hoja1->setCellValueByColumnAndRow(15, $fila, $paciente->email);
            $hoja1->setCellValueByColumnAndRow(16, $fila, $paciente->ocupacion);
            $hoja1->setCellValueByColumnAndRow(17, $fila, $paciente->persona_responsable);
            $hoja1->setCellValueByColumnAndRow(18, $fila, $paciente->profesion);
            $hoja1->setCellValueByColumnAndRow(19, $fila, $paciente->es_empleado);
            $fila++;
        }
        ///-----------------HOJA 1 END-----------------------------
        ///-----------------HOJA 2 START-----------------------------
        $hoja2 =  $documento->createSheet();
        $hoja2->setTitle('ATENCION');
        $encabezado2 = [
            "ID ATENCION", "ID PERSONA", "ID EMPLEADO", "FECHA", "HORA", "ID SERVICIO", "COSTO", "ESTADO"
        ];
        $hoja2->fromArray($encabezado2, null, 'A1');

        $sql2 = "SELECT a.idatencion, 
            CONCAT(a.idpersona, '-',p.amaterno, ' ', p.apaterno, ' ', p.nombre) nombre, 
            CONCAT(a.idusuario,'-',(SELECT CONCAT(amaterno, ' ',apaterno, ' ', nombre) 
                FROM persona WHERE idpersona = a.idusuario))  empleado,
            a.fecha, a.hora, CONCAT(a.idservicio,'-',s.nombre) servicio, a.costo, a.estado
        from atencion a
        INNER JOIN persona p ON (a.idpersona = p.idpersona)
         INNER JOIN servicio s ON(a.idservicio = s.idservicio)";
        $resp2 =  ejecutarConsulta($sql2);

        $fila2 = 2;
        while ($consulta = $resp2->fetch_object()) {
            $hoja2->setCellValueByColumnAndRow(1, $fila2, $consulta->idatencion);
            $hoja2->setCellValueByColumnAndRow(2, $fila2, $consulta->nombre);
            $hoja2->setCellValueByColumnAndRow(3, $fila2, $consulta->empleado);
            $hoja2->setCellValueByColumnAndRow(4, $fila2, $consulta->fecha);
            $hoja2->setCellValueByColumnAndRow(5, $fila2, $consulta->hora);
            $hoja2->setCellValueByColumnAndRow(6, $fila2, $consulta->servicio);
            $hoja2->setCellValueByColumnAndRow(7, $fila2, $consulta->costo);
            $hoja2->setCellValueByColumnAndRow(8, $fila2, $consulta->estado);
            $fila2++;
        }
        ///-----------------HOJA 2 END-----------------------------
        ///-----------------HOJA 3 START-----------------------------
        $hoja3 =  $documento->createSheet();
        $hoja3->setTitle('CONSULTA GENERAL');
        $encabezado3 = [
            "ID RESULTADO", "ID ATENCION", "TIPO CONSULTA", "MOTIVO CONSULTA", "TIPO ENFERMEDAD", "ANTECEDENTES", "EXAMEN FISICO",
            "TRATAMIENTO", "PROXIMA CITA", "ESTADO", "PLAN", "FECHA", "HORA", "FECHA INICIO MALESTAR", "TOMA MEDICAMENTOS",
            "PADECE ENFERMEDADES", "TELEFONO REFERENCIA", "NOMBRE REFERENCIA"
        ];
        $hoja3->fromArray($encabezado3, null, 'A1');

        $sql3 = "SELECT CONCAT(a.idatencion, '-',p.amaterno, ' ', p.apaterno, ' ', p.nombre, '-Estado: ', a.estado) atencion, 
            r.* FROM resultado r 
            INNER JOIN atencion a ON (r.idatencion = a.idatencion) 
            INNER JOIN persona p ON (a.idpersona = p.idpersona) 
            INNER JOIN servicio s ON(a.idservicio = s.idservicio)";

        $resp3 =  ejecutarConsulta($sql3);
        $fila3 = 2;
        while ($resultado = $resp3->fetch_object()) {
            $hoja3->setCellValueByColumnAndRow(1, $fila3, $resultado->idresultado);
            $hoja3->setCellValueByColumnAndRow(2, $fila3, $resultado->atencion);
            $hoja3->setCellValueByColumnAndRow(3, $fila3, $resultado->tipoconsulta);
            $hoja3->setCellValueByColumnAndRow(4, $fila3, $resultado->motivo_consulta);
            $hoja3->setCellValueByColumnAndRow(5, $fila3, $resultado->tiempo_enfermedad);
            $hoja3->setCellValueByColumnAndRow(6, $fila3, $resultado->antecedentes);
            $hoja3->setCellValueByColumnAndRow(7, $fila3, $resultado->examen_fisico);
            $hoja3->setCellValueByColumnAndRow(8, $fila3, $resultado->tratamiento);
            $hoja3->setCellValueByColumnAndRow(9, $fila3, $resultado->proxima_cita);
            $hoja3->setCellValueByColumnAndRow(10, $fila3, $resultado->estado);
            $hoja3->setCellValueByColumnAndRow(11, $fila3, $resultado->plan);
            $hoja3->setCellValueByColumnAndRow(12, $fila3, $resultado->fecha);
            $hoja3->setCellValueByColumnAndRow(13, $fila3, $resultado->hora);
            $hoja3->setCellValueByColumnAndRow(14, $fila3, $resultado->fecha_inicio_malestar);
            $hoja3->setCellValueByColumnAndRow(15, $fila3, $resultado->toma_medicamentos);
            $hoja3->setCellValueByColumnAndRow(16, $fila3, $resultado->padece_enferedades);
            $hoja3->setCellValueByColumnAndRow(17, $fila3, $resultado->telefono_referencia);
            $hoja3->setCellValueByColumnAndRow(18, $fila3, $resultado->nombre_referencia);
            $fila3++;
        }
        ///-----------------HOJA 3 END-----------------------------
        ///-----------------HOJA 4 START-----------------------------
        $hoja4 =  $documento->createSheet();
        $hoja4->setTitle('GINECOLOGIA');
        $encabezado4 = [
            "ID GINECOLOGIA", "ID ATENCION", "PARIDAD", "FECHA ULTIMA REGLA", "FECHA ULTIMO PARTO", "CLIMATERIO", "MENARQUIA", "MENOPAUSIA", "M. PLANIFICACION FAMILIAR",
            "CICLOS MENSTRUALES R.", "ULTIMA CITOLOGIA", "CONSULTA POR", "PRESENTA ENFERMEDADE", "ANTECENDENTES MEDICOS", "ANTECEDENTES QUIRURGICOS",
            "ULTRASONOGRAFIA", "MAMOGRAFIA", "CABEZA", "CUELLO", "TORAX", "ABDOMEN", "GENITALES EXTERNOS", "ESPECULO", "IMP. DIAGNOSTICO",
            "TENSION ARTERIAL", "FRECUENCIA CARDIACA", "FRECUENCIA RESPIRATORIA", "TEMPERATURA", "PESO", "TALLA", "TRATAMIENTO", "PROXIMA CITA",
            "EXAMEN FISICO"
        ];
        $hoja4->fromArray($encabezado4, null, 'A1');

        $sql4 = "SELECT CONCAT(a.idatencion, '-',p.amaterno, ' ', p.apaterno, ' ', p.nombre, '-Estado: ', a.estado) atencion,
            g.*
            FROM ginecologia g
            INNER JOIN atencion a ON (g.idatencion = a.idatencion) 
            INNER JOIN persona p ON (a.idpersona = p.idpersona) 
            INNER JOIN servicio s ON(a.idservicio = s.idservicio)";

        $resp4 =  ejecutarConsulta($sql4);
        $fila4 = 2;
        while ($ginecologia = $resp4->fetch_object()) {
            $hoja4->setCellValueByColumnAndRow(1, $fila4, $ginecologia->id_ginecologia);
            $hoja4->setCellValueByColumnAndRow(2, $fila4, $ginecologia->atencion);
            $hoja4->setCellValueByColumnAndRow(3, $fila4, $ginecologia->paridad);
            $hoja4->setCellValueByColumnAndRow(4, $fila4, $ginecologia->fecha_ult_regla);
            $hoja4->setCellValueByColumnAndRow(5, $fila4, $ginecologia->fecha_ult_parto);
            $hoja4->setCellValueByColumnAndRow(6, $fila4, $ginecologia->climaterio);
            $hoja4->setCellValueByColumnAndRow(7, $fila4, $ginecologia->menarquia);
            $hoja4->setCellValueByColumnAndRow(8, $fila4, $ginecologia->menopausia);
            $hoja4->setCellValueByColumnAndRow(9, $fila4, $ginecologia->metd_planf_familiar);
            $hoja4->setCellValueByColumnAndRow(10, $fila4, $ginecologia->ciclos_mestrl_regulares);
            $hoja4->setCellValueByColumnAndRow(11, $fila4, $ginecologia->ultima_citologia);
            $hoja4->setCellValueByColumnAndRow(12, $fila4, $ginecologia->consultar_por);
            $hoja4->setCellValueByColumnAndRow(13, $fila4, $ginecologia->presenta_enfemedade);
            $hoja4->setCellValueByColumnAndRow(14, $fila4, $ginecologia->antecedentes_medic);
            $hoja4->setCellValueByColumnAndRow(15, $fila4, $ginecologia->antecedentes_quirurgico);
            $hoja4->setCellValueByColumnAndRow(16, $fila4, $ginecologia->ultrasonografia);
            $hoja4->setCellValueByColumnAndRow(17, $fila4, $ginecologia->mamografia);
            $hoja4->setCellValueByColumnAndRow(18, $fila4, $ginecologia->cabeza);
            $hoja4->setCellValueByColumnAndRow(19, $fila4, $ginecologia->cuello);
            $hoja4->setCellValueByColumnAndRow(20, $fila4, $ginecologia->torax);
            $hoja4->setCellValueByColumnAndRow(21, $fila4, $ginecologia->abdomen);
            $hoja4->setCellValueByColumnAndRow(22, $fila4, $ginecologia->gentles_Externos);
            $hoja4->setCellValueByColumnAndRow(23, $fila4, $ginecologia->especulo);
            $hoja4->setCellValueByColumnAndRow(24, $fila4, $ginecologia->imp_diagnost);
            $hoja4->setCellValueByColumnAndRow(25, $fila4, $ginecologia->tension_arterial);
            $hoja4->setCellValueByColumnAndRow(26, $fila4, $ginecologia->frecu_cardiaca);
            $hoja4->setCellValueByColumnAndRow(27, $fila4, $ginecologia->frecu_respiratoria);
            $hoja4->setCellValueByColumnAndRow(28, $fila4, $ginecologia->temperatura);
            $hoja4->setCellValueByColumnAndRow(29, $fila4, $ginecologia->peso);
            $hoja4->setCellValueByColumnAndRow(30, $fila4, $ginecologia->talla);
            $hoja4->setCellValueByColumnAndRow(31, $fila4, $ginecologia->tratamiento);
            $hoja4->setCellValueByColumnAndRow(32, $fila4, $ginecologia->proxima_cita);
            $hoja4->setCellValueByColumnAndRow(33, $fila4, $ginecologia->examen_fisico);
            $fila4++;
        }
        ///-----------------HOJA 4 END-----------------------------
        ///-----------------HOJA 5 START-----------------------------
        $hoja5 =  $documento->createSheet();
        $hoja5->setTitle('OBSTETRICA Y CONTROL PRENATAL');
        $encabezado5 = [
            "ID OBSTETRICA", "ID CONTROL", "ID ATENCION", "PARIDAD", "FECHA ULTIMA REGLA", "FECHA_PROBABLE DE PARTO", "EDAD REGLA P.", "EDAD GESTORIAL",
            "TALLA", "INDICE MASA CORPORAL", "TIPEO", "EXAMEN GENERAL HECES", "CIFILIS", "VHI", "PAPANICOLAO", "HEMATOCRITO /2",
            "HEMOGLOBINA /2", "GLOCOSA /2", "EXAMEN GENERAL ORINA /2", "ANTECENDETES", "VACUNAS", "OTROS", "SEGURO", "ESTADO", "PADECE ALERGIA",
            "EXAMEN FISICO", "-----", "ID CONTROL", "FECHA CONTROL", "EDAD REGLA PRIMERA VEZ", "PESO", "ALTURA UTERINA", "PRESION ARTERIAL", "PULSO",
            "FRECUENCIA CARDIACA FETAL", "MOVIMIENTO FETAL", "MEDICAMENTO", "SIGNOS ALARMAS", "ULTRASONOGRAFIA", "PROXIMA CITA"
        ];
        $hoja5->fromArray($encabezado5, null, 'A1');

        $sql5 = "SELECT CONCAT(a.idatencion, '-',p.amaterno, ' ', p.apaterno, ' ', p.nombre, '-Estado: ', a.estado) atencion,
                o.*, cp.id_control, cp.fecha_control, cp.edad_rgl_primera, cp.peso, cp.altr_uterina, 
                cp.prson_arterial, cp.pulso, cp.frecu_cardiaca_fetal, cp.mov_fetal, cp.medicamento, cp.signos_alarmas,
                cp.ultrasonografia, cp.proxima_cita
            FROM obstetrica o
            INNER JOIN atencion a ON (o.idatencion = a.idatencion) 
            INNER JOIN persona p ON (a.idpersona = p.idpersona) 
            INNER JOIN servicio s ON(a.idservicio = s.idservicio)
            LEFT JOIN cntrl_prenatal cp ON (o.id_obstetrica = cp.id_obstetrica)";

        $resp5 =  ejecutarConsulta($sql5);
        $fila5 = 2;
        while ($controlPre = $resp5->fetch_object()) {
            $hoja5->setCellValueByColumnAndRow(1, $fila5, $controlPre->id_obstetrica);
            $hoja5->setCellValueByColumnAndRow(2, $fila5, $controlPre->id_control);
            $hoja5->setCellValueByColumnAndRow(3, $fila5, $controlPre->atencion);
            $hoja5->setCellValueByColumnAndRow(4, $fila5, $controlPre->paridad);
            $hoja5->setCellValueByColumnAndRow(5, $fila5, $controlPre->fecha_ult_regla);
            $hoja5->setCellValueByColumnAndRow(6, $fila5, $controlPre->fecha_prb_parto);
            $hoja5->setCellValueByColumnAndRow(7, $fila5, $controlPre->edad_rgl_primera);
            $hoja5->setCellValueByColumnAndRow(8, $fila5, $controlPre->edad_gestorial);
            $hoja5->setCellValueByColumnAndRow(9, $fila5, $controlPre->talla);
            $hoja5->setCellValueByColumnAndRow(10, $fila5, $controlPre->indc_m_corporal);
            $hoja5->setCellValueByColumnAndRow(11, $fila5, $controlPre->tipeo);
            $hoja5->setCellValueByColumnAndRow(12, $fila5, $controlPre->exam_gnrl_heces);
            $hoja5->setCellValueByColumnAndRow(13, $fila5, $controlPre->cifilis);
            $hoja5->setCellValueByColumnAndRow(14, $fila5, $controlPre->vhi);
            $hoja5->setCellValueByColumnAndRow(15, $fila5, $controlPre->papanicolao);
            $hoja5->setCellValueByColumnAndRow(16, $fila5, $controlPre->hematocrito_v1 . ' / ' . $controlPre->hematocrito_v2);
            $hoja5->setCellValueByColumnAndRow(17, $fila5, $controlPre->hemoglobina_v1 . ' / ' . $controlPre->hemoglobina_v2);
            $hoja5->setCellValueByColumnAndRow(18, $fila5, $controlPre->glucosa_v1 . ' / ' . $controlPre->glucosa_v2);
            $hoja5->setCellValueByColumnAndRow(19, $fila5, $controlPre->exam_gnrl_orina . ' / ' . $controlPre->exam_gnrl_orina2);
            $hoja5->setCellValueByColumnAndRow(20, $fila5, $controlPre->antecedentes);
            $hoja5->setCellValueByColumnAndRow(21, $fila5, $controlPre->vacunas);
            $hoja5->setCellValueByColumnAndRow(22, $fila5, $controlPre->otros);
            $hoja5->setCellValueByColumnAndRow(23, $fila5, $controlPre->seguro);
            $hoja5->setCellValueByColumnAndRow(24, $fila5, $controlPre->estado);
            $hoja5->setCellValueByColumnAndRow(25, $fila5, $controlPre->padece_alergia);
            $hoja5->setCellValueByColumnAndRow(26, $fila5, $controlPre->examen_fisico);
            $hoja5->setCellValueByColumnAndRow(27, $fila5, " --- ");
            $hoja5->setCellValueByColumnAndRow(28, $fila5, $controlPre->id_control);
            $hoja5->setCellValueByColumnAndRow(29, $fila5, $controlPre->fecha_control);
            $hoja5->setCellValueByColumnAndRow(30, $fila5, $controlPre->edad_rgl_primera);
            $hoja5->setCellValueByColumnAndRow(31, $fila5, $controlPre->peso);
            $hoja5->setCellValueByColumnAndRow(32, $fila5, $controlPre->altr_uterina);
            $hoja5->setCellValueByColumnAndRow(33, $fila5, $controlPre->prson_arterial);
            $hoja5->setCellValueByColumnAndRow(34, $fila5, $controlPre->pulso);
            $hoja5->setCellValueByColumnAndRow(35, $fila5, $controlPre->frecu_cardiaca_fetal);
            $hoja5->setCellValueByColumnAndRow(36, $fila5, $controlPre->mov_fetal);
            $hoja5->setCellValueByColumnAndRow(37, $fila5, $controlPre->medicamento);
            $hoja5->setCellValueByColumnAndRow(38, $fila5, $controlPre->signos_alarmas);
            $hoja5->setCellValueByColumnAndRow(39, $fila5, $controlPre->ultrasonografia);
            $hoja5->setCellValueByColumnAndRow(40, $fila5, $controlPre->proxima_cita);
            $fila5++;
        }
        ///-----------------HOJA 3 END-----------------------------
        ///-----------------CREA DOCUMENTO-----------------------------
        $writer = new Xlsx($documento);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode("Historico.xlsx") . '"');
        ob_start();
        $writer->save('php://output');
        $documento = ob_get_contents();
        ob_end_clean();
        return array(
            'status' => 1,
            'data' => "data:application/vnd.ms-excel;base64," . base64_encode($documento)
        );
    }
}
