<?php
/**
 * Shared functions for SQL queries.
 */

require_once "sql_connect.php";

$mysqli = get_mysqli();

/**
 * Helper function for getting a result from a query
 */
function get_query_result(string $query, string $types, array $params) {
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

/**
 * Helper function for executing a query
 */
function execute_query(string $query, string $types, array $params) {
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

/**
 * Checks to see if that username exists
 */
function exists_user(string $username) {
    $query = "SELECT * FROM `users` WHERE username=?";
    return count(get_query_result($query, "s", array($username))) === 1;
}

/**
 * Creates new user
 */
function create_user(string $username, string $password) {
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

/**
 * Checks if login info is valid
 */
function check_login(string $username, string $password) {
    global $mysqli;

    $statement = $mysqli->prepare("SELECT COUNT(*), hashed_password FROM users WHERE username=?");
    $statement->bind_param('s', $username);
    $statement->execute();
    $statement->bind_result($count, $hash);
    $statement->fetch();
    $statement->close();

    return ($count == 1 && password_verify($password, $hash));
}

/**
 * Has a user join an event
 */
function join_event($event_id, $username) {
    $query = "INSERT INTO `events_users` (event_id, username) VALUES (?, ?)";
    execute_query($query, "is", array($event_id, $username));
}

/**
 * Has a user join the last created event
 */
function join_last_event($username) {
    global $mysqli;
    join_event($mysqli->insert_id, $username);
}

/**
 * Creates an event with automatic event_id and no route
 */
function create_event($name, $date, $is_private) {
    $query = "INSERT INTO `events` (event_id, name, date, is_private, route) VALUES (NULL, ?, ?, ?, NULL)";
    execute_query($query, "ssi", array($name, $date, $is_private));
}

/**
 * Adds a route to an event
 */
function add_route_to_event($event_id, $route) {
    $query = "UPDATE `events` SET route = ? WHERE event_id = ?";
    execute_query($query, "si", array($route, $event_id));
}

/**
 * Get an array of a users' events
 */
function get_user_events($username) {
    $query = "SELECT events.* FROM events JOIN events_users ON events_users.event_id = events.event_id WHERE username = ?";
    return get_query_result($query, "s", array($username));
}

/**
 * Get a single event from its id
 */
function get_event($event_id) {
    $query = "SELECT * FROM events WHERE event_id = ?";
    return get_query_result($query, "i", array($event_id))[0];
}
