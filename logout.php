<?php
    session_start();

    include "./functions.php";
    include "./popup.php";

    unsetSessionUserVars();
    setPopupVars("Sukces!", "Zostałeś wylogowany.");

    navigateTo('./');
?>