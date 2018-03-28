<?php
include "lib/dbcnx.inc.php"; 
//$_SESSION["role_id_sess"] = "001";
 ?>

<ul class="navigation">
	
<?php
	$role_id = $_SESSION['role_id_sess'];
	//$sql = "select * from menu where menu_level='0' order by menu_order";
	//$sql = "select * from menu where menu_level='0' and menu_id in (select menu_id from menugroup where role_id ='$role_id') order by menu_id asc";
	
$sql = "select * from menu where menu_level='0' and menu_id in (select menu_id from menugroup where role_id ='$role_id') order by menu_id asc";
	
	//echo $sql;
	$result = mysql_query($sql)or die(mysql_error());
	$numrows = mysql_num_rows($result);
	for($i=0; $i<$numrows; $i++){
		$row = mysql_fetch_array($result);
		$menu_id = $row['menu_id'];
		$parent_id = $row['parent_id'];
		$menu_level = $row['menu_level'];
	
	
				
				//$sql_1 = "select * from menu where parent_id = '$menu_id' order by menu_order";
			$sql_1 = "select * from menu where parent_id = '$menu_id' and menu_id in (select menu_id from menugroup where role_id ='$role_id') order by menu_order";
				//echo $sql_1;
				$result_1 = mysql_query($sql_1);
				$numrows_1 = mysql_num_rows($result_1);
				$openable = ($numrows_1>0)?"class = 'openable'":"";
				echo '<li '.$openable.' ><a href="#"><span class="isw-grid"></span><span class="text"> '.$row['menu_name'].'</span></a>';

				if($numrows_1 > 0) {
					echo '<ul>';
					for($j=0; $j<$numrows_1; $j++){
						$row_1 = mysql_fetch_array($result_1);
						$menu_id_1 = $row_1['menu_id'];
						$menu_url_1 = $row_1['menu_url'];
						if($menu_url_1=='')continue;
						//echo "menu_id = ".$menu_id_1;
						//echo $row_1[menu_name];
						echo "<li><a href='#' onclick=\"getpage('$row_1[menu_url]','page')\"><span class='icon-stop'></span><span class='text'>$row_1[menu_name]</span></a></li>";
					} //End 1st level For Loop
				echo "</ul>";
				} // End of $numrows_1 > 0
				echo "</li>";
	} // End of Outer for Loop
?>
   	</ul>