<?php
require_once('dbhelp.php');
require_once("login_function.php");
login();
$user=validateToken();
if(isset($user)){
    header('Location: manage.php');
    die();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Đăng nhập</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="https://e7.pngegg.com/pngimages/10/325/png-clipart-world-health-organization-computer-icons-business-organization-emblem-logo.png"/> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="heading-login">
        <h1 style="text-align: center">QUẢN LÝ NGƯỜI TIÊM VẮC XIN</h1>
        <img alt="" src="https://tiemchungcovid19.gov.vn/assets/portal/img/logoboyte.png"
    style="display:block;width:120px; height:120px;margin:0 auto">
    </div>
    <div class="container mobile-full-width">
        <form method="POST" class="form-login mobile-full-width">
            <div class="form-login__user form-group addon-user mobile-full-width">
                <label for="user">Tài khoản</label>
                <i class="firstGly glyphicon glyphicon-user"></i>     
                <input type="text" class="form-login__user-input form-control mobile-full-width" name="username">
            </div>
            <div class="form-login__password form-group addon-password mobile-full-width">
                <label for="pwd">Mật khẩu</label>
                <i class="firstGly glyphicon glyphicon-lock"></i>   
                <i id="glyphiconType" onclick = "hidePassword()" class ="glyphicon glyphicon-eye-close"></i>
                <input id="pwdFormat" type="password" class="form-login__password-input form-control mobile-full-width" name="password" >
            </div>
            <button type="submit" class="form-login__btn btn btn-primary mobile-full-width" >Đăng nhập</button>    
            <p style="display:block;text-decoration: underline;width:140px;margin:10px auto">
                    <a href="register.php" >Đăng ký tài khoản mới</a>
            </p>
        </form>
    </div>
    <script type="text/javascript">
        var check = true;
        function hidePassword(){
            if(check){
                document.getElementById('pwdFormat').type = "text";
                document.getElementById("glyphiconType").classList.remove('glyphicon-eye-close');
                document.getElementById("glyphiconType").classList.add('glyphicon-eye-open');
                check=false;
            }
            else{
                document.getElementById('pwdFormat').type = "password";
                document.getElementById("glyphiconType").classList.remove('glyphicon-eye-open');
                document.getElementById("glyphiconType").classList.add('glyphicon-eye-close');
                check=true;
            }
        }
    </script>
</body>
</html>
