<?php

require_once('../config.php');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

$mps = getMPs();
$constituencies = getConstituencies();

mysql_close();
    
    

function getMPs() {
	echo("Getting MPs...<br/><br/>");
    $response = file_get_contents("http://www.theyworkforyou.com/api/getMPs?output=php&key=" . TWFY_API_KEY);
    $blob = unserialize($response);
    
    $query = "TRUNCATE TABLE twfy_mps";
    mysql_query($query);

    foreach ($blob as $mp) {
		echo($mp["name"] . "<br/>");
		$detailresponse = file_get_contents("http://www.theyworkforyou.com/api/getMP?id=" . $mp["person_id"] . "&output=php&key=" . TWFY_API_KEY);
	    $detailblob = unserialize($detailresponse);
		//echo($detailresponse);
	
        $query = "INSERT INTO twfy_mps VALUES ('0', '" . $mp["member_id"] . "', '" . $mp["person_id"] . "', '" . mysql_real_escape_string($mp["name"]) . "','" . mysql_real_escape_string($mp["party"]) . "','" . mysql_real_escape_string($mp["constituency"]) . "', 'http://www.theyworkforyou.com" . mysql_real_escape_string($detailblob[0]["image"]) . "', '" . $detailblob[0]["image_height"] . "', '" . $detailblob[0]["image_width"] . "', '" . mysql_real_escape_string($detailblob[0]["office"][0]["position"]) . "', '" . mysql_real_escape_string($detailblob[0]["office"][0]["dept"]) . "')";
        $result = mysql_query($query);
		//echo($query . "<br/>");
		//echo($result . "<br/><br/>");
        
        $query = "SELECT * FROM hubble_mps WHERE (hubble_mps.person_id = '" . $mp["person_id"] . "')";
        $result = mysql_query($query);
        if (mysql_num_rows($result) == 0) {
            $query = "INSERT INTO hubble_mps VALUES ('0', '" . $mp["person_id"] . "', '', '', '', '', '', '', '', '', '', '', '')";
            mysql_query($query);
        }
    }
}

function getConstituencies() {
	echo("<br/>Getting Constituency Geometries...<br/><br/>");
    $response = file_get_contents("http://www.theyworkforyou.com/api/getConstituencies?&output=php&key=" . TWFY_API_KEY);
    $blob = unserialize($response);
	
	foreach ($blob as $constituencyname) {
        
		$response = file_get_contents("http://www.theyworkforyou.com/api/getGeometry?name=" . urlencode($constituencyname["name"]) . "&output=php&key=" . TWFY_API_KEY);
		$constituency = unserialize($response);

		$query = "INSERT INTO twfy_constituencies VALUES ('0', '" . $constituency["name"] . "', '" . $constituency["centre_lat"] . "', '" . $constituency["centre_lon"] . "')";
        mysql_query($query);
    }
}

echo("Done!");
  
?>