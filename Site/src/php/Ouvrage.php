<?php
    $pageId = 1;
    require_once("before.php");
//Récupères tous les livres

//Si il y suffisament de livre
    $books = DBCom::getAllBooks();
    if (count($books) > 0) {

        //Boucle sur toutes les lignes de livres
        foreach ($books as $book) {
            echo '<a href="/ShowBook?bookId=' . $book['idBook'] . '"><div class="bookElement col-sm-4">';
            echo '   <p>' . $book['booTitle'] . '</p>';
            echo '   <img src="userContent/Book_Cover/' . $book['booPictureLink'] . '" alt="[Couverture de livre]">';
            echo '</div></a>';
        }
    } else {
        Misc::writeMessage(2, "Il n'y a aucun livre pour le moment T-T");
    }
?>

    <div class="row"></div>
<?php
    require_once("after.php");