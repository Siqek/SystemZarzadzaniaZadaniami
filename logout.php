<?php
    session_start();

    include "./functions.php";
    include "./popup.php";

    unsetSessionUserVars();
    setPopupVars("Sukces!", "Zostałeś wylogowany.", "/index.php");

    navigateTo('./index.php');
?>