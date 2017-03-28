<?php
$pageId = 2;
require_once("before.php");

//Vérifie si l'utilisateur est bien connecté pour afficher la page
if ($_SESSION["userID"] == null) {
    header("Location: login?previousPageID=$pageId");
    exit;
}
//check if a post has been already made or no
if (isset($_POST) && count($_POST) > 0) {
    //if Yes, check if the inputs are correct or no, and write errors according to that
    if (FormValidator::checkAddBook($_POST)) {
        //TODO : Upload the book
    }
}
//TODO : Reremplir la page automatiquement en cas d'erreur au lieu de demander à l'utilisateur de tout retaper
//TODO : à la correction vérifier le nom de l'auteur, en chercher des avec un nom semblable à celui entré, ou avertir avant d'en créer un nouveau
echo "<pre>";
print_r($_POST);
echo "</pre>";
?>
    <form method="post">
        <div class="row">
            <div class="col-sm-12">
                <label for="bookName">Nom du livre : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="bookName" name="bookName" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <label for="authorName">Nom de l'Auteur : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="authorName" name="authorName" required>
            </div>
            <div class="col-sm-4 col-sm-offset-2">
                <label for="authorFirstname">Prénom de l'Auteur : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="authorFirstname" name="authorFirstname" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <label for="editor">Editeur : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="editor" name="editor" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 col-sm-offset-1">
                <p>Catégorie de livre : <span class="mChars">*</span></p>
                <!--TODO : lire les différentes catégories depuis la BD-->
                <div class="checkbox">
                    <label><input type="checkbox" name="bookCategory[0]"/> Catégorie 1</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="bookCategory[1]"/> Catégorie 1</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="bookCategory[2]"/> Catégorie 1</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="bookCategory[3]"/> Catégorie 1</label>
                </div>
            </div>
            <div class="col-sm-4 col-sm-offset-3">
                <label for="selType">Type de livre : <span class="mChars">*</span></label>
                <select class="form-control" id="selType" name="selType" required>
                    <!--TODO : lire les différentes options depuis la BD-->
                    <option>BD</option>
                    <option>Manga</option>
                    <option>42</option>
                    <option>9999</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <label for="nbPage">Nombre de page : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="nbPage" name="nbPage" required>
            </div>
            <div class="col-sm-2">
                <label for="releaseYear">Année de parution : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="releaseYear" name="releaseYear" required>
            </div>
        </div>
        <div class="row">
            <label for="summary">Résumé du livre : </label>
        </div>
        <textarea class="form-control" id="summary" name="summary"></textarea>
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

        <div class="row">
            <input type="submit">
        </div>
    </form>
<?php
require_once("after.php");