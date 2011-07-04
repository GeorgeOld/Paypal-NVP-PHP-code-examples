
<!--
DoVoid.html

This is the main page for DoVoid sample. 
This page allow the user to enter the required 
parameters for DoVoid API call and a Submit button 
that calls  DoVoidReceipt.php.

Called by index.html.

Calls  DoVoidReceipt.php.

-->
<?php
$authorization_id = $_REQUEST['authorization_id'];
if(!isset($authorization_id))
   $authorization_id = '';
?>

<html>
<head>
    <title>PayPal PHP SDK - DoVoid API</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
		<br>
		<center>
		<font size=2 color=black face=Verdana><b>DoVoid</b></font>
		<br><br>
    
	 <form action="DoVoidReceipt.php" method="post">
    <table class="api">
        
        <tr>
            <td class="thinfield">
                Authorization ID:</td>
            <td>
                <input type="text" name="authorization_id"  value="<?php $authorization_id;?>" >
            </td>
               
		<td><b>(Required)</b></td>
        </tr>
        <tr>
            <td class="thinfield">
                Note:</td>
            <td>
                <textarea name="note" cols="30" rows="4"></textarea></td>
        </tr>	
        <tr>
            <td colspan="2">
                <center>
                <input type="Submit" value="Submit" /></center>
            </td>
        </tr>
    </table>
	</form>
    </center>
    <a class="home" id="CallsLink" href="index.html">Home</a>
</body>
</html>
