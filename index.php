<?php
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
    <a href="event_create.php">Create an event</a>

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
            printf("<th><a href='event.php/?event_id={$event["event_id"]}'>{$event['name']}</a></th>");
            printf("<th>{$event['date']}</th>");
            printf("</tr>");
        }
        echo "</table>";
    }
    ?>
</body>

<?php
include "includes/tail.php";
?>