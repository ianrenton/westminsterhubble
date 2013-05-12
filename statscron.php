<?php

require_once('config.php');
require_once('simplepie/simplepie.inc');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

echo('<h2>Stats Cron Job</h2>');

$query = "SET time_zone = 'Europe/London'";
$result = mysql_query($query);

echo('Time: ' . date('H:i') . '<br/>');

echo('<b>Crunching stats...</b><br/>');

// 'Spammer'
$query = "SELECT COUNT(*) AS `Rows`, person_id FROM `hubble_cache` GROUP BY person_id ORDER BY `Rows` DESC LIMIT 1";
$result = mysql_query($query);
$item = mysql_fetch_assoc($result);
$spammerNumPosts = $item['Rows'];
$spammerPersonID = $item['person_id'];
$query = "SELECT name FROM twfy_mps WHERE (person_id=" . $spammerPersonID . ")";
$result = mysql_query($query);
$nameAssoc = mysql_fetch_assoc($result);
$query = "SELECT date FROM hubble_cache WHERE (date != \"0000-00-00 00:00:00\") AND (person_id = " . $spammerPersonID . ") ORDER BY date ASC LIMIT 1";
$result = mysql_query($query);
$dateAssoc = mysql_fetch_assoc($result);
$spammer = array('name' => $nameAssoc['name'], 'number' => $spammerNumPosts, 'since' => $dateAssoc['date']);

// 'Member of the Moment'
$query = "SELECT COUNT(*) AS `Rows`, person_id FROM `hubble_cache` WHERE (hubble_cache.date > \"" . date('Y-m-d H:i:s', strtotime('-24 hours')) . "\") GROUP BY person_id ORDER BY `Rows` DESC LIMIT 1";
$result = mysql_query($query);
$item = mysql_fetch_assoc($result);
$momNumPosts = $item['Rows'];
$momPersonID = $item['person_id'];
$query = "SELECT name FROM twfy_mps WHERE (person_id=" . $momPersonID . ")";
$result = mysql_query($query);
$nameAssoc = mysql_fetch_assoc($result);
$memberOfTheMoment = array('name' => $nameAssoc['name'], 'number' => $momNumPosts);

// 'Blogger'
$query = "SELECT COUNT(*) AS `Rows`, person_id FROM `hubble_cache` WHERE (type = \"blog\") OR (type = \"website\") GROUP BY person_id ORDER BY `Rows` DESC LIMIT 1";
$result = mysql_query($query);
$item = mysql_fetch_assoc($result);
$mostProlificBloggerNumPosts = $item['Rows'];
$mostProlificBloggerPersonID = $item['person_id'];
$query = "SELECT name FROM twfy_mps WHERE (person_id=" . $mostProlificBloggerPersonID . ")";
$result = mysql_query($query);
$nameAssoc = mysql_fetch_assoc($result);
$query = "SELECT date FROM hubble_cache WHERE (date != \"0000-00-00 00:00:00\") AND (person_id = " . $mostProlificBloggerPersonID . ") ORDER BY date ASC LIMIT 1";
$result = mysql_query($query);
$dateAssoc = mysql_fetch_assoc($result);
$oldestItem = $dateAssoc['date'];
$mostProlificBlogger = array('name' => $nameAssoc['name'], 'number' => $mostProlificBloggerNumPosts, 'since' => $dateAssoc['date']);

// 'Twitterati'
$query = "SELECT COUNT(*) AS `Rows`, person_id FROM `hubble_cache` WHERE (type = \"twitter\") GROUP BY person_id ORDER BY `Rows` DESC LIMIT 1";
$result = mysql_query($query);
$item = mysql_fetch_assoc($result);
$twitteratiNumPosts = $item['Rows'];
$twitteratiPersonID = $item['person_id'];
$query = "SELECT name FROM twfy_mps WHERE (person_id=" . $twitteratiPersonID . ")";
$result = mysql_query($query);
$nameAssoc = mysql_fetch_assoc($result);
$query = "SELECT date FROM hubble_cache WHERE (date != \"0000-00-00 00:00:00\") AND (person_id = " . $twitteratiPersonID . ") ORDER BY date ASC LIMIT 1";
$result = mysql_query($query);
$dateAssoc = mysql_fetch_assoc($result);
$oldestItem = $dateAssoc['date'];
$twitterati = array('name' => $nameAssoc['name'], 'number' => $twitteratiNumPosts, 'since' => $dateAssoc['date']);

// 'Facebooker'
$query = "SELECT COUNT(*) AS `Rows`, person_id FROM `hubble_cache` WHERE (type = \"facebook\") GROUP BY person_id ORDER BY `Rows` DESC LIMIT 1";
$result = mysql_query($query);
$item = mysql_fetch_assoc($result);
$facebookerNumPosts = $item['Rows'];
$facebookerPersonID = $item['person_id'];
$query = "SELECT name FROM twfy_mps WHERE (person_id=" . $facebookerPersonID . ")";
$result = mysql_query($query);
$nameAssoc = mysql_fetch_assoc($result);
$query = "SELECT date FROM hubble_cache WHERE (date != \"0000-00-00 00:00:00\") AND (person_id = " . $facebookerPersonID . ") ORDER BY date ASC LIMIT 1";
$result = mysql_query($query);
$dateAssoc = mysql_fetch_assoc($result);
$oldestItem = $dateAssoc['date'];
$facebooker = array('name' => $nameAssoc['name'], 'number' => $facebookerNumPosts, 'since' => $dateAssoc['date']);

// 'Representative'
$query = "SELECT COUNT(*) AS `Rows`, person_id FROM `hubble_cache` WHERE (type = \"twfy\") GROUP BY person_id ORDER BY `Rows` DESC LIMIT 1";
$result = mysql_query($query);
$item = mysql_fetch_assoc($result);
$dedicatedRepresentativeNumPosts = $item['Rows'];
$dedicatedRepresentativePersonID = $item['person_id'];
$query = "SELECT name FROM twfy_mps WHERE (person_id=" . $dedicatedRepresentativePersonID . ")";
$result = mysql_query($query);
$nameAssoc = mysql_fetch_assoc($result);
$query = "SELECT date FROM hubble_cache WHERE (date != \"0000-00-00 00:00:00\") AND (person_id = " . $dedicatedRepresentativePersonID . ") ORDER BY date ASC LIMIT 1";
$result = mysql_query($query);
$dateAssoc = mysql_fetch_assoc($result);
$oldestItem = $dateAssoc['date'];
$dedicatedRepresentative = array('name' => $nameAssoc['name'], 'number' => $dedicatedRepresentativeNumPosts, 'since' => $dateAssoc['date']);

// Count MPs
$query = "SELECT count(*) FROM twfy_mps";
$result = mysql_query($query);
$assoc = mysql_fetch_assoc($result);
$numberOfMPs = $assoc['count(*)'];

// Cached items
$query = "SELECT count(*) FROM hubble_cache";
$result = mysql_query($query);
$assoc = mysql_fetch_assoc($result);
$numberOfCachedItems = $assoc['count(*)'];

// Oldest
$query = "SELECT date FROM hubble_cache WHERE (date > \"1990-01-01 00:00:00\") ORDER BY date ASC LIMIT 1";
$result = mysql_query($query);
$assoc = mysql_fetch_assoc($result);
$oldestItem = $assoc['date'];

// Newest
$query = "SELECT date FROM hubble_cache ORDER BY date DESC LIMIT 1";
$result = mysql_query($query);
$assoc = mysql_fetch_assoc($result);
$newestItem = $assoc['date'];

// DB Size
$query = "SELECT table_schema \"westminsterhubble\", sum( data_length + index_length ) / 1024 / 1024 \"size\" FROM information_schema.TABLES GROUP BY table_schema ;";
$result = mysql_query($query);
$assoc = mysql_fetch_assoc($result);
$assoc = mysql_fetch_assoc($result);
$dbSize = substr($assoc['size'], 0, 5);

// Twitterers
$query = "SELECT count(*) FROM twfy_mps, hubble_mps WHERE (twfy_mps.person_id = hubble_mps.person_id) AND (hubble_mps.twitter != '')";
$result = mysql_query($query);
$assoc = mysql_fetch_assoc($result);
$numberOfMPsOnTwitter = $assoc['count(*)'];

// Facebookers
$query = "SELECT count(*) FROM twfy_mps, hubble_mps WHERE (twfy_mps.person_id = hubble_mps.person_id) AND (hubble_mps.facebook != '')";
$result = mysql_query($query);
$assoc = mysql_fetch_assoc($result);
$numberOfMPsOnFacebook = $assoc['count(*)'];

// YouTubers
$query = "SELECT count(*) FROM twfy_mps, hubble_mps WHERE (twfy_mps.person_id = hubble_mps.person_id) AND (hubble_mps.youtube != '')";
$result = mysql_query($query);
$assoc = mysql_fetch_assoc($result);
$numberOfMPsOnYoutube = $assoc['count(*)'];

// Modqueue
$query = "SELECT count(*) FROM hubble_modqueue";
$result = mysql_query($query);
$assoc = mysql_fetch_assoc($result);
$modQueueSize = $assoc['count(*)'];

$html='
<h3>Badges</h3>
<div class="content"><br/>
<div class="blogphoto"><img src="images/badges/spamking.png"/></div><b>Spam King</b><br/><a href="' . $spammer['name'] . '">' . $spammer['name'] . '</a>, with ' . $spammer['number'] . ' items posted since ' . date('F Y', strtotime($spammer['since'])) . '.</p><div style="clear:both;"></div>
<div class="blogphoto"><img src="images/badges/moment.png"/></div><b>Member of the Moment</b><br/><a href="' . $memberOfTheMoment['name'] . '">' . $memberOfTheMoment['name'] . '</a>, with ' . $memberOfTheMoment['number'] . ' items posted in the last 24 hours.</p><div style="clear:both;"></div>
<div class="blogphoto"><img src="images/badges/blogger.png"/></div><b>Most Prolific Blogger</b><br/><a href="' . $mostProlificBlogger['name'] . '">' . $mostProlificBlogger['name'] . '</a>, who has blogged ' . $mostProlificBlogger['number'] . ' times since ' . date('F Y', strtotime($mostProlificBlogger['since'])) . '.</p><div style="clear:both;"></div>
<div class="blogphoto"><img src="images/badges/twitterati.png"/></div><b>Prince of the Twitterati</b><br/><a href="' . $twitterati['name'] . '">' . $twitterati['name'] . '</a>, who has tweeted ' . $twitterati['number'] . ' times since ' . date('F Y', strtotime($twitterati['since'])) . '.</p><div style="clear:both;"></div>
<div class="blogphoto"><img src="images/badges/facebooker.png"/></div><b>Facebooker Extraordinaire</b><br/><a href="' . $facebooker['name'] . '">' . $facebooker['name'] . '</a>, who has posted ' . $facebooker['number'] . ' things on their Facebook wall since ' . date('F Y', strtotime($facebooker['since'])) . '.</p><div style="clear:both;"></div>
<div class="blogphoto"><img src="images/badges/representative.png"/></div><b>Dedicated Representative</b><br/><a href="' . $dedicatedRepresentative['name'] . '">' . $dedicatedRepresentative['name'] . '</a>, who has addressed the House or provided written answers ' . $dedicatedRepresentative['number'] . ' times since ' . date('F Y', strtotime($dedicatedRepresentative['since'])) . '.</p><div style="clear:both;"></div>
</div>

<h3>Social Network Use</h3>
<div class="content">
<p>Number of MPs on Twitter: ' . $numberOfMPsOnTwitter . '</p>
<p>Number of MPs on Facebook: ' . $numberOfMPsOnFacebook . '</p>
<p>Number of MPs on YouTube: ' . $numberOfMPsOnYoutube . '</p>
</div>

<h3>Database</h3>
<div class="content">
<p>Number of known MPs: ' . $numberOfMPs . '</p>
<p>Number of cached items: ' . $numberOfCachedItems . '</p>
<p>Oldest item: ' . $oldestItem . '</p>
<p>Newest item: ' . $newestItem . '</p>
<p>Database size: ' . $dbSize . ' MB</p>
</div>

<h3>Moderation</h3>
<div class="content">
<p>Changes waiting in mod queue: ' . $modQueueSize . '</p>
</div>
';

$query = "TRUNCATE TABLE hubble_statscache";
mysql_query($query);

$query = "INSERT INTO hubble_statscache VALUES ('0', '" . mysql_real_escape_string($html) . "', '" . date('Y-m-d H:i:s') . "')";
mysql_query($query);

echo("<br/><b>The end!</b>");

mysql_close();
  
?>
