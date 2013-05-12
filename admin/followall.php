<?php

require_once('../config.php');
require_once('twitteroauth/twitteroauth.php');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

// Auth with Twitter
$access_token_string = 'a:4:{s:11:"oauth_token";s:50:"165844462-hWgx71v7yx1KWmpX9eG98Y6NzMAJ2ZAgwPyrZLF7";s:18:"oauth_token_secret";s:40:"Qh9ineInrcJ3AOoneq8cAzwjEpDLVzTBBqTRoQIE";s:7:"user_id";s:9:"165844462";s:11:"screen_name";s:14:"WestminsterHub";}';
$access_token = unserialize($access_token_string);
$to = new TwitterOAuth("gaurdyVhWxIDSIZGLJHeAA", "UokeUSd76JdfiGzONSyocSW2JI8Zh2fUfKLEsHQKT8", $access_token['oauth_token'], $access_token['oauth_token_secret']);

echo('<h2>Follow everybody!</h2>');

$query = "SELECT twitter FROM hubble_mps WHERE twitter != ''";
$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
    $response = $to->post('friendships/create', array('screen_name' => mysql_real_escape_string($row['twitter']), 'follow' => 'true'));
    echo($row['twitter'] . "<br/>");
}

echo("The end!");

mysql_close();
  
?>
