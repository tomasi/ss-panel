<?php
/*
 * 清空流量
 */
//定义清零日期,1为每月1号
/$reset_date = '1';
//日期符合就清零 
if (date('d')==$reset_date){
    $sspass = \Ss\Etc\Comm::get_random_char(8);
    $db->update("user",[
            "passwd" => $sspass
        ],[
            "uid" => 2
        ]);
    $db->update("user",[
        "transfer_enable" => $a_transfer,
        "u" => "0",
        "d" => "0"
    ]);
}
