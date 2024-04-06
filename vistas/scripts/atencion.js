var tabla;

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});

	$("#formularioActualizacion").on("submit", function (e) {
		editarplan(e);
	});

	$("#modal-busqueda-paciente").on("submit", (e) => {
		buscarPacientesCriterio(e);
	});

	$("#modal-control-prenatal").on("submit", (e) => {
		actualizarControlPrenatal(e);
	});

	$.post("../ajax/atencion.php?op=selectEspecialista", function (r) {
		$("#idempleado").html(r);
		$('#idempleado').selectpicker('refresh');
	});
	$.post("../ajax/atencion.php?op=selectServicio", function (r) {
		$("#idservicio").html(r);
		$('#idservicio').selectpicker('refresh');
	});

	$("#pesoTAtencion").change(calcularIMC);
	$("#tallaTAtencion").change(calcularIMC);

	$("#furPaciente").change(() => {
		let fecha = sumarDiasFecha($("#furPaciente").val(), 281).toISOString().slice(0, 10);
		let semanas = obtenerSemanasXDiasCalculados($("#furPaciente").val());
		$("#fppPaciente").val(fecha);
		$("#amenorreoPaciente").val(semanas);
		$("#amenorreaPacienteCP").val(obtenerSemanasXDiasCalculados($("#furPaciente").val(), $("#fechaPacienteCP").val()));
	});

	$("#fechaPacienteCP").change(() => {

		let semanas = obtenerSemanasXDiasCalculados($("#furPaciente").val(), $("#fechaPacienteCP").val());
		console.log(semanas);
		$("#amenorreaPacienteCP").val(semanas);
	});
}

//Función limpiar
function limpiar() {
	$("#idatencion").val("");
	$("#idatencionEdicion").val("");
	$("#costo").val("");
	$("#idpaciente").val("");
	$("#paciente").val("");
	$("#documento").val("");

}

//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#formularioplan").hide();
		$("#btnActualizar").prop("disabled", false);
		$("#btnagregar").hide();
	}
	else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#formularioregistrosEdicion").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar() {
	tabla = $('#tbllistado').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdf'
			],
			"ajax":
			{
				url: '../ajax/atencion.php?op=listar',
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 5
		}).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnActualizar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/atencion.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			bootbox.alert(datos);
			mostrarform(false);
			listar();
		}

	});
	limpiar();
}

function mostrar(idatencion) {
	$.post("../ajax/atencion.php?op=mostrar", { idatencion: idatencion }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		$("#costo").val(data.total);
		$("#idatencion").val(data.idatencion);
		$("#idpaciente").val(data.idpersona);
		$("#paciente").val(data.paciente);
		$("#idservicio").val(data.idservicio);
		$("#idservicio").selectpicker('refresh');
		$("#idempleado").val(data.idempleado);
		$("#idempleado").selectpicker('refresh');
	});
}

//Función para desactivar registros
function anular(idatencion) {
	bootbox.confirm("¿Está Seguro de anular la atención?", function (result) {
		if (result) {
			$.post("../ajax/atencion.php?op=anular", { idatencion: idatencion }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function buscarPaciente(documento) {
	$("#busqueda-paciente-modal").modal("hide");
	$.post("../ajax/persona.php?op=buscar", { documento: documento }, function (data, status) {
		$("#idpaciente").val('');
		$("#paciente").val('');

		if (data == null) {
			//mostrarform(true);
			$("#idpaciente").val('');
			$("#paciente").val('No existe el paciente');
		}
		else {
			data = JSON.parse(data);
			//mostrarform(true);
			$("#idpaciente").val(data.idpersona);
			$("#paciente").val(data.apaterno + ' ' + data.amaterno + ' ' + data.nombre);
			$("#documento").val(data.num_documento);
		}

	})
}

function abrirEnPestana(url) {
	$("<a>").attr("href", url).attr("target", "_blank")[0].click();
}

function buscarPacientesCriterio(e) {
	e.preventDefault();
	let criterio = '';
	let textoBusqueda = $("#texto-busqueda").val();
	if ($("#documentoBusqueda").is(':checked')) {
		criterio = $("#documentoBusqueda").val();
	} else if ($("#nombreBusqueda").is(':checked')) {
		criterio = $("#nombreBusqueda").val();
	} else if ($("#telefonoBusqueda").is(':checked')) {
		criterio = $("#telefonoBusqueda").val();
	} else if ($("#correoBusqueda").is(':checked')) {
		criterio = $("#correoBusqueda").val();
	}
	$('#table-resultado-busqueda').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla1
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdf'
			],
			"ajax":
			{
				url: '../ajax/atencion.php?op=buscarCriterio',
				type: "post",
				data: {
					criterio: criterio, textoBusqueda: textoBusqueda
				},
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 5
		}).DataTable();
}


//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto = 18;
var cont = 0;
var contr = 1;
var detalles = 0;
var valor = 0;
$("#btnGuardarP").hide();

//Función para guardar o editar
function editarplan(e) {
	e.preventDefault();
	let ida = $("#idatencionEdicion").val();
	let idr = $("#idresultadoEdicion").val();
	let formData = agregarDatoForm(ida, idr);
	$.ajax({
		url: "../ajax/resultado.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			bootbox.alert(datos);
			mostrarform(false);
			tabla.ajax.reload();
			recargarPagina();
			window.open("../reportes/historia.php?idatencion=" + ida, '_blank');
			window.open("../reportes/receta.php?idatencion=" + ida, '_blank');
		}

	});
	limpiarPlan();
}

function agregarDatoForm(ida, idr) {
	let formData = new FormData($("#formularioActualizacion")[0]);
	formData.append('tipoConsulta', $("#atencionRealizada").val());
	formData.append('idatencion', ida);
	formData.append('idresultado', idr);
	formData.append('presion_arterial', $("#presion_arterialAtencion").val());
	formData.append('temperatura', $("#temperaturaAtencion").val());
	formData.append('frecuencia_respiratoria', $("#frecuencia_respiratoriaAtencion").val());
	formData.append('frecuencia_cardiaca', $("#frecuencia_cardiacaAtencion").val());
	formData.append('saturacion', $("#saturacionAtencion").val());
	formData.append('pesoT', $("#pesoTAtencion").val());
	formData.append('tallaT', $("#tallaTAtencion").val());
	formData.append('imcT', $("#imcTAtencion").val());
	return formData;
}

//Función limpiarPlan
function limpiarPlan() {
	$("#idatencion").val("");
	$("#tiempo_enfermedad").val("");
	$("#antecedentes").val("");
	$("#examen_fisico").val("");
	$("#tratamiento").val("");
	$("#receta").val("");
	$("#proxima_cita").val("");
	$("#motivo_consulta").val("");
	$("#plan").val("");
	$("#texto").val("");
	$("#diagnosticos").html("");
	//$("#estado").val("");
	$(".filas").remove();
	$(".filasr").remove();
	cont = 0;
	contr = 1;
	detalles = 0;
	valor = 0;
	$("#btnGuardarP").hide();

	//Agregamos la receta inicial
	var fila = '<tr class="filasr" id="filar0">' +
		'<td><button type="button" class="btn btn-sm btn-danger" onclick="eliminarReceta(' + contr + ')"><i class="fa fa-trash"></i></button></td>' +
		'<td><input type="text" class="control" name="medicamento[]" required=""></td>' +
		'<td><input type="text" class="control" name="presentacion[]"></td>' +
		'<td><input type="text" class="control" name="dosis[]"></td>' +
		'<td><input type="text" class="control" name="duracion[]"></td>' +
		'<td><input type="text" class="control" name="cantidad[]"></td>' +
		'</tr>';
	$('#recetas').append(fila);
}

function modificar(idatencion) {

	$("#formularioregistrosEdicion").show();
	$("#listadoregistros").hide();
	$("#formularioregistros").hide();
	$("#btnagregar").hide();
	$("#idatencionEdicion").val(idatencion);

	$.post("../ajax/resultado.php?op=modificar", { idatencion: idatencion }, function (data, status) {
		data = JSON.parse(data);

		//PLAN DE ATENCION LLENADO START
		llenarPlanAtencionAEditar(data);
		mostrarTipoConsulta();
		//PLAN DE ATENCION LLENADO END

		//LLENADO ESTANDAR ALL
		llenarDatosClienteEnPestanas(data);
		//LLENADO ESTANDAR END

		//CONSULTA GENERAL LLENADO START
		llenarDatosClientesConsultaGeneral(data);
		//CONSULTA GENERAL LLENADO END

		//OBSTETRICA LLENADO START
		llenarObstetricaAEditar(data.idpersona);
		//OBSTETRICA LLENADO END

		//CONTROL PRENATAL LLENADO START
		llenarControlPrenatalAEditar(idatencion);
		//CONTROL PRENATAL LLENADO END

		//GINECOLOGIA LLENADO START
		llenarGinecologiaAEditar(idatencion);
		//GINECOLOGIA LLENADO END

		//LLENADO DE RECETA START
		$.post("../ajax/resultado.php?op=detalles&idresultado=" + data.idresultado, function (r) {
			$("#detalles > tbody").html(r);
			$("#btnGuardarP").show();
		});

		$.post("../ajax/resultado.php?op=recetas&idatencion=" + idatencion, function (r) {
			$("#recetas > tbody").html(r);
			//Agregamos la receta inicial
			/*var fila = '<tr class="filasr" id="filar0">' +
				'<td><button type="button" class="btn btn-sm btn-danger" onclick="eliminarReceta(0)"><i class="fa fa-trash"></i></button></td>' +
				'<td><input type="text" class="form-control" name="medicamento[]" ></td>' +
				'<td><input type="text" class="form-control" name="presentacion[]"></td>' +
				'<td><input type="text" class="form-control" name="dosis[]"></td>' +
				'<td><input type="text" class="form-control" name="duracion[]"></td>' +
				'<td><input type="text" class="form-control" name="cantidad[]"></td>' +
				'</tr>';
			$('#recetas').append(fila);*/
		});
		//LLENADO DE RECETA END

	});
}

function llenarPlanAtencionAEditar(data) {
	$("#atencionRealizada").val(data.servicio);
	$("#pacienteAtencion").val(data.paciente);
	$("#dniAtencion").val(data.num_documento);
	$("#edadAtencion").val(data.edad);
	$("#especialistaAtencion").val(data.especialista);
	$("#servicioAtencion").val(data.servicio);
	$("#presion_arterialAtencion").val(data.presion_arterial);
	$("#temperaturaAtencion").val(data.temperatura);
	$("#frecuencia_respiratoriaAtencion").val(data.frecuencia_respiratoria);
	$("#frecuencia_cardiacaAtencion").val(data.frecuencia_cardiaca);
	$("#saturacionAtencion").val(data.saturacion);
	$("#pesoTAtencion").val(data.peso);
	$("#tallaTAtencion").val(data.talla);
	$("#imcTAtencion").val(data.imc);
	calcularIMC();
}

function llenarDatosClienteEnPestanas(data) {
	$("#nombrePacienteG").val(data.paciente);
	$("#nacimientoPacienteG").val(data.fecha_nacimiento);
	$("#edadPacienteFG").val(data.edad);
	$("#escolaridadPacienteG").val(data.profesion);
	$("#estadoCPacienteG").val(data.estado_civil);

	$("#nombrePacienteO").val(data.paciente);
	$("#nacimientoPacienteO").val(data.fecha_nacimiento);
	$("#edadPacienteO").val(data.edad);
	$("#escolaridadPacienteO").val(data.profesion);

	$("#estadoCPacienteO").val(data.estado_civil);
	$("#nombrePacienteC").val(data.paciente);
	$("#nacimientoPacienteC").val(data.fecha_nacimiento);
	$("#edadPacienteC").val(data.edad);
	$("#escolaridadPacienteC").val(data.profesion);
	$("#estadoCPacienteC").val(data.estado_civil);
}

function llenarDatosClientesConsultaGeneral(data) {

	$("#motivo_consulta").val(data.motivo_consulta);
	$("#antecedentes").val(data.antecedentes);
	$("#tiempo_enfermedad").val(data.tiempo_enfermedad);
	$("#tel_ref").val(data.telefono_referencia);
	$("#nombre_ref").val(data.nombre_referencia);
	$("#vacunas_completas").val(data.vacunas_completas);
	$("#fecha_in_mal").val(data.fecha_inicio_malestar);
	$("#p_enfermedades").val(data.padece_enferedades);
	$("#alergia").val(data.alergia);
	$("#toma_medicamento").val(data.toma_medicamentos);
	$("#intervenciones_quirurgicas").val(data.intervenciones_quirurgicas);
	$("#plan").val(data.plan);
	$("#proxima_cita").val(data.proxima_cita);
	$("#examen_fisico").val(data.examen_fisico);

	$("#idpersona").val(data.idpersona);
	$("#idresultadoEdicion").val(data.idresultado);

}

function llenarObstetricaAEditar(idpersona) {
	$.post("../ajax/obstetrica.php?op=mostrarConsultaRealizada", { idpersona: idpersona }, function (data, status) {
		data = JSON.parse(data);
		console.log(data);
		if (data != null) {
			$("#idobstetricaPacienteGnrl").val(data.id_obstetrica);
			$("#paridadPaciente").val(data.paridad);
			$("#furPaciente").val(data.fecha_ult_regla);
			$("#fppPaciente").val(data.fecha_prb_parto);
			$("#amenorreoPaciente").val(data.edad_rgl_primera);
			$("#eGestionalPaciente").val(data.edad_gestorial);
			$("#tipeoPaciente").val(data.tipeo);
			$("#eghPaciente").val(data.exam_gnrl_heces);
			$("#vdrlPaciente").val(data.cifilis);
			$("#vhiPaciente").val(data.vhi);
			$("#papPaciente").val(data.papanicolao);
			$("#seguroPaciente").val(data.seguro);
			$("#hto1Paciente").val(data.hematocrito_v1);
			$("#hto2Paciente").val(data.hematocrito_v2);
			$("#hb1Paciente").val(data.hemoglobina_v1);
			$("#hb2Paciente").val(data.hemoglobina_v2);
			$("#glisema1Paciente").val(data.glucosa_v1);
			$("#glisema2Paciente").val(data.glucosa_v2);
			$("#ego1Paciente").val(data.exam_gnrl_orina);
			$("#ego2Paciente").val(data.exam_gnrl_orina2);
			$("#antecedentesPacienteObs").val(data.antecedentes);
			$("#alergiasObs").val(data.padece_alergia);
			$("#vacunaPaciente").val(data.vacunas);
			$("#otrosPaciente").val(data.otros);
		}
	});
}

function llenarControlPrenatalAEditar(idatencion) {
	$('#table-control-prenatal').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla1
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdf'
			],
			"ajax":
			{
				url: '../ajax/controlPrenatal.php?op=obtenerControlPrenatalEditar',
				data: { "idatencion": idatencion },
				type: "post",
				dataType: "json",
				error: function (e) {
					console.log(e);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 5
		}).DataTable();
}

function llenarGinecologiaAEditar(idatencion) {
	$.post("../ajax/ginecologia.php?op=mostrarDatosGinecologia", { idatencion: idatencion }, function (data, status) {
		data = JSON.parse(data);
		if (data != null) {
			$("#idginecologia").val(data.id_ginecologia);
			$("#paridadPacienteG").val(data.paridad);
			$("#furPacienteG").val(data.fecha_ult_regla);
			$("#fupPacienteG").val(data.fecha_ult_parto);
			$("#climaterioPacienteG").val(data.climaterio);
			$("#menarquiaPacienteG").val(data.menarquia);
			$("#menopausiaPacienteG").val(data.menopausia);
			$("#mpfPacienteG").val(data.metd_planf_familiar);
			$("#cmrPacienteG").val(data.ciclos_mestrl_regulares);
			$("#ultpapPacienteG").val(data.ultm_citologia);
			$("#alerPacienteG").val(data.alergias);
			$("#medicosPacienteG").val(data.antecedentes_medic);
			$("#quirurgicosPacienteG").val(data.antecedentes_quirurgico);
			$("#ultraPacienteG").val(data.ultrasonografia);
			$("#mamografiasPacienteG").val(data.mamografia);
			$("#cxPacienteG").val(data.consultar_por);
			$("#pePacienteG").val(data.presenta_enfemedade);
			$("#examen_fisicoGINE").val(data.examen_fisico);
			$("#indiagPacienteG").val(data.imp_diagnost);
			$("#trataPacienteG").val(data.tratamiento);
			$("#pCitaPacienteG").val(data.proxima_cita);
		}
	});
}

function buscarDiagnostico() {
	var texto = $("#texto").val();
	$.post("../ajax/resultado.php?op=diagnosticos&texto=" + texto, function (r) {
		$("#diagnosticos").html(r);
	});
}

function agregar(iddiagnostico, enfermedad) {
	if (iddiagnostico != "") {
		var fila = '<tr class="filas" id="fila' + cont + '">' +
			'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')"><i class="fa fa-trash"></i></button></td>' +
			'<td><select class="form-control" name="tipo[]"><option value="P">Primaria</option><option value="S">Subsecuente</option></select></td>' +
			'<td><input type="hidden" name="iddiagnostico[]" value="' + iddiagnostico + '">' + enfermedad + '</td>' +
			'</tr>';
		cont++;
		detalles = detalles + 1;
		$('#detalles').append(fila);
	}
	else {
		alert("Error al aplicar el diagnóstico, revise los datos.");
	}
	evaluar();
}

function agregarReceta() {
	var fila = '<tr class="filasr" id="filar' + contr + '">' +
		'<td><button type="button" class="btn btn-sm btn-danger" onclick="eliminarReceta(' + contr + ')"><i class="fa fa-trash"></i></button></td>' +
		'<td><input type="text" class="form-control" name="medicamento[]" required=""></td>' +
		'<td><input type="text" class="form-control" name="presentacion[]"></td>' +
		'<td><input type="text" class="form-control" name="dosis[]"></td>' +
		'<td><input type="text" class="form-control" name="duracion[]"></td>' +
		'<td><input type="text" class="form-control" name="cantidad[]"></td>' +
		'</tr>';
	contr++;
	$('#recetas').append(fila);
}

function evaluar() {
	if (detalles > 0) {
		$("#btnGuardarP").show();
	}
	else {
		$("#btnGuardarP").show();
		cont = 0;
	}
}

function eliminarDetalle(indice) {
	$("#fila" + indice).remove();
	detalles = detalles - 1;
	evaluar();
}

function eliminarReceta(indice) {
	$("#filar" + indice).remove();
}

function mostrarObstetrica() {
	$("#plan-obs").click(() => {
		//DESACTIVAR LOS OTROS TABS
		$("#plan-atencion").removeClass('active');
		$("#plan-general").removeClass('active');
		$("#plan-control").removeClass('active');
		$("#plan-gine").removeClass('active');
		$("#plan-receta").removeClass('active');
		$("#plan-obs").removeClass('active');
		//ACTIVAR TABS
		$("#plan-obs").addClass('active');
		//OCULTAR PANELES NO SELECCIONADOS EN EL TAB
		$("#atencion-content").addClass('d-none');
		$("#general-content").addClass('d-none');
		$("#control-content").addClass('d-none');
		$("#ginecologia-content").addClass('d-none');
		$("#receta-content").addClass('d-none');
		//MOSTRAR DIV SELECCIONADO EN EL TAB
		$("#obstetrica-content").removeClass('d-none');
	});
}

function mostrarControlPrenatal() {
	$("#plan-control").click(() => {
		//DESACTIVAR LOS OTROS TABS
		$("#plan-atencion").removeClass('active');
		$("#plan-general").removeClass('active');
		$("#plan-obs").removeClass('active');
		$("#plan-gine").removeClass('active');
		$("#plan-receta").removeClass('active');
		$("#plan-control").removeClass('active');
		//ACTIVAR TABS
		$("#plan-control").addClass('active');
		//OCULTAR PANELES NO SELECCIONADOS EN EL TAB
		$("#atencion-content").addClass('d-none');
		$("#general-content").addClass('d-none');
		$("#obstetrica-content").addClass('d-none');
		$("#ginecologia-content").addClass('d-none');
		$("#receta-content").addClass('d-none');
		//MOSTRAR DIV SELECCIONADO EN EL TAB
		$("#control-content").removeClass('d-none');
	});
}

function mostrartGinecologia() {
	$("#plan-gine").click(() => {
		//DESACTIVAR LOS OTROS TABS
		$("#plan-atencion").removeClass('active');
		$("#plan-general").removeClass('active');
		$("#plan-obs").removeClass('active');
		$("#plan-control").removeClass('active');
		$("#plan-receta").removeClass('active');
		$("#plan-gine").removeClass('active');
		//ACTIVAR TABS
		$("#plan-gine").addClass('active');
		//OCULTAR PANELES NO SELECCIONADOS EN EL TAB
		$("#atencion-content").addClass('d-none');
		$("#general-content").addClass('d-none');
		$("#obstetrica-content").addClass('d-none');
		$("#control-content").addClass('d-none');
		$("#receta-content").addClass('d-none');
		//MOSTRAR DIV SELECCIONADO EN EL TAB
		$("#ginecologia-content").removeClass('d-none');
	});
}

function mostrarReceta() {
	$("#plan-receta").click(() => {
		//DESACTIVAR LOS OTROS TABS
		$("#plan-atencion").removeClass('active');
		$("#plan-general").removeClass('active');
		$("#plan-obs").removeClass('active');
		$("#plan-control").removeClass('active');
		$("#plan-gine").removeClass('active');
		$("#plan-receta").removeClass('active');
		//ACTIVAR TABS
		$("#plan-receta").addClass('active');
		//OCULTAR PANELES NO SELECCIONADOS EN EL TAB
		$("#atencion-content").addClass('d-none');
		$("#general-content").addClass('d-none');
		$("#obstetrica-content").addClass('d-none');
		$("#control-content").addClass('d-none');
		$("#ginecologia-content").addClass('d-none');
		//MOSTRAR DIV SELECCIONADO EN EL TAB
		$("#receta-content").removeClass('d-none');
	});
}

function mostrarGeneral() {
	$("#plan-general").click(() => {
		//DESACTIVAR LOS OTROS TABS
		$("#plan-atencion").removeClass('active');
		$("#plan-general").removeClass('active');
		$("#plan-obs").removeClass('active');
		$("#plan-control").removeClass('active');
		$("#plan-gine").removeClass('active');
		$("#plan-receta").removeClass('active');
		//ACTIVAR TABS
		$("#plan-general").addClass('active');
		//OCULTAR PANELES NO SELECCIONADOS EN EL TAB
		$("#atencion-content").addClass('d-none');
		$("#general-content").addClass('d-none');
		$("#obstetrica-content").addClass('d-none');
		$("#control-content").addClass('d-none');
		$("#ginecologia-content").addClass('d-none');
		$("#receta-content").addClass('d-none');
		//MOSTRAR DIV SELECCIONADO EN EL TAB
		$("#general-content").removeClass('d-none');
	});
}

function mostrarTipoTabs() {
	$("#plan-atencion").click(() => {
		//DESACTIVAR LOS OTROS TABS
		$("#plan-general").removeClass('active');
		$("#plan-obs").removeClass('active');
		$("#plan-control").removeClass('active');
		$("#plan-gine").removeClass('active');
		$("#plan-receta").removeClass('active');
		$("#plan-general").removeClass('active');
		//ACTIVAR TABS
		$("#plan-atencion").addClass('active');
		//OCULTAR PANELES NO SELECCIONADOS EN EL TAB
		$("#general-content").addClass('d-none');
		$("#obstetrica-content").addClass('d-none');
		$("#control-content").addClass('d-none');
		$("#ginecologia-content").addClass('d-none');
		$("#receta-content").addClass('d-none');
		//MOSTRAR DIV SELECCIONADO EN EL TAB
		$("#atencion-content").removeClass('d-none');
	});
}

function mostrarPlanAtencion() {
	$("#plan-atencion").click(() => {
		//DESACTIVAR LOS OTROS TABS
		$("#plan-general").removeClass('active');
		$("#plan-obs").removeClass('active');
		$("#plan-control").removeClass('active');
		$("#plan-gine").removeClass('active');
		$("#plan-receta").removeClass('active');
		$("#plan-general").removeClass('active');
		//ACTIVAR TABS
		$("#plan-atencion").addClass('active');
		//OCULTAR PANELES NO SELECCIONADOS EN EL TAB
		$("#general-content").addClass('d-none');
		$("#obstetrica-content").addClass('d-none');
		$("#control-content").addClass('d-none');
		$("#ginecologia-content").addClass('d-none');
		$("#receta-content").addClass('d-none');
		//MOSTRAR DIV SELECCIONADO EN EL TAB
		$("#atencion-content").removeClass('d-none');
	});
}

function mostrarTipoConsulta() {
	$("#plan-general").css("background-color", "#D8D8D8");
	$("#plan-obs").css("background-color", "#D8D8D8");
	$("#plan-control").css("background-color", "#D8D8D8");
	$("#plan-gine").css("background-color", "#D8D8D8");
	$("#plan-receta").css("background-color", "#D8D8D8");

	$("#plan-general").off('click');
	$("#plan-obs").off('click');
	$("#plan-control").off('click');
	$("#plan-gine").off('click');
	$("#plan-receta").off('click');

	//$("#atencionRealizada").change(() => {
	let tipo = $("#atencionRealizada").val();
	mostrarPlanAtencion();
	switch (tipo) {
		case 'none':
			$("#plan-obs").css("background-color", "#D8D8D8");
			$("#plan-control").css("background-color", "#D8D8D8");
			$("#plan-gine").css("background-color", "#D8D8D8");
			$("#plan-receta").css("background-color", "#D8D8D8");
			$("#plan-general").css("background-color", "#D8D8D8");

			$("#plan-general").off('click');
			$("#plan-obs").off('click');
			$("#plan-control").off('click');
			$("#plan-gine").off('click');
			$("#plan-receta").off('click');
			break;
		case 'Consulta médica general':
			//dasabilitado
			$("#plan-obs").css("background-color", "#D8D8D8");
			$("#plan-control").css("background-color", "#D8D8D8");
			$("#plan-obs").off('click');
			$("#plan-control").off('click');
			$("#plan-gine").css("background-color", "#D8D8D8");
			$("#plan-gine").off('click');

			//habilitado
			$("#plan-general").css("background-color", "");
			$("#plan-receta").css("background-color", "");
			$("#plan-general").on('click', mostrarGeneral());
			$("#plan-receta").on('click', mostrarReceta());
			break;
		case 'Consulta Obstetrica':
			//dasabilitado
			$("#plan-gine").css("background-color", "#D8D8D8");
			$("#plan-gine").off('click');
			$("#plan-general").css("background-color", "#D8D8D8");
			$("#plan-general").off('click');

			//habilitado
			$("#plan-obs").css("background-color", "");
			$("#plan-control").css("background-color", "");
			$("#plan-receta").css("background-color", "");

			$("#plan-obs").on('click', mostrarObstetrica());
			$("#plan-control").on('click', mostrarControlPrenatal());
			$("#plan-receta").on('click', mostrarReceta());
			break;
		case 'Consulta Control Prenatal':
			//dasabilitado
			$("#plan-gine").css("background-color", "#D8D8D8");
			$("#plan-gine").off('click');
			$("#plan-general").css("background-color", "#D8D8D8");
			$("#plan-general").off('click');

			//habilitado
			$("#plan-obs").css("background-color", "");
			$("#plan-control").css("background-color", "");
			$("#plan-receta").css("background-color", "");
			$("#plan-obs").on('click', mostrarObstetrica());
			$("#plan-control").on('click', mostrarControlPrenatal());
			$("#plan-receta").on('click', mostrarReceta());
			break;
		case 'Consulta Ginecologica':
			//desabilitado
			$("#plan-obs").css("background-color", "#D8D8D8");
			$("#plan-control").css("background-color", "#D8D8D8");
			$("#plan-obs").off('click');
			$("#plan-control").off('click');
			$("#plan-general").css("background-color", "#D8D8D8");
			$("#plan-general").off('click');

			//habilitado
			$("#plan-gine").css("background-color", "");
			$("#plan-receta").css("background-color", "");
			$("#plan-gine").on('click', mostrartGinecologia());
			$("#plan-receta").on('click', mostrarReceta());
			break;
		default:
			break;
	}
	//});
}

function calcularIMC() {
	var peso = $("#pesoTAtencion").val();
	var talla = $("#tallaTAtencion").val();

	//Validamos inicialmente

	if (peso != "" && talla != "") {

		//Mostramos el div de resultados
		$("#resultado").show();
		//Obtenemos los valores ingresados por el usuario

		//Calculamos el imc
		talla = talla / 100;
		var imc = peso / (talla * talla);

		var estado = "";

		if (imc < 18) {
			estado = "Peso Bajo";
		}
		else if (imc >= 18 && imc < 25) {
			estado = "Peso Normal";
		}
		else if (imc >= 25 && imc < 27) {
			estado = "Sobrepeso";
		}
		else if (imc >= 27 && imc < 30) {
			estado = "Obesidad grado I";
		}
		else if (imc >= 30 && imc < 40) {
			estado = "Obesidad grado II";
		}
		else {
			estado = "Obesidad grado III";
		}

		$("#imcTAtencion").val(imc.toFixed(2));

		$("#estadoTAtencion").val(estado);


		$("#estadoG").val(estado);
		$("#estadoO").val(estado);
		$("#pesoPacienteCP").val(peso);
		$("#pesoPacienteG").val(peso);
		$("#pesoPacienteO").val(peso);
		$("#tallaPaciente").val(talla);
		$("#tallaPacienteG").val(talla);
		$("#tallaPacienteO").val(talla);
		$("#imcPacienteG").val(imc.toFixed(2));
		$("#imcPacienteO").val(imc.toFixed(2));
		//Mostramos los resultados
	}
}

function mostrarControlPrenatalEditar(idControl) {
	$.post("../ajax/controlPrenatal.php?op=buscarControlPrenatal",
		{ idControl: idControl }, function (data, status) {
			data = JSON.parse(data);
			if (data != null) {
				$("#idcontrolModal").val(data.id_control);
				$("#fechaPacienteCP").val(data.fecha_control);
				$("#amenorreaPacienteCP").val(data.edad_rgl_primera);
				$("#pesoPacienteCP").val(data.peso);
				$("#auPacienteCP").val(data.altr_uterina);
				$("#taPacienteCP").val(data.prson_arterial);
				$("#pulsoPacienteCP").val(data.pulso);
				$("#fcfPacienteCP").val(data.frecu_cardiaca_fetal);
				$("#mPacienteCP").val(data.mov_fetal);
				$("#medicamentoPacienteCP").val(data.medicamento);
				$("#saPacienteCP").val(data.signos_alarmas);
				$("#ultraPacienteCP").val(data.ultrasonografia);
				$("#pcPacienteCP").val(data.proxima_cita);
				$("#contro_prenatal_modal").modal('show');
			}
		});
}

function actualizarControlPrenatal(e) {
	e.preventDefault();
	let formControlPrenatal = new FormData($("#modal-control-prenatal")[0]);
	formControlPrenatal.append('idControl', $("#idcontrolModal").val());
	$.ajax({
		url: "../ajax/controlPrenatal.php?op=guardaryeditardatos",
		type: "POST",
		data: formControlPrenatal,
		contentType: false,
		processData: false,
		success: function (datos) {
			bootbox.alert(datos);
			$("#contro_prenatal_modal").modal('hide');
			limpiarModalControlPrenatal();
			init();
		}
	});
}

function limpiarModalControlPrenatal() {
	$("#idcontrolModal").val("");
	$("#idobstetricaPacienteModal").val("");
	$("#idobstetricaPaciente").val("");
	$("#fechaPacienteCP").val("");
	$("#amenorreaPacienteCP").val("");
	$("#pesoPacienteCP").val("");
	$("#auPacienteCP").val("");
	$("#taPacienteCP").val("");
	$("#pulsoPacienteCP").val("");
	$("#fcfPacienteCP").val("");
	$("#mPacienteCP").val("");
	$("#medicamentoPacienteCP").val("");
	$("#saPacienteCP").val("");
	$("#ultraPacienteCP").val("");
	$("#pcPacienteCP").val("");
}

function recargarPagina() {
	setTimeout(() => {
		location.reload();
	}, 2000);
}

function sumarDiasFecha(fecha, dias) {
	fecha = new Date(Date.parse(fecha));
	fecha.setDate(fecha.getDate() + dias);
	return fecha;
}

function obtenerSemanasXDiasCalculados(fecha, fecha2 = null) {
	if (fecha != null || fecha != '' || fecha != undefined) {
		let fechaNow = moment((fecha2 == null) ? new Date() : fecha2);
		fecha = moment(new Date(Date.parse(fecha)));
		let dias = fechaNow.diff(fecha, 'days');
		let contador = 7;
		let contadorSemana = 1;
		let flag = true;
		while (flag) {
			if (dias > contador) {
				contadorSemana++;
				contador = contador + 7;
			} else {
				flag = false;
			}
		}
		return (contadorSemana < 2) ? (contadorSemana + ' Semana') : (contadorSemana + ' Semanas');
	}
	return null;
}

init();