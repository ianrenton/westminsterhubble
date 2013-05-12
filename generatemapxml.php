<?php
require("config.php");

function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

$query = "SELECT * FROM twfy_constituencies, twfy_mps WHERE (twfy_constituencies.con_name = twfy_mps.constituency)";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Start XML file, fwrite($file, parent node
$file = fopen("map.xml", 'w');
fwrite($file, '<markers>');

// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  fwrite($file, '<marker ');
  fwrite($file, 'name="' . parseToXML($row['con_name']) . '" ');
  fwrite($file, 'lat="' . $row['centre_lat'] . '" ');
  fwrite($file, 'lng="' . $row['centre_lon'] . '" ');
  fwrite($file, 'personid="' . $row['person_id'] . '" ');
  fwrite($file, 'mpname="' . $row['name'] . '" ');
  fwrite($file, 'party="' . $row['party'] . '" ');
  fwrite($file, '/>');
  fwrite($file, "\n");
}

// End XML file
fwrite($file, '</markers>');
fclose($file);

?>
