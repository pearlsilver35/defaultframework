<?php
	include("lib/dbfunctions.php");
	$dbobject = new dbobject();
	$username = $_SESSION['username_sess'];	
?>
<div class="row-fluid">
 <form class="mws-form" action="" method="get" id="form1">
                    <div class="span12">
                        <div class="head clearfix">
                            <div class="isw-documents"></div>
                            <h1>Change Password</h1>
                        </div>
                        <div class="block-fluid">                        

                            <div class="row-form clearfix">
                                <div class="span2">Username:</div>
                                <div class="span2">
                                <input type="text" readonly="readonly" name="username" id="username" value="<?php echo $username; ?>"/>
                                </div>
                                 <!--<div class="span2">othername:</div>
                                <div class="span4">
                                <input type="text" readonly="readonly" name="username" id="username" value="<?php echo $username; ?>"/>
                                </div>-->
                            </div> 

                            <div class="row-form clearfix">
                                <div class="span2">Old Password:</div>
                                <div class="span2"><input type="password" name="oldpassword" id="oldpassword" class="required-text" title="Old Password" value="<?php echo $userpassword; ?>" /></div>
                            </div>
                            
                            <div class="row-form clearfix">
                                <div class="span2">New Password:</div>
                                <div class="span2">
                                <input type="password" name="userpassword" id="userpassword" class="required-text" title="New Password" value="<?php echo $userpassword; ?>">
                               </div>
                            </div>
                            
                            
                            <div class="row-form clearfix">
                                <div class="span2">Confirm New Password:</div>
                                <div class="span2">
                                <input type="password" name="confirm_userpassword" id="confirm_userpassword" title="Confirm Password" class="required-text" value="<?php echo $confirm_userpassword; ?>"  />
                               </div>
                            </div>
                            <div id ="display_message" style="padding-left:10px;padding-right:10px;display:none;"></div>
                            <div class="footer tar">
                              <input type="button" name="subbtn" id="subbtn" value="Save" onclick="javascript: chkpassword('save_password'); return false;" class="btn" />
                             
                              <input type="button" value="Cancel" id="cancelbtn" onclick="window.location='home.php';" class="btn btn-danger" />
                            </div>                            
                        </div>

                    </div>
</form>
                </div>