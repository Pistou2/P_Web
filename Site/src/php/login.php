<?php
    $pageId = 5;
    require_once("before.php");

//Vérifie si l'utilisateur est connecté
    if (isset($_SESSION["userID"]) && $_SESSION["userID"] != null) {
        $_SESSION["mustShowPopup"] = true;

        //Redirige vers la page précédente, ou la page d'accueil si aucune est entrée
        //Et s'assure de ne pas rediriger vers la page actuel
        if (isset($_GET["previousPageID"]) && $_GET["previousPageID"] != $pageId) {
            header("location: " . GlobalValue::PAGES_ARRAY[$_GET["previousPageID"]][1]);
        } else {
            header("location: Accueil");
        }
    }

//Regarde si il y a une tentative de connexion
    if (isset($_POST["email"]) && isset($_POST["pswd"])) {

        //vérifie si la connection réussi

        echo $_POST["email"];

        $userID = FormValidator::checkLogin($_POST["email"], $_POST["pswd"]);

        if ($userID != null) {
            $_SESSION["userID"] = $userID;
            $_SESSION["mustShowPopup"] = true;

            //Redirige vers la page précédente, ou la page d'accueil si aucune est entrée
            //Et s'assure de ne pas rediriger vers la page actuel
            if (isset($_GET["previousPageID"]) && $_GET["previousPageID"] != $pageId) {
                header("location: " . GlobalValue::PAGES_ARRAY[$_GET["previousPageID"]][1]);
            } else {
                header("location: Accueil");
            }
        } else {
            //si non, affiche une erreur
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
                            <?php /*Remet la valeure précédente de l'email en cas d'échec si elle existe*/
                                echo(isset($_POST["email"]) && $_POST["email"] != "" ? 'value="' . $_POST["email"] . '"' : "") ?>
                               required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="pswd" type="password" class="form-control" name="pswd"
                               placeholder="Mot de passe" required>
                    </div>
                    <button type="submit" class="btn btn-default">Login</button>
                </form>
            </div>
        </div>
    </div>
<?php
    require_once("after.php");