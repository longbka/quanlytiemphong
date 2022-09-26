<?php
    require_once('dbhelp.php');
    if (isset($_POST['id'])){
        $id = $_POST['id'];
        $sql='delete from comment where id='.$id;
        execute($sql);
    }
?>