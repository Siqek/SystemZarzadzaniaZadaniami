<?php
    session_start();

    include "./functions.php";

    if (!isLogged() || (!isset($_POST["zadanieID"]) && !isset($_SESSION["zadanieID"])))
    {
        navigateTo('./');
    }

    #zapisywanie id zadania do SESSION aby uniknac wymagania dodawania go do kazdego formularza
    if (isset($_POST["zadanieID"]))
        $_SESSION["zadanieID"] = $_POST["zadanieID"];

    $currentID = $_SESSION["zadanieID"];

    #usuwanie pracownika z zadania
    if (isset($_POST["usunPrac"]))
    {
        $conn = newConn();

        $sql = "UPDATE `zadania` SET `pracownik` = NULL WHERE id = " . $currentID;

        mysqli_query($conn, $sql);

        mysqli_close($conn);

        unset($_POST["usunPrac"]);
    }

    #przypisywanie pracownika do zadania
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
        unset($_POST["selectPrac"]);
    }

    #aktualizacja statusu zadania
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
        unset($_POST["status"]);
    }

    #aktualizacja opisu zadania
    if (isset($_POST["stop_editing_opis"]))
    {
        unset($_POST["stop_editing_opis"]);
        unset($_POST["editing_opis"]);
        unset($_POST['nowy_opis']);
    }
    else if (isset($_POST['save_opis']))
    {
        $conn = newConn();

        $sql = "UPDATE `zadania` SET `opis` = '" . $_POST["nowy_opis"] . "' WHERE `id` = " . $currentID;

        mysqli_query($conn, $sql);

        mysqli_close($conn);

        unset($_POST["save_opis"]);
        unset($_POST["editing_opis"]);
        unset($_POST['nowy_opis']);
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

    function selectPrac ($name) 
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
            echo 
                #podstawowe info o zadaniu (bez opisu)
                "<span>
                    <span class='info'>
                        <h1 class='margin'>" . $row["tytul"] . "</h1>
                        <form action='details.php' method='POST'>
                            <span class='inRow'>"
                                . (
                                    (isset($_POST["editing_status"]))
                                    ?   # przycisk do zapisania nowego statusu
                                        # przycisk do anulowania edycji
                                        "<input type='submit' value='zapisz' name='save_status'>
                                        <input type='submit' name='stop_editing_status' value='anuluj'>"
                                        . selectStatusy("status")
                                    :   # przycisk do edycji statusu
                                        (
                                            (isLoggedAs('admin') || $row["pracownik"] == $_SESSION["login"]) 
                                            ?   "<input type='submit' value='edytuj' name='editing_status'>" 
                                            :   ''
                                        )
                                        . "<p class='margin'>" . $row["nazwa"] . "</p>"
                                )
                            . "</span>
                        </form>
                    </span>
                    <span class='info'>
                        <p class='margin'>" . $row["user"] . "</p>
                        <p class='margin'>" . $row["data"] . "</p>
                    </span>
                    <span class='info'>"
                    #wyswietlanie przypisanego pracownika do zadania lub
                    #wyswietlanie formularza do przypisania nowego pracownika
                    . (
                        (isset($_POST["przypiszPrac"]))
                        ?   #select z pracownikami do przypisania
                            "<form method='POST' action='details.php'>"
                                . selectPrac("selectPrac")
                                . "<input type='submit' value='przypisz' name='nowyPrac' class='margin'>
                                <input type='submit' value='anuluj' name='cancel' class='margin'>
                            </form>" 
                        : (
                            ($row["pracownik"]) 
                            ?   #przypisany pracownik
                                "<p class='margin'>" . $row["pracownik"] . "</p>" 
                            :   #informacja o braku przypisanego pracownika
                                "<p class='margin'>nie przypisano pracownika</p>" 
                        )
                    )
                    #przyciski do obslugi przypisanego pracownika do zadania (tylko dla admina)
                    . (
                        (isLoggedAs('admin'))
                        ? "<form method='POST' action='./details.php'>" . 
                            (($row["pracownik"]) 
                                ?   #przycisk do usuniecia przypisanego pracownika z zadania
                                    "<input type='submit' name='usunPrac' value='zwolnij' class='margin'>" 
                                :   #przycisk do przypisywania pracownika
                                    #wyswietla gdy nie zostal jeszcze klikniety
                                    (
                                        (!isset($_POST["przypiszPrac"])) 
                                        ? "<input type='submit' name='przypiszPrac' value='przypisz' class='margin'>"
                                        : ''
                                    )
                            ) 
                            . "</form>"
                        : '' 
                    )
                    . "</span>
                    <div class='line'></div>
                </span>"

                #opis zadania
                . "<form method='POST' action='./details.php' id='opisForm'>
                    <div id='opis'>"
                    #edycja opisu / wyswietlenie opisu
                    . (
                        (isset($_POST["editing_opis"])) 
                        ?   "<textarea id='inputOpis' name='nowy_opis' rows='1'
                            onload='auto_resize(this);' onkeypress='auto_resize(this);' onkeyup='auto_resize(this);'>" 
                                . $row["opis"] 
                            . "</textarea>" 
                        :   "<p>" . str_replace("\n", "<br>", $row["opis"]) . "</p>"
                    ) .
                    "</div>
                    <span>"
                    #przyciski do obslugi edycji opisu
                    . (
                        (isset($_POST["editing_opis"])) 
                        ?   #przycisk do zapisu opisu
                            #przycisk do anulowania
                            "<input type='submit' name='save_opis' value='zapisz'>
                            <input type='submit' name='stop_editing_opis' value='anuluj'>"
                        :   #edycja mozliwa gdy zadanie nie zostalo jeszcze rozpoczete
                            #zadanie musi nalezec do zalogowanej osoby aby edutowac
                            (
                                ($row["nazwa"] === 'nierozpoczęte' && $_SESSION["login"] === $row["user"]) 
                                ?   #przycisk do edycji opisu
                                    "<input type='submit' name='editing_opis' value='edutuj'>" 
                                :   ''
                            )
                    ) . 
                    "</span>
                </form>";
        }
    }
?>
            </div>
        </span>
    </div>
</body>
<script>
    function auto_resize (element)
    {
        element.style.height = 'auto';
        element.style.height = (element.scrollHeight)+'px';
    }
</script>
</html>