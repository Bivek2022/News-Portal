<?php require '../config/init.php' ?>
<?php 
    $_title = SITE_NAME." || Admin login";

    if(isset($_SESSION['token']) && !empty($_SESSION['token'])){
        redirect('dashboard.php');
    }
    
    if(isset($_COOKIE['_au']) && !empty($_COOKIE['_au'])){
        redirect('dashboard.php');
    }


?>
<?php require 'inc/header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <?php flash() ?>
                    <div class="panel-body">
                        <form role="form" method="post" action="process/login.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" requried autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" requried value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button style="border-radius: 10px;" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require 'inc/footer.php' ?>