<?php
session_start();

//logout operations
include("lib/dbfunctions.php");
$dbobject = new dbobject();
session_destroy();
?>
<script language="javascript">
<!--
window.location= "login.php";
-->
</script>
<?php
exit();
?>
