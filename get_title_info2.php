<?php
    function get_title_info()
    {
        if(! array_key_exists("isbn", $_POST))
        {
            destroy_and_exit("must select an isbn!");
        }

        $username = $_SESSION["username"];
        $password = $_SESSION["password"];

        $conn = hsu_conn_sess($username, $password);

        $isbn = htmlspecialchars(strip_tags($_POST["isbn"]));
        $quantity = htmlspecialchars(strip_tags($_POST["quantity"]));

        $_SESSION["isbn"] = $isbn;
        $_SESSION["quantity"] = $quantity;

        $title_str = "select pub_name, title_name, author, title_price
                      from publisher p, title t
                      where p.pub_id = t.pub_id
                         and isbn = :isbn";
        $title_stmt = oci_parse($conn, $title_str);

        oci_bind_by_name($title_stmt, ":isbn", $isbn);
        oci_execute($title_stmt);

        oci_fetch($title_stmt);
        $chosen_pub = oci_result($title_stmt, "PUB_NAME");
        $chosen_title = oci_result($title_stmt, "TITLE_NAME");
        $chosen_author = oci_result($title_stmt, "AUTHOR");
        $chosen_price = oci_result($title_stmt, "TITLE_PRICE");
        oci_free_statement($title_stmt);
        oci_close($conn);

        $subtotal = $chosen_price * $quantity;
        $tax = $subtotal * .0775;
        ?>

        <h2> Information for ISBN: <?= $isbn ?> </h2>
        <ul>
            <li> Publisher name: <?= $chosen_pub ?> </li>
            <li> Title: <?= $chosen_title ?> </li>
            <li> Author: <?= $chosen_author ?> </li>
            <li> Price: <div id="price"> <?= $chosen_price ?> </div> </li>
            <li> Entered desired quantity: <div id="quant"> <?= $quantity ?>
                 </div> </li>
        </ul>

        <hr />

        <h3> Subtotal for sale: <div id="sub"> </div> </h3>
        <h3> Tax for sale: <div id="tax"> </div> </h3>
        <h3> Sale total: <div id="total"> </div> </h3>

        <hr />

        <p>
            <button id="calcTotal">
                Calculate Total </button> <br />
        </p>

            <p id="result"> </p>

        <hr />

        <form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"" method="post">
             Would you like to complete the purchase?
             <button name="next" type="submit" value="purchase"> Purchase </button>
             <button name="next" type="submit" value="cancel"> Cancel </button>
        </form>
        <?php
    }
?>

