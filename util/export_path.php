<?php
/**
 * This file allows a user to export a path.
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

if (!isset($_POST["route"])) {
    header("Location:../sign_in.php");
    exit;
}

add_route_to_event($_GET["event_id"], $_POST["route"]);


header("Location:../event.php?event_id={$_GET["event_id"]}");
exit();
