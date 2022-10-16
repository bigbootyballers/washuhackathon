<?php

require_once "util/sql_queries.php";

function main() {
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: index.php");
        exit();
    }
}

main();

include "includes/head.php";
?>

<body>
    <?php
    include "includes/header.php";
    ?>

    <h1>Join / create a group</h1>
    <h2>Join a group</h2>
    <form method="POST">
        <p>
            <label for="group_name">Group name: </label>
            <input type="text" name="group_name" id="group_name">
        </p>
        <p>
            <input type="submit" value="Submit">
        </p>
    </form>
    <?php
    if (isset($_POST["group_name"])) {
        if (exists_group($_POST["group_name"])) {
            add_to_group($_SESSION["username"], $_POST["group_name"]);
            printf("<p>Joined group \"%s\"</p>!", $_POST["group_name"]);
        } else {
            printf("<p>Group \"%s\"does not exist.</p>", $_POST["group_name"]);
        }
    }
    ?>

    <h2>Or, create a group:</h2>
    <form method="POST">
        <p>
            <label for="new_group_name">New group name: </label>
            <input type="text" name="new_group_name" id="new_group_name">
        </p>
        <p>
            <input type="submit" value="Submit">
        </p>
    </form>
    <?php
    if (isset($_POST["new_group_name"])) {
        if (exists_group($_POST["new_group_name"])) {
            printf("<p>A group with the name \"%s\" already exists.</p>", $_POST["new_group_name"]);
        } else {
            create_group($_POST["new_group_name"]);
            add_to_group($_SESSION["username"], $_POST["new_group_name"]);
            printf("<p>Created and joined group \"%s\"!</p>", $_POST["new_group_name"]);
        }
    }
    ?>

</body>

<?php
include "includes/tail.php";
?>