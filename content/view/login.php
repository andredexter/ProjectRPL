<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="css/login.css" rel="stylesheet" />
   
	<link rel="shortcut icon" href="img/favicon/favicon.png">
</head>
<body class="eternity-form">
    <section class="colorBg3 colorBg">
	   <div class="container">
			<div class="login-form-section">
				<div class="logo animated fadeInDown" data-animation="fadeInDown" data-animation-delay=".8s">
				<!--<img src="img/logo2.png">-->
				</div>
                <div class="login-content animated bounceIn" data-animation="bounceIn">
                    <form id="form" name="form" action="content/proses.php?act=login" method="post">
                        <div class="section-title">
                            <h3>LOG IN</h3>
							 <?php 
							 if (isset($_SESSION['login'])) {
								if($_SESSION['login']=='fail'){
									echo "<p class='login-fail'>Username atau Password anda salah</p>";
									}
								else if($_SESSION['login']=='welcome'){
									echo "<p class='login-fail'>Uanda salah</p>";
									}
								unset($_SESSION['login']);
								
							}         
							?>
                        </div>
                        <div class="textbox-wrap">
                            <div class="input-group">
                                <span class="input-group-addon "><i class="icon-user icon-color"></i></span>
                                <input type="text" name="name" id="name" required="required" class="form-control" placeholder="Username" />
                            </div>
                        </div>
                        <div class="textbox-wrap">
                            <div class="input-group">
                                <span class="input-group-addon "><i class="icon-key icon-color"></i></span>
                                <input type="password" name="password" id="password" required="required" class="form-control " placeholder="Password" />
                            </div>
                        </div>
                        <div class="login-form-action clearfix">
							<a class="blue openNoty"><i class="icon-male"></i>&nbsp;Butuh Akses ? </a>
                            <button type="submit" id="submit" name="submit"  class="btn btn-success pull-right blue-btn">LogIn &nbsp; <i class="icon-chevron-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

    <script type="text/javascript">
        $(function () {
			 $(".form-control").focus(function () {
                $(this).closest(".textbox-wrap").addClass("focused");
            }).blur(function () {
                $(this).closest(".textbox-wrap").removeClass("focused");
            });

			
			$(".openNoty").bind("click", function() {
               noty({text: 'Selamat datang di aplikasi penggajian, untuk menggunakannya dibutuhkan hak akses khusus untuk dapat menggunakan modul-modul yang disediakan oleh aplikasi ini, silahkan hubungi pihak pengembang untuk informasi lebih lanjut',modal : true, layout:'center',type:'notification'});
            });
        });
    </script>

</body>
<!-- jQuery Notification - Noty -->
<script src="js/jquery.noty.js"></script> <!-- jQuery Notify -->
<script src="js/themes/default.js"></script> <!-- jQuery Notify -->
<script src="js/themes/center.js"></script> <!-- jQuery Notify -->

<!-- jQuery Notification ends -->
</html>
