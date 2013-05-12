            <?php $activepicker = "Search";
			include('mainpagepicker.php'); ?>

			<div id="findlocal">
                <div id="explanation"><p>This site provides up-to-the-minute streams of all your representatives' online activity, from tweets and Facebook posts to questions in parliament.</p><p>To begin, type the name of your MP or constituency, or your postcode, in the search box.  Alternatively you can use the buttons above to select from a map or from a list of all MPs.</p></div>
				<form id="findform" name="findform" method="post" action="index.php">
				<fieldset class="search">
                	<input type="text" name="query" id="query" class="query" autocomplete="off" autofocus value="Search for an MP!" onfocus="if (this.value == 'Search for an MP!') { this.value = ''}" onblur="if (this.value == '') { this.value = 'Search for an MP!'}" />
                	<button class="submit" type="submit" name="submit" title="Submit">Search</button>
                </fieldset>
				</form>
		  </div>
		<?php
		if ($searchFailed == true) {
			?><div id="error"><p>Your search query was not recognised.  Valid entries are the name of a currently-serving MP, a constituency, or a valid UK postcode.  If you do not have any of this information, try using the map or the list (accessible via the buttons above) to locate the MP you are interested in.</p></div><?php
		}
		if ($detailAdded == true) {
			?><div id="error"><p>Thank you, your submission has been added to the database.  If will appear on the site shortly, once we have verified that it is a real site or username for that MP.</p></div><?php
		}
		?>
		<h4>ADD DETAILS</h4>
		<?php include('adddetail.php'); ?>
		<h4>CONNECT WITH WESTMINSTER HUBBLE</h4>
		<table cellspacing="20"><tr><td valign="top">
		<span id="follow-twitterapi" style="width:180px"></span><script type="text/javascript">twttr.anywhere(function (T) {  T("#follow-twitterapi").followButton("westminsterhub");  });  </script>
		</td><td valign="top">
		<iframe src="http://www.facebook.com/widgets/like.php?href=http://www.facebook.com/pages/Westminster-Hubble/131789076860594?ref=sgm" scrolling="no" frameborder="0" style="border:none; height: 28px;"></iframe>
		</td></tr></table>
