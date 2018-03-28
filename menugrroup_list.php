<?php 
session_start();
if (!isset($_SESSION['username_sess']))
{
	include('logout.php');
	}
//require("lib/dbcnx.inc"); 
include("lib/dbfunctions.php");
$dbobject = new dbobject();
?>
<form name="form1" id="form1" method="post" action="">
<input type="hidden" name="username" />
<input type="hidden" name="op" />
<input type="hidden" name="var1" />
<?php
			//Get User Branch in Session
			$user_role_session = $_SESSION['role_id_sess'];
			$username_sess = $_SESSION[username_sess];
 			//echo $user_role_session.' - '.$branch_roleid;
			
			
		$count = 0;
			$limit = !isset($_REQUEST['limit'])?"200":$_REQUEST['limit'];
			$pageNo = !isset($_REQUEST['fpage'])?"1":$_REQUEST['fpage'];
$searchby = !isset($_REQUEST['searchby'])?"role_name":$_REQUEST['searchby'];
			$keyword = !isset($_REQUEST['keyword'])?"":$_REQUEST['keyword'];
			$orderby = !isset($_REQUEST['orderby'])?"role_name":$_REQUEST['orderby'];
			$orderflag = !isset($_REQUEST['orderflag'])?"asc":$_REQUEST['orderflag'];
			$lower = !isset($_REQUEST['lower'])?"":$_REQUEST['lower'];
			$upper = !isset($_REQUEST['upper'])?"":$_REQUEST['upper'];
			$upper = !isset($_REQUEST['upper'])?"":$_REQUEST['upper'];
			$start_date = !isset($_REQUEST['start_date'])?"":$_REQUEST['start_date'];
			$end_date = !isset($_REQUEST['end_date'])?"":$_REQUEST['end_date'];

			
			$searchdate ="";
			if($start_date!='' && $end_date!=''){
			$searchdate = " and (created between '$start_date 00:00'  and '$end_date 23:59') ";
			}else{
				$datestr = date('Y-m-d');
				$searchdate = "";
			}
			
			
			$filter = "";
			if($keyword!=''){$filter=" AND $searchby like '%$keyword%' ";}
			$order = " order by ".$orderby." ".$orderflag;
			$sql = "select count(role_id) counter from menugroup, role where role.role_id = menugroup.role_id and menugroup.menu_id = menu.menu_id and role.role_id not in(select parameter_value from parameter where parameter_name='$user_role_session' ) ";
			//echo $sql;
			$result = mysql_query($sql);
			if($result){
			$row = mysql_fetch_array($result);
			$count = $row['counter'];
			}
			
			$skip = 0;
			$maxPage = $limit;
			//echo $count;
			$npages = (int)($count/$maxPage);
			//echo $npages;
			if ($npages!=0){
				if(($npages * $maxPage) != $count){	
					$npages = $npages+1;
					//echo $npages;
				}
			}else{
				$npages = 1;
				//echo "Here";
			}
			
			$sel = !isset($_REQUEST['op'])?"":$_REQUEST['op'];
			if ($sel=="del"){
				$delvalues = !isset($_REQUEST['role_id'])?"":$_REQUEST['role_id'];
				$delsql = "delete from menugroup where role_id = '$delvalues'";
				$dresult = mysql_query($delsql);
				echo "<font class='header2white'>No of Deleted Records: ".mysql_affected_rows()." </font>";
			}
	$pg = $pageNo -1;
	$limRange = $pg * $limit;
	$limit_filter = " LIMIT ".$limRange.",".$limit;	
	$query = "select * from role";
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	
	//echo 'D page:  '.$pageNo;
	?>
   
<input type = 'hidden' name = 'sql' id='sql' value="<?php echo $download_query;?>" />
<input type = 'hidden' name = 'filename' id='filename' value="userdata" />
<input type = 'hidden' name = 'pageNo' id="pageNo" value = "<?php echo $pageNo; ?>">		
<input type = 'hidden' name = 'rowCount' value = "<?php echo $count; ?>">
<input type = 'hidden' name = 'skipper' value = "<?php echo $skip; ?>">
<input type = 'hidden' name = 'pageEnd' value = "<?php echo $npages; ?>">
<input type = 'hidden' name = 'sel' /> 
<script type="text/javascript">
$(".mws-datepicker").datepicker({
				dateFormat: 'yy-mm-dd',
				changeYear: true,
			    showOtherMonths: true
            });

</script>
<div class="row-fluid">

                    <div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Menugroup List</h1>
                            
                                              
                        </div>
                        
                       
                        
                        <div class="block-fluid clearfix">
                       
                       
                       
                        <div id="filter_div" align="center">
<table width="99%" style="">
<tbody>
<tr>
<td width="177" height="14"><table border="0" cellpadding="0" cellspacing="0">
                  <tbody><tr>
                    <td width="80" align="right" nowrap="nowrap">Start Date: </td>
                    <td>
                    <input type="text" name="start_date" id="start_date" class="mws-datepicker" value="<?php echo $start_date; ?>" >
                    </td>
                  </tr>
    </tbody></table></td>
	<td width="1116" rowspan="2" align="left"><table width="507">
	  <tbody><tr>
	    <td width="11%" align="right">Search:</td>
	    <td width="25%"><select name="searchby" class="table_text1"  id="searchby">
	      <option value="menu_id" <?php echo ($searchby=='menu_id')?"selected":""; ?>>Menu ID</option>
	        <option value="menu_name" <?php echo ($searchby=='menu_name')?"selected":""; ?>>Menu Name</option>
	      </select></td>
	    <td width="17%" align="right"> <span>Keyword:</span></td>
	    <td width="33%">
	      <input name="keyword" type="text" class="table_text1" id="keyword" value=""></td>  <td width="14%"><span class="submit">
	        <input name="search2" type="button" class="btn" id="search2" onclick="javascript:doSearch('menu_list.php')" value="Search"></span>
	        </td></tr>
	  <tr>
	    <td align="right">Order:</td>
	    <td colspan="4">
        <select name="orderby" class="table_text1"  id="orderby">
                  <option value="menu_id" <?php echo ($orderby=='menu_id')?"selected":""; ?>>Menu ID</option>
                  <option value="menu_name" <?php echo ($orderby=='role_name')?"selected":""; ?>>Menu Name</option>
                  </select>
	      <select name="orderflag" class="table_text1" id="orderflag">
	        <option value="asc" selected="">Ascending</option>
	        <option value="desc">Descending</option>
	        </select>				  </td>
	    </tr></tbody></table>  </td>
</tr>
<tr>
  <td height="24"><table border="0" cellpadding="0" cellspacing="0">
                  <tbody><tr>
                    <td width="80" align="right" nowrap="nowrap">End Date: </td>
                    <td><input type="text" name="end_date" id="end_date"  class="mws-datepicker" value="<?php echo $end_date; ?>" /></td>
                  </tr>
    </tbody></table> </td>
</tr>
</tbody></table>
</div>



<div id="inner_div">
<table width="100%">

<tr>
  <td align="right" nowrap="nowrap" width="200"><font class='table_text1'>
    <label> </label>    No of Records : <?php echo $count; ?></td>
  <td align="right" nowrap="nowrap"> Limit :
    <select name="limit"   id="limit" onchange="javascript:doSearch('menu_list.php');" style="width:100px;">
      <option value="1" <?php echo ($limit=="1"?"selected":""); ?>>1</option>
      <option value="10" <?php echo ($limit=="10"?"selected":""); ?>>10</option>
      <option value="20" <?php echo ($limit=="20"?"selected":""); ?>>20</option>
      <option value="50" <?php echo ($limit=="50"?"selected":""); ?>>50</option>
      <option value="100" <?php echo ($limit=="100"?"selected":""); ?>>100</option>
      <option value="200" <?php echo ($limit=="200"?"selected":""); ?>>200</option>
      <option value="500" <?php echo ($limit=="500"?"selected":""); ?>>500</option>
      <option value="700" <?php echo ($limit=="700"?"selected":""); ?>>700</option>
      <option value="1000" <?php echo ($limit=="1000"?"selected":""); ?>>1000</option>
      </select>
    Page
    <input name="fpage" type="text" class="table_text1" id="fpage" value="<?php echo $pageNo; ?>" style="width:40px;" size="3"/>
    of
    <input name="tpages" type="text" class="table_text1" id="tpages" value="<?php echo $npages; ?>" style="width:40px" size="3"/>
    &nbsp; </td>
  <td width="271" align="left"><input name="search22" type="button" class="btn" id="search22" onclick="javascript:doSearch('menu_list.php');" value="Go" /></td>
  <td width="49" colspan="-2" align="right"><span>&nbsp;</span></td>
  <td width="186" align="left">&nbsp;</td>
  <td width="34" colspan="-2"><span class="table_text1"><a href="#" onclick="javascript: goFirst('menu_list.php');"><img src="images/first.png" alt="First" width="24" height="24" border="0" /></a></span></td>
  <td width="32" colspan="-2"><span class="table_text1"><a href="#" onclick="javascript: goPrevious('menu_list.php');"><img src="images/prev.png" alt="Previous" width="24" height="24" border="0" /></a></span></td>
  <td width="32" colspan="-2"><span class="table_text1"><a href="#" onclick="javascript: goNext('menu_list.php');"><img src="images/next.png" alt="Next" width="24" height="24" border="0"/></a></span></td>
  <td width="63" colspan="-2"><span class="table_text1"><a href="#" onclick="javascript: goLast('user_list.php');"><img src="images/last.png" alt="Last" width="24" height="24" border="0"/></a></span></td>
</tr>
</table>



<table width="100%">
  <tr>
  &nbsp;&nbsp;<input name="add_new" type="button" class="btn" id="search" onclick="getpage('menudetails.php','page')" value="Add New">
  
  &nbsp;&nbsp;<input name="print" type="button" class="btn" id="search" onclick="printDiv('print_div');" value="Print">

  
  </tr>
</table>
</div>
                       
                       
                       
                       <div  id="print_div">
                       <link href="css/stylesheets.css" rel="stylesheet" type="text/css" />  
    <!--[if lt IE 8]>
        <link href="css/ie7.css" rel="stylesheet" type="text/css" />
    <![endif]-->            
    <link rel='stylesheet' type='text/css' href='css/fullcalendar.print.css' media='print' />
    <table border="0" cellpadding="5" cellspacing="0" >
         <?php 
			$k = $pg * $limit;
  			while($row = mysql_fetch_array($result)){
			$k++;
			$role_id=$row["role_id"];
			?>
        <tr onclick="$('.role<?php echo $role_id;?>').toggle(1000);" style="cursor:pointer;" >
            <td nowrap="nowrap">
            <strong><span class="odd">
            <span style="color:#666666;">
			<?php echo $row["role_name"];?>
            </span>
            </span>
            </strong>
         	 </td>
        </tr>  
        <?php 
			
		  $ssql = "select role.role_name,menu.menu_name from role,menu,menugroup where role.role_id=$role_id and role.role_id = menugroup.role_id and menugroup.menu_id = menu.menu_id and role.role_id not in(select parameter_value from parameter where parameter_name='$user_role_session' ) ".$filteradmin.$order.$limit_filter;
		  //echo $ssql;			//} //End For Loop
				$rrres=mysql_query($ssql);
				mysql_num_rows($rrres);
				if(mysql_num_rows($rrres)>0)
				{
					//echo "<span id='role$role_id'>";
					while($rrow=mysql_fetch_array($rrres))
					{
						echo "<tr class='role$role_id' style='display:none;' ><td>".$rrow['menu_name']."<br></td></tr>";
						?>
                        
						<?php
						}
			      //echo "</span>";
			}
			?>
            
	
			<?php	} //End If Result Test	
		  ?>
    </table>
</div>
                       
                            
                        </div>
                    </div>                                

                </div>