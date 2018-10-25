<?php
    function create_login()
    {
        ?>
        <form method="post"
              action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
        <fieldset>
            <legend> Please enter Oracle username/password: </legend>

            <label for="username"> Username: </label>
            <input type="text" name="username" id="username" />

            <label for="password"> Password: </label>
            <input type="password" name="password"
                   id="password" />

            <div class="submit">
                <input type="submit" value="Log in" />
            </div>
        </fieldset>
        </form>
        <?php
    }
?>


