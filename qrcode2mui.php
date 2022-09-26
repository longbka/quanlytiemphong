<?php
    require_once 'phpqrcode/qrlib.php';

    $path='img/';
    $file=$path.$id.".png";
    $text="$fullname|$email|Mũi 1:$loaimui1|Mũi 2:$loaimui2";
    if(file_exists("img/$id.png")){
        unlink("img/$id.png");
        QRcode::png($text,$file,'L',6,2);
        echo "<img src='".$file."'>";
    }
    else{
        QRcode::png($text,$file,'L',6,2);
        echo "<img src='".$file."'>";
    }
?>