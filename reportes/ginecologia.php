<?php
$idginecologia = $_GET['idginecologia'];

require_once "../modelos/Ginecologia.php";

$ginecologia = new Ginecologia();
$respuesta1 = $ginecologia->listarGinecologia($idginecologia);
$datosgenerales = $respuesta1->fetch_object();

$separador = "<tr><td colspan='8'><br /></td></tr>";

$rowGeneral1 = "<th>Nombre:</th><td>$datosgenerales->paciente</td>";
$rowGeneral1 .= "<th>Edad:</th><td>$datosgenerales->edad</td>";
$rowGeneral1 .= "<th>Fecha:</th><td>$datosgenerales->fecha $datosgenerales->hora</td>";
$rowGeneral1 .= "<th>Paridad:</th><td>$datosgenerales->paridad</td>";

$rowGeneral2 = "<th>F.U.R.:</th><td>$datosgenerales->fecha_ult_regla</td>";
$rowGeneral2 .= "<th>F.U.P.:</th><td>$datosgenerales->fecha_ult_parto</td>";
$rowGeneral2 .= "<th>Menopausia:</th><td>$datosgenerales->menopausia</td>";
$rowGeneral2 .= "<th>Climaterio:</th><td>$datosgenerales->climaterio</td>";

$rowGeneral3 = "<th>Menarquia:</th><td>$datosgenerales->menarquia</td>";
$rowGeneral3 .= "<th>C.M.R.:</th><td>$datosgenerales->ciclos_mestrl_regulares</td>";
$rowGeneral3 .= "<th>Ultimo PAP:</th><td>$datosgenerales->ultm_citologia</td>";
$rowGeneral3 .= "<th>M.P.F.:</th><td>$datosgenerales->metd_planf_familiar</td>";

$rowGeneral4 = "<th>CX.:</th><td>$datosgenerales->consultar_por</td>";
$rowGeneral4 .= "<th>PE.:</th><td>$datosgenerales->presenta_enfemedade</td>";
$rowGeneral4 .= "<th>Antecedentes Medicos:</th><td >$datosgenerales->antecedentes_medic</td>";
$rowGeneral4 .= "<th>Antecedentes Quirurgicos:</th><td>$datosgenerales->antecedentes_quirurgico</td>";

$rowGeneral5 = "<th>Ultrasonografia:</th><td>$datosgenerales->ultrasonografia</td>";
$rowGeneral5 .= "<th>Mamografia:</th><td>$datosgenerales->mamografia</td>";
$rowGeneral5 .= "<th>Impresión Diagnóstica:</th><td>$datosgenerales->imp_diagnost</td>";
$rowGeneral5 .= "<th>Tratamiento:</th><td>$datosgenerales->tratamiento</td>";

$rowGeneral6 = "<th>Alergias:</th><td colspan='5'>$datosgenerales->alergias</td>";
$rowGeneral6 .= "<th>Proxima Cita:</th><td>$datosgenerales->proxima_cita</td>";

$rowGeneral7 = "<th>Examen Fisico:</th><td colspan='7'>$datosgenerales->examen_fisico</td>";


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
      <title>Reporte de Ginecologia</title>
      <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    </head>

    <body>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="table-responsive">
              <table width="100%" border="1" cellpadding="5" cellspacing="5" style="font-size: 18px; border:0px">
                <tr>

                  <td colspan="8">
                    <center><img src="../public/images/logos/logoG.jpg" width="100%"></center>
                  </td>
                </tr>
                <tr>
                  <td colspan="8">
                    <center>
                      <h4><b>Ginecología</b></h4>
                    </center>
                    <center>
                      <h6><b>Dra. Ingrid Hernández de Castro</b></h6>
                    </center>
                  </td>
                </tr>

                <?= $separador ?>
                <tr style="font-size: 12px;">
                  <?= $rowGeneral1 ?>
                </tr>
                <?= $separador ?>
                <tr style="font-size: 12px;">
                  <?= $rowGeneral2 ?>
                </tr>
                <?= $separador ?>
                <tr style="font-size: 12px;">
                  <?= $rowGeneral3 ?>
                </tr>
                <?= $separador ?>
                <tr style="font-size: 12px;">
                  <?= $rowGeneral4 ?>
                </tr>
                <?= $separador ?>
                <tr style="font-size: 12px;">
                  <?= $rowGeneral5 ?>
                </tr>
                <?= $separador ?>
                <tr style="font-size: 12px;">
                  <?= $rowGeneral6 ?>
                </tr>
                <?= $separador ?>
                <tr style="font-size: 12px;">
                  <?= $rowGeneral7 ?>
                </tr>

                <tr>
                  <td colspan="8">
                    <center><img src="../public/images/logos/piePagina.jpg" width="100%"></center>
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