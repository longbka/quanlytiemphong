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
require_once('changepwd.php');
require_once('comment.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Trang chủ</title>
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
  <div class="container-fluid">
    <div class="panel-group">
      <div class="panel panel-primary" style="width: 1335px;position:relative">
        <div class="panel-heading" style="padding:15px;position:relative">
          <img style="position:absolute;top:10px" width="50px" height="50px" src="https://upload.wikimedia.org/wikipedia/vi/thumb/b/ba/Logo_B%E1%BB%99_Y_t%E1%BA%BF.svg/313px-Logo_B%E1%BB%99_Y_t%E1%BA%BF.svg.png"/>
          <strong style="font-size: 30px; margin-left: 5%;"> QUẢN LÝ THÔNG TIN NGƯỜI TIÊM VẮC-XIN COVID-19 </strong>
          <div id="menu">
            <p class="menu-user">Tài khoản<i class="iconUser glyphicon glyphicon-chevron-down"></i></p>
            <ul class="sub-menu" >   
              <li><a class="menu-log-out" onclick="window.open('logout.php','_self')">
              <i class="iconLogOut glyphicon glyphicon-log-out"></i>Đăng xuất</a></li>
              <li><a class="menu-change-password js-btn-cpwd">
              <i class="iconCpwd glyphicon glyphicon-cog"></i>Đổi mật khẩu</a></li>
              <li><a class="menu-register-vaccination" href="https://tokhaiyte.vn">
              <i class="iconRegister glyphicon glyphicon-list-alt"></i>Đăng ký tiêm vắc xin</a></li>
              <?php
              if($data[0]['role_id']==0){
                echo'<li><a class="menu-comment js-btn-comment">
              <i class="iconComment glyphicon glyphicon-envelope"></i>Đóng góp ý kiến</a></li>';
              }
              else{
                echo'<li><a class="menu-comment" href="commentEnvelope.php">
              <i class="iconComment glyphicon glyphicon-envelope"></i>Hòm thư góp ý</a></li>';
              }
              ?>
            </ul>
          </div>
      </div>
        <br>
        <div id="wrapper" style="margin: 5px">
          <form method="post">
            <div id="search" style="margin-left: 10px" class="addon-search" >
              <i class="glyphicon glyphicon-search"></i>
              <input type="text" name="txtsearch" placeholder="Nhập tên" style="width: 200px; padding-left:30px">
              <input type="submit" name="search" value="Tìm kiếm">
            </div>
          </form>
        </div>
        <p style="position:absolute; top:95px;right:3.5%;z-index:1">
          <?php    
            if ($data!=null&&$data[0]['role_id'] == 1) {
              echo '<button class="btn btn-primary" onclick=\'
                window.open("manageUser.php","_self")\'><strong>Quản lý tài khoản người dùng</strong></button>';
            }
          ?>
        </p>
        
        <!-- Hiển thị danh sách tìm kiếm  -->
        <?php
        if (isset($_POST['search'])) {
          $s = $_POST['txtsearch'];
          $s = str_replace('\'','\\\'',$s);
          if ($s == '') {
            header('Location: manage.php');
          }
          else {
            $sql = "SELECT * FROM vacxin_management WHERE HoTen LIKE '%$s%'";
            $result = executeResult($sql);
            $count = count($result);
            if ($result = !NULL && $count > 0) {
              echo '<p style="font-style:italic;margin-left:15px">Tìm thấy ' . $count . ' kết quả cho tìm kiếm này</p>';
        ?>
              <div class="panel-body">
                <table class="table table-bordered">
                <div style="text-align: center;"><h2 style="font-weight:bold">Danh sách tìm kiếm</h2></div>
                  <thead>
                    <tr>
                      <th style="text-align: center; font-size:15px; vertical-align: middle">Họ tên</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Tuổi</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Địa chỉ</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Email</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Giới Tính</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Ngày tiêm mũi 1</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Ngày tiêm mũi 2</th>
                    </tr>
                  </thead>
                  <tbody>
              <?php
              $sql = "SELECT * FROM vacxin_management WHERE HoTen LIKE'%$s%' order by HoTen";
              $result = executeResult($sql);
              for ($i = 1; $i <= count($result); $i++) {
                $date1=date("d-m-Y",strtotime($result[$i - 1]['NgayTiemMui1']));
                $date2=date("d-m-Y",strtotime($result[$i - 1]['NgayTiemMui2']));
                if ($date1=='30-11--0001'){
                  $date1='Không xác định';
                }
                if($date2=='30-11--0001'){
                  $date2='Không xác định';
                }
                echo  '<tr>
            <td style="text-align:center;  font-size:15px">' . $result[$i - 1]['HoTen'] . '</td>
            <td style="text-align:center;  font-size:15px">' . $result[$i - 1]['Tuoi'] . '</td>
            <td style="text-align:center;  font-size:15px">' . $result[$i - 1]['DiaChi'] . '</td>
            <td style="text-align:center;  font-size:15px">' . $result[$i - 1]['Email'] . '</td>
            <td style="text-align:center;  font-size:15px">' . $result[$i - 1]['GioiTinh'] . '</td>
            <td style="text-align:center;  font-size:15px">' . $date1 . '</td>
            <td style="text-align:center;  font-size:15px">' . $date2 . '</td>';
              }
            } else {
              echo '<p style="font-style:italic;margin-left:15px">Không tìm thấy kết quả nào cho tìm kiếm này</p>';
            }
          }
        }
        
              ?>
              <div class="panel-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align: center; font-size:15px; vertical-align:middle;">STT</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Họ tên</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Tuổi</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Địa chỉ</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Email</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Giới Tính</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Ngày tiêm mũi 1</th>
                      <th style="text-align: center; font-size:15px; vertical-align:middle">Ngày tiêm mũi 2</th>
                      <th colspan="3" style="text-align: center; vertical-align: middle">
                      <?php    
                        if ($data!=null&&$data[0]['role_id'] == 1) {
                        echo '<button class="btn btn-link" onclick=\'
                        window.open("input.php","_self")\'><strong>Thêm mới người tiêm</strong></button>';
                        }
                      ?>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <br>
                    <div style="text-align: center; margin-bottom:40px"><h2 style="font-weight:bold">Danh sách người tiêm vắc xin</h2></div>
                    <?php
                    $sql= "SELECT * FROM vacxin_management ORDER BY HoTen";
                    $peopleList = executeResult($sql);
                    for ($i = 1; $i <= count($peopleList); $i++) {
                      $date1=date("d-m-Y",strtotime($peopleList[$i - 1]['NgayTiemMui1']));
                      $date2=date("d-m-Y",strtotime($peopleList[$i - 1]['NgayTiemMui2']));
                      if ($date1=='30-11--0001'){
                        $date1='Không xác định';
                      }
                      if($date2=='30-11--0001'){
                        $date2='Không xác định';
                      }
                      echo  '<tr>
            <td style="text-align:center; font-size:15px; vertical-align: middle">' . $i . '</td>
            <td style="text-align:center; font-size:15px; vertical-align: middle">' . $peopleList[$i - 1]['HoTen'] . '</td>
            <td style="text-align:center; font-size:15px; vertical-align: middle">' . $peopleList[$i - 1]['Tuoi'] . '</td>
            <td style="text-align:center; font-size:15px; vertical-align: middle">' . $peopleList[$i - 1]['DiaChi'] . '</td>
            <td style="text-align:center; font-size:15px; vertical-align: middle">' . $peopleList[$i - 1]['Email'] . '</td>
            <td style="text-align:center; font-size:15px; vertical-align: middle">' . $peopleList[$i - 1]['GioiTinh'] . '</td>
            <td style="text-align:center; font-size:15px; vertical-align: middle">' . $date1 . '</td>
            <td style="text-align:center; font-size:15px; vertical-align: middle">' . $date2 . '</td>';
                      if ($data!=null&&$data[0]['role_id'] == 1) {

                        echo '<td width="60px"><button class ="btn btn-link"  
                         onclick = \'window.open("input.php?id=' . $peopleList[$i - 1]['id'] . '","_self")\'>
                         <strong>Sửa</strong></button></td><td width="60px">
                        <button class ="btn btn-link" onclick="deletePeople(' . $peopleList[$i - 1]['id'] . ')">
                        <strong>Xóa</strong></button></td>
                        <td width="60px"><button class ="btn btn-link" 
                        onclick=\'window.open("information.php?id=' . $peopleList[$i - 1]['id'] . '","_self")\'>
                        <strong>Xem chi tiết</strong></button></td></tr>';
                      }
                      else{ echo '<td width="60px"><button class ="btn btn-link" 
                        onclick=\'window.open("information.php?id=' . $peopleList[$i - 1]['id'] . '","_self")\'>
                        <strong>Xem chi tiết</strong></button></td></tr>';
                      }
                    }
                    ?>
                  </tbody>
                </table>
                </div>
            </div>
      </div>
    </div>
  </div>
  <!-- Giao diện đổi mật khẩu -->
  <div class="cpwd js-cpwd">
        <div class="cpwd-container js-cpwd-container">
            <div class="cpwd-close  js-cpwd-close">
                <i class="ti-close"></i>
            </div>
            <header class="cpwd-header">
                <i class="ti-bag cpwd-heading-bag"></i> Đổi mật khẩu
            </header>

            <div class="cpwd-body">
            <form action="" method="post"> 
              <label for="cpwd-old" class="cpwd-label">
                <i class="ti-key"></i>
                 Mật khẩu cũ
              </label>
              <input required ="true" id="cpwd-old" type="password" class="cpwd-input" name="oldPwd"
              <?php
                  if ($data[0]['role_id']==0){
                    echo 'minlength="6"'; 
                  }
              ?>>
              <label for="cpwd-new" class="cpwd-label">
                <i class="ti-lock"></i>
                  Mật khẩu mới
              </label>
              <input required ="true" id="cpwd-new" type="password" class="cpwd-input" name="newPwd"
              <?php
                  if ($data[0]['role_id']==0){
                    echo 'minlength="6"'; 
                  }
              ?>>
              <button id="cpwd-confirm" type="submit">
                  Xác nhận <i class="ti-check"></i>
              </button>
            </form>      
              </div>
            <footer class="cpwd-footer">
                <p class="cpwd-help">
                    Need <a href="">help?</a>
                </p>
            </footer>
        </div>

  </div>

 <!-- Giao diện góp ý -->
 <div class="comment js-comment">
    <div class="comment-container js-comment-container">
        <div class="comment-close  js-comment-close">
            <i class="ti-close"></i>
        </div>
        <header class="comment-header">
            <i class="ti-pencil comment-heading-bag"></i> Góp ý
        </header>

        <div class="comment-body">
        <form action="" method="post"> 
          <label for="name" class="comment-label">
            <i class="ti-user"></i>
             Họ và tên
          </label>
          <input required ="true" type="text" class="comment-input" name="fullName">
          <label for="email" class="comment-label">
            <i class="ti-email"></i>
             Email
          </label>
          <input required ="true" type="email" class="comment-input" name="email">
          <label for="phone" class="comment-label">
            <i class="ti-mobile"></i>
             Số điện thoại
          </label>
          <input required ="true" type="text" class="comment-input" name="phone">
          <label for="commentPassage" class="comment-label">
            <i class="ti-email"></i>
             Ý kiến
          </label>
          <input required ="true" type="text" class="comment-input" name="commentPassage">
          <button id="comment-confirm" type="submit">
              Gửi <i class="ti-check"></i>
          </button>
        </form>      
          </div>
        <footer class="comment-footer">
            <p class="comment-help">
                Need <a href="">help?</a>
            </p>
        </footer>
    </div>

</div>

  <!-- Js xóa người tiêm -->
  <script type="text/javascript">
    function deletePeople(id) {
      option = confirm('Bạn có chắc chắn muốn xóa tài khoản này không?');
      if (!option) return;
      $.post('delete.php', {
        'id': id
      }, function(data) {
        alert('Xoa thanh cong');
        location.reload();
      })
    }
  </script>

  <!-- Js đổi mật khẩu -->
  <script >
    const btnCpwd = document.querySelector('.js-btn-cpwd');
    const cpwd = document.querySelector('.js-cpwd');
    const cpwdClose = document.querySelector('.js-cpwd-close');
    const cpwdContainer = document.querySelector('.js-cpwd-container');
    btnCpwd.addEventListener('click',showChangePwd);
    cpwdClose.addEventListener('click',hideChangePwd);
    // Hàm hiển thị giao diện đổi mật khẩu
    function showChangePwd(){
      cpwd.classList.add('open');
    }
    // Hàm ẩn giao diện đổi mật khẩu
    function hideChangePwd(){
      cpwd.classList.remove('open');
    }
    cpwd.addEventListener('click',hideChangePwd);
    cpwdContainer.addEventListener('click',function(event){
      event.stopPropagation();
    })
  </script>

  <!-- Js đóng góp ý kiến -->
  <script>
    const btnComment = document.querySelector('.js-btn-comment');
    const comment = document.querySelector('.js-comment');
    const commentClose = document.querySelector('.js-comment-close');
    const commentContainer = document.querySelector('.js-comment-container');
    btnComment.addEventListener('click',showComment);
    commentClose.addEventListener('click',hideComment);
    // Hàm hiển thị giao diện đổi mật khẩu
    function showComment(){
      comment.classList.add('open');
    }
    // Hàm ẩn giao diện đổi mật khẩu
    function hideComment(){
      comment.classList.remove('open');
    }
    comment.addEventListener('click',hideComment);
    commentContainer.addEventListener('click',function(event){
      event.stopPropagation();
    })
  </script>

</body>

</html>