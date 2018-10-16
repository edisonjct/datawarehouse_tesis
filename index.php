<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DATA WAREHOUSE</title>
        <!-- Bootstrap -->
        <link href="view/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="view/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="view/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="view/vendors/animate.css/animate.min.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="view/build/css/custom.min.css" rel="stylesheet">
        <!-- Login -->
        <script src="view/vendors/jquery/dist/jquery.min.js"></script>
        <script src="view/vendors/sweetalert/sweetalert2.all.min.js"></script>
        <script src="view/js/login.js"></script>
    </head>

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form method="post" id="formulario">
                            <h1>Iniciar Sesion</h1>
                            <div>
                                <input type="text" class="form-control" placeholder="Username" required="" name="usuario"/>
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Password" required="" name="password"  />
                            </div>
                            <div>
                                <button class="btn btn-default submit" type="button" id="btn-ingresar">Iniciar</button>
                            </div>                            
                            <div class="separator">                                
                                <div class="clearfix"></div>
                                <br />
                                <div>
                                    <h1><i class="fa fa-cube"></i> DATA WAREHOUSE</h1>                                    
                                </div>
                            </div>
                            <div id="resp"></div>
                        </form>
                    </section>
                </div>                
            </div>
        </div>
    </body>
</html>
