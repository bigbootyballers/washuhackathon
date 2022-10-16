<?php
/**
 * Shared functions for SQL queries.
 */

require_once "sql_connect.php";

$mysqli = get_mysqli();

function check_user_exists(string $username) {
    /**
     * Checks to see if that username exists
     */
    global $mysqli;

    $statement = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE username=?");
    $statement->bind_param('s', $username);
    $statement->execute();
    $statement->bind_result($count);
    $statement->fetch();
    $statement->close();

    if ($count == 1) {
        return true;
    }
    else {
        return false;
    }
}

function create_user(string $username, string $password) {
    /**
     * Creates new user
     */
    global $mysqli;

    $statement = $mysqli->prepare("insert into users (username, hashed_password) values (?, ?)");
    if(!$statement){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $statement->bind_param('ss', $username, $password_hash);
    $statement->execute();
    $statement->close();
}

function check_login(string $username, string $password) {
    /**
     * Checks if login info is valid
     */
    global $mysqli;

    $statement = $mysqli->prepare("SELECT COUNT(*), hashed_password FROM users WHERE username=?");
    $statement->bind_param('s', $username);
    $statement->execute();
    $statement->bind_result($count, $hash);
    $statement->fetch();
    $statement->close();

    return ($count == 1 && password_verify($password, $hash));
}

function get_query_result(string $query, string $types, array $params) {
    /**
     * Helper function for getting a result from a query
     */
    global $mysqli;

    $statement = $mysqli->prepare($query);
    if(!$statement){
        printf("Query prep failed: %s\n", $mysqli->error);
        exit;
    }
    $statement->bind_param($types, ...$params);
    $statement->execute();

    $result = $statement->get_result();
    $statement->close();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function execute_query(string $query, string $types, array $params) {
    /**
     * Helper function for executing a query
     */
    global $mysqli;

    $statement = $mysqli->prepare($query);
    if(!$statement){
        printf("Query prep failed: %s\n", $mysqli->error);
        exit;
    }
    $statement->bind_param($types, ...$params);
    $statement->execute();
    $statement->close();
}

function join_event($event_id, $username) {
    /**
     * Haves a user join an event
     */
    $query = "INSERT INTO `events_users` (event_id, username) VALUES (?, ?)";
    execute_query($query, "is", array($event_id, $username));
}

function create_event($name, $date, $is_private) {
    /**
     * Creates an event with automatic event_id and no route
     */
    $query = "INSERT INTO `events` (event_id, name, date, is_private, route) VALUES (NULL, ?, ?, ?, NULL)";
    execute_query($query, "ssi", array($name, $date, $is_private));
}

function add_route_to_event($event_id, $route) {
    /**
     * Adds a route to an event
     */
    $query = "UPDATE `events` SET route = ? WHERE event_id = ?";
    execute_query($query, "si", array($route, $event_id));
}
