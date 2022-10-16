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

function exists_group(string $group_name) {
    $query = "SELECT * FROM `groups` WHERE group_name=?";
    return count(get_query_result($query, "s", array($group_name))) === 1;
}

function add_to_group($username, $group_name) {
    $query = "INSERT INTO `users_groups` (username, group_name) VALUES (?, ?)";
    execute_query($query, "ss", array($username, $group_name));
}

function create_group($group_name) {
    $query = "INSERT INTO `groups` (group_name) VALUE (?)";
    execute_query($query, "s", array($group_name));
}
