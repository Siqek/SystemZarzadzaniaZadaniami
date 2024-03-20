<div id='menu'>
    <?php
        if (isLogged())
        {
            echo "<a href='./zadanieForm.php'>dodaj zadanie</a>";

            echo "<a href='./listaZadan.php'>zadania</a>";

            if (isLoggedAs('pracownik') || isLoggedAs('admin'))
                echo "<a href='./przypisane.php'>przypisane zadania</a>";

            if (isLoggedAs('admin'))
                echo "<a href='./users.php'>użytkownicy</a>";

            echo "<a href='./konto.php'>konto</a>";
            
            echo "<a href='./logout.php'>wyloguj</a>";
        }
    ?>
</div>