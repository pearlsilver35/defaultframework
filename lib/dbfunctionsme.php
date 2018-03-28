<?php
@session_start();
///////////////////	
require_once("lib/dbcnx.inc");
require('lib/desencrypt.php');
//////////////////////
class dbobject 
{
	function begin(){
		@mysql_query("BEGIN");
		}
	function commit(){
		@mysql_query("COMMIT");
		}
	function rollback(){
		@mysql_query("ROLLBACK");
		}
	//////////////////////////////////Generic Script///////////////////////////////////////////////////
	function SaveTransEdit($tbl,$inpFds,$inpFdsVals,$operation)
	{
		$whrcond = 0;
		$resp = 0;
		if($operation == 'new'){
		$query = "insert into ".$tbl." set ";
		$where = "";
		for($i=0;$i<count($inpFds);$i++)
		{	
			$field = explode("-",$inpFds[$i]);
			if($field[1]=='fd')
			{
				$query .= $field[0]."='".$inpFdsVals[$i]."', ";
				//$affected .= $field[0].", ";
				//$updatedVals .= $inpFdsVals[$i]."/";
			}
			elseif($field[1]=='whr' && $whrcond==0)
			{
				$where .= ", ".$field[0]."='".$inpFdsVals[$i]."'";
				$whrcond +=1;
				//$trail_appl = $inpFdsVals[$i];
			}
			elseif($field[1]=='whr' && $whrcond >=1)
			{
				$where .= ", ".$field[0]."='".$inpFdsVals[$i]."'";
				$whrcond +=1;
			}
		}
		$query = rtrim($query,", ");
		$query_data = $query.$where;
		$query_data .=';';
		//echo $query_data;
		//$affected = rtrim($affected,", ");
		//$query1 = "select ".$affected." from ".$tbl.$where.';';
		//echo $query1;
		//$result1 = mysql_query($query1);
		/*while($row=mysql_fetch_array($result1))
		{
			$fdd = explode(", ",$affected);
			for($t=0;$t<count($fdd);$t++)
			{
				$afftd .= $fdd[$t].'/';
				$intVals .= $row[$fdd[$t]].'/';
			}
		}
*/		$daty = @date('Y-m-d H:i:s');
		$officer = $_SESSION['username_sess'];
		$ip = $_SERVER['REMOTE_ADDR'];
		//$query2 = "insert into audit_trail  values('','$tbl','$trail_appl','$afftd','$intVals','$updatedVals','Edit','$daty','$officer','$ip')";
		if(mysql_query($query_data)or die(mysql_error()))
		{
			$resp += 1;
			//if(mysql_query($query2))	$resp += 1;
			//else	$resp = -2;
			
		}
		else	$resp = -1;
		//if(!mysql_error())*/
		return $resp;
		
		}elseif($operation == 'edit'){
		$query = "update ".$tbl." set ";
		$where = "";
		for($i=0;$i<count($inpFds);$i++)
		{	
			$field = explode("-",$inpFds[$i]);
			if($field[1]=='fd')
			{
				$query .= $field[0]."='".$inpFdsVals[$i]."', ";
				//$affected .= $field[0].", ";
				//$updatedVals .= $inpFdsVals[$i]."/";
			}
			elseif($field[1]=='whr' && $whrcond==0)
			{
				$where .= " where ".$field[0]."='".$inpFdsVals[$i]."'";
				$whrcond +=1;
				//$trail_appl = $inpFdsVals[$i];
			}
			elseif($field[1]=='whr' && $whrcond >=1)
			{
				$where .= " and ".$field[0]."='".$inpFdsVals[$i]."'";
				$whrcond +=1;
			}
		}
		$query = rtrim($query,", ");
		$query_data = $query.$where;
		$query_data .=';';
		//$affected = rtrim($affected,", ");
		//$query1 = "select ".$affected." from ".$tbl.$where.';';
		//echo $query_data;
		//$result1 = mysql_query($query1);
		/*while($row=mysql_fetch_array($result1))
		{
			$fdd = explode(", ",$affected);
			for($t=0;$t<count($fdd);$t++)
			{
				$afftd .= $fdd[$t].'/';
				$intVals .= $row[$fdd[$t]].'/';
			}
		}
*/		$daty = @date('Y-m-d H:i:s');
		$officer = $_SESSION['username_sess'];
		$ip = $_SERVER['REMOTE_ADDR'];
		//$query2 = "insert into audit_trail  values('','$tbl','$trail_appl','$afftd','$intVals','$updatedVals','Edit','$daty','$officer','$ip')";
		if(mysql_query($query_data))//or die(mysql_error()))
		{
			$resp += 1;
			//if(mysql_query($query2))	$resp += 1;
			//else	$resp = -2;
			
		}
		else	$resp = -2;
		//if(!mysql_error())*/
		return $resp;
		
		
		}else{echo 'something went wrong'; exit();}
		
		
	}
///////////////////////////////////////////////////////		
	function exister($table,$field1,$field2,$value1,$value2)		
	{
		// counter function=>to return numbers of rows fetched or found
		function counter($resource)	
		{
			return mysql_num_rows($resource);
		}
		//////////////////////////
		$existed = mysql_query("SELECT * FROM $table WHERE $field1='$value1' and $field2='$value2'")or die('Inavlid Exist Query'. mysql_error());
		$no = counter($existed) ;
		return $no;
	}
	

//////-> check user details
	
function getcheckdetails($user,$password) {
	//echo 'country code : '.$countrycode;
	$desencrypt = new DESEncryption();
	$key = $user; //"mantraa360";
	$cipher_password = $desencrypt->des($key, $password, 1, 0, null,null);
	$str_cipher_password = $desencrypt->stringToHex ($cipher_password);
	
	$label = "";
	$table_filter = " where username='".$user."' and password='".$str_cipher_password."'";
	
	$query = "select * from userdata".$table_filter;
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_affected_rows();
	//echo ' num rows :'.$numrows;
	$dbobject = new dbobject();
	$no_of_pin_misses = $dbobject->getitemlabel('parameter','parameter_name','no_of_pin_misses','parameter_value');
	$pin_missed = $dbobject->getitemlabel('userdata','username',$user,'pin_missed');
	$override_wh = $dbobject->getitemlabel('userdata','username',$user,'override_wh');
	$extend_wh = $dbobject->getitemlabel('userdata','username',$user,'extend_wh');
	
	if($numrows > 0){
		@ $ddate = date('w');
		$row = mysql_fetch_array($result);
		
		@ $dhrmin = date('Hi');
		$worktime = $dbobject->getitemlabel('parameter','parameter_name','working_hours','parameter_value');
		//echo $dhrmin;
		if($override_wh=='1'){
		$worktime = $extend_wh;
		}
		$worktimesplit = explode("-",$worktime);
		$lowertime = str_replace(":","",$worktimesplit[0]);
		$uppertime = str_replace(":","",$worktimesplit[1]);
		
		$lowerstatus = ($lowertime < $dhrmin)==''?"0":"1";
		$upperstatus = ($dhrmin < $uppertime)==''?"0":"1";
		
		$pass_dateexpire = $row['pass_dateexpire'];
		@$expiration_date = strtotime($pass_dateexpire);
		@$today = date('Y-m-d');
		@$today_date = strtotime($today);
		
		//echo 'exp date: '.$pass_dateexpire.'   -  today date: '.$today;
		//echo 'Change on Logon : '.$row['passchg_logon'];
		
		if($row['user_disabled']=='1'){
			$label = "2";
		}
		else if($row['user_locked']=='1'){
			$label = "3";
		}
		else if($row['day_1']=='0' && $ddate=='0'){
			//You are not allowed to login on Sunday
			$label = "4";
		}
		else if($row['day_2']=='0' && $ddate=='1'){
			//You are not allowed to login on Monday
			$label = "5";
		}
		else if($row['day_3']=='0' && $ddate=='2'){
			//You are not allowed to login on Tuesday
			$label = "6";
		}
		else if($row['day_4']=='0' && $ddate=='3'){
			//You are not allowed to login on Wednesday
			$label = "7";
		}
		else if($row['day_5']=='0' && $ddate=='4'){
			//You are not allowed to login on Thursday
			$label = "8";
		}
		else if($row['day_6']=='0' && $ddate=='5'){
			//You are not allowed to login on Friday
			$label = "9";
		}
		else if($row['day_7']=='0' && $ddate=='6'){
			//You are not allowed to login on Saturday
			$label = "10";
		}
		else if(!(($lowerstatus==1) && ($upperstatus==1))){
			//You are not allowed to login due to working hours violation
			$label = "11";
		}
		else if($expiration_date <=$today_date){
			$label = "13";
		}
		else if($row['passchg_logon']=='1'){
			$label = "14";
		}
		else {
			$label = "1";
			$_SESSION[username_sess] = $user;
			$_SESSION[role_id_sess] = $row['role_id'];
			$_SESSION[role_name_sess] = $row['role_name'];
			$_SESSION[branch_code_sess] = $row['branch_code'];
			$_SESSION[firstname_sess] = $row['firstname'];
			$_SESSION[lastname_sess] = $row['lastname'];
			$_SESSION[acct_no_sess] = $row['acct_no'];
			
			$_SESSION['agent_login'] = "OK";
			$_SESSION['last_page_load'] = time();
			$_SESSION['processor'] = $user;
			$oper="IN";
			//$audit = $dbobject->doAuditTrail($oper);
			$dbobject->resetpinmissed($user);
		}
		//$label = $user.'|'.$row['role_id'].'|'.$row['role_name'].'|'.$row['branch_code'].'|'.$row['firstname'].'|'.$row['lastname'];
	}else{
		if($no_of_pin_misses==$pin_missed){
			$label = "12";
			$dbobject->updateuserlock($user,'1');
		}else{
		$label = "0";
		$dbobject->updatepinmissed($user);
		}		
	}
	return $label;
	}
	///////////
	
	function updatepinmissed($username){
		$query = "update userdata set pin_missed=pin_missed+1 where username= '$username'";
		//echo $query;
		$resultid = mysql_query($query);
		$numrows = mysql_affected_rows();
	}
	function resetpinmissed($username){
		$query = "update userdata set pin_missed=0 where username= '$username'";
		//echo $query;
		$resultid = mysql_query($query);
		$numrows = mysql_affected_rows();
	}
	function updateuserlock($username,$value){
		$query = "update userdata set user_locked='$value' where username= '$username'";
		//echo $query;
		$resultid = mysql_query($query);
		$numrows = mysql_affected_rows();
	}	
	
	//// select a field from a table
	function getitemlabel($tablename,$table_col,$table_val,$ret_val) {
	$label = "";
	$table_filter = " where ".$table_col."='".$table_val."'";

	$query = "select ".$ret_val." from ".$tablename.$table_filter;
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_affected_rows();
	if($numrows > 0){
		$row = mysql_fetch_array($result);
		$label = $row[$ret_val];
	}
	return $label;
	}
	
	function getitemlabelmenu($tablename,$table_col,$table_val,$ret_val) {
	$label = "";
	$table_filter = " where ".$table_col."='".$table_val."'";

	$query = "select ".$ret_val." from ".$tablename.$table_filter;
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_affected_rows();
	if($numrows > 0){
		while($row = mysql_fetch_array($result)){
		$label .= "'".$row[$ret_val]."',";
		}
		$label = rtrim($label,",");
	}
	return $label;
	}
	
	///////////////
	function loadParameters(){
		$label = "";
		$query = "select * from parameter";
		$result = mysql_query($query);
		$numrows = mysql_num_rows($result);
		for($i=0; $i<$numrows; $i++){
			$row = mysql_fetch_array($result);
			$label = $label .'"'.$row["parameter_name"].'"=>"'.$row["parameter_value"]."\", ";
			$_SESSION[$row["parameter_name"]] = $row["parameter_value"];
		}
		return $label;
	}
	//////////
	function getrecordset($tablename,$table_col,$table_val)
	{
		$label = "";
		$table_filter = " where ".$table_col."='".$table_val."'";
	
		$query = "select * from ".$tablename.$table_filter;
		//echo $query;
		$result = mysql_query($query);
		//$numrows = mysql_num_rows($result);
		/*
		if($numrows > 0){
			$row = mysql_fetch_array($result);
			$label = $row[$ret_val];
		}
		*/
		return $result;
	}
	/////////////////
	function getrecordsetdata($query) {
	$query = $query;
	//echo $query;
	$result = mysql_query($query);
	return $result;
	}
	//////////////////
	function getparentmenu($opt) {
	$filter = "";
	$options = "<option value='#'>::: None ::: </option>";
		 /*
		 if($opt!= ""){
		 $filter = "where menu_id='".$opt."' and parent_id='#' "; //" username='$username' and password='$password' ";
		 }else{
		 */
			$filter = "where parent_id='#' or parent_id2='#'  order by menu_order";
		 //}
	$query = "select distinct menu_id, menu_name from menu  ".$filter;
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	if($numrows > 0){
		for($i=0; $i<$numrows; $i++){
		$row = mysql_fetch_array($result);
		//echo $row['country_code'];
		 if($opt==$row['menu_id']) $filter='selected';
		//echo ($opt=='$row["country_code"]'?'selected':'None');
		$options = $options."<option value='$row[menu_id]' $filter >$row[menu_name]</option>";
		$filter='';
		}
	}
	return $options;
	}
	function getsubmenu($opt) {
		$filter = "";
		$options = "";
			 if($opt!= ""){
			 $filter = "where parent_id='$opt' order by menu_order"; //" username='$username' and password='$password' ";
			 }
		$query = "select distinct menu_id, menu_name from menu  ".$filter;
		//echo $query;
		$result = mysql_query($query);
		$numrows = mysql_num_rows($result);
		if($numrows > 0){
			for($i=0; $i<$numrows; $i++){
			$row = mysql_fetch_array($result);
			$options = $options."<option value='$row[menu_id]' $filter >$row[menu_name]</option>";
			$filter='';
			}
		}
		return $options;
		}
	////////////////////////////////////
		function reorder_submenu($parent_menu,$sub_menu){
		$num_count = 0;
		$sub_menu_arr = explode(',',$sub_menu);
		for($i=0; $i<sizeof($sub_menu_arr); $i++){
			$query = "update menu set menu_order=$i where menu_id= '$sub_menu_arr[$i]'";
			//echo $query;
			$result = mysql_query($query);
			$num_count+=mysql_affected_rows();
		}
			return $num_count;
		}
		///////////////////////////////////
	function validatepassword($user,$password){
	//echo 'country code : '.$countrycode;
	$desencrypt = new DESEncryption();
	$key = $user; //"mantraa360";
	$cipher_password = $desencrypt->des($key, $password, 1, 0, null,null);
	$str_cipher_password = $desencrypt->stringToHex ($cipher_password);
	
	$label = "";
	$table_filter = " where username='".$user."' and password='".$str_cipher_password."'";

	$query = "select * from userdata".$table_filter;
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	if($numrows > 0) $label = "1";
	else $label = "-1";	
	
	return $label;
	}
	
	// Change to user profile password
	function doPasswordChange($username,$user_password){
			$desencrypt = new DESEncryption();
			$key = $username;
			$cipher_password = $desencrypt->des($key, $user_password, 1, 0, null,null);
			$str_cipher_password = $desencrypt->stringToHex ($cipher_password);
		$query_data ="update userdata set password='$str_cipher_password' where username= '$username'";
			//echo $query_data;
			$result_data = mysql_query($query_data);
			$count_entry = mysql_affected_rows();
			
			return $count_entry;
	}
	function pick_role($opt) {
	$filter = "";
	$options = "<option value=''>::: Select a Role ::: </option>";
	/*
	if($opt!= ""){
	 $filter = "where role_id='".$opt."'"; //" username='$username' and password='$password' ";
	 }
	 */
	$dbobject = new dbobject();
	$user_role_session = $_SESSION['role_id_sess'];
	//$filter_role_id = $dbobject->getitemlabel('parameter','parameter_name','admin_code','parameter_value');
	//$filteradmin = ($user_role_session == $filter_role_id)?"":" and role_id not in ('".$filter_role_id."')";
	$query = "select distinct role_id, role_name from role where role_id <> '030' AND role_id <> '020'";//.$filteradmin;
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	if($numrows > 0){
		for($i=0; $i<$numrows; $i++){
		$row = mysql_fetch_array($result);
		//echo $row['country_code'];
		 if($opt==$row['role_id']) $filter='selected';
		//echo ($opt=='$row["country_code"]'?'selected':'None');
		$options = $options."<option value='$row[role_id]' $filter >$row[role_name]</option>";
		$filter='';
		}
	}
	return $options;
	}
	////////////////////////
	function doRole($role_id,$role_name,$enable_role){
			$count_entry = 0;
			$query = "select * from role  where role_id='$role_id'";
			//echo $query;
			$result = mysql_query($query);
			$numrows = mysql_num_rows($result);
			if($numrows >=1){
				$query_data ="update role set role_name='$role_name', role_enabled='$enable_role' where role_id='$role_id' ";
			$result_data = mysql_query($query_data);
			$count_entry = mysql_affected_rows();
			}
			else
			{
			$query_data = "insert into role (role_id,role_name,role_enabled,created) values( '$role_id','$role_name','$enable_role',now())";
			//echo $query_data;
			$result_data = mysql_query($query_data);
			$count_entry = mysql_affected_rows();
			}
			return $count_entry;
		}
		
function doUser($operation,$username,$userpassword,$firstname,$lastname,$email,$phone, $chgpword_logon, $user_locked, $user_disable,$day_1,$day_2,$day_3,$day_4,$day_5,$day_6,$day_7,$override_wh,$extend_wh,$role_id,$role_name,$merchant_id,$user_type){
			$desencrypt = new DESEncryption();
			$count_entry = 0;
			$key = $username;
			$cipher_password = $desencrypt->des($key, $userpassword, 1, 0, null,null);
			$str_cipher_password = $desencrypt->stringToHex ($cipher_password);
			
			$query = "select * from userdata  where username='$username'";
			//echo $query;
			$result = mysql_query($query);
			$numrows = mysql_num_rows($result);
			if($numrows >=1 && $operation=='new'){
				$count_entry = -9;
			}
			else
			{
				if($numrows >=1){
					$addquery = $user_locked=='0'?",pin_missed=0":"";
					$query_data ="update userdata set password='$str_cipher_password', role_id='$role_id', firstname='$firstname', lastname='$lastname', email='$email', mobile_phone='$phone', passchg_logon='$chgpword_logon', user_disabled='$user_disable', user_locked='$user_locked', day_1='$day_1', day_2='$day_2', day_3='$day_3', day_4='$day_4', day_5='$day_5', day_6='$day_6', day_7='$day_7', modified=now(), user_type='$user_type', merchant_id='$merchant_id', override_wh='$override_wh', extend_wh='$extend_wh' $addquery where username='$username'";
					//echo $query_data;
				$result_data = mysql_query($query_data);//or die(mysql_error());
				//echo mysql_error();
				$count_entry = mysql_affected_rows();
				}
				else
				{
				$pass_expiry_days = $_SESSION['password_expiry_days'];
				$today = @date("Y-m-d");
				$pass_dateexpire = @date("Y-m-d",strtotime($today."+".$pass_expiry_days."days"));
				$query_data = "insert into userdata (username,password,role_id, firstname, lastname, email, mobile_phone, passchg_logon, user_disabled, user_locked,day_1,day_2,day_3,day_4,day_5,day_6,day_7,created, modified,override_wh,extend_wh,pass_dateexpire,user_type,merchant_id) values( '$username','$str_cipher_password','$role_id', '$firstname','$lastname','$email','$phone','$chgpword_logon','$user_disable','$user_locked','$day_1', '$day_2', '$day_3', '$day_4', '$day_5', '$day_6', '$day_7' , now(), now(), '$override_wh', '$extend_wh', '$pass_dateexpire','$user_type','$merchant_id')";
				//echo $query_data;
				$result_data = mysql_query($query_data);//or die(mysql_error());
				$count_entry = mysql_affected_rows();
				} //End inner else
			} // End Else
			return $count_entry;
		}
		//////////////////////////////////////////////
		
		
		
		function paddZeros($id, $length){
		$data = "";
		$zeros = "";
		$rem_len = $length - strlen($id);

		if($rem_len > 0){
			for($i=0; $i<$rem_len; $i++){
				$zeros.="0";
			}
			$data = $zeros.$id;
		}else{
			$data = $id;
		}
		return $data;
	}
	
	///////////////////////////////
	function getnextid($tablename){
	//require_once("../../Copy of acomoran/lib/connect.php");
	$id = 0;
	$query = "update gendata set table_id=table_id+1 where table_name= '$tablename'";
	//echo $query;
	$resultid = mysql_query($query);
	$numrows = mysql_affected_rows();
	//echo 'result '.$resultid;
	if($numrows==0){
		$query_ins = "insert into gendata values ('$tablename', 1)";
		//echo $query_ins;
		$result_ins = mysql_query($query_ins);
		$numrows = mysql_affected_rows();
	}
	// Get the new id
	$query_sel = "select table_id from gendata where table_name= '$tablename'";
	//echo $query;
	$result_sel = mysql_query($query_sel);
	$numrows_sel = mysql_num_rows($result_sel);
		if($numrows_sel==1){
			$row = mysql_fetch_array($result_sel);
			$id = $row['table_id'];
			
			//result count when it reaches 
			if($id > 999998){
				$query = "update gendata set table_id=table_id+1 where table_name= '$tablename'";
				//echo $query;
				$resultid = mysql_query($query);
			}
		}

	return $id;
	}
	//////////////////////////////////////////
	function getuniqueid($y, $m, $d){
		$month_year = array ('01' => '025',
						'02' => '468',
						'03' => '469',
						'04' => '431',
						'05' => '542',
						'06' => '790',
						'07' => '138',
						'08' => '340',
						'09' => '356',
						'10' => '763',
						'11' => '845',
						'12' => '890');
		$year = array('2009' => '111',
				'2010' => '222',
				'2011' => '333',
				'2012' => '444',
				'2013' => '555',
				'2014' => '777',
				'2015' => '000',
				'2016' => '666',
				'2017' => '999',
				'2018' => '123',
				'2019' => '321',
				'2020' => '431',
				'2021' => '521',
				'2022' => '146',
				'2023' => '246',
				'2024' => '357',
				'2025' => '768',
				'2026' => '430',
				'2027' => '770',
				'2028' => '773',
				'2029' => '873',
				'2030' => '962',
				'2031' => '909',
				'2032' => '830',
				'2033' => '349',
				'2034' => '457',
				'2035' => '248');

		$day = array('01' => '50',
				'02' => '31',
				'03' => '23',
				'04' => '12',
				'05' => '54',
				'06' => '67',
				'07' => '87',
				'08' => '90',
				'09' => '11',
				'10' => '34',
				'11' => '22',
				'12' => '38',
				'13' => '88',
				'14' => '78',
				'15' => '33',
				'16' => '54',
				'17' => '67',
				'18' => '77',
				'19' => '29',
				'20' => '59',
				'21' => '17',
				'22' => '32',
				'23' => '44',
				'24' => '66',
				'25' => '00',
				'26' => '04',
				'27' => '05',
				'28' => '03',
				'29' => '08',
				'30' => '20',
				'31' => '45');

	$unique_id = $year[$y].$month_year[$m].$day[$d];
	return $unique_id;
	}
	
	//////////////////////////////////////////
	function doMenu($menu_id,$menu_name,$menu_url,$parent_menu,$menu_level,$parent_menu2){
			$count_entry = 0;
			$query = "select * from menu  where menu_id='$menu_id'";
			//echo $query;
			$result = mysql_query($query);
			$numrows = mysql_num_rows($result);
			if($numrows >=1){
				$query_data ="update menu set menu_name='$menu_name', menu_url='$menu_url', parent_id='$parent_menu',  parent_id2='$parent_menu2', menu_level='$menu_level' where menu_id='$menu_id' ";
			//echo $query_data;
			$result_data = mysql_query($query_data);
			$count_entry = mysql_affected_rows();
			}
			else
			{
			$query_data = "insert into menu (menu_id,menu_name,menu_url,parent_id,parent_id2,menu_level,created) values( '$menu_id','$menu_name','$menu_url','$parent_menu','$parent_menu2','$menu_level',now())";
			//echo $query_data;
			$result_data = mysql_query($query_data);
			$count_entry = mysql_affected_rows();
			}
			return $count_entry;
		}
		/////////////////////////////////////////////////////////
	function getmenu($opt) {
	$filter = "";
	$options = "<option value='#'>::: Select Menu Option ::: </option>";
		 if($opt!= ""){
		 $filter = " and menu_id='".$opt."' "; //" username='$username' and password='$password' ";
		 }
		 $filter .=" order by menu_name ";
		 $dbobject = new dbobject();
	 $user_role_session = $_SESSION['role_id_sess'];
	 //$filter_role_id = $dbobject->getitemlabel('parameter','parameter_name','admin_code','parameter_value');
	 //$filter_menu_id = $dbobject->getitemlabelmenu('parameter','parameter_name','admin_menu_code','parameter_value');
	 //$filteradmin = ($user_role_session == $filter_role_id)?"":" and menu_id not in (".$filter_menu_id.")";
	$query = "select distinct menu_id, menu_name from menu where 1=1 ".$filter;
	//echo $query;
	$result = mysql_query($query);
	$numrows = @mysql_num_rows($result);
	if($numrows > 0){
		for($i=0; $i<$numrows; $i++){
		$row = mysql_fetch_array($result);
		//echo $row['country_code'];
		 if($opt==$row['menu_id']) $filter='selected';
		//echo ($opt=='$row["country_code"]'?'selected':'None');
		$options = $options."<option value='$row[menu_id]' $filter >$row[menu_name]</option>";
		$filter='';
		}
	}
	return $options;
	}
	/////////////////////////////////
	function getexistrole($opt) {
	$filter = "";
	//$options = "<option value='#'>::: Select Menu Option ::: </option>";
		 if($opt!= ""){
		 $filter = "where menu_id='".$opt."' "; //" username='$username' and password='$password' ";
		 }
	$query = "select role_id, role_name from role where role_id in (select role_id from menugroup   ".$filter.")";
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	if($numrows > 0){
		for($i=0; $i<$numrows; $i++){
		$row = mysql_fetch_array($result);
		//echo $row['country_code'];
		 //if($opt==$row['role_id']) $filter='selected';
		//echo ($opt=='$row["country_code"]'?'selected':'None');
		$options = $options."<option value='$row[role_id]' $filter >$row[role_name]</option>";
		$filter='';
		}
	}
	return $options;
	}
	///////////////////////////////////////////
	function getnonexistrole($opt) {
	$filter = "";
	//$options = "<option value='#'>::: Select Menu Option ::: </option>";
		 if($opt!= ""){
		 $filter = "where menu_id='".$opt."' "; //" username='$username' and password='$password' ";
		 }
	$query = "select role_id, role_name from role where role_id not in (select role_id from menugroup   ".$filter.")";
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	if($numrows > 0){
		for($i=0; $i<$numrows; $i++){
		$row = mysql_fetch_array($result);
		//echo $row['country_code'];
		 //if($opt==$row['role_id']) $filter='selected';
		//echo ($opt=='$row["country_code"]'?'selected':'None');
		$options = $options."<option value='$row[role_id]' $filter >$row[role_name]</option>";
		$filter='';
		}
	}
	return $options;
	}
	
	function doMenuGroup($menu_id,$exist_role){
			$count_entry = 0;
			$exist_role_arr = explode(",",$exist_role);
			$role_id = "";
			for($i=0; $i<count($exist_role_arr); $i++){
			$role_id = $role_id."'".$exist_role_arr[$i]."', ";
			}
			$role_id = substr($role_id,0,(strlen($role_id)-2));
			$query_data ="delete from menugroup where role_id not in ($role_id) and menu_id='$menu_id' ";
			//echo $query_data.'<br>';
			$result_data = mysql_query($query_data);
			$count_entry += mysql_affected_rows();

			for($i=0; $i<count($exist_role_arr); $i++){
			$query_data_i = "insert into menugroup values ('$exist_role_arr[$i]','$menu_id')";
			//echo $query_data_i.'<br>';
			$result_data_i = mysql_query($query_data_i);
			$count_entry += mysql_affected_rows();
			}

			echo "Count Entry :: "+$count_entry;
			return $count_entry;
		}
		////////////////////////////////////////////////

		function gettableselect($tablename, $field1, $field2, $opt) {
	$filter = "";
	$options = "<option value=''>::: please select option ::: </option>";
	$query = "select distinct $field1, $field2 from $tablename  ".$filter;
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	if($numrows > 0){
		for($i=0; $i<$numrows; $i++){
		$row = mysql_fetch_array($result);
		//echo $row['country_code'];
		 if($opt==$row[$field1]) $filter='selected';
		//echo ($opt=='$row["country_code"]'?'selected':'None');
		$options = $options."<option value='$row[$field1]' $filter >$row[$field2]</option>";
		$filter='';
		}
	}
	return $options;
	}
	///////////////////////////////////
	function gettableselectorder($tablename, $field1, $field2, $opt,$order) {
	$filter = "";
	$order_by = "";
	$options = "<option value=''>::: please select option ::: </option>";
	if($order!='') $order_by = " order by ".$order;
	$query = "select distinct $field1, $field2 from $tablename  ".$filter.$order_by ;
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	if($numrows > 0){
		for($i=0; $i<$numrows; $i++){
		$row = mysql_fetch_array($result);
		//echo $row['country_code'];
		 if($opt==$row[$field1]) $filter='selected';
		//echo ($opt=='$row["country_code"]'?'selected':'None');
		$options = $options."<option value='$row[$field1]' $filter >$row[$field2]</option>";
		$filter='';
		}
	}
	return $options;
 }
	/////////////////////////////////////
	function getdataselect($sql) {
	$filter = "";
	$options = "<option value=''>::: please select option ::: </option>";
	//$query = "select distinct $field1, $field2 from $tablename  ".$filter;
	//echo $sql;
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
	if($numrows > 0){
		for($i=0; $i<$numrows; $i++){
		$row = mysql_fetch_array($result);
		$options = $options."<option value='$row[0]' $filter >$row[1]</option>";
		$filter='';
		}
	}
	return $options;
	}

	
	function getTblField($tablename,$field1,$field2,$field3) {
		$query = "select distinct $field1 from $tablename  where $field2='$field3'";
		//echo $query;
		$result = mysql_query($query);
		$numrows = mysql_num_rows($result);
		if($numrows > 0){
			$row = mysql_fetch_array($result);
			$options = $row[$field1];
		}
		return $options;
	}
	
	function getTblItemList($tablename,$field1) {
	$options = "<option value=''>::: please select option ::: </option>";
		$query = "select distinct $field1 from $tablename";
		//echo $query;
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)){
			$options .= "<option value='$row[$field1]'>$row[$field1]</option>";
		}
		return $options;
	}
	
	function getFormInput($tablename,$field2,$field3,$field4,$field5){
		$query = "select * from $tablename  where $field2='$field3' and $field4='$field5'";
		//echo $query;
		$result = mysql_query($query);
		//$numrows = mysql_num_rows($result);
		/*while($row = mysql_fetch_array($result)){
			$options .= "<input type='checkbox' name='<?php echo $row[$field1]; ?>' id='<?php echo $row[$field1]; ?>'> ".$row[$field]."  &nbsp;&nbsp;&nbsp;&nbsp;".$row[$field1]."<br /><hr></hr>";
		}*/
		return $result;
	}
	
	
	
	function doPasswordChangeExp($username,$user_password, $new_expdate){
				$desencrypt = new DESEncryption();
				$count_entry = 0;
				$key = $username;
				$cipher_password = $desencrypt->des($key, $user_password, 1, 0, null,null);
				$str_cipher_password = $desencrypt->stringToHex ($cipher_password);
			$query_data ="update userdata set password='$str_cipher_password', pass_dateexpire='$new_expdate' where username= '$username'";
				//echo $query_data;
				$result_data = mysql_query($query_data);
				$count_entry = mysql_affected_rows();
				
				return $count_entry;
		}
		///////////////////////////////
		// Do password change on logon
		function doPasswordChangeLogon($username,$user_password){
				$desencrypt = new DESEncryption();
				$count_entry = 0;
				$key = $username;
				$cipher_password = $desencrypt->des($key, $user_password, 1, 0, null,null);
				$str_cipher_password = $desencrypt->stringToHex ($cipher_password);
				$query_data ="update userdata set password='$str_cipher_password', passchg_logon='0' where username= '$username'";
				//echo $query_data;
				$result_data = mysql_query($query_data);
				$count_entry = mysql_affected_rows();
				
				return $count_entry;
		}

	
	function getparameter($opt,$parameter_id,$parameter_table,$parameter_col,$val1) {
	$filter = "";
	$options = "<option value=''>::: Select ::: </option>";
		 /*
		 if($opt!= ""){
		 $filter = "where menu_id='".$opt."' and parent_id='#' "; //" username='$username' and password='$password' ";
		 }else{
		 */$filter1 = "";
			if($parameter_id!=''){$filter1= "and  ".$parameter_col." = '$parameter_id' ";}
			$filter = " where 1=1 ";
		 //}
	$query = "select * from ".$parameter_table.$filter.$filter1;
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	$filter='';
	if($numrows > 0){
		for($i=0; $i<$numrows; $i++){
		$row = mysql_fetch_array($result);
		//echo $row['country_code'];
		 if($opt==$row[$val1]) $filter='selected';
		//echo ($opt=='$row["country_code"]'?'selected':'None');
		$options = $options."<option value='$row[$val1]' $filter >$row[$val1]</option>";
		$filter='';
		}
	}
	return $options;
	}


////////////////////////////////////////////////////////////////BEGIN CodeEngine SAMABOS/////////////////////////////////////////////////////////

function doUserAll($username,$userpassword,$surname,$othernames,$address,$email,$phone, $chgpword_logon, $user_locked, $user_disable,$day_1,$day_2,$day_3,$day_4,$day_5,$day_6,$day_7,$override_wh,$extend_wh,$role_id,$role_name,$sex,$title,$uqid,$security_question,$security_answer)
{
			$dbobject = new dbobject();
			$desencrypt = new DESEncryption();
			$count_entry = 0;
			$key = $username;
			$cipher_password = $desencrypt->des($key, $userpassword, 1, 0, null,null);
			$str_cipher_password = $desencrypt->stringToHex ($cipher_password);
			
			$key = $dbobject->getitemlabel('parameter','parameter_name','actvt','parameter_value');
			$user_uqid = $username."~".$uqid;
			$user_uqid = $desencrypt->des($key, $user_uqid, 1, 0, null,null);
			$encrptuqid = $desencrypt->stringToHex ($user_uqid);
			
			
			$query = "select * from userdata  where username='$username'";
			//echo $query;
			$result = mysql_query($query);
			$numrows = mysql_num_rows($result);
			if(($numrows)>=(1))
			{
				$count_entry = 2;
			}
			else
			{
				$pass_expiry_days = $_SESSION['password_expiry_days'];
				$today = @date("Y-m-d");
				$pass_dateexpire = @date("Y-m-d",strtotime($today."+".$pass_expiry_days."days"));
				$query_data = "insert into userdata(username, password, role_id, firstname, lastname, address, gender, title, email, mobile_phone, passchg_logon, user_disabled, user_locked, day_1, day_2, day_3, day_4, day_5, day_6, day_7, created, modified, override_wh, extend_wh, pass_dateexpire, login_status, activation_code,hint_question,hint_answer) values ('$username', '$str_cipher_password', '$role_id', '$othernames', '$surname', '$address', '$sex', '$title', '$username', '$phone', '$chgpword_logon', '$user_disable', '$user_locked', '$day_1', '$day_2', '$day_3', '$day_4', '$day_5', '$day_6', '$day_7' , now(), now(), '$override_wh', '$extend_wh', '$pass_dateexpire', '0', '$encrptuqid', '$security_question', '$security_answer')";
				//echo $query_data;
				$result_data = mysql_query($query_data) or die(mysql_error());
				if ((mysql_affected_rows())>0)
				{
					$query_data2 = "insert into customer_balance(username, previous_balance, current_balance, created) values ('$username', 0, 0, now())";
					//echo $query_data;
					$result_data = mysql_query($query_data2) or die(mysql_error());
					$count_entry = mysql_affected_rows();
					if (($count_entry)>0)
					{
						$resp = $dbobject->sendEmail($encrptuqid);
						//code to send an email here
					
					}
				}
				
			} // End Else
			return $count_entry;
		}	
		
function sendEmail($encrptuqid){
	
	$fp = fopen('https://www.vuvaa.com/demo/email.txt','rb');
	//$fp = fopen('email.txt','rb');
	$contents = stream_get_contents($fp);
	fclose($fp);
	
	
	
	$actvt = "https://www.vuvaa.com/demo/_actvt_".$encrptuqid;
	
	////////////////////////////////////////////////////////////////////////
	//$valitem_unit = number_format($valitem_unit,2);
	$contents = str_replace('#actvt',$actvt,$contents);
	///////////////////////////////////////////////////////////////////////
	//////////////////////////////Prepare Header//////////////////////////
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
	$headers .= 'From: VUVAA <info@vuvaa.com>' . "\r\n";
	//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
	//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
	///////////////////////////////////////////////////////////////////////
	//echo $contents;
	return @mail($email,'VUVAA Customer Information', $contents, $headers); 
						
	}
			
function getuniqueid2()
{
	$month_year = array ('01' => '025',
						'02' => '468',
						'03' => '469',
						'04' => '431',
						'05' => '542',
						'06' => '790',
						'07' => '138',
						'08' => '340',
						'09' => '356',
						'10' => '763',
						'11' => '845',
						'12' => '890');
		
	$year = array('2009' => '111',
				'2010' => '222',
				'2011' => '333',
				'2012' => '444',
				'2013' => '555',
				'2014' => '777',
				'2015' => '000',
				'2016' => '666',
				'2017' => '999',
				'2018' => '123',
				'2019' => '321',
				'2020' => '431',
				'2021' => '521',
				'2022' => '146',
				'2023' => '246',
				'2024' => '357',
				'2025' => '768',
				'2026' => '430',
				'2027' => '770',
				'2028' => '773',
				'2029' => '873',
				'2030' => '962',
				'2031' => '909',
				'2032' => '830',
				'2033' => '349',
				'2034' => '457',
				'2035' => '248');

	$day = array('01' => '50',
				'02' => '31',
				'03' => '23',
				'04' => '12',
				'05' => '54',
				'06' => '67',
				'07' => '87',
				'08' => '90',
				'09' => '11',
				'10' => '34',
				'11' => '22',
				'12' => '38',
				'13' => '88',
				'14' => '78',
				'15' => '33',
				'16' => '54',
				'17' => '67',
				'18' => '77',
				'19' => '29',
				'20' => '59',
				'21' => '17',
				'22' => '32',
				'23' => '44',
				'24' => '66',
				'25' => '00',
				'26' => '04',
				'27' => '05',
				'28' => '03',
				'29' => '08',
				'30' => '20',
				'31' => '45');
	//////////////--------> get 2day's date		
	$today_date = @date('Y-m-d');
	$date_arr = explode("-",$today_date);
	$unique_id = $year[$date_arr[0]].$month_year[$date_arr[1]].$day[$date_arr[2]];
	return $unique_id;
}
	



function saveTransEntry($inpFds,$inpFdsVals)
{
		$dbobject = new dbobject();

		$daty = @date('Y-m-d H:i:s');
		if(isset($_SESSION['username_sess']) && !isset($_SESSION['vuvaa_customer_username_sess']))
		{
			$officer = $_SESSION['username_sess'];
		}elseif(isset($_SESSION['vuvaa_customer_username_sess']))
		{
			$officer = $_SESSION['vuvaa_customer_username_sess'];
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		
		////////////////////////////////////////////////////////transaction table/////////////////////////////////////////
		$itmcd = $_REQUEST['itmcd'];	
		//$merharr = explode('-',$itmcd);
		$merchant_id = $_SESSION[uniquemID];
		//$col_1 = $_REQUEST['col_1-fd'];
		if($itmcd=='#')
		{
			$amount = $_REQUEST['amount'];	
			$desc = "Purchase from ".$merchant_id;
		}else{
			$amount = $dbobject->getitemlabel('merchant_item_setup','item_code','ACC-VMCHT'.$itmcd,'item_value');
			$desc = "Purchase "."ACC-VMCHT".$itmcd;
		}
		$itmdecs = $dbobject->getitemlabel('merchant_item_setup','item_code',$itmcd,'item_name');
		$trans_id = $_REQUEST['trans_ext_id-fd'];
		$trans_type = 'MPMT';
		
		
		$query_trans = "INSERT INTO transaction_table SET transaction_id='$trans_id', transaction_desc='$desc', trans_type = '$trans_type', transaction_amount='$amount', response_code='0', payment_mode='', posted_ip='$ip', created='$daty', posted_user='$officer'";
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		///////////////////////////////////// for transaction extention table///////////////
		$whrcond = 0;
		$resp = 0;
		$query = "insert into transaction_extension set merchant_id = '$merchant_id', ";
		//$where = "";
		for($i=0;$i<count($inpFds);$i++)
		{	
			$field = explode("-",$inpFds[$i]);
			if($field[1]=='fd')
			{
				$query .= $field[0]."='".$inpFdsVals[$i]."', ";
			}
		}
		$query = rtrim($query,", ");
		$query_transext = $query;
		$query_transext .=';';
		/////////////////////////////////////////////////////end of transaction extention table///////////////////////////		
		@mysql_query("BEGIN");
		
		$result_transext = @mysql_query($query_transext);
		if(!$result_transext){@mysql_query("ROLLBACK"); exit("ERORR:Please contact Customer Care OR refresh and try again");}
		
		$result_trans = @mysql_query($query_trans);
		if(!$result_trans){@mysql_query("ROLLBACK"); exit("ERORR:Please contact Customer Care OR refresh and try again");}
		
		//@mysql_query("ROLLBACK");
		@mysql_query("COMMIT");
			$resp = "SUCCESSFUL:Please wait you will be redirected in a moment";
		
		return $resp;
}





function getitemcount($tablename,$table_col,$table_val,$ret_val) {
	$label = "";
	$table_filter = " where ".$table_col."='".$table_val."'";

	$query = "select Count(".$ret_val.") counter from ".$tablename.$table_filter;
	//echo $query;
	$result = mysql_query($query);//or die(mysql_error());
	$numrows = mysql_num_rows($result);
	if($numrows > 0){
		$row = mysql_fetch_array($result);
		$label = $row['counter'];
	}
	return $label;
	}

	

////////////////////////////////////////////////////////////////END CodeEngine SAMABOS///////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////
//////////////////////////Beginning of Isaiah///////////////////////////////
	function getrecordsetArr($tablename,$table_col_arr,$table_val_arr)
	{
		$where_clause = " ";
		for($i=0;$i<count($table_col_arr);$i++)
		{
			$where_clause .=$table_col_arr[$i]."='".$table_val_arr[$i]."' and ";
		}
		
		$where_clause = rtrim($where_clause," and ");
		//echo 'country code : '.$countrycode;
		$label = "";
		$table_filter = " where ".$where_clause;
	
		$query = "select * from ".$tablename.$table_filter;
		//echo $query;
		$result = mysql_query($query);
		return $result;
	}
	
	function getrecordsetArrLim($tablename,$table_col_arr,$table_val_arr,$limval,$orderby_arr,$orderdir)
	{
		$where_clause = " ";
		for($i=0;$i<count($table_col_arr);$i++)
		{
			$where_clause .=$table_col_arr[$i]."='".$table_val_arr[$i]."' and ";
		}
			$table_order='';
			if($orderby_arr!=''){
					for($i=0;$i<count($orderby_arr);$i++)
					{
						$orderby_str .=$orderby_arr[$i].", ";
					}
					
					$orderby_str = rtrim($orderby_str,",");
					$table_order = " ORDERBY ".$orderby_str." ".$orderdir;
			}
		$where_clause = rtrim($where_clause," and ");
		//echo 'country code : '.$countrycode;
		$label = "";
		$table_filter = " where ".$where_clause.$table_order." LIMIT ".$limval;
	
		$query = "select * from ".$tablename.$table_filter;
		//echo $query;
		$result = mysql_query($query);
		return $result;
	}
	
	function getTableSelectArr($tablename,$selarr,$whrarr,$whrvalarr,$order,$orderdir,$opt,$initOpt)
	{
		$filter = $opt;
		$selectVar = " ";
		$whereClause = " where ";
		for($i=0;$i<count($selarr);$i++)
		{
			$selectVar .=$selarr[$i].", ";
			if($i==0){
			$optDisplayVal = $selarr[$i];
			}else
			{
				$optDisplayName .= $row[$selarr[$i]];
			}
		}
		$selectVar = rtrim($selectVar,', ');
		
		for($i=0;$i<count($whrarr);$i++)
		{
			$whereClause .=$whrarr[$i]."='".$whrvalarr[$i]."' and ";
		}
		
		$whereClause = rtrim($whereClause," and ");
		if($order!='')
		{ 
			if($orderdir=='')
			{
				$oderby = 'order by '.$order.' asc';
			}else
			{
				$oderby = 'order by '.$order.' '.$orderdir;
			}
		}
		else $oderby ="";
		$options = "<option value='#'>::: Please Select ".$initOpt." :::</option>";
		$query = "select distinct $selectVar from $tablename ".$whereClause.$oderby;
		//echo $query.'-'.$opt;
		$result = mysql_query($query);
		$numrows = mysql_num_rows($result);
		if($numrows > 0){
			for($i=0; $i<$numrows; $i++){
			$row = mysql_fetch_array($result);
			for($j=0;$j<count($selarr);$j++)
			{
				if($j>0){
					$optDisplayName .= $row[$selarr[$j]]." ";
				}
			}
			 if($opt==$row[$optDisplayVal]) $filter='selected';
			//echo ($opt=='$row["country_code"]'?'selected':'None');
			$options = $options."<option value='$row[$optDisplayVal]' $filter >$optDisplayName</option>";
			$filter='';
			$optDisplayName ="";
			//echo 'yes'.$optDisplayName;
			//echo $row[$field1];
			}
	}
	
	return $options;
	}

////////////////////////////dbfunctions by Isaiah/////////////////////////////////////

	function getMerchantPayInfo($transId)
	{
		
		$query = "select a.merchant_name namme, a.merchant_logo loggo, b.role_id rrole, c.transaction_desc description,c.created pdate from merchant_reg a, userdata b, transaction_table c where a.merchant_id=b.merchant_id and b.username=c.destination_acct  and  c.transaction_id='$transId'";
		//echo $query;
		$result = mysql_query($query);
		if(mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			return $row['namme']."::".$row['loggo']."::".$row['description']."::".$row['pdate']."::".$row['rrole'];
		}else
		{
			return " ";
		}
	}
	
	function getPayInfo($transId)
	{
		
		$query = "select transaction_desc,transaction_amount,created, posted_user from transaction_table where transaction_id='$transId'";
		//echo $query;
		$result = mysql_query($query);
		if(mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			return $row['transaction_desc']."::".$row['transaction_amount']."::".$row['posted_user']."::".$row['created'];
		}else
		{
			return " ";
		}
	}
	
	
	function getCustomersDetails($user,$password)
	{
	//echo 'country code : '.$countrycode;
	$desencrypt = new DESEncryption();
	$key = $user; //"mantraa360";
	$cipher_password = $desencrypt->des($key, $password, 1, 0, null,null);
	$str_cipher_password = $desencrypt->stringToHex ($cipher_password);
	
	$label = "";
	$table_filter = " where username='".$user."' and password='".$str_cipher_password."'";
	
	$query = "select * from userdata".$table_filter;
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_affected_rows();
	//echo ' num rows :'.$numrows;
	$dbobject = new dbobject();
	$no_of_pin_misses = $dbobject->getitemlabel('parameter','parameter_name','no_of_pin_misses','parameter_value');
	$pin_missed = $dbobject->getitemlabel('userdata','username',$user,'pin_missed');
	$override_wh = $dbobject->getitemlabel('userdata','username',$user,'override_wh');
	$extend_wh = $dbobject->getitemlabel('userdata','username',$user,'extend_wh');
	
	if($numrows > 0)
	{
		@ $ddate = date('w');
		$row = mysql_fetch_array($result);
		
		@ $dhrmin = date('Hi');
		$worktime = $dbobject->getitemlabel('parameter','parameter_name','working_hours','parameter_value');
		//echo $dhrmin;
		if($override_wh=='1'){
		$worktime = $extend_wh;
		}
		$worktimesplit = explode("-",$worktime);
		$lowertime = str_replace(":","",$worktimesplit[0]);
		$uppertime = str_replace(":","",$worktimesplit[1]);
		
		$lowerstatus = ($lowertime < $dhrmin)==''?"0":"1";
		$upperstatus = ($dhrmin < $uppertime)==''?"0":"1";
		
		$pass_dateexpire = $row['pass_dateexpire'];
		@$expiration_date = strtotime($pass_dateexpire);
		@$today = date('Y-m-d');
		@$today_date = strtotime($today);
		
		//echo 'exp date: '.$pass_dateexpire.'   -  today date: '.$today;
		//echo 'Change on Logon : '.$row['passchg_logon'];
		
		if($row['user_disabled']=='1'){
			$label = "2";
		}
		else if($row['user_locked']=='1'){
			$label = "3";
		}
		else if($row['day_1']=='0' && $ddate=='0'){
			//You are not allowed to login on Sunday
			$label = "4";
		}
		else if($row['day_2']=='0' && $ddate=='1'){
			//You are not allowed to login on Monday
			$label = "5";
		}
		else if($row['day_3']=='0' && $ddate=='2'){
			//You are not allowed to login on Tuesday
			$label = "6";
		}
		else if($row['day_4']=='0' && $ddate=='3'){
			//You are not allowed to login on Wednesday
			$label = "7";
		}
		else if($row['day_5']=='0' && $ddate=='4'){
			//You are not allowed to login on Thursday
			$label = "8";
		}
		else if($row['day_6']=='0' && $ddate=='5'){
			//You are not allowed to login on Friday
			$label = "9";
		}
		else if($row['day_7']=='0' && $ddate=='6'){
			//You are not allowed to login on Saturday
			$label = "10";
		}
		else if(!(($lowerstatus==1) && ($upperstatus==1))){
			//You are not allowed to login due to working hours violation
			$label = "11";
		}
		else if($expiration_date <=$today_date){
			$label = "13";
		}
		else if($row['passchg_logon']=='1'){
			$label = "14";
		}
		else {
			$label = "1";
			$_SESSION[vuvaa_customer_username_sess] = $user;
			$_SESSION[vuvaa_customer_firstname_sess] = $row['firstname'];
			$_SESSION[vuvaa_customer_lastname_sess] = $row['lastname'];
			$dbobject->resetpinmissed($user);
			$custBalance = $dbobject->getitemlabel('customer_balance','username',$user,'current_balance');
		}
		//$label = $user.'|'.$row['role_id'].'|'.$row['role_name'].'|'.$row['branch_code'].'|'.$row['firstname'].'|'.$row['lastname'];
	}else{
		if($no_of_pin_misses==$pin_missed){
			$label = "12";
			$dbobject->updateuserlock($user,'1');
		}else{
		$label = "0";
		$dbobject->updatepinmissed($user);
		}		
	}
	return $label.'|'.$_SESSION[vuvaa_customer_firstname_sess].'|'.$_SESSION[vuvaa_customer_lastname_sess].'|'.$custBalance.'|'.$_SESSION[vuvaa_customer_username_sess];
	}


	function doDbTblUpdate($tbl,$setFieldArr,$setFieldValArr,$whrFieldArr,$whrFieldValArr)
	{
		if(count($setFieldArr)==count($setFieldValArr) && count($whrFieldArr)==count($whrFieldValArr))
		{
			////////// set clause starts here////////////////////////////////
			for($i=0; $i<count($setFieldArr);$i++)
			{
				$setClause .= $setFieldArr[$i]."='".$setFieldValArr[$i]."', ";
			}
			$setClause = rtrim($setClause,", ");
			//echo $setClause;
			/////////////////////////////////////////////////////////////////
			///////////////where clause starts here/////////////////////////
			for($j=0; $j<count($whrFieldArr);$j++)
			{
				$whrClause .= $whrFieldArr[$j]."='".$whrFieldValArr[$j]."', ";
			}
			$whrClause = rtrim($whrClause,", ");
			// echo $whrClause;
			///////////////////////////////////////////////////////////////
			////////////the complete query/////////////////////////////////
			$query = "UPDATE ".$tbl." SET ".$setClause." WHERE ".$whrClause;
			// echo $query;
			$result = mysql_query($query);
			if(mysql_affected_rows()>0)
			{
				$resp = 1;//successful
				return $resp;
			}else
			{
				$resp = 2;//update not successful. Possibly transaction details not available 
				return $resp;
			}
		}else
		{
			$resp = 3; //array count does not match
			return $resp;
		}
		
	}
	
	function getItemLabelArr($tablename,$table_col_arr,$table_val_arr,$ret_val_arr)
	{
		$label = "";
		/////////////////////////////////////////////////////////////////
		////////// select clause starts here////////////////////////////////
		if($ret_val_arr=="*")
		{
			$result = mysql_query("SHOW COLUMNS FROM $tablename ");
			while($roww = mysql_fetch_array( $result ))
      		{
				$selectClause .=$roww[0].", ";
				$ret_val[] = $roww[0];
			}
			$retCount =$ret_val;
			$selectClause = rtrim($selectClause,", ");
		}else
		{
			for($i=0; $i<count($ret_val_arr);$i++)
			{
				$selectClause .=$ret_val_arr[$i].", ";
			}
			$selectClause = rtrim($selectClause,", ");
			$retCount = $ret_val_arr;
			//echo $setClause;
		}
		/////////////////////////////////////////////////////////////////
		///////////////where clause starts here/////////////////////////
		for($j=0; $j<count($table_col_arr);$j++)
		{
			$whrClause .= $table_col_arr[$j]."='".$table_val_arr[$j]."', ";
		}
		$whrClause = rtrim($whrClause,", ");
		/////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////
		$table_filter = " where ".$whrClause;
	
		$query = "select ".$selectClause." from ".$tablename.$table_filter;
		//echo $query;
		$result = mysql_query($query);
		$numrows = mysql_affected_rows();
		if($numrows > 0)
		{
			/*$row = mysql_fetch_array($result);
			for($k=0; $k<count($retCount);$k++)
			{
				$retValue .= $row[$retCount[$k]].'::';
			}
			$retValue = rtrim($retValue,":: ");*/
			$retValue  = mysql_fetch_assoc($result);
		}
		return $retValue;
	}
	
	
	function fidelityRespCodes($success)
	{
		switch($success)
		{
		   case "00":
		   return 'Successful Transaction';break;
		   case "01":
		   return 'Failed Transaction';break;
		   case "02":
		   return 'Pending Transaction';break;
		   case "03":
		   return 'Transaction Cancelled';break;
		   case "04":
		   return 'Not Processed';break;
		   case "05":
		   return 'Invalid Merchant';break;
		   case "06":
		   return 'Inactive Merchant';break;
		   case "07":
		   return 'Invalid Order ID';break;
		   case "08":
		   return 'Duplicate Order ID';break;
		   case "09":
		   return 'Invalid Amount';break;
		   default:
				 echo "Transaction Failed Due to UNKNOWN ERROR!!!";break;
		}  
	}

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//End Class
?>
