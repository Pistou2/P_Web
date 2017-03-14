<?php
$pageId = 5;
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
if (isset($_POST["email"]) && isset($_POST["pswd"])) {

    //check if the log is successfull or no
    $userID = FormValidator::checkLogin($_POST["email"], $_POST["pswd"]);

    if ($userID != null) {
        $_SESSION["userID"] = $userID;
        $_SESSION["mustShowPopup"] = true;

        // redirect to the previous page, or the index page if none is inputed
        if (isset($_GET["previousPageID"])) {
            header("location: /" . GlobalValue::PAGES_ARRAY[$_GET["previousPageID"]][1]);
        } else {
            header("location: /");
        }
    } else {
        //if not, display an error
        //TODO
        ?>
        <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><strong>Erreur !</strong> Email ou mot de passe incorect.</p>
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