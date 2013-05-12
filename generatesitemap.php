<?php

require_once('config.php');

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
  <loc>http://westminsterhubble.com/</loc>
  <changefreq>always</changefreq>
  <priority>1.00</priority>
</url>
<url>
  <loc>http://westminsterhubble.com/about</loc>
  <changefreq>monthly</changefreq>
  <priority>0.80</priority>
</url>
<url>
  <loc>http://westminsterhubble.com/blog</loc>
  <changefreq>daily</changefreq>
  <priority>0.80</priority>
</url>
<url>
  <loc>http://westminsterhubble.com/contact</loc>
  <changefreq>monthly</changefreq>
  <priority>0.80</priority>
</url>
<url>
  <loc>http://westminsterhubble.com/statistics</loc>
  <changefreq>always</changefreq>
  <priority>0.80</priority>
</url>
';

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

$query = "SELECT * FROM twfy_mps WHERE 1 ORDER BY name;";
$result = mysql_query($query);

while ($mp = mysql_fetch_assoc($result)) {
	$xml .= "<url>\n";
	$xml .= "  <loc>http://westminsterhubble.com/" . str_replace(" ", "_", htmlspecialchars($mp["name"])) . "</loc>\n";
	$xml .= "  <changefreq>hourly</changefreq>\n";
	$xml .= "  <priority>0.60</priority>\n";
	$xml .= "</url>\n";
}
$xml .= "</urlset>";

$file = fopen('sitemap.xml', 'w');
fwrite($file, $xml);
fclose($file);

echo("Sitemap generated.");

mysql_close();

?>
