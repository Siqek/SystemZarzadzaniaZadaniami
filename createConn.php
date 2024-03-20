<?php
    function newConn ()
    {
        $host = '192.168.15.182';
        $user = 'root';
        $pass = 'zaq1';
        $db = 'szz';

        $conn = mysqli_connect($host, $user, $pass, $db);

        if (!$conn)
            return false;
        else
            return $conn;
    }
?>