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
        <p>
            <label for="date">Date: </label>
            <input type="date" id="date" name="date"
                   value="<?php echo date("Y-m-d");?>">
        </p>
        <p>
            <input type="submit" value="Submit">
        </p>
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