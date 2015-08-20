<?php
require_once '../lib/config.php';
require_once '_check.php';
$id = $_GET['id'];
$type = $_GET['type'];
$node = new \Ss\Node\NodeInfo($id);
$server = $node->Server();
$method = $node->Method();
if ($type == "1"){
$pass = $oo->get_pass();
$port = $oo->get_port();
}else{
$s = new \Ss\User\Ss(2);
$pass = $s->get_pass();
$port = $s->get_port();
}
?>
{
"server":"<?php echo $server; ?>",
"server_port":<?php echo $port; ?>,
"local_port":1080,
"password":"<?php echo $pass; ?>",
"timeout":600,
"method":"<?php echo $method; ?>"
}




