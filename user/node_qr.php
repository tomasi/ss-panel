<?php
require_once '../lib/config.php';
require_once '_check.php';
$id = $_GET['id'];
$type = $_GET['type'];
$node = new \Ss\Node\NodeInfo($id);
$server =  $node->Server();
$method = $node->Method();
if ($type=="1"){
    $pass = $oo->get_pass();
    $port = $oo->get_port();
}
else{
    $s = new \Ss\User\Ss(2);
    $pass = $s->get_pass();
    $port = $s->get_port();    
}
$ssurl =  $method.":".$pass."@".$server.":".$port;
$ssqr = "ss://".base64_encode($ssurl);
?>
<p>ss://<?php echo $ssurl;?></p>
<p id="ssqr_text" ><?php echo $ssqr;?></p>
<div align="center">
    <div id="qrcode"></div>
</div>
<script src="../asset/js/jQuery.min.js"></script>
<script src="../asset/js/jquery.qrcode.min.js"></script>
<script>
    jQuery('#qrcode').qrcode("<?php echo $ssqr;?>");
</script>




