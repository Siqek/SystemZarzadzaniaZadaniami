<div id='menu'>
    <?php
        if (isLogged())
        {
            echo "<a href='./zadanieForm.php'>dodaj zadanie</a>";

            if (isLoggedAs('pracownik') || isLoggedAs('admin'))
                ;#echo "<a href='./'>test pracownika</a>";

            if (isLoggedAs('admin'))
                echo "<a href='./users.php'>użytkownicy</a>";

            echo "<a href='./logout.php'>wyloguj</a>";
        }
    ?>
</div>