<?
session_start();
if (!$_SESSION['id']) {
    header('Location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>        
        <link rel="stylesheet" type="text/css" href="vendors/orb/dist/orb.css" />
        <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">                
        <script type="text/javascript" src="vendors/orb/deps/react-0.12.2.js"></script>
        <script type="text/javascript" src="vendors/orb/dist/orb.js"></script>

        <link href="vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
        <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">        
        <link href="vendors/nprogress/nprogress.css" rel="stylesheet">        
        <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet"> 
        <link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">                                                
        <link href="build/css/custom.min.css" rel="stylesheet">
        <style>
            .caption{padding:0px 0px !important;background:transparent !important}.caption p{margin-bottom:0px !important}
        </style>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <? include_once 'menuprofile.php'; ?>
                <? include_once 'menusidebar.php'; ?>
                <? include_once 'menufooter.php'; ?>
                <? include_once 'menusiderbar2.php'; ?>
                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>CUBO DE VENTAS</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                            
                                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <br />
                                        <form id="cubo" class="form-horizontal form-label-left">                                          
                                            <input type="text" class="hidden" name="proceso" value="ventas" />
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Rango de Fechas</label>
                                                <div class="col-sm-6">
                                                    <div class="input-daterange input-group" id="datepicker">
                                                        <span class="input-group-addon">Desde</span>
                                                        <input type="text" class="input-sm form-control" name="start" id="start" />
                                                        <span class="input-group-addon">Hasta</span>
                                                        <input type="text" class="input-sm form-control" name="end" id="end" />                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">Tipo Cubo</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" class="flat" checked name="tipo" id="tipo" value="0"> Totalisado
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" class="flat" name="tipo" id="tipo" value="1"> Detallado
                                                        </label>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="ln_solid"></div>
                                            <div class="form-group">
                                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                                    <button type="button" class="btn btn-primary">Cancelar</button>                                                    
                                                    <button type="button" id="btn-ventas" class="btn btn-success">Procesar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">                                        
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                            
                                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="table table-responsive">
                                        <div id="cubo-ventas"></div>
                                    </div>
                                </div>                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
            <? include_once 'templates/footer.php'; ?>
        </div>
    </div>
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="vendors/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.js"></script>
    <script src="vendors/sweetalert/sweetalert2.all.min.js"></script>
    <script src="js/ventas.js"></script>

</body>
</html>
