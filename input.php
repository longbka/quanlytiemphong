<?php
    require_once('dbhelp.php');
    $token = '';
    $data='';
    $msg='';
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
    $id=$id_post=$fullname=$age=$address=$email=$phone_number=$mui1=$mui2=$loaimui1=$loaimui2=$sex="";
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql="select * from vacxin_management where id='".$id."'";
        $peopleList = executeResult($sql);
        if($peopleList!=null && count($peopleList)>0)
        {
            $person = $peopleList[0];
            $id_post = $person['ID_NguoiTiem'];
            $fullname=$person['HoTen'];
            $age=$person['Tuoi'];
            $address=$person['DiaChi'];
            $email=$person['Email'];
            $sex=$person['GioiTinh'];
            $phone_number = $person['SoDT'];
            $mui1=$person['NgayTiemMui1'];
            $mui2=$person['NgayTiemMui2'];
            $loaimui1=$person['LoaiVaccine1'];
            $loaimui2=$person['LoaiVaccine2'];
        }
        else{
            $id='';
        }
    }
    if(!empty($_POST))
    {
        if(isset($_POST['sex']))
        {
            $sex=$_POST['sex'];
        }

        if(isset($_POST['id']))
        {
            $id_post=$_POST['id'];
        }

        if(isset($_POST['fullname'])){
            $fullname=$_POST['fullname'];
        }

        if(isset($_POST['age'])){
            $age=$_POST['age'];
        }

        if(isset($_POST['address'])){
            $address=$_POST['address'];
        }

        if(isset($_POST['email'])){
            $email=$_POST['email'];
        } 

        if(isset($_POST['phone_number'])){
            $phone_number=$_POST['phone_number'];
        }

        if(isset($_POST['mui1'])){
            $mui1=$_POST['mui1'];
        }

        if(isset($_POST['mui2'])){
            $mui2=$_POST['mui2'];
        }

        if(isset($_POST['loaimui1'])){
            $loaimui1=$_POST['loaimui1'];
        }

        if(isset($_POST['loaimui2'])){
            $loaimui2=$_POST['loaimui2'];
        }
        $fullname = str_replace('\'','\\\'',$fullname);
        $age = str_replace('\'','\\\'',$age);
        $email = str_replace('\'','\\\'',$email);
        $address = str_replace('\'','\\\'',$address);
        $phone_number = str_replace('\'','\\\'',$phone_number);
        $loaimui1 = str_replace('\'','\\\'',$loaimui1);
        $loaimui2 = str_replace('\'','\\\'',$loaimui2);
        
        // MYSQL
        /*if($id!='')
        {
            $sql="update vacxin_management set ID_NguoiTiem='$id_post', HOTEN='$fullname', Tuoi='$age', GioiTinh='$sex',
            DIACHI='$address', EMAIL='$email', SoDT='$phone_number', NgayTiemMui1='$mui1', NgayTiemMui2='$mui2',
            LoaiVaccine1='$loaimui1', LoaiVaccine2='$loaimui2' where id='".$id."'";
        }
        else {
        $sql="insert into vacxin_management(ID_NguoiTiem,HOTEN,Tuoi,DIACHI,GioiTinh,EMAIL,SoDT,NgayTiemMui1,NgayTiemMui2,
        LoaiVaccine1,LoaiVaccine2) VALUES 
        ('$id_post','$fullname','$age','$address','$sex','$email','$phone_number','$mui1','$mui2','$loaimui1','$loaimui2')";
        }*/

        //SQLSERVER
        if($id!='')
        {
            $sql="update vacxin_management set ID_NguoiTiem='$id_post', HoTen='$fullname', Tuoi='$age', GioiTinh='$sex',
            DiaChi='$address', Email='$email', SoDT='$phone_number', NgayTiemMui1='$mui1', NgayTiemMui2='$mui2',
            LoaiVaccine1='$loaimui1', LoaiVaccine2='$loaimui2' where id='".$id."'";
            execute($sql);
            header("Location: manage.php");
            die();
        }
        else {
            $sql = "select * from vacxin_management where ID_NguoiTiem ='$id_post'";
            $idExist = executeResult($sql);
            $sql = "select * from vacxin_management where Email ='$email'";
            $emailExist = executeResult($sql);
            $sql = "select * from vacxin_management where SoDT ='$phone_number'";
            $phoneExist = executeResult($sql);
            if($idExist!=null){
                $msg="CCCD/CMND này đã tồn tại";
            }
            else if($emailExist!=null){
                $msg="Email này đã được đăng ký";
            }
            else if($phoneExist!=null){
                $msg="Số điện thoại này đã được đăng ký";
            }
            else{
                $sql="insert into vacxin_management(ID_NguoiTiem,HoTen,Tuoi,DiaChi,GioiTinh,Email,SoDT,NgayTiemMui1,NgayTiemMui2,
                LoaiVaccine1,LoaiVaccine2) VALUES 
                ('$id_post','$fullname','$age','$address','$sex','$email','$phone_number','$mui1','$mui2','$loaimui1','$loaimui2')";
                execute($sql);
                header("Location: manage.php");
                die();
            }
        }
    }
    
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        <?php
        if(isset($_GET['id']))
        {
            echo 'Sửa thông tin';
        }
        else{
            echo 'Thêm người tiêm';
        }
        ?>
    </title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="https://e7.pngegg.com/pngimages/10/325/png-clipart-world-health-organization-computer-icons-business-organization-emblem-logo.png"/> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div style="margin-top:25px">
    <?php
    if(isset($_GET['id']))
    {
        echo '<center><h1 class ="bold">SỬA THÔNG TIN</h1></center>';
    }
    else{
        echo '<center><h1>THÊM VÀO DANH SÁCH</h1></center>';
    }
    ?>
    <h5 style='color:red' class="text-center"><strong><?= $msg ?></strong></h5>
    </div>
    <br>
    <div class="container" style="margin-left:auto;margin-right:auto; width:65%">
        <form method="POST" action="">
            <div class="form-group">
                <label for="fullname"><strong>Họ tên</strong></label>
                <input required="true" type="text" style="color:black" class="form-control" name="fullname" 
                placeholder="Ex: Nguyễn Văn A" 
                <?php if(isset($_GET['id'])) echo 'value="'.$fullname.'"'?>>
            </div>
            <div class="form-group">
                <label for="id"><strong>CCCD/CMND</strong></label>
                <input required="true" type="text" style="color:black" class="form-control" name="id"
                <?php if(isset($_GET['id'])) echo 'value="'.$id_post.'"'?>>
            </div>
            <div class="form-group">
                <label for="age"><strong>Tuổi</strong></label>
                <input required="true"  type="number" style="color:black" class="form-control" name="age"
                 placeholder="Example: 19"
                <?php if(isset($_GET['id'])) echo 'value="'.$age.'"'?>>
            </div> 
            <div class="form-group">
                <label for="address"><strong>Địa chỉ</strong></label>
                <input required="true"  type="text" style="color:black" class="form-control" name="address"
                 placeholder="Example: Hà nội" 
                 <?php if(isset($_GET['id'])) echo 'value="'.$address.'"'?>>
            </div>
            <div class="form-group">
                <label for="email"><strong>Email</strong></label>
                <input required="true"  type="email" style="color:black" class="form-control" name="email" 
                placeholder="aaa@gmail.com" 
                <?php if(isset($_GET['id'])) echo 'value="'.$email.'"'?>>
            </div>
            <div class="form-group">
                <label for="phone_number"><strong>Số điện thoại</strong></label>
                <input required="true"  type="tel" style="color:black" class="form-control"  name="phone_number"
                placeholder="09xxxxxxxx"
                <?php if(isset($_GET['id'])) echo 'value="'.$phone_number.'"'?>>
            </div>
            <div class="form-group">
                <label for="sex"><strong>Giới tính</strong></label>
                <select class="form-control" name="sex" id="sex" >
                <option hidden>----Chọn----</option>
                <?php
                if(isset($_GET['id'])){
                    
                    if($sex=="Nam"){
                        echo '<option selected value="'.$sex.'">'.$sex.'</option>';
                        echo '<option value= "Nữ"> Nữ </option>';
                        echo '<option value= "Khác"> Khác </option>' ;
                    }
                    else if($sex=="Nữ"){
                        echo  '<option value= "Nam"> Nam </option>';
                        echo '<option selected value="'.$sex.'">'.$sex.'</option>';
                        echo '<option value= "Khác"> Khác </option>'; 
                    } 
                    else{
                        echo '<option value= "Nam"> Nam </option>';
                        echo '<option value= "Nữ"> Nữ </option>'; 
                        echo '<option selected value="'.$sex.'">'.$sex.'</option>';
                    }
                }
                else{
                echo '<option value= "Nam"> Nam </option>';
                echo '<option value= "Nữ"> Nữ </option>' ; 
                echo '<option value= "Khác"> Khác </option>' ; 
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label for="mui1"><strong>Ngày tiêm mũi 1</strong></label>
                <input type="date" style="color:black" class="form-control" name="mui1"
                style="width: 700px;padding-left:30px"
                <?php
                if(isset($_GET['id'])){ 
                    $date1 = $mui1;
                    echo 'value="'.$date1.'"';
                } ?>>
            </div>
            <div class="form-group">
                <label for="mui2"><strong>Ngày tiêm mũi 2</strong></label>
                <input type="date" style="color:black" class="form-control" name="mui2"
                style="width: 700px;padding-left:30px"
                <?php
                if(isset($_GET['id'])) 
                {
                    $date2 = $mui2;
                    echo 'value="'.$date2.'"';
                }?>>
            </div> 
            <div class="form-group">
                <label for="loaimui1"><strong>Loại Vaccine mũi 1</strong></label>
                <input type="text" style="color:black" class="form-control" name="loaimui1"
                style="width: 700px;padding-left:30px"
                <?php if(isset($_GET['id'])) echo 'value="'.$loaimui1.'"'?>>
            </div> 
            <div class="form-group">
                <label for="loaimui2"><strong>Loại Vaccine mũi 2</strong></label>
                <input type="text" style="color:black" class="form-control" name="loaimui2"
                style="width: 700px;padding-left:30px"
                <?php if(isset($_GET['id'])) echo 'value="'.$loaimui2.'"'?>>
            </div>
            <div class="form-input__btn">
                <button type="submit" class="btn btn-primary">Lưu lại</button>
                <a class="btn btn-danger" href="manage.php">Quay lại</a>
            </div> 
            <br><br>
        </form>
    </div>
</body>

</html>