<?php

    require_once('config.php');

    $q = strtolower($_GET["q"]);
    if (!$q) return;
    
    if (preg_match("/^[A-Z]{1,2}[0-9R][0-9A-Z]?\s?[0-9][A-Z]{2}$/i", $q)) {
        echo $q . " (post code)|" . $q . "\n";
    } else if (preg_match("/^[A-Z]{1,2}[0-9]/i", $q)) {
        echo "Please type a full post code|". $q . "\n";
    } else {
        mysql_connect(DB_SERVER,DB_USER,DB_PASS);
    	@mysql_select_db(DB_NAME) or die( "Unable to select database");

    	$query = "SELECT * FROM twfy_mps WHERE ((name LIKE '%" . mysql_real_escape_string($q) . "%') OR (constituency LIKE '%" . mysql_real_escape_string($q) . "%')) ORDER BY name";
    	$result = mysql_query($query);

    	while($item = mysql_fetch_assoc($result)) {
            if ((strpos(strtolower($item["name"]), $q) !== false) || (strpos(strtolower($item["constituency"]), $q) !== false)) {
        		echo $item["name"] . " (" . $item["party"] . ", " . $item["constituency"] . ")|" . $item["name"] . "\n";
        	}
    	}

    	mysql_close();
    }
?>