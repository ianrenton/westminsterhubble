<?php

require_once('config.php');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

// From detail page Javascript
if ((isset($_GET['person_id'])) && (isset($_GET['type'])) && (isset($_GET['newvalue']))) {
    $person_id = urldecode($_GET['person_id']);
    $type = $_GET['type'];
    $newValue = urldecode($_GET['newvalue']);
    
    $query = "INSERT INTO hubble_modqueue VALUES ('0', '" . mysql_real_escape_string($person_id) . "', '" . mysql_real_escape_string($type) . "', '" . mysql_real_escape_string($newValue) . "')";
    mysql_query($query);
	mail("webmaster@westminsterhubble.com","New item in mod queue", $newValue);

// From home page form
} elseif ((isset($_POST['name'])) && (isset($_POST['url']))) {
	
    $url = $_POST['url'];
	// Check MP name
    $query = "SELECT * FROM twfy_mps, hubble_mps WHERE (twfy_mps.person_id = hubble_mps.person_id) AND (twfy_mps.name LIKE '%" . mysql_real_escape_string($_POST['name']) . "%') ORDER BY name";
	$result = mysql_query($query);
    $match = mysql_fetch_assoc($result);

	$person_id = 99999; // Dummy in case no match found
    if ($match != false) {
        $person_id = $match["person_id"];
    }

	// Insert into mod queue
	$query = "INSERT INTO hubble_modqueue VALUES ('0', '" . mysql_real_escape_string($person_id) . "', 'SETME', '" . mysql_real_escape_string($url) . "')";
    mysql_query($query);
	mail("webmaster@westminsterhubble.com","New item in mod queue", $url);
//echo($query);
	header('Location: index.php?detailadded=true');
	die();

} else {

    echo ("Weird parameters.");

}

mysql_close();

  
?>
