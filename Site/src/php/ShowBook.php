<?php
    /*
        ETML
        Auteur: Clément Dieperink
        Date: 25.04.17
        Description: Affiche les informations d'un livre
    */

    // Indique l'id de la page
    $pageId = 7;

    include_once "classes/DBCom.php";

    // Vérifie qu'il y ait bien un livre à afficher
    if (isset($_GET["bookId"]) && ctype_digit($_GET["bookId"])) {

        // Obtient les informations du live voulu
        $bookInfo = DBCom::getBookWithId($_GET["bookId"]);

        // Vérifie que le livre existe bien
        if (!empty($bookInfo)) {
            // Enlève le tableau de tableau
            $bookInfo = $bookInfo[0];

            // Change le titre de la page
            $pageTitle = $bookInfo["booTitle"];
        } else {
            // Si le livre n'existe pas redirige vers la page de sélection des livres
            header("Location: Books");
            die();
        }
    } else {
        // S'il n'y a pas de livre à regarder redirige vers la page de sélection des livres
        header("Location: Books");
        die();
    }

    // Affiche le début de la page
    require_once("header.inc.php");

    // Si l'utilisateur à mis une note et qu'il est connecté
    if (isset($_GET["rate"]) && $isConnected) {
        // Si la note se situe entre 1 et 5
        if ($_GET["rate"] > 0 && $_GET["rate"] <= 5) {
            // Ajoute/change la note de l'utilisateur
            DBCom::setRateForUserAndBook($_SESSION["userID"], $_GET["bookId"], $_GET["rate"]);
        }
    }

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
                    // Récupère les catégories du livre
                    $bookCategory = DBCom::getAllCategoryForABook($_GET["bookId"]);

                    // Affiche chaque catégorie du livre
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
                // Si le livre n'a pas de résumé l'indique sinon affiche le résumé
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
                    // Récupère les notes du livre
                    $bookRates = DBCom::getRateForBook($_GET["bookId"]);

                    // S'il n'y a pas encore de note l'indique
                    if (empty($bookRates)) {
                        $rateAverage = 0;
                        ?>
                        <p id="noRate">Il n'y a encore aucune note pour ce livre</p>
                        <?php
                    } else {
                        //Sinon calcule la moyenne des notes
                        $rateSum = 0;
                        foreach ($bookRates as $rate) {
                            $rateSum += $rate["ratRating"];
                        }
                        $rateAverage = $rateSum / count($bookRates);

                        // Affiche la moyenne arrondie au dixième
                        echo "<p>" . round($rateAverage, 1) . " <span id='numberOfNote'>". count($bookRates) ." notes</span></p>";
                    }

                    echo "<p>";

                    // Affiche les 5 étoiles pour la notes en fonction de la moyenne
                    for ($i = 1; $i <= 5; $i++) {
                        if ($rateAverage >= $i - 0.25) {
                            echo "<span class='glyphicon glyphicon-star'></span>";
                        } else if ($rateAverage - $i >= -0.75) {
                            echo "<span class='glyphicon glyphicon-star half'></span>";
                        } else {
                            echo "<span class='glyphicon glyphicon-star empty'></span>";
                        }
                    }

                    echo "</p>";
                ?>
            </div>
            <br/>
            <div id="currentRate">
                <?php
                    // Si l'utilisateur est connecté affiche
                    if ($isConnected) {
                        // Obtient la note de l'utilisateur
                        $userRate = DBCom::getRateForUserAndBook($_SESSION["userID"], $_GET["bookId"]);

                        // S'il n'a pas encore mis de note l'indique et propose d'en mettre une
                        if (empty($userRate)) {
                            $actualNote = 0;
                            ?>
                            <p>Vous n'avez pas encore mis de note pour ce livre</p>
                            <p>Mettre une note :</p>
                            <?php
                        } else {
                            // Sinon affiche la note actuel et propose de la changer
                            $actualNote = $userRate[0]["ratRating"];
                            ?>
                            <p>Votre note actuel est <?php echo $userRate[0]["ratRating"] ?></p>
                            <p>Changer votre note :</p>
                            <?php
                        }

                        // Affiche des étoiles en fonction de la note qui permette de la changer
                        for ($i = 1; $i <= 5; $i++) {
                            if ($actualNote >= $i) {
                                echo "<a href='ShowBook?bookId=" . $_GET["bookId"] . "&rate=$i'><span class='glyphicon glyphicon-star'></span></a>";
                            } else {
                                echo "<a href='ShowBook?bookId=" . $_GET["bookId"] . "&rate=$i'><span class='glyphicon glyphicon-star empty'></span></a>";
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
                // S'il n'y a pas d'extrait pour le livre et que le fichier existe l'indique
                if (empty($bookInfo["booExtractLink"]) || !file_exists("../../userContent/Book_Extract/" . $bookInfo["booExtractLink"])) {
                    ?>
                    <p>Ce livre ne possède pas d'extrait</p>
                    <?php
                } else {
                    // Sinon affiche l'extrait dans un iframe
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
    require_once("footer.inc.php");