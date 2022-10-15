<header>
    <nav>
        <!--suppress HtmlUnknownTarget -->
        <a href="index.php"><b>News</b></a>
        <span class="nav-right">
            <?php
                if (isset($_SESSION['username'])) {
                    echo <<<EOF
                    <a href="submit_post.php">Submit post</a> 
                    <a href="profile.php?username={$_SESSION['username']}">Profile</a>
                    <a href="sign_out.php">Sign out</a>
                    EOF;
                } else {
                    /** @noinspection HtmlUnknownTarget */
                    echo <<<EOF
                    <a href="sign_in.php">Sign in/register</a> 
                    EOF;
                }
            ?>
        </span>
    </nav>
</header>
