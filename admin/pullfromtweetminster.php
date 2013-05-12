<?php

require_once('../config.php');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

for ($i=1; $i<45; $i++){
	$response = file_get_contents("http://tweetminster.co.uk/mps/index/page:" . $i);
	preg_match_all('/class="name" >([\w\s-\']*)<\/a>/', $response, $matches);
	$names = $matches[1];
	preg_match_all('/class="twitterLink">([\w\s-\']*)<\/a>/', $response, $matches);
	$twitters = $matches[1];
	for ($j=0; $j<5; $j++) {
		$query = "SELECT * FROM twfy_mps WHERE (twfy_mps.name = '" . mysql_real_escape_string($names[$j]) . "')";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        if ($row == false) {
            echo ("FAILED: " . $names[$j] . ":  @" . $twitters[$j] . "<br/>");
        } else {
            $query = "SELECT * FROM hubble_mps WHERE (hubble_mps.person_id = '" . $row["person_id"] . "')";
            $result = mysql_query($query);
            $row2 = mysql_fetch_assoc($result);
            if ($row2 != false) {
                $query = "UPDATE hubble_mps SET twitter = '" . $twitters[$j] . "' WHERE hubble_mps.person_id = '" . $row["person_id"] . "' LIMIT 1";
                $result = mysql_query($query);
                if ($result == false) {
                    echo ("FAILED: " . $names[$j] . ":  @" . $twitters[$j] . "<br/>");
                }
            }
        }
	}
}

mysql_close();

echo("Done!");

?>