<?php
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
            <input type="text" id="name" name="name">
        </div>

        <div>
            <label for="date">Date: </label>
            <input type="date" id="date" name="date"
                   value="<?php echo date("Y-m-d");?>">
        </div>

        <fieldset>
            <legend>Private/Public:</legend>
            <div>
                <input type="radio" name="private/public" id="private" value="private" checked>
                <label for="private">Private</label>
            </div>

            <div>
                <input type="radio" name="private/public" id="public" value="public" checked>
                <label for="public">Public</label>
            </div>
        </fieldset>

        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
    <h2>
        Upcoming events
    </h2>
    <p>
        ...
    </p>
</body>

<?php
include "includes/tail.php";
?>