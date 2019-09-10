<!-- TODO: includes logo and everything before nav bar and content (top rectangle on design sketches) -->
<header>
<?php
        function makeNav ($pageArr){
          $current_file = basename($_SERVER['PHP_SELF']);
          foreach ($pageArr as $page){
            if ($page[0] == $current_file){
              echo("<class = active><a href=\"" . $page[0] . "\">" . $page[1] . "</a>");
            }
            else
              echo("<a href=\"" . $page[0] . "\">" . $page[1] . "</a>");
          }
        }
    ?>

    <div id = "title">

        <div id ="logo">
            <!-- Source: (original work) Anthony Sheehi -->
            <img src ="images/logo.png" alt="logo" width="480">
            <!-- <h1>CornelleScope Logo</h1>-->
        </div>
        <div id = "info">
            <h2 style="font-size: 250%;">"Any place, any study."</h2>
        </div>
        <?php if (!is_user_logged_in()) { ?>
        <div id = "login">
            <form id="loginForm" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
            <ul>
                <li>
                    <label for="username">Username:</label>
                    <input id="username" type="text" name="username" />
                </li>
                <li>
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" />
                </li>
                <li>
                    <button name="login" type="submit">Sign In</button>
                </li>
            </ul>
            </form>
        </div>
        <?php } else { ?>
        <div id = "logout">
        <?php
        // Log Out link
        //if ( is_user_logged_in() ) {
        // Add a logout query string parameter
            $logout_url = htmlspecialchars( $_SERVER['PHP_SELF'] ) . '?' . http_build_query( array( 'logout' => '' ) );

            echo '<li id="nav-last"><a href="' . $logout_url . '">Sign Out ' . htmlspecialchars($current_user['username']) . '</a></li>';
        }
        ?>
        </div>
    </div>
</header>
<div class="sidenav">
        <?php
            $pages = [array("index.php", "Home"), array("gallery.php", "Gallery"), array("about.php", "About")];
            makeNav($pages);
        ?>
</div>
