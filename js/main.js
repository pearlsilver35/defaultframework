//////added by Turbo
function showHide(currdiv)
{
	if($('#override_wh').attr('checked'))
	{
		$('#extend_div').show('slow');
	}
	else 
	{
		$('#extend_div').hide('slow');
	}
}

/////////////// Generic Script ////////////////////////

function chkpasswordExp(opt){
	//alert('yes');
	if($("#userpassword").val()!= $("#confirm_userpassword").val())
	{
		$('#error_label_login').html('');
	    $('#error_label_login').show('fast');
		$("#display_message").html('Passwords do not match');
		$("#display_message").show('slow');
		$("#display_message").click();
		//$('#postbtn').attr("disabled","disabled");
		return false;
	}else{
		$("#display_message").html('');
		$("#display_message").show('slow');
		callpage(opt);
		$('#error_label_login').html('');
	    $('#error_label_login').show('fast');
		return true;
	}
}
 
function getValuetoHidden(str)
	{
	var data = $('#'+str).val();
	$('#'+str+'-fd').attr('value',data);
		if(data == 'Others')
		{
			//alert(data);
		$('#'+str+'-div').attr('style','display:;');
		}
		else
		{
		$('#'+str+'-div').attr('style','display:none;');
		}
	}
	
 function callPageEdit(str,pgload,divd)
{
	var operation = $("#operation").html();
	//alert(operation);
	var i = 0;
	var inpname = [];
	$("#form1").serialize();
	$.each($("input, select, textarea"), function(i,v) {
    var theElement = $(v);
	var theName = escape(theElement.attr('name'));
	inpname[i] = theName;
	i += 1;
	});
	var data = getdata();
	//alert(data);
	if(data!='error')
	{
		$.ajax({
			async: true,
	   		type: "POST", 
	   		url: "utilities.php", 
	   		data: "op=editTrans&operation="+operation+"&tableName="+str+'&'+data+"&inputs="+inpname,
	   		success: function(msg){
		 	//alert(msg);
			var myMsgTest = msg.split("::||::");
			if(myMsgTest[0]=='1')
			{ 
				$('#alertmsg').removeClass('alert-success');
				$('#alertmsg').removeClass('alert-error');
				$('#alertmsg').addClass('alert-success');
				$("#hhdd").html('Success!');
				$("#display_message").html(myMsgTest[1]);
			 	$("#display_message").show('fast');
			 	$("#alertmsg").show('fast');
				$("#opt").hide('fast');
				$("#addopt").show('fast');
				
			}else
			{
				$('#alertmsg').removeClass('alert-error');
				$('#alertmsg').removeClass('alert-success');
				$('#alertmsg').addClass('alert-error');
				$("#hhdd").html('Error !');
				$("#display_message").html(msg);
			 	$("#display_message").show('fast');
			 	$("#alertmsg").show('fast');
				$("#opt").hide('fast');
				$("#addopt").show('fast');
			}
			
			 msgarray = msg.split(":");
			if(pgload=='getTransCol' && msgarray[0] =='Successful' ){
				setTimeout("getTbRows('getTransCol')",500);
			}else if(pgload=='getItemlist' && msgarray[0] =='Successful' ){
				var data = "merchant_id-whr="+$("#merchant_id-whr").val();
				getGenid(data);
				setTimeout("getTbRows('getItemlist')",500);
			}else if(pgload!='' && msgarray[0] =='Successful' )
			 {
				setTimeout("getpage('"+pgload+"','"+divd+"')",3000);
			 }			 
	   } 
	     
  });
	}
}

function checkboxVal(obj){
	if(obj.checked){
		//alert('yes');
		$('#subbtn').attr('disabled','');
		$('#subbtn').attr('value','Register').show('slow');
	}else{
		$('#subbtn').attr('disabled','disabled');
		$('#subbtn').attr('value','Read the Terms Before Proceeding!').show('slow');
	}
	
}

function checklogin(formurl,formurlconvert){		
		$('#error_label_login').ajaxStart(function(){
		//$('#error_label_login').css({background-image: "url(../images/progress_bar.gif)"});
		$('#error_label_login').html('<img src="images/loading.gif" alt="" />loading please wait . . .');
		});
	
		var data = $("#userid").val();
		var data2 = $("#userpassword").val();
		//var data3 = $("#agent_radio").val();
		//alert(data+":"+data2);
		//error_label_login
		$.ajax({ 
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op=checklogin&username="+data+"&password="+data2, 
		   success: function(msg){  
			 msg = jQuery.trim(msg);
			console.log(msg);
			 $("#error_label_login").html('logging you in ...').show();
				if(msg==''){
					$("#error_label_login").html('<div class=\' alert alert-error \'>Please enter a valid Username and Password</div>').show();
				}
				else if(msg=='0'){
					$("#error_label_login").html('<div class=\' alert alert-error \'>Invalid username or password</div>').show();
				}
				else if(msg=='1'){
				//	alert(msg); 
				 $("#form1").attr("action",formurl);
				 $("#form1").submit();
				}
				else if(msg=='2'){
					$("#error_label_login").html('Your user profile has been disabled').show();
				}
				else if(msg=='3'){
					$("#error_label_login").html('Your user profile has been locked').show();
				}
				else if(msg=='4'){
					$("#error_label_login").html('You are not allowed to login on Sunday').show();
				}
				else if(msg=='5'){
					$("#error_label_login").html('You are not allowed to login on Monday').show();
				}
				else if(msg=='6'){
					$("#error_label_login").html('You are not allowed to login on Tuesday').show();
				}
				else if(msg=='7'){
					$("#error_label_login").html('You are not allowed to login on Wednesday').show();
				}
				else if(msg=='8'){
					$("#error_label_login").html('You are not allowed to login on Thursday').show();
				}
				else if(msg=='9'){
					$("#error_label_login").html('You are not allowed to login on Friday').show();
				}
				else if(msg=='10'){
					$("#error_label_login").html('You are not allowed to login on Saturday').show();
				}
				else if(msg=='11'){
					$("#error_label_login").html('You are not allowed to login at this time <br> The time is not within the working hours').show();
				}
				else if(msg=='12'){
					$("#error_label_login").html('Your profile has been Locked, please contact Administrator').show();
				}
				else if(msg=='13'){
					$("#error_label_login").html("Your password has expired, <br><a href='change_password_exp.php?id="+data+"'> click here to change password </a>").show();
				}
				else if(msg=='14'){
					$("#error_label_login").html("You are required to change your password, <br><a href='change_password_logon.php?id="+data+"'> click here to change password </a>").show();
				}else if(msg=='15'){
					$("#error_label_login").html("You did not logout the last time you logged in. Pls Login again .. ").show();
				}
				else{
					$("#error_label_login").html('Invalid username or password'+msg).show();
				}
		   } 
		 });
		//alert(data);
		return false;
}

function chkpassword(opt)
{
	//alert($("#userpassword").val());
	//alert($("#confirm_userpassword").val());
	if($("#userpassword").val()!= $("#confirm_userpassword").val())
	{
		$("#display_message").html('Passwords do not match');
		$("#display_message").show('slow');
		$("#display_message").click();		
		return false;
	}
	else
	{
		$("#display_message").html('');
		$("#display_message").show('slow');
		callpage(opt);
		return true;
	}
}



function getdata()
{
	var data = "";
	$("#form1").serialize();
	$.each($("input, select, textarea"), function(i,v) {
    var theTag = v.tagName;
    var theElement = $(v);
	var theName = theElement.attr('name');
    var theValue = escape(theElement.val());
	var classname = theElement.attr('class');
	//alert('name : '+theName+"   value :"+theValue+"  class :"+classname);
	if(classname=='required-text')
	{
		if(!check_textvalues(theElement)) data = "error";
	}
	if(classname=='required-number')
	{
		if(!check_numbers(theElement)) data = "error";
	}
	if(classname=='required-email')
	{
		if(!check_email(theElement)) data = "error";
	}
	if(classname=='not-required-email')
	{
		if(!check_email(theElement)) data = "error";
	}
	if(classname=='required-alphanumeric')
	{
		if(!check_password_aplhanumeric(theElement)) data = "error";
	}
	if(classname=='required-password')
	{
		if(!check_password(theElement)) data = "error";
	}
	if(classname=='required-captcha')
	{
		if(!check_captcha(theElement)) data = "error";
	}
	if(data!='error')
	{
		data = data+theName+"="+theValue+"&";
	}
	});
	//alert(data);
	return data;
}

function callpage(page)
{
	
	//alert(page);
var data = getdata();

	if(data!='error')
	{
		
		//$("#display_message").ajaxStart(function(){
			$.blockUI({ message:'<img src="images/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .'});
		//});

		$.ajax({ 
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op="+page+"&"+data, 
		  
		   success: function(msg){ 
		  // alert(data);
			 //alert( "Data Saved: " + msg ); 
			 console.log(msg);
			  msg = jQuery.trim(msg)
			$.unblockUI();
			 	if(msg == 1){
					//alert('we');
					$("#display_message").html("Login Successful");
			 $("#display_message").show("fast");
				
					 //getpage('reg_confirmation.php','main_body');
					 $("#form1").attr("action","home.php");
				 $("#form1").submit();
				}
				else 
				{
				//alert(page);
			$("#display_message").html(msg);
			 $("#display_message").show("fast");
			$("#display_message").click();
				if(msg.indexOf("Error")<0)
				{
				
				if(page=='save_role')
				{
				getpage('role_list.php','page');
				}
				
				if(page=='save_user')
				{
				getpage('user_list.php','page');
				}
				
				if(page=='save_menu')
				{
				getpage('menu_list.php','page');
				}
				
				
				
				}
				}
		   		}
 				});
		//alert('yes');
	}
}

function callpost(page)
{
	//alert(page);
//var data = getdata();

//	if(data!='error')
//	{
		
		//$("#display_message").ajaxStart(function(){
			//$.blockUI({ message:'<img src="images/loading.gif" alt=""/><br />processing request please wait . . .'});
		//});
		$.ajax({ 
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op="+page,//+"&"+data, 
		  
		   success: function(msg){ 
			//alert(msg);		
			$("#ticker").html(msg);
			 $("#ticker").show("fast");

							   } 
		 });
	//}
}

function check_textvalues(formElement)
{
	if(triminput(formElement.val())==''){
		$("#display_message").html('<div class="alert alert-error">please enter value for :'+formElement.attr('title')+"</div>");
		$("#display_message").show('fast');
		formElement.focus();
		$("#display_message").click();
		return false;
	}else return true;
}

function check_numbers(formElement)
{
		if(triminput(formElement.val())==''){
			$("#display_message").html('<div class="alert alert-error">please enter number for : '+formElement.attr('title')+"</div>");
			$("#display_message").show('fast');
			formElement.focus();
			$("#display_message").click();
			return false;
		}
		if(isNaN(formElement.val())){
			$("#display_message").html('<div class="alert alert-error">please enter number for : '+formElement.attr('title')+"</div>");
			$("#display_message").show('fast');
			formElement.focus();
			$("#display_message").click();
			return false;
		}else return true;	
}

function check_email(formElement)
{
	var emails = formElement.val();
	emailRegEx = /^[^@]+@[^@]+.[a-z]{2,}$/i;
	if (emails=="")return true;
	if((formElement.val()).search(emailRegEx) == -1)
	{
		$("#display_message").html('<div class="alert alert-error">please enter valid email for : '+formElement.attr('title')+"</div>");
		$("#display_message").show('fast');
		formElement.focus();
		$("#display_message").click();
		return false;
	}
	else return true;
}

function check_captcha(formElement)
{
	var captcha = formElement.val();
	var captcha_sess = $('#captcha_sess').val();
	//alert(captcha);
	//alert(captcha_sess);
	if(captcha != captcha_sess)
	{
		$("#display_message").html('<div class="alert alert-error">Please Enter Figures Displayed in ImageCaptcha into textbox above</div>');
		$("#display_message").show('fast');
		formElement.focus();
		$("#display_message").click();
		return false;
	}
	else return true;
}

function check_password_aplhanumeric(formElement)
{
		var f1 = /[A-Z]/
		var f2 = /[a-z]/
		var f3 = /[0-9]/
		
		if((f1.test(formElement.val()) || f2.test(formElement.val())) && f3.test(formElement.val())){
		//alert('passed');
        return true;
		}else {
		$("#display_message").html('<div class="alert alert-error">please enter alphanumeric as password</div>');
		$("#display_message").show('fast');
		//alert('failed');
		formElement.focus();
		$("#display_message").click();
		return false;
		}
		
}

function check_password(formElement)
{
var password = formElement.val();
var errorval = '';
var passed = validatePassword(password, {
	length:   [6, 8],
	lower:    0,
	upper:    0,
	numeric:  0,
	special:  0,
	badWords: ["password", "steven", "levithan"],
	badSequenceLength: 4
});
	if((!chkpassword()) || (!passed)) 
	{
		$("#display_message").html(errorval);
		$("#display_message").show('fast');
		//alert('failed');
		formElement.focus();
		$("#display_message").click();
		return false;
	}
}

function triminput(inputString) 
{
	var removeChar = ' ';
	var returnString = inputString;

	if (removeChar.length)
	{
	  while(''+returnString.charAt(0)==removeChar)
		{
		  returnString=returnString.substring(1,returnString.length);
		}

		while(''+returnString.charAt(returnString.length-1)==removeChar)

	  {

	    returnString=returnString.substring(0,returnString.length-1);

	  }

	}

	return returnString;
}

function checkOption(obj)
{
	if(obj.checked){
		obj.value='1';
	}else{
		obj.value='0';
		obj.checked=false;
		//alert(obj.value);
	}
}

function ttoggleOption()
{
	$.each($('input:checkbox'), function(i,v) {
		  if ($(this).is(':checked')){
			   $(this).val('1');
		  }else{
			   $(this).val('0');
		  }
	});
}

function callpagepost(str,divid){
//	 $("#form1").attr("target","");
	// $("#form1").attr("action",returnpage);
	 //$("#form1").submit();
 
	var data = getdata();
	
	if(data!='error')
	{		
		//$("#display_message").ajaxStart(function(){
			$.blockUI({ message:'<img src="images/loading.gif" alt=""/><br />processing request please wait . . .'});
		//});

	//alert(data);
			/*
			$(divid).ajaxStart(function(){
			$(divid).html('');
			$(divid).html('<img src="images/loading.gif" alt="" />loading please wait . . .');
			});
			*/
			if(str!='#'){
				//trapSession();
				
				
				$.blockUI({ message:'<img src="images/loading.gif" alt=""/>&nbsp;&nbsp;loading please wait . . .'});
				//$("#display_message").html('<img src="images/loading.gif" alt="" />loading please wait . . .');
				
			$.ajax({ 
			   type: "POST", 
			   url: str, 
			   data: data, 
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				 //alert(msg);
				 
				 
				 
				 $('#'+divid).html(msg);
				 $.unblockUI();
				 //$("#display_message").html("");
			   } 
			 });
			/*	
			 $(divid).ajaxComplete(function(){ 
				$(divid).html(""); 
			 });
			*/
			}// end if


	}

}

function getpage(str,divid) 
{ 
	//var data = getdata();
	//alert(data);
			/*
			$(divid).ajaxStart(function(){
			$(divid).html('');
			$(divid).html('<img src="images/loading.gif" alt="" />loading please wait . . .');
			});
			*/
			if(str!='#'){
				$.blockUI({ message:'<img src="images/loading.gif" alt=""/>&nbsp;&nbsp;loading please wait . . .'});
				//$("#display_message").html('<img src="images/loading.gif" alt="" />loading please wait . . .');
				
			$.ajax({ 
			   type: "POST", 
			   url: str, 
			   data: '',
			   //timeout:1000, 
			   error: function(x, t, m) {
				  // $.unblockUI();
				   $.blockUI({ message:'Error Loading Page'});
				   setTimeout(function(){$.unblockUI()},2000);
				   },
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				 //alert(msg);
				 $('#'+divid).html(msg).animate();
				 $.unblockUI();
				 //$("#display_message").html("");
			   } 
			 });
			/*	
			 $(divid).ajaxComplete(function(){ 
				$(divid).html(""); 
			 });
			*/
			}// end if
}

function doSearch(url)
{
	//alert('Got here');
	//$("#form1").submit();
	var data = getdata();
	//alert("@ Search : "+data);
	//loadpage('branch_list.php',data,'page');
	getpage(url+'?'+data,'page');
}
function doSearch1(url,divid)
{
	//alert('Got here');
	//$("#form1").submit();
	var data = getdata();
	//alert("@ Search : "+data);
	//loadpage('branch_list.php',data,'page');
	getpage(url+'?'+data,divid);
}



function goFirst(dpage)
{
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(fpage!=1){
		$("#fpage").get(0).value = '1';
		$("#pageNo").get(0).value = 1;
		doSearch(dpage);
	}else{
		return false;
	}
}

function goLast(dpage)
{
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(lpage!=fpage){
		$("#fpage").get(0).value = lpage;
		$("#pageNo").get(0).value = lpage;
		doSearch(dpage);
	}else{
		return false;
	}

}

function goPrevious(dpage)
{
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(fpage !=1){
		$("#fpage").get(0).value = fpage-1;
		$("#pageNo").get(0).value = fpage-1;
		doSearch(dpage);
	}else{
		return false;
	}

}

function goNext(dpage)
{
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if((lpage > fpage)){
		$("#fpage").get(0).value = fpage+1;
		$("#pageNo").get(0).value = fpage+1;
		doSearch(dpage);
	}else{
		return false;
	}

}

function doClickAll(form) 
{
	var form = document.getElementById("form1");
	for (var i = 0; i < form.elements.length; i++) {
		if (form.elements[i].type == "checkbox") {
			if ( !form.elements[i].checked ) { form.elements[i].click();
			}
		}
    }
	return true;
}

function doUnClickAll(form) 
{
	for (var i = 0; i < form.elements.length; i++) {
		if ( form.elements[i].type == "checkbox") {
			if (  form.elements[i].checked ) { form.elements[i].checked = false;
			}
		}
	}
	return true;
  }

 
function checkSelected(form, url)
{
  //var form = document.forms[0];
  var parString = "";
  var delcount = 0;
  for(var i = 0; i < form.elements.length; ++i)
   if(form.elements[i].type == "checkbox" & form.elements[i].name == 'chkopt')
    if(form.elements[i].checked == true){
    	delcount++;
      parString =  parString + "-" + form.elements[i].value+"-, ";
      }

  if(parString == "") {
   window.alert("Select record(s) to continue...");
   return (false);
  }
  else {
	//delcount = delcount - 1;
	form.var1.value = parString;
	form.op.value = 'del';
  	ans=window.confirm("You have selected " + delcount + " record(s), Are your sure ?")
  	if (ans == 1){doSearch(url);
	return false;
	}
	else return false;
   }
  }
function checkSelected1(form, url, divid)
{
  //var form = document.forms[0];
  var parString = "";
  var delcount = 0;
  for(var i = 0; i < form.elements.length; ++i)
   if(form.elements[i].type == "checkbox" & form.elements[i].name == 'chkopt')
    if(form.elements[i].checked == true){
    	delcount++;
      parString =  parString + "-" + form.elements[i].value+"-, ";
      }

  if(parString == "") {
   window.alert("Check Friend(s) to continue...");
   return (false);
  }
  else {
	//delcount = delcount - 1;
	form.var1.value = parString;
	form.op.value = 'del';
  	ans=window.confirm("You have selected " + delcount + " Friend(s), Are your sure ?")
  	if (ans == 1){doSearch1(url,divid);
	return false;
	}
	else return false;
   }
  }
  
function printDiv(seldiv)
{
  var divToPrint=document.getElementById(seldiv);
  var newWin=window.open();
  newWin.document.open();
  newWin.document.write('<html><link rel="stylesheet" type="text/css" href="css/merchant.css"><body>'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  //setTimeout(function(){newWin.close();},20);
}

function printReceipt(seldiv)
{
  var divToPrint=document.getElementById(seldiv);
  var newWin=window.open();
  /*newWin.document.open();*/
  newWin.document.write('<html><link rel="stylesheet" type="text/css" href="css/style.css"><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  //setTimeout(function(){newWin.close();},20);
}


function blockUIDiv(divid)
{
	//$('#'+divid).click(function() { 
        $.blockUI({ message: $('#'+divid) }); 
 
        //setTimeout($.unblockUI, 2000); 
    //}); 
}
function calldialog(divid){
//$('#'+divid).dialog();
$.blockUI({ message: $('#'+divid) });
setTimeout($.unblockUI, 2000);
}

function loadroles(){
	var data = escape($('#menu_id').val());
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getnonexistrole&menu_id="+data, 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#non_exist_role").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });
   // for existing roles
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getexistrole&menu_id="+data, 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#exist_role").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });  
}

function moveuprole() {
   var listField = document.getElementById('exist_role');
   if ( listField.length == -1) {  // If the list is empty
      alert("There are no values which can be moved!");
   } else {
      var selected = listField.selectedIndex;
      if (selected == -1) {
         alert("You must select an entry to be moved!");
      } else {  // Something is selected
         if ( listField.length == 0 ) {  // If there's only one in the list
            alert("There is only one entry!\nThe one entry will remain in place.");
         } else {  // There's more than one in the list, rearrange the list order
            if ( selected == 0 ) {
               alert("The first entry in the list cannot be moved up.");
            } else {
               // Get the text/value of the one directly above the hightlighted entry as
               // well as the highlighted entry; then flip them
               var moveText1 = listField[selected-1].text;
               var moveText2 = listField[selected].text;
               var moveValue1 = listField[selected-1].value;
               var moveValue2 = listField[selected].value;
               listField[selected].text = moveText1;
               listField[selected].value = moveValue1;
               listField[selected-1].text = moveText2;
               listField[selected-1].value = moveValue2;
               listField.selectedIndex = selected-1; // Select the one that was selected before
            }  // Ends the check for selecting one which can be moved
         }  // Ends the check for there only being one in the list to begin with
      }  // Ends the check for there being something selected
   }  // Ends the check for there being none in the list
}//endmoveuprole() 
  
  
  
  function movedownrole() {
	var listField = document.getElementById('exist_role');
   if ( listField.length == -1) {  // If the list is empty
      alert("There are no values which can be moved!");
   } else {
      var selected = listField.selectedIndex;
      if (selected == -1) {
         alert("You must select an entry to be moved!");
      } else {  // Something is selected
         if ( listField.length == 0 ) {  // If there's only one in the list
            alert("There is only one entry!\nThe one entry will remain in place.");
         } else {  // There's more than one in the list, rearrange the list order
            if ( selected == listField.length-1 ) {
               alert("The last entry in the list cannot be moved down.");
            } else {
               // Get the text/value of the one directly below the hightlighted entry as
               // well as the highlighted entry; then flip them
               var moveText1 = listField[selected+1].text;
               var moveText2 = listField[selected].text;
               var moveValue1 = listField[selected+1].value;
               var moveValue2 = listField[selected].value;
               listField[selected].text = moveText1;
               listField[selected].value = moveValue1;
               listField[selected+1].text = moveText2;
               listField[selected+1].value = moveValue2;
               listField.selectedIndex = selected+1; // Select the one that was selected before
            }  // Ends the check for selecting one which can be moved
         }  // Ends the check for there only being one in the list to begin with
      }  // Ends the check for there being something selected
   }  // Ends the check for there being none in the list
}// endmovedown
 
  
  
function addrole(){
	return !$('#non_exist_role option:selected').remove().appendTo('#exist_role'); 
}
function removerole(){
	return !$('#exist_role option:selected').remove().appendTo('#non_exist_role');
}
function selectalldata(){
	$("#exist_role *").attr("selected","selected");
}

function toggleOption(){
	$("input[type=checkbox]").each(
		  function() {
		   if($(this).is(':checked')){
		   var idname = $(this).attr('id');
		    $(this).val(idname);
			//alert($(this).val());
		   }else{
		   		$(this).val('');
		   }
		  }
	);
	
}

function Resize(imgId,division_1, division_2)
{
  var img = document.getElementById(imgId);
  var w = img.width, h = img.height;
  w /= division_1; h /= division_2;
  img.width = w; img.height = h;
}


function selectalllist(list){
	$("#"+list+" *").attr("selected","selected");
}
/////////////////

function pageloader(str,divid) 
{ 
	var data = getdata();
	//alert(data);
	if(data!='error') {
	$.ajax({ 
	   type: "POST", 
	   url: str, 
	   data: data, 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(msg);
		 $('#'+divid).html(msg);
		 //$("#display_message").fadeIn("slow");
	   } 
	 });
	}
}
///////////////////////////////////
function moveUpList(listField) {
   if ( listField.length == -1) {  // If the list is empty
      alert("There are no values which can be moved!");
   } else {
      var selected = listField.selectedIndex;
      if (selected == -1) {
         alert("You must select an entry to be moved!");
      } else {  // Something is selected 
         if ( listField.length == 0 ) {  // If there's only one in the list
            alert("There is only one entry!\nThe one entry will remain in place.");
         } else {  // There's more than one in the list, rearrange the list order
            if ( selected == 0 ) {
               alert("The first entry in the list cannot be moved up.");
            } else {
               // Get the text/value of the one directly above the hightlighted entry as
               // well as the highlighted entry; then flip them
               var moveText1 = listField[selected-1].text;
               var moveText2 = listField[selected].text;
               var moveValue1 = listField[selected-1].value;
               var moveValue2 = listField[selected].value;
               listField[selected].text = moveText1;
               listField[selected].value = moveValue1;
               listField[selected-1].text = moveText2;
               listField[selected-1].value = moveValue2;
               listField.selectedIndex = selected-1; // Select the one that was selected before
            }  // Ends the check for selecting one which can be moved
         }  // Ends the check for there only being one in the list to begin with
      }  // Ends the check for there being something selected
   }  // Ends the check for there being none in the list
   return false;
}

function moveDownList(listField) {
   if ( listField.length == -1) {  // If the list is empty
      alert("There are no values which can be moved!");
   } else {
      var selected = listField.selectedIndex;
      if (selected == -1) {
         alert("You must select an entry to be moved!");
      } else {  // Something is selected 
         if ( listField.length == 0 ) {  // If there's only one in the list
            alert("There is only one entry!\nThe one entry will remain in place.");
         } else {  // There's more than one in the list, rearrange the list order
            if ( selected == listField.length-1 ) {
               alert("The last entry in the list cannot be moved down.");
            } else {
               // Get the text/value of the one directly below the hightlighted entry as
               // well as the highlighted entry; then flip them
               var moveText1 = listField[selected+1].text;
               var moveText2 = listField[selected].text;
               var moveValue1 = listField[selected+1].value;
               var moveValue2 = listField[selected].value;
               listField[selected].text = moveText1;
               listField[selected].value = moveValue1;
               listField[selected+1].text = moveText2;
               listField[selected+1].value = moveValue2;
               listField.selectedIndex = selected+1; // Select the one that was selected before
            }  // Ends the check for selecting one which can be moved
         }  // Ends the check for there only being one in the list to begin with
      }  // Ends the check for there being something selected
   }  // Ends the check for there being none in the list
   return false;
}

function validatePassword (pw, options) {
	// default options (allows any password)
	var o = {
		lower:    0,
		upper:    0,
		alpha:    0, /* lower + upper */
		numeric:  0,
		special:  0,
		length:   [0, Infinity],
		custom:   [ /* regexes and/or functions */ ],
		badWords: [],
		badSequenceLength: 0,
		noQwertySequences: false,
		noSequential:      false
	};

	for (var property in options)
		o[property] = options[property];

	var	re = {
			lower:   /[a-z]/g,
			upper:   /[A-Z]/g,
			alpha:   /[A-Z]/gi,
			numeric: /[0-9]/g,
			special: /[\W_]/g
		},
		rule, i;

	// enforce min/max length
	if (pw.length < o.length[0] || pw.length > o.length[1])
		errorval = 'Password Minimum Length is '+o.length[0]+' While Maximum Lenght Should not exceed '+o.length[1]; 
		return false;

	// enforce lower/upper/alpha/numeric/special rules
	for (rule in re) {
		if ((pw.match(re[rule]) || []).length < o[rule])
		errorval = 'Password Should contain lower/upper/alpha/numeric/'; 
			return false;
	}

	// enforce word ban (case insensitive)
	for (i = 0; i < o.badWords.length; i++) {
		if (pw.toLowerCase().indexOf(o.badWords[i].toLowerCase()) > -1)
		
			return false;
	}

	// enforce the no sequential, identical characters rule
	if (o.noSequential && /([\S\s])\1/.test(pw))
		return false;

	// enforce alphanumeric/qwerty sequence ban rules
	if (o.badSequenceLength) {
		var	lower   = "abcdefghijklmnopqrstuvwxyz",
			upper   = lower.toUpperCase(),
			numbers = "0123456789",
			qwerty  = "qwertyuiopasdfghjklzxcvbnm",
			start   = o.badSequenceLength - 1,
			seq     = "_" + pw.slice(0, start);
		for (i = start; i < pw.length; i++) {
			seq = seq.slice(1) + pw.charAt(i);
			if (
				lower.indexOf(seq)   > -1 ||
				upper.indexOf(seq)   > -1 ||
				numbers.indexOf(seq) > -1 ||
				(o.noQwertySequences && qwerty.indexOf(seq) > -1)
			) {
				return false;
			}
		}
	}

	// enforce custom regex/function rules
	for (i = 0; i < o.custom.length; i++) {
		rule = o.custom[i];
		if (rule instanceof RegExp) {
			if (!rule.test(pw))
				return false;
		} else if (rule instanceof Function) {
			if (!rule(pw))
				return false;
		}
	}

	// great success!
	return true;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////js by SAMABOS//////////////////////////////////

function callpagepost2(page,opt,returnpage,divid)
{
	var data = getdata();
	//alert(data);
	var poststatus = true;
		if(data!='error') 
		{
			//$('#error_label_login').css({background-image: "url(../images/progress_bar.gif)"});
			$.blockUI({ message:'<img src="images/loading.gif" alt=""/>&nbsp;&nbsp;loading please wait . . .'});
		//alert(poststatus);
		if(poststatus==true)
		{
			$.ajax({ 
			   type: "POST", 
			   url: "utilities.php", 
			   data: "op="+page+"&"+data, 
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				 //alert(data);
				 $.unblockUI();
				 $("#display_message").html(msg);
				 $("#display_message").show("fast");
				 $("#display_message").click();
				 setTimeout("callresponse('"+returnpage+"','"+divid+"','"+msg+"')",2000);	

		   } 
		 });
		} // end poststatus
	}
}

function callresponse(returnpage,divid,msg)
{
	var resp = msg.split("/");
	if(resp[1]=='1')
	{
		$("#display_message").html(resp[0]);
		$("#display_message").show("fast");
		$.unblockUI();
		doSubmit(returnpage,divid);
	}
	else
	{
		$("#display_message").html(resp[0]);
		$("#display_message").show("fast");
		$.unblockUI();
	}
}

function doSubmit(url,pgdiv)
{
	//alert('Got here');
	//$("#form1").submit();
	var data = getdata();
	//alert("@ Search : "+data);
	//loadpage('branch_list.php',data,'page');
	getpage(url+'?'+data,pgdiv);
}








function doTransEntry(page,divd){
//callPageEdit('transaction_extension','','');
	var trans_ext_id = $('#trans_ext_id-fd').val();
	//alert(trans_ext_id);
	//var page = page+"?transId="+trans_ext_id;
	var i = 0;
	var inpname = [];
	$("#form1").serialize();
	$.each($("input, select, textarea"), function(i,v) {
    var theElement = $(v);
	var theName = escape(theElement.attr('name'));
	inpname[i] = theName;
	i += 1;
	});
	
	var data = getdata();
	//alert(data);
	if(data!='error')
	{
		$.blockUI({ message:'<img src="images/loading.gif" alt=""/>&nbsp;&nbsp;loading please wait . . .'});
		$.ajax({
			async: true,
	   		type: "POST", 
	   		url: "utilities.php", 
	   		data: "op=doTransEntry&"+data+"&inputs="+inpname,
	   		success: function(msg){
				var msgarr = msg.split(':');
				if(msgarr[0]=='SUCCESSFUL' && page != ''){
				$("#display_message").html(msg);
				$("#display_message").show();
				setTimeout("getpage('"+page+"','"+divd+"')",2000);	
					}else{
				$("#display_message").html(msg);
				$("#display_message").show();	
					}
//				setTimeout("getpage('"+pgload+"','"+divd+"')",3000);

			 $.unblockUI();
			}
	     
  		});
  	
  	}
	
}

function updateUser(strr,str)
{
	//alert('yes');
	//$("#resu").css("text-align", "center");
	if(strr=='101' && str!="")
	{
		$("#resu").html('Welcome '+str+' <font color="#009900">You are now logged in</font>');
		$(".rerun").show();
		$("#resu_recharge").show(); 
		$("#resu_balance").show();	
		$("#error_label_loginn").hide(); 
		$("#sresu").hide();
		return true;
	}else
	{
		$("#display_message").html('Invalid Username or Password');
		$("#display_message").show('fast');
		return false;
	}
}

		
function getCustomerDetails(str)
{
	//alert('yes');
	$("#SubmitBtn").attr("disabled", "disabled");
	var merchant_id = $('#merchant_id-fd').val();
	$("#customerinfo").html('<img src="images/loading.gif" alt="" />loading please wait . . .');
	$("#customerinfo").show("fast");
	$.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCustomerDetails&str="+str+"&merchant_id="+merchant_id, 
	   success: function(msg){
		   //alert(msg);
		   if(msg.indexOf('NO DETAILS FOUND')<0)
		   {
			$("#SubmitBtn").removeAttr("disabled");
		   $("#customerinfo").html(msg);
		   $("#customerinfo").show("fast");
		   }
		   else
		   {
		   $("#customerinfo").html(msg);
		   $("#customerinfo").show("fast");
		   }
		   
		   }
	});
}
		
function calldownload(){
	//
	var data = $('#sql').val();
	var data2 = $('#filename').val();
	//alert(data);
	window.open("download.php?sql="+escape(data)+"&filename="+data2,"mydownload","status=0,toolbar=0");
}

function callPageFormRequest(str,frmid)
{
	var data = getDatta(frmid);
	//alert(data);
	if(data!='error')
	{
		$.blockUI({ message:'<img src="images/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .'});
		
		$.ajax({ 
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op="+str+'&'+data, 
		   success: function(msg){
				//alert(msg);
				var myMsgTest = msg.split("::||::");
				if(myMsgTest[0]=='1')
				{ 
					$('#alertmsg').removeClass('alert-success');
					$('#alertmsg').removeClass('alert-error');
					$('#alertmsg').addClass('alert-success');
					$("#hhdd").html('Success!');
					$("#display_message").html(myMsgTest[1]);
					$("#display_message").show('fast');
					$("#alertmsg").show('fast');
					$("#opt").hide('fast');
					$("#addopt").show('fast');
					
				}else
				{
					$('#alertmsg').removeClass('alert-error');
					$('#alertmsg').removeClass('alert-success');
					$('#alertmsg').addClass('alert-error');
					$("#hhdd").html('Error !');
					$("#display_message").html(msg);
					$("#display_message").show('fast');
					$("#alertmsg").show('fast');
					$("#opt").hide('fast');
					$("#addopt").show('fast');
				}
				$.unblockUI();
		   } 
			 
	   });
	}
}

function getDataRefined(){
	var data = "";
	//$("#form1").serialize();
	$.each($("input, select, textarea"), function(i,v) {
		var theTag = v.tagName;
		var theElement = $(v);
		var theName = theElement.attr('name');
		var theValue = encodeURIComponent(theElement.val());
		var classname = theElement.attr('class');
		var altVal = theElement.attr('alt');
		if(theElement.hasClass('required-text'))
		{
			if(!check_textvalues(theElement)) data = "error";
		}
		if(theElement.hasClass('required-number'))
		{
			if(!check_numbers(theElement)) data = "error";
		}
		if(theElement.hasClass('required-email'))
		{
			if(!check_email(theElement)) data = "error";
			
		}
		if(theElement.hasClass('required-alphanumeric'))
		{
			if(!check_password_aplhanumeric(theElement)) data = "error";
		}
		if(data!='error')
		{
			data = data+theName+"="+theValue+"&";
		}
	});
	//alert(data);
	return data;
}
