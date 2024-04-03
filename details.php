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
    function selectPrac() 
    {
        $conn = newConn();

        $sql = "SELECT * FROM `users` JOIN `uprawnienia` ON `users`.upr = `uprawnienia`.id WHERE `uprawnienia`.nazwa IN ('admin', 'pracownik')";
        $result = mysqli_query($conn, $sql);

        $select = '';
        if (mysqli_num_rows($result) > 0)
        {
            $select .= "<select name='selectPrac' class='margin'>";
            while ($row = mysqli_fetch_assoc($result))
            {
                $select .= "<option value='" . $row["login"] . "'>" . $row["login"] . "</option>";
            }
            $select .= "</select>";
        }

        mysqli_close($conn);

        return $select;
    }
?>
<body>
    <?php include "./menu.php"; ?>
    <div id='content'>
        <a href="./listaZadan.php">powrót</a>
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
                                    <p class='margin'>" . $row["nazwa"] . "</p>
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
                                                . selectPrac()
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
                            <div id='opis'>
                                <p>" . $row["opis"] . "</p>
                            </div>";
                        }
                        #form do edycji jeżeli to ty utworzyleś to zadanie
                        #zmiana statusu jeżeli ty jesteś przypisany do zadania
                    }
                ?>
            </div>
        </span>
    </div>
</body>
</html>