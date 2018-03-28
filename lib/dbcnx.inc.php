<?php
$db_server = 'localhost';
$db_name = 'gendata';
$db_user = 'root';
$db_password = '';
$db_connect = mysql_connect($db_server, $db_user, $db_password) or trigger_error(mysql_error(),e_user_error);
mysql_select_db($db_name,$db_connect);


?>