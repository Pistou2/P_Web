<?php
$pageId = 2;
require_once("before.php");

//Vérifie si l'utilisateur est bien connecté pour afficher la page
if ($_SESSION["userID"] == null) {
    header("Location: /Login");
    exit;
}
//TODO : Reremplir la page automatiquement en cas d'erreur au lieu de demander à l'utilisateur de tout retaper
//TODO : à la correction vérifier le nom de l'auteur, en chercher des avec un nom semblable à celui entré, ou avertir avant d'en créer un nouveau
?>
    <form method="post">
        <div class="row">
            <div class="col-sm-offset-3 col-sm-6">
                <label for="bookname">Nom du livre : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="bookname" name="bookname" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 col-sm-offset-3">
                <label for="authorName">Nom de l'Auteur : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="authorName" name="authorName" required>
            </div>
            <div class="col-sm-3 col-sm-offset-1">
                <label for="editor">Editeur : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="editor" name="editor" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 col-sm-offset-3">
                <label for="authorFirstname">Prénom de l'Auteur : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="authorFirstname" name="authorFirstname" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 col-sm-offset-3">
                <label for="selType">Type de livre : <span class="mChars">*</span></label>
                <select class="form-control" id="selType" name="selType" required>
                    <!--TODO : lire les différentes options depuis la BD-->
                    <option>BD</option>
                    <option>Manga</option>
                    <option>42</option>
                    <option>9999</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="nbPage">Nombre de page : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="nbPage" name="nbPage" required>
            </div>
            <div class="col-sm-2">
                <label for="releaseYear">Année de parution : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="releaseYear" name="releaseYear" required>
            </div>
        </div>
        <label for="summary">Résumé du livre : </label>
        <textarea class="form-control" id="summary" name="summary" required></textarea>
        <div class="row">
            <div class="col-sm-6">
                <label for="bookPicture">Photo de couverture : </label>
                <input type="file" class="form-control" id="bookPicture" name="bookPicture">
            </div>
            <div class="col-sm-6">
                <label for="bookExtract">Extrait (image) : </label>
                <input type="file" class="form-control" id="bookExtract" name="bookExtract">
            </div>
        </div>
    </form>
<?php
require_once("after.php");