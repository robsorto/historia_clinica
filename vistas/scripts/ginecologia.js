//Función Listar
function init() {
	listar()
}
$("#fechainicio").change(listar);
$("#fechafin").change(listar);

function listar() {
	fechainicio = $("#fechainicio").val();
	fechafin = $("#fechafin").val();
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
				url: '../ajax/consultas.php?op=listarGinecologia&fechainicio=' + fechainicio + '&fechafin=' + fechafin,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 5,
			"order": [[0, "desc"]]
		}).DataTable();
}

init();