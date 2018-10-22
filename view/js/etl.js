/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('ready', function () {

});


function etlproductos() {
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    $('#etlproductos').html('<div align="center"><img src="images/data.gif" width="150"/></i> <br> <h1>Minando Datos ...</h1></div>');
    $('#btn-productos').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
    var url = '../controler/etlControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=productos',
        success: function (datos) {
            $('#etlproductos').html(datos);
            $.unblockUI();
        },
        complete: function () {
            $('#btn-productos').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}

function etlclientes() {
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    $('#etlclientes').html('<div align="center"><img src="images/data.gif" width="150"/></i> <br> <h1>Minando Datos ...</h1></div>');
    $('#btn-clientes').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
    var url = '../controler/etlControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=clientes',
        success: function (datos) {
            $('#etlclientes').html(datos);
            $.unblockUI();
        },
        complete: function () {
            $('#btn-clientes').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}

function etlprovedores() {
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    $('#etlprovedores').html('<div align="center"><img src="images/data.gif" width="150"/></i> <br> <h1>Minando Datos ...</h1></div>');
    $('#btn-provedores').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
    var url = '../controler/etlControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=provedores',
        success: function (datos) {
            $('#etlprovedores').html(datos);
            $.unblockUI();
        },
        complete: function () {
            $('#btn-provedores').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}

function etlventas() {
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    $('#etlventas').html('<div align="center"><img src="images/data.gif" width="150"/></i> <br> <h1>Minando Datos ...</h1></div>');
    $('#btn-clientes').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
    var url = '../controler/etlControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=ventas',
        success: function (datos) {
            $('#etlventas').html(datos);
            $.unblockUI();
        },
        complete: function () {
            $('#btn-clientes').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}

function etltablas() {
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    $('#etltablas').html('<div align="center"><img src="images/data.gif" width="150"/></i> <br> <h1>Minando Datos ...</h1></div>');
    $('#btn-tablas').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
    var url = '../controler/etlControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=tablasdehechos',
        success: function (datos) {
            $('#etltablas').html(datos);
            $.unblockUI();
        },
        complete: function () {
            $('#btn-tablas').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}