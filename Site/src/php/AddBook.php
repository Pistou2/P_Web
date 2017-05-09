<?php
    /*
        ETML
        Auteur: Yann Merk
        Date: 14.03.17
        Description: Permet à un utilisateur connecté d'ajouter un livre
    */

    $pageId = 2;
    require_once("header.inc.php");

    // Vérifie si l'utilisateur est bien connecté pour afficher la page
    if ($_SESSION["userID"] == null) {
        header("Location: Login?previousPageID=$pageId");
        exit;
    }

    // Vérifie si un POST est fait ou pas
    if (isset($_POST) && count($_POST) > 0) {

        // Si oui, vérifie que les inputs sont correct et affiche une erreur en fonction
        $bookId = FormValidator::checkAddBook($_POST, $_FILES);

        // Si l'id du livre n'est pas nul redirige vers la page d'affichage du livre
        if ($bookId != null) {
            header('location: ShowBook?bookId=' . $bookId);
            exit;
        }
    }
?>
    <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-12">
                <label for="bookName">Nom du livre : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="bookName"
                       name="bookName" <?php echo isset($_POST["bookName"]) ? "value=\"" . $_POST["bookName"] . "\"" : "" ?>
                       required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <label for="authorName">Nom de l'Auteur : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="authorName"
                       name="authorName" <?php echo isset($_POST["authorName"]) ? "value=\"" . $_POST["authorName"] . "\"" : "" ?>
                       required>
            </div>
            <div class="col-sm-4 col-sm-offset-2">
                <label for="authorFirstname">Prénom de l'Auteur : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="authorFirstname"
                       name="authorFirstname" <?php echo isset($_POST["authorFirstname"]) ? "value=\"" . $_POST["authorFirstname"] . "\"" : "" ?>
                       required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <label for="editor">Editeur : <span class="mChars">*</span></label>
                <input type="text" class="form-control" id="editor"
                       name="editor" <?php echo isset($_POST["editor"]) ? "value=\"" . $_POST["editor"] . "\"" : "" ?>
                       required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 col-sm-offset-1">
                <p>Catégorie de livre : <span class="mChars">*</span></p>
                <?php
                    $allCategory = DBCom::getAllCategory();

                    for ($i = 0; $i < count($allCategory); $i++) {
                        ?>
                        <div class="checkbox">
                            <label data-toggle="tooltip" data-placement="bottom"
                                   title="<?php echo $allCategory[$i]["catDescription"] ?>">
                                <input type="checkbox"
                                       name="bookCategory[]" value="<?php echo $allCategory[$i]['idCategory'] ?>"
                                    <?php echo isset($_POST['bookCategory']) && in_array($allCategory[$i]['idCategory'], $_POST['bookCategory']) ? "checked" : "" ?>/>
                                <?php echo $allCategory[$i]['catName'] ?>
                            </label>
                        </div>
                        <?php
                    }
                ?>
            </div>
            <div class="col-sm-4 col-sm-offset-3">
                <label for="selType">Type de livre : <span class="mChars">*</span></label>
                <select class="form-control" id="selType" name="selType" required>
                    <?php
                        $allType = DBCom::getAllType();

                        for ($i = 0; $i < count($allType); $i++) {
                            ?>
                            <option
                                value="<?php echo $allType[$i]['idBookType'] ?>" <?php echo isset($_POST['selType']) && $_POST['selType'] == $allType[$i]['idBookType'] ? "selected" : "" ?>><?php echo $allType[$i]['btName'] ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <label for="nbPage">Nombre de page : <span class="mChars">*</span></label>
                <input type="number" class="form-control" id="nbPage"
                       name="nbPage" <?php echo isset($_POST["nbPage"]) ? "value=\"" . $_POST["nbPage"] . "\"" : "" ?>
                       required>
            </div>
            <div class="col-sm-2">
                <label for="releaseYear">Année de parution : <span class="mChars">*</span></label>
                <input type="number" class="form-control" id="releaseYear"
                       name="releaseYear" <?php echo isset($_POST["releaseYear"]) ? "value=\"" . $_POST["releaseYear"] . "\"" : "" ?>
                       required>
            </div>
        </div>
        <div class="row">
            <label for="summary">Résumé du livre : </label>
        </div>
        <textarea class="form-control" id="summary"
                  name="summary"><?php echo isset($_POST["summary"]) ? $_POST["summary"] : "" ?></textarea>
        <div class="row">
            <div class="col-sm-6">
                <label for="bookPicture">Photo de couverture : <span class="mChars">*</span></label>
                <input type="file" class="form-control" id="bookPicture" name="bookPicture">
            </div>
            <div class="col-sm-6">
                <label for="bookExtract">Extrait (PDF uniquement) : </label>
                <input type="file" class="form-control" id="bookExtract" name="bookExtract">
            </div>
        </div>

        <div class="row">
            <input type="submit">
        </div>
    </form>
<?php
    require_once("footer.inc.php");