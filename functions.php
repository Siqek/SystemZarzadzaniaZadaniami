<?php
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
?>