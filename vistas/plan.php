  <?php
  error_reporting(0);
  ob_start();
  session_start();

  if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
  } else {
    require 'header.php';

    if ($_SESSION['resultado'] == 1) {
  ?>
      <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h1 class="box-title">Plan de Atención</h1>
                  <div class="box-tools pull-right">
                  </div>
                </div>
                <!-- /.box-header -->
                <!-- centro -->
                <div class="panel-body table-responsive" id="listadoregistros">
                  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                      <th>Opciones</th>
                      <th>Fecha</th>
                      <th>Registrador</th>
                      <th>Servicio</th>
                      <th>Especialista</th>
                      <th>Paciente</th>
                      <th>Costo</th>
                      <th>Estado</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <th>Opciones</th>
                      <th>Fecha</th>
                      <th>Registrador</th>
                      <th>Servicio</th>
                      <th>Especialista</th>
                      <th>Paciente</th>
                      <th>Costo</th>
                      <th>Estado</th>
                    </tfoot>
                  </table>
                </div>

                <div class="panel-body" id="formularioregistros">
                  <form name="formulario" id="formulario" method="POST">

                    <!--TABS PARA DESPLAZARSE EN LA PANTALLA-->
                    <ul id="tabs-plan-atencion" class="nav nav-tabs">
                      <li id="plan-atencion" class="active"><a style="cursor: pointer;">PLAN ATENCIÓN</a></li>
                      <li id="plan-general"><a style="cursor: pointer;">CONSULTA GENERAL</a></li>
                      <li id="plan-obs"><a style="cursor: pointer;">OBSTETRICA</a></li>
                      <li id="plan-control"><a style="cursor: pointer;">CONTROL PRENATAL</a></li>
                      <li id="plan-gine"><a style="cursor: pointer;">GINECOLOGIA</a></li>
                      <li id="plan-receta"><a style="cursor: pointer;">DIAGNOSTICO Y TRATAMIENTO</a></li>
                    </ul>

                    <div id="atencion-content">
                      <h3 class="text-center">Plan de atención</h3>
                      <div class="row text-center">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-lg-offset-3 col-md-offset-3">
                          <label for="tipoConsulta">Seleccione un tipo atención</label>
                          <select class="form-control" id="tipoConsulta" name="tipoConsulta" required>
                          </select>
                        </div>
                      </div>
                      <br />
                      <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                          <label for="paciente">Paciente</label>
                          <input type="text" readonly id="paciente" class="form-control" name="paciente">
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                          <label for="dni">Documento</label>
                          <input type="text" readonly id="dni" class="form-control" name="dni">
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                          <label for="edad">Edad</label>
                          <input type="text" readonly id="edad" class="form-control" name="edad">
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                          <label for="especialista">Especialista</label>
                          <input type="text" readonly id="especialista" class="form-control" name="especialista">
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                          <label for="servicio">Servicio</label>
                          <input type="text" readonly id="servicio" class="form-control" name="servicio">
                        </div>
                      </div>
                      <br />
                      <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                          <label for="presion_arterial">Presión Arterial (mmhg)</label>
                          <input type="text" id="presion_arterial" class="form-control" name="presion_arterial">
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                          <label for="temperatura">Temperatura (&deg;C)</label>
                          <input type="text" id="temperatura" class="form-control" name="temperatura">
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                          <label for="frecuencia_respiratoria">Frecuencia Respiratoria (x')</label>
                          <input type="text" id="frecuencia_respiratoria" class="form-control" name="frecuencia_respiratoria">
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                          <label for="frecuencia_cardiaca">Frecuencia Cardiaca (x')</label>
                          <input type="text" id="frecuencia_cardiaca" class="form-control" name="frecuencia_cardiaca">
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                          <label for="saturacion">Saturación (%)</label>
                          <input type="text" id="saturacion" class="form-control" name="saturacion">
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                          <label for="pesoT">Peso (Kg)</label>
                          <input type="text" id="pesoT" class="form-control" name="pesoT">
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                          <label for="tallaT">Talla (Cm)</label>
                          <input type="text" id="tallaT" class="form-control" name="tallaT">
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                          <label for="imcT">IMC</label>
                          <input type="text" id="imcT" class="form-control" name="imcT">
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                          <label>Estado:</label>
                          <input type="text" class="form-control" name="estadoT" id="estadoT" maxlength="256" placeholder="estado" disabled="">
                        </div>
                      </div>
                    </div>

                    <div id="general-content" class="d-none">
                      <h3 class="text-center">Consulta General</h3>
                      <br />
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                          <label for="nombrePacienteG">Nombre paciente:</label>
                          <input type="text" id="nombrePacienteG" name="nombrePacienteG" readonly="true" disabled="true" class="form-control" />
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                          <label for="nacimientoPacienteG">Fecha Nacimiento:</label>
                          <input type="text" id="nacimientoPacienteG" name="nacimientoPacienteG" readonly="true" disabled="true" class="form-control" />
                        </div>
                        <div class="col-lg-4 col-md-3 col-sm-12">
                          <label for="edadPacienteG">Edad:</label>
                          <input type="text" id="edadPacienteG" name="edadPacienteG" readonly="true" disabled="true" class="form-control" />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                          <label for="escolaridadPacienteG">Escolaridad:</label>
                          <input type="text" id="escolaridadPacienteG" name="escolaridadPacienteG" readonly="true" disabled="true" class="form-control" />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                          <label for="estadoCPacienteG">Estado Civil:</label>
                          <input type="text" id="estadoCPacienteG" name="estadoCPacienteG" readonly="true" disabled="true" class="form-control" />
                        </div>
                      </div>
                      <br />
                      <div class="row">
                        <div class="form-group col-lg-6 col-md-56 col-sm-12 col-xs-6">
                          <label>Motivo de la Consulta:</label>
                          <input type="hidden" class="form-control" name="idresultado" id="idresultado">
                          <input type="hidden" class="form-control" name="idatencion" id="idatencion">
                          <textarea class="form-control" name="motivo_consulta" id="motivo_consulta" rows="3">
                                    </textarea>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-6">
                          <label>Antecedentes:</label>
                          <textarea class="form-control" name="antecedentes" id="antecedentes" rows="3">
                                    </textarea>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-2">
                          <label>Telefono:</label>
                          <input type="text" class="form-control" name="tiempo_enfermedad" id="tiempo_enfermedad" maxlength="30">
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-2">
                          <label>Telefono Referencia:</label>
                          <input type="text" class="form-control" name="tel_ref" id="tel_ref" maxlength="30">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-4">
                          <label>Nombre de referencia:</label>
                          <input type="text" class="form-control" name="nombre_ref" id="nombre_ref" maxlength="30">
                        </div>
                        <div class="form-group col-lg-2 col-md-32 col-sm-12 col-xs-2">
                          <label>Vacunas completas:</label>
                          <select class="form-control" name="vacunas_completas" id="vacunas_completas">
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                          </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-2">
                          <label>Fecha inicio malestar:</label>
                          <input type="date" class="form-control" name="fecha_in_mal" id="fecha_in_mal">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-4">
                          <label>Padece Enfermedades:</label>
                          <input type="text" class="form-control" name="p_enfermedades" id="p_enfermedades" maxlength="200">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-4">
                          <label>Padece Alergias:</label>
                          <input type="hidden" name="idpersona" id="idpersona">
                          <input type="text" class="form-control" name="alergia" id="alergia" maxlength="100">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-4">
                          <label>Toma medicamentos:</label>
                          <input type="text" class="form-control" name="toma_medicamento" id="toma_medicamento" maxlength="200">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-3">
                          <label>Intervenciones Quirúrgicas:</label>
                          <input type="text" class="form-control" name="intervenciones_quirurgicas" id="intervenciones_quirurgicas" maxlength="100">
                        </div>

                        <div class="form-group col-lg-7 col-md-7 col-sm-12 col-xs-7">
                          <label>Plan:</label>
                          <input type="text" class="form-control" name="plan" id="plan" maxlength="256">
                        </div>
                        <div class="form-group col-lg-2 col-md-32 col-sm-12 col-xs-2">
                          <label>Próxima Cita:</label>
                          <input type="date" class="form-control" name="proxima_cita" id="proxima_cita">
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <label>Examen Físico:</label>
                          <textarea class="form-control" name="examen_fisico" id="examen_fisico" rows="2">
                                    </textarea>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        </div>

                      </div>
                    </div>

                    <div id="obstetrica-content" class="d-none">
                      <div class="panel-body">
                        <h3 class="text-center">Consulta Obstetrica</h3>
                        <input type="hidden" id="validaDatosObstetrica" name="validaDatosObstetrica" />
                        <input type="hidden" id="idobstetricaPacienteGnrl" name="idobstetricaPacienteGnrl" class="form-control" />
                        <div class="row">
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="nombrePacienteO">Nombre paciente:</label>
                            <input type="text" id="nombrePacienteO" name="nombrePacienteO" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="nacimientoPacienteO">Fecha Nacimiento:</label>
                            <input type="text" id="nacimientoPacienteO" name="nacimientoPacienteO" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-3 col-sm-12">
                            <label for="edadPacienteO">Edad:</label>
                            <input type="text" id="edadPacienteO" name="edadPacienteO" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="escolaridadPacienteO">Escolaridad:</label>
                            <input type="text" id="escolaridadPacienteO" name="escolaridadPacienteO" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="estadoCPacienteO">Estado Civil:</label>
                            <input type="text" id="estadoCPacienteO" name="estadoCPacienteO" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="pesoPacienteO">PESO KGS:</label>
                            <input type="text" id="pesoPacienteO" name="pesoPacienteG" readonly="true" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="tallaPacienteO">TALLA MTS:</label>
                            <input type="text" id="tallaPacienteO" name="tallaPacienteG" readonly="true" class="form-control" />
                          </div>
                          <div class="col-lg-2 col-md-2 col-sm-12">
                            <label for="tallaPacienteO">IMC:</label>
                            <input type="text" id="imcPacienteO" name="tallaPacienteG" readonly="true" class="form-control" />
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Estado:</label>
                            <input type="text" class="form-control" name="estadoO" id="estadoO" maxlength="256" placeholder="estado" disabled="">
                          </div>
                        </div>
                        <br />
                        <div class="row">
                          <div class="col-lg-2 col-md-3 col-sm-12">
                            <label for="paridadPaciente">PARIDAD:</label>
                            <input type="text" id="paridadPaciente" name="paridadPaciente" class="form-control" placeholder="Paridad" />
                          </div>
                          <div class="col-lg-2 col-md-3 col-sm-12">
                            <label for="furPaciente">FUR:</label>
                            <input type="date" id="furPaciente" name="furPaciente" class="form-control" />
                          </div>
                          <div class="col-lg-2 col-md-3 col-sm-12">
                            <label for="fppPaciente">F.P.P:</label>
                            <input type="date" id="fppPaciente" name="fppPaciente" class="form-control" />
                          </div>
                          <div class="col-lg-2 col-md-3 col-sm-12">
                            <label for="amenorreoPaciente">AMENORREA:</label>
                            <input type="text" id="amenorreoPaciente" name="amenorreoPaciente" class="form-control" placeholder="Amenorrea" />
                          </div>
                          <div class="col-lg-2 col-md-3 col-sm-12">
                            <label for="eGestionalPaciente">EDAD GESTIONAL:</label>
                            <input type="text" id="eGestionalPaciente" name="eGestionalPaciente" class="form-control" placeholder="Edad gestional" />
                          </div>
                          <div class="col-lg-2 col-md-3 col-sm-12">
                            <label for="tipeoPaciente">TIPEO:</label>
                            <input type="text" id="tipeoPaciente" name="tipeoPaciente" class="form-control" placeholder="Tipeo" />
                          </div>

                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="eghPaciente">EGH:</label>
                            <input type="text" id="eghPaciente" name="eghPaciente" class="form-control" placeholder="Egh" />
                          </div>
                          <div class="col-lg-2 col-md-3 col-sm-12">
                            <label for="vdrlPaciente">VDRL:</label>
                            <input type="text" id="vdrlPaciente" name="vdrlPaciente" class="form-control" placeholder="Vdrl" />
                          </div>
                          <div class="col-lg-2 col-md-3 col-sm-12">
                            <label for="vhiPaciente">VHI:</label>
                            <input type="text" id="vhiPaciente" name="vhiPaciente" class="form-control" placeholder="Vhi" />
                          </div>
                          <div class="col-lg-2 col-md-3 col-sm-12">
                            <label for="papPaciente">PAP:</label>
                            <input type="text" id="papPaciente" name="papPaciente" class="form-control" placeholder="Pap" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="seguroPaciente">SEGURO:</label>
                            <input type="text" id="seguroPaciente" name="seguroPaciente" class="form-control" placeholder="Seguro" />
                          </div>

                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                              <label for="" class="text-center" style="width: 100%">HTO</label>
                              <div class="input-group">
                                <input type="text" id="hto1Paciente" name="hto1Paciente" class="form-control" placeholder="Valor 1">
                                <span class="input-group-addon"></span>
                                <input type="text" id="hto2Paciente" name="hto2Paciente" class="form-control" placeholder="Valor 2">
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                              <label for="" class="text-center" style="width: 100%">HB</label>
                              <div class="input-group">
                                <input type="text" id="hb1Paciente" name="hb1Paciente" class="form-control" placeholder="Valor 1">
                                <span class="input-group-addon"></span>
                                <input type="text" id="hb2Paciente" name="hb2Paciente" class="form-control" placeholder="Valor 2">
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                              <label for="" class="text-center" style="width: 100%">GLISEMIA</label>
                              <div class="input-group">
                                <input type="text" id="glisema1Paciente" name="glisema1Paciente" class="form-control" placeholder="Valor 1">
                                <span class="input-group-addon"></span>
                                <input type="text" id="glisema2Paciente" name="glisema2Paciente" class="form-control" placeholder="Valor 2">
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                              <label for="" class="text-center" style="width: 100%">EGO</label>
                              <div class="input-group">
                                <input type="text" id="ego1Paciente" name="ego1Paciente" class="form-control" placeholder="Valor 1">
                                <span class="input-group-addon"></span>
                                <input type="text" id="ego2Paciente" name="ego2Paciente" class="form-control" placeholder="Valor 2">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-9 col-md-9 col-sm-12">
                            <label for="antecedentesPacienteObs">ANTECEDENTES MEDICOS QUIRURGICOS:</label>
                            <input type="text" id="antecedentesPacienteObs" name="antecedentesPacienteObs" class="form-control" placeholder="Antecedentes medicos quirurgicos" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="alergiasObs">ALERGIAS:</label>
                            <input type="text" id="alergiasObs" name="alergiasObs" class="form-control" placeholder="Alergias" />
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="vacunaPaciente">VACUNAS:</label>
                            <input type="text" id="vacunaPaciente" name="vacunaPaciente" class="form-control" placeholder="Vacunas" />
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="otrosPaciente">OTROS:</label>
                            <input type="text" id="otrosPaciente" name="otrosPaciente" class="form-control" placeholder="Otros" />
                          </div>
                          <!--<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Examen Físico:</label>
                            <textarea class="form-control" name="examen_fisicoOBS" id="examen_fisicoOBS" rows="2"></textarea>
                          </div>-->
                        </div>

                      </div>
                    </div>

                    <div id="control-content" class="d-none">
                      <div class="panel-body">
                        <h3 class="text-center">Control Prenatal</h3>
                        <div class="row">
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="nombrePacienteC">Nombre paciente:</label>
                            <input type="text" id="nombrePacienteC" name="nombrePacienteC" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="nacimientoPacienteC">Fecha Nacimiento:</label>
                            <input type="text" id="nacimientoPacienteC" name="nacimientoPacienteC" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-3 col-sm-12">
                            <label for="edadPacienteC">Edad:</label>
                            <input type="text" id="edadPacienteC" name="edadPacienteC" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="escolaridadPacienteC">Escolaridad:</label>
                            <input type="text" id="escolaridadPacienteC" name="escolaridadPacienteC" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="estadoCPacienteC">Estado Civil:</label>
                            <input type="text" id="estadoCPacienteC" name="estadoCPacienteC" readonly="true" disabled="true" class="form-control" />
                          </div>
                        </div>
                        <br />
                        <div class="row">
                          <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-6">
                            <button type="button" id="btn-activar-modal" class="btn form-control btn-success">
                              <i class="fa fa-plus"></i> Agregar
                            </button>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-6">
                            <button type="button" id="btn-desactivar-control" class="btn form-control btn-primary">
                              <i class="fa fa-close"></i> Finalizar Control Prenatal
                            </button>
                          </div>
                          <div class="table-wrap">
                            <br />
                            <table id="table-control-prenatal" style="width: 100%;" class="table table-striped">
                              <thead>
                                <tr>
                                  <th>FECHA</th>
                                  <th>AMONORREA/EG</th>
                                  <th>PESO kgs</th>
                                  <th>AU</th>
                                  <th>TA</th>
                                  <th>PULSO</th>
                                  <th>FCF</th>
                                  <th>M</th>
                                  <th>MEDICAMENTO</th>
                                  <th>SIGNOS Y SINTOMAS DE ALARMAS</th>
                                  <th>ULTRASONOGRAFIA</th>
                                  <th>PRIXIMA CITA</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="ginecologia-content" class="d-none">
                      <div class="panel-body">
                        <h3 class="text-center">Consulta Ginecologica</h3>
                        <div class="row">
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="nombrePacienteGine">Nombre paciente:</label>
                            <input type="text" id="nombrePacienteGine" name="nombrePacienteGine" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="nacimientoPacienteGine">Fecha Nacimiento:</label>
                            <input type="text" id="nacimientoPacienteGine" name="nacimientoPacienteGine" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-3 col-sm-12">
                            <label for="edadPacienteGine">Edad:</label>
                            <input type="text" id="edadPacienteGine" name="edadPacienteGine" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="escolaridadPacienteGine">Escolaridad:</label>
                            <input type="text" id="escolaridadPacienteGine" name="escolaridadPacienteGine" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="estadoCPacienteGine">Estado Civil:</label>
                            <input type="text" id="estadoCPacienteGine" name="estadoCPacienteGine" readonly="true" disabled="true" class="form-control" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="pesoPacienteG">PESO KGS:</label>
                            <input type="text" id="pesoPacienteG" name="pesoPacienteG" readonly="true" class="form-control" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="tallaPacienteG">TALLA MTS:</label>
                            <input type="text" id="tallaPacienteG" name="tallaPacienteG" readonly="true" class="form-control" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="tallaPacienteG">IMC:</label>
                            <input type="text" id="imcPacienteG" name="tallaPacienteG" readonly="true" class="form-control" />
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Estado:</label>
                            <input type="text" class="form-control" name="estadoG" id="estadoG" maxlength="256" placeholder="estado" disabled="">
                          </div>
                        </div>
                        <br />
                        <div class="row">
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="paridadPacienteG">PARIDAD:</label>
                            <input type="text" id="paridadPacienteG" name="paridadPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="furPacienteG">FUR:</label>
                            <input type="date" id="furPacienteG" name="furPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="fupPacienteG">FUP:</label>
                            <input type="date" id="fupPacienteG" name="fupPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="climaterioPacienteG">CLIMATERIO:</label>
                            <input type="text" id="climaterioPacienteG" name="climaterioPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="menarquiaPacienteG">MENARQUIA:</label>
                            <input type="text" id="menarquiaPacienteG" name="menarquiaPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="menopausiaPacienteG">MENOPAUSIA:</label>
                            <input type="text" id="menopausiaPacienteG" name="menopausiaPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="mpfPacienteG">MPF:</label>
                            <input type="text" id="mpfPacienteG" name="mpfPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="cmrPacienteG">CMR:</label>
                            <input type="text" id="cmrPacienteG" name="cmrPacienteG" class="form-control" />
                          </div>

                        </div>
                        <br />
                        <h4 class="text-center">ANTECEDENTES</h4>
                        <div class="row">
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="ultpapPacienteG">ULTPAP:</label>
                            <input type="text" id="ultpapPacienteG" name="ultpapPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="alerPacienteG">ALERGIAS:</label>
                            <input type="text" id="alerPacienteG" name="alerPacienteG" class="form-control" />
                          </div>

                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="medicosPacienteG">MEDICOS:</label>
                            <input type="text" id="medicosPacienteG" name="medicosPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="quirurgicosPacienteG">QUIRURGICOS:</label>
                            <input type="text" id="quirurgicosPacienteG" name="quirurgicosPacienteG" class="form-control" />
                          </div>

                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="ultraPacienteG">ULTRASONOGRAFIAS:</label>
                            <input type="text" id="ultraPacienteG" name="ultraPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="mamografiasPacienteG">MAMOGRAFIAS:</label>
                            <input type="text" id="mamografiasPacienteG" name="mamografiasPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="cxPacienteG">CX:</label>
                            <input type="text" id="cxPacienteG" name="cxPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="pePacienteG">PE:</label>
                            <input type="text" id="pePacienteG" name="pePacienteG" class="form-control" />
                          </div>
                        </div>
                        <br />
                        <h4 class="text-center">EXAMEN FISICO</h4>
                        <div class="row">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Examen Físico:</label>
                            <textarea class="form-control" name="examen_fisicoGINE" id="examen_fisicoGINE" rows="2"></textarea>
                          </div>
                          <!--<div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="taPacienteG">TA:</label>
                            <input type="text" id="taPacienteG" name="taPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="fcPacienteG">FC:</label>
                            <input type="text" id="fcPacienteG" name="fcPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="frPacienteG">FR:</label>
                            <input type="text" id="frPacienteG" name="frPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="temPacienteG">TEMPERATURA C°:</label>
                            <input type="text" id="temPacienteG" name="temPacienteG" class="form-control" />
                          </div>


                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="cabezaPacienteG">CABEZA:</label>
                            <input type="text" id="cabezaPacienteG" name="cabezaPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="cuelloPacienteG">CUELLO:</label>
                            <input type="text" id="cuelloPacienteG" name="cuelloPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="toraxPacienteG">TORAX:</label>
                            <input type="text" id="toraxPacienteG" name="toraxPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="abdomenPacienteG">ABDOMENM:</label>
                            <input type="text" id="abdomenPacienteG" name="abdomenPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="gePacienteG">GE:</label>
                            <input type="text" id="gePacienteG" name="gePacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="spPacienteG">SP:</label>
                            <input type="text" id="spPacienteG" name="spPacienteG" class="form-control" />
                          </div>-->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="indiagPacienteG">IMPRESIÓN DIAGNOSTICA:</label>
                            <input type="text" id="indiagPacienteG" name="indiagPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="trataPacienteG">TRATAMIENTO:</label>
                            <input type="text" id="trataPacienteG" name="trataPacienteG" class="form-control" />
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="pCitaPacienteG">PROXIMA CITA:</label>
                            <input type="date" id="pCitaPacienteG" name="pCitaPacienteG" class="form-control" />
                          </div>


                        </div>
                      </div>
                    </div>

                    <div id="receta-content" class="d-none">
                      <br />
                      <h3 class="text-center">Resumen de consulta</h3>
                      <br />
                      <div class="col-row">
                        <div class="panel panel-primary">
                          <h4 class="text-center text-bold">Diagnosticos y tratamiento</h4>
                          <hr />
                          <div class="panel-body">

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <label>Código (Nombre)</label>
                              <div class="input-group">

                                <span class="input-group-btn">
                                  <button type="button" onclick="buscarDiagnostico()" class="btn btn-info">Consultar</button>
                                </span>
                                <input type="text" class="form-control" name="texto" id="texto">
                              </div>
                            </div>

                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>Diagnósticos</label>
                              <ul id="diagnosticos">
                              </ul>
                            </div>
                            <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                              <label>Aplicar</label>
                              <table id="detalles" class="table">
                                <thead style="background-color: #A9D0F5;">
                                  <tr>
                                    <th>Borrar</th>
                                    <th>Tipo</th>
                                    <th>Enfermedad</th>
                                  </tr>
                                <tbody>
                                </tbody>
                                </thead>
                              </table>
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <label>Diagnostico:</label>
                              <textarea class="form-control" name="tratamiento" id="tratamiento" rows="2"></textarea>
                            </div>
                          </div>
                        </div>
                        <br />
                        <div class="panel panel-primary">
                          <h4 class="text-center text-bold">Recetas</h4>
                          <hr />
                          <div class="panel-body">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <label>Receta <button type="button" class="btn btn-sm btn-success" onclick="agregarReceta()"><i class="fa fa-plus"></i></button></label>
                              <table id="recetas" class="table">
                                <thead style="background-color: #A9D0F5;">
                                  <tr>
                                    <th>Borrar</th>
                                    <th>Medicamento</th>
                                    <th>Presentación</th>
                                    <th>Dosis</th>
                                    <th>Duración</th>
                                    <th>Cantidad</th>
                                  </tr>
                                <tbody>
                                  <tr class="filasr" id="filar0">
                                    <td><button type="button" class="btn btn-sm btn-danger" onclick="eliminarReceta(1)"><i class="fa fa-trash"></i></button></td>
                                    <td><input type="text" class="form-control" name="medicamento[]" required=""></td>
                                    <td><input type="text" class="form-control" name="presentacion[]"></td>
                                    <td><input type="text" class="form-control" name="dosis[]"></td>
                                    <td><input type="text" class="form-control" name="duracion[]"></td>
                                    <td><input type="text" class="form-control" name="cantidad[]"></td>
                                  </tr>
                                </tbody>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <br />
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="guardar">
                      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                      <button class="btn btn-danger" id="btnCancelar" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                  </form>
                </div>
                
                <!--Fin centro -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->
      <!--Fin-Contenido-->
      <div class="modal fade" id="contro_prenatal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content modal-lg">
            <form id="modal-control-prenatal">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Control prenatal</h4>
              </div>
              <div class="modal-body">
                <input type="hidden" id="idobstetricaPacienteModal" name="idobstetricaPacienteModal" class="form-control" />
                <div class="row">
                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="fechaPacienteCP">Fecha:</label>
                    <input type="date" id="fechaPacienteCP" value="<?= date('Y-m-d') ?>" name="fechaPacienteCP" class="form-control" />
                  </div>
                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="amenorreaPacienteCP">AMENORREA:</label>
                    <input type="text" id="amenorreaPacienteCP" name="amenorreaPacienteCP" class="form-control" />
                  </div>
                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="pesoPacienteCP">PESO (kgs):</label>
                    <input type="text" id="pesoPacienteCP" name="pesoPacienteCP" class="form-control" />
                  </div>

                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="auPacienteCP">AU (Altura Uterina):</label>
                    <input type="text" id="auPacienteCP" name="auPacienteCP" class="form-control" />
                  </div>
                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="taPacienteCP">TA (Precion Arterial):</label>
                    <input type="text" id="taPacienteCP" name="taPacienteCP" class="form-control" />
                  </div>
                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="pulsoPacienteCP">PULSO:</label>
                    <input type="text" id="pulsoPacienteCP" name="pulsoPacienteCP" class="form-control" />
                  </div>

                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="fcfPacienteCP">FCF (Frecuencia Cardiaca Fetal):</label>
                    <input type="text" id="fcfPacienteCP" name="fcfPacienteCP" class="form-control" />
                  </div>
                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="mPacienteCP">M (Movimiento Fetal):</label>
                    <input type="text" id="mPacienteCP" name="mPacienteCP" class="form-control" />
                  </div>
                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="medicamentoPacienteCP">MEDICAMENTO:</label>
                    <input type="text" id="medicamentoPacienteCP" name="medicamentoPacienteCP" class="form-control" />
                  </div>

                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="saPacienteCP">SIGNOS Y SINTOMAS DE ALARMAS:</label>
                    <input type="text" id="saPacienteCP" name="saPacienteCP" class="form-control" />
                  </div>
                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="ultraPacienteCP">ULTRASONOGRAFIAS:</label>
                    <input type="text" id="ultraPacienteCP" name="ultraPacienteCP" class="form-control" />
                  </div>
                  <div class="col-lg-4 col-dm-6 col-sm-12">
                    <label for="pcPacienteCP">PROXIMA CITA:</label>
                    <input type="date" id="pcPacienteCP" name="pcPacienteCP" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    <?php
    } else {
      require 'noacceso.php';
    }

    require 'footer.php';
    ?>
    <script type="text/javascript" src="../public/libraries/moment.min.js"></script>
    <script type="text/javascript" src="scripts/plan.js"></script>
  <?php
  }
  ob_end_flush();
  ?>