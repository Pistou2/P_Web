<?php
$pageId = 5;
require_once("before.php");

//check if there's an attempt to login
if (isset($_POST["email"]) && isset($_POST["pswd"])) {
    //check if the log is successfull or no
    if (FormValidator::checkLogin($_POST["email"], $_POST["pswd"])) {

        $_SESSION["isConnected"] = true;
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
    }
}
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
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
            <div class="col-sm-3"></div>
        </div>
    </div>
<?php
require_once("after.php");