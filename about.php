<?php

	$isHomePage = false;
	$title = "About";
	
	include('header.php');
	
	echo ("<div id=\"detailcontainer\">");
    renderAboutTop();
    renderAboutLeft();
    echo ("<div id=\"detailright\">");
	echo ("<div id=\"blogfeeds\">");
	?>
	<h3>What is Westminster Hubble?</h3>
	<div class="content">
	<p>Westminster Hubble was created as a social experiment, to create an open platform which collates any and all sources of information about MPs and others involved in the political sphere. This could be Twitter, Facebook, blogs, or any other service.</p>

	<p>Initially we've only included MPs, but over time we will add more features, including journalists and anyone else who occurs to us.</p>

	<p>Due to the number of potential sources of information we want people to submit sources of information on MPs and others. We'll then check them out, and if they're legitimate, add them to the appropriate feed. That way, we'll always have the most current information.</p>

	<p>This is a community project, something which everyone can contribute to. We want to make this the biggest directory of information on politicos available in the UK over time, and we hope you'll help us do it.</p>
	</div>
	<h3>Who created it?</h3>
	<div class="content">
	<div class="sidebarphoto"><img src="images/photos/chris-small.jpg"/></div>
	<p>The concept of Westminster Hubble was created by <b><a href="http://recampaign.blogspot.com/2010/01/about-me.html" target="_blank">Chris Cox</a></b>, a political consultant working and living in London.<br/><br/><br/></p>
	<div class="sidebarphoto"><img src="images/photos/ian-small.jpg"/></div>
	<p>The site was programmed by <b><a href="http://ianrenton.com" target="_blank">Ian Renton</a></b>, a software engineer who seems to be growing ever more political these days.  He considers programming his base state, and is surprised and grateful that people seem to want to pay him for it.  Ian has a day job in the defence industry, an evening job as a husband and a father, and seems to sacrifice all his spare time to writing web apps like this one.</p>
	</div>
	<h3>What's your motivation for creating Westminster Hubble?</h3>
	<div class="content">
	<p>We're passionate about technology's role in politics.  Many MPs have websites, blogs, even Twitter and Facebook accounts, but they can be hard to find even if you're looking.  This is why we created Westminster Hubble to pull everything together and give users any easy way to communicate with their MP.</p>
	</div>
	<h3>Where does the data come from?</h3>
	<div class="content">
	<p>Core MP data, such as names, parties, constituencies and photos, come from TheyWorkForYou, a site dedicated to allowing us to keep tracks on our MPs, via their splendid API.  All the other information about each MP, such as their websites and Twitter usernames, we rely on users of the site to add and maintain.</p>
	<p>Behind the scenes, Westminster Hubble crawls all the feeds it knows about regularly, building up the list of items that you see on each MP's page.</p>
	</div>
	<h3>What's the status of Westminster Hubble?</h3>
	<div class="content">
	<p>Westminster Hubble is currently in an open beta test.  We believe that there are no current issues, however, please let us know via the <a href="contact">contact form</a> if you have any difficulty using the site or if you have features you would like to suggest.</p>
	<p>In case you were about to ask, non-Westminster representatives (i.e. of European and Scottish Parliaments, Welsh and Northern Irish Assemblies) are planned to be added in the near future.</p>
	</div>
	<h3>How can I keep up-to-date with Westminster Hubble news?</h3>
	<div class="content">
	<p>We're on Twitter as <a href="http://www.twitter.com/WestminsterHub" target="new">@WestminsterHub</a>, and we also have a <a href="http://www.facebook.com/pages/Westminster-Hubble/131789076860594?ref=sgm" target="new">page on Facebook</a>.  Follow us on Twitter or Like our Facebook page, and you'll stay up-to-date.</p>
	</div>
	<h3>Are you affiliated with a political party?</h3>
	<div class="content">
	<p>No, Westminster Hubble is a non-partisan website.</p>
	</div>
	<h3>Are you a profit-making organisation?</h3>
	<div class="content">
	<p>No.  We use the ads on this site to help us cover our bandwidth bills, but the site has no other forms of revenue.</p>
	</div>
	<?php
	echo ("</div></div></div>");
	include('footer.php');
	
	
	// Renders the top of the about page.
	function renderAboutTop() {

		echo ("<div class=\"blogname\">About Westminster Hubble</div>");
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
