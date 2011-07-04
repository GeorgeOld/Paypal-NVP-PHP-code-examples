<?php

/******************************************************
TransactionDetails.php

Sends a GetTransactionDetails NVP API request to PayPal.

The code retrieves the transaction ID and constructs the
NVP API request string to send to the PayPal server. The
request to PayPal uses an API Signature.

After receiving the response from the PayPal server, the
code displays the request and response in the browser. If
the response was a success, it displays the response
parameters. If the response was an error, it displays the
errors received.

Called by GetTransactionDetails.html.

Calls CallerService.php and APIError.php.

******************************************************/
// clearing the session before starting new API Call
session_unset();

require_once 'CallerService.php';

session_start();




$transactionID=urlencode($_REQUEST['transactionID']);

/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
$nvpStr="&TRANSACTIONID=$transactionID";



/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */
$resArray=hash_call("gettransactionDetails",$nvpStr);

/* Next, collect the API request in the associative array $reqArray
   as well to display back to the browser.
   Normally you wouldnt not need to do this, but its shown for testing */

$reqArray=$_SESSION['nvpReqArray'];

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
    <title>Transaction details</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<br>
		<center>
		<font size=3 color=black face=Verdana><b>Transaction Details</b></font>
		<br><br>

	<table width=400>
		 <?php 
   		 		require_once 'ShowAllResponse.php';
    		?>
	</table>

	<?php
		$tran_ID=$resArray['TRANSACTIONID'];
		$currency_cd=$resArray['CURRENCYCODE'];
		$gross_amt=$resArray['AMT'];

		// Build links
		$do_void_link = 'DoVoid.php?authorization_id='.$tran_ID;
		$do_authorization_link = 'DoAuthorization.php?order_id='.$tran_ID.'&currency='.$currency_cd.'&amount='.$gross_amt;
		$do_capture_link = 'DoCapture.php?authorization_id='.$tran_ID.'&currency='.$currency_cd.'&amount='.$gross_amt;
		$do_refund_link = 'RefundTransaction.php?transaction_id='.$tran_ID.'&currency='.$currency_cd.'&amount='.$gross_amt;
	?>

    <br> <font size=2 color=black face=Verdana>
    <a id="DoVoidLink" href="<?php echo $do_void_link?>">Void</a>
    <a id="DoAuthorization" href="<?php echo $do_authorization_link?>">Authorization</a>
    <a id="DoCaptureLink" href="<?php echo $do_capture_link?>">Capture</a>
    <a id="RefundTransactionLink" href="<?php echo $do_refund_link?>">Refund</a>
    <a id="BackLink" href="javascript:history.back()">Back</a>
    <br /> </font></center>
    <a class="home" id="CallsLink" href="index.html">Home</a>
</body>
</html>
