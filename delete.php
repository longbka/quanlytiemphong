<?php
require_once('dbhelp.php');
if (isset($_POST['id'])){
    $id = $_POST['id'];
    $sql='delete from vacxin_management where id='.$id;
    execute($sql);
    if(file_exists("img/$id.png")){
        unlink("img/$id.png");
    }
}
?>