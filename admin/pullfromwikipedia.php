<?php

require_once('../config.php');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

$query = "SELECT * FROM twfy_mps WHERE 1 ORDER BY name;";
$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
    $query = "SELECT * FROM hubble_mps WHERE (hubble_mps.person_id = '" . $row["person_id"] . "')";
	$result2 = mysql_query($query);
    $row2 = mysql_fetch_assoc($result2);
    if ($row2["wikipedia"] == "") {
        $query = "UPDATE hubble_mps SET wikipedia = '" . mysql_real_escape_string("http://en.wikipedia.org/wiki/" . str_replace(" ", "_", $row["name"])) . "' WHERE hubble_mps.person_id = '" . $row["person_id"] . "' LIMIT 1";
        mysql_query($query);
    }
}

echo("Done.");

mysql_close();
  
?>