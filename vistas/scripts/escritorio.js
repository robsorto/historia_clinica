function init(){
	$.post("../ajax/escritorio.php?op=listarTriaje",function(r){
	        $("#triaje").html(r);
	});

	$.post("../ajax/escritorio.php?op=listarPlan",function(r){
	        $("#plan").html(r);
	});
}


init();