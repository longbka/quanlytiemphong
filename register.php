<?php
require_once("dbhelp.php");
$username = $password = $msg = '';
if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $email =$_POST['email'];
    $fullName =$_POST['fullName'];
    if (empty($username) || empty($password) || strlen($password) < 6) {
    } else {
        $sql = "select * from login_management where Ten_TKhoan ='$username'";
        $userExist = executeResult($sql);
        $sql = "select * from login_management where Email ='$email'";
        $emailExist = executeResult($sql);
        $sql = "select * from login_management where SoDT ='$phone'";
        $phoneExist = executeResult($sql);
        if ($userExist != null) {
            $msg = 'Tài khoản đã tồn tại, nhập vào tài khoản khác';

        }
        else if($emailExist!=null){
            $msg = 'Email đã tồn tại';
        }
        else if($phoneExist!=null){
            $msg = 'Số điện thoại này đã được đăng ký';
        }
        else {
            $username = $_POST['username'];
            $password = $_POST['password'];
            //thuc hien truy van du lieu - insert data vao database
            $query = "INSERT INTO login_management(Ten_TKhoan,MatKhau,role_id,Email,SoDT,HoTen) 
            VALUES ('" . $username . "','" . $password . "',0,'".$email."','".$phone."','".$fullName."')";
            execute($query);
            echo '<script type="text/javascript">';
            echo 'Đăng ký tài khoản thành công';
            echo '</script>';
            header('location: index.php');
            die();
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Đăng ký</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="https://e7.pngegg.com/pngimages/10/325/png-clipart-world-health-organization-computer-icons-business-organization-emblem-logo.png"/> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <center>
        <h1>Đăng ký tài khoản</h1>
        <h5 style='color:red' class="text-center"><strong><?= $msg ?></strong></h5>
    </center>
    <img alt="" src="https://tiemchungcovid19.gov.vn/assets/portal/img/logoboyte.png"
    style="display:block;width:120px; height:120px;margin:0px auto">
    <div class="container mobile-full-width">
        <form method="POST" action="" onsubmit="return validateForm()">
            <div class="form-register__fullName form-group addon-name mobile-full-width">
                <label for="fullName">Họ tên</label>
                <i  class="firstGly glyphicon glyphicon-info-sign"></i>   
                <input required="true" type="text" class="form-register__input form-control mobile-full-width" id="fullName" name="fullName">
            </div>
            <div class="form-group addon-email">
                <label for="email">Email</label>
                <i  class="firstGly glyphicon glyphicon-envelope"></i>   
                <input required="true" type="text" class="form-register__input form-control mobile-full-width" id="email" name="email">
            </div>
            <div class="form-group addon-phone">
                <label for="phone">Số điện thoại</label>
                <i  class="firstGly glyphicon glyphicon-phone"></i>   
                <input required="true" type="text" class="form-register__input form-control mobile-full-width" id="phone" name="phone">
            </div>
            <div class="form-group addon-user">
                <label for="username">Tài khoản</label>
                <i  class="firstGly glyphicon glyphicon-user"></i>     
                <input required="true" type="text" id='username' class="form-register__input form-control mobile-full-width" name="username">
            </div>
            <div class="form-group addon-password">
                <label for="pwd">Mật khẩu</label>
                <i  class="firstGly glyphicon glyphicon-lock"></i>   
                <input required="true" type="password" class="form-register__input form-control mobile-full-width" id="pwd" name=" password" minlength="6">
            </div>
            <div class="form-group addon-password">
                <label for="confirmation_pwd">Nhập lại mật khẩu</label>
                <i  class="firstGly glyphicon glyphicon-ok-sign"></i>   
                <input required="true" type="password" class="form-register__input form-control mobile-full-width" id="confirmation_pwd" name="confirmation_pwd" minlength="6">
            </div>
            <button type="submit" class="form-register__btn btn btn-success mobile-full-width">Đăng ký</button>
            <p style="display:block;text-decoration: underline;width:118.3px;margin:10px auto">
                <a href="index.php" >Tôi đã có tài khoản</a>
            </p>
            </form>
    </div>
    <script type="text/javascript">
        function validateForm() {
            $pwd = $('#pwd').val();
            $confirmPwd = $('#confirmation_pwd').val();
            if ($pwd != $confirmPwd) {
                alert("Mật khẩu không khớp, vui lòng nhập lại");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>