<?php


    if(!isset($_SESSION['token']))
    $_SESSION['token'] = sha1(rand()); // random token

echo "
<hr>

<div class='modal hide' id='loginModal'>
    <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>✕</button>
        <h3>Login</h3>
    </div>
        <div class='modal-body' style='text-align:center;'>
        <div class='row-fluid'>
            <div class='span10 offset1'>
                <div id='modalTab'>
                    <div class='tab-content'>
                        <div class='tab-pane active' id='login'>
                            <form method='post' action='$set->url/login.php' name='login_form'>
                                <p><input type='text' class='span12' name='name' placeholder='Username'></p>
                                <p><input type='password' class='span12' name='password' placeholder='Password'></p>
                                <p>
                                	<input class='pull-left' type='checkbox' name='r' value='1' id='rm'>  
                                	<label class='pull-left' for='rm'>Remember Me</label>
                                </p>
                                <div class='clearfix'></div>

                                <input type='hidden' name='token' value='".$_SESSION['token']."'>
                                
                                <p><button type='submit' class='btn btn-primary'>Sign in</button>
                                <a href='#forgotpassword' data-toggle='tab'>Forgot Password?</a>
                                </p>
                            </form>
                        </div>
                        <div class='tab-pane fade' id='forgotpassword'>
                            <form method='post' action='$set->url/login.php?forget=1' name='forgot_password'>
                                <p>Hey this stuff happens, send us your email and we'll reset it for you!</p>
                                <input type='text' class='span12' name='email' placeholder='Email'>
                                <p><button type='submit' class='btn btn-primary'>Submit</button>
                                
                                <input type='hidden' name='token' value='".$_SESSION['token']."'>

                                <a href='#login' data-toggle='tab'>Wait, I remember it now!</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
";

?>

<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ul class="list-inline">
					<li><a href="<?php echo $set->url;?>/index.php">Home</a>
					</li>
					<li class="footer-menu-divider">&sdot;</li>
					<li><a href="<?php echo $set->url;?>/about.php">About</a>
					</li>
					<li class="footer-menu-divider">&sdot;</li>
					<li><a href="<?php echo $set->url;?>/terms.php">Terms</a>
					</li>
					<li class="footer-menu-divider">&sdot;</li>
					<li><a href="<?php echo $set->url ;?>/privacypolicies.php">Privacy</a>
					</li>
					<li class="footer-menu-divider">&sdot;</li>
					<li><a href="<?php echo $set->url;?>/help.php">Help</a>
					</li>
				</ul>
				<p class="copyright text-muted small">Copyright &copy; ifriend <?php echo date("Y");?>. All Rights Reserved</p>
			</div>
		</div>
	</div>
</footer>   

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $set->url;?>/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>

<script src="<?php echo $set->url;?>/js/vendor/bootstrap.min.js"></script>

<!-- Validate Plugin -->
<script src="<?php echo $set->url;?>/js/vendor/jquery.validate.min.js"></script>

<script src="<?php echo $set->url;?>/js/main.js"></script>

<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
</body>
</html>