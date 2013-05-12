<?php

// If we have a person_id, this has been set up properly to include a details page.
if (isset($person_id)) {

	// Get MP details
    $query = "SELECT * FROM twfy_mps, hubble_mps WHERE (twfy_mps.person_id = hubble_mps.person_id) AND (twfy_mps.person_id = '" . $person_id . "')";
    $result = mysql_query($query);
    $mp = mysql_fetch_assoc($result);

	// Get constituency lat/long for the map
	/*$query = "SELECT * FROM twfy_constituencies WHERE (con_name = '" . $mp["constituency"] . "')";
    $result = mysql_query($query);
    $constituency = mysql_fetch_assoc($result);
	$mapLat = $constituency["centre_lat"];
	$mapLon = $constituency["centre_lon"];*/

	// Begin rendering
	$title = $mp["name"];
    $isHomePage = false;
    
    // Sets up the function to load the feeds.
	// This is called jQuery-style when the DOM is ready.  Because we need to
	// populate it with values from the DB, this can't sit in javascript.js.
	// Pass on the refreshcache signal if we got one.
	if (isset($_GET['refreshcache'])) {
		$refresh = "&refreshcache=true";
	} else {
		$refresh = "";
	}
    $loadFeedsJS = '$("#feeds").load("feeds.php?person_id=' . $person_id . $refresh . '");';
    
	include('header.php');


	echo ("<div id=\"detailcontainer\">");
    renderMPDetailsTop($mp);
    renderMPDetailsLeft($mp);
    echo ("<div id=\"detailright\">");
    renderFilters($mp);
    renderRSSLink($mp);
	echo ("<div id=\"feeds\"><div class=\"spinner\"><img src=\"images/ajax-loader.gif\" alt=\"Loading...\"/> Loading...</span></div>");
	echo ("</div></div>");
	include('footer.php');

} else {
    $searchfailed = true;
	include('mainpage.php');
}

// Renders the top of the details page.
function renderMPDetailsTop($mp) {
    $name = $mp["name"];
    $party = $mp["party"];
    $constituency = $mp["constituency"];
    $pic_url = $mp["pic_url"];
    $pic_height = $mp["pic_height"];
    $pic_width = $mp["pic_width"];
    $position = $mp["position"];
    $dept = $mp["dept"];

	echo ("<div class=\"picture\"><img src=\"" . $pic_url . "\" height=\"" . $pic_height . "\" width=\"" . $pic_width . "\"/></div>");
    echo ("<table><tr><td colspan=\"2\"><!--span class=\"lineheader\">Name </span></td><td--><span class=\"name\">" . $name . "</span></td></tr>");
    echo ("<tr><td><span class=\"lineheader\">Party </span></td><td><span class=\"detail " . str_replace(" ", "-", strtolower($party)) . "\">" . $party . "</span></td></tr>");
    echo ("<tr><td><span class=\"lineheader\">Const </span></td><td><span class=\"detail\">" . $constituency . "</span></td></tr>");
    if ($position != "") {
    	echo ("<tr><td><span class=\"lineheader\">Title </span></td><td><span class=\"detail\">" . $position);
		if (($dept != "") && ($dept != "No Department")) {
			echo(",</span><span class=\"detailsmall\">" . $dept . "</span>");
		} else {
			echo("</span>");
		}
		echo("</td></tr>");
        //echo ("<tr><td><span class=\"lineheader\">Dept </span></td><td><span class=\"detail\">" . $dept . "</span></td></tr>");
    }
    echo ("</table>");
	echo ("<div class=\"spacer\"></div>");

}


// Renders the left of the details page.
function renderMPDetailsLeft($mp) {
    $person_id = $mp["person_id"];
    $name = $mp["name"];
    $constituency = $mp["constituency"];
    $position = $mp["position"];
    $dept = $mp["dept"];
    $website = $mp["website"];
    $twitter = $mp["twitter"];
    $facebook = $mp["facebook"];
    $blog = $mp["blog"];
    $youtube = $mp["youtube"];
    $email = $mp["email"];
    $address = $mp["address"];
    $phone = $mp["phone"];
    $wikipedia = $mp["wikipedia"];
    $other = $mp["other"];

    echo ("<div id=\"detailleft\">");

	echo ("<h4>Net Presence</h4>");

    echo ("<div class=\"website-link info-icon\">");
    if ($website != "") {
		preg_match('/^(https?|ftp|file):\/\/([^\/]+)\/?(.*)$/', $website, $urlParts);
	    $server = $urlParts[2];
		if (strpos($server, "www.") === 0) {
			$server = substr($server, 4);
		}
        echo ("<a href=\"" . $website . "\" target=\"_blank\">" . $server . "</a>");
    }
	echo (" <a class=\"editlink\" href=\"javascript:setDetail('". $person_id . "', 'website', '". $website . "', 'Please enter the full URL (including http://) of the MP\'s website:');\">");
	if ($website != "") {
        echo ("Edit");
    } else {
        echo ("Add");
    }
    echo ("</a></div>");

    echo ("<div class=\"blog-link info-icon\">");
    if ($blog != "") {
		preg_match('/^(https?|ftp|file):\/\/([^\/]+)\/?(.*)$/', $blog, $urlParts);
	    $server = $urlParts[2];
		if (strpos($server, "www.") === 0) {
			$server = substr($server, 4);
		}
        echo ("<a href=\"" . $blog . "\" target=\"_blank\">" . $server . "</a>");
    }
	echo (" <a class=\"editlink\" href=\"javascript:setDetail('". $person_id . "', 'blog', '". $blog . "', 'Please enter the full URL (including http://) of the MP\'s blog, if it differs from their homepage:');\">");
	if ($blog != "") {
        echo ("Edit");
    } else {
        echo ("Add");
    }
    echo ("</a></div>");

	echo ("<div class=\"email-link info-icon\">");
    if ($email != "") {
        echo ("<a href=\"mailto:" . $email . "\">" . $email . "</a>");
    }
	echo (" <a class=\"editlink\" href=\"javascript:setDetail('". $person_id . "', 'email', '". $email . "', 'Please enter the MP\'s e-mail address:');\">");
	if ($email != "") {
        echo ("Edit");
    } else {
        echo ("Add");
    }
    echo ("</a></div>");

	echo ("<h4>Social Networks</h4>");

    echo ("<div class=\"twitter-link info-icon\">");
    if ($twitter != "") {
        echo ("<a href=\"http://www.twitter.com/" . $twitter . "\" target=\"_blank\">@" . $twitter . "</a>");
    }
	echo (" <a class=\"editlink\" href=\"javascript:setDetail('". $person_id . "', 'twitter', '". $twitter . "', 'Please enter the MP\'s Twitter username (not a URL!):');\">");
	if ($twitter != "") {
        echo ("Edit");
    } else {
        echo ("Add");
    }
    echo ("</a></div>");

    echo ("<div class=\"facebook-link info-icon\">");
    if ($facebook != "") {
        echo ("<a href=\"" . $facebook . "\" target=\"_blank\">" . $name . "</a>");
    }
	echo (" <a class=\"editlink\" href=\"javascript:setDetail('". $person_id . "', 'facebook', '". $facebook . "', 'Please enter the full URL (including http://) of the MP\'s Facebook page:');\">");
	if ($facebook != "") {
        echo ("Edit");
    } else {
        echo ("Add");
    }
    echo ("</a></div>");


    echo ("<div class=\"youtube-link info-icon\">");
    if ($youtube != "") {
        echo ("<a href=\"http://www.youtube.com/user/" . $youtube . "\" target=\"_blank\">" . $youtube . "</a>");
    }
	echo (" <a class=\"editlink\" href=\"javascript:setDetail('". $person_id . "', 'youtube', '". $youtube . "', 'Please enter the MP\'s YouTube username (not a URL!):');\">");
	if ($youtube != "") {
        echo ("Edit");
    } else {
        echo ("Add");
    }
    echo ("</a></div>");

    echo ("<div class=\"other-link info-icon\">");
    if ($other != "") {
		preg_match('/^(https?|ftp|file):\/\/([^\/]+)\/?(.*)$/', $other, $urlParts);
	    $server = $urlParts[2];
		if (strpos($server, "www.") === 0) {
			$server = substr($server, 4);
		}
        echo ("<a href=\"" . $other . "\" target=\"_blank\">" . $server . "</a>");
    }
	echo (" <a class=\"editlink\" href=\"javascript:setDetail('". $person_id . "', 'other', '". $other . "', 'Please enter the full URL (including http://) of the MP\'s page on another social network:');\">");
	if ($other != "") {
        echo ("Edit");
    } else {
        echo ("Add");
    }
    echo ("</a></div>");

	if (($mp['twitter'] != "") || ($mp['youtube'] != "") || ($mp['facebook'] != "")) {
		echo('<div style="margin-bottom:20px"></div>');
	}
	if ($mp['twitter'] != "") {
		echo ('<span id="follow-twitterapi" style="padding-left:10px;"></span><script type="text/javascript">twttr.anywhere(function (T) {  T("#follow-twitterapi").followButton("' . $mp['twitter'] . '");  });  </script>');
	}
	if ($mp['facebook'] != "") {
		echo ('<iframe src="http://www.facebook.com/widgets/like.php?href=' . $mp['facebook'] . '" scrolling="no" frameborder="0" style="border:none; height:30px; width:250px; padding:10px 0 0 10px;"></iframe>');
	}
	if ($mp['youtube'] != "") {
		echo ('<a href="http://www.youtube.com/subscription_center?add_user=' . $mp['youtube'] . '"><img src="images/youtubesubscribe.png" border="0" style="margin-top:10px; margin-left:8px;"/></a>');
	}

	echo ("<h4>Other Sites</h4>");

	echo ("<div class=\"twfy-link info-icon\">");
	echo ("<a href=\"" . getTWFYURL($name, $constituency) . "\" target=\"_blank\">TheyWorkForYou</a>");
    echo ("</div>");

	echo ("<div class=\"parliament-link info-icon\">");
	echo ("<a href=\"" . getParliamentURL($name, $constituency) . "\" target=\"_blank\">UK Parliament</a>");
    echo ("</div>");

	echo ("<div class=\"telegraph-link info-icon\">");
	echo ("<a href=\"" . getTelegraphURL($name, $constituency) . "\" target=\"_blank\">Telegraph</a>");
    echo ("</div>");

	echo ("<div class=\"parliament-link info-icon\">");
	echo ("<a href=\"" . getAllowancesURL($name, $constituency) . "\" target=\"_blank\">Allowances</a>");
    echo ("</div>");

    echo ("<div class=\"wikipedia-link info-icon\">");
    if ($wikipedia != "") {
        echo ("<a href=\"" . $wikipedia . "\" target=\"_blank\">Wikipedia Entry</a>");
    }
	echo (" <a class=\"editlink\" href=\"javascript:setDetail('". $person_id . "', 'wikipedia', '". $wikipedia . "', 'Please enter the full URL (including http://) of the MP\'s Wikipedia page:');\">");
	if ($wikipedia != "") {
        echo ("Edit");
    } else {
        echo ("Add");
    }
    echo ("</a></div>");

	echo ("<h4>Offline</h4>");

	echo ("<div class=\"address-link info-icon\">");
    if ($address != "") {
        echo ("<a href=\"http://maps.google.com/?q=" . $address . "\" target=\"_blank\">" . $address . "");
    }
	echo (" <a class=\"editlink\" href=\"javascript:setDetail('". $person_id . "', 'address', '". $address . "', 'Please enter the MP\'s home or local office postal address:');\">");
	if ($address != "") {
        echo ("Edit");
    } else {
        echo ("Add");
    }
    echo ("</a></div>");

	echo ("<div class=\"phone-link info-icon\">");
    if ($phone != "") {
        echo ($phone);
    }
	echo (" <a class=\"editlink\" href=\"javascript:setDetail('". $person_id . "', 'phone', '". $phone . "', 'Please enter the MP\'s home or local office telephone number:');\">");
	if ($phone != "") {
        echo ("Edit");
    } else {
        echo ("Add");
    }
    echo ("</a></div>");
	
	echo ("<h4>Advertisement</h4>");

    ?>
        <script type="text/javascript"><!--
        google_ad_client = "pub-1015407546173442";
        /* Hubble Vertical */
        google_ad_slot = "1908702328";
        google_ad_width = 120;
        google_ad_height = 600;
        //-->
        </script>
        <script type="text/javascript"
        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
        <?

    echo ("</div>"); // Close detailleft
}


function getTWFYURL($name, $constituency) {
	$url = "http://www.theyworkforyou.com/mp/";
	$url .= strtolower(str_replace(" ", "_", $name));
	$url .= "/";
	$url .= strtolower(str_replace(" ", "_", $constituency));
	return $url;
}

function getTelegraphURL($name, $constituency) {
	$url = "http://ukpolitics.telegraph.co.uk/";
	$url .= str_replace(" ", "+", $constituency);
	$url .= "/";
	$url .= str_replace(" ", "+", $name);
	return $url;
}

function getParliamentURL($name, $constituency) {
	$url = "http://findyourmp.parliament.uk/constituencies/";
	$url .= strtolower(str_replace(" ", "-", $constituency));
	return $url;
}

function getAllowancesURL($name, $constituency) {
	$url = "http://mpsallowances.parliament.uk/mpslordsandoffices/hocallowances/allowances-by-mp/";
	$url .= strtolower(str_replace(" ", "-", $name));
	return $url;
}


// Renders the filter form
function renderFilters($mp) {
    // Filter string from cookie, if it exists
    if (isset($_COOKIE['filterstring'])) {
        $filterstring = $_COOKIE["filterstring"];
    // Otherwise blank (show everything)
    } else {
        $filterstring = "";
    }
    
    $person_id = $mp["person_id"];

	?><div id="filters">
		<form id="filterform" name="filterform">
		Filter:&nbsp;&nbsp;
        <span <?php if ($mp["website"] == "") { echo ('style="display:none;"'); } ?>><img src="images/icons/website.png"><input type="checkbox" name="website" onclick="javascript:setFilters(<?php echo ($person_id); ?>)" <?php if (strpos($filterstring, "website") === FALSE) echo("checked"); ?>>&nbsp;&nbsp;</span>
        <span <?php if ($mp["blog"] == "") { echo ('style="display:none;"'); } ?>><img src="images/icons/blog.png"><input type="checkbox" name="blog" onclick="javascript:setFilters(<?php echo ($person_id); ?>)" <?php if (strpos($filterstring, "blog") === FALSE) echo("checked"); ?>>&nbsp;&nbsp;</span>
        <span <?php if ($mp["twitter"] == "") { echo ('style="display:none;"'); } ?>><img src="images/icons/twitter.png"><input type="checkbox" name="twitter" onclick="javascript:setFilters(<?php echo ($person_id); ?>)" <?php if (strpos($filterstring, "twitter") === FALSE) echo("checked"); ?>>&nbsp;&nbsp;</span>
        <span <?php if ($mp["facebook"] == "") { echo ('style="display:none;"'); } ?>><img src="images/icons/facebook.png"><input type="checkbox" name="facebook" onclick="javascript:setFilters(<?php echo ($person_id); ?>)" <?php if (strpos($filterstring, "facebook") === FALSE) echo("checked"); ?>>&nbsp;&nbsp;</span>
        <span <?php if ($mp["youtube"] == "") { echo ('style="display:none;"'); } ?>><img src="images/icons/youtube.png"><input type="checkbox" name="youtube" onclick="javascript:setFilters(<?php echo ($person_id); ?>)" <?php if (strpos($filterstring, "youtube") === FALSE) echo("checked"); ?>>&nbsp;&nbsp;</span>
        <span <?php if ($mp["other"] == "") { echo ('style="display:none;"'); } ?>><img src="images/icons/other.png"><input type="checkbox" name="other" onclick="javascript:setFilters(<?php echo ($person_id); ?>)" <?php if (strpos($filterstring, "other") === FALSE) echo("checked"); ?>>&nbsp;&nbsp;</span>
		<span><img src="images/icons/twfy.png"><input type="checkbox" name="twfy" onclick="javascript:setFilters(<?php echo ($person_id); ?>)" <?php if (strpos($filterstring, "twfy") === FALSE) echo("checked"); ?>></span>
		</form>
	</div><?php
}

// Renders the RSS link
function renderRSSLink($mp) {
	echo ("<div id=\"rsslink\"><div class=\"rss-link info-icon\"><a href=\"rss.php?personid=" . $mp['person_id'] . "\" target=\"blank\">Subscribe</a></div>");
	
	echo("</div>");
}

?>
