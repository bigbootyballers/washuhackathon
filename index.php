﻿<?php
require_once "util/sql_queries.php";

function main() {
    session_start();
    # https://stackoverflow.com/a/15088537
    if (!isset($_SESSION['username'])) {
        header("Location:sign_in.php");
        exit;
    }
}

main();

include "includes/head.php";
?>

<body>
    <?php
    include "includes/header.php";
    ?>
   
    <h1>
        Home
    </h1>
    <p>
        <?php
        printf("Signed in as %s", htmlspecialchars($_SESSION['username']));
        ?>
        (<a href="sign_out.php">sign out</a>)
    </p>

    <h2>
        Create an event
    </h2>
    <form method="POST">
        <div>
            <label for="name">Event name: </label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="date">Date: </label>
            <input type="date" id="date" name="date"
                   value="<?php echo date("Y-m-d");?>" required>
        </div>

        <fieldset>
            <legend>Private/public:</legend>
            <div>
                <input type="radio" name="private/public" id="private" value="private" checked required>
                <label for="private">Private</label>
            </div>

            <div>
                <input type="radio" name="private/public" id="public" value="public" required>
                <label for="public">Public</label>
            </div>
        </fieldset>

        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
    <?php
    if (isset($_POST["name"])) {
        create_event($_POST["name"], $_POST["date"], $_POST["private/public"] == "private");
        join_last_event($_SESSION["username"]);
        printf("<p>Created and joined event \"%s\"!</p>", $_POST["name"]);
    }
    ?>
    <h2>
        Upcoming events
    </h2>
    <?php
    $events = get_user_events($_SESSION["username"]);
    if (count($events) === 0) {
        printf("<p>You don't have any upcoming events!</p>");
    } else {
        echo<<<EOF
        <table>
            <tr>
                <th>Event name</th>
                <th>Date</th>
            </tr>
        EOF;
        foreach ($events as $event) {
            printf("<tr>");
            printf("<th>${$event["name"]}</th>");
            printf("<th>${$event["date"]}</th>");
            printf("</tr>");
        }
        echo "</table>";
    }
    ?>
</body>

<?php
include "includes/tail.php";
?>