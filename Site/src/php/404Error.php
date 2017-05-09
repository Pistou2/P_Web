<?php
    /*
        ETML
        Auteur: Clément Dieperink
        Date: 07.03.17
        Description: Page d'erreur 404
    */

    $pageId = 4;
    require_once("before.php");
?>
    <p class="alert alert-danger"><strong><span class="glyphicon glyphicon-warning-sign"></span>Attention !</strong>
        Cette page n'existe pas.</p>
    <img src="resources/image/404.gif">
<?php
    require_once("after.php");