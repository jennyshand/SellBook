<?php
function sell_book()
{
     if(! array_key_exists("isbn", $_SESSION))
        {
            destroy_and_exit("must select an isbn!");
        }

        $username = $_SESSION["username"];
        $password = $_SESSION["password"];

        $conn = hsu_conn_sess($username, $password);

        $isbn = $_SESSION["isbn"];
        $quantity = $_SESSION["quantity"];

        $sell_book_call = 'begin :result := sell_book(:new_isbn,
                                         :new_qty); end;';
        
        $sell_book_stmt = oci_parse($conn, $sell_book_call);

        oci_bind_by_name($sell_book_stmt, ":new_isbn",
                         $isbn);
        oci_bind_by_name($sell_book_stmt, ":new_qty",
                         $quantity);
        oci_bind_by_name($sell_book_stmt, ":result", 
                         $result, 50);

        oci_execute($sell_book_stmt, OCI_DEFAULT);
     
        oci_free_statement($sell_book_stmt);

        $title_str = "select  title_name
                      from title 
                      where isbn = :isbn";
        $title_stmt = oci_parse($conn, $title_str);

        oci_bind_by_name($title_stmt, ":isbn", $isbn);
        oci_execute($title_stmt);
        oci_commit($conn);        
        oci_fetch($title_stmt);
        $purchased_title = oci_result($title_stmt, "TITLE_NAME");
        oci_free_statement($title_stmt);
        
        oci_close($conn);
        ?>

        <p>
            <div> You have purchased <strong>
            <?= $quantity ?> </strong> copies of
            <strong> <?= $purchased_title ?> </strong> </div> </p>

        <hr />

    <form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"" method="post">
         Would you like to make another order?
         <button name="finish" type="submit" value="goback"> Make another order </button>
         <button name="finish" type="submit" value="done"> I'm done </button>
    </form>
    <?php
}
?>
