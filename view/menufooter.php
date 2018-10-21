<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">    
    <a data-toggle="tooltip" data-placement="top" title="FullScreen" onclick="alterna_modo_de_pantalla();">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Logout" href="../controler/destruirSesion.php">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
    <script type="text/javascript">
        function alterna_modo_de_pantalla() {
            if ((document.fullScreenElement && document.fullScreenElement !== null) || // metodo alternativo
                    (!document.mozFullScreen && !document.webkitIsFullScreen)) {               // metodos actuales
                if (document.documentElement.requestFullScreen) {
                    document.documentElement.requestFullScreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullScreen) {
                    document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        }
    </script>
</div>
<!-- /menu footer buttons -->
</div>
</div>