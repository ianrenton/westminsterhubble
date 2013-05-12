<?php

require_once('../config.php');

mysql_connect(DB_SERVER,DB_USER,DB_PASS);
@mysql_select_db(DB_NAME) or die( "Unable to select database");

    $handle = fopen("MP_email_addresses.csv", "r");
    while (($data = fgetcsv($handle)) !== FALSE) {
        $query = "SELECT * FROM twfy_mps WHERE (twfy_mps.name = '" . mysql_real_escape_string($data[0]) . "')";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        if ($row == false) {
            echo ("FAILED: " . $data[0] . "  " . $data[1] . "<br/>");
        } else {
            $query = "SELECT * FROM hubble_mps WHERE (hubble_mps.person_id = '" . $row["person_id"] . "')";
            $result = mysql_query($query);
            $row2 = mysql_fetch_assoc($result);
            if ($row2 != false) {
                $query = "UPDATE hubble_mps SET email = '" . $data[1] . "' WHERE hubble_mps.person_id = '" . $row["person_id"] . "' LIMIT 1";
                $result = mysql_query($query);
                if ($result == false) {
                    echo ("FAILED: " . $data[0] . "  " . $data[1] . "<br/>");
                }
            }
        }
    }
    
    echo("Done.");

mysql_close();
  
?>