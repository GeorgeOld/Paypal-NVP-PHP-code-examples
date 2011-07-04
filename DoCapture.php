
<!--
DoCapture.html

This is the main page for DoCapture sample. 
This page allow the user to enter the required 
parameters for DoCapture API call and a Submit button 
that calls DoCaptureReceipt.php.

Called by index.html.

Calls DoCaptureReceipt.php.

-->
<?php

   $authorization_id = $_REQUEST['authorization_id'];
   if(!isset($authorization_id))
      $authorization_id='';
   $amount = $_REQUEST['amount'];
   if(!isset($amount))
      $amount = '0.00';
   $currency_cd = $_REQUEST['currency'];
   if(!isset($currency_cd))
      $currency_cd = 'USD';
           
?>

<html >
<head>
    <title>PayPal PHP SDK - DoCapture API</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<br>
	<center>
	<font size=2 color=black face=Verdana><b>DoCapture</b></font>
	<br><br>
    
	<form action="DoCaptureReceipt.php" method="post">
    <table class="api">
         <tr>
            <td class="thinfield">
                Authorization ID:</td>
            <td>
                <input type="text" name="authorization_id" value="<?php echo $authorization_id;?>" >
                </td>
                <td><b>(Required)</b></td>
        </tr>
        <tr>
            <td class="thinfield">
                Complete Code Type:</td>
            <td>
                <select name="CompleteCodeType">
                <option value="Complete">Complete</option>
                <option value="NotComplete">NotComplete</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="thinfield">
                Amount:</td>
            <td>
                <input type="text" name="amount" value=<?php echo $amount;?> size="5" maxlength="7" />
                <select name="currency">

<?php
   $cur_list = array('USD', 'GBP', 'EUR', 'JPY', 'CAD', 'AUD');
   for($s=0; $s < sizeof($cur_list); $s++) {
      $selected = (!strcmp($currency_cd, $cur_list[$s])) ? 'selected' : '';
?>
			<option  <?php echo $selected;?>><?php echo $cur_list[$s];?></option>

<?php } ?>
                </select>
                </td>
                <td><b>(Required)</b></td>
        </tr>
        <tr>
            <td class="thinfield">
                Invoice ID:</td>
            <td>
                <input type="text" name="invoice_id" /></td>
        </tr>
        <tr>
            <td class="thinfield">
                Note:</td>
            <td>
                <textarea name="note" cols="30" rows="4"></textarea></td>
        </tr>
        <tr>
            <td class="thinfield">
            </td>
            <td>
                <input type="Submit" value="Submit" />
            </td>
        </tr>
    </table>
	</form>
    </center>
    <a class="home" id="CallsLink" href="index.html">Home</a>
</body>
</html>
