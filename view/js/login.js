/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).on('ready', function () {
    $('#btn-ingresar').click(function () {
        $('#btn-ingresar').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
        //$('#resp').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
        var url = "controler/loginControler.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#formulario").serialize(),
            success: function (data) {
                if (data) {
                    //$('#resp').html(data);
                    window.location.href = 'view/index';
                } else {
                    swal("¡Error!", "Usuario y Contraseña Incorectas", "error");
                    $('#usuario').val('');
                    $('#password').val('');                    
                    //$('#resp').html('');
                }
            },
            complete: function () {
                $('#btn-ingresar').removeAttr('disabled').find('i.fa').remove();
            }
        });
    });
});