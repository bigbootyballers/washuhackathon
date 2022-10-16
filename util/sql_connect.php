<?php
/**
 * The code for connecting into the SQL database, can be required by other files.
 */

function get_mysqli() {
    $mysqli = new mysqli("localhost", "trashfree_inst", "trashfree_pass", "trashfree");

    if ($mysqli->connect_errno) {
        echo("Connection Failed: " . $mysqli->connect_error);
        exit();
    }

    return $mysqli;
}