var tabla;

$("#peso").change(calcularIMC);
$("#talla").change(calcularIMC);

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	})
}


//Función limpiar
function limpiar() {
	$("#idatencion").val("");
	$("#presion_arterial").val("");
	$("#temperatura").val("");
	$("#frecuencia_respiratoria").val("");
	$("#frecuencia_cardiaca").val("");
	$("#saturacion").val("");
	$("#peso").val("");
	$("#talla").val("");
	$("#imc").val("");
	$("#estado").val("");
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
				url: '../ajax/triaje.php?op=listar',
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
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/triaje.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			bootbox.alert(datos);
			mostrarform(false);
			tabla.ajax.reload();
		}

	});
	limpiar();
}

function mostrar(idatencion) {
	$.post("../ajax/triaje.php?op=mostrar", { idatencion: idatencion }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);

		$("#edad").val(data.edad);
		$("#dni").val(data.num_documento);
		$("#paciente").val(data.paciente);
		$("#especialista").val(data.especialista);
		$("#servicio").val(data.servicio);
		$("#idatencion").val(data.idatencion);

	})
}

//Función para desactivar registros
function desactivar(idtriaje) {
	bootbox.confirm("¿Está Seguro de desactivar el Espera?", function (result) {
		if (result) {
			$.post("../ajax/triaje.php?op=desactivar", { idtriaje: idtriaje }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Función para activar registros
function activar(idtriaje) {
	bootbox.confirm("¿Está Seguro de activar el Espera?", function (result) {
		if (result) {
			$.post("../ajax/triaje.php?op=activar", { idtriaje: idtriaje }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
function calcularIMC() {
	var peso = $("#peso").val();
	var talla = $("#talla").val();

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


		$("#imc").val(imc.toFixed(2));
		$("#estado").val(estado);
		//Mostramos los resultados
	}
	else {
		//$("#resultado").hide();
	}
}

init();