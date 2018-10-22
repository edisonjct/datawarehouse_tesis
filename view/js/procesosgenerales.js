/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('ready', function () {

});


function backup() {
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    $('#backups').html('<div align="center"><img src="images/data.gif" width="150"/></i> <br> <h1>Generando Backup...</h1></div>');
    $('#btn-backup').attr('disabled', 'disabled').prepend('<i class="fa fa-refresh fa-spin"></i>  ');
    var url = '../controler/procesosgeneralesControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=backup',
        success: function (datos) {
            $('#backups').html(datos);
            $.unblockUI();
        },
        complete: function () {
            $('#btn-backup').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}