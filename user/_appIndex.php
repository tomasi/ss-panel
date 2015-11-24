<?php
require_once '../lib/config.php';
$name = $_POST['username'];
$name = strtolower($name);
$q = new \Ss\User\Query();
$uid = $q->GetUidByUser($name);
$oo = new Ss\User\Ss($uid);
if($oo->get_transfer()<1000000)
{
    $transfers=0;
}else{
    $transfers=$oo->get_transfer();
}
//计算流量并保留2位小数
$rs['transfers'] = round($transfers/$tomb;,2)
$rs['all_transfer'] = round($oo->get_transfer_enable()/$togb,2);
$rs['unused_transfer'] = round($oo->unused_transfer()/$togb,2);
$rs['used_100'] = round($oo->get_transfer()/$oo->get_transfer_enable(), 2) * 100;

//最后在线时间
$rs['unix_time'] = $oo->get_last_unix_time();

echo json_encode($rs);
