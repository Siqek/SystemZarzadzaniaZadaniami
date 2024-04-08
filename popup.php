<?php
    if ($_SERVER['PHP_SELF'] == '/popup.php')
        navigateTo('./');

    include "./popupFunctions.php";

    function popup() : void
    {
        if (shouldClosePopup())
        {
            unsetPopupVars();
        }
        else if (shouldDisplayPopup())
        {
            displayPopup();
        }
    }
?>