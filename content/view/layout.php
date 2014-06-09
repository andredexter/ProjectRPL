<!DOCTYPE html>
<html>
	<head>
		<!-- Title here -->
		<title>Dashboard - Sekolah Musik</title>
		<!-- Description, Keywords and Author -->
		<meta name="description" content="Sistem Informasi Pengelolaan Penggajian SIMS">
		<meta name="keywords" content="sistem informasi unand 11 rekayasa perangkat lunak">
		<meta name="author" content="kelompok9">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- Font awesome CSS -->
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<!-- Custom Color CSS -->
		<link href="css/less-style.css" rel="stylesheet">	
		<!-- TimePicker -->
		<link href="css/bootstrap-timepicker.min.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="css/style.css" rel="stylesheet">
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="#">
	</head>
	
	<body>
	<?php
		$webApp = new webApp();
		$setting = new settingApps();
        $menuItem = new menuController();
    ?>
		<div class="outer">
			
			<!-- Sidebar starts -->
			<div class="sidebar">
			
				<div class="sidey">
					<!-- Logo -->
					<div class="logo">
						<?php echo $setting->loadSetting('judul')?>
					</div>
					<!-- Sidebar navigation starts -->
					
					<!-- Responsive dropdown -->
					<div class="sidebar-dropdown"><a href="#" class="br-red"><i class="fa fa-bars"></i></a></div>
					
					<div class="side-nav">
						<?php
							include ('content/view/menuItem.php');
							$menuItem->headingmenu("0", "Main","*");
							$menuItem->singleMenu("Home", "./", "fa-home", "Home", '*');
							$menuItem->singleMenu("Jadwal Belajar", "?p=jadwal", "fa-table", "jadwal", '*');
							$menuItem->singleMenu("Uang Bulanan", "?p=pembayaran","fa-money", "pembayaran",'*');
							$menuItem->singleMenu("Absensi", "?p=absensi","fa-file-text", "absensi",'*');
							$menuItem->headingmenu("1", "", "*");
							
							$menuItem->headingmenu("0", "Data Utama", "*");
							$menuItem->singleMenu("Data Siswa", "?p=siswa&sub=lihat", "fa-users", "siswa", '*');
							$menuItem->singleMenu("Data Pengajar", "?p=pengajar&sub=lihat", "fa-user", "pengajar", '*');
							$menuItem->singleMenu("Data Instrument", "?p=instrument", "fa-music", "instrument", '*');
							$menuItem->headingmenu("1", "", "*");
							
							$menuItem->headingmenu("0", "Laporan", "0");
							$menuItem->singleMenu("Neraca Keuangan", "?p=neraca","fa-bar-chart-o", "neraca",'0');
							$menuItem->singleMenu("Laporan Gaji", "?p=gaji","fa-check-square-o", "gaji",'0');
							$menuItem->headingmenu("1", "", "0");							
			
							$menuItem->headingmenu("0", "Pengaturan","*");				
							$menuItem->singleMenu("Pengaturan Shift", "?p=shift","fa-align-justify", "shift",'*');							
							$menuItem->singleMenu("Pengaturan Sekolah", "?p=informasi&sub=sekolah","fa-archive", "informasi-sekolah",'*');							
							$menuItem->dropdownMenu("Informasi", "fa-th-large", "informasi",$dmInformasi, '*');
							$menuItem->headingmenu("1", "","*");
						?>
					</div>
					
					<!-- Sidebar navigation ends -->
					
				</div>
			</div>
			<!-- Sidebar ends -->
			
			<!-- Mainbar starts -->
			<div class="mainbar">
			
				<!-- Mainbar head starts -->
				<div class="main-head">
					<div class="container">
						<div class="row">
							<div class="col-md-3 col-sm-4 col-xs-6">
								<!-- Page title -->
								<h2><i class="fa fa-desktop lblue"></i> <?php echo $setting->loadSetting('nama')?></h2>
							</div>
							
							<div class="col-md-3 col-sm-4 col-xs-6">
							</div>
							
							<div class="col-md-3 col-sm-4 hidden-xs">
								<!-- Search block -->
								<!--
								<div class="head-search">
									<form class="form" role="form">
										<div class="input-group">
										  <input type="text" class="form-control" placeholder="Search...">
										  <span class="input-group-btn">
											<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
										  </span>
										  
										</div>
									</form>
								</div>
								-->
							</div>
							
							
							<div class="col-md-3 hidden-sm hidden-xs">
								<!-- Head user -->
								<div class="head-user dropdown pull-right">
									<a href="#" data-toggle="dropdown" id="profile">
										<!-- Icon 
										<i class="fa fa-user"></i>  -->
										
										<img src="img/user.jpg" alt="" class="img-responsive img-circle"/>
										
										<!-- User name -->
										<?php
										if(isset($_SESSION['usernya'])){
											echo strtoupper($_SESSION['usernya']);
										}
										?> 
										<i class="fa fa-caret-down"></i> 
									</a>
									<!-- Dropdown -->
									<ul class="dropdown-menu" aria-labelledby="profile">
									    <!--<li><a href="#">Lihat/Ubah Profil <span class="badge badge-info pull-right">6</span></a></li>-->
										 <li><a href="?p=informasi&sub=user"><i class="fa fa-gear pull-right"></i> Change Password </a></li>
										 <li><a href="content/proses.php?act=logout"><i class="fa fa-power-off pull-right"></i> Keluar </a></li>										
									</ul>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>	
					</div>
					
				</div>
				
				<!-- Mainbar head ends -->
				
				<div class="main-content">
					<div class="container">
						<?php
							$webApp->loadContent();
						?>
					</div>
				</div>
				
			</div>
			<!-- Mainbar ends -->
			
			<div class="clearfix"></div>
		</div>
		
		<!-- Javascript files -->
	<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- jQuery UI -->
		<script src="js/jquery-ui.min.js"></script>
		<!-- Validate JS -->
		<script src="js/jquery.validate.js"></script>
		<!-- jQuery slim scroll -->
		<script src="js/jquery.slimscroll.min.js"></script>
		<!-- Data Tables JS -->
		<script src="js/jquery.dataTables.min.js"></script>	
		<!-- Respond JS for IE8 -->
		<script src="js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="js/html5shiv.js"></script>
		<!-- TimePicker -->
		<script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
		
		<!-- Custom JS -->
		<script src="js/custom.js"></script>
		
	</body>	
</html>