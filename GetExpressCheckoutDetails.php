<?php
/********************************************************
GetExpressCheckoutDetails.php

This functionality is called after the buyer returns from
PayPal and has authorized the payment.

Displays the payer details returned by the
GetExpressCheckoutDetails response and calls
DoExpressCheckoutPayment.php to complete the payment
authorization.

Called by ReviewOrder.php.

Calls DoExpressCheckoutPayment.php and APIError.php.

********************************************************/

session_start();

/* Collect the necessary information to complete the
   authorization for the PayPal payment
   */

$_SESSION['token']=$_REQUEST['token'];
$_SESSION['payer_id'] = $_REQUEST['PayerID'];

$_SESSION['paymentAmount']=$_REQUEST['paymentAmount'];
$_SESSION['currCodeType']=$_REQUEST['currencyCodeType'];
$_SESSION['paymentType']=$_REQUEST['paymentType'];

$resArray=$_SESSION['reshash'];
$_SESSION['TotalAmount']= $resArray['AMT'] + $resArray['SHIPDISCAMT'];

/* Display the  API response back to the browser .
   If the response from PayPal was a success, display the response parameters
   */

?>



<html>
<head>
    <title>PayPal NVP SDK - ExpressCheckout-Instant API- Simplified Order Review Page</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
<center>
	<font size=2 color=black face=Verdana><b>Order Review</b></font>
	<br><br></center>
	<form action="DoExpressCheckoutPayment.php" method="POST">
	 <center>
           <table width =270>
             <tr>
		               <td colspan="2" class="header">
		                   Step 3: DoExpressCheckoutPayment
		               </td>
          </tr>
            <tr>
                <td><b>Order Total:</b></td>
                <td>
                  <?php  echo $_REQUEST['currencyCodeType'];   echo $resArray['AMT'] + $resArray['SHIPDISCAMT'] ?></td>
            </tr>
            
 		<?php 
   		 	require_once 'ShowAllResponse.php';
   		 ?>
          
            <tr>
                <td class="thinfield">
                     <input type="submit" value="Pay" />
                </td>
            </tr>
        </table>
    </center>
    </form>

</body>
</html>
