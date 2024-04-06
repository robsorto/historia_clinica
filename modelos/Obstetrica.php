<?php

require "../config/Conexion.php";

class Obstetrica
{
    public function __construct()
    {
    }

    public function insertarObstetrica(
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
        $antecedentes,
        $vacunas,
        $otros,
        $seguro,
        $examenFisicoOBS,
        $alergiasOBS
    ) {
        $sql = "INSERT INTO obstetrica(id_obstetrica, idatencion, idpersona, paridad, fecha_ult_regla, fecha_prb_parto, edad_rgl_primera, edad_gestorial, talla, 
        indc_m_corporal, tipeo, exam_gnrl_heces, cifilis, vhi, papanicolao, hematocrito_v1, hematocrito_v2, hemoglobina_v1, 
        hemoglobina_v2, glucosa_v1, glucosa_v2, exam_gnrl_orina, exam_gnrl_orina2, antecedentes, vacunas, otros, seguro, examen_fisico, estado, padece_alergia) 
        values('0','$idatencion', '$idpersona', '$paridad', '$fur', '$fpp', '$amenorrea', '$gestional', '$talla', 
        '$imc', '$tipeo', '$egh', '$vdrl', '$vhi', '$pap', '$hto1', '$hto2', '$hb1', '$hb2', '$glisema1', '$glisema2',
        '$ego1', '$ego2', '$antecedentes', '$vacunas', '$otros', '$seguro', '$examenFisicoOBS', 'A', '$alergiasOBS')";
        return ejecutarConsulta_retornarID($sql);
    }

    public function actualizarObstetrica(
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
    ) {

        $sql = "UPDATE obstetrica SET paridad = '$paridad' , fecha_ult_regla = '$fur', 
        fecha_prb_parto = '$fpp', edad_rgl_primera = '$amenorrea', edad_gestorial = '$gestional', talla = '$talla', 
        indc_m_corporal = '$imc', tipeo = '$tipeo', exam_gnrl_heces = '$egh', cifilis = '$vdrl', vhi = '$vhi', 
        papanicolao = '$pap', hematocrito_v1 = '$hto1', hematocrito_v2 = '$hto2', hemoglobina_v1 = '$hb1', 
        hemoglobina_v2 = '$hb2', glucosa_v1 = '$glisema1', glucosa_v2 = '$glisema2', exam_gnrl_orina = '$ego1', 
        exam_gnrl_orina2 = '$ego2', antecedentes = '$antecedentesPaciente', vacunas = '$vacunas', otros = '$otros', seguro = '$seguro', 
        examen_fisico = '$examenFisicoOBS', padece_alergia = '$alergiasObs' 
        WHERE id_obstetrica = '$idobstetricaPaciente'";
        return ejecutarConsulta($sql);
    }

    public function buscarObstetricaPaciente($idpersona)
    {
        $sql = "SELECT * FROM obstetrica WHERE idpersona ='$idpersona' and estado ='A'";

        return ejecutarConsultaSimpleFila($sql);
    }

    public function buscarObstetricaPacienteG($idpersona)
    {
        $sql = "SELECT * FROM obstetrica WHERE idpersona ='$idpersona'";

        return ejecutarConsultaSimpleFila($sql);
    }

    public function buscarObstetricaPacienteRealizada($idatencion)
    {
        $sql = "SELECT * FROM obstetrica WHERE idatencion ='$idatencion'";

        return ejecutarConsultaSimpleFila($sql);
    }

    public function inactivarControlPrenatal($idpersona, $idobstetricaPaciente)
    {
        $sql = "update obstetrica set estado = 'I' 
        where idpersona = '$idpersona' and id_obstetrica = '$idobstetricaPaciente'";
        return ejecutarConsulta($sql);
    }
}
