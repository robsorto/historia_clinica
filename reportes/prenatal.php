<?php
$idpaciente = $_GET['idpaciente'];
$idobstetrica = $_GET['idobstetrica'];

require_once "../modelos/ControlPrenatal.php";

$prenatal = new ControlPrenatal();
$respuesta1 = $prenatal->listarControlPrenatalPaciente($idpaciente, $idobstetrica);
$respuesta2 = $prenatal->listarDetalleControlPrenatalPaciente($idobstetrica);
$datosgenerales = $respuesta1->fetch_object();

$separador = "<tr><td colspan='14'><br /></td></tr>";

$rowGeneral1 = "<th style='font-size:10px'>Nombre:</th><td style='font-size:10px' colspan='3'>$datosgenerales->nombre</td>";
$rowGeneral1 .= "<th style='font-size:10px'>Edad:</th><td style='font-size:10px'>$datosgenerales->edad</td>";
$rowGeneral1 .= "<th style='font-size:10px'>Fecha de Nacimiento:</th><td style='font-size:10px'>$datosgenerales->fecha_nacimiento</td>";
$rowGeneral1 .= "<th style='font-size:10px'>Escolaridad:</th><td style='font-size:10px' colspan='2'>$datosgenerales->profesion</td>";
$rowGeneral1 .= "<th style='font-size:10px'>Estado Civil:</th><td style='font-size:10px' colspan='2'>$datosgenerales->estado_civil</td>";

$rowGeneral2 = "<th style='font-size:10px'>Paridad:</th><td style='font-size:10px' >$datosgenerales->paridad</td>";
$rowGeneral2 .= "<th style='font-size:10px'>F.U.R:</th><td style='font-size:10px' colspan='1'>$datosgenerales->fecha_ult_regla</td>";
$rowGeneral2 .= "<th style='font-size:10px'>F.P.P:</th><td style='font-size:10px' colspan='1'>$datosgenerales->fecha_prb_parto</td>";
$rowGeneral2 .= "<th style='font-size:10px'>Amenorrea:</th><td style='font-size:10px' >$datosgenerales->edad_rgl_primera</td>";
$rowGeneral2 .= "<th style='font-size:10px'>Edad Gestional:</th><td style='font-size:10px'>$datosgenerales->edad_gestorial</td>";
$rowGeneral2 .= "<th style='font-size:10px'>Talla:</th><td style='font-size:10px' colspan='1'>$datosgenerales->talla</td>";
$rowGeneral2 .= "<th style='font-size:10px'>IMC:</th><td style='font-size:10px' colspan='2'>$datosgenerales->indc_m_corporal</td>";

$rowGeneral3 = "<th style='font-size:10px' colspan='6'>Antecedentes Médicos o Quirúrgicos:</th><td style='font-size:10px' colspan='9'>$datosgenerales->antecedentes</td>";

$rowGeneral4_1 = "<th style='font-size:10px' colspan='2'>Hto:</th><td style='font-size:10px' colspan='2'>$datosgenerales->hematocrito_v1 <b>/</b> $datosgenerales->hematocrito_v2</td>";
$rowGeneral4_1 .= "<th style='font-size:10px' colspan='2'>Hb:</th><td style='font-size:10px' colspan=.'2'>$datosgenerales->hematocrito_v1 <b>/</b> $datosgenerales->hematocrito_v2</td>";
$rowGeneral4_1 .= "<th style='font-size:10px' colspan='2'>Glisemia:</th><td style='font-size:10px' colspan='2'>$datosgenerales->glucosa_v1 <b>/</b> $datosgenerales->glucosa_v2</td>";
$rowGeneral4_1 .= "<th  style='font-size:10px' colspan='2'>Tipeo:</th><td style='font-size:10px' colspan='2'>$datosgenerales->tipeo</td>";
$rowGeneral4_2 = "<th style='font-size:10px' colspan='2'>EGO:</th><td style='font-size:10px' colspan='1'>$datosgenerales->exam_gnrl_orina <b>/</b>$datosgenerales->exam_gnrl_orina2 </td>";
$rowGeneral4_2 .= "<th style='font-size:10px' colspan='2'>EGH:</th><td style='font-size:10px' colspan='1'>$datosgenerales->exam_gnrl_heces</td>";
$rowGeneral4_2 .= "<th style='font-size:10px' colspan='2'>VDRL:</th><td style='font-size:10px' colspan='1'>$datosgenerales->cifilis</td>";
$rowGeneral4_2 .= "<th style='font-size:10px' colspan='2'>VHI:</th><td style='font-size:10px' colspan='1'>$datosgenerales->vhi</td>";
$rowGeneral4_2 .= "<th style='font-size:10px' colspan='1'>PAP:</th><td style='font-size:10px' colspan='1'>$datosgenerales->papanicolao</td>";

$rowGeneral5 = "<th style='font-size:10px' colspan='3'>Otros:</th><td style='font-size:10px' colspan='15'>$datosgenerales->otros</td>";
$rowGeneral6 = "<th style='font-size:10px' colspan='3'>Vacunas:</th><td style='font-size:10px' colspan='15'>$datosgenerales->vacunas</td>";

$controlPrenatal = '';

while ($detalle = $respuesta2->fetch_object()) {
  $controlPrenatal .= "<tr>";
  $controlPrenatal .= "<td style='font-size:10px'>$detalle->fecha_control</td>";
  $controlPrenatal .= "<td style='font-size:10px'>$detalle->edad_rgl_primera</td>";
  $controlPrenatal .= "<td style='font-size:10px'>$detalle->peso</td>";
  $controlPrenatal .= "<td style='font-size:10px'>$detalle->altr_uterina</td>";
  $controlPrenatal .= "<td style='font-size:10px'>$detalle->prson_arterial</td>";
  $controlPrenatal .= "<td style='font-size:10px'>$detalle->pulso</td>";
  $controlPrenatal .= "<td style='font-size:10px'>$detalle->frecu_cardiaca_fetal</td>";
  $controlPrenatal .= "<td style='font-size:10px'>$detalle->mov_fetal</td>";
  $controlPrenatal .= "<td style='font-size:10px'>$detalle->medicamento</td>";
  $controlPrenatal .= "<td style='font-size:10px'>$detalle->signos_alarmas</td>";
  $controlPrenatal .= "<td style='font-size:10px'>$detalle->ultrasonografia</td>";
  $controlPrenatal .= "</tr>";
}

//Obtenemos valores de la base de datos
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  if ($_SESSION['pacientes'] == 1) {

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
      <meta charset="utf-8">
      <title>Reporte de Control Prenatal Clínica</title>
      <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    </head>

    <body >
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="table-responsive">
              <table width="100%" border="1" cellpadding="5" cellspacing="5" style="font-size: 20px; border:0px">
                <tr>

                  <td colspan="14">
                    <center><img src="../public/images/logos/logoG.jpg" width="80%"></center>
                  </td>
                </tr>
                <tr>
                  <td colspan="14">
                    <center>
                      <h3><b>Control Prenatal</b></h3>
                    </center>
                    <center>
                      <h6><b>Dra. Ingrid Hernández de Castro</b></h6>
                    </center>
                  </td>
                </tr>

                <?= $separador ?>
                <tr>
                  <?= $rowGeneral1 ?>
                </tr>
                <?= $separador ?>
                <tr>
                  <?= $rowGeneral2 ?>
                </tr>
                <?= $separador ?>
                <tr>
                  <?= $rowGeneral3 ?>
                </tr>
                <?= $separador ?>
                <tr>
                  <?= $rowGeneral4_1 ?>
                </tr>
                <tr>
                  <?= $rowGeneral4_2 ?>
                </tr>
                <?= $separador ?>
                <tr>
                  <?= $rowGeneral5 ?>
                </tr>
                <?= $separador ?>
                <tr>
                  <?= $rowGeneral6 ?>
                </tr>

                <?= $separador ?>
                <tr>
                  <td colspan="14">
                    <table width="100%" border="1" cellpadding="5" cellspacing="5" style="font-size: 20px;">
                      <thead>
                        <tr >
                          <th style="font-size:12px">Fecha</th>
                          <th style="font-size:12px">Amenorrea/EG</th>
                          <th style="font-size:12px">Peso</th>
                          <th style="font-size:12px">AU</th>
                          <th style="font-size:12px">TA</th>
                          <th style="font-size:12px">Pulso</th>
                          <th style="font-size:12px">FCF</th>
                          <th style="font-size:12px">M</th>
                          <th style="font-size:12px">Medicamentos</th>
                          <th style="font-size:12px">Signos y síntomas de alarma</th>
                          <th style="font-size:12px">Ultrasonografía</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?= $controlPrenatal ?>
                      </tbody>
                    </table>
                  </td>
                </tr>

              </table>
            </div>
          </div>
        </div>
      </div>

    </body>

    </html>
  <?php
  } else {
    require '../vistas/noacceso.php';
  }
  ?>
<?php
}
ob_end_flush();
?>