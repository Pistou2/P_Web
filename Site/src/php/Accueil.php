<?php
    $pageId = 0;
    require_once("before.php");
?>
    <h1>Bienvenue</h1>
    <p>Ce site a pour but de pouvoir partager des livres que vous avez lu avec d'autre personne.</p>
    <p>Voici les 5 derniers livres ajoutés</p>
    <?php
            $books = DBCom::getFiveLastBook();

            foreach ($books as $book) {
    ?>
    <a href="ShowBook?bookId=<?php echo $book['idBook'] ?>">
        <div class="bookElement col-sm-2">
            <p>
                <?php echo $book['booTitle'] ?>
            </p>
            <img src="userContent/Book_Cover/<?php echo $book['booPictureLink'] ?>" alt="[Couverture de livre]" />
        </div>
    </a>
    <?php
            }
    ?>
<?php
    require_once("after.php");