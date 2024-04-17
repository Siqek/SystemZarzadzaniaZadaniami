<?php
    session_start();

    include "./functions.php";
    include "./popup.php";

    if (!isLogged())
    {
        navigateTo('./');
    }

    if (isset($_POST["title"], $_POST["opis"])
        && !empty($_POST["title"])
        && !empty($_POST["opis"]))
    {
        $title  = $_POST["title"];
        $opis   = $_POST["opis"];
        $user   = $_SESSION["login"];

        $conn = newConn();

        $sql = "INSERT INTO `zadania`(`tytul`, `opis`, `user`, `data`)
            VALUES ('$title', '$opis', '$user', CURRENT_DATE)";

        if (mysqli_query($conn, $sql))
        {
            setPopupVars("Sukces!", "Dodano nowe zadanie.");
        }
        else
        {
            setPopupVars("Błąd!", "Nie można utworzyć zadania");
        }

        mysqli_close($conn);

        unset($_POST["title"]);
        unset($_POST["opis"]);
    }
    else if (isset($_POST["form"]))
    {
        unset($_POST["form"]);
        setPopupVars("", "Podaj więcej informacji aby utworzyć zadanie.");
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
    <link rel="stylesheet" href="popup.css">
    <link rel="stylesheet" href="zadanieForm.css">
</head>
<body>
    <?php include './menu.php'; ?>
    <form action="./zadanieForm.php" method="POST">
        <h3>Dodaj nowe zadanie: </h3>
        <input id='title' type="text" name="title" placeholder="tytuł" maxlength="100">
        <textarea class='scroll' id='opis' name="opis" rows='1' placeholder="opis" onkeypress='auto_resize(this);' onkeyup='auto_resize(this);'></textarea>
        <br>
        <input type="submit" name="form" value="Dodaj">
    </form>
    <?php popup(); ?>
</body>
<script>
    function auto_resize (element)
    {
        element.style.height = 'auto';
        element.style.height = (element.scrollHeight - 8)+'px';
    }
</script>
</html>