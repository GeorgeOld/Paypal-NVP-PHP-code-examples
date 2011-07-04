<?php

/******************************************************
BillOutstandingAmount.php

Sends a BillOutstandingAmount NVP API request to PayPal.

The code retrieves the profile ID, amount and constructs the
NVP API request string to send to the PayPal server. The
request to PayPal uses an API Signature.

After receiving the response from the PayPal server, the
code displays the request and response in the browser. If
the response was a success, it displays the response
parameters. If the response was an error, it displays the
errors received.

Called by BillOutstandingAmount.html.

Calls CallerService.php and APIError.php.

******************************************************/
// clearing the session before starting new API Call
session_unset();

require_once '../CallerService.php';


session_start();



$profileID=urlencode($_REQUEST['profileID']);
$amount = urlencode($_REQUEST['amount']);

/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
$nvpStr="&PROFILEID=$profileID&AMT=$amount";





/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */
$resArray=hash_call("BillOutstandingAmount",$nvpStr);

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
		$location = "../APIError.php";
		header("Location: $location");
	}

?>

<html>
<head>
    <title>BillOutstandingAmount</title>
    <link href="../sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<br>
		<center>
		<font size=3 color=black face=Verdana><b>Bill Outstanding Amount</b></font>
		<br><br>

	<table width=400>
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
     <a id="CallsLink" href="RecurringPayments.php"  class="home" >Recurring Payments Home</a>
</body>
</html>
