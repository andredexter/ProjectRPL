<?php
 require_once ('content/classes/siswaClass.php');
  $siswa = new siswa();
  
  $dataSiswa = $siswa->countSiswa();
?>
<div class="page-content">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<h4>Selamat Datang</h4>
			<p>Selamat datang di aplikasi penggajian Sekolah Musik</p>
		</div>
	</div>
	
</div><br><br>
<div class="row">			
	<!-- Current status -->
	<div class="col-md-8">
		<div class="current-status widget ">
		<p>Silahkan klik pada modul-modul dibawah ini</p>
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-6">
					<a href="?p=siswa&sub=lihat">
					<div class="current-status-item">
						<!-- Icon 
						<i class="fa fa-user lblue"></i> -->
						<!-- Heading -->
						<h6>Data</h6>
						<h3><span class="fa fa-users green"></span> Siswa</h3>
					</div>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6">
					<a href="?p=pengajar&sub=lihat">
					<div class="current-status-item">
						<!-- Icon 
						<i class="fa fa-bar-chart-o lblue"></i> -->
						<!-- Heading -->
						<h6>Data</h6>
						<h3><span class="fa fa-user red"></span> Pengajar</h3>
					</div>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6">
					<a href="?p=instrument">
					<div class="current-status-item">
						<!-- Heading -->
						<h6>Data</h6>
						<h3><span class="fa fa-music lblue"></span> Instrument</h3>
					</div>
				</div>
			
				<div class="col-md-3 col-sm-3 col-xs-6">
					<a href="?p=jadwal">
					<div class="current-status-item">
						<!-- Icon 
						<i class="fa fa-user lblue"></i> -->
						<!-- Heading -->
						<h6>Jadwal</h6>
						<h3><span class="fa fa-table lblue"></span> Belajar</h3>
					</div>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6">
					<a href="?p=pembayaran">
					<div class="current-status-item">
						<!-- Icon 
						<i class="fa fa-bar-chart-o lblue"></i> -->
						<!-- Heading -->
						<h6>Uang</h6>
						<h3><span class="fa fa-money green"></span> Bulanan</h3>
					</div>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6">
					<a href="?p=absensi">
					<div class="current-status-item">
						<!-- Heading -->
						<h6>Absensi</h6>
						<h3><span class="fa fa-file-text yellow"></span> Belajar</h3>
					</div>
					</a>
				</div>
				<?php
				if(isset($_SESSION['prive'])){
					if($_SESSION['prive'] == '0'){
					
				?>
				<div class="col-md-3 col-sm-3 col-xs-6">
					<a href="?p=neraca">
					<div class="current-status-item">
						<!-- Heading -->
						<h6>Neraca </h6>
						<h3><span class="fa fa-bar-chart-o green"></span> Keuangan</h3>
					</div>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6">
					<a href="?p=gaji">
					<div class="current-status-item">
						<!-- Heading -->
						<h6>Laporan </h6>
						<h3><span class="fa fa-check-square-o brown"></span> Gaji</h3>
					</div>
					</a>
				</div>
				<?php
					}
				}
				?>
				<div class="col-md-3 col-sm-3 col-xs-6">
					<a href="?p=shift">
					<div class="current-status-item">
						<!-- Heading -->
						<h6>Pengaturan </h6>
						<h3><span class="fa fa-align-justify red"></span> Shift Belajar</h3>
					</div>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6">
					<a href="?p=informasi&sub=sekolah">
					<div class="current-status-item">
						<!-- Heading -->
						<h6>Pengaturan </h6>
						<h3><span class="fa fa-archive red"></span> Sekolah</h3>
					</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 pull-right">
		<!-- Main area chart -->
		<div class="widget">
			<div class="widget-head br-lblue">
				<h3><i class="fa fa-desktop"></i> Laporan Siswa</h3>
			</div>
			<div class="widget-body">
				<!-- Pie chart -->
				<div class="m-pie-chart">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6 text-left">
							<!-- Pie chart info -->
							<ul class="list-unstyled">
							<?php
								foreach ($dataSiswa as $data) {
									echo "<li><span class='badge badge-info'>".$data['semua']."</span> &nbsp; <strong>Siswa Terdaftar</strong></li>";
									echo "<li><span class='badge badge-success'>".$data['aktif']."</span> &nbsp; <strong>Siswa Aktif</strong></li>";
									echo "<li><span class='badge badge-brown'>".$data['tamat']."</span> &nbsp; <strong>Siswa Tamat</strong></li>";
								}
							?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	</div>
	
</div>

<div class="knobs text-center">
	<div class="row">
		
			
		
		</div>
	</div>
