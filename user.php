<?php
	include("lib/dbfunctions.php");
	$dbobject = new dbobject();
	$role_id = "";
	$branch_code = "";
	
	$op = isset($_REQUEST['op'])?$_REQUEST['op']:'new';	
	if($_REQUEST['op']=='edit'){
		$username = $_REQUEST['username'];
		$result = $dbobject->getrecordset('userdata','username',$username);
		$numrows = mysql_num_rows($result);
	
			if($numrows > 0)
			{
				$row = mysql_fetch_array($result);
				$userpassword = $row['password'];
				$desencrypt = new DESEncryption();
				$cipher_password = $desencrypt->hexToString($userpassword);
				$recovered_pass = trim($desencrypt->des($username, $cipher_password, 0, 0, null,null));
				//echo $userpassword.'recovered'.$recovered_pass;
				$firstname = $row['firstname'];
				$lastname = $row['lastname'];
				$email = $row['email'];
				$phone = $row['mobile_phone'];
				$chgpword_logon = $row['passchg_logon'];
				$user_locked = $row['user_locked'];
				$user_disable = $row['user_disabled'];
				$role_id = $row['role_id'];
				$day_1 = $row['day_1'];
				$day_2 = $row['day_2'];
				$day_3 = $row['day_3'];
				$day_4 = $row['day_4'];
				$day_5 = $row['day_5'];
				$day_6 = $row['day_6'];
				$day_7 = $row['day_7'];
			}
	
	}
	//$role_sel = $dbobject->pick_role($role_id);
	$role_sel= $dbobject->getTableSelectArr('role',array('role_id','role_name'),array('1','role_id!'),array('1','501'),'role_id','ASC',$role_id,'User Role');
	$schoptions = $dbobject->gettableselect('jssce_school_registration','school_code','school_name','');
?>
<style type="text/css">
.fdtddd input,textarea,select
{
	width:95% !important;
}
#heading_td
{
	background-color:#00A0B1;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif !important;
}
</style>
<form action="" method="post" id="form1">
<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
<div class="span10">
    <div class="head clearfix">
        <!--<div class="isw-documents"></div>-->
        <h1>User Setup</h1>
    </div>
    <div class="block-fluid">
          <table width="100%" border="0" cellspacing="0" cellpadding="5" id="list_table">
            <tr>
              <td width="721" colspan="4" id="">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" style="padding:0px !important;"><table width="100%" border="0" cellspacing="0" id="list_table" class="table" style="border-color:#CCC !important;">
                <tr>
                  <td width="97" align="right" nowrap="nowrap">Username :</td>
                  <td align="left" class="fdtddd">
                    <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="required-text form-control" title="Username" autocomplete="off" placeholder="Enter Username Here" />
                  </td>
                  <td align="left" class="fdtddd">&nbsp;</td>
                  <td align="left" class="fdtddd">&nbsp;</td>
                </tr>
                <tr>
                  <td align="right" nowrap="nowrap">Password :</td>
                  <td width="380" align="left" class="fdtddd"><input type="password" name="userpassword" id="userpassword" value="<?php echo $recovered_pass; ?>" class="required-text form-control" title="Password" /></td>
                  <td width="167" align="right" nowrap="nowrap">Confirm Password :</td>
                  <td width="380" align="left" class="fdtddd"><input type="password" name="npswd" id="npswd" value="<?php echo $recovered_pass; ?>" class="required-text form-control" title="Confirm password" /></td>
                </tr>
                <tr>
                  <td align="right" nowrap="nowrap">Firstname :</td>
                  <td align="left" class="fdtddd"><input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" class="required-text form-control" title="Firstname" /></td>
                  <td align="right" nowrap="nowrap">Lastname :</td>
                  <td align="left" class="fdtddd"><input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>" class="required-text form-control" title="Lastname" /></td>
                </tr>
                <tr>
                  <td align="right" nowrap="nowrap">Email :</td>
                  <td align="left" class="fdtddd"><input type="text" name="email" id="email" value="<?php echo $email; ?>" class="required-email form-control" title="Email" /></td>
                  <td align="right" nowrap="nowrap">Phone :</td>
                  <td align="left" class="fdtddd"><input type="text" name="phone" id="phone" value="<?php echo $phone; ?>" class="required-number form-control" title="Phone" /></td>
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="4" align="left" id="" style="padding:0px !important;">
                                   <div class="widget teal"><header> <h4 class="title"><span class="icon icone-lock"></span>Security Options</h4></header></div></td>
            </tr>
            <tr>
              <td colspan="4" style="padding:0px !important;"><table width="100%" border="0" cellspacing="0" cellpadding="5" id="list_table" class="table">
                <tr>
                  <td colspan="2" align="left">
                  <div class="checkbox">
                  <label><input name="chgpword_logon" type="checkbox" id="chgpword_logon" onchange="javascript: checkOption(this);" <?php echo ($chgpword_logon=='1')?"checked=true":""; ?> />
                   <span class="text">Change Password at next logon </span>
                   </label>
                   </div></td>
                  <td colspan="2" align="left">
                  <div class="checkbox">
                  <label> <input name="user_locked" type="checkbox" id="user_locked" onchange="javascript: checkOption(this);" <?php echo ($user_locked=='1')?"checked=true":""; ?> />
                   <span class="text">Check here to lock this User </span>
                   </label>
                   </div>                 
                    </td>
                </tr>
                <tr>
                  <td colspan="2" align="left">
                  <div class="checkbox">
                  <label> <input name="user_disable" type="checkbox" id="user_disable" onchange="javascript: checkOption(this);" <?php echo ($user_disable=='1')?"checked=true":""; ?> />
                   <span class="text">Check here to disable this User </span>
                   </label>
                   </div>
                    </td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="4" align="left" nowrap="nowrap" ></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="4" align="left" id="" style="padding:0px !important;"><div class="widget teal"><header> <h4 class="title"><span class="icon icone-lock"></span>Choose Login Days</h4></header></div></td>
            </tr>
            <tr>
              <td colspan="4"><table width="100%" border="0" class="table" cellspacing="0" cellpadding="5" id="list_table">
                <tr>
                  <td colspan="4" align="left" nowrap="nowrap">
                  <div class="checkbox col-lg-2">
                  <label><input name="day_2" type="checkbox" id="day_2" onchange="javascript: checkOption(this);" <?php echo ($day_2=='1')?"checked=true value=1":""; ?> />
                   <span class="text"> Monday</span>
                   </label>
                   </div>
                   <div class="checkbox col-lg-2">
                  <label> <input name="day_3" type="checkbox" id="day_3" onchange="javascript: checkOption(this);" <?php echo ($day_3=='1')?"checked=true value=1":""; ?> />
                   <span class="text"> Tuesday</span>
                   </label>
                   </div>
                   <div class="checkbox col-lg-2">
                  <label> <input name="day_4" type="checkbox" id="day_4" onchange="javascript: checkOption(this);" <?php echo ($day_4=='1')?"checked=true value=1":""; ?> />
                   <span class="text"> Wednesday</span>
                   </label>
                   </div>
                   <div class="checkbox col-lg-2">
                  <label>  <input name="day_5" type="checkbox" id="day_5" onchange="javascript: checkOption(this);" <?php echo ($day_5=='1')?"checked=true value=1":""; ?> />
                   <span class="text"> Thursday</span>
                   </label>
                   </div>
                   <div class="checkbox col-lg-2">
                  <label> <input name="day_6" type="checkbox" id="day_6" onchange="javascript: checkOption(this);" <?php echo ($day_6=='1')?"checked=true value=1":""; ?> />
                   <span class="text">Friday</span>
                   </label>
                   </div>
                   <div class="checkbox col-lg-2">
                  <label>  <input name="day_7" type="checkbox" id="day_7" onchange="javascript: checkOption(this);" <?php echo ($day_7=='1')?"checked=true value=1":""; ?> />
                   <span class="text"> Saturday</span>
                   </label>
                   </div>
                   <div class="checkbox col-lg-2">
                  <label> <input name="day_1" type="checkbox" id="day_1" onchange="javascript: checkOption(this);" <?php echo ($day_1=='1')?"checked=true value=1":""; ?> />
                   <span class="text">Sunday</span>
                   </label>
                   </div>
                   </td>
                </tr>
                <tr>
                  <td align="right">Select Role :</td>
                  <td align="left"><label>
                    <select name="role_id" id="role_id">
                      <?php echo $role_sel; ?>
                    </select>
                  </label></td>
                  <td align="left">&nbsp;</td>
                  <td align="left"><div id="sch_div" style="display:none">
                    <select name="station" id="station">
                      <?php echo $schoptions; ?>
                    </select>
                  </div></td>
                </tr>
                <tr>
                  <td colspan="4" align="center">
                   <div id="alertmsg" class="alert alert-success" style="display:none;">
                          <strong id="hhdd"> </strong>
                          <div id ="display_message" style="padding-left:10px;padding-right:10px;display:none;" ></div>
                    </div>
                  </td>
                  </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><label>
                    <input type="button" class="btn btn-info" name="subbtn" id="subbtn" value="Save User" onclick="javascript: callpage('save_user');" /> |  <input type="button" class="btn btn-danger" name="cancel" id="cancel" value="Cancel" onclick="javascript: getpage('user_list.php','page');" />
                  </label></td>
                </tr>
              </table></td>
            </tr>
          </table>
        </div>
        </div>
</form>
