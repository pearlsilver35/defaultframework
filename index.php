<?php
session_start();
if (isset($_SESSION['username_sess']))
{
	echo '<script type="text/javascript">window.location = "home.php"; </script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <!--[if gt IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->
    
    <title>True Worshiper</title>

    <link rel="icon" type="image/png" href="favicon.png"/>
    
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 8]>
        <link href="css/ie7.css" rel="stylesheet" type="text/css" />
    <![endif]-->    
    <link rel='stylesheet' type='text/css' href='css/fullcalendar.print.css' media='print' />
    
    <script type='text/javascript' src='js/libs/jquery/1.7/jquery.min.js'></script>
    <script type='text/javascript' src='js/libs/jqueryui/1.8/jquery-ui.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery.mousewheel.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/cookie/jquery.cookies.2.2.0.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/bootstrap.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/charts/excanvas.min.js'></script>
    <script type='text/javascript' src='js/plugins/charts/jquery.flot.js'></script>    
    <script type='text/javascript' src='js/plugins/charts/jquery.flot.stack.js'></script>    
    <script type='text/javascript' src='js/plugins/charts/jquery.flot.pie.js'></script>
    <script type='text/javascript' src='js/plugins/charts/jquery.flot.resize.js'></script>
    
    <script type='text/javascript' src='js/plugins/sparklines/jquery.sparkline.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/fullcalendar/fullcalendar.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/select2/select2.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/uniform/uniform.js'></script>
    
    <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput-1.3.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/validation/languages/jquery.validationEngine-en.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/plugins/validation/jquery.validationEngine.js' charset='utf-8'></script>
    
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    <script type='text/javascript' src='js/plugins/animatedprogressbar/animated_progressbar.js'></script>
    
    <script type='text/javascript' src='js/plugins/qtip/jquery.qtip-1.0.0-rc3.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/cleditor/jquery.cleditor.js'></script>
    
    <script type='text/javascript' src='js/plugins/dataTables/jquery.dataTables.min.js'></script>    
    
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js'></script>
    
    <script type='text/javascript' src='js/cookies.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/charts.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>
	<script type="text/javascript" src="js/main.js"></script>    
</head>
<body>
    
    <div class="loginBox">
        <div class="bLogo"></div>
        <div class="loginForm">
            <form class="form-horizontal" action="http://aqvatarius.com/themes/aquarius_v13/index.html" method="POST" id="form1">
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><span class="icon-user"></span></span>
                        <input name="userid" type="text" id="userid" placeholder="Username"/>
                    </div>                
                </div>
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><span class="icon-lock"></span></span>
                        <input name="userpassword" id="userpassword" type="password" placeholder="Password" onKeyDown="if (event.keyCode == 13) document.getElementById('button').click()"/>
                    </div>
                </div>
                
                <div class="control-group" id="error_label_login" style="display:none;"></div>
                
                <div class="row-fluid">
                    <div class="span8">
                        <div class="control-group" style="margin-top: 5px;">
                            <label class="checkbox"><input type="checkbox"> Remember me</label>                            
                        </div>                    
                    </div>
                    <div class="span4">
                        <input type="button" id="button"  class="btn btn-block" style="background-image: -moz-linear-gradient(top, #4F7302, #405908);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#4F7302), to(#405908));
        background-image: -webkit-linear-gradient(top, #4F7302, #405908);
        background-image: -o-linear-gradient(top, #4F7302, #405908);
        background-image: linear-gradient(to bottom, #4F7302, #405908);
        background-repeat: repeat-x;
        border-color: #405908 #405908 #000000;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff4F7302', endColorstr='#ff405908', GradientType=0);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);"
        
        onClick="javascript:
                  if($.trim($('#userid').val())==''){
                  $('#error_label_login').html('<div class=\' alert alert-error \'>Username Field is empty...</div>');
                    $('#error_label_login').show();
				  }else if(jQuery.trim($('#userpassword').val())==''){
                  	$('#error_label_login').html('<div class=\' alert alert-error \'>Password Field is empty...</div>');
                    $('#error_label_login').show();
                  }else{
                  	return checklogin('home.php')}; return false; "                   
        
        value = "Sign In" />       
                    </div>
                </div>
            </form>        
            <div class="row-fluid">
             <div class="span1"></div>
                          
            </div>
        </div>
    </div>    
    
</body>

</html>
