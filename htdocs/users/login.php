<?php

include("redirect.php");
include("includes/stats_lib.php");
include("includes/password_reset_need.php");
include("includes/script_elems.php");

$file = "../../BlisSetup.html";
$content =<<<content
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="Refresh"
CONTENT="1; URL=http://{$_SERVER['SERVER_ADDR']}:4001/login.php">
</head>
</html>
content;
file_put_contents($file, $content);

session_start();
# If already logged in, redirect to home page
if(isset($_SESSION['user_id']))
{
	header("Location: home.php");
}
LangUtil::setPageId("login");

$script_elems = new ScriptElems();
$script_elems->enableJQuery();
?>
<meta charset="UTF-8"> 
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta http-equiv="Content-Language" content="en" />
<meta name="msapplication-TileColor" content="#2d89ef">
<meta name="theme-color" content="#4188c9">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<link rel="icon" href="./favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
<title>Login - C4G BLIS</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
<script>
    requirejs.config({
        baseUrl: '.'
    });

</script>
<script src="../assets/js/require.min.js"></script>
<link href="../assets/css/dashboard.css" rel="stylesheet" />
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/plugins/input-mask/plugin.js"></script>
<script>
    function load() {
        $('#username_error').hide();
        $('#password_error').hide();
    }

    function check_input_boxes() {
        if ($('#username').val() == "") {
            $('#username_error').show();
            return;
        } else {
            $('#username_error').hide();
        }
        if ($('#password').val() == "") {
            $('#password_error').show();
            return;
        } else {
            $('#password_error').hide();
        }
        $('#form_login').submit();

    }

    function unload() {
        document.getElementById("username_error").value == "";
        document.getElementById("password_error").value == "";
    }

    $(document).ready(function() {
        load();
        $('#username').focus();
    });

    function capLock(e) {
        kc = e.keyCode ? e.keyCode : e.which;
        if (kc == 8) {
            //delete key pressed, maintain same state
            return;
        }
        sk = e.shiftKey ? e.shiftKey : ((kc == 16) ? true : false);
        if (((kc >= 65 && kc <= 90) && !sk) || ((kc >= 97 && kc <= 122) && sk))
            $('#caps_lock_msg_div').show();
        else
            $('#caps_lock_msg_div').hide();
    }

</script>

<body class="">
    <div class="page">
        <div class="page-single">
            <div class="container">
                <div class="row">
                    <div class="col col-login mx-auto">
                        <div class="text-center mb-6">
                            <img src="../images/logo_small.png" class="h-7" alt="C4G BLIS - Logo">
                        </div>
                        <form class="card" name="form_login" id='form_login' action="validate.php" method="post">
                            <div class="card-body p-6">
                                <div class="card-title">Basic Laboratory Information System</div>
                                <div class="form-group">
                                    <label class="form-label">
                                        <?php echo LangUtil::getGeneralTerm("USERNAME"); ?>
                                    </label>
                                    <input type="text" class="form-control" name="username" id="username" value="">
                                    <label class="error" for="username" id="username_error"><small>
                                            <font color="red">
                                                <?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?>
                                            </font>
                                        </small>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        <?php echo LangUtil::getGeneralTerm("PWD"); ?>
                                    </label>
                                    <input type="password" class="form-control" name="password" id="password" value="" onkeypress="javascript:capLock(event);" onkeydown="javascript:capLock(event);">
                                    <label class="error" for="password" id="password_error"><small>
                                            <font color="red">
                                                <?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?>
                                            </font>
                                        </small>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <div id="caps_lock_msg_div" style="display:none">
                                        <font color='red'><small>
                                                <?php echo LangUtil::getPageTerm("MSG_CAPSLOCK"); ?></small></font>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <?php
                                            if(isset($_REQUEST['to']))
                                            {
                                                # Previous session timed out
                                                echo "<div class='alert alert-danger' role='alert><span id='server_msg' class='error_string'>";
                                                echo LangUtil::getPageTerm("MSG_TIMED_OUT");
                                                echo "</span></div>";
                                            }
                                            else if(isset($_REQUEST['err']))
                                            {
                                                # Incorrect username/password
                                                echo "<div class='alert alert-danger' role='alert><span id='server_msg' class='error_string'>";
                                                echo LangUtil::getPageTerm("MSG_ERR_PWD");
                                                echo "</span></div>";
                                            }
                                            else if(isset($_REQUEST['errPR']))
                                            {
                                                # Incorrect username/password
                                                echo "<div class='alert alert-danger' role='alert><span id='server_msg' class='error_string'>";
                                                echo LangUtil::getPageTerm("MSG_ERR_PWDRST");
                                                echo "</span></div>";
                                            }
                                        ?>

                                </div>

                                <div class="form-footer">
                                    <button type="button" class="btn btn-primary btn-block" role="button" id="login_button" onclick="check_input_boxes()">
                                        <?php echo LangUtil::$generalTerms["CMD_LOGIN"]; ?></button>
                                </div>
                            </div>

                        </form>
                        <div class="text-center text-muted">
                            Did you forget your username or password?<br>
                            <a href="">Send a request to your local administrator</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php $script_elems->bindEnterToClick("#password", "#login_button"); ?>
