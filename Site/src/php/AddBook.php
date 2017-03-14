<?php
$pageId = 2;
require_once("before.php");

//Vérifie si l'utilisateur est bien connecté pour afficher la page
if ($_SESSION["userID"] == null) {
    header("Location: /401Error");
    exit;
}
//TODO : Reremplir la page automatiquement en cas d'erreur au lieu de demander à l'utilisateur de tout retaper
//TODO : à la correction vérifier le nom de l'auteur, en chercher des avec un nom semblable à celui entré, ou avertir avant d'en créer un nouveau
?>
    <form method="post">
        <div class="form-group">
            <label for="bookname">Nom du livre : </label>
            <input type="text" class="form-control" id="bookname" name="bookname" required>
            <label for="author">Autheur : </label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>
        <div class="form-group">
            <label for="selType">Type de livre : </label>
            <select class="form-control" id="selType" name="selType">
                <!--TODO : lire les différentes options depuis la BD-->
                <option>BD</option>
                <option>Manga</option>
                <option>42</option>
                <option>9999</option>
            </select>
        </div>
    </form>
<?php
require_once("after.php");