<?php
// Website Contact Form Generator 
// http://www.tele-pro.co.uk/scripts/contact_form/ 
// This script is free to use as long as you  
// retain the credit link  

// get posted data into local variables
$EmailFrom = Trim(stripslashes($_POST['EmailFrom'])); 
$EmailTo = "ianrenton@gmail.com";
$Subject = "Westminster Hubble Contact";
$YourName = Trim(stripslashes($_POST['YourName'])); 
$Message = Trim(stripslashes($_POST['Message'])); 

// validation
$validationOK=true;
if (Trim($EmailFrom)=="") $validationOK=false;
if (!$validationOK) {
  print "<meta http-equiv=\"refresh\" content=\"0;URL=contact.php?return=error\">";
  exit;
}

// prepare email body text
$Body = "";
$Body .= "Name: ";
$Body .= $YourName;
$Body .= "\n";
$Body .= "Message: ";
$Body .= $Message;
$Body .= "\n";

// send email 
$success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");

// redirect to success page 
if ($success){
  print "<meta http-equiv=\"refresh\" content=\"0;URL=contact.php?return=ok\">";
}
else{
  print "<meta http-equiv=\"refresh\" content=\"0;URL=contact.php?return=error\">";
}
?>
