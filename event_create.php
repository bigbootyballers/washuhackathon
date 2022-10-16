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

        <main>
            <h1>
                Create an event
            </h1>

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
        </main>
    </body>

<?php
include "includes/tail.php";
?>