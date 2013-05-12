<h2>Super Admin Fun-time Menu</h2>
<ul><li><a href="modqueue.php">Mod Queue</a><br/></li>
<li><a href="pullfromemails.php">Pull data from E-mails CSV</a> (won't do anything unless given a CSV)</li>
<li><a href="pullfromtwfy.php">Pull data from They Work for You</a> (only run from ssh, back up DB first please!)</li>
<li><a href="pullfromtweetminster.php">Pull data from Tweetminster</a> (back up DB first please!)</li>
<li><a href="pullfromtwikipedia.php">Pull Wikipedia links</a> (won't overwrite)</li>
<li><a href="followall.php">Get @WestminsterHub to follow everyone</a><br/></li>
<li><a href="../cron.php">Manually run cron</a></li>
<li><form id="modqueueform" name="modqueueform" method="post" action="../cron.php">
	Manually run cron for person_id: <input type="text" size="7" name="person_id" value="">
	<input type="submit" name="submit" value="Run" /></form></li>
<li><a href="../statscron.php">Manually run stats cron</a></li>
<li><a href="../blogscron.php">Manually run blogs cron</a><br/></li>
<li><a href="../generatemapxml.php">Regenerate Constituency Geography Map</a></li>
<li><a href="../generatesitemap.php">Regenerate Sitemap</a></li></ul>
