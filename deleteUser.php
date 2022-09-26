<?php
require_once('dbhelp.php');
if (isset($_POST['id'])){
    $id = $_POST['id'];
    $sql='delete from login_management where ID='.$id;
    execute($sql);
}
?>