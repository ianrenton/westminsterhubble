<?php

require_once('config.php');
require_once('simplepie/simplepie.inc');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

$query = "SET time_zone = 'Europe/London'";
$result = mysql_query($query);

$types = array("website", "blog", "twitter", "facebook", "youtube", "other", "twfy");

echo("Content-type: text/html\n\n");
echo('<h2>Cron Job</h2>');

echo('Time: ' . date('H:i') . '<br/>');

echo('<b>Deleting old entries...</b><br/>');


echo('<b>Adding new entires...</b><br/>');

// Create a single SimplePie for the cron job.
$feed = new SimplePie();

$query = "SELECT * FROM hubble_mps";
$result = mysql_query($query);
$numRows = mysql_num_rows($result);
echo($numRows . " MPs in database<br/><br/>");

// Run the query to fetch the 20 oldest ones, or the one specific one if provided.
$query = "SELECT * FROM hubble_mps ";
if (isset($_POST['person_id'])) {
    $query = $query . "WHERE person_id=" . mysql_real_escape_string($_POST['person_id'] . " ");
}
$query = $query . "ORDER BY last_crawled ASC LIMIT 20";
echo ("Query: " . $query . "<br/><br/>");
$result = mysql_query($query);
$counter = 1;

// For each MP...
while ($mp = mysql_fetch_assoc($result)) {

	// Update last_cralwed time
	$query = "UPDATE hubble_mps SET last_crawled = '" . date('Y-m-d H:i:s') . "' WHERE person_id=" . $mp["person_id"];
	mysql_query($query);

    //echo($counter++ . ": ");
    // All MPs have a TWFY but it's not stored in the database, so work that out now.
    $query = "SELECT * FROM twfy_mps WHERE (person_id = " . $mp["person_id"] . ") LIMIT 1";
    $twfympresult = mysql_query($query);
    $twfymp = mysql_fetch_assoc($twfympresult);
    
    // If there's no name this must be for an old MP or rogue data, so don't
    // bother parsing - it'll never show up in search results anyway.
    if ($twfymp["name"] != "") {

        echo($twfymp["name"] . ": ");
        $mp["twfy"] = getTWFYURL($twfymp["name"], $twfymp["constituency"]);

        // For each type...
        foreach ($types as $type) {

            // If there's data
            if ($mp[$type] != "") {
                echo($type . " ");

                // Twitter and YouTube are special in that we store usernames not URLs, so expand them.
                if ($type == "twitter") {
                    $checkurl = "http://www.twitter.com/" . $mp[$type] . "";
                } elseif ($type == "youtube") {
                    $checkurl = "http://www.youtube.com/user/" . $mp[$type];
                } else {
                    $checkurl = $mp[$type];
                }

                $feed = grabRSS($feed, $checkurl);
                foreach ($feed->get_items() as $item) {
                    $title = html_entity_decode($item->get_title(), ENT_QUOTES, 'UTF-8');
                    $description = html_entity_decode($item->get_description(), ENT_QUOTES, 'UTF-8');
                    $url = $item->get_permalink();
                    $feedurl = $item->get_feed()->get_permalink();
                    $date = $item->get_date('Y-m-d H:i:s');

                    // Avoid sending reply tweets (those beginning with @) to the DB.
                    // We never show these, so there's no sense cluttering it up.
                    if ($type == "twitter") {
                        $colonpos = strpos($description, ":");
                		$description = substr($description, $colonpos+2);
                        if (strpos($description, "@") === 0) {
                            continue;
                        }
                    }

                    // Insert item into the cache table.  The table will weed out
					// duplicates based on the item URL.
                    $query = "INSERT INTO hubble_cache VALUES ('0', '" . $mp["person_id"] . "', '" . $type . "', '" . $date . "', '" . mysql_real_escape_string($title) . "', '" . mysql_real_escape_string($description) . "', '" . mysql_real_escape_string($url) . "', '" . mysql_real_escape_string($feedurl) . "');";
                    mysql_query($query);
                }
            }
        }

        echo("<br/>");
    }
}



echo("<br/><b>The end!</b>");

mysql_close();


// Grabs a set of RSS feeds using simplepie.
function grabRSS($feed, $url) {
	$feed->set_feed_url($url);
    $feed->set_autodiscovery_level(SIMPLEPIE_LOCATOR_ALL);
	$feed->enable_cache(false);
	$feed->enable_xml_dump(false);
	$feed->enable_order_by_date(true);
	$success = @$feed->init();
	$feed->handle_content_type();
	return $feed;
}


// Turn a name and constituency into a TheyWorkForYou URL.
function getTWFYURL($name, $constituency) {
	$url = "http://www.theyworkforyou.com/mp/";
	$url .= strtolower(str_replace(" ", "_", $name));
	$url .= "/";
	$url .= strtolower(str_replace(" ", "_", $constituency));
	return $url;
}
  
?>
