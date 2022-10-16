<?php
/**
 * This file allows a user to join an event.
 */

require_once "sql_queries.php";

session_start();

if (!isset($_GET["event_id"])) {
    header("Location:../sign_in.php");
    exit;
}
if (!isset($_SESSION["username"])) {
    header("Location:../sign_in.php");
    exit;
}

join_event($_GET["event_id"], $_SESSION["username"]);

exit();
