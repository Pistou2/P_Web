<?php
    /* 
        ETML
        Auteur: Yann Merk
        Date: 04.04.17
        Description: Affiche les livres qui sont partager sur le site
    */

    $pageId = 1;
    require_once("header.inc.php");

    // Initialise une variable pour le nombre maximum de livre à afficher
    $maxBookShow = 30;

    // Obtient le numéro de la page actuel
    $pageNumber = isset($_GET["pageNumber"]) && $_GET["pageNumber"] > 0 ? $_GET["pageNumber"] : 1;

    // Récupères les livres en fonction de la page actuel et du nombre maximum de livre à afficher et le nombre total de livre dans la BD
    $books = DBCom::getBooks($pageNumber, $maxBookShow);
    $totalOfBook = DBCom::getNumberOfBook();

?>
    <div class="col-sm-12">
        <?php
            // S'il y a des livres à afficher
            if (count($books) > 0) {

                //Affiche tous les livres
                foreach ($books as $book) {
                    ?>
                    <a href="ShowBook?bookId=<?php echo $book['idBook'] ?>">
                        <div class="bookElement col-sm-4">
                            <p><?php echo $book['booTitle'] ?></p>
                            <img src="userContent/Book_Cover/<?php echo $book['booPictureLink'] ?>"
                                 alt="[Couverture de livre]">
                        </div>
                    </a>
                    <?php
                }
            } // Sinon s'il y a des livres dans la BD
            else if ($totalOfBook > 0) {
                // Redirige vers la page 1 de l'affichage des ouvrages
                header("Location: Book");
            } else {
                // Sinon affiche un message pour dire qu'il n'y a pas encore de livre
                Misc::writeMessage(2, "Il n'y a aucun livre pour le moment.");
            }

        ?>
    </div>

    <div class="col-sm-12 pagination">
        <?php
            // Calcul la première et la dernière page pour l'affichage de la navigation entre page
            $startPage = $pageNumber <= 3 ? 1 : $pageNumber - 2;
            $endPage = $startPage + 4 <= $totalOfBook / $maxBookShow ? $startPage + 4 : ceil($totalOfBook / $maxBookShow);
            $startPage = $endPage - 4 > 0 ? $endPage - 4 : 1;

            // S'il n'y a pas seulement une page à afficher
            if ($startPage != $endPage) {
                ?>
                <ul class="pagination">
                    <?php
                        // Si ce n'est pas la première page
                        if ($pageNumber != $startPage) {
                            // Affiche une flèche vers la gauche pour "précédent"
                            ?>
                            <li><a href="Books?pageNumber=<?php echo $pageNumber - 1 ?>"><span
                                        class="glyphicon glyphicon-menu-left"></span></a></li>
                            <?php
                        }

                        // Affiche chaque numéro de page entre la première et la dernière page à afficher
                        for ($i = $startPage; $i <= $endPage; $i++) {
                            ?>
                            <li <?php echo $i == $pageNumber ? 'class="active"' : "" ?>><a
                                    href="Books?pageNumber=<?php echo $i ?>"><?php echo $i ?></a></li>
                            <?php
                        }

                        // Si ce n'est pas la dernière page
                        if ($pageNumber != $endPage) {
                            // Affiche une flèche vers la droite pour "suivant"
                            ?>
                            <li><a href="Books?pageNumber=<?php echo $pageNumber + 1 ?>"><span
                                        class="glyphicon glyphicon-menu-right"></span></a></li>
                            <?php
                        }
                    ?>
                </ul>
                <?php
            }
        ?>
    </div>
<?php
    require_once("footer.inc.php");