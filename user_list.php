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
$user_role_session = $_SESSION['role_id_sess'];
$username_sess = $_SESSION[username_sess];
		$count = 0;
		$limit = !isset($_REQUEST['limit'])?"200":$_REQUEST['limit'];
		$pageNo = !isset($_REQUEST['fpage'])?"1":$_REQUEST['fpage'];
$searchby = !isset($_REQUEST['searchby'])?"username":$_REQUEST['searchby'];
		$keyword = !isset($_REQUEST['keyword'])?"":$_REQUEST['keyword'];
		$orderby = !isset($_REQUEST['orderby'])?"username":$_REQUEST['orderby'];
		$orderflag = !isset($_REQUEST['orderflag'])?"asc":$_REQUEST['orderflag'];
		$lower = !isset($_REQUEST['lower'])?"":$_REQUEST['lower'];
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
			$sql = "select count(username) counter from userdata where 1=1 and role_id not in(select parameter_value from parameter where parameter_name='$user_role_session' )".$filter.$filteradmin.$searchdate.$order;			
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
				$delvalues = !isset($_REQUEST['username'])?"":$_REQUEST['username'];
				$delsql = "delete from userdata where username = '$delvalues'";
				$dresult = mysql_query($delsql);
				
				$delvalues = !isset($_REQUEST['var1'])?"":$_REQUEST['var1'];
				if($delvalues!=''){
					$delvalues = substr($delvalues,0,strlen($delvalues)-2);
					$delvalues = str_replace("-","'",$delvalues);
					$delsql = "delete from userdata where username in ($delvalues)";
					//echo $delsql;
					$dresult = mysql_query($delsql);
				}
				echo "<font class='header2white'>No of Deleted Records: ".mysql_affected_rows()." </font>";
			}
	$pg = $pageNo -1;
	$limRange = $pg * $limit;
	$limit_filter = " LIMIT ".$limRange.",".$limit;	

	//mysql_select_db($database_courier);
	$query = "select * from userdata where 1=1 and role_id not in(select parameter_value from parameter where parameter_name='$user_role_session' )".$filter.$filteradmin.$searchdate.$order.$limit_filter;
	//echo $query;
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
                            <h1>User List</h1>
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
	      <option value="username" <?php echo ($searchby=='username')?"selected":""; ?>>Username</option>
	        <option value="role_name" <?php echo ($searchby=='role_name')?"selected":""; ?>>Role Name</option>
	      </select></td>
	    <td width="17%" align="right"> <span>Keyword:</span></td>
	    <td width="33%">
	      <input name="keyword" type="text" class="table_text1" id="keyword" value=""></td>  <td width="14%"><span class="submit">
	        <input name="search2" type="button" class="btn" id="search2" onclick="javascript:doSearch('user_list.php')" value="Search"></span>
	        </td></tr>
	  <tr>
	    <td align="right">Order:</td>
	    <td colspan="4"><select name="orderby" class="table_text1"  id="orderby">
	      <option value="username" <?php echo ($searchby=='username')?"selected":""; ?>>Username</option>
	        <option value="role_name" <?php echo ($searchby=='role_name')?"selected":""; ?>>Role Name</option>
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
    <select name="limit"   id="limit" onchange="javascript:doSearch('user_list.php');" style="width:100px;">
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
  <td width="271" align="left"><input name="search22" type="button" class="btn" id="search22" onclick="javascript:doSearch('user_list.php');" value="Go" /></td>
  <td width="49" colspan="-2" align="right"><span>&nbsp;</span></td>
  <td width="186" align="left">&nbsp;</td>
  <td width="34" colspan="-2"><span class="table_text1"><a href="#" onclick="javascript: goFirst('user_list.php');"><img src="images/first.png" alt="First" width="24" height="24" border="0" /></a></span></td>
  <td width="32" colspan="-2"><span class="table_text1"><a href="#" onclick="javascript: goPrevious('user_list.php');"><img src="images/prev.png" alt="Previous" width="24" height="24" border="0" /></a></span></td>
  <td width="32" colspan="-2"><span class="table_text1"><a href="#" onclick="javascript: goNext('user_list.php');"><img src="images/next.png" alt="Next" width="24" height="24" border="0"/></a></span></td>
  <td width="63" colspan="-2"><span class="table_text1"><a href="#" onclick="javascript: goLast('user_list.php');"><img src="images/last.png" alt="Last" width="24" height="24" border="0"/></a></span></td>
</tr>
</table>



<table width="100%">
  <tr>
  &nbsp;&nbsp;<input name="add_new" type="button" class="btn" id="search" onclick="getpage('user.php','page')" value="Add New">
  
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
    
    
    
   <table class="table">
                            <thead>
                                <tr>
								 <th width="34" align="center" valign="middle" nowrap="nowrap"><input type="checkbox" name="chkall" id="chkall" value="" onclick="javascript: if (this.checked) {doClickAll(this.form)} else {doUnClickAll(this.form)}"; /></th>
                                    <th nowrap="nowrap" style="width:10px;" width="39">S/N</th>
                                    <th nowrap="nowrap" align="left" >Username</th>
                                    <th nowrap="nowrap" align="left" >Role Name</th>
									 <th nowrap="nowrap" align="left" >First Name</th>
                                    <th nowrap="nowrap" align="left" >Last Name</th>
									<th nowrap="nowrap" align="left" >Status</th>
									<th nowrap="nowrap" align="left" >Posted By</th>
                                    <th nowrap="nowrap" align="left" >Created On</th>
									<th nowrap="nowrap" align="left" ></th>
                                </tr>
                            </thead>
                            <tbody>
    <?php 
							  $k = $pg * $limit;
							  while($row = mysql_fetch_array($result)){
							  $k++;
							  
							 ?>
                            
                                <tr>
                                    <td align="center" valign="middle" nowrap="nowrap">
									<input type="checkbox" name="chkopt" id="chkopt" value="<?php echo $row["username"];?>" /></td>
									<td nowrap="nowrap" align="left" >&nbsp;<?php echo $k+$skip;?>&nbsp;</td>
									<td nowrap="nowrap" align="left" >&nbsp;<?php echo $row['username'];?>&nbsp;</td>
									<td nowrap="nowrap" align="left" >&nbsp;<?php echo $dbobject->getitemlabel('role','role_id',$row["role_id"],'role_name');?>&nbsp;</td>
									<td nowrap="nowrap" align="left" >&nbsp;<?php echo $row["firstname"];?>&nbsp;</td>
									<td nowrap="nowrap" align="left" >&nbsp;<?php echo $row["lastname"];?>&nbsp;</td>
									<td align="left" nowrap="nowrap" ><a href="#" style="text-decoration:none" onclick="getpage('user_list.php?userlock2=<?php echo $row['username'];?>&val2=<?php echo $status;?>','page')"><?php echo $status==''?"<font color='black'>Off</font>":"<font color='red'>On</font>";?></a></td>
									<td align="left" nowrap="nowrap" ><?php echo $row["posted_user"];?></td>
									<td nowrap="nowrap" align="left" >&nbsp;<?php echo $row["created"];?>&nbsp;</td>
									<td nowrap="nowrap" align="left" >&nbsp; <a href="javascript:getpage('user.php?op=edit&username=<?php echo $row["username"];?>','page')">Edit</a> | &nbsp; <a href="javascript:if(confirm('Are you Sure you want to DELETE this User ?')){getpage('user_list.php?op=del&username=<?php echo $row["username"];?>','page');}">delete</a>
									</td>
                                </tr>
							<?php
							  }
							?>	                            
                            
                            </tbody>
                        </table>
                        <?php
                        if(mysql_num_rows($result)==0)
							  {
								  echo "<div align='center'>No Records Found</div>";
								  }

						?>
</div>
                       
                            
                        </div>
                    </div>                                

                </div>