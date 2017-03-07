<?php
    $pageId = 2;
    require_once("before.php");

    if (!$_SESSION["isConnected"])
    {
        header("Location: /401Error");
    }
?>
<?php
    require_once ("after.php");