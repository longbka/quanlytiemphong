<?php
    require_once('config.php');
 /**
  * insert,update,delete
 */   
function execute($sql){
    //tao ket noi
    $conn= mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE);
    mysqli_set_charset($conn, 'UTF8');
    //truy van
    mysqli_query($conn,$sql);
    
    //dong ket noi
    mysqli_close($conn);
}
/**
 * su dung cho lenh select=> tra ve ket qua
 */
function executeResult($sql)
{
    //tao ket noi
    $conn= mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE);
    mysqli_set_charset($conn, 'UTF8');
    //truy van
    $resultset=mysqli_query($conn,$sql);
    $list=[];
    while($row=mysqli_fetch_array($resultset,1)){
        $list[]=$row;
    }
    //dong ket noi
    mysqli_close($conn);
    return $list;
}
// function execute($sql){
//     $serverName = "42.116.100.248,1433"; //serverName\instanceName

//     // Since UID and PWD are not specified in the $connectionInfo array,
//     // The connection will be attempted using Windows Authentication.
//     $connectionInfo = array( "Database"=>"test","UID"=>"sa", "PWD"=>"123456");
//     $conn = sqlsrv_connect( $serverName, $connectionInfo);
//     if( $conn === false ) {
//         die( print_r( sqlsrv_errors(), true));
//     }
//     sqlsrv_query( $conn, $sql );
//     sqlsrv_close( $conn );
// }
// function executeResult($sql)
// {
//     $serverName = "42.116.100.248,1433"; //serverName\instanceName

//     // Since UID and PWD are not specified in the $connectionInfo array,
//     // The connection will be attempted using Windows Authentication.
//     $connectionInfo = array( "Database"=>"test","UID"=>"sa", "PWD"=>"123456");
//     $conn = sqlsrv_connect( $serverName, $connectionInfo);
//     if( $conn === false ) {
//         die( print_r( sqlsrv_errors(), true));
//     }

//     $resultset=sqlsrv_query( $conn, $sql );
//     $list=[];
//     while($row=sqlsrv_fetch_array($resultset, SQLSRV_FETCH_ASSOC)){
//         $list[]=$row;
//     }
//     //dong ket noi
//     sqlsrv_close( $conn );
//     return $list;
// }

function validateToken() {
    $token = '';    
    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];
        $sql   = "select * from login_management where token = '$token'";
        $data  = executeResult($sql);
        if ($data != null && count($data) > 0) {
            return $data[0];
        }
    }
    return null;
}
?>