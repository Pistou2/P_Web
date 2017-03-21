<?php
    $pageId = 6;
    require_once("before.php");

//TODO : redirect / warn if the user is already logged

//check if the user is already connected
    if (isset($_SESSION["userID"]) && $_SESSION["userID"] != null) {
        $_SESSION["mustShowPopup"] = true;
        // redirect to the previous page, or the index page if none is inputed
        if (isset($_GET["previousPageID"])) {
            header("location: /" . GlobalValue::PAGES_ARRAY[$_GET["previousPageID"]][1]);
        } else {
            header("location: /");
        }
    }

//check if there's an attempt to login
    if (isset($_POST["email"]) && isset($_POST["pswd"]) && isset($_POST["pswdConfirmed"])) {

        if (!DBCom::getUserData($_POST["email"])->fetch()) {
            if ($_POST["pswd"] == $_POST["pswdConfirmed"]) {
                $values = ["useNickname" => $_POST["email"], "usePassword" => password_hash($_POST["pswd"], PASSWORD_DEFAULT), "useRegisteryDate" => date("Y-m-d")];

                DBCom::saveData("t_user", $values);
            } else {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <p><strong>Erreur !</strong> Les mots de passe ne correspondent pas</p>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <p><strong>Erreur !</strong> Votre email est déjà utilisée</p>
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
                        <input id="email" type="text" class="form-control" name="email" placeholder="Email" required>
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