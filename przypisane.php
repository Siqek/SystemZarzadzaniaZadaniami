<?php
    session_start();

    include "./functions.php";

    if (!isLogged()
        || !(isLoggedAs('pracownik') || isLoggedAs('admin')))
    {
        navigateTo('./');
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
    <div id='content'>
        <div id='wyszukiwanie'>
            <input type="text" id="searchBar" placeholder="wyszukaj zadanie"
                onkeydown="search(this.value)" onkeyup="search(this.value)">
        </div>
        <div id="zadania" class='scroll'>
            <?php
                $conn = newConn();

                $sql = "SELECT * FROM `zadania` JOIN `statusy` ON `zadania`.status = `statusy`.id WHERE archiwizowane = false AND pracownik = '" . $_SESSION["login"] . "' ORDER BY `data` DESC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0)
                {
                    while ($row = mysqli_fetch_assoc($result))
                    {
                        echo "<span class='elem task'>
                                <div class='zadanie'>
                                    <span>
                                    <div class='info'>
                                        <h3 id='title' class='green'>" . $row["tytul"] . "</h3>
                                        <p>" . $row["nazwa"] . "</p>
                                    </div>
                                    <div class='info'>
                                        <p>" . $row["user"] . "</p>
                                        <p>" . $row["data"] . "</p>
                                    </div>
                                    <p>" . ((!empty($row["pracownik"])) ? $row["pracownik"] : "brak") . "</p>
                                    <div id='line'></div>
                                    </span>
                                    <div class='opis scroll'>
                                        <p id='description'>" . str_replace("\n", "<br>", $row["opis"]) . "</p>
                                    </div>
                                </div>
                            </span>";
                    }
                }

                mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
<script>
    function search(content)
    {
        let tasks = document.querySelectorAll(".task");

        tasks.forEach((elem) => 
        {
            title = elem.querySelector("#title").innerHTML;
            description = elem.querySelector("#description").innerHTML;

            console.log((title.includes(content) || description.includes(content)))

            if (title.includes(content) || description.includes(content))
            {
                elem.style.display = 'inline-flex';
                elem.querySelector(".zadanie").style.display = 'grid';
            }
            else
            {
                elem.style.display = 'none';
                elem.querySelector(".zadanie").style.display = 'none';
            }
        })
    }
</script>
</html>