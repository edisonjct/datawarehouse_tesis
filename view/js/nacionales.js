$(document).ready(function () {
    $('#datepicker').datepicker({
        //format: "mm-dd-yyyy",
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        language: "es",
        autoclose: true
    });


    $('#btn-nacionales').click(function () {
        $('#cubo-ventas-nacional').html('<div align="center"><img src="images/data.gif" width="150"/></i></div>');
        var desde = $('#start').val();
        var hasta = $('#hasta').val();
        var tipo = $('#tipo').val();
//        alert(fecha);
//        var fecha = $('#fecha').text();
        var url = "../controler/ventasControler.php";
        $.ajax({
            type: "POST",
            url: url,
            //data: 'proceso=nacionales&desde=' + desde + '&hasta=' + hasta + '&tipo=' + tipo,
            data: $("#cubo-nacionales").serialize(),
            success: function (data) {
                $('#cubo-ventas-nacional').html(data);
            }
        });
    });

});