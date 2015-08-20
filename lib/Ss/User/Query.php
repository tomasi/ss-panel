<?php


namespace Ss\User;


class Query {

    public  $uid;
    private $dbc;
    private $db;

    function __construct($uid=0){
        global $dbc;
        global $db;
        $this->uid = $uid;
        $this->dbc = $dbc;
        $this->db  = $db;
    }

    //根据email返回UID
    function GetUidByEmail($email){
        $datas = $this->db->select("user","*",[
            "email" => $email,
            "LIMIT" => 1
        ]);
        return $datas['0']['uid'];
    }

    //根据user返回UID
    function GetUidByUser($name){
        $datas = $this->db->select("user","*",[
            "user_name" => $name,
            "LIMIT" => 1
        ]);
        return $datas['0']['uid'];
    }


}