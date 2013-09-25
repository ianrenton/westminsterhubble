<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Westminster Hubble <?php
    if ($title != "") echo (" - " . $title);
    ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/ico" />
	<link rel="icon" href="/favicon.ico" type="image/ico" />
	<link type="text/css" rel="stylesheet" media="all" href="css/style.css" />
	<!--[if IE]> <link rel="stylesheet" href="css/ie.css" type="text/css">  <![endif]-->
	
	<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />
	<?php
    if ($person_id != '') {
		echo ('<link rel="alternate" type="application/rss+xml" title="RSS feed for ' . $title . '" href="rss.php?personid=' . $person_id . '" />');
	} else if ($title == '') {
		echo ('<link rel="alternate" type="application/rss+xml" title="RSS feed for all MPs" href="rss.php" />');
	}
    ?>
	<script type="text/javascript" src="javascript/jquery.js"></script>
	<script type="text/javascript" src="javascript/jquery.form.js"></script>
    <script type='text/javascript' src='javascript/jquery.bgiframe.min.js'></script>
    <script type='text/javascript' src='javascript/jquery.ajaxQueue.js'></script>
    <script type='text/javascript' src='javascript/thickbox-compressed.js'></script>
    <script type='text/javascript' src='javascript/jquery.autocomplete.js'></script>
	<script type="text/javascript" src="javascript/javascript.js"></script>
	<script src="http://platform.twitter.com/anywhere.js?id=4NtMEMChKtGMsythBGvLIQ&amp;v=1"></script>
	<script type="text/javascript" src="javascript/discontinued.js"></script>
	
	<script>
    $(document).ready(function(){
        <?php if ($loadFeedsJS != "") echo ($loadFeedsJS); ?>
        setAutoComplete();
		refreshLiveFeed();
	    var refreshId = setInterval(function() {refreshLiveFeed(); }, 30000);
    });
    </script>
    
    <?php if ($includesMap == true) { ?>
    <script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAA4f8pRNBT_o7wZoAgoU2cgBSVUJKZzB93MwLxrdgHIdsg9xLWERQET5BC1vGowGwzDATWA0cw7bMDAQ"
       type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[

    var iconBlue = new GIcon();
    iconBlue.image = 'images/pins/blue.png';
    iconBlue.shadow = 'images/pins/shadow.png';
    iconBlue.iconSize = new GSize(32, 32);
    iconBlue.shadowSize = new GSize(59, 32);
    iconBlue.iconAnchor = new GPoint(16, 32);
    iconBlue.infoWindowAnchor = new GPoint(5, 1);

    var iconRed = new GIcon();
    iconRed.image = 'images/pins/red.png';
    iconRed.shadow = 'images/pins/shadow.png';
    iconRed.iconSize = new GSize(32, 32);
    iconRed.shadowSize = new GSize(59, 32);
    iconRed.iconAnchor = new GPoint(16, 32);
    iconRed.infoWindowAnchor = new GPoint(5, 1);

    var iconYellow = new GIcon();
    iconYellow.image = 'images/pins/yellow.png';
    iconYellow.shadow = 'images/pins/shadow.png';
    iconYellow.iconSize = new GSize(32, 32);
    iconYellow.shadowSize = new GSize(59, 32);
    iconYellow.iconAnchor = new GPoint(16, 32);
    iconYellow.infoWindowAnchor = new GPoint(5, 1);

    var iconGreen = new GIcon();
    iconGreen.image = 'images/pins/green.png';
    iconGreen.shadow = 'images/pins/shadow.png';
    iconGreen.iconSize = new GSize(32, 32);
    iconGreen.shadowSize = new GSize(59, 32);
    iconGreen.iconAnchor = new GPoint(16, 32);
    iconGreen.infoWindowAnchor = new GPoint(5, 1);

    var iconDarkGreen = new GIcon();
    iconDarkGreen.image = 'images/pins/darkgreen.png';
    iconDarkGreen.shadow = 'images/pins/shadow.png';
    iconDarkGreen.iconSize = new GSize(32, 32);
    iconDarkGreen.shadowSize = new GSize(59, 32);
    iconDarkGreen.iconAnchor = new GPoint(16, 32);
    iconDarkGreen.infoWindowAnchor = new GPoint(5, 1);

    var iconDarkGreenYellowRed = new GIcon();
    iconDarkGreenYellowRed.image = 'images/pins/darkgreenyellowred.png';
    iconDarkGreenYellowRed.shadow = 'images/pins/shadow.png';
    iconDarkGreenYellowRed.iconSize = new GSize(32, 32);
    iconDarkGreenYellowRed.shadowSize = new GSize(59, 32);
    iconDarkGreenYellowRed.iconAnchor = new GPoint(16, 32);
    iconDarkGreenYellowRed.infoWindowAnchor = new GPoint(5, 1);

    var iconPurpleYellow = new GIcon();
    iconPurpleYellow.image = 'images/pins/purpleyellow.png';
    iconPurpleYellow.shadow = 'images/pins/shadow.png';
    iconPurpleYellow.iconSize = new GSize(32, 32);
    iconPurpleYellow.shadowSize = new GSize(59, 32);
    iconPurpleYellow.iconAnchor = new GPoint(16, 32);
    iconPurpleYellow.infoWindowAnchor = new GPoint(5, 1);

    var iconRedWhiteBlue = new GIcon();
    iconRedWhiteBlue.image = 'images/pins/redwhiteblue.png';
    iconRedWhiteBlue.shadow = 'images/pins/shadow.png';
    iconRedWhiteBlue.iconSize = new GSize(32, 32);
    iconRedWhiteBlue.shadowSize = new GSize(59, 32);
    iconRedWhiteBlue.iconAnchor = new GPoint(16, 32);
    iconRedWhiteBlue.infoWindowAnchor = new GPoint(5, 1);

    var iconOrange = new GIcon();
    iconOrange.image = 'images/pins/orange.png';
    iconOrange.shadow = 'images/pins/shadow.png';
    iconOrange.iconSize = new GSize(32, 32);
    iconOrange.shadowSize = new GSize(59, 32);
    iconOrange.iconAnchor = new GPoint(16, 32);
    iconOrange.infoWindowAnchor = new GPoint(5, 1);

    var iconGrey = new GIcon();
    iconGrey.image = 'images/pins/grey.png';
    iconGrey.shadow = 'images/pins/shadow.png';
    iconGrey.iconSize = new GSize(32, 32);
    iconGrey.shadowSize = new GSize(59, 32);
    iconGrey.iconAnchor = new GPoint(16, 32);
    iconGrey.infoWindowAnchor = new GPoint(5, 1);

    var customIcons = [];
    customIcons["Conservative"] = iconBlue;
    customIcons["Labour"] = iconRed;
    customIcons["Liberal Democrat"] = iconYellow;
    customIcons["DUP"] = iconRedWhiteBlue;
    customIcons["Scottish National Party"] = iconPurpleYellow;
    customIcons["Plaid Cymru"] = iconOrange;
    customIcons["Green"] = iconGreen;
    customIcons["Sinn Fein"] = iconDarkGreen;
    customIcons["Social Democratic and Labour Party"] = iconDarkGreenYellowRed;
    customIcons["Other"] = iconGrey;

    //]]>
  </script>
  <?php } ?>

	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-40732019-5']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
  </head>


  <body>

	<?php if ($isHomePage == true) { ?>
    <div id="header">
        <div id="headerright-thick">
            <div id="linksinheader"><a href="about">About</a><a href="blog">Blog</a><a href="contact">Contact</a><a href="statistics">Stats</a></div>
        </div>
        <a href="/"><img src="images/logo-thick.png"></a>
    </div>
	<?php } else { ?>
    <div id="header-thin">
        <div id="headerright-thin">
            <div id="linksinheader"><?php renderSearch(); ?></div>
        </div>
        <a href="/"><img src="images/logo-thin.png"></a>
    </div>
	<?php } ?>

<?php
function renderSearch() {
	?><div id="findlocal">
		<form id="findform" name="findform" method="post" action="index.php">
			<a href="about">About</a><a href="blog">Blog</a><a href="contact">Contact</a><a href="statistics">Stats</a>
			<fieldset class="smallsearch">
				<input type="text" name="query" id="query" class="query" value="Search" autocomplete="off" onfocus="if (this.value == 'Search') { this.value = '' }" onblur="if (this.value == '') { this.value = 'Search' }">
				<button class="submit" type="submit" name="submit" value="Go" >Go</button>
			</fieldset>
		</form>
	</div><?php
}
?>
