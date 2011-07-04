<?php

/************************************************************

ThreeDSecure.php
 
This is the main web page for the DoDirectPayment sample.
This page allows the user to enter name, address, amount,
and credit card information. It also accept input variable
paymentType which becomes the value of the PAYMENTACTION
parameter.

When the user clicks the Submit button, ThreeDSecureReceipt.php
is called.

Called by index.html.

Calls ThreeDSecureReceipt.php.

************************************************************/
// clearing the session before starting new API Call
session_unset();
$paymentType = $_REQUEST['paymentType'];

?>


<html>
<head>
<title>PayPal PHP SDK - 3D Secure DoDirectPayment API</title>
<link href="pages/sdk.css" rel="stylesheet" type="text/css"/>
<script language="JavaScript">
	function generateCC(){
		var cc_number = new Array(16);
		var cc_len = 16;
		var start = 0;
		var rand_number = Math.random();

		switch(document.DoDirectPaymentForm.creditCardType.value)
        {
			case "Visa":
				cc_number[start++] = 4;
				break;
			case "MasterCard":
				cc_number[start++] = 5;
				cc_number[start++] = Math.floor(Math.random() * 5) + 1;
				break;
			case "Maestro":
				cc_number[start++] = 3;
				cc_number[start++] = Math.round(Math.random()) ? 7 : 4 ;
				cc_len = 16;
				break;
        }

        for (var i = start; i < (cc_len - 1); i++) {
			cc_number[i] = Math.floor(Math.random() * 10);
        }

		var sum = 0;
		for (var j = 0; j < (cc_len - 1); j++) {
			var digit = cc_number[j];
			if ((j & 1) == (cc_len & 1)) digit *= 2;
			if (digit > 9) digit -= 9;
			sum += digit;
		}

		var check_digit = new Array(0, 9, 8, 7, 6, 5, 4, 3, 2, 1);
		cc_number[cc_len - 1] = check_digit[sum % 10];

		document.DoDirectPaymentForm.creditCardNumber.value = "";
		for (var k = 0; k < cc_len; k++) {
			document.DoDirectPaymentForm.creditCardNumber.value += cc_number[k];
		}
	}
</script>
</head>

<body alink=#0000FF vlink=#0000FF>
<br>
<center>
<font size=2 color=black face=Verdana><b>3D Secure Payment </b></font>
<br><br>
<form method="POST" action="ThreeDSecureReceipt.php" name="DoDirectPaymentForm">
<!--Payment type is <?=$paymentType?><br> -->
<input type=hidden name=paymentType value="<?php echo $paymentType;?>" />
<table width=600>
	<tr>
		<td align=right>First Name:</td>
		<td align=left><input type=text size=30 maxlength=32 name=firstName value=John></td>
	</tr>
	<tr>
		<td align=right>Last Name:</td>
		<td align=left><input type=text size=30 maxlength=32 name=lastName value=Doe></td>
	</tr>
	<tr>
		<td align=right>Card Type:</td>
		<td align=left>
			<select name=creditCardType onChange="javascript:generateCC(); return false;">
				<option value=Maestro selected>Maestro</option>
				<option value=MasterCard>Visa</option>
				<option value=MasterCard>MasterCard</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align=right>Card Number:</td>
		<td align=left><input type=text size=19 maxlength=19 name=creditCardNumber></td>
	</tr>
	<tr>
		<td align=right>Start Date:</td>
		<td align=left><p>
			<select name=startDateMonth>
				<option value=1>01</option>
				<option value=2>02</option>
				<option value=3>03</option>
				<option value=4>04</option>
				<option value=5>05</option>
				<option value=6>06</option>
				<option value=7>07</option>
				<option value=8>08</option>
				<option value=9>09</option>
				<option value=10>10</option>
				<option value=11>11</option>
				<option value=12>12</option>
			</select>
			<select name=startDateYear>
				<option value=2005>2005</option>
				<option value=2006>2006</option>
				<option value=2007>2007</option>
				<option value=2008>2008</option>
				<option value=2009 selected>2009</option>
				<option value=2010>2010</option>
				<option value=2011>2011</option>
				<option value=2012>2012</option>
				<option value=2013>2013</option>
				<option value=2014>2014</option>
				<option value=2015>2015</option>
			</select>
		</p></td>
	</tr>
	<tr>
		<td align=right>Expiration Date:</td>
		<td align=left><p>
			<select name=expDateMonth>
				<option value=1>01</option>
				<option value=2>02</option>
				<option value=3>03</option>
				<option value=4>04</option>
				<option value=5>05</option>
				<option value=6>06</option>
				<option value=7>07</option>
				<option value=8>08</option>
				<option value=9>09</option>
				<option value=10>10</option>
				<option value=11>11</option>
				<option value=12>12</option>
			</select>
			<select name=expDateYear>
				<option value=2005>2005</option>
				<option value=2006>2006</option>
				<option value=2007>2007</option>
				<option value=2008>2008</option>
				<option value=2009>2009</option>
				<option value=2010>2010</option>
				<option value=2011 >2011</option>
				<option value=2012 selected>2012</option>
				<option value=2013>2013</option>
				<option value=2014>2014</option>
				<option value=2015>2015</option>
			</select>
		</p></td>
	</tr>
	<tr>
		<td align=right>Card Verification Number:</td>
		<td align=left><input type=text size=3 maxlength=4 name=cvv2Number value=962></td>
	</tr>
	<tr>
		<td align=right><br><b>Billing Address:</b></td>
	</tr>
	<tr>
		<td align=right>Address 1:</td>
		<td align=left><input type=text size=25 maxlength=100 name=address1 value="123 Fake St"></td>
	</tr>
	<tr>
		<td align=right>Address 2:</td>
		<td align=left><input type=text  size=25 maxlength=100 name=address2>(optional)</td>
	</tr>
	<tr>
		<td align=right>City:</td>
		<td align=left><input type=text size=25 maxlength=40 name=city value="London"></td>
	</tr>
	<tr>
		<td align=right>State:</td>
		<td align=left>
			<input type=text size=25 maxlength=40 name=state value="London">
		</td>
	</tr>
	<tr>
		<td align=right>ZIP Code:</td>
		<td align=left><input type=text size=10 maxlength=10 name=zip value="WC2H 7LA"></td>
	</tr>
	<tr>
		<td align=right>Country:</td>
		<td align=left>United Kingdom</td>
	</tr>
	<tr>
		<td align=right><br>Amount:</td>
		<td align=left><br>
			<input type=text size=4 maxlength=7 name=amount value=1.00> 
			<select name=currency>
				<option value=USD>USD</option>
				<option value=GBP selected>GBP</option>
				<option value=EUR>EUR</option>
				<option value=JPY>JPY</option>
				<option value=CAD>CAD</option>
				<option value=AUD>AUD</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><br>
			<b>3D Secure</b></td>
	</tr>
	<tr>
		<td align=right>EciFlag:
		</td>
		<td><input id="eciFlag" type="text" maxLength="50" size="40" name="eciFlag">
		</td>
	</tr>
	<tr>
		<td align=right>Cavv:
		</td>
		<td><input id="cavv" type="text" maxLength="50" size="40" name="cavv">
		</td>
	</tr>
	<tr>
		<td align=right>Xid:
		</td>
		<td><input id="xid" type="text" maxLength="50" size="40" name="xid">
		</td>
	</tr>
	<tr>
		<td align=right>MPIVendor3DS:
		</td>
		<td><input id="enrolled" type="text" maxLength="50" size="40" name="enrolled">
		</td>
	</tr>
	<tr>
		<td align=right>AuthStatus3D:
		</td>
		<td><input id="pAResStatus" type="text" maxLength="50" size="40" name="pAResStatus">
		</td>
	</tr>
	<tr>
		<td/>
		<td><input type=Submit value=Submit></td>
	</tr>
</table>
</form>
</center>
<a id="CallsLink" href="../index.html">Home</a>
<script language="javascript">
	generateCC();
</script>
</body>
</html>