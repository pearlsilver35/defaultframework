<?php
	include("lib/dbfunctions.php");
	$dbobject = new dbobject();
	$username = $_SESSION['username_sess'];	
	$dbobject = new dbobject();
	if($_REQUEST['op']=='edit')
	{
		$role_id = $_REQUEST['role_id'];
		$result = $dbobject->getrecordset('role','role_id',$role_id);
		$numrows = mysql_num_rows($result);
		if($numrows > 0)
		{
			$row = mysql_fetch_array($result);
			$role_name = $row['role_name'];
			$enable_role = $row['role_enabled'];
		}
	}else
	{
		$query = "SELECT role_id FROM role ORDER BY role_id DESC LIMIT 1";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$role_id = $row[role_id]+1;
		$role_id = $dbobject->paddZeros($role_id,3);
	}
?>
<div class="row-fluid">
 <form class="mws-form" action="" method="get" id="form1">
                    <div class="span8">
                        <div class="head clearfix">
                            <!--<div class="isw-documents"></div>-->
                            <h1>Role Setup</h1>
                        </div>
                        <div class="block-fluid">                        
						<div class="row-form clearfix">
                                <div class="span2">Role ID : </div>
                                <div class="span5">
                                <input type="text" name="role_id" id="role_id" value="<?php echo $role_id; ?>" class="required-text form-control" readonly="true"/>
                                </div>
                            </div> 

                            <div class="row-form clearfix">
                                <div class="span2">Role Name :</div>
                                <div class="span5"><input type="text" name="role_name" id="role_name" class="required-text form-control" title="Role Name" value="<?php echo $role_name; ?>" /></div>
                            </div>
                        
                                    
                    <div id="alertmsg" class="alert alert-success" style="display:none;">
                          <strong id="hhdd">Successful ! </strong>
                          <div id ="display_message" style="padding-left:10px;padding-right:10px;display:none;" ></div>
                    </div>
                    <div class="footer tar" style="padding-right:60px !important; text-align:center !important;">
                        <input type="button" name="subbtn" id="subbtn" value="Save Role" onclick="javascript:callpage('save_role')" class="btn btn-info">
                        <input type="button" name="subbtn" id="subbtn" value="Cancel" onclick="javascript:getpage('role_list.php','page')" class="btn btn-danger">
                    </div>
                    
                 </div>
             </div>
             
             </div>
             </div>
             </div>
             </div>
             </form>
              