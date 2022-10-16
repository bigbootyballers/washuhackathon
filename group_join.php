<?php

require_once "util/sql_queries.php";

function main() {
    session_start();
    if (isset($_SESSION["username"])) {
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

    <h1>Group</h1>
    <h2>Join a Group</h2>
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
            printf("Joined group %s\n!", $_POST["group_name"]);
        } else {
            echo "That group does not exist.";
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
            echo "A group with that name already exists!";
        } else {
            create_group($_POST["new_group_name"]);
            add_to_group($_SESSION["username"], $_POST["new_group_name"]);
            printf("Created and joined group %s\n!", $_POST["new_group_name"]);
        }
    }
    ?>

</body>

<?php
include "includes/tail.php";
?>