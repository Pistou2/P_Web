<?php
    /*
        ETML
        Auteur: Clément Dieperink
        Date: 02.05.17
        Description: Page d'accueil du site
    */

    $pageId = 0;
    require_once("before.php");
?>
    <h1>Bienvenue</h1>
    <p>Ce site a pour but de pouvoir partager des livres que vous avez lu avec d'autre personne.</p>
    <p>Voici les 5 derniers livres ajoutés</p>
<?php
    // Obtient les 5 derniers livres de la BD
    $books = DBCom::getBooks(1, 5);

    // Affiche les 5 livres
    foreach ($books as $book) {
        ?>
        <a href="ShowBook?bookId=<?php echo $book['idBook'] ?>">
            <div class="bookElement col-sm-2">
                <p>
                    <?php echo $book['booTitle'] ?>
                </p>
                <img src="userContent/Book_Cover/<?php echo $book['booPictureLink'] ?>" alt="[Couverture de livre]"/>
            </div>
        </a>
        <?php
    }
    require_once("after.php");