<?php
    /*
        ETML
        Auteur: Cl�ment Dieperink
        Date: 21.03.17
        Description: Permet � un utilisateur de se cr�er un compte
    */

    $pageId = 6;
    require_once("before.php");

    // V�rifie si l'utilisateur est d�j� connect�
    if (isset($_SESSION["userID"]) && $_SESSION["userID"] != null) {
        $_SESSION["mustShowPopup"] = true;

        // Redirige vers la page pr�c�dente, ou la page d'accueil si aucune est entr�e
        // Et s'assure de ne pas rediriger vers la page actuel
        if (isset($_GET["previousPageID"]) && $_GET["previousPageID"] != $pageId) {
            header("location: " . GlobalValue::PAGES_ARRAY[$_GET["previousPageID"]][1]);
        } else {
            header("location: Accueil");
        }
    }

    // V�rifie s'il y a des valeurs d'inscription en post
    if (isset($_POST["email"]) && isset($_POST["pswd"]) && isset($_POST["pswdConfirmed"])) {

        // Valide les informations
        $error = FormValidator::checkRegister($_POST["email"], $_POST["pswd"], $_POST["pswdConfirmed"]);

        // S'il n'y a pas eu d'erreure
        if ($error == null) {
            // Enregistre l'utilisateur et le connecte
            $_SESSION["userID"] = DBCom::saveUserData($_POST["email"], password_hash($_POST["pswd"], PASSWORD_DEFAULT), date("Y-m-d"));

            // Redirige vers la derni�re page ou l'index s'il n'y en a pas
            if (isset($_GET["previousPageID"])) {
                header("location: " . GlobalValue::PAGES_ARRAY[$_GET["previousPageID"]][1]);
            } else {
                header("location: Accueil");
            }
        } else {
            // Si non affiche l'erreur
            ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <p><strong>Erreur !</strong> <?php echo $error ?></p>
            </div>
            <?php
        }
    }
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-push-3">
                <form method="post">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="email" type="text" class="form-control" name="email"
                        <!-- Remet l'email s'il l'utilisateur avait fait une erreure -->
                        placeholder="Email" <?php echo isset($_POST["email"]) ? "value=\"" . $_POST["email"] . "\"" : "" ?>
                        required>
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="pswd" type="password" class="form-control" name="pswd"
                               placeholder="Mot de passe" required>
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="pswdConfirmed" type="password" class="form-control" name="pswdConfirmed"
                               placeholder="Confirmer le mot de passe" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-default">Inscription</button>
                </form>
            </div>
        </div>
    </div>
<?php
    require_once("after.php");