<?php

	$isHomePage = false;
	$title = "Contact";
	
	include('header.php');
	
	echo ("<div id=\"detailcontainer\">");
    renderAboutTop();
    renderAboutLeft();
    echo ("<div id=\"detailright\">");
	echo ("<div id=\"blogfeeds\">");
	?>
	<div class="content">
		<form method="POST" action="contact-send.php">

		<p>Your name:<br>
		<input type="text" size="50" name="YourName">
		<p>Your e-mail address:<br>
		<input type="text" size="50" name="EmailFrom">
		<p>Message:<br>
		<textarea name="Message" cols="70" rows="10"></textarea>
		<p><input type="submit" name="submit" value="Submit">
		</form>

	<?php
	
	if (isset($_GET['return'])) {
	    if ($_GET['return'] == "ok") {
			echo('<div id="infobox"><p>Your message was successfully submitted!  Thanks for contacting the Westminster Hubble team.</p></div>');
		} else {
			echo('<div id="error"><p>Your message failed to send.  Please check you have filled in all the boxes.</p></div>');
		}
	}
	
	echo ("</div></div></div></div>");
	include('footer.php');
	
	
	// Renders the top of the about page.
	function renderAboutTop() {

		echo ("<div class=\"blogname\">Contact Us</div>");
		echo ("<div class=\"spacer\"></div>");

	}


	// Renders the left of the about page.
	function renderAboutLeft() {

	    echo ("<div id=\"detailleft\">");

		echo ("<h4>Contact Form</h4>");
		
		echo ("<p>Please use this form to contact the people behind Westminster Hubble!</p>");

	    echo ("</div>");
	}
?>