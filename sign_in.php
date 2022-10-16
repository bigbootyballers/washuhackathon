<?php
/**
 * The sign-in / register page.
 */

require_once "util/sql_queries.php";
include "includes/head.php";
?>

<body>
    <?php
    include "includes/header.php";
    ?>

    <main>
        <h1>Sign in</h1>
        <form method="POST">
            <p>
                <label for="username">Username: </label>
                <input type="text" name="username" id="username">
            </p>
            <p>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password">
            </p>

            <p>
                <input type="submit" value="Submit">
            </p>
        </form>
        <br>
        <h1>Register</h1>
        <form method="POST">
            <p>
                <label for="new_username">New username: </label>
                <input type="text" name="new_username" id="new_username">
            </p>
            <p>
                <label for="new_password">New password: </label>
                <input type="password" name="new_password" id="new_password">
            </p>

            <p>
                <input type="submit" value="Submit">
            </p>
        </form>

        <?php
        session_start();
        if (isset($_SESSION['username'])) {
            header("Location: index.php");
            exit();
        }
        if (isset($_POST['username']) && $_POST['password']) {
            if (check_login($_POST['username'], $_POST['password'])) {
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
                header("Location: index.php");
                exit();
            }
            else {
                echo "Wrong username or password";
            }
        }
        if (isset($_POST['new_username']) && $_POST['new_password']) {
            if (check_user_exists($_POST['new_username'])) {
                echo "Username already exists, pick a different one";
            }
            else {
                create_user($_POST['new_username'], $_POST['new_password']);
                echo "Account created, log in with your username and password";
            }
        }
        ?>
    </main>
</body>

<?php
include "includes/tail.php";
?>
