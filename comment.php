<?php
if(isset($_COOKIE['token'])){
  if(isset($_POST['commentPassage'])){
    $fullName=$_POST['fullName'];
    $email =$_POST['email'];
    $comment=$_POST['commentPassage'];
    $phone =$_POST['phone'];
    $sql =  "select * from login_management where token = '$token'";
    $data  = executeResult($sql);
    $userID = $data[0]['ID'];
    $sql="insert into comment(Comment,HoTen,UserID,Email) VALUES 
    ('$comment','$fullName','$userID','$email')";
    execute($sql);
    header('Location: loadPage.html');
  }
}