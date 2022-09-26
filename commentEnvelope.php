<?php
   require_once('dbhelp.php');
   $token = '';
   $data='';
   if (isset($_COOKIE['token'])) {
     $token = $_COOKIE['token'];
     $sql   = "select * from login_management where token = '$token'";
     $data  = executeResult($sql);
     if ($data == null && count($data) <= 0 || $data[0]['role_id']==0) {
       header('Location: index.php');
       die();
     }
   }
   else {
     header('Location: index.php');
     die();
   }
?>
<!DOCTYPE html>
<html>

<head>
  <title>Quản lý tài khoản người dùng</title>
  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="https://e7.pngegg.com/pngimages/10/325/png-clipart-world-health-organization-computer-icons-business-organization-emblem-logo.png"/> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="./theme_icon/themify-icons/themify-icons.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container-fluid" style="width: 1365px">
    <div class="panel-group">
      <div class="panel panel-primary" style="width: 1335px">
        <div class="panel-heading" style="padding:15px;position:relative">
            <img style="position:absolute;top:10px" width="50px" height="50px" src="https://upload.wikimedia.org/wikipedia/vi/thumb/b/ba/Logo_B%E1%BB%99_Y_t%E1%BA%BF.svg/313px-Logo_B%E1%BB%99_Y_t%E1%BA%BF.svg.png"/>
            <strong style="font-size: 30px; margin-left: 5%;"> HÒM THƯ GÓP Ý </strong>
            <div class="turnBack"><a href="manage.php">Quay lại</a></div>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th style="text-align: center; font-size:15px; vertical-align:middle;">STT</th>
                    <th style="text-align: center; font-size:15px; vertical-align:middle">Tên người dùng</th>
                    <th style="text-align: center; font-size:15px; vertical-align:middle">Email</th>
                    <th style="text-align: center; font-size:15px; vertical-align:middle">Ý kiến</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql= "SELECT * FROM comment ORDER BY HoTen";
                    execute($sql);
                    $cmtList = executeResult($sql);
                    for ($i = 1; $i <= count($cmtList); $i++) {
                        echo  '<tr>
                <td style="text-align:center; font-size:15px; vertical-align: middle">' . $i . '</td>
                <td style="text-align:center; font-size:15px; vertical-align: middle">' . $cmtList[$i - 1]['HoTen'] . '</td>
                <td style="text-align:center; font-size:15px; vertical-align: middle">' . $cmtList[$i - 1]['Email'] . '</td>
                <td style="text-align:center; font-size:15px; vertical-align: middle">' . $cmtList[$i - 1]['Comment'] . '</td>
                <td style = "text-align:center; vertical-align: middle">
                <button class ="btn btn-link" onclick="deleteCmt(' . $cmtList[$i - 1]['ID'] . ')">        
                 <strong>Xóa</strong></button></td>
                </tr>';
                  }?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Js xóa user -->
  <script type="text/javascript">
    function deleteCmt(id) {
      option = confirm('Bạn có chắc chắn muốn xóa bình luận này không?');
      if (!option) return;
      $.post('deleteCmt.php', {
        'id': id
      }, function(data) {
        alert('Xoa thanh cong');
        location.reload();
      })
    }
  </script>
</body>
</html>