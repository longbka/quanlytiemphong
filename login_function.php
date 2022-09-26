<?php
function login()
{
    if(!empty($_POST))
    {
        $username = $_POST['username'];
        $password=$_POST['password'];
        $username = str_replace('\'','\\\'',$username);
        $password = str_replace('\'','\\\'',$password);
        require_once("dbhelp.php");
        //thuc hien truy van du lieu
        $query="SELECT * FROM login_management WHERE Ten_TKhoan= '".$username."'
         AND MatKhau = '".$password."' ";    
        $data= executeResult($query);
        if($data!=null&&count($data)>0){
            $token=md5(time().$data[0]['email']);
            setcookie('token',"$token",time()+60*60,'/');
            $sql="update login_management set token='$token' where ID= ".$data[0]['ID'];
            execute($sql);
            header("Location: manage.php");
       }
        else if ($data==null&&count($data)==0){
            echo '<script language="javascript">';
            echo 'alert("Sai ten dang nhap hoac mat khau")';
            echo '</script>';
        }
    }
}

