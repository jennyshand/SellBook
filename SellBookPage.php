<?php
    session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
   Jenny Shand
   4/13/18
   URL: http://nrs-projects.humboldt.edu/~jes1098/328hw11/SellBookPage.php
-->

<head>
    <title> Turtle Books </title>
    <meta charset="utf-8" />

    <?php
        require_once("create_login2.php");
        require_once("create_dropdown2.php");
        require_once("get_title_info2.php");
        require_once("destroy_and_exit.php");
        require_once("hsu_conn_sess.php");
        require_once("sell_book.php");
    ?>

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />


    <link href="need-order.css"
          type="text/css" rel="stylesheet" />

    <script src="calcTotal.js" type="text/javascript" async="async">
    </script>
</head>

<body>
    <h1> Turtle Books </h1>

    <h2> Jenny Shand </h2>

    <h3> CS 328 </h3>

    <?php
    if (! array_key_exists('next-stage', $_SESSION))
    {
        create_login();
        $_SESSION['next-stage'] = "dropdown";
    }
    elseif ($_SESSION['next-stage'] == "dropdown")
    {
        create_dropdown();
        $_SESSION['next-stage'] = "titleinfo";
    }
    elseif ($_SESSION['next-stage'] == "titleinfo")
    {
        get_title_info();
        $_SESSION['next-stage'] = "purchase";
    }
    elseif ($_SESSION['next-stage'] == "purchase" &&
            array_key_exists("next", $_POST))
    {
        if($_POST['next'] == "purchase")
        {   
            sell_book();
            $_SESSION['next-stage'] = "is_user_done";
        }
        else
        {
            session_destroy();
            session_regenerate_id(TRUE);
            session_start();

            create_login();
            $_SESSION['next-stage'] = "dropdown";
        }
    }
    elseif ($_SESSION['next-stage'] == "is_user_done")
    {
        if($_POST['finish'] == "goback")
        {       
            create_dropdown();
            $_SESSION['next-stage'] = "titleinfo";
        }
        else
        {
            session_destroy();
            session_regenerate_id(TRUE);
            session_start();

            create_login();
            $_SESSION['next-stage'] = "dropdown";
        }
    }

    // I hope to never reach here...!

    else
    {
        ?>
        <p> <strong> YIKES! should NOT have been able to reach
            here! </strong> </p>
        <?php

        session_destroy();
        session_regenerate_id(TRUE);
        session_start();

        create_login();
        $_SESSION['next-stage'] = "dropdown";
    }
    require_once("328footer.html");
?>

</body>
</html>

