<?php
    session_start();

    include "./functions.php";

    if (!isLogged()
        || !isLoggedAs('admin'))
    {
        navigateTo('./');
    }

    if (isset($_POST["cancel"]))
    {
        unset($_POST["select"]);
        unset($_POST[$_POST["login"]]);
        unset($_POST["login"]);
    }
    else if (isset($_POST["select"]))
    {
        $conn = newConn();

        $sql = "UPDATE `users` SET `upr`='" . $_POST["select"] . "' WHERE login = '" . $_POST["login"] . "'";

        mysqli_query($conn, $sql);

        mysqli_close($conn);

        unset($_POST["select"]);
        unset($_POST[$_POST["login"]]);
        unset($_POST["login"]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SZZ</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="users.css">
</head>
<?php
    function selectForm() 
    {
        $conn = newConn();

        $sql = "SELECT * FROM `uprawnienia`";
        $result = mysqli_query($conn, $sql);

        $select = '';
        if (mysqli_num_rows($result) > 0)
        {
            $select .= "<select name='select'>";
            while ($row = mysqli_fetch_assoc($result))
            {
                $select .= "<option value='" . $row["id"] . "'>" . $row["nazwa"] . "</option>";
            }
            $select .= "</select>";
        }

        mysqli_close($conn);

        return $select;
    }
?>
<body>
    <?php include "./menu.php"; ?>
    <div id='users'>
        <table>
            <tr>
                <th>Login</th>
                <th>UserName</th>
                <th>Upr</th>
                <th hidden></th>
            </tr>
            <form method="POST" action="./users.php">
            <?php
                $conn = newConn();

                $sql = "SELECT * FROM `users` JOIN `uprawnienia` ON `uprawnienia`.id = `users`.upr";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0)
                {
                    while ($row = mysqli_fetch_assoc($result))
                    {
                        if (isset($_POST[$row["login"]]))
                            echo "<input type='text' name='login' value='" . $row["login"] . "' hidden>";

                        echo
                        "<tr>
                            <td>" . $row["login"] . "</td>
                            <td>" . $row["username"] . "</td>
                            <td>" . (isset($_POST[$row["login"]]) ? selectForm() : $row["nazwa"]) . "</td>
                            <td>
                                " . (isset($_POST[$row["login"]]) ? "<input type='submit' name='cancel' value='ANULUJ'>" : "") . "
                                <input type='submit' name='" . $row["login"] . "' value='" . (isset($_POST[$row["login"]]) ? "ZAPISZ" : "EDYTUJ") ."'>
                            </td>
                        </tr>";
                    }
                }
            ?>
            </form>
        </table>
    </div>
</body>
</html>