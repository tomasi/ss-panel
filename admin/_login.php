<?php
require_once '../lib/config.php';
$name = $_POST['username'];
$name = strtolower($name);
$passwd = $_POST['passwd'];
$passwd = \Ss\User\Comm::SsPW($passwd);
$rem = $_POST['remember_me'];
$c = new \Ss\User\UserCheck();
$q = new \Ss\User\Query();
if($c->UserLogin($name,$passwd)){
    $rs['code'] = '1';
    $rs['ok'] = '1';
    $rs['msg'] = "欢迎回来";
    //login success
    if($rem= "week"){
        $ext = 3600*24*7;
    }else{
        $ext = 3600;
    }
    //获取用户id
    $id = $q->GetUidByUser($name);
    //处理密码
    $pw = \Ss\User\Comm::CoPW($passwd);
    setcookie("user_pwd",$pw,time()+$ext);
    setcookie("uid",$id,time()+$ext);
    $ui = new \Ss\User\UserInfo($id);
    setcookie("user_email",$ui->GetEmail(),time()+$ext);
    setcookie("user_name",$name,time()+$ext);
}else{
    $rs['code'] = '0';
    $rs['msg'] = "用户名或者密码错误";
}
echo json_encode($rs);