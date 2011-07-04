<?php
/******************************************************
TransactionSearchResults.php

Sends a TransactionSearch NVP API request to PayPal.

The code retrieves the transaction ID,start date,end date
and constructs the NVP API request string to send to the 
PayPal server. The request to PayPal uses an API Signature.

After receiving the response from the PayPal server, the
code displays the request and response in the browser. If
the response was a success, it displays the response
parameters. If the response was an error, it displays the
errors received.

Called by TransactionSearch.html.

Calls CallerService.php and APIError.php.

******************************************************/
// clearing the session before starting new API Call
session_unset();

require_once 'CallerService.php';

session_start();


/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
$nvpStr;

$startDateStr=$_REQUEST['startDateStr'];
$endDateStr=$_REQUEST['endDateStr'];
$transactionID=urlencode($_REQUEST['transactionID']);
if(isset($startDateStr)) {
   $start_time = strtotime($startDateStr);
   $iso_start = date('Y-m-d\T00:00:00\Z',  $start_time);
   $nvpStr="&STARTDATE=$iso_start";
  }

if(isset($endDateStr)&&$endDateStr!='') {
   $end_time = strtotime($endDateStr);
   $iso_end = date('Y-m-d\T24:00:00\Z', $end_time);
   $nvpStr.="&ENDDATE=$iso_end";    
}

if($transactionID!='') 
   $nvpStr=$nvpStr."&TRANSACTIONID=$transactionID";



/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */

$resArray=hash_call("TransactionSearch",$nvpStr);

/* Next, collect the API request in the associative array $reqArray
   as well to display back to the browser.
   Normally you wouldnt not need to do this, but its shown for testing */

$reqArray=$_SESSION['nvpReqArray'];

/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
$ack = strtoupper($resArray["ACK"]);

if($ack!="SUCCESS" && $ack!="SUCCESSWITHWARNING"){
		$_SESSION['reshash']=$resArray;
		$location = "APIError.php";
		header("Location: $location");
	}
?>


<html>
<head>
    <title>PayPal PHP SDK: Transaction Search Results</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <br>
	<center>
	<font size=3 color=black face=Verdana><b>Transaction Search Results</b></font>
	<br><br>
    <table class="api">
<?php //checking for Transaction ID in NVP response
 if(!isset($resArray["L_TRANSACTIONID0"])){
?>
	<tr>
		<td colspan="6" class="field">
			No Transaction Selected
		</td>
	</tr>
<?php 
  }else { 
		$count=0;
		//counting no.of  transaction IDs present in NVP response arrray.
		while (isset($resArray["L_TRANSACTIONID".$count])) 
			$count++; 
?>	
			<tr>
            <td colspan="6" class="thinfield">
                   Results 1 - <?php echo $count; ?>
            </td>
        </tr>
        <tr>
            <td >
            </td>
            <td >
                <b>ID</b></td>
            <td >
                <b>Time</b></td>
            <td >
                <b>Status</b></td>
            <td >
                <b>Payer Name</b></td>
            <td >
                <b>Gross Amount</b></td>
        </tr>
        
<?php 
	  $ID=0;
  while ($count>0) {
		  $transactionID    = $resArray["L_TRANSACTIONID".$ID];
		  $timeStamp = $resArray["L_TIMESTAMP".$ID];
		  $payerName  = $resArray["L_NAME".$ID]; 
		  $amount  = $resArray["L_AMT".$ID]; 
		  $status  = $resArray["L_STATUS".$ID]; 
		  $count--; $ID++;
?>
	    <tr>
		    <td><?php echo $ID; ?></td>
            <td><a id="TransactionDetailsLink0"  href="TransactionDetails.php?transactionID=<?php echo $transactionID; ?>"><?php echo $transactionID; ?></a></td>
            <td><?php echo $timeStamp;?> <!--12/7/2005 9:57:58 AM--></td>
            <td><?php echo $status;?></td>
            <td><?php echo $payerName;?></td>
            <td>USD<?php echo $amount;?></td>
        </tr>
<?php }// while
}//else ?>

            
            
     </table>
    </center>
    <a class="home" id="CallsLink" href="index.html">Home</a>
</body>
</html>
