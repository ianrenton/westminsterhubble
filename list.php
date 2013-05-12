<?php

	require_once('config.php');

	mysql_connect(DB_SERVER,DB_USER,DB_PASS);
	@mysql_select_db(DB_NAME) or die( "Unable to select database");
	
	$activepicker = "List";
	include('mainpagepicker.php');

	$query = "SELECT * FROM twfy_mps WHERE 1 ORDER BY name;";
	$result = mysql_query($query);

	while ($mp = mysql_fetch_assoc($result)) {
		echo("<p><a href=\"" . str_replace(" ", "_", $mp["name"]) . "\">" . $mp["name"] . "</a> (" . $mp["party"] . ", " . $mp["constituency"] . ")</p>");
	}
	
	mysql_close();
	
?>
