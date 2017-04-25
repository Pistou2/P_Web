<?php
    $pageId = 7;

    include_once "classes/DBCom.php";

    if (isset($_GET["bookId"]) && ctype_digit($_GET["bookId"]))
    {
        echo $_GET["bookId"];

        $bookInfo = DBCom::getBookWithId($_GET["bookId"]);



        if (!empty($bookInfo))
        {
            $bookInfo = $bookInfo[0];

            $pageTitle = $bookInfo["booTitle"];

            print_r($bookInfo);
        }
        else
        {
            header("Location: Ouvrage");
            die();
        }
    }
    else
    {
        header("Location: Ouvrage");
        die();
    }

    require_once("before.php");
?>
    <div class="row">
        <div class="col-sm-6">
            <img src="userContent/Book_Cover/<?php echo $bookInfo["booPictureLink"]?>">
        </div>
        <div class="col-sm-6">
            <p>Auteur : <?php echo $bookInfo["autName"]." ".$bookInfo["autFirstname"] ?></p><br>
            <p>Année de parution : <?php echo $bookInfo["booReleaseYear"]; ?></p><br>
            <p>Nombre de page : <?php echo $bookInfo["booPageNumber"]; ?></p><br>
            <p>Type de livre : <?php echo $bookInfo["btName"]?></p><br>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            Résumé<br>
            <?php echo $bookInfo["booSummary"]; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            Extrait du livre:<br><iframe src="/userContent/Book_Extract/<?php echo $bookInfo["booExtractLink"]?>"></iframe>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            Ce livre a été ajouté par <?php echo $bookInfo["useNickname"] ?>
        </div>
    </div>
<?php
    require_once("after.php");