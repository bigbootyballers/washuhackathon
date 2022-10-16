<?php
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

</body>

<?php
include "includes/tail.php";
?>