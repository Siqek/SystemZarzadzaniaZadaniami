<?php
    if ($_SERVER['PHP_SELF'] == '/popupFunctions.php')
        navigateTo('./');

    function issetPopupVars() : bool
    {
        return (
            isset(
                $_SESSION["POPUP_TITLE"], 
                $_SESSION["POPUP_CONTENT"]
            )
        );
    }

    function setPopupVars($title = '', $content = '') : void
    {
        $_SESSION["POPUP_TITLE"]     = $title;
        $_SESSION["POPUP_CONTENT"]   = $content;
    }

    function getPopupVars() //: array | bool
    {
        return (issetPopupVars() 
            ? array(
                "title"     => $_SESSION["POPUP_TITLE"],
                "content"   => $_SESSION["POPUP_CONTENT"]
            )
            : false
        );
    }

    function unsetPopupVars() : void
    {
        unset($_SESSION["POPUP_TITLE"]);
        unset($_SESSION["POPUP_CONTENT"]);
    }

    function shouldDisplayPopup() : bool
    {
        return (issetPopupVars());
    }

    function displayPopup() : void
    {
        if ($popupVars = getPopupVars())
        {
            echo
            "<div id='popupContainer'>
                <div id='popup'>
                    <h2 id='popupTitle'>" . $popupVars["title"] . "</h2>
                    <span id='popupMessage'><p>" . join("</p><p>", explode("\n", $popupVars["content"])) . "</p></span>
                    <form method='POST' id='popupButton'>
                        <input type='submit' name='closePopup' value='OK'>
                    </form>
                </div>
            </div>";
        }
    }

    function shouldClosePopup() : bool
    {
        return (isset($_POST["closePopup"]));
    }
?>
