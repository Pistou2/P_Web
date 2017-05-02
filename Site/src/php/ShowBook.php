<?php
    $pageId = 7;

    include_once "classes/DBCom.php";

    if (isset($_GET["bookId"]) && ctype_digit($_GET["bookId"]))
    {
        $bookInfo = DBCom::getBookWithId($_GET["bookId"]);



        if (!empty($bookInfo))
        {
            $bookInfo = $bookInfo[0];

            $pageTitle = $bookInfo["booTitle"];
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
            <img src="userContent/Book_Cover/<?php echo $bookInfo["booPictureLink"]?>" id="bookCover" alt="[Couverture du livre]" />
        </div>
        <div class="col-sm-6">
            <p>Auteur : <b><?php echo $bookInfo["autName"]." ".$bookInfo["autFirstname"] ?></b></p><br/>
            <p>Editeur : <b><?php echo $bookInfo["ediName"] ?></b></p><br />
            <p>Année de parution : <b><?php echo $bookInfo["booReleaseYear"] ?></b></p><br/>
            <p>Nombre de page : <b><?php echo $bookInfo["booPageNumber"] ?></b></p><br/>
            <p>Type de livre : <b><?php echo $bookInfo["btName"] ?></b></p><br />
            <p>
                Catégorie du livre : 
                <?php
                    $bookCategory = DBCom::getAllCategoryForABook($_GET["bookId"]);

                for ($i = 0; $i < count($bookCategory); $i++) {
                ?>
                <label data-toggle="tooltip" data-placement="bottom"
                    title="<?php echo $bookCategory[$i]["catDescription"] ?>">
                    <?php echo $bookCategory[$i]['catName'] ?>
                </label>
                    <?php
                    echo (($i + 1) == count($bookCategory) ? "" : ", ");
                }
                ?>
            </p>
            <br />
            <br />
            <br />
            <br />
            <?php
                if (empty($bookInfo["booSummary"]))
                {
                    ?>
                    <p>Ce livre n'a pas de résumé</p>
                    <?php
                }
                else{
                    ?>
                    <div class="well">
                        <p>
                        Résumé :<br>
                        <b><?php echo $bookInfo["booSummary"]; ?></b>
                        </p>
                    </div>
            <?php
                 }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
                if (empty($bookInfo["booExtractLink"]) || !file_exists("../../userContent/Book_Extract/".$bookInfo["booExtractLink"]))
                {
                    ?>
                    <p>Ce livre ne possède pas d'extrait</p>
                    <?php
                }
                else{
                    ?>
                    Extrait du livre:<br>
                    <iframe src="userContent/Book_Extract/<?php echo $bookInfo["booExtractLink"]?>" id="bookExtract"></iframe>
                    <?php
                }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            Livre a été ajouté par <?php echo $bookInfo["useNickname"] ?>
        </div>
    </div>
<?php
    require_once("after.php");