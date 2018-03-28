<form action="" method="get" id="form1">
<?php
	include("lib/dbfunctions.php");
	$dbobject = new dbobject();
	$parent_id = "";
		
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
	$parent_menu_list = $dbobject->getmenu($parent_id);
	
?>
 
 

		<div class="row-fluid">
  				<div class="span6">
					<div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Menu Group</h1>
                        </div>
                       
                        <div class="block-fluid">                        
                          
                          <div class="row-form clearfix">
                            <div class="span2">Select Menu:</div>
                            <div class="span4">
                            <select name="menu_id" id="menu_id" onChange='javascript: loadroles();'>
                            <?php echo $parent_menu_list; ?>
                            </select>
                            </div>
                         </div>
		                
                        <div class="row-form clearfix">
                        <table align="center" width="400" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="3">&nbsp;</td>
        <td width="283">&nbsp;</td>
      </tr>
      <tr>
        <td width="234" align="center"><label>
          <select name="non_exist_role" size="5" multiple id="non_exist_role">
          </select>
        </label></td>
        <td width="79"><table align="center" width="79" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><img src="images/right.png" alt="Move Forward" width="26" height="28" onClick="javascript: addrole();"></td>
            </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><img src="images/left.png" alt="Move Backward" width="26" height="28" onClick="javascript: removerole();"></td>
            </tr>
          
        </table></td>
        <td width="4">&nbsp;</td>
        <td align="center"><select name="exist_role" size="5" multiple id="exist_role">
                                                </select></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
                        </div>
                        
                        
                        <div id ="display_message" style="padding-left:10px;padding-right:10px;display:none;"></div>
                            <div class="footer tar">
                              <input type="button" name="subbtn" id="subbtn" value="Save" onclick="javascript: selectalldata(); callpage('save_menugroup');" class="btn" />
                            
                              <input type="button" value="Cancel" id="cancelbtn" onclick="window.location='home.php';" class="btn btn-danger" />
                            </div>                            

                        
                        </div>
       			</div>
            </div>             
                </form>