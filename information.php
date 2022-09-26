<?php
    require_once('dbhelp.php');
    $token = '';
    $data='';
    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];
        $sql   = "select * from login_management where token = '$token'";
        $data  = executeResult($sql);
        if ($data == null && count($data) <= 0) {
            header('Location: index.php');
            die();
        }
    }
    else {
        header('Location: index.php');
        die();
    }
    $loaimui1=$loaimui2=$fullname=$address=$sex=$email=$phone_number=$id_cccd=$mui1=$mui2='';
    $id=$_GET['id'];
    $sql="select * from vacxin_management where id='".$id."'";
    $data=executeResult($sql);
    if(isset($_GET['id'])){
        $person=$data[0];
        $fullname=$person['HoTen'];
        $address=$person['DiaChi'];
        $sex=$person['GioiTinh'];
        $email=$person['Email'];
        $phone_number=$person['SoDT'];
        $id_cccd=$person['ID_NguoiTiem'];
        $loaimui1=$person['LoaiVaccine1'];
        $loaimui2=$person['LoaiVaccine2'];
        $mui1=$person['NgayTiemMui1'];
        $mui2=$person['NgayTiemMui2'];
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thông tin chi tiết</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="https://e7.pngegg.com/pngimages/10/325/png-clipart-world-health-organization-computer-icons-business-organization-emblem-logo.png"/> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styleif.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body style = "<?php
if($loaimui1!=''&&$loaimui2!=''){
    echo "background-color: #009900";
}
else if($loaimui1==''&&$loaimui2==''){
    echo "background-color: #B22222";
}
else {
    echo "background-color: #FFA500";
}
?>">
    <div class="container">
        <div class="main-body">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a style="color:white" href="manage.php"><strong>Quay lại</strong></a></li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img 
                                <?php
                                if($sex=="Nam")
                                {
                                echo 'src="https://bootdey.com/img/Content/avatar/avatar7.png"';
                                } 
                                else if($sex=="Nữ"){
                                    echo 'src="https://bootdey.com/app/webroot/img/Content/avatar/avatar8.png"';
                                }
                                else{
                                    echo 'src="https://kenh14cdn.com/thumb_w/600/uBQNqcWy759hasJndzwjfkFyAeoKLM/Image/2015/06/150627tektut1-42778.png"';
                                }
                                ?>
                                alt="Avatar" class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4><?=$fullname?></h4>
                                    <p class="text-secondary mb-1">Việt Nam</p>
                                    <p class="text-muted font-size-sm"><?=$address?></p>
                                    <?php
                                    if($loaimui1!=''&&$loaimui2!=''){
                                        echo '<h5><strong>Chứng nhận tiêm 2 mũi</strong></h5>';
                                        require_once('qrcode2mui.php');
                                    }
                                    else if($loaimui1==''&&$loaimui2==''){
                                        echo '<h5><strong>Chưa tiêm mũi nào</strong></h5>';
                                    }
                                    else{
                                        echo '<h5><strong>Tiêm 1 mũi</strong></h5>';
                                        require_once('qrcode2mui.php');
                                    }
                                    ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Họ tên đầy đủ</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?=$fullname?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?=$email?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Số điện thoại</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php
                                    $sql="select * from login_management where token = '". $_COOKIE['token']."'";
                                    $person_login=executeResult($sql);
                                    if($person_login[0]['role_id']=="1"){
                                        echo "$phone_number";
                                    }
                                    else{
                                        echo substr($phone_number, 0, -3)."***";
                                    }
                                    ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Địa chỉ</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?=$address?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">CCCD/CMND</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php
                                    $sql="select * from login_management where token = '". $_COOKIE['token']."'";
                                    $person_login=executeResult($sql);
                                    if($person_login[0]['role_id']=="1"){
                                        echo "$id_cccd";
                                    }
                                    else{
                                        echo "***********";
                                    }
                                    ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Ngày tiêm thứ nhất</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php
                                    $date1 =date("d-m-Y",strtotime($mui1));
                                    if($date1=='30-11--0001'){
                                        $date1='Không xác định';
                                    }
                                    echo "$date1"?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Loại Vaccine</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?=$loaimui1?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Ngày tiêm thứ hai</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php
                                    $date2 =date("d-m-Y",strtotime($mui2));
                                    if($date2=='30-11--0001'){
                                        $date2='Không xác định';
                                    }
                                    echo "$date2"
                                    ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Loại Vaccine</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?=$loaimui2?>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>