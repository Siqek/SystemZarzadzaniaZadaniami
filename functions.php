<?php
    if ($_SERVER['PHP_SELF'] == '/functions.php')
        navigateTo('./');

    function newConn ()
    {
        $host = '192.168.43.204';
        //$host = '192.168.15.182';
        $user = 'root';
        $pass = 'zaq1';
        $db = 'szz';

        $conn = mysqli_connect($host, $user, $pass, $db);
      
        return $conn;
    }

    function szyfrujPass($pass) 
    {
        return md5($pass);
    }

    function navigateToAfterTime ($location, $miliseconds)
    {
        echo 
        "<script>
            setTimeout(() => 
            {
                location.href = '$location';
            }, $miliseconds)
        </script>";
    }

    function navigateTo ($location)
    {
        echo 
        "<script>
            location.href = '$location';
        </script>";
    }

    function setSessionUserVars($login, $username, $upr)
    {
        $_SESSION["logged"]     = true;
        $_SESSION["login"]      = $login;
        $_SESSION["username"]   = $username;
        $_SESSION["upr"]        = $upr;
    }

    function unsetSessionUserVars()
    {
        $_SESSION["logged"]     = false;
        $_SESSION["login"]      = NULL;
        $_SESSION["username"]   = NULL;
        $_SESSION["upr"]        = NULL;
    }

    function isLogged()
    {
        return ($_SESSION["logged"] === true);
    }

    function isLoggedAs($upr)
    {
        return ($_SESSION["upr"] === $upr);
    }
?>