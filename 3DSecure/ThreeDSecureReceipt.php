<?php
/***********************************************************
ThreeDSecureReceipt.php

Submits a credit card transaction to PayPal using a
DoDirectPayment request.

The code collects transaction parameters from the form
displayed by DoDirectPayment.php then constructs and sends
the DoDirectPayment request string to the PayPal server.
The paymentType variable becomes the PAYMENTACTION parameter
of the request string.

After the PayPal server returns the response, the code
displays the API request and response in the browser.
If the response from PayPal was a success, it displays the
response parameters. If the response was an error, it
displays the errors.

Called by ThreeDSecure.php.

Calls CallerService.php and APIError.php.

***********************************************************/

require_once '../CallerService.php';

session_start();


/**
 * Get required parameters from the web form for the request
 */
$paymentType =urlencode( $_POST['paymentType']);
$firstName =urlencode( $_POST['firstName']);
$lastName =urlencode( $_POST['lastName']);
$creditCardType =urlencode( $_POST['creditCardType']);
$creditCardNumber = urlencode($_POST['creditCardNumber']);
$expDateMonth =urlencode( $_POST['expDateMonth']);
$startDateMonth =urlencode( $_POST['startDateMonth']);

// Month must be padded with leading zero
$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
$padStartDateMonth = str_pad($startDateMonth, 2, '0', STR_PAD_LEFT);

$expDateYear =urlencode( $_POST['expDateYear']);
$startDateYear =urlencode( $_POST['startDateYear']);
$cvv2Number = urlencode($_POST['cvv2Number']);
$address1 = urlencode($_POST['address1']);
$address2 = urlencode($_POST['address2']);
$city = urlencode($_POST['city']);
$state =urlencode( $_POST['state']);
$zip = urlencode($_POST['zip']);
$amount = urlencode($_POST['amount']);
$currencyCode=urlencode($_POST['currency']);
$paymentType=urlencode($_POST['paymentType']);

//3D Secure fields
$eciFlag = urlencode($_POST['eciFlag']);
$cavv = urlencode($_POST['cavv']);
$xid = urlencode($_POST['xid']);
$enrolled = urlencode($_POST['enrolled']);
$pAResStatus = urlencode($_POST['pAResStatus']);

/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
"&ZIP=$zip&COUNTRYCODE=GB&CURRENCYCODE=$currencyCode&STARTDATE=$padStartDateMonth$startDateYear&ECI3DS=$eciFlag&CAVV=$cavv&XID=$xid&MPIVENDOR3DS=$enrolled&AUTHSTATUS3DS=$pAResStatus";




/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */
$resArray=hash_call("doDirectPayment",$nvpstr);

/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
$ack = strtoupper($resArray["ACK"]);

if($ack!="SUCCESS" && $ack!="SUCCESSWITHWARNING")  {
    $_SESSION['reshash']=$resArray;
	$location = "../APIError.php";
		 header("Location: $location");
   }

?>

<html>
<head>
    <title>PayPal PHP SDK - 3D Secure DoDirectPayment API</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<br>
	<center>
	<font size=2 color=black face=Verdana><b>3D Secure DDP Response</b></font>
	<br><br>

	<b>Thank you for your payment!</b><br><br>
	
    <table width = 400>
    	<?php 
    		foreach($resArray as $key => $value) {
    			
    			echo "<tr><td>$key:</td><td>$value</td>";
    		}	
    	?>
    </table>
    </center>
    <a class="home" id="CallsLink" href="../index.html">Home</a>
</body>




