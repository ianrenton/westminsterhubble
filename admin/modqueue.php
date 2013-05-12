<?php

require_once('../config.php');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

if (((isset($_POST['submit'])) || (isset($_POST['delete']))) && (isset($_POST['modqueue_id'])) && (isset($_POST['person_id'])) && (isset($_POST['field'])) && (isset($_POST['newvalue']))) {
	$modqueue_id = urldecode($_POST['modqueue_id']);
    $person_id = urldecode($_POST['person_id']);
    $type = urldecode($_POST['field']);
    $newValue = urldecode($_POST['newvalue']);
    
	if ($_POST['submit']) {
    	$query = "UPDATE hubble_mps SET " . mysql_real_escape_string($type) . " = '" . mysql_real_escape_string($newValue) . "' WHERE hubble_mps.person_id = '" . mysql_real_escape_string($person_id) . "' LIMIT 1";
	    mysql_query($query);
	}
	$query = "DELETE FROM hubble_modqueue WHERE id=" . mysql_real_escape_string($modqueue_id) . ";";
    mysql_query($query);
}

echo('<h2>Behold the Mod Queue!</h2>');
$query = "SELECT * FROM hubble_modqueue LIMIT 9999";
$result = mysql_query($query);
echo('<table border="0">');
while($row = mysql_fetch_row($result)) {
	$mpquery = "SELECT * FROM twfy_mps WHERE person_id='" . $row[1] . "'";
    $mpresult = mysql_query($mpquery);
	$mprow = mysql_fetch_row($mpresult);
	?>
	<tr><td>
	<form id="modqueueform" name="modqueueform" method="post" action="modqueue.php"></td>
	<td><input type="text" size="3" name="modqueue_id" value="<?php echo($row[0]) ?>"></td>
	<td><input type="text" size="7" name="person_id" value="<?php echo($row[1]) ?>"></td>
	<td><?php echo($mprow[3]) ?></td>
	<td><input type="text" size="15" name="field" value="<?php echo($row[2]) ?>"></td>
	<td><input type="text" size="30" name="newvalue" value="<?php echo($row[3]) ?>"></td>
	<td><input type="submit" name="submit" value="Approve" />
	<input type="submit" name="delete" value="Delete" /></td></tr>
	</form>
	<?php
}
echo("</table>");
echo("The end!");

mysql_close();
  
?>