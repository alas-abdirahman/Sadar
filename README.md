# Sadar
How to Used<br>

<?php
include_once ('sadar.lib.php'); // Import Gateway  File
$apikey=""; // API KEY
$apitoken=""; // API Token
// https://yooltech.com/sadar/portal/api_user ( API Key Generate )
$SadarSMS = new SadarSMS($apikey, $api_key);

// Check Balance
echo $SadarSMS->check_balance();


// Send SMS Number For Singal and Multi
$number ="";
$sender = ""; // Sender ID
$message="";

$result=  $SadarSMS->sendMessageToNumber($number, $message,$sender);
print_r($result["response"]);


?>
