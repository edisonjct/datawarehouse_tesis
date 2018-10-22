/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('ready', function () {

});

function mostrat_backup() {
    $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
    //$('#backups').html('<div align="center"><img src="images/data.gif" width="150"/></i> <br> <h1>Generando Backup...</h1></div>');    
    var url = '../controler/procesosgeneralesControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=mostrar_backups',
        success: function (datos) {
            $('#backups').html(datos);
            $.unblockUI();
        }
    });
    return false;
}

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
            mostrat_backup();
            //$.unblockUI();
        },
        complete: function () {
            $('#btn-backup').removeAttr('disabled').find('i.fa').remove();
        }
    });
    return false;
}

function eliminar_backup(id) {
    swal({
        title: "Esta seguro de borrar el backup?",
        text: "Se borraran permanente el backup",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, Estoy Seguro!',
        cancelButtonText: "No, Cancelar!"
    }).then(function () {
        $.blockUI({css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff'}});
        var url = '../controler/procesosgeneralesControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=eliminar_backup&id=' + id,
            success: function (datos) {
                mostrat_backup();
                //$.unblockUI();
            }
        });
        return false;
    });



}