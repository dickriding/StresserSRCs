<?php ob_start();
session_start();

include("config.php");
include("config2.php");

$ayar = @mysqli_query($baglanti, "select * from ayarlar where id='1'");
$ayar = $ayar->fetch_assoc();

if (isset($_SESSION["id"])) {
    header("Location:index");
    exit;
}

if (@$_POST["kadi"] != Null && @$_POST["pass"] != Null) {
    $kadi = htmlentities($_POST["kadi"], ENT_QUOTES, "UTF-8");
    $pass = htmlentities($_POST["pass"], ENT_QUOTES, "UTF-8");
    $pass = md5($pass);
    $sql_check = @mysqli_query($baglanti, "select * from user where kadi='$kadi' and pass='$pass'");

    if (@mysqli_num_rows($sql_check)) {
        $sonuc = $sql_check->fetch_assoc();
        if ($sonuc["rank"] != "1" && $ayar["bakim"] == "1") {
            header("Location: maintenance");
            exit;
        }

        $ip = ipal();
        $tarih = date("Y-m-d H:i:s");
        $dataid = $sonuc["id"];
        $baglanti->query("UPDATE user SET son_ip='$ip',son_giris='$tarih' WHERE id='$dataid'");
        $_SESSION["login"] = "1";
        $_SESSION["id"] = $sonuc["id"];
        $_SESSION["rank"] = $sonuc["rank"];
        $baglanti->query("INSERT INTO login (user, tarih, ip) VALUES ('$dataid','$tarih', '$ip')");
        header("Location: index");
        exit;
    } else {
        header("Location: ?error=pass");

        exit;
    }
}

ob_end_flush();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <title><?php echo $ayar["ad"]; ?></title>

    <meta name="keywords" content="<?php echo $ayar["keyword"]; ?>">
    <meta name="description" content="<?php echo $ayar["description"]; ?>">

    <link rel="icon" type="image/x-icon" href="../favicon.png" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Saira&display=swap" rel="stylesheet">
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
    <link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">

    <script src="https://kit.fontawesome.com/b5170af4d1.js" crossorigin="anonymous"></script>

</head>

<body class="form">

    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <h1 class="">Login</h1>
                        <form class="text-left" method="post" action="">
                            <div class="form"></br>
                            
                                <?php if (@$_GET["error"] == "pass") {
                                    echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Username or password is incorrect, please try again.</div>';
                                }
                                if (@$_GET["process"] == "success") {

                                    echo '<div class="alert alert-outline-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>You have successfully registered, you can login.</div>';
                                } ?>

                                <div id="username-field" class="field-wrapper input">

                                    <label for="username">USERNAME</label>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>

                                    <input id="username" name="kadi" required type="text" class="form-control" placeholder="Username">
                                </div>



                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">PASSWORD</label>

                                    </div>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>

                                    <input id="password" name="pass" required type="password" class="form-control" placeholder="Password">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>

                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Log In</button>

                                    </div>
                                </div>

                                <p class="signup-link">Did you forget your password? <a href="recovery">Reset password</a></p>
                                <p class="signup-link" style="margin-top: 0px;">Don't have an account? <a href="register">Create Account</a></p>
                                <p class="signup-link" style="margin-top: 0px;"><i class="fab fa-telegram-plane" aria-hidden="true"></i><a href="https://t.me/stresser_gg"> Telegram</a></p>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <link rel="stylesheet" type="text/css" href="boostrap/css/boostrap.min.css">
    <style type="text/css">
        .alert-infoor {
            color: #d3d3d3;
            background-color: #1b2e4b;
            border-color: #287dff;
        }

        .alert-danger {
            color: #d3d3d3;
            background-color: #7c141d;
            border-color: #bf0011;
        }

        .alert-success {
            color: #d3d3d3;
            background-color: #00ad10;
            border-color: #00ed16;
        }

        .widget-table-three .table .td-content a {
            border-bottom: unset !important
        }
    </style>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->

    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <script src="assets/js/authentication/form-2.js"></script>

</body>
</html>