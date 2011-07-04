<?php
/***********************************************************
CreateRPProfileReceipt.php

Submits a Profile Details and credit card information to PayPal using a
CreateRecurringPaymentsProfile request.

The code collects transaction parameters from the form
displayed by CreateRPProfile.php then constructs and sends
the CreateRecurringPaymentsProfile request string to the PayPal server.

After the PayPal server returns the response, the code
displays the API request and response in the browser.
If the response from PayPal was a success, it displays the
response parameters. If the response was an error, it
displays the errors.

Called by CreateRPProfile.php.

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

// Month must be padded with leading zero
$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);

$expDateYear =urlencode( $_POST['expDateYear']);
$cvv2Number = urlencode($_POST['cvv2Number']);
$address1 = urlencode($_POST['address1']);
$address2 = urlencode($_POST['address2']);
$city = urlencode($_POST['city']);
$state =urlencode( $_POST['state']);
$zip = urlencode($_POST['zip']);
$amount = urlencode($_POST['amount']);
$currencyCode="USD";

$profileDesc = urlencode($_POST['profileDesc']);
$billingPeriod = urlencode($_POST['billingPeriod']);
$billingFrequency = urlencode($_POST['billingFrequency']);
$totalBillingCycles = urlencode($_POST['totalBillingCycles']);

$profileStartDateDay = $_POST['profileStartDateDay'];
// Day must be padded with leading zero
$padprofileStartDateDay = str_pad($profileStartDateDay, 2, '0', STR_PAD_LEFT);
$profileStartDateMonth = $_POST['profileStartDateMonth'];
// Month must be padded with leading zero
$padprofileStartDateMonth = str_pad($profileStartDateMonth, 2, '0', STR_PAD_LEFT);
$profileStartDateYear = $_POST['profileStartDateYear'];

$profileStartDate = urlencode($profileStartDateYear . '-' . $padprofileStartDateMonth . '-' . $padprofileStartDateDay . 'T00:00:00Z'); 

/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
$nvpstr="&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode&PROFILESTARTDATE=$profileStartDate&DESC=$profileDesc&BILLINGPERIOD=$billingPeriod&BILLINGFREQUENCY=$billingFrequency&TOTALBILLINGCYCLES=$totalBillingCycles";





/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */
$resArray=hash_call("CreateRecurringPaymentsProfile",$nvpstr);

/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
$ack = strtoupper($resArray["ACK"]);

if($ack!="SUCCESS")  {
    $_SESSION['reshash']=$resArray;
	$location = "../APIError.php";
		 header("Location: $location");
   }

?>

<html>
<head>
    <title>PayPal PHP SDK - CreateRecurringPaymentsProfile API</title>
    <link href="../sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<br>
	<center>
	<font size=2 color=black face=Verdana><b>Create Recurring Payments Profile</b></font>
	<br><br>
    <table width = 400>
    	<?php 
    		foreach($resArray as $key => $value) {
    			
    			echo "<tr><td>$key:</td><td>$value</td>";
    		}	
    	?>
    	<tr>
    		<td>
    			<a id="GetRPProfileDetailsLink" href="GetRPProfileDetails.html?profileID=<?php echo $resArray['PROFILEID'];?>">Get Recurring Payments Details</a>
    		</td>
    	</tr>
    </table>
    </center>
   <a id="CallsLink" href="RecurringPayments.php"><b>Recurring Payments Home</b></a>
</body>




