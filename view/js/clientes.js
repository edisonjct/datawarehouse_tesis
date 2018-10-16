/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('ready', function () {
    //alert("cargo");


    $('#ingresar-cliente').hide();

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

    $("#tabla-servicios").DataTable();




    $('#nuevo-cliente').click(function () {
        $('#codigo-tmp').val(Math.floor((Math.random() * 99999) + 100));
        $('#datos-cliente').hide();
        $('#ingresar-cliente').show();
    });



    $('#agregar-servicios').click(function () {
        var codtemp = $('#codigo-tmp').val();
        var servicio = $('#servicios-cliente').val();
        if (servicio !== '') {
            $('mostrar-servicios').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
            var url = '../controler/clienteControler.php';
            $.ajax({
                type: 'POST',
                url: url,
                data: 'proceso=agregar_servicios&codtemp=' + codtemp + '&servicio=' + servicio,
                success: function (datos) {
                    $('#mostrar-servicios').html(datos);
                }
            });
            return false;
        } else {
            swal("¡Error!", "Seleccione el servicio", "error");
        }
    });

    $('#cedula').change(function () {
        var cedula = $('#cedula').val();
        if (cedula !== '') {
            var url = '../controler/clienteControler.php';
            $.ajax({
                type: 'POST',
                url: url,
                data: 'proceso=valida_cedula&cedula=' + cedula,
                success: function (datos) {
                    $('#mensaje').html(datos);
                }
            });
            return false;
        } else {
            swal("¡Error!", "Campo Vacio", "error");
        }
    });

    $('#agregar-claves').click(function () {
        var codtemp = $('#codigo-tmp').val();
        var nombre = $('#nombre-clave').val();
        var clave = $('#clave').val();
        if (nombre !== '' && clave !== '') {
            $('mostrar-claves').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
            var url = '../controler/clienteControler.php';
            $.ajax({
                type: 'POST',
                url: url,
                data: 'proceso=agregar_claves&codtemp=' + codtemp + '&nombre=' + nombre + '&clave=' + clave,
                success: function (datos) {
                    $('#mostrar-claves').html(datos);
                }
            });
            return false;
        } else {
            swal("¡Error!", "Seleccione el servicio", "error");
        }
    });

    $('#agregar-documentos').click(function () {

    });




    $('#modificar-cliente').click(function () {
        alert("entre");

//        var codtemp = $('#codigo-tmp').val();
//        var cedula = $('#cedula').val();
//        var nombre = $('#nombre').val();
//        var apellido = $('#apellido').val();
//        var direccion = $('#direccion').val();
//        var telefono = $('#telefono').val();
//        var correo = $('#correo').val();
//        var gender = $("input[name$='gender']").val();
//        var profecion = $('#profecion').val();
//        var fecha_nacimiento = $('#fecha-nacimiento').val();
//        var estado_civil = $('#estado-civil').val();
//        var tipo_cliente = $('#tipo-cliente').val();
//        var fecha_declaracion = $('#fecha-declaracion').val();
//        var grupo = $('#grupo').val();
//        var tarifa_rrhh = $('#tarifa-rrhh').val();
//        var prioridad = $('#prioridad').val();
//        var fe = $("input[name$='fe']").val();
//        var personal = $("input[name$='personal-bd']").val();
//        var tarifa_semestral = $('#tarifa-semestral').val();
//        var tarifa_anual = $('#tarifa-anual').val();
//        var comisionista = $('#comisionista').val();
//        if (codtemp !== '' && cedula !== '' && nombre !== '' && apellido !== '' && direccion !== '' && telefono !== '' && correo !== '' && gender !== '' && profecion !== '' && fecha_nacimiento !== '' && estado_civil !== '' && tipo_cliente !== '' && fecha_declaracion !== '' && fe !== '' && personal !== '' && tarifa_semestral !== '' && tarifa_anual !== '' && comisionista !== '') {
//            //alert("entro");
//            $('ingresar-cliente').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
//            var url = '../controler/clienteControler.php';
//            $.ajax({
//                type: 'POST',
//                url: url,
//                data: 'proceso=agregar_cliente&codtemp=' + codtemp + '&cedula=' + cedula + '&nombre=' + nombre + '&cedula=' + cedula + '&nombre=' + nombre +
//                        '&apellido=' + apellido + '&direccion=' + direccion + '&telefono=' + telefono + '&correo=' + correo + '&gender=' + gender + '&profecion=' + profecion +
//                        '&fecha_nacimiento=' + fecha_nacimiento + '&estado_civil=' + estado_civil + '&tipo_cliente=' + tipo_cliente + '&fecha_declaracion=' + fecha_declaracion + '&grupo=' + grupo + '&tarifa_rrhh=' + tarifa_rrhh +
//                        '&prioridad=' + prioridad + '&fe=' + fe + '&personal=' + personal + '&tarifa_semestral=' + tarifa_semestral + '&tarifa_anual=' + tarifa_anual + '&comisionista=' + comisionista,
//                success: function (datos) {
//                    $('#ingresar-cliente').html(datos);
//                    setTimeout('redireciona_cliente()', 3000);
//
//                }
//            });
//            return false;
//        } else {
//            swal("¡Error!", "Ingrese los datos obligatorios", "error");
//        }
    });




    $('.buttonFinishCliente').click(function () {
        var cedula = $('#cedula').val();
        var fechadeclaracion = $('#fecha-declaracion').val();
        var nombres = $('#nombres').val();
        var razonsocial = $('#razonsocial').val();
        var representante = $('#representante').val();
        var referido = $("#referido").val();
        var profecion = $('#profecion').val();
        var direccion = $('#direccion').val();
        var telefono = $('#telefono').val();
        var ciudad = $('#ciudad').val();
        var correo = $('#correo').val();
        var tipocliente = $('#tipo-cliente').val();
        var gender = $('#gender').val();
        var fechanacimiento = $('#fecha-nacimiento').val();
        var estadocivil = $("#estado-civil").val();
//        var clavesri = $("#clavesri").val();
//        var clavesotras = $('#clavesotras').val();
        var grupo = $('#grupo').val();
        var sector = $('#sector').val();
        var observacion = $('#observacion').val();
        if (cedula !== '' && fechadeclaracion !== '' && nombres !== '' && profecion !== '' && direccion !== '' && telefono !== '' && ciudad !== '' && correo !== '' && tipocliente !== '' && gender !== '' && fechanacimiento !== '' && estadocivil !== '') {
            $('ingresar-cliente').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
            var url = '../controler/clienteControler.php';
            $.ajax({
                type: 'POST',
                url: url,
                data: 'proceso=agregar_cliente&cedula=' + cedula + '&fechadeclaracion=' + fechadeclaracion + '&nombres=' + nombres + '&razonsocial=' + razonsocial + '&representante=' + representante +
                        '&referido=' + referido + '&profecion=' + profecion + '&direccion=' + direccion + '&telefono=' + telefono + '&ciudad=' + ciudad + '&correo=' + correo +
                        '&tipocliente=' + tipocliente + '&gender=' + gender + '&fechanacimiento=' + fechanacimiento + '&estadocivil=' + estadocivil +
                        '&grupo=' + grupo + '&observacion=' + observacion + '&sector=' + sector,
                success: function (datos) {
                    $('#ingresar-cliente').html(datos);
                    setTimeout('redireciona_cliente()', 3000);

                }
            });
            return false;
        } else {
            swal("¡Error!", "Ingrese los datos obligatorios", "error");
        }

//        alert(cedula);
//        alert(nombre);
//        alert(apellido);
//        alert(direccion);
//        alert(telefono);
//        alert(correo);
//        alert(gender);
//        alert(profecion);
//        alert(fecha_nacimiento);
//        alert(estado_civil);        
//        alert(estado_civil);
//        alert(fecha_declaracion);
//        alert(tarifa_rrhh);
//        alert(prioridad);
//        alert(fe);
//        alert(personal);
//        alert(tarifa_semestral);
//        alert(tarifa_anual);
//        alert(comisionista);
    });



});

function agregar_documento(cliente) {
    var nombre = $('#nombre-documento').val();
    var inputFileImage = document.getElementById("documento");
    if (nombre !== '' && inputFileImage !== '') {
        var file = inputFileImage.files[0];
        var data = new FormData();
        data.append('documento', file);
        var url = '../controler/clienteUploadControler.php?proceso=agregar_documento_cliente&cliente=' + cliente + '&nombre=' + nombre;
        $.ajax({
            url: url,
            type: 'POST',
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            success: function (datos) {
                $('#mostrar-documentos-cliente').html(datos); // display response from the PHP script, if any   
            }
        });
        return false;
    } else {
        swal("¡Error!", "Ingrese los Parametros de Documentos", "error");
        return false;
    }
}

function agregar_clave(cliente) {
    var nombre = $('#nombre-clave').val();
    var clave = $('#clave').val();
    if (nombre !== '' && clave !== '') {
        var url = '../controler/clienteControler.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: 'proceso=agregar_claves&id=' + cliente + '&nombre=' + nombre + '&clave=' + clave,
            success: function (datos) {
                $('#mostrar-clave-cliente').html(datos);
                $('#nombre-clave').val('');
                $('#clave').val('');
            }
        });
        return false;
    } else {
        swal("¡Error!", "Ingrese los Parametros Solicitados", "error");
    }

}

function mostrar_documento(cliente) {
    var url = '../controler/clienteControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=mostrar_documentos&id=' + cliente,
        success: function (datos) {
            $('#mostrar-documentos-cliente').html(datos);
        }
    });
    return false;
}

function mostrar_clave(cliente) {
    var url = '../controler/clienteControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=mostrar_claves&id=' + cliente,
        success: function (datos) {
            $('#mostrar-clave-cliente').html(datos);
        }
    });
    return false;
}

function cancelar_cliente() {
    swal({
        title: "Esta seguro de cancelar?",
        text: "Se borraran los datos ingresados",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, Estoy Seguro!',
        cancelButtonText: "No, Cancelar!"
    }).then(function () {
        window.location.href = '../view/clientes';
    });
}

function redireciona_cliente() {
    window.location.href = '../view/clientes';
}

function editar_cliente(id) {
    var url = '../controler/clienteControler.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'proceso=editar_cliente&id=' + id,
        success: function (datos) {
            $('#datos-cliente').hide();
            $('#editar-cliente').html(datos);
        }
    });
    return false;

}

function SmartWizard(target, options) {
    this.target = target;
    this.options = options;
    this.curStepIdx = options.selected;
    this.steps = $(target).children("ul").children("li").children("a"); // Get all anchors
    this.contentWidth = 0;
    this.msgBox = $('<div class="msgBox"><div class="content"></div><a href="#" class="close">X</a></div>');
    this.elmStepContainer = $('<div></div>').addClass("stepContainer");
    this.loader = $('<div>Loading</div>').addClass("loader");
    this.buttons = {
        next: $('<a>' + options.labelNext + '</a>').attr("href", "#").addClass("buttonNext"),
        previous: $('<a>' + options.labelPrevious + '</a>').attr("href", "#").addClass("buttonPrevious"),
        finish: $('<a>' + options.labelFinish + '</a>').attr("href", "#").addClass("buttonFinishCliente")
    };

    /*
     * Private functions
     */

    var _init = function ($this) {
        var elmActionBar = $('<div></div>').addClass("actionBar");
        elmActionBar.append($this.msgBox);
        $('.close', $this.msgBox).click(function () {
            $this.msgBox.fadeOut("normal");
            return false;
        });

        var allDivs = $this.target.children('div');
        $this.target.children('ul').addClass("anchor");
        allDivs.addClass("content");

        // highlight steps with errors
        if ($this.options.errorSteps && $this.options.errorSteps.length > 0) {
            $.each($this.options.errorSteps, function (i, n) {
                $this.setError({stepnum: n, iserror: true});
            });
        }

        $this.elmStepContainer.append(allDivs);
        elmActionBar.append($this.loader);
        $this.target.append($this.elmStepContainer);
        elmActionBar.append($this.buttons.finish)
                .append($this.buttons.next)
                .append($this.buttons.previous);
        $this.target.append(elmActionBar);
        this.contentWidth = $this.elmStepContainer.width();

        $($this.buttons.next).click(function () {
            $this.goForward();
            return false;
        });
        $($this.buttons.previous).click(function () {
            $this.goBackward();
            return false;
        });
        $($this.buttons.finish).click(function () {
            if (!$(this).hasClass('buttonDisabled')) {
                if ($.isFunction($this.options.onFinish)) {
                    var context = {fromStep: $this.curStepIdx + 1};
                    if (!$this.options.onFinish.call(this, $($this.steps), context)) {
                        return false;
                    }
                } else {
                    var frm = $this.target.parents('form');
                    if (frm && frm.length) {
                        frm.submit();
                    }
                }
            }
            return false;
        });

        $($this.steps).bind("click", function (e) {
            if ($this.steps.index(this) == $this.curStepIdx) {
                return false;
            }
            var nextStepIdx = $this.steps.index(this);
            var isDone = $this.steps.eq(nextStepIdx).attr("isDone") - 0;
            if (isDone == 1) {
                _loadContent($this, nextStepIdx);
            }
            return false;
        });

        // Enable keyboard navigation
        if ($this.options.keyNavigation) {
            $(document).keyup(function (e) {
                if (e.which == 39) { // Right Arrow
                    $this.goForward();
                } else if (e.which == 37) { // Left Arrow
                    $this.goBackward();
                }
            });
        }
        //  Prepare the steps
        _prepareSteps($this);
        // Show the first slected step
        _loadContent($this, $this.curStepIdx);
    };

    var _prepareSteps = function ($this) {
        if (!$this.options.enableAllSteps) {
            $($this.steps, $this.target).removeClass("selected").removeClass("done").addClass("disabled");
            $($this.steps, $this.target).attr("isDone", 0);
        } else {
            $($this.steps, $this.target).removeClass("selected").removeClass("disabled").addClass("done");
            $($this.steps, $this.target).attr("isDone", 1);
        }

        $($this.steps, $this.target).each(function (i) {
            $($(this).attr("href").replace(/^.+#/, '#'), $this.target).hide();
            $(this).attr("rel", i + 1);
        });
    };

    var _step = function ($this, selStep) {
        return $(
                $(selStep, $this.target).attr("href").replace(/^.+#/, '#'),
                $this.target
                );
    };

    var _loadContent = function ($this, stepIdx) {
        var selStep = $this.steps.eq(stepIdx);
        var ajaxurl = $this.options.contentURL;
        var ajaxurl_data = $this.options.contentURLData;
        var hasContent = selStep.data('hasContent');
        var stepNum = stepIdx + 1;
        if (ajaxurl && ajaxurl.length > 0) {
            if ($this.options.contentCache && hasContent) {
                _showStep($this, stepIdx);
            } else {
                var ajax_args = {
                    url: ajaxurl,
                    type: "POST",
                    data: ({step_number: stepNum}),
                    dataType: "text",
                    beforeSend: function () {
                        $this.loader.show();
                    },
                    error: function () {
                        $this.loader.hide();
                    },
                    success: function (res) {
                        $this.loader.hide();
                        if (res && res.length > 0) {
                            selStep.data('hasContent', true);
                            _step($this, selStep).html(res);
                            _showStep($this, stepIdx);
                        }
                    }
                };
                if (ajaxurl_data) {
                    ajax_args = $.extend(ajax_args, ajaxurl_data(stepNum));
                }
                $.ajax(ajax_args);
            }
        } else {
            _showStep($this, stepIdx);
        }
    };

    var _showStep = function ($this, stepIdx) {
        var selStep = $this.steps.eq(stepIdx);
        var curStep = $this.steps.eq($this.curStepIdx);
        if (stepIdx != $this.curStepIdx) {
            if ($.isFunction($this.options.onLeaveStep)) {
                var context = {fromStep: $this.curStepIdx + 1, toStep: stepIdx + 1};
                if (!$this.options.onLeaveStep.call($this, $(curStep), context)) {
                    return false;
                }
            }
        }
        $this.elmStepContainer.height(_step($this, selStep).outerHeight());
        var prevCurStepIdx = $this.curStepIdx;
        $this.curStepIdx = stepIdx;
        if ($this.options.transitionEffect == 'slide') {
            _step($this, curStep).slideUp("fast", function (e) {
                _step($this, selStep).slideDown("fast");
                _setupStep($this, curStep, selStep);
            });
        } else if ($this.options.transitionEffect == 'fade') {
            _step($this, curStep).fadeOut("fast", function (e) {
                _step($this, selStep).fadeIn("fast");
                _setupStep($this, curStep, selStep);
            });
        } else if ($this.options.transitionEffect == 'slideleft') {
            var nextElmLeft = 0;
            var nextElmLeft1 = null;
            var nextElmLeft = null;
            var curElementLeft = 0;
            if (stepIdx > prevCurStepIdx) {
                nextElmLeft1 = $this.contentWidth + 10;
                nextElmLeft2 = 0;
                curElementLeft = 0 - _step($this, curStep).outerWidth();
            } else {
                nextElmLeft1 = 0 - _step($this, selStep).outerWidth() + 20;
                nextElmLeft2 = 0;
                curElementLeft = 10 + _step($this, curStep).outerWidth();
            }
            if (stepIdx == prevCurStepIdx) {
                nextElmLeft1 = $($(selStep, $this.target).attr("href"), $this.target).outerWidth() + 20;
                nextElmLeft2 = 0;
                curElementLeft = 0 - $($(curStep, $this.target).attr("href"), $this.target).outerWidth();
            } else {
                $($(curStep, $this.target).attr("href"), $this.target).animate({left: curElementLeft}, "fast", function (e) {
                    $($(curStep, $this.target).attr("href"), $this.target).hide();
                });
            }

            _step($this, selStep).css("left", nextElmLeft1).show().animate({left: nextElmLeft2}, "fast", function (e) {
                _setupStep($this, curStep, selStep);
            });
        } else {
            _step($this, curStep).hide();
            _step($this, selStep).show();
            _setupStep($this, curStep, selStep);
        }
        return true;
    };

    var _setupStep = function ($this, curStep, selStep) {
        $(curStep, $this.target).removeClass("selected");
        $(curStep, $this.target).addClass("done");

        $(selStep, $this.target).removeClass("disabled");
        $(selStep, $this.target).removeClass("done");
        $(selStep, $this.target).addClass("selected");

        $(selStep, $this.target).attr("isDone", 1);

        _adjustButton($this);

        if ($.isFunction($this.options.onShowStep)) {
            var context = {fromStep: parseInt($(curStep).attr('rel')), toStep: parseInt($(selStep).attr('rel'))};
            if (!$this.options.onShowStep.call(this, $(selStep), context)) {
                return false;
            }
        }
        if ($this.options.noForwardJumping) {
            // +2 == +1 (for index to step num) +1 (for next step)
            for (var i = $this.curStepIdx + 2; i <= $this.steps.length; i++) {
                $this.disableStep(i);
            }
        }
    };

    var _adjustButton = function ($this) {
        if (!$this.options.cycleSteps) {
            if (0 >= $this.curStepIdx) {
                $($this.buttons.previous).addClass("buttonDisabled");
                if ($this.options.hideButtonsOnDisabled) {
                    $($this.buttons.previous).hide();
                }
            } else {
                $($this.buttons.previous).removeClass("buttonDisabled");
                if ($this.options.hideButtonsOnDisabled) {
                    $($this.buttons.previous).show();
                }
            }
            if (($this.steps.length - 1) <= $this.curStepIdx) {
                $($this.buttons.next).addClass("buttonDisabled");
                if ($this.options.hideButtonsOnDisabled) {
                    $($this.buttons.next).hide();
                }
            } else {
                $($this.buttons.next).removeClass("buttonDisabled");
                if ($this.options.hideButtonsOnDisabled) {
                    $($this.buttons.next).show();
                }
            }
        }
        // Finish Button
        if (!$this.steps.hasClass('disabled') || $this.options.enableFinishButton) {
            $($this.buttons.finish).removeClass("buttonDisabled");
            if ($this.options.hideButtonsOnDisabled) {
                $($this.buttons.finish).show();
            }
        } else {
            $($this.buttons.finish).addClass("buttonDisabled");
            if ($this.options.hideButtonsOnDisabled) {
                $($this.buttons.finish).hide();
            }
        }
    };

    /*
     * Public methods
     */

    SmartWizard.prototype.goForward = function () {
        var nextStepIdx = this.curStepIdx + 1;
        if (this.steps.length <= nextStepIdx) {
            if (!this.options.cycleSteps) {
                return false;
            }
            nextStepIdx = 0;
        }
        _loadContent(this, nextStepIdx);
    };

    SmartWizard.prototype.goBackward = function () {
        var nextStepIdx = this.curStepIdx - 1;
        if (0 > nextStepIdx) {
            if (!this.options.cycleSteps) {
                return false;
            }
            nextStepIdx = this.steps.length - 1;
        }
        _loadContent(this, nextStepIdx);
    };

    SmartWizard.prototype.goToStep = function (stepNum) {
        var stepIdx = stepNum - 1;
        if (stepIdx >= 0 && stepIdx < this.steps.length) {
            _loadContent(this, stepIdx);
        }
    };
    SmartWizard.prototype.enableStep = function (stepNum) {
        var stepIdx = stepNum - 1;
        if (stepIdx == this.curStepIdx || stepIdx < 0 || stepIdx >= this.steps.length) {
            return false;
        }
        var step = this.steps.eq(stepIdx);
        $(step, this.target).attr("isDone", 1);
        $(step, this.target).removeClass("disabled").removeClass("selected").addClass("done");
    }
    SmartWizard.prototype.disableStep = function (stepNum) {
        var stepIdx = stepNum - 1;
        if (stepIdx == this.curStepIdx || stepIdx < 0 || stepIdx >= this.steps.length) {
            return false;
        }
        var step = this.steps.eq(stepIdx);
        $(step, this.target).attr("isDone", 0);
        $(step, this.target).removeClass("done").removeClass("selected").addClass("disabled");
    }
    SmartWizard.prototype.currentStep = function () {
        return this.curStepIdx + 1;
    }

    SmartWizard.prototype.showMessage = function (msg) {
        $('.content', this.msgBox).html(msg);
        this.msgBox.show();
    }
    SmartWizard.prototype.hideMessage = function () {
        this.msgBox.fadeOut("normal");
    }
    SmartWizard.prototype.showError = function (stepnum) {
        this.setError(stepnum, true);
    }
    SmartWizard.prototype.hideError = function (stepnum) {
        this.setError(stepnum, false);
    }
    SmartWizard.prototype.setError = function (stepnum, iserror) {
        if (typeof stepnum == "object") {
            iserror = stepnum.iserror;
            stepnum = stepnum.stepnum;
        }

        if (iserror) {
            $(this.steps.eq(stepnum - 1), this.target).addClass('error')
        } else {
            $(this.steps.eq(stepnum - 1), this.target).removeClass("error");
        }
    }

    SmartWizard.prototype.fixHeight = function () {
        var height = 0;

        var selStep = this.steps.eq(this.curStepIdx);
        var stepContainer = _step(this, selStep);
        stepContainer.children().each(function () {
            height += $(this).outerHeight();
        });

        // These values (5 and 20) are experimentally chosen.
        stepContainer.height(height + 5);
        this.elmStepContainer.height(height + 20);
    }

    _init(this);
}
;



(function ($) {

    $.fn.smartWizard = function (method) {
        var args = arguments;
        var rv = undefined;
        var allObjs = this.each(function () {
            var wiz = $(this).data('smartWizard');
            if (typeof method == 'object' || !method || !wiz) {
                var options = $.extend({}, $.fn.smartWizard.defaults, method || {});
                if (!wiz) {
                    wiz = new SmartWizard($(this), options);
                    $(this).data('smartWizard', wiz);
                }
            } else {
                if (typeof SmartWizard.prototype[method] == "function") {
                    rv = SmartWizard.prototype[method].apply(wiz, Array.prototype.slice.call(args, 1));
                    return rv;
                } else {
                    $.error('Method ' + method + ' does not exist on jQuery.smartWizard');
                }
            }
        });
        if (rv === undefined) {
            return allObjs;
        } else {
            return rv;
        }
    };

// Default Properties and Events
    $.fn.smartWizard.defaults = {
        selected: 0, // Selected Step, 0 = first step
        keyNavigation: true, // Enable/Disable key navigation(left and right keys are used if enabled)
        enableAllSteps: false,
        transitionEffect: 'fade', // Effect on navigation, none/fade/slide/slideleft
        contentURL: null, // content url, Enables Ajax content loading
        contentCache: true, // cache step contents, if false content is fetched always from ajax url
        cycleSteps: false, // cycle step navigation
        enableFinishButton: false, // make finish button enabled always
        hideButtonsOnDisabled: false, // when the previous/next/finish buttons are disabled, hide them instead?
        errorSteps: [], // Array Steps with errors
        labelNext: 'Siguiente',
        labelPrevious: 'Atras',
        labelFinish: 'Finalizar',
        noForwardJumping: false,
        onLeaveStep: null, // triggers when leaving a step
        onShowStep: null, // triggers when showing a step
        onFinish: null  // triggers when Finish button is clicked
    };

})(jQuery);
