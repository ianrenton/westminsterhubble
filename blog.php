<?php

	$isHomePage = false;
	$title = "Blog";
    // Sets up the function to load the feeds.
	// This is called jQuery-style when the DOM is ready.  Because we need to
	// populate it with values specific to this page, this can't sit in javascript.js.
	$loadFeedsJS = '$("#blogfeeds").load("feeds.php?blog");';
	include('header.php');
	
	echo ("<div id=\"detailcontainer\">");
    renderBlogTop();
    renderBlogLeft();
    echo ("<div id=\"detailright\">");
	echo ("<div id=\"blogfeeds\"><div class=\"spinner\"><img src=\"images/ajax-loader.gif\" alt=\"Loading...\"/> Loading...</span></div>");
	echo ("</div></div>");
	include('footer.php');
	

// Renders the top of the blog page.
function renderBlogTop() {

	echo ("<div class=\"blogname\">Westminster Hubble Blog</div>");
	echo ("<div class=\"spacer\"></div>");

}


// Renders the left of the blog page.
function renderBlogLeft() {

    echo ("<div id=\"detailleft\">");

	echo ("<h4>Who are we?</h4>");
	echo ("<div class=\"sidebarphoto\"><img src=\"images/photos/chris-small.jpg\"/></div><b>Chris Cox</b><br/>Political consultant working in London.");
	echo ("<div style=\"clear:both; height:10px;\"></div>");
	echo ("<div class=\"sidebarphoto\"><img src=\"images/photos/ian-small.jpg\"/></div><b>Ian Renton</b><br/>Code-monkey, net-junkie and part-time socialist.");
	echo ("<div style=\"clear:both; height:10px;\"></div>");
	echo ("<p><a href=\"about\"><b>Read more about us and Westminster Hubble</b></a></p>");

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
