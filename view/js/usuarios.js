/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('ready', function () {
    //alert("cargo");


    $("#table-usuarios").DataTable({
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

    $("#table-perfil").DataTable({
        order: [[0, "asc"]],
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

function nuevo_usuario() {
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=nuevo',
        success: function (datos) {
            $('#datos-usuario').html(datos);
        }
    });
    return false;
}

function cargar_usuarios() {
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=cargar',
        success: function (datos) {
            $('#datos-usuario').html(datos);
        }
    });
    return false;
}

function cancelar_usuario() {
    swal({
        title: "Esta seguro de cancelar?",
        text: "Se borraran los datos ingresados",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, Estoy Seguro!',
        cancelButtonText: "No, Cancelar!"
    }).then(function () {
        cargar_usuarios();
        //window.location.href = '../view/productos';
    });
}

function mostrar_usuario(id) {
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=mostrar_usuario&id=' + id,
        success: function (datos) {
            $('#datos-usuario').html(datos);
        }
    });
    return false;
}

function guardar_usuario() {
    var nombre = $('#nombre').val();
    var usuario = $('#usuario').val();
    var clave = $('#clave').val();
    var tipo = $('#tipo').val();
    var correo = $('#correo').val();
    var costos = $('#costos').val();
    if (nombre !== '' && usuario !== '' && clave !== '' && tipo !== '' && costos !== '') {
        $('datos-usuario').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=guardar&nombre=' + nombre + '&usuario=' + usuario + '&clave=' + clave + '&tipo=' + tipo + '&correo=' + correo + '&costos=' + costos,
            success: function (datos) {
                $('#datos-usuario').html(datos);
            }
        });
        return false;
    } else {
        swal("¡Error!", "Ingrese los campos obligatorios", "error");
    }
}

function modificar_usuario() {
    var id = $('#id').val();
    var nombre = $('#nombre').val();
    var usuario = $('#usuario').val();
    var tipo = $('#tipo').val();
    var correo = $('#correo').val();
    var costos = $('#costos').val();
    var estado = $('#estado').val();
    if (nombre !== '' && usuario !== '' && tipo !== '' && correo !== '' && costos !== '' && estado !== '') {
        $('datos-usuario').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=modificar&id=' + id + '&nombre=' + nombre + '&usuario=' + usuario + '&tipo=' + tipo + '&correo=' + correo + '&costos=' + costos + '&estado=' + estado,
            success: function (datos) {
                $('#datos-usuario').html(datos);
            }
        });
        return false;
    } else {
        swal("¡Error!", "Seleccione el servicio", "error");
    }
}

function eliminar_usuario(id) {
    swal({
        title: "Esta seguro de Eliminar este usuario?",
        text: "No se podra reversar los cambios",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, Estoy Seguro!',
        cancelButtonText: "No, Cancelar!"
    }).then(function () {
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=eliminar&id=' + id,
            success: function (datos) {
                $('#datos-usuario').html(datos);
            }
        });
        return false;
    });
}

function nuevo_perfil() {
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=nuevo_perfil',
        success: function (datos) {
            $('#datos-perfil').html(datos);
        }
    });
    return false;
}


function cancelar_perfil() {
    swal({
        title: "Esta seguro de cancelar?",
        text: "Se borraran los datos ingresados",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, Estoy Seguro!',
        cancelButtonText: "No, Cancelar!"
    }).then(function () {
        cargar_perfil();
        //window.location.href = '../view/productos';
    });
}

function cargar_perfil() {
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=cargar_perfil',
        success: function (datos) {
            $('#datos-perfil').html(datos);
        }
    });
    return false;
}

function guardar_perfil() {
    var nombre = $('#nombre').val();
    if (nombre !== '') {
        $('datos-perfil').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=guardar_perfil&nombre=' + nombre,
            success: function (datos) {
                $('#datos-perfil').html(datos);
            }
        });
        return false;
    } else {
        swal("¡Error!", "Ingrese los campos obligatorios", "error");
    }
}

function mostrar_perfil(id) {
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=mostrar_perfil&id=' + id,
        success: function (datos) {
            $('#datos-perfil').html(datos);
        }
    });
    return false;
}

function eliminar_perfil(id) {
    swal({
        title: "Esta seguro de Eliminar este usuario?",
        text: "No se podra reversar los cambios",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, Estoy Seguro!',
        cancelButtonText: "No, Cancelar!"
    }).then(function () {
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=eliminar_perfil&id=' + id,
            success: function (datos) {
                $('#datos-perfil').html(datos);
            }
        });
        return false;
    });
}

function modificar_perfil() {
    var id = $('#id').val();
    var nombre = $('#nombre').val();
    var estado = $('#estado').val();
    if (nombre !== '' && estado !== '') {
        $('datos-perfil').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=modificar_perfil&id=' + id + '&nombre=' + nombre + '&estado=' + estado,
            success: function (datos) {
                $('#datos-perfil').html(datos);
            }
        });
        return false;
    } else {
        swal("¡Error!", "Seleccione el servicio", "error");
    }
}

function mostrar_permisos(id) {
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=mostrar_menu&id=' + id,
        success: function (datos) {
            $('#datos-perfil').html(datos);
        }
    });
    return false;
}

function agregar_permiso(perfil, menu) {
    $('#permiso-' + menu).html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:30px"></i></div>');
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=agregar_permiso&perfil=' + perfil + '&menu=' + menu,
        success: function (datos) {
            $('#permiso-' + menu).html(datos);
        }
    });
    return false;
}

function quitar_permiso(perfil, menu) {
    $('#permiso-' + menu).html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:30px"></i></div>');
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=quitar_permiso&perfil=' + perfil + '&menu=' + menu,
        success: function (datos) {
            $('#permiso-' + menu).html(datos);
        }
    });
    return false;
}