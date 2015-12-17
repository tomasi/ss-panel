<?php
/**
 * User Shadowsocks  info Class
 * @author  orvice <orvice@gmail.com>
 */
namespace Ss\User;

class Ss {
    //
    public  $uid;
    public $db;
    public $CA_LOCATION;

    function  __construct($uid=0){
        global $db;
        $this->uid = $uid;
        $this->db  = $db;
        $this->CA_LOCATION = "/usr/local/share/ca-certificates";
    }

    //user info array
    function get_user_info_array(){
        $datas = $this->db->select("user","*",[
            "uid" => $this->uid,
            "LIMIT" => "1"
        ]);
        return $datas['0'];
    }

    //返回用户名
    function  get_user_name(){
         return $this->get_user_info_array()['user_name'];
    }

    //返回端口号
    function  get_port(){
         return $this->get_user_info_array()['port'];
    }

    //获取流量
    function get_transfer(){
        return $this->get_user_info_array()['u']+$this->get_user_info_array()['d'];
    }

    //返回密码
    function  get_pass(){
        return $this->get_user_info_array()['passwd'];
    }

    //返回Plan
    function  get_plan(){
        return $this->get_user_info_array()['plan'];
    }

    //返回transfer_enable
    function  get_transfer_enable(){
        return $this->get_user_info_array()['transfer_enable'];
    }

    //get money
    function  get_money(){
        return $this->get_user_info_array()['money'];
    }

    //get unused traffic
    function unused_transfer(){
        //global $dbc;
        return $this->get_transfer_enable() - $this->get_transfer();
    }

    //get last time
    function get_last_unix_time(){
        return $this->get_user_info_array()['t'];
    }

    //get last check in time
    function get_last_check_in_time(){
        return $this->get_user_info_array()['last_check_in_time'];
    }

    //check is able to check in
    function is_able_to_check_in(){
        $now = time();
        if( $now-$this->get_last_check_in_time() > 3600*22 ){
            return 1;
        }else{
            return 0;
        }
    }

    //update last check_in time
    function update_last_check_in_time(){
        $now = time();
        $this->db->update("user",[
            "last_check_in_time" => $now
        ],[
            "uid" => $this->uid
        ]);
    }

    //add transfer 添加流量
    function  add_transfer($transfer=0){
        $transfer = $this->get_transfer_enable()+$transfer;
        $this->db->update("user",[
            "transfer_enable" => $transfer
        ],[
            "uid" => $this->uid
        ]);
    }

    //add money
    function add_money($uid,$money){
        $money = $this->get_money()+$money;
        $this->db->update("user",[
            "money" => $money
        ],[
            "uid" => $uid
        ]);
    }

    //update ss pass
    function update_ss_pass($pass){
        $this->db->update("user",[
            "passwd" => $pass
        ],[
            "uid" => $this->uid
        ]);
    }

    //返回AC密码
    function  get_ac_pass(){
        $datas = $this->db->select("ac_cert","*",[
            "uid" => $this->uid,
            "LIMIT" => "1"
        ]);
        return $datas['0']['passwd'];
    }

    //返回AC时间
    function  get_ac_expire(){
        $datas = $this->db->select("ac_cert","*",[
            "uid" => $this->uid,
            "LIMIT" => "1"
        ]);
        return $datas['0']['expire_time'];
    }


    function check_ca_cert()
    {
        $location = $this->CA_LOCATION;
        print_r("check_ca_cert");
        if (!file_exists("/usr/sbin/ocserv")) {
            print_r("/usr/sbin/ocserv is not exist");
            return false;
        }
        if (!file_exists("$location/ca-cert.pem")) {
             print_r("ca-key is not exist");
            return false;
        }
        if (!file_exists("$location/ca-key.pem")) {
             print_r("ca-cert is not exist");
            return false;
        }
        return true;
    }

    function Outdate_Autoclean()
    {
        print_r("Outdate_Autoclean");
    }

    function revoke_userca($uname)
    {
        print_r("revoke_userca");
    }


    function create_userca($uname,$pass,$time)
    {
        $location = $this->CA_LOCATION;
        if ($this->check_ca_cert()) {
            $this->Outdate_Autoclean();
            if (file_exists("/var/www/ocvpn/$uname.p12")) {
                $this->revoke_userca($uname);
            }
            print_r("create_userca mkdir");
            mkdir("$location/user-$uname");
            $caname="ocvpn";
            $tmpl= fopen("$location/user-$uname/user.tmpl", "w") or die("Unable to open file!");
            $content = "cn =$uname\nunit = Route\nuid =$uname\nexpiration_days =$time\nsigning_key\ntls_www_client";
            fwrite($tmpl, $content);
            fclose($tmpl);
            $cmd = "openssl genrsa -out $location/user-$uname/user-$uname-key.pem 2048";
            system($cmd);
            $cmd = "certtool --generate-certificate --hash SHA256 --load-privkey $location/user-$uname/user-$uname-key.pem --load-ca-certificate $location/ca-cert.pem --load-ca-privkey $location/ca-key.pem --template $location/user-$uname/user.tmpl --outfile $location/user-$uname/user-$uname-cert.pem";
            system($cmd);
            $cmd = "openssl pkcs12 -export -inkey $location/user-$uname/user-$uname-key.pem -in $location/user-$uname/user-$uname-cert.pem -name $uname -certfile $location/ca-cert.pem -caname $caname -out $location/user-$uname/$uname.p12 -passout pass:$pass";
            system($cmd);
            print_r("create_userca copy");
            copy("$location/user-$uname/$uname.p12", "/var/www/ocvpn/$uname.p12");
        }
    }

    //update ac cert
    function update_ac_cert($uname,$pass,$time){
        $expire = time() + $time * 3600 * 24;
        $this->db->update("ac_cert",[
            "passwd" => $pass,
            "expire_time" => $expire,
        ],[
            "uid" => $this->uid
        ]);
        $this->create_userca($uname,$pass,$time);
    }

    //user info array
    function getUserArray(){
        $datas = $this->db->select("user","*",[
            "uid" => $this->uid,
            "LIMIT" => "1"
        ]);
        return $datas['0'];
    }

    //获取已用流量
    function getUsedTransfer(){
        return $this->getUserArray()['u']+$this->getUserArray()['d'];
    }

    //获取总流量
    function getTransferEnable(){
        return $this->getUserArray()['transfer_enable'];
    }

    //剩余流量
    function getUnusedTransfer(){
        return $this->getTransferEnable()-$this->getUsedTransfer();
    }

}
