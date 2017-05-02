<?php
    $pageId = 7;

    include_once "classes/DBCom.php";

    if (isset($_GET["bookId"]) && ctype_digit($_GET["bookId"])) {
        $bookInfo = DBCom::getBookWithId($_GET["bookId"]);


        if (!empty($bookInfo)) {
            $bookInfo = $bookInfo[0];

            $pageTitle = $bookInfo["booTitle"];
        } else {
            header("Location: Ouvrage");
            die();
        }
    } else {
        header("Location: Ouvrage");
        die();
    }

    if (isset($_GET["rate"]))
    {
        if ($_GET["rate"] > 0 && $_GET["rate"] <= 5)
        {

        }
    }

    require_once("before.php");
?>
    <div class="row">
        <div class="col-sm-6">
            <img src="userContent/Book_Cover/<?php echo $bookInfo["booPictureLink"] ?>" id="bookCover"
                 alt="[Couverture du livre]"/>
        </div>
        <div class="col-sm-6">
            <p>Auteur : <b><?php echo $bookInfo["autName"] . " " . $bookInfo["autFirstname"] ?></b></p><br/>
            <p>Editeur : <b><?php echo $bookInfo["ediName"] ?></b></p><br/>
            <p>Année de parution : <b><?php echo $bookInfo["booReleaseYear"] ?></b></p><br/>
            <p>Nombre de page : <b><?php echo $bookInfo["booPageNumber"] ?></b></p><br/>
            <p>Type de livre : <b><?php echo $bookInfo["btName"] ?></b></p><br/>
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
                        echo(($i + 1) == count($bookCategory) ? "" : ", ");
                    }
                ?>
            </p>
            <br/>
            <br/>
            <br/>
            <br/>
            <?php
                if (empty($bookInfo["booSummary"])) {
                    ?>
                    <p>Ce livre n'a pas de résumé</p>
                    <?php
                } else {
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
            <br/>
            <br/>
            <div id="rating">
            <?php
                $db = new DBCom();

                $bookRates = $db::getRateForBook($_GET["bookId"]);

                if (empty($bookRates))
                {
                    $rateAverage = 0;
                    ?>
                    <p>Il n'y a encore aucune note pour ce livre</p>
                    <?php
                }
                else
                {
                    $rateSum = 0;

                    foreach ($bookRates as $rate)
                    {
                        $rateSum += $rate["ratRating"];
                    }

                    $rateAverage = $rateSum / count($bookRates);

                    echo "<p>$rateAverage</p>";
                }

                echo "<p>";

                for($i = 1; $i <= 5; $i++)
                {
                    if ($rateAverage > $i - 0.5)
                    {
                        echo "<span class='glyphicon glyphicon-star'></span>";
                    }
                    else
                    {
                        echo "<span class='glyphicon glyphicon-star-empty'></span>";
                    }
                }

                echo "</p>";
            ?>
            </div>
            <?php

                if ($isConnected)
                {
                    $userRate = $db::getRateForUserAndBook($_SESSION["userID"], $_GET["bookId"]);

                    if (empty($userRate))
                    {
                        $actualNote = $userRate[0]["ratRating"];
                        ?>
                        <p>Vous n'avez pas encore mis de note pour ce livre</p>
                        <p>Mettre une note :</p>
                        <?php
                    }

                    else
                    {
                        $actualNote = $userRate[0]["ratRating"];
                        ?>
                        <p>Votre note actuel est <?php echo $userRate[0]["ratRating"] ?></p>
                        <p>Changer votre note :</p>
                        <?php
                    }
                    for ($i = 1; $i <= 5;$i++) {
                        if ($rateAverage >= $i)
                        {
                            echo "<a href='ShowBook?bookId=".$_GET["bookId"]."&rate=$i'><span class='glyphicon glyphicon-star'></span></a>";
                        }
                        else
                        {
                            echo "<a href='ShowBook?bookId=".$_GET["bookId"]."&rate=$i'><span class='glyphicon glyphicon-star-empty'></span></a>";
                        }
                    }
                }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
                if (empty($bookInfo["booExtractLink"]) || !file_exists("../../userContent/Book_Extract/" . $bookInfo["booExtractLink"])) {
                    ?>
                    <p>Ce livre ne possède pas d'extrait</p>
                    <?php
                } else {
                    ?>
                    Extrait du livre:<br>
                    <iframe src="userContent/Book_Extract/<?php echo $bookInfo["booExtractLink"] ?>"
                            id="bookExtract"></iframe>
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