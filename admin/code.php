<?php
require_once 'lib/config.php';
$invite = new \Ss\User\Invite($uid);
$c = new \Ss\User\Invite();
?>

<div class="container">
    <div class="section"> 
        <!--   Icon Section   -->
        <div class="row">
            <div class="row marketing">
                <h2 class="sub-header">邀请码</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>###</th>
                            <th>邀请码</th>
                            <th>状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $datas = $c->CodeArray(); 
                        foreach($datas as $data ){
                            ?>
                            <tr>
                                <td><?php echo $data['id'];?></td>
                                <td><a href="/user/register.php?code=<?php echo $data['code'];?>"><?php echo $data['code'];?></a></td>
                                <td>可用</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>  
</div>
<?php  include_once 'ana.php';
include_once 'footer.php';?>
