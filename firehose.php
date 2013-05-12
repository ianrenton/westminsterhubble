<?php

	$isHomePage = false;
	$title = "Firehose";
        // Sets up the function to load the feeds.
	// This is called jQuery-style when the DOM is ready.  Because we need to
	// populate it with values specific to this page, this can't sit in javascript.js.
	$loadFeedsJS = '$("#feeds").load("feeds.php");';
	include('header.php');
	
	echo ("<div id=\"detailcontainer\">");
    renderFirehoseTop();
    renderFirehoseLeft();
    echo ("<div id=\"detailright\">");
	echo ("<div id=\"rsslink\"><div class=\"rss-link info-icon\"><a href=\"rss.php\" target=\"blank\">Subscribe</a></div></div>");
	echo ("<div id=\"feeds\"><div class=\"spinner\"><img src=\"images/ajax-loader.gif\" alt=\"Loading...\"/> Loading...</span></div>");
	echo ("</div></div>");
	include('footer.php');
	

// Renders the top of the Firehose page.
function renderFirehoseTop() {

	echo ("<div class=\"blogname\">Westminster Hubble Firehose</div>");
	echo ("<div class=\"spacer\"></div>");

}


// Renders the left of the Firehose page.
function renderFirehoseLeft() {

    echo ("<div id=\"detailleft\">");

	echo ("<h4>What's a 'firehose'?</h4>");
	echo ("<p>'Firehose' is a term used around the internet for a high-volume feed, much as a real firehose has a large water flow rate.</p>");
	echo ("<p>In the case of Westminster Hubble, this page shows every update from everyone in the database.</p>");
	echo ("<p>You can subscribe to this page via RSS if you want, but I'd only recommend it if you're piping it into some other software &#8212; you're probably not going to want this much stuff clogging up your Google Reader!</p>");

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

    echo ("</div>");
}


?>
