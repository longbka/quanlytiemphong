<?php
    session_start();
    session_destroy();
    setcookie('token','false',time()-100,'/');
    header("Location: index.php");