<?php
	include("lib/dbfunctions.php");
	$dbobject = new dbobject();
	$username = $_SESSION['username_sess'];	
	if(!isset($_REQUEST['op'])){
		$menu_id = $dbobject->paddZeros($dbobject->getnextid('menu'),3);
	}	
	if($_REQUEST['op']=='edit'){
		$menu_id = $_REQUEST['menu_id'];
		$result = $dbobject->getrecordset('menu','menu_id',$menu_id);
		$numrows = mysql_num_rows($result);
	
			if($numrows > 0){
				$row = mysql_fetch_array($result);
				$menu_name = $row['menu_name'];
				$menu_url = $row['menu_url'];
				$parent_id = $row['parent_id'];
			}
	
	}
	$parent_menu_list = $dbobject->getparentmenu($parent_id);
	
?>
<div class="row-fluid">
 <form class="mws-form" action="" method="get" id="form1">
                    <div class="span8">
                        <div class="head clearfix">
                            <!--<div class="isw-documents"></div>-->
                            <h1>Menu Details Setup</h1>
                        </div>
                        <div class="block-fluid">                        

                            <div class="row-form clearfix">
                                <div class="span2">Menu ID:</div>
                                <div class="span5">
                                <input type="text" name="menu_id" id="menu_id" value="<?php echo $menu_id; ?>" readonly="true"/>
                                </div>
                            </div> 

                            <div class="row-form clearfix">
                                <div class="span2">Menu Name :</div>
                                <div class="span5"><input type="text" name="menu_name" id="menu_name" class="required-text" title="Menu Name" value="<?php echo $menu_name; ?>" /></div>
                            </div>
                            
                            <div class="row-form clearfix">
                                <div class="span2">Menu URL :</div>
                                <div class="span5">
                                <input type="text" name="menu_url" id="menu_url" class="required-text" title="Menu URL" value="<?php echo $menu_url; ?>">
                               </div>
                            </div>
                            
                            
                            <div class="row-form clearfix">
                                <div class="span2"> Parent Menu:</div>
                                <div class="span5">
                                <select name="parent_menu" id="parent_menu">
									<?php echo $parent_menu_list; ?>
                                </select>
                               </div>
                            </div>
                            <div id ="display_message" style="padding-left:10px;padding-right:10px;display:none;"></div>
                            <div class="footer tar" style="padding-right:60px !important; text-align:center !important;">
                              <input type="button" name="subbtn" id="subbtn" value="Save" onclick="javascript:callpage('save_menu')" class="btn">
                              <input type="button" name="subbtn" id="subbtn" value="Cancel" onclick="Cancel" class="btn btn-danger">
                            </div>                            
                        </div>

                    </div>
</form>
                </div>