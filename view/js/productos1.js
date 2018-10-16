/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('ready', function () {
    //alert("cargo");

   
    $("#table-productos").DataTable({
        order: [[6, "desc"]],
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

function nuevo_producto() {
    var url = '../controler/productoControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=nuevo',
        success: function (datos) {
            $('#datos-producto').html(datos);
        }
    });
    return false;
}

function cargar_producto() {
    var url = '../controler/productoControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=cargar_producto',
        success: function (datos) {
            $('#datos-producto').html(datos);
        }
    });
    return false;
}

function cancelar_producto() {
    swal({
        title: "Esta seguro de cancelar?",
        text: "Se borraran los datos ingresados",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, Estoy Seguro!',
        cancelButtonText: "No, Cancelar!"
    }).then(function () {
        cargar_producto();
        //window.location.href = '../view/productos';
    });
}

function mostrar_producto(id) {
    var url = '../controler/productoControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=mostrar_producto&id=' + id,
        success: function (datos) {
            $('#datos-producto').html(datos);
        }
    });
    return false;
}


function modificar_producto() {
    var id = $('#id').val();
    var tipo = $('#tipo').val();
    var considera = $('#considera').val();
    var nombre = $('#nombre').val();
    var cantidad = $('#cantidad').val();
    var costo = $('#costo').val();
    var pvp = $('#pvp').val();
    var iva = $('#iva').val();
    var descuento = $('#descuento').val();
    var observacion = $('#observacion').val();
    var estado = $('#estado').val();
    if (tipo !== '' && considera !== '' && nombre !== '' && cantidad !== '' && costo !== '' && pvp !== '' && iva !== '') {
        $('datos-producto').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        var url = '../controler/productoControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=modificar_producto&tipo=' + tipo + '&considera=' + considera + '&nombre=' + nombre + '&cantidad=' + cantidad + '&costo=' + costo + '&pvp=' + pvp + '&iva=' + iva + '&descuento=' + descuento + '&observacion=' + observacion + '&estado=' + estado + '&id=' + id,
            success: function (datos) {
                $('#datos-producto').html(datos);
            }
        });
        return false;
    } else {
        swal("¡Error!", "Seleccione el servicio", "error");
    }
}