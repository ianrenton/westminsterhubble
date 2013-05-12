<?php

	$isHomePage = false;
	$title = "Statistics";
	
	include('header.php');
	
	echo ("<div id=\"detailcontainer\">");
    renderAboutTop();
    renderAboutLeft();
    echo ("<div id=\"detailright\">");
	echo ("<div id=\"blogfeeds\">");
	
	$query = "SELECT * FROM hubble_statscache WHERE 1";
	$result = mysql_query($query);
	$assoc = mysql_fetch_assoc($result);
	$html = $assoc['html'];
	
	echo($html);

	echo ("</div></div></div>");
	include('footer.php');
	
	
	// Renders the top of the about page.
	function renderAboutTop() {

		echo ("<div class=\"blogname\">Westminster Hubble Statistics</div>");
		echo ("<div class=\"spacer\"></div>");

	}


	// Renders the left of the about page.
	function renderAboutLeft() {

	    echo ("<div id=\"detailleft\">");

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
