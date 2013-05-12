<?php
/* Include HTML to display on the main (non-details) page */
	$isHomePage = true;
	$includesMap = true;
	include('header.php');
	
?>
	<div id="blurb">This site provides up-to-the-minute streams of all your representatives' online activity, from tweets and Facebook posts to questions in parliament.</div>

	<div id="maincontainer">
             
	  <div id="mainpagelivefeed">
		  <?php //$widget = true; include('feeds.php'); ?>
	  </div>
	  <div id="mainpagecontents">
		  <?php include('search.php'); ?>
	  </div>
	</div>	

<?php

	include('footer.php');
    
?>
