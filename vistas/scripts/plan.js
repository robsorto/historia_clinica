var tabla;

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();
	mostrarTipoTabs();
	mostrarTipoConsulta();
	listarConsultasPlanAtencion();
	$("#pesoT").change(calcularIMC);
	$("#tallaT").change(calcularIMC);

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$("#modal-control-prenatal").on("submit", (e) => {
		guardaryeditarDatosControlPrenatal(e);
	});

	$("#btn-activar-modal").click(() => {
		$("#contro_prenatal_modal").modal('show');
	});
	$("#btn-desactivar-control").click((e) => {
		desactivarControlPrenatal(e);
	});

	$("#furPaciente").change(() => {
		let fecha = sumarDiasFecha($("#furPaciente").val(), 281).toISOString().slice(0, 10);
		let semanas = obtenerSemanasXDiasCalculados($("#furPaciente").val());
		$("#fppPaciente").val(fecha);
		$("#amenorreoPaciente").val(semanas);
		$("#amenorreaPacienteCP").val(obtenerSemanasXDiasCalculados($("#furPaciente").val(), $("#fechaPacienteCP").val()));
	});

	$("#fechaPacienteCP").change(() => {
		let semanas = obtenerSemanasXDiasCalculados($("#furPaciente").val(), $("#fechaPacienteCP").val());
		$("#amenorreaPacienteCP").val(semanas);
	});
}

function limpiarModalControlPrenatal() {
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

//Función limpiar
function limpiar() {
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
	$("#btnGuardar").hide();

	//Agregamos la receta inicial
	var fila = '<tr class="filasr" id="filar0">' +
		'<td><button type="button" class="btn btn-sm btn-danger" onclick="eliminarReceta(' + contr + ')"><i class="fa fa-trash"></i></button></td>' +
		'<td><input type="text" class="form-control" name="medicamento[]" required=""></td>' +
		'<td><input type="text" class="form-control" name="presentacion[]"></td>' +
		'<td><input type="text" class="form-control" name="dosis[]"></td>' +
		'<td><input type="text" class="form-control" name="duracion[]"></td>' +
		'<td><input type="text" class="form-control" name="cantidad[]"></td>' +
		'</tr>';
	$('#recetas').append(fila);
}

//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
	}
	else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
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
				url: '../ajax/resultado.php?op=listar',
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
function guardaryeditar(e = null) {
	let idatencion = $("#idatencion").val();
	e.preventDefault();
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

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
			listar();
			init();
			window.open("../reportes/receta.php?idatencion=" + idatencion, '_blank');
			//window.open("../reportes/historia.php?idatencion=" + idatencion, '_blank');
			init();
			recargarPagina();
		}

	});
	limpiar();
}

function mostrar(idatencion) {
	$.post("../ajax/resultado.php?op=mostrar", { idatencion: idatencion }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		$("#edad").val(data.edad);
		$("#dni").val(data.num_documento);
		$("#paciente").val(data.paciente);
		$("#especialista").val(data.especialista);
		$("#servicio").val(data.servicio);
		$("#idatencion").val(data.idatencion);

		$("#presion_arterial").val(data.presion_arterial);
		$("#temperatura").val(data.temperatura);
		$("#frecuencia_respiratoria").val(data.frecuencia_respiratoria);
		$("#frecuencia_cardiaca").val(data.frecuencia_cardiaca);

		$("#saturacion").val(data.saturacion);
		$("#peso").val(data.peso);
		$("#talla").val(data.talla);
		var imc2 = Number(data.imc);
		$("#imc").val(imc2.toFixed(2));

		$("#idpersona").val(data.idpersona);
		$("#alergia").val(data.alergia);
		$("#intervenciones_quirurgicas").val(data.intervenciones_quirurgicas);
		$("#vacunas_completas").val(data.vacunas_completas);

		//MOSTRAR DATOS PERSONALES DE LA PERSONA
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

		$("#nombrePacienteGine").val(data.paciente);
		$("#nacimientoPacienteGine").val(data.fecha_nacimiento);
		$("#edadPacienteGine").val(data.edad);
		$("#escolaridadPacienteGine").val(data.profesion);
		$("#estadoCPacienteGine").val(data.estado_civil);

		mostrarObstetricaDatos(data.idpersona);

		//llenar campos en obstetrica, control prenatal y ginecologia
		if (data.peso != null) {
			$("#pesoPacienteCP").val(data.peso);
			$("#pesoPacienteG").val(data.peso);
			$("#pesoPacienteO").val(data.peso);
			$("#pesoT").val(data.peso);
		}
		if (data.talla != null) {
			$("#tallaPaciente").val(data.talla);
			$("#tallaPacienteG").val(data.talla);
			$("#tallaPacienteO").val(data.talla);
			$("#tallaT").val(data.talla);
		}

		$("#imcT").val($("#imc").val());
		calcularIMC();
		$("#imcPacienteG").val($("#imcT").val());
		$("#imcPacienteO").val($("#imcT").val());

	});

}

function buscarDiagnostico() {
	var texto = $("#texto").val();
	$.post("../ajax/resultado.php?op=diagnosticos&texto=" + texto, function (r) {
		$("#diagnosticos").html(r);
	});
}
//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto = 18;
var cont = 0;
var contr = 1;
var detalles = 0;
$("#btnGuardar").hide();


function agregar(iddiagnostico, enfermedad) {
	if (iddiagnostico != "") {
		var fila = '<tr class="filas" id="fila' + cont + '">' +
			'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')"><i class="fa fa-trash"></i></button></td>' +
			'<td><select name="tipo[]" class="form-control"><option value="P">Primera</option><option value="S">Subsecuente</option></td>' +
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
		$("#btnGuardar").show();
	}
	else {
		$("#btnGuardar").hide();
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

	$("#tipoConsulta").change(() => {
		let tipo = $("#tipoConsulta").val();
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
	});
}

function mostrarObstetricaDatos(persona) {
	$.post("../ajax/obstetrica.php?op=mostrar", { idpersona: persona }, (data, status) => {
		data = JSON.parse(data);
		if (data != null) {
			$("#paridadPaciente").val(data.paridad);
			$("#furPaciente").val(data.fecha_ult_regla);
			$("#fppPaciente").val(data.fecha_prb_parto);
			$("#amenorreoPaciente").val(data.edad_rgl_primera);
			$("#eGestionalPaciente").val(data.edad_gestorial);
			$("#tallaPaciente").val(data.talla);
			$("#imcPaciente").val(data.indc_m_corporal);
			$("#tipeoPaciente").val(data.tipeo);
			$("#eghPaciente").val(data.exam_gnrl_heces);
			$("#vdrlPaciente").val(data.cifilis);
			$("#vhiPaciente").val(data.vhi);
			$("#papPaciente").val(data.papanicolao);
			$("#hto1Paciente").val(data.hematocrito_v1);
			$("#hto2Paciente").val(data.hematocrito_v2);
			$("#hb1Paciente").val(data.hemoglobina_v1);
			$("#hb2Paciente").val(data.hemoglobina_v2);
			$("#glisema1Paciente").val(data.glucosa_v1);
			$("#glisema2Paciente").val(data.glucosa_v2);
			$("#ego1Paciente").val(data.exam_gnrl_orina);
			$("#ego2Paciente").val(data.exam_gnrl_orina2);
			$("#antecedentesPacienteObs").val(data.antecedentes);
			$("#vacunaPaciente").val(data.vacunas);
			$("#otrosPaciente").val(data.otros);
			$("#seguroPaciente").val(data.seguro);
			$("#idobstetricaPacienteModal").val(data.id_obstetrica);
			$("#validaDatosObstetrica").val("A");
			$("#idobstetricaPacienteGnrl").val(data.id_obstetrica);
			$("#alergiasObs").val(data.padece_alergia);
			$("#examen_fisicoOBS").val(data.examen_fisico);
			mostrarControlPrenatalDatos(data.id_obstetrica);

		} else {
			$("#validaDatosObstetrica").val("G");
			$("#btn-desactivar-control").attr('disabled', 'true');
		}

		//calculo de amenorre de control prenatal
		let semanas = obtenerSemanasXDiasCalculados($("#furPaciente").val(), $("#fechaPacienteCP").val());
		$("#amenorreaPacienteCP").val(semanas);
	});
}

function mostrarControlPrenatalDatos(idobstetrica) {
	$.ajax({
		url: '../ajax/controlPrenatal.php?op=verificarListado',
		data: { "idobstetricaPacienteModal": idobstetrica },
		type: "post",
		dataType: "json",
		contentType: false,
		processData: false,
		success: function (datos) {
			dato = JSON.parse(datos);
			if (dato.resultado != "0") {
				$("#btn-desactivar-control").attr('disabled', 'true');
			} else {
				$("#btn-desactivar-control").removeAttr('disabled');
			}
		}
	});

	tabla = $('#table-control-prenatal').dataTable(
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
				url: '../ajax/controlPrenatal.php?op=listar',
				data: { "idobstetricaPacienteModal": idobstetrica },
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

function guardaryeditarDatosControlPrenatal(e) {
	e.preventDefault();
	let formDataObstetrica = new FormData($("#formulario")[0]);
	let formData = new FormData($("#modal-control-prenatal")[0]);
	formDataObstetrica.append('tipoGestion', $("#validaDatosObstetrica").val());
	formData.append('idatencion', $("#idatencion").val());
	$.ajax({
		url: "../ajax/obstetrica.php?op=guardaryeditardatos",
		type: "POST",
		data: formDataObstetrica,
		contentType: false,
		processData: false,
		success: function (datos) {
			if ($("#validaDatosObstetrica").val() == 'G') {
				let d = JSON.parse(datos);
				formData.append('idObstetrica_G', d.idObstetrica);
			}
			$.ajax({
				url: "../ajax/controlPrenatal.php?op=guardaryeditardatos",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function (datos) {
					bootbox.alert(datos);
					$("#contro_prenatal_modal").modal('hide');
					mostrarControlPrenatalDatos($("#idobstetricaPacienteModal").val());
					limpiarModalControlPrenatal();
					init();
					recargarPagina();
				}
			});

		}
	});
}

function listarConsultasPlanAtencion() {
	$.post("../ajax/servicio.php?op=listarPlan", (data, status) => {
		data = JSON.parse(data);
		$("#tipoConsulta").append(`<option  value="none">--Seleccione una opción--</option>`);
		data.forEach(ele => {
			$("#tipoConsulta").append(`<option  value="${ele.nombre}">${ele.idservicio} - ${ele.nombre}</option>`);
		});
	});
}

function desactivarControlPrenatal(e) {
	e.preventDefault();
	$.post("../ajax/obstetrica.php?op=finalizarControl",
		{
			"idobstetricaPacienteGnrl": $("#idobstetricaPacienteGnrl").val(),
			"idpersona": $("#idpersona").val()
		}, (datos, status) => {
			let data = JSON.parse(datos);
			if (data.cod == 1) {
				guardaryeditar(e);
				bootbox.alert(data.mensaje);
			} else {
				bootbox.alert(data.mensaje);
			}

		}
	);
}

function sumarDiasFecha(fecha, dias) {
	fecha = new Date(Date.parse(fecha));
	fecha.setDate(fecha.getDate() + dias);
	return fecha;
}

function recargarPagina() {
	setTimeout(() => {
		location.reload();
	}, 3000);
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

function calcularIMC() {
	var peso = $("#pesoT").val();
	var talla = $("#tallaT").val();

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

		$("#imcT").val(imc.toFixed(2));
		$("#estadoT").val(estado);
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
	else {
		//$("#resultado").hide();
	}
}

init();
