/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).on('ready', function () {
    $('#btn-ingresar').click(function () {
        $('#resp').html('<div align="center"><img src="view/production/images/data.gif" width="150"/></i></div>');
        var url = "controler/loginControler.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#formulario").serialize(),
            success: function (data) {
                if (data) {
                    $('#resp').html(data);
                    window.location.href = 'view/production/index.php';
                } else {
                    swal("¡Error!", "Usuario y Contraseña Incorectas", "error");
                    $('#resp').html('');
                }
            }
        });
    });
});