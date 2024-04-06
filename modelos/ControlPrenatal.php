<?php
require "../config/Conexion.php";

class ControlPrenatal
{

    public function __construct()
    {
    }

    public function obtenerDatosControlPrenatal($idobstetrica)
    {
        $sql = "SELECT cp.fecha_control, cp.edad_rgl_primera as amonorrea, cp.peso, cp.altr_uterina as au,
        cp.prson_arterial as ta, cp.pulso, cp.frecu_cardiaca_fetal as fcf, cp.mov_fetal as m, cp.medicamento,
        cp.signos_alarmas, cp.ultrasonografia, cp.proxima_cita, cp.idatencion
        FROM cntrl_prenatal cp 
        INNER JOIN obstetrica ob ON (cp.id_obstetrica = ob.id_obstetrica)
        WHERE ob.id_obstetrica = '$idobstetrica' and ob.estado = 'A'";
        return ejecutarConsulta($sql);
    }

    public function verificarListadoControlPrenatal($idobstetrica)
    {
        $sql = "SELECT COUNT(*) resultado 
        FROM cntrl_prenatal cp 
        INNER JOIN obstetrica ob ON (cp.id_obstetrica = ob.id_obstetrica)
        WHERE ob.id_obstetrica = '$idobstetrica' and ob.estado = 'A'";
        $resp = ejecutarConsulta($sql);
        $reg = $resp->fetch_object();

        return $reg;
    }

    public function guardarControlPrenatal(
        $idobstetrica,
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
    ) {

        $sql = "INSERT INTO cntrl_prenatal(id_control, id_obstetrica, fecha_control, edad_rgl_primera, peso, altr_uterina, prson_arterial, 
        pulso, frecu_cardiaca_fetal, mov_fetal, medicamento, signos_alarmas, ultrasonografia, proxima_cita, idatencion) 
        values('0', '$idobstetrica', '$fechacontrol', '$edadrgl', '$peso', '$auterina', '$presionart', '$pulso', '$frecfetal', '$movfetal',
        '$medicamentocp', '$signosalarm', '$ultrasonografia', '$proxcita', '$idatencion')";

        return ejecutarConsulta($sql);
    }

    public function listarControlPrenatalPaciente($idpaciente, $idobstetrica)
    {
        $sql = "SELECT CONCAT(p.apaterno, ' ', p.amaterno, ' ', p.nombre) as nombre,
        CONCAT((YEAR(CURDATE( ))- YEAR(p.fecha_nacimiento) - IF( MONTH( CURDATE( ) ) < MONTH(p.fecha_nacimiento), 1, 
        IF ( MONTH(CURDATE( )) = MONTH(p.fecha_nacimiento),IF (DAY( CURDATE( ) ) < DAY(p.fecha_nacimiento ),1,0 ),0)))) as edad,
        p.fecha_nacimiento, p.profesion, case when p.estado_civil = 'S' then 'Soltero/a' when p.estado_civil = 'C' then 'Casado/a' 
        when p.estado_civil = 'D' then 'Divorciado/a' when p.estado_civil = 'V' then 'Viudo/a' ELSE 'Otros' END AS estado_civil,
        o.*
        FROM persona p 
        inner join obstetrica o ON (p.idpersona = o.idpersona) 
        WHERE p.idpersona = '$idpaciente' and o.id_obstetrica = '$idobstetrica'";

        return ejecutarConsulta($sql);
    }

    public function listarDetalleControlPrenatalPaciente($idobstetrica)
    {
        $sql = "SELECT cp.* FROM obstetrica o
        INNER JOIN cntrl_prenatal cp ON (o.id_obstetrica = cp.id_obstetrica)
        WHERE o.id_obstetrica = '$idobstetrica'";

        return ejecutarConsulta($sql);
    }

    public function listarControlPrenatalIdAtencion($idatencion)
    {
        $sql = "SELECT * FROM cntrl_prenatal WHERE idatencion = '$idatencion'";

        return ejecutarConsulta($sql);
    }

    public function buscarControl($idcontrol)
    {
        $sql = "SELECT * FROM cntrl_prenatal WHERE id_control = '$idcontrol'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function actualizarControlPrenatal(
        $idcontrol,
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
    ) {
        $sql = "UPDATE cntrl_prenatal set fecha_control='$fechacontrol', edad_rgl_primera='$edadrgl', peso='$peso', altr_uterina='$auterina',
        prson_arterial='$presionart', pulso='$pulso', frecu_cardiaca_fetal='$frecfetal', mov_fetal='$movfetal', medicamento='$medicamentocp', 
        signos_alarmas='$signosalarm', ultrasonografia='$ultrasonografia', proxima_cita='$proxcita' WHERE id_control='$idcontrol' ";
        return ejecutarConsulta($sql);
    }
}
