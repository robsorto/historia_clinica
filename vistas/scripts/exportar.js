function init() {
    $("#descargar-documento").click((e) => {
        exportar(e);
    })
}

function exportar(e) {
    e.preventDefault();
    $.ajax({
        async: true,
        type: "POST",
        dataType: "html",//html
        contentType: "application/x-www-form-urlencoded",//application/x-www-form-urlencoded
        url: "../ajax/exportar.php?op=exportarTodo",
        data: null,
        beforeSend: function () { },
        success: function (data) {
            var opResult = JSON.parse(data);
            var $a = $("<a>");
            $a.attr("href", opResult.data);
            //$a.html("LNK");
            $("body").append($a);
            $a.attr("download", "Historico.xlsx");
            $a[0].click();
            $a.remove();
        }
    });
}

init();