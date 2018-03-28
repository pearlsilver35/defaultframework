<?php
	
//////////////////call nusoap class ////////////////////////
require_once ('nusoap.php'); 
///////////////////////////////////////
//////////////////////

class wcclient
{

	function doDepositWC($customerName,$portalId,$amount,$sourceAccount,$destAccount,$transId){
	//ob_start();
	//try
	//{
		$param_var = array('customerName'=>$customerName,'portalId'=>$portalId,'amount'=>$amount,'sourceAccount'=>$sourceAccount,'destAccount'=>$destAccount,'transId'=>$transId);
		$client = new nusoap_client(//'http://127.0.0.1:8000/WaiseConnect/WaiseConnect?wsdl');
		
		'http://192.168.3.239:8080/WaiseConnectWS/WaiseConnect?wsdl');
		
		//$client->setHTTPProxy('192.168.123.251','808','tobi','access');
		//$client = new soapclient('http://74.213.179.202/WS-API/pick_msg_Server.php');
		$err = $client->getError();
		if ($err) {
			// Display the error
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
			// At this point, you know the call that follows will fail
		}
		// Call the SOAP method
		$result = $client->call('postTransaction',$param_var,'http://ws.access.com/');
		// Check for a fault
		if ($client->fault) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
		} else {
			// Check for errors
			$err = $client->getError();
			if ($err) {
				// Display the error
				echo '<h2>Error</h2><pre>' . $err . '</pre>';
			} else {
				
				return $result."::".$amount;
				// Display the result
			   // echo '<h2>Result</h2><pre>';
				//print_r($result);
				
				#$json = '{"foo-bar": 12345}';
				//print $result;
				//$obj = json_decode($result);
				//print 'return = '.$obj->{'return'}.'<br>';
				
				//return $result;
			//echo '</pre>';
			}
		
		}
	//}catch(Exception $ex){
	//	ob_end_clean();
	//	displayErrorPage($e->getMessage());
//	}
	}

	
///////////////////////////Kunle Transaction Reversal///////////////////////////////////////
function doTransReverse($customerName,$portalId,$amount,$sourceAccount,$destAccount,$transId)
{
		//echo "$customerName,$portalId,$amount,$terminalId,$transId";
		//////////////////////
		
		$param_var = array('customerName'=>$customerName,'portalId'=>$portalId,'amount'=>$amount,'sourceAccount'=>$sourceAccount,'destAccount'=>$destAccount,'transId'=>$transId);
		$client = new nusoap_client(//'http://127.0.0.1:8000/WaiseConnect/WaiseConnect?wsdl');
	'http://192.168.3.239:8080/WaiseConnectWS/WaiseConnect?wsdl');
	
	
		//$client = new soapclient('http://74.213.179.202/WS-API/pick_msg_Server.php');
		$err = $client->getError();
		if ($err) {
			// Display the error
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
			
			// At this point, you know the call that follows will fail
		}
		// Call the SOAP method
		$result = $client->call('reverseTransaction',$param_var,'http://ws.access.com/');
		// Check for a fault
		if ($client->fault) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
		} else {
			// Check for errors
			$err = $client->getError();
			if ($err) {
				// Display the error
				echo '<h2>Error</h2><pre>' . $err . '</pre>';
			} 
			else {
				
				return $result;
					}
		}
		
	}
////////////////////////////////////////////////////////////////////////////////////////////
	
	



	function eHajjWCClient($TransID,$portalId,$amount,$customerName,$Date,$URL) {
		
		 $host = 'http://127.0.0.1:8000/WaiseConnect/connHttp';
		 $URL = 'http://www.accessng.com/EHAJJ2/eHajjWCServer2.php';
		 $param_var = 'url='.$URL.'&param='.urlencode("TransID=$TransID&portalId=$portalId&amount=$amount&customerName=$customerName&Created=$Date&par=doPostPortalTrans");		 
		
		  //$proxy = '10.10.0.96:8080';//Proxy IP and Port
		  //$proxyauth = 'transaction.alert:Money123';
		  $proxy = '192.168.123.251:808';//Proxy IP and Port
		  $proxyauth = 'tobi:access';
		  //$EhajjID = 'EHAJJ/0023/ABJ/2012';
		  //$post_fields = 'GetPortalID='.$portalId;
		  ///////////////////
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL,$host);
		  //curl_setopt($ch, CURLOPT_PROXY, $proxy);
		  //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
		  curl_setopt($ch, CURLOPT_VERBOSE, '1');
		  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');
		  curl_setopt($ch, CURLOPT_POST, 1);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $param_var); // Pass form Fields. 
		  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_HEADER, 0);
		  $curl_scraped_page = curl_exec($ch);
		  /////////////////////
		  if (!empty($curl_scraped_page)) 
		  {
			return $curl_scraped_page;
		  } 
		  else 
		  {
			 echo curl_error($ch);
		  }
		  ///////////////
		  curl_close($ch);
		
	}




	function eHajjWCClientReversal($TransID,$portalId,$amount,$customerName,$Date,$URL){
		
		 $host = 'http://127.0.0.1:8000/WaiseConnect/connHttp';
		 $URL = 'http://www.accessng.com/EHAJJ2/eHajjWCServer2.php';
		 $param_var = 'url='.$URL.'&param='.urlencode("TransID=$TransID&portalId=$portalId&amount=$amount&customerName=$customerName&Created=$Date&par=doPostPortalTransReversal");

		
		  //$proxy = '10.10.0.96:8080';//Proxy IP and Port
		  //$proxyauth = 'transaction.alert:Money123';
		  $proxy = '192.168.123.251:808';//Proxy IP and Port
		  $proxyauth = 'tobi:access';
		  //$EhajjID = 'EHAJJ/0023/ABJ/2012';
		  //$post_fields = 'GetPortalID='.$portalId;
		  ///////////////////
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL,$host);
		  //curl_setopt($ch, CURLOPT_PROXY, $proxy);
		  //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
		  curl_setopt($ch, CURLOPT_VERBOSE, '1');
		  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');
		  curl_setopt($ch, CURLOPT_POST, 1);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $param_var); // Pass form Fields. 
		  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_HEADER, 0);
		  $curl_scraped_page = curl_exec($ch);
		  /////////////////////
		  if (!empty($curl_scraped_page)) 
		  {
			 //echo $curl_scraped_page;
			return $curl_scraped_page;
		  } 
		  else 
		  {
			 echo curl_error($ch);
		  }
		  ///////////////
		  curl_close($ch);
		
	}

function eHajjWCClientGetPilgrimDetails($portalId,$URL) {			    
		  
		  $post_fields = "GetPortalID=$portalId";
		  ///////////////////
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL,$URL);
		  //curl_setopt($ch, CURLOPT_PROXY, $proxy);
		  //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
		  curl_setopt($ch, CURLOPT_VERBOSE, '1');
		  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');
		  curl_setopt($ch, CURLOPT_POST, 1);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); // Pass form Fields. 
		  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_HEADER, 0);
		  $curl_scraped_page = curl_exec($ch);
		  /////////////////////
		  if (!empty($curl_scraped_page)) 
		  {
			// echo $curl_scraped_page;
			return $curl_scraped_page;
		  } 
		  else 
		  {
			 echo curl_error($ch);
		  }
		  ///////////////
		  curl_close($ch);
}
}
?>