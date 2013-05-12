<?php

require_once('config.php');
require_once('simplepie/simplepie.inc');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

$query = "SET time_zone = 'Europe/London'";
$result = mysql_query($query);

if (isset($_GET['widget'])) {
	$widget = true;
}

if (isset($_GET['blog'])) {
	$blog = true;
}

// If running as a widget, print heading
if ($widget == true) {
	echo ("<h4>Live Feed</h4>");
}

// If we have a person_id, this has been called properly to show a feed page-insert.
if (isset($_GET['person_id'])) {
    $person_id = $_GET['person_id'];

	// Get MP details
    $query = "SELECT * FROM twfy_mps WHERE (twfy_mps.person_id = '" . $person_id . "')";
    $result = mysql_query($query);
    
    if (mysql_num_rows($result) > 0) {
        // Fetch and render
        $mp = mysql_fetch_assoc($result);
        renderFeeds($mp, false, $widget);
    } else {
		echo("Person not found.  Please try that again.");
    }

// No proper id received, display feed for everyone
} else {
	renderFeeds(null, $blog, $widget);
}

mysql_close();



// Renders the main (right-hand feeds) section of the details page.
function renderFeeds($mp, $blog, $widget) {
	$urls = array();
    
    // Set up filter string so we know which feeds to omit.  If we're looking at the firehose or blog
    // (i.e. no person_id specified) use a blank filterstring as we just show everything here.
    if (isset($_GET['person_id'])) {
	    if (isset($_GET["filterstring"])) {
		$filterstring = $_GET["filterstring"];
		
		// Filter string to cookie
	    	setcookie("filterstring", $filterstring, time()+60*60*24*365);
	    } else {
		// Filter string from cookie, if it exists
		if (isset($_COOKIE['filterstring'])) {
		    $filterstring = $_COOKIE["filterstring"];
		// Otherwise blank (show everything)
		} else {
		    $filterstring = "";
		}
	    }
    } else {
	$filterstring = "";
    }

	// Generate certain times used in the creation of friendly display times.
	// We do this here so we only have to do it once, not on every feed item.
    $timeLimit = 1;
    if (isset($_GET["timelimit"])) {
        $timeLimit = $_GET["timelimit"];
    }
	$midnight = strtotime("midnight");
	$midnightYesterday = strtotime("midnight -1 day");
	$oneWeekAgo = strtotime("midnight -6 days");
	$first = strtotime(date("j/n/Y", mktime(0, 0, 0, date("d")-date("d")+1, date("m") , date("Y"))));
	$lastTimeHeading = "";
	
	// Build the fetch query based on the filter string, including a restriction
	// to a certain MP if we have one, and the right number of items.
	$personIDClause = "";
	if ($mp != NULL) $personIDClause = "(person_id = " . $mp["person_id"] . ") AND ";
	$fetchItems = $timeLimit*20;
	if ($widget == true) $fetchItems = 7;
	if ($widget == true) $filterstring = "twfy,website,blog,other";
	$table = "hubble_cache";
	if ($blog == true) $table = "hubble_blog";
	
	$query = "SELECT * FROM " . $table . " WHERE " . $personIDClause . "(0";
	
    if (strpos($filterstring, "twfy") === FALSE) {
        $query = $query . " OR type = 'twfy'";
    }
    if (strpos($filterstring, "website") === FALSE) {
        $query = $query . " OR type = 'website'";
    }
    if (strpos($filterstring, "twitter") === FALSE) {
        $query = $query . " OR type = 'twitter'";
    }
    if (strpos($filterstring, "facebook") === FALSE) {
        $query = $query . " OR type = 'facebook'";
    }
    if (strpos($filterstring, "blog") === FALSE) {
        $query = $query . " OR type = 'blog'";
    }
    if (strpos($filterstring, "youtube") === FALSE) {
        $query = $query . " OR type = 'youtube'";
    }
    if (strpos($filterstring, "other") === FALSE) {
        $query = $query . " OR type = 'other'";
    }
    
	// Run the big fetch query
	$query = $query . ") ORDER BY date DESC LIMIT " . $fetchItems;
	$result = mysql_query($query);
	
	if (mysql_num_rows($result) == 0) {
        if ($filterstring != "") {
            echo("<div class=\"spinner\"><p>Sorry, this MP has no streams that match your filter criteria.  Try checking some of the unchecked filter boxes (above-right).</p></div>");
        } else {
            echo("<div class=\"spinner\"><p>Sorry, this MP has no items in their feed.  This probably means they're a new MP, and they have had no activity in Parliament and no sites have been added for them on the left.</p><p>If you know of one of this MP's websites or social network profiles, please add it on the left and its contents will appear here once it has been approved by the moderation team.</p><p>If one of the items on the left should have an RSS feed but you are seeing this message, the site may have been having technical issues when Westminster Hubble last checked it.  Please try again in an hour.</p></div>");
        }
	} else {
	
    	while ($item = mysql_fetch_assoc($result)) {
	
            // Sort out what we display based on what type of item it is.
            
            if ($item["type"] == "website") {
                $feedtitle = "Website";
            	$favicon = "images/icons/website.png";
                $text = "<a href=\"" . $item["url"] . "\" target=\"_blank\">" . $item["title"] . "</a><br/>" . $item["description"];
                
            } elseif ($item["type"] == "blog") {
                $feedtitle = "Blog";
            	$favicon = "images/icons/blog.png";
                $text = "<a href=\"" . $item["url"] . "\" target=\"_blank\">" . $item["title"] . "</a><br/>" . $item["description"];

            } elseif ($item["type"] == "twitter") {
                $feedtitle = "Twitter";
            	$favicon = "images/icons/twitter.png";
        		$text = parseTwitterLinks($item["description"]);

            } elseif ($item["type"] == "facebook") {
                $feedtitle = "Facebook";
            	$favicon = "images/icons/facebook.png";
            	$text = $item["description"];
        		$text = preg_replace("/<img[^>]+\>/i", "", $text);  // Remove images
        		$text = preg_replace("/<a href[^>]+\><\/a>/i", "", $text); // Remove empty links now images are gone
            	$text = preg_replace("/(<br(\s)?\/>)+/i", "<br/>", $text); // Remove multiple linebreaks
            	if (strpos($text, "<br/>") === 0) $text = substr($text, 5); // Remove initial linebreaks
        		$text = preg_replace("/<div[^>]+\>/i", "", $text);  // Remove divs
        		$text = preg_replace("/<\/div[^>]+\>/i", "", $text);  // Remove divs
        		$text = preg_replace("/<span[^>]+\>/i", "", $text);  // Remove spans
        		$text = preg_replace("/<\/span[^>]+\>/i", "", $text);  // Remove spans

            } elseif ($item["type"] == "youtube") {
                $feedtitle = "YouTube";
            	$favicon = "images/icons/youtube.png";
            	$text = $item["title"];

            } elseif ($item["type"] == "twfy") {
                $feedtitle = "They Work For You";
            	$favicon = "images/icons/twfy.png";
            	$text = $item["title"];

            } else {
                // Catches the legitimate "other" case, and any rogue data
                $feedtitle = "Other";
            	$favicon = "images/icons/other.png";
            	$text = $item["title"];
            }

    		// Do date grouping if not a widget and not the blog
			if (($widget != true) && ($blog != true)) {
	    		$firstinsection = false;
	    		$newTimeHeading = makeFriendlyTime(strtotime($item["date"]), $midnight, $midnightYesterday, $oneWeekAgo, $first);
	    		if ($lastTimeHeading != $newTimeHeading) {
	    			echo ("<h4>" . $newTimeHeading . "</h4>");
	    			$lastTimeHeading = $newTimeHeading;
	    			$firstinsection = true;
	    		}
			}

			// Get a name to display if it's the everyone feed
			if (($mp == NULL) && ($blog != true)) {
				$query = "SELECT name FROM twfy_mps WHERE person_id = " . $item["person_id"];
				$nameresult = mysql_query($query);
				$nameitem = mysql_fetch_assoc($nameresult);
				$name = $nameitem["name"];
			}

			// Get the right photo for blog posts
			if ($blog == true) {
				if (strpos($item["url"], "ianrenton.com")) {
            		$photo = "images/photos/ian.jpg";
            	} else {
                	$photo = "images/photos/chris.jpg";
            	}
			}
            
			// Render item.  Blog and other feeds are very different, so we handle
			// them separately.
			if ($blog != true) {
           		echo('<div class="chunk"><p class="header');
				if ($firstinsection == true) echo(' header-first-in-section');
	    		echo('" style="background-image:url(' . $favicon . ')">');
				if ($mp == NULL) echo ("<span class=\"nameinfeed\"><a href=\"" . str_replace(" ", "_", $name) . "\">" . $name . "</a></span><br/>");
				echo($text);
				if ($widget != true) { echo('<span class="footnote"><a href="' . $item["url"] . '" target="_blank">Source</a></span>'); }
	    		echo('</p></div>');
			} else {
				echo ("<div class=\"chunk\"><h4><a href=\"" . $item["url"] . "\" target=\"_blank\">" . html_entity_decode($item["title"], ENT_QUOTES, 'UTF-8') . "</a> <span class=\"date\">(" . makeFriendlyTime(strtotime($item["date"]), $midnight, $midnightYesterday, $oneWeekAgo, $first) . ")</span></h4><div class=\"content\"><div class=\"blogphoto\"><img src=\"" . $photo . "\"/></div>" . $item["description"] . "</div></div><div style=\"height:20px; clear:both;\"></div>");
			}

        }

	}
	
	// Show the More box.
	if ($widget == true) {
		echo("<div id=\"moreitems\"><a href=\"firehose\"')\">More!</a></div>");
	} elseif ($blog == true) {
		echo("<div id=\"moreitems\"><a href=\"javascript:showMoreBlog('" . ($timeLimit+1) . "')\"')\">More!</a></div>");
	} else {
		echo("<div id=\"moreitems\"><a href=\"javascript:showMoreItems('". $mp["person_id"] . "', '" . ($timeLimit+1) . "')\">More!</a></div>");
	}
   
}


// Turns a UNIX time into a friendly time string, form depending on how
// far in the past the given time is.
function makeFriendlyTime($time, $midnight, $midnightYesterday, $oneWeekAgo, $first) {
	$timeString = "";
	if ($time >= $midnight) {
		$timeString = "Today";
	} else if ($time >= $midnightYesterday) {
		$timeString = "Yesterday";
	} else if ($time >= $oneWeekAgo) {
		$timeString = date("l", $time);
	} else if ($time >= $first) {
		$timeString = date("jS F", $time);
	} else if (!($time >= "2nd January 1970")) {
		$timeString = "Date Unknown";
	} else {
		$timeString = date("F Y", $time);
	}
	return $timeString;
}

// Parses the tweet text, and links up URLs, @names and #tags.
function parseTwitterLinks($html) {
	$html = preg_replace('/\\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]/i', "<a href=\"\\0\">\\0</a>", $html);
	$html = preg_replace('/^d\s(\w+)/', 'd <a href="http://www.twitter.com/\1">\1</a>', $html);
	$html = preg_replace('/(^|\s)@(\w+)/', '\1<a href="http://www.twitter.com/\2">@\2</a>', $html);
	$html = preg_replace('/(^|\s)#(\w+)/', '\1<a href="http://search.twitter.com/search?q=%23\2">#\2</a>', $html);
	return $html;
}

?>
