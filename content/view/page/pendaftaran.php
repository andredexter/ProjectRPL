<div class="page-content">

	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-credit-card lblue"></i> Pendaftaran Siswa Baru</h3>
		<div class="clearfix"></div>
	</div>
	<?php
					if(isset($_SESSION['notif'])){
						if($_SESSION['notif'] == 'duplicatePengajar') {
							echo "<div class='alert alert-danger alert-dismissable'>
								  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
								  <strong>Kesalahan!</strong> Nama pengajar telah didaftarkan sebelumnya.
								  </div>";
						}
						else if($_SESSION['notif'] == 'successPengajar') {
							echo "<div class='alert alert-success alert-dismissable'>
								  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
								  <strong>Berhasil!</strong> Pengajar berhasil disimpan.
								  </div>";
						}
						unset($_SESSION['notif']);
						
					 }
				?>
	<!-- Form page -->
	<div class="page-form">
		<form class="form-horizontal" role="form" action="content/proses.php?act=savePengajar" method="post">
			<div class="row">
				<div class="form-group">
					<label class="col-lg-2 control-label">Tanggal</label>
					<div class="col-lg-2"	>
						<input type="date" class="form-control" value="">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-lg-2 control-label">Biaya Pendaftaran</label>
					<div class="col-lg-3"	>
						<input type="text" class="form-control">
					</div>
				</div>
				
				<hr>
				<div class="form-group">
						<label class="col-lg-2 control-label">Nama Siswa</label>
						<div class="col-lg-3"	>
							<input type="text" class="form-control" placeholder="Input Box">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Tanggal Lahir</label>
						<div class="col-lg-2"	>
							<input type="text" class="form-control" placeholder="Input Box">
						</div>
					</div>					
					<div class="form-group">
						<label class="col-lg-2 control-label">Alamat Siswa</label>
						<div class="col-lg-4"	>
							<input type="text" class="form-control" placeholder="Alamat Siswa">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Telepon Siswa</label>
						<div class="col-lg-2"	>
							<input type="text" class="form-control">
						</div>
					</div>
			</div>
			<hr>
			<div class="row">
					<div class="form-group">
						<label class="col-lg-2 control-label">Jenis Instrument</label>
						<div class="col-lg-3"	>
							<input type="text" class="form-control" placeholder="Alamat Siswa">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Guru Pengajar</label>
						<div class="col-lg-3"	>
							<input type="text" class="form-control" placeholder="Alamat Siswa">
						</div>
					</div>
			</div>
			<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<input type="submit" class="btn btn-primary submit" value="Simpan"></input>&nbsp;
						<a href="?p=guru&sub=lihat"><button type="button" class="btn btn-default">Batal</button></a>
					</div>	
				</div>
		</form>
	</div> <!-- Form page end -->
	
</div> <!-- Page content end -->