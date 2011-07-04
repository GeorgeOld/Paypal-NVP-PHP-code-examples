<?php
/******************************************************
MassPayReceipt.php

Sends a MassPay NVP API request to PayPal.

The code retrieves the receiveremails, if receiveremail is 
not null then only the item is added to 
NVP API request string, to send to the PayPal server. The
request to PayPal uses an API Signature.

After receiving the response from the PayPal server, the
code displays the request and response in the browser. If
the response was a success, it displays the response
parameters. If the response was an error, it displays the
errors received.

Called by MassPay.html.

Calls CallerService.php and APIError.php.

******************************************************/
require_once 'CallerService.php';

session_start();


/**
 * Get required parameters from the web form for the request
 */
$emailSubject =urlencode($_POST['emailSubject']);

$receiverType = urlencode($_POST['receiverType']);

$currency=urlencode($_REQUEST['currency']);

$nvpstr;

$count= count($_POST['receiveremail']);
for($i=0,$j=0;$i<$count;$i++) {
		if (isset($_POST['receiveremail'][$i]) && $_POST['receiveremail'][$i]!='' ) {
				$receiverEmail = urlencode($_POST['receiveremail'][$i]);
				$amount = urlencode($_POST['amount'][$i]);
				$uniqueID = urlencode($_POST['uniqueID'][$i]);
				$note = urlencode($_POST['note'][$i]);
				$nvpstr.="&L_EMAIL$j=$receiverEmail&L_Amt$j=$amount&L_UNIQUEID$j=$uniqueID&L_NOTE$j=$note";
				$j++;
		}
}
/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
   

$nvpstr.="&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency" ;




/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */

$resArray=hash_call("MassPay",$nvpstr);

/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
   
$ack = strtoupper($resArray["ACK"]);

if($ack!="SUCCESS"){
		$_SESSION['reshash']=$resArray;
		$location = "APIError.php";
		header("Location: $location");
   }

?>

<html>
<head>
    <title>PayPal PHP SDK - MassPay API</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
		<form id="Form1" method="post" runat="server">
			<center>
			<b>MassPay Successful!</b><br><br>
				<TABLE class="api" id="Table1">
					<?php 
   		 				require_once 'ShowAllResponse.php';
    				?>
				</TABLE>
				
			</center>
			<b></b><A id="CallsLink" href="index.html">Home</A></B>
		</form>
	</body>



