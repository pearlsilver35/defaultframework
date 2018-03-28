<?php
include("lib/dbfunctions.php");
$dbobject = new dbobject();
//////request OP
$op = $_REQUEST['op'];
if($op=='checklogin')
{
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$member_details = $dbobject->getcheckdetails($username,$password);
	//echo "Am here";
echo trim($member_details);
}elseif($op=='save_password')
{
	if(isset($_REQUEST['subbtn'])){
	$username = $_REQUEST['username'];
	$oldpassword = $_REQUEST['oldpassword'];
	$user_password = $_REQUEST['userpassword'];
		if($dbobject->validatepassword($username,$oldpassword)=='1'){
		$curr_resp = $dbobject->doPasswordChange($username,$user_password);
			if($curr_resp == 1) {
				echo '<div class="alert alert-success">The User password has been successfully changed </div>';
			}
			else{
				echo '<div class="alert alert-error">Error : Please check password detail</div>';
			}
		}
		else
		{
				echo '<div class="alert alert-error">Your old password is invalid</div>';
		}
	}
}elseif($op=='save_role')
{
		//if(isset($_REQUEST['role_id'])){
		$role_id = $_REQUEST['role_id'];
		$role_name = $_REQUEST['role_name'];
		$enable_role = $_REQUEST['enable_role'];
		$role_resp = $dbobject->doRole($role_id,$role_name,$enable_role);
			if($role_resp=='1') {
				echo 'Role detail has been successfully saved';
			}else{
				echo 'Error : Please check Role detail';
			}
		//}
		
	}elseif($op=='save_user')
	{
		if(isset($_REQUEST['subbtn'])){
/////////////////////////////////////////////////////////////////////////////////////////
		$username = $_REQUEST['username'];
		$userpassword = $_REQUEST['userpassword'];
		$firstname = $_REQUEST['firstname'];
		$lastname = $_REQUEST['lastname']." ".$_REQUEST['middlename'];;
		$email = $_REQUEST['email'];
		$phone = $_REQUEST['phone'];
		$chgpword_logon = $_REQUEST['chgpword_logon']!='1'?'0':$_REQUEST['chgpword_logon'];
		$user_locked = $_REQUEST['user_locked']!='1'?'0':$_REQUEST['user_locked'];
		$user_disable = $_REQUEST['user_disable']!='1'?'0':$_REQUEST['user_disable'];
		$day_1 = $_REQUEST['day_1']!='1'?'0':$_REQUEST['day_1'];
		$day_2 = $_REQUEST['day_2']!='1'?'0':$_REQUEST['day_2'];
		$day_3 = $_REQUEST['day_3']!='1'?'0':$_REQUEST['day_3'];
		$day_4 = $_REQUEST['day_4']!='1'?'0':$_REQUEST['day_4'];
		$day_5 = $_REQUEST['day_5']!='1'?'0':$_REQUEST['day_5'];
		$day_6 = $_REQUEST['day_6']!='1'?'0':$_REQUEST['day_6'];
		$day_7 = $_REQUEST['day_7']!='1'?'0':$_REQUEST['day_7'];
		$override_wh = $_REQUEST['override_wh']!='1'?'0':$_REQUEST['override_wh'];
		$extend_wh = $_REQUEST['extend_wh'];
		if($override_wh!='1') $extend_wh='';
		$role_id = $_REQUEST['role_id'];
		$operation = $_REQUEST['operation'];
		$role_id = $_REQUEST['role_id'];
		$role_name = $dbobject->getitemlabel('role','role_id',$role_id,'role_name');
		$insurance_coy = $_REQUEST['insurance_coy'];
		$user_resp = $dbobject->doUser($operation,$username,$userpassword,$firstname,$lastname,$email,$phone, $chgpword_logon, $user_locked, $user_disable,$day_1,$day_2,$day_3,$day_4,$day_5,$day_6,$day_7,$override_wh,$extend_wh,$role_id,$role_name);
			
			if($user_resp==-9){
				echo 'User detail already exist, please enter a different username';
			}
			else if($user_resp > 0) {
				echo 'User detail has been successfully saved';
			}else{
				echo 'Error : Please check User detail';
			}
		}
		
	}elseif($op=='edit_user'){
	
		//if(isset($_REQUEST['password'])){
		
		$firstname = $_REQUEST['fname'];
		$lastname = $_REQUEST['lname'];
		$reg_email = $_REQUEST['reg_email'];
		$phone = $_REQUEST['phone'];
		$dob = $_REQUEST['dob'];
		$gender = $_REQUEST['gender'];
		$contact_address = $_REQUEST['address'];
		$user_resp = $dbobject->doEditUser($reg_email,$firstname,$lastname,$phone, $dob,$gender,$contact_address);
			
			if($user_resp==-9){
				echo 'Account can not be updated at this moment';
			}
			elseif($user_resp > 0) {
				echo 'Your profile has been updated';
			}else{
				echo 'Error : Please check User detail'.$user_resp;
			}
		//}else{ echo 'here is the bug';  }
		
		
	}elseif($op=='save_menu'){
		//if(isset($_REQUEST['subbtn'])){
		$menu_id = $_REQUEST['menu_id'];
		$menu_name = $_REQUEST['menu_name'];
		$menu_url = $_REQUEST['menu_url'];
		$parent_menu = $_REQUEST['parent_menu'];
		//if($parent_menu!='#')echo 'parent menu : '.$parent_menu;
		$parent_id2 = "";
		$menu_level = $parent_menu=='#'?"0":"1";
		if($menu_url=='#' && $parent_menu!='#'){
			$menu_level = '1';
			$parent_id2 = '#';
			//echo "Here 1";
		}
		if($menu_url!='#' && $parent_menu!='#'){
			$menu_level = $dbobject->getitemlabel('menu','menu_id',$parent_menu,'menu_level');
			//echo 'Level : '.$menu_level;
			$menu_level = ($menu_level=='0')?'1':'2';
			$parent_id2 = $parent_id;
			$parent_id = $dbobject->getitemlabel('menu','menu_id',$parent_id,'parent_id');
			//select parent_id from menu where menu_id= '$parent_id'
		}
		
		$menu_resp = $dbobject->doMenu($menu_id,$menu_name,$menu_url,$parent_menu,$menu_level,$parent_id2);
			if($menu_resp=='1') {
				echo 'Menu detail has been successfully saved';
			}else{
				echo 'Error : Please check Menu detail';
			}
		//}
		
	}
	/////////////////////////////////////
	if($op=='getexistrole'){
			$menu_id = $_REQUEST['menu_id'];
			$existrole = $dbobject->getexistrole($menu_id);
			echo $existrole;
	}
	////////////////////////////////////
	if($op=='getnonexistrole'){
			$menu_id = $_REQUEST['menu_id'];
			$noexistrole = $dbobject->getnonexistrole($menu_id);
			echo $noexistrole;
	}elseif($op=='save_menugroup'){
		if(isset($_REQUEST['menu_id'])){
		$menu_id = $_REQUEST['menu_id'];
		$exist_role = $_REQUEST['exist_role'];
		$menugroup_resp = $dbobject->doMenuGroup($menu_id,$exist_role);
			if($menugroup_resp > 0) {
				echo 'MenuGroup detail has been successfully saved';
			}else{
				echo 'Error : Please check MenuGroup detail';
			}
		}
	}
	elseif($op=='save_password_exp')
	{
		if(isset($_REQUEST['subbtn'])){
		$username = $_REQUEST['username'];
		$oldpassword = $_REQUEST['oldpassword'];
		$user_password = $_REQUEST['userpassword'];
		$pass_expiry_days = $_SESSION['password_expiry_days'];
		$today = @date("Y-m-d");
		$pass_dateexpire = @date("Y-m-d",strtotime($today."+".$pass_expiry_days."days"));
			if($dbobject->validatepassword($username,$oldpassword)=='1'){
			$curr_resp = $dbobject->doPasswordChangeExp($username,$user_password,$pass_dateexpire);
				if($curr_resp == 1) {
					echo 'The User password has been successfully changed ';
				}
				else{
					echo 'Error : Please check password detail';
				}
			}
			else
			{
				echo 'Your old password is invalid';
			}
		}
	}elseif($op=='save_password_logon'){
		if(isset($_REQUEST['subbtn'])){
		$username = $_REQUEST['username'];
		$oldpassword = $_REQUEST['oldpassword'];
		$user_password = $_REQUEST['userpassword'];
			if($dbobject->validatepassword($username,$oldpassword)=='1'){
			$curr_resp = $dbobject->doPasswordChangeLogon($username,$user_password);
				if($curr_resp == 1) {
					echo 'The User password has been successfully changed ';
				}
				else{
					echo 'Error : Please check password detail';
				}
			}
			else{
					echo 'Your old password is invalid';
			}
		}
	}elseif($op=='save_reordersubmenu')
	{
		if(isset($_REQUEST['subbtn'])){
		$parent_menu = $_REQUEST['parent_menu'];
		$sub_menu = $_REQUEST['sub_menu'];
		//echo $sub_menu;
		$curr_resp = $dbobject->reorder_submenu($parent_menu,$sub_menu);
			if($curr_resp > 0) {
				echo 'Menu Re-ordering has been successfully saved';
			}else{
				echo 'Error : Changes were not saved';
			}
		}
		
	}elseif ($op=="editTrans")
{
	if(isset($_REQUEST['subbtn']))
	{	
		$operation = $_REQUEST['operation'];
		$message = $_REQUEST['message'];
		//echo $operation;
		$tbl = $_REQUEST['tableName'];
		//if($tbl=='student_reg') $innp .=
		$innp = $_REQUEST['inputs'];
		$inpFds = explode(',',$innp);
		for($j=0;$j<count($inpFds);$j++)
		{
			$inpFdsVals[$j] = $_REQUEST[$inpFds[$j]];
			//$inpp .= $inpFds[$j].'='.$inpFdsVals[$j].'-';
		}
		//echo $inpp;
		$resp = $dbobject->SaveTransEdit($tbl,$inpFds,$inpFdsVals,$operation);
	
		if($resp=='1') 
		{
			echo $resp.'::||::'.$message." Has been Successful Saved !!!";
		}
		elseif($resp=='-1')
		{
			echo "ERROR:: ".$message." Details cannot be Saved:! Please check form Details ";
		}
		else if($resp=='-2')
		{
			echo "ERROR:: Update Failed !";
		}
		else
		{
			echo $resp;
		}
	}
}
?>
