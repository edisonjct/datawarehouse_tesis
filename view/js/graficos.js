/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('ready', function () {
    cargar_venta_anaul();
    cargar_pais();
    cargar_categoria();
    cargar_vendedores();
    cargar_ventas_clientes();
});


function cargar_venta_anaul() {
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var anio = $('#anioventas').val();
    $('#anioventas').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
    //$('#ventastiendas').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    var url = '../controler/datagraficosControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=ventasanuales&anio=' + anio,
        success: function (datos) {
            $('#ventastiendas').html(datos);
            $.unblockUI();
        },
        complete: function () {
            $('#anioventas').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}

function cargar_pais() {
    //$('#ventaspaises').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/datagraficosControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=ventaspaises',
        success: function (datos) {
            $('#ventaspaises').html(datos);
            $.unblockUI();
        }
    });
    return false;
}

function cargar_categoria() {
    var anio = $('#aniocategoria').val();
    $('#aniocategoria').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
    //$('#ventascategoria').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/datagraficosControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=ventascategoria&anio=' + anio,
        success: function (datos) {
            $('#ventascategoria').html(datos);
            $.unblockUI();
        },
        complete: function () {
            $('#aniocategoria').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}

function cargar_vendedores() {
    var anio = $('#aniovendedor').val();
    $('#aniovendedor').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
    //$('#ventasvendedor').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/datagraficosControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=ventasvendedor&anio=' + anio,
        success: function (datos) {
            $('#ventasvendedor').html(datos);
            $.unblockUI();
        },
        complete: function () {
            $('#aniovendedor').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}

function cargar_ventas_clientes() {
    var anio = $('#anioclientes').val();
    $('#anioclientes').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
    //$('#ventasclientes').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/datagraficosControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=ventasclientes&anio=' + anio,
        success: function (datos) {
            $('#ventasclientes').html(datos);
            $.unblockUI();
        },
        complete: function () {
            $('#anioclientes').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}