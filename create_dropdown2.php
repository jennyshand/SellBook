<?php
    function create_dropdown()
    {
        if (array_key_exists("username", $_POST) )
        {
            $username = strip_tags($_POST['username']);

            $password = $_POST['password'];

            $_SESSION['username'] = $username;

            $_SESSION['password'] = $password;
         }
         elseif (array_key_exists("username", $_SESSION) )
         {

            $username = $_SESSION['username'];

            $password = $_SESSION['password'];
         }
         else
         {
                ?>
                <a href="http://nrs-projects.humboldt.edu/~jes1098/328hw11/SellBookPage.php">
                 Need a valid username and password! </a>

                <hr />

        </body>
        </html>

                <?php
                session_destroy();
                exit;
         }


            $db_conn_str =
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                       (HOST = cedar.humboldt.edu)
                                       (PORT = 1521))
                            (CONNECT_DATA = (SID = STUDENT)))";


        // let's try to connect and log into Oracle using this

            $conn = oci_connect($username, $password, $db_conn_str);

        // exiting if connection/log in failed

            if (! $conn)
            {
                ?>
                <p> Could not log into Oracle, sorry </p>
    </body>
    </html>

                <?php
                session_destroy();
                exit;
            }

            $password = NULL;

            $title_query_str = 'select isbn, title_name
                           from title';
            $title_query_stmt = oci_parse($conn, $title_query_str);

            oci_execute($title_query_stmt, OCI_DEFAULT);
            ?>
            <form method="post"
                  action="<?= htmlentities($_SERVER['PHP_SELF'],
                                   ENT_QUOTES) ?>">
                <fieldset>
                    <legend> Select desired ISBN </legend>
                    <select name="isbn" required="required">
                        <option value=""> Select ISBN </option>
                    <?php
                    while (oci_fetch($title_query_stmt))
                    {
                        $curr_isbn = oci_result($title_query_stmt, 'ISBN');
                        $curr_title_name = oci_result($title_query_stmt, 'TITLE_NAME');
                        ?>
                        <option id="title" value="<?= $curr_isbn ?>" >
                            <?= $curr_title_name ?> -  <?= $curr_isbn ?> </option>
                        <?php
                    }
                    ?>
                    </select>
                    <hr />
                <label> Enter a quantity:
                    <input required="required" type="number" name="quantity" />
                </label> <br />     

                <input type="submit" value="submit choice" />
                </fieldset>
            </form>

            <?php

             // FREE your statement, CLOSE your connection
            oci_free_statement($title_query_stmt);
            oci_close($conn);
    }
?>


