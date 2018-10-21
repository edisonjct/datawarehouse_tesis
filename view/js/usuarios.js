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

    $('#btn-cambiar-pass').click(function () {
        var id = $('#id').val();
        var pass = $('#pass').val();
        $('#btn-cambiar-pass').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
        //$('#resp').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=reset_pass&id=' + id + '&pass=' + pass,
            success: function (datos) {
                $('#datos-usuario').html(datos);
            },
            complete: function () {
                $('#btn-cambiar-pass').removeAttr('disabled').find('i.fa').remove();
            }
        });
        return false;
    });

});

function nuevo_usuario() {
    //$('#datos-usuario').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=nuevo',
        success: function (datos) {
            $('#datos-usuario').html(datos);
            $.unblockUI();
        }
    });
    return false;
}

function cargar_usuarios() {
    //$('#datos-usuario').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=cargar',
        success: function (datos) {
            $('#datos-usuario').html(datos);
            $.unblockUI();
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
        //$('#datos-usuario').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
        cargar_usuarios();
        //window.location.href = '../view/productos';
    });
}

function mostrar_usuario(id) {
    //$('#datos-usuario').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=mostrar_usuario&id=' + id,
        success: function (datos) {
            $('#datos-usuario').html(datos);
            $.unblockUI();
        }
    });
    return false;
}

function reset_password(id) {
    //$('#datos-usuario').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=reset_password&id=' + id,
        success: function (datos) {
            $('#datos-usuario').html(datos);
            $.unblockUI();
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
        //$('#datos-usuario').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=guardar&nombre=' + nombre + '&usuario=' + usuario + '&clave=' + clave + '&tipo=' + tipo + '&correo=' + correo + '&costos=' + costos,
            success: function (datos) {
                $('#datos-usuario').html(datos);
                $.unblockUI();
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
        //$('#datos-usuario').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=modificar&id=' + id + '&nombre=' + nombre + '&usuario=' + usuario + '&tipo=' + tipo + '&correo=' + correo + '&costos=' + costos + '&estado=' + estado,
            success: function (datos) {
                $('#datos-usuario').html(datos);
                $.unblockUI();
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
        //$('#datos-usuario').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=eliminar&id=' + id,
            success: function (datos) {
                $('#datos-usuario').html(datos);
                $.unblockUI();
            }
        });
        return false;
    });
}

function nuevo_perfil() {
    //$('#datos-perfil').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=nuevo_perfil',
        success: function (datos) {
            $('#datos-perfil').html(datos);
            $.unblockUI();
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
        //$('#datos-perfil').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
        cargar_perfil();
        //window.location.href = '../view/productos';
    });
}

function cargar_perfil() {
    //$('#datos-perfil').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=cargar_perfil',
        success: function (datos) {
            $('#datos-perfil').html(datos);
            $.unblockUI();
        }
    });
    return false;
}

function guardar_perfil() {
    var nombre = $('#nombre').val();
    if (nombre !== '') {
        //$('#datos-perfil').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=guardar_perfil&nombre=' + nombre,
            success: function (datos) {
                $('#datos-perfil').html(datos);
                $.unblockUI();
            }
        });
        return false;
    } else {
        swal("¡Error!", "Ingrese los campos obligatorios", "error");
    }
}

function mostrar_perfil(id) {
    //$('#datos-perfil').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=mostrar_perfil&id=' + id,
        success: function (datos) {
            $('#datos-perfil').html(datos);
            $.unblockUI();
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
        //$('#datos-perfil').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=eliminar_perfil&id=' + id,
            success: function (datos) {
                $('#datos-perfil').html(datos);
                $.unblockUI();
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
        //$('#datos-perfil').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
        var url = '../controler/usuarioControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=modificar_perfil&id=' + id + '&nombre=' + nombre + '&estado=' + estado,
            success: function (datos) {
                $('#datos-perfil').html(datos);
                $.unblockUI();
            }
        });
        return false;
    } else {
        swal("¡Error!", "Seleccione el servicio", "error");
    }
}

function mostrar_permisos(id) {
    //$('#datos-perfil').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=mostrar_menu&id=' + id,
        success: function (datos) {
            $('#datos-perfil').html(datos);
            $.unblockUI();
        }
    });
    return false;
}

function agregar_permiso(perfil, menu) {
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    $('#permiso-' + menu).html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:30px"></i></div>');
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=agregar_permiso&perfil=' + perfil + '&menu=' + menu,
        success: function (datos) {
            $('#permiso-' + menu).html(datos);
            $.unblockUI();
        }
    });
    return false;
}

function quitar_permiso(perfil, menu) {
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    $('#permiso-' + menu).html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:30px"></i></div>');
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=quitar_permiso&perfil=' + perfil + '&menu=' + menu,
        success: function (datos) {
            $('#permiso-' + menu).html(datos);
            $.unblockUI();
        }
    });
    return false;
}

function cambiar_pass() {
    var id = $('#id').val();
    var pass = $('#pass').val();
    //$('#btn-cambiarp').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
    //$('#resp').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    var url = '../controler/usuarioControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=reset_pass&id=' + id + '&pass=' + pass,
        success: function (datos) {
            $('#result').html(datos);
            $.unblockUI();
        },
        complete: function () {
            $('#btn-cambiarp').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}