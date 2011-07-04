
<!--
TransactionSearch.html

This is the main page for TransactionSearch sample. 
This page allow the user to enter the required 
parameters for TransactionSearch API call and a Submit button 
that calls TransactionSearchResults.php.

Called by index.html.

Calls TransactionSearchResults.php.

-->
<?php
/**
 * Default startDateStr to yesterday date and endtDateStr to today date in mm/dd/yyyy format
 */
if (isset($_POST['startDateStr'])) {
    $start_date_str = $_POST['startDateStr'];
} else {
   $yesterdayDate = time()-86400; 
   $start_date_str = date('m/d/Y', $yesterdayDate);
}
if (isset($_POST['endDateStr'])) {
    $end_date_str = $_POST['endDateStr'];
} else {
   $currentDate = time(); 
   $end_date_str = date('m/d/Y', $currentDate);
}
?>
<html>
<head>
    <title>PayPal PHP SDK - TransactionSearch API</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <center>
    <form action="TransactionSearchResults.php">
		<span id=apiheader>TransactionSearch</span>
		
        <table class="api">
				
            <tr>
                <td class="field">
                    StartDate:</td>
                <td>
                    <input type="text" name="startDateStr" maxlength="20" size="10" value="<?php echo $start_date_str ?>" />
                    
                </td>
                <td>(Required)</td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    MM/DD/YYYY
                </td>
            </tr>
            <tr>
                <td class="field">
                    EndDate:</td>
                <td>
                    <input type="text" name="endDateStr" maxlength="20" size="10"  value="<?php echo $end_date_str ?>" />
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    MM/DD/YYYY
                </td>
            </tr>
            <tr>
                <td class="field">
                    TransactionID:</td>
                <td>
                    <input type="text" name="transactionID" /></td>
            </tr>
            <tr>
                <td class="field">
                </td>
                <td>
                    <br />
                    <input type="Submit" value="Submit" /></td>
            </tr>
        </table>
    </form>
    </center>
    <a class="home" id="CallsLink" href="index.html">Home</a>
</body>
</html>
