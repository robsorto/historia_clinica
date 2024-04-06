<?php

require "../config/Conexion.php";

class Ginecologia
{

    public function __construct()
    {
    }

    public function insertarDatosGinecologia(
        $idatencion,
        $idpersona,
        $paridad,
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
        $temperatura,
        $peso,
        $talla,
        $tratamiento,
        $proximacita,
        $examenFisicoGINE,
        $alergiasGINE
    ) {
        $sql = "INSERT INTO ginecologia(id_ginecologia, idatencion, idpersona, paridad, fecha_ult_regla, fecha_ult_parto, climaterio,
        menarquia, menopausia, metd_planf_familiar, ciclos_mestrl_regulares, ultm_citologia, consultar_por, presenta_enfemedade, 
        antecedentes_medic, antecedentes_quirurgico, ultrasonografia, mamografia, cabeza, cuello, torax, abdomen, gentles_externos, especulo,
        imp_diagnost, tension_arterial, frecu_cardiaca, frecu_respiratoria, temperatura, peso, talla, tratamiento, proxima_cita, 
        examen_fisico, alergias)
        values('0', '$idatencion', '$idpersona', '$paridad', '$fecharegla', '$fechaparto', '$climaterio',
            '$menarquia', '$menopausia', '$metdfamiliar', '$ciclosregulares', '$ultmcitologia', '$consultarpor', '$presentaenfermedade', 
            '$antecedentesmedic', '$antecedentesquirurgico', '$ultrasonografia', '$mamografia', '$cabeza', '$cuello', '$torax', '$abdomen', 
            '$gentlesexternos', '$especulo', '$impdiagnost', '$tensionarterial', '$frecucardiaca', '$frecurespiratoria', 
            '$temperatura', '$peso', '$talla', '$tratamiento', '$proximacita', '$examenFisicoGINE', '$alergiasGINE')";

        return ejecutarConsulta_retornarID($sql);
    }

    public function listarGinecologia($idginecologia)
    {
        $sql = "SELECT 
        CONCAT((YEAR( CURDATE( ) ) - YEAR( p.fecha_nacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( p.fecha_nacimiento), 1, 
		IF ( MONTH(CURDATE( )) = MONTH(fecha_nacimiento),IF (DAY( CURDATE( ) ) < DAY( fecha_nacimiento ),1,0 ),0)))) as edad,
        a.fecha, a.hora, CONCAT(p.apaterno, ' ', p.amaterno, ' ', p.nombre) paciente, g.* 
        FROM ginecologia g
        INNER JOIN atencion a ON (g.idatencion = a.idatencion)
		INNER JOIN persona p ON(g.idpersona = p.idpersona)
        where id_ginecologia = '$idginecologia'";
        return ejecutarConsulta($sql);
    }

    public function obtenerGinecologia($idatencion){
        $sql ="SELECT * FROM ginecologia WHERE idatencion='$idatencion'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function actualizarDatosGinecologia(
        $idginecologia,
        $paridad,
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
        $temperatura,
        $peso,
        $talla,
        $tratamiento,
        $proximacita,
        $examenFisicoGINE,
        $alergiasGINE
    ) {
        $sql = "UPDATE ginecologia SET paridad='$paridad', fecha_ult_regla='$fecharegla', 
        fecha_ult_parto='$fechaparto', climaterio='$climaterio',menarquia='$menarquia', menopausia='$menopausia', 
        metd_planf_familiar='$metdfamiliar', ciclos_mestrl_regulares='$ciclosregulares', ultm_citologia='$ultmcitologia', 
        consultar_por='$consultarpor', presenta_enfemedade='$presentaenfermedade', antecedentes_medic='$antecedentesmedic', 
        antecedentes_quirurgico='$antecedentesquirurgico', ultrasonografia='$ultrasonografia', mamografia='$mamografia', 
        cabeza='$cabeza', cuello='$cuello', torax='$torax', abdomen='$abdomen', gentles_externos='$gentlesexternos', especulo='$especulo',
        imp_diagnost='$impdiagnost', tension_arterial='$tensionarterial', frecu_cardiaca='$frecucardiaca', 
        frecu_respiratoria='$frecurespiratoria', temperatura='$temperatura', peso='$peso', talla='$talla', tratamiento='$tratamiento', 
        proxima_cita='$proximacita', examen_fisico='$examenFisicoGINE', alergias='$alergiasGINE' WHERE id_ginecologia='$idginecologia'";

        return ejecutarConsulta($sql);
    }
}
