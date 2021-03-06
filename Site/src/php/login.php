<?php
    /*
        ETML
        Auteur: Yann Merk
        Date: 07.03.17
        Description: Page pour se connetcer à un compte
    */

    $pageId = 5;
    require_once("header.inc.php");

    // Vérifie si l'utilisateur est connecté
    if (isset($_SESSION["userID"]) && $_SESSION["userID"] != null) {
        $_SESSION["mustShowPopup"] = true;

        // Redirige vers la page précédente, ou la page d'accueil si aucune est entrée
        // Et s'assure de ne pas rediriger vers la page actuel
        if (isset($_GET["previousPageID"]) && $_GET["previousPageID"] != $pageId) {
            header("location: " . GlobalValue::PAGES_ARRAY[$_GET["previousPageID"]][1]);
        } else {
            header("location: Home");
        }
    }

    // Regarde si il y a une tentative de connexion
    if (isset($_POST["email"]) && isset($_POST["pswd"])) {

        // Vérifie si la connection réussi
        $userID = FormValidator::checkLogin($_POST["email"], $_POST["pswd"]);

        if ($userID != null) {
            $_SESSION["userID"] = $userID;
            $_SESSION["mustShowPopup"] = true;

            // Redirige vers la page précédente, ou la page d'accueil si aucune est entrée
            // Et s'assure de ne pas rediriger vers la page actuel ou la page d'inscription
            if (isset($_GET["previousPageID"]) && $_GET["previousPageID"] != $pageId && $_GET["previousPageID"] != GlobalValue::ID_PAGE_SIGN_UP) {
                header("location: " . GlobalValue::PAGES_ARRAY[$_GET["previousPageID"]][1]);
            } else {
                header("location: Home");
            }
        } else {
            // Si non, affiche une erreur
            Misc::writeMessage(3, '<strong>Erreur !</strong> Email ou mot de passe incorrect.');
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
                               placeholder="Email"
                            <?php // Remet la valeure précédente de l'email en cas d'échec si elle existe
                                echo(isset($_POST["email"]) && $_POST["email"] != "" ? 'value="' . $_POST["email"] . '"' : "") ?>
                               required>
                    </div>
                    <br/>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="pswd" type="password" class="form-control" name="pswd"
                               placeholder="Mot de passe" required>
                    </div>
                    <br />
                    <button type="submit" class="btn btn-default">Login</button>
                </form>
            </div>
        </div>
    </div>
<?php
    require_once("footer.inc.php");