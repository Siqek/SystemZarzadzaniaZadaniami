<?php
    session_start();

    include "./functions.php";

    if (!isLogged() || (!isset($_POST["zadanieID"]) && !isset($_SESSION["zadanieID"])))
    {
        navigateTo('./');
    }

    if (isset($_POST["zadanieID"]))
        $_SESSION["zadanieID"] = $_POST["zadanieID"];

    $currentID = $_SESSION["zadanieID"];

    if (isset($_POST["usunPrac"]))
    {
        $conn = newConn();

        $sql = "UPDATE `zadania` SET `pracownik` = NULL WHERE id = " . $currentID;

        mysqli_query($conn, $sql);

        mysqli_close($conn);

        unset($_POST["usunPrac"]);
    }

    if (isset($_POST["cancel"]))
    {
        unset($_POST["cancel"]);
        unset($_POST["przypiszPrac"]);
    }
    else if (isset($_POST["nowyPrac"]) && isset($_POST["selectPrac"]))
    {
        $conn = newConn();

        $sql = "UPDATE `zadania` SET `pracownik` = '" . $_POST["selectPrac"] . "' WHERE id = " . $currentID;

        mysqli_query($conn, $sql);

        mysqli_close($conn);

        unset($_POST["przypiszPrac"]);
        unset($_POST["nowyPrac"]);
    }

    if (isset($_POST["stop_editing_status"]))
    {
        unset($_POST["stop_editing_status"]);
        unset($_POST["editing_status"]);
    }
    else if (isset($_POST["save_status"]) && isset($_POST["status"]))
    {
        $conn = newConn();

        $sql = "UPDATE `zadania` SET `status` = '" . $_POST["status"] . "' WHERE id = " . $currentID;

        mysqli_query($conn, $sql);

        mysqli_close($conn);

        unset($_POST["editing_status"]);
        unset($_POST["save_status"]);
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
    <link rel="stylesheet" href="details.css">
</head>
<?php
    function select ($name, $sql, $value_row, $label_row)
    {
        $conn = newConn();
        $result = mysqli_query($conn, $sql);

        $select = '';
        if (mysqli_num_rows($result) > 0)
        {
            $select .= "<select name='$name' class='margin'>";
            while ($row = mysqli_fetch_assoc($result))
            {
                $select .= "<option value='" . $row[$value_row] . "'>" . $row[$label_row] . "</option>";
            }
            $select .= "</select>";
        }

        mysqli_close($conn);

        return $select;
    }

    function selectPrac($name) 
    {
        $sql = "SELECT * FROM `users` 
            JOIN `uprawnienia` ON `users`.upr = `uprawnienia`.id 
            WHERE `uprawnienia`.nazwa IN ('admin', 'pracownik')";

        return select($name, $sql, "login", "login");;
    }

    function selectStatusy ($name)
    {
        $sql = "SELECT * FROM `statusy`";

        return select($name, $sql, "id", "nazwa");
    }
?>
<body>
    <?php include "./menu.php"; ?>
    <div id='content'>
        <a href="./listaZadan.php" class='back'>powrót</a>
        <span class='center'>
            <div id='zadanie'>
                <?php
                    $conn = newConn();

                    $sql = "SELECT * FROM `zadania` JOIN `statusy` ON `zadania`.status = `statusy`.id WHERE `zadania`.id =" . $currentID;
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0)
                    {
                        if ($row = mysqli_fetch_assoc($result))
                        {
                            echo "<span>
                                <span class='info'>
                                    <h1 class='margin'>" . $row["tytul"] . "</h1>
                                    <form action='details.php' method='POST'>
                                        <span class='inRow'>"
                                            . ((isset($_POST["editing_status"]))
                                                ? 
                                                    "<input type='submit' value='zapisz' name='save_status'>
                                                    <input type='submit' name='stop_editing_status' value='anuluj'>"
                                                    . selectStatusy("status")
                                                : 
                                                    ((isLoggedAs('admin') || $row["pracownik"] == $_SESSION["login"]) ? "<input type='submit' value='edytuj' name='editing_status'>" : '')
                                                    . "<p class='margin'>" . $row["nazwa"] . "</p>")
                                        . "</span>
                                    </form>
                                </span>
                                <span class='info'>
                                    <p class='margin'>" . $row["user"] . "</p>
                                    <p class='margin'>" . $row["data"] . "</p>
                                </span>
                                <span class='info'>" . 
                                    (($row["pracownik"]) 
                                    ? "<p class='margin'>" . $row["pracownik"] . "</p>"
                                    : ((isset($_POST["przypiszPrac"]))
                                        ? "<form method='POST' action='details.php'>"
                                                . selectPrac("selectPrac")
                                                . "<input type='submit' value='przypisz' name='nowyPrac' class='margin'>
                                                <input type='submit' value='anuluj' name='cancel' class='margin'>
                                            </form>" 
                                        : "<p class='margin'>nie przypisano pracownika</p>"));
                                if (isLoggedAs('admin'))
                                {
                                    echo "<form method='POST' action='./details.php'>";
                                    if ($row["pracownik"])
                                        echo "<input type='submit' name='usunPrac' value='zwolnij' class='margin'>";
                                    else if (!isset($_POST["przypiszPrac"]))
                                        echo "<input type='submit' name='przypiszPrac' value='przypisz' class='margin'>";
                                    echo "</form>";
                                }
                                echo "</span>
                                <div class='line'></div>
                            </span>
                            <form method='POST' action='./details.php' id='opisForm'>
                                <div id='opis'>
                                    <p>" . $row["opis"] . "</p>
                                </div>
                                <span>
                                    <input type='submit' name='editing_opis' value='edutuj'>
                                </span>
                            </form>";
                        }
                        #form do edycji jeżeli to ty utworzyleś to zadanie
                    }
                ?>
            </div>
        </span>
    </div>
</body>
</html>