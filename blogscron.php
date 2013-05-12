<?php

require_once('config.php');
require_once('simplepie/simplepie.inc');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

$query = "SET time_zone = 'Europe/London'";
$result = mysql_query($query);

echo("Content-type: text/html\n\n");
echo('<h2>Cron Job</h2>');

echo('Time: ' . date('H:i') . '<br/>');

// Grab our blog entries
	echo('<b>Grabbing blog entires...</b><br/>');
	
	$urls = array("http://blog.ianrenton.com/category/politics/feed/", "http://recampaign.blogspot.com/");
	
	$feed = grabRSS($urls);
	$count = 0;
	foreach ($feed->get_items() as $item) {
        $title = html_entity_decode($item->get_title(), ENT_QUOTES, 'UTF-8');
        $description = html_entity_decode($item->get_content(), ENT_QUOTES, 'UTF-8');
        $url = $item->get_permalink();
        $feedurl = $item->get_feed()->get_permalink();
        $date = $item->get_date('Y-m-d H:i:s');

        // Insert item into the blog cache table.  The table will weed out
		// duplicates based on the item URL.
        $query = "INSERT INTO hubble_blog VALUES ('0', '0', 'blog', '" . $date . "', '" . mysql_real_escape_string($title) . "', '" . mysql_real_escape_string($description) . "', '" . mysql_real_escape_string($url) . "', '" . mysql_real_escape_string($feedurl) . "');";
        mysql_query($query);
    }

echo("<br/><b>The end!</b>");

mysql_close();


// Grabs a set of RSS feeds using simplepie.
function grabRSS($url) {
	$feed = new SimplePie();
	$feed->set_feed_url($url);
    $feed->set_autodiscovery_level(SIMPLEPIE_LOCATOR_ALL);
	$feed->enable_cache(false);
	$feed->enable_xml_dump(false);
	$feed->enable_order_by_date(true);
	$success = $feed->init();
	$feed->handle_content_type();
	return $feed;
}
?>
