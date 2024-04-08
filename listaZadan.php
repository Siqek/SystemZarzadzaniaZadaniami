<?php
    session_start();

    include "./functions.php";

    if (!isLogged())
    {
        navigateTo('./');
    }

    if (isset($_POST["zadanieID"]))
    {
        $conn = newConn();

        if (isset($_POST["przypisz"]))
        {
            $sql = "UPDATE `zadania` SET `pracownik` = '" . $_SESSION["login"] . "' WHERE id = " . $_POST["zadanieID"];
            
            mysqli_query($conn, $sql);
        }
        else if (isset($_POST["archiwizuj"]))
        {
            $sql = "UPDATE `zadania` SET `archiwizowane`= NOT `archiwizowane` WHERE id = " . $_POST["zadanieID"];

            mysqli_query($conn, $sql);
        }
        else if (isset($_POST["wypisz"]))
        {
            $sql = "UPDATE `zadania` SET `pracownik` = NULL WHERE id = " . $_POST["zadanieID"];

            mysqli_query($conn, $sql);
        }
        else if (isset($_POST["usun"]))
        {
            $sql = "DELETE FROM `zadania` WHERE id = " . $_POST["zadanieID"];

            mysqli_query($conn, $sql);
        }

        mysqli_close($conn);
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
    <link rel="stylesheet" href="listaZadan.css">
</head>
<body>
    <?php include "./menu.php"; ?>
    <div id="zadania">
        <?php
            $conn = newConn();

            if (isLoggedAs('admin'))
                $sql = "SELECT *, `zadania`.id as id_zadania FROM `zadania` JOIN `statusy` ON `zadania`.status = `statusy`.id ORDER BY `data` DESC";
            else
                $sql = "SELECT *, `zadania`.id as id_zadania FROM `zadania` JOIN `statusy` ON `zadania`.status = `statusy`.id WHERE archiwizowane = false ORDER BY `data` DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0)
            {
                while ($row = mysqli_fetch_assoc($result))
                {
                    echo "<span class='elem'>
                            <div class='zadanie'>
                                <span>
                                <div class='info'>
                                    <h3>" . $row["tytul"] . "</h3>
                                    <p>" . $row["nazwa"] . "</p>
                                </div>
                                <div class='info'>
                                    <p>" . $row["user"] . "</p>
                                    <p>" . $row["data"] . "</p>
                                </div>
                                <p>" . ((!empty($row["pracownik"])) ? $row["pracownik"] : "brak") . "</p>
                                <div id='line'></div>
                                </span>
                                <div class='opis'>
                                    <p>" . str_replace("\n", "<br>", $row["opis"]) . "</p>
                                </div>
                            </div>
                            <div class='tools'>
                                <form action='./listaZadan.php' method='POST'>
                                    <input type='text' value='" . $row["id_zadania"] . "' name='zadanieID' hidden>";
                                if ($row["user"] == $_SESSION["login"] && $row["nazwa"] == 'nierozpoczęte')
                                    echo "<input type='submit' value='Usuń zadanie' name='usun'>"; 

                                if (empty($row["pracownik"]) && (isLoggedAs("pracownik") || isLoggedAs("admin")))
                                    echo "<input type='submit' value='Przypisz się' name='przypisz'>";

                                if ($row["pracownik"] == $_SESSION["login"])
                                    echo "<input type='submit' value='Zrezygnuj' name='wypisz'>";

                                if (isLoggedAs('admin'))
                                    echo "<input type='submit' value='" . (($row['archiwizowane']) ? "Odarchiwizuj" : "Archiwizuj") . "' name='archiwizuj'>";
                                echo "</form>";
                                echo "<form action='./details.php' method='POST'>
                                    <input type='text' value='" . $row["id_zadania"] . "' name='zadanieID' hidden>
                                    <input type='submit' value='szczegóły'>
                                </form>
                            </div>
                        </span>";
                }
            }

            mysqli_close($conn);
        ?>
    </div>
</body>
</html>