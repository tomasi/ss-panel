<footer class="page-footer orange">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">关于</h5>
                <p class="grey-text text-lighten-4">本站提供某种帐号用于科学上网.</p>


            </div>
            <div class="col l3 s12">
                <h5 class="white-text">用户</h5>
                <ul>
                    <li><a class="white-text" href="user">用户中心</a></li>
                    <li><a class="white-text" href="user/login.php">登录</a></li>
                    <li><a class="white-text" href="user/register.php">注册</a></li>
                </ul>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">页面</h5>
                <ul>
                    <li><a class="white-text" href="code.php">邀请码</a></li>
                    <li><a class="white-text" href="user/tos.php">TOS</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            &copy; <?php echo $site_name."  ".date('Y'); ?>  Powered by <a class="orange-text text-lighten-3" href="https://github.com/SpiritRain/ss-panel" target="_blank">ss-panel</a> <?php echo $version; ?>
            Processed in <?php
            $Runtime->Stop();
            echo $Runtime->SpendTime()."ms";
            ?> Theme by <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a>
            <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1255304124'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1255304124%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
        </div>
    </div>
</footer>


<!--  Scripts-->
<script src="asset/js/jQuery.min.js"></script>
<script src="asset/materialize/js/materialize.min.js"></script>
<script src="asset/materialize/js/init.js"></script>

</body>
</html>
