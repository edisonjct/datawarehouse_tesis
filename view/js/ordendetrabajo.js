/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('ready', function () {
    //alert("cargo");

    $('#cedula').change(function () {
        var cedula = $('#cedula').val();
        var url = '../controler/ordenTrabajoControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=mostrar_datos_cliente' + '&cedula=' + cedula,
            success: function (datos) {
                $('#mensaje').html(datos);
            }
        });
        return false;
    });


    $("#clientes").DataTable({
        order: [[5, "desc"]],
        dom: "Bfrtip",
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ],
        responsive: true
    });




});

function calcular() {
    var cantidad = $('#cantidad').val();
    var pvp = $('#pvp').val();
    var desc = $('#desc').val();
    var total = (pvp * cantidad) - ((pvp * cantidad) * desc) / 100;
    $('#total').val(total);
}

function id_datos_productos() {
    var id = $('#id_producto').val();
    if (id !== '') {
        var url = '../controler/productoControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=id_datos_productos&id=' + id,
            success: function (datos) {
                $('#id_datos_productos').html(datos);
                $('#cantidad').focus();
            }
        });
        return false;
    } else {
        swal("¡Error!", "Seleccione el servicio", "error");
    }
}

function agregar_producto_tmp() {
    var codtmp = $('#cod-tmp').val();
    var id_producto = $('#id_producto').val();
    var pvp = $('#pvp').val();
    var iva = $('#iva').val();
    var año = $('#año').val();
    var cantidad = $('#cantidad').val();
    var desc = $('#desc').val();
    var total = $('#total').val();
    var cedula = $('#cedula').val();
    if (id_producto !== '' && pvp !== '' && cantidad !== '' && desc !== '' && total !== '' && cedula !== '') {
        var url = '../controler/ordenTrabajoControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=add_tmp_productos&codtmp=' + codtmp + '&id_producto=' + id_producto + '&pvp=' + pvp + '&cantidad=' + cantidad + '&descuento=' + desc + '&total=' + total + '&cedula=' + cedula + '&año=' + año + '&iva=' + iva,
            success: function (datos) {
                $('#mostrar_productos_tmp').html(datos);
                $('#div-fp').show();
            }
        });
        return false;
    } else {
        swal("¡Error!", "Seleccione el servicio", "error");
    }
}

function agregar_forma_tmp() {
    var codtmp = $('#cod-tmp').val();
    var cedula = $('#cedula').val();
    var valor = $('#valor').val();
    var total = $('#total').val();
    if (codtmp !== '' && cedula !== '' && valor !== '' && total !== '') {
        var url = '../controler/ordenTrabajoControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=add_tmp_formas&codtmp=' + codtmp + '&cedula=' + cedula + '&valor=' + valor + '&total=' + total,
            success: function (datos) {
                $('#mostrar_productos_tmp').html(datos);
            }
        });
        return false;
    } else {
        swal("¡Error!", "Seleccione el servicio", "error");
    }
}

function mostrar_fp(id) {
    if (id !== '') {
        var url = '../controler/ordenTrabajoControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=mostrar_fp&id=' + id,
            success: function (datos) {                
                $('#div-deta-fp').show();
                $('#div-deta-fp').html(datos);
            }
        });
        return false;
    } else {
        swal("¡Error!", "Seleccione el servicio", "error");
    }
}


function nuevo_orden(id) {
    if (id !== '') {
        var url = '../controler/ordenTrabajoControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=nueva_orden&id=' + id,
            success: function (datos) {
                $('#orden_trabajo').html(datos);
            }
        });
        return false;
    } else {
        swal("¡Error!", "No hay datos", "error");
    }
}

function cargar_clientes() {
    var url = '../controler/ordenTrabajoControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=cargar_clientes',
        success: function (datos) {
            $('#orden_trabajo').html(datos);
        }
    });
    return false;
}

function cancelar_orden() {
    swal({
        title: "Esta seguro de cancelar?",
        text: "Se borraran los datos ingresados",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, Estoy Seguro!',
        cancelButtonText: "No, Cancelar!"
    }).then(function () {
        cargar_clientes();
    });
}