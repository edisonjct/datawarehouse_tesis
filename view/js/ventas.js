$(document).ready(function () {
    $('#datepicker').datepicker({
        //format: "mm-dd-yyyy",
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        language: "es",
        autoclose: true
    });


    $('#btn-ventas').click(function () {
        var desde = $('#start').val();
        var hasta = $('#hasta').val();
        var tipo = $('input:radio[name=tipo]:checked').val();
        if (desde !== '' && hasta !== '') {
            $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
            if (tipo === '1') {
                swal({
                    title: "Esta seguro de procesar el cubo detallado?",
                    text: "Este proceso puede tardar seguin el rango de fechas",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Si, Estoy Seguro!',
                    cancelButtonText: "No, Cancelar!"
                }).then(function () {
                    $('#cubo-ventas').html('<div align="center"><img src="images/data.gif" width="150"/></i></div>');
                    var url = "../controler/ventasControler.php";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: $("#cubo").serialize(),
                        success: function (data) {
                            $('#cubo-ventas').html(data);
                            $.unblockUI();
                        }
                    });
                });
            } else {
                $('#cubo-ventas').html('<div align="center"><img src="images/data.gif" width="150"/></i></div>');
                var url = "../controler/ventasControler.php";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#cubo").serialize(),
                    success: function (data) {
                        $('#cubo-ventas').html(data);
                        $.unblockUI();
                    }
                });
            }

        } else {
            swal("¡Error!", "Seleccione Rango de Fechas", "error");
        }
    });

    $('#btn-vendedores').click(function () {
        var desde = $('#start').val();
        var hasta = $('#hasta').val();
        if (desde !== '' && hasta !== '') {
            $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
            $('#cubo-clientes').html('<div align="center"><img src="images/data.gif" width="150"/></i></div>');
            var url = "../controler/ventasControler.php";
            $.ajax({
                type: "POST",
                url: url,
                data: $("#cubo").serialize(),
                success: function (data) {
                    $('#cubo-vendedores').html(data);
                    $.unblockUI();
                }
            });
        } else {
            swal("¡Error!", "Seleccione Rango de Fechas", "error");
        }
    });

    $('#btn-clientes').click(function () {
        var desde = $('#start').val();
        var hasta = $('#hasta').val();
        if (desde !== '' && hasta !== '') {
            $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
            $('#cubo-clientes').html('<div align="center"><img src="images/data.gif" width="150"/></i></div>');
            var url = "../controler/ventasControler.php";
            $.ajax({
                type: "POST",
                url: url,
                data: $("#cubo").serialize(),
                success: function (data) {
                    $('#cubo-clientes').html(data);
                    $.unblockUI();
                }
            });
        } else {
            swal("¡Error!", "Seleccione Rango de Fechas", "error");
        }
    });

});