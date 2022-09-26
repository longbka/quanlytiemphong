<?php
if(isset($_COOKIE['token'])){
  if(isset($_POST['oldPwd'])&&isset($_POST['newPwd'])){
    $token=$_COOKIE['token'];
    $oldPwd=$_POST['oldPwd'];
    $newPwd=$_POST['newPwd'];
    $sql   = "select * from login_management where token = '$token'";
    $data  = executeResult($sql);
    if ($data != null && count($data) > 0 && $data[0]['MatKhau']==$oldPwd && $oldPwd!=$newPwd ) {
      $sql = "update login_management set MatKhau='$newPwd' where token='".$token."'";
      execute($sql);
      header('Location: loadPage.html');
    }
    else if($oldPwd==$newPwd){
      echo '<script language="javascript">';
      echo 'var do_alert = function(){
        alert("Mật khẩu cũ phải khác với mật khẩu mới");
      };
      setTimeout(do_alert, 100);';
      echo '</script>';
    }
    else{
      // echo '<script language="javascript">';
      // echo 'alert("Bạn đã nhập sai mật khẩu cũ vui lòng nhập lại")';
      // echo '</script>';
      echo '<script language="javascript">';
      echo 'var do_alert = function(){
        alert("Bạn đã nhập sai mật khẩu vui lòng nhập lại");
      };
      setTimeout(do_alert, 100);';
      echo '</script>';
    }
  }
}
?>