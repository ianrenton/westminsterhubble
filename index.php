<?php

require_once('config.php');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

$isHomePage = false;

// If we've added a detail, display the main page again with a thankyou message
if (isset($_GET['detailadded'])) {
	$detailAdded = $_GET['detailadded'];
	include('mainpage.php');

// If we have a person_id, we can show a details page straight away.
} else if (isset($_GET['person_id'])) {
    $person_id = $_GET['person_id'];
    include('detailpage.php');

// If we have a urlparam, it's come from the htaccessURL Rewriter, so it's a query that we want to just display immediately. 
} else if (isset($_GET['urlparam'])) {
    if ($_GET['urlparam'] == "about") {
        include('about.php');
    } elseif ($_GET['urlparam'] == "blog") {
        include('blog.php');
    } elseif ($_GET['urlparam'] == "contact") {
        include('contact.php');
    } elseif ($_GET['urlparam'] == "statistics") {
        include('stats.php');
    } elseif ($_GET['urlparam'] == "firehose") {
        include('firehose.php');
    } elseif ($_GET['urlparam'] == "list") {
		include('list.php');
    } elseif ($_GET['urlparam'] == "map") {
		include('map.php');
    } else {
        runSearch($_GET['urlparam'], false);
    }

// If it's been called with a search query, look it up and reload the page with a friendly url.
} else if (isset($_POST['query'])) {
    runSearch($_POST['query'], true);
    
// No proper search received, display main page (with error message if necessary)
} else {
    $searchfailed = false;
	include('mainpage.php');
}

mysql_close();


// Runs a search on the given term ($searchstring).  If $reloadWithNewURL is true,
// this will reload the page with a "friendly" url that must be ModRewritten by
// htaccess, i.e. "http://domain.com/tom watson".  If false, it'll just load the
// page.  So the default behaviour should be false if it already comes from a
// ModRewrite, and true if it comes from the search box.
function runSearch($searchstring, $reloadWithNewURL) {
	
	// Empty strings fail straight away, because they'll match anything.
	if($searchstring == "") {
		$searchFailed = true;
        include('mainpage.php');
	}
	
	$searchstring = str_replace("_", " ", $searchstring);
	
    // Check MP name
    $query = "SELECT * FROM twfy_mps, hubble_mps WHERE (twfy_mps.person_id = hubble_mps.person_id) AND (twfy_mps.name LIKE '%" . mysql_real_escape_string($searchstring) . "%') ORDER BY name";
	$result = mysql_query($query);
    $match = mysql_fetch_assoc($result);

	// MP name matches!
    if ($match != false) {
        if ($reloadWithNewURL) {
            reloadURL($match["name"]);
        } else {
            includeDetailPage($match["person_id"]);
        }
        
    } else {
        
        // Check constituency name
        $query = "SELECT * FROM twfy_mps, hubble_mps WHERE (twfy_mps.person_id = hubble_mps.person_id) AND (twfy_mps.constituency LIKE '%" . mysql_real_escape_string($searchstring) . "%') ORDER BY name";
        $result = mysql_query($query);
        $match = mysql_fetch_assoc($result);
        
		// Constituency name matches!
        if ($match != false) {
            if ($reloadWithNewURL) {
                reloadURL($match["name"]);
            } else {
                includeDetailPage($match["person_id"]);
            }
        } else {
	
        	// Else stick it through TWFY's parser.
			$detailresponse = file_get_contents("http://www.theyworkforyou.com/api/getMP?postcode=" . urlencode($searchstring) . "&output=php&always_return=true&key=" . TWFY_API_KEY);
		    $detailblob = unserialize($detailresponse);
		
			// Postcode returned a result!
            if ($detailblob["person_id"] != null) {
                if ($reloadWithNewURL) {
                    reloadURL($detailblob["full_name"]);
                } else {
                    includeDetailPage($detailblob["person_id"]);
                }
            } else {
                $searchFailed = true;
                include('mainpage.php');
            }
        }
    }
}


// Includes a detail page
function includeDetailPage($person_id) {
    include('detailpage.php');
}


// Reloads with a new URL
function reloadURL($urlparam) {
    $urlparam = str_replace(" ", "_", $urlparam);
    header('Location: ' . $urlparam);
	die();
}

?>
