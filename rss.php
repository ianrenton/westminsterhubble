<?php

require_once('config.php');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

$isHomePage = false;

if (isset($_GET['personid'])) {
    runSearch($_GET['personid']);
} else {
	getAll();
}

mysql_close();


// Runs a search on the given term ($searchstring).
function runSearch($searchstring) {

    // Check MP name
    $query = "SELECT * FROM twfy_mps WHERE (twfy_mps.person_id LIKE '%" . mysql_real_escape_string($searchstring) . "%') ORDER BY name";
	$result = mysql_query($query);
    $match = mysql_fetch_assoc($result);

	// MP name matches.  Since this page should only be referred to within the
	// header of a proper HTML page, this should always match.
    if ($match != false) {
    
        // Grab latest 20 items
        $query = "SELECT * FROM hubble_cache WHERE (person_id = " . $match["person_id"] . ") ORDER BY date DESC";
    	$result = mysql_query($query);
    	$itemcounter = 0;
    	
    	// Header
    	?>
    	
    	<rss version="2.0">
        <channel>
        <title>Westminster Hubble for <?php echo($match['name']); ?></title>
        <link>http://www.westminsterhubble.com/<?php echo($match['name']); ?></link>
        <description>This is a feed of all the known online activity of <?php echo($match['name']); ?>.</description>
        <lastBuildDate><?php date("D, d M Y H:i:s e"); ?></lastBuildDate>
        <language>en-gb</language>

    	
    	<?php
    	
    	makeFeed($result);
    	
    	//Footer
    	?>
    	
    	</channel>
        </rss>

        <?php
        
    } else {
        die();
    }
}


// Get an RSS feed for everyone
function getAll() {

    // Grab latest 20 items
    $query = "SELECT * FROM hubble_cache ORDER BY date DESC";
   	$result = mysql_query($query);
   	$itemcounter = 0;
   	
   	// Header
   	?>
   	
   	<rss version="2.0">
       <channel>
       <title>Westminster Hubble</title>
       <link>http://www.westminsterhubble.com/</link>
       <description>This is a feed of all the known online activity of all MPs in the Westminster Hubble database.</description>
       <lastBuildDate><?php date("D, d M Y H:i:s e"); ?></lastBuildDate>
       <language>en-gb</language>

   	
   	<?php
   	
   	makeFeed($result);
   	
   	//Footer
   	?>
   	
   	</channel>
       </rss>

       <?php
}


// The actual feed generation code
function makeFeed($result) {
	while ($item = mysql_fetch_assoc($result)) {
        if ($itemcounter < 20) {

            ?>

            <item>
            <title><?php echo $item["title"]; ?></title>
            <link><?php echo $item["url"]; ?></link>
            <guid><?php echo $item["url"]; ?></guid>
            <pubDate><?php date("D, d M Y H:i:s e", strtotime($item["date"])) ?></pubDate>
            <description><?php echo $item["description"]; ?></description>
            </item>


            <?php

            // Increment item counter here so we can guarantee the number of posts actually displayed
            $itemcounter = $itemcounter + 1;
        } else {
            // Items are sorted, so if one fails there's no need to check the rest.
            break;
        }
	
	}
}

?>
