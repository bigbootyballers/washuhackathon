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
